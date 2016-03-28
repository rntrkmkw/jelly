<?php

defined('BASEPATH') or exit('No direct script access allowed');
class It_login {
    public $CI;
    public function __construct() {
        $this->CI = &get_instance();
    }

    // --------------------------------------------------------------------
    /**
     * アフィリエイターログイン
     *
     * @param unknown $id
     * @param unknown $password
     * @return number
     */
    public function login_afi($id, $password, $proxy_flag=FALSE) {
        // モデルロード
        $this->CI->load->model('afi_info_model');

        // 重複ログインチェック
        if ($this->is_duplicate_login($id)){
            $this->logout();
        }

        // トランザクション開始
        $this->CI->db->trans_begin();

        // ログイン情報を取得
        $login_info = $this->CI->afi_info_model->get_login_info($id);

        // 存在チェック
        if (empty($login_info)) {
            return ERROR__LOGIN__NON_USER;
        }
        // ステータスチェック
        switch ($login_info['status_flag']){
            case AFI_INFO__STATUS_FLAG__REGIST_COMPLETE:
                // 承認完了
                break;
            case AFI_INFO__STATUS_FLAG__REGIST_TEMP:
                // 仮登録
                return ERROR__LOGIN__STATUS_REGIST_TEMP;
                break;
            case AFI_INFO__STATUS_FLAG__NON_APPROVAL:
                // 非承認
                return ERROR__LOGIN__STATUS_NON_APPROVAL;
                break;
            case AFI_INFO__STATUS_FLAG__DELETE:
                // 削除
                return ERROR__LOGIN__STATUS_DELETE;
                break;
            default:
                // 不明なステータス
                return ERROR__LOGIN__UNKNOWN;
                break;
        }

        // 代理ログインフラグ
        if($proxy_flag){
            // 代理ログインチェック
            $result = $this->proxy_login($password);
            if($result != ERROR__RESPONSE_STATUS__SUCCESS){
                return $result;
            }

        }else{
            // パスワードチェック
            if (! password_verify($password, $login_info['login_passwd'])) {
                return ERROR__LOGIN__MISS_MATCH_PASSWORD;
            }
        }

        // ログインチェック
        if (! $this->check_login_status()) {
            // モデルロード
            $this->CI->load->model('afi_last_login_model');
            if (! $this->CI->afi_last_login_model->update_last_login($login_info['customer_id'])) {
                // ロールバック
                $this->CI->db->trans_rollback();
                // 不明なステータス
                return ERROR__LOGIN__UNKNOWN;
            }

            // セッションにログイン情報を格納
            $session_data = array(
                            SESS_KEY__LOGIN__USER_ATTR => $this->CI->attr,
                            SESS_KEY__LOGIN__INFO => $login_info
            );
            $this->CI->session->set_userdata(SESS_KEY__LOGIN__LOGIN, $session_data);
            //セッション情報をCIオブジェクトへセット
            $this->CI->login_session_data = $session_data;
        }
        // コミット
        $this->CI->db->trans_commit();

        // ログイン成功した場合はログインカスタマーIDを設定
        $this->CI->login_customer_id = $login_info['customer_id'];

        return LOGIN__STATUS__SUCCESS;
    }

    // --------------------------------------------------------------------
    /**
     * 購入者ログイン
     *
     * @param unknown $mail
     * @param unknown $password
     * @return string|number
     */
    public function login_buyer($mail, $password, $proxy_flag=FALSE) {
        // モデルロード
        $this->CI->load->model('buyer_info_model');

        // 重複ログインチェック
        if ($this->is_duplicate_login($mail)){
            $this->logout();
        }

        // トランザクション開始
        $this->CI->db->trans_begin();

        // ログイン情報を取得
        $login_info = $this->CI->buyer_info_model->get_login_info($mail);
        // 存在チェック
        if (empty($login_info)) {
            return ERROR__LOGIN__NON_USER;
        }

        // ステータスチェック
        switch ($login_info['status_flag']){
            case BUYER_INFO__STATUS_FLAG__REGIST_COMPLETE:
                // 承認完了
                break;
            case BUYER_INFO__STATUS_FLAG__NON_APPROVAL:
                // 非承認
                return ERROR__LOGIN__STATUS_NON_APPROVAL;
                break;
            case BUYER_INFO__STATUS_FLAG__DELETE:
                // 削除
                return ERROR__LOGIN__STATUS_DELETE;
                break;
            default:
                // 不明なステータス
                return ERROR__LOGIN__UNKNOWN;
                break;
        }
        // 代理ログインフラグ
        if($proxy_flag){
            // 代理ログインチェック
            $result = $this->proxy_login($password);
            if($result != ERROR__RESPONSE_STATUS__SUCCESS){
                return $result;
            }

        }else{
            // パスワードチェック
            if (! password_verify($password, $login_info['login_passwd'])) {
                return ERROR__LOGIN__MISS_MATCH_PASSWORD;
            }
        }

        // ログインチェック
        if (! $this->check_login_status()) {
            // モデルロード
            $this->CI->load->model('buyer_last_login_model');
            if (! $this->CI->buyer_last_login_model->update_last_login($login_info['customer_id'])) {
                // ロールバック
                $this->CI->db->trans_rollback();
                // 不明なステータス
                return ERROR__LOGIN__UNKNOWN;
            }

            // セッションにログイン情報を格納
            $session_data = array(
                            SESS_KEY__LOGIN__USER_ATTR => $this->CI->attr,
                            SESS_KEY__LOGIN__INFO => $login_info
            );
            $this->CI->session->set_userdata(SESS_KEY__LOGIN__LOGIN, $session_data);
            //セッション情報をCIオブジェクトへセット
            $this->CI->login_session_data = $session_data;
        }
        // コミット
        $this->CI->db->trans_commit();

        // ログイン成功した場合はログインカスタマーIDを設定
        $this->CI->login_customer_id = $login_info['customer_id'];

        return LOGIN__STATUS__SUCCESS;
    }

