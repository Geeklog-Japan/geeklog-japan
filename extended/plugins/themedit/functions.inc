<?php
//
// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/themedit/functions.inc                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2017 - geeklog AT mystral-kk DOT net                   |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

// Language file Include
$langfile = $_CONF['path'] . 'plugins/themedit/language/' . $_CONF['language'] . '.php';
clearstatcache();

if (file_exists($langfile)) {
	include_once $langfile;
} else {
	include_once $_CONF['path'] . 'plugins/themedit/language/english.php';
}

// Includes themedit config file
require_once $_CONF['path'] . 'plugins/themedit/config.php';

THM_loadConfig();

// Defines useful constants
if (!defined('LB')) {
	define('LB', "\n");
}

if (!defined('XHTML')) {
	define('XHTML', '');
}

define('THEMEDIT_BASE_URL', $_CONF['site_admin_url'] . '/plugins/themedit');

// Enables all files if $_THM_CONF['enable_all_files'] is true
if (isset($_THM_CONF['enable_all_files']) && $_THM_CONF['enable_all_files'] == true) {
	$_THM_CONF['allowed_files'] = array();
	$_THM_CONF['allowed_files'] = THM_getAllThemeFiles(
		$_CONF['path_themes'] . 'professional', true
	);
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

if (!is_callable('DB_escapeString')) {
	function DB_escapeString($str) {
		return addslashes($str);
	}
}

if (!is_callable('COM_redirect')) {
	function COM_redirect($url) {
		echo COM_refresh($url);
		die();
	}
}

function plugin_geticon_themedit() {
	return THEMEDIT_BASE_URL . '/images/themedit.gif';
}

/**
* Checks to see if this Plugin uses comments
*/
function plugin_commentsupport_themedit() {
	return false;
}

/**
* Returns the URL to a given document
*/
function plugin_getdocumentationurl_themedit($file) {
	global $_CONF;
	
	$lang = str_replace('_utf-8', '', COM_getLanguage());
	$path = $_CONF['path_html'] . 'admin/plugins/themedit/docs/' . $lang . '/'
		  . $file . '.html';
	clearstatcache();
	
	if (!file_exists($path)) {
		$lang = 'english';
	}
	
	$retval = THEMEDIT_BASE_URL . '/docs/' . $lang . '/' . $file . '.html';
	
	return $retval;
}

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, null to use config 
*                           tooltip hack, or empty string when not available
*/
function plugin_getconfigtooltip_themedit($id) {
	// Use config tooltip hack where tooltip is read from the config documentation
	return null;
}

/**
* Returns ccpanel options
*/
function plugin_cclabel_themedit() {
	global $_CONF, $LANG_THM;
	
	if (SEC_hasRights('themedit.admin')) {
		$pi_name   = THM_str('cc_label');
		$admin_url = THEMEDIT_BASE_URL . '/index.php';
		$icon_url  = plugin_geticon_themedit();
		return array($pi_name, $admin_url, $icon_url);
	}
}

/**
* Returns the administrative option for this plugin
*/
function plugin_getadminoption_themedit() {
	global $_CONF, $_TABLES;
	
	if (SEC_hasRights('themedit.admin')) {
		$pi_name   = THM_str('cc_label');
		$admin_url = THEMEDIT_BASE_URL . '/index.php';
		$num_items = DB_count($_TABLES['thm_contents']);
		return array($pi_name, $admin_url, $num_items);
	}
}

/**
* Returns the version for this plugin
*/
function plugin_chkVersion_themedit() {
	global $_THM_CONF;
	
	return $_THM_CONF['pi_version'];
}

/**
* Upgrades the plugin
*/
function plugin_upgrade_themedit() {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$pi_version = DB_getItem(
		$_TABLES['plugins'], 'pi_version', "(pi_name = 'themedit')"
	);
	
    /**
    * If the version of Themedit plugin is lower than 1.0.5 AND Geeklog version
	* is 1.5 or newer, then save config values into DB with config.class.php.
    */
    if ((version_compare($pi_version, '1.0.5') <= 0) && (version_compare(VERSION, '1.5') >= 0)) {
        require_once $_CONF['path'] . 'plugins/themedit/install_defaults.php';
        plugin_initconfig_themedit();
    }
	
    if (version_compare($pi_version, '1.2.0') < 0) {
		$sql1 = "UPDATE {$_TABLES['features']} "
			  . "  SET ft_descr = 'Theme Editor Admin' "
			  . "  WHERE (ft_descr = 'themedit Admin') ";
		$sql2 = "UPDATE {$_TABLES['groups']} "
			  . "  SET grp_name = 'Theme Editor Admin' "
			  . "  WHERE (grp_name = 'themedit Admin') ";
		$sql3 = "DELETE FROM {$_TABLES['conf_values']} "
			  . "  WHERE (name = 'enable_csrf_protection') "
			  . "    AND (group_name = 'themedit') ";
		DB_query($sql1);
		DB_query($sql2);
		DB_query($sql3);
	}
	
	// Updates plugin info
	$sql = "UPDATE {$_TABLES['plugins']} "
		 . "  SET pi_version = '". $_THM_CONF['pi_version'] . "' "
		 . "  WHERE (pi_name = 'themedit')";
	$result = DB_query($sql);
	COM_errorLog("Themedit plugin was successfully updated to version {$_THM_CONF['pi_version']}.");
	
	return true;
}

/**
* Returns JavaScript to be inserted into the header
*/
function plugin_getheadercode_themedit() {
	global $_CONF;
	
	$header = '<meta http-equiv="Content-Script-Type" content="text/javascript"'
			. XHTML . '>' . LB
			. '<script type="text/javascript" src="' . THEMEDIT_BASE_URL
			. '/js/selection.js' . '"></script>' . LB;
	return $header;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*/
function plugin_autouninstall_themedit() {
	$out = array (
		/* give the name of the tables, without $_TABLES[] */
		'tables'     => array('thm_contents'),
		/* give the full name of the group, as in the db */
		'groups'     => array('Theme Editor Admin'),
		/* give the full name of the feature, as in the db */
		'features'   => array('themedit.admin'),
		/* give the full name of the block, including 'phpblock_', etc */
		'php_blocks' => array(),
		/* give all vars with their name */
		'vars'       => array(''),
	);

	return $out;
}

/**
* Escapes a string for output
*/
function THM_esc($str) {
	static $charset = null;
	
	if ($charset === null) {
		$charset = COM_getCharset();
	}
	
	return htmlspecialchars($str, ENT_QUOTES, $charset);
}

function THM_str($index) {
	global $LANG_THM;
	
	if (isset($LANG_THM[$index])) {
		return THM_esc($LANG_THM[$index]);
	} else {
		COM_errorLog(__FUNCTION__ . ': undefined index: ' . $index);
		return '(undefined)';
	}
}

/**
* Return template vars stored in DB
*
* @return: array of string: names of template vars
*/
function THM_getTemplateVars($theme, $filename) {
	global $_TABLES;
	
	$retval = array();
	
	$theme    = DB_escapeString($theme);
	$filename = DB_escapeString($filename);
	$sql = "SELECT thm_vars "
		 . "FROM {$_TABLES['thm_contents']} "
		 . "WHERE (thm_name = '{$theme}') AND (thm_filename = '{$filename}')";
	$result = DB_query($sql);
	
	if (!DB_error()) {
		$A = DB_fetchArray($result);
		
		if (!empty($A['thm_vars'])) {
			$retval = explode(',', $A['thm_vars']);
		}
	}
	
	return $retval;
}

/**
* Returns template vars
*
* @param   $text  string    the contents of a template
* @return  array of string  names of template vars
*/
function THM_scanTemplateVars($text) {
	$retval = array();
	
	$result = preg_match_all('/\{([^}].*?)\}/', $text, $match);
	
	if ($result >= 1) {
		$retval = array_unique($match[1]);
		sort($retval);
	}
	
	return $retval;
}

/**
* Returns the current contents of a given file stored on Web server
*
* @param  $theme     string  theme name
*         $filename  string  file name
* @return            string  the current contents of a given file
*/
function THM_getContents($theme, $filename) {
	global $_CONF, $_THM_CONF;
	
	$retval = '';
	$path = $_CONF['path_themes'] . $theme . '/' . $filename;
	clearstatcache();
	
	if (file_exists($path)) {
		$contents = @file_get_contents($path);
		if ($contents === false) {
			$retval = '';
		} else {
			$retval = $contents;
		}
	} else {
		$retval = '';
	}
	
	return $retval;
}

/**
* Returns the initial contents of a given file stored in DB
*
* @param  $theme     string  theme name
*         $filename  string  file name
* @return            string  the initial contents of a given file
*/
function THM_getInitalContents($theme, $filename) {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$contents = '';
	$theme    = DB_escapeString($theme);
	$filename = DB_escapeString($filename);
	
	$sql = "SELECT thm_init_contents "
		 . "FROM {$_TABLES['thm_contents']} "
		 . "WHERE (thm_name = '{$theme}') AND (thm_filename = '{$filename}')";
	$result = DB_query($sql);
	
	if (!DB_error()) {
		$A = DB_fetchArray($result);
		$contents = $A['thm_init_contents'];
	}
	
	return $contents;
}

/**
* Returns allowed theme names, considering $_THM_CONF['allowed_themes']
*
* @return   array of string  theme names
*/
function THM_getAllowedThemes() {
	global $_CONF, $_THM_CONF;
	
	$retval = array();
	$themes = COM_getThemes(true);
	
	if ($_THM_CONF['enable_all_themes']) {
		$retval = $themes;
	} else {
		foreach ($themes as $theme) {
			if (in_array($theme, $_THM_CONF['allowed_themes'])) {
				$retval[] = $theme;
			}
		}
	}
	
	return $retval;
}

/**
* Imports the designated file and scan template vars in case of a template file
* and save the contents into database
*
* @return  boolean  true = success, false = otherwise
*/
function THM_importFile($theme, $filename) {
	global $_TABLES;
	
	$contents = THM_getContents($theme, $filename);
	
	if (preg_match("/\.thtml$/i", $filename)) {
		$vars = implode(',', THM_scanTemplateVars($contents));
	} else {
		$vars = '';
	}
	
	$theme    = DB_escapeString($theme);
	$filename = DB_escapeString($filename);
	$contents = DB_escapeString($contents);
	$vars     = DB_escapeString($vars);
	$sql = "INSERT INTO {$_TABLES['thm_contents']} "
		 . "(thm_name, thm_filename, thm_init_contents, thm_vars) "
		 . "VALUES ('{$theme}', '{$filename}', '{$contents}', '{$vars}')";
	$result = DB_query($sql);
	
	return !($result === false);
}

/**
* Initializes themedit database -- populate the table with default file contents
*/
function THM_initDatabase() {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$themes = THM_getAllowedThemes();
	
	foreach ($themes as $theme) {
		foreach ($_THM_CONF['allowed_files'] as $filename) {
			THM_importFile($theme, $filename);
		}
	}
}

/**
* Saves the file on the server
*
* @return  boolean  true = success, false = fail
*/
function THM_saveFile($theme, $filename, $contents) {
	global $_CONF;
	
	$path = $_CONF['path_themes'] . $theme . '/' . $filename;
	$fh = @fopen($path, 'wb');
	
	if ($fh === false) {
		return false;
	}
	
	$result1 = fwrite($fh, $contents);
	$result2 = fclose($fh);
	
	if (($result1 === false) || ($result1 != strlen($contents))
	 || ($result2 === false)) {
		return false;
	}
	
	return true;
}

/**
* Initializes the contnets on the web with the data stored in DB
*/
function THM_initFile($theme, $filename) {
	$contents = THM_getInitalContents($theme, $filename);
	
	return THM_saveFile($theme, $filename, $contents);
}

/**
* Returns if a file is writable
*/
function THM_isWritable($theme, $filename) {
	global $_CONF;
	
	$path = $_CONF['path_themes'] . $theme . '/' . $filename;
	clearstatcache();
	$retval = is_writable($path);
# 	if ($retval) {
# 		$path_parts = pathinfo($path);
# 		clearstatcache();
# 		$retval = is_writable($path_parts['dirname']);
# 	}
	
	return $retval;
}

/**
* Returns if themes and/or files are added and/or removed
*
* @TODO  this function doesn't work well when themes are deleted from
*        $_THM_CONF['allowed_themes'].
*/
function THM_isAddedOrRemoved() {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$retval = array();
	$retval['added']   = array();
	$retval['removed'] = array();
	$themes = THM_getAllowedThemes();
	
	foreach ($themes as $theme) {
		$theme = DB_escapeString($theme);
		$sql = "SELECT thm_filename FROM {$_TABLES['thm_contents']} "
			 . "WHERE (thm_name = '{$theme}')";
		$result = DB_query($sql);
		
		if (DB_error()) {
			exit;
		} else {
			$db_files = array();
			
			while (($A = DB_fetchArray($result)) !== false) {
				$db_files[] = $A['thm_filename'];
			}
		}
		
		foreach ($_THM_CONF['allowed_files'] as $filename) {
			$path = $_CONF['path_themes'] . $theme . '/' . $filename;
			clearstatcache();
			
			if (file_exists($path)) {
				// file exists, but not in DB
				if (!in_array($filename, $db_files)) {
					$retval['added'][] = array('theme' => $theme, 'file' => $filename);
				}
			} else {
				// the file no longer exits but the corresponding DB record still remains
				if (in_array($filename, $db_files)) {
					$retval['removed'][] = array('theme' => $theme, 'file' => $filename);
				}
			}
		}
	}
	
	return $retval;
}

/**
* Updates all files and/or database according to $_THM_CONF['allowed_themes']
* and $_THM_CONF['allowed_files']
*/
function THM_updateAll() {
	global $_CONF, $_TABLES;

	$diff = THM_isAddedOrRemoved();
	
	// Adds new files into database
	foreach ($diff['added'] as $added) {
		$theme = $added['theme'];
		$file  = $added['file'];
		THM_importFile($theme, $file);
	}
	
	/**
	* Delete old files from database
	*/
	foreach ($diff['removed'] as $removed) {
		$theme = $removed['theme'];
		$file  = $removed['file'];
		$theme = DB_escapeString($theme);
		$file  = DB_escapeString($file);
		$sql = "DELETE FROM {$_TABLES['thm_contents']} "
			 . "WHERE (thm_name = '{$theme}') AND (thm_filename = '{$file}')";
		DB_query($sql);
	}
	
	COM_errorLog('Themedit: Updated the information stored in the database successfully.');
	COM_redirect(THEMEDIT_BASE_URL . '/index.php');
}

/**
* Returns the preview HTML by letting public_html/index.php do the job
*/
function THM_getPreview() {
	global $_CONF, $_TABLES;
	
	$old_level = error_reporting(0);
	ob_start();
	require_once $_CONF['path_html'] . 'index.php';
	$retval = ob_get_contents();
	ob_end_clean();
	error_reporting($old_level);
	
	return $retval;
}

/**
* Returns a directory tree with the current directory name stressed
*/
function THM_getDirTree($theme, $selected_dir = '/images') {
	global $_CONF, $_USER, $_TABLES;
	
	// Checks for '..' in case of the directory-traversal attack
	if (strpos($selected_dir, '..') !== false) {
		COM_errorLog("Themedit: someone tried directory-traversal attack on THM_getDirTree(): User ID = {$_USER['uid']}");
		return '';
	}
	
	$retval   = '<ul>' . LB;
	$cgi_path = THEMEDIT_BASE_URL . '/upload.php';
	
	// images/
	$retval .= '<li>';
	
	if ($selected_dir == '/images') {
		$retval .= "<strong>{$theme}/images</strong>";
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images',
						'theme' => $theme
					)
		);
		$retval .= '<a href="' . $url . '">' . THM_esc($theme) . '/images<a>';
	}
	
	$retval .= '<br' . XHTML . '>' . LB
			.  '<ul>' . LB;
	
	// images/admin/
	$retval .= '<li>' . LB;
	
	if ($selected_dir === '/images/admin') {
		$retval .= '<strong>/admin</strong>';
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images/admin',
						'theme' => $theme
					)
		);
		$retval .= '<a href="' . $url . '">/admin</a>';
	}
	
	$retval .= '</li>' . LB;
	
	// images/buttons/
	$retval .= '<li>' . LB;
	
	if ($selected_dir === '/images/buttons') {
		$retval .= '<strong>/buttons</strong>';
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images/buttons',
						'theme' => $theme
					)
		);
		$retval .= '<a href="' . $url . '">/buttons</a>';
	}
	
	$retval .= '</li>' . LB;

	// images/icons/
	$retval .= '<li>' . LB;
	
	if ($selected_dir === '/images/icons') {
		$retval .= '<strong>/icons</strong>';
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images/icons',
						'theme' => $theme
					)
		);
		$retval .= '<a href="' . $url . '">/icons</a>';
	}
	
	$retval .= '</li>' . LB
			.  '</ul>' . LB
			.  '</li>' . LB
			.  '</ul>' . LB;
	
	return $retval;
}

