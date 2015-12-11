<?php

// +---------------------------------------------------------------------------+
// | nmoxtopicown Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/nmoxtopicown/autoinstall.php                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2012 by nmox                                           |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), strtolower(basename(__FILE__))) !== FALSE) {
	die('This file cannot be used on its own!');
}

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*/
function plugin_autoinstall_nmoxtopicown($pi_name) {
	global $_NMOXTOPICOWN;
	
	require_once dirname(__FILE__) . '/config.php';
	
	$pi_name         = 'nmoxtopicown';
	$pi_display_name = 'Nmoxtopicown';
	$pi_admin        = $pi_display_name . ' Admin';
	
	$info = array(
		'pi_name'         => $pi_name,
		'pi_display_name' => $pi_display_name,
		'pi_version'      => $_NMOXTOPICOWN['pi_version'],
		'pi_gl_version'   => $_NMOXTOPICOWN['gl_version'],
		'pi_homepage'     => $_NMOXTOPICOWN['pi_url'],
	);
	
	$groups   = $_NMOXTOPICOWN['GROUPS'];
	$features = $_NMOXTOPICOWN['FEATURES'];
	$mappings = $_NMOXTOPICOWN['MAPPINGS'];
	
	$tables = array();
	
	$inst_parms = array(
		'info'      => $info,
		'groups'    => $groups,
		'features'  => $features,
		'mappings'  => $mappings,
		'tables'    => $tables
	);
	
	return $inst_parms;
}

/**
* Checks if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*/
function plugin_compatible_with_this_version_nmoxtopicown($pi_name) {
	global $_CONF, $_DB_dbms;
	
	return TRUE;
}
