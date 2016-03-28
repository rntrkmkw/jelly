<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ステージゼリーマスタモデル
 *
 * @author kamikawa
 *
 */
class M_stage_jelly_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ステージゼリー一覧を取得
     * @param Array stage_detail_ids
     * @return Array
     */
    function get_list($stage_detail_ids) {
        $this->db->select('m_stage_detail_id AS stage_detail_id');
        $this->db->select('position_x');
        $this->db->select('position_y');
        $this->db->select('position_range_x');
        $this->db->select('position_range_y');
        $this->db->select('type');

        $this->db->from('m_stage_jelly');

        $this->db->where_in('m_stage_detail_id', $stage_detail_ids);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ステージゼリー情報を取得
     * @param Integer $stage_jelly_id
     * @return Array
     */
    function get_data($stage_jelly_id) {
    }

    /**
     * ステージゼリー情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * ステージゼリー情報を登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
