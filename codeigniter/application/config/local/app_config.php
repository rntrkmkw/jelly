<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 記述例
//$config['social_top'] = base_url();

/*
|--------------------------------------------------------------------------
| アプリケーションの稼働モード設定
|--------------------------------------------------------------------------
| アプリケーションの稼働モード設定を行う
|	0: 通常稼働
|	1: デバッグ
|	2: 負荷テスト
|	3:
*/
$config['app_exec_mode'] = APPLICATION_RUNNNING_MODE__DEBUG;

/*
 |--------------------------------------------------------------------------
 | アプリケーションキー設定
 |--------------------------------------------------------------------------
 */
$config['app_key'] = 'W37XdaHP62JCgY3fduyDagtCVwHsYyLE';

/*
 |--------------------------------------------------------------------------
 | テスト用パラメータ設定
 |--------------------------------------------------------------------------
 */
// 共通パラメータ
$common_params = array(
    'app_key' => $config['app_key'],        // アプリケーションキー
    'language' => T_USER__LANGUAGE__JP,     // 言語
    'token'    => '',                       // 認証トークン
    'device_id'  => 2                       // デバイスID
);
// レシート(ダミー文字列)
$receipt = '';
for($i = 0;$i < 16;$i++){
    $int = rand(0,9);
    $receipt .= $int;
}
$config['test_params'] = array(
    // S_TOKEN_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J2000'
    ),
    // T_USER_REGIST
    array(
        'app_key'      => $common_params['app_key'], 
        'language'     => $common_params['language'], 
        'token'        => $common_params['token'],
        'api_id'       => 'J0100',
        'app_ver'      => '1.0.0', 
        'os_type'      => T_USER__OS_TYPE__IOS, 
        'os_ver'       => '8.1.2', 
        'uiid'         => 'versiontest',
        'device_ver'   => 'versiontest',
        'device_token' => 'versiontest'
    ),
    // T_USER_LOGIN
    array(
        'app_key'     => $common_params['app_key'], 
        'language'    => $common_params['language'], 
        'token'       => $common_params['token'],
        'device_id'   => $common_params['device_id'],
        'api_id'      => 'J0101',
        'name'        => 'friendregisttest',
        'image_url'   => '/friendregist/test.img',
        'auth_token'  => 'friendregisttest',
        'secret_key'  => 'friendregisttest',
        'facebook_id' => 'friendregisttest'
    ),
    // T_USER_LOGOUT
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0102'
    ),
    // T_USER_PLAYING_STAGE_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0103',
        'user_id'   => 1
    ),
    // T_USER_MESSAGE_LIST_GET
    array(
        'app_key'     => $common_params['app_key'], 
        'language'    => $common_params['language'], 
        'token'       => $common_params['token'],
        'device_id'   => $common_params['device_id'],
        'api_id'      => 'J0104',
        'user_id'     => 29
    ),
    //// T_USER_MESSAGE_REGIST
    array(
        'app_key'      => $common_params['app_key'], 
        'language'     => $common_params['language'], 
        'token'        => $common_params['token'],
        'device_id'    => $common_params['device_id'],
        'api_id'       => 'J0105',
        'user_id'      => 29,
        'facebook_ids' => array('logintest', 'transactiontest', 'emptytest', 'paramsmoditest')
    ),
    // T_USER_NOTICE_LIST_GET
    array(
        'app_key'     => $common_params['app_key'], 
        'language'    => $common_params['language'], 
        'token'       => $common_params['token'],
        'device_id'   => $common_params['device_id'],
        'api_id'      => 'J0106'
    ),
    // T_FRIEND_DATA_UPDATE
    array(
        'app_key'      => $common_params['app_key'], 
        'language'     => $common_params['language'], 
        'token'        => $common_params['token'],
        'device_id'    => $common_params['device_id'],
        'api_id'       => 'J0200',
        'user_id'      => 29,
        'facebook_ids' => array('logintest', 'transactiontest', 'emptytest', 'paramsmoditest')
    ),
    // T_STAGE_DATA_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0300',
        'user_id'   => 1,
        'stage_id'  => 1
    ),
    // T_STAGE_SCORE_UPDATE
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0301',
        'user_id'   => 1,
        'stage_id'  => 3,
        'status'    => 2,
        'score'     => 1000000,
        'rank'      => 3
    ),
    // T_STAGE_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0302',
        'user_id'   => 1,
        'map_id'    => 1
    ),
    // T_GOLD_DATA_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'user_id'   => 1,
        'api_id'    => 'J0400' 
    ),
    // T_GOLD_PURCHASE_UPDATE
    array(
        'app_key'    => $common_params['app_key'], 
        'language'   => $common_params['language'], 
        'token'      => $common_params['token'],
        'device_id'  => $common_params['device_id'],
        'api_id'     => 'J0401',
        'os_type'    => T_USER__OS_TYPE__IOS,
        'product_id' => 'aaaaaaaaa',
        'receipt'    => $receipt
    ),
    // T_ITEM_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0500',
        'user_id'   => 1
    ),
    // T_ITEM_ADD_UPDATE
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0501',
        'user_id'   => 1,
        'item_id'   => 1
    ),
    // T_ITEM_CONSUME_UPDATE
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J0502',
        'user_id'   => 1,
        'item_id'   => 1
    ),
    // T_ITEM_PURCHASE_UPDATE
    array(
        'app_key'       => $common_params['app_key'], 
        'language'      => $common_params['language'], 
        'token'         => $common_params['token'],
        'device_id'     => $common_params['device_id'],
        'api_id'        => 'J0503',
        'user_id'       => 1,
        'item_price_id' => 1
    ),
    // T_EVENT_STAGE_DATA_GET
    array(
        'app_key'         => $common_params['app_key'], 
        'language'        => $common_params['language'], 
        'token'           => $common_params['token'],
        'device_id'       => $common_params['device_id'],
        'api_id'          => 'J0600',
        'user_id'         => 2,
        'event_member_id' => 1
    ),
    // T_EVENT_STAGE_DATA_UPDATE
    array(
        'app_key'         => $common_params['app_key'], 
        'language'        => $common_params['language'], 
        'token'           => $common_params['token'],
        'device_id'       => $common_params['device_id'],
        'api_id'          => 'J0601',
        'user_id'         => 2,
        'event_id'        => 1,
        'event_member_id' => 1,
        'event_stage_id'  => 5,
        'm_stage_id'      => 5,
        'status'          => 1
    ),
    // M_GOLD_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1000',
        'os_type'   => T_USER__OS_TYPE__IOS 
    ),
    // M_ITEM_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1001'
    ),
    // M_NOTICE_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1002'
    ),
    // M_MAP_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1003'
    ),
    // M_STAGE_MAP_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1004',
        'stage_id'  => 1
    ),
    // M_STAGE_LIST_SAME_MAP_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1005',
        'stage_id'  => 1
    ),
    // M_STAGE_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1006',
        'map_id'    => 1
    ),
    // M_STAGE_DETAIL_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1007',
        'stage_id'  => 1
    ),
    // M_STAGE_GAME_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1008',
        'stage_id'  => 1
    ),
    // M_VERSION_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J1009'
    ),
    // M_EVENT_LIST_GET
    array(
        'app_key'   => $common_params['app_key'], 
        'language'  => $common_params['language'], 
        'token'     => $common_params['token'],
        'device_id' => $common_params['device_id'],
        'api_id'    => 'J5000',
        'user_id'   => 5
    )
);
