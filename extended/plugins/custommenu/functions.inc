<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/functions.inc                                          |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

/**
* Include language file
*/
$plugin_path = $_CONF['path'] . 'plugins/custommenu/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

$_CMED_CONF = array();

/**
* Add to $_TABLES array the tables custommenu plugin uses
*/
$_TABLES['menuitems'] = $_DB_table_prefix . 'menuitems';

/**
* Check and see if we need to load the plugin configuration
*/
require_once $_CONF['path_system'] . 'classes/config.class.php';
$plg_config = config::get_instance();
$temp = $plg_config->get_config('custommenu');
if (is_array($temp)) {
    $_CMED_CONF = array_merge($_CMED_CONF, $temp);
}

// Set path and URL to the templates directory
if (is_dir($_CONF['path_layout'] . 'custommenu')) {
    $_CMED_CONF['path_layout'] = $_CONF['path_layout'] . 'custommenu';
    $_CMED_CONF['css_url'] = $_CONF['layout_url'] . '/custommenu';

    //location of file relative to public_html directory.
    $_CMED_CONF['css_file'] = '/layout/' . $_CONF['theme'] . '/custommenu/custommenu.css';
} else {
    $_CMED_CONF['path_layout'] = $_CONF['path_html'] . 'custommenu/templates';
    $_CMED_CONF['css_url'] = $_CONF['site_url'] . '/custommenu/templates';

    //location of file relative to public_html directory.
    $_CMED_CONF['css_file'] = '/custommenu/templates/custommenu.css';
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+


/**
* Check to see if this Plugin uses comments
*
* Geeklog is checking to see if this plugin supports comments, tell it no!
* NOTE: to support comments you must use the same date/time based ID for your
* widget.  In other words, to make primary keys for your plugin you should call
* makesid().  Comments are keyed off of that...it is a limitation on how geeklog
* does comments.
*
* @return   boolean true or false
*
*/
function plugin_commentsupport_custommenu()
{
    return false;
}

/**
* This will put an option for custommenu in the command and control block on
* moderation.php
*
* @return   mixed   array(title, url, icon), or boolean false when not allowed
*
*/
function plugin_cclabel_custommenu()
{
    global $_CONF, $LANG_CMED;

    if (SEC_hasRights('custommenu.admin')) {
        return array ($LANG_CMED['display_name'],
                      $_CONF['site_admin_url'] . '/plugins/custommenu/index.php',
                      plugin_geticon_custommenu());
    }

    return false;
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_custommenu()
{
    global $_CONF;

    return $_CONF['site_url'] . '/custommenu/images/custommenu.gif';
}

/**
* returns the administrative option for this plugin
*
* Adds the plugin to the Admin menu
*
* Universal Plugin:  Modify use it
*
* @return   mixed   array(title, url, num. items), or void when not allowed
*
*/
function plugin_getadminoption_custommenu()
{
    global $_CONF, $_TABLES, $LANG_CMED;

    if (SEC_hasRights('custommenu.admin', 'OR')) {
        $pi_name   = $LANG_CMED['display_name'];
        $admin_url = $_CONF['site_admin_url'] . '/plugins/custommenu/index.php';
        $num_items = DB_getItem($_TABLES['menuitems'], 'COUNT(*)',
                                COM_getPermSql (''));

        return array($pi_name, $admin_url, $num_items);
    }
}

/**
* Called by the plugin Editor to display the current plugin code version
* This may be different than the version installed and registered currently.
* If newer then you may want to run the update
*
* @return   string  version number
*
*/
function plugin_chkVersion_custommenu()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/custommenu/autoinstall.php';

    $inst_parms = plugin_autoinstall_custommenu('custommenu');

    return $inst_parms['info']['pi_version'];
}

/**
* Upgrade the custommenu plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_custommenu()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/custommenu/autoinstall.php';

    return CMED_upgrade();
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_custommenu($old_conf)
{
    global $_CONF;

    $tables = array(
        'menuitems'    => 'mid, url, icon_url, pattern',
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
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
function plugin_autouninstall_custommenu()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/custommenu/autoinstall.php';

    return CMED_autouninstall();
}

function plugin_getListField_custommenu($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG25, $LANG_ACCESS;

    $retval = '';

    $access = SEC_hasAccess($A['owner_id'], $A['group_id'],
                            $A['perm_owner'], $A['perm_group'],
                            $A['perm_members'], $A['perm_anon']);
    if ($access > 0) {
        switch ($fieldname) {
            case 'edit':
                if ($access == 3) { // User is in Root group
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/plugins/custommenu/index.php"
                            . "?mode=edit&amp;uid={$A['uid']}\">{$icon_arr['edit']}</a>";
                }
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    } else {
        $retval = false;
    }

    return $retval;
}


/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_custommenu($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'custommenu/docs/' . $doclang . '/custommenu.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/custommenu/docs/english/custommenu.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, NULL to use config 
*                           tooltip hack, or empty string when not available
*
*/
function plugin_getconfigtooltip_custommenu($id)
{   
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

function plugin_getheadercode_custommenu()
{
    global $_SCRIPTS, $_CMED_CONF;

    $_SCRIPTS->setCSSFile('custommenu', $_CMED_CONF['css_file'], false);
}

function CMED_replaceLabel($label)
{
    preg_match('/(.+)\[(.+)\]/', $label, $m);
    if (($m[1] != '') && ($m[2] != '')) {
        $m[2] = str_replace("'", "", $m[2]);
        $m[2] = str_replace('"', "", $m[2]);
        $label = $GLOBALS[ $m[1] ][ $m[2] ];
    } else {
        $label = $GLOBALS[$label];
    }
    
    return $label;
}

function CMED_replaceUrl($url)
{
    global $_CONF;

    $url = preg_replace('/\[site_url\]/i',       $_CONF['site_url'],       $url);
    $url = preg_replace('/\[site_admin_url\]/i', $_CONF['site_admin_url'], $url);

    return $url;
}

if (!function_exists('CUSTOM_menuEntries')) {

    // $_CMED_pi_version = DB_getItem($_TABLES['plugins'], 'pi_version', "(pi_name = 'custommenu')");
    // $_CMED_CONF['pulldown_enabled'] = (version_compare($_CMED_pi_version, '0.4.0') >= 0);
    $_CMED_CONF['pulldown_enabled'] = true;
    $_CMED_CONF['current_url'] = COM_getCurrentURL();
    $_CMED_CONF['lang_id'] = COM_getLanguageId();

    function CUSTOM_menuEntries()
    {
        return CMED_menuEntries_recursive();
    }

    function CMED_menuEntries_recursive($pmid='')
    {
        global $_CONF, $_TABLES, $topic, $_CMED_CONF;

        $myentries = array();
        if (!empty($_TABLES['menuitems'])) {
            $sql = "SELECT * FROM {$_TABLES['menuitems']} WHERE is_enabled = 1";
            if ($_CMED_CONF['pulldown_enabled']) {
               $sql .= " AND pmid = '$pmid'";
            }
            if(!empty($topic)) {
                $sql .= " AND (tid = '$topic' OR tid = 'all')";
            } else {
                if(COM_onFrontpage()) {
                    $sql .= " AND (tid = 'homeonly' OR tid = 'all')";
                } else {
                    $sql .= " AND (tid = 'all')";
                }
            }
            $sql .= " ORDER BY menuorder ASC";
            $result = DB_query($sql);
            while ($A = DB_fetchArray($result)) {

                $sql2 = "SELECT * FROM {$_TABLES['menuitems']} "
                      . "WHERE mid = '" . $A['mid'] . '_' . $_CMED_CONF['lang_id'] . "'";
                $result2 = DB_query($sql2);
                if (DB_numRows($result2) == 1) {
                    // overwrite with data for language-specific menuitem
                    $A = DB_fetchArray($result2);
                }

                $access = SEC_hasAccess($A['owner_id'],    $A['group_id'],
                                        $A['perm_owner'],  $A['perm_group'],
                                        $A['perm_members'],$A['perm_anon']);
                if ($access > 0) {

                    $submenu_entries = array();
                    if ($_CMED_CONF['pulldown_enabled']) {
                        $submenu_entries = CMED_menuEntries_recursive($A['mid']);
                    }
                    $url         = CMED_replaceUrl($A['url']);
                    $icon_url    = CMED_replaceUrl($A['icon_url']);
                    $pattern     = stripslashes($A['pattern']);
                    $selected    = '';
                    $class_name  = stripslashes($A['class_name']);
                    $id_name     = stripslashes($A['mid']);
                    
                    switch ($A['mode']) {
                        case "fixation":
                            $label = stripslashes($A['label']);
                            break;
                            
                        case "variable":
                            $label = stripslashes($A['label_var']);
                            $label = CMED_replaceLabel($label);
                            break;
                            
                        case "php":
                            $function = stripslashes($A['php_function']);
                            if (function_exists($function)) {
                                $menuitems = $function();
                                if ((is_array ($menuitems)) && (sizeof($menuitems) > 0)) {
                                    $url      = $menuitems['url'];
                                    $label    = $menuitems['label'];
                                    $icon_url = $menuitems['icon_url'];
                                    if (!empty($menuitems['id_name'])) {
                                        $id_name = $menuitems['id_name'];
                                    }
                                    if (!empty($menuitems['class_name'])) {
                                        $id_name = $menuitems['class_name'];
                                    }
                                    if (is_array($menuitems['submenu_entries']) && !empty($menuitems['submenu_entries'])) {
                                        $submenu_entries = $menuitems['submenu_entries'];
                                    }
                                }
                            }
                            break;
                    }

                    if (!empty($pattern)) {
                        if ($A['is_preg'] == 0) {
                            $selected = (strpos($_CMED_CONF['current_url'], $pattern) === false) ? '' : 'uk-active';
                        } else {
                            $selected = (preg_match($pattern, $_CMED_CONF['current_url']) == 0)  ? '' : 'uk-active';
                        }
                    }
                    
                    $myentries[] = array('url'             => $url,
                                         'label'           => $label,
                                         'icon_url'        => $icon_url,
                                         'selected'        => $selected,
                                         'id_name'         => $id_name,
                                         'class_name'      => $class_name,
                                         'submenu_entries' => $submenu_entries);
                }
            }
        }
        return $myentries;
    }

    if (!function_exists('CUSTOM_renderMenu') && $_CMED_CONF['menu_render'] == 'pulldown') {

        function CUSTOM_renderMenu(&$T, $custom_entries, &$menuCounter)
        {
            global $_CONF, $_CMED_CONF;

            $T->set_root($_CMED_CONF['path_layout']);
            $T->set_file(array(
                'menuitem_custom' => 'menuitem.thtml',
                'menuitem_drop'   => 'menuitem_drop.thtml',
            ));
            CMED_renderMenu_sub_recursive($T, $custom_entries, $menuCounter);
            $T->set_root($_CONF['path_layout']);
        }
    }

    function CMED_renderMenu(&$T, $custom_entries, &$menuCounter)
    {
        global $_CONF, $_CMED_CONF;

        $T->set_root($_CMED_CONF['path_layout']);
        $T->set_file(array(
            'menuitem_custom' => 'menuitem.thtml',
            'menuitem_drop'   => 'menuitem_drop.thtml',
        ));
        CMED_renderMenu_sub_recursive($T, $custom_entries, $menuCounter);
        $T->set_root($_CONF['path_layout']);
    }

    function CMED_renderMenu_sub_recursive(&$T, $custom_entries, &$menuCounter)
    {
        global $_CONF, $_TABLES, $topic, $_CMED_CONF;

        $custom_count = 0;
        $custom_size = sizeof($custom_entries);
        foreach ($custom_entries as $entry) {
            $custom_count++;
            if (empty($entry['url']) || empty($entry['label'])) continue;

            $class_name = $entry['menuitem_class'];
            $class_name = trim($class_name) . ' ' . $entry['class_name'];
            $class_name = trim($class_name) . ' ' . $entry['selected'];
            $class_name = trim($class_name) . (($custom_count == $custom_size) ? ' last' : '');
            $class_name = trim($class_name);
            $class_property = (empty($class_name)) ? '' : (' class="' . $class_name . '"');

            if (empty($entry['submenu_entries'])) {
                $T->set_var('menuitem_url',   $entry['url']);
                $T->set_var('menuitem_text',  $entry['label']);
                $T->set_var('menuitem_id',    $_CMED_CONF['prefix_id'] . $entry['id_name']);
                $T->set_var('menuitem_class', $class_name);
                $T->set_var('class_property', $class_property);
                $T->set_var('menuitem_icon_url', $entry['icon_url']);
                $T->parse('menu_elements', 'menuitem_custom', true);
            } else {
                $T2 = new Template($_CMED_CONF['path_layout']);
                $T2->set_file(array(
                    'menuitem_custom' => 'menuitem.thtml',
                    'menuitem_drop'   => 'menuitem_drop.thtml',
                ));
                CMED_renderMenu_sub_recursive($T2, $entry['submenu_entries'], $menuCounter2);
                $T2->set_var('menuitem_url',   $entry['url']);
                $T2->set_var('menuitem_text',  $entry['label']);
                $T2->set_var('menuitem_id',    $_CMED_CONF['prefix_id'] . $entry['id_name']);
                $T2->set_var('menuitem_class', $class_name);
                $T2->set_var('class_property', $class_property);
                $T2->set_var('menuitem_icon_url', $entry['icon_url']);
                $T2->parse('submenu', 'menuitem_drop');
                $submenu = $T2->finish($T2->get_var('submenu'));

                $T->set_var('menu_elements', $submenu, true);
            }
            $menuCounter++;
        }
    }
}


function phpmenuitem_contribute()
{
    global $_CONF, $LANG01, $topic;

    if(empty($topic)) {
        $url = $_CONF['site_url'] . '/submit.php?type=story';
    } else {
        $url = $_CONF['site_url'] . '/submit.php?type=story&amp;topic=' . $topic;
    }
    $label = $LANG01[71];
    
    $menuitems = array(
        'url'        => $url,
        'label'      => $label,
        'icon_url'   => '',
        'id_name'    => '',
        'class_name' => '',
        'submenu_entries' => array(),
    );
    return $menuitems;
}

function phpmenuitem_login()
{
    global $_CONF, $_USER, $LANG01;

    if (!empty($_USER['uid']) && ($_USER['uid'] > 1)) {
        $url = $_CONF['site_url'] . '/users.php?mode=logout';
        $label = $LANG01[19];
    } else {
        $url = $_CONF['site_url'] . '/users.php?mode=login';
        $label = $LANG01[47];
    }

    $menuitems = array(
        'url'        => $url,
        'label'      => $label,
        'icon_url'   => '',
        'id_name'    => '',
        'class_name' => '',
        'submenu_entries' => array(),
    );
    return $menuitems;
}

?>