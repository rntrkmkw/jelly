<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 課金レシート(iOS)情報モデル
 *
 * @author kamikawa
 *
 */
class T_receipt_ios_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * 課金レシート(iOS)情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * 課金レシート(iOS)情報を取得
     * @param String $receipt
     * @return Array
     */
    function get_data($receipt) {
        $this->db->select('id AS receipt_id');
        $this->db->select('device_id');
        $this->db->select('user_id');
        $this->db->select('product_id');
        $this->db->select('receipt');

        $this->db->from('t_receipt_ios');

        $this->db->where('receipt', $receipt);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * 課金レシート(iOS)情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     *  課金レシート(iOS)情報を登録
     * @param Integer $device_id
     * @param Integer $user_id
     * @param Integer $product_id
     * @param String $receipt
     * @param Integer $sandbox_flg
     * @param Array $result
     * @return Boolean
     */
    function insert($device_id, $user_id, $product_id, $receipt, $sandbox_flg, $result) {

        // ToDO : 登録データをセット
        $data = array(
            'device_id'                         => $device_id,
            'user_id'                           => $user_id,
            'product_id'                        => $product_id,
            'receipt'                           => $receipt,
            'sandbox_flg'                       => $sandbox_flg,
            'apple_original_purchase_date_pst'  => $result['receipt']['original_purchase_date_pst'],
            'apple_purchase_date_ms'            => $result['receipt']['purchase_date_ms'],
            'apple_unique_identifier'           => $result['receipt']['unique_identifier'],
            'apple_original_transaction_id'     => $result['receipt']['original_transaction_id'],
            'apple_bvrs'                        => $result['receipt']['bvrs'],
            'apple_transaction_id'              => $result['receipt']['transaction_id'],
            'apple_quantity'                    => $result['receipt']['quantity'],
            'apple_unique_vendor_identifier'    => $result['receipt']['unique_vendor_identifier'],
            'apple_item_id'                     => $result['receipt']['item_id'],
            'apple_product_id'                  => $result['receipt']['product_id'],
            'apple_purchase_date'               => $result['receipt']['purchase_date'],
            'apple_original_purchase_date'      => $result['receipt']['original_purchase_date'],
            'apple_purchase_date_pst'           => $result['receipt']['purchase_date_pst'],
            'apple_bid'                         => $result['receipt']['bid'],
            'apple_original_purchase_date_ms'   => $result['receipt']['original_purchase_date_ms'],
            'apple_status'                      => $result['status']
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_receipt_ios', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
