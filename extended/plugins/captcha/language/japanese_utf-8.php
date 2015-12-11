<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v3.5 Plugin                                                       |
// +---------------------------------------------------------------------------+
// | This is the Japanse language page for the CAPTCHA Plugin                  |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2009-2014 by the following authors:                         |
// |                                                                           |
// | ben           ben AT geeklog DOT fr                                       |
// |                                                                           |
// | Based on the original CAPTCHA Plugin                                      |
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Mark R. Evans - mark AT glfusion DOT org                                  | 
// | Tranlated by Ivy                                                          |
// +---------------------------------------------------------------------------|
// |                                                                           |
// | If you translate this file, please consider uploading a copy at           |
// |    http://geeklog.net so others can benefit from your                     |
// |    translation.  Thank you!                                               |
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

$LANG_CP00 = array (
    'menulabel'         => 'CAPTCHA',
    'plugin'            => 'CAPTCHA',
    'access_denied'     => 'アクセスできません',
    'access_denied_msg' => 'このページにはアクセスできません。あなたのユーザー名とIPアドレスを記録しました。',
    'admin'             => 'CAPTCHA 管理',
    'install_header'    => 'CAPTCHA プラグイン インストール/アンインストール',
    'installed'         => 'CAPTCHAプラグインをインストール済みです。',
    'uninstalled'       => 'インストールに成功しました',
    'install_success'   => 'インストールに成功しました。',
    'install_failed'    => 'インストールに失敗しました。原因を調べるにはエラーログを参照してださい。',
    'uninstall_msg'     => 'プラグインのアンインストールに成功しました。',
    'install'           => 'インストール',
    'uninstall'         => 'アンインストール',
    'warning'           => '警告! まだプラグインが有効です',
    'enabled'           => 'アンインストールする前に無効にしてください。',
    'readme'            => 'CAPTCHAプラグインインストール',
    'installdoc'        => "<a href=\"http://geeklog.fr/wiki/plugins:captcha\" target=\"_blank\">オンラインWiki</a>",
    'overview'          => 'CAPTCHAはGeeklogのプラグインで、スパムに対するセキュリティレイヤーを提供します。<br /><br />CAPTCHA ("コンピューターと人間を区別する完全に自動化されたテスト"が、カーネギーメロン大学によって商標登録されました。)は、ユーザーが人間かどうかを自動判断します。CAPTCHAによるテストにより、あなたのサイトからスパムボットの投稿から守られます。',
    'details'           => '',
    'preinstall_check'  => '',
    'geeklog_check'     => '',
    'php_check'         => '',
    'preinstall_confirm' => "",
    'captcha_help'      => '',
    'bypass_error'      => "このサイトのCAPTCHA処理が迂回されています。新規ユーザー登録を利用してください。",
    'bypass_error_blank' => "このサイトのCAPTCHA処理が迂回されています。",
    'entry_error'       => '私たちのフィルタはエラーを示します。下の指示をよく読んでください。',
    'captcha_info'      => 'CAPTCHAプラグインは、スパムボットからGeeklogサイトを守るための機能を提供しています。詳しくは<a href="%s">オンラインドキュメントWiki</a>を参照してください。 ',
    'enabled_header'    => 'カレントのCAPTCHA設定',
    'view_logfile'      => 'CAPTCHAログを見る',
    'log_viewer'        => 'Geeklog ログビューワー',
    'on'                => 'On',
    'off'               => 'Off',
    'save'              => '保存',
    'cancel'            => 'キャンセル',
    'success'           => 'コンフィギュレーションオプションが保存されました。',
	'captcha'           => 'セキュリティ',
	'question'          => '下のアクションは、あなたが人間なのかスパムなのかを判断するためのものです。矢印の方向にスワイプしてください。',
	'what_code'         => '',
    'view_log'          => 'Geeklogのログ閲覧/削除',
    'file'              => 'File:',
    'view_file'         => 'ログを見る',
    'clear_file'        => 'ログを削除する',
    'file_cleared'      => 'ログを消しました',
	'txtLock'           => 'ロック : フォーム投稿できません',
	'txtUnlock'         => 'ロック解除 : フォーム投稿できます',
);

$PLG_captcha_MESSAGE1 = 'CAPTCHA プラグインアップデート: アップデートが完了しました。';
$PLG_captcha_MESSAGE2 = 'CAPTCHA プラグインアップデート失敗 - error.logをチェック';
$PLG_captcha_MESSAGE3 = 'CAPTCHA プラグインアップデート成功';

// Localization of the Admin Configuration UI
$LANG_configsections['captcha'] = array(
    'label' => 'Captcha',
    'title' => 'Captchaの設定'
);

$LANG_confignames['captcha'] = array(
    'anonymous_only' => 'ゲストユーザーに対してのみ使用する',
	'remoteusers' => 'リモートユーザー全員に強制する',
	'debug' => 'デバッグ',
	'enable_comment' => 'コメントをサポートする',
	'enable_contact' => 'メール送信をサポートする',
	'enable_emailstory' => '「記事をメールする」をサポートする',
	'enable_forum' => '掲示板プラグインをサポートする',
	'enable_registration' => 'ユーザー登録をサポートする',
	'enable_mediagallery' => 'メディアギャラリープラグイン(Postcards)をサポートする',
	'enable_rating' => 'レーティングプラグインをサポートする',
	'enable_story' => '記事投稿をサポートする',
	'enable_calendar' => 'カレンダープラグインをサポートする',
	'enable_links' => 'リンクプラグインをサポートする',
	'logging' => '無効な試行をログファイルに記録する',
	'input_id' => '非可視入力のカスタムID',
	'use_slider' => 'CAPTCHAスライダーを有効にする',
);

$LANG_configsubgroups['captcha'] = array(
    'sg_main' => '主要設定'
);

$LANG_tab['captcha'] = array(
    'tab_main' => 'CAPTCHA設定'
);
 
$LANG_fs['captcha'] = array(
    'fs_config' => 'CAPTCHAコンフィギュレーション',
    'fs_integration' => 'Geeklogへの統合'    
);

// Note: entries 0 is the same as in $LANG_configselects['Core']
$LANG_configselects['captcha'] = array(
    0 => array('はい' => 1, 'いいえ' => 0)
);

?>