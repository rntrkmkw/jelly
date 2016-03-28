<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * アプリバージョンマスタモデル
 *
 * @author kamikawa
 *
 */
class M_version_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * アプリバージョン一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
        $this->db->select('id AS version_id');
        $this->db->select('app_version');
        $this->db->select('dl_host');
        $this->db->select('master_version');
        $this->db->select('ios_review');

        $this->db->from('m_version');

        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $this->db->order_by('id', 'desc');

        $data = $this->db->get();
        // 最新の1件のみ取得する
        $result = $data->row_array();

        return $result;
    }

    /**
     * アプリバージョンデータを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * アプリバージョンデータを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * アプリバージョンデータを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
