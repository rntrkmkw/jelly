<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * アイテムマスタモデル
 *
 * @author kamikawa
 *
 */
class M_item_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * アイテム一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
        $this->db->select('id AS item_id');
        $this->db->select('name');
        $this->db->select('description');
        $this->db->select('effect_name');
        $this->db->select('effect_type');
        $this->db->select('effect_value');

        $this->db->from('m_item');

        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * アイテムデータを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * アイテムデータを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * アイテムデータを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
