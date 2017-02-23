<?php

// +---------------------------------------------------------------------------+
// | Japanize Plugin for Geeklog - The Ultimate Weblog                         |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/japanize/install_defaults.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tsuchi           - tsuchi AT geeklog DOT jp                      |
// |          mystral-kk       - geeklog AT mystral-kk DOT net                 |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

global $_JAPANIZE_DEFAULT;

$_JAPANIZE_DEFAULT = array();

/**
* Initialize Links plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_LI_CONF if available (e.g. from
* an old config.php), uses $_LI_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*/
function plugin_initconfig_japanize() {
    global $_JAPANIZE_CONF, $_JAPANIZE_DEFAULT;

    return true;
}
