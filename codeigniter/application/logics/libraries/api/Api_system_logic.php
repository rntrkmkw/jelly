<?php
require_once APPPATH.'logics/libraries/api/Api_logic.php';

/**
 * Apiシステムロジック
 *
 * @author kamikawa
 */
class Api_system_logic extends Api_logic {

    function __construct(){
        parent:: __construct();
    }

    /**
     * ApiID 2000
     * 認証トークン取得ロジック
     *
     * @param Array $params 
     * @author kamikawa
     */
    function s_token_get_2000($params) {

        $result = array();

        $result['token'] = $this->CI->security->get_csrf_hash();

        return $result;
    }
}
