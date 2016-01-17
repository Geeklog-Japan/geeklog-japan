<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/config.php                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2016 mystral-kk - geeklog AT mystral-kk DOT net        |
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

if (stripos($_SERVER['PHP_SELF'], 'config.php') !== FALSE) {
    die('This file cannot be used on its own.');
}

global $_DB_table_prefix, $_TABLES, $_DPXY_CONF;

// Sets plugin table prefix the same as Geeklog's
$_DPXY_table_prefix = $_DB_table_prefix;

// Adds to $_TABLES array the tables your plugin uses
$_TABLES['dpxy_notify'] = $_DPXY_table_prefix . 'dpxy_notify';

$_DPXY_CONF = array();

// Plugin info
$_DPXY_CONF['pi_version'] = '2.0.1';					// Plugin Version
$_DPXY_CONF['gl_version'] = '1.6.0';					// GL Version plugin for
$_DPXY_CONF['pi_url']     = 'http://mystral-kk.net/';	// Plugin Homepage
