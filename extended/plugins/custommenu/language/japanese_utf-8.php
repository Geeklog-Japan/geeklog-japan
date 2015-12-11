<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/language/japanese_utf-8.php                            |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2008-2013 dengen - taharaxp AT gmail DOT com                |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett               -    twillett AT users DOT sourceforge DOT net  |
// | Blaine Lang               -    langmail AT sympatico DOT ca               |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                -    tony AT tonybibbs DOT com                  |
// | Modified by:                                                              |
// | mystral-kk                -    geeklog AT mystral-kk DOT net              |
// | dengen                    -    taharaxp AT gmail DOT com                  |
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
//

$LANG_CMED = array(
    'display_name'        => 'カスタムメニュー',
    'menu_title'          => 'カスタムメニュー',
    'plugin'              => 'カスタムメニュー編集',
    'access_denied'       => 'アクセスできません',
    'access_denied_msg'   => 'このページにはRootユーザーだけがアクセスできます。あなたのユーザー名とIPアドレスを記録しました。',
    'admin'               => 'カスタムメニュープラグイン管理',
    'install_header'      => 'カスタムメニュープラグインのインストール/アンインストール',
    'installed'           => 'カスタムメニュープラグインはインストール済みです。',
    'uninstalled'         => 'カスタムメニュープラグインはインストールしていません。',
    'install_success'     => 'カスタムメニュープラグインのインストールに成功しました。',
    'install_failed'      => 'カスタムメニュープラグインのインストーに失敗しました。詳細はエラーログ(error.log)をご覧ください。',
    'uninstall_msg'       => 'カスタムメニュープラグインのアンインストールに成功しました。',
    'install'             => 'インストール',
    'uninstall'           => 'アンインストール',
    'warning'             => '警告! まだカスタムメニュープラグインが有効です。',
    'enabled'             => 'アンインストールする前に、カスタムメニュープラグインを無効にしてください。',
    'readme'              => 'ちょっと待って! 「インストール」をクリックする前に、お読みください: ',
    'installdoc'          => 'インストール手順書',

    // for stats
    'stats_headline'      => 'メニュー管理 (上位10件)',
    'stats_title'         => '件名',
    'stats_value'         => '件',
    'stats_no_value'      => 'データがありません。',
    
    // for admin
    'manager'             => 'カスタムメニュー編集',
    'move'                => '移動',
    'order'               => '順番',
    'id'                  => 'ID',
    'classname'           => 'クラス名',
    'instructions'        => 'データを修正、削除する場合は各データの「編集」アイコンをクリックしてください。新規作成は「新規作成」をクリックしてください。',

    'warning_updated'     => 'カスタムメニュー編集プラグインは最新です。',
    'instructions_update' => 'プラグイン管理で \'custommenu\' の更新を行って下さい。',
);

