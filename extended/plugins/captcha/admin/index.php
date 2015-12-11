<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v3.3 Plugin                                                       |
// +---------------------------------------------------------------------------+
// | Admin Interface to CAPTCHA Plugin.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                         |
// |                                                                           |
// | ben           cordiste AT free DOT fr                                     |
// |                                                                           |
// | Based on the original CAPTCHA Plugin                                      |
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Mark R. Evans - mark AT glfusion DOT org                                  | 
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

require_once('../../../lib-common.php');

function CP_array_sort($array, $key) {
    for ($i=0;$i<sizeof($array);$i++) {
        $sort_values[$i] = $array[$i][$key];
    }
    asort($sort_values);
    reset($sort_values);
    while (list($arr_key, $arr_val) = each($sort_values)) {
        $sorted_arr[] = $array[$arr_key];
    }
    return $sorted_arr;
}


// Only let admin users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the CAPTCHA Administration page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    $display  = COM_siteHeader();
    $display .= COM_startBlock($LANG27[12]);
    $display .= $LANG27[12];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    echo $display;
    exit;
}

$msg = '';

if ( isset($_POST['mode']) ) {
    $mode = COM_applyFilter($_POST['mode']);
} else {
    $mode = '';
}

if ( $mode == $LANG_CP00['cancel'] && !empty($LANG_CP00['cancel']) ) {
    header('Location:' . $_CONF['site_admin_url'] . '/moderation.php');
    exit;
}


$display = '';

$T = new Template($_CONF['path'] . 'plugins/captcha/templates');
$T->set_file (array ('admin' => 'admin.thtml'));

$link = "<form name='captcha_conf_link' action='{$_CONF['site_admin_url']}/configuration.php' method='POST'>"
				 . "<input type='hidden' name='conf_group' value='captcha'></form>"
				 . "<a href='#' onclick=\"document.captcha_conf_link.submit()\">"
				 . "{$LANG_CP00['conf_link']}</a>";
				 
$T->set_var(array(
    'site_admin_url'            => $_CONF['site_admin_url'],
    'site_url'                  => $_CONF['site_url'],
    'lang_overview'             => sprintf($LANG_CP00['captcha_info'], 'http://geeklog.fr/wiki/plugins:captcha'),
	'config_link'               => $link,
    'lang_view_logfile'         => $LANG_CP00['view_logfile'],
    'lang_msg'                  => $msg,
	'lang_admin'                => $LANG_CP00['plugin'],
    'version'                   => $_CP_CONF['version'],
    's_form_action'             => $_CONF['site_admin_url'] . '/plugins/captcha/index.php',
));



$T->parse('output', 'admin');
$display .= $T->finish($T->get_var('output'));

// View Log

$log = isset($_REQUEST['log']) ? COM_applyFilter($_REQUEST['log']) : '';

$display .= COM_startBlock();

$T = new Template($_CONF['path'] . '/plugins/captcha/templates');
$T->set_file (array ('admin' => 'administration.thtml'));

$T->set_var(array(
    'site_admin_url'    => $_CONF['site_admin_url'],
    'site_url'          => $_CONF['site_url'],
    'lang_admin'        => $LANG_CP00['plugin'],
    'version'           => $_CP_CONF['version'],
));

$retval .= "<br" . XHTML . '><p>' . $LANG_CP00['view_log'] . '</p>';
$retval .= "<form method=\"post\" action=\"{$_CONF['site_admin_url']}/plugins/captcha/index.php\">";
$retval .= "{$LANG_CP00['file']}&nbsp;&nbsp;&nbsp;";
$files = array();

if ($dir = @opendir($_CONF['path_log'])) {
    while(($file = readdir($dir)) !== false) {
        if (is_file($_CONF['path_log'] . $file)) { array_push($files,$file); }
    }
    closedir($dir);
}

$retval .= '<select name="log">';
if (empty($log)) { $log = $files[0]; } // default file to show
for ($i = 0; $i < count($files); $i++) {
    $retval .= '<option value="' . $files[$i] . '"';
    if ($log == $files[$i]) { $retval .= ' selected="selected"'; }
    $retval .= '>' . $files[$i] . '</option>';
    next($files);
}
$retval .= "</select>&nbsp;&nbsp;&nbsp;&nbsp;";
$retval .= "<input type=\"submit\" name=\"action\" value=\"{$LANG_CP00['view_file']}\"" . XHTML . ">";
$retval .= "&nbsp;&nbsp;&nbsp;&nbsp;";
$retval .= "<input type=\"submit\" name=\"action\" value=\"{$LANG_CP00['clear_file']}\"" . XHTML . ">";
$retval .= "</form>";

$action = COM_applyFilter($_REQUEST['action']);

if ($action == $LANG_CP00['clear_file']) {
    @unlink($_CONF['path_log'] . $log);
    $timestamp = strftime( "%c" );
    $fd = fopen( $_CONF['path_log'] . $log, 'a' );
    fputs( $fd, "$timestamp - {$LANG_CP00['file_cleared']} \n" );
    fclose($fd);
    $action = $LANG_CP00['view_file'];
}
if ($action == $LANG_CP00['view_file']) {
    $retval .= "<hr" . XHTML . "><p><b>{$LANG_CP00['file']} " . $log . "</b></p><div class=\"captcha_logview\">";
	if (file_exists($_CONF['path_log'] . $log)) {
    $retval .= implode('<br' . XHTML . '><br' . XHTML . '>', file($_CONF['path_log'] . $log));
	}
    $retval .= "</div>";
}

$T->set_var(array(
    'admin_body'    => $retval,
    'title'         => $LANG_CP00['log_viewer'],
));

$T->parse('output', 'admin');
$display .= $T->finish($T->get_var('output'))  . COM_endBlock();

//Output

if (function_exists("COM_createHTMLDocument")) {
    //Geeklog 2.0+
	COM_output(COM_createHTMLDocument($display));
} else {
    COM_output(COM_siteHeader() . $display . COM_siteFooter(true));
    
}


?>