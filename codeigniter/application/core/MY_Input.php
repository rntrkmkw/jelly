<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Input extends CI_Input {
    // --------------------------------------------------------------------
    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------
    /**
     * Inputクラスのラッパー関数
     *
     * @param string $index
     *            item to be fetched from $_POST or $_GET
     * @param bool $xss_clean
     *            apply XSS filtering
     * @return mixed
     */
    public function post_get($index, $xss_clean = NULL) {
        // 継承元を実行
        $param = parent::post_get($index, $xss_clean);

        // GETパラメータから取得した場合は取得した値をPOSTパラメータにセット
        if ((isset($param)) && (!isset($_POST[$index]))) {
            $_POST[$index] = $param;
        }
        return $param;
    }

    // --------------------------------------------------------------------
}
