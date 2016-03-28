<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * イベントステージマスタモデル
 *
 * @author kamikawa
 *
 */
class M_event_stage_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * イベントステージ一覧を取得
     * @param Integer $group_id
     * @return Array
     */
    function get_list($group_id) {
        $this->db->select('t1.id AS event_stage_id');
        $this->db->select('t1.m_event_group_id');
        $this->db->select('t1.m_stage_id');
        $this->db->select('t1.stage_order');
        $this->db->select('t1.last_stage_flg');
        $this->db->select('t2.name');
        $this->db->select('t2.level');
        $this->db->select('t2.comp_type');
        $this->db->select('t2.comp_condition');

        $this->db->from('m_event_stage t1');
        $this->db->join('m_stage t2', 't2.id=t1.m_stage_id');

        $this->db->where('t1.m_event_group_id', $group_id);
        $this->db->where('t1.del_flg', COMMON__FLAG__OFF);
        $this->db->where('t2.del_flg', COMMON__FLAG__OFF);

        $this->db->order_by('t1.stage_order');

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * イベントステージ情報を取得
     * @param Integer $id
     * @return Array
     */
    function get_data($id) {
        $this->db->select('id AS event_stage_id');
        $this->db->select('m_event_group_id AS event_group_id');
        $this->db->select('m_stage_id');
        $this->db->select('stage_order');
        $this->db->select('last_stage_flg');

        $this->db->from('m_event_stage');

        $this->db->where('id', $id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * イベントステージ情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * イベントステージ情報を登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
