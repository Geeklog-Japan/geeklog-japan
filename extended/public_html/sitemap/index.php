<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | public_html/sitemap/index.php                                             |
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

require_once '../lib-common.php';

if (!defined('XHTML')) {
	define('XHTML', '');
}

// Checks if user has right to access this page
$uid = 1;

if (isset($_USER['uid']) && is_numeric($_USER['uid'])) {
	$uid = (int) $_USER['uid'];
} else {
	$_USER['uid']   = 1;
	$_USER['theme'] = $_CONF['theme'];
}

if (($_SMAP_CONF['anon_access'] === false) && ($uid === 1)) {
    // Anonymous user is not allowed to access this page
	echo COM_refresh($_CONF['site_url']);
	exit;
} else if (!in_array('dataproxy', $_PLUGINS)) {
    COM_errorLog(SITEMAP_str('dataproxy_unavailable'));
	echo COM_refresh($_CONF['site_url']);
	exit;
} else if (!in_array('sitemap', $_PLUGINS)) {
    COM_errorLog(SITEMAP_str('sitemap_unavailable'));
	echo COM_refresh($_CONF['site_url']);
	exit;
}

//===========================
//  Functions
//===========================

/**
* Returns a selector to choose data source
*/
function SITEMAP_getSelectForm($selected = 'all') {
	global $_CONF, $_SMAP_CONF, $LANG_SMAP;
	
	$this_script = $_CONF['site_url'] . '/sitemap/index.php';
	
	$retval = '<form method="post" action="' . $this_script .  '">' . LB
			. '  <select name="type" onchange="this.form.submit()">' . LB
			. '    <option value="all"';
	
	if ($selected === 'all') {
		$retval .= ' selected="selected"';
	}
	
	$retval .= '>' . SITEMAP_str('all') . '</option>' . LB;
	$disp_orders = array();
	
	foreach (Dataproxy::getAllDriverNames() as $driver) {
		$order = $_SMAP_CONF['order_' . $driver];
		$disp_orders[$order] = $driver;
	}
	
	if (count($disp_orders) > 0) {
		foreach ($disp_orders as $driver_name) {
			if (empty($driver_name) || ($_SMAP_CONF['sitemap_' . $driver_name] === false)) {
				continue;
			}
			
			$retval .= '    <option value="' . $driver_name . '"';
			
			if ($selected === $driver_name) {
				$retval .= ' selected="selected"';
			}
			
			$retval .= '>' . SITEMAP_str($driver_name) . '</option>' . LB;
		}
	}
	
	$retval .= '  </select>' . LB
			.  '  <noscript>' . LB
			.  '    <input name="submit" type="submit" value="'
			.  SITEMAP_str('submit') . '"' . XHTML . '>' . LB
			.  '  </noscript>' . LB
			.  '</form>' . LB;
	
	return $retval;
}

/**
* Builds items belonging to a category
*
* @param   object  $T       reference to Template object
* @param   object  $driver  reference to driver object
* @param   mixed   $pid     id of parent category
* @return  array of (num_items, html)
*
* @destroy        $T->var( 'items', 'item', 'item_list' )
*/
function SITEMAP_buildItems($driver, $pid) {
	global $_SMAP_CONF, $T;
	
	$html = '';
	$T->clear_var('items');
	$sp_excepts = explode(' ', $_SMAP_CONF['sp_except']);
	$items = $driver->getItems($pid);
	$num_items = count($items);
	
	if ($num_items > 0) {
		foreach ($items as $item) {
			list(, $class_name) = explode('_', get_class($driver), 2);
			
			if ($class_name === 'Staticpages') {
				if (SITEMAP_isExcepted($item['id'], $sp_excepts)) {
					$num_items --;
					continue;
				}
				
				$temp = $driver->getItemById($item['id']);
				$raw  = $temp['raw_data'];
				
				if ((($_SMAP_CONF['sp_type'] == 1) && ($raw['sp_centerblock'] != 1)) ||
					(($_SMAP_CONF['sp_type'] == 2) && ($raw['sp_centerblock'] == 1))) {
					$num_items--;
					continue;
				}
			}
			
			$link = '<a href="' . $item['uri'] . '">'
				  . $driver->escape($item['title']) . '</a>';
			$T->set_var('item', $link);
			
			if (($item['date'] !== false) && ($item['date'] !== '')) {
				$date = date($_SMAP_CONF['date_format'], (int) $item['date']);
				$T->set_var('date', $date);
			}
			
			$T->parse('items', 't_item', true);
		}
		
		$T->parse('item_list', 't_item_list');
		$html = $T->finish($T->get_var('item_list'));
	}
	
	return array($num_items, $html);
}

/**
* Builds a category and items belonging to it
*
* @param   object  $T       reference to Template object
* @param   object  $driver  reference to driver object
* @param   array   $cat     array of category data
* @return  string           HTML
*
* @destroy        $T->var( 'child_categories', 'category', 'num_items' )
*/
function SITEMAP_buildCategory($driver, $cat) {
	global $T;
	
	$num_total_items = 0;
	$temp = $T->get_var('child_categories');	// Push $T->var('child_categories')

	// Builds {child_categories}
	$child_categories = $driver->getChildCategories($cat['id']);

	if (count($child_categories) > 0) {
		$child_cats = '';
		
		foreach ($child_categories as $child_category) {
			list($num_child_category, $child_cat) = SITEMAP_buildCategory($driver, $child_category);
			$num_total_items += $num_child_category;
			$child_cats      .= $child_cat;
		}
		
		$T->set_var('categories', $child_cats);
		$T->parse('temp', 't_category_list');
		$child_cats = $T->get_var('temp');
		$T->set_var(
			'child_categories',
			'<br' . XHTML . '>' . $child_cats . '<br' . XHTML . '>'
		);
	}
	
	// Builds {items}
	list($num_items, $items) = SITEMAP_buildItems($driver, $cat['id']);
	$num_total_items += $num_items;
	$T->set_var('num_items', $num_items);
	
	if (!empty($items)) {
		$T->set_var(
			'items',
			'<br' . XHTML . '>' . $items . '<br' . XHTML . '>'
		);
	}
	
	// Builds {category}
	if ($cat['uri'] !== false) {
		$category_link = '<a href="' . $cat['uri'] . '">'
					   . $driver->escape($cat['title']) . '</a>';
	} else {
		$category_link = $driver->escape($cat['title']);
	}
	
	$T->set_var('category', $category_link);
	$T->parse('category', 't_category');
	$retval = $T->finish($T->get_var('category'));
	$T->set_var('child_categories', $temp);		// Pop $T->var('child_categories')
	
	return array($num_total_items, $retval);
}

//=====================================
//  Main 
//=====================================

// Retrieves vars
$_GET  = SITEMAP_stripslashes($_GET);
$_POST = SITEMAP_stripslashes($_POST);
$selected = 'all';

if (isset($_POST['type'])) {
	$selected = COM_applyFilter($_POST['type']);
}

// Decides templates to be used
$theme = $_CONF['theme'];

if (isset($_USER['theme']) && in_array($_USER['theme'], COM_getThemes())) {
	$theme = $_USER['theme'];
}

$template = $_CONF['path_themes'] . $theme . '/sitemap';
clearstatcache();

if (!is_file($template . '/index.thtml')) {
	$template = $_CONF['path'] . 'plugins/sitemap/templates';
}

$T = new Template($template);	// $T is a global object in this script
$T->set_file(
	array(
		't_index'         => 'index.thtml',
		't_data_source'   => 'data_source.thtml',
		't_category_list' => 'category_list.thtml',
		't_category'      => 'category.thtml',
		't_item_list'     => 'item_list.thtml',
		't_item'          => 'item.thtml',
	)
);
$T->set_var('xhtml', XHTML);

// Collects data sources

// $dataproxy is a global object in this script and functions.inc
$dataproxy = Dataproxy::getInstance($uid);
$disp_orders = array();

foreach (Dataproxy::getAllDriverNames() as $driver) {
	$order = $_SMAP_CONF['order_' . $driver];
	$disp_orders[$order] = $driver;
}

ksort($disp_orders);

foreach ($disp_orders as $disp_order => $driver_name) {
	if (($_SMAP_CONF['sitemap_' . $driver_name] === false) ||
		(($selected !== 'all') && ($selected !== $driver_name))) {
		continue;
	}
	
	$num_items = 0;
	$driver = $dataproxy->$driver_name;
	$entry  = $driver->getEntryPoint();
	
	if ($entry === false) {
		$entry = SITEMAP_str($driver_name);
	} else {
		$entry = '<a href="' . $entry . '">' . SITEMAP_str($driver_name)
			   . '</a>';
	}
	
	$T->set_var('lang_data_source', $entry);
	$categories = $driver->getChildCategories(false);
	
	if (count($categories) === 0) {
		list($num_items, $items) = SITEMAP_buildItems($driver, false);
		$T->set_var('category_list', $items);
	} else {
		$cats = '';
		
		foreach ($categories as $category) {
			list($num_cat, $cat) = SITEMAP_buildCategory($driver, $category);
			$cats .= $cat;
			$num_items += $num_cat;
		}
		
		$T->set_var('categories', $cats);
		$T->parse('category_list', 't_category_list');
	}
	
	$T->set_var('num_items', $num_items);
	$T->parse('data_sources', 't_data_source', true);
}

$T->set_var('lang_sitemap', SITEMAP_str('sitemap'));
$T->set_var('selector', SITEMAP_getSelectForm($selected));
$T->parse('output', 't_index');
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
