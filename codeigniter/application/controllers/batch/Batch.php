<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Batchクラス
 * @author kamikawa
 *
*/
class Batch extends MY_Controller {

    function __construct(){
        parent:: __construct();

        // CLIチェック
        if (!is_cli()){
            show_error('実行不可', 200, 'システムエラー');
        }

        // モデルロード
        // コンフィグロード
        // ヘルパーロード
        // ライブラリ
        // ライブラリロード
        // 言語ロード

        // アプリ名の取得
        $this->app_name = strtolower(__CLASS__);

        // データの初期化
    }
}
