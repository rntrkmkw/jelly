<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * |--------------------------------------------------------------------------
 * | Email送信用設定ファイル
 * |--------------------------------------------------------------------------
 * |
 * | 以下のURLに載っている本家サイトのマニュアルに沿った内容を設定していく
 * |
 * | http://www.codeigniter.com/user_guide/libraries/email.html#email-preferences
 * |
 * |
 */
$config['useragent'] = 'CodeIgniter';                                                   // The “user agent”.
$config['protocol'] = 'mail';                                                       // The mail sending protocol.
$config['mailpath'] = 'C:\work\app\Eclipse\pleiades\xampp\mailtodisk\mailtodisk.exe';   // The server path to Sendmail.
$config['smtp_host'] = '';                                                              // SMTP Server Address.
$config['smtp_user'] = '';                                                              // SMTP Username.
$config['smtp_pass'] = '';                                                              // SMTP Password.
$config['smtp_port'] = 25;                                                              // SMTP Port.
$config['smtp_timeout'] = 5;                                                            // SMTP Timeout (in seconds).
$config['smtp_keepalive'] = FALSE;                                                      // Enable persistent SMTP connections.
$config['smtp_crypto'] = 'tls';                                                         // tls or ssl SMTP Encryption
$config['wordwrap'] = TRUE;                                                             // Enable word-wrap.
$config['wrapchars'] = 76;                                                              // Character count to wrap at.
$config['mailtype'] = 'text';                                                           // Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don’t have any relative links or relative image paths otherwise they will not work.
$config['charset'] = 'utf-8';                                                           // Character set (utf-8, iso-8859-1, etc.).
$config['validate'] = FALSE;                                                            // Whether to validate the email address.
$config['priority'] = 3;                                                                // Email Priority. 1 = highest. 5 = lowest. 3 = normal.
$config['crlf'] = "\n";                                                                 // Newline character. (Use “\r\n” to comply with RFC 822).
$config['newline'] = "\n";                                                              // Newline character. (Use “\r\n” to comply with RFC 822).
$config['bcc_batch_mode'] = FALSE;                                                      // Enable BCC Batch Mode.
$config['bcc_batch_size'] = 200;                                                        // Number of emails in each BCC batch.
$config['dsn'] = FALSE;                                                                 // Enable notify message from server
