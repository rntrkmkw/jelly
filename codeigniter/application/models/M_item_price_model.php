<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * アイテム価格マスタモデル
 *
 * @author kamikawa
 *
 */
class M_item_price_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * アイテム価格一覧を取得
     * @param Array $item_ids
     * @return Array
     */
    function get_list($item_ids) {
        $this->db->select('m_item_id AS item_id');
        $this->db->select('cnt');
        $this->db->select('price');

        $this->db->from('m_item_price');

        $this->db->where_in('m_item_id', $item_ids);
        $this->db->where('start_at <=', $this->CI->current_date);
        $this->db->where('end_at >=', $this->CI->current_date);
        $this->db->where('del_flg', COMMON__FLAG__OFF);
        
        $this->db->order_by('m_item_id');
        $this->db->order_by('price');

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * アイテム価格データを取得
     * @param Integer $item_price_id
     * @return Array
     */
    function get_data($item_price_id) {
        $this->db->select('m_item_id AS item_id');
        $this->db->select('cnt');
        $this->db->select('price');

        $this->db->from('m_item_price');

        $this->db->where('id', $item_price_id);
        
        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * アイテム価格データを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * アイテム価格データを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
