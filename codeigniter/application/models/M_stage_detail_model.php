<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ステージ詳細マスタモデル
 *
 * @author kamikawa
 *
 */
class M_stage_detail_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ステージ詳細一覧を取得
     * @param Integer $stage_id
     * @return Array
     */
    function get_list($stage_id) {
        $this->db->select('t1.id AS stage_detail_id');
        $this->db->select('t1.m_stage_id AS stage_id');
        $this->db->select('t1.name AS stage_detail_name');
        $this->db->select('t1.length_x');
        $this->db->select('t1.length_y');
        $this->db->select('t1.obstacle AS obstacle_cnt');
        $this->db->select('t1.goal AS goal_cnt');
        $this->db->select('t2.comp_type');
        $this->db->select('t2.comp_condition');

        $this->db->from('m_stage_detail t1');
        $this->db->join('m_stage t2', 't2.id=t1.m_stage_id');

        $this->db->where('t1.m_stage_id', $stage_id);
        $this->db->where('t1.del_flg', COMMON__FLAG__OFF);
        $this->db->where('t2.del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ステージ詳細データを取得
     * @param Integer $stage_detail_id
     * @return Array
     */
    function get_data($stage_detail_id) {
    }

    /**
     * ステージ詳細データを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * ステージ詳細データを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
