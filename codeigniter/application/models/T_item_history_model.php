<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * アイテム購入履歴情報モデル
 *
 * @author kamikawa
 *
 */
class T_item_history_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * アイテム購入履歴情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * アイテム購入履歴情報を取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * アイテム購入履歴情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     *  アイテム購入履歴情報を登録
     * @param Integer $device_id
     * @param Integer $user_id
     * @param Integer $item_price_id
     * @return Boolean
     */
    function insert($device_id, $user_id, $item_price_id) {

        // 登録データをセット
        $data = array(
            'device_id'       => $device_id,
            'user_id'         => $user_id,
            'm_item_price_id' => $item_price_id
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_item_history', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
