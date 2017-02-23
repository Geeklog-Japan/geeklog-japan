<?php

// +---------------------------------------------------------------------------+
// | Japanize Plugin for Geeklog - The Ultimate Weblog                         |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/japanize/index.php                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tsuchi           - tsuchi AT geeklog DOT jp                      |
// |          mystral-kk       - geeklog AT mystral-kk DOT net                 |
// +---------------------------------------------------------------------------+
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

require_once '../../../lib-common.php';

if (!SEC_hasRights('japanize.edit')) {
    $content = COM_startBlock($MESSAGE[30], '', COM_getBlockTemplate('_msg_block', 'header'))
             . $MESSAGE[35]
             . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
    $display = is_callable('COM_createHTMLDocument')
             ? COM_createHTMLDocument($content)
             : COM_siteHeader() . $content . COM_siteFooter();
    COM_accessLog('User ' . $_USER['username'] . ' tried to illegally access the japanize administration screen.');
    echo $display;
    exit;
}

// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+

// Gets the current state of Japanization
if (DB_getItem($_TABLES['vars'], 'COUNT(*)', "name='japanize_plugin'") == 1) {
    $current = (int) DB_getItem($_TABLES['vars'], 'value', "name='japanize_plugin'");
} else {
    $current = 0;
}

$needChange = false;

if (isset($_POST['japanize_all']) &&
        ($_POST['japanize_all'] === JAPANIZE_str('japanize_all'))) {
    $A = 63;
    $needChange = true;
} elseif (isset($_POST['restore_all']) &&
        ($_POST['restore_all'] === JAPANIZE_str('restore_all'))) {
    $A = 0;
    $needChange = true;
} elseif (isset($_POST['execute']) &&
        ($_POST['execute'] === JAPANIZE_str('execute')) &&
        isset($_POST['A']) && is_array($_POST['A'])) {
    $A = 0;
    $needChange = true;
    
    foreach ($_POST['A'] as $value) {
        $A += (int) COM_applyFilter($value, true);
    }
} else {
    $A = $current;
}

$checked = array(
    1 => (($A &  1) ===  1),
    2 => (($A &  2) ===  2),
    3 => (($A &  4) ===  4),
    4 => (($A &  8) ===  8),
    5 => (($A & 16) === 16),
    6 => (($A & 32) === 32),
);

$japanized = array(
    1 => (($current &  1) ===  1),
    2 => (($current &  2) ===  2),
    3 => (($current &  4) ===  4),
    4 => (($current &  8) ===  8),
    5 => (($current & 16) === 16),
    6 => (($current & 32) === 32),
);

$new = 0;
$msgs = array();

if ($needChange && SEC_checkToken()) {
    for ($type = 1; $type <= 6; $type++) {
        if ($checked[$type]) {
            $new += pow(2, $type - 1);
        }
        
        if ($checked[$type] !== $japanized[$type]) {
            $lang = $checked[$type] ? 'ja' : 'en';
            JAPANIZE_execute($type, $lang);
            $msgs[] = JAPANIZE_str('msg_' . $lang . '_' . $type);
        }
    }
	
	// Clear cached data
	if (is_callable('CTL_clearCache')) {
		CTL_clearCache();
	}
} else {
    $new = $current;
}

if (count($msgs) > 0) {
    $li_style = ' style="margin: 0 0 0 2em; padding: 0;"';
    $msgs = '<ol style="background-color: #ccff99; padding: 3px; border: solid 1px #33ccff;">'
          . '<li' . $li_style . '>'
          . implode('</li><li' . $li_style . '>', $msgs)
          . '</li></ol>';
} else {
    $msgs = '';
}

if (DB_getItem($_TABLES['vars'], 'COUNT(*)', "name='japanize_plugin'") == 1) {
    $sql = "UPDATE {$_TABLES['vars']} "
         . "SET value = '" . DB_escapeString($new) . "' "
         . "WHERE (name = 'japanize_plugin') ";
} else {
    $sql = "INSERT INTO {$_TABLES['vars']} (name, value) "
         . "VALUES ('japanize_plugin', '" . DB_escapeString($new) . "') ";
}

DB_query($sql);

$T = new Template($_CONF['path'] . 'plugins/japanize/templates/admin');
$T->set_file('admin', 'index.thtml');
$T->set_var(array(
    'checked1'          => ($checked[1] ? ' checked="checked"' : ''),
    'checked2'          => ($checked[2] ? ' checked="checked"' : ''),
    'checked3'          => ($checked[3] ? ' checked="checked"' : ''),
    'checked4'          => ($checked[4] ? ' checked="checked"' : ''),
    'checked5'          => ($checked[5] ? ' checked="checked"' : ''),
    'checked6'          => ($checked[6] ? ' checked="checked"' : ''),
    'icon_url'          => plugin_geticon_japanize(),
    'lang_cancel'       => JAPANIZE_str('cancel'),
    'lang_execute'      => JAPANIZE_str('execute'),
    'lang_japanize_all' => JAPANIZE_str('japanize_all'),
    'lang_piname'       => JAPANIZE_str('piname'),
    'lang_restore_all'  => JAPANIZE_str('restore_all'),
    'msgs'              => $msgs,
    'site_admin_url'    => $_CONF['site_admin_url'],
    'token_name'        => CSRF_TOKEN,
    'token_value'       => SEC_createToken(),
    'xhtml'             => XHTML,
));
$T->parse('output', 'admin');
$content = $T->finish($T->get_var('output'));
$display = is_callable('COM_createHTMLDocument')
         ? COM_createHTMLDocument($content)
         : COM_siteHeader() . $content . COM_siteFooter();

if (is_callable('COM_output')) {
    COM_output($display);
} else {
    echo $display;
}
