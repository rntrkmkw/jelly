<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ユーザイベントステージ情報モデル
 *
 * @author kamikawa
 *
 */
class T_event_stage_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ユーザイベントステージ情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * ユーザイベントステージ情報を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_data($user_id) {
        $this->db->select('m_event_stage_id');
        $this->db->select('user_id');
        $this->db->select('m_stage_id');
        $this->db->select('status');

        $this->db->from('t_event_stage');

        $this->db->where('user_id', $user_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        // 最新のみ取得
        $this->db->order_by('id', 'desc');

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ユーザイベントステージ情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * ユーザイベントステージ情報を登録
     * @param Integer $user_id
     * @param Integer $event_stage_id
     * @param Integer $m_stage_id
     * @param Integer $status
     * @return Boolean
     */
    function insert($user_id, $event_stage_id, $m_stage_id, $status) {

        // 登録データをセット
        $data = array(
            'm_event_stage_id' => $event_stage_id,
            'user_id'          => $user_id,
            'm_stage_id'       => $m_stage_id,
            'status'           => $status
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_event_stage', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
