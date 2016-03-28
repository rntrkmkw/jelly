<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * イベントメンバ情報モデル
 *
 * @author kamikawa
 *
 */
class T_event_member_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * イベントメンバ情報一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * イベントメンバ情報データを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * イベントメンバ情報データを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * イベントメンバ情報データを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
