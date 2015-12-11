<?php

// +---------------------------------------------------------------------------+
// | nmoxtopicown Geeklog Plugin 1.0                                           |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2012 by nmox                                           |
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
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), strtolower(basename(__FILE__))) !== FALSE) {
	die('This file cannot be used on its own!');
}

$_NMOXTOPICOWN = array();

$_NMOXTOPICOWN['pi_version'] = '1.0.12';
$_NMOXTOPICOWN['gl_version'] = '1.4.1';
$_NMOXTOPICOWN['pi_url']     = 'http://nmox.com/';
$_NMOXTOPICOWN['GROUPS']     = array(
		'nmoxtopicown Admin' => 'Users in this group can administer the nmoxtopicown plugin',
);
$_NMOXTOPICOWN['FEATURES']   = array(
		'nmoxtopicown.edit' => 'Access to nmoxtopicown editor',
);
$_NMOXTOPICOWN['MAPPINGS']   = array(
		'nmoxtopicown.edit' => array('nmoxtopicown Admin'),
);
