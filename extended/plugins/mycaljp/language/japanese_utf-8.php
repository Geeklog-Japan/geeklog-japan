<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | plugins/mycaljp/language/japanese_utf-8.php                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// | Geeklog Author:        Tony Bibbs - tony AT tonybibbs DOT com             |
// | mycal Block Author:    Blaine Lang - geeklog AT langfamily DOT ca         |
// | Mycaljp Plugin Author: dengen - taharaxp AT gmail DOT com                 |
// | Original PHP Calendar by Scott Richardson - srichardson@scanonline.com    |
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

$LANG_MYCALJP = array (
    'plugin'            => 'Mycaljpプラグイン',
    'plugin_name'       => 'Mycaljp',
    'access_denied'     => 'アクセスできません',
    'access_denied_msg' => 'このページにはRootユーザーだけがアクセスできます。あなたのユーザー名とIPアドレスを記録しました。',
    'admin'             => 'サイトカレンダーMycaljpの管理',
    'install_header'    => 'サイトカレンダーMycaljpプラグインのインストール/アンインストール',
    'installed'         => 'サイトカレンダーMycaljpプラグインはインストール済みです。',
    'uninstalled'       => 'サイトカレンダーMycaljpプラグインはインストールしていません。',
    'install_success'   => 'サイトカレンダーMycaljpプラグインのインストールに成功しました。',
    'install_failed'    => 'サイトカレンダーMycaljpプラグインのインストールに失敗しました。詳細はエラーログ(error.log)をご覧ください。',
    'uninstall_msg'     => 'サイトカレンダーMycaljpプラグインのアンインストールに成功しました。',
    'install'           => 'インストール',
    'uninstall'         => 'アンインストール',
    'warning'           => '警告!  サイトカレンダーMycaljpプラグインは有効なままです。',
    'enabled'           => 'アンインストールする前にサイトカレンダーMycaljpプラグインを無効にしてください。',
    'readme'            => 'ちょっと待って!  「インストール」をクリックする前に、お読みください: ',
    'installdoc'        => 'インストール手順書',
    
    'blocktitle'        => 'ブロックタイトル',
    'selecttemplates'   => 'テンプレートの選択',
    'checkcontents'     => 'チェック対象のコンテンツ',
    'wdays'             => '曜日タイトル',
    'prevmonth'         => '先月へ',
    'nextmonth'         => '翌月へ',
    'skipcalendar'      => 'サイトカレンダーをスキップ',
    'headeroflink'      => '',
    'footeroflink'      => 'のコンテンツ',
    'yes'               => 'はい',
    'no'                => 'いいえ',
    'sunday'            => '日',
    'monday'            => '月',
    'tuesday'           => '火',
    'wednesday'         => '水',
    'thursday'          => '木',
    'friday'            => '金',
    'saturday'          => '土',

    'applythemetmplate' => 'テーマ提供テンプレートの適用',
    'headerofdate'      => '',
    'middleofdate'      => ' ～ ',
    'footerofdate'      => ' の検索結果',
    'no_dataproxy'      => 'Dataproxy がありません。',
    'pickup_title'      => 'サイトカレンダー - ピックアップ',
    'block_title'       => 'サイトカレンダー',
);


// Localization of the Admin Configuration UI
$LANG_configsections['mycaljp'] = array(
    'label' => 'Mycaljp',
    'title' => 'Mycaljpの設定'
);

$LANG_confignames['mycaljp'] = array(
    'headertitleyear'     => 'ヘッダータイトル(年)',
    'headertitlemonth'    => 'ヘッダータイトル(月)',
    'titleorder'          => 'ヘッダータイトルの順序',
    'sunday'              => '日',
    'monday'              => '月',
    'tuesday'             => '火',
    'wednesday'           => '水',
    'thursday'            => '木',
    'friday'              => '金',
    'saturday'            => '土',
    'showholiday'         => '土・日・休日を色分け表示する',
    'checkjpholiday'      => '日本の休日を調べる',
    'enablesrblocks'      => '右サイドバーを表示する',
    'showstoriesintro'    => '記事冒頭文を表示する',
    'use_theme'           => 'テーマのテンプレートを使う',
    'template'            => 'テンプレート名',
    'date_format'         => '日付の形式',
    'supported_contents'  => 'サポートするコンテンツ',
    'enabled_contents'    => '有効にするコンテンツ',
    'sp_type'             => 'リストに掲載するタイプ',
    'sp_except'           => '除外するページID',
    'block_enable'        => '有効',
    'block_isleft'        => '左ブロックで表示する',
    'block_order'         => 'ブロックの順番',
    'block_topic_option'  => '話題オプション',
    'block_topic'         => '話題',
    'block_group_id'      => 'グループ',
    'block_permissions'   => 'パーミッション'
);

$LANG_configsubgroups['mycaljp'] = array(
    'sg_main' => 'メイン'
);

$LANG_tab['mycaljp'] = array(
    'tab_main'          => 'Mycaljpのメイン設定',
    'tab_staticpages'   => '静的ページの設定',
    'tab_mycaljp_block' => 'ブロックの設定',
);

$LANG_fs['mycaljp'] = array(
    'fs_main'              => 'Mycaljpのメイン設定',
    'fs_staticpages'       => '静的ページの設定',
    'fs_block_settings'    => 'ブロックの設定',
    'fs_block_permissions' => 'ブロックのパーミッション',
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['mycaljp'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('年 月' => TRUE, '月 年' => FALSE),
    14 => array('すべて' => 0, 'センターブロックに表示するページのみ' => 1, 'センターブロックに表示しないページのみ' => 2),
    15 => array('すべて' => TOPIC_ALL_OPTION, 'ホームページのみ' => TOPIC_HOMEONLY_OPTION, '話題を選択する' => TOPIC_SELECTED_OPTION),
    16 => array('アクセス不可' => 0, '表示' => 2),
);
?>