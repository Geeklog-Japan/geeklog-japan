<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendarjp Plugin for Geeklog                                             |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2014 by dengen - taharaxp AT gmail DOT com             |
// |                                                                           |
// | Calendarjp plugin is based on prior work by:                              |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
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
* Calendarjp plugin automatic plugin install
*
* @package Calendarjp
*/

function plugin_autoinstall_calendarjp($pi_name)
{
    $pi_name         = 'calendarjp';
    $pi_display_name = 'Calendarjp';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.1.7',
        'pi_gl_version'   => '2.1.0',
        'pi_homepage'     => 'http://www.geeklog.jp/'
    );

    $groups = array(
//      $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
        $pi_admin => 'カレンダー管理者'
    );

    $features = array(
        $pi_name . '.moderate'                              => 'Ability to moderate pending events',
        $pi_name . '.edit'                                  => 'Access to event editor',
        $pi_name . '.submit'                                => 'May skip the event submission queue',
        'config.' . $pi_name . '.tab_main'                  => 'Access to configure general calendar settings',
        'config.' . $pi_name . '.tab_permissions'           => 'Access to configure event default permissions',
        'config.' . $pi_name . '.tab_autotag_permissions'   => 'Access to configure event autotag usage permissions',
        'config.' . $pi_name . '.tab_events_block'          => 'Access to configure events block'
    );

    $mappings = array(
        $pi_name . '.moderate'                              => array($pi_admin),
        $pi_name . '.edit'                                  => array($pi_admin),
        $pi_name . '.submit'                                => array($pi_admin),
        'config.' . $pi_name . '.tab_main'                  => array($pi_admin),
        'config.' . $pi_name . '.tab_permissions'           => array($pi_admin),
        'config.' . $pi_name . '.tab_autotag_permissions'   => array($pi_admin),
        'config.' . $pi_name . '.tab_events_block'          => array($pi_admin)
    );

    $tables = array(
        'eventsjp',
        'eventsubmissionjp',
        'personal_eventsjp'
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

function plugin_load_configuration_calendarjp($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_calendarjp();
}

function plugin_postinstall_calendarjp($pi_name)
{
    return true;
}

function plugin_compatible_with_this_version_calendarjp($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (function_exists('COM_printUpcomingEvents')) {
        // if this function exists, then someone's trying to install the
        // plugin on Geeklog 1.4.0 or older - sorry, but that won't work
        return false;
    }   

    if (!function_exists('MBYTE_strpos')) {
        // the plugin requires the multi-byte functions
        return false; 
    }   

    if (!function_exists('COM_createLink')) {
        return false;
    }

    if (!function_exists('SEC_createToken')) {
        return false;
    }

    if (!function_exists('COM_showMessageText')) {
        return false;
    }

    if (!function_exists('SEC_getTokenExpiryNotice')) {
        return false;
    }

    if (!function_exists('SEC_loginRequiredForm')) {
        return false;
    }

    return true;
}

?>
