<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/downloads.class.php                     |
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

class dpxyDriver_Downloads extends dpxyDriver
{
	/*
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint() {
		global $_CONF;
		
		return $_CONF['site_url'] . '/downloads/index.php';
	}
	
	/**
	* @param $pid int/string/boolean id of the parent category
	* @param $current_groups array ids of groups the current user belongs to
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*  )
	*/
	public function getChildCategories($pid = false, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if ($pid === false) {
			$pid = 'root';
		}
		
		$sql = "SELECT * "
			 . "  FROM {$_TABLES['downloadcategories']} "
			 . "WHERE (pid = '" . $this->escapeString($pid) . "') "
			 . "  AND (is_enabled = 1) ";
		
		if ($all_langs === false) {
			$sql .= COM_getLangSQL('cid', 'AND');
		}
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSQL('AND', Dataproxy::uid());
		}
		
		$sql .= "ORDER BY corder";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['cid'];
			$entry['pid']       = $A['pid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = $_CONF['site_url'] . '/downloads/index.php?cid=' . $entry['id'];
			$entry['date']      = false;
			$entry['image_uri'] = $A['imgurl'];
			$entries[] = $entry;
		}
		
		return $entries;
	}
	
	/**
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
			 . "  FROM {$_TABLES['downloads']} AS f "
			 . "  LEFT JOIN {$_TABLES['downloadcategories']} AS c "
			 . "    ON f.cid = c.cid "
			 . "WHERE (f.lid = '" . $this->escapeString($id) . "') "
			 . "  AND (c.is_enabled = 1) "
			 . "  AND (f.is_released = 1) "
			 . "  AND (f.is_listing = 1) "
			 . "  AND (f.date <= UNIX_TIMESTAMP(NOW())) ";
		
		if ($all_langs === false) {
			$sql .= COM_getLangSQL('cid', 'AND', 'c');
		}
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSQL('AND', Dataproxy::uid(), 2, 'c');
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
			$retval['uri']       = $_CONF['site_url'] . '/downloads/index.php?id=' . $id;
			$retval['date']      = (int) $A['date'];
			$retval['image_uri'] = $A['logourl'];
			
			if (empty($retval['image_uri'])) {
				$retval['image_uri'] = false;
			}
			
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
	public function getItems($cid, $all_langs = false)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		$sql = "SELECT lid, f.title, logourl, date "
			 . "  FROM {$_TABLES['downloads']} AS f "
			 . "  LEFT JOIN {$_TABLES['downloadcategories']} AS c "
			 . "    ON f.cid = c.cid "
			 . "WHERE (f.cid = '" . $this->escapeString($cid) . "') "
			 . "  AND (c.is_enabled = 1) "
			 . "  AND (f.is_released = 1) "
			 . "  AND (f.is_listing = 1) "
			 . "  AND (f.date <= UNIX_TIMESTAMP(NOW())) ";
		
		if ($all_langs === false) {
			$sql .= COM_getLangSQL('cid', 'AND', 'c');
		}
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSQL('AND', Dataproxy::uid(), 2, 'c');
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['lid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = COM_buildUrl($_CONF['site_url'] . '/downloads/index.php?id=' . $entry['id']);
			$entry['date']      = (int) $A['date'];
			$entry['image_uri'] = $A['logourl'];
			$entries[] = $entry;
		}
		
		return $entries;
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
	public function getItemsByDate($cid = '', $all_langs = false)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql = "SELECT f.lid, f.title, f.logourl, f.date "
			 . "  FROM {$_TABLES['downloads']} AS f "
			 . "  LEFT JOIN {$_TABLES['downloadcategories']} AS c "
			 . "    ON f.cid = c.cid "
			 . "WHERE (f.is_released = 1) "
			 . "  AND (f.is_listing = 1) "
			 . "  AND (f.date <= UNIX_TIMESTAMP(NOW())) "
			 . "  AND (f.date BETWEEN '" . Dataproxy::$startDate
			 . "' AND '" . Dataproxy::$endDate . "') ";
		
		if (!empty($cid)) {
			$sql .= "  AND (c.is_enabled = 1) "
				 .  "  AND (f.cid = '" . $this->escapeString($cid) . "') ";
			
			if ($all_langs === FALSE) {
				$sql .= COM_getLangSQL('cid', 'AND', 'c');
			}
		}
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSQL('AND', Dataproxy::uid(), 2, 'c');
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['lid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = COM_buildUrl($_CONF['site_url'] . '/downloads/index.php?id=' . $entry['id']);
			$entry['date']      = (int) $A['date'];
			$entry['image_uri'] = $A['logourl'];
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
