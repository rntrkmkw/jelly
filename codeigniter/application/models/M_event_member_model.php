<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * イベントメンバマスタモデル
 *
 * @author kamikawa
 *
 */
class M_event_member_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * 自分以外のイベントメンバ一覧を取得
     * @param Integer $user_id
     * @param Integer $group_id
     * @return Array
     */
    function get_list($user_id, $group_id) {
        $this->db->select('user_id');

        $this->db->from('m_event_member');

        $this->db->where('m_event_group_id', $group_id);
        $this->db->where('user_id !=', $user_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * イベント情報を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_data($user_id) {
        $this->db->select('t1.id AS event_member_id');
        $this->db->select('t1.user_id');
        $this->db->select('t2.id AS group_id');
        $this->db->select('t2.start_at AS group_start_at');
        $this->db->select('t2.end_at AS group_end_at');
        $this->db->select('t3.id AS event_id');
        $this->db->select('t3.name');
        $this->db->select('t3.start_at AS event_start_at');
        $this->db->select('t3.end_at AS event_end_at');

        $this->db->from('m_event_member t1');
        $this->db->join('m_event_group t2', 't2.id=t1.m_event_group_id');
        $this->db->join('m_event t3', 't3.id=t2.m_event_id');

        $this->db->where('t1.user_id', $user_id);
        $this->db->where('t2.start_at <=', $this->CI->current_date);
        $this->db->where('t2.end_at >=', $this->CI->current_date);
        $this->db->where('t1.del_flg', COMMON__FLAG__OFF);
        $this->db->where('t2.del_flg', COMMON__FLAG__OFF);
        $this->db->where('t3.del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * イベントメンバを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * イベントメンバを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
