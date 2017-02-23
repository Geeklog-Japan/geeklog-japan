<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | notify.php                                                                |
// | View users curent monitored topics                                        |
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
    COM_handle404();
    exit;
}

require_once $CONF_FORUM['path_include'] . 'gf_format.php';

// Pass thru filter any get or post variables to only allow numeric values and remove any hostile data
$forum      = isset($_REQUEST['forum'])  ? COM_applyFilter($_REQUEST['forum'],true) : '';
$id         = isset($_REQUEST['id'])     ? COM_applyFilter($_REQUEST['id'],true)    : '';
$msg        = isset($_GET['msg'])        ? COM_applyFilter($_GET['msg'], true)      : '';
$notifytype = isset($_REQUEST['filter']) ? COM_applyFilter($_REQUEST['filter'])     : '';
$op         = isset($_REQUEST['op'])     ? COM_applyFilter($_REQUEST['op'])         : '';
$page       = isset($_GET['page'])       ? COM_applyFilter($_GET['page'],true)      : '';
$show       = isset($_GET['show'])       ? COM_applyFilter($_GET['show'],true)      : '';
$topic      = isset($_REQUEST['topic'])  ? COM_applyFilter($_REQUEST['topic'],true) : '';

//Check is anonymous users can access - and need to be signed in
forum_chkUsercanAccess(true);

$display = '';

// Debug Code to show variables
$display .= gf_showVariables();

// Display warning if no email found (usually happens with user oauth accounts)
if (($_USER['email'] == '')  OR !COM_isEmail($_USER['email'])) {
    $display .= alertMessage($LANG_GF02['msg145'], $LANG_GF01['WARNING'], false);
}

if ($msg==1) {
    $display .= COM_showMessageText($LANG_GF02['msg146']);
}

// NOTIFY CODE -> SAVE
if (isset($_REQUEST['submit'])) {
	if (($_REQUEST['submit'] == 'save') && ($id != 0)) {
	    $sql = "SELECT * FROM {$_TABLES['forum_watch']} WHERE ((topic_id='$id') AND (uid='{$_USER['uid']}') OR ";
	    $sql .= "((forum_id='$forum') AND (topic_id='0') AND (uid='{$_USER['uid']}')))";
	    $notifyquery = DB_query("$sql");
	    $pid = DB_getItem($_TABLES['forum_topic'],'pid',"id='$id'");
	    if ($pid == 0) {
	        $pid = $id;
	    }
	    if (DB_numRows($notifyquery) > 0 ) {
	        $A = DB_fetchArray($notifyquery);
	        if ($A['topic_id'] == 0) {     // User has subscribed to complete forum
	           // Check and see if user has a non-subscribe record for this topic id
	            $query = DB_query("SELECT id FROM {$_TABLES['forum_watch']} WHERE uid='{$_USER['uid']}' AND forum_id='$forum' AND topic_id < '0' " );
	            if (DB_numRows($query) > 0) {
	                list($watchrec) = DB_fetchArray($query);
	                DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE id=$watchrec");
	            }  else {
	                DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$pid','{$_USER['uid']}',now() )");
	            }
                if (($_USER['email'] != '')  AND COM_isEmail($_USER['email'])) {
                    $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=2&amp;showtopic=$id");
                } else {
                    // Invalid or no email address remind user to add one
                    $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=12&amp;showtopic=$id");
                }
	        } else {
	            $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=3&amp;showtopic=$id");
	        }
	    } else {
	        DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$pid','{$_USER['uid']}',now() )");
	        $nid = -$id;
	        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='{$_USER['uid']}' AND forum_id='$forum' AND topic_id = '$nid'");          
            if (($_USER['email'] != '')  AND COM_isEmail($_USER['email'])) {
                $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=2&amp;showtopic=$id");
            } else {
                // Invalid or no email address remind user to add one
                $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=12&amp;showtopic=$id");
            }
	    }
	    COM_output($display);
	    exit();

	} elseif (($_REQUEST['submit'] == 'delete') AND ($id != 0))  {
	    DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE (id='$id')");
	    $display = COM_refresh($_CONF['site_url'] . "/forum/notify.php?msg=1&amp;filter=$notifytype");
	    COM_output($display);
	    exit();

	} elseif (($_REQUEST['submit'] == 'delete2') AND ($id != ''))  {
	    // Check and see if subscribed to complete forum and if so - unsubscribe to just this topic
	    if (DB_getItem($_TABLES['forum_watch'], 'topic_id', "id='$id'") == 0 ) {
	        $ntopic = -$topic;  // Negative Value
	        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='{$_USER['uid']}' AND forum_id='$forum' AND topic_id = '$topic'");
	        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='{$_USER['uid']}' AND forum_id='$forum' AND topic_id = '$ntopic'");
	        DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$ntopic','{$_USER['uid']}',now() )");
	    } else {
	        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE (id='$id')");
	    }
	    $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=4&amp;showtopic=$topic");
	    COM_output($display);
	    exit();
	}
}

// NOTIFY MAIN
// Page Navigation Logic
if ($show == 0) {
    $show = $CONF_FORUM['show_messages_perpage'];
}
// Check if this is the first page.
if ($page == 0) {
     $page = 1;
}

/* Check to see if user has checked multiple records to delete */
if ($op == 'delchecked' && isset($_POST['chk_record_delete'])) {
    foreach ($_POST['chk_record_delete'] as $id) {
        $id = COM_applyFilter($id);
        if (DB_getItem($_TABLES['forum_watch'],'uid',"id='$id'") == $_USER['uid']) {
            DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE id='$id'");
        }
    }
}

$report = COM_newTemplate(CTL_plugin_templatePath('forum'));
$report->set_file (array (
                  'report'         => 'reports/notifications.thtml',
                  'forum_links'    => 'forum_links.thtml' ));

$report->set_block('report', 'notification_record');
$report->set_block('report', 'no_records_message');
$report->set_block('report', 'links');
$report->set_block('forum_links', 'trash_link');
$report->set_block('forum_links', 'return_link');

$report->set_var ('imgset', $CONF_FORUM['imgset']);
$report->set_var ('layout_url', $CONF_FORUM['layout_url']);
$report->set_var ('LANG_TITLE', $LANG_GF02['msg89']);
$report->set_var ('select_forum', f_forumjump($_CONF['site_url'].'/forum/notify.php',$forum));

$filteroptions = '';
for ($i = 1; $i <= 3; $i++) {
    if ($notifytype == $i) {
        $filteroptions .= '<option value="'.$i.'" SELECTED>'.$LANG_GF08[$i].'</option>';
    } else {
        $filteroptions .= '<option value="'.$i.'">'.$LANG_GF08[$i].'</option>';
    }
}

$report->set_var ('filter_options', $filteroptions);
//$report->set_var ('LANG_Heading1', $LANG_GF01['ID']);
$report->set_var ('LANG_Heading2', $LANG_GF01['FORUM']);
$report->set_var ('LANG_Heading3', $LANG_GF01['SUBJECT']);
$report->set_var ('LANG_Heading4', $LANG_GF01['DATEADDED']);
$report->set_var ('LANG_Heading5', $LANG_GF01['STARTEDBY']);
$report->set_var ('LANG_Heading6', $LANG_GF01['VIEWS']);
$report->set_var ('LANG_Heading7', $LANG_GF01['REPLIES']);
$report->set_var ('LANG_Heading8', $LANG_GF01['REMOVE']);

$report->set_var ('LANG_deleteall', $LANG_GF01['DELETEALL']);
$report->set_var ('LANG_DELALLCONFIRM', $LANG_GF01['DELALLCONFIRM']);
$report->parse ('trash_link', 'trash_link');

$report->set_var ('notifytype', $notifytype);   
if ($CONF_FORUM['usermenu'] == 'navbar') {
    $report->set_var('navmenu', forumNavbarMenu($LANG_GF01['SUBSCRIPTIONS']));
} else {
    $report->set_var('navmenu','');
}