    // --------------------------------------------------------------------
    /**
     * 販売者ログイン
     *
     * @param unknown $id
     * @param unknown $password
     * @return number
     */
    public function login_seller($id, $password, $proxy_flag=FALSE) {
        // モデルロード
        $this->CI->load->model('seller_info_model');

        // 重複ログインチェック
        if ($this->is_duplicate_login($id)){
            $this->logout();
        }

        // トランザクション開始
        $this->CI->db->trans_begin();

        // ログイン情報を取得
        $login_info = $this->CI->seller_info_model->get_login_info($id);
        // 存在チェック
        if (empty($login_info)) {
            return ERROR__LOGIN__NON_USER;
        }
        // ステータスチェック
        switch ($login_info['status_flag']){
            case SELLER_INFO__STATUS_FLAG__REGIST_COMPLETE:
                // 承認完了
                break;
            case SELLER_INFO__STATUS_FLAG__REGIST_TEMP:
                // 仮登録
                return ERROR__LOGIN__STATUS_REGIST_TEMP;
                break;
            case SELLER_INFO__STATUS_FLAG__NON_APPROVAL:
                // 非承認
                return ERROR__LOGIN__STATUS_NON_APPROVAL;
                break;
            case SELLER_INFO__STATUS_FLAG__DELETE:
                // 削除
                return ERROR__LOGIN__STATUS_DELETE;
                break;
            default:
                // 不明なステータス
                return ERROR__LOGIN__UNKNOWN;
                break;
        }
        // 代理ログインフラグ
        if($proxy_flag){
            // 代理ログインチェック
            $result = $this->proxy_login($password);
            if($result != ERROR__RESPONSE_STATUS__SUCCESS){
                return $result;
            }

        }else{
            // パスワードチェック
            if (! password_verify($password, $login_info['login_passwd'])) {
                return ERROR__LOGIN__MISS_MATCH_PASSWORD;
            }
        }

        // ログインチェック
        if (! $this->check_login_status()) {
            // モデルロード
            $this->CI->load->model('seller_last_login_model');
            if (! $this->CI->seller_last_login_model->update_last_login($login_info['customer_id'])) {
                // ロールバック
                $this->CI->db->trans_rollback();
                // 不明なステータス
                return ERROR__LOGIN__UNKNOWN;
            }

            // セッションにログイン情報を格納
            $session_data = array(
                            SESS_KEY__LOGIN__USER_ATTR => $this->CI->attr,
                            SESS_KEY__LOGIN__INFO => $login_info
            );
            $this->CI->session->set_userdata(SESS_KEY__LOGIN__LOGIN, $session_data);
            //セッション情報をCIオブジェクトへセット
            $this->CI->login_session_data = $session_data;
        }

        // コミット
        $this->CI->db->trans_commit();

        // ログイン成功した場合はログインカスタマーIDを設定
        $this->CI->login_customer_id = $login_info['customer_id'];

        return LOGIN__STATUS__SUCCESS;
    }

