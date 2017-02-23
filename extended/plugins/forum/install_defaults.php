<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Forum plugin default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */

global $_FORUM_DEFAULT;

$_FORUM_DEFAULT = array(
    'registration_required' => '0',
    'registered_to_post'    => '0',
    'allow_notification'    => '1',
    'show_topicreview'      => '1',
    'allow_user_dateformat' => '0',
    'use_pm_plugin'         => '0',
    'show_topics_perpage'   => '10',
    'show_posts_perpage'    => '10',
    'show_messages_perpage' => '20',
    'show_searches_perpage' => '20',
    'showblocks'            => 'leftblocks', // Added
    'usermenu'              => 'blockmenu',  // Added
    'use_themes_template'   => '0',          // Added
    // ----------------------------------
    'show_subject_length'   => '75',
    'min_username_length'   => '2',
    'min_subject_length'    => '2',
    'min_comment_length'    => '5',
    'views_tobe_popular'    => '20',
    'post_speedlimit'       => '60',
    'allowed_editwindow'    => '60',
    'allow_html'            => '1',
    'post_htmlmode'         => '1',
    'convert_break'         => '0',
    'use_censor'            => '1',
    'use_glfilter'          => '1',
    'use_geshi'             => '1',
    'use_spamx_filter'      => '1',
    'show_moods'            => '1',
    'allow_smilies'         => '1',
    'use_smilies_plugin'    => '0',
    'avatar_width'          => '0', // Added
    // ----------------------------------
    'show_centerblock'      => '1',
    'centerblock_homepage'  => '0',
    'centerblock_numposts'  => '5',
    'cb_subject_size'       => '40',
    'centerblock_where'     => '2',
    // ----------------------------------
    'sideblock_numposts'    => '5',
    'sb_subject_size'       => '20',
    'sb_latestpostonly'     => '0',
    'sideblock_isleft'         => '0',
    'sideblock_order'          => '100',
    'sideblock_topic_option'   => TOPIC_HOMEONLY_OPTION,
    'sideblock_topic'          => array(),
    'sideblock_enable'         => true,
    'sideblock_permissions'    => array (2, 2, 2, 2),
    // ----------------------------------
    'level1'                => '1',
    'level2'                => '15',
    'level3'                => '35',
    'level4'                => '70',
    'level5'                => '120',
    'level1name'            => 'Newbie',
    'level2name'            => 'Junior',
    'level3name'            => 'Chatty',
    'level4name'            => 'Regular Member',
    'level5name'            => 'Active Member',
    // ----------------------------------
    'menublock_isleft'         => '1',
    'menublock_order'          => '0',
    'menublock_topic_option'   => TOPIC_ALL_OPTION,
    'menublock_topic'          => array(),
    'menublock_enable'         => true,
    'menublock_permissions'    => array (2, 2, 2, 2)
);

