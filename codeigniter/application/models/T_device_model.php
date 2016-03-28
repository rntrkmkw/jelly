<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * デバイス情報モデル
 *
 * @author kamikawa
 *
 */
class T_device_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * デバイス情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * デバイス情報を取得
     * @param String $uiid
     * @return Array
     */
    function get_data_by_uiid($uiid) {
        $this->db->select('id AS device_id');
        $this->db->select('app_ver');
        $this->db->select('os_type');
        $this->db->select('os_ver');
        $this->db->select('device_ver');

        $this->db->from('t_device');

        $this->db->where('uiid', $uiid);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * デバイス情報を更新
     * @param unknown
     * @return Boolean
     */
    function update() {
    }

    /**
     * デバイス情報を登録
     * @param String uiid
     * @param Integer app_ver
     * @param Integer os_type
     * @param String os_ver
     * @param String device_ver
     * @param String device_token
     * @return Boolean
     */
    function insert($uiid, $app_ver, $os_type, $os_ver, $device_ver, $device_token) {

        // 登録データをセット
        $data = array(
            'uiid'         => $uiid,
            'app_ver'      => $app_ver,
            'os_type'      => $os_type,
            'os_ver'       => $os_ver,
            'device_ver'   => $device_ver,
            'device_token' => $device_token
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_device', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
