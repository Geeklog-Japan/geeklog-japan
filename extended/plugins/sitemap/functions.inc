<?php
//
// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/functions.inc                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-k DOT net         |
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

// Language file Include
$langfile = $_CONF['path'] . 'plugins/sitemap/language/' . $_CONF['language'] . '.php';
clearstatcache();

if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/sitemap/language/english.php';
}

// Includes sitemap config file
require_once $_CONF['path'] . 'plugins/sitemap/config.php';

// Loads config
SITEMAP_loadConfig();

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* @return    array   Associative array of menu items to be added to menu
*/
function plugin_getmenuitems_sitemap() {
	global $_CONF, $_PLUGINS;
	
    $menuitems = array();
	
	if (in_array('dataproxy', $_PLUGINS)) {
		$menuitems[SITEMAP_str('menu_label')] = $_CONF['site_url'] . '/sitemap/index.php';
	}
	
    return $menuitems;
}

/**
* Check to see if this Plugin uses comments
*
* @return   boolean true or false
*/
function plugin_commentsupport_sitemap() {
    return false;
}

/**
* This will put an option for the plugin in the command and control block on
* moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*/
function plugin_cclabel_sitemap() {
    global $_CONF;

	$pi_name   = SITEMAP_str('menu_label');
	$admin_url = $_CONF['site_admin_url'] . '/plugins/sitemap/index.php';
	$icon_url  = $_CONF['site_url'] . '/sitemap/images/sitemap.gif';

    return array($pi_name, $admin_url, $icon_url);
}

/**
* Returns the administrative option for this plugin
*
* @return   array   Array containing (plugin name, plugin admin url, # of items
*                   in plugin or '')
*/
function plugin_getadminoption_sitemap() {
	global $_CONF, $_TABLES;

	if (SEC_hasRights('sitemap.admin')) {
		$pi_name   = SITEMAP_str('menu_label');
		$admin_url = $_CONF['site_admin_url'] . '/plugins/sitemap/index.php';
		$num_items = '';
		
		return array($pi_name, $admin_url, $num_items);
	}
}

/**
* Returns the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_sitemap() {
	global $_SMAP_CONF;
	
	return $_SMAP_CONF['pi_version'];
}

/**
* Upgrades the plugin
*
* @return   boolean TRUE (= success)
*/
function plugin_upgrade_sitemap() {
	global $_CONF, $_TABLES, $_SMAP_CONF;
	
	// Gets version info stored in database
	$pi_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'sitemap'");
	
	// Does upgrading
	while ($pi_version !== $_SMAP_CONF['pi_version']) {
		switch ($pi_version) {
			case '1.0':
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_article', 1)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_comments', 2)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_trackback', 3)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_staticpages', 4)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_calendar', 5)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_links', 6)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_polls', 7)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_dokuwiki', 8)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_forum', 9)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_filemgmt', 10)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_faqman', 11)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_mediagallery', 12)");
				
				$pi_version = '1.0.1';
				break;
		
			case '1.0.1':
			case '1.0.2':
			case '1.0.3':
			case '1.1.0':
			case '1.1.1':
			case '1.1.2':
			case '1.1.3':	// This version doesn't exist
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES ('sp_type', 2)");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES ('sp_except', 'formmail')");
			
				$pi_version = '1.1.4';
				break;
		
			case '1.1.4':
				DB_query("ALTER TABLE {$_TABLES['smap_config']} CHANGE value value VARCHAR(255) NULL DEFAULT NULL");
			
				$pi_version = '1.1.5';
				break;

			case '1.1.5':
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_calendarjp', 'true')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_calendarjp', 'true')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('freq_calendarjp', 'daily')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('priority_calendarjp', '0.5')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_calendarjp', 13)");
			
				$pi_version = '1.1.6';
				break;
		
			case '1.1.6':
			case '1.1.7':
			case '1.1.8':
				// Nothing done from 1.1.6 -> 1.1.7
				// Nothing done from 1.1.7 -> 1.1.8
				// Nothing done from 1.1.8 -> 1.1.9
				$pi_version = '1.1.9';
				break;
		
			case '1.1.9':
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_downloads', 'true')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_downloads', 'true')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('freq_downloads', 'daily')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('priority_downloads', '0.5')");
				DB_query("INSERT INTO {$_TABLES['smap_config']} VALUES('order_downloads', 14)");
			
				$pi_version = '1.2.0';
				break;
		
			case '1.2.0':
			case '1.2.1':
			case '1.2.2':
			case '2.0.0':
				DB_query("UPDATE {$_TABLES['features']} SET ft_descr = 'Sitemap Admin' WHERE (ft_name = 'sitemap.admin')");
				DB_query("UPDATE {$_TABLES['groups']} SET grp_name = 'Sitemap Admin' WHERE (grp_name = 'sitemap Admin')");
				$pi_version = '2.1.0';
				break;
			
			default:
				COM_errorLog('Sitemap: upgrade procedure for version ' . $pi_version . ' is not implemented in plugin_upgrade_sitemap().');
				break;
		}
	}
	
	// Update plugin info
	
	$sql = "UPDATE {$_TABLES['plugins']} "
		 . "  SET pi_version = '" . SITEMAP_escapeString($_SMAP_CONF['pi_version']) . "' "
		 . "  WHERE (pi_name = 'sitemap')";
	$result = DB_query($sql);
	COM_errorLog("Sitemap plugin was successfully updated to version {$_SMAP_CONF['pi_version']}.");
	
	return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*/
function plugin_autouninstall_sitemap() {
	$out = array (
		/* give the name of the tables, without $_TABLES[] */
		'tables'     => array('smap_config'),
		/* give the full name of the group, as in the db */
		'groups'     => array('Sitemap Admin'),
		/* give the full name of the feature, as in the db */
		'features'   => array('sitemap.admin'),
		/* give the full name of the block, including 'phpblock_', etc */
		'php_blocks' => array(),
		/* give all vars with their name */
		'vars'       => array(),
	);

	return $out;
}

function SITEMAP_escapeString($str) {
	return is_callable('DB_escapeString') ? DB_escapeString($str) : addslashes($str);
}

/**
* Loads vars from DB into $_SMAP_CONF[]
*/
function SITEMAP_loadConfig() {
	global $_TABLES, $_SMAP_CONF;
	
	$sql = "SELECT * FROM {$_TABLES['smap_config']}";
	$result = DB_query($sql);
	
	if (DB_error()) {
		COM_errorLog(__FUNCTION__ . ': cannot load config.');
		exit;
	}
	
	while (($A = DB_fetchArray($result)) !== false) {
		list($name, $value) = $A;
		
		if ($value === 'true') {
			$value = true;
		} else if ($value === 'false') {
			$value = false;
		}
		
		if ($name === 'date_format') {
			$value = substr($value, 1, -1);
		} else if (substr($name, 0, 6) === 'order_') {
			$value = (int) $value;
		}
		
		$_SMAP_CONF[$name] = $value;
	}
}

/**
* Saves vars into DB from $_SMAP_CONF[]
*/
function SITEMAP_saveConfig() {
	global $_TABLES, $_SMAP_CONF;
	
	$excepts = array(
		'pi_version', 'gl_version', 'pi_url', 'GROUPS', 'FEATURES', 'MAPPINGS',
	);
	
	foreach ($_SMAP_CONF as $name => $value) {
		if (!in_array($name, $excepts)) {
			if ($value === true) {
				$value = 'true';
			} else if ($value === false) {
				$value = 'false';
			}
			
			// To prevent MySQL from trimming trailing spaces
			if ($name == 'date_format') {
				$value = '[' . $value . ']';
			}
			
			$name  = SITEMAP_escapeString($name);
			$value = SITEMAP_escapeString($value);
			
			$sql = "UPDATE {$_TABLES['smap_config']} "
				 . "SET value = '{$value}' "
				 . "WHERE (name = '{$name}')";
			$result = DB_query($sql);
			
			if (DB_error()) {
				COM_errorLog(__FUNCTION__ . ': cannot save config.');
			}
		}
	}
}

/**
* Returns encoding
*/
function SITEMAP_getEncodingt() {
	global $_CONF, $LANG_CHARSET;
	
	static $encoding = null;
	
	if ($encoding === null) {
		$encoding = COM_getCharset();
	}
	
	return $encoding;
}

/**
* Escapes a string for HTML output
*/
function SITEMAP_escape($str) {
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	
	return htmlspecialchars($str, ENT_QUOTES, SITEMAP_getEncodingt());
}

function SITEMAP_str($index, $noesc = false) {
	global $LANG_SMAP;
	
	if (isset($LANG_SMAP[$index])) {
		if ($noesc) {
			return $LANG_SMAP[$index];
		} else {
			return SITEMAP_escape($LANG_SMAP[$index]);
		}
	} else {
		COM_errorLog(__FUNCTION__ . ': undefined index "' . $index . '".');
		return '(undefined)';
	}
}

/**
* Strips slashes if magic_quotes_gpc is on
*/
function SITEMAP_stripslashes($var) {
	if (get_magic_quotes_gpc()) {
		if (is_array($var)) {
			return array_map('SITEMAP_stripslashes', $var);
		} else {
			return stripslashes($var);
		}
	} else {
		return $var;
	}
}

/**
* Converts a timestamp into ISO8601 format
*/
function SITEMAP_convertDate($timestamp) {
	global $_SMAP_CONF;
	
	$retval = date('Y-m-d', $timestamp) . 'T'
			. date('H:i:s', $timestamp) . $_SMAP_CONF['time_zone'];
	
	return $retval;
}

