<?php

defined('BASEPATH') or exit('No direct script access allowed');
class It_login_admin {
    public $CI;
    public $auth_result = ADMIN_AUTH__CHECK_RESULT__DEFAULT; // 権限チェック結果※0は未チェック

    public function __construct() {
        $this->CI = &get_instance();
    }

    // --------------------------------------------------------------------
    /**
     * 管理画面ログイン
     *
     * @param unknown $id
     * @param unknown $password
     * @return number
     */
    public function login_admin($id, $password) {
        // モデルロード
        $this->CI->load->model('admin_account_model');

        // トランザクション開始
        // $this->CI->db->trans_begin();

        // ログイン情報を取得
        $login_info = $this->CI->admin_account_model->get_login_info($id);
        // 存在チェック
        if (empty($login_info)) {
            return ERROR__LOGIN__NON_USER;
        }

        // パスワードチェック
        if (! password_verify($password, $login_info['password'])) {
            return ERROR__LOGIN__MISS_MATCH_PASSWORD;
        }

        // ログインチェック
        if (! $this->is_login()) {
            // セッションにログイン情報を格納
            $session_data = array(
                            SESS_KEY__ADMIN_LOGIN__INFO => $login_info
            );
            $this->CI->session->set_userdata(SESS_KEY__ADMIN_LOGIN__LOGIN, $session_data);
            // セッション情報をCIオブジェクトへセット
            $this->CI->login_admin_session_data = $session_data;
            // モデルロード
            $this->CI->load->model('admin_group_permission_model');
            // メニュー権限一覧を取得
            $this->CI->group_permission_session_data = $this->CI->admin_group_permission_model->get_enable_permission_list($login_info['admin_group_id']);
        }
        // コミット
        // $this->CI->db->trans_commit();

        // ログイン中の場合はアカウントIDをセット
        $this->CI->login_account_id = $login_info['login_account_id'];

        return LOGIN__STATUS__SUCCESS;
    }

    // --------------------------------------------------------------------
    /**
     *
     * @param unknown $ctrl_url
     * @return boolean true:ログイン中,false:未ログイン
     */
    public function is_login() {

        // ログインユーザ情報取得
        $session_data = $this->CI->session->userdata(SESS_KEY__ADMIN_LOGIN__LOGIN);

        // セッションチェック
        if (empty($session_data)) {
            // セッション情報が存在しない場合は未ログイン
            return false;
        }

        // セッションとDBでデータ検証
        $login_info = array();
        $session_info = $session_data[SESS_KEY__ADMIN_LOGIN__INFO];
        // モデルロード
        $this->CI->load->model('admin_account_model');
        // ログイン情報を取得
        $login_info = $this->CI->admin_account_model->get_login_id($session_info['login_account_id']);

        // セッションとDBが不整合の場合は未ログイン
        if ($session_info['login_id'] != $login_info['login_id']) {
            $this->logout();
            return false;
        }

        // ログイン中の場合はアカウントIDをセット
        $this->CI->login_account_id = $login_info['login_account_id'];
        // セッション情報をCIオブジェクトへセット
        $this->CI->login_admin_session_data = $session_data;

        // モデルロード
        $this->CI->load->model('admin_group_permission_model');
        // メニュー権限一覧を取得
        $this->CI->group_permission_session_data = $this->CI->admin_group_permission_model->get_enable_permission_list($session_info['admin_group_id']);

        // ログイン中
        return true;
    }

    // --------------------------------------------------------------------
    /**
     * ログアウト
     */
    public function logout() {
        // セッションからログイン情報を削除する
        $this->CI->session->unset_userdata(SESS_KEY__ADMIN_LOGIN__LOGIN);
    }

