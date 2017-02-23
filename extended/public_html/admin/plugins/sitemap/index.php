<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/sitemap/index.php                               |
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

require_once '../../../lib-common.php';

// Only let admin users access this page
if (!SEC_hasRights('sitemap.admin')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the sitemap Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
    $content = COM_startBlock(SITEMAP_str('access_denied'))
			 . SITEMAP_str('access_denied_msg')
			 . COM_endBlock();
	
	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
		$display = COM_siteHeader()
				 . $content
				 . COM_siteFooter();
	}
	
	if (is_callable('COM_output')) {
		COM_output($display);
	} else {
		echo $display;
	}
	
    exit;
} elseif (!in_array('dataproxy', $_PLUGINS)) {
    COM_errorLog(SITEMAP_str('dataproxy_unavailable'));
    $content = SITEMAP_str('dataproxy_unavailable');
	
	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
		$display = COM_siteHeader()
				 . $content
				 . COM_siteFooter();
	}
	
	if (is_callable('COM_output')) {
		COM_output($display);
	} else {
		echo $display;
	}
	
    exit;
}

//=====================================
//  Functions
//=====================================

/**
* Creates a checkbox as follows:
*   <input id="sitemap_{$var_name}" name="{$var_name}" [checked="checked">
*	<lable for="sitemap_{$var_name}">{lang_{$var_name}}</label>
*/
function SITEMAP_createCheckBox($var_name) {
	global $_SMAP_CONF, $LANG_SMAP;
	
	$id = 'sitemap_' . $var_name;
	$retval = '<input id="' . $id . '" name="' . $var_name
			. '" type="checkbox" value="' . $var_name . '"';
	
	if ($_SMAP_CONF[$var_name] === true) {
		$retval .= ' checked="checked"';
	}
	
	$retval .= '><label for="' . $id . '">'
			. SITEMAP_str($var_name) . '</label>' . LB;
	
	return $retval;
}

/**
* Creates static pages type dropdown list
*/
function SITEMAP_createSPOption($type) {
	global $_SMAP_CONF, $LANG_SMAP;
	
	$selection = ($type == $_SMAP_CONF['sp_type'])
	 		   ? ' selected="selected"' : '';
	$retval = '<option value="' . $type . '"' . $selection . '>'
			. SITEMAP_str('sp_type' . (string) $type) . '</option>' . LB;
	return $retval;
}

/**
* Returns <select> list to be used as the frequency selector in Google sitemap
*/
function SITEMAP_getFreqOptions($driver) {
	global $_SMAP_CONF, $LANG_SMAP, $freqs;
	
	$retval = '<select name="freq_' . $driver . '">' . LB;
	
	foreach ($freqs as $freq) {
		$retval .= '  <option value="' . $freq . '"';
		
		if ($freq == $_SMAP_CONF['freq_' . $driver]) {
			$retval .= ' selected="selected"';
		}
		
		$retval .= '>' . SITEMAP_str($freq) . '</option>' . LB;
	}
	
	$retval .= '</select>' . LB;
	
	return $retval;
}

/**
* Changes the display order of a given driver
*/
function SITEMAP_changeOrder($driver, $op) {
	global $_SMAP_CONF;
	
	$all_supported_drivers = Dataproxy::getAllSupportedDriverNames();
	
	if ((($op === 'up') || ($op === 'down')) &&
		in_array($driver, $all_supported_drivers)) {
		$me = (int) $_SMAP_CONF['order_' . $driver];
		
		if ($op === 'up') {
			$you = $me - 1;
			
			if ($you <= 0) {
				$you = 1;
			}
		} else {
			$you = $me + 1;
			
			if ($you > count($all_supported_drivers)) {
				$you = count($all_supported_drivers);
			}
		}
		
		if ($me !== $you) {
			foreach ($all_supported_drivers as $supported_driver) {
				if ((int) $_SMAP_CONF['order_' . $supported_driver] === $you) {
					$_SMAP_CONF['order_' . $supported_driver] = $me;
					$_SMAP_CONF['order_' . $driver]           = $you;
					SITEMAP_saveConfig();
					break;
				}
			}
		}
	}
}

//=====================================
//  Main
//=====================================

if (!defined('XHTML')) {
	define('XHTML', '');
}

define('THIS_SCRIPT', $_CONF['site_admin_url'] . '/plugins/sitemap/index.php');

// Loads Dataproxy plugin
if (isset($_USER['uid']) && ($_USER['uid'] >= 1)) {
	$uid = $_USER['uid'];
} else {
	$uid = 1;
}

// $dataproxy is a global object in this script and functions.inc
$dataproxy = Dataproxy::getInstance($uid);
$freqs = array(
	'always', 'hourly', 'daily', 'weekly',	'monthly', 'yearly', 'never'
);
// Retrieves vars
$_GET  = SITEMAP_stripslashes($_GET);
$_POST = SITEMAP_stripslashes($_POST);

// Changes display order
if (isset($_GET['op']) && isset($_GET['driver'])) {
	$op     = COM_applyFilter($_GET['op']);
	$driver = COM_applyFilter($_GET['driver']);
	SITEMAP_changeOrder($driver, $op);
}

// Saves vars
if (isset($_POST['submit']) && ($_POST['submit'] === $LANG_SMAP['submit'])) {
	if (!is_array($_POST['drivers'])) {
		$_POST['drivers'] = (array) $_POST['drivers'];
	}
	
	$all_drivers = Dataproxy::getAllSupportedDriverNames();
	
	foreach ($all_drivers as $driver) {
		$_SMAP_CONF['sitemap_' . $driver] = in_array($driver, $_POST['sitemap_drivers']);
		$_SMAP_CONF['gsmap_' . $driver]   = in_array($driver, $_POST['gsmap_drivers']);
		
		// Frequency
		$freq = COM_applyFilter($_POST['freq_' . $driver]);
		
		if (in_array($freq, $freqs)) {
			$_SMAP_CONF['freq_' . $driver] = $freq;
		}
		
		// Priority
		$priority = trim($_POST['priority_' . $driver]);
		$priority = (float) preg_replace("/[^0-9.-]/", '', $priority);
		
		if (($priority < 0.0) || ($priority > 1.0)) {
			$priority = 0.5;
		}
		
		$_SMAP_CONF['priority_' . $driver] = $priority;
	}
	
	$_SMAP_CONF['anon_access']         = isset($_POST['anon_access']);
	$_SMAP_CONF['date_format']         = $_POST['date_format'];
	$_SMAP_CONF['google_sitemap_name'] = $_POST['google_sitemap_name'];
	$timezone = preg_replace("/[^0-9.:+-]/", '', $_POST['time_zone']);
	$_SMAP_CONF['time_zone'] = $timezone;
	
	// Since version 1.1.4
	$sp_type = (int) $_POST['sp_type'];
	
	if (($sp_type < 0) || ($sp_type > 2)) {
		$sp_type = 2;
	}
	
	$_SMAP_CONF['sp_type']   = $sp_type;
	$_SMAP_CONF['sp_except'] = preg_replace("/\s{2,}/", ' ', $_POST['sp_except']);
	
	// Saves config data and re-create the sitemap if necessary
	SITEMAP_saveConfig();
	
	if (isset($_POST['update_now'])) {
		SITEMAP_createGoogleSitemap();
	}
}

// Displays
$T = new Template($_CONF['path'] . 'plugins/sitemap/templates');
$T->set_file('admin', 'admin.thtml');
$T->set_var('xhtml', XHTML);
$T->set_var('this_script', $_CONF['site_admin_url'] . '/plugins/sitemap/index.php');
$T->set_var('icon_url', $_CONF['site_url'] . '/sitemap/images/sitemap.gif');
$T->set_var('lang_admin', SITEMAP_str('admin'));
$T->set_var('lang_sitemap_items', SITEMAP_str('sitemap_items'));
$T->set_var('lang_order', SITEMAP_str('order'));
$T->set_var('lang_sitemap_setting', SITEMAP_str('sitemap_setting'));
$T->set_var('lang_sitemap_setting_misc', SITEMAP_str('sitemap_setting_misc'));
$T->set_var('lang_gsmap_setting', SITEMAP_str('gsmap_setting'));
$T->set_var('lang_date_format', SITEMAP_str('date_format'));
$T->set_var('lang_desc_date_format', SITEMAP_str('desc_date_format', true));
$T->set_var('lang_google_sitemap_name', SITEMAP_str('google_sitemap_name'));
$T->set_var('lang_file_creation', SITEMAP_str('file_creation'));
$T->set_var('lang_time_zone', SITEMAP_str('time_zone'));
$T->set_var('lang_desc_filename', SITEMAP_str('desc_filename', true));
$T->set_var('lang_desc_time_zone', SITEMAP_str('desc_time_zone', true));
$T->set_var('lang_gsmap_items', SITEMAP_str('gsmap_items'));
$T->set_var('lang_item_name', SITEMAP_str('item_name'));
$T->set_var('lang_freq', SITEMAP_str('freq'));
$T->set_var('lang_priority', SITEMAP_str('priority'));
$T->set_var('lang_desc_freq', SITEMAP_str('desc_freq', true));
$T->set_var('lang_desc_priority', SITEMAP_str('desc_priority', true));
$T->set_var('lang_update_now', SITEMAP_str('update_now'));
$T->set_var('lang_last_updated', SITEMAP_str('last_updated'));
$T->set_var('lang_submit', SITEMAP_str('submit'));

// Since version 1.1.4
$T->set_var('lang_common_setting', SITEMAP_str('common_setting'));
$T->set_var('lang_sp_setting', SITEMAP_str('sp_setting'));
$T->set_var('lang_sp_type', SITEMAP_str('sp_type'));
$sp_options = SITEMAP_createSPOption(0)
			. SITEMAP_createSPOption(1)
			. SITEMAP_createSPOption(2);
$T->set_var('sp_options', $sp_options);
$T->set_var('lang_sp_except', SITEMAP_str('sp_except'));
$T->set_var('sp_except', $_SMAP_CONF['sp_except']);

// Sets config vars for sitemap
$disp_orders = array();

foreach (Dataproxy::getAllSupportedDriverNames() as $supported_driver) {
	$order = $_SMAP_CONF['order_' . $supported_driver];
	$disp_orders[$order] = $supported_driver;
}

ksort($disp_orders);
$num_drivers = count($disp_orders);
$drivers = '';

for ($i = 1; $i <= $num_drivers; $i ++) {
	$supported_driver = $disp_orders[$i];
	$id   = 'sitemap_admin_' . $supported_driver;
	$link = '<a href="' . THIS_SCRIPT . '?driver=' . $supported_driver
		  . '&amp;op=up">' . SITEMAP_str('up') . '</a>&nbsp;'
		  . '<a href="' . THIS_SCRIPT . '?driver=' . $supported_driver
		  . '&amp;op=down">' . SITEMAP_str('down') . '</a>';
	
	$drivers .= '<tr><th style="text-align: left;"><input id="' . $id
			 .  '" name="sitemap_drivers[]" ' . 'type="checkbox" value="'
			 .  SITEMAP_escape($supported_driver) . '"';
	
	if ($_SMAP_CONF['sitemap_' . $supported_driver] === true) {
		$drivers .= ' checked="checked"';
	}
	
	$drivers .= XHTML . '><label for="' . $id . '">'
			 .  SITEMAP_str($supported_driver)
			 . '</label></th><td>' . $link . '</td></tr>' . LB;
}

$T->set_var('sitemap_drivers', $drivers);

// Sets config vars for Google sitemap
$gsmap_drivers = '';

foreach (Dataproxy::getAllSupportedDriverNames() as $supported_driver) {
	$id = 'gsmap_admin_' . $supported_driver;
	$gsmap_drivers .= '<tr><th style="text-align: left;"><input id="' . $id
				   .  '" name="gsmap_drivers[]" type="checkbox" value="'
				   .  SITEMAP_escape($supported_driver) . '"';
	
	if ($_SMAP_CONF['gsmap_' . $supported_driver] === true) {
		$gsmap_drivers .= ' checked="checked"';
	}
	
	$gsmap_drivers .= '><label for="' . $id . '">'
				   .  SITEMAP_str($supported_driver) . '</label></th>';
	
	// Frequency
	$gsmap_drivers .= '<td>' . SITEMAP_getFreqOptions($supported_driver)
				   .  '</td>' . LB;
	
	// Priority
	$gsmap_drivers .= '<td><input name="priority_' . $supported_driver
				   .  '" type="text" value="' . $_SMAP_CONF['priority_'
				   .  $supported_driver] . '" style="text-align: right;"></td>'
				   .  LB
				   .  '</tr>' . LB;
}

$T->set_var('gsmap_drivers', $gsmap_drivers);
$sitemap_fields = SITEMAP_createCheckBox('anon_access')      . '<br' . XHTML . '>' . LB;
$T->set_var('sitemap_fields', $sitemap_fields);
$T->set_var('time_zone', $_SMAP_CONF['time_zone']);
$T->set_var('date_format', $_SMAP_CONF['date_format']);
$T->set_var('google_sitemap_name', $_SMAP_CONF['google_sitemap_name']);

// Shows the last updated time of the Google sitemap
$filename = $_SMAP_CONF['google_sitemap_name'];

if (($pos = strpos($filename, ';')) !== false) {
	$filename = substr($filename, 0, $pos);
}

clearstatcache();
$last_updated = @filemtime($_CONF['path_html'] . $filename);

if ($last_updated === false) {
	$last_updated = SITEMAP_str('unknown');
} else {
	$last_updated = date('Y-m-d H:i:s', $last_updated);
}

$T->set_var('last_updated', SITEMAP_escape($last_updated));
$T->parse('output', 'admin');
$content = $T->finish($T->get_var('output'));

if (is_callable('COM_createHTMLDocument')) {
	$display = COM_createHTMLDocument($content);
} else {
	$display = COM_siteHeader()
			 . $content
			 . COM_siteFooter();
}

if (is_callable('COM_output')) {
	COM_output($display);
} else {
	echo $display;
}