/**
* Gets all theme-related files (*.thtml, *.css)
*
* @param  string  $path  the name of the path
* @return array of file names
*/
function THM_getAllThemeFiles($path, $top_level = false) {
	global $_CONF;
	
	$retval = array();
	
	$dh = @opendir($path);
	
	if ($dh !== false) {
		while (($entry = readdir($dh)) !== false) {
			$this_path = $path . '/' . $entry;
			
			if (is_dir($this_path)) {
				if (($entry != '.') && ($entry != '..')) {
					$retval = array_merge($retval, THM_getAllThemeFiles($this_path, false));
				}
			} else {
				if (preg_match("/\.(thtml|css)$/i", $this_path)) {
					$retval[] = $this_path;
				}
			}
		}
	}
	
	closedir($dh);
	
	if ($top_level) {
		for ($i = 0; $i < count($retval); $i ++) {
			$retval[$i] = substr(
				$retval[$i], strlen($_CONF['path_themes'] . 'professional/')
			);
		}
	}
	
	return $retval;
}

/**
* Builds a URL with a query string
*/
function THM_buildURL($url, $params = array()) {
	$retval = $url;
	
	if (count($params) >= 1) {
		$temp = array();
		
		foreach ($params as $key => $value) {
			$temp[] = $key . '=' . rawurlencode($value);
		}
		
		$retval .= '?' . implode('&amp;', $temp);
	}
	
	return $retval;
}

/**
* Creates a menu with an optional icon and optional text below
* this is used in the admin screens but may be used elsewhere also.
*
* @param    string  $text  instructions to be displayed
* @return   string         HTML output of function
*/
function THM_createMenu($current_menu = 'list', $text = '', $noesc = true) {
    global $_CONF, $_THM_CONF;
    
    $THM_MENU = array(
        'admin' => array(
                    'url'  => $_CONF['site_admin_url'],
                    'text' => THM_str('menu_admin_home'),
        ),
        'file'  => array(
                    'url'  => THEMEDIT_BASE_URL . '/index.php?cmd=file',
                    'text' => THM_str('menu_file'),
        ),
        'image' => array(
                    'url'  => THEMEDIT_BASE_URL . '/index.php?cmd=image',
                    'text' => THM_str('menu_image'),
        ),
    );
    
    if ($_THM_CONF['allow_restore'] == false) {
        unset($THM_MENU['restore']);
    }
	
    $admin_templates = new Template($_CONF['path'] . 'plugins/themedit/templates');
    $admin_templates->set_file (
        array ('top_menu' => 'topmenu.thtml')
    );
    
    $menu_fields = array();
    $attr = array(
        'class' => 'admin-menu-item'
    );
    
    foreach ($THM_MENU as $key => $value) {
        if ($key != $current_menu) {
            $menu_fields[] = '<a href="' . $value['url']
                           . '" class="admin-menu-item">' . $value['text'] . '</a>';
        } else {
            $menu_fields[] = '<strong>' . $value['text'] . '</strong>';
        }
    }
    
    $admin_templates->set_var('icon', THEMEDIT_BASE_URL . '/images/themedit.gif');
    $admin_templates->set_var('menu_fields', implode(' | ', $menu_fields));
	
    if ($noesc) {
        $admin_templates->set_var('lang_instructions', THM_esc($text));
    } else {
        $admin_templates->set_var('lang_instructions', $text);
    }
	
    $admin_templates->set_var('xhtml', XHTML);
    $admin_templates->parse('top_menu', 'top_menu');
    $retval = $admin_templates->finish($admin_templates->get_var('top_menu'));
    
    return $retval;
}

