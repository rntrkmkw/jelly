<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 管理画面の基底クラス
 *
 * @author kamikawa
 *
 *
 */
class Admin extends MY_Controller {
    protected $keep_alive_flg;                              // セッションの延命フラグ
    public $request_data;                                   // リクエストデータ
    public $page_layout;                                    // デフォルトページレイアウト
    public $login_account_id;                               // ログインアカウントID
    public $login_admin_session_data = array();             // 管理画面ログインセッション情報
    public $group_permission_session_data = array();        // 管理画面権限セッション情報
    public $login_session_data = array();                   // ログインセッション情報(WEB側代理ログイン用)
    public $current_admin_menu_id;                          // カレント管理者メニューID
    public $current_admin_menu_name;                        // カレント管理者メニュー名
    protected $customer_config;                             // カスタマーコンフィグ

    function __construct() {
        parent::__construct();

        // 管理画面用のセッションID保存キーの設定
        // ※config.phpの設定をsessionライブラリロード前に上書きする
        $this->config->set_item('sess_cookie_name', 'ci_admin_session');

        // モデルロード
        // コンフィグロード
        $this->load->config('customer_config', TRUE);
        $this->customer_config = $this->config->item('customer_config');

        // ヘルパーのロード
        $this->load->helper(array(
                        'form',
                        'url',
                        'it_form',
                        'it_model_common'
        ));
        // ライブラリ
        // ライブラリロード
        $this->load->library(array(
                        'user_agent',
                        'it_login_admin',
                        'session'
        ));
        // ヘルパロード
        $this->load->helper(array(
                        'it_common'
        ));
        // 言語ロード
        $this->lang->load('message', 'japanese');
        $this->lang->load('form_validation', 'japanese');
        $this->lang->load('error', 'japanese_' . ENVIRONMENT_COMMON);

        // アプリ名の取得
        $this->app_name = strtolower(__CLASS__);
        // ページレイアウトを取得
        $this->page_layout = $this->get_directory() . $this->controller_name . '/' . $this->action_name;

        // データの初期化
        $this->init();

        // ログインチェック
        // ログイン画面表示時はチェックしない
        if ($this->page_layout != 'login/index') {
            if (! $this->it_login_admin->is_login()) {
                it_redirect('login/index?logout_mode=1');
            }
        }

        // レコード登録・更新者名
        // これまで通りログインIDをセット
        $this->by_user_name = $this->login_account_id;
    }

    /**
     * アウトプットデータのリストデータにページ情報をセットする
     * ※1レコード分のリストでないデータはset_template_data()を使用すること
     * ※本関数はページネイションライブラリをロード後に使用する
     *
     * @param unknown $list_code
     * @param unknown $list_data
     * @param string $pagination
     */
    protected function set_template_list($list_code, $list_data, $pagination) {
        // 総ページ数算出用
        $page_count = (int)(get_total_rows() / $this->pagination->per_page);
        // 最終ページ算出用
        $mod_count = get_total_rows() % $this->pagination->per_page;
        // データセット
        $list = array(
                        'list_code' => $list_code,                                          // リストコード(当該リストにつけるコード)※文字列でも数値でも可
                        'total_page' => $mod_count == 0 ? $page_count : $page_count + 1,    // 総ページ数
                        'page' => get_current_page(),                                       // 現在ページ
                        'total_rows' => get_total_rows(),                                   // 総数
                        'per_page' => $this->pagination->per_page,                          // 単位
                        'view_start' => get_current_page_start(),                           // 表示開始データ数
                        'view_end' => get_current_page_end(),                               // 表示終了データ数
                        'list' => $list_data,                                               // リストデータ(リストのネスト可)
                        'link' => $pagination
        );

        $this->data['response']['data'] = array_merge($this->data['response']['data'], $list);
    }

