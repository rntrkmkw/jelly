<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ユーザ連携情報モデル
 *
 * @author kamikawa
 *
 */
class T_user_device_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ユーザ連携情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * ユーザ連携情報を取得
     * @param String $device_id
     * @return Array
     */
    function get_data($device_id) {
        $this->db->select('id AS user_device_id');
        $this->db->select('device_id');
        $this->db->select('user_id');

        $this->db->from('t_user_device');

        $this->db->where('device_id', $device_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ユーザ連携情報を更新
     * @param Integer device_id
     * @param Integer user_id
     * @return Boolean
     */
    function update($device_id, $user_id) {

        // 更新データをセット
        $data = array(
            'user_id' => $user_id
        );

        // 更新条件をセット
        $this->db->where('device_id', $device_id);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_user_device', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     * ユーザ連携情報を登録
     * @param Integer device_id
     * @param Integer user_id
     * @return Boolean
     */
    function insert($device_id, $user_id) {

        // 登録データをセット
        $data = array(
            'device_id' => $device_id,
            'user_id'   => $user_id
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_user_device', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
