<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | plugins/mycaljp/install_defaults.php                                      |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Mycaljp default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */

global $_CONF, $_MYCALJP2_DEFAULT, $LANG_MYCALJP;

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/mycaljp/language/'
          . $_CONF['language'] . '.php';

if ( file_exists( $langfile ) ) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/mycaljp/language/english.php';
}

/*
 * サポートするコンテンツの設定
 * ----------------------------
 */

$_MYCALJP2_DEFAULT['supported_contents'] = array(
    'stories',          //記事
    'comments',         //コメント
    'trackback',        //トラックバック
    'staticpages',      //静的ページ
    'calendar',         //イベントカレンダー
    'links',            //リンク
    'polls',            //アンケート
    'dokuwiki',         //DokuWiki
    'forum',            //掲示板
    'filemgmt',         //ファイル管理
    'faqman',           //Faqman
    'mediagallery',     //メディアギャラリ
    'calendarjp',       //イベントカレンダー（日本語版）
    'downloads'         //ダウンロード
);

$_MYCALJP2_DEFAULT['enabled_contents'] = array(
    'stories'      => 1,    //記事
    'comments'     => 1,    //コメント
    'trackback'    => 1,    //トラックバック
    'staticpages'  => 1,    //静的ページ
    'calendar'     => 1,    //イベントカレンダー
    'links'        => 1,    //リンク
    'polls'        => 1,    //アンケート
    'dokuwiki'     => 1,    //DokuWiki
    'forum'        => 1,    //掲示板
    'filemgmt'     => 1,    //ファイル管理
    'faqman'       => 1,    //Faqman
    'mediagallery' => 1,    //メディアギャラリ
    'calendarjp'   => 1,    //イベントカレンダー（日本語版）
    'downloads'    => 1     //ダウンロード
);

/*
 * チェックするコンテンツの設定
 * ----------------------------
 */

//$_MYCALJP2_DEFAULT['contents'] = $_MYCALJP2_DEFAULT['support'];

/*
 * 土・日・休日の色分け表示の設定
 * ------------------------------
 *   true  : 色分けする (default)
 *   false : 色分けしない
 */

$_MYCALJP2_DEFAULT['showholiday'] = true;

/*
 * 日本の休日を調べるかどうかの設定
 * --------------------------------
 *   true  : 調べる (default)
 *   false : 調べない
 */

$_MYCALJP2_DEFAULT['checkjpholiday'] = true;

/*
 * タイトル(年・月)の設定
 * ----------------------
 * "m"  月．数字。先頭にゼロをつける．  (01 から 12)
 * "n"  月．数字。先頭にゼロをつけない．(1 から 12)
 * "F"  月．フルスペルの文字．          (January から December)
 * "M"  月．3 文字形式．                (Jan から Dec)
 * "Y"  年．4 桁の数字．                (例: 1999または2003)
 * "y"  年．2 桁の数字．                (例: 99 または 03)
 */

if ($_CONF['language'] == 'japanese_utf-8') {

    $_MYCALJP2_DEFAULT['headertitleyear']  = "Y年";
    $_MYCALJP2_DEFAULT['headertitlemonth'] = "m月";

} else {

    $_MYCALJP2_DEFAULT['headertitleyear']   = "Y";
    $_MYCALJP2_DEFAULT['headertitlemonth']  = "F";

}

/*
 * タイトル(年・月)の表示順序の設定
 * ----------------------
 *   true  : 年 月
 *   false : 月 年
 */

if ($_CONF['language'] == 'japanese_utf-8') {

    $_MYCALJP2_DEFAULT['titleorder'] = true;

} else {

    $_MYCALJP2_DEFAULT['titleorder'] = false;

}

/*
 * 曜日の表示文字列の設定
 * ----------------------------
 */
$_MYCALJP2_DEFAULT['sunday']    = $LANG_MYCALJP['sunday'];
$_MYCALJP2_DEFAULT['monday']    = $LANG_MYCALJP['monday'];
$_MYCALJP2_DEFAULT['tuesday']   = $LANG_MYCALJP['tuesday'];
$_MYCALJP2_DEFAULT['wednesday'] = $LANG_MYCALJP['wednesday'];
$_MYCALJP2_DEFAULT['thursday']  = $LANG_MYCALJP['thursday'];
$_MYCALJP2_DEFAULT['friday']    = $LANG_MYCALJP['friday'];
$_MYCALJP2_DEFAULT['saturday']  = $LANG_MYCALJP['saturday'];

/*
 * 日付クリック後の検索結果表示において、右サイドバーを表示するかどうかの設定
 * --------------------------------------------------------------------------
 *   true  : 表示する (default)
 *   false : 表示しない
 */

$_MYCALJP2_DEFAULT['enablesrblocks'] = true;

/*
 * 日付クリック後の検索結果表示において、記事の導入部(イントロ)を表示するかどうかの設定
 * ------------------------------------------------------------------------------------
 *   true  : 表示する (default)
 *   false : 表示しない
 */

$_MYCALJP2_DEFAULT['showstoriesintro'] = true;


/*
 * 曜日の表示文字列の設定
 * ----------------------------
 */

$_MYCALJP2_DEFAULT['template'] = 'default';

$_MYCALJP2_DEFAULT['use_theme'] = false;

$_MYCALJP2_DEFAULT['sp_type']   = 1;
$_MYCALJP2_DEFAULT['sp_except'] = 'formmail';

$_MYCALJP2_DEFAULT['date_format'] = '[Y-m-d] ';


/*
 * Site Calendar Block
 * ----------------------------
 */
$_MYCALJP2_DEFAULT['block_isleft'] = 1;
$_MYCALJP2_DEFAULT['block_order'] = 10;
$_MYCALJP2_DEFAULT['block_topic_option'] = TOPIC_ALL_OPTION;
$_MYCALJP2_DEFAULT['block_topic'] = array();
$_MYCALJP2_DEFAULT['block_enable'] = true;
$_MYCALJP2_DEFAULT['block_permissions'] = array (2, 2, 2, 2);

/**
* Initialize Navigation Manager plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_MYCALJP2_CONF if available (e.g. from
* an old config.php), uses $_MYCALJP2_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_mycaljp()
{
    global $_GROUPS, $_TABLES, $_MYCALJP2_CONF, $_MYCALJP2_DEFAULT;

    if (is_array($_MYCALJP2_CONF) && (count($_MYCALJP2_CONF) > 1)) {
        $_MYCALJP2_DEFAULT = array_merge($_MYCALJP2_DEFAULT, $_MYCALJP2_CONF);
    }

    $c = config::get_instance();
    $n = 'mycaljp';
    $o = 1;
    if ($c->group_exists($n)) return true;
    $c->add('sg_main',            NULL,                                     'subgroup', 0, 0, NULL, 0,    true, $n);
    // ----------------------------------
    $c->add('fs_main',            NULL,                                     'fieldset', 0, 0, NULL, 0,    true, $n);
    $c->add('headertitleyear',    $_MYCALJP2_DEFAULT['headertitleyear'],    'text',     0, 0, 0,    $o++, true, $n);
    $c->add('headertitlemonth',   $_MYCALJP2_DEFAULT['headertitlemonth'],   'text',     0, 0, 0,    $o++, true, $n);
    $c->add('titleorder',         $_MYCALJP2_DEFAULT['titleorder'],         'select',   0, 0, 13,   $o++, true, $n);
    $c->add('sunday',             $_MYCALJP2_DEFAULT['sunday'],             'text',     0, 0, 0,    $o++, true, $n);
    $c->add('monday',             $_MYCALJP2_DEFAULT['monday'],             'text',     0, 0, 0,    $o++, true, $n);
    $c->add('tuesday',            $_MYCALJP2_DEFAULT['tuesday'],            'text',     0, 0, 0,    $o++, true, $n);
    $c->add('wednesday',          $_MYCALJP2_DEFAULT['wednesday'],          'text',     0, 0, 0,    $o++, true, $n);
    $c->add('thursday',           $_MYCALJP2_DEFAULT['thursday'],           'text',     0, 0, 0,    $o++, true, $n);
    $c->add('friday',             $_MYCALJP2_DEFAULT['friday'],             'text',     0, 0, 0,    $o++, true, $n);
    $c->add('saturday',           $_MYCALJP2_DEFAULT['saturday'],           'text',     0, 0, 0,    $o++, true, $n);
    $c->add('showholiday',        $_MYCALJP2_DEFAULT['showholiday'],        'select',   0, 0, 1,    $o++, true, $n);
    $c->add('checkjpholiday',     $_MYCALJP2_DEFAULT['checkjpholiday'],     'select',   0, 0, 1,    $o++, true, $n);
    $c->add('enablesrblocks',     $_MYCALJP2_DEFAULT['enablesrblocks'],     'select',   0, 0, 1,    $o++, true, $n);
    $c->add('showstoriesintro',   $_MYCALJP2_DEFAULT['showstoriesintro'],   'select',   0, 0, 1,    $o++, true, $n);
    $c->add('use_theme',          $_MYCALJP2_DEFAULT['use_theme'],          'select',   0, 0, 0,    $o++, true, $n);
    $c->add('template',           $_MYCALJP2_DEFAULT['template'],           'select',   0, 0, NULL, $o++, true, $n);
    $c->add('date_format',        $_MYCALJP2_DEFAULT['date_format'],        'text',     0, 0, 0,    $o++, true, $n);
    $c->add('supported_contents', $_MYCALJP2_DEFAULT['supported_contents'], '%text',    0, 0, NULL, $o++, true, $n);
    $c->add('enabled_contents',   $_MYCALJP2_DEFAULT['enabled_contents'],   '%text',    0, 0, NULL, $o++, true, $n);
    // ----------------------------------
    $c->add('fs_staticpages',     NULL,                                     'fieldset', 0, 1, NULL, 0,    true, $n);
    $c->add('sp_type',            $_MYCALJP2_DEFAULT['sp_type'],            'select',   0, 1, 14,   $o++, true, $n);
    $c->add('sp_except',          $_MYCALJP2_DEFAULT['sp_except'],          'text',     0, 1, 0,    $o++, true, $n);

    if (function_exists('COM_versionCompare')) {
        MYCALJP_update_ConfValues_addTabs();
    }

    $new_group_id = MYCALJP_helper_get_new_group_id();

    // ----------------------------------
    $c->add('tab_mycaljp_block',  NULL,                                     'tab',      0, 2, NULL, 0,    true, $n, 2);
    $c->add('fs_block_settings',  NULL,                                     'fieldset', 0, 2, NULL, 0,    true, $n, 2);
    $c->add('block_enable',       $_MYCALJP2_DEFAULT['block_enable'],       'select',   0, 2, 0,    $o++, true, $n, 2);
    $c->add('block_isleft',       $_MYCALJP2_DEFAULT['block_isleft'],       'select',   0, 2, 0,    $o++, true, $n, 2);
    $c->add('block_order',        $_MYCALJP2_DEFAULT['block_order'],        'text',     0, 2, 0,    $o++, true, $n, 2);
    $c->add('block_topic_option', $_MYCALJP2_DEFAULT['block_topic_option'], 'select',   0, 2, 15,   $o++, true, $n, 2);
    $c->add('block_topic',        $_MYCALJP2_DEFAULT['block_topic'],        '%select',  0, 2, NULL, $o++, true, $n, 2);
    // ----------------------------------
    $c->add('fs_block_permissions', NULL,                                   'fieldset', 0, 3, NULL, 0,    true, $n, 2);
    $c->add('block_group_id',     $new_group_id,                            'select',   0, 3, NULL, $o++, true, $n, 2);
    $c->add('block_permissions',  $_MYCALJP2_DEFAULT['block_permissions'],  '@select',  0, 3, 16,   $o++, true, $n, 2);

    return true;
}

function MYCALJP_updateSortOrder()
{
    global $_TABLES;

    $conf_vals = array(
        'headertitleyear',
        'headertitlemonth',
        'titleorder',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'showholiday',
        'checkjpholiday',
        'enablesrblocks',
        'showstoriesintro',
        'use_theme',
        'template',
        'date_format',
        'supported_contents',
        'enabled_contents',
        'sp_type',
        'sp_except',
        'block_enable',
        'block_isleft',
        'block_order',
        'block_topic_option',
        'block_topic',
        'block_group_id',
        'block_permissions',
    );
    $o = 1;
    foreach ($conf_vals as $val) {
        $sql = "UPDATE {$_TABLES['conf_values']} "
             . "SET sort_order = $o "
             . "WHERE name = '$val' AND group_name = 'mycaljp'";
        DB_query($sql);
        $o++;
    }
}

function MYCALJP_update_ConfValues_addTabs()
{
    global $_TABLES;

    // Add in all the Tabs for the configuration UI
    $c = config::get_instance();
    $c->add('tab_main',        NULL, 'tab', 0, 0, NULL, 0, true, 'mycaljp', 0);
    $c->add('tab_staticpages', NULL, 'tab', 0, 1, NULL, 0, true, 'mycaljp', 1);

    DB_query("UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'mycaljp'");

    return true;
}

function MYCALJP_update_ConfValues_2_1_4()
{
    global $_TABLES;

    $new_group_id = MYCALJP_helper_get_new_group_id();

    $c = config::get_instance();
    $n = 'mycaljp';
    $o = 1;
    // ----------------------------------
    $c->add('tab_mycaljp_block',  NULL,                                     'tab',      0, 2, NULL, 0,    true, $n, 2);
    $c->add('fs_block_settings',  NULL,                                     'fieldset', 0, 2, NULL, 0,    true, $n, 2);
    $c->add('block_enable',       $_MYCALJP2_DEFAULT['block_enable'],       'select',   0, 2, 0,    $o++, true, $n, 2);
    $c->add('block_isleft',       $_MYCALJP2_DEFAULT['block_isleft'],       'select',   0, 2, 0,    $o++, true, $n, 2);
    $c->add('block_order',        $_MYCALJP2_DEFAULT['block_order'],        'text',     0, 2, 0,    $o++, true, $n, 2);
    $c->add('block_topic_option', $_MYCALJP2_DEFAULT['block_topic_option'], 'select',   0, 2, 15,   $o++, true, $n, 2);
    $c->add('block_topic',        $_MYCALJP2_DEFAULT['block_topic'],        '%select',  0, 2, NULL, $o++, true, $n, 2);
    // ----------------------------------
    $c->add('fs_block_permissions', NULL,                                   'fieldset', 0, 3, NULL, 0,    true, $n, 2);
    $c->add('block_group_id',     $new_group_id,                            'select',   0, 3, NULL, $o++, true, $n, 2);
    $c->add('block_permissions',  $_MYCALJP2_DEFAULT['block_permissions'],  '@select',  0, 3, 16,   $o++, true, $n, 2);

    // fixed type of 'enabled_contents' from '%text' to '*text'
    $sql = "UPDATE {$_TABLES['conf_values']} "
         . "SET type = '*text' "
         . "WHERE name = 'enabled_contents' AND group_name = 'mycaljp'";
    DB_query($sql);

    return true;
}

function MYCALJP_helper_get_new_group_id()
{
    global $_GROUPS, $_TABLES;

    $new_group_id = 0;
    if (isset($_GROUPS['Mycaljp Admin'])) {
        $new_group_id = $_GROUPS['Mycaljp Admin'];
    } else {
        $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Mycaljp Admin'");
        if ($new_group_id == 0) {
            if (isset($_GROUPS['Root'])) {
                $new_group_id = $_GROUPS['Root'];
            } else {
                $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            }
        }
    }

    return $new_group_id;
}

?>