<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * マップマスタモデル
 *
 * @author kamikawa
 *
 */
class M_map_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * マップ一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
        $this->db->select('id');
        $this->db->select('name');

        $this->db->from('m_map');

        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * マップデータを取得
     * @param Integer $map_id
     * @return Array
     */
    function get_data($map_id) {
        $this->db->select('id AS map_id');
        $this->db->select('name');

        $this->db->from('m_map');

        $this->db->where('id', $map_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * マップデータを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * マップデータを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
