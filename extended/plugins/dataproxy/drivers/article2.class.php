<?php

// +---------------------------------------------------------------------------+
// | Dataproxy Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/article.class.php                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

class dpxyDriver_Article extends dpxyDriver
{
	/**
	* Returns the location of index.php of each plugin
	*
	* @return  mixed  uri(string) / false(no entry)
	*/
	public function getEntryPoint()
	{
		return false;
	}
	
	public function getChildCategories($pid = false, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$retval = array();
		
		if ($pid !== false) {
			return $retval;
		}
		
		$where = array();
		$sql = "SELECT tid, topic, imageurl "
			 . "FROM {$_TABLES['topics']} ";
		
		if (Dataproxy::uid() > 1) {
			$tids = DB_getItem(
				$_TABLES['userindex'], 'tids', "uid = " . Dataproxy::uid()
			);
			
			if (!empty($tids)) {
				$where[] = "(tid NOT IN ('"
						 .  str_replace(' ', "','", $this->escapeString($tids)) . "'))";
			}
		}
		
		// Adds permission check.
		if (!Dataproxy::isRoot()) {
			$temp = COM_getPermSQL('', Dataproxy::uid());
			
			if (!empty($temp)) {
				$where[] = $temp;
			}
		}

		// Adds lang id.
		if (!Dataproxy::isRoot() && ($all_langs === false)) {
			$temp = COM_getLangSQL('tid', '');
			
			if (!empty($temp)) {
				$where[] = $temp;
			}
		}
		
		if (count($where) > 0) {
			$sql .= " WHERE " . implode(" AND ", $where);
		}
		
		if ($_CONF['sortmethod'] === 'alpha') {
			$sql .= ' ORDER BY topic ASC';
		} else {
			$sql .= ' ORDER BY sortnum';
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = stripslashes($A['tid']);
			$entry['title']     = stripslashes($A['topic']);
			$entry['uri']       = $_CONF['site_url'] . '/index.php?topic=' . $entry['id'];
			$entry['date']      = false;
			$entry['image_uri'] = stripslashes($A['imageurl']);
			$retval[] = $entry;
		}
		
		return $retval;
	}
	
	/**
	* @param  boolean  $all_langs  true = all languages, true = current language
	* Returns array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string),
	*   'raw_data'  => raw data of the item (stripslashed)
	* )
	*/
	public function getItemById($id, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$retval = array();
		
		$sql = "SELECT * "
			 . "  FROM {$_TABLES['stories']} "
			 . "WHERE (sid ='" . $this->escapeString($id) . "') "
			 . "  AND (draft_flag = 0) AND (date <= NOW()) ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getTopicSql('AND', Dataproxy::uid())
				 .  COM_getPermSql('AND', Dataproxy::uid());
			
			if ($all_langs === false) {
				$sql .= COM_getLangSQL('sid', 'AND');
			}
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result) == 1) {
			$A = DB_fetchArray($result, false);
			$A = array_map('stripslashes', $A);
			
			$retval['id']        = $id;
			$retval['title']     = $A['title'];
			$retval['uri']       = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $id);
			$retval['date']      = strtotime($A['date']);
			$retval['image_uri'] = false;
			$retval['raw_data']  = $A;
		}
		
		return $retval;
	}
	
	/**
	* Returns an array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	public function getItems($tid, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$retval = array();
		
		// Collects sids
		$sql = "SELECT id "
			 . "  FROM {$_TABLES['topic_assignments']} "
			 . "WHERE (type= 'article') AND (tdefault = 1) "
			 . "  AND (tid = '" . $this->escapeString($tid) . "') ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getTopicSql('AND', Dataproxy::uid());
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		} else {
			$sids = array();
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$sids[] = $this->escapeString($A['id']);
			}
			
			if (count($sids) === 0) {
				return $retval;
			}
		}
		
		$sql = "SELECT sid, title, UNIX_TIMESTAMP(date) AS day "
			 . "  FROM {$_TABLES['stories']} "
			 . "WHERE (draft_flag = 0) AND (date <= NOW()) "
			 . "  AND (sid IN ('" . implode("', '", $sids) . "')) ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSql('AND', Dataproxy::uid());
			
			if ($all_langs === false) {
				$sql .= COM_getLangSQL('sid', 'AND');
			}
		}
		
		$sql .= " ORDER BY date DESC ";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		$entries = array();
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']       = stripslashes($A['sid']);
			$entry['title']    = stripslashes($A['title']);
			$entry['uri']      = COM_buildUrl($_CONF['site_url'] . '/article.php?story='. stripslashes($A['sid']));
			$entry['date']     = $A['day'];
			$entry['imageurl'] = false;
			$retval[] = $entry;
		}
		
		return $retval;
	}
	
	/**
	* Returns an array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	public function getItemsByDate($tid = '', $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$retval = array();
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $retval;
		}
		
		// Collects sids
		$sql = "SELECT id "
			 . "  FROM {$_TABLES['topic_assignments']} "
			 . "WHERE (type= 'article') AND (tdefault = 1) ";
		
		if (!empty($tid)) {
			$sql .= "  AND (tid = '" . $this->escapeString($tid) . "') ";
		}
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getTopicSql('AND', Dataproxy::uid());
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		} else {
			$sids = array();
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$sids[] = $this->escapeString($A['id']);
			}
			
			if (count($sids) === 0) {
				return $retval;
			}
		}
		$sql = "SELECT sid, title, UNIX_TIMESTAMP(date) AS day "
			 . "  FROM {$_TABLES['stories']} "
			 . "WHERE (draft_flag = 0) AND (date <= NOW()) "
			 . "  AND (UNIX_TIMESTAMP(date) BETWEEN '" . Dataproxy::$startDate
			 . "' AND '" . Dataproxy::$endDate . "') ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSql('AND', Dataproxy::uid());
			
			if ($all_langs === false) {
				$sql .= COM_getLangSQL('sid', 'AND');
			}
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']       = stripslashes($A['sid']);
			$entry['title']    = stripslashes($A['title']);
			$entry['uri']      = COM_buildUrl($_CONF['site_url'] . '/article.php?story='. stripslashes($A['sid']));
			$entry['date']     = $A['day'];
			$entry['imageurl'] = false;
			$retval[] = $entry;
		}
		
		return $retval;
	}
}
