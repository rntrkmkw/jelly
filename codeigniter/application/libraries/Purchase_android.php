<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'libraries/Purchase.php';

/**
 * アプリ内課金(Android)クラス
 * @author kamikawa
 *
 */
class Purchase_android extends Purchase{

    function __construct(){
        parent::__construct();
    }

    // ToDo : 固定値定義
    private $google_access_token_url = 'https://accounts.google.com/o/oauth2/token';
    private $google_purchase_history_url = '';
    private $google_client_id = '';
    private $google_client_secret = '';
    private $google_refresh_token = '';

    /**
     * リクエストデータのログ出力
     * レシート検証
     *  -> 成功したらレシート登録、ゴールド購入履歴登録、ゴールド付与
     *
     * @param Array $params
     * 
     */
    public function verify($params) {

        $result = array();

        // レシートがすでに登録されていたらエラー
        $this->CI->load->model('T_receipt_android_model');
        $receipt_data = $this->CI->T_receipt_android_model->get_data($params['receipt']);
        if($receipt_data) { return false; }

        // レシートデータのログファイル出力
        $this->output_receipt_log($params);

        // レシート検証
        // 本番アクセス
        $result = $this->curl_android($params);

        // 失敗時 
        //if(! $result) {
        //    return false;
        //}

        // 成功時
        // ToDo : レシートデータ登録
        $result = array(
            'signature'      => 'xxxxxxxx',
            'purchase_token' => 'xxxxxxxx',
            'order_id'       => 'xxxxxxxx'
        );
        $this->CI->load->model('T_receipt_android_model');
        $status = $this->CI->T_receipt_android_model->insert($params['device_id'], $params['user_id'], $params['product_id'], $params['receipt'], $result);
        if(! $status) { return false; }

        // 購入履歴登録
        $this->CI->load->model('M_gold_android_model');
        $m_gold_data = $this->CI->M_gold_android_model->get_data($params['product_id']);
        $this->CI->load->model('T_gold_history_model');
        $status = $this->CI->T_gold_history_model->insert($params['device_id'], $params['user_id'], $params['os_type'], $m_gold_data['m_gold_id']);
        if(! $status) { return false; }

        // ゲストユーザでなければユーザゴールド更新
        if(! empty($params['user_id'])) {

            $status = $this->update_gold($params['user_id'], $m_gold_data['charge_gold']);
            if(! $status) { return false; }
        }

        return true;
    }

    /**
     * レシート検証アクセス
     *
     * @param Array $params
     * 
     */
    private function curl_android($params) {

        $result = array();

        $url = $this->google_access_token_url;

        // 送信データをJSONエンコード
        $data_json = json_encode(array(
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->google_client_id,
            'client_secret' => $this->google_client_secret,
            'refresh_token' => $this->google_refresh_token
            ));

        $ch = curl_init($url);

        // curl_exec()の返り値を文字列にする設定
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // POST送信設定
        curl_setopt($ch, CURLOPT_POST, true);
        // 送信データの設定
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        // HTTPヘッダフィールドの設定
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json; charset=UTF-8'));

        // 送信
        $result_json = curl_exec($ch);

        // 返り値をデコード
        $result = json_decode($result_json, true);

        // 問い合わせ失敗
        if( empty($result['error'])) {
            log_message('ERROR', 'curl exec failed. because '. curl_error($ch). ' URL:'. $url. ' receipt-data:'. $params['receipt']);
            return false;
        }

        // 問い合わせ成功
        $this->output_access_log($params['device_id'], $params['user_id'], $url, $result);

        return $result;

    }
}
