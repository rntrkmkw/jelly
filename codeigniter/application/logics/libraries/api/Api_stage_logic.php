<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * ユーザステージロジック
 *
 * @author kamikawa
 */
class Api_stage_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 300
     * ユーザステージ情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_stage_data_get_300($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザステージ情報を取得
        $this->CI->load->model('T_stage_model');
        $result['stage'] = $this->CI->T_stage_model->get_data($params['user_id'], $params['stage_id']);

        return $result;
    }

    /**
     * ApiID 301
     * ユーザステージ更新登録ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_stage_score_update_301($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザステージ情報を取得
        $this->CI->load->model('T_stage_model');
        $stage_data = $this->CI->T_stage_model->get_data($params['user_id'], $params['stage_id']);

        // レコードが存在すれば更新、なければ登録する
        if(! empty($stage_data)) {
            // ユーザステージを更新
            $status = $this->CI->T_stage_model->update($params['user_id'], $params['stage_id'], max($params['status'], $stage_data['status']), max($params['score'], $stage_data['score']), max($params['rank'], $stage_data['rank']));
        } else {
            // ユーザステージを登録
            $status = $this->CI->T_stage_model->insert($params['user_id'], $params['stage_id'], $params['status'], $params['score'], $params['rank']);
        }

        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        // 成功したら最新のユーザステージ情報を取得
        $result['stage'] = $this->CI->T_stage_model->get_data($params['user_id'], $params['stage_id']);

        return $result;
    }

    /**
     * ApiID 302
     * ユーザステージリスト取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_stage_list_get_302($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ステージリストを取得
        $this->CI->load->model('M_stage_model');
        $stage_list = $this->CI->M_stage_model->get_list($params['map_id']);

        // ステージリストのID群
        $stage_ids = array();
        foreach($stage_list as &$stage) {
            array_push($stage_ids, $stage['stage_id']);
        }

        // ユーザステージリストを取得
        $this->CI->load->model('T_stage_model');
        $result['stage'] = $this->CI->T_stage_model->get_list($params['user_id'], $stage_ids);

        return $result;
    }

}
