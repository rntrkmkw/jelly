<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * アイテム情報モデル
 *
 * @author kamikawa
 *
 */
class T_item_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * アイテム情報一覧を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_list($user_id) {
        $this->db->select('user_id');
        $this->db->select('m_item_id AS item_id');
        $this->db->select('cnt');

        $this->db->from('t_item');

        $this->db->where('user_id', $user_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * アイテム情報を取得
     * @param Integer $user_id
     * @param Integer $item_id
     * @return Array
     */
    function get_data($user_id, $item_id) {
        $this->db->select('user_id');
        $this->db->select('m_item_id AS item_id');
        $this->db->select('cnt');

        $this->db->from('t_item');

        $this->db->where('user_id', $user_id);
        $this->db->where('m_item_id', $item_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * アイテム情報を更新
     * @param Integer $user_id
     * @param Integer $item_id
     * @param Integer $cnt
     * @return Boolean
     */
    function update($user_id, $item_id, $cnt) {

        // 更新データをセット
        $data = array(
            'cnt' => $cnt
        );

        // 更新条件をセット
        $this->db->where('user_id', $user_id);
        $this->db->where('m_item_id', $item_id);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_item', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     *  アイテム情報を登録
     * @param Integer $user_id
     * @param Integer $item_id
     * @param Integer $cnt
     * @return Boolean
     */
    function insert($user_id, $item_id, $cnt) {

        // 登録データをセット
        $data = array(
            'user_id'   => $user_id,
            'm_item_id' => $item_id,
            'cnt'       => $cnt
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_item', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
