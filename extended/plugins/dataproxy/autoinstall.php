<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Hiroron           - hiroron AT hiroron DOT com                   |
// |          mystral-kk        - geeklog AT mystral-kk DOT net                |
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

/**
* Autoinstall API functions for the DataProxy plugin
*
* @package DataProxy
*/

require_once __DIR__ . '/config.php';

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*/
function plugin_autoinstall_dataproxy($pi_name) {
	global $_DPXY_CONF;
	
    $pi_name         = 'dataproxy';
    $pi_display_name = 'Dataproxy';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => $_DPXY_CONF['pi_version'],
        'pi_gl_version'   => $_DPXY_CONF['gl_version'],
        'pi_homepage'     => $_DPXY_CONF['pi_url']
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.admin' => $pi_admin
    );

    $mappings = array(
        $pi_name . '.admin' => array($pi_admin)
    );

    $tables = array(
        'dpxy_notify'
    );

    return array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables
    );
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string   $pi_name    Plugin name
* @return   boolean              true: plugin compatible; false: not compatible
*/
function plugin_compatible_with_this_version_dataproxy($pi_name) {
    global $_CONF, $_DB_dbms;

    if (!function_exists('SEC_getGroupDropdown')) {
        return false;
    }

    if (!function_exists('SEC_createToken')) {
        return false;
    }

    if (!function_exists('COM_showMessageText')) {
        return false;
    }

    if (!function_exists('COM_setLangIdAndAttribute')) {
        return false;
    }

    return true;
}

/**
* Plugin postinstall
*
* We're inserting our default data here since it depends on other stuff that
* has to happen first ...
*
* @return   boolean     true = proceed with install, false = an error occured
*/
function plugin_postinstall_dataproxy($pi_name) {
    global $_TABLES;

    $inst_parms = plugin_autoinstall_dataproxy($pi_name);
    $pi_name = $inst_parms['info']['pi_name'];
    $pi_admin = key($inst_parms['groups']);

    $admin_group_id = DB_getItem(
		$_TABLES['groups'], 'grp_id', "grp_name = '{$pi_admin}'"
	);

    $DP_SQL = array();
    $DP_SQL[] = "CREATE TABLE {$_TABLES['dpxy_notify']} ("
              . "id int(10) NOT null AUTO_INCREMENT,"
              . "callback_name VARCHAR(30) NOT null DEFAULT '',"
              . "type VARCHAR(255) NOT null DEFAULT '',"
              . "KEY id(id)"
              . ")";

    $DP_SQL[] = "INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_gid', '#group#')";

    foreach ($DP_SQL as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
		
        if (DB_error()) {
            COM_errorLog("SQL error in DataProxy plugin postinstall, SQL: " . $sql);
            return false;
        }
    }

    return true;
}
