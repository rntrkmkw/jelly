<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Webクラス
 * @author kamikawa
 *
*/
class Web extends MY_Controller {

    protected $keep_alive_flg;                                  // セッションの延命フラグ
    public $request_data;                                       // リクエストデータ
    public $page_layout;                                        // デフォルトページレイアウト
    public $attr;                                               // 画面属性(1:buyer,2:afi,3:seller,4:portal)
    public $login_custamer_id;                                  // ログインカスタマーID（buyer:buyer_id, afi:afi_id,seller:seller_id）
    protected $login_config;                                    // ログインコンフィグ
    public $login_session_data = array();                       // ログインセッション情報

    function __construct(){
        parent:: __construct();

        // モデルロード
        // コンフィグロード
//        $this->load->config('login_config', TRUE);
//        $this->login_config = $this->config->item('login_config');
        // ヘルパーのロード
        $this->load->helper(array('form', 'url', 'jellyroll_common'));
        // ライブラリ
        // ライブラリロード
        $this->load->library(array('user_agent', 'session'));
        // 言語ロード
        $this->lang->load('message', 'japanese');
        $this->lang->load('form_validation', 'japanese');
        $this->lang->load('error', 'japanese_'. ENVIRONMENT_COMMON);

        // アプリ名の取得
        $this->app_name = strtolower(__CLASS__);
        // ページレイアウトを取得
        $this->page_layout = $this->get_directory(). $this->controller_name. '/'. $this->action_name;

        // レコード登録・更新者名
        //TODO 仮でこれまで通りIPアドレスをセット by nagao
        $this->by_user_name = $this->input->server('SERVER_ADDR');

        // データの初期化
        $this->init();
    }

    /**
     * アウトプットデータのリストデータにページ情報をセットする
     * ※1レコード分のリストでないデータはset_template_data()を使用すること
     * ※本関数はページネイションライブラリをロード後に使用する
     * @param unknown $list_code
     * @param unknown $list_data
     * @param string $pagination
     */
    protected function set_template_list($list_code, $list_data, $pagination){
        // 総ページ数算出用
        $page_count = (int)(get_total_rows() / $this->pagination->per_page);
        // 最終ページ算出用
        $mod_count = get_total_rows() % $this->pagination->per_page;
        // データセット
        $list = array('list_code'   => $list_code,                                      // リストコード(当該リストにつけるコード)※文字列でも数値でも可
                      'total_page'  => $mod_count == 0 ? $page_count : $page_count + 1, // 総ページ数
                      'page'        => get_current_page(),                              // 現在ページ
                      'total_rows' => get_total_rows(),                                 // 総数
                      'per_page'        => $this->pagination->per_page,                 // 単位
                      'view_start'  => get_current_page_start(),                        // 表示開始データ数
                      'view_end'    => get_current_page_end(),                          // 表示終了データ数
                      'list'        => $list_data,                                      // リストデータ(リストのネスト可)
                      'link'        => $pagination
                     );

        $this->data['response']['data'] = array_merge($this->data['response']['data'], $list);
    }

    /**
     * レスポンスデータに指定したデータ配列をセットする
     * ※リストデータの場合はset_template_list()を使用すること
     *
     * @param unknown $data
     */
    protected function set_template_data($data){
        $this->data['response']['data'] = array_merge($this->data['response']['data'], $data);
    }

