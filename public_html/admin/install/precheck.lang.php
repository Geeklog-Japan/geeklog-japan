<?php

// +---------------------------------------------------------------------------+
// | Precheck for Geeklog 2.0                                                  |
// +---------------------------------------------------------------------------+
// | public_html/admin/install/precheck.lang.php                               |
// |                                                                           |
// | Part of Geeklog pre-installation check scripts                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2016 by the following authors:                         |
// |                                                                           |
// | Authors: mystral-kk - geeklog AT mystral-kk DOT net                       |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* This script tests the file and directory permissions, thus addressing the
* most common errors / omissions when setting up a new Geeklog site ...
*
* @author   mystral-kk <geeklog AT mystral-kk DOT net>
* @date     2016-02-06
* @version  1.4.7
* @license  GPLv2 or later
*/

if (stripos($_SERVER['PHP_SELF'], 'precheck.lang.php') !== false) {
    die('This file cannot be used on its own.');
}

$LANG_PRECHECK = array();

$LANG_PRECHECK['ja'] = array(
	'and'								=> 'と',
	'back'								=> '元のページに戻る',
	'back_hint'							=> 'JavaScriptをOffにしている場合は、ブラウザの「戻る」ボタンで戻ってください',
	'check_again'						=> 'チェックし直す',
	'check_path'						=> 'ディレクトリ・パスが書き込み可かどうかのチェック',
	'check_php_config'					=> 'PHPの設定チェック',
	'continue'							=> '続行する',
	'db_host'							=> 'データベースのホスト名',
	'db_name'							=> 'データベース名',
	'db_pass'							=> 'データベースのパスワード',
	'db_prefix'							=> 'データベースの接頭子',
	'db_type'							=> 'データベースの種類',
	'db_user'							=> 'データベースのユーザー名',
	
	'enabled'							=> '有効になっています',
	'error'								=> 'エラー',
	'e_access_log'						=> '<strong>非公開領域/logs/access.log</strong>が書き込み禁止になっています。',
	'e_backend'							=> '<strong>公開領域/backend</strong>が書き込み禁止になっています。',
	'e_backend_geeklog_rss'				=> '<strong>公開領域/backend/geeklog.rss</strong>が書き込み禁止になっています。',
	'e_backups'							=> '<strong>非公開領域/backups</strong>が書き込み禁止になっています。',
	'e_data'							=> '<strong>非公開領域/data</strong>が書き込み禁止になっています。',
	'e_database_disabled'				=> 'PHPにデータベースを利用する機能が組み込まれていません。',
	'e_database_unknown'                => 'データベースの種類が不正です。',
	'e_database_not_empty'				=> 'エラー：データベースが空ではありません!',
	'e_database_not_utf8'               => 'エラー：データベースの文字セットがutf8で作成されていません。「サーバー接続の照合順序」を <strong>utf8_general_ci</strong> か <strong>utf8mb4_general_ci</strong> に変更してから、データベースを作成してください。',
	'e_dbconfig_not_found'				=> 'db-config.php の場所がわかりません。',
	'e_db_config_php'					=> '<strong>非公開領域/db-config.php</strong>が書き込み禁止になっています。',
	'e_default_charset'					=> '<strong>default_charset</strong>に特定の文字セットが設定されているようです。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>\'\'</strong>(空文字列)か<strong>utf-8</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=default_charset">設定方法はこちら</a>]',
	'e_disabled'						=> '無効になっています',
	'e_error_log'						=> '<strong>非公開領域/logs/error.log</strong>が書き込み禁止になっています。',
	'e_fatal_error'						=> '致命的なエラーが見つかったため、インストールできません。表示されたエラーを解決してから、もう一度チェックし直してください。なお、警告の部分はとりあえず無視しても構いませんが、いったんインストールに成功したら、忘れずに修正してください。',
	'e_ini_get_disabled'				=> '<strong>ini_get()関数が無効になっているので、PHPの設定をチェックできませんでした。Webサーバーの管理者に依頼して、<strong>php.ini</strong>の<strong>disabled_functions</strong>の設定値から<strong>ini_get</strong>を除外するよう依頼してください。',
	'e_mbstring_disabled'				=> 'PHPにマルチバイト文字列関数(mbstring)が組み込まれていません。',
	'e_mbstring_encoding_translation'	=> '<strong>mbstring.encoding_translation</strong>が<strong>On</strong>になっています。文字化けやセキュリティ低下の原因になるので、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Off</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_encoding_translation">設定方法はこちら</a>]。',
	'e_mbstring_http_output'			=> '<strong>mbstring.http_output</strong>に特定の文字セットが設定されているようです。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>pass</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_http_output">設定方法はこちら</a>]。',
	'e_mbstring_language_others'		=> '<strong>mbstring.language</strong>に<strong>Japanese</strong>以外の言語が設定されているようです。文字化けの原因になるので、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Japanese</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_language">設定方法はこちら</a>]。',
	'e_mysql1'							=> 'MySQLのバージョン',
	'e_mysql2'							=> 'が低すぎます。最低でも',
	'e_mysql3'							=> 'が必要です。',
	'e_mysql_database_not_found'		=> 'データベースが作成されていません。phpMyAdminなどを利用して、データベースを作成してください。',
	'e_php_version1'					=> 'PHPのバージョンが低すぎます。最低でも',
	'e_php_version2'					=> 'が必要です。',
	'e_precheck_not_supported'			=> 'PrecheckはこのバージョンのGeeklogをサポートしていません。バージョン1.5.0以降でお使いください。',
	'e_siteconfig_php'					=> '<strong>公開領域/siteconfig.php</strong>が書き込み禁止になっています。',
	'e_sitemapxml'						=> '<strong>公開領域/sitemap.xml</strong>が存在しないか、書き込み禁止になっています。',
	'e_spamx_log'						=> '<strong>非公開領域/logs/spamx.log</strong>が書き込み禁止になっています。',
	'fresh_install'						=> '新規インストール',
	'go_to_installer'					=> 'インストーラへ',
	'info'								=> '情報',
	'info_config'						=> 'の設定方法',
	'info_default_charset'				=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>default_charset = utf-8</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_value default_charset utf-8</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@ini_set(\'default_charset\', \'utf-8\');</code>',	// INI_ALL
	'info_display_errors'				=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>display_errors = Off</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag display_errors Off</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@ini_set(\'display_errors\', FALSE);</code>',	// INI_ALL
	'info_magic_quotes_gpc'				=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>magic_quotes_gpc = Off</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag magic_quotes_gpc Off</code>',	// INI_PERDIR
	'info_magic_quotes_runtime'			=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>magic_quotes_runtime = Off</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag magic_quotes_runtime Off</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@set_magic_quotes_runtime(FALSE);</code>',	// INI_ALL
	'info_magic_quotes_sybase'			=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>magic_quotes_sybase = Off</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag magic_quotes_sybase Off</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@ini_set(\'magic_quotes_sybase\', FALSE);</code>',	// INI_ALL
	'info_mbstring_encoding_translation'	=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>mbstring.encoding_translation = Off</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag mbstring.encoding_translation Off</code>',	// INI_PERDIR
	'info_mbstring_http_output'			=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>mbstring.http_output = pass</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_value mbstring.http_output pass</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@ini_set(\'mbstring.http_output\', \'pass\');</code>',	// INI_ALL
	'info_mbstring_internal_encoding'	=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>mbstring.internal_encoding = utf-8</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_value mbstring.internal_encoding utf-8</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@ini_set(\'mbstring.internal_encoding\', \'utf-8\');</code>',	// INI_ALL
	'info_mbstring_language'			=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>mbstring.language = Japanese</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_value mbstring.language Japanese</code>',	// INI_ALL、INI_PERDIR(～5.2.6)
	'info_memory_limit'					=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>memory_limit = 128M</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_value memory_limit 128M</code><p>(<strong>siteconfig.php</strong>で設定する場合)</p><code>@ini_set(\'memory_limit\', \'128M\');</code>',	// INI_ALL
	'info_register_globals'				=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>register_globals = Off</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag register_globals Off</code>', // INI_PERDIR
	'info_cgi_fix_pathinfo'				=> '<p>(<strong>php.ini</strong>で設定する場合)</p><code>cgi.fix_pathinfo = 1</code><p>(<strong>.htaccess</strong>で設定する場合)</p><code>php_flag cgi.fix_pathinfo On</code>', // INI_SYSTEM
	
	'item_php_version'					=> 'PHPのバージョン',
	'item_database'						=> 'データベース機能',
	'item_mbstring'						=> 'マルチバイト文字列関数(mbstring)',
	'item_dbconfig_path'				=> 'db-config.phpのパス',
	
	'lang_help'							=> 'インストールで困ったら、こちらのサイトへ',
	'lang_precheck'						=> 'Geeklogインストール前チェック',
	'lang_version'						=> 'Ver',
	'migrate'							=> '移行',
	'no'								=> 'いいえ',
	'no_error'							=> 'エラーはありません。',
	'num_error'							=> '個のエラー',
	'num_warning'						=> '個の警告',
	'ok'								=> 'OK',
	'result'							=> '診断結果',
	'step0'								=> 'Step 0. PHPの設定確認',
	'step1'								=> 'Step 1. db-config.phpのパス確認',
	'step2'								=> 'Step 2. インストールタイプの選択',
	'step3'								=> 'Step 3. 初期診断',
	'step4'								=> 'Step 4. データベース情報入力',
	'success'							=> '致命的なエラーはなさそうなので、インストールできます。続行するには、下の「続行する」をクリックしてください。',
	'upgrade'							=> 'アップグレード',
	'use_filebrowser'					=> 'ファイルブラウザで探す',
	'use_utf8'							=> 'UTF-8を使用する',
	'warning'							=> '警告',
	'w_display_errors'					=> '<strong>display_errors</strong>がオンになっています。エラー発生時に重要な情報を漏洩する原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=display_errors">設定方法はこちら</a>]。',
	'w_magic_quotes_gpc'				=> '<strong>magic_quotes_gpc</strong>がオンになっています。文字化けの原因になるので、<strong>httpd.conf</strong>か<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=magic_quotes_gpc">設定方法はこちら</a>]。',
	'w_get_magic_quotes_runtime'		=> '<strong>magic_quotes_runtime</strong>がオンになっています。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=magic_quotes_runtime">設定方法はこちら</a>]。',
	'w_magic_quotes_sybase'				=> '<strong>magic_quotes_sybase</strong>がオンになっています。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=magic_quotes_sybase">設定方法はこちら</a>]。',
	'w_mbstring.internal_encoding'		=> '<strong>mbstring.internal_encoding</strong>に特定の文字セットが設定されているようです。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>utf-8</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_internal_encoding">設定方法はこちら</a>]。',
	'w_mbstring_language_neutral'		=> '<strong>mbstring.language</strong>に<strong>neutral</strong>が設定されています。文字化けするようなら、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Japanese</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_language">設定方法はこちら</a>]。',
	'w_memory_limit'					=> 'PHPに割り当てられたメモリが少ないようです。少なくとも16Mバイトは割り当ててください。[<a href="precheck.php?mode=info&amp;item=memory_limit">設定方法はこちら</a>]',
	'w_register_globals'				=> '<strong>register_globals</strong>が<strong>On</strong>になっています。セキュリティを低下させる原因になるので、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Off</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=register_globals">設定方法はこちら</a>]',
	'w_cgi_fix_pathinfo'                => '<strong>cgi.fix_pathinfo</strong>が<strong>Off(0)</strong>になっています。URLリライト機能を使用する場合は、<strong>httpd.conf</strong>か<strong>php.ini</strong>で<strong>On(1)</strong>に設定する必要がありますが、PHP-5.3.9よりも古いバージョンでは<code>security.limit_extension</code>を設定できないため、<strong>セキュリティ上極めて危険</strong>です。[<a href="precheck.php?mode=info&amp;item=cgi_fix_pathinfo">設定方法はこちら</a>]',
	'yes'								=> 'はい',
);
