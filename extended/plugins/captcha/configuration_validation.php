<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Captcha 3.5                                                               |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | List of validation rules for the captcha plugin configurations            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013 by the following authors:                              |
// |                                                                           |
// | Authors: Ben         - ben AT geeklog DOT fr                              |
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

// General Captcha Settings
$_CONF_VALIDATE['captcha']['anonymous_only'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['remoteusers'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['debug'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_comment'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_contact'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_emailstory'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_forum'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_registration']= array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_mediagallery'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_rating'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_story'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_calendar'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['enable_links'] = array('rule' => 'boolean');
$_CONF_VALIDATE['captcha']['logging'] = array('rule' => 'boolean');

?>
