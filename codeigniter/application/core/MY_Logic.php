<?php

/**
 * ロジック基底クラス
 *
 * @author kamikawa
 */
class MY_Logic {

    // インスタンス
    protected $CI = null;
    public $app_exec_mode = APPLICATION_RUNNNING_MODE__DEBUG;

    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    /**
     * パラメータチェック
     * @param Array $validation_list
     * @return Boolean
     */
    public function check_params($validation_list){
        $result = false;

        // バリデーションルール設定
        $this->CI->form_validation->set_rules($validation_list);

        // チェック開始
        if($this->CI->form_validation->run() == FALSE){
            // エラー処理
            if ($this->app_exec_mode == APPLICATION_RUNNNING_MODE__DEBUG){
                log_message('ERROR', '********** VALIDATION ERRORS **********');
                log_message('ERROR', var_export($this->CI->form_validation->error_array(), true));
                log_message('ERROR', '***************************************');
            }
        }else{
            // 成功処理
            $result = true;
        }

        $this->CI->form_validation->reset_validation();
        
        return $result;
    }

    /**
     * バリデーションリスト取得
     *
     * @param Integer $api_id 
     * @return Array
     */
    public function get_validation_list($api_id) {
        $validation_list = array(
            'J0100' => array(
                array('field' => 'app_ver', 'label' => 'アプリバージョン', 'rules' => 'required|regex_match[^[a-zA-Z0-9 .,\-]+$^]'),
                array('field' => 'os_type', 'label' => 'OS種別', 'rules' => 'required|greater_than_equal_to['. T_USER__OS_TYPE__IOS. ']|less_than_equal_to['. T_USER__OS_TYPE__ANDROID.']'),
                array('field' => 'os_ver', 'label' => 'OSバージョン', 'rules' => 'required|regex_match[^[a-zA-Z0-9 .,\-]+$^]'),
                array('field' => 'uiid', 'label' => '端末識別番号', 'rules' => 'required|alpha_numeric'),
                array('field' => 'device_ver', 'label' => 'デバイスバージョン', 'rules' => 'required|regex_match[^[a-zA-Z0-9 .,\-]+$^]'),
                array('field' => 'device_token', 'label' => 'デバイストークン', 'rules' => 'required|alpha_numeric'),
            ),
            'J0101' => array(
                array('field' => 'name', 'label' => 'ユーザ名', 'rules' => 'regex_match[^[a-zA-Z0-9 .,\-]+$^]'),
                array('field' => 'image_url', 'label' => 'プロフィール画像URL', 'rules' => 'regex_match[^[a-zA-Z0-9 .,\-]+$^]'),
                array('field' => 'auth_token', 'label' => 'Facebook認証トークン', 'rules' => 'alpha_numeric'),
                array('field' => 'secret_key', 'label' => 'Facebookシークレットキー', 'rules' => 'alpha_numeric'),
                array('field' => 'facebook_id', 'label' => 'Facebook ID', 'rules' => 'alpha_numeric')
            ),
            'J0103' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric')
            ),
            'J0104' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric')
            ),
            'J0105' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'facebook_ids[]', 'label' => 'フレンドリスト', 'rules' => 'required|alpha_numeric')
            ),
            'J0200' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'facebook_ids[]', 'label' => 'フレンドリスト', 'rules' => 'required|alpha_numeric')
            ),
            'J0300' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric')
            ),
            'J0301' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric'),
                array('field' => 'status', 'label' => 'ステータス', 'rules' => 'required|greater_than_equal_to['. T_STAGE__STATUS__DEFAULT. ']|less_than_equal_to['. T_STAGE__STATUS__CLEARED.']'),
                array('field' => 'score', 'label' => 'スコア', 'rules' => 'required|numeric'),
                array('field' => 'rank', 'label' => '評価', 'rules' => 'required|greater_than_equal_to[1]|less_than_equal_to[3]')
            ),
            'J0302' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'map_id', 'label' => 'マップID', 'rules' => 'required|numeric')
            ),
            'J0400' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric')
            ),
            'J0401' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'numeric'),
                array('field' => 'product_id', 'label' => 'プロダクトID', 'rules' => 'required|alpha_numeric'),
                array('field' => 'receipt', 'label' => 'レシート', 'rules' => 'required')
            ),
            'J0500' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric')
            ),
            'J0501' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'item_id', 'label' => 'アイテムID', 'rules' => 'required|numeric')
            ),
            'J0502' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'item_id', 'label' => 'アイテムID', 'rules' => 'required|numeric')
            ),
            'J0503' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'item_price_id', 'label' => 'アイテム価格ID', 'rules' => 'required|numeric')
            ),
            'J0600' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'event_member_id', 'label' => 'イベントメンバーID', 'rules' => 'required|numeric')
            ),
            'J0601' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric'),
                array('field' => 'event_id', 'label' => 'イベントID', 'rules' => 'required|numeric'),
                array('field' => 'event_member_id', 'label' => 'イベントメンバーID', 'rules' => 'required|numeric'),
                array('field' => 'event_stage_id', 'label' => 'イベントステージID', 'rules' => 'required|numeric'),
                array('field' => 'm_stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric'),
                array('field' => 'status', 'label' => 'ステータス', 'rules' => 'required|greater_than_equal_to['. T_EVENT_STAGE__STATUS__FAILED. ']|less_than_equal_to['. T_EVENT_STAGE__STATUS__SUCCESS.']')
            ),
            'J1000' => array(
                array('field' => 'os_type', 'label' => 'OS種別', 'rules' => 'required|greater_than_equal_to['. T_USER__OS_TYPE__IOS. ']|less_than_equal_to['. T_USER__OS_TYPE__ANDROID.']')
            ),
            'J1004' => array(
                array('field' => 'stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric')
            ),
            'J1005' => array(
                array('field' => 'stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric')
            ),
            'J1006' => array(
                array('field' => 'map_id', 'label' => 'マップID', 'rules' => 'required|numeric')
            ),
            'J1007' => array(
                array('field' => 'stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric')
            ),
            'J1008' => array(
                array('field' => 'stage_id', 'label' => 'ステージID', 'rules' => 'required|numeric')
            ),
            'J5000' => array(
                array('field' => 'user_id', 'label' => 'ユーザID', 'rules' => 'required|numeric')
            )
        );
        return $validation_list[$api_id];
    }

    /**
     * 管理画面の操作ログを登録する
     *
     * @param string $account_id
     * @param string $web
     * @return boolean
     */
    function resist_admin_operation_log($account_id = null, $web=false) {
        $status = false;

        // Web画面でなく未ログイン時はオペレーションログをとらない
        if (!$web && !$this->CI->it_login_admin->is_login()) {
            return $status;
        }

        if(empty($account_id)){
           $account_id =  $this->CI->login_account_id;
        }

        // 操作メニューID
        $current_admin_menu_id = OPERATION_LOG__ADMIN_MENU_ID__UNKNOWN;

        // 操作タイプ
        $operation_type = '';

        //モード
        $mode = $this->CI->input->post('mode');

        // 操作タイプ判定
        $list = strrpos($this->CI->action_name, 'list');
        $detail = strrpos($this->CI->action_name, 'detail');
        $download = strrpos($this->CI->action_name, 'download');
        $regist = strrpos($this->CI->action_name, 'regist_conf');
        $update = strrpos($this->CI->action_name, 'update_conf');
        $delete = strrpos($this->CI->action_name, 'delete_conf');
        $mail_send = strrpos($this->CI->action_name, 'mail_send_conf');
        $upload = strrpos($this->CI->action_name, 'upload');

        if ($list !== false){
            $current_admin_menu_id = $this->CI->current_admin_menu_id;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__SELECT;
        }else if ($detail !== false){
            $current_admin_menu_id = $this->CI->current_admin_menu_id;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__DETAIL;
        }else if ($download !== false){
            $current_admin_menu_id = $this->CI->current_admin_menu_id;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__DOWNLOAD;
        }else if ($upload !== false){
            $current_admin_menu_id = $this->CI->current_admin_menu_id;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__UPLOAD;
        }else if ($regist !== false){
            if($mode == CTRL__MODE__EXEC_REGIST || $mode == CTRL__MODE__EXEC_UPDATE || $mode == CTRL__MODE__EXEC_DELETE){
                $current_admin_menu_id = $this->CI->current_admin_menu_id;
                $operation_type = ADMIN_OPERATION_LOG__TYPE__REGIST;
            }
        }else if($update !== false){
            if($mode == CTRL__MODE__EXEC_REGIST || $mode == CTRL__MODE__EXEC_UPDATE || $mode == CTRL__MODE__EXEC_DELETE){
                $current_admin_menu_id = $this->CI->current_admin_menu_id;
                $operation_type = ADMIN_OPERATION_LOG__TYPE__UPDATE;
            }
        }else if($delete !== false){
            if($mode == CTRL__MODE__EXEC_REGIST || $mode == CTRL__MODE__EXEC_UPDATE || $mode == CTRL__MODE__EXEC_DELETE){
                $current_admin_menu_id = $this->CI->current_admin_menu_id;
                $operation_type = ADMIN_OPERATION_LOG__TYPE__DELETE;
            }
        }else if($mail_send !== false){
            if($mode == CTRL__MODE__EXEC_REGIST || $mode == CTRL__MODE__EXEC_UPDATE || $mode == CTRL__MODE__EXEC_DELETE){
                $current_admin_menu_id = $this->CI->current_admin_menu_id;
                $operation_type = ADMIN_OPERATION_LOG__TYPE__MAIL_SEND;
            }
        }else if($this->CI->controller_name == 'top' && $this->CI->action_name == 'index'){
            $current_admin_menu_id = OPERATION_LOG__ADMIN_MENU_ID__LOGIN;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__LOGIN;
        }else if($this->CI->controller_name == 'afi_login' && $this->CI->action_name == 'form'){
            $current_admin_menu_id = OPERATION_LOG__ADMIN_MENU_ID__PROXY_LOGIN;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__PROXY_LOGIN_AFI;
        }else if($this->CI->controller_name == 'buyer_login' && $this->CI->action_name == 'form'){
            $current_admin_menu_id = OPERATION_LOG__ADMIN_MENU_ID__PROXY_LOGIN;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__PROXY_LOGIN_BUYER;
        }else if($this->CI->controller_name == 'seller_login' && $this->CI->action_name == 'form'){
            $current_admin_menu_id = OPERATION_LOG__ADMIN_MENU_ID__PROXY_LOGIN;
            $operation_type = ADMIN_OPERATION_LOG__TYPE__PROXY_LOGIN_SELLER;
        }

        if(!empty($operation_type)){

            // モデルロード
            $this->CI->load->model('admin_operation_log_model');

            // トランザクション開始
            $this->transaction_begin();

            // 他のトランザクション処理確定後に実行
            $status = $this->CI->admin_operation_log_model->insert_admin_operation_log($account_id, $current_admin_menu_id, $operation_type);

            // トランザクションコミット
            $this->transaction_commit();
        }

        return $status;
    }
}
