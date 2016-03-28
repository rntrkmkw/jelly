<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * メッセージ情報モデル
 *
 * @author kamikawa
 *
 */
class T_message_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * メッセージ情報一覧を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_list($user_id) {
        $this->db->select('id AS message_id');
        $this->db->select('user_id');
        $this->db->select('friend_id');
        $this->db->select('read_flg');

        $this->db->from('t_message');

        $this->db->where('friend_id', $user_id);
        $this->db->where('read_flg', COMMON__FLAG__OFF);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $this->db->limit(50);

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * メッセージ情報を取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * メッセージ情報を更新
     * @param Array $message_ids
     * @return Boolean
     */
    function update($message_ids) {

        // 更新データをセット
        $data = array(
            'read_flg' => COMMON__FLAG__ON
        );

        // 更新条件をセット
        $this->db->where_in('id', $message_ids);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_message', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     *  メッセージ情報を登録
     * @param Integer $user_id
     * @param Array $friend_ids
     * @return Boolean
     */
    function insert($user_id, $friend_ids) {

        // 登録データをセット
        $data_list = array();
        foreach($friend_ids as $friend_id) {
            $data = array(
                'user_id'   => $user_id,
                'friend_id' => $friend_id,
                'read_flg'  => COMMON__FLAG__OFF
            );
            array_push($data_list, $data);
        }

        // 登録
        $result_status = $this->insertBatchCustomCheckCount('t_message', $data_list);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return $result_status;
    }
}
