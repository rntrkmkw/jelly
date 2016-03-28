<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

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
define('APPLICATION_RUNNNING_MODE__DEFAULT', 0);
define('APPLICATION_RUNNNING_MODE__DEBUG', 1);
define('APPLICATION_RUNNNING_MODE__LOAD_TEST', 2);

/*
 |--------------------------------------------------------------------------
 | アプリケーション名の設定
 |--------------------------------------------------------------------------
 */
define('APPLICATION_NAME__ADMIN',                   'admin');       // 管理画面
define('APPLICATION_NAME__API',                       'api');       // WebAPI
define('APPLICATION_NAME__BATCH',                   'batch');       // バッチ
define('APPLICATION_NAME__WEB',                       'web');       // WEBアプリ

/*
 |--------------------------------------------------------------------------
 | SESSIONデータキーの固定値の定義
 |--------------------------------------------------------------------------
 |
 | ■記述ルール
 |   ・全て大文字で名前をつける
 |   ・「SESS_KEY__機能名__パラメータ名」で名前をつける
 |
 */
/******* システム関連 *******/
define('SESS_KEY__SYSTEM__CSRF_TOKEN',        'system__csrf_token');       // CSRFトークン

/******* ログイン関連 *******/
define('SESS_KEY__LOGIN__LOGIN',                           'login');       // ログイン情報
define('SESS_KEY__LOGIN__USER_ATTR',                   'user_attr');       // ユーザ属性
define('SESS_KEY__LOGIN__INFO',                             'info');       // ログインユーザ属性

/******* フラッシュデータ関連 *******/
define('FLASH_KEY__REQUEST__DATA',                'f_request_data');       // リクエスト情報
define('FLASH_KEY__VIEW__DATA',                      'f_view_data');       // ビュー情報

/******* ログイン関連 *******/
define('SESS_KEY__ADMIN_LOGIN__LOGIN',               'admin_login');       // 管理画面ログイン情報
define('SESS_KEY__ADMIN_LOGIN__INFO',                 'admin_info');       // 管理画面ログインユーザ情報

/******* フラッシュデータ関連 *******/
define('FLASH_KEY__ADMIN_REQUEST__DATA',    'f_admin_request_data');       // リクエスト情報
define('FLASH_KEY__ADMIN_VIEW__DATA',          'f_admin_view_data');       // ビュー情報

/******* 検索条件保持用 *******/
define('SESS_KEY__SEARCH_CONDITION__KEY',   'search_condition_key');       // 検索条件情報
/*
 |--------------------------------------------------------------------------
 | COOKIEデータキーの固定値の定義
 |--------------------------------------------------------------------------
 |
 | ■記述ルール
 |   ・全て大文字で名前をつける
 |   ・「COOKIE_KEY__機能名__パラメータ名」で名前をつける
 |
 */
/******* ログイン関連 *******/
define('COOKIE_KEY__LOGIN__ADMIN_LOGIN_ID',         'admin_login_id');      // 管理者ログインID

/******* 有効期間タイプ *******/
define('COOKIE__VALIDATION_PERIOD_TYPE__HOUR_1',          0);       // 1時間
define('COOKIE__VALIDATION_PERIOD_TYPE__DAY_1',           1);       // 1日
define('COOKIE__VALIDATION_PERIOD_TYPE__DAY_7',           2);       // 7日
define('COOKIE__VALIDATION_PERIOD_TYPE__DAY_30',          3);       // 30日

/******* 有効期間 *******/
define('COOKIE__VALIDATION_PERIOD__HOUR_1',            3600);       // 1時間(60 * 60)
define('COOKIE__VALIDATION_PERIOD__DAY_1',            86400);       // 1日(60 * 60 * 24)
define('COOKIE__VALIDATION_PERIOD__DAY_7',           604800);       // 7日(60 * 60 * 24 * 7)
define('COOKIE__VALIDATION_PERIOD__DAY_30',         2592000);       // 30日(60 * 60 * 24 * 30)

/*
 |--------------------------------------------------------------------------
 | 各機能で使用する設定
 |--------------------------------------------------------------------------
 |
 | ■記述ルール
 |   ・全て大文字で名前をつける
 |   ・「機能名__項目名__値」で名前をつける
 */
