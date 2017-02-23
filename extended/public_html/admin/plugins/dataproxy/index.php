<?php

// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/dataproxy/index.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
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

/**
* Only let admin users access this page
*/
if (!SEC_hasRights('dataproxy.admin')) {
    // Someone is trying to illegally access this page
    COM_errorLog( "Someone has tried to illegally access the dataproxy Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1 );
	$content = COM_startBlock(DPXY_str('access_denied')) . DPXY_str('access_denied_msg') . COM_endBlock();
	
	if (is_callable('COM_createHTMLDocument')) {
		$display = COM_createHTMLDocument($content);
	} else {
	    $display = COM_siteHeader() . $content . COM_siteFooter();
	}

	if (is_callable('COM_output')) {
		COM_output($display);
	} else {
		echo $display;
	}
	
    exit;
}
 
/**
* Main 
*/
if (!defined('XHTML')) {
	define('XHTML', '');
}

$T = new Template($_CONF['path'] . 'plugins/dataproxy/templates');
$T->set_file('admin', 'admin.thtml');
$T->set_var('xhtml', XHTML);
$T->set_var('site_url', $_CONF['site_url']);
$T->set_var('site_admin_url', $_CONF['site_admin_url']);
$T->set_var('icon_url', $_CONF['site_admin_url'] . '/plugins/dataproxy/images/dataproxy.gif');
$T->set_var('header', DPXY_str('admin'));
$T->set_var('plugin', 'dataproxy');

// put your code here



$T->parse('output', 'admin');
$content = $T->finish($T->get_var('output'))

if (is_callable('COM_createHTMLDocument')) {
	$display = COM_createHTMLDocument($content);
} else {
    $display = COM_siteHeader() . $content . COM_siteFooter();
}

if (is_callable('COM_output')) {
	COM_output($display);
} else {
	echo $display;
}
