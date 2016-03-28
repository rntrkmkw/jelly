<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ステージマスタモデル
 *
 * @author kamikawa
 *
 */
class M_stage_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ステージ一覧を取得
     * @param Integer $map_id
     * @return Array
     */
    function get_list($map_id) {
        $this->db->select('id AS stage_id');
        $this->db->select('name AS stage_name');
        $this->db->select('m_map_id AS map_id');
        $this->db->select('m_reward_id');
        $this->db->select('level');
        $this->db->select('comp_type');
        $this->db->select('comp_condition');

        $this->db->from('m_stage');

        $this->db->where('m_map_id', $map_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ステージデータを取得
     * @param Integer $stage_id
     * @return Array
     */
    function get_data($stage_id) {
        $this->db->select('id AS stage_id');
        $this->db->select('name AS stage_name');
        $this->db->select('m_map_id AS map_id');
        $this->db->select('m_reward_id');
        $this->db->select('level');
        $this->db->select('comp_type');
        $this->db->select('comp_condition');

        $this->db->from('m_stage');

        $this->db->where('id', $stage_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ステージデータを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * ステージデータを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
