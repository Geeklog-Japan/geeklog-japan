<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/comments.class.php                      |
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

class dpxyDriver_Comments extends dpxyDriver
{
	/**
	* Returns the location of index.php of each plugin
	*
	* @return mixed uri (string) / false (no entry)
	*/
	public function getEntryPoint()
	{
		return FALSE;
	}
	
	public function getChildCategories($pid = false, $all_langs = false)
	{
		global $_CONF, $_TABLES, $LANG_SMAP;
		
		$entries = array();
		
		if ($pid !== false) {
			return $entries;
		}
		
		$supported_drivers = Dataproxy::getAllDriverNames();
		$sql = "SELECT DISTINCT type "
			 . "  FROM {$_TABLES['comments']} "
			 . "ORDER BY type";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			if (in_array(stripslashes($A['type']), $supported_drivers)) {
				$entry = array();
				$entry['id']        = stripslashes($A['type']);
				$entry['pid']       = false;
				$entry['title']     = $entry['id'];
				$entry['uri']       = false;
				$entry['date']      = false;
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
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
	public function getItemById($id, $all_langs = false) {
		global $_CONF, $_TABLES;
		
		$retval = array();
		
		$sql = "SELECT * "
			 . "  FROM {$_TABLES['comments']} "
			 . "WHERE (cid = '" . $this->escapeString($id) . "') ";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result) == 1) {
			$A = DB_fetchArray($result, false);
			$A = array_map('stripslashes', $A);
			$retval['id']        = $id;
			$retval['title']     = $A['title'];
			$retval['uri']       = $_CONF['site_url'] . '/comment.php?mode=view&amp;cid=' . $id;
			$retval['date']      = strtotime($A['date']);
			$retval['image_uri'] = false;
			$retval['raw_data']  = $A;
		}
		
		return $retval;
	}
	
	/**
	* @param $all_langs boolean: true = all languages, true = current language
	* Returns an array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	public function getItems($category, $all_langs = false) {
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (!in_array($category, Dataproxy::getAllDriverNames())) {
			return $entries;
		}
		
		$sql = "SELECT cid, title, UNIX_TIMESTAMP(date) AS day "
			 . "  FROM {$_TABLES['comments']} "
			 . "WHERE (type = '" . $this->escapeString($category) . "') "
			 . "ORDER BY day DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['cid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = $_CONF['site_url'] . '/comment.php?mode=view&amp;cid='
								. $entry['id'];
			$entry['date']      = $A['day'];
			$entry['image_uri'] = false;
			$entries[] = $entry;
		}
		
		return $entries;
	}
	
	/**
	* @param $all_langs boolean: true = all languages, true = current language
	* Returns an array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	public function getItemsByDate($category = '', $all_langs = false) {
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (!empty($category) &&
			!in_array($category, Dataproxy::getAllDriverNames())) {
			return $entries;
		}
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql = "SELECT cid, title, UNIX_TIMESTAMP(date) AS day "
			 . "  FROM {$_TABLES['comments']} "
			 . "WHERE (1 = 1) ";
		
		if (!empty($category)) {
			$sql .= "AND (type = '" . $this->escapeString($category) . "') ";
		}
		
		$sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '"
			 .  Dataproxy::$startDate . "' AND '" . Dataproxy::$endDate
			 .  "') "
			 .  "ORDER BY date DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['cid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = $_CONF['site_url'] . '/comment.php?mode=view&amp;cid='
								. $entry['id'];
			$entry['date']      = $A['day'];
			$entry['image_uri'] = false;
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
