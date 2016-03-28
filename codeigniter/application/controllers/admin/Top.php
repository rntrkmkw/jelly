<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ソースツリーバグ対策※日本語文字化け対策
require_once(APPPATH.'/controllers/admin/Admin.php');

/**
 * TOP画面クラス
 * @author kamikawa
 *
*/
class Top extends Admin {
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
     * TOP画面
     */
    function index() {
        // アウトプット
        $this->output_data();
    }
}
