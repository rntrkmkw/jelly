<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * お知らせマスタモデル
 *
 * @author kamikawa
 *
 */
class M_notice_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * お知らせ一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
        $this->db->select('id AS notice_id');
        $this->db->select('title');
        $this->db->select('contents');
        $this->db->select('m_reward_id');

        $this->db->from('m_notice');

        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * お知らせデータを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * お知らせデータを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * お知らせデータを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
