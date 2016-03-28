<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * ユーザアイテムロジック
 *
 * @author kamikawa
 */
class Api_item_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 500
     * ユーザアイテム情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_item_list_get_500($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザアイテム情報を取得
        $this->CI->load->model('T_item_model');
        $result['item'] = $this->CI->T_item_model->get_list($params['user_id']);

        return $result;
    }

    /**
     * ApiID 501
     * ユーザアイテム獲得更新登録ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_item_add_update_501($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザアイテム情報を取得
        $this->CI->load->model('T_item_model');
        $item_data = $this->CI->T_item_model->get_data($params['user_id'], $params['item_id']);

        // レコードが存在すれば更新、なければ登録する
        if(! empty($item_data)) {
            // ユーザアイテムを更新
            $status = $this->CI->T_item_model->update($params['user_id'], $params['item_id'], $item_data['cnt']+1);
        } else {
            // ユーザアイテムを登録
            $item_cnt_default = 1;  // 獲得したアイテム個数
            $status = $this->CI->T_item_model->insert($params['user_id'], $params['item_id'], $item_cnt_default);
        }

        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        // 成功したら最新のユーザアイテム情報を取得
        $result['item'] = $this->CI->T_item_model->get_data($params['user_id'], $params['item_id']);


        return $result;
    }

    /**
     * ApiID 502
     * ユーザアイテム消費更新ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_item_consume_update_502($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザアイテム情報を取得
        $this->CI->load->model('T_item_model');
        $item_data = $this->CI->T_item_model->get_data($params['user_id'], $params['item_id']);

        // レコードが存在し当該アイテムを所持していた場合は更新する
        if(! empty($item_data) && $item_data['cnt'] > 0) {
            // ユーザアイテムを更新
            $status = $this->CI->T_item_model->update($params['user_id'], $params['item_id'], $item_data['cnt']-1);
        } else {
            return ERROR__REQUEST_DATA_INVALID;
        }

        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        // 成功したら最新のユーザアイテム情報を取得
        $result['item'] = $this->CI->T_item_model->get_data($params['user_id'], $params['item_id']);


        return $result;
    }

    /**
     * ApiID 503
     * ユーザアイテム購入更新登録ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_item_purchase_update_503($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // アイテム価格情報を取得
        $this->CI->load->model('M_item_price_model');
        $item_price_data = $this->CI->M_item_price_model->get_data($params['item_price_id']);

        // ユーザゴールド情報を取得
        $this->CI->load->model('T_gold_model');
        $gold_data = $this->CI->T_gold_model->get_data($params['user_id']);

        // '所持ゴールド < 価格'の場合はNG
        $diff_sum = $gold_data['sum_gold'] - $item_price_data['price'];
        if($diff_sum < 0) {
            return ERROR__REQUEST_DATA_INVALID;
        } else {
            // ゴールド所持数をそれぞれ計算してユーザゴールド情報を更新
            $result_calc = $this->item_purchase_calc($item_price_data['price'], $diff_sum, $gold_data['charge_gold'], $gold_data['free_gold']);
            
            $status = $this->CI->T_gold_model->update($params['user_id'], $result_calc['sum_gold'], $result_calc['charge_gold'], $result_calc['free_gold']);

            if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

            // ユーザアイテム情報があれば所持数を計算して更新、なければ登録
            $this->CI->load->model('T_item_model');
            $item_data = $this->CI->T_item_model->get_data($params['user_id'], $item_price_data['item_id']);

            if(! empty($item_data)) {
                $item_cnt = $item_data['cnt'] + $item_price_data['cnt'];
                $status = $this->CI->T_item_model->update($params['user_id'], $item_price_data['item_id'], $item_cnt);

                if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

            } else {
                $status = $this->CI->T_item_model->insert($params['user_id'], $item_price_data['item_id'], $item_price_data['cnt']);

                if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }
            }

            // ユーザアイテム購入履歴を登録
            $this->CI->load->model('T_item_history_model');
            $status = $this->CI->T_item_history_model->insert($params['device_id'], $params['user_id'], $params['item_price_id']);

            if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }
        }

        // 成功したら最新のユーザアイテム情報とユーザゴールド情報を取得
        $result['item'] = $this->CI->T_item_model->get_data($params['user_id'], $item_price_data['item_id']);
        $result['gold'] = $this->CI->T_gold_model->get_data($params['user_id']);

        return $result;
    }

    /**
     * ゴールド所持数計算ロジック
     *
     * @param Integer $price
     * @param Integer $diff_sum 
     * @param Integer $charge_gold 
     * @param Integer $free_gold 
     * @author kamikawa
     */
    private function item_purchase_calc($price, $diff_sum, $charge_gold, $free_gold) {

        $result = array();

        // 合計ゴールド数 = 価格との差額
        $result['sum_gold'] = $diff_sum;

        // 価格と無償ゴールドの差額を算出して有償無償それぞれの所持数を計算
        $diff_free = $free_gold - $price;

        if($diff_free < 0) {
            $result['charge_gold'] = $charge_gold + $diff_free;
            $result['free_gold']   = 0;
        } else {
            $result['charge_gold'] = $charge_gold;
            $result['free_gold']   = $diff_free;
        }

        return $result;
    }
}