    /**
     * エラーメッセージをレスポンスデータにセットする
     * ※メッセージとは排他
     * @param unknown $data
     * @param number $error_code
     * @param number $api_id
     */
    protected function set_error_info($data, $error_code = '0', $api_id = '0'){
        $this->data['response']['info']['status'] = ERROR__RESPONSE_STATUS__ERROR;
        $this->data['response']['info']['error_code'] = $error_code;
        $this->data['response']['info']['api_id'] = (string)$api_id;

        // 配列チェック
        if (!is_array($data)){
            $data = array($data);
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
    protected function init(){
        // インプットデータ
        $this->initialize_input_data();

        // レスポンスデータ：情報部
        $info = array('status'       => 0,                      // ステータス(0:成功、1:失敗)
                      'error_code'   => 0,                      // エラーコード(0:正常、99:システムエラー)※statusが1の時、有効
                      'message'      => array(),                // エラーメッセージ(statusが1の時、有効)
                      'request_data' => array(),                // リクエスト元画面
        );
        // レスポンスデータ：データ部
        $data = array();
        // アウトプット用データ配列の初期化
        $this->data['response'] = array('info' => $info,
                                        'data' => $data
        );

        // リクエストデータ
        $this->request_data = array('id'         => '',         // 画面ID
                                    'uri'        => '',         // リクエストURI
                                    'param_list' => array());   // パラメータ一覧
    }

    /**
     * インプットデータの初期化
     */
    private function initialize_input_data(){
        $flg = $this->input->post_get('keep_alive_flg');
        $this->keep_alive_flg = empty($flg) ? false : true;                   // セッション延命フラグ
    }

    /**
     * POST,GETパラメータ一覧を取得する
     * @return unknown
     */
    private function get_input_param_list(){
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
    private function set_request_data(){
        $this->request_data['id'] = get_class($this);
        $this->request_data['uri'] = uri_string();
        $this->request_data['param_list'] = $this->get_input_param_list();
        $this->request_data['attr'] = $this->attr;

        // レスポンスにセット
        if ($this->keep_alive_flg){
            // セッションの延命をする場合
            $this->request_data = $this->session->flashdata(FLASH_KEY__REQUEST__DATA);
        }
        $this->data['response']['info']['request_data'] = $this->request_data;

        // セッションクラスを使用してSessionに格納
        $this->session->set_flashdata(FLASH_KEY__REQUEST__DATA, $this->request_data);
    }

    //TODO output_data以外から呼ぶためにprotectedに変更　2重呼び出しで影響ないか継続検証 by nagao
    /**
     * アウトプット用データを設定する
     */
    protected function set_output_data(){
        // リスエストデータをSessionに格納
        $this->set_request_data();
    }

    /**
     * 指定コントローラのビューを出力する
     * @param string $ctrl_name
     */
    protected function output_data($ctrl_name = ''){
        // アウトプット用データを設定する
        $this->set_output_data();

        // モデルロード
        $this->load->model('page_layout_model');
        // DBからページレイアウト情報を取得する
        $block_list = $this->page_layout_model->getPageLayout($ctrl_name);

        // ビュー取得失敗
        if (count($block_list) == 0){
            show_error(add_error_trace($this->lang->line('error_system_error'), $ctrl_name.':DBからビュー取得失敗'));
            return;
        }

        // 動作モードがデバッグの場合はプロファイル情報を出力
        if (config_item('app_exec_mode') == APPLICATION_RUNNNING_MODE__DEBUG){
            $this->output->enable_profiler();
            $this->data['block_data']['load_list']['profiler_css'] = 'layout/profiler.css';
        }

        // 追加ファイルの読み込み設定
        $this->data['block_data']['load_list']['add_option'] = array('css' => array(), 'js' => array());
        if (!empty($block_list[0]['add_option'])){
            // DBデータは「,」区切りで複数保存されているため分割
            $add_list = explode(',', $block_list[0]['add_option']);
            // 配列データをビューで読み込み可能な形にセットしなおす
            foreach ($add_list as $file){
                // CSSとJSの振り分け
                if (strstr($file, '.css')){
                    $this->data['block_data']['load_list']['add_option']['css'][] = $file;
                } else {
                    $this->data['block_data']['load_list']['add_option']['js'][] = $file;
                }
            }
        }

        // 属性ごとの固有CSSの読み込み設定
        switch ($this->attr){
            case APPLICATION_VIEW_ATTRIBUTE__PORTAL:
            case APPLICATION_VIEW_ATTRIBUTE__BUYER:
                $this->data['block_data']['load_list']['add_option']['css'][] = 'css/layout/buyer_common.css';
                break;
            case APPLICATION_VIEW_ATTRIBUTE__AFI:
                $this->data['block_data']['load_list']['add_option']['css'][] = 'css/layout/afi_common.css';
                break;
            case APPLICATION_VIEW_ATTRIBUTE__SELLER:
                $this->data['block_data']['load_list']['add_option']['css'][] = 'css/layout/seller_common.css';
                break;
            default:
                break;
        }

        // ビューをロードして画面表示
        // ブロックデータ格納用配列
        $this->data['block_data']['page_layout'] = array();
        for ($i = 0; $i < count($block_list); $i++){
            // DBから取得したビューデータをブロック単位で処理する
            $this->data['block_data']['page_layout'][$i] = $block_list[$i];

            $block_path = $block_list[$i]['block_path'];                // ブロックパス
            $replace_key = array('other_block/', 'main_block/');
            $dir_name = str_replace($replace_key, '', $block_path);     // ビューブロックの格納ディレクトリ名
            $this->data['block_data']['page_layout'][$i]['dir_name'] = $dir_name;
            $block_name = $block_list[$i]['block_name'];                // ブロックファイル名

            // モバイル判定
            if ($this->agent->is_mobile()){
                $css_name = $block_name;
                $js_name = $block_name;
                // SP用ブロックがある場合はブロック名を変更
                $block_name .= $block_list[$i]['sp_block_flag'] ? '_sp' : '';
                $this->data['block_data']['page_layout'][$i]['block_name'] = $block_name;

                // CSS・JS読み込み用配列の作成
                $sp_css_str = $block_list[$i]['sp_css_flag'] ? '_sp' : '';
                $sp_js_str = $block_list[$i]['sp_js_flag'] ? '_sp' : '';
                $this->data['block_data']['load_list'][$block_path. $sp_css_str. '_css'] = $block_path. '/'. $dir_name. $sp_css_str. '.css';
                $this->data['block_data']['load_list'][$block_name. '_css'] = $block_path. '/'. $css_name. $sp_js_str. '.css';
                $this->data['block_data']['load_list'][$block_path. $sp_js_str. '_js'] = $block_path. '/'. $dir_name. $sp_js_str. '.js';
                $this->data['block_data']['load_list'][$block_name. '_js'] = $block_path. '/'. $js_name. $sp_js_str. '.js';
            } else {
                // PCブラウザ
                // CSS・JS読み込み用配列の作成
                $this->data['block_data']['load_list'][$block_path. '_css'] = $block_path. '/'. $dir_name. '.css';
                $this->data['block_data']['load_list'][$block_name. '_css'] = $block_path. '/'. $block_name. '.css';
                $this->data['block_data']['load_list'][$block_path. '_js'] = $block_path. '/'. $dir_name. '.js';
                $this->data['block_data']['load_list'][$block_name. '_js'] = $block_path. '/'. $block_name. '.js';
            }

            // 配列の最終要素かチェック
            if ($i != count($block_list) - 1){
                // 最終要素でない場合
                $this->output_view($block_path, $block_name, false, $i);
            } else {
                // 最終要素の場合
                // モバイル判定
                // モバイルの場合は設定されたレイアウトタイプを使用する
                if ($this->agent->is_mobile()){
                    $this->data['block_data']['type'] = $block_list[$i]['type'];
                } else {
                    // PCブラウザを使用
                    $this->data['block_data']['type'] = 0;
                }
                $this->output_view($block_path, $block_name, true, $i);
            }
        }
    }

    /**
     * ビューデータを作成し、ブラウザへ出力する
     * @param unknown $block_path
     * @param unknown $block_name
     * @param unknown $flag
     * @param unknown $index
     */
    private function output_view($block_path, $block_name, $flag, $index) {
        // ブロックパス＋ブロック名をキーにした連想配列にビューデータを保存していく
        $this->data['block_data']['page_layout'][$index][$block_path. '/'. $block_name] =
                            $this->load->view($block_path. '/'. $block_name, $this->data, true);

        // 動作モードがデバッグの場合はHTMLのコメントでブロック名を出力する
        if (config_item('app_exec_mode') == APPLICATION_RUNNNING_MODE__DEBUG){
            $page_data = $this->data['block_data']['page_layout'][$index];
            // 先頭にコメント追加
            $this->data['block_data']['page_layout'][$index][$block_path. '/'. $block_name] =
                        substr_replace($page_data[$block_path. '/'. $block_name],
                                       "\n<!-- ##### TARGET: ". $page_data['target_id']. "-". $page_data['block_row']. " ##### --> ".
                                       "\n<!-- ***** ". $block_path. '/'. $block_name. " START ***** -->\n", 0, 0);
            // 最後にコメント追加
            $this->data['block_data']['page_layout'][$index][$block_path. '/'. $block_name] .= "\n<!-- ***** ". $block_path. '/'. $block_name. "  END  ***** -->\n";
        }

        // 最終ビューの場合
        if ($flag){
            $this->load->view('layout/layout_'. $this->data['block_data']['type'], $this->data['block_data']);
        }
    }

    /**
     * ログインチェックをするかしないかを返す
     *
     * @return boolean true:する,false:しない
     */
    protected function is_exec_check_login_status(){
        $search_list = array();

        switch ($this->attr){
            case APPLICATION_VIEW_ATTRIBUTE__AFI:
                $search_list = $this->login_config['afi_skip_list'];
                break;
            case APPLICATION_VIEW_ATTRIBUTE__BUYER:
                $search_list = $this->login_config['buyer_skip_list'];
                break;
            case APPLICATION_VIEW_ATTRIBUTE__SELLER:
                $search_list = $this->login_config['seller_skip_list'];
                break;
            default:
                show_error(add_error_trace($this->lang->line('error_system_error')));
                break;
        }

        $result = array_key_exists($this->page_layout, $search_list);

        if ($result === FALSE) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * ログイン画面のURLを取得する
     * @return boolean
     */
    protected function get_login_from_url(){
        $search_list = array();

        $redirect_url;

        switch ($this->attr){
            case APPLICATION_VIEW_ATTRIBUTE__AFI:
                $search_list = $this->login_config['afi_redirect_list'];
                $redirect_url = AFI_LOGIN_FORM_URL;
                break;
            case APPLICATION_VIEW_ATTRIBUTE__BUYER:
                $search_list = $this->login_config['buyer_redirect_list'];
                $redirect_url = BUYER_LOGIN_FORM_URL;
                break;
            case APPLICATION_VIEW_ATTRIBUTE__SELLER:
                $search_list = $this->login_config['seller_redirect_list'];
                $redirect_url = SELLER_LOGIN_FORM_URL;
                break;
            default:
                show_error(add_error_trace($this->lang->line('error_system_error')));
                break;
        }

        $result = array_key_exists($this->page_layout, $search_list);
        if ($result === FALSE) {
            return $redirect_url;
        } else {
            $this->set_output_data();
            return get_url_view($redirect_url, array(), REQUEST_URI__KEEP_ALIVE_FLG__ON);
        }
    }

    /**
     * ビューデータのadd_optionを取得する
     */
    public function get_add_option(){
        return $this->data['block_data']['load_list']['add_option'];
    }

    /**
     * CSV形式のレスポンスを生成する
     * @param unknown $csv_data
     */
    protected function output_csv($csv_data) {

        if(!isset($csv_data)){
            show_error(add_error_trace($this->lang->line('error_system_error')));
        }

        $this->session->keep_flashdata(FLASH_KEY__REQUEST__DATA);

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
}
