<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

// General Forum Settings
$_CONF_VALIDATE['forum']['registration_required'] = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['registered_to_post']    = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['allow_notification']    = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['show_topicreview']      = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['allow_user_dateformat'] = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['use_pm_plugin']         = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['show_topics_perpage']   = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['show_posts_perpage']    = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['show_messages_perpage'] = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['show_searches_perpage'] = array('rule' => 'numeric');
$_CONF_VALIDATE['links']['showblocks']            = array(
    'rule' => array('inList', array('leftblocks', 'rightblocks', 'allblocks', 'noblocks'), true)
);
$_CONF_VALIDATE['links']['usermenu']              = array(
    'rule' => array('inList', array('blockmenu', 'navbar', 'none'), true)
);
$_CONF_VALIDATE['forum']['use_themes_template']   = array('rule' => 'boolean');

// Topic Posting Settings
$_CONF_VALIDATE['forum']['show_subject_length']   = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['min_username_length']   = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['min_subject_length']    = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['min_comment_length']    = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['views_tobe_popular']    = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['post_speedlimit']       = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['allowed_editwindow']    = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['allow_html']            = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['post_htmlmode']         = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['convert_break']         = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['use_censor']            = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['use_glfilter']          = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['use_geshi']             = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['use_spamx_filter']      = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['show_moods']            = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['allow_smilies']         = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['use_smilies_plugin']    = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['avatar_width']          = array('rule' => 'numeric');

// Centerblock Settings
$_CONF_VALIDATE['forum']['show_centerblock']      = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['centerblock_homepage']  = array('rule' => 'boolean');
$_CONF_VALIDATE['forum']['centerblock_numposts']  = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['cb_subject_size']       = array('rule' => 'numeric');
$_CONF_VALIDATE['links']['centerblock_where']     = array(
    'rule' => array('inList', array(1, 2, 3), true)
);

// Sideblock Settings
$_CONF_VALIDATE['forum']['sideblock_numposts']    = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['sb_subject_size']       = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['sb_latestpostonly']     = array('rule' => 'boolean');

// Rank Settings
$_CONF_VALIDATE['forum']['level1']                = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['level2']                = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['level3']                = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['level4']                = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['level5']                = array('rule' => 'numeric');
$_CONF_VALIDATE['forum']['level1name']            = array('rule' => 'string');
$_CONF_VALIDATE['forum']['level2name']            = array('rule' => 'string');
$_CONF_VALIDATE['forum']['level3name']            = array('rule' => 'string');
$_CONF_VALIDATE['forum']['level4name']            = array('rule' => 'string');
$_CONF_VALIDATE['forum']['level5name']            = array('rule' => 'string');

?>
