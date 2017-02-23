<?php

// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/themedit/index.php                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2017 - geeklog AT mystral-kk DOT net                   |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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

require_once '../../../lib-common.php';
require_once dirname(__FILE__) . '/compat.php';

if (!defined('XHTML')) {
	define('XHTML', '');
}

/**
* Only lets admin users access this page
*/
if (!SEC_hasRights('themedit.admin')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the themedit Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock(THM_str('access_denied'))
			 . THM_str('access_denied_msg')
			 . COM_endBlock();
	$display = COM_createHTMLDocument($content);
	COM_output($display);
    exit;
}
 
/**
* Main
*/
$sys_message = '';
$file        = '';
$vars        = array();
$op          = '';
$contents    = '';

// Undoes magic_quotes if necessary
if (get_magic_quotes_gpc()) {
	$_GET    = array_map('stripslashes', $_GET);
	$_POST   = array_map('stripslashes', $_POST);
	$_COOKIE = array_map('stripslashes', $_COOKIE);
}

// Checks if themes and/or files are added and/or deleted
switch (strtolower($_THM_CONF['resync_database'])) {
	case 'auto':
		$diff = THM_isAddedOrRemoved();
		
		if ((count($diff['added']) > 0) || (count($diff['removed']) > 0)) {
			THM_updateAll();
		}
		break;
	
	case 'manual':
		$diff = THM_isAddedOrRemoved();
		
		if ((count($diff['added']) > 0) || (count($diff['removed']) > 0)) {
			$link = $_CONF['site_admin_url'] . '/plugins/themedit/index.php?op=updateall';
			$sys_message .= str_replace('%s', $link, $LANG_THM['file_changed']);
		}
		
		break;
	
	case 'ignore':
	default:
		break;
}

// Retrieve request vars
$theme_names = THM_getAllowedThemes();
$theme = @$theme_names[0];

// Theme name
if (isset($_POST['thm_theme'])) {
	$req_theme = COM_applyFilter($_POST['thm_theme']);
} elseif (isset($_GET['thm_theme'])) {
	$req_theme = COM_applyFilter($_GET['thm_theme']);
} else {
	$req_theme = '';
}

if (in_array($req_theme, $theme_names)) {
	$theme = $req_theme;
} else {
	COM_errorLog('Themedit: Unknown theme name posted: ' . $req_theme);
}

// File name
if (isset($_POST['thm_file'])) {
	$req_file = COM_applyFilter($_POST['thm_file']);
} elseif (isset($_GET['thm_file'])) {
	$req_file = COM_applyFilter($_GET['thm_file']);
} else {
	$req_file = '';
}

if (in_array($req_file, $_THM_CONF['allowed_files'])) {
	$file = $req_file;
} else {
	COM_errorLog('Themedit: Unknown file name posted: ' . $req_file);
}

// Operation
if (isset($_POST['thm_op'])) {
	$op = COM_applyFilter($_POST['thm_op']);
} elseif (isset($_GET['op'])) {
	$op = COM_applyFilter($_GET['op']);
}

if (($op == '') && ($file != '')) {
	$op = 'load';
}

// Content being edited
if (isset($_POST['theme_contents'])) {
	$contents = $_POST['theme_contents'];
}

// Checks if $file is writable
if (!empty($file)) {
	if (!THM_isWritable($theme, $file)) {
		$sys_message .= THM_str('not_writable');
		COM_errorLog('Themedit: File is not writable.  Theme: ' . $theme . ' file: ' . $file);
	}
}

