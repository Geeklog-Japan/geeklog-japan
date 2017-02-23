<?php

// +---------------------------------------------------------------------------+
// | Japanize Plugin for Geeklog - The Ultimate Weblog                         |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/japanize/autoinstall.php                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tsuchi           - tsuchi AT geeklog DOT jp                      |
// |          mystral-kk       - geeklog AT mystral-kk DOT net                 |
// +---------------------------------------------------------------------------+
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

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*/
function plugin_autoinstall_japanize($pi_name) {
    global $_JPN_CONF;
    
    include_once 'version.php';

    return array(
        'info'            => array(
            'pi_name'         => 'japanize',
            'pi_display_name' => 'Japanize',
            'pi_version'      => $_JPN_CONF['version'],
            'pi_gl_version'   => '2.1.2',
            'pi_homepage'     => 'https://www.geeklog.jp/filemgmt/index.php?id=340',
        ),
        'groups'          => array(
            'Japanize Admin' => 'Has full access to Japanize features',
        ),
        'features'        => array(
            'japanize.edit'  => 'Access to Japanize editor',
        ),
        'mappings'        => array(
            'japanize.edit'  => array('Japanize Admin'),
        ),
        'tables'          => array(),
    );
}

function plugin_load_configuration_japanize($pi_name) {
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once 'install_defaults.php';

    return plugin_initconfig_japanize();
}

function plugin_compatible_with_this_version_japanize($pi_name) {
    return function_exists('DB_escapeString') &&
           function_exists('COM_truncate') &&
           function_exists('MBYTE_strpos') &&
           function_exists('SEC_createToken') &&
           !function_exists('custom_mail');
}
