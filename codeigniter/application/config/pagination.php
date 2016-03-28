<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| ページネーションリンク作成用設定ファイル
|--------------------------------------------------------------------------
|
| 以下のURLに載っている本家サイトのマニュアルに沿った内容を設定していく
|
|	http://www.codeigniter.com/user_guide/libraries/pagination.html#pagination-class
|
|
*/

$config['page_query_string'] = TRUE;

// オフセット値(または、ページ番号)を示すGETクエリ文字列を設定します。
$config['query_string_segment'] = 'page';

// オフセット値の代わりにページ番号がURIパスに付加されます。
$config['use_page_numbers'] = TRUE;

// 現在のページ番号の左右にいくつのページ番号リンクを生成するか設定します。
$config['num_links'] = 5;

// ページネーションリンクの「<a>」アンカータグに「clsas=」属性を設定します。
$config['anchor_class'] = 'page-link';

// ページネーションリンク全体を階層化するHTMLタグの閉じタグ文字列を指定します。
$config['full_tag_open'] = '<div id="pagenavi"><ul><li>';
$config['full_tag_close'] = '</li></ul></div>';

// 次へ・前へリンク指定
$config['next_link'] = '»';
$config['prev_link'] = '«';

// 最初へ・最後へリンク指定
$config['first_link'] = false;
$config['last_link'] = false;
