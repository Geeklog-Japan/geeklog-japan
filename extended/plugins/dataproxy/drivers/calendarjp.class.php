<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/calendarjp.class.php                    |
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

class dpxyDriver_Calendarjp extends dpxyDriver
{
	/**
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint() {
		global $_CONF;
		
		return $_CONF['site_url'] . '/calendarjp/index.php';
	}
	
	public function getChildCategories($pid, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if ($pid !== false) {
			return $entries;
		}
		
		$sql = "SELECT DISTINCT event_type FROM {$_TABLES['eventsjp']} "
			 . "ORDER BY event_type";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();

			$entry['id']        = stripslashes($A['event_type']);
			$entry['pid']       = false;
			$entry['title']     = $entry['id'];
			$entry['uri']       = false;
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
			 . "FROM {$_TABLES['eventsjp']} "
			 . "WHERE (eid = '" . $this->escapeString($id) . "') ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSql('AND', Dataproxy::uid());
		}
		
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result == 1)) {
			$A = DB_fetchArray($result, false);
			$A = array_map('stripslashes', $A);
			$retval['id']        = $id;
			$retval['title']     = $A['title'];
			$retval['uri']       = $_CONF['site_url'] . '/calendarjp/event.php?eid=' . $id;
			$retval['date']      = strtotime($A['datestart']) + strtotime($A['timestart']);
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
	public function getItems($category = '', $all_langs = false)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();
		$sql = "SELECT eid, title, UNIX_TIMESTAMP(datestart) AS day1, UNIX_TIMESTAMP(timestart) AS day2 "
			 . "FROM {$_TABLES['eventsjp']} "
			 . "WHERE (event_type = '" . $this->escapeString($category) . "') ";
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSql('AND', Dataproxy::uid());
		}
		
		$sql .= " ORDER BY day1 DESC, day2 DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			
			$entry['id']        = $A['eid'];
			$entry['title']     = stripslashes( $A['title'] );
			$entry['uri']       = $_CONF['site_url'] . '/calendarjp/event.php?eid=' . $entry['id'];
			$entry['date']      = (int) $A['day1'] + (int) $A['day2'];
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
	public function getItemsByDate($event_type = '', $all_langs = false)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();

		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql = "SELECT eid, title, UNIX_TIMESTAMP(datestart) AS day1, "
			 . "  UNIX_TIMESTAMP(timestart) AS day2 "
			 . "FROM {$_TABLES['eventsjp']} "
			 . "WHERE (UNIX_TIMESTAMP(datestart) BETWEEN '"
			 . Dataproxy::$startDate . "' AND '" . Dataproxy::$endDate
			 . "') ";
		
		if (!empty($event_type)) {
			$sql .= "AND (event_type = '" . $this->escapeString($event_type) . "') ";
		}
		
		if (!Dataproxy::isRoot()) {
			$sql .= COM_getPermSql('AND', Dataproxy::uid());
		}
		
		$sql .= " ORDER BY day1 DESC, day2 DESC";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['eid'];
			$entry['title']     = stripslashes( $A['title'] );
			$entry['uri']       = $_CONF['site_url'] . '/calendarjp/event.php?eid=' . $entry['id'];
			$entry['date']      = (int) $A['day1'] + (int) $A['day2'];
			$entry['image_uri'] = false;
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
