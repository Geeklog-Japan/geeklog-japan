<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/dokuwiki.class.php                      |
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

class dpxyDriver_Dokuwiki extends dpxyDriver
{
	/**
	* Returns the location of index.php of each plugin
	*/
	public function getEntryPoint() {
		global $_CONF;
		
		return $_CONF['site_url'] . '/dokuwiki/doku.php';
	}
	
	public function getChildCategories($pid = FALSE, $all_langs = false)
	{
		return array();
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
	    global $_CONF, $_TABLES, $_DW_CONF;
		
		$retval = array();
		$base_path = $_CONF['path_html'] . substr($_DW_CONF['public_dir'], 1);
		
		if (!file_exists($base_path)) {
			COM_errorLog("Dataproxy: can't find DokuWiki directory.");
			return $retval;
		}
		
		require_once $base_path . 'conf/dokuwiki.php';
		$data_path = realpath($base_path . $conf['savedir'] . '/pages');
		
		if ($data_path === FALSE) {
			COM_errorLog("Dataproxy: can't find DokuWiki's data directory.");
			return $retval;
		}
		
		$full_path = $data_path . DIRECTORY_SEPARATOR . urlencode($id) . '.txt';
		
		if (is_file($full_path)) {
			$retval['id']        = $id;
			$retval['title']     = $id;
			$retval['uri']       = $_CONF['site_url'] . $_DW_CONF['public_dir']
								 . 'doku.php?id=' . urlencode($id);
			clearstatcache();
			$retval['date']      = filemtime($full_path);
			$retval['image_uri'] = false;
			$retval['raw_data']  = @file_get_contents($full_path);
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
	    global $_CONF, $_TABLES, $_DW_CONF;
		
		// Collect all Dokuwiki entries since Dokuwiki does no access control.
		$base_path = $_CONF['path_html'] . substr($_DW_CONF['public_dir'], 1);
		clearstatcache();
		
		if (!file_exists($base_path)) {
			COM_errorLog("Dataproxy: can't find DokuWiki's directory.");
			return false;
		}
		
		require_once $base_path . 'conf/dokuwiki.php';
		$data_path = realpath($base_path . $conf['savedir'] . '/pages');
		
		if ($data_path === false) {
			COM_errorLog("Dataproxy: can't find DokuWiki's data directory.");
			return $retval;
		}
		
		$dh = @opendir($data_path);
		
		if ($dh === false) {
			return $retval;
		}
		
		$entries = array();
		
		while (($entry_name = readdir($dh)) !== false) {
			$full_path = $data_path . DIRECTORY_SEPARATOR . $entry_name;
			clearstatcache();
			
			if (is_file($full_path) &&
				preg_match('/^(.*)(\.txt)$/i', $entry_name, $match)) {
				$entry = array();
				$entry['id']    = $match[1];
				$entry['title'] = urldecode($entry['id']);
				
				switch ($conf['userewrite']) {
					case 1: // URL rewrite - .htaccess
						COM_errorLog('Dataproxy: dokuwiki URL rewrite rule is not defined.  File: ' . __FILE__ . ' line: ' . __LINE__);
						// fall through to case 0:
					
					case 0: // URL rewrite - off
						$entry['uri'] = $_CONF['site_url'] . $_DW_CONF['public_dir'] . 'doku.php?id=' . $entry['id'];
						break;
					
					case 2: // URL rewrite - internal
						$entry['uri'] = $_CONF['site_url'] . $_DW_CONF['public_dir'] . 'doku.php/' . $entry['id'];
						break;
					
					default:
						break;
				}
				
				clearstatcache();
				$entry['date']      = filemtime($full_path);
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		}
		
		closedir($dh);
		
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
	    global $_CONF, $_TABLES, $_DW_CONF;
		
		$entries = array();
		
		// Collects all Dokuwiki entries since Dokuwiki does no access control.
		$base_path = $_CONF['path_html'] . substr($_DW_CONF['public_dir'], 1);
		clearstatcache();
		
		if (!file_exists($base_path)) {
			COM_errorLog("Dataproxy: can't find DokuWiki's directory.");
			return entries;
		}
		
		require_once $base_path . 'conf/dokuwiki.php';
		$data_path = realpath($base_path . $conf['savedir'] . '/pages');
		
		if ($data_path === false) {
			COM_errorLog("Dataproxy: can't find DokuWiki's data directory.");
			return $entries;
		}
		
		$dh = @opendir($data_path);
		
		if ($dh === false) {
			return $entries;
		}
		
		if (empty(Dataproxy::$startDate) || empty(Dataproxy::$endDate)) {
			return $entries;
		}
		
		while (($entry_name = readdir($dh)) !== FALSE) {
			$full_path = $data_path . DIRECTORY_SEPARATOR . $entry_name;
			$file_time = filemtime($full_path);
			
			if (($file_time < Dataproxy::$startDate) ||
				($file_time > Dataproxy::$endDate)) {
				continue;
			}
			
			clearstatcache();
			
			if (is_file($full_path) &&
				preg_match('/^(.*)(\.txt)$/i', $entry_name, $match)) {
				$entry = array();
				$entry['id']    = $match[1];
				$entry['title'] = urldecode($entry['id']);
				
				switch ($conf['userewrite']) {
					case 1: // URL rewrite - .htaccess
						COM_errorLog('Dataproxy: dokuwiki URL rewrite rule is not defined.  File: ' . __FILE__ . ' line: ' . __LINE__);
						// fall through to case 0:
					
					case 0: // URL rewrite - off
						$entry['uri'] = $_CONF['site_url'] . $_DW_CONF['public_dir'] . 'doku.php?id=' . $entry['id'];
						break;
					
					case 2: // URL rewrite - internal
						$entry['uri'] = $_CONF['site_url'] . $_DW_CONF['public_dir'] . 'doku.php/' . $entry['id'];
						break;
					
					default:
						break;
				}
				
				clearstatcache();
				$entry['date']      = $file_time;
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		}
		
		closedir($dh);
		
		return $entries;
	}
}
