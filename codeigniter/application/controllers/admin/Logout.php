<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ソースツリーバグ対策※日本語文字化け対策
require_once(APPPATH.'/controllers/admin/Admin.php');

/**
 * ログアウトクラス
 * @author kamikawa
 *
*/
class Logout extends Admin {
    function __construct() {
        parent:: __construct();
        // モデルロード
        // ライブラリロード
        $this->load->library('session');
        // ヘルパロード
        $this->load->helper(array('it_common'));
        // 言語ロード
    }

    /**
     * 管理画面ログアウト
     */
    function index() {
        // ログアウト
        $status = $this->it_login_admin->logout();
        // 管理画面ログインへリダイレクト
        it_redirect(get_url_view('login/index',array('logout_mode'=> 2)));
    }
}
