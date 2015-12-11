<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------|
// | plugins/custommenu/install_defaults.php                                   |
// +---------------------------------------------------------------------------|
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * CustomMenu Editor default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */

global $_CMED_DEFAULT;

$_CMED_DEFAULT = array();

/** What to show after a data has been saved? Possible choices:
 * 'list'   -> display the admin-list of custommenu
 * 'home'   -> display the site homepage
 * 'admin'  -> display the site admin homepage
 */
$_CMED_DEFAULT['aftersave'] = 'list';

/**
 * Define default permissions for new custommenu created from the Admin panel.
 * Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
 * order). Possible values:
 * - 3 = read + write permissions (perm_owner and perm_group only)
 * - 2 = read-only
 * - 0 = neither read nor write permissions
 * (a value of 1, ie. write-only, does not make sense and is not allowed)
 */
$_CMED_DEFAULT['default_permissions'] = array (3, 2, 2, 2);

/**
 * Menu Render
 * 'standard' -> Geeklog system standard
 * 'pulldown' -> Supports a pulldown menu
 */
$_CMED_DEFAULT['menu_render'] = 'pulldown';

/**
 * Prefix to add to ID
 */
$_CMED_DEFAULT['prefix_id'] = 'cmitem-';

/**
* Initialize CustomMenu Editor plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_CMED_CONF if available (e.g. from
* an old config.php), uses $_CMED_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_custommenu()
{
    global $_CONF, $_CMED_CONF, $_CMED_DEFAULT;

    if (is_array($_CMED_CONF) && (count($_CMED_CONF) > 1)) {
        $_CMED_DEFAULT = array_merge($_CMED_DEFAULT, $_CMED_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('custommenu')) {
        $c->add('sg_main',             NULL,                                  'subgroup', 0, 0, NULL, 0,  true, 'custommenu', 0);
        // ----------------------------------
        $c->add('tab_main',            NULL,                                  'tab',      0, 0, NULL, 0,  true, 'custommenu', 0);
        $c->add('fs_main',             NULL,                                  'fieldset', 0, 0, NULL, 0,  true, 'custommenu', 0);
        $c->add('aftersave',           $_CMED_DEFAULT['aftersave'],           'select',   0, 0, 9,    10, true, 'custommenu', 0);
        $c->add('menu_render',         $_CMED_DEFAULT['menu_render'],         'select',   0, 0, 10,   20, true, 'custommenu', 0);
        $c->add('prefix_id',           $_CMED_DEFAULT['prefix_id'],           'text',     0, 0, 0,    30, true, 'custommenu', 0);
        // ----------------------------------
        $c->add('tab_permissions',     NULL,                                  'tab',      0, 2, NULL, 0,  true, 'custommenu', 1);
        $c->add('fs_permissions',      NULL,                                  'fieldset', 0, 2, NULL, 0,  true, 'custommenu', 1);
        $c->add('default_permissions', $_CMED_DEFAULT['default_permissions'], '@select',  0, 2, 12,   40, true, 'custommenu', 1);
    }

    return true;
}
?>