<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Captcha plugin 3.5                                                        |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
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
//

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Captcha default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_CP_DEFAULT;
$_CP_DEFAULT = array();

$_CP_DEFAULT['anonymous_only']   = 1;
$_CP_DEFAULT['remoteusers']   = 0;
$_CP_DEFAULT['debug']   = 0;
$_CP_DEFAULT['enable_comment']   = 1;
$_CP_DEFAULT['enable_contact']   = 1;
$_CP_DEFAULT['enable_emailstory']   = 1;
$_CP_DEFAULT['enable_forum']   = 1;
$_CP_DEFAULT['enable_registration']   = 1;
$_CP_DEFAULT['enable_mediagallery']   = 1;
$_CP_DEFAULT['enable_rating']   = 1;
$_CP_DEFAULT['enable_story']   = 1;
$_CP_DEFAULT['enable_calendar']   = 1;
$_CP_DEFAULT['enable_links']   = 1;
$_CP_DEFAULT['logging']   = 0;

/**
* Initialize Captcha plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_CA_CONF if available (e.g. from
* an old config.php), uses $_CP_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_captcha()
{
    global $_CP_DEFAULT;

    $c = config::get_instance();
    if (!$c->group_exists('captcha')) {

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'captcha', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'captcha', 0);
		
        $c->add('fs_config', NULL, 'fieldset', 0, 0, NULL, 0, true, 'captcha', 0);
        
		$c->add('debug', $_CP_DEFAULT['debug'],
                'select', 0, 0, 0, 50, true, 'captcha', 0);
        $c->add('logging', $_CP_DEFAULT['logging'],
                'select', 0, 0, 0, 60, true, 'captcha', 0);
		$c->add('input_id', rand(),
                'text', 0, 0, 0, 70, true, 'captcha', 0);
		$c->add('use_slider', 1,
					'select', 0, 0, 0, 80, true, 'captcha', 0);

        $c->add('fs_integration', NULL, 'fieldset', 0, 10, NULL, 0, true, 'captcha', 0);
		
		$c->add('anonymous_only', $_CP_DEFAULT['anonymous_only'],
                'select', 0, 10, 0, 10, true, 'captcha', 0);
		 $c->add('remoteusers', $_CP_DEFAULT['remoteusers'],
                'select', 0, 10, 0, 20, true, 'captcha', 0);
        $c->add('enable_comment', $_CP_DEFAULT['enable_comment'],
                'select', 0, 10, 0, 40, true, 'captcha', 0);
        $c->add('enable_contact', $_CP_DEFAULT['enable_contact'],
                'select', 0, 10, 0, 50, true, 'captcha', 0);
        $c->add('enable_emailstory', $_CP_DEFAULT['enable_emailstory'],
                'select', 0, 10, 0, 60, true, 'captcha', 0);
        $c->add('enable_forum', $_CP_DEFAULT['enable_forum'],
                'select', 0, 10, 0, 70, true, 'captcha', 0);
        $c->add('enable_registration', $_CP_DEFAULT['enable_registration'],
                'select', 0, 10, 0, 80, true, 'captcha', 0);
        $c->add('enable_mediagallery', $_CP_DEFAULT['enable_mediagallery'],
                'select', 0, 10, 0, 90, true, 'captcha', 0);
        $c->add('enable_rating', $_CP_DEFAULT['enable_rating'],
                'select', 0, 10, 0, 100, true, 'captcha', 0);
        $c->add('enable_story', $_CP_DEFAULT['enable_story'],
                'select', 0, 10, 0, 110, true, 'captcha', 0); 
		$c->add('enable_calendar', $_CP_DEFAULT['enable_calendar'],
                'select', 0, 10, 0, 120, true, 'captcha', 0);
        $c->add('enable_links', $_CP_DEFAULT['enable_links'],
                'select', 0, 10, 0, 130, true, 'captcha', 0);			
       
    }

    return true;
}

?>
