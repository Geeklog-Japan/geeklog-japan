<?php

// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/themedit/install_defaults.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2017 - geeklog AT mystral-kk DOT net                   |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
	die('This file can not be used on its own.');
}

/**
* Theme Editor default settings
*
* Initial Installation Defaults used when loading the online configuration
* records. These settings are only used during the initial installation
* and not referenced any more once the plugin is installed
*/

/**
* Theme Editor plugin configuration file
*/
global $_DB_table_prefix, $_THM_DEFAULT;

/**
* the Theme Editor plugin's config array
* 
* @global array $_THM_DEFAULT
*/
$_THM_DEFAULT = array();

//-------------------------------------
//  Theme names and file names
//-------------------------------------

/**
* If you set $_THM_CONF['enable_all_themes'] to true, all themes will be
* accessible from the Theme Editor Plugin, regardless of the value of
* $_THM_CONF['allowed_themes'] var.
*/
$_THM_DEFAULT['enable_all_themes'] = false;

/**
* If you set true to $_THM_DEFAULT['enable_all_files'], all files related to
* themes (*.thtml, *.css) will be accessible from the Theme Editor Plugin,
* regardless of the value of $_THM_DEFAULT['allowed_files'] var
*/
$_THM_DEFAULT['enable_all_files'] = false;

/**
* Themes to be edited with this plugin
* @NOTE: theme names are case-sensitive
*/
if (version_compare(VERSION, '2.1.2') >= 0) {
	$_THM_DEFAULT['allowed_themes'] = array(
		'denim', 'denim_curve', 'modern_curve',
	);
} else {
	$_THM_DEFAULT['allowed_themes'] = array(
		'professional',
	);
}

/**
* Template files and CSS files to be edited with this plugin
* @NOTE: file names are case-sensitive
*/
$_THM_DEFAULT['allowed_files'] = array(
	// CSS
	'style.css', 'custom.css', 'custom.sample.css', 'style_forum.css',
	
	// Site header and footer
	'header.thtml', 'footer.thtml',
	
	// Blocks
	'leftblocks.thtml', 'blockheader-left.thtml', 'blockfooter-left.thtml',
	'rightblocks.thtml', 'blockheader-right.thtml', 'blockfooter-right.thtml',
	
	// Story
	'storytext.thtml', 'featuredstorytext.thtml', 'archivestorytext.thtml',
	'article/article.thtml', 'article/printable.thtml',
	
	// Menu
	'menuitem.thtml', 'menuitem_last.thtml', 'menuitem_none.thtml',
	
	// List
	'list.thtml', 'listitem.thtml',
	
	// Login
	'loginform.thtml',
	
	// Profile
	'profiles/contactuserform.thtml', 'profiles/contactauthorform.thtml',
	'preferences/profile.thtml', 'users/profile.thtml',
	
	// Search
	'search/searchform.thtml', 'search/searchresults.thtml',
	
	// User submission
	'submit/submitevent.thtml', 'submit/submitloginrequired.thtml',
	
	// User
	'users/newpassword.thtml', 'users/getpasswordform.thtml',
	'users/loginform.thtml', 'users/registrationform.thtml',
	'users/storyrow.thtml', 'users/commentrow.thtml', 
);

/**
* If you'd like to see theme names and file names sorted alphabetically in
* their dropdown list, uncomment the next two lines.
*/
// sort($_THM_DEFAULT['allowed_themes']);
// sort($_THM_DEFAULT['allowed_files']);

/**
* When you add/remove a theme to/from $_THM_DEFAULT['allowed_themes'], or
* a template file to/from $_THM_DEFAULT['allowed_files'], Theme Editor plugin will
* detect it automatically.  When this option is set to 'auto', the plugin will
* update the data stored in databse automatically.  When set to 'manual', the
* plugin will display the information and 'UPDATE database' button.  When set
* to 'ignore', the plugin will do nothing about the change.
*/
$_THM_DEFAULT['resync_database'] = 'manual';

//-------------------------------------
//  Image upload
//-------------------------------------

/**
* If set true, you can upload images to theme/images/* directories
*/
$_THM_DEFAULT['allow_upload'] = true;

/**
* Thumbnail sizes in pixels
*/
$_THM_DEFAULT['image_width']  = 120;

$_THM_DEFAULT['image_height'] = 100;

/**
* Max column number of thumbnails
*/
$_THM_DEFAULT['image_max_col'] = 6;

/**
* Max size of a file in bytes (1048576 bytes = 1M bytes) for uploading to the
* Web server
*/
$_THM_DEFAULT['upload_max_size'] = 1048576;

/**
* Initialize Dbman plugin configuration
*
* Creates the database entries for the configuation if they don't already exist.
* Initial values will be taken from $_THM_CONF if available (e.g. from an old
* config.php), uses $_THM_CONF otherwise.
*
* @return   boolean     true: success; false: an error occurred
*/
function plugin_initconfig_themedit() {
	global $_THM_CONF, $_THM_DEFAULT;
	
	$me = 'themedit';
	$c = config::get_instance();
	
	if (!$c->group_exists($me)) {
		$c->add('sg_main', null, 'subgroup', 0, 0, null, 0, true, $me);
		$c->add('fs_main', null, 'fieldset', 0, 0, null, 0, true, $me);
		
		// Main
		$c->add('enable_all_themes', $_THM_DEFAULT['enable_all_themes'], 'select', 0, 0, 0, 10, true, $me);
		$c->add('enable_all_files', $_THM_DEFAULT['enable_all_files'], 'select', 0, 0, 0, 20, true, $me);
		$c->add('allowed_themes', $_THM_DEFAULT['allowed_themes'], '%text', 0, 0, null, 30, true, $me);
		$c->add('allowed_files', $_THM_DEFAULT['allowed_files'], '%text', 0, 0, null, 40, true, $me);
		$c->add('resync_database', $_THM_DEFAULT['resync_database'], 'select', 0, 0, 1, 50, true, $me);
		$c->add('allow_upload', $_THM_DEFAULT['allow_upload'], 'select', 0, 0, 0, 60, true, $me);
		$c->add('image_width', $_THM_DEFAULT['image_width'], 'text', 0, 0, null, 70, true, $me);
		$c->add('image_height', $_THM_DEFAULT['image_height'], 'text', 0, 0, null, 80, true, $me);
		$c->add('image_max_col', $_THM_DEFAULT['image_max_col'], 'text', 0, 0, null, 90, true, $me);
		$c->add('upload_max_size', $_THM_DEFAULT['upload_max_size'], 'text', 0, 0, null, 100, true, $me);
	}
	
	return true;
}
