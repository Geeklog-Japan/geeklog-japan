<?php

// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/themedit/getimage.php                           |
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
    COM_errorLog("Someone has tried to illegally access the themedit uploader.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock(THM_str('access_denied'))
			 . THM_str('access_denied_msg')
			 . COM_endBlock();
    $display = COM_createHTMLDocument($content);
	COM_output($display);
    exit;
}

$path = $_GET['path'];
$info = pathinfo($path);

// Creates an image
switch (strtolower($info['extension'])) {
	case 'jpg':
	case 'jpeg':
		$type = 'jpeg';
		$im   = @imagecreatefromjpeg($path);
		break;
	
	case 'png':
		$type = 'png';
		$im   = @imagecreatefrompng($path);
		break;
	
	case 'gif':
		$type = 'gif';
		$im   = @imagecreatefromgif($path);
		break;
	
	default:
		$type = 'none';
		$im   = FALSE;
		break;
}

// Displays the image
if ($im === FALSE) {
	COM_errorLog("themedit: invalid path or GD unsupported: {$path}");
} else {
	header("Content-Type: image/{$type}");
	
	if ($type === 'jpeg') {
		imagejpeg($im);
	} else if ($type === 'png') {
		imagepng($im);
	} else if ($type === 'gif') {
		imagegif($im);
	}
	
	imagedestroy($im);
}
