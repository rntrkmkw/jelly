<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ステージフェンスマスタモデル
 *
 * @author kamikawa
 *
 */
class M_stage_fence_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ステージフェンス一覧を取得
     * @param Array stage_detail_ids
     * @return Array
     */
    function get_list($stage_detail_ids) {
        $this->db->select('m_stage_detail_id AS stage_detail_id');
        $this->db->select('base_x');
        $this->db->select('base_y');
        $this->db->select('size_x');
        $this->db->select('size_y');

        $this->db->from('m_stage_fence');

        $this->db->where_in('m_stage_detail_id', $stage_detail_ids);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ステージフェンス情報を取得
     * @param Integer $stage_fence_id
     * @return Array
     */
    function get_data($stage_fence_id) {
    }

    /**
     * ステージフェンス情報を更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * ステージフェンス情報を登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
