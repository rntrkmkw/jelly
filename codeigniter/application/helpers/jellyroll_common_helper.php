<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ------------------------------------------------------------------------
if (! function_exists('get_total_rows')) {
    /**
     * ページネイションデータの総数を取得する
     */
    function get_total_rows() {
        $CI = &get_instance();

        return $CI->pagination->get_total_rows();
    }
}

// ------------------------------------------------------------------------
if (! function_exists('get_current_page_start')) {
    /**
     * 現在ページの開始データ件数を取得する
     *
     * @return number
     */
    function get_current_page_start() {
        $CI = &get_instance();

        $start = 0;

        if (get_total_rows() > $CI->pagination->per_page) {
            // 2ページ目以降がある場合
            $start = ($CI->pagination->cur_page - 1) * $CI->pagination->per_page + 1;
        } else if (get_total_rows() <= $CI->pagination->per_page && get_total_rows() > 0) {
            // 1ページ目しかない場合
            $start = 1;
        }

        return $start;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('get_current_page_end')) {
    /**
     * 現在ページの終了データ件数を取得する
     *
     * @return number
     */
    function get_current_page_end() {
        $CI = &get_instance();

        $end = 0;

        if (get_total_rows() <= $CI->pagination->per_page) {
            // 1ページ目しかない場合
            // ※$CI->pagination->cur_pageが1ページしかないと0になるため、別処理
            $end = get_total_rows();
        } else if (get_total_rows() < ($CI->pagination->per_page * $CI->pagination->cur_page)) {
            // 最終ページ
            $end = get_total_rows();
        } else if (get_total_rows() >= ($CI->pagination->per_page * $CI->pagination->cur_page) && get_total_rows() > 0) {
            // 2ページ目以降
            $end = $CI->pagination->per_page * $CI->pagination->cur_page;
        }

        return $end;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('get_current_page')) {
    /**
     * 現在ページを取得する
     *
     * @return number
     */
    function get_current_page() {
        $CI = &get_instance();

        $page = 0;

        if (get_total_rows() <= $CI->pagination->per_page) {
            // 1ページ目しかない場合
            // ※$CI->pagination->cur_pageが1ページしかないと0になるため、別処理
            $page = 1;
        } else {
            $page = $CI->pagination->cur_page;
        }

        return $page;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('set_it_cookie')) {
    /**
     * Cookieに指定データを保存する
     * ※cookieヘルパーのラップ関数
     * ※オプションの引数が必要な場合は追加する
     *
     * @param unknown $name
     * @param unknown $value
     * @param string $type
     */
    function set_it_cookie($name, $value, $type = COOKIE__VALIDATION_PERIOD_TYPE__DAY_30) {
        // 有効期間
        $validation_period = 0;

        switch ($type){
            case COOKIE__VALIDATION_PERIOD_TYPE__HOUR_1:
                $validation_period = COOKIE__VALIDATION_PERIOD__HOUR_1;
                break;
            case COOKIE__VALIDATION_PERIOD_TYPE__DAY_1:
                $validation_period = COOKIE__VALIDATION_PERIOD__DAY_1;
                break;
            case COOKIE__VALIDATION_PERIOD_TYPE__DAY_7:
                $validation_period = COOKIE__VALIDATION_PERIOD__DAY_7;
                break;
            case COOKIE__VALIDATION_PERIOD_TYPE__DAY_30:
                $validation_period = COOKIE__VALIDATION_PERIOD__DAY_30;
                break;
            default:
                break;
        }
        // Cookieヘルパーロード
        $CI = &get_instance();
        $CI->load->helper('cookie');

        // 有効期限日時
        $validation_date = $validation_period;

        // Cookieセット
        set_cookie($name, $value, $validation_date);
    }
}

// ------------------------------------------------------------------------
if (! function_exists('get_it_cookie')) {
    /**
     * Cookieの指定データを取得する
     * ※cookieヘルパーのラップ関数
     *
     * @param unknown $name
     * @param string $xss_clean
     * @return mixed
     */
    function get_it_cookie($name, $xss_clean = NULL) {
        // Cookieヘルパーロード
        $CI = &get_instance();
        $CI->load->helper('cookie');

        $cookie = get_cookie($name, $xss_clean);

        return $cookie;
    }
}
// ------------------------------------------------------------------------
if (! function_exists('delete_it_cookie')) {
    /**
     * Cookieの指定データを削除する
     * ※cookieヘルパーのラップ関数
     *
     * @param unknown $name
     * @param string $domain
     * @param string $path
     * @param string $prefix
     * @return mixed
     */
    function delete_it_cookie($name, $domain = '', $path = '/', $prefix = '') {
        // Cookieヘルパーロード
        $CI = &get_instance();
        $CI->load->helper('cookie');

        delete_cookie($name, $domain, $path, $prefix);
    }
}

// ------------------------------------------------------------------------

if (! function_exists('get_url_view')) {

    /**
     * 共通パラメータ付きのリクエストURLを返す
     *
     * @param unknown $uri
     * @param unknown $param
     * @param boolean $keep_alive_flg
     *            フラッシュデータの延命フラグ[false：延命しない、true：延命する]
     * @return string
     */
    function get_url_view($uri, $param = array(), $keep_alive_flg = REQUEST_URI__KEEP_ALIVE_FLG__OFF) {
        // URIが無指定の場合は空文字を返す
        if (empty($uri)) {
            return '';
        }

        // アプリ共通パラメータはここで定義する
        if (! empty($keep_alive_flg)) {
            $param['keep_alive_flg'] = $keep_alive_flg;
        }

        return base_url($uri) . (empty($param) ? '' : '?' . http_build_query($param));
    }
}
// ------------------------------------------------------------------------

if (! function_exists('get_return_url')) {

    /**
     * リクエスト元画面のリクエストURLを返す
     * ※戻るリンク用
     *
     * @param unknown $param
     * @param number $keep_alive_flg
     * @return string
     */
    function get_return_url($param = array(), $keep_alive_flg = REQUEST_URI__KEEP_ALIVE_FLG__OFF) {
        $CI = &get_instance();

        $param_list = array();
        // 戻るボタンにパラメータを追加する場合に引数で指定した
        if (! empty($param)) {
            $param_list = array_merge($CI->request_data['param_list']['get'], $param);
        }

        // URLを取得
        $url = get_url_view($CI->request_data['uri'], $param_list, empty($keep_alive_flg) ? REQUEST_URI__KEEP_ALIVE_FLG__OFF : REQUEST_URI__KEEP_ALIVE_FLG__ON);
        return $url;
    }
}

// ------------------------------------------------------------------------

if (! function_exists('get_search_cond_url')) {

    /**
     * リクエスト元画面が検索画面の場合のリクエストURLを返す
     * ※戻るリンク用
     *
     * @param unknown $uri
     * @param unknown $param
     * @param string $keep_alive_flg
     * @return string
     */
    function get_search_cond_url($uri, $param = array(), $keep_alive_flg = REQUEST_URI__KEEP_ALIVE_FLG__OFF) {
        $CI = &get_instance();

        $param_list = array();
        // セッションから検索条件を取得
        $param_list = $CI->session->userdata(SESS_KEY__SEARCH_CONDITION__KEY);

        if (empty($param_list)) {
            $param_list = array();
        }

        $param_list = array_merge($param_list, $param);

        // URLを取得
        $url = get_url_view($uri, $param_list, empty($keep_alive_flg) ? REQUEST_URI__KEEP_ALIVE_FLG__OFF : REQUEST_URI__KEEP_ALIVE_FLG__ON);
        return $url;
    }
}

// ------------------------------------------------------------------------

if (! function_exists('save_view_data')) {
    /**
     * 指定データをフラッシュデータにセーブする
     *
     * @param unknown $data
     * @return string データロード時に使用するトークン
     */
    function save_view_data($data) {
        // 配列以外は保存しない
        if (! is_array($data)) {
            return '';
        }

        $CI = &get_instance();
        $CI->load->library('Session');

        // フラッシュデータに保存する
        switch ($CI->app_name){
            case APPLICATION_NAME__ADMIN:
                $CI->session->set_flashdata(FLASH_KEY__ADMIN_VIEW__DATA, $data);
                break;
            case APPLICATION_NAME__WEB:
                $CI->session->set_flashdata(FLASH_KEY__VIEW__DATA, $data);
                break;
            default:
                break;
        }

        // cookieにワンタイムトークンを保存してトークンを返す
        return $CI->security->csrf_set_cookie()->get_csrf_hash();
    }
}
// ------------------------------------------------------------------------

if (! function_exists('load_view_data')) {
    /**
     * フラッシュデータからデータをロードする
     *
     * @param unknown $token
     * @return multitype:|unknown
     */
    function load_view_data($token) {
        // トークンの指定なしは空配列を返す
        if (empty($token)) {
            return array();
        }

        $CI = &get_instance();
        $CI->load->library('Session');

        // ********** CSRFチェックのために一時的にPOSTに偽装 ********** //
        // 一時保管
        $wk_method = $_SERVER['REQUEST_METHOD'];
        // 強制的にPOSTに変更
        $_SERVER['REQUEST_METHOD'] = 'POST';
        // POST値にワンタイムトークンをセット
        $_POST[$CI->security->get_csrf_token_name()] = $token;
        // CSRFチェック
        // ※エラーの場合はshow_error()がコールされるため、戻り値はチェックしない
        $CI->security->csrf_verify();
        // 元に戻す
        $_SERVER['REQUEST_METHOD'] = $wk_method;
        // ************************************************************ //

        // フラッシュデータからロードする
        switch ($CI->app_name){
            case APPLICATION_NAME__ADMIN:
                $data = $CI->session->flashdata(FLASH_KEY__ADMIN_VIEW__DATA);
                break;
            case APPLICATION_NAME__WEB:
                $data = $CI->session->flashdata(FLASH_KEY__VIEW__DATA);
                break;
            default:
                break;
        }
        return $data;
    }
}
// ------------------------------------------------------------------------

if (! function_exists('keep_view_data')) {
    /**
     * フラッシュデータを延命する
     */
    function keep_view_data() {
        $CI = &get_instance();
        $CI->load->library('Session');

        // フラッシュデータから延命する
        switch ($CI->app_name){
            case APPLICATION_NAME__ADMIN:
                $CI->session->keep_flashdata(FLASH_KEY__ADMIN_VIEW__DATA);
                break;
            case APPLICATION_NAME__WEB:
                $CI->session->keep_flashdata(FLASH_KEY__VIEW__DATA);
                break;
            default:
                break;
        }

        // 延命時は最新のハッシュを返却する
        return $CI->security->get_csrf_hash();
    }
}

// ------------------------------------------------------------------------

if (! function_exists('get_token')) {
    /**
     * 32文字のトークンを取得する
     * ※CSRFのハッシュと同じロジックを使用
     */
    function get_token() {
        $CI = get_instance();

        // CSRFのハッシュと同じロジックを使用して生成
        // ※Securityクラスの_csrf_set_hash()
        $rand = $CI->security->get_random_bytes(16);
        return ($rand === FALSE) ? md5(uniqid(mt_rand(), TRUE)) : bin2hex($rand);
    }
}

// ------------------------------------------------------------------------
if (! function_exists('concat_date_value')) {
    /**
     * 指定したキー、フォーマットで日付文字列をPOSTに追加する
     *
     * @param unknown $key
     * @param unknown $y
     * @param unknown $m
     * @param unknown $d
     * @param string $h
     * @param string $i
     * @param string $s
     */
    function add_post_concat_date_value($key, $y, $m, $d, $h = '', $i = '', $s = '') {
        $date = '';

        // 年月日が指定されている
        if (! empty($y) && ! empty($m) && ! empty($d)) {
            $date = $y . '-' . $m . '-' . $d;
            // 時分秒が指定されている
            if (! empty($h) || ! empty($i) || ! empty($s)) {
                $date .= ' ' . $h . ':' . $i . ':' . $s;
            } else {
                $date .= ' 00:00:00';
            }
        }

        // POSTにキーが存在しない場合は連結した日付文字列を格納
        $_POST[$key] = array_key_exists($key, $_POST) ? $_POST[$key] : $date;
    }
}
// ------------------------------------------------------------------------
if (! function_exists('add_post_value')) {
    /**
     * 指定したキーで文字列をPOSTに追加する
     *
     * @param unknown $key
     * @param unknown $value1
     * @param unknown $value2
     * @param unknown $connect
     */
    function add_post_value($key, $value) {
        $_POST[$key] = $value;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('set_post_value_list')) {
    /**
     * 指定したキーで文字列をPOSTに追加する
     * @param unknown $value
     */
    function set_post_value_list($value){
        // POST値のクリア
        $_POST = array();

        // 配列じゃない場合は配列に変換
        if (!is_array($value)){
            $value = array('param' => $value);
        }

        // POST値に値をセット
        foreach ($value as $key => $data){
            $_POST[$key] = $data;
        }
        
        // リクエストパラメータのJSON内にuser_idが存在しない場合は0で追加する
        if (empty($_POST['user_id'])){
            $_POST['user_id'] = 0;
        }
    }
}

// ------------------------------------------------------------------------
if (! function_exists('add_post_concat_2_value')) {
    /**
     * 指定したキー、接続語で2つの変数を合体する
     *
     * @param unknown $key
     * @param unknown $value1
     * @param unknown $value2
     * @param unknown $connect
     */
    function add_post_concat_2_value($key, $value1, $value2, $connect) {
        $value_all = '';

        // 両方が存在する
        if (! empty($value1) && ! empty($value2)) {
            $_POST[$key] = $value1 . $connect . $value2;
        }

        // POSTにキーが存在しない場合は連結した文字列を格納
        $_POST[$key] = array_key_exists($key, $_POST) ? $_POST[$key] : $value_all;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('search_str_by_array')) {
    /**
     * 文字列に対して文字列検索する
     * ※複数指定可
     *
     * @param unknown $target_str
     * @param unknown $serch_list
     * @return boolean
     */
    function search_str_by_array($target_str, $serch_list) {
        // 検索リストを順に検索
        foreach ( $serch_list as $val ) {
            // パターン文字列生成
            $pattern = '/' . preg_quote($val, '/') . '/i';
            // 検索
            if (preg_match($pattern, $str)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('set_param_array')) {
    /**
     * 配列の値の有無をチェック
     *
     * @param unknown $param_list
     */
    function check_param_array($param_list) {
        $param_array = "";
        foreach ( $param_list as $key => $value ) {
            if (! empty($value)) {
                $param_array[$key] = $value;
            }
        }
        return $param_array;
    }
}
// ------------------------------------------------------------------------
if (! function_exists('set_param_array')) {
    /**
     * パラメータで配列を生成
     *
     * @param unknown $key
     * @param unknown $param_list
     */
    function set_param_array($keys, $param_list) {
        $param_array = "";
        if (! empty($param_list)) {
            foreach ( $param_list as $list ) {
                if (! empty($list)) {
                    $param_array[] = $list;
                }
            }
        }
        $_POST[$keys] = $param_array;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('get_line_csv')) {
    /**
     * CSVファイルから1行取得する
     *
     * @param unknown $fp
     * @param number $row_count
     * @return multitype:
     */
    function get_line_csv($fp, $row_count = 0) {
        $line = array();

        // ファイルポインタチェック
        if (empty($fp)) {
            return $line;
        }

        // 1行取得※空行と指定カラムがない場合はスキップして次の行を取得する
        while (($row = fgetcsv($fp)) !== FALSE){
            // 空行はスキップ
            if ($row === array(null)) {
                continue;
            }
            // カラム数チェック
            if ($row_count != 0) {
                if (count($row) !== $row_count) {
                    continue;
                }
            }

            // 1行取得
            $line = $row;
            break;
        }

        return $line;
    }
}

// ------------------------------------------------------------------------
if (! function_exists('get_ci_class_methods')) {
    /**
     * 指定したクラス名のインスタンス関数一覧を取得する
     * @param unknown $class_name
     * @return unknown[]
     */
    function get_ci_class_methods($class_name) {
        $result = array();
        
        // CIオブジェクトにロードしたオブジェクトのインスタンス関数一覧を取得する
        $CI = get_instance();
        $method_list = get_class_methods(get_class($CI->$class_name));
        foreach ($method_list as $method){
            // 関数名を分解して最後が数字かチェック
            $split_data = explode('_', $method);
            // 分解した最後(API ID)を取得する
            $api_id = $split_data[count($split_data)-1];
            if (!is_numeric($api_id)){
                // 数値でない場合はスキップ
                continue;
            }
            // API IDを持つ関数だけをリストアップする
            $result[$api_id] = $method;
        }
        return $result;
    }
}