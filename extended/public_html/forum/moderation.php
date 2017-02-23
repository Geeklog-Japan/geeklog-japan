<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | moderation.php                                                            |
// | Forum Moderation Program                                                  |
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

require_once '../lib-common.php';

if (!in_array('forum', $_PLUGINS)) {
    COM_handle404();
    exit;
}

require_once $CONF_FORUM['path_include'] . 'gf_format.php';
require_once $CONF_FORUM['path_include'] . 'gf_showtopic.php';

// Check for access privilege and pass true to check that user is signed in.
forum_chkUsercanAccess(true);

$display = '';

// Debug Code to show variables
$display .= gf_showVariables();

// Pass thru filter any get or post variables to only allow numeric values and remove any hostile data
$confirmbanip     = isset($_POST['confirmbanip'])     ? COM_applyFilter($_POST['confirmbanip'])          : '';
$confirm_move     = isset($_POST['confirm_move'])     ? COM_applyFilter($_POST['confirm_move'])          : '';
$fortopicid       = isset($_REQUEST['fortopicid'])    ? COM_applyFilter($_REQUEST['fortopicid'],true)    : '';
$fortopicid       = isset($_REQUEST['fortopicid'])    ? COM_applyFilter($_REQUEST['fortopicid'],true)    : '';
$forum            = isset($_REQUEST['forum'])         ? COM_applyFilter($_REQUEST['forum'],true)         : '';
$hostip           = isset($_POST['hostip'])           ? COM_applyFilter($_POST['hostip'])                : '';
$modconfirmdelete = isset($_POST['modconfirmdelete']) ? COM_applyFilter($_POST['modconfirmdelete'])      : '';
$modfunction      = isset($_REQUEST['modfunction'])   ? COM_applyFilter($_REQUEST['modfunction'])        : '';
$moveid           = isset($_REQUEST['moveid'])        ? COM_applyFilter($_REQUEST['moveid'],true)        : '';
$movetoforum      = isset($_REQUEST['movetoforum'])   ? COM_applyFilter($_REQUEST['movetoforum'])        : '';
$movetitle        = isset($_REQUEST['movetitle'])     ? COM_applyFilter($_REQUEST['movetitle'])          : '';
$msgid            = isset($_REQUEST['msgid'])         ? COM_applyFilter($_REQUEST['msgid'],true)         : '';
$msgpid           = isset($_REQUEST['msgpid'])        ? COM_applyFilter($_REQUEST['msgpid'],true)        : '';
$page             = isset($_REQUEST['page'])          ? COM_applyFilter($_REQUEST['page'],true)          : '';
$showtopic        = isset($_REQUEST['showtopic'])     ? COM_applyFilter($_REQUEST['showtopic'],true)     : '';
$submit           = isset($_REQUEST['submit'])        ? COM_applyFilter($_POST['submit'])                : '';
$top              = isset($_REQUEST['top'])           ? COM_applyFilter($_REQUEST['top'])                : '';

ForumHeader($forum, $showtopic, $display);

if ($forum == 0) {
    $display .= alertMessage($LANG_GF02['msg71']);
    $display = gf_createHTMLDocument($display);
    COM_output($display);
    exit();
}

if (forum_modPermission($forum,$_USER['uid'])) {

    //Moderator check OK, everything dealing with moderator permissions go here.
    if ($modconfirmdelete == 1 && $msgid != '') {
        if ($submit == $LANG_GF01['CANCEL']) {
            echo COM_refresh("viewtopic.php?showtopic=$msgpid");
            exit();
        } else {

            $topicparent = DB_getItem($_TABLES['forum_topic'],"pid","id='$msgid'");
            if ($top == 'yes') {
                DB_query("DELETE FROM {$_TABLES['forum_topic']} WHERE (id='$msgid')");
                PLG_itemDeleted($msgid, 'forum');
                COM_rdfUpToDateCheck('forum'); // forum rss feeds update
                DB_query("DELETE FROM {$_TABLES['forum_topic']} WHERE (pid='$msgid')");

                DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE (id='$msgid')");
                $postCount = DB_Count($_TABLES['forum_topic'],'forum',$forum);
                DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=topic_count-1,post_count=$postCount WHERE forum_id=$forum");
                $query = DB_query("SELECT MAX(id) FROM {$_TABLES['forum_topic']} WHERE forum=$forum");
                list($last_topic) = DB_fetchArray($query);
                if ($last_topic > 0) {
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET last_post_rec=$last_topic WHERE forum_id=$forum");
                } else {
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET last_post_rec=0 WHERE forum_id=$forum");
                }
            } else {
                DB_query("UPDATE {$_TABLES['forum_topic']} SET replies=replies-1 WHERE id=$topicparent");
                DB_query("DELETE FROM {$_TABLES['forum_topic']} WHERE (id='$msgid')");
                PLG_itemDeleted($msgid, 'forum');
                COM_rdfUpToDateCheck('forum'); // forum rss feeds update
                DB_query("UPDATE {$_TABLES['forum_forums']} SET post_count=post_count-1 WHERE forum_id=$forum");
                // Get the post id for the last post in this topic
                $query = DB_query("SELECT MAX(id) FROM {$_TABLES['forum_topic']} WHERE forum=$forum");
                list($last_topic) = DB_fetchArray($query);
                if ($last_topic > 0) {
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET last_post_rec=$last_topic WHERE forum_id=$forum");
                }
            }

            if ($topicparent == 0) {
                $topicparent = $msgid;
            } else {
                $lsql = DB_query("SELECT MAX(id) FROM {$_TABLES['forum_topic']} WHERE pid=$topicparent");
                list($lastrecid) = DB_fetchArray($lsql);
                if ($lastrecid == NULL) {
                    $topicdatecreated = DB_getItem($_TABLES['forum_topic'], 'date', "id=$topicparent");
                    DB_query("UPDATE {$_TABLES['forum_topic']} SET last_reply_rec=$topicparent, lastupdated='$topicdatecreated' WHERE id=$topicparent");
                } else {
                    $topicdatecreated = DB_getItem($_TABLES['forum_topic'], 'date', "id=$lastrecid");
                    DB_query("UPDATE {$_TABLES['forum_topic']} SET last_reply_rec=$lastrecid, lastupdated='$topicdatecreated' WHERE id=$topicparent");
                }
            }

            // Remove any lastviewed records in the log so that the new updated topic indicator will appear
            DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE topic='$topicparent'");

            if ($top == 'yes') {
                $display = COM_refresh($_CONF['site_url'] . "/forum/index.php?msg=3&amp;forum=$forum");
            } else {
                $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=5&amp;showtopic=$msgpid");
            }
            echo $display;
            exit();
        }
    }

    if ($confirmbanip == '1') {
        if ($submit == $LANG_GF01['CANCEL']) {
            echo COM_refresh("viewtopic.php?showtopic=$fortopicid");
            exit();
        } else {
            DB_query("INSERT INTO {$_TABLES['forum_banned_ip']} (host_ip) VALUES ('$hostip')");
            $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=6&amp;showtopic=$fortopicid");
            echo $display;
            exit();
        }
    }

    if ($confirm_move == '1' AND forum_modPermission($forum,$_USER['uid'],'mod_move') AND $moveid != 0) {
        if ($submit == $LANG_GF01['CANCEL']) {
            echo COM_refresh("viewtopic.php?showtopic=$moveid");
            exit();
        } else {
            $date = time();
            $movetoforum = gf_preparefordb($movetoforum,'text');
            $movetitle = gf_preparefordb($movetitle,'text');
            $newforumid = DB_getItem($_TABLES['forum_forums'],"forum_id","forum_name='$movetoforum'");
            /* Check and see if we are splitting this forum thread */

            if (isset($_POST['splittype'])) {  // - Yes
                $curpostpid = DB_getItem($_TABLES['forum_topic'],"pid","id='$moveid'");
                if ($_POST['splittype'] == 'single') {  // Move only the single post - create a new topic
                    $topicdate = DB_getItem($_TABLES['forum_topic'],"date","id='$moveid'");
                    $sql  = "UPDATE {$_TABLES['forum_topic']} SET forum='$newforumid', pid='0',lastupdated='$topicdate', ";
                    $sql .= "subject='$movetitle', replies = '0' WHERE id='$moveid' ";
                    DB_query($sql);
                    PLG_itemSaved($moveid, 'forum');
                    DB_query("UPDATE {$_TABLES['forum_topic']} SET replies=replies-1 WHERE id='$curpostpid' ");

                    // Update Topic and Post Count for the effected forums
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=topic_count+1, post_count=post_count+1 WHERE forum_id=$newforumid");
                    $topicsQuery = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE forum=$forum AND pid=0");
                    $topic_count = DB_numRows($topicsQuery);
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=$topic_count, post_count=post_count-1 WHERE forum_id=$forum");

                    // Update the Forum and topic indexes
                    gf_updateLastPost($forum,$curpostpid);
                    gf_updateLastPost($newforumid,$moveid);
                } else {
                    $movesql = DB_query("SELECT id,date FROM {$_TABLES['forum_topic']} WHERE pid='$curpostpid' AND id >= '$moveid'");
                    $numreplies = DB_numRows($movesql);
                    $topicparent = 0;
                    while($movetopic = DB_fetchArray($movesql)) {
                        if ($topicparent == 0) {
                            $sql  = "UPDATE {$_TABLES['forum_topic']} SET forum='$newforumid', pid='0',lastupdated='{$movetopic['date']}', ";
                            $sql .= "replies=$numreplies - 1, subject='$movetitle' WHERE id='{$movetopic['id']}'";
                            DB_query($sql);
                            PLG_itemSaved($movetopic['id'], 'forum');
                            $topicparent = $movetopic['id'];
                        } else {
                            $sql  = "UPDATE {$_TABLES['forum_topic']} SET forum='$newforumid', pid='$topicparent', ";
                            $sql .= "subject='$movetitle' WHERE id='{$movetopic['id']}'";
                            DB_query($sql);
                            PLG_itemSaved($movetopic['id'], 'forum');
                            $topicdate = DB_getItem($_TABLES['forum_topic'],"date","id='{$movetopic['id']}'");
                            DB_query("UPDATE {$_TABLES['forum_topic']} SET lastupdated='$topicdate' WHERE id='$topicparent'");
                        }
                    }
                    // Update the Forum and topic indexes
                    gf_updateLastPost($forum,$curpostpid);
                    gf_updateLastPost($newforumid,$topicparent);

                    /* Update the number of replies now in all previous topic post records */
                    DB_query("UPDATE {$_TABLES['forum_topic']} SET replies=replies-$numreplies WHERE id='$curpostpid' ");

                    // Update Topic and Post Count for the effected forums
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=topic_count+1, post_count=post_count+$numreplies WHERE forum_id=$newforumid");
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=topic_count-1, post_count=post_count-$numreplies WHERE forum_id=$forum");
                }
                
                $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=7&amp;showtopic=$moveid");

            } else {  // Move complete topic
                $moveResult = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE pid=$moveid");
                $postCount = DB_numRows($moveResult) +1;  // Need to account for the parent post
                while($movetopic = DB_fetchArray($moveResult)) {
                    DB_query("UPDATE {$_TABLES['forum_topic']} SET forum='$newforumid' WHERE id='{$movetopic['id']}'");
                    PLG_itemSaved($movetopic['id'], 'forum');
                }
                // Update any topic subscription records - need to change the forum ID record
                DB_query("UPDATE {$_TABLES['forum_watch']} SET forum_id = '$newforumid' WHERE topic_id='{$moveid}'");
                DB_query("UPDATE {$_TABLES['forum_topic']} SET forum = '$newforumid', moved = '1' WHERE id=$moveid");
                PLG_itemSaved($moveid, 'forum');

                // Update the Last Post Information
                gf_updateLastPost($newforumid,$moveid);
                gf_updateLastPost($forum);

                // Update Topic and Post Count for the effected forums
                DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=topic_count+1, post_count=post_count+$postCount WHERE forum_id=$newforumid");
                DB_query("UPDATE {$_TABLES['forum_forums']} SET topic_count=topic_count-1, post_count=post_count-$postCount WHERE forum_id=$forum");

                // Remove any lastviewed records in the log so that the new updated topic indicator will appear
                DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE topic='$moveid'");
                
                $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=8&amp;showtopic=$moveid");
            }
            
            COM_rdfUpToDateCheck('forum'); // forum rss feeds update
            
            echo $display;
            exit();

        }
    }

    if ($modfunction == 'deletepost' AND forum_modPermission($forum,$_USER['uid'],'mod_delete') AND $fortopicid != 0) {

        if ($top == 'yes') {
            $alertmessage = $LANG_GF02['msg65'] . "<p>";
        } else {
            $alertmessage = '';
        }
        $subject = DB_getItem($_TABLES['forum_topic'],"subject","id='$msgpid'");
        $alertmessage .= sprintf($LANG_GF02['msg64'],$fortopicid,$subject);
        
		$page = COM_newTemplate(CTL_plugin_templatePath('forum', 'moderator'));
		$page->set_file(array('page'=>'delete.thtml'));
		
		$page->set_var('fortopicid', $fortopicid);
		$page->set_var('forum', $forum);
		$page->set_var('msgpid', $msgpid);
		$page->set_var('top', $top);
		$page->parse('output', 'page');
		$promptform = $page->finish($page->get_var('output'));         
        
        $display .= alertMessage($alertmessage, $LANG_GF02['msg182'], $promptform);
    } elseif ($modfunction == 'editpost' AND forum_modPermission($forum,$_USER['uid'],'mod_edit') AND $fortopicid != 0) {
        echo COM_refresh("createtopic.php?method=edit&amp;id=$fortopicid&amp;page=$page");
        exit();
    } elseif ($modfunction == 'lockedpost' AND forum_modPermission($forum,$_USER['uid'],'mod_edit') AND $fortopicid != 0) {
        echo COM_refresh("createtopic.php?method=postreply&amp;id=$fortopicid");
        exit();
    } elseif ($modfunction == 'movetopic' AND forum_modPermission($forum,$_USER['uid'],'mod_move') AND $fortopicid != 0) {
        $SECgroups = SEC_getUserGroups();  // Returns an Associative Array - need to parse out the group id's
        $modgroups = '';
        foreach ($SECgroups as $key) {
          if ($modgroups == '') {
             $modgroups = $key;
          } else {
              $modgroups .= ",$key";
          }
        }
        /* Check and see if user had moderation rights to another forum to complete the topic move */
        $sql = "SELECT DISTINCT forum_name FROM {$_TABLES['forum_moderators']} a , {$_TABLES['forum_forums']} b ";
        $sql .= "WHERE a.mod_forum = b.forum_id AND ( a.mod_uid='{$_USER['uid']}' OR a.mod_groupid IN ($modgroups))";
        $query = DB_query($sql);

        if (DB_numRows($query) == 0) {
            $display .= alertMessage($LANG_GF02['msg181'],$LANG_GF01['WARNING']);
        } else {
			$page = COM_newTemplate(CTL_plugin_templatePath('forum', 'moderator'));
			$page->set_file(array('page'=>'split_move.thtml'));
			
			$page->set_block('page', 'split_topic');
        	
            $topictitle = DB_getItem($_TABLES['forum_topic'],"subject","id='$fortopicid'");
            $page->set_var('fortopicid', $fortopicid);
            $page->set_var('forum', $forum);
            $page->set_var('topictitle', $topictitle);
            
            while($showforums = DB_fetchArray($query)){
                $promptform  .= "<option>$showforums[forum_name]";
            }
            $page->set_var('forumoptions', $promptform);

            /* Check and see request to move complete topic or split the topic */
            if (DB_getItem($_TABLES['forum_topic'],"pid","id='$fortopicid'") == 0) {
                $page->parse('split_topic', '');
                
				$page->parse('output', 'page');
				$promptform = $page->finish($page->get_var('output'));                
                
                $alertmessage = sprintf($LANG_GF03['movetopicmsg'],$topictitle);
                $display .= alertMessage($alertmessage, $LANG_GF02['msg182'], $promptform);
            } else {
                $poster   = DB_getItem($_TABLES['forum_topic'],"name","id='$fortopicid'");
                $postdate = COM_getUserDateTimeFormat(DB_getItem($_TABLES['forum_topic'],"date","id='$fortopicid'"));
                $page->parse('split_topic', 'split_topic');
				$page->parse('output', 'page');
				$promptform = $page->finish($page->get_var('output')); 
                
                $alertmessage = sprintf($LANG_GF03['splittopicmsg'],$topictitle,$poster,$postdate[0]);
                $display .= alertMessage($alertmessage,$LANG_GF02['msg182'],$promptform);
            }
        }

	} elseif ($modfunction == 'banip' AND forum_modPermission($forum,$_USER['uid'],'mod_ban') AND $fortopicid != 0 AND (function_exists('BAN_for_plugins_check_access') AND BAN_for_plugins_check_access())) {
        $iptobansql = DB_query("SELECT ip FROM {$_TABLES['forum_topic']} WHERE id='$fortopicid'");
        $forumpostipnum = DB_fetchArray($iptobansql);
        if ($forumpostipnum['ip'] == '') {
            $display .= alertMessage($LANG_GF02['msg174']);
            exit;
        }
        
        $ip_address = $forumpostipnum['ip'];
        
        if (BAN_for_plugins_ban_found($ip_address)) {
			BAN_for_plugins_ban_ip($ip_address, 'forum', false);
			$display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=11&amp;showtopic=$msgpid");
		} else {
			BAN_for_plugins_ban_ip($ip_address, 'forum');
			$display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=10&amp;showtopic=$msgpid");
		}
		COM_output($display);
		exit;
    } elseif ($modfunction == 'banippost' AND forum_modPermission($forum,$_USER['uid'],'mod_ban') AND $fortopicid != 0) {
        $iptobansql = DB_query("SELECT ip FROM {$_TABLES['forum_topic']} WHERE id='$fortopicid'");
        $forumpostipnum = DB_fetchArray($iptobansql);
        if ($forumpostipnum['ip'] == '') {
            $display .= alertMessage($LANG_GF02['msg174']);
            exit;
        }
        $alertmessage =  $LANG_GF02['msg68'];
        $ip_address = $forumpostipnum['ip'];
        if (!empty($_CONF['ip_lookup'])) {
            $iplookup = str_replace('*', $ip_address, $_CONF['ip_lookup']);
            $ip_address = COM_createLink($ip_address, $iplookup);
        }
        $alertmessage .= sprintf($LANG_GF02['msg69'], $ip_address);
        
		$page = COM_newTemplate(CTL_plugin_templatePath('forum', 'moderator'));
		$page->set_file(array('page'=>'ban.thtml'));
		
		$page->set_var('hostip', $forumpostipnum['ip']);
		$page->set_var('forum', $forum);
		$page->set_var('fortopicid', $fortopicid);
 
		$page->parse('output', 'page');
		$promptform = $page->finish($page->get_var('output'));     
 
        $display .= alertMessage($alertmessage, $LANG_GF02['msg182'], $promptform);

    } else {
        $display .= alertMessage($LANG_GF02['msg71'], $LANG_GF01['WARNING']);
    }

} else {
    $display .= alertMessage($LANG_GF02['msg72'], $LANG_GF01['ACCESSERROR']);
}

$display = gf_createHTMLDocument($display);

COM_output($display);
?>
