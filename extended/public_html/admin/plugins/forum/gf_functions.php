<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | gf_functions.php                                                          |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'gf_functions.php') !== false) {
    die('This file can not be used on its own.');
}

require_once '../../../lib-common.php';

if (!in_array('forum', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

/**
* Security check to ensure user even belongs on this page
*/
require_once '../../auth.inc.php';

if (!SEC_hasRights('forum.edit')) {
    $display = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the forum administration.");
    COM_output($display);
    exit;
}

gf_updateSystem();

require_once $_CONF['path_system'] . 'classes/navbar.class.php';
$navbar = new navbar;
$navbar->add_menuitem($LANG_GF06['1'], $_CONF['site_admin_url'] .'/plugins/forum/index.php');
$navbar->set_onclick($LANG_GF06['1'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/index.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
$navbar->add_menuitem($LANG_GF06['3'], $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
$navbar->set_onclick($LANG_GF06['3'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/boards.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
$navbar->add_menuitem($LANG_GF06['4'], $_CONF['site_admin_url'] .'/plugins/forum/mods.php');
$navbar->set_onclick($LANG_GF06['4'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/mods.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
$navbar->add_menuitem($LANG_GF06['5'], $_CONF['site_admin_url'] .'/plugins/forum/migrate.php');
$navbar->set_onclick($LANG_GF06['5'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/migrate.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
$navbar->add_menuitem($LANG_GF06['6'], $_CONF['site_admin_url'] .'/plugins/forum/messages.php');
$navbar->set_onclick($LANG_GF06['6'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/messages.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
$navbar->add_menuitem($LANG_GF06['7'], $_CONF['site_admin_url'] .'/plugins/forum/ips.php');
$navbar->set_onclick($LANG_GF06['7'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/ips.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
$navbar->add_menuitem($LANG_GF06['2'], $_CONF['site_admin_url'] .'/plugins/forum/settings.php');
$navbar->set_onclick($LANG_GF06['2'], 'location.href="' . "{$_CONF['site_admin_url']}/plugins/forum/settings.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)

function gf_resyncforum($id) {
    global $_CONF,$_TABLES;

    COM_errorLog("Re-Syncing Forum id:$id");
    // Update all the Topics lastupdated timestamp to that of the last posted comment
    $topicsQuery = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE forum=$id AND pid=0");
    $topicCount = DB_numRows($topicsQuery);
    if ($topicCount > 0) {
        $lastTopicQuery = DB_query("SELECT MAX(id) AS maxid FROM {$_TABLES['forum_topic']} WHERE forum=$id");
        $lasttopic = DB_fetchArray($lastTopicQuery);
        DB_query("UPDATE {$_TABLES['forum_forums']} SET last_post_rec = {$lasttopic['maxid']} WHERE forum_id=$id");
        $postCount = DB_Count($_TABLES['forum_topic'],'forum',$id);
        // Update the forum definition record to know the number of topics and number of posts
        DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=$topicCount, post_count=$postCount WHERE forum_id=$id");

        $recCount = 0;
        while($trecord = DB_fetchArray($topicsQuery)) {
            $recCount++;
            // Retrieve the oldest post records for this topic and update the lastupdated time in the parent topic record
            $lsql = DB_query("SELECT MAX(id) AS maxid FROM {$_TABLES['forum_topic']} WHERE pid={$trecord['id']}");
            $lastrec = DB_fetchArray($lsql);
            if ($lastrec['maxid'] != NULL) {
                $postCount = DB_count($_TABLES['forum_topic'],'forum',$id);
                $latest = DB_getItem($_TABLES['forum_topic'], 'date', "id={$lastrec['maxid']}");
                DB_query("UPDATE {$_TABLES['forum_topic']} SET lastupdated = '$latest' WHERE id='{$trecord['id']}'");
                // Update the parent topic record to know the id of the Last Reply
                DB_query("UPDATE {$_TABLES['forum_topic']} SET last_reply_rec = {$lastrec['maxid']} WHERE id='{$trecord['id']}'");
            } else {
                $latest = DB_getItem($_TABLES['forum_topic'], 'date', "id={$trecord['id']}");
                DB_query("UPDATE {$_TABLES['forum_topic']} SET lastupdated = '$latest' WHERE id='{$trecord['id']}'");
            }
            // Recalculate and Update the number of replies
            $numreplies = DB_Count($_TABLES['forum_topic'], "pid", $trecord['id']);
            DB_query("UPDATE {$_TABLES['forum_topic']} SET replies = '$numreplies' WHERE id='{$trecord['id']}'");
        }
        COM_errorLog("$recCount Topic Records Updated");
    } else {
        COM_errorLog("No topic records to resync");
    }
}

function gf_updateSystem() {
    global $_CONF, $_TABLES;

    if (function_exists('COM_versionCompare')) { // This function was introduced in Geeklog 1.8.0
        // So, if we have it, we can use tabs in the configuration UI
        // Which were also introduced in version 1.8.0 of Geeklog
        $code_version = plugin_chkVersion_forum();
        $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['conf_values']} "
                         . "WHERE group_name = 'forum' AND type = 'tab'");
        $A = DB_fetchArray($result);
        if ($A['count'] == 0 && version_compare($code_version, '2.7.99', '>')) {
            require_once $_CONF['path'] . 'plugins/forum/install_defaults.php';
            forum_update_ConfValues_addTabs();
        }
    }
}

?>
