<?php

// +---------------------------------------------------------------------------+
// | Geeklog Dbman Plugin for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/dbman/download.php                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2016 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// +---------------------------------------------------------------------------+

/**
* Dbman plugin download controller file
*/
require_once '../../../lib-common.php';

if (!in_array('dbman', $_PLUGINS)) {
	echo COM_refresh($_CONF['site_url']);
	exit;
}

// Check if user has rights to access this page
if (!SEC_hasRights('dbman.edit')) {
	// Someone is trying to illegally access this page
	COM_errorLog("Dbman: Someone has tried to illegally access the Dbman page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock($LANG_DBMAN['access_denied'])
			 . DBMAN_str('access_denied_msg')
			 . COM_endBlock();
	
	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
		$display = COM_siteHeader() . $content . COM_siteFooter();
	}
	
	echo $display;
	exit;
}

// Checks if filename contains directory, or if filename ends with '.sql' or '.sql.gz'
$filename = COM_applyFilter($_GET['filename']);

if (($filename !== basename($filename)) ||
	(!preg_match('/\.sql$/i', $filename) && !preg_match('/\.sql\.gz$/i', $filename))) {
	// Invalid file name was designated.
	COM_errorLog("Invalid file name was designated for download.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock($LANG_DBMAN['access_denied'])
			 . DBMAN_str('access_denied_msg')
			 . COM_endBlock();

	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
		$display = COM_siteHeader() . $content . COM_siteFooter();
	}

	echo $display;
	exit;
}

// Checks if the file really exists
$filename = $_CONF['backup_path'] . $filename;
clearstatcache();

if (!file_exists($filename)) {
	// The designated file doesn't exist
	COM_errorLog("Dbman: The file you designated doesn't exist.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock($LANG_DBMAN['access_denied'])
			 . $LANG_DBMAN['file_not_found']
			 . COM_endBlock();

	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
		$display = COM_siteHeader() . $content . COM_siteFooter();
	}

	echo $display;
	exit;
}

// Download it!
clearstatcache();
$info = pathinfo($filename);

if ($info['extension'] === 'gz') {
	header("Content-type: application/x-gzip");
} else {
	header("Content-type: text/x-sql");
//	header("Content-type: application/octetstream");
}

header("Content-Disposition: attachment; filename={$info['basename']}");
readfile($filename);
