<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Security extends CI_Security {

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct() {

        // 管理画面の場合はCSRF用のトークンキーとクッキーのキーを書き換える
        // ※親クラスのコンストラクタコール前に書き換える
        if (defined('ADMIN_DEF')){
            get_config(array('csrf_token_name' => 'csrf_admin_token', 'csrf_cookie_name' =>'csrf_admin_cookie'));
        }

        parent::__construct();

        // Set the CSRF hash
        $this->_csrf_set_hash();
    }
}
