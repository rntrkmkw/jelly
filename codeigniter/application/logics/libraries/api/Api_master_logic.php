<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * Apiマスタロジック
 *
 * @author kamikawa
 */
class Api_master_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 1000
     * ゴールド購入一覧取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_gold_list_get_1000($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        switch($params['os_type']) {
            case T_USER__OS_TYPE__IOS:
                // ゴールド一覧(iOS)を取得
                $this->CI->load->model('M_gold_ios_model');
                $result['gold'] = $this->CI->M_gold_ios_model->get_list($params['language']);
                break;
            case T_USER__OS_TYPE__ANDROID:
                // ゴールド一覧(iOS)を取得
                $this->CI->load->model('M_gold_android_model');
                $result['gold'] = $this->CI->M_gold_android_model->get_list($params['language']);
                break;
            default:
                $result['gold'] = array();
                break;
        }

        return $result;
    }

    /**
     * ApiID 1001
     * アイテム購入リスト取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_item_list_get_1001($params) {

        $result = array();

        // 必要であればここで固有パラメータチェック

        // アイテムリスト一覧を取得
        $this->CI->load->model('M_item_model');
        $result['item'] = $this->CI->M_item_model->get_list();

        // アイテムリスト一覧のID群
        $item_ids = array();
        foreach($result['item'] as &$item){
            array_push($item_ids, $item['item_id']);
        }

        // アイテム価格データを取得
        $this->CI->load->model('M_item_price_model');
        $result['item_price'] = $this->CI->M_item_price_model->get_list($item_ids);

        return $result;
    }

    /**
     * ApiID 1002
     * お知らせ一覧取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_notice_list_get_1002($params) {

        $result = array();

        // 必要であればここで固有パラメータチェック

        // お知らせ一覧を取得
        $this->CI->load->model('M_notice_model');
        $result['notice'] = $this->CI->M_notice_model->get_list();

        return $result;
    }

    /**
     * ApiID 1003
     * 全マップ情報一覧取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_map_list_get_1003($params) {

        $result = array();

        // 必要であればここで固有パラメータチェック

        // マップリスト一覧を取得
        $this->CI->load->model('M_map_model');
        $result['map'] = $this->CI->M_map_model->get_list();

        return $result;
    }

    /**
     * ApiID 1004
     * 特定ステージの親マップ情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_stage_map_get_1004($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ステージデータを取得
        $this->CI->load->model('M_stage_model');
        $stage_data = $this->CI->M_stage_model->get_data($params['stage_id']);

        // 親マップデータを取得
        $this->CI->load->model('M_map_model');
        $result['map'] = $this->CI->M_map_model->get_data($stage_data['map_id']);

        return $result;
    }

    /**
     * ApiID 1005
     * 特定ステージと同一マップ内の全ステージ情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_stage_list_same_map_get_1005($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ステージデータを取得
        $this->CI->load->model('M_stage_model');
        $stage_data = $this->CI->M_stage_model->get_data($params['stage_id']);

        // 同一マップ内ステージ一覧を取得
        $result['stage'] = $this->CI->M_stage_model->get_list($stage_data['map_id']);

        return $result;
    }

    /**
     * ApiID 1006
     * 特定マップ内の全ステージ情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_stage_list_get_1006($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ステージ一覧を取得
        $this->CI->load->model('M_stage_model');
        $result['stage'] = $this->CI->M_stage_model->get_list($params['map_id']);

        return $result;
    }

    /**
     * ApiID 1007
     * 特定ステージの情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_stage_detail_get_1007($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ステージ情報を取得
        $this->CI->load->model('M_stage_model');
        $result['stage'] = $this->CI->M_stage_model->get_data($params['stage_id']);

        // ステージ詳細データを取得
        $this->CI->load->model('M_stage_detail_model');
        $result['detail'] = $this->CI->M_stage_detail_model->get_list($params['stage_id']);

        return $result;
    }

    /**
     * ApiID 1008
     * 特定ステージのインゲーム情報(マス目の数・障害物の数・キューブの数etc)取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_stage_game_get_1008($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ステージ詳細データを取得
        $this->CI->load->model('M_stage_detail_model');
        $result['detail'] = $this->CI->M_stage_detail_model->get_list($params['stage_id']);

        $stage_detail_ids = array();
        foreach($result['detail'] as &$detail){
            array_push($stage_detail_ids, $detail['stage_detail_id']);
            // 【クライアント向け追加】floor_position_x => 0, floor_position_y => 0
            $detail = array_merge($detail, array('floor_position_x' => 0, 'floor_position_y' => 0));
        }

        // ステージフェンスデータを取得
        $this->CI->load->model('M_stage_fence_model');
        $result['fence'] = $this->CI->M_stage_fence_model->get_list($stage_detail_ids);

        // ステージゼリーデータを取得
        $this->CI->load->model('M_stage_jelly_model');
        $jelly_list = $this->CI->M_stage_jelly_model->get_list($stage_detail_ids);

        // 【クライアント向けコンバート】ゼリーとゴールにリストを分割
        $result['jelly'] = array();
        $result['goal']  = array();
        foreach($jelly_list as $jelly) {
            switch($jelly['type']) {
                case M_STAGE_JELLY__TYPE__GOAL_FOR_DEAD:
                case M_STAGE_JELLY__TYPE__GOAL_FOR_LINKED:
                    array_push($result['goal'], $jelly);
                    break;
                default:
                    array_push($result['jelly'], $jelly);
                    break;
            }
        }

        return $result;
    }

    /**
     * ApiID 1009
     * アプリバージョン情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function m_version_list_get_1009($params) {

        $result = array();

        // 必要であればここで固有パラメータチェック

        // アプリバージョン情報を取得
        $this->CI->load->model('M_version_model');
        $result['version'] = $this->CI->M_version_model->get_list();

        return $result;
    }

}
