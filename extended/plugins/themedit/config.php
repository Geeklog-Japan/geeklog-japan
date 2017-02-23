<?php
//
// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/themedit/config.php                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2017 - geeklog AT mystral-kk DOT net                   |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

global $_DB_table_prefix, $_TABLES;

/**
* Add to $_TABLES array the tables your plugin uses
*/
$_TABLES['thm_contents'] = $_DB_table_prefix . 'thm_contents';

$_THM_CONF = array();

/**
* Plugin info
*/
$_THM_CONF['pi_version'] = '1.2.2';						// Plugin Version
$_THM_CONF['gl_version'] = '1.6.0';						// GL Version plugin for
$_THM_CONF['pi_url']     = 'https://mystral-kk.net/';	// Plugin Homepage
$_THM_CONF['GROUPS']     = array(
		'Theme Editor Admin' => 'Users in this group can administer the Theme Editor plugin',
);
$_THM_CONF['FEATURES']   = array(
		'themedit.admin' => 'Access to Theme Editor',
);
$_THM_CONF['MAPPINGS']   = array(
		'themedit.admin' => array('Theme Editor Admin'),
);
