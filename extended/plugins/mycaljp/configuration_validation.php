<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | plugins/mycaljp/configuration_validation.php                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// | Geeklog Author:        Tony Bibbs - tony AT tonybibbs DOT com             |
// | mycal Block Author:    Blaine Lang - geeklog AT langfamily DOT ca         |
// | Mycaljp Plugin Author: dengen - taharaxp AT gmail DOT com                 |
// | Original PHP Calendar by Scott Richardson - srichardson@scanonline.com    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

$_CONF_VALIDATE['mycaljp']['headertitleyear']    = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['headertitlemonth']   = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['titleorder']         = array('rule' => 'boolean');
$_CONF_VALIDATE['mycaljp']['sunday']             = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['monday']             = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['tuesday']            = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['wednesday']          = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['thursday']           = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['friday']             = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['saturday']           = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['showholiday']        = array('rule' => 'boolean');
$_CONF_VALIDATE['mycaljp']['checkjpholiday']     = array('rule' => 'boolean');
$_CONF_VALIDATE['mycaljp']['enablesrblocks']     = array('rule' => 'boolean');
$_CONF_VALIDATE['mycaljp']['showstoriesintro']   = array('rule' => 'boolean');
$_CONF_VALIDATE['mycaljp']['use_theme']          = array('rule' => 'boolean');
$_CONF_VALIDATE['mycaljp']['template']           = array('rule' => 'string');
$_CONF_VALIDATE['mycaljp']['date_format']        = array('rule' => 'string');
//$_CONF_VALIDATE['mycaljp']['supported_contents'] = ?;
//$_CONF_VALIDATE['mycaljp']['enabled_contents']   = ?;
$_CONF_VALIDATE['mycaljp']['sp_type']            = array(
    'rule' => array('inList', array(0, 1, 2), true)
);
$_CONF_VALIDATE['mycaljp']['sp_except']          = array('rule' => 'string');

?>
