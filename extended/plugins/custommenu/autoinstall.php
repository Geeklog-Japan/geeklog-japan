<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/autoinstall.php                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2013 dengen - taharaxp AT gmail DOT com                |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett               -    twillett AT users DOT sourceforge DOT net  |
// | Blaine Lang               -    langmail AT sympatico DOT ca               |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                -    tony AT tonybibbs DOT com                  |
// | Modified by:                                                              |
// | mystral-kk                -    geeklog AT mystral-kk DOT net              |
// | dengen                    -    taharaxp AT gmail DOT com                  |
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

$_CMED_plugin_label_var = array(
    'calendar'     => "LANG_CAL_1[16]",
    'calendarjp'   => "LANG_CALJP_1[16]",
    'links'        => "LANG_LINKS[114]",
    'polls'        => "LANG_POLLS['polls']",
    'forum'        => "LANG_GF00['pluginlabel']",
    'filemgmt'     => "LANG_FILEMGMT['downloads']",
    'downloads'    => "LANG_DLM['downloads']",
    'mediagallery' => "_MG_CONF['menulabel']",
    'sitemap'      => "LANG_SMAP['menu_label']",
    'autotags'     => "LANG_AUTO['main_menulabel']",
    'tag'          => "LANG_TAG['admin_label']",
    'faqman'       => "LANG_FAQ['headerlabel']",
    'vthemes'      => "LANG_VT00['menulabel']",
    'dokuwiki'     => "LANG_DW00['menulabel']",
);

