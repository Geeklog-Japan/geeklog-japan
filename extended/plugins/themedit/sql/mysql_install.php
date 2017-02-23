<?php

// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/sql/mysql_install.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
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
    die('This file can not be used on its own!');
}

$_SQL[] = "
CREATE TABLE {$_TABLES['thm_contents']} (
	thm_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	thm_name VARCHAR(20) NOT NULL DEFAULT '',
	thm_filename VARCHAR(100) NOT NULL DEFAULT '',
	thm_init_contents LONGTEXT,
	thm_vars TEXT,
	PRIMARY KEY thm_id(thm_id)
) ENGINE=MyISAM
";
