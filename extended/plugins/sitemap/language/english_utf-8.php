<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | private/plugins/sitemap/language/english_utf-8.php                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-k DOT net         |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
	die('This file cannot be used on its own.');
}

$LANG_SMAP = array (
    'plugin'            => 'sitemap Plugin',
	'access_denied'     => 'Access Denied',
	'access_denied_msg' => 'Only Root Users have Access to this Page.  Your user name and IP have been recorded.',
	'admin'		        => 'sitemap Plugin Admin',
	'install_header'	=> 'Install/Uninstall the sitemap Plugin',
	'install_success'	=> 'Installation Successful',
	'install_fail'	    => 'Installation Failed -- See your error log to find out why.',
	'uninstall_success'	=> 'Uninstallation Successful',
	'uninstall_fail'    => 'Installation Failed -- See your error log to find out why.',
	'uninstall_msg'		=> 'sitemap plugin was successfully uninstalled.',
	'menu_label'        => 'Sitemap',
	'sitemap'           => 'Sitemap',
	'submit'            => 'submit',
	'all'               => 'All',
	'article'           => 'Stories',
	'comments'          => 'Comments',
	'trackback'         => 'Trackbacks',
	'staticpages'       => 'Staticpages',
	'calendar'          => 'Calendar',
	'links'             => 'Links',
	'polls'             => 'Polls',
	'dokuwiki'          => 'DokuWiki',
	'forum'             => 'Forum',
	'filemgmt'          => 'File Management',
	'faqman'            => 'FAQ',
	'mediagallery'      => 'Media Gallery',
	'calendarjp'        => 'CalendarJP',
	'downloads'         => 'Downloads',
	'sitemap_setting'   => 'Sitemap configuration',
	'sitemap_setting_misc' => 'Display settings',
	'order'             => 'Display Order',
	'up'                => 'Up',
	'down'              => 'Down',
	'anon_access'       => 'Allows anonymous users to access sitemap',
	'sitemap_in_xhtml'  => 'Displays sitemap in XHTML',
	'date_format'       => 'Date format',
	'desc_date_format'  => 'At <strong>Date format</strong>, enter the format string used in the format parameter of PHP\' <a href="http://www.php.net/manual/en/function.date.php">date() function</a>.',
	'sitemap_items'     => 'Items to be included in sitemap',
	'gsmap_setting'     => 'Google sitemap configuration',
	'file_creation'     => 'File creation settings',
	'google_sitemap_name' => 'File name: ',
	'time_zone'         => 'Time zone: ',
	'update_now'        => 'Update now!',
	'last_updated'      => 'Last updated: ',
	'unknown'           => 'unknown',
	'desc_filename'     => 'At <strong>File Name</strong>, enter the file name(s) of Google Sitemap.  You can specifiy more than one file name separated by a semicolon(;).  For Mobile Sitemap, enter "mobile.xml".',
	'desc_time_zone'    => 'At <strong>Time zone</strong>, enter the time zone of the Web server you installed Geeklog on in <a href="http://en.wikipedia.org/wiki/Iso8601">ISO 8601</a> format ((+|-)hh:mm).  e.g. +09:00(Tokyo), +01:00(Paris), +01:00(Berlin), +00:00(London), -05:00(New York), -08:00(Los Angeles)',
	'gsmap_items'       => 'Items to be included in Google sitemap',
	'item_name'         => 'Item Name',
	'freq'              => 'Frequency',
	'always'            => 'always',
	'hourly'            => 'hourly',
	'daily'             => 'daily',
	'weekly'            => 'weekly',
	'monthly'           => 'monthly',
	'yearly'            => 'yearly',
	'never'             => 'never',
	'priority'          => 'Priority',
	'desc_freq'         => '<strong>Frequency</strong> tells Google web crawlers how often the item is likely to be updated.  Even if you choose "never", Google crawlers will sometimes check if there is any update in the item.',
	'desc_priority'     => 'At <strong>Priority</strong>, enter the value between <strong>0.0</strong> (lowest) and <strong>1.0</strong> (highest).  The default value is <strong>0.5</strong>.',
	
	// Since version 1.1.4
	'common_setting'    => 'Common Settings',
	'sp_setting'        => 'Static Pages',
	'sp_type'           => 'Types of static pages to be listed on the sitemap',
	'sp_type0'          => 'All',
	'sp_type1'          => 'Only pages that appear on the center block',
	'sp_type2'          => 'Only pages that do NOT appear on the center block',
	'sp_except'         => 'IDs of pages that should not be listed on the sitemap (space separated, regular expression supported)',
	
	// Since version 1.2.2
	'dataproxy_unavailable'	=> 'Error!  Dataproxy plugin is not installed or is disabled.',

	// Since version 2.0.0
	'sitemap_unavailable'	=> 'Error!  Sitemap plugin is not installed or is disabled.',
);