$LANG_CMED_EDITOR = array(
    'confirm'             => $MESSAGE[76],
    'topic'               => $LANG_ADMIN['topic'],
    'menuitemtype'        => $LANG_ADMIN['type'],
    'save'                => $LANG_ADMIN['save'],
    'cancel'              => $LANG_ADMIN['cancel'],
    'delete'              => $LANG_ADMIN['delete'],

    'accessrights'        => $LANG_ACCESS['accessrights'],
    'owner'               => $LANG_ACCESS['owner'],
    'group'               => $LANG_ACCESS['group'],
    'permissions'         => $LANG_ACCESS['permissions'],
    'perm_key'            => $LANG_ACCESS['permissionskey'],
    'permissions_msg'     => $LANG_ACCESS['permmsg'],

    'custommenueditor'    => 'メニューアイテムの編集',
    'all'                 => 'すべて',
    'menuitemorder'       => '順序',
    'instructions'        => 'メニューアイテムの編集・削除は以下のメニューアイテムの編集アイコンを、新規作成は上の「新規作成」リンクをクリックします',
    'homeonly'            => 'ホームページのみ',
    'menuitemid'          => 'メニューアイテムID',
    'nospaces'            => '(半角英数字とハイフン)',
    'includehttp'         => 'http:// を含む。固定モードおよび可変モード時に必須。',
    'mode'                => 'モード',
    'mode_info'           => '固定: タイトル固定モード<br' . XHTML . '>可変: 多言語切り替え機能に応じたタイトル可変モード<br' . XHTML . '>PHP: PHP関数でタイトルとURLを柔軟に設定するモード',
    'mode_fixation'       => '固定',
    'mode_variable'       => '可変',
    'mode_php'            => 'PHP',
    'title_fixation'      => 'タイトル(固定)',
    'title_fixation_info' => '固定モード時に必須。',
    'title_variable'      => 'タイトル(可変)',
    'title_variable_info' => '可変モード時に必須。<br' . XHTML . '>言語ファイル内で定義している配列変数を指定します。<br' . XHTML . '>例えば、$MY_WORD[\'label\'] をタイトルにする場合は MY_WORD[\'label\'] を記入します。',
    'php_function'        => 'PHP関数名',
    'php_function_info'   => 'PHPモード時に必須。<br' . XHTML . '>関数名に接頭辞「phpmenuitem_」を付けて下さい。',
    'is_enabled'          => '有効',
    'menuitemurl'         => 'URL',
    'icon_url'            => 'アイコンURL',
    'icon_url_info'       => 'http:// を含む。この項目は標準的には無効です。<br' . XHTML . '>有効に活用するためには、別途、COM_renderMenu 関数の変更が必要です。',
    'type_gldefault'      => 'Geeklog default',
    'type_plugin'         => 'Plugin',
    'type_custom'         => 'Custom',
    'update'              => '更新',
    'error_field'         => '未入力または入力が不適切な項目があります',
    'message_access1'     => "管理権限のないメニューアイテムを編集しようとしました。このアクセスを記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/custommenu/index.php\">カスタムメニューの編集</a>画面に戻ってください.",
    'message_access2'     => 'カスタムメニュー管理画面へのアクセス権がありません。権限のない機能へのアクセスはすべて記録しています。',
    'message_access3'     => '管理権限のないメニューアイテムを削除しようとしました。このアクセスを記録しました。',
    'move_down'           => 'メニューアイテムを下に',
    'move_up'             => 'メニューアイテムを上に',
    'message_title'       => 'メニューアイテムのタイトルが不適切です',
    'message_wrong'       => '入力値が不適切です',
    'message_title2'      => 'タイトルは空欄ではいけませんし、HTMLを含んでもいけません!',
    'access_denied'       => 'アクセスできません。',
    'validate_message_1'  => '固定モードで、タイトル(固定)は省略できません。',
    'validate_message_2'  => '可変モードで、タイトル(可変)は省略できません。',
    'validate_message_3'  => 'PHPモードで、PHP関数名は省略できません。',
    'validate_message_4'  => 'メニューアイテムIDは省略できません。',
    'validate_message_5'  => '既に同じメニューアイテムIDが存在します。',
    'validate_message_6'  => 'URL照合文字列が正しくありません。',
    'validate_message_7'  => '固定モードと可変モードで、URLは省略できません。',
    'validate_message_8'  => '親アイテムIDの設定に誤りがあります。',
    'pattern'             => 'URL照合文字列',
    'pattern_info'        => '表示中のページのURLがこの文字列とマッチした場合は、"selected"をGeeklogシステムに渡すメニューアイテムの情報に追加します。<br' . XHTML . '>これを活用するとメニューアイテムのスタイルを反転させることが可能になります。',
    'is_preg'             => '正規表現',
    'parentitemid'        => '親アイテムID',

    'class_name'          => 'クラス名',
    'class_name_info'     => 'メニューアイテムごとにクラス名を指定できます。',
);

// 可変モード用のオリジナルタイトルを定義しましょう!
$MY_TITLES = array(
);

// Messages for COM_showMessage the submission form

$PLG_custommenu_MESSAGE2 = 'カスタムメニューのデータを保存しました。';
$PLG_custommenu_MESSAGE3 = 'カスタムメニューのデータを削除しました。';

// Messages for the plugin upgrade
$PLG_custommenu_MESSAGE3001 = 'プラグインのアップグレードはサポートしていません。';
$PLG_custommenu_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['custommenu'] = array(
    'label' => 'カスタムメニュー',
    'title' => 'カスタムメニューの設定'
);

$LANG_confignames['custommenu'] = array(
    'aftersave' => 'メニューアイテム保存後の画面遷移',
    'menu_render' => 'メニューレンダラー',
    'prefix_id' => 'IDに付加するプリフィックス',
    'default_permissions' => 'パーミッション'
);

$LANG_configsubgroups['custommenu'] = array(
    'sg_main' => 'メイン'
);

$LANG_tab['custommenu'] = array(
    'tab_main' => 'カスタムメニューのメイン設定',
    'tab_permissions' => 'メニューアイテムのパーミッション'
);

$LANG_fs['custommenu'] = array(
    'fs_main' => 'カスタムメニューのメイン設定',
    'fs_public' => 'カスタムメニューの表示',
    'fs_permissions' => 'メニューアイテムのパーミッションのデフォルト([0]所有者 [1]グループ [2]メンバー [3]ゲスト)'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['custommenu'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    9 => array('カスタムメニュー管理を表示する' => 'list', 'ホームを表示する' => 'home', '管理画面トップを表示する' => 'admin'),
    10 => array('Geeklogシステム標準' => 'standard', '階層メニュー対応' => 'pulldown'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3)
);

?>