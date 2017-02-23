<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/sql/mysql_install.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2012-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
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
    die('This file cannot be used on its own!');
}

$_SQL = array();

$_SQL[] = "
CREATE TABLE {$_TABLES['smap_config']} (
  name VARCHAR(30) NOT NULL default '',
  value VARCHAR(255),
  PRIMARY KEY name(name)
)
";

// Default data
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('anon_access', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('date_format', '[[Y-m-d] ]')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_in_xhtml', 'false')";

// Whether to include data source into sitemap
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_article', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_staticpages', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_calendar', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_links', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_polls', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_forum', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_filemgmt', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_faqman', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_dokuwiki', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_comments', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_trackback', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_mediagallery', 'true')";

// for Google sitemap
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('google_sitemap_name', 'sitemap.xml')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('time_zone', '+09:00')";

// Whether to include data source into Google sitemap
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_article', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_staticpages', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_calendar', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_links', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_polls', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_forum', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_filemgmt', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_faqman', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_dokuwiki', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_comments', 'false')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_trackback', 'false')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_mediagallery', 'true')";

// Updating frequency
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_article', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_staticpages', 'weekly')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_calendar', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_links', 'weekly')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_polls', 'weekly')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_forum', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_filemgmt', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_faqman', 'weekly')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_dokuwiki', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_comments', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_trackback', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_mediagallery', 'daily')";

// Priority
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_article', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_staticpages', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_calendar', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_links', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_polls', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_forum', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_filemgmt', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_faqman', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_dokuwiki', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_comments', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_trackback', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_mediagallery', '0.5')";

// Upgrades from v1.0 to v1.0.1
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_article', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_comments', 2)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_trackback', 3)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_staticpages', 4)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_calendar', 5)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_links', 6)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_polls', 7)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_dokuwiki', 8)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_forum', 9)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_filemgmt', 10)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_faqman', 11)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_mediagallery', 12)";

// Upgrades from v1.0.1 to v1.1.4
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES ('sp_type', 2)";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES ('sp_except', 'formmail')";

// Upgrades from v1.1.4 to v1.1.5
$_SQL[] = "ALTER TABLE {$_TABLES['smap_config']} CHANGE value value VARCHAR(255) NULL DEFAULT NULL";

// Upgrades from v1.1.5 to v1.1.6
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_calendarjp', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_calendarjp', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_calendarjp', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_calendarjp', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_calendarjp', 13)";

// Upgrades from v1.1.9 to v1.2.0
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('sitemap_downloads', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('gsmap_downloads', 'true')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('freq_downloads', 'daily')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('priority_downloads', '0.5')";
$_SQL[] = "INSERT INTO {$_TABLES['smap_config']} VALUES('order_downloads', 14)";
