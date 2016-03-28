<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 親モデルクラス
 * @author kamikawa
 *
*/
class MY_Model extends CI_Model{
    public $CI;                     // CIオブジェクト

    /**
     * コンストラクタ
     */
    function __construct(){
        parent::__construct();
        $this->CI =& get_instance();

        // 最初にロードしたモデルクラスのDBオブジェクトを保管
        if (!isset($this->CI->db)){
            $this->CI->db = $this->db;
        }

        // ヘルパーロード
        log_message('INFO', get_class($this).' Model Class Initialized');

    }

    /**
     * モデル内から他のモデルをロードする
     */
    function load_model($model,$name = '',$db_conn = false){
//        $this->CI =& get_instance();
        $this->CI->load->model($model,$name,$db_conn);

        if(!strpos($model,'/') === false){
            $x = explode('/',$model);
            $model = end($x);
        }

        $model = strtolower($model);
        if($name == ''){
            $name = $model;
            $this->$name = $this->CI->$model;
        }
    }

    /**
     * データインサート共通関数
     * ※アクティブレコードのinsert関数の直接使用は禁止！！
     * @param unknown $table_name
     * @param unknown $data
     */
    function insertCustom($table_name, $data = array()){
        // 共通項目の値セット
        $data = array_merge($data, $this->get_common_update_column(TRUE));

        $this->CI->db->insert($table_name, $data);

        // 更新チェック
        if ($this->CI->db->trans_status() === FALSE){
            return false;
        }
        return true;
    }

    /**
     * データインサート共通関数
     * ※アクティブレコードのinsert関数の直接使用は禁止！！
     * ※挿入件数が0件の場合もエラーにする
     * @param unknown $table_name
     * @param unknown $data
     */
    function insertCustomCheckCount($table_name, $data = array()){
        // 共通項目の値セット
        $data = array_merge($data, $this->get_common_update_column(TRUE));

        $this->CI->db->insert($table_name, $data);

        // 更新チェック
        if ($this->CI->db->trans_status() === FALSE){
            return false;
        }
        // 挿入件数が0件の場合はfalseを返す
        if ($this->CI->db->affected_rows() == 0){
            return false;
        }
        return true;
    }

    /**
     * バルクインサート用
     * ※可読性が落ちるため本関数は不用意に使用しないこと
     *
     * @param unknown $data_list
     * @return boolean
     */
    function insertBatchCustomCheckCount($table_name, $data_list){

        // 共通項目の値セット
        foreach($data_list as &$data) {
            $data = array_merge($data, $this->get_common_update_column(TRUE));
        }

        // 登録
        $insert_count = $this->db->insert_batch($table_name, $data_list);

        // 登録チェック
        if ($insert_count != count($data_list)){
            return false;
        }
        return $insert_count;
    }

    /**
     * バルクインサート用
     * ※可読性が落ちるため本関数は不用意に使用しないこと
     *
     * @param unknown $data_list
     * @return boolean
     */
    function insert_batch($data_list){
        // テーブル名を取得する
        $table_name = str_replace('_model', '', strtolower(get_class($this)));

        // 登録
        $insert_count = $this->db->insert_batch($table_name, $data_list);

        // 登録チェック
        if ($insert_count != count($data_list)){
            return false;
        }
        return true;
    }

    /**
     * データアップデート共通関数
     * ※アクティブレコードのupdate関数の直接使用は禁止！！
     * @param unknown $table_name
     * @param unknown $data
     */
    function updateCustom($table_name, $data = array()){
        // 共通項目の値セット
        $data = array_merge($data, $this->get_common_update_column(FALSE));

        $this->CI->db->update($table_name, $data);

        // 更新チェック
        if ($this->CI->db->trans_status() === FALSE){
            return false;
        }
        return true;
    }

    /**
     * データアップデート共通関数
     * ※アクティブレコードのupdate関数の直接使用は禁止！！
     * ※更新件数が0件の場合もエラーにする
     * @param unknown $table_name
     * @param unknown $data
     */
    function updateCustomCheckCount($table_name, $data = array()){
        // 共通項目の値セット
        $data = array_merge($data, $this->get_common_update_column(FALSE));

        $this->CI->db->update($table_name, $data);

        // 更新チェック
        if ($this->CI->db->trans_status() === FALSE){
            return false;
        }
        // 更新件数が0件の場合はfalseを返す
        if ($this->CI->db->affected_rows() == 0){
            return false;
        }
        return true;
    }

    /**
     * レコード更新時の共通カラム用のデータ取得
     * @param unknown $update_type
     */
    private function get_common_update_column($update_type_flg){

        $common_update_column_data = array();

        if($update_type_flg){
            $common_update_column_data['updated_at'] = $this->CI->current_date; // レコード更新日時
            $common_update_column_data['updated_by'] = $this->CI->by_user_name; // レコード更新者
            $common_update_column_data['created_at'] = $this->CI->current_date; // レコード作成日時
            $common_update_column_data['created_by'] = $this->CI->by_user_name; // レコード作成者
        }else{
            $common_update_column_data['updated_at'] = $this->CI->current_date; // レコード更新日時
            $common_update_column_data['updated_by'] = $this->CI->by_user_name; // レコード更新者
        }

        return $common_update_column_data;
    }
}
