<?php

// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/themedit/upload.php                             |
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

/**
* Security check
*/
if (!SEC_hasRights('themedit.admin')) {
    // Someone is trying to illegally access this page
    COM_errorLog( "Someone has tried to illegally access the themedit uploader.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock(THM_str('access_denied'))
			 . THM_str('access_denied_msg')
			 . COM_endBlock();
    $display = COM_createHTMLDocument($content);
	COM_output($display);
    exit;
}

// Retrives vars
if (get_magic_quotes_gpc()) {
	$_GET    = array_map('stripslashes', $_GET);
	$_POST   = array_map('stripslashes', $_POST);
	$_COOKIE = array_map('stripslashes', $_COOKIE);
}

$theme = '';

if (isset($_GET['thm_theme'])) {
	$theme = COM_applyFilter($_GET['thm_theme']);
} elseif (isset($_POST['thm_theme'])) {
	$theme = COM_applyFilter($_POST['thm_theme']);
}

$all_themes = THM_getAllowedThemes();

if (!in_array($theme, $all_themes)) {
	$theme = $all_themes[0];
}

$selected_dir = 'images/';

if (isset($_POST['thm_dir'])) {
	$selected_dir = $_POST['thm_dir'];
}

$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/themedit/templates');
$T->set_file(
	array(
		'upload' => 'upload.thtml',
		'cell'   => 'cell.thtml'
	)
);
$T->set_var('temp_site_admin_url', $_CONF['site_admin_url']);
$T->set_var('temp_header', THM_str('upload_header'));
$T->set_var('temp_theme', $theme);
$T->set_var('temp_lang_return_to_editor', THM_str('return_to_editor'));
$T->set_var('site_admin_url', $_CONF['site_admin_url']);
$T->set_var('temp_lang_dest', THM_str('dest'));
$T->set_var('temp_lang_script_disabled', THM_str('script_disabled'));
$T->set_var('thm_theme', $theme);
$T->set_var('thm_dir', $selected_dir);

// Sets theme names
$theme_names = THM_getAllowedThemes();
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
$T->set_var('temp_lang_dir', THM_str('dir'));
$allowed_dirs = array(
	'images/', 'images/admin/', 'images/buttons/', 'images/icons/',
	'images/custom/',
);
$temp_dirs = '';

foreach ($allowed_dirs as $allowed_dir) {
	if ($allowed_dir == $selected_dir) {
		$temp_dirs .= '<option selected="selected">';
	} else {
		$temp_dirs .= '<option>';
	}
	
	$temp_dirs .= $allowed_dir . '</option>' . LB;
}

$T->set_var('temp_dirs', $temp_dirs);
$T->set_var('temp_lang_file', THM_str('file'));
$T->set_var('temp_lang_submit', THM_str('upload'));
$T->set_var('temp_lang_change', THM_str('change'));
$T->set_var('temp_lang_delete', THM_str('delete'));
$T->set_var('max_upload_size', THM_str('upload_max_size'));

// Processes uploaded files if any
if (isset($_POST['submit']) && ($_POST['submit'] == $LANG_THM['upload']) &&
		isset($_FILES['thmfile']) && ($_FILES['thmfile']['size'] > 0)) {
	$u_name = $_FILES['thmfile']['name'];
	$u_size = $_FILES['thmfile']['size'];
	$u_tmp  = $_FILES['thmfile']['tmp_name'];
	$path_parts = pathinfo( $u_name );
	
	if ($u_size > $_THM_CONF['upload_max_size']) {
		$T->set_var('temp_sys_message', "<span style='color: red; font-weight: bold;'>{$LANG_THM['file_too_large']}</a>");
	} elseif (!in_array(strtolower($path_parts['extension']), array('jpg', 'jpeg', 'gif', 'png'))) {
		$T->set_var('temp_sys_message', "<span style='color: red; font-weight: bold;'>{$LANG_THM['file_type_unsupported']}</p>");
	} elseif (is_uploaded_file($u_tmp)) {
		$dest = $_CONF['path_themes'] . $theme . '/' . $selected_dir
			  . basename($u_name);
		
		if (@move_uploaded_file($u_tmp, $dest)) {
			$T->set_var('temp_sys_message', "<span style='color: #339933; font-weight: bold;'>{$LANG_THM['upload_success']}</p>");
		} else {
			$T->set_var('temp_sys_message', "<span style='color: red; font-weight: bold;'>{$LANG_THM['upload_fail']}</p>");
		}
	} else {
		$T->set_var('temp_sys_message', "<span style='color: red; font-weight: bold;'>{$LANG_THM['upload_attack']}</p>");
	}
}

// Deletes checked files if any
if (isset($_POST['thm_delete']) && ($_POST['thm_delete'] == $LANG_THM['delete']) && isset($_POST['ch'])) {
	$success = $fail = 0;
	
	foreach ($_POST['ch'] as $checked_file) {
		$entry = $_CONF['path_themes'] . $theme . '/' . $selected_dir . $checked_file;
		
		if (@unlink($entry)) {
			$success++;
		} else {
			$fail++;
		}
	}
	
	$delete_msg = '';
	
	if ($success) {
		$delete_msg = '<span style="color: #339933; font-weight: bold;">' . sprintf($LANG_THM['delete_success'], $success) . '</span>';
		
		if ($fail) {
			$delete_msg .= '&nbsp;&nbsp;';
		}
	}
	
	if ($fail) {
		$delete_msg = '<span style="color: red; font-weight: bold;">' . sprintf($LANG_THM['delete_fail'], $fail) . '</span>';
	}
	
	$T->set_var('temp_sys_message', $delete_msg);
}

// Displays images
$basedir = $_CONF['path_themes'] . $theme . '/' . $selected_dir;
$images  = '';
$num_col = 0;
$dh = @opendir($basedir);

if ($dh !== false) {
	while (($entry = readdir($dh)) !== false) {
		if (is_file($basedir . '/' . $entry)) {
			if (preg_match('/\.(gif|png|jpg|jpeg)$/i', $entry)) {
				if ($num_col == 0) {
					$images .= '<tr>' . LB;
				}
				
				$T->set_var('temp_cell_width', $_THM_CONF['image_width'] + 2);
				$T->set_var('temp_cell_height', $_THM_CONF['image_height'] + 12 + 2);
				$T->set_var('temp_img_src', $_CONF['site_url'] . '/layout/' . $theme . '/' . $selected_dir . $entry);
				$T->set_var('temp_filename', $entry);
				list($width, $height, $type, $dummy) = @getimagesize($basedir . '/' . $entry);
				if ($width > $_THM_CONF['image_width'] || $height > $_THM_CONF['image_height']) {
					if ($width / $_THM_CONF['image_width'] > $height / $_THM_CONF['image_height']) {
						$height = floor($height * ($_THM_CONF['image_width'] / $width));
						$width  = $_THM_CONF['image_width'];
					} else {
						$width = floor($width * ($_THM_CONF['image_height'] / $height));
						$height = $_THM_CONF['image_height'];
					}
				}
				
				$T->set_var('temp_img_width', $width);
				$T->set_var('temp_img_height', $height);
				$path = $basedir . '/' . $entry;
				$T->set_var('temp_getimage_url', $_CONF['site_admin_url'] . "/plugins/themedit/getimage.php?path={$path}");
				$T->parse('output', 'cell');
				$images .= '<td>' . $T->finish($T->get_var('output')) . '</td>' . LB;
				$num_col ++;
				
				if ($num_col >= $_THM_CONF['image_max_col']) {
					$num_col = 0;
					$images .= '</tr>' . LB;
				}
			}
		}
	}
}

if ($num_col > 0) {
	$images .= '</tr>' . LB;
}

$T->set_var('temp_images', $images);
$T->parse('output','upload');
$content = $T->finish($T->get_var('output'));
$display = COM_createHTMLDocument($content);
COM_output($display);
