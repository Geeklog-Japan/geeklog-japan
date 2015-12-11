<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/trackback.class.php                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2012 mystral-kk - geeklog AT mystral-kk DOT net        |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'trackback.class.php') !== FALSE) {
    die('This file can not be used on its own.');
}

class dpxyDriver_Trackback extends dpxyDriver
{
	/**
	* Returns the location of index.php of each plugin
	*
	* @return mixed uri(string) / FALSE(no entry)
	*/
	public function getEntryPoint()
	{
		return FALSE;
	}
	
	public function getChildCategories($pid = FALSE, $all_langs = FALSE)
	{
		global $_CONF, $_TABLES, $LANG_SMAP;
		
		$entries = array();
		
		if ($pid !== FALSE) {
			return $entries;
		}
		
		$supported_drivers = Dataproxy::getAllDriverNames();
		$sql = "SELECT DISTINCT type "
			 . "FROM {$_TABLES['trackback']} "
			 . "ORDER BY type";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, FALSE)) !== FALSE) {
			if (in_array(stripslashes($A['type']), $supported_drivers)) {
				$entry = array();
				$entry['id']        = stripslashes($A['type']);
				$entry['pid']       = FALSE;
				$entry['title']     = $entry['id'];
				$entry['uri']       = FALSE;
				$entry['date']      = FALSE;
				$entry['image_uri'] = FALSE;
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
	public function getItemById($id, $all_langs = FALSE)
	{
	    global $_CONF, $_TABLES;
		
		$retval = array();
		
		$sql = "SELECT * "
			 . "FROM {$_TABLES['trackback']} "
			 . "WHERE (cid = '" . addslashes($id) . "') ";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result) == 1) {
			$A = DB_fetchArray($result, FALSE);
			$A = array_map('stripslashes', $A);
			
			$retval['id']        = $id;
			$retval['title']     = $A['title'];
			$retval['uri']       = $A['url'];	// maybe needs cleaning
			$retval['date']      = strtotime($A['date']);
			$retval['image_uri'] = FALSE;
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
	public function getItems($category, $all_langs = FALSE)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (!in_array($category, Dataproxy::getAllDriverNames())) {
			return $entries;
		}
		
		$sql = "SELECT cid, title, url, UNIX_TIMESTAMP(date) AS day "
			 . "  FROM {$_TABLES['trackback']} "
			 . "WHERE (type = '" . addslashes($category) . "') "
			 . "ORDER BY day DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, FALSE)) !== FALSE) {
			$entry = array();
			
			$entry['id']        = $A['cid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = $this->cleanUrl($A['url']);
			$entry['date']      = $A['day'];
			$entry['image_uri'] = FALSE;
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
	public function getItemsByDate($category = '', $all_langs = FALSE)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (!in_array($category, Dataproxy::getAllDriverNames())) {
			return $entries;
		}
		
		if (empty(Dataproxy::$startDate) OR empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql = "SELECT cid, title, url, UNIX_TIMESTAMP(date) AS day "
			 . "  FROM {$_TABLES['trackback']} "
			 . "WHERE (type = '" . addslashes($category) . "') "
			 . "  AND (UNIX_TIMESTAMP(date) BETWEEN '" . Dataproxy::$startDate
			 . "' AND '" . Dataproxy::$endDate . "') "
			 . "ORDER BY date DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, FALSE)) !== FALSE) {
			$entry = array();
			
			$entry['id']        = $A['cid'];
			$entry['title']     = stripslashes($A['title']);
			$entry['uri']       = $this->cleanUrl($A['url']);
			$entry['date']      = $A['day'];
			$entry['image_uri'] = FALSE;
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
