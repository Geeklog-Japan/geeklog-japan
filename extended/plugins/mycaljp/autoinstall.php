<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | plugins/mycaljp/autoinstall.php                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// | Geeklog Author:        Tony Bibbs - tony AT tonybibbs DOT com             |
// | mycal Block Author:    Blaine Lang - geeklog AT langfamily DOT ca         |
// | Mycaljp Plugin Author: dengen - taharaxp AT gmail DOT com                 |
// | Original PHP Calendar by Scott Richardson - srichardson@scanonline.com    |
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

function plugin_autoinstall_mycaljp($pi_name)
{
    $pi_name         = 'mycaljp';
    $pi_display_name = 'Mycaljp';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '2.2.0',
        'pi_gl_version'   => '2.0.0',
        'pi_homepage'     => 'http://www.trybase.com/~dengen/log/'
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.admin'  => 'Mycaljp Admin'
    );

    $mappings = array(
        $pi_name . '.admin'  => array($pi_admin)
    );

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

function plugin_load_configuration_mycaljp($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_mycaljp();
}

function plugin_compatible_with_this_version_mycaljp($pi_name)
{
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

    return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function MYCALJP_autouninstall()
{
    global $_CONF;

    $out = array(
        'tables'     => array(),
        'groups'     => array('Mycaljp Admin'),
        'features'   => array('mycaljp.admin'),
        'php_blocks' => array('phpblock_mycaljp2'),
        'vars'       => array()
    );

    $fname = $_CONF['path_data'] . 'mycaljp_conf.php';
    if (file_exists($fname)) {
        @unlink($fname);
    }

    return $out;
}

/**
* Upgrade the plugin
*
* @return   boolean true (= success)
*
*/
function MYCALJP_upgrade()
{
    global $_CONF, $_TABLES;

    $pi_name = 'mycaljp';
    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = '$pi_name'");
    $func = "plugin_chkVersion_$pi_name";
    $code_version = $func();
    if ($installed_version == $code_version) return true;
    $func = "plugin_compatible_with_this_version_$pi_name";
    if (!$func($pi_name)) return 3002;

    if (version_compare($installed_version, '2.1.0') < 0) {
        require_once $_CONF['path'] . 'plugins/mycaljp/install_defaults.php';
        plugin_initconfig_mycaljp();
    }

    if (version_compare($installed_version, '2.1.3') < 0) {
        require_once $_CONF['path'] . 'plugins/mycaljp/install_defaults.php';
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $c = config::get_instance();
        $conf_vals = $c->get_config('mycaljp');
        $c->del('template', 'mycaljp');
        $c->add('template', $_MYCALJP2_DEFAULT['template'], 'select', 0, 0, NULL, 0, true, 'mycaljp');
        $c->set('template', $conf_vals['template'], 'mycaljp');
        // MYCALJP_updateSortOrder();
    }

    if (version_compare($installed_version, '2.1.4') < 0) {
        require_once $_CONF['path'] . 'plugins/mycaljp/install_defaults.php';
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        if (function_exists('COM_versionCompare')) {
            MYCALJP_update_ConfValues_addTabs();
        }
        // MYCALJP_updateSortOrder();
    }

    if (version_compare($installed_version, '2.2.0') < 0) {

        // Delete Old Site Calendar Blocks since now dynamic blocks
        DB_query("DELETE FROM {$_TABLES['blocks']} WHERE phpblockfn = 'phpblock_mycaljp2'");

        require_once $_CONF['path'] . 'plugins/mycaljp/install_defaults.php';
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        MYCALJP_update_ConfValues_2_1_4();
        MYCALJP_updateSortOrder();
    }

    $func = "plugin_autoinstall_$pi_name";
    $inst_parms = $func($pi_name);
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    // Update the version numbers
    DB_query("UPDATE {$_TABLES['plugins']} "
           . "SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' "
           . "WHERE pi_name = '$pi_name'");

    COM_errorLog(ucfirst($pi_name)
        . " plugin was successfully updated to version $code_version.");

    return true;
}

?>
