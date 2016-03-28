<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ゴールド購入(Android)マスタモデル
 *
 * @author kamikawa
 *
 */
class M_gold_android_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ゴールド購入一覧を取得
     * @param Integer $language
     * @return Array
     */
    function get_list($language) {
        $this->db->select('id AS gold_id');
        $this->db->select('product_id');
        $this->db->select('type');
        $this->db->select('publish_flg');
        $this->db->select('language');
        $this->db->select('title');
        $this->db->select('description');
        $this->db->select('autofill');
        $this->db->select('country');
        $this->db->select('price');
        $this->db->select('charge_gold');

        $this->db->from('m_gold_android');

        $this->db->where('language', $language);
        $this->db->where('publish_flg', COMMON__FLAG__ON);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ゴールド購入データを取得
     * @param Integer $product_id
     * @return Array
     */
    function get_data($product_id) {
        $this->db->select('id AS m_gold_id');
        $this->db->select('product_id');
        $this->db->select('title');
        $this->db->select('description');
        $this->db->select('price');
        $this->db->select('charge_gold');

        $this->db->from('m_gold_android');

        $this->db->where('product_id', $product_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ゴールド購入データを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * ゴールド購入データを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
