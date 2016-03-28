<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * イベントキング情報モデル
 *
 * @author kamikawa
 *
 */
class T_event_king_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * イベントキング情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * イベントキング情報を取得
     * @param Integer $event_member_id
     * @return Array
     */
    function get_data($event_member_id) {
        $this->db->select('id AS event_king_id');
        $this->db->select('m_event_member_id');
        $this->db->select('user_id');
        $this->db->select('success_date');
        $this->db->select('success_count');
        $this->db->select('m_event_reward_id');
        $this->db->select('dist_flg');

        $this->db->from('t_event_king');

        $this->db->where('m_event_member_id', $event_member_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        // 最新のみ取得
        $this->db->order_by('id', 'desc');

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ユーザのイベントキング情報を取得
     * @param Integer $user_id
     * @param Integer $event_member_id
     * @return Array
     */
    function get_user_king_data($user_id, $event_member_id) {
        $this->db->select('id AS event_king_id');
        $this->db->select('m_event_member_id');
        $this->db->select('user_id');
        $this->db->select('success_date');
        $this->db->select('success_count');
        $this->db->select('m_event_reward_id');
        $this->db->select('dist_flg');

        $this->db->from('t_event_king');

        $this->db->where('m_event_member_id', $event_member_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        // 最新のみ取得
        $this->db->order_by('id', 'desc');

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * イベントキング情報を更新
     * @param Integer $event_king_id
     * @param Integer $event_reward_id
     * @return Boolean
     */
    function update($event_king_id, $event_reward_id) {

        // 更新データをセット
        $data = array(
            'm_event_reward_id' => $event_reward_id,
            'dist_flg'          => COMMON__FLAG__ON
        );

        // 更新条件をセット
        $this->db->where('id', $event_king_id);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_event_king', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     * イベントキング情報を登録
     * @param Integer $user_id
     * @param Integer $event_member_id
     * @param Integer $success_count
     * @return Boolean
     */
    function insert($user_id, $event_member_id, $success_count) {

        // 登録データをセット
        $data = array(
            'm_event_member_id' => $event_member_id,
            'user_id'           => $user_id,
            'success_date'      => $this->CI->current_date,
            'success_count'     => $success_count,
            'dist_flg'          => COMMON__FLAG__OFF
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_event_king', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
