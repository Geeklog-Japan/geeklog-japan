<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | plugins/mycaljp/language/english.php                                      |
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

$LANG_MYCALJP = array (
    'plugin'            => 'Mycaljp Plugin',
    'plugin_name'       => 'Mycaljp',
    'access_denied'     => 'Access Denied',
    'access_denied_msg' => 'Only Root Users have Access to this Page.  Your user name and IP have been recorded.',
    'admin'             => 'Mycaljp Plugin Admin',
    'install_header'    => 'Install/Uninstall the Mycaljp Plugin',
    'installed'         => 'The Plugin is Installed',
    'uninstalled'       => 'The Plugin is Not Installed',
    'install_success'   => 'Installation Successful',
    'install_failed'    => 'Installation Failed -- See your error log to find out why.',
    'uninstall_msg'     => 'The Mycaljp Plugin Successfully Uninstalled',
    'install'           => 'Install',
    'uninstall'         => 'UnInstall',
    'warning'           => 'Warning!  the Mycaljp Plugin is still Enabled',
    'enabled'           => 'Disable the plugin before uninstalling.',
    'readme'            => 'STOP!  Before you press install please read the ',
    'installdoc'        => 'Install Document.',
    
    'blocktitle'        => 'Block Title',
    'selecttemplates'   => 'Select Template',
    'checkcontents'     => 'Checked Contents',
    'wdays'             => 'Week Title',
    'prevmonth'         => 'Last Month',
    'nextmonth'         => 'Next Month',
    'skipcalendar'      => 'Skip Site Calendar',
    'headeroflink'      => 'Contents ',
    'footeroflink'      => '',
    'yes'               => 'Yes',
    'no'                => 'No',
    'sunday'            => 'Su',
    'monday'            => 'M',
    'tuesday'           => 'Tu',
    'wednesday'         => 'W',
    'thursday'          => 'Th',
    'friday'            => 'F',
    'saturday'          => 'Sa',

    'applythemetmplate' => 'Apply Themes Tmplate',
    'headerofdate'      => 'Search Result of',
    'middleofdate'      => ' through ',
    'footerofdate'      => '',
    'no_dataproxy'      => 'Dataproxy does not exist.',
    'pickup_title'      => 'Site Calendar - Pickup',
    'block_title'       => 'Site Calendar',
);


// Localization of the Admin Configuration UI
$LANG_configsections['mycaljp'] = array(
    'label' => 'Mycaljp',
    'title' => 'Mycaljp Configulation'
);

$LANG_confignames['mycaljp'] = array(
    'headertitleyear'     => 'Header Title (Year)',
    'headertitlemonth'    => 'Header Title (Month)',
    'titleorder'          => 'Order of Header Title',
    'sunday'              => 'Sunday',
    'monday'              => 'Monday',
    'tuesday'             => 'Tuesday',
    'wednesday'           => 'Wednesday',
    'thursday'            => 'Thursday',
    'friday'              => 'Friday',
    'saturday'            => 'Saturday',
    'showholiday'         => 'Separate Sat, Sun, and Holiday by Color',
    'checkjpholiday'      => 'Check Holiday of Japan',
    'enablesrblocks'      => 'Display Right Sidebar',
    'showstoriesintro'    => 'Display Intro of Stories',
    'use_theme'           => 'Use template at the theme',
    'template'            => 'Template Name',
    'date_format'         => 'Date format',
    'supported_contents'  => 'Supported Contents',
    'enabled_contents'    => 'Enabled Contents',
    'sp_type'             => 'Types of pages to be listed',
    'sp_except'           => 'IDs of pages should not be listed',
    'block_enable'        => 'Enabled',
    'block_isleft'        => 'Display Block on Left',
    'block_order'         => 'Block Order',
    'block_topic_option'  => 'Topic Options',
    'block_topic'         => 'Topic',
    'block_group_id'      => 'Group',
    'block_permissions'   => 'Permissions',
);

$LANG_configsubgroups['mycaljp'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['mycaljp'] = array(
    'tab_main'        => 'General Mycaljp Settings',
    'tab_staticpages' => 'Staticpages Settings',
    'tab_mycaljp_block' => 'Block Settings',
);

$LANG_fs['mycaljp'] = array(
    'fs_main'              => 'General Mycaljp Settings',
    'fs_staticpages'       => 'Staticpages Settings',
    'fs_block_settings'    => 'Block Settings', 
    'fs_block_permissions' => 'Block Permissions',
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['mycaljp'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('Year Month' => 0, 'Month Year' => 1),
    14 => array('All' => 0, 'Only pages that appear on the center block' => 1, 'Only pages that do NOT appear on the center block' => 2),
    15 => array('All' => TOPIC_ALL_OPTION, 'Homepage Only' => TOPIC_HOMEONLY_OPTION, 'Select Topics' => TOPIC_SELECTED_OPTION),
    16 => array('No access' => 0, 'Read-Only' => 2),
);
?>