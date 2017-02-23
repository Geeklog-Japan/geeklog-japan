<?php
//
// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/config.php                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-k DOT net         |
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
    die('This file cannot be used on its own.');
}

global $_DB_table_prefix, $_TABLES;

// Sets plugin table prefix the same as Geeklog's
$_SMAP_table_prefix = $_DB_table_prefix;

// Adds to $_TABLES array the tables your plugin uses
$_TABLES['smap_config'] = $_SMAP_table_prefix . 'smap_config';

$_SMAP_CONF = array();

// Plugin info
$_SMAP_CONF['pi_version'] = '2.1.0';					// Plugin Version
$_SMAP_CONF['gl_version'] = '1.6.0';					// GL Version plugin for
$_SMAP_CONF['pi_url']     = 'https://mystral-kk.net/';	// Plugin Homepage
$_SMAP_CONF['GROUPS']     = array(
		'Sitemap Admin' => 'Users in this group can administer the Sitemap plugin',
);
$_SMAP_CONF['FEATURES']   = array(
		'sitemap.admin' => 'Access to Sitemap editor',
);
$_SMAP_CONF['MAPPINGS']   = array(
		'sitemap.admin' => array('Sitemap Admin'),
);
