<?php

// +---------------------------------------------------------------------------+
// | Dbman Plugin for Geeklog - The Ultimate Weblog                            |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/install_defaults.php                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011-2016 mystral-kk - geeklog AT mystral-kk DOT net        |
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
* Dbman default settings
*
* Initial Installation Defaults used when loading the online configuration
* records.  These settings are only used during the initial installation
* and not referenced any more once the plugin is installed
*
*/
global $_DB_table_prefix, $_DBMAN_DEFAULT;

$_DBMAN_DEFAULT = array();

//===============================================
// Main settings
//===============================================

// The flag to decide whether to allow restoration in Dbman plugin.  SHOULD BE
// false TO PREVENT ACCIDENTAL DAMAGE TO DATABASE.  SET THIS OPTION TO true
// ONLY IF YOU KNOW WHAT YOU DO.  YOU HAVE BEEN WARNED!
$_DBMAN_DEFAULT['allow_restore'] = false;

// The number of records to select data from database when the dbman plugin
// backups a table.  If "MySQL client run out of memory." error occurs, decrease
// this value
$_DBMAN_DEFAULT['chunk_size'] = 100;

// The flag to indicate compression level:
// valid values: 1 (largest size) - 9 (smallest size)
$_DBMAN_DEFAULT['compression_level'] = 8;

// Table names which the Dbman plugin shouldn't backup the data of (table
// structures will always be backupped).  You can use regular expressions
// (preg_match() style) to designate table name(s).
// e.g. "/^{$_DB_table_prefix}sessions_/"
$_DBMAN_DEFAULT['backup_except']   = array();
$_DBMAN_DEFAULT['backup_except'][] = "/^{$_DB_table_prefix}gus_/";

// The flag to decide whether to backup with psedo-cron
$_DBMAN_DEFAULT['cron_backup'] = false;

// Maximum number of backup files to be kept.  When set to 0, no backup file
// will be deleted.
$_DBMAN_DEFAULT['max_backup'] = 0;

//===============================================
// Default settings for backup
//===============================================

// The flag to decide whether to add "DROP TABLE IF EXISTS ...".  For the
// compatibility with PhpMyAdminin, this should be set false.
$_DBMAN_DEFAULT['add_drop_table'] = false;

// The flag to decide whether to compress backup files.  If set true, the dbman
// plugin tries to compress the data with Zlib.  In this case, names of backup
// files are '*.sql.gz'.
$_DBMAN_DEFAULT['compress_data'] = false;

// The flag to decide whether to download backup files.
$_DBMAN_DEFAULT['download_as_file'] = false;

/**
* Initializes Dbman plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist.  Initial values will be taken from $_DBMAN_DEFAULT
* if available (e.g. from an old config.php), uses $_DBMAN_DEFAULT
* otherwise.
*
* @return   boolean     true: success; false: an error occurred
*/
function plugin_initconfig_dbman() {
    global $_DBMAN_DEFAULT;
	
	$me = 'dbman';
    $c = config::get_instance();
	
    if (!$c->group_exists($me)) {
        $c->add('sg_main', null, 'subgroup', 0, 0, null, 0, true, $me);
        $c->add('fs_main', null, 'fieldset', 0, 0, null, 1, true, $me);
        $c->add('fs_backup', null, 'fieldset', 0, 1, null, 2, true, $me);
		
		// Main settings
        $c->add('allow_restore', $_DBMAN_DEFAULT['allow_restore'], 'select', 0, 0, 0, 110, true, $me);
        $c->add('chunk_size', $_DBMAN_DEFAULT['chunk_size'], 'text', 0, 0, null, 120, true, $me);
        $c->add('compression_level', $_DBMAN_DEFAULT['compression_level'], 'select', 0, 0, 1, 130, true, $me);
        $c->add('backup_except', $_DBMAN_DEFAULT['backup_except'], '%text', 0, 0, null, 140, true, $me);
        $c->add('cron_backup', $_DBMAN_DEFAULT['cron_backup'], 'select', 0, 0, 0, 150, true, $me);
        $c->add('max_backup', $_DBMAN_DEFAULT['max_backup'], 'text', 0, 0, null, 160, true, $me);
		
		// Default settings for backup
        $c->add('add_drop_table', $_DBMAN_DEFAULT['add_drop_table'], 'select', 0, 1, 0, 210, true, $me);
        $c->add('compress_data', $_DBMAN_DEFAULT['compress_data'], 'select', 0, 1, 0, 220, true, $me);
        $c->add('download_as_file', $_DBMAN_DEFAULT['download_as_file'], 'select', 0, 1, 0, 230, true, $me);
    }
	
    return true;
}
