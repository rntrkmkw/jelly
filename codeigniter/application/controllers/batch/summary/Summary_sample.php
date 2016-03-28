<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/controllers/batch/summary/Summary.php');

/**
 * サマリーサンプルクラス
 * @author kamikawa
 *
*/
class Summary_sample extends Summary {

    function __construct(){
        parent:: __construct();
        // モデルロード
        // ライブラリロード
//        $this->load->library('session');
        // ヘルパロード
        // 言語ロード
        $this->lang->load('error', 'japanese_'. ENVIRONMENT_COMMON);

    }

    /**
     * サンプルコントローラ
     *
     */
    function index(){
        var_export($this->input->get());
        var_export($this->app_name, false);
    }
}