function plugin_autoinstall_custommenu($pi_name)
{
    $pi_name         = 'custommenu';
    $pi_display_name = 'CustomMenu';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '0.7.0',
        'pi_gl_version'   => '2.0.0',
        'pi_homepage'     => 'http://www.trybase.com/~dengen/log/'
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.admin'  => 'CustomMenu Admin',
        'config.' . $pi_name . '.tab_main'        => 'Access to configure general custommenu settings',
        'config.' . $pi_name . '.tab_permissions' => 'Access to configure custommenu default permissions',
    );

    $mappings = array(
        $pi_name . '.admin'  => array($pi_admin),
        'config.' . $pi_name . '.tab_main'        => array($pi_admin),
        'config.' . $pi_name . '.tab_permissions' => array($pi_admin),
    );

    $tables = array(
        'menuitems',
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

function plugin_load_configuration_custommenu($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_custommenu();
}

function plugin_postinstall_custommenu($pi_name)
{
    global $_CONF, $_TABLES, $LANG01;

    $inst_parms = plugin_autoinstall_custommenu($pi_name);
    $pi_admin = key($inst_parms['groups']);

    $admin_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = '{$pi_admin}'");
    $blockadmin_id  = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Block Admin'");

    $DEFVALUES = array();
    $url = addslashes('[site_url]/');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('home',       'gldefault', 'variable', '" . $LANG01[90]  . "', 'LANG01[90]',                           '$url', 10, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/submit.php?type=story');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var, php_function, url, menuorder, owner_id, group_id, perm_anon) VALUES ('contribute', 'gldefault', 'php',      '" . $LANG01[71]  . "', 'LANG01[71]', 'phpmenuitem_contribute', '$url', 20, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/search.php');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('search',     'gldefault', 'variable', '" . $LANG01[75]  . "', 'LANG01[75]',                           '$url', 30, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/stats.php');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('stats',      'gldefault', 'variable', '" . $LANG01[76]  . "', 'LANG01[76]',                           '$url', 40, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/directory.php');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('directory',  'gldefault', 'variable', '" . $LANG01[117] . "', 'LANG01[117]',                          '$url', 50, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/usersettings.php?mode=edit');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('prefs',      'gldefault', 'variable', '" . $LANG01[48]  . "', 'LANG01[48]',                           '$url', 60, 2, '#group#' ,0)";

    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var, php_function, url, menuorder, owner_id, group_id, perm_anon) VALUES ('login',      'custom',    'php',      '" . $LANG01[47]  . "', '',           'phpmenuitem_login',      '',     70, 2, '#group#' ,2)";

    foreach ($DEFVALUES as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
        if (DB_error()) {
            COM_error("SQL error in custommenu plugin postinstall, SQL: " . $sql);
            return false;
        }
    }

    // Set menu elements
    $c = config::get_instance();
    $c->set('menu_elements', array('custom'));
    CMED_addPluginsMenuitems();

    return true;
}

function plugin_compatible_with_this_version_custommenu($pi_name)
{
    return (version_compare(VERSION, '1.7.99') > 0); // means Geeklog 1.8.0 or later (also includes beta version and rc version)
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
function CMED_autouninstall()
{
    global $_CONF, $_TABLES;

    // Restore menu elements
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $c = config::get_instance();
    $sql = "SELECT subgroup,tab FROM {$_TABLES['conf_values']} "
         . "WHERE name = 'menu_elements' AND group_name = 'Core'";
    $result = DB_query($sql);
    $A = DB_fetchArray($result);
    $result = $c->restore_param('menu_elements', 'Core', $A['subgroup'], $A['tab']);

    if ($result == true) {
        $out = array(
            // give the name of the tables, without $_TABLES[]
            'tables' => array('menuitems'),

            // give the full name of the group, as in the db
            'groups' => array('CustomMenu Admin'),

            // give the full name of the feature, as in the db
            'features' => array('custommenu.admin',
                                'config.custommenu.tab_main',
                                'config.custommenu.tab_permissions'),
        );
        return $out;
    }
}

/**
* Upgrade the custommenu plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function CMED_upgrade()
{
    global $_CONF, $_TABLES, $_CMED_CONF;

    $pi_name = 'custommenu';
    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = '$pi_name'");
    $code_version = plugin_chkVersion_custommenu();
    if ($installed_version == $code_version) return true;
    if (!plugin_compatible_with_this_version_custommenu($pi_name)) return 3002;

    $inst_parms = plugin_autoinstall_custommenu($pi_name);
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    require_once $_CONF['path'] . 'plugins/custommenu/install_updates.php';

    if (version_compare($installed_version, '0.2.0') < 0) {
        plugin_initconfig_custommenu();
    }

    if (version_compare($installed_version, '0.3.0') < 0) {
        $sql = "ALTER TABLE {$_TABLES['menuitems']} "
             . "ADD COLUMN pattern varchar(255) default NULL,"
             . "ADD COLUMN is_preg tinyint(1) NOT NULL default '0'";
        DB_query($sql);
    }

    if (version_compare($installed_version, '0.4.0') < 0) {
        $sql = "ALTER TABLE {$_TABLES['menuitems']} "
             . "ADD COLUMN pmid varchar(40) NOT NULL default '',"
             . "ADD COLUMN class_name varchar(48) default NULL";
        DB_query($sql);
    }

    if (version_compare($installed_version, '0.4.1') < 0) {
        require_once $_CONF['path'] . 'plugins/custommenu/install_defaults.php';
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $c = config::get_instance();
        $n = DB_count($_TABLES['conf_values'], "name", 'menu_render');
        if ($n == 0) {
            $c->add('menu_render', $_CMED_DEFAULT['menu_render'], 'select', 0, 0, 10, 20, true, 'custommenu');
        }
        $n = DB_count($_TABLES['conf_values'], "name", 'prefix_id');
        if ($n == 0) {
            $c->add('prefix_id', $_CMED_DEFAULT['prefix_id'], 'text', 0, 0, 0, 30, true, 'custommenu');
        }
        DB_query("UPDATE {$_TABLES['conf_values']} SET sort_order = 40 WHERE name = 'default_permissions'");
    }

    if (version_compare($installed_version, '0.5.0') < 0) {
        // Set new Tab column to whatever fieldset is
        $_SQL = array();
        $_SQL[] = "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'custommenu'";
        $_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.custommenu.tab_main', 'Access to configure general custommenu settings', 0)";
        $_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.custommenu.tab_permissions', 'Access to configure custommenu default permissions', 0)";
        foreach ($_SQL as $sql) {
            DB_query($sql);
        }
        custommenu_update_ConfValues_0_5_0();
        custommenu_update_ConfigSecurity_0_5_0();
    }

    // Update the version numbers
    DB_query("UPDATE {$_TABLES['plugins']} "
           . "SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' "
           . "WHERE pi_name = '$pi_name'");

    COM_errorLog(ucfirst($pi_name)
        . " plugin was successfully updated to version $code_version.");

    return true;
}

/**
* Add Menuitems of the plugins
*/
function CMED_addPluginsMenuitems()
{
    global $_PLUGINS, $_TABLES, $_CMED_plugin_label_var;

    if (empty($_PLUGINS)) return true;

    $SQLS = array();
    $num = DB_getItem($_TABLES['menuitems'], "MAX(menuorder)") + 10;
    $menuitems = array();
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'CustomMenu Admin'");
    foreach ($_PLUGINS as $pi_name) {
        if ($pi_name == 'staticpages') continue;
        if (DB_count($_TABLES['menuitems'], "mid", $pi_name) != 1) {
            $function = 'plugin_getmenuitems_' . $pi_name;
            if (function_exists($function)) {
                $menuitems = $function();
                if ((is_array($menuitems)) && (sizeof($menuitems) > 0)) {
                    $mid = $pi_name;
                    $url = addslashes(current($menuitems));
                    $label = addslashes(key($menuitems));
                    $label_var = (!empty($_CMED_plugin_label_var[$pi_name])) ? $_CMED_plugin_label_var[$pi_name] : '';
                    $label_var = addslashes($label_var);
                    $mode = (!empty($_CMED_plugin_label_var[$pi_name])) ? 'variable' : 'fixation';
                    
                    $SQLS[] = "INSERT INTO " . $_TABLES['menuitems'] 
                            . " (mid, is_enabled, type, mode, label, label_var, url, menuorder, owner_id, group_id) "
                            . "VALUES ('$mid', 1, 'plugin', '$mode', '$label', '$label_var', '$url', $num, 2, '$group_id')";
                    $num += 1;
                }
            }
        }
    }

    foreach ($SQLS as $sql) {
        DB_query($sql, 1);
        if (DB_error()) {
            return false;
        }
    }
    return true;
}
?>