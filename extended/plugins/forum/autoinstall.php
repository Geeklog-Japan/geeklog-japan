<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008 by the following authors:                              |
// |    Dirk Haun         dirk AT haun-online DOT de                           |
// |                                                                           |
// | Forum Plugin Authors                                                      |
// |    Mr.GxBlock                                        www.gxblock.com      |
// |    Matthew DeWyer   matt AT mycws DOT com            www.cweb.ws          |
// |    Blaine Lang      geeklog AT langfamily DOT ca     www.langfamily.ca    |
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
// +---------------------------------------------------------------------------+

/**
* Autoinstall API functions for the Forum plugin
*
* @package GeeklogForum
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_forum($pi_name)
{
    $pi_name         = 'forum';
    $pi_display_name = 'Forum';
//  $pi_admin        = $pi_display_name . ' Admin';
    $pi_admin        = $pi_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '2.9.2',
        'pi_gl_version'   => '2.1.2',
        'pi_homepage'     => 'http://code.google.com/p/geeklog/'
    );

    $groups = array(
//      $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
        $pi_admin => 'Users in this group can administer the forum plugin'
    );

    $features = array(
        $pi_name . '.edit'      => 'Forum Admin',
        $pi_name . '.user'      => 'Forum Viewer'
    );

    $mappings = array(
        $pi_name . '.edit'      => array($pi_admin),
        $pi_name . '.user'      => array($pi_admin)
    );

    $tables = array(
        'forum_userprefs',
        'forum_topic',
        'forum_categories',
        'forum_forums',
        'forum_settings',
        'forum_watch',
        'forum_moderators',
        'forum_banned_ip',
        'forum_log',
        'forum_userinfo',
    );

    $requires = array(
        array(
               'db' => 'mysql',
               'version' => '4.1'
             )
    );    

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables,
        'requires'  => $requires
    );

    return $inst_parms;
}

/**
* Load plugin configuration from database
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true on success, otherwise false
* @see      plugin_initconfig_forum
*
*/
function plugin_load_configuration_forum($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_forum();
}

/**
* Plugin postinstall
*
* We're inserting our default data here since it depends on other stuff that
* has to happen first ...
*
* @return   boolean     true = proceed with install, false = an error occured
*
*/
/*
function plugin_postinstall_forum($pi_name)
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $gf_config = config::get_instance();
    $_GF_CONF = $gf_config->get_config('forum');

    $inst_parms = plugin_autoinstall_forum($pi_name);
    $pi_admin = key($inst_parms['groups']);

    $admin_group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                 "grp_name = '{$pi_admin}'");
    $blockadmin_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                "grp_name = 'Block Admin'");

    $GF_SQL = array();

    $GF_SQL[] = "INSERT INTO {$_TABLES['blocks']} (is_enabled,name,type,title,tid,blockorder,onleft,phpblockfn,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon) "
     . " VALUES ('1','Forum News','phpblock','Forumposts','all',0,0,'phpblock_forum_newposts',2,2,3,3,2,2)";

    $GF_SQL[] = "INSERT INTO {$_TABLES['blocks']} (is_enabled,name,type,title,tid,blockorder,onleft,phpblockfn,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon) "
     . " VALUES (0, 'forum_menu', 'phpblock', 'Forum Menu', 'all', 0, 1, 'phpblock_forum_menu', 2,2,3,2,2,2)";

    foreach ($GF_SQL as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
        if (DB_error()) {
            COM_errorLog("SQL error in Forum plugin postinstall, SQL: " . $sql);
            return false;
        }
    }

    return true;
}
*/

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_forum($pi_name)
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
    
    if (!function_exists('TOPIC_getList')) {
        return false;
    }    

	if (!function_exists('CTL_plugin_templatePath')) {
        return false;
    }    

    return true;
}

?>