/**
* Writes a Google Sitemap
*/
function SITEMAP_write($filename, $sitemap) {
	global $_CONF, $_SMAP_CONF;
	
	$retval = false;
	
	/**
	* for Google Mobile Sitemap
	*/
	if (preg_match("/mobile/i", $filename)) {
		$sitemap = str_replace(
			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
			'<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">',
			$sitemap
		);
		$sitemap = str_replace(
			'</url>',
			'  <mobile:mobile/>' . "\n" . '  </url>',
			$sitemap
		);
	}
	
	$path = $_CONF['path_html'] . basename($filename);
	clearstatcache();
	
	if (!file_exists($path)) {
		$fh = @fopen($path, 'wb');
		
		if ($fh === false) {
			COM_errorLog('Sitemap: cannot create Google sitemap file.  Please create the file "' . $path . '" manually.');
			return false;
		}
	} else {
		$fh = @fopen($path, 'r+b');
		
		if ($fh === false) {
			COM_errorLog('Sitemap: Google sitemap file is NOT writable: ' . $path);
			return false;
		}
	}
	
	if (flock($fh, LOCK_EX) === true) {
		ftruncate($fh, 0);
		rewind($fh);
		$result = @fwrite($fh, $sitemap);
		
		if (($result === false) || ($result != strlen($sitemap))) {
			COM_errorLog('Sitemap: cannot write into Google sitemap file fully: ' . $path);
		}
		
		@flock($fh, LOCK_UN);
		$retval = true;
	} else {
		COM_errorLog('Sitemap: cannot write-lock Google sitemap file: ' . $path);
	}
	
	@fclose($fh);
	
	return $retval;
}

/**
* Creates a Google Sitemap
*/
function SITEMAP_createGoogleSitemap() {
	global $_CONF, $_SMAP_CONF;
	
	$retval = false;
	
	// Header
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . LB
			 . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . LB;
	
	// Collects items
	$dataproxy  = Dataproxy::getInstance(1);
	$sp_excepts = explode(' ', $_SMAP_CONF['sp_except']);
	
	foreach (Dataproxy::getAllDriverNames() as $driver) {
		if (($driver === 'trackback') || ($driver === 'comments') ||
			($_SMAP_CONF['gsmap_' . $driver] === false)) {
			continue;
		}
		
		$items = $dataproxy->$driver->getAllItems(true);
		
		if (!is_array($items) || (count($items) === 0)) {
			continue;
		}
		
		foreach ($items as $item) {
			if ($driver === 'staticpages') {
				if (SITEMAP_isExcepted($item['id'], $sp_excepts)) {
					continue;
				}
				
				$temp = $dataproxy->$driver->getItemById($item['id']);
				$raw  = $temp['raw_data'];
				
				if ((($_SMAP_CONF['sp_type'] == 1) && ($raw['sp_centerblock'] != 1)) ||
					(($_SMAP_CONF['sp_type'] == 2) && ($raw['sp_centerblock'] == 1))) {
					continue;
				}
			}
			
			$sitemap .= '  <url>' . LB
					 .  '    <loc>' . $item['uri'] . '</loc>' . LB;
			
			if ($item['date'] !== false) {
				$sitemap .= '    <lastmod>' . SITEMAP_convertDate( $item['date'] ) . '</lastmod>' . LB;
			} else {
				$sitemap .= '    <lastmod>' . SITEMAP_convertDate(time()) . '</lastmod>' . LB;
			}
			
			$sitemap .= '    <changefreq>' . $_SMAP_CONF['freq_' . $driver]
					 .  '</changefreq>' . LB;
			$priority = (float) $_SMAP_CONF['priority_' . $driver];
			
			if (($priority != 0.5) AND ($priority >= 0.0) AND ($priority <= 1.0)) {
				$sitemap .= '    <priority>' . $priority . '</priority>' . LB;
			}
			
			$sitemap .= '  </url>' . LB;
		}
	}
	
	// Footer
	$sitemap .= '</urlset>' . LB;
	
	// Writes into the Google Sitemap
	foreach (explode(';', $_SMAP_CONF['google_sitemap_name']) as $filename) {
		$retval = $retval || !SITEMAP_write($filename, $sitemap);
	}
	
	return !$retval;
}

/**
* Check if a given static page id is excepted
*
* @param  string   id          a static page id
* @param  string   sp_excepts  an array of regular expressions WITH delimiters
*                              being '/'
* @return boolean  true = excepted, false = otherwise
*/
function SITEMAP_isExcepted($id, $sp_excepts) {
	foreach ($sp_excepts as $except) {
		if (strlen($except) > 0) {
			if ($except[0] != '/') {
				$except = '/' . $except . '/';
			}
			
			if (preg_match($except , $id)) {
				return true;
			}
		}
	}
	
	return false;
}

/**
* callback function for the pseudo cron job 
*/
function plugin_runScheduledTask_sitemap() {
	SITEMAP_createGoogleSitemap();
}

/**
* callback function when a new item was saved
*/
function plugin_itemsaved_sitemap($id, $type) {
	SITEMAP_createGoogleSitemap();
}
