<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Captcha Plugin 3.5                                                        |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013 by the following authors:                              |
// |                                                                           |
// | Authors: Ben         - ben AT geeklog DOT fr                              |
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
* Captcha plugin automatic plugin install
*
* @package Captcha
*/

function plugin_autoinstall_captcha($pi_name)
{
    $pi_name         = 'captcha';
    $pi_display_name = 'Captcha';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '3.5.5',
        'pi_gl_version'   => '1.8.0',
        'pi_homepage'     => 'http://www.geeklog.fr/'
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        'config.' . $pi_name . '.tab_main'                  => 'Access to configure general captcha settings',
    );

    $mappings = array(
        'config.' . $pi_name . '.tab_main'                  => array($pi_admin)
    );

    $tables = array(
        'cp_sessions'
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

function plugin_load_configuration_captcha($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_captcha();
}

function plugin_compatible_with_this_version_captcha($pi_name)
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

function plugin_postinstall_captcha($pi_name)
{
    global $_TABLES, $_CONF, $_USER;
	
    /* This code is for statistics ONLY */
    $message =  'Completed captcha plugin install: ' .date('m d Y',time()) . "   AT " . date('H:i', time()) . "\n";
    $message .= 'Site: ' . $_CONF['site_url'] . ' and Sitename: ' . $_CONF['site_name'] . "\n";
    $pi_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'captcha'");
    COM_mail("ben@geeklog.fr","$pi_name Version:$pi_version Install successfull",$message);

	return true;
}
?>
