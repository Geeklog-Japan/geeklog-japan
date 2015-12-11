<?php

// +---------------------------------------------------------------------------+
// | Custom function to change user's themes forcibly when the default theme   |
// | of the site changes                                                       |
// +---------------------------------------------------------------------------+
// | geeklog/system/custom/custom_forcethemechange.php                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 mystral-kk - geeklog AT mystral-kk DOT net             |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), strtolower(basename(__FILE__))) !== FALSE) {
    die('This file can not be used on its own.');
}

/**
* サイトのデフォルトテーマが変化した場合のコールバック関数
*/
function CUSTOM_forceThemeChange() {
    global $_CONF, $_TABLES;
    
    if ($_CONF['allow_user_themes']) {
        // ユーザーがテーマを選択できる場合は、新しいテーマに強制的に変更する
        $sql = "UPDATE {$_TABLES['users']} "
             . "SET theme = '" . addslashes($_CONF['theme']) . "' ";
        
        $previousTheme = DB_getItem($_TABLES['vars'], 'value', 'name="previous_theme"');
        
        if ($previousTheme != '') {
            $sql .= "WHERE (theme = '" . addslashes($previousTheme) . "') ";
        }
        
        DB_query($sql);
        
        // 現在のテーマをDBに保存する
        if ($previousTheme != '') {
            $sql = "UPDATE {$_TABLES['vars']} "
                 . "SET value = '" . addslashes($_CONF['theme']) . "' "
                 . "WHERE (name ='previous_theme') ";
        } else {
            $sql = "INSERT INTO {$_TABLES['vars']} (name, value) "
                 . "VALUES ('previous_theme', '" . addslashes($_CONF['theme']) . "') ";
        }
        
        DB_query($sql);
    }
}

/**
* コンフィギュレーションが変化した場合のコールバック関数
*
* @param   string  $group    グループ名/プラグイン名
* @param   array   $changes  変化したコンフィギュレーション名の配列
* @return  void
*/
function CUSTOM_configchange($group, $changes = array()) {
    global $_CONF, $_TABLES;
    
    if (strcasecmp($group, 'Core') === 0) {
        if (in_array('theme', $changes)) {
            CUSTOM_forceThemeChange();
        }
    } else {
    }
}