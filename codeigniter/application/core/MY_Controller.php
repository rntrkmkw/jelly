<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *
 * 拡張コントローラ設定
 *
 * @author kamikawa
 *
 *
 */
class MY_Controller extends CI_Controller {
    public $app_name;                           // アプリ名
    public $directory_name;                     // リクエストURLディレクトリ名
    public $controller_name;                    // リクエストURLクラス名
    public $action_name;                        // リクエストURLアクション名
    public $current_date;                       // コントローラ共通日付
    protected $data = array();                  // ビューorレスポンス用データ配列
    public $log_user = '';                      // ログ分岐ユーザ(デフォルトはなし)
    public $by_user_name = '';
    protected $trans_level = 0;                 // トランザクションレベル

    /**
     * コンストラクタ
     */
    function __construct() {
        parent::__construct();
        // モデルロード
        // コンフィグロード
        // ヘルパーロード
        // ライブラリ
        // ロジッククラスのファイルパスをライブラリに追加
        $this->load->add_package_path(APPPATH . 'logics');
        // ライブラリロード
        // 言語ロード
        // $this->lang->load('error', 'japanese');

        // 日付データの取得
        $this->current_date = date('Y-m-d H:i:s');

        // ルーターオブジェクトを作成してクラス名と関数名を取得する
        $router_obj = & load_class('Router', 'core');
        $this->directory_name = $router_obj->fetch_directory();
        $this->controller_name = $router_obj->fetch_class();
        $this->action_name = $router_obj->fetch_method();
    }

    /**
     * コントローラのディレクトリパスを取得する
     *
     * @return mixed
     */
    protected function get_directory() {
        return str_replace($this->app_name . '/', '', $this->directory_name);
    }

    /**
     * ビューデータのinfo部を取得する
     */
    public function get_response_info() {
        return $this->data['response']['info'];
    }

    /**
     * 汎用トランザクション開始
     */
    public function transaction_begin() {
        // 接続確認
        if (! isset($this->db)) {
            log_message('ERROR', 'DB OBJECT IS NOTHING!');
            return;
        }

        // トランザクションレベルチェック
        // ※トランザクションのネストはさせない
        if ($this->trans_level == 0) {
            $this->db->trans_begin();
            $this->trans_level ++; // レベル増加
        } else {
            log_message('ERROR', 'ALREADY STARTED A TRANSACTION!');
        }
        return;
    }

    /**
     * 汎用トランザクションコミット
     */
    public function transaction_commit() {
        // 接続確認
        if (! isset($this->db)) {
            log_message('ERROR', 'DB OBJECT IS NOTHING!');
            return;
        }

        // トランザクションレベルチェック
        // ※トランザクションのネストはさせない
        if ($this->trans_level == 1) {
            $this->db->trans_commit();
            $this->trans_level --; // レベル減算
        } else {
            log_message('ERROR', 'NOT START A TRANSACTION!');
        }

        return;
    }

    /**
     * 汎用トランザクションロールバック
     */
    public function transaction_rollback() {
        // 接続確認
        if (! isset($this->db)) {
            log_message('ERROR', 'DB OBJECT IS NOTHING!');
            return;
        }

        // トランザクションレベルチェック
        // ※トランザクションのネストはさせない
        if ($this->trans_level == 1) {
            $this->db->trans_rollback();
            $this->trans_level --; // レベル減算
        } else {
            log_message('ERROR', 'NOT START A TRANSACTION!');
        }

        return;
    }
}