// Operation
switch ($op) {
	case $LANG_THM['save']:
		if (!SEC_checkToken()) {
		    COM_errorLog("Themedit: Someone might have tried CSRF attack.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
			COM_refresh($_CONF['site_url']);
			exit;
		}
		
		$result = THM_saveFile($theme, $file, $contents);
		$sys_message = ($result) ? THM_str('save_success') : THM_str('save_fail');
		break;
	
	case $LANG_THM['init']:
		$result = THM_initFile($theme, $file);
		
		if ($result) {
			$contents = THM_getContents($theme, $file);
			$sys_message = THM_str('init_success');
		} else {
			$sys_message = THM_str('init_fail');
		}
		
		break;
	
	case 'updateall':
		THM_updateAll();
		break;
	
	case $LANG_THM['image']:
		header('Location: ' . $_CONF['site_admin_url'] . '/plugins/themedit/upload.php?thm_theme=' . rawurlencode($theme));
		exit;
		break;
	
	default:
		break;
}

// Display
$T = new Template($_CONF['path'] . 'plugins/themedit/templates');
$T->set_file('admin', 'admin.thtml');

// Prevents template engine from removing template vars loaded in <textarea>
$T->set_unknowns('keep');

$T->set_var('xhtml', XHTML);
$T->set_var('temp_site_url', $_CONF['site_url']);
$T->set_var('temp_site_admin_url', $_CONF['site_admin_url']);
$T->set_var('temp_header', THM_str('admin'));
$code4preview = <<<EOD1
<script type="text/javascript">
<!--
	window.open("{$_CONF['site_admin_url']}/plugins/themedit/preview.html", "PREVIEW");
//-->
</script>
EOD1;

if ($op === $LANG_THM['preview']) {
	/**
	* If a file is being edited, first swap its contents with that of the
	* corresponding file saved on the Web, then create a preview, and finally
	* restore the file contents
	*/
	if (!empty($file)) {
		$path_parts = pathinfo($file);
		$is_css = preg_match("/\.css$/i", $file);
		
		if ($is_css) {
			$fh = fopen($_CONF['path_html'] . 'admin/plugins/themedit/preview.css', 'wb');
			
			if ($fh !== false) {
				fwrite($fh, $contents);
				fclose($fh);
			}
		} else {
			$org_contents = THM_getContents($theme, $file);
			THM_saveFile($theme, $file, $contents);
		}
	}
	
	$preview = THM_getPreview();
	
	if (!empty($file) && !$is_css) {
		THM_saveFile($theme, $file, $org_contents);
	}
	
	$preview = preg_replace(
		'/(^.*?<title>).*?(<\/title>.*$)/mi',
		'$1' . THM_str('preview') . '$2',
		$preview
	);
	list(, $dummy) = explode(' ', microtime());
	
	// Makes sure your browser reads a CSS file afresh, not from cache
	if ($is_css) {
		$css_path = $_CONF['site_url'] . '/layout/' . $theme . '/' . $file;
		$alt_css_path = $_CONF['site_admin_url']
					  . '/plugins/themedit/preview.css?dummy=' . $dummy;
		$pos = strpos(strtolower($preview), strtolower($css_path));
		COM_errorLog('$preview: ' . $preview . "\r\n" . '$css_path: ' . $css_path);
		
		if ($pos !== false) {
			$preview = substr($preview, 0, $pos) . $alt_css_path
					 . substr($preview, $pos + strlen($css_path));
		}
//		$preview = str_replace($css_path, $alt_css_path, $preview);
	} else {
		$preview = preg_replace(
			'/(^.*?)(href=".*\.css)(".*$)/im',
			'$1$2?dummy=' . $dummy . '$3',
			$preview
		);
	}
	
	$fh = fopen($_CONF['path_html'] . 'admin/plugins/themedit/preview.html', 'wb');
	
	if ($fh !== false) {
		fwrite($fh, $preview);
		fclose($fh);
	}
	
	$T->set_var('temp_preview_code', $code4preview);
} else {
	$T->set_var('temp_preview_code', '');
}

if (empty($sys_message)) {
	$T->set_var('temp_sys_message', '');
} else {
	$T->set_var(
		'temp_sys_message',
		'<p style="border: solid 2px red; padding: 5px;">' . $sys_message . '</p>'
	);
}

$T->set_var(
	'temp_lang_script_disabled',
	'<p style="color: red; font-weight: bold;">' . THM_str('script_disabled') . '</p>'
);
$T->set_var('temp_lang_select', THM_str('select'));
$T->set_var('temp_lang_theme_edited', THM_str('theme_edited'));
$T->set_var('temp_lang_file_edited', THM_str('file_edited'));

// Sets theme name drop down list
$themes4html = '';

foreach ($theme_names as $theme_name) {
	if ($theme_name == $theme) {
		$themes4html .= "<option value='{$theme_name}' selected='selected'>";
	} else {
		$themes4html .= "<option value='{$theme_name}'>";
	}
	
	$themes4html .= THM_esc($theme_name) . '</option>' . LB;
}

$T->set_var('temp_themes', $themes4html);

// Sets template/css name drop down list
if ($file == '') {
	$files4html = '<option selected="selected">';
} else {
	$files4html = '<option>';
}

$files4html .= '-</option>' . LB;

foreach ($_THM_CONF['allowed_files'] as $allowed_file) {
	if ($allowed_file == $file) {
		$files4html .= "<option value='{$allowed_file}' selected='selected'>";
	} else {
		$files4html .= "<option value='{$allowed_file}'>";
	}
	
	if (isset($LANG_THM[$allowed_file])) {
		$text = THM_str($allowed_file);
	} else {
		$text = $allowed_file;
	}
	
	$files4html .= THM_esc($text) . '</option>' . LB;
}

$T->set_var('temp_files', $files4html);

// Loads template vars & file contents
if (!empty($file)) {
	$vars = THM_getTemplateVars($theme, $file);
}

if ($op === 'load') {
	$contents = THM_getContents($theme, $file);
}

$contents4html = THM_esc($contents);

// In case of a template file, show a list of template vars available
$vars4html = '';

if (count($vars) > 0) {
	$vars4html .= '<table style="border: solid 1px #7F9DB9; padding: 5px; width: 100%">'
			   .  '<caption style="text-align: center; color: white; background-color: #7F9DB9;">'
			   .  THM_str('vars_available') . '</caption>'
			   .  '<tr>' . LB;
	
	for ($i = 0, $j = 0; $i < count($vars); $i ++) {
		$vars4html .= '<td width="150"><button type="button" title="'
				   .  THM_str("help_{$vars[$i]}") . '" onClick="insert_var(\''
				   .  $vars[$i]. '\')"'
				   .  ' style="color: white; background-color: #333366;">'
				   .  $vars[$i] . '</button></td>';
		$j ++;
		
		if ($j % 4 === 0) {
			$vars4html .= '</tr>' . LB . '<tr>';
		}
	}
	
	$vars4html .= '</tr>' . LB
			   .  '</table>' . LB;
}

$T->set_var('temp_vars', $vars4html);
$T->set_var('temp_contents', $contents4html);
$T->set_var('temp_lang_preview', THM_str('preview'));
$T->set_var('temp_lang_save', THM_str('save'));
$T->set_var('temp_lang_image', THM_str('image'));
$T->set_var('temp_lang_init', THM_str('init'));
$T->set_var('temp_token_name', CSRF_TOKEN);
$ttl = DB_getItem(
	$_TABLES['users'], 'cookietimeout', "(uid='" . DB_escapeString($_USER['uid']) . "')"
);
$T->set_var('temp_token_value', SEC_createToken($ttl));
$T->parse('output','admin');
$content = $T->finish($T->get_var('output'));
$display = COM_createHTMLDocument($content);
COM_output($display);
