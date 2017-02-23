<?php

// +---------------------------------------------------------------------------+
// | Geeklog Dbman Plugin for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/dbman/index.php                                 |
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
* Dbman plugin admin index file based on Geeklog 'databse.php' file
*/
global $_CONF, $_USER;

require_once '../../../lib-common.php';

if (!in_array('dbman', $_PLUGINS)) {
	echo COM_refresh($_CONF['site_url']);
	exit;
}

if (!defined('XHTML')) {
	define('XHTML', '');
}

if (!is_callable('COM_output')) {
	function COM_output($output) {
		header('Content-Type: text/html; charset=' . COM_getCharset());
		echo $output;
		exit;
	}
}

if (!is_callable('COM_createHTMLDocument')) {
	function COM_createHTMLDocument($content) {
		return COM_siteHeader() . $content . COM_siteFooter();
	}
}

$content = '';

// Checks if user has rights to access this page
if (!SEC_hasRights('dbman.edit')) {
	// Someone is trying to illegally access this page
	COM_errorLog("Someone has tried to illegally access the Dbman page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = COM_startBlock($LANG_DBMAN['access_denied'])
			 . DBMAN_str('access_denied_msg')
			 . COM_endBlock();
	$display = COM_createHTMLDocument($content);
	COM_output($display);
	exit;
}

// ==================================================================
// 		Main function
// ==================================================================

// The three values set below are meaningful only the first time this file is called
$add_drop_table   = $_DBMAN_CONF['add_drop_table'];
$compress_data    = $_DBMAN_CONF['compress_data'];
$download_as_file = $_DBMAN_CONF['download_as_file'];

// Decides whether to list or backup or restore
$cmd = 'list';

if (isset($_GET['cmd'])) {
	$cmd = COM_applyFilter($_GET['cmd']);
} elseif (isset($_POST['cmd'])) {
	$cmd = COM_applyFilter($_POST['cmd']);
}

if (isset($_GET['msg'])) {
	$msg = COM_applyFilter($_GET['msg']);
} else {
	$msg = 0;
}

$is_submit = isset($_POST['submit']);

if ($msg > 0) {
	$content .= COM_startBlock(DBMAN_str('access_denied'))
			 .  '<p style="border: solid 2px red; padding: 5px;">'
			 .  '<img src="' . $_CONF['site_url'] 
			 .  '/layout/professional/images/sysmessage.png' . '"' . XHTML
			 .  '>  ' .  DBMAN_str('errmsg' . (string) $msg) . '</p>' . LB
			 .  COM_endBlock();
} else {
	switch (strtolower($cmd)) {
		case 'backup':
			if ($is_submit) {
				DBMAN_checkToken();
				$add_drop_table = isset($_POST['add_drop_table']);
				$compress_data  = isset($_POST['compress_data']);
				$download_as_file = isset($_POST['download_as_file']);
				$rst = DBMAN_backup($add_drop_table, $compress_data, $download_as_file);
			
				if ($rst == 2) {		//  failed
					$content .= '<p style="font-size: 20px; font-weight: bold; color: red;">'
						. DBMAN_str('backup_failure')
						. '</p>';
					break;
				} else {		//  success
					if ($rst == 1) {	// in case of download, just exit
						exit;
					} else {	//  redirect to dbman main page
						$content = COM_refresh($_CONF['site_admin_url'] . '/plugins/dbman/index.php') . $content
							. '<p style="font-size: 20px; font-weight: bold; color: green;">'
							. DBMAN_str('backup_success')
							. '</p>';
						break;
					}
				}
			}
			// fall through to 'backup_option'
	
		case 'backup_option':
			$content .= DBMAN_backupOptions($add_drop_table, $compress_data, $download_as_file);
			break;
	
		case 'restore_select':
			$content .= DBMAN_restoreSelectFile();
			break;

		case 'restore_option':
			if ($is_submit) {
				DBMAN_checkToken();
			
				if (isset($_POST['filename'])) {
					$filename = COM_applyFilter($_POST['filename']);	//  not good enough
					$content .= DBMAN_restoreOption($filename);
				} else {
					$content = COM_refresh($_CONF['site_admin_url'] . '/plugins/dbman/index.php?cmd=restore_select') . $content
						. '<p style="font-size: 20px; font-weight: bold; color: red;">'
						. DBMAN_str('no_file_selected')
						. '</p>';
				}
			}
		
			break;
	
		case 'restore':
			if ($is_submit) {
				DBMAN_checkToken();
				$filename = COM_applyFilter($_POST['filename']);	//  maybe not very good
			
				if (isset($_POST['restore_structure'])) {
					$restore_structure = $_POST['restore_structure'];
				}
			
				if (isset($_POST['restore_data'])) {
					$restore_data = $_POST['restore_data'];
				}
			
				if (DBMAN_restore($filename, $restore_structure, $restore_data)) {
					$content = COM_refresh($_CONF['site_admin_url'] . '/plugins/dbman/index.php') . $content
						. '<p style="font-size: 20px; font-weight: bold; color: green;">'
						. DBMAN_str('resore_success')
						. '</p>';
				} else {
					$content .= '<p style="font-size: 20px; font-weight: bold; color: red;">'
							 .  DBMAN_str('restore_failure') . '</p>';
				}
			}
		
			break;
	
		case 'delete':
			if (isset($_POST['deletefiles'])) {
				DBMAN_checkToken();
				$content .= COM_startBlock(DBMAN_str('ttl_delete_file'));
				$deletefiles = $_POST['deletefiles'];
			
				foreach ($deletefiles as $deletefile) {
					$result = DBMAN_delete(COM_applyFilter($deletefile));
				
					if ($result) {
						COM_errorLog("Dbman: successfully deleted {$deletefile}.");
						$content .= '<span style="color: green;">[success]</span> <strong>'
								 .  $deletefile . '</strong><br' . XHTML . '>';
					} else {
						COM_errorLog("Dbman: failed in deleting {$deletefile}.");
						$content .= '<span style="color: red;">[failure]</span> <strong>'
								 .  $deletefile . '</strong><br' . XHTML . '>';
					}
				}
			
				$content .= '<p><a href="' . $_CONF['site_admin_url']
						 .  '/plugins/dbman/index.php' . '">Dbman HOME</a></p>'
						 .  COM_endBlock();
			}
		
			break;
	
		case 'console':
			$content .= DBMAN_showSQLConsole();
			break;
	
		case 'console_exec':
			DBMAN_checkToken();
			$content .= DBMAN_execSQL();
			break;
	
		case 'list':
			$content .= DBMAN_listBackups();
			break;
	}
}

$display = COM_createHTMLDocument($content);
COM_output($display);
