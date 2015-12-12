<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | userprefs.php                                                             |
// | User definable settings                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |                                                                           |
// | Copyright (C) 2000,2001,2002,2003 by the following authors:               |
// |    Tony Bibbs       tony AT tonybibbs DOT com                             |
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

require_once '../lib-common.php'; // Path to your lib-common.php

if (!in_array('forum', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

require_once $CONF_FORUM['path_include'] . 'gf_format.php';

//Check is anonymous users can access - and need to be signed in
forum_chkUsercanAccess(true);

$display = '';

$msg = isset($_GET['msg']) ? COM_applyFilter($_GET['msg'], true) : '';
if ($msg==1) {
    $display .= COM_showMessageText($LANG_GF92['setsavemsg']);
}

// SAVE SETTINGS
if (isset($_POST['submit']) && SEC_checkToken()) {
    $xalwaysnotify    = isset($_POST['xalwaysnotify'])    ? COM_applyFilter($_POST['xalwaysnotify'],true)    : '';
    $xalwaysnotify     = isset($_POST['xalwaysnotify'])     ? COM_applyFilter($_POST['xalwaysnotify'],true)  : '';
    $xmembersperpage  = isset($_POST['xmembersperpage'])  ? COM_applyFilter($_POST['xmembersperpage'],true)  : '';
    $xmessagesperpage = isset($_POST['xmessagesperpage']) ? COM_applyFilter($_POST['xmessagesperpage'],true) : '';
    $xnotifyonce      = isset($_POST['xnotifyonce'])      ? COM_applyFilter($_POST['xnotifyonce'],true)      : '';
    $xpopularlimit    = isset($_POST['xpopularlimit'])    ? COM_applyFilter($_POST['xpopularlimit'],true)    : '';
    $xpostsperpage    = isset($_POST['xpostsperpage'])    ? COM_applyFilter($_POST['xpostsperpage'],true)    : '';
    $xsearchlines     = isset($_POST['xsearchlines'])     ? COM_applyFilter($_POST['xsearchlines'],true)     : '';
    $xshowiframe      = isset($_POST['xshowiframe'])      ? COM_applyFilter($_POST['xshowiframe'],true)      : '';
    $xtopicsperpage   = isset($_POST['xtopicsperpage'])   ? COM_applyFilter($_POST['xtopicsperpage'],true)   : '';
    $xviewanonposts   = isset($_POST['xviewanonposts'])   ? COM_applyFilter($_POST['xviewanonposts'],true)   : '';

    DB_query("UPDATE {$_TABLES['forum_userprefs']} SET
        topicsperpage='$xtopicsperpage',
        postsperpage='$xpostsperpage',
        popularlimit='$xpopularlimit',
        searchlines='$xsearchlines',
        membersperpage='$xmembersperpage',
        enablenotify='$xalwaysnotify',
        viewanonposts='$xviewanonposts',
        alwaysnotify='$xalwaysnotify',
        notify_once='$xnotifyonce',
        showiframe='$xshowiframe'
     WHERE uid='{$_USER['uid']}'");

    $display = COM_refresh($_CONF['site_url'] .'/forum/userprefs.php?msg=1');
    COM_output($display);
    exit;
}


// SETTINGS MAIN
if (!isset($_POST['$submit'])) {
    // Get user specific settings from database
    $result = DB_query("SELECT * FROM {$_TABLES['forum_userprefs']} WHERE uid='{$_USER['uid']}'");
    $nrows = DB_numRows($result);

    if ($nrows == 0) {
        // Insert a new blank record. Defaults are set in SQL Defintion for table.
        DB_query("INSERT INTO {$_TABLES['forum_userprefs']} (uid) VALUES ('{$_USER['uid']}')");
        $result = DB_query("SELECT * FROM {$_TABLES['forum_userprefs']} WHERE uid='{$_USER['uid']}'");
    }

    $A = DB_fetchArray($result);

    if ($A['viewanonposts'] == 1) {
        $viewanonposts_yes = 'checked="checked"';
        $viewanonposts_no  = '';
    } else {
        $viewanonposts_no  = 'checked="checked"';
        $viewanonposts_yes = '';
    }

    if ($A['alwaysnotify'] == 1) {
        $alwaysnotify_yes = 'checked="checked"';
        $alwaysnotify_no  = '';
    } else {
        $alwaysnotify_no  = 'checked="checked"';
        $alwaysnotify_yes = '';
    }
    if ($A['enablenotify'] == 1) {
        $emailnotify_yes = 'checked="checked"';
        $emailnotify_no  = '';
    } else {
        $emailnotify_no  = 'checked="checked"';
        $emailnotify_yes = '';
    }

    if ($A['notify_once'] == 1) {
        $notifyonce_yes = 'checked="checked"';
        $notifyonce_no  = '';
    } else {
        $notifyonce_yes = '';
        $notifyonce_no  = 'checked="checked"';
    }

    if ($A['showiframe'] == 1) {
        $showiframe_yes = 'checked="checked"';
        $showiframe_no  = '';
    } else {
        $showiframe_no  = 'checked="checked"';
        $showiframe_yes = '';
    }

    $usersettings = COM_newTemplate($CONF_FORUM['path_layout'] . 'forum/layout/userprefs');
    $usersettings->set_file (array ('usersettings'=>'user_settings.thtml'));
    $usersettings->set_var ('phpself', $_CONF['site_url'] .'/forum/userprefs.php');
    $usersettings->set_var ('LANG_feature', $LANG_GF01['FEATURE']);  
    $usersettings->set_var ('LANG_setting', $LANG_GF01['SETTING']);  
    $usersettings->set_var ('LANG_GF01[YES]', $LANG_GF01['YES']);
    $usersettings->set_var ('LANG_GF01[NO]', $LANG_GF01['NO']);
    $usersettings->set_var ('LANG_save', $LANG_GF01['SAVE']);
    $usersettings->set_var ('LANG_GF92[topicspp]', $LANG_GF92['topicspp']);
    $usersettings->set_var ('LANG_GF92[topicsppdscp]', $LANG_GF92['topicsppdscp']);
    $usersettings->set_var ('topicsperpage', $A['topicsperpage']);
    $usersettings->set_var ('LANG_GF92[postspp]', $LANG_GF92['postspp']);
    $usersettings->set_var ('LANG_GF92[postsppdscp]', $LANG_GF92['postsppdscp']);
    $usersettings->set_var ('postsperpage', $A['postsperpage']);
    $usersettings->set_var ('LANG_GF02[msg122]', $LANG_GF02['msg122']);
    $usersettings->set_var ('LANG_GF02[msg123]', $LANG_GF02['msg123']);
    $usersettings->set_var ('popularlimit', $A['popularlimit']);
    $usersettings->set_var ('LANG_GF02[msg126]', $LANG_GF02['msg126']);
    $usersettings->set_var ('LANG_GF02[msg127]', $LANG_GF02['msg127']);
    $usersettings->set_var ('searchlines', $A['searchlines']);
    $usersettings->set_var ('LANG_GF02[msg128]', $LANG_GF02['msg128']);
    $usersettings->set_var ('LANG_GF02[msg129]', $LANG_GF02['msg129']);
    $usersettings->set_var ('membersperpage', $A['membersperpage']);
    $usersettings->set_var ('LANG_GF02[msg130]', $LANG_GF02['msg130']);
    $usersettings->set_var ('LANG_GF02[msg131]', $LANG_GF02['msg131']);
    $usersettings->set_var ('viewanonposts', $A['viewanonposts']);
    $usersettings->set_var ('viewanonposts_yes', $viewanonposts_yes);
    $usersettings->set_var ('viewanonposts_no', $viewanonposts_no);
    $usersettings->set_var ('LANG_GF02[msg167]', $LANG_GF02['msg167']);
    $usersettings->set_var ('LANG_GF02[msg168]', $LANG_GF02['msg168']);
    $usersettings->set_var ('enablenotify', $A['enablenotify']);
    $usersettings->set_var ('emailnotify_yes', $emailnotify_yes);
    $usersettings->set_var ('emailnotify_no', $emailnotify_no);
    $usersettings->set_var ('LANG_GF02[msg184]', $LANG_GF02['msg184']);
    $usersettings->set_var ('LANG_GF02[msg185]', $LANG_GF02['msg185']);
    $usersettings->set_var ('notifyonce_yes', $notifyonce_yes);
    $usersettings->set_var ('notifyonce_no', $notifyonce_no);
    $usersettings->set_var ('LANG_GF02[msg132]', $LANG_GF02['msg132']);
    $usersettings->set_var ('LANG_GF02[msg133]', $LANG_GF02['msg133']);
    $usersettings->set_var ('alwaysnotify', $A['alwaysnotify']);
    $usersettings->set_var ('alwaysnotify_yes', $alwaysnotify_yes);
    $usersettings->set_var ('alwaysnotify_no', $alwaysnotify_no);
    $usersettings->set_var ('LANG_GF92[showiframe]', $LANG_GF92['showiframe']);
    $usersettings->set_var ('LANG_GF92[showiframedscp]', $LANG_GF92['showiframedscp']);
    $usersettings->set_var ('showiframe', $A['showiframe']);
    $usersettings->set_var ('showiframe_yes', $showiframe_yes);
    $usersettings->set_var ('showiframe_no', $showiframe_no);
    if ($CONF_FORUM['usermenu'] == 'navbar') {
        $usersettings->set_var('navmenu', forumNavbarMenu($LANG_GF01['USERPREFS']));
    } else {
        $usersettings->set_var('navmenu','');
    }
    $usersettings->set_var('gltoken_name', CSRF_TOKEN);
    $usersettings->set_var('gltoken', SEC_createToken());

    $usersettings->parse ('output', 'usersettings');
    $display .= $usersettings->finish($usersettings->get_var('output'));
}

$display = gf_createHTMLDocument($display);

COM_output($display);
?>
