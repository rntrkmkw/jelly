<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sessionライブラリ
 * @author kamikawa
 *
 */
class MY_Session extends CI_Session {
    protected $CI;
    
    /**
     * コンストラクタ
     *
     * @access  public
     * @return  void
     */
    function __construct() {
        parent::__construct();

        $this->CI =& get_instance();
        // ヘルパロード

    }

    /**
     * CSRFトークンを取得する
     * @return Ambigous <string, unknown>
     */
    function get_csrf_token(){
        // セッション終了※セッションクローズ忘れ対策
        session_write_close();

        // セッション開始
        session_start();

        $token = !empty($_SESSION[SESS_KEY__SYSTEM__CSRF_TOKEN]) ? $_SESSION[SESS_KEY__SYSTEM__CSRF_TOKEN] : '';
        // 取得したら削除
        if (!empty($token)){
            unset($_SESSION[SESS_KEY__SYSTEM__CSRF_TOKEN]);
        }
        // セッション終了
        session_write_close();

        return $token;
    }

    /**
     * CSRFトークンをSESSIONに格納する
     * @param unknown $token
     * @return boolean
     */
    function set_csrf_token($token){

        // 文字数チェック
        if (!$this->CI->form_validation->exact_length($token, 32)){
            return false;
        }
        // 16進数文字列チェック
        if (!ctype_xdigit($token)){
            return false;
        }

        // セッション終了※セッションクローズ忘れ対策
        session_write_close();

        // セッション開始
        session_start();

        // 前回分を削除
        if (!empty($_SESSION[SESS_KEY__SYSTEM__CSRF_TOKEN])){
            unset($_SESSION[SESS_KEY__SYSTEM__CSRF_TOKEN]);
        }
        // CSRFトークンをセッションに格納
        $_SESSION[SESS_KEY__SYSTEM__CSRF_TOKEN] = $token;

        // セッション終了
        session_write_close();

        return true;
    }
}
?>
