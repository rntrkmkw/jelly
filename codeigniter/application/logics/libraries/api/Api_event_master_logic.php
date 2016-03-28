<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * イベントマスタロジック
 *
 * @author kamikawa
 */
class Api_event_master_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 5000
     * イベント情報一覧取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_event_list_get_5000($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // イベント情報を取得
        $this->CI->load->model('M_event_member_model');
        $result['event'] = $this->CI->M_event_member_model->get_data($params['user_id']);

        // 自分以外のグループメンバーを取得
        $result['member'] = $this->CI->M_event_member_model->get_list($params['user_id'], $result['event']['group_id']);

        // イベント用ステージ一覧を取得
        $this->CI->load->model('M_event_stage_model');
        $result['stage'] = $this->CI->M_event_stage_model->get_list($result['event']['group_id']);

        // イベント報酬情報を取得
        $this->CI->load->model('M_event_reward_model');
        $result['reward'] = $this->CI->M_event_reward_model->get_list($result['event']['event_id']);

        return $result;
    }
}
