<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 課金レシート(Android)情報モデル
 *
 * @author kamikawa
 *
 */
class T_receipt_android_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * 課金レシート(Android)情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * 課金レシート(Android)情報を取得
     * @param String $receipt
     * @return Array
     */
    function get_data($receipt) {
        $this->db->select('id AS receipt_id');
        $this->db->select('device_id');
        $this->db->select('user_id');
        $this->db->select('product_id');
        $this->db->select('receipt');

        $this->db->from('t_receipt_android');

        $this->db->where('receipt', $receipt);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * 課金レシート(Android)情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     *  課金レシート(Android)情報を登録
     * @param Integer $device_id
     * @param Integer $user_id
     * @param Integer $product_id
     * @param String $receipt
     * @param Array $result
     * @return Boolean
     */
    function insert($device_id, $user_id, $product_id, $receipt, $result) {

        // TODO : 登録データをセット
        $data = array(
            'device_id'      => $device_id,
            'user_id'        => $user_id,
            'product_id'     => $product_id,
            'receipt'        => $receipt,
            'signature'      => $result['signature'],
            'purchase_token' => $result['purchase_token'],
            'order_id'       => $result['order_id']
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_receipt_android', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
