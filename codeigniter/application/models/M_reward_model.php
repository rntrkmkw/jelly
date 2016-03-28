<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 報酬マスタモデル
 *
 * @author kamikawa
 *
 */
class M_reward_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * 報酬一覧を取得
     * @param unknown
     * @return Array
     */
    function get_list() {
    }

    /**
     * 報酬データを取得
     * @param $id
     * @return Array
     */
    function get_data($id) {
    }

    /**
     * 報酬データを更新
     * @param $id
     * @return Boolean
     */
    function update() {
    }

    /**
     * 報酬データを登録
     * @param unknown
     * @return Boolean
     */
    function insert() {
    }
}