$sql = "SELECT id,forum_id,topic_id,date_added FROM {$_TABLES['forum_watch']} WHERE (uid='{$_USER['uid']}')";
if ($forum > 0 ) {
    $sql .= " AND forum_id='$forum'";   
}
if ($notifytype == '2') {
    $sql .= " AND topic_id = '0'";
} elseif ($notifytype == '3') {
    $sql .= " AND topic_id < '0'";
} else {
    $sql .= " AND topic_id > '0'";
}

$sql .= " ORDER BY forum_id ASC, date_added DESC";
$notifications = DB_query($sql);
$nrows = DB_numRows($notifications);
$numpages = ceil($nrows / $show);
$offset = ($page - 1) * $show;
$base_url = $_CONF['site_url'] . "/forum/notify.php?filter={$notifytype}&amp;forum=$forum&amp;show={$show}";

$sql .= " LIMIT $offset, $show";
$notifications = DB_query($sql);

$i = 0;
while (list($notify_recid,$forum_id,$topic_id,$date_added) = DB_fetchArray($notifications)) {
    $forum_name = DB_getItem($_TABLES['forum_forums'],"forum_name","forum_id='$forum_id'");
    $is_forum = '';
    if ($topic_id == '0') {
        $subject = '';
        $is_forum = $LANG_GF02['msg138'];
        $topic_link = '<a href="' .$_CONF['site_url']. '/forum/index.php?forum=' .$forum_id. '" title="' .$subject. '">' .$subject. '</a>';
    } else {
        if ($topic_id < 0) {
            $neg_subscription = true;
            $topic_id = -$topic_id;
        } else {
            $neg_subscription = false;
        }
        $result = DB_query("SELECT subject,name,replies,views,uid,id FROM {$_TABLES['forum_topic']} WHERE id = '$topic_id'");
        $A = DB_fetchArray($result);
        if ($A['subject'] == '') {
            $subject = $LANG_GF01['MISSINGSUBJECT'];
        } elseif (strlen($A['subject']) > 50) {
            $subject = htmlspecialchars(COM_truncate($A['subject'], 50, '...'), ENT_QUOTES, $CONF_FORUM['charset']);
        } else {
            $subject = htmlspecialchars($A['subject'], ENT_QUOTES, $CONF_FORUM['charset']);
        }
        $topic_link = '<a href="' .$_CONF['site_url']. '/forum/viewtopic.php?showtopic=' .$topic_id. '" title="';
        $topic_link .= $subject. '">' .$subject. '</a>';

    }

    $report->set_var ('id', $notify_recid);
    $report->set_var ('csscode', $i%2+1);
    $report->set_var ('forum', $forum_name);
    $report->set_var ('linksubject', htmlspecialchars($subject,ENT_QUOTES,$CONF_FORUM['charset']));
    $report->set_var ('is_forum', $is_forum);
    $report->set_var ('topic_link', $topic_link);
    $report->set_var ('topicauthor', $A['name']);
    $report->set_var ('date_added', $date_added);
    $report->set_var ('uid', $A['uid']);
    $report->set_var ('views', $A['views']);
    $report->set_var ('replies', $A['replies']);
    $report->set_var ('topic_id', $topic_id);
    $report->set_var ('notify_id', $notify_recid);
    $report->set_var ('LANG_REMOVE', $LANG_GF01['REMOVE']);
    $report->parse ('notification_record', 'notification_record',true);
    $i++;
}

if ($nrows == 0) {
    $report->set_var ('message',$LANG_GF02['msg44']);
    $report->parse ('no_records_message', 'no_records_message');
} else {
    $report->set_var ('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));
    if ($forum > 0) {
    	$report->set_var ('LANG_return', $LANG_GF02['msg144']);
        $report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php?forum=$forum");
    } else {
    	$report->set_var ('LANG_return', $LANG_GF02['msg175']);
        $report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php");
    }
    $report->parse ('return_link', 'return_link');
    $report->parse ('links', 'links');
}
$report->parse ('output', 'report');
$display .= $report->finish ($report->get_var('output'));
$display = gf_createHTMLDocument($display);

COM_output($display);
?>
