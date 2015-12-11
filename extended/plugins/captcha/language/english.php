<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v3.5 Plugin                                                       |
// +---------------------------------------------------------------------------+
// | This is the English language page for the CAPTCHA Plugin                  |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2009-2014 by the following authors:                         |
// |                                                                           |
// | ben           ben AT geeklog DOT fr                                     |
// |                                                                           |
// | Based on the original CAPTCHA Plugin                                      |
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Mark R. Evans - mark AT glfusion DOT org                                  | 
// +---------------------------------------------------------------------------|
// |                                                                           |
// | If you translate this file, please consider uploading a copy at           |
// |    http://geeklog.net so others can benefit from your                     |
// |    translation.  Thank you!                                               |
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

$LANG_CP00 = array (
    'menulabel'         => 'CAPTCHA',
    'plugin'            => 'CAPTCHA',
    'access_denied'     => 'Access Denied',
    'access_denied_msg' => 'You do not have the proper security privilege to access to this page.  Your user name and IP have been recorded.',
    'admin'             => 'CAPTCHA Administration',
    'install_header'    => 'CAPTCHA Plugin Install/Uninstall',
    'installed'         => 'CAPTCHA is Installed',
    'uninstalled'       => 'CAPTCHA is Not Installed',
    'install_success'   => 'CAPTCHA Installation Successful.  <br /><br />Please review the system documentation and also visit the  <a href="%s">administration section</a> to insure your settings correctly match the hosting environment.',
    'install_failed'    => 'Installation Failed -- See your error log to find out why.',
    'uninstall_msg'     => 'Plugin Successfully Uninstalled',
    'install'           => 'Install',
    'uninstall'         => 'UnInstall',
    'warning'           => 'Warning! Plugin is still Enabled',
    'enabled'           => 'Disable plugin before uninstalling.',
    'readme'            => 'CAPTCHA Plugin Installation',
    'installdoc'        => "<a href=\"http://geeklog.fr/wiki/plugins:captcha\" target=\"_blank\">online wiki</a>",
    'overview'          => 'CAPTCHA is a native geeklog plugin that provides an additional layer of security for spambots. <br /><br />A CAPTCHA (an acronym for "Completely Automated Public Turing test to tell Computers and Humans Apart", trademarked by Carnegie Mellon University) is a type of challenge-response test used in computing to determine whether or not the user is human.By implementing the CAPTCHA test, it should help reduce the number of Spambot entries on your site.',
    'details'           => '',
    'preinstall_check'  => '',
    'geeklog_check'     => '',
    'php_check'         => '',
    'preinstall_confirm' => "",
    'captcha_help'      => '',
    'bypass_error'      => "You have attempted to bypass the CAPTCHA processing at this site, please use the New User link to register.",
    'bypass_error_blank' => "You have attempted to bypass the CAPTCHA processing at this site.",
    'entry_error'       => 'Our filter indicates an error. Please, read carefully the instructions below.',
    'captcha_info'      => 'The CAPTCHA Plugin provides another layer of protection against SpamBots for your geeklog site.  See the <a href="%s">Online Documentation Wiki</a> for more info.',
    'enabled_header'    => 'Current CAPTCHA Settings',
    'view_logfile'      => 'View CAPTCHA Logfile',
    'log_viewer'        => 'Geeklog Log Viewer',
    'on'                => 'On',
    'off'               => 'Off',
    'save'              => 'Save',
    'cancel'            => 'Cancel',
    'success'           => 'Configuration Options successfully saved.',
	'captcha'           => 'Security',
	'question'          => 'The action below is for testing whether you are a human visitor and to prevent automated spam submissions. Un-lock to submit the form...',
	'what_code'         => '',
    'view_log'          => 'Views/Clear the Geeklog Log Files.',
    'file'              => 'File:',
    'view_file'         => 'View Log File',
    'clear_file'        => 'Clear Log File',
    'file_cleared'      => 'Log File Cleared',
	'txtLock'           => 'Locked : form can\'t be submited',
	'txtUnlock'         => 'Unlocked : form can be submited',
);

$PLG_captcha_MESSAGE1 = 'CAPTCHA plugin upgrade: Update completed successfully.';
$PLG_captcha_MESSAGE2 = 'CAPTCHA plugin upgrade failed - check error.log';
$PLG_captcha_MESSAGE3 = 'CAPTCHA Plugin Successfully Installed';

// Localization of the Admin Configuration UI
$LANG_configsections['captcha'] = array(
    'label' => 'Captcha',
    'title' => 'Captcha Configuration'
);

$LANG_confignames['captcha'] = array(
    'anonymous_only' => 'Anonymous Only',
	'remoteusers' => 'Force CAPTCHA for all Remote Users',
	'debug' => 'Debug',
	'enable_comment' => 'Enable Comment',
	'enable_contact' => 'Enable Contact',
	'enable_emailstory' => 'Enable Email Story',
	'enable_forum' => 'Enable Forum',
	'enable_registration' => 'Enable Registration',
	'enable_mediagallery' => 'Enable Media Gallery (Postcards)',
	'enable_rating' => 'Enable Rating Plugin Support',
	'enable_story' => 'Enable Story',
	'enable_calendar' => 'Enable Calendar Plugin Support',
	'enable_links' => 'Enable Links Plugin Support',
	'logging' => 'Log invalid CAPTCHA attempts',
	'input_id' => 'Custom id for invisible input',
	'use_slider' => 'Enable CAPTCHA slider',
);

$LANG_configsubgroups['captcha'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['captcha'] = array(
    'tab_main' => 'General Captcha Settings'
);
 
$LANG_fs['captcha'] = array(
    'fs_config' => 'CAPTCHA Configuration',
    'fs_integration' => 'CAPTCHA Integration'    
);

// Note: entries 0 is the same as in $LANG_configselects['Core']
$LANG_configselects['captcha'] = array(
    0 => array('True' => 1, 'False' => 0)
);

?>