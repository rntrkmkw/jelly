<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * イベントマスタモデル
 *
 * @author kamikawa
 *
 */
class M_event_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * イベント一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * イベントを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * イベントを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * イベントを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
