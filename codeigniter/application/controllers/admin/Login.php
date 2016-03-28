<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ソースツリーバグ対策※日本語文字化け対策
require_once(APPPATH.'/controllers/admin/Admin.php');

/**
 * ログインクラス
 * @author kamikawa
 *
*/
class Login extends Admin {
    function __construct() {
        parent:: __construct();
        // モデルロード
        // ライブラリロード
        // ヘルパロード
        $this->load->helper(array('it_common'));
        // 言語ロード
    }

    /**
     * 管理画面ログイン
     */
    function index() {
        $data = array ();
        $mode = $this->input->post('mode');
        if (empty($mode)) {
            // 初期表示
            $message = '';
            $logout_mode = $this->input-> post_get('logout_mode');

            if(!empty($logout_mode)){
                if($logout_mode == 2){
                    $message = '正常ログアウト';
                }
                if($logout_mode == 1){
                    $message = 'ログインチェックエラーでログアウト';
                }
            }

            // パラメータセット
            $param_list = array('account_cd' => '',
                                'password' => ''
                               );
            $this->set_error_info($message);
            // ビュー用データにセット
            $data = $param_list;
        } else if ($mode == CTRL__MODE__EXEC_NORMAL){
            // ログイン時
            // 処理に必要なデータの取得
            $account_cd = $this->input->post('account_cd');
            $password = $this->input->post('password');

            // パラメータセット
            $param_list = array('account_cd' => $account_cd,
                                'password' => $password
                               );
            // パラメータチェック
            $error = $this->check_param($param_list);
            if (empty($error)) {
                // 管理画面ログイン認証
                $status = $this->it_login_admin->login_admin($param_list['account_cd'], $param_list['password']);
                // ログイン成功
                if ($status == LOGIN__STATUS__SUCCESS) {
                    // 管理画面ホームへリダイレクト
                    it_redirect(get_url_view('top/index'));
                } else {
                    // ログイン失敗
                    // エラーメッセージを設定
                    $this->set_error_info($this->lang->line('error_login_error'));
                }
            } else {
                // エラーメッセージをセット
                $this->set_error_info($error);
            }
            // ビュー用データにセット
            $data = $param_list;
        } else {
            // システムエラー
            show_error(add_error_trace($this->lang->line('error_system_error')));
        }

        // アウトプットデータに追加
        $this->set_template_data($data);


        // アウトプット
        $this->output_data('admin/login_index');
    }

    /**
     * パラメータチェック
     *
     * @param unknown $param_list
     * @return boolean
     */
    private function check_param($param_list) {
        $result = array ();
        // ライブラリロード
        $this->load->library('form_validation');
        // バリデーションルール設定
        //TODO 必要であればバリデーション実装 by nagao

        // チェック開始
        if ($this->form_validation->run() == FALSE) {
            // エラー処理
            $error = $this->form_validation->error_array();
            $result = $error;
        } else {
            // 成功処理
        }
        return $result;
    }
}