/**
* Initialize Forum plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_FORUM_CONF if available (e.g. from
* an old config.php), uses $_FORUM_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_forum()
{
    global $CONF_FORUM, $_FORUM_DEFAULT, $_TABLES;

    if (is_array($CONF_FORUM) && (count($CONF_FORUM) > 1)) {
        $_FORUM_DEFAULT = array_merge($_FORUM_DEFAULT, $CONF_FORUM);
    }

    $c = config::get_instance();
    $n = 'forum';
    $o = 1;
    if (!$c->group_exists($n)) {
        $c->add('sg_main',               NULL,                                     'subgroup', 0, 0, NULL, 0,    true, $n);
        // ----------------------------------
        $t = 0;
        $c->add('tab_main',              NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
        $c->add('fs_main',               NULL,                                     'fieldset', 0, 0, NULL, 0,    true, $n, $t);
        $c->add('registration_required', $_FORUM_DEFAULT['registration_required'], 'select',   0, 0, 0,    $o++, true, $n, $t);
        $c->add('registered_to_post',    $_FORUM_DEFAULT['registered_to_post'],    'select',   0, 0, 0,    $o++, true, $n, $t);
        $c->add('allow_notification',    $_FORUM_DEFAULT['allow_notification'],    'select',   0, 0, 0,    $o++, true, $n, $t);
        $c->add('show_topicreview',      $_FORUM_DEFAULT['show_topicreview'],      'select',   0, 0, 0,    $o++, true, $n, $t);
        $c->add('allow_user_dateformat', $_FORUM_DEFAULT['allow_user_dateformat'], 'select',   0, 0, 0,    $o++, true, $n, $t);
        $c->add('use_pm_plugin',         $_FORUM_DEFAULT['use_pm_plugin'],         'select',   0, 0, 0,    $o++, true, $n, $t);
        $c->add('show_topics_perpage',   $_FORUM_DEFAULT['show_topics_perpage'],   'text',     0, 0, 0,    $o++, true, $n, $t);
        $c->add('show_posts_perpage',    $_FORUM_DEFAULT['show_posts_perpage'],    'text',     0, 0, 0,    $o++, true, $n, $t);
        $c->add('show_messages_perpage', $_FORUM_DEFAULT['show_messages_perpage'], 'text',     0, 0, 0,    $o++, true, $n, $t);
        $c->add('show_searches_perpage', $_FORUM_DEFAULT['show_searches_perpage'], 'text',     0, 0, 0,    $o++, true, $n, $t);
        $c->add('showblocks',            $_FORUM_DEFAULT['showblocks'],            'select',   0, 0, 6,    $o++, true, $n, $t);
        $c->add('usermenu',              $_FORUM_DEFAULT['usermenu'],              'select',   0, 0, 7,    $o++, true, $n, $t);
        $c->add('use_themes_template',   $_FORUM_DEFAULT['use_themes_template'],   'select',   0, 0, 0,    $o++, true, $n, $t);
        // ----------------------------------
        $t = 1;
        $c->add('tab_topicposting',      NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
        $c->add('fs_topicposting',       NULL,                                     'fieldset', 0, 1, NULL, 0,    true, $n, $t);
        $c->add('show_subject_length',   $_FORUM_DEFAULT['show_subject_length'],   'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('min_username_length',   $_FORUM_DEFAULT['min_username_length'],   'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('min_subject_length',    $_FORUM_DEFAULT['min_subject_length'],    'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('min_comment_length',    $_FORUM_DEFAULT['min_comment_length'],    'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('views_tobe_popular',    $_FORUM_DEFAULT['views_tobe_popular'],    'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('post_speedlimit',       $_FORUM_DEFAULT['post_speedlimit'],       'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('allowed_editwindow',    $_FORUM_DEFAULT['allowed_editwindow'],    'text',     0, 1, 0,    $o++, true, $n, $t);
        $c->add('allow_html',            $_FORUM_DEFAULT['allow_html'],            'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('post_htmlmode',         $_FORUM_DEFAULT['post_htmlmode'],         'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('convert_break',         $_FORUM_DEFAULT['convert_break'],         'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('use_censor',            $_FORUM_DEFAULT['use_censor'],            'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('use_glfilter',          $_FORUM_DEFAULT['use_glfilter'],          'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('use_geshi',             $_FORUM_DEFAULT['use_geshi'],             'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('use_spamx_filter',      $_FORUM_DEFAULT['use_spamx_filter'],      'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('show_moods',            $_FORUM_DEFAULT['show_moods'],            'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('allow_smilies',         $_FORUM_DEFAULT['allow_smilies'],         'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('use_smilies_plugin',    $_FORUM_DEFAULT['use_smilies_plugin'],    'select',   0, 1, 0,    $o++, true, $n, $t);
        $c->add('avatar_width',          $_FORUM_DEFAULT['avatar_width'],          'text',     0, 1, 0,    $o++, true, $n, $t);
        // ----------------------------------
        $t = 2;
        $c->add('tab_centerblock',       NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
        $c->add('fs_centerblock',        NULL,                                     'fieldset', 0, 2, NULL, 0,    true, $n, $t);
        $c->add('show_centerblock',      $_FORUM_DEFAULT['show_centerblock'],      'select',   0, 2, 0,    $o++, true, $n, $t);
        $c->add('centerblock_homepage',  $_FORUM_DEFAULT['centerblock_homepage'],  'select',   0, 2, 0,    $o++, true, $n, $t);
        $c->add('centerblock_numposts',  $_FORUM_DEFAULT['centerblock_numposts'],  'text',     0, 2, 0,    $o++, true, $n, $t);
        $c->add('cb_subject_size',       $_FORUM_DEFAULT['cb_subject_size'],       'text',     0, 2, 0,    $o++, true, $n, $t);
        $c->add('centerblock_where',     $_FORUM_DEFAULT['centerblock_where'],     'select',   0, 2, 5,    $o++, true, $n, $t);
        // ----------------------------------
        $t = 3;
        $c->add('tab_sideblock',         NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
        $c->add('fs_sideblock',          NULL,                                     'fieldset', 0, 3, NULL, 0,    true, $n, $t);
        $c->add('sideblock_numposts',    $_FORUM_DEFAULT['sideblock_numposts'],    'text',     0, 3, 0,    $o++, true, $n, $t);
        $c->add('sb_subject_size',       $_FORUM_DEFAULT['sb_subject_size'],       'text',     0, 3, 0,    $o++, true, $n, $t);
        $c->add('sb_latestpostonly',     $_FORUM_DEFAULT['sb_latestpostonly'],     'select',   0, 3, 0,    $o++, true, $n, $t);

        $c->add('fs_sideblock_settings', NULL,                                     'fieldset', 0, 5, NULL, 0,    true, $n, $t);
        $c->add('sideblock_enable',      $_FORUM_DEFAULT['sideblock_enable'],      'select',   0, 5, 0,    $o++, true, $n, $t);
        $c->add('sideblock_isleft',      $_FORUM_DEFAULT['sideblock_isleft'],      'select',   0, 5, 0,    $o++, true, $n, $t);
        $c->add('sideblock_order',       $_FORUM_DEFAULT['sideblock_order'],       'text',     0, 5, 0,    $o++, true, $n, $t);
        $c->add('sideblock_topic_option',$_FORUM_DEFAULT['sideblock_topic_option'],'select',   0, 5, 15,   $o++, true, $n, $t);
        $c->add('sideblock_topic',       $_FORUM_DEFAULT['sideblock_topic'],       '%select',  0, 5, NULL, $o++, true, $n, $t);

        $c->add('fs_sideblock_permissions', NULL,                                  'fieldset', 0, 6, NULL, 0,    true, $n, $t);
        $new_group_id = 0;
        if (isset($_GROUPS['Forum Admin'])) {
            $new_group_id = $_GROUPS['Forum Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Forum Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }
        $c->add('sideblock_group_id',    $new_group_id,                            'select',   0, 6, NULL,    $o++, true, $n, $t);
        $c->add('sideblock_permissions', $_FORUM_DEFAULT['sideblock_permissions'], '@select',  0, 6, 14,      $o++, true, $n, $t);
        // ----------------------------------
        $t = 4;
        $c->add('tab_rank',              NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
        $c->add('fs_rank',               NULL,                                     'fieldset', 0, 4, NULL, 0,    true, $n, $t);
        $c->add('level1',                $_FORUM_DEFAULT['level1'],                'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level2',                $_FORUM_DEFAULT['level2'],                'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level3',                $_FORUM_DEFAULT['level3'],                'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level4',                $_FORUM_DEFAULT['level4'],                'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level5',                $_FORUM_DEFAULT['level5'],                'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level1name',            $_FORUM_DEFAULT['level1name'],            'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level2name',            $_FORUM_DEFAULT['level2name'],            'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level3name',            $_FORUM_DEFAULT['level3name'],            'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level4name',            $_FORUM_DEFAULT['level4name'],            'text',     0, 4, 0,    $o++, true, $n, $t);
        $c->add('level5name',            $_FORUM_DEFAULT['level5name'],            'text',     0, 4, 0,    $o++, true, $n, $t);
        // ----------------------------------
        $t = 5;
        $c->add('tab_menublock',         NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
        $c->add('fs_menublock_settings', NULL,                                     'fieldset', 0, 7, NULL, 0,    true, $n, $t);
        $c->add('menublock_isleft',      $_FORUM_DEFAULT['menublock_isleft'],      'select',   0, 7, 0,    $o++, true, $n, $t);
        $c->add('menublock_order',       $_FORUM_DEFAULT['menublock_order'],       'text',     0, 7, 0,    $o++, true, $n, $t);
    }

    return true;
}

function forum_update_ConfValues_2_7_4()
{
    global $CONF_FORUM, $_FORUM_DEFAULT, $_TABLES, $_DB_table_prefix;

    // Retrieve the forum global settings so we can move them to the geeeklog configuration
    $_TABLES['forum_settings']     = $_DB_table_prefix . 'forum_settings';
    $result = DB_query("SELECT * FROM {$_TABLES['forum_settings']}");
    $A = DB_fetchArray($result);
    $CONF_FORUM['registration_required']  = $A['registrationrequired'];
    $CONF_FORUM['registered_to_post']     = $A['registerpost'];
    $CONF_FORUM['allow_html']             = $A['allowhtml'];
    $CONF_FORUM['post_htmlmode']          = $A['post_htmlmode'];
    $CONF_FORUM['use_glfilter']           = $A['glfilter'];
    $CONF_FORUM['use_geshi']              = $A['use_geshi_formatting'];
    $CONF_FORUM['use_censor']             = $A['censor'];
    $CONF_FORUM['show_moods']             = $A['showmood'];
    $CONF_FORUM['allow_smilies']          = $A['allowsmilies'];
    $CONF_FORUM['allow_notification']     = $A['allow_notify'];
    $CONF_FORUM['allow_user_dateformat']  = $A['allow_userdatefmt'];
    $CONF_FORUM['show_topicreview']       = $A['showiframe'];
    $CONF_FORUM['use_autorefresh']        = $A['autorefresh'];
    $CONF_FORUM['autorefresh_delay']      = $A['refresh_delay'];
    $CONF_FORUM['show_subject_length']    = $A['viewtopicnumchars'];
    $CONF_FORUM['show_topics_perpage']    = $A['topicsperpage'];
    $CONF_FORUM['show_posts_perpage']     = $A['postsperpage'];
    $CONF_FORUM['show_messages_perpage']  = $A['messagesperpage'];
    $CONF_FORUM['show_searches_perpage']  = $A['searchesperpage'];
    $CONF_FORUM['views_tobe_popular']     = $A['popular'];
    $CONF_FORUM['convert_break']          = $A['html_newline'];
    $CONF_FORUM['min_comment_length']     = $A['min_comment_len'];
    $CONF_FORUM['min_username_length']    = $A['min_name_len'];
    $CONF_FORUM['min_subject_length']     = $A['min_subject_len'];
    $CONF_FORUM['post_speedlimit']        = $A['speedlimit'];
    $CONF_FORUM['use_smilies_plugin']     = $A['use_smiliesplugin'];
    $CONF_FORUM['use_pm_plugin']          = $A['use_pmplugin'];
    $CONF_FORUM['use_spamx_filter']       = $A['use_spamxfilter'];
    $CONF_FORUM['show_centerblock']       = $A['cb_enable'];
    $CONF_FORUM['centerblock_homepage']   = $A['cb_homepage'];
    $CONF_FORUM['centerblock_where']      = $A['cb_where'];
    $CONF_FORUM['cb_subject_size']        = $A['cb_subjectsize'];
    $CONF_FORUM['centerblock_numposts']   = $A['cb_numposts'];
    $CONF_FORUM['sb_subject_size']        = $A['sb_subjectsize'];
    $CONF_FORUM['sb_latestpostonly']      = $A['sb_latestposts'];
    $CONF_FORUM['sideblock_numposts']     = $A['sb_numposts'];
    $CONF_FORUM['allowed_editwindow']     = $A['edit_timewindow'];

    $CONF_FORUM['level1']                 = $A['level1'];
    $CONF_FORUM['level2']                 = $A['level2'];
    $CONF_FORUM['level3']                 = $A['level3'];
    $CONF_FORUM['level4']                 = $A['level4'];
    $CONF_FORUM['level5']                 = $A['level5'];
    $CONF_FORUM['level1name']             = $A['level1name'];
    $CONF_FORUM['level2name']             = $A['level2name'];
    $CONF_FORUM['level3name']             = $A['level3name'];
    $CONF_FORUM['level4name']             = $A['level4name'];
    $CONF_FORUM['level5name']             = $A['level5name'];

    if (is_array($CONF_FORUM) && (count($CONF_FORUM) > 1)) {
        $_FORUM_DEFAULT = array_merge($_FORUM_DEFAULT, $CONF_FORUM);
    }

    $c = config::get_instance();
    $n = 'forum';
    $o = 1;
    if (!$c->group_exists($n)) {
        $c->add('sg_main',               NULL,                                     'subgroup', 0, 0, NULL, 0,    true, $n);
        // ----------------------------------
        $c->add('fs_main',               NULL,                                     'fieldset', 0, 0, NULL, 0,    true, $n);
        $c->add('registration_required', $_FORUM_DEFAULT['registration_required'], 'select',   0, 0, 0,    $o++, true, $n);
        $c->add('registered_to_post',    $_FORUM_DEFAULT['registered_to_post'],    'select',   0, 0, 0,    $o++, true, $n);
        $c->add('allow_notification',    $_FORUM_DEFAULT['allow_notification'],    'select',   0, 0, 0,    $o++, true, $n);
        $c->add('show_topicreview',      $_FORUM_DEFAULT['show_topicreview'],      'select',   0, 0, 0,    $o++, true, $n);
        $c->add('allow_user_dateformat', $_FORUM_DEFAULT['allow_user_dateformat'], 'select',   0, 0, 0,    $o++, true, $n);
        $c->add('use_pm_plugin',         $_FORUM_DEFAULT['use_pm_plugin'],         'select',   0, 0, 0,    $o++, true, $n);
        $c->add('show_topics_perpage',   $_FORUM_DEFAULT['show_topics_perpage'],   'text',     0, 0, 0,    $o++, true, $n);
        $c->add('show_posts_perpage',    $_FORUM_DEFAULT['show_posts_perpage'],    'text',     0, 0, 0,    $o++, true, $n);
        $c->add('show_messages_perpage', $_FORUM_DEFAULT['show_messages_perpage'], 'text',     0, 0, 0,    $o++, true, $n);
        $c->add('show_searches_perpage', $_FORUM_DEFAULT['show_searches_perpage'], 'text',     0, 0, 0,    $o++, true, $n);
        $c->add('showblocks',            $_FORUM_DEFAULT['showblocks'],            'select',   0, 0, 6,    $o++, true, $n); // Added
        $c->add('usermenu',              $_FORUM_DEFAULT['usermenu'],              'select',   0, 0, 7,    $o++, true, $n); // Added
        $c->add('use_themes_template',   $_FORUM_DEFAULT['use_themes_template'],   'select',   0, 0, 0,    $o++, true, $n); // Added
        // ----------------------------------
        $c->add('fs_topicposting',       NULL,                                     'fieldset', 0, 1, NULL, 0,    true, $n);
        $c->add('show_subject_length',   $_FORUM_DEFAULT['show_subject_length'],   'text',     0, 1, 0,    $o++, true, $n);
        $c->add('min_username_length',   $_FORUM_DEFAULT['min_username_length'],   'text',     0, 1, 0,    $o++, true, $n);
        $c->add('min_subject_length',    $_FORUM_DEFAULT['min_subject_length'],    'text',     0, 1, 0,    $o++, true, $n);
        $c->add('min_comment_length',    $_FORUM_DEFAULT['min_comment_length'],    'text',     0, 1, 0,    $o++, true, $n);
        $c->add('views_tobe_popular',    $_FORUM_DEFAULT['views_tobe_popular'],    'text',     0, 1, 0,    $o++, true, $n);
        $c->add('post_speedlimit',       $_FORUM_DEFAULT['post_speedlimit'],       'text',     0, 1, 0,    $o++, true, $n);
        $c->add('allowed_editwindow',    $_FORUM_DEFAULT['allowed_editwindow'],    'text',     0, 1, 0,    $o++, true, $n);
        $c->add('allow_html',            $_FORUM_DEFAULT['allow_html'],            'select',   0, 1, 0,    $o++, true, $n);
        $c->add('post_htmlmode',         $_FORUM_DEFAULT['post_htmlmode'],         'select',   0, 1, 0,    $o++, true, $n);
        $c->add('convert_break',         $_FORUM_DEFAULT['convert_break'],         'select',   0, 1, 0,    $o++, true, $n);
        $c->add('use_censor',            $_FORUM_DEFAULT['use_censor'],            'select',   0, 1, 0,    $o++, true, $n);
        $c->add('use_glfilter',          $_FORUM_DEFAULT['use_glfilter'],          'select',   0, 1, 0,    $o++, true, $n);
        $c->add('use_geshi',             $_FORUM_DEFAULT['use_geshi'],             'select',   0, 1, 0,    $o++, true, $n);
        $c->add('use_spamx_filter',      $_FORUM_DEFAULT['use_spamx_filter'],      'select',   0, 1, 0,    $o++, true, $n);
        $c->add('show_moods',            $_FORUM_DEFAULT['show_moods'],            'select',   0, 1, 0,    $o++, true, $n);
        $c->add('allow_smilies',         $_FORUM_DEFAULT['allow_smilies'],         'select',   0, 1, 0,    $o++, true, $n);
        $c->add('use_smilies_plugin',    $_FORUM_DEFAULT['use_smilies_plugin'],    'select',   0, 1, 0,    $o++, true, $n);
        $c->add('avatar_width',          $_FORUM_DEFAULT['avatar_width'],          'text',     0, 1, 0,    $o++, true, $n); // Added
        // ----------------------------------
        $c->add('fs_centerblock',        NULL,                                     'fieldset', 0, 2, NULL, 0,    true, $n);
        $c->add('show_centerblock',      $_FORUM_DEFAULT['show_centerblock'],      'select',   0, 2, 0,    $o++, true, $n);
        $c->add('centerblock_homepage',  $_FORUM_DEFAULT['centerblock_homepage'],  'select',   0, 2, 0,    $o++, true, $n);
        $c->add('centerblock_numposts',  $_FORUM_DEFAULT['centerblock_numposts'],  'text',     0, 2, 0,    $o++, true, $n);
        $c->add('cb_subject_size',       $_FORUM_DEFAULT['cb_subject_size'],       'text',     0, 2, 0,    $o++, true, $n);
        $c->add('centerblock_where',     $_FORUM_DEFAULT['centerblock_where'],     'select',   0, 2, 5,    $o++, true, $n);
        // ----------------------------------
        $c->add('fs_sideblock',          NULL,                                     'fieldset', 0, 3, NULL, 0,    true, $n);
        $c->add('sideblock_numposts',    $_FORUM_DEFAULT['sideblock_numposts'],    'text',     0, 3, 0,    $o++, true, $n);
        $c->add('sb_subject_size',       $_FORUM_DEFAULT['sb_subject_size'],       'text',     0, 3, 0,    $o++, true, $n);
        $c->add('sb_latestpostonly',     $_FORUM_DEFAULT['sb_latestpostonly'],     'select',   0, 3, 0,    $o++, true, $n);
        // ----------------------------------
        $c->add('fs_rank',               NULL,                                     'fieldset', 0, 4, NULL, 0,    true, $n);
        $c->add('level1',                $_FORUM_DEFAULT['level1'],                'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level2',                $_FORUM_DEFAULT['level2'],                'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level3',                $_FORUM_DEFAULT['level3'],                'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level4',                $_FORUM_DEFAULT['level4'],                'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level5',                $_FORUM_DEFAULT['level5'],                'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level1name',            $_FORUM_DEFAULT['level1name'],            'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level2name',            $_FORUM_DEFAULT['level2name'],            'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level3name',            $_FORUM_DEFAULT['level3name'],            'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level4name',            $_FORUM_DEFAULT['level4name'],            'text',     0, 4, 0,    $o++, true, $n);
        $c->add('level5name',            $_FORUM_DEFAULT['level5name'],            'text',     0, 4, 0,    $o++, true, $n);

        // Forum 2.8.0 only required Geeklog 1.6.0 but since this is now an upgrade to 2.9.0 lets insert all tabs here for version 2.8.0
        $c->add('tab_main',         NULL, 'tab', 0, 0, NULL, 0, true, 'forum', 0);
        $c->add('tab_topicposting', NULL, 'tab', 0, 1, NULL, 0, true, 'forum', 1);
        $c->add('tab_centerblock',  NULL, 'tab', 0, 2, NULL, 0, true, 'forum', 2);
        $c->add('tab_sideblock',    NULL, 'tab', 0, 3, NULL, 0, true, 'forum', 3);
        $c->add('tab_rank',         NULL, 'tab', 0, 4, NULL, 0, true, 'forum', 4);

        DB_query("UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'forum'");
    }

    return true;
}

function forum_update_ConfValues_2_8_0()
{
    global $_CONF, $_FORUM_DEFAULT, $CONF_FORUM, $_GROUPS, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/forum/install_defaults.php';


    // Config values for dynamic blocks (posts and menu)
    $n = 'forum';

    // ----------------------------------
    $t = 3;
    $o = 40; // Set sort order of config value
    $c->add('fs_sideblock_settings', NULL,                                     'fieldset', 0, 5, NULL, 0,    true, $n, $t);
    $c->add('sideblock_enable',      $_FORUM_DEFAULT['sideblock_enable'],      'select',   0, 5, 0,    $o++, true, $n, $t);
    $c->add('sideblock_isleft',      $_FORUM_DEFAULT['sideblock_isleft'],      'select',   0, 5, 0,    $o++, true, $n, $t);
    $c->add('sideblock_order',       $_FORUM_DEFAULT['sideblock_order'],       'text',     0, 5, 0,    $o++, true, $n, $t);
    $c->add('sideblock_topic_option',$_FORUM_DEFAULT['sideblock_topic_option'],'select',   0, 5, 15,   $o++, true, $n, $t);
    $c->add('sideblock_topic',       $_FORUM_DEFAULT['sideblock_topic'],       '%select',  0, 5, NULL, $o++, true, $n, $t);

    $c->add('fs_sideblock_permissions', NULL,                                  'fieldset', 0, 6, NULL, 0,    true, $n, $t);
    $new_group_id = 0;
    if (isset($_GROUPS['Forum Admin'])) {
        $new_group_id = $_GROUPS['Forum Admin'];
    } else {
        $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Forum Admin'");
        if ($new_group_id == 0) {
            if (isset($_GROUPS['Root'])) {
                $new_group_id = $_GROUPS['Root'];
            } else {
                $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            }
        }
    }
    $c->add('sideblock_group_id',    $new_group_id,                            'select',   0, 6, NULL,  $o++, true, $n, $t);
    $c->add('sideblock_permissions', $_FORUM_DEFAULT['sideblock_permissions'], '@select',  0, 6, 14,    $o++, true, $n, $t);
    // ----------------------------------
    $t = 5;
    $o = 57; // Set sort order of config value
    $c->add('tab_menublock',         NULL,                                     'tab',      0, $t, NULL, 0,   true, $n, $t);
    $c->add('fs_menublock_settings', NULL,                                     'fieldset', 0, 7, NULL, 0,    true, $n, $t);
    $c->add('menublock_isleft',      $_FORUM_DEFAULT['menublock_isleft'],      'select',   0, 7, 0,    $o++, true, $n, $t);
    $c->add('menublock_order',       $_FORUM_DEFAULT['menublock_order'],       'text',     0, 7, 0,    $o++, true, $n, $t);

    return true;
}

function forum_update_ConfValues_2_9_0()
{
	global $_CONF;
	
    require_once $_CONF['path_system'] . 'classes/config.class.php';
	
    // Remove use_themes_template override
	$c = config::get_instance();
	$c->del('use_themes_template', 'forum');
    
	return true;	
}

?>
