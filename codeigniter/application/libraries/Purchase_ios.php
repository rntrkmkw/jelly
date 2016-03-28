<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'libraries/Purchase.php';

/**
 * アプリ内課金(iOS)クラス
 * @author kamikawa
 *
 */
class Purchase_ios extends Purchase{

    function __construct(){
        parent::__construct();
    }

    // ToDo : 固定値定義
    private $apple_production_url = 'https://buy.itunes.apple.com/verifyReceipt';
    private $apple_sandbox_url    = 'https://sandbox.itunes.apple.com/verifyReceipt';
    private $status_sandbox       = 21007;

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

        $status_util          = 0;

        // レシートがすでに登録されていたらエラー
        $this->CI->load->model('T_receipt_ios_model');
        $receipt_data = $this->CI->T_receipt_ios_model->get_data($params['receipt']);
        if($receipt_data) { return false; }

        // レシートデータのログファイル出力
        $this->output_receipt_log($params);

        // レシート検証
        $sandbox_flg = COMMON__FLAG__OFF;
        // 本番アクセス
        $result = $this->curl_ios($this->apple_production_url, $params);

        // サンドボックスアクセス
        if((! empty($result['status'])) && ($result['status'] === $this->status_sandbox)) {
            $result = $this->curl_ios($this->apple_sandbox_url, $params);
            $sandbox_flg = COMMON__FLAG__ON;
        }

        // 失敗時 
        //if($result['status'] !== $status_util) {
        //    return false;
        //}

        // 成功時
        // ToDo : レシートデータ登録 ここではテスト用のデータを使用
        $result = array(
            'status' => 0,
            'receipt' => array(
                'original_purchase_date_pst' => 'xxxxxxxxx',
                'purchase_date_ms'           => 'xxxxxxxxx',
                'unique_identifier'          => 'xxxxxxxxx',  
                'original_transaction_id'    => 'xxxxxxxxx',
                'bvrs'                       => 'xxxxxxxxx',
                'transaction_id'             => 'xxxxxxxxx',
                'quantity'                   => 'xxxxxxxxx',
                'unique_vendor_identifier'   => 'xxxxxxxxx',
                'item_id'                    => 'xxxxxxxxx',  
                'product_id'                 => 'xxxxxxxxx',  
                'purchase_date'              => 'xxxxxxxxx',  
                'original_purchase_date'     => 'xxxxxxxxx',  
                'purchase_date_pst'          => 'xxxxxxxxx',  
                'bid'                        => 'xxxxxxxxx',     
                'original_purchase_date_ms'  => 'xxxxxxxxx'
            )
        );
        $status = $this->CI->T_receipt_ios_model->insert($params['device_id'], $params['user_id'], $params['product_id'], $params['receipt'], $sandbox_flg, $result);
        if(! $status) { return false; }

        // 購入履歴登録
        $this->CI->load->model('M_gold_ios_model');
        $m_gold_data = $this->CI->M_gold_ios_model->get_data($params['product_id']);
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
     * @param String $url
     * @param Array $params
     * 
     */
    private function curl_ios($url, $params) {

        $result = array();

        // レシートデータをJSONエンコード
        $receipt_json = json_encode(array('receipt-data' => $params['receipt']));

        $ch = curl_init($url);

        // curl_exec()の返り値を文字列にする設定
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // POST送信設定
        curl_setopt($ch, CURLOPT_POST, true);
        // 送信データの設定
        curl_setopt($ch, CURLOPT_POSTFIELDS, $receipt_json);
        // HTTPヘッダフィールドの設定
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json; charset=UTF-8'));

        // 送信
        $result_json = curl_exec($ch);

        // 返り値をデコード
        $result = json_decode($result_json, true);

        // 問い合わせ失敗
        if(! $result) {
            log_message('ERROR', 'curl exec failed. because '. curl_error($ch). ' URL:'. $url. ' receipt-data:'. $params['receipt']);
            return false;
        }

        // 問い合わせ成功
        $this->output_access_log($params['device_id'], $params['user_id'], $url, $result);

        return $result;

    }
}
