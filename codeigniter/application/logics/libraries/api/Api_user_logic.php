<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * ユーザ基本情報ロジック
 *
 * @author kamikawa
 */
class Api_user_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 100
     * ユーザ情報登録ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_regist_100($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // デバイス情報を取得
        $this->CI->load->model('T_device_model');
        $device_data = $this->CI->T_device_model->get_data_by_uiid($params['uiid']);

        // レコードが存在したらそのデータを返却、なければ登録
        if(! empty($device_data)) {
            $result['device'] = $device_data;
        } else {
            
            // デバイス情報を登録
            $status = $this->CI->T_device_model->insert(
                $params['uiid'],
                $params['app_ver'],
                $params['os_type'],
                $params['os_ver'],
                $params['device_ver'],
                $params['device_token']
            );

            if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

            // デバイス情報を取得
            $result['device'] = $this->CI->T_device_model->get_data_by_uiid($params['uiid']);

        }

        return $result;
    }

    /**
     * ApiID 101
     * ユーザログインロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_login_101($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザ情報を取得
        $this->CI->load->model('T_user_model');
        $user_data = $this->CI->T_user_model->get_data_by_fbid($params['facebook_id']);

        // レコードが存在したらそのデータと関連データを返却、なければ登録
        if(! empty($user_data)) {

            $result = $this->get_data_about_user($user_data);

        } else {

            $result = $this->insert_data_about_user($params);
            if(! $result) { return ERROR__TRANSACTION_ROLLBACK; }

        }

        // ユーザ連携情報の更新or登録
        $status = $this->user_device_data_check($params['device_id'], $result['user']['user_id']);
        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        return $result;
    }

    /**
     * ApiID 102
     * ユーザログアウトロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_logout_102($params) {

        $result = array();

        // 必要であればここで固有パラメータチェック

        // ユーザ連携情報を取得
        $this->CI->load->model('T_user_device_model');
        $user_device_data = $this->CI->T_user_device_model->get_data($params['device_id']);

        // レコードが存在したら連携ユーザIDを更新
        if(! empty($user_device_data)) {

            $status = $this->CI->T_user_device_model->update($params['device_id'], null);
            if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        }

        // 空の返却データをセット
        $result = array(
            'user'  => array(),
            'gold'  => array(),
            'item'  => array(),
            'stage' => array()
        );

        return $result;
    }

    /**
     * ユーザ連携情報チェックロジック
     *
     * @param Integer $device_id
     * @param Integer $user_id
     * @author kamikawa
     */
    private function user_device_data_check($device_id, $user_id) {

        $status = false;

        // ユーザ連携情報取得
        $this->CI->load->model('T_user_device_model');
        $user_device_data = $this->CI->T_user_device_model->get_data($device_id);

        // レコードが存在したら更新、なければ登録
        if(! empty($user_device_data)) {

            $status = $this->CI->T_user_device_model->update(
                $device_id,
                $user_id
            );

        } else {

            $status = $this->CI->T_user_device_model->insert(
                $device_id,
                $user_id
            );

        }

        return $status;
    }

    /**
     * ユーザ関連情報取得ロジック
     *
     * @param Array $user_data
     * @author kamikawa
     */
    private function get_data_about_user($user_data) {

        $result = array();

        // ユーザ情報取得
        $result['user'] = $user_data;

        // ユーザゴールド情報取得
        $this->CI->load->model('T_gold_model');
        $result['gold'] = $this->CI->T_gold_model->get_data($user_data['user_id']);

        // ユーザアイテム情報取得
        $this->CI->load->model('T_item_model');
        $result['item'] = $this->CI->T_item_model->get_list($user_data['user_id']);

        // ユーザステージ情報取得
        $this->CI->load->model('T_stage_model');
        $result['stage'] = $this->CI->T_stage_model->get_all($user_data['user_id']);

        return $result;
    }

    /**
     * ユーザ関連情報登録ロジック
     *
     * @param Array $params
     * @author kamikawa
     */
    private function insert_data_about_user($params) {

        $result = array();
            
        // ユーザ情報登録
        $status = $this->CI->T_user_model->insert(
            $params['name'],
            $params['image_url'],
            $params['auth_token'],
            $params['secret_key'],
            $params['facebook_id']
        );
        if(! $status) { return false; }
        // ユーザ情報取得
        $result['user'] = $this->CI->T_user_model->get_data_by_fbid($params['facebook_id']);

        // ユーザゴールド情報登録
        $this->CI->load->model('T_gold_model');
        $status = $this->CI->T_gold_model->insert($result['user']['user_id']);
        if(! $status) { return false; }
        // ユーザゴールド情報取得
        $result['gold'] = $this->CI->T_gold_model->get_data($result['user']['user_id']);

        // フレンド情報登録※返却のための取得はしない
        $this->CI->load->model('T_friend_model');
        $status = $this->CI->T_friend_model->insert($result['user']['user_id']);
        if(! $status) { return false; }

        // ユーザアイテム情報
        $result['item'] = array();
        // ユーザステージ情報
        $result['stage'] = array();

        return $result;
    }

    /**
     * ApiID 103
     * ユーザプレイングステージ情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_playing_stage_get_103($params) {

        $result = array();

        // 必要であればここで固有パラメータチェック

        // ユーザがプレイ中のステージ情報を取得
        $this->CI->load->model('T_stage_model');
        $result['stage'] = $this->CI->T_stage_model->get_last_stage_data($params['user_id']);

        // レコードが無ければ初回ステージの情報を返却
        if(empty($result['stage'])) {
            $result['stage'] = array(
                'user_id'    => $params['user_id'],
                'm_stage_id' => T_STAGE__M_STAGE_ID__DEFAULT,
                'status'     => T_STAGE__STATUS__DEFAULT,
                'score'      => T_STAGE__SCORE__DEFAULT,
                'rank'       => T_STAGE__RANK__DEFAULT
            );
        }

        return $result;
    }

    /**
     * ApiID 104
     * ユーザメッセージ取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_message_list_get_104($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザメッセージ取得
        $this->CI->load->model('T_message_model');
        $result['message'] = $this->CI->T_message_model->get_list($params['user_id']);

        // 取得したメッセージの既読フラグをオンにする
        $message_ids = array();
        foreach($result['message'] as $message) {
            array_push($message_ids, $message['message_id']);
        }
        if(! empty($message_ids)) {
            $status = $this->CI->T_message_model->update($message_ids);
            if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }
        }

        return $result;
    }

    /**
     * ApiID 105
     * ユーザメッセージ登録ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_message_regist_105($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // フレンド情報を取得
        $this->CI->load->model('T_friend_model');
        $friend_data = $this->CI->T_friend_model->get_data($params['user_id']);
        $friend_id_list = json_decode($friend_data['friend_id_list'], true);

        // facebook_idからユーザIDを取得してフレンドにいるかチェック
        $friend_ids = array();
        if(! empty($friend_id_list)) {
            $this->CI->load->model('T_user_model');
            foreach($params['facebook_ids'] as $fb_id) {
                $fb_user = $this->CI->T_user_model->get_data_by_fbid($fb_id); 
                if(($key = array_search($fb_user['user_id'], $friend_id_list)) !== false) {
                    array_push($friend_ids, $fb_user['user_id']);
                    unset($friend_id_list[$key]);
                }
            }
        }

        // ユーザメッセージ一括登録
        $this->CI->load->model('T_message_model');
        $status = $this->CI->T_message_model->insert($params['user_id'], $friend_ids);
        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        $result['friend_num'] = $status;

        return $result;
    }

    /**
     * ApiID 106
     * ユーザお知らせ取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_user_notice_list_get_106($params) {

        $result = array();

        // 必要であればここでパラメータチェック

        // ユーザお知らせ取得
        $this->CI->load->model('T_notice_model');
        $result['notice'] = $this->CI->T_notice_model->get_list($params['device_id']);

        // 取得したお知らせの既読フラグをオンにする
        $notice_ids = array();
        foreach($result['notice'] as $notice) {
            if($notice['read_flg'] == COMMON__FLAG__OFF) {
                array_push($notice_ids, $message['notice_id']);
            }
        }
        if(! empty($notice_ids)) {
            $status = $this->CI->T_notice_model->update($notice_ids);
            if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }
        }

        return $result;
    }
}
