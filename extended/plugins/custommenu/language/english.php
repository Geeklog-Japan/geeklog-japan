<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/language/english.php                                   |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2008-2013 dengen - taharaxp AT gmail DOT com                |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett               -    twillett AT users DOT sourceforge DOT net  |
// | Blaine Lang               -    langmail AT sympatico DOT ca               |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                -    tony AT tonybibbs DOT com                  |
// | Modified by:                                                              |
// | mystral-kk                -    geeklog AT mystral-kk DOT net              |
// | dengen                    -    taharaxp AT gmail DOT com                  |
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

$LANG_CMED = array(
    'display_name'        => 'CustomMenu',
    'menu_title'          => 'CustomMenu',
    'plugin'              => 'CustomMenu Editor',
    'access_denied'       => 'Access Denied',
    'access_denied_msg'   => 'Only Root Users have Access to this Page.  Your user name and IP have been recorded.',
    'admin'               => 'CustomMenu Plugin Admin',
    'install_header'      => 'Install/Uninstall the CustomMenu Plugin',
    'installed'           => 'The Plugin is Installed',
    'uninstalled'         => 'The Plugin is Not Installed',
    'install_success'     => 'Installation Successful',
    'install_failed'      => 'Installation Failed -- See your error log to find out why.',
    'uninstall_msg'       => 'The CustomMenu Plugin Successfully Uninstalled',
    'install'             => 'Install',
    'uninstall'           => 'UnInstall',
    'warning'             => 'Warning!  the CustomMenu Plugin is still Enabled',
    'enabled'             => 'Disable the plugin before uninstalling.',
    'readme'              => 'STOP!  Before you press install please read the ',
    'installdoc'          => 'Install Document.',

    // for stats
    'stats_headline'      => 'Menu Configulation (Top10)',
    'stats_title'         => 'Title',
    'stats_value'         => 'Value',
    'stats_no_value'      => 'No Data.',
    
    // for admin
    'manager'             => 'CustomMenu Editor',
    'move'                => 'Move',
    'order'               => 'Order',
    'id'                  => 'ID',
    'classname'           => 'Class',
    'instructions'        => 'To modify or delete a data, click on that data\'s edit icon below.  To create a new data, click on "Create New" above.',

    'warning_updated'     => 'CustomMenu Editor Plugin is updated.',
    'instructions_update' => 'Please update \'custommenu\' in Plugin Management.',
);

