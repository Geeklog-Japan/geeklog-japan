<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/polls.class.php                         |
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

class dpxyDriver_Polls extends dpxyDriver
{
	/*
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint()
	{
		global $_CONF;
		
		return $_CONF['site_url'] . '/polls/index.php';
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
		
		if (Dataproxy::$isGL150) {
			$sql = "SELECT * "
				 . "  FROM {$_TABLES['polltopics']} "
				 . "WHERE (pid = '" . $this->escapeString($id) . "') ";
			
			if (!Dataproxy::isRoot()) {
				$sql .= COM_getPermSQL('AND', Dataproxy::uid());
			}
			
			$result = DB_query($sql);
			
			if (DB_error()) {
				return $retval;
			}
			
			if (DB_numRows($result) == 1) {
				$A = DB_fetchArray($result, FALSE);
				$A = array_map('stripslashes', $A);
				
				$retva['id']         = $id;
				$retval['title']     = $A['topic'];
				$retval['uri']       = $_CONF['site_url'] . '/polls/index.php?pid=' . urlencode($id);
				$retval['date']      = Dataproxy::$isGL170
									 ? strtotime($A['modified'])
									 : strtotime($A['date']);
				$retval['image_uri'] = false;
				
				$retval['raw_data']  = $A;
			}
		} else {
			$sql = "SELECT * "
				 . "  FROM {$_TABLES['pollquestions']} "
				 . "WHERE (qid = '" . $this->escapeString($id) . "') ";
			
			if (!Dataproxy::isRoot()) {
				$sql .= COM_getPermSQL('AND', Dataproxy::uid());
			}
			
			$result = DB_query($sql);
			
			if (DB_error()) {
				return $retval;
			}
			
			if (DB_numRows($result) == 1) {
				$A = DB_fetchArray($result, false);
				$A = array_map('stripslashes', $A);
				
				$retva['id']         = $id;
				$retval['title']     = $A['question'];
				$retval['uri']       = $_CONF['site_url'] . '/polls/index.php?qid=' . urlencode($id)
									 . '&amp;aid=-1';
				$retval['date']      = strtotime($A['date']);
				$retval['image_uri'] = false;
				
				$retval['raw_data']  = $A;
			}
		}
		
		return $retval;
	}
	
	/**
	* Returns meta data of child categories
	*
	* @param $pid       int/string/boolean: id of the parent category.  false
	*                   means the top category (with no parent)
	* @param $all_langs boolean: TRUE = all languages, FALSE = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	public function getChildCategories($pid = false, $all_langs = false)
	{
		return array();
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
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (Dataproxy::$isGL150) {
			if (Dataproxy::$isGL170) {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(modified) AS day "
					 . "  FROM {$_TABLES['polltopics']} ";
			} else {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(date) AS day "
					 . "  FROM {$_TABLES['polltopics']} ";
			}
			
			if (!Dataproxy::isRoot()) {
				$sql .= COM_getPermSQL('WHERE', Dataproxy::uid());
			}
			
			$sql .= " ORDER BY pid";
			$result = DB_query($sql);
			
			if (DB_error()) {
				return $entries;
			}
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['pid'];
				$entry['title']     = stripslashes($A['topic']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?pid=' . urlencode($entry['id']);
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		} else {
			$sql = "SELECT qid, question, UNIX_TIMESTAMP(date) AS day "
				 . "  FROM {$_TABLES['pollquestions']} ";
			
			if (!Dataproxy::isRoot()) {
				$sql .= COM_getPermSQL('WHERE', Dataproxy::uid());
			}
			
			$sql .= " ORDER BY qid";
			$result = DB_query($sql);
			
			if (DB_error()) {
				return $entries;
			}
		
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['qid'];
				$entry['title']     = stripslashes($A['question']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?qid=' . urlencode($entry['id']) . '&amp;aid=-1';
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
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
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		$sql_date = "AND (UNIX_TIMESTAMP(date) BETWEEN '"
				  . Dataproxy::$startDate . "' AND '" . Dataproxy::$endDate
				  . "') ";
		
		if (Dataproxy::$isGL150) {
			if (Dataproxy::$isGL170) {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(modified) AS day "
					 . "  FROM {$_TABLES['polltopics']} "
					 . "WHERE (UNIX_TIMESTAMP(modified) BETWEEN '"
					 . Dataproxy::$startDate . "' AND '" . Dataproxy::$endDate
					 . "') ";
			} else {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(date) AS day "
					 . "  FROM {$_TABLES['polltopics']} "
					 . "WHERE (1 = 1) " . $sql_date;
			}
			
			if (!Dataproxy::isRoot()) {
				$sql .= COM_getPermSQL('AND', Dataproxy::uid());
			}
			
			$sql .= " ORDER BY pid";
			$result = DB_query($sql);
			
			if (DB_error()) {
				return $entries;
			}
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['pid'];
				$entry['title']     = stripslashes($A['topic']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?pid=' . urlencode($entry['id']);
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		} else {
			$sql = "SELECT qid, question, UNIX_TIMESTAMP(date) AS day "
				 . "FROM {$_TABLES['pollquestions']} "
				 . "WHERE (1 = 1) " . $sql_date;
			
			if (!Dataproxy::isRoot()) {
				$sql .= COM_getPermSQL('AND', Dataproxy::uid());
			}
			
			$sql .= " ORDER BY qid";
			$result = DB_query($sql);
			
			if (DB_error()) {
				return $entries;
			}
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['qid'];
				$entry['title']     = stripslashes($A['question']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?qid=' . urlencode($entry['id']) . '&amp;aid=-1';
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		}
		
		return $entries;
	}
}
