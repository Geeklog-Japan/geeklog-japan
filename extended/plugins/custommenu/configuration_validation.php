<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/configuration_validation.php                           |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

// General CustomMenu Settings
$_CONF_VALIDATE['custommenu']['aftersave']   = array(
    'rule' => array('inList', array('list', 'home', 'admin'), true)
);
$_CONF_VALIDATE['custommenu']['menu_render'] = array(
    'rule' => array('inList', array('standard', 'pulldown'), true)
);
$_CONF_VALIDATE['custommenu']['prefix_id']   = array('rule' => 'string');

// CustomMenu Default Permissions
$_CONF_VALIDATE['custommenu']['default_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['custommenu']['default_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['custommenu']['default_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['custommenu']['default_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
?>