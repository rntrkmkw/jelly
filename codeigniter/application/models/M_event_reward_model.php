<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * イベント報酬マスタモデル
 *
 * @author kamikawa
 *
 */
class M_event_reward_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * イベント報酬情報一覧を取得
     * @param Integer $event_id
     * @return Array
     */
    function get_list($event_id) {
        $this->db->select('id AS event_reward_id');
        $this->db->select('m_event_id');
        $this->db->select('priority');
        $this->db->select('m_item_id');
        $this->db->select('cnt');

        $this->db->from('m_event_reward');

        $this->db->where('m_event_id', $event_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * イベント報酬情報を取得
     * @param Integer $event_id
     * @param Integer $priority
     * @return Array
     */
    function get_data($event_id, $priority) {
        $this->db->select('id AS event_reward_id');
        $this->db->select('m_event_id');
        $this->db->select('priority');
        $this->db->select('m_item_id');
        $this->db->select('cnt');

        $this->db->from('m_event_reward');

        $this->db->where('m_event_id', $event_id);
        $this->db->where('priority', $priority);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * イベント報酬情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * イベント報酬情報を登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
