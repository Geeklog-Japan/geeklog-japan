<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/faqman.class.php                        |
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

class dpxyDriver_Faqman extends dpxyDriver
{
	/*
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint()
	{
		global $_CONF;
		
		return $_CONF['site_url'] . '/faqman/index.php';
	}
	
	public function getChildCategories($pid = false, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if ($pid !== FALSE) {
			return $entries;
		}
		
		$sql = "SELECT catID, name "
			 . "  FROM {$_TABLES['faq_categories']} "
			 . "ORDER BY catID";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $entries;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = $A['catID'];
			$entry['pid']       = false;
			$entry['title']     = stripslashes($A['name']);
			$entry['uri']       = $_CONF['site_url'] . '/faqman/index.php?op=cat&amp;c=' . $entry['id'];
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
			 . "  FROM {$_TABLES['faq_topics']} "
			 . "WHERE (topicID = '" . $this->escapeString($id) . "') ";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		if (DB_numRows($result) == 1) {
			$A = DB_fetchArray($result, false);
			$A = array_map('stripslashes', $A);
			$retval['id']        = $id;
			$retval['title']     = $A['question'];
			$retval['uri']       = $_CONF['site_url']
				. '/faqman/index.php?op=view&amp;t=' . $id;
			$retval['date']      = false;
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
	public function getItems($cid, $all_langs = false)
	{
	    global $_CONF, $_TABLES;
		
		$entries = array();
		
		$sql = "SELECT topicID, question "
			 . "  FROM {$_TABLES['faq_topics']} "
			 . "WHERE (catID = '" . $this->escapeString($cid) . "') "
			 . "ORDER BY topicID";
		$result = DB_query($sql);
		
		if (DB_error()) {
			return $retval;
		}
		
		while (($A = DB_fetchArray($result, false)) !== false) {
			$entry = array();
			$entry['id']        = stripslashes($A['topicID']);
			$entry['title']     = stripslashes($A['question']);
			$entry['uri']       = $_CONF['site_url'] . '/faqman/index.php?op=view&amp;t=' . $entry['id'];
			$entry['date']      = false;
			$entry['image_uri'] = false;
			$entries[] = $entry;
		}
		
		return $entries;
	}
}
