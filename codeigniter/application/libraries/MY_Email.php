<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Email extends CI_Email {
    private $_email_config;
    private $_email_data = array();

    protected $_test_flag = false;
    protected $_template_id = 1;
    protected $_replace_list = array();

    // --------------------------------------------------------------------
    public function __construct(array $config = array()) {
        parent::__construct($config);

        $CI = & get_instance();
        // コンフィグロード
        $CI->load->config('email_config', TRUE);
        $this->_email_config = $CI->config->item('email_config');

        // 初期化
        $this->from(MAIL__FROM__ADDRESS, MAIL__FROM__NAME);         // 差出人
//        $this->CI->email->cc('another@another-example.com');
//        $this->CI->email->bcc('them@their-example.com');

        log_message('info', 'MY Email Class Initialized');
    }

    /**
     * マジックメソッドのゲッター
     * @param unknown $name
     */
    function __get($name){
    }

    /**
     * マジックメソッドのセッター
     * @param unknown $name
     * @param unknown $value
     */
    function __set($name, $value){
        // email_configに設定されていないキーはメンバ変数に追加させない
        if (!array_key_exists($name, $this->_email_config['rep_key_list'])) {
            return ;
        }

        // キーごとの個別処理
        switch ($name){
            default:
                break;
        }

        // メンバ変数に追加
        $this->_email_data[$name] = $value;
    }

    /**
     * テストフラグを設定する
     *
     * @param unknown $test_flag
     */
    public function set_test_flag($test_flag) {
        if ($test_flag === true) {
            $this->_test_flag = $test_flag;
        }
    }

    /**
     * テンプレートIDを設定する
     *
     * @param unknown $template_id
     */
    public function set_template_id($template_id) {
        if (! empty($template_id) && is_numeric($template_id)) {
            $this->_template_id = $template_id;
        }
    }

    /**
     * メール送信
     * ※主にWEBアプリ用
     *
     * @param string $auto_clear
     * @return Ambigous <boolean, void>
     */
    public function send_custom($auto_clear = TRUE) {
        $CI = & get_instance();

        // モデルロード
        $CI->load->model('template_mail_model');
        
        // DBからメールテンプレート情報を取得する
        $template_list = $CI->template_mail_model->get_mail_template($CI->page_layout, $this->_template_id);
        
        // テンプレートが取得できない場合はエラーを返す
        if (empty($template_list)){
            return false;
        }
        
        // メール送信
        return $this->send_common($template_list, $auto_clear);
    }
    
    /**
     * メール送信
     * ※主にADMIN、BATCH、APIアプリ用
     * 
     * @param unknown $page_layout_id
     * @param string $auto_clear
     * @return boolean|Ambigous
     */
    public function send_custom_by_page_layout_id($page_layout_id, $auto_clear = TRUE) {
        $CI = & get_instance();
    
        // モデルロード
        $CI->load->model('template_mail_model');
        
        // DBからメールテンプレート情報を取得する
        $template_list = $CI->template_mail_model->get_mail_template_by_page_layout_id($page_layout_id, $this->_template_id);
    
        // テンプレートが取得できない場合はエラーを返す
        if (empty($template_list)){
            return false;
        }
    
        // メール送信
        return $this->send_common($template_list, $auto_clear);
    }
    
    /**
     * 共通メール送信
     * @param unknown $template_list
     * @param string $auto_clear
     * @return Ambigous <boolean, void>
     */
    public function send_common($template_list, $auto_clear = TRUE) {
        $CI = & get_instance();
        
        // モデルロード
        $CI->load->model('template_mail_ad_model');

        // メール広告情報取得
        $template_mail_id_list = array();
        foreach ( $template_list as $template_data ) {
            // メールテンプレートIDリストの作成
            $template_mail_id_list[] = $template_data['id'];
        }
    
        $mail_ad_list = $CI->template_mail_ad_model->get_ad_data($template_mail_id_list);
        // メンバ変数に追加
        foreach ($mail_ad_list as $mail_ad_data){
            $this->_email_data[$mail_ad_data['ad_key']] = $mail_ad_data['content'];
        }
    
        $title = '';
        $message = '';
        // メールタイトルと本文を作成
        foreach ( $template_list as $template_data ) {
            $title .= $CI->load->view($template_data['mail_path'] . '/' . $template_data['mail_name'] . '_title.php', $this->_email_data, true);
            $message .= $CI->load->view($template_data['mail_path'] . '/' . $template_data['mail_name'] . '.php', $this->_email_data, true);
        }
    
        // メールタイトルと本文をセット
        $this->subject($title);
        $this->message($message);
    
        return $this->send($auto_clear);
    }
    
    /**
     * メールテンプレートからタイトルと本文を作成
     * ※主に入出金管理用
     * 
     * @param unknown $page_layout_id
     * @param string $auto_clear
     * @return boolean|Ambigous
     */
    public function get_mail_text($page_layout_id, $auto_clear = TRUE) {
        $CI = & get_instance();
    
        // モデルロード
        $CI->load->model('template_mail_model');
        
        // DBからメールテンプレート情報を取得する
        $template_list = $CI->template_mail_model->get_mail_template_by_page_layout_id($page_layout_id, $this->_template_id);
    
        // テンプレートが取得できない場合はエラーを返す
        if (empty($template_list)){
            return false;
        }

        // メール広告情報取得
        $template_mail_id_list = array();
        foreach ( $template_list as $template_data ) {
            // メールテンプレートIDリストの作成
            $template_mail_id_list[] = $template_data['id'];
        }
    
        // モデルロード
        $CI->load->model('template_mail_ad_model');
        $mail_ad_list = $CI->template_mail_ad_model->get_ad_data($template_mail_id_list);
        // メンバ変数に追加
        foreach ($mail_ad_list as $mail_ad_data){
            $this->_email_data[$mail_ad_data['ad_key']] = $mail_ad_data['content'];
        }
    
        $mail_text = array();
        $mail_text['title'] = null;
        $mail_text['message'] = null;
        // メールタイトルと本文を作成
        foreach ( $template_list as $template_data ) {
            $mail_text['title'] .= $CI->load->view($template_data['mail_path'] . '/' . $template_data['mail_name'] . '_title.php', $this->_email_data, true);
            $mail_text['message'] .= $CI->load->view($template_data['mail_path'] . '/' . $template_data['mail_name'] . '.php', $this->_email_data, true);
        }

        return $mail_text;
    }
}
