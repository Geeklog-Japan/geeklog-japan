<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/language/japanese_utf-8.php                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-k DOT net         |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
	die('This file cannot be used on its own.');
}

$LANG_SMAP = array(
    'plugin'            => 'sitemapプラグイン',
	'access_denied'     => 'アクセスは拒否されました。',
	'access_denied_msg' => 'このページにアクセスできるのは、Rootユーザだけです。あなたのユーザ名とIPアドレスは記録されました。',
	'admin'		        => 'sitemapプラグイン管理',
	'install_header'	=> 'sitemapプラグインのインストール/アンインストール',
	'install_success'	=> 'sitemapプラグインのインストールに成功しました。',
	'install_fail'  	=> 'sitemapプラグインのインストールに失敗しました。詳細はエラーログ(error.log)をご覧ください。',
	'uninstall_success'	=> 'sitemapプラグインのアンインストールに成功しました。',
	'uninstall_fail'    => 'sitemapプラグインのアンインストールに失敗しました。詳細はエラーログ(error.log)をご覧ください。',
	'uninstall_msg'		=> 'sitemapプラグインはアンインストールされました。',
	'menu_label'        => 'サイトマップ',
	'sitemap'           => 'サイトマップ',
	'submit'            => '送信',
	'all'               => 'すべて',
	'article'           => '記事',
	'comments'          => 'コメント',
	'trackback'         => 'トラックバック',
	'staticpages'       => '静的ページ',
	'calendar'          => 'カレンダ',
	'links'             => 'リンク',
	'polls'             => 'アンケート',
	'dokuwiki'          => 'DokuWiki',
	'forum'             => '掲示板',
	'filemgmt'          => 'ファイル管理',
	'faqman'            => 'FAQ',
	'mediagallery'      => 'メディアギャラリ',
	'calendarjp'        => 'カレンダjp',
	'downloads'         => 'ダウンロード',
	'sitemap_setting'   => 'サイトマップの設定',
	'sitemap_setting_misc' => 'サイトマップの表示設定',
	'order'             => '表示順',
	'up'                => '上へ',
	'down'              => '下へ',
	'anon_access'       => 'ゲストユーザのアクセスを許可する',
	'sitemap_in_xhtml'  => 'XHTMLで作成する',
	'date_format'       => '日付の形式',
	'desc_date_format'  => '「日付の形式」で使用するパラメータは、PHPの<a href="http://www.php.net/manual/ja/function.date.php">date()関数</a>のformatパラメータと同じです。',
	'sitemap_items'     => 'サイトマップに掲載する項目',
	'gsmap_setting'     => 'Googleサイトマップの設定',
	'file_creation'     => 'ファイル作成の設定',
	'google_sitemap_name' => 'ファイル名：',
	'time_zone'         => 'タイムゾーン：',
	'update_now'        => 'いますぐ更新する',
	'last_updated'      => '前回更新時：',
	'unknown'           => '不明',
	'desc_filename'     => '<strong>「ファイル名」</strong>には、Googleサイトマップのファイル名を指定します。セミコロンで区切って複数指定できます。モバイル用のサイトマップ名は mobile.xml としてください。',
	'desc_time_zone'    => '<strong>「タイムゾーン」</strong>には、Geeklogを設置しているサーバのタイムゾーンを<a href="http://ja.wikipedia.org/wiki/ISO_8601">ISO 8601</a>の形式((+|-)hh:mm)で指定します。例：+09:00（東京）、+01:00（パリ）、+01:00（ベルリン）、+00:00（ロンドン）、-05:00（ニューヨーク）、-08:00（ロサンジェルス）',
	'gsmap_items'       => 'Googleサイトマップに掲載する項目',
	'item_name'         => '項目名',
	'freq'              => '更新間隔',
	'always'            => '常に更新',
	'hourly'            => '1時間に1回更新',
	'daily'             => '1日に1回更新',
	'weekly'            => '1週間に1回更新',
	'monthly'           => '1ヶ月に1回更新',
	'yearly'            => '1年に1回更新',
	'never'             => '更新しない',
	'priority'          => '優先度',
	'desc_freq'         => '<strong>「更新間隔」</strong>は、項目がどれくらいの頻度で更新されるかというおおよその目安をGoogleのクローラに指示します。「更新しない」を選択しても、Googleのクローラはときどき巡回してきます。',
	'desc_priority'     => '<strong>「優先度」</strong>は、項目の優先度を<strong>0.0</strong>（最低）から<strong>1.0</strong>（最高）の範囲で指定してください。既定値は<strong>0.5</strong>です。',
	
	// Since version 1.1.4
	'common_setting'    => '共通の設定',
	'sp_setting'        => '静的ページの設定',
	'sp_type'           => 'サイトマップに掲載するタイプ',
	'sp_type0'          => 'すべて',
	'sp_type1'          => 'センターブロックに表示されるページのみ',
	'sp_type2'          => 'センターブロックに表示されないページのみ',
	'sp_except'         => '除外するページID（正規表現可。半角スペースで区切る）',
	
	// Since version 1.2.2
	'dataproxy_unavailable'	=> 'エラーが発生しました。Dataproxyプラグインがインストールされていないか、無効になっています。',
	
	// Since version 2.0.0
	'sitemap_unavailable'	=> 'エラーが発生しました。サイトマッププラグインがインストールされていないか、無効になっています。',
);