// API処理最大数
define('COMMON__EXEC_API__MAX_COUNT',                   5);                 // API処理最大数

// チェック ON/OFF （DBの削除フラグなどでも使用可）
define('COMMON__FLAG__OFF',                             0);                 // OFF
define('COMMON__FLAG__ON',                              1);                 // ON

// 日付の初期値
define('COMMON__DATETIME__DEFAULT_DATE',     '0000-00-00');
define('COMMON__DATETIME__DEFAULT_TIME',       '00:00:00');
// トークンのキー名
define('COMMON__VIEW_DATA__TOKEN',                'token');                 // キー名

// デフォルトページ件数
define('COMMON__PAGE_PER_UNIT__DEFAULT',               10);                 // デフォルトページ件数

// ログイン
define('LOGIN__STATUS__SUCCESS',                        0);                 // ログイン成功

// 表示モード
define('CTRL__MODE__INITIAL_VIEW',                      0);                 // 初期表示
define('CTRL__MODE__EXEC_NORMAL',                       1);                 // 実行（コントローラ内で処理の分岐に使用）
define('CTRL__MODE__EXEC_REGIST',                       2);                 // 登録
define('CTRL__MODE__EXEC_UPDATE',                       3);                 // 更新
define('CTRL__MODE__EXEC_DELETE',                       4);                 // 削除
define('CTRL__MODE__EXEC_COMPLETE',                     5);                 // 完了
define('CTRL__MODE__EXEC_BACK',                         6);                 // 戻る
define('CTRL__MODE__EXEC_FUNC_01',                    100);                 // その他処理1
define('CTRL__MODE__EXEC_FUNC_02',                    101);                 // その他処理2
define('CTRL__MODE__EXEC_FUNC_03',                    102);                 // その他処理3
define('CTRL__MODE__EXEC_FUNC_04',                    103);                 // その他処理4
define('CTRL__MODE__EXEC_FUNC_05',                    104);                 // その他処理5
define('CTRL__MODE__EXEC_FUNC_06',                    105);                 // その他処理6
define('CTRL__MODE__EXEC_FUNC_07',                    106);                 // その他処理7
define('CTRL__MODE__EXEC_FUNC_08',                    107);                 // その他処理8
define('CTRL__MODE__EXEC_FUNC_09',                    108);                 // その他処理9
define('CTRL__MODE__EXEC_FUNC_10',                    109);                 // その他処理10

// 管理画面アカウント管理
//DB更新ステータス
define('COMMON__DB_STATUS__NORMAL',                     0);                 // 正常
define('COMMON__DB_STATUS__DATA_EXISTED',               1);                 // 登録済みデータ
define('COMMON__DB_STATUS__ERROR_INSERT',               2);                 // 登録失敗
define('COMMON__DB_STATUS__ERROR_UPDATE',               3);                 // 更新失敗
define('COMMON__DB_STATUS__ERROR_DELETE',               4);                 // 削除失敗
define('COMMON__DB_STATUS__ERROR_SELECT',               5);                 // 参照失敗

