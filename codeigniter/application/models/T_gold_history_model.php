<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 有償ゴールド購入履歴情報モデル
 *
 * @author kamikawa
 *
 */
class T_gold_history_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * 有償ゴールド購入履歴情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * 有償ゴールド購入履歴情報データを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * 有償ゴールド購入履歴情報データを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * 有償ゴールド購入履歴情報データを登録
     * @param Integer $device_id
     * @param Integer $user_id
     * @param Integer $os_type
     * @param Integer $m_gold_id
     * @return Boolean
     */
    function insert($device_id, $user_id, $os_type, $m_gold_id) {

        // 登録データをセット
        $data = array(
            'device_id' => $device_id,
            'user_id'   => $user_id,
            'os_type'   => $os_type,
            'm_gold_id' => $m_gold_id
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_gold_history', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
