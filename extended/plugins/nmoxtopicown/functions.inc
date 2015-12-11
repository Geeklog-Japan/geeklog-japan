<?php

// +---------------------------------------------------------------------------+
// | nmoxtopicown Geeklog Plugin                                               |
// +---------------------------------------------------------------------------+
// | function.inc                                                              |
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
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== FALSE){
    die ('This file cannot be used on its own.');
}

if (!defined('XHTML')) {
    define('XHTML', '');
}

// Language file Include
$langfile = $_CONF['path'] . 'plugins/nmoxtopicown/language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
	include_once $langfile;
} else {
	include_once $_CONF['path'] . 'plugins/nmoxtopicown/language/english.php';
}

require_once $_CONF['path'] . 'plugins/nmoxtopicown/config.php';

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

function plugin_chkVersion_nmoxtopicown() {
	global $_NMOXTOPICOWN;

	return $_NMOXTOPICOWN['pi_version'];
}

/**
* Check to see if this Plugin uses comments
*
* @return   boolean TRUE or FALSE
*/
function plugin_commentsupport_nmoxtopicown() {
	return FALSE;
}

function plugin_upgrade_nmoxtopicown () {
    global $_TABLES, $_NMOXTOPICOWN;

    $v = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'nmoxtopicown'");

    if ($v !== $_NMOXTOPICOWN['pi_version']) {
        // Updates version number
		$sql = "UPDATE {$_TABLES['plugins']} "
			 . "SET pi_version = '" . addslashes($_NMOXTOPICOWN['pi_version'])
			 . "', pi_gl_version = '1.4.1' "
			 . "WHERE pi_name = 'nmoxtopicown'";
        DB_query($sql);
    }

    return TRUE;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*/
function plugin_autouninstall_nmoxtopicown() {
	$out = array (
		/* give the name of the tables, without $_TABLES[] */
		'tables'     => array(),
		/* give the full name of the group, as in the db */
		'groups'     => array('nmoxtopicown Admin'),
		/* give the full name of the feature, as in the db */
		'features'   => array('nmoxtopicown.edit'),
		/* give the full name of the block, including 'phpblock_', etc */
		'php_blocks' => array(),
		/* give all vars with their name */
		'vars'       => array(),
	);

	return $out;
}

/**
* Removes the datastructures for this plugin from the Geeklog database.
*
* @param    string   $installCheck     Defult is blank but if set, check if
*                                      plugin is disabled first
* @return   boolean TRUE if successful FALSE otherwise
*/
function plugin_uninstall_nmoxtopicown($installCheck = '') {
	global $_TABLES, $LANG_NMOXTOPICOWN, $_CONF;

	$pi_name  = 'nmoxtopicown';
	$grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_admin'");
	DB_delete($_TABLES['plugins'], 'pi_name', 'nmoxtopicown');
	DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id",1);
	$FEATURES = array('nmoxtopicown.edit');
	
	foreach ($FEATURES as $feature) {
		$feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
		DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id", 1);
		DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id", 1);
	}
	
	DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_admin'");
	DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id", 1);

	return TRUE;
}

function plugin_getadminoption_nmoxtopicown() {
	global $_CONF, $_NMOXTOPICOWN, $_TABLES, $LANG_NMOXTOPICOWN;

	if (SEC_hasRights('nmoxtopicown.edit')) {
		return array ($LANG_NMOXTOPICOWN['nmoxtopicown'], $_CONF['site_admin_url'] . '/plugins/nmoxtopicown/index.php');
	}
}
