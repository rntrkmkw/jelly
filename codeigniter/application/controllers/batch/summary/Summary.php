<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/controllers/batch/Batch.php');

/**
 * サマリーバッチ親クラス
 * @author kamikawa
 *
*/
class Summary extends Batch {

    function __construct(){
        parent:: __construct();
    }
}
