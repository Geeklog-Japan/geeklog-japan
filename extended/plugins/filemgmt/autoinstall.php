<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
// +-------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or           |
// | modify it under the terms of the GNU General Public License             |
// | as published by the Free Software Foundation; either version 2          |
// | of the License, or (at your option) any later version.                  |
// |                                                                         |
// | This program is distributed in the hope that it will be useful,         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                    |
// | See the GNU General Public License for more details.                    |
// |                                                                         |
// | You should have received a copy of the GNU General Public License       |
// | along with this program; if not, write to the Free Software Foundation, |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.         |
// |                                                                         |
// +-------------------------------------------------------------------------+

/**
* Autoinstall API functions for the Filemgmt plugin
*
* @package Filemgmt
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_filemgmt($pi_name)
{
    $pi_name         = 'filemgmt';
    $pi_display_name = 'Filemgmt';
    $pi_admin        = $pi_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.6.0.jp3',
        'pi_gl_version'   => '1.6.0',
        'pi_homepage'     => 'http://www.geeklog.jp/'
    );

    $groups = array(
        $pi_admin => 'Users in this group can administer the ' . $pi_name . ' plugin'
    );

    $features = array(
        $pi_name . '.user'   => 'filemgmt Access',
        $pi_name . '.edit'   => 'filemgmt Admin Rights',
        $pi_name . '.upload' => 'filemgmt File Upload Rights'
    );

    $mappings = array(
        $pi_name . '.user'   => array($pi_admin),
        $pi_name . '.edit'   => array($pi_admin),
        $pi_name . '.upload' => array($pi_admin)
    );

    $tables = array(
        'filemgmt_category',
        'filemgmt_filedetail',
        'filemgmt_filedesc',
        'filemgmt_broken',
        'filemgmt_votedata',
        'filemgmt_downloadhistory'
    );

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
* Load plugin configuration from database
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true on success, otherwise false
* @see      plugin_initconfig_filemgmt
*
*/
function plugin_load_configuration_filemgmt($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_filemgmt();
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_filemgmt($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (!function_exists('COM_truncate') || !function_exists('MBYTE_strpos')) {
        return false;
    }

    if (!function_exists('SEC_createToken')) {
        return false;
    }

    if (!function_exists('COM_showMessageText')) {
        return false;
    }

    return true;
}

?>
