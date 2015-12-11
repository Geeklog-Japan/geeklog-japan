<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendarjp Plugin for Geeklog                                             |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2012 by dengen - taharaxp AT gmail DOT com             |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Calendarjp default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_CAJP_DEFAULT;
$_CAJP_DEFAULT = array();

// when set to 1 will only allow logged-in users to view the list of past events
// (also see $_CONF['loginrequired'] in Geeklog's main configuration)
$_CAJP_DEFAULT['calendarloginrequired']   = 0;

// enable (set to 1) or disable (set to 0) submission queues:
$_CAJP_DEFAULT['eventsubmission'] = 1;

// Set to 1 to hide the "Calendarjp" entry from the top menu:
$_CAJP_DEFAULT['hidecalendarmenu']    = 0;

// Calendarjp Settings
$_CAJP_DEFAULT['personalcalendars']     = 1;
$_CAJP_DEFAULT['showupcomingevents']    = 1;
$_CAJP_DEFAULT['upcomingeventsrange']   = 90; // days
$_CAJP_DEFAULT['event_types']  = "記念日,約束,誕生日,打ち合わせ,セミナー,休日,会議,用事"
                                .",個人の用事,電話,特別な行事,旅行,休暇";

// Whether to use 12 hour (am/pm) or 24 hour mode
$_CAJP_DEFAULT['hour_mode'] = 24; // 12 hour am/pm or 24 hour format

// notify when a new event was submitted for the site calendarjp (when set = 1)
$_CAJP_DEFAULT['notification'] = 0;

// When a user is deleted, ownership of events created by that user can
// be transfered to a user in the Root group (= 0) or the events can be
// deleted (= 1).
$_CAJP_DEFAULT['delete_event'] = 0;