// 共通使用可能文字列
define('COMMON__ENABLE_STRING__ALPHA_UPPER',            'ABCDEFGHIJKLMNOPQRSTUVWXYZ');      // アルファベット大文字
define('COMMON__ENABLE_STRING__ALPHA_LOWER',            'abcdefghijklmnopqrstuvwxyz');      // アルファベット小文字
define('COMMON__ENABLE_STRING__NUMBER',                 '1234567890');                      // 数値
define('COMMON__ENABLE_STRING__SYMBOL_VIEW',        '!"#$%&()=~|-^@[;:],./`{+*}<>?_');      // 記号※表示用
define('COMMON__ENABLE_STRING__SYMBOL',      COMMON__ENABLE_STRING__SYMBOL_VIEW. ' ');      // 記号※空白含む
define('COMMON__ENABLE_STRING__HIRAGANA_A',                             'あいうえお');      // あ行
define('COMMON__ENABLE_STRING__HIRAGANA_KA',                            'かきくけこ');      // か行
define('COMMON__ENABLE_STRING__HIRAGANA_SA',                            'さしすせそ');      // さ行
define('COMMON__ENABLE_STRING__HIRAGANA_TA',                            'たちつてと');      // た行
define('COMMON__ENABLE_STRING__HIRAGANA_NA',                            'なにぬねの');      // な行
define('COMMON__ENABLE_STRING__HIRAGANA_HA',                            'はひふへほ');      // は行
define('COMMON__ENABLE_STRING__HIRAGANA_MA',                            'まみむめも');      // ま行
define('COMMON__ENABLE_STRING__HIRAGANA_YA',                                'やゆよ');      // や行
define('COMMON__ENABLE_STRING__HIRAGANA_YA_5',                            'や ゆ よ');      // や行※区切り文字含む
define('COMMON__ENABLE_STRING__HIRAGANA_RA',                            'らりるれろ');      // ら行
define('COMMON__ENABLE_STRING__HIRAGANA_WA',                                'わをん');      // わ行
define('COMMON__ENABLE_STRING__HIRAGANA_WA_5',                            'わ を ん');      // わ行※区切り文字含む
define('COMMON__ENABLE_STRING__OTHER',                                          '他');      // その他※50音と組み合わせ
define('COMMON__ENABLE_STRING__HIRAGANA_46',    COMMON__ENABLE_STRING__HIRAGANA_A.  COMMON__ENABLE_STRING__HIRAGANA_KA.
                                                COMMON__ENABLE_STRING__HIRAGANA_SA. COMMON__ENABLE_STRING__HIRAGANA_TA.
                                                COMMON__ENABLE_STRING__HIRAGANA_NA. COMMON__ENABLE_STRING__HIRAGANA_HA.
                                                COMMON__ENABLE_STRING__HIRAGANA_MA. COMMON__ENABLE_STRING__HIRAGANA_YA.
                                                COMMON__ENABLE_STRING__HIRAGANA_RA. COMMON__ENABLE_STRING__HIRAGANA_WA);    // 50音
define('COMMON__ENABLE_STRING__HIRAGANA_50',    COMMON__ENABLE_STRING__HIRAGANA_A.  COMMON__ENABLE_STRING__HIRAGANA_KA.
                                                COMMON__ENABLE_STRING__HIRAGANA_SA. COMMON__ENABLE_STRING__HIRAGANA_TA.
                                                COMMON__ENABLE_STRING__HIRAGANA_NA. COMMON__ENABLE_STRING__HIRAGANA_HA.
                                                COMMON__ENABLE_STRING__HIRAGANA_MA. COMMON__ENABLE_STRING__HIRAGANA_YA_5.
                                                COMMON__ENABLE_STRING__HIRAGANA_RA. COMMON__ENABLE_STRING__HIRAGANA_WA_5);  // 50音
define('COMMON__ENABLE_STRING__HIRAGANA_50_1',  COMMON__ENABLE_STRING__HIRAGANA_A.  COMMON__ENABLE_STRING__HIRAGANA_KA.
                                                COMMON__ENABLE_STRING__HIRAGANA_SA. COMMON__ENABLE_STRING__HIRAGANA_TA.
                                                COMMON__ENABLE_STRING__HIRAGANA_NA. COMMON__ENABLE_STRING__HIRAGANA_HA.
                                                COMMON__ENABLE_STRING__HIRAGANA_MA. COMMON__ENABLE_STRING__HIRAGANA_YA_5.
                                                COMMON__ENABLE_STRING__HIRAGANA_RA. COMMON__ENABLE_STRING__HIRAGANA_WA.
                                                ' '.                                COMMON__ENABLE_STRING__OTHER);          // 50音+他

// 共通文字数
define('COMMON__PASSWORD_COUNT__MIN',                   8);                 // パスワード最小文字数
define('COMMON__PASSWORD_COUNT__MAX',                  20);                 // パスワード最大文字数
define('COMMON__TOKEN_COUNT__COUNT',                   32);                 // トークン文字数

//リクエストURIデータの延命フラグ[0：延命しない、1：延命する]
define('REQUEST_URI__KEEP_ALIVE_FLG__OFF',              0);                 // OFF
define('REQUEST_URI__KEEP_ALIVE_FLG__ON',               1);                 // ON

/*
 |--------------------------------------------------------------------------
 | DBデータの固定値の定義
 |--------------------------------------------------------------------------
 |
 | ■記述ルール
 |   ・全て大文字で名前をつける
 |   ・「テーブル名__カラム名__値」で名前をつける
 |
 */
 /***** T_user_model *****/
define('T_USER__OS_TYPE__IOS',                          0);                 // iOS
define('T_USER__OS_TYPE__ANDROID',                      1);                 // Android
define('T_USER__LANGUAGE__JP',                          0);                 // 日本語
define('T_USER__LANGUAGE__EN',                          1);                 // 英語
define('T_USER__STATUS__VALID',                         0);                 // 有効
define('T_USER__STATUS__DELETE',                        9);                 // 削除
 /***** T_stage_model *****/
define('T_STAGE__STATUS__DEFAULT',                      0);                 // 未トライ
define('T_STAGE__STATUS__TRYING',                       1);                 // トライ中
define('T_STAGE__STATUS__CLEARED',                      2);                 // クリア済
define('T_STAGE__SCORE__DEFAULT',                       0);                 // 0点
define('T_STAGE__RANK__DEFAULT',                        0);                 // 評価0
define('T_STAGE__M_STAGE_ID__DEFAULT',                  1);                 // 初回ステージID
 /***** T_event_stage_model *****/
define('T_EVENT_STAGE__STATUS__FAILED',                 0);                 // クリア失敗
define('T_EVENT_STAGE__STATUS__SUCCESS',                1);                 // クリア成功
 /***** M_stage_jelly_model *****/
define('M_STAGE_JELLY__TYPE__OBSTACLE',                 0);                 // 障害物
define('M_STAGE_JELLY__TYPE__MAIN',                     1);                 // ユーザが動かすゼリー
define('M_STAGE_JELLY__TYPE__DEAD',                     2);                 // 不動ゼリー
define('M_STAGE_JELLY__TYPE__GOAL_FOR_DEAD',            3);                 // 不動ゼリーのゴール
define('M_STAGE_JELLY__TYPE__LINKED',                   4);                 // 連動ゼリー
define('M_STAGE_JELLY__TYPE__GOAL_FOR_LINKED',          5);                 // 連動ゼリーのゴール
 /***** M_item_model *****/
define('M_ITEM__ID__FREE_GOLD',                         0);                 // 無償ゴールド
 /***** M_event_reward_model *****/
define('M_EVENT_REWARD__PRIORITY__MIN',                 0);                 // 最低報酬
define('M_EVENT_REWARD__PRIORITY__MAX',                 9);                 // キング滞在最高報酬


/*
 |--------------------------------------------------------------------------
 | エラーコードの定義
 |--------------------------------------------------------------------------
 |
 | ■記述ルール
 |   ・全て大文字で名前をつける
 |   ・「ERROR__カテゴリ__チェック内容」で名前をつける
 |
 */
/***** 共通エラーステータス *****/
define('ERROR__RESPONSE_STATUS__SUCCESS',           '0');  // 成功
define('ERROR__RESPONSE_STATUS__ERROR',             '1');  // エラー

/***** 共通エラー *****/
define('ERROR__VALIDATION',                         '1');  // バリデーションチェック
define('ERROR__DB_DATA_NOTHING',                    '2');  // DBデータなし
define('ERROR__CONSISTENCY',                        '3');  // 整合性チェック
define('ERROR__DB_DATA_UPDATE',                     '4');  // DB更新エラー
define('ERROR__NG_WORD',                            '5');  // 禁止文字チェック
define('ERROR__DUPLICATE_DATA',                     '6');  // 重複データチェック
define('ERROR__REQUEST_DATA_INVALID',               '7');  // リクエストデータ不正
define('ERROR__TOKEN_VERIFY_CHECK',                 '8');  // トークン認証エラー 
define('ERROR__TRANSACTION_ROLLBACK',               '9');  // トランザクションロールバック 

/*
 |--------------------------------------------------------------------------
 | 機能固有の固定値の定義
 |--------------------------------------------------------------------------
 |
 | ■記述ルール
 |   ・全て大文字で名前をつける
 |   ・「機能名__項目名__値」で名前をつける
 |
 */
