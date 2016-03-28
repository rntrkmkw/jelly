<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * フレンドロジック
 *
 * @author kamikawa
 */
class Api_friend_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 200
     * フレンド情報更新ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_friend_data_update_200($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // 取得したFacebookIDからユーザIDを取得
        $this->CI->load->model('T_user_model');
        $friend_ids = array();
        foreach($params['facebook_ids'] as $fb_id) {
            $friend_data = $this->CI->T_user_model->get_data_by_fbid($fb_id);
            if(! empty($friend_data)) {
                array_push($friend_ids, $friend_data['user_id']);
            }
        }
        $friend_ids_json = json_encode($friend_ids);

        // フレンド情報を更新
        $this->CI->load->model('T_friend_model');
        $status = $this->CI->T_friend_model->update($params['user_id'], $friend_ids_json);
        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        $result['friend_num'] = count($friend_ids);

        return $result;
    }

}
