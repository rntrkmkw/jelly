<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

require_once (APPPATH . '/controllers/web/Web.php');

/**
 * Apiクラス
 *
 * @author kamikawa
 *
 *
 */
class Api extends Web {
    public $api_num;                         // 処理中API番号
    public $app_exec_mode = APPLICATION_RUNNNING_MODE__DEFAULT;

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // モデルロード
        // コンフィグロード
        $this->load->config('app_config', TRUE);
        // アプリケーションの稼働モードチェック
        $this->app_exec_mode = $this->config->item('app_exec_mode');
        // ヘルパーのロード
        // ライブラリロード
        $this->load->library('form_validation');
        // 言語ロード
        
        // クライアントからはGET通信でリクエストされるがココで強制的に書き換える
        //　※バリデーション処理をするため。
        $_SERVER['REQUEST_METHOD'] = 'POST';
    }

    /**
     * 初期化
     */
    protected function init() {
        // レスポンスデータ：情報部
        $info = array(
                        'status' => '0',                // ステータス(0:成功、1:失敗)
                        'error_code' => '0',            // エラーコード(0:正常、99:システムエラー)※statusが1の時、有効
                        'api_id' => '0',                // エラーAPI ID
                        'message' => array(),           // エラーメッセージ(statusが1の時、有効)
                        'token' => '',                  // 認証トークン
        );

        // レスポンスデータ：データ部
        $data = array();

        // アウトプット用データ配列の初期化
        $this->data['response'] = array(
                        'info' => $info,
                        'data' => $data
        );
    }

    /**
     * ワンタイムトークンを発行してセッションに設定する
     */
    protected function set_token(){
        // ワンタイムトークンの発行
        $token = $this->security->get_csrf_hash();

        // セッションへセット
        if (!$this->session->set_csrf_token($token)){
            log_message('DEBUG', 'CSRF TOKEN SET FAILED.');
        }

        return $token;
    }

    /**
     * ワンタイムトークンの認証をする
     * @param unknown $sess_token
     * @param unknown $req_token
     * @param string $skip
     */
    protected function check_token($sess_token, $req_token, $skip = false){

        // スキップフラグONの場合はチェックをスキップ
        if ($skip){
            return true;
        }
        
        // 必須チェック
        if (empty($req_token)){
            log_message('DEBUG', 'CAN NOT GET PARAMETER. TOKEN IS EMPTY.');
            return false;
        }
        // 整合性チェック
        if ($req_token !== $sess_token){
            log_message('DEBUG', 'CHECK TOKEN ERROR. TOKEN IS ' . $req_token . '. ' . 'CSRF_TOKEN IS ' . $sess_token . '.');
            return false;
        }

        log_message('DEBUG', 'TOKEN IS ' . $req_token . '. ' . 'CSRF_TOKEN IS ' . $sess_token . '.');
        return true;
    }

    /**
     * JSON形式のレスポンスを生成する
     *
     */
    protected function output_json($token_flg = true) {
       // トークンフラグがONの場合はレスポンスに差し替え用のトークンを追加
        if ($token_flg){
            // 認証トークン発行
            $token = $this->security->get_csrf_hash();
            $this->data['response']['info']['token'] = $token;
            // セッションに保存
            $this->session->set_csrf_token($token);
        }
        // 結果出力
        header('Content-Type: application/json; charset=UTF-8');
        
        // info部をJSON形式に変換
        $this->data['response']['info'] = json_encode($this->data['response']['info']);
        // data部をJSON形式に変換した空配列で最大数分埋める
        $this->data['response']['data'] = array_pad($this->data['response']['data'], COMMON__EXEC_API__MAX_COUNT, json_encode(array()));

        // レスポンスデータをJSON形式に変換して返却
        // ※クライアント要望の為、JSONをネスト
        exit(json_encode($this->data['response']));
    }

    /**
     * エラーをJSONで返却する
     *
     * @param Integer $error_code
     * @param String $error_line
     * @param Integer $api_id
     * @return
     */
    private function output_error_info($error_code, $error_line, $api_id) {
        // トランザクションロールバック
        $this->transaction_rollback();
        
        $this->set_error_info($this->lang->line($error_line), $error_code, $api_id);
        $this->set_template_data(array());
        $this->output_json(false);
    }

    /**
     * 共通API
     *
     */
    function exec() {
        $data = array();
        
        // 最大実行回数
        $exec_api_max_cnt = COMMON__EXEC_API__MAX_COUNT;

        // JSONデータ取得
        $request = $this->input->get('request');

        // SESSIONに格納したCSRFトークンを取得
        $sess_token = $this->session->get_csrf_token();

        // デバッグモードの場合
        $check_token_flg = false;
        $api_list = array();        // APIのパラメータリスト
        if($this->app_exec_mode === APPLICATION_RUNNNING_MODE__DEBUG) {
            // デバッグモードかつリクエストパラメータが空の場合はテスト用パラメータを使用
            if (empty($request)){
                $api_list = $this->config->item('test_params');
                $exec_api_max_cnt += 999;   // 実行回数制限を撤廃
                
                // テスト用パラメータ使用時はトークンチェックはスキップ
                $check_token_flg = true;
            }
            
            // アプリ動作モードがデバッグかつローカル環境の場合はチェックなし
            if ((ENVIRONMENT == 'local')){
                $check_token_flg = true;
            }
        }
        
        // JSONデータを配列にデコード
        if (empty($api_list)){
            $api_list = json_decode($request, true);
        }

        // エラーチェック
        // 配列チェック
        if (!is_array($api_list)){
            $this->output_error_info(ERROR__REQUEST_DATA_INVALID, 'error_request_data_invalid', null);
            return;
        }

        // 配列キーチェック
        $api_keys = array_keys($api_list);
        foreach ($api_keys as $key){
            // 数字かつ最大実行回数未満でない場合はエラー
            if (is_numeric($key) && ($exec_api_max_cnt <= $key)){
                $this->output_error_info(ERROR__REQUEST_DATA_INVALID, 'error_request_data_invalid', null);
                return;
            }
        }

        // トランザクション開始
        $this->transaction_begin();

        // API実行
        $method_list_tran         = array();
        $method_list_master       = array();
        $method_list_system       = array();
        $method_list_event_master = array();
        foreach ($api_list as $api_data){
            $result_logic = array();
            $logic_func = '';
            
            // api_idチェック
            // フォーマットチェック
            if (!preg_match('/J\d{4}/', $api_data['api_id'])){
                $this->output_error_info(ERROR__REQUEST_DATA_INVALID, 'error_request_api_id_invalid', $api_data['api_id']);
                return;
            }
            // 番号に変換
            $this->api_num = (int)ltrim($api_data['api_id'], 'J');
            if (empty($this->api_num) || !is_numeric($this->api_num) || ($this->api_num >= 10000)){
                $this->output_error_info(ERROR__REQUEST_DATA_INVALID, 'error_request_api_id_invalid', $this->api_num);
                return;
            }

            // POST値のクリアとAPIごとのパラメータセット
            //set_post_value_list($api_data);
            
            // 共通バリデーションチェック
            if (!$this->check_param_common($api_data)){
                $this->output_error_info(ERROR__VALIDATION, 'error_request_data_invalid', $this->api_num);
                return;
            }
            
            // ロジックロード
            switch (floor($this->api_num / 1000)){
                case 0:
                    // トランザクション系
                    switch (floor($this->api_num / 100)){
                        case 0:
                            break;
                        case 1:
                            $logic_name = $this->controller_name . '_user_logic';
                            break;
                        case 2:
                            $logic_name = $this->controller_name . '_friend_logic';
                            break;
                        case 3:
                            $logic_name = $this->controller_name . '_stage_logic';
                            break;
                        case 4:
                            $logic_name = $this->controller_name . '_gold_logic';
                            break;
                        case 5:
                            $logic_name = $this->controller_name . '_item_logic';
                            break;
                        case 6:
                            $logic_name = $this->controller_name . '_event_logic';
                            break;
                        case 7:
                            break;
                        case 8:
                            break;
                        case 9:
                            break;
                        default:
                            break;
                    }
                    // トークンチェック
                    $status = $this->check_token($sess_token, $api_data['token'], $check_token_flg);
                    if(! $status) {
                        $this->output_error_info(ERROR__TOKEN_VERIFY_CHECK, 'error_token_verify_failed', $this->api_num);
                        return;
                    }
                    // 関数一覧を取得
                    if (empty($method_list_tran[$logic_name])){
                        $this->load->library($this->directory_name . $logic_name);
                        $method_list_tran[$logic_name] = get_ci_class_methods($logic_name);
                    }
                    // ロジック名取得
                    $logic_func = $method_list_tran[$logic_name][$this->api_num];
                    break;
                case 1 :
                    // マスタ系
                    // トークンチェック
                    $status = $this->check_token($sess_token, $api_data['token'], $check_token_flg);
                    if(! $status) {
                        $this->output_error_info(ERROR__TOKEN_VERIFY_CHECK, 'error_token_verify_failed', $this->api_num);
                        return;
                    }
                    // 関数一覧を取得
                    if (empty($method_list_master)){
                        $logic_name = $this->controller_name . '_master_logic';
                        $this->load->library($this->directory_name . $logic_name);
                        $method_list_master = get_ci_class_methods($logic_name);
                    }
                    // ロジック名取得
                    $logic_func = $method_list_master[$this->api_num];
                    break;
                case 2 :
                    // システム系※認証トークンチェックなし
                    $logic_name = $this->controller_name . '_system_logic';
                    $this->load->library($this->directory_name . $logic_name);
                    // 関数一覧を取得
                    if (empty($method_list_system)){
                        $method_list_system = get_ci_class_methods($logic_name);
                    }
                    // ロジック名取得
                    $logic_func = empty($method_list_system[$this->api_num]) ? null : $method_list_system[$this->api_num];
                    break;
                case 5 :
                    // イベントマスタ系
                    // トークンチェック
                    $status = $this->check_token($sess_token, $api_data['token'], $check_token_flg);
                    if(! $status) {
                        $this->output_error_info(ERROR__TOKEN_VERIFY_CHECK, 'error_token_verify_failed', $this->api_num);
                        return;
                    }
                    // 関数一覧を取得
                    if (empty($method_list_event_master)){
                        $logic_name = $this->controller_name . '_event_master_logic';
                        $this->load->library($this->directory_name . $logic_name);
                        $method_list_event_master = get_ci_class_methods($logic_name);
                    }
                    // ロジック名取得
                    $logic_func = $method_list_event_master[$this->api_num];
                    break;
                default :
                    $this->output_error_info(ERROR__REQUEST_DATA_INVALID, 'error_request_api_id_invalid', $this->api_num);
                    return;
                    break;
            }
            // APIロジック名が存在しない場合はエラー
            if (empty($logic_func)){
                $this->output_error_info(ERROR__TRANSACTION_ROLLBACK, 'error_request_api_id_invalid', $this->api_num);
                return;
            }
            // APIロジックコール
            $result_logic = $this->$logic_name->{$logic_func}($api_data);

            // 失敗した場合はロールバック※配列じゃない場合はエラーステータスが返却されている
            if(! is_array($result_logic)) {
                $this->output_error_info($result_logic, 'error_request_data_invalid', $this->api_num);
                return;
            }
            $common_data = array();
            $common_data['api_id'] = (string)$api_data['api_id'];                                       // API ID
            $common_data['api_name'] = strtoupper(str_replace('_'. $this->api_num, '', $logic_func));   // API名
            // 共通データとロジックデータをマージ
            // ※クライアント要望のため、各APIの共通パラメータを先頭にする
            $common_data = array_merge($common_data, $result_logic);
            
            // data部にJSON形式に変換したデータを追加する
            $data[] = json_encode($common_data);
        }

        // トランザクションコミット
        $this->transaction_commit();

        // アウトプットデータに追加
        $this->set_template_data($data);
        $this->output_json();
    }
    
    /**
     * 共通パラメータチェック
     * @param unknown $api_param
     */
    private function check_param_common($api_param){

        $result = false;

        // 値をセット
        $validation_data = $api_param;
        
        // リクエストパラメータのJSON内にdevice_idが存在しない場合は0で追加する
        if (empty($api_param['device_id'])){
            $validation_data['device_id'] = 0;
        }

        $this->form_validation->set_data($validation_data);

        // バリデーションルール設定
        $this->form_validation->set_rules('app_key', 'アプリキー', 'required|in_list['. $this->config->item('app_key').']');
        $this->form_validation->set_rules('device_id', 'デバイスID', 'required|numeric');
//        $this->form_validation->set_rules('os_type', 'OS種別', 'required|greater_than_equal_to[1]|less_than_equal_to[2]');
        $this->form_validation->set_rules('language', '言語', 'required|greater_than_equal_to['. T_USER__LANGUAGE__JP. ']|less_than_equal_to['. T_USER__LANGUAGE__EN.']');

        // チェック開始
        if($this->form_validation->run() == FALSE){
            // エラー処理
            if ($this->app_exec_mode == APPLICATION_RUNNNING_MODE__DEBUG){
                log_message('ERROR', '********** VALIDATION ERRORS **********');
                log_message('ERROR', var_export($this->form_validation->error_array(), true));
                log_message('ERROR', '***************************************');
            }
        }else{
            // 成功処理
            $result = true;
        }

        // バリデーションルールをリセット
        $this->form_validation->reset_validation();
        
        return $result;
    }
}