$LANG_CMED_EDITOR = array(
    'confirm'             => $MESSAGE[76],
    'topic'               => $LANG_ADMIN['topic'],
    'menuitemtype'        => $LANG_ADMIN['type'],
    'save'                => $LANG_ADMIN['save'],
    'cancel'              => $LANG_ADMIN['cancel'],
    'delete'              => $LANG_ADMIN['delete'],

    'accessrights'        => $LANG_ACCESS['accessrights'],
    'owner'               => $LANG_ACCESS['owner'],
    'group'               => $LANG_ACCESS['group'],
    'permissions'         => $LANG_ACCESS['permissions'],
    'perm_key'            => $LANG_ACCESS['permissionskey'],
    'permissions_msg'     => $LANG_ACCESS['permmsg'],

    'custommenueditor'    => 'MenuItem Editor',
    'all'                 => 'all',
    'menuitemorder'       => 'Order',
    'instructions'        => 'To modify or delete a menuitem, click on that menuitem\'s edit icon below.  To create a new menuitem, click on "Create New" above. To move a menuitem, click on the arrows.',
    'homeonly'            => 'Homepage Only',
    'menuitemid'          => 'Menuitem ID',
    'nospaces'            => ' (no spaces and must be unique)',
    'includehttp'         => 'include http://  It is essential in a Fixed Mode and a Variable Mode. ',
    'mode'                => 'Mode',
    'mode_info'           => 'Fixation : The mode fixes a Title.<br' . XHTML . '>Variable : The mode is made variable with a Title.(for MultiLanguage)<br' . XHTML . '>PHP : The mode sets a Title and URL by a PHP Function flexibly.',
    'mode_fixation'       => 'Fixation',
    'mode_variable'       => 'Variable',
    'mode_php'            => 'PHP',
    'title_fixation'      => 'Title (Fixation)',
    'title_fixation_info' => 'In the Fixed Mode, this is required.',
    'title_variable'      => 'Title (Variable)',
    'title_variable_info' => 'In the Variable Mode, this is required.<br' . XHTML . '>You can set an array variable defined in a language file.<br' . XHTML . '>For example, you set "MY_WORD[\'label\']" when you make a title "$MY_WORD[\'label\']".',
    'php_function'        => 'PHP Function Name',
    'php_function_info'   => 'In the PHP Mode, this is required.<br' . XHTML . '>You must add prefix "phpmenuitem_" to a PHP Function Name.',
    'is_enabled'          => 'Enabled',
    'menuitemurl'         => 'URL',
    'icon_url'            => 'Icon URL',
    'icon_url_info'       => 'include http:// This item is invalid normally. <br' . XHTML . '>You have to change a COM_renderMenu function elsewhere to utilize this effectively.',
    'type_gldefault'      => 'Geeklog default',
    'type_plugin'         => 'Plugin',
    'type_custom'         => 'Custom',
    'update'              => 'Update',
    'error_field'         => 'Error Missing Field(s)',
    'message_access1'     => "You are trying to access a menuitem that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/custommenu/index.php\">go back to the CustomMenu administration screen</a>.",
    'message_access2'     => 'Sorry, you do not have access to the CustomMenu administration page.  Please note that all attempts to access unauthorized features are logged',
    'message_access3'     => 'You are trying to delete a menuitem that you don\'t have rights to.  This attempt has been logged. ',
    'move_down'           => 'Move Menuitem Down',
    'move_up'             => 'Move Menuitem Up',
    'message_title'       => 'Bad Menuitem Title.',
    'message_wrong'       => 'Input value is inappropriate.',
    'message_title2'      => 'Your Title must not be empty and cannot contain HTML!',
    'access_denied'       => 'Access Denied.',
    'validate_message_1'  => 'In the Fixed Mode, you cannot omit the input of the Title (Fixation).',
    'validate_message_2'  => 'In the Variable Mode, you cannot omit the input of the Title (Variable).',
    'validate_message_3'  => 'In the PHP Mode, you cannot omit input of the PHP Function Name.',
    'validate_message_4'  => 'You cannot omit input of the Menuitem ID.',
    'validate_message_5'  => 'There is already the same Menuitem ID.',
    'validate_message_6'  => 'URL matching character string is not right.',
    'validate_message_7'  => 'In the Fixed Mode and the Variable Mode, you cannot omit the input of the URL.',
    'validate_message_8'  => 'The value of the Parent Item ID is invalid.',
    'pattern'             => 'URL matching character string',
    'pattern_info'        => 'When the URL of a page displaying matched it with this character string, "selected" is added to the information of menuitem handed to Geeklog system.<br' . XHTML . '>It is enabled to reverse the style of the menuitem when I utilize this.',
    'is_preg'             => 'Regular Expression',
    'parentitemid'        => 'Parent Item ID',

    'class_name'          => 'Class Name',
    'class_name_info'     => 'You can set class names every Menuitem.',
);

// Let's define original titles for Variable Modes!
$MY_TITLES = array(
);

// Messages for COM_showMessage the submission form

$PLG_custommenu_MESSAGE2 = 'CustomMenu data has been successfully saved.';
$PLG_custommenu_MESSAGE3 = 'CustomMenu data has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_custommenu_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_custommenu_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['custommenu'] = array(
    'label' => 'CustomMenu',
    'title' => 'CustomMenu Configuration'
);

$LANG_confignames['custommenu'] = array(
    'aftersave' => 'After Saving CustomMenu Data',
    'menu_render' => 'Menu Render',
    'prefix_id' => 'Prefix to add to ID',
    'default_permissions' => 'CustomMenu Default Permissions'
);

$LANG_configsubgroups['custommenu'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['custommenu'] = array(
    'tab_main' => 'General CustomMenu Settings',
    'tab_permissions' => 'CustomMenu Default Permissions'
);

$LANG_fs['custommenu'] = array(
    'fs_main' => 'CustomMenu Main Settings',
    'fs_public' => 'Public CustomMenu List Settings',
    'fs_permissions' => 'CustomMenu Default Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['custommenu'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE),
    9 => array('Display Admin List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    10 => array('Geeklog System Standard' => 'standard', 'Supports a Pulldown Menu' => 'pulldown'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>