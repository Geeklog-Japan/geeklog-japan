<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/mediagallery.class.php                  |
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

class dpxyDriver_Mediagallery extends dpxyDriver
{
	public function isLoginRequired() {
		global $_CONF, $_TABLES, $_MG_CONF;
		
		static $retval = null;
		
		if ($retval === null) {
			$sql = "SELECT config_value "
				 . "  FROM {$_TABLES['mg_config']} "
				 . "WHERE (config_name = 'loginrequired')";
			$result = DB_query($sql);
			
			if (DB_error()) {
				$retval = true;	// just to be on the safe side
			} else {
				$A = DB_fetchArray($result, false);
				$retval = ((int) $A['config_value'] != 0);
			}
		}
		
		return $retval;
	}
	
	/*
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint()
	{
		global $_CONF, $_MG_CONF;
		
		return $_MG_CONF['site_url'] . '/index.php';
	}
	
	/**
	* @param $pid int/string/boolean id of the parent category.  false means
	*        the top category (with no parent)
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*  )
	*/	
	public function getChildCategories($pid = false)
	{
		global $_CONF, $_TABLES, $_MG_CONF;
		
		$entries = array();
		
		if (Dataproxy::isAnon() && $this->isLoginRequired()) {
			return $entries;
		}
		
		if ($pid === false) {
			$pid = 0;
		}
		
		$sql = "SELECT album_id, album_title, album_parent, last_update "
			 . "  FROM {$_TABLES['mg_albums']} "
			 . "WHERE (album_parent = '" . $this->escapeString($pid) . "') ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSQL('AND ', Dataproxy::uid())
				 .  " AND (hidden = '0') ";
		}
		
		$sql .= " ORDER BY album_order";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['album_id'];
			$entry['pid']       = $A['album_parent'];
			$entry['title']     = stripslashes($A['album_title']);
			$entry['uri']       = $_MG_CONF['site_url'] . '/album.php?aid='
								. $entry['id'];
			$entry['date']      = $A['last_update'];
			$entry['image_uri'] = false;
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
	    global $_CONF, $_TABLES, $_MG_CONF;
		
		$retval = array();
		
		if (Dataproxy::isAnon() && $this->isLoginRequired()) {
			return $retval;
		}

		$sql = "SELECT * "
			 . "FROM {$_TABLES['mg_media']} "
			 . "WHERE (media_id ='" . $this->escapeString($id) . "') ";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result) == 1) {
			$A = DB_fetchArray($result, false);
			$A = array_map('stripslashes', $A);
			
			if (empty($A['media_title'])) {
				$A['media_title'] = $id;
			}
			
			$retval['id']        = $id;
			$retval['title']     = $A['media_title'];
			$retval['uri']       = $_MG_CONF['site_url'] . '/media.php?s=' . urlencode($id);
			$retval['date']      = $A['media_time'];
			$retval['image_uri'] = $retval['uri'];
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
	public function getItems($category, $all_langs = false)
	{
		global $_CONF, $_TABLES, $_MG_CONF;
		
		$entries = array();
		
		if (Dataproxy::isAnon() && $this->isLoginRequired()) {
			return $entries;
		}
		
		$sql = "SELECT media_id "
			 . "  FROM {$_TABLES['mg_media_albums']} "
			 . "WHERE (album_id ='" . $this->escapeString($category) . "') "
			 . "ORDER BY media_order";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		$media_ids = array();
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$media_ids[] = "'" . $A['media_id'] . "'";
		}
		
		if (count($media_ids) === 0) {
			return $entries;
		}
		
		$sql = "SELECT media_id, media_title, media_time "
			 . "  FROM {$_TABLES['mg_media']} "
			 . "WHERE (media_id IN (" . implode(',', $media_ids) . "))";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			if (empty($A['media_title'])) {
				$A['media_title'] = $A['media_id'];
			}
			
			$entry = array();
			$entry['id']        = stripslashes($A['media_id']);
			$entry['title']     = stripslashes($A['media_title']);
			$entry['uri']       = $_MG_CONF['site_url'] . '/media.php?s=' . urlencode($entry['id']);
			$entry['date']      = $A['media_time'];
			$entry['image_uri'] = false;
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
	public function getItemsByDate($category = '', $all_langs = false)
	{
		global $_CONF, $_TABLES, $_MG_CONF;
		
		$entries = array();
		
		if (Dataproxy::isAnon() && $this->isLoginRequired()) {
			return $entries;
		}
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql = "SELECT media_id "
			 . "  FROM {$_TABLES['mg_media_albums']} "
			 . "WHERE (album_id ='" . $this->escapeString($category) . "') "
			 . "ORDER BY media_order";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		$media_ids = array();
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$media_ids[] = "'" . $A['media_id'] . "'";
		}
		
		if (count($media_ids) === 0) {
			return $entries;
		}
		
		$sql = "SELECT media_id, media_title, media_time "
			 . "  FROM {$_TABLES['mg_media']} "
			 . "WHERE (media_id IN (" . implode(',', $media_ids) . "))"
			 . "  AND (media_time BETWEEN '" . Dataproxy::$startDate
			 . "' AND '" . Dataproxy::$endDate . "') ";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			if (empty($A['media_title'])) {
				$A['media_title'] = $A['media_id'];
			}
			
			$entry = array();
			$entry['id']        = stripslashes($A['media_id']);
			$entry['title']     = stripslashes($A['media_title']);
			$entry['uri']       = $_MG_CONF['site_url'] . '/media.php?s=' . urlencode($entry['id']);
			$entry['date']      = $A['media_time'];
			$entry['image_uri'] = false;
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