    /**
     * レスポンスデータに指定したデータ配列をセットする
     * ※リストデータの場合はset_template_list()を使用すること
     *
     * @param unknown $data
     */
    protected function set_template_data($data) {
        $this->data['response']['data'] = array_merge($this->data['response']['data'], $data);
    }

    /**
     * エラーメッセージをレスポンスデータにセットする
     *
     * @param unknown $data
     * @param number $error_code
     */
    protected function set_error_info($data, $error_code = 0) {
        $this->data['response']['info']['status'] = ERROR__RESPONSE_STATUS__ERROR;
        $this->data['response']['info']['error_code'] = $error_code;
        // 配列チェック
        if (! is_array($data)) {
            $data = array(
                            $data
            );
        }
        $this->data['response']['info']['message'] = array_merge($this->data['response']['info']['message'], $data);
    }

    /**
     * メッセージをレスポンスデータにセットする
     * ※エラーメッセージとは排他
     * @param unknown $data
     */
    protected function set_message_info($data){
        $this->data['response']['info']['status'] = ERROR__RESPONSE_STATUS__SUCCESS;
        // 配列チェック
        if (!is_array($data)){
            $data = array($data);
        }
        $this->data['response']['info']['message'] = array_merge($this->data['response']['info']['message'], $data);
    }


    /**
     * 個別に読み込むJSとCSSのリストをセットする
     * @param unknown $js_list
     * @param unknown $css_list
     */
    protected function set_add_option($js_list = array(), $css_list = array()) {
        // JS配列チェック
        if (! is_array($js_list)) {
            $js_list = array(
                            $js_list
            );
        }
        $this->data['add_option']['js'] = $js_list;

        // CSS配列チェック
        if (! is_array($css_list)) {
            $css_list = array(
                            $css_list
            );
        }
        $this->data['add_option']['css'] = $css_list;
    }

    /**
     * 初期化
     */
    private function init() {
        // インプットデータ
        $this->initialize_input_data();

        // レスポンスデータ：情報部
        $info = array(
                        'status' => 0,  // ステータス(0:成功、1:失敗)
                        'error_code' => 0,  // エラーコード(0:正常、99:システムエラー)※statusが1の時、有効
                        'message' => array(),  // エラーメッセージ(statusが1の時、有効)
                        'request_data' => array()
        ); // リクエスト元画面

        // レスポンスデータ：データ部
        $data = array();
        // アウトプット用データ配列の初期化
        $this->data['response'] = array(
                        'info' => $info,
                        'data' => $data
        );

        // リクエストデータ
        $this->request_data = array(
                        'id' => '',  // 画面ID
                        'uri' => '',  // リクエストURI
                        'param_list' => array()
        ); // パラメータ一覧
    }

    /**
     * インプットデータの初期化
     */
    private function initialize_input_data() {
        $flg = $this->input->post_get('keep_alive_flg');
        $this->keep_alive_flg = empty($flg) ? false : true; // セッション延命フラグ
    }

    /**
     * POST,GETパラメータ一覧を取得する
     *
     * @return unknown
     */
    private function get_input_param_list() {
        $paramList_post = $this->input->post();
        $paramList_post = empty($paramList_post) ? array() : $paramList_post;
        $paramList_get = $this->input->get();
        $paramList_get = empty($paramList_get) ? array() : $paramList_get;

        $paramList = array();
        $paramList['post'] = $paramList_post;
        $paramList['get'] = $paramList_get;

        return $paramList;
    }

    /**
     * リクエストデータを格納する
     */
    private function set_request_data() {
        $this->request_data['id'] = get_class($this);
        $this->request_data['uri'] = uri_string();
        $this->request_data['param_list'] = $this->get_input_param_list();

        // レスポンスにセット
        if ($this->keep_alive_flg) {
            // セッションの延命をする場合
            $this->request_data = $this->session->flashdata(FLASH_KEY__ADMIN_REQUEST__DATA);
        }
        $this->data['response']['info']['request_data'] = $this->request_data;

        // セッションクラスを使用してSessionに格納
        $this->session->set_flashdata(FLASH_KEY__ADMIN_REQUEST__DATA, $this->request_data);
    }

