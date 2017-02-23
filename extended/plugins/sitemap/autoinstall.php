<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/autoinstall.php                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2012-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
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
	die('This file cannot be used on its own!');
}

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*/
function plugin_autoinstall_sitemap($pi_name) {
	global $_SMAP_CONF;
	
	require_once __DIR__ . '/config.php';
	
	$pi_name         = 'sitemap';
	$pi_display_name = 'Sitemap';
	$pi_admin        = $pi_display_name . ' Admin';
	
	$info = array(
		'pi_name'         => $pi_name,
		'pi_display_name' => $pi_display_name,
		'pi_version'      => $_SMAP_CONF['pi_version'],
		'pi_gl_version'   => $_SMAP_CONF['gl_version'],
		'pi_homepage'     => $_SMAP_CONF['pi_url'],
	);
	
	$groups   = $_SMAP_CONF['GROUPS'];
	$features = $_SMAP_CONF['FEATURES'];
	$mappings = $_SMAP_CONF['MAPPINGS'];
	$tables   = array('smap_config');
	
	$inst_parms = array(
		'info'      => $info,
		'groups'    => $groups,
		'features'  => $features,
		'mappings'  => $mappings,
		'tables'    => $tables,
	);
	
	return $inst_parms;
}

/**
* Checks if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*/
function plugin_compatible_with_this_version_sitemap($pi_name) {
	global $_CONF, $_DB_dbms;
	
	// Checks if we support the DBMS the site is running on
	$dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
			. $_DB_dbms . '_install.php';
	
	if (!file_exists($dbFile)) {
		return false;
	}
	
	return true;
}
