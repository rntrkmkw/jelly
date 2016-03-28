<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * ユーザイベントロジック
 *
 * @author kamikawa
 */
class Api_event_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 600
     * ユーザイベントステージ情報取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_event_stage_data_get_600($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザイベントステージ情報を取得
        $this->CI->load->model('T_event_stage_model');
        $result['event_stage'] = $this->CI->T_event_stage_model->get_data($params['user_id']);

        // イベントキング情報を取得
        $this->CI->load->model('T_event_king_model');
        $result['king'] = $this->CI->T_event_king_model->get_data($params['event_member_id']);

        return $result;
    }

    /**
     * ApiID 601
     * ユーザイベントステージ情報更新ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function t_event_stage_data_update_601($params) {

        $result = array();

        // 固有パラメータチェック
        if(! $this->check_params($this->get_validation_list($params['api_id']))) {
            return ERROR__VALIDATION;
        }

        // ユーザイベントステージ情報を登録
        $this->CI->load->model('T_event_stage_model');
        $status = $this->CI->T_event_stage_model->insert($params['user_id'], $params['event_stage_id'], $params['m_stage_id'], $params['status']);
        if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }

        // 成功時にラストステージかどうかチェックしてキング達成かどうか判別
        if($params['status'] == COMMON__FLAG__ON) {
            $this->CI->load->model('M_event_stage_model');
            $event_stage = $this->CI->M_event_stage_model->get_data($params['event_stage_id']);
            if(! $event_stage) { return ERROR__TRANSACTION_ROLLBACK; }

            // キング達成時
            if($event_stage['last_stage_flg'] == COMMON__FLAG__ON) {

                // 達成時の更新登録処理
                $status = $this->king_success_update($params['user_id'], $params['event_id'], $params['event_member_id']);
                if(! $status) { return ERROR__TRANSACTION_ROLLBACK; }
            }
        }

        // ユーザイベントステージ情報
        $result['event_stage'] = $this->CI->T_event_stage_model->get_data($params['user_id']);
        // キング情報
        $result['king'] = $this->CI->T_event_king_model->get_data($params['event_member_id']);
        // ユーザアイテム情報
        $this->CI->load->model('T_item_model');
        $result['item'] = $this->CI->T_item_model->get_list($params['user_id']);
        // ユーザゴールド情報
        $this->CI->load->model('T_gold_model');
        $result['gold'] = $this->CI->T_gold_model->get_data($params['user_id']);

        return $result;
    }

    /**
     * イベントキング達成ロジック
     *
     * @param Integer $user_id
     * @param Integer $event_id
     * @param Integer $event_member_id
     * @author kamikawa
     */
    private function king_success_update($user_id, $event_id, $event_member_id) {

        // すでにキングになっているユーザが居るかチェック
        $this->CI->load->model('T_event_king_model');
        $last_king = $this->CI->T_event_king_model->get_data($event_member_id);

        // ユーザがキングになった回数を取得
        $user_king_data = $this->CI->T_event_king_model->get_user_king_data($user_id, $event_member_id);
        $success_cnt = empty($user_king_data) ? 1:$user_king_data['success_count']+1;

        // キング情報を登録
        $status = $this->CI->T_event_king_model->insert($user_id, $event_member_id, $success_cnt);
        if(! $status) { return false; }

        // 最低報酬を配布
        $status = $this->dist_event_reward($user_id, $event_id, M_EVENT_REWARD__PRIORITY__MIN);
        if(! $status) { return false; }

        // 前キングユーザに対しての報酬を配布してレコードを更新
        if(! empty($last_king)) {
            // キング滞在時間を算出して報酬を決定
            $king_reward = $this->calc_king_reward($event_id, $last_king['success_date']);

            // キング滞在報酬を配布
            $status = $this->dist_event_reward($last_king['user_id'], $event_id, $king_reward['priority']);
            if(! $status) { return false; }

            // キング情報更新
            $status = $this->CI->T_event_king_model->update($last_king['event_king_id'], $king_reward['event_reward_id']);
            if(! $status) { return false; }
        }

        return true;
    }

    /**
     * イベント報酬配布ロジック
     *
     * @param Integer $user_id
     * @param Integer $event_id
     * @param Integer $priority
     * @author kamikawa
     */
    private function dist_event_reward($user_id, $event_id, $priority) {
        // モデルロード
        $this->CI->load->model('M_event_reward_model');
        // イベント報酬情報取得
        $event_reward = $this->CI->M_event_reward_model->get_data($event_id, $priority);
        // 報酬がアイテムならレコードの存在をチェックしてアイテム情報を更新or登録
        if($event_reward['m_item_id'] != M_ITEM__ID__FREE_GOLD) {
            $this->CI->load->model('T_item_model');
            $item_data = $this->CI->T_item_model->get_data($user_id, $event_reward['m_item_id']);
            if(! empty($item_data)) {
                $status = $this->CI->T_item_model->update($user_id, $event_reward['m_item_id'], $item_data['cnt']+$event_reward['cnt']);
                if(! $status) { return false; }
            } else {
                $status = $this->CI->T_item_model->insert($user_id, $event_reward['m_item_id'], $event_reward['cnt']);
                if(! $status) { return false; }
            }
        // 報酬が無償ゴールドならゴールド情報を更新
        } else {
            $this->CI->load->model('T_gold_model');
            $gold_data = $this->CI->T_gold_model->get_data($user_id);
            $status = $this->CI->T_gold_model->update($user_id, $gold_data['sum_gold']+$event_reward['cnt'], $gold_data['charge_gold'], $gold_data['free_gold']+$event_reward['cnt']);
            if(! $status) { return false; }
        }

        return true;
    }

    /**
     * キング滞在報酬ロジック
     *
     * @param Integer $event_id
     * @param String $success_date
     * @author kamikawa
     */
    private function calc_king_reward($event_id, $success_date) {

        // キング滞在時間(秒)を算出
        $king_time = (strtotime($this->CI->current_date) - strtotime($success_date));

        // 報酬係数(優先度に相当)の決定
        // 報酬係数＝'滞在秒÷150'の対数(底2)の切り上げとして計算(ただし1未満は1とする)
        /*
         * 滞在時間(秒)と報酬係数の対応
         * 300秒以下:優先度1、600秒以下:優先度2、1200秒以下:優先度3、2400秒以下:優先度4、・・・
         */
        $priority_coefficient = ceil(log($king_time/150, 2));
        $priority = ($priority_coefficient < 1)? 1:$priority_coefficient;

        // 配布するイベント報酬
        $event_reward = $this->CI->M_event_reward_model->get_data($event_id, $priority);
        // 該当する優先度の報酬が設定されていなかった場合はキング滞在報酬として最大優先度のもの(優先度9)を配布する
        if(empty($event_reward)) {
            $event_reward = $this->CI->M_event_reward_model->get_data($event_id, M_EVENT_REWARD__PRIORITY__MAX);
        }

        return $event_reward;

    }
}
