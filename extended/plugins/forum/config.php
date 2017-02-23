<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |                                                                           |
// | Forum Plugin Authors                                                      |
// |    Mr.GxBlock                                        www.gxblock.com      |
// |    Matthew DeWyer   matt AT mycws DOT com            www.cweb.ws          |
// |    Blaine Lang      geeklog AT langfamily DOT ca     www.langfamily.ca    |
// +---------------------------------------------------------------------------+
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
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'config.php') !== false) {
    die('This file can not be used on its own.');
}

// Set to true if you need to handle previous version 2.5 quotes and new line formatting - setting to false should be faster
$CONF_FORUM['pre2.5_mode'] = true;

// When a user or moderator edits a story - if the default should be to not change post timestamps
// and trigger any user notifications - then set default as true
$CONF_FORUM['silent_edit_default'] = true;

// The BBCode tag [img] is enabled by default - set this to false to disable it
$CONF_FORUM['allow_img_bbcode'] = true;

// Disabled by default for performance gains. Enable if you need to show moderators on the main forum index page
$CONF_FORUM['show_moderators'] = false;

/* The forum uses a number of icons and you may have a need to use a mixture of image types.
 * Enabling the $CONF_FORUM['autoimagetype'] feature will invoke a function that will first
 * check for an image of the type set in your themes function.php $_IMAGE_TYPE 
 * If the icon of that image type is not found, then it will use an image of type 
 * specified by the $CONF_FORUM['image_type_override'] setting.
 * Set $CONF_FORUM['autoimagetype'] to false to disable this feature and 
 * only icons of type set by the themes $_IMAGE_TYPE setting will be used
*/
$CONF_FORUM['autoimagetype'] = true;
$CONF_FORUM['image_type_override'] = 'gif'; 

// Default date/time format to use if Forum setting for allow user-dateformat is disabled
$CONF_FORUM['default_Datetime_format'] = $_CONF['shortdate']." ".$_CONF['timeonly'] ;

// Date format that is shown at the top of of the topic post used if Forum setting for allow user-dateformat is disabled
$CONF_FORUM['default_Topic_Datetime_format'] = $_CONF['shortdate']." ".$_CONF['timeonly'] ;

/* Number of characters of the topic contents when hovering over the topic post subject link */ 
$CONF_FORUM['contentinfo_numchars'] = 256;

/* Width of pop-up info window that is displayed when hovering over topic posts. */
$CONF_FORUM['linkinfo_width'] = 30;

/* Format style for quotes */
$CONF_FORUM['quoteformat'] = "[QUOTE][u]Quote by: %s[/u][p]%s[/p][/QUOTE]";

// 0 shows all posts of user
$CONF_FORUM['show_last_post_count'] = 10; 

// How many posts or views does a topic need to show on popular topics page. 0 shows all topics
$CONF_FORUM['popular_limit'] = '0';

// How many messages to show on the Most Popular page. 0 shows all topics
$CONF_FORUM['show_popular_perpage'] = '20';

// How many lines to show on one page in the search results
$CONF_FORUM['show_search_perpage'] = 20;

// How many lines to show on one page in the search results
$CONF_FORUM['show_newposts_perpage'] = 20;

// How many users to show on one page in the memberlist results
$CONF_FORUM['show_members_perpage'] = 20;

// Show the members list page to anonymous users
$CONF_FORUM['show_memberslist_anonymous'] = false;

// View Anonymous Posts - registed users can set this false
$CONF_FORUM['show_anonymous_posts'] = 1;

// Only send Notification once - even if more posts are created since your last visit
$CONF_FORUM['notify_once'] = 1;

// When this value is true, set the sort order of the topic view list in ASC.
$CONF_FORUM['sort_order_asc'] = true;

// Mapping of Group Names to badges that can optionally be displayed in Forum Post under user avatar
// Place images in the directory /forum/forum/image_set/badges
// Note Root needs a unique mapping since if you are in the Root group, then you are in all groups
// $CONF_FORUM['grouptags'] and $CONF_FORUM['groupnames'] needs to have the same element ids
$CONF_FORUM['grouptags'] = array(
    'Root'            => 'siteadmin_badge.png',
    'Logged-in Users' => 'forum_user.png',
    'Group A'         => 'badge1.png',
    'Group B'         => 'badge2.png'
);
$CONF_FORUM['groupnames'] = array(
    'Root'            => 'Site Admin',
    'Logged-in Users' => 'Forum User',
    'Group A'         => 'Group A',
    'Group B'         => 'Group B'
);

// Should glMenu be used for this menublock
$CONF_FORUM['use_glmenu'] = false;

// When the user agent is mobile, overwrite setting specially.
// This setting is only valid Geeklog Japanese edition.
if (function_exists('CUSTOM_MOBILE_is_cellular') && CUSTOM_MOBILE_is_cellular()) {
    $CONF_FORUM['sort_order_asc']        = false;
    $CONF_FORUM['show_topics_perpage']   = 5;
    $CONF_FORUM['show_posts_perpage']    = 5;
    $CONF_FORUM['centerblock_numposts']  = 5;
    $CONF_FORUM['show_searches_perpage'] = 5;
    $CONF_FORUM['show_messages_perpage'] = 5;
    $CONF_FORUM['sideblock_numposts']    = 5;
}

?>
