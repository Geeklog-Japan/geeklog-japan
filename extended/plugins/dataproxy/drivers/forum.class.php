<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/forum.class.php                         |
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

class dpxyDriver_Forum extends dpxyDriver
{
	/*
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint()
	{
		global $_CONF;
		
		return $_CONF['site_url'] . '/forum/index.php';
	}
	
	public function getChildCategories($pid = false, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if ($pid !== false) {
			return $entries;
		}
		
		$sql = "SELECT forum_id, forum_name FROM {$_TABLES['gf_forums']} "
			 . "  WHERE (is_hidden = '0') ";
		
		if (!Dataproxy::isRoot()) {
			$current_groups = SEC_getUserGroups( Dataproxy::uid() );
			$sql .= "AND (grp_id IN (" . implode(',', $current_groups) . ")) ";
		}
		
		$sql .= "ORDER BY forum_order";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = (int) $A['forum_id'];
			$entry['pid']       = false;
			$entry['title']     = stripslashes($A['forum_name']);
			$entry['uri']       = $_CONF['site_url'] . '/forum/index.php?forum=' . $entry['id'];
			$entry['date']      = false;
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
	    global $_CONF, $_TABLES;
		
		$retval = array();
		
		$sql = "SELECT * "
			 . "  FROM {$_TABLES['gf_topic']} "
		     . "WHERE (id = '" . $this->escapeString($id) . "')";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result) == 1) {
			$A = DB_fetchArray($result, false);
			$A = array_map('stripslashes', $A);
			$retval['id']        = $id;
			$retval['title']     = $A['subject'];
			$retval['uri']       = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $id;
			$retval['date']      = (int) $A['date'];
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
	public function getItems($forum_id, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		$sql = "SELECT id, subject, date FROM {$_TABLES['gf_topic']} "
		     . "  WHERE (pid = 0) AND (forum = '" . $this->escapeString($forum_id) ."') "
			 . "ORDER BY date DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['id'];
			$entry['title']     = stripslashes($A['subject']);
			$entry['uri']       = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $entry['id'];
			$entry['date']      = $A['date'];
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
	public function getItemsByDate($forum_id = '', $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql = "SELECT id, subject, date "
			 . "  FROM {$_TABLES['gf_topic']} "
		     . "WHERE (pid = 0) AND (forum = '" . $this->escapeString($forum_id) ."') "
			 . "  AND (date BETWEEN '" . Dataproxy::$startDate
			 . "' AND '" . Dataproxy::$endDate . "') "
			 . "ORDER BY date DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['id'];
			$entry['title']     = stripslashes($A['subject']);
			$entry['uri']       = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $entry['id'];
			$entry['date']      = $A['date'];
			$entry['image_uri'] = false;
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