function THM_list($header_arr, $data_arr) {
    $retval = '<table class="admin-list-table">' . LB
            . '<tr style="background: #ffffff;">' . LB;
    
    foreach ($header_arr as $header) {
        $retval .= '<th class="admin-list-headerfield">' . $header . '</th>' . LB;
    }
    
    $retval .= '</tr>' . LB;
    $class = 'pluginRow1';
    
    foreach ($data_arr as $row) {
        $retval .= '<tr class="' . $class . '" onmouseover="className=\'pluginRollOver\';" onmouseout="className=\'' . $class . '\';">' . LB;

        foreach ($row as $cell) {
            $retval .= '<td class="admin-list-field">' . $cell . '</td>' . LB;
        }
        
        $retval .= '</tr>' . LB;
        $class = ($class === 'pluginRow1' ? 'pluginRow2' : 'pluginRow1');
    }
    
    $retval .= '</table>' . LB;
	
    return $retval;
}

function THM_form() {
    return '<form action="' . THEMEDIT_BASE_URL . '/index.php" method="post">' . LB;
}

function THM_checkbox($name, $id, $value, $label, $checked = true) {
    $retval = '<input type="checkbox" id="' . $id . '" name="' . $name
            . '" value="' . $value . '"';
    
	if ($checked) {
        $retval .= ' checked="checked"';
    }
    
    $retval .= XHTML . '><label for="' . $id . '">' . $label . '</label>';
    return $retval;
}

function THM_radio($name, $id, $value, $label, $checked = true) {
    $retval = '<input type="radio" id="' . $id . '" name="' . $name
            . '" value="' . $value . '"';
    if ($checked) {
        $retval .= ' checked="checked"';
    }
    
    $retval .= XHTML . '><label for="' . $id . '">' . THM_esc($label) . '</label>';
    return $retval;
}

/**
* Loads config info with config.class.php
*/
function THM_loadConfig() {
	global $_CONF, $_THM_CONF;
	
	require_once $_CONF['path_system'] . 'classes/config.class.php';
	
	$config = config::get_instance();
	
	if ($config->group_exists('themedit')) {
		$temp = $config->get_config('themedit');
		
		if (isset($_THM_CONF) && is_array($_THM_CONF) && is_array($temp) && (count($temp) > 0)) {
			$_THM_CONF = array_merge($_THM_CONF, $temp);
		}
	}
}
