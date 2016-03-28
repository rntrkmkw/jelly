<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * ユーザゴールドロジック
 *
 * @author kamikawa
 */
class Api_gold_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 400
     * ユーザゴールド情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_gold_data_get_400($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザゴールド情報を取得
        $this->CI->load->model('T_gold_model');
        $result['gold'] = $this->CI->T_gold_model->get_data($params['user_id']);

        return $result;
    }

    /**
     * ApiID 401
     * ユーザゴールド購入更新登録ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_gold_purchase_update_401($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ゲストユーザの時はuser_idをnullにして保持
        if(empty($params['user_id'])) {
            $params['user_id'] = null;
        }

        // ライブラリロード
        switch($params['os_type']) {
            case T_USER__OS_TYPE__IOS:
                $this->CI->load->library('Purchase_ios', null, 'Purchase_logic');
                break;
            case T_USER__OS_TYPE__ANDROID:
                $this->CI->load->library('Purchase_android', null, 'Purchase_logic');
                break;
            default:
                return false;
                break;
        }

        // トランザクション開始
        $this->CI->transaction_begin();
        
        // レシート検証
        $status = $this->CI->Purchase_logic->verify($params);

        if(! $status) {
            // トランザクションロールバック
            $this->CI->transaction_rollback();

            return ERROR__TRANSACTION_ROLLBACK;
        }

        // トランザクションコミット
        $this->CI->transaction_commit();


        // ToDo : 要検討　ユーザゴールド情報を取得
        $this->CI->load->model('T_gold_model');
        $result['gold'] = $this->CI->T_gold_model->get_data($params['user_id']);

        return $result;
    }

}
