<?php

// +---------------------------------------------------------------------------+
// | Dbman Plugin for Geeklog - The Ultimate Weblog                            |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/config.php                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2016 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], 'config.php') !== false) {
    die('This file cannot be used on its own.');
}

/**
* Dbman plugin configuration file
*/
global $_DB_table_prefix, $_CONF;

// the Dbman plugin's config array
$_DBMAN_CONF = array();

$_DBMAN_CONF['pi_version'] = '0.8.0';					// Plugin Version
$_DBMAN_CONF['gl_version'] = '1.6.0';					// GL Version plugin for
$_DBMAN_CONF['pi_url']     = 'http://mystral-kk.net/';	// Plugin Homepage
$_DBMAN_CONF['GROUPS']     = array(
		'Dbman Admin' => 'Users in this group can administer the Dbman plugin',
);
$_DBMAN_CONF['FEATURES']   = array(
		'dbman.edit' => 'Access to Dbman editor',
);
$_DBMAN_CONF['MAPPINGS']   = array(
		'dbman.edit' => array('Dbman Admin'),
);
