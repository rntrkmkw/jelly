<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * フレンド情報モデル
 *
 * @author kamikawa
 *
 */
class T_friend_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * フレンド情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * フレンド情報を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_data($user_id) {
        $this->db->select('user_id');
        $this->db->select('friend_id_list');

        $this->db->from('t_friend');

        $this->db->where('user_id', $user_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * フレンド情報を更新
     * @param Integer $user_id
     * @param String $friend_list_json
     * @return Boolean
     */
    function update($user_id, $friend_list_json) {

        // 更新データをセット
        $data = array(
            'friend_id_list' => $friend_list_json
        );

        // 更新条件をセット
        $this->db->where('user_id', $user_id);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_friend', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     * フレンド情報を登録
     * @param Integer $user_id
     * @return Boolean
     */
    function insert($user_id) {

        // 登録データをセット
        $data = array(
            'user_id' => $user_id
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_friend', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
