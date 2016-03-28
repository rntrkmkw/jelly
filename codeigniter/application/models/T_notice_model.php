<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * お知らせ情報モデル
 *
 * @author kamikawa
 *
 */
class T_notice_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * お知らせ情報一覧を取得
     * @param Integer $device_id
     * @return Array
     */
    function get_list($device_id) {
        $this->db->select('id AS notice_id');
        $this->db->select('device_id');
        $this->db->select('user_id');
        $this->db->select('m_notice_id');
        $this->db->select('read_flg');

        $this->db->from('t_notice');

        $this->db->where('device_id', $device_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $this->db->limit(50);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * お知らせ情報を取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * お知らせ情報を更新
     * @param Array $notice_ids
     * @return Boolean
     */
    function update($notice_ids) {

        // 更新データをセット
        $data = array(
            'read_flg' => COMMON__FLAG__ON
        );

        // 更新条件をセット
        $this->db->where_in('id', $notice_ids);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_notice', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     *  お知らせ情報を登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