    // --------------------------------------------------------------------
    /**
     * ログイン状態をチェックしてログイン済みなら属性を取得する
     *
     * @param number $attr
     * @return number ログイン中:属性の値,未ログイン:0
     */
    public function check_login_status($attr = 0) {
        // 属性の指定がない場合はリクエストされた画面属性を使用する
        if (empty($attr)) {
            $attr = $this->CI->attr;
        }

        // ログインユーザ情報取得
        $session_data = $this->CI->session->userdata(SESS_KEY__LOGIN__LOGIN);
        // セッションチェック
        if (empty($session_data)) {
            // セッション情報が存在しない場合は未ログイン
            return 0;
        }

        // セッションの属性と画面属性が異なる場合は強制ログアウトして未ログイン
        if ($session_data[SESS_KEY__LOGIN__USER_ATTR] != $attr) {
            $this->logout();
            return 0;
        }

        // セッションとDBでデータ検証
        $login_info = array();
        $session_info = $session_data[SESS_KEY__LOGIN__INFO];
        switch ($attr){
            case APPLICATION_VIEW_ATTRIBUTE__PORTAL:
                // モデルロード
                $this->CI->load->model('buyer_info_model');
                // ログイン情報を取得
                $login_info = $this->CI->buyer_info_model->get_login_id($session_info['customer_id']);
                break;
            case APPLICATION_VIEW_ATTRIBUTE__BUYER:
                // モデルロード
                $this->CI->load->model('buyer_info_model');
                // ログイン情報を取得
                $login_info = $this->CI->buyer_info_model->get_login_id($session_info['customer_id']);
                break;
            case APPLICATION_VIEW_ATTRIBUTE__AFI:
                // モデルロード
                $this->CI->load->model('afi_info_model');
                // ログイン情報を取得
                $login_info = $this->CI->afi_info_model->get_login_id($session_info['customer_id']);
                break;
            case APPLICATION_VIEW_ATTRIBUTE__SELLER:
                // モデルロード
                $this->CI->load->model('seller_info_model');
                // ログイン情報を取得
                $login_info = $this->CI->seller_info_model->get_login_id($session_info['customer_id']);
                break;
            default:
                $this->logout();
                return 0;
                break;
        }

        // セッションとDBが不整合の場合は未ログイン
        if ($session_info['login_id'] != $login_info['login_id']) {
            $this->logout();
            return 0;
        }

        // ログイン中の場合はログインカスタマーIDを設定
        $this->CI->login_customer_id = $login_info['customer_id'];
        //セッション情報をCIオブジェクトへセット
        $this->CI->login_session_data = $session_data;

        // ログイン中の場合は属性を返す
        return $attr;
    }

    // --------------------------------------------------------------------
    /**
     * ログアウト
     */
    public function logout() {
        // セッションからログイン情報を削除する
        $this->CI->session->unset_userdata(SESS_KEY__LOGIN__LOGIN);
    }

// --------------------------------------------------------------------
    /**
     * セッションのログイン情報を取得する
     * ※指定された属性と異なる場合は空配列を返す
     * ※ログインチェックはしない
     *
     */
    public function get_login_info($attr = 0) {
        // 属性の指定がない場合はリクエストされた画面属性を使用する
        if (empty($attr)) {
            $attr = $this->CI->attr;
        }

        // ログインユーザ情報取得
        $session_data = $this->CI->session->userdata(SESS_KEY__LOGIN__LOGIN);
        // セッション情報が存在しない場合
        if (empty($session_data)) {
            return array();
        }

        // セッションの属性と画面属性が異なる場合
        if ($session_data[SESS_KEY__LOGIN__USER_ATTR] != $attr) {
            return array();
        }

        // ログイン情報を返す
        return $session_data;
    }

    /**
     * 重複ログインチェック
     * ※Aユーザログイン中にBユーザでログインした場合は一旦ログアウト
     *
     * @param unknown $id
     * @return boolean true:重複ログイン、false:単独ログイン
     */
    private function is_duplicate_login($id){
        // セッション取得
        $session = $this->CI->session->userdata(SESS_KEY__LOGIN__LOGIN);
        // セッションチェック
        if (!empty($session)) {
            // 画面属性とログイン情報の属性が一致
            if ($this->CI->attr == $session[SESS_KEY__LOGIN__USER_ATTR]){
                // 指定されたログインIDとログイン中のIDが不一致の場合
                if ($id != $session[SESS_KEY__LOGIN__INFO]['customer_id']){
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 代理ログイン
     * @param unknown $proxy_login_key
     * @return string
     */
    private function proxy_login($proxy_login_key){

        // キーチェック
        if($proxy_login_key != PROXY_LOGIN__KEY){
            return ERROR__LOGIN__PROXY_KEY_NG;
        }

        // IPアドレスチェック
        // アクセス元：取得
        $http_referer = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : NULL;
        $accessed = parse_url($http_referer);

        // アクセス元：管理サイト確認
        if(isset($accessed['host'])) {
            $domains = config_item('proxy_authorized_domains');
            for($i = 0; $i < count($domains); $i++) {
                if($accessed['host'] == $domains[$i]) {
                    break;
                }
                if($i == count($domains) - 1) {
                    return ERROR__LOGIN__PROXY_DOMEIN_NG;
                }
            }
        }else{
            return ERROR__LOGIN__PROXY_DOMEIN_NG;
        }

        return ERROR__RESPONSE_STATUS__SUCCESS;;
    }
}
