<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendarjp Plugin for Geeklog                                             |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

// General Calendarjp Settings
$_CONF_VALIDATE['calendarjp']['calendarloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['addeventloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['hidecalendarmenu'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['personalcalendars'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['eventsubmission'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['showupcomingevents'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['upcomingeventsrange'] = array('rule' => 'numeric');
$_CONF_VALIDATE['calendarjp']['hour_mode'] = array(
    'rule' => array('inList', array('12', '24'), true)
);
$_CONF_VALIDATE['calendarjp']['event_types'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['notification'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['delete_event'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['aftersave'] = array(
    'rule' => array('inList', array('item', 'list', 'plugin', 'home', 'admin'), true)
);
$_CONF_VALIDATE['calendarjp']['advanced_editor'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['wikitext_editor'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendarjp']['postmode'] = array(
    'rule' => array('inList', array('plaintext', 'html'), true)
);

// Default Permissions
$_CONF_VALIDATE['calendarjp']['default_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['calendarjp']['default_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['calendarjp']['default_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['calendarjp']['default_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

// Autotag Usage Permissions
$_CONF_VALIDATE['calendarjp']['autotag_permissions_event[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['calendarjp']['autotag_permissions_event[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['calendarjp']['autotag_permissions_event[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['calendarjp']['autotag_permissions_event[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

?>
