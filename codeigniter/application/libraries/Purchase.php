<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * アプリ内課金クラス
 * @author kamikawa
 *
 */
class Purchase {

    public $CI;

    function __construct(){
        $this->CI = &get_instance();

        $this->CI->config->load('app_config');
    }

    /**
     * レシートデータのログファイル出力
     *
     * @param Array $params 
     */
    protected function output_receipt_log($params) {

        $log_path = $this->CI->config->item('log_path');
        $file_path = $log_path. $params['device_id']. '_'. $params['user_id']. '_'. date('Y-m-d'). '.log';
        if($fp = @fopen($file_path, 'a')) {
            fwrite($fp, date('Y-m-d H:m:s'). "\t". $params['device_id']. "\t". $params['user_id']. "\t". $params['product_id']. "\t". $params['receipt']. "\n");
            fflush($fp);
            fclose($fp);
        }
    }

    /**
     * 問い合わせ成功時のログファイル出力
     *
     * @param Integer $device_id
     * @param Integer $user_id
     * @param String $url
     * @param Array $result
     */
    protected function output_access_log($device_id, $user_id, $url, $result) {

        $log_path = $this->CI->config->item('log_path');
        $file_path = $log_path. $device_id. '_'. $user_id. '_'. date('Y-m-d'). '.log';
        if($fp = @fopen($file_path, 'a')) {
            fwrite($fp, date('Y-m-d H:m:s'). "\t". $device_id. "\t". $user_id. "\t". $url. "\t". json_encode($result). "\n");
            fflush($fp);
            fclose($fp);
        }
    }

    /**
     * ユーザゴールドの更新
     *
     * @param Integer $user_id
     * @param Integer $charge_gold
     * @param Array $result
     */
    protected function update_gold($user_id, $charge_gold) {

        $status = false;

        $this->CI->load->model('T_gold_model');
        $t_gold_data = $this->CI->T_gold_model->get_data($user_id);
        $status = $this->CI->T_gold_model->update($user_id, $t_gold_data['sum_gold']+$charge_gold, $t_gold_data['charge_gold']+$charge_gold, $t_gold_data['free_gold']);

        return $status;

    }
}