/** What to show after a event has been saved? Possible choices:
 * 'item' -> forward to the event
 * 'list' -> display the admin-list of the calendarjp
 * 'plugin' -> display the public homepage of the calendarjp plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_CAJP_DEFAULT['aftersave'] = 'list';

// Events Block
$_CAJP_DEFAULT['block_isleft'] = 1;
$_CAJP_DEFAULT['block_order'] = 50;
$_CAJP_DEFAULT['block_topic_option'] = TOPIC_ALL_OPTION;
$_CAJP_DEFAULT['block_topic'] = array();
$_CAJP_DEFAULT['block_enable'] = true;
$_CAJP_DEFAULT['block_permissions'] = array (2, 2, 2, 2);

// Define default permissions for new events created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_CAJP_DEFAULT['default_permissions'] = array(3, 2, 2, 2);

// Define default usuage permissions for the calendarjp autotags.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 2 = use
// 0 = cannot use
// (a value of 1 is not allowed)
$_CAJP_DEFAULT['autotag_permissions_event'] = array (2, 2, 2, 2);

// Support Advanced Rich Text Editor
$_CAJP_DEFAULT['advanced_editor'] = true;

// Support wiki-formatted Text Editor
$_CAJP_DEFAULT['wikitext_editor'] = false;

// Default Post Mode
$_CAJP_DEFAULT['postmode'] = 'plaintext';

// when set to 1 will only allow logged-in users to add master events
$_CAJP_DEFAULT['addeventloginrequired'] = 0;

/**
* Initialize Calendarjp plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_CAJP_CONF if available (e.g. from
* an old config.php), uses $_CAJP_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_calendarjp()
{
    global $_CONF, $_CAJP_CONF, $_CAJP_DEFAULT, $_TABLES, $_GROUPS;

    if (is_array($_CAJP_CONF) && (count($_CAJP_CONF) > 1)) {
        $_CAJP_DEFAULT = array_merge($_CAJP_DEFAULT, $_CAJP_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('calendarjp')) {

        if (isset($_CONF['hour_mode'])) {
            $_CAJP_DEFAULT['hour_mode'] = $_CONF['hour_mode'];
        }

        // 'event_types' used to be a comma-separated list but that would be
        // clumsy to handle in the GUI, so let's make it an array
        if (!is_array($_CAJP_DEFAULT['event_types'])) {
            $_CAJP_DEFAULT['event_types'] = explode(',', $_CAJP_DEFAULT['event_types']);

            $num_types = count($_CAJP_DEFAULT['event_types']);
            for ($i = 0; $i < $num_types; $i++) {
                $_CAJP_DEFAULT['event_types'][$i] = trim($_CAJP_DEFAULT['event_types'][$i]);
            }
        }

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'calendarjp', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'calendarjp', 0);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'calendarjp', 0);
        $c->add('calendarloginrequired', $_CAJP_DEFAULT['calendarloginrequired'],
                'select', 0, 0, 0, 10, true, 'calendarjp', 0);
        $c->add('addeventloginrequired', $_CAJP_DEFAULT['addeventloginrequired'],
                'select', 0, 0, 0, 15, true, 'calendarjp', 0);
        $c->add('hidecalendarmenu', $_CAJP_DEFAULT['hidecalendarmenu'],
                'select', 0, 0, 1, 20, true, 'calendarjp', 0);
        $c->add('personalcalendars', $_CAJP_DEFAULT['personalcalendars'],
                'select', 0, 0, 1, 30, true, 'calendarjp', 0);
        $c->add('eventsubmission', $_CAJP_DEFAULT['eventsubmission'],
                'select', 0, 0, 0, 40, true, 'calendarjp', 0);
        $c->add('showupcomingevents', $_CAJP_DEFAULT['showupcomingevents'],
                'select', 0, 0, 0, 50, true, 'calendarjp', 0);
        $c->add('upcomingeventsrange', $_CAJP_DEFAULT['upcomingeventsrange'],
                'text', 0, 0, 0, 60, true, 'calendarjp', 0);
        $c->add('hour_mode', $_CAJP_DEFAULT['hour_mode'],
                'select', 0, 0, 6, 70, true, 'calendarjp', 0);
        $c->add('event_types', $_CAJP_DEFAULT['event_types'],
                '%text', 0, 0, NULL, 80, true, 'calendarjp', 0);
        $c->add('notification', $_CAJP_DEFAULT['notification'],
                'select', 0, 0, 0, 90, true, 'calendarjp', 0);
        $c->add('delete_event', $_CAJP_DEFAULT['delete_event'],
                'select', 0, 0, 0, 100, true, 'calendarjp', 0);
        $c->add('aftersave', $_CAJP_DEFAULT['aftersave'],
                'select', 0, 0, 9, 110, true, 'calendarjp', 0);

        $c->add('advanced_editor', $_CAJP_DEFAULT['advanced_editor'],
                'select', 0, 0, 1, 120, true, 'calendarjp', 0);

        $c->add('wikitext_editor', $_CAJP_DEFAULT['wikitext_editor'],
                'select', 0, 0, 1, 130, true, 'calendarjp', 0);

        $c->add('postmode', $_CAJP_DEFAULT['postmode'],
                'select', 0, 0, 5, 140, true, 'calendarjp', 0);

        $c->add('tab_permissions', NULL, 'tab', 0, 1, NULL, 0, true, 'calendarjp', 1);
        $c->add('fs_permissions', NULL, 'fieldset', 0, 1, NULL, 0, true, 'calendarjp', 1);
        $c->add('default_permissions', $_CAJP_DEFAULT['default_permissions'],
                '@select', 0, 1, 12, 150, true, 'calendarjp', 1);

        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'calendarjp', 10);
        $c->add('fs_autotag_permissions', NULL, 'fieldset', 0, 10, NULL, 0, true, 'calendarjp', 10);
        $c->add('autotag_permissions_event', $_CAJP_DEFAULT['autotag_permissions_event'], '@select',
                0, 10, 13, 10, true, 'calendarjp', 10);

        $c->add('tab_events_block', NULL, 'tab', 0, 20, NULL, 0, true, 'calendarjp', 20);
        $c->add('fs_block_settings', NULL, 'fieldset', 0, 10, NULL, 0, true, 'calendarjp', 20);
        $c->add('block_enable', $_CAJP_DEFAULT['block_enable'], 'select',
                0, 10, 0, 10, true, 'calendarjp', 20);
        $c->add('block_isleft', $_CAJP_DEFAULT['block_isleft'], 'select',
                0, 10, 0, 20, true, 'calendarjp', 20);
        $c->add('block_order', $_CAJP_DEFAULT['block_order'], 'text',
                0, 10, 0, 30, true, 'calendarjp', 20);
        $c->add('block_topic_option', $_CAJP_DEFAULT['block_topic_option'],'select',
                0, 10, 15, 40, true, 'calendarjp', 20);
        $c->add('block_topic', $_CAJP_DEFAULT['block_topic'], '%select',
                0, 10, NULL, 50, true, 'calendarjp', 20);

        $c->add('fs_block_permissions', NULL, 'fieldset', 0, 20, NULL, 0, true, 'calendarjp', 20);
        $new_group_id = 0;
        if (isset($_GROUPS['Calendarjp Admin'])) {
            $new_group_id = $_GROUPS['Calendarjp Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Calendarjp Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }
        $c->add('block_group_id', $new_group_id,'select',
                0, 20, NULL, 10, TRUE, 'calendarjp', 20);
        $c->add('block_permissions', $_CAJP_DEFAULT['block_permissions'], '@select',
                0, 20, 14, 20, true, 'calendarjp', 20);
    }

    return true;
}

?>
