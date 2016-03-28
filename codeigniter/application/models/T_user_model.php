<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ユーザ情報モデル
 *
 * @author kamikawa
 *
 */
class T_user_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ユーザ情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * ユーザ情報を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_data($user_id) {
    //    $this->db->select('id AS user_id');
    //    $this->db->select('name');
    //    $this->db->select('image_url');
    //    $this->db->select('auth_token');
    //    $this->db->select('secret_key');
    //    $this->db->select('facebook_id');

    //    $this->db->from('t_user');

    //    $this->db->where('id', $user_id);

    //    $data = $this->db->get();
    //    $result = $data->row_array();

    //    return $result;
    }

    /**
     * ユーザ情報を取得
     * @param Integer $fb_id
     * @return Array
     */
    function get_data_by_fbid($fb_id) {
        $this->db->select('id AS user_id');
        $this->db->select('name');
        $this->db->select('status');
        $this->db->select('image_url');
        $this->db->select('auth_token');
        $this->db->select('secret_key');
        $this->db->select('facebook_id');

        $this->db->from('t_user');

        $this->db->where('facebook_id', $fb_id);
        $this->db->where('status', T_USER__STATUS__VALID);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ユーザ情報を更新
     * @param Integer $user_id
     * @param String $name
     * @param String $image_url
     * @param String $auth_token
     * @param String $secret_key
     * @param String $facebook_id
     * @param String $mail
     * @return Boolean
     */
    function update_data($user_id, $name, $image_url, $auth_token, $secret_key, $facebook_id, $mail) {

    //    // 更新データをセット
    //    $data = array(
    //        'name'        => $name,
    //        'image_url'   => $image_url,
    //        'auth_token'  => $auth_token,
    //        'secret_key'  => $secret_key,
    //        'facebook_id' => $facebook_id,
    //        'mail'        => $mail
    //    );

    //    // 更新条件をセット
    //    $this->db->where('id', $user_id);

    //    // 更新
    //    $result_status = $this->updateCustomCheckCount('t_user', $data);
    //    // 更新チェック
    //    if (!$result_status){
    //        return false;
    //    }
    //    return true;
    }

    /**
     * ユーザ情報を登録
     * @param String name
     * @param String image_url
     * @param String auth_token
     * @param String secret_key
     * @param String facebook_id
     * @return Boolean
     */
    function insert($name, $image_url, $auth_token, $secret_key, $facebook_id) {

        // 登録データをセット
        $data = array(
            'name'        => $name,
            'status'      => T_USER__STATUS__VALID,
            'image_url'   => $image_url,
            'auth_token'  => $auth_token,
            'secret_key'  => $secret_key,
            'facebook_id' => $facebook_id
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_user', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
