<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/functions.inc                                   |
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
	die('This file cannot be used on its own.');
}

//define('DATAPROXY_DEBUG', TRUE);

// Includes language file 
$langfile = $_CONF['path'] . 'plugins/dataproxy/language/' . $_CONF['language'] . '.php';
clearstatcache();

if (file_exists($langfile)) {
	include_once $langfile;
} else {
	include_once $_CONF['path'] . 'plugins/dataproxy/language/english.php';
}

// Includes dataproxy config file
require_once $_CONF['path'] . 'plugins/dataproxy/config.php';
require_once $_CONF['path'] . 'plugins/dataproxy/dataproxy.php';

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* @return    array   Associative array of menu items to be added to menu
*/
function plugin_getmenuitems_dataproxy() {
	return array();
}

/**
* Check to see if this Plugin uses comments
*
* @return   boolean TRUE or false
*/
function plugin_commentsupport_dataproxy() {
	return false;
}

/**
* This will put an option for the plugin in the command and control block on
* moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*/
function plugin_cclabel_dataproxy() {
	global $_CONF;
	
	$pi_name   = DPXY_str('menu_label');
	$admin_url = '';
	$icon_url  = $_CONF['site_admin_url'] . '/plugins/dataproxy/images/dataproxy.gif';
	
	return array($pi_name, $admin_url, $icon_url);
}

/**
* Returns the administrative option for this plugin
*
* Adds the plugin to the Admin menu
*
* @return   array   Array containing (plugin name, plugin admin url, # of items in plugin or '')
*/
function plugin_getadminoption_dataproxy() {
	global $_CONF, $_TABLES;

	if (SEC_hasRights('dataproxy.admin')) {
		$pi_name   = DPXY_str('menu_label');
		$admin_url = '';
		$num_items = '';
		return array($pi_name, $admin_url, $num_items);
	}
}

/**
* Returns the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_dataproxy() {
	global $_DPXY_CONF;
	
	return $_DPXY_CONF['pi_version'];
}

/**
* Upgrade the plugin
*
* @return   boolean true (= success)
*
*/
function plugin_upgrade_dataproxy() {
	global $_CONF, $_TABLES, $_DPXY_CONF;

	$result = DB_query("SELECT pi_version FROM {$_TABLES['plugins']} WHERE (pi_name = 'dataproxy')");
	$A = DB_fetchArray($result, false);
	$pi_version = $A['pi_version'];		// Version info stored in database
	
	// Do upgrading
	
// 	switch ($pi_version) {
// 		case '':
// 		break;
// 		
// 		case '':
// 		break;
// 		
// 	}
	
	// Update plugin info
	
	$result = DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = \"{$_DPXY_CONF['pi_version']}\" WHERE (pi_name = 'dataproxy')");
	COM_errorLog(ucfirst("dataproxy") . " plugin was successfully updated to version {$_DPXY_CONF['pi_version']}.");
	
	return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*/
function plugin_autouninstall_dataproxy() {
	$out = array (
		/* give the name of the tables, without $_TABLES[] */
		'tables'     => array('dpxy_notify'),
		/* give the full name of the group, as in the db */
		'groups'     => array('DataProxy Admin'),
		/* give the full name of the feature, as in the db */
		'features'   => array('dataproxy.admin'),
		/* give the full name of the block, including 'phpblock_', etc */
		'php_blocks' => array(),
		/* give all vars with their name */
		'vars'       => array('dataproxy_gid'),
	);

	return $out;
}

/**
* Returns the current encoding
*/
function DPXY_encoding() {
	global $_CONF, $LANG_CHARSET;
	
	static $encoding = null;
	
	if ($encoding === null) {
		if (isset($LANG_CHARSET)) {
			$encoding = $LANG_CHARSET;
		} else if (isset($_CONF['default_charset'])) {
			$encoding = $_CONF['default_charset'];
		} else {
			$encoding = 'iso-8859-1';
		}
	}
	
	return $encoding;
}

/**
* Returns a string escaped for output
*/
function DPXY_esc($str) {
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	return htmlspecialchars($str, ENT_QUOTES, DPXY_encoding());
}

/**
* Returns a lang var, escaped if necessary
*/
function DPXY_str($index, $noesc = false) {
	global $LANG_DPXY;
	
	if (isset($LANG_DPXY[$index])) {
		if ($noesc) {
			return $LANG_DPXY[$index];
		} else {
			return DPXY_esc($LANG_DPXY[$index]);
		}
	} else {
		COM_errorLog('DPXY_str: undefined index "' . $index . '".');
		return '(undefined)';
	}
}

/**
* This function is called when an item is about to be saved.  Currently, only
* 'article' seems to be supported.
*
* @param $type string  type of the item, e.g. 'article'
* @param $id   string  unique ID of the item
*/
function plugin_itemsaved_dataproxy($id, $type) {
	
	if (defined('DATAPROXY_DEBUG')) {
		COM_errorLog("plugin_itemsaved_dataproxy('{$id}', '{$type}')");
	}
	
	return false;
}

/**
* The interval between runs is determined by $_CONF['cron_schedule_interval']
*/
function plugin_runScheduledTask_dataproxy() {
	if (defined('DATAPROXY_DEBUG')) {
		COM_errorLog('plugin_runScheduledTask_dataproxy:');
	}
}
