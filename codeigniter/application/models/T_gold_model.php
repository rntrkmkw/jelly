<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ゴールド情報モデル
 *
 * @author kamikawa
 *
 */
class T_gold_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ゴールド情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * ゴールド情報を取得
     * @param $user_id
     * @return Array
     */
    function get_data($user_id) {
        $this->db->select('user_id');
        $this->db->select('sum_gold');
        $this->db->select('charge_gold');
        $this->db->select('free_gold');

        $this->db->from('t_gold');

        $this->db->where('user_id', $user_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ゴールド情報を更新
     * @param Integer $user_id
     * @param Integer $sum_gold
     * @param Integer $charge_gold
     * @param Integer $free_gold
     * @return Boolean
     */
    function update($user_id, $sum_gold, $charge_gold, $free_gold) {

        // 更新データをセット
        $data = array(
            'sum_gold'    => $sum_gold,
            'charge_gold' => $charge_gold,
            'free_gold'   => $free_gold
        );

        // 更新条件をセット
        $this->db->where('user_id', $user_id);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_gold', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     *  ゴールド情報を登録
     * @param Integer $user_id
     * @return Boolean
     */
    function insert($user_id) {

        // 登録データをセット
        $data = array(
            'user_id'     => $user_id,
            'sum_gold'    => 0,
            'charge_gold' => 0,
            'free_gold'   => 0
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_gold', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
