<?php

// +---------------------------------------------------------------------------+
// | nmoxtopicown Geeklog Plugin                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2012 by nmox                                           |
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
// +---------------------------------------------------------------------------+

require_once '../../../lib-common.php';

// Checks if the current user is allowed to administer this page
if (!SEC_hasRights('nmoxtopicown.edit')) {
	COM_errorLog("Someone has tried to illegally access the nmoxtopicown page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
	$content = '<div style="margin: 50px;">' . $LANG_NMOXTOPICOWN['access_denied']
			 . '</div>';
	
	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
		$display = COM_siteHeader() . $content . COM_siteFooter();
	}
	
	if (is_callable('COM_output')) {
		COM_output($display);
	} else {
		echo $display;
	}
	
	exit;
}

class Nmoxtopicown
{
	private $_charset;
	private $_gl150 = TRUE;
	private $_gl200 = TRUE;
	
	public function __construct()
	{
		global $_CONF, $LANG_CHARSET;
		
		$version = preg_replace("/[^0-9.]/", '', VERSION);
		$this->_gl150 = version_compare($version, '1.5.0', '>=');
		$this->_gl200 = version_compare($version, '2.0.0', '>=');
		
		if (is_callable('COM_getCharset')) {
			$charset = COM_getCharset();
		} else {
			if (empty($LANG_CHARSET)) {
				$charset = $_CONF['default_charset'];
			
				if (empty($charset)) {
					$charset = 'iso-8859-1';
				}
			} else {
				$charset = $LANG_CHARSET;
			}
		}
		
		$this->_charset = $charset;
	}
	
	public function esc($str)
	{
		return htmlspecialchars($str, ENT_QUOTES, $this->_charset);
	}
	
	public function str($index)
	{
		global $LANG_NMOXTOPICOWN;
		
		if (isset($LANG_NMOXTOPICOWN[$index])) {
			return $this->esc($LANG_NMOXTOPICOWN[$index]);
		} else {
			return '?';
		}
	}
	
	public function listup()
	{
		global $_CONF, $_TABLES, $LANG_NMOXTOPICOWN;
		
		// Stores user info
		$users = array();
		$result = DB_query("SELECT uid, username FROM " . $_TABLES['users']);
		
		while (($A = DB_fetchArray($result, FALSE)) !== FALSE) {
			$users[] = array('uid' => $A['uid'], 'username' => $A['username']);
		}
		
		$T = new Template($_CONF['path'] . 'plugins/nmoxtopicown/templates');
		$T->set_file('admin', 'admin.thtml');
		$T->set_file('item', 'item.thtml');
		$T->set_var('xhtml', XHTML);
		$T->set_var('this_script', $_CONF['site_admin_url'] . '/plugins/nmoxtopicown/index.php');
		$T->set_var('lang_title', $this->str('nmoxtopicown'));
		$T->set_var('lang_ok', $this->str('ok'));
		$T->set_var('lang_caution', $this->str('message_caution'));
		$T->set_var('lang_change_writer', $this->str('change_writer'));

		if ($this->_gl150) {
			$T->set_var('token_name', CSRF_TOKEN);
			$T->set_var('token_value', SEC_createToken());
		}

		if (isset($_GET['msg']) AND !empty($_GET['msg'])) {
			$T->set_var('done', '<div>' . $this->str('done') . '</div>');
		}
		
		$n = 1;
		$result = DB_query("SELECT topic, tid, owner_id FROM " . $_TABLES['topics']);
		
		while (($A = DB_fetchArray($result, FALSE)) !== FALSE) {
			$T->set_var('topic', $this->esc($A['topic']));
			$T->set_var('n', $n);
			$T->set_var('tid', $A['tid']);
			
			$options = '';
			
			foreach ($users as $user) {
				$options .= '<option value="' . $user['uid'] . '"'
						 .  ($user['uid'] == $A['owner_id'] ? ' selected="selected"' : '')
						 .  '>' . $this->esc($user['username']) . '</option>';
			}
			
			$T->set_var('options', $options);
			$T->parse('output', 'item');
			$T->set_var('items', $T->get_var('output'), TRUE);
			$n ++;
		}
		
		$T->parse('output', 'admin');
		
		return $T->finish($T->get_var('output'));
	}
	
	/**
	* Changes the owner of a topic
	*
	* @param   string  $uid  new user id
	* @param   string  $tid  topic id to be changed
	* @return  (void)
	*/
	protected function _changeOwner($uid, $tid)
	{
		global $_TABLES;
		
		$uid = (int) $uid;
		$tid = addslashes($tid);
		
		$sql1 = "UPDATE {$_TABLES['topics']} "
			  . "  SET owner_id = {$uid} "
			  . "  WHERE (tid ='{$tid}') ";
		
		if ($this->_gl200) {
			$sql2 = "UPDATE {$_TABLES['stories']} "
				  . "  SET owner_id = $uid "
				  . "  WHERE (sid IN ("
				  . "    SELECT id "
				  . "      FROM {$_TABLES['topic_assignments']} "
				  . "      WHERE ((type = 'article') AND (tid = '{$tid}')) "
				  . "  )"
				  . "  ) ";
		} else {
			$sql2 = "UPDATE {$_TABLES['stories']} "
				  . "  SET owner_id = {$uid} "
				  . "  WHERE (tid = '{$tid}') ";
		}
		
		DB_query($sql1);
		DB_query($sql2);
	}
	
	/**
	* Changes the uid of stories with a given topic id
	*
	* @param   string  $uid  new user id
	* @param   string  $tid  topic id to be changed
	* @return  (void)
	*/
	protected function _changeUid($uid, $tid)
	{
		global $_TABLES;
		
		$uid = (int) $uid;
		$tid = addslashes($tid);
		
		if ($this->_gl200) {
			$sql = "UPDATE {$_TABLES['stories']} "
				 . "  SET uid = {$uid} "
				 . "  WHERE (sid IN ("
				 . "    SELECT id "
				 . "      FROM {$_TABLES['topic_assignments']} "
				 . "      WHERE ((type = 'article') AND (tid = '{$tid}')) "
				 . "  )"
				 . "  ) ";
		} else {
			$sql = "UPDATE {$_TABLES['stories']} "
				 . "  SET uid = {$uid} "
				 . "  WHERE (tid = '{$tid}') ";
		}
		
		DB_query($sql);
	}
	
	public function dbset()
	{
		for ($n = 1; $n < 1000; $n ++) {
			$f_uid = 'uid' . $n;
			$f_tid = 'tid' . $n;
			$f_chk = 'touser' . $n;
			
			if (isset($_POST[$f_uid]) AND is_numeric($_POST[$f_uid]) AND
				isset($_POST[$f_tid])){
				$this->_changeOwner($_POST[$f_uid], $_POST[$f_tid]);
				
				if (isset($_POST[$f_chk]) AND ((int) $_POST[$f_chk] === 1)) {
					$this->_changeUid($_POST[$f_uid], $_POST[$f_tid]);
				}
			} else {
				break;
			}
		}
	}
}

//===================================================================
// Main
//===================================================================

$cl = new Nmoxtopicown();

if (isset($_POST['mode'])) {
	$mode = COM_applyFilter($_POST['mode']);
} else {
	$mode = '';
}

if ($mode === 'dbset') {
	if (is_callable('SEC_checkToken') AND !SEC_checkToken()) {
		exit($LANG_NMOXTOPICOWN['invalid_token']);
	} else {
		$html = $cl->dbset();
		header('Location: ' . $_CONF['site_admin_url'] . '/plugins/nmoxtopicown/index.php?msg=done');
		exit;
	}
} else {
	$html = $cl->listup();
}

if (is_callable('COM_createHTMLDocument')) {
	$display = COM_createHTMLDocument($html);
} else {
	$display = COM_siteHeader() . $html . COM_siteFooter();
}

if (is_callable('COM_output')) {
	COM_output($display);
} else {
	echo $display;
}