    /**
     * 権限チェック
     * @param string $func_name
     * @param string $permission
     * @return boolean
     */
    public function is_auth($func_name = '', $permission = ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__ADMIN) {
        $result = false;


        $action_name = $this->CI->action_name;

        // 代理ログインアクション判定
        $pl_pos = strrpos($action_name, 'proxy_login');

        // ダウンロードアクション判定
        $dl_pos = strrpos($action_name, 'download');

        // 通常コントローラ
        if ($dl_pos === false && $pl_pos === false){
            // 特殊権限
            // ※権限チェックをコールする側で設定することが可能
            $sp_permission_list = array('permission' => $permission,
                                        'func_list' => empty($func_name) ? array(): array($func_name)
                                    );

            // 閲覧権限のみ
            $view_permission_list = array('permission' => ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__VIEW,
                                          'func_list' => array('lists', 'list', 'detail')
                                    );
            // 登録変更権限あり(INSERT/UPDATE)
            $update_permission_list = array('permission' => ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__UPDATE,
                                            'func_list' => array('regist', 'update', 'conf', 'comp')
                                    );
            // 管理者権限(DELETE)
            $admin_permission_list = array('permission' => ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__ADMIN,
                                           'func_list' => array('delete', 'del_conf', 'del_comp',
                                                                'ad_regist', 'ad_conf', 'ad_comp',
                                                                'ad_update')
                                    );
            // 権限一覧
            $permission_list = array(0 => $sp_permission_list,
                                     1 => $view_permission_list,
                                     2 => $update_permission_list,
                                     3 => $admin_permission_list
                                    );

            // リクエストされたコントローラ名から権限レベルを取得する
            $func_permission = ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__NOTHING;
            foreach ($permission_list as $permission_data){
                foreach ($permission_data['func_list'] as $func_data){
                    // 実行されたアクション名の権限レベルを検索する
                    $pos = strrpos($action_name, $func_data);
                    // 検索失敗はスキップ
                    if ($pos === false){
                        continue;
                    }
                    if (($pos + strlen($func_data)) == strlen($action_name)){
                        // 権限レベルをセット
                        $func_permission = $permission_data['permission'];
                        break;
                    }
                }
                // 権限レベル設定済みの場合は検索ストップ
                if ($func_permission != ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__NOTHING){
                    break;
                }
            }

            // 権限レベルが未設定の場合
            if ($func_permission == ADMIN_GROUP_PERMISSION__CONTROLL_LEVEL__NOTHING){
                return $result;
            }

            // ログインユーザに設定されている権限を取得する
            foreach ($this->CI->group_permission_session_data as $self_permission){
                    // 権限チェックするコントローラを検索する
                if ($this->CI->controller_name != $self_permission['controller']){
                    continue;
                }

                $this->CI->current_admin_menu_id = $self_permission['admin_menu_id'];
                $this->CI->current_admin_menu_name = $self_permission['name'];

                // 実行権限チェック
                if (intval($self_permission['controll_level']) >= $func_permission){
                    // 権限チェック結果をセット
                    $this->auth_result = ADMIN_AUTH__CHECK_RESULT__OK;
                    $result = true;
                } else {
                    // 権限チェック結果をセット
                    $this->auth_result = ADMIN_AUTH__CHECK_RESULT__NG;
                }
                break;
            }

        // ダウンロードコントローラ
        }else if($dl_pos !== false){
            // ログインユーザに設定されている権限がダウンロード可能かチェック
            foreach ($this->CI->group_permission_session_data as $self_permission){
                // 権限チェックするコントローラを検索する
                if ($this->CI->controller_name != $self_permission['controller']){
                    continue;
                }

                $this->CI->current_admin_menu_id = $self_permission['admin_menu_id'];
                $this->CI->current_admin_menu_name = $self_permission['name'];

                // ダウンロード権限チェック
                if (intval($self_permission['download_level']) >= ADMIN_GROUP_PERMISSION__DOWNLOAD_LEVEL__PRIVATE_NG){
                    // 権限チェック結果をセット
                    $this->auth_result = ADMIN_AUTH__CHECK_RESULT__OK;
                    $result = true;
                } else {
                    // 権限チェック結果をセット
                    $this->auth_result = ADMIN_AUTH__CHECK_RESULT__NG;
                }
                break;
            }

        // 代理ログインコントローラ
        }else if($pl_pos !== false){

            $afi_pos = strrpos($action_name, 'afi');
            $buyer_pos = strrpos($action_name, 'buyer');
            $seller_pos = strrpos($action_name, 'seller');

            // ログインユーザ情報取得
            $session_data = $this->CI->session->userdata(SESS_KEY__ADMIN_LOGIN__LOGIN);

            // セッションチェック
            if (empty($session_data)) {
                // セッション情報が存在しない場合は未ログイン
                return false;
            }
            $login_info = $session_data[SESS_KEY__ADMIN_LOGIN__INFO];

            // モデルロード
            $this->CI->load->model('admin_group_model');
            $group_info = $this->CI->admin_group_model->get_group_info($login_info['admin_group_id']);

            $this->auth_result = ADMIN_AUTH__CHECK_RESULT__NG;

            if ($afi_pos !== false && $group_info['proxy_afi_flag'] == COMMON__FLAG__ON){
                // 権限チェック結果をセット
                $this->auth_result = ADMIN_AUTH__CHECK_RESULT__OK;
                $result = true;
            }
            if ($buyer_pos !== false && $group_info['proxy_buyer_flag'] == COMMON__FLAG__ON){
                // 権限チェック結果をセット
                $this->auth_result = ADMIN_AUTH__CHECK_RESULT__OK;
                $result = true;
            }
            if ($seller_pos !== false && $group_info['proxy_seller_flag'] == COMMON__FLAG__ON){
                // 権限チェック結果をセット
                $this->auth_result = ADMIN_AUTH__CHECK_RESULT__OK;
                $result = true;
            }

        }
        return $result;
    }
}