    /**
     * アウトプット用データを設定する
     */
    private function set_output_data() {
        // リスエストデータをSessionに格納
        $this->set_request_data();
    }

    /**
     * 指定コントローラのビューを出力する
     *
     * @param string $view_name
     */
    public function output_data($view_name = '', $header_flg = false) {
        // アウトプット用データを設定する
        $this->set_output_data();

        // 動作モードがデバッグの場合はプロファイル情報を出力
        if (config_item('app_exec_mode') == APPLICATION_RUNNNING_MODE__DEBUG) {
            $this->output->enable_profiler();
        }

        switch (ENVIRONMENT){
            case 'local':
                $this->data['env_str'] = '[ローカル環境]';
                break;
            case 'development':
                $this->data['env_str'] = '[検証環境]';
                break;
            case 'testing':
                $this->data['env_str'] = '[ステージング環境]';
                break;
            case 'production':
                $this->data['env_str'] = '[本番環境]';
                break;
            default:
                break;
        }

        $this->data['view_header'] = '';
        // 権限チェック結果をチェック
        // ※admin/配下のコントローラは権限チェックなし
        if (strlen($this->get_directory()) != 0) {
            if (($this->it_login_admin->auth_result == ADMIN_AUTH__CHECK_RESULT__DEFAULT) || ($this->it_login_admin->auth_result == ADMIN_AUTH__CHECK_RESULT__NG)) {
                // ヘッダをロード
                $this->data['view_header'] = $this->load->view('admin/common/header', $this->data, true);
                // 権限チェックをしていない場合
                $view_name = 'admin/common/auth_error';
            }
        }

        // メインビューをロード
        if (empty($view_name)) {
            // ヘッダをロード
            $this->data['view_header'] = $this->load->view('admin/common/header', $this->data, true);
            $view_name = 'admin/' . $this->get_directory() . $this->controller_name . '_' . $this->action_name;
        }

        if($header_flg){
            // ヘッダをロード
            $this->data['view_header'] = $this->load->view('admin/common/header', $this->data, true);
        }

        $this->data['main_contents'] = $this->load->view($view_name, $this->data, true);

        // 操作ログ記録
        $this->resist_operation_log();

        $this->load->view('admin/common/layout', $this->data);
    }

    /**
     * ダウンロードレベルを取得
     */
    public function get_download_level(){

        $download_level = ADMIN_GROUP_PERMISSION__DOWNLOAD_LEVEL__NOTHING;

        foreach ($this->group_permission_session_data as $premission){

            if($premission['controller'] == $this->controller_name){
                $download_level = $premission['download_level'];
                break;
            }
        }

        return $download_level;
    }

    /**
     * CSV形式のレスポンスを生成する
     * @param unknown $csv_data
     */
    protected function output_csv($csv_data) {

        if(!isset($csv_data)){
            show_error(add_error_trace($this->lang->line('error_system_error')));
        }

        $this->session->keep_flashdata(FLASH_KEY__ADMIN_REQUEST__DATA);

        // 操作ログ記録
        $this->resist_operation_log();

        $this->output_csv_base($csv_data);
    }

    /**
     * ファイルをアップロードする
     * @param unknown $field_name
     * @param unknown $path
     * @param unknown $file_name
     * @param string $types
     * @param string $max_seize
     * @return Ambigous <string, multitype:NULL >
     */
    public function upload_file($field_name, $path, $file_name, $types = NULL, $max_seize = NULL) {
        return $this->upload_file_base($field_name, $path, $file_name, $types, $max_seize);
    }

    /**
     * 操作ログ記録
     */
    private function resist_operation_log(){
        // ロジッククラスコール
        $this->load->library($this->directory_name . $this->controller_name . '_logic');
        $this->{$this->controller_name . '_logic'}->resist_admin_operation_log();
    }
}
