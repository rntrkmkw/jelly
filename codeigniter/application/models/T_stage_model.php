<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ステージ情報モデル
 *
 * @author kamikawa
 *
 */
class T_stage_model extends MY_Model {

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！ **********
    }

    /**
     * ステージ情報一覧を全取得
     * @param Integer $user_id
     * @return Array
     */
    function get_all($user_id) {
        $this->db->select('user_id');
        $this->db->select('m_stage_id');
        $this->db->select('status');
        $this->db->select('score');
        $this->db->select('rank');

        $this->db->from('t_stage');

        $this->db->where('user_id', $user_id);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $this->db->order_by('m_stage_id');

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ステージ情報一覧を取得
     * @param Integer $user_id
     * @param Array $stage_ids
     * @return Array
     */
    function get_list($user_id, $stage_ids) {
        $this->db->select('user_id');
        $this->db->select('m_stage_id');
        $this->db->select('status');
        $this->db->select('score');
        $this->db->select('rank');

        $this->db->from('t_stage');

        $this->db->where('user_id', $user_id);
        $this->db->where_in('m_stage_id', $stage_ids);
        $this->db->where('del_flg', COMMON__FLAG__OFF);

        $this->db->order_by('m_stage_id');

        $data = $this->db->get();
        $result = $data->result_array();

        return $result;
    }

    /**
     * ステージ情報データを取得
     * @param Integer $user_id
     * @param Integer $stage_id
     * @return Array
     */
    function get_data($user_id, $stage_id) {
        $this->db->select('user_id');
        $this->db->select('m_stage_id');
        $this->db->select('status');
        $this->db->select('score');
        $this->db->select('rank');

        $this->db->from('t_stage');

        $this->db->where('user_id', $user_id);
        $this->db->where('m_stage_id', $stage_id);

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * プレイ中ステージ情報を取得
     * @param Integer $user_id
     * @return Array
     */
    function get_last_stage_data($user_id) {
        $this->db->select('user_id');
        $this->db->select('m_stage_id');
        $this->db->select('status');
        $this->db->select('score');
        $this->db->select('rank');

        $this->db->from('t_stage');

        $this->db->where('user_id', $user_id);

        $this->db->order_by('m_stage_id', 'desc');

        $data = $this->db->get();
        $result = $data->row_array();

        return $result;
    }

    /**
     * ステージ情報を更新
     * @param Integer $user_id
     * @param Integer $stage_id
     * @param Integer $status
     * @param Integer $score
     * @param Integer $rank
     * @return Boolean
     */
    function update($user_id, $stage_id, $status, $score, $rank) {

        // 更新データをセット
        $data = array(
            'status' => $status,
            'score'  => $score,
            'rank'   => $rank
        );

        // 更新条件をセット
        $this->db->where('user_id', $user_id);
        $this->db->where('m_stage_id', $stage_id);

        // 更新
        $result_status = $this->updateCustomCheckCount('t_stage', $data);
        // 更新チェック
        if (!$result_status){
            return false;
        }
        return true;
    }

    /**
     * ステージ情報を登録
     * @param Integer $user_id
     * @param Integer $stage_id
     * @param Integer $status
     * @param Integer $score
     * @param Integer $rank
     * @return Boolean
     */
    function insert($user_id, $stage_id, $status, $score, $rank) {

        // 登録データをセット
        $data = array(
            'user_id'    => $user_id,
            'm_stage_id' => $stage_id,
            'status'     => $status,
            'score'      => $score,
            'rank'       => $rank
        );

        // 登録
        $result_status = $this->insertCustomCheckCount('t_stage', $data);
        // 更新チェック
        if (! $result_status) {
            return false;
        }

        return true;
    }
}
