<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | createtopic.php                                                           |
// | Main program to create topics and posts in the forum                      |
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

require_once $CONF_FORUM['path_include'] . 'gf_showtopic.php';
require_once $CONF_FORUM['path_include'] . 'gf_format.php';

$display = '';


// Check if anonymouse users can access
if ($CONF_FORUM['registered_to_post'] && COM_isAnonUser()) {
	forum_chkUsercanAccess(true);
}

// Check if IP of user has been banned
$ip = getenv("REMOTE_ADDR");
$sqlresult = DB_query ("SELECT * FROM {$_TABLES['forum_banned_ip']} WHERE host_ip like '$ip'");
$numRows = DB_numRows($sqlresult);
if ($numRows > 0) {
    $display .= alertMessage(sprintf($LANG_GF02['msg14'], $_CONF['site_mail']), $LANG_GF00['access_denied']);
    
    $display = COM_createHTMLDocument($display);
    COM_output($display);
    exit();
}

// Pass thru filter any get or post variables to only allow numeric values and remove any hostile data
$aname       = isset($_POST['aname'])              ? strip_tags($_POST['aname'])                        : '';
$editid      = isset($_POST['editid'])             ? COM_applyFilter($_POST['editid'],true)             : '';
$editpid     = isset($_POST['editpid'])            ? COM_applyFilter($_POST['editpid'],true)            : '';
$editpost    = isset($_POST['editpost'])           ? COM_applyFilter($_POST['editpost'])                : '';
$forum       = isset($_REQUEST['forum'])           ? COM_applyFilter($_REQUEST['forum'],true)           : '';
$id          = isset($_REQUEST['id'])              ? COM_applyFilter($_REQUEST['id'],true)              : '';
$method      = isset($_REQUEST['method'])          ? COM_applyFilter($_REQUEST['method'])               : '';
$mode_switch = isset($_REQUEST['postmode_switch']) ? COM_applyFilter($_REQUEST['postmode_switch'],true) : '';
$mood        = isset($_POST['mood'])               ? COM_applyFilter($_POST['mood'])                    : '';
$notify      = isset($_POST['notify'])             ? COM_applyFilter($_POST['notify'])                  : '';
$page        = isset($_REQUEST['page'])            ? COM_applyFilter($_REQUEST['page'],true)            : '';
$preview     = isset($_REQUEST['preview'])         ? COM_applyFilter($_REQUEST['preview'])              : '';
$quoteid     = isset($_REQUEST['quoteid'])         ? COM_applyFilter($_REQUEST['quoteid'],true)         : '';
$showtopic   = isset($_REQUEST['showtopic'])       ? COM_applyFilter($_REQUEST['showtopic'],true)       : '';
$silentedit  = isset($_POST['silentedit'])         ? COM_applyFilter($_POST['silentedit'],true)         : '';
$subject     = isset($_POST['subject'])            ? COM_applyFilter($_POST['subject'])                 : '';
$submit      = isset($_POST['submit'])             ? COM_applyFilter($_POST['submit'])                  : '';
$postmode    = isset($_POST['postmode'])           ? COM_applyFilter($_POST['postmode'])                : '';

if ($preview == $LANG_GF01['PREVIEW']) {
    $preview = 'Preview';
}

// Debug Code to show variables
$display .= gf_showVariables();

ForumHeader($forum, $showtopic, $display);

if (empty($_USER['uid']) OR $_USER['uid'] == 1 ) {
    $uid = 1;
} else {
    $uid = $_USER['uid'];
}

// CHECK TO SEE IF CANCELED
if ($submit == $LANG_GF01['CANCEL']) {
	if (!empty($id)) {
		// Cancel Reply
		$display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=9&amp;showtopic=$id");
	} elseif (!empty($forum)) {
		// Cancel New Topic
		$display = COM_refresh($_CONF['site_url'] . "/forum/index.php?msg=9&amp;forum=$forum");
	} else {
		// Something wrong so just go back
		$display = COM_refresh($_CONF['site_url'] . "/forum/index.php?msg=9");
	}
	
	COM_output($display);
	exit;	
}

// ADD EDITED TOPIC
if (($submit == $LANG_GF01['SUBMIT']) && ($editpost == 'yes') && SEC_checkToken()) {
    $date = time();

    $editAllowed = false;
    if (forum_modPermission($forum,$_USER['uid'],'mod_edit')) {
        $editAllowed = true;
    } else {
        if ($CONF_FORUM['allowed_editwindow'] > 0) {
            $t1 = DB_getItem($_TABLES['forum_topic'],'date',"id='$id'");
            $t2 = $CONF_FORUM['allowed_editwindow'];
            $time = time();
            if ((time() - $t2) < $t1) {
                $editAllowed = true;
            }
        } else {
            $editAllowed = true;
        }
    }

    if (($editpid < 1) && (trim($_POST['subject']) == '')) {
		$display .= alertMessage($LANG_GF02['msg18'], '');
    } elseif (!$editAllowed) {
        $link = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$id}";
        $display .= alertMessage('',$LANG_GF02['msg189'], sprintf($LANG_GF02['msg187'],$link));
    } else {
        if (strlen(trim($_POST['name'])) > $CONF_FORUM['min_username_length'] && strlen(trim($_POST['comment'])) > $CONF_FORUM['min_comment_length']) {
            if ($CONF_FORUM['use_spamx_filter'] == 1) {
                // Check for SPAM
                $spamcheck = '<h1>' . $_POST['subject'] . '</h1><p>' . $_POST['comment'] . '</p>';
                $result = PLG_checkforSpam($spamcheck, $_CONF['spamx']);
                // Now check the result and redirect to index.php if spam action was taken
                if ($result > 0) {
                    // then tell them to get lost ...
                    $display .= COM_showMessage( $result, 'spamx' );
                    $display = gf_createHTMLDocument($display);
                    COM_output($display);
                    exit;
                }
            }

            $postmode = gf_chkpostmode($postmode,$mode_switch);
            $subject  = gf_preparefordb(strip_tags($_POST['subject']),'text');
            $comment  = gf_preparefordb($_POST['comment'],$postmode);

            // If user has moderator edit rights only
            $locked = 0;
            $sticky = 0;
            if ($_POST['modedit'] == 1) {
                if (isset($_POST['locked_switch']) AND $_POST['locked_switch'] == 1)  $locked = 1;
                if (isset($_POST['sticky_switch']) AND $_POST['sticky_switch'] == 1)  $sticky = 1;
            }
            $sql = "UPDATE {$_TABLES['forum_topic']} SET subject='$subject',comment='$comment',postmode='$postmode', ";
            $sql .= "mood='$mood', sticky='$sticky', locked='$locked' WHERE (id='$editid')";
            DB_query($sql);
            // PLG_itemSaved($editid, 'forum'); // done below so commented out

            $topicparent = DB_getItem($_TABLES['forum_topic'],"pid","id='$editid'");
            if ($topicparent == 0) {
                $topicparent = $editid;
            }

            //NOTIFY - Checkbox variable in form set to "on" when checked and they have not already subscribed to forum
            $notifyRecID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forum' AND topic_id='$topicparent' AND uid='$uid'");
            if ($notify == 1 AND $notifyRecID < 1) {
                DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$topicparent','{$_USER['uid']}',now() )");
            } elseif ($notify == '' AND $notifyRecID > 1) {
                DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE id=$notifyRecID");
            }

            // if user has un-checked the Silent option then they want to have user alerted of the edit and update the topic timestamp
            if ($silentedit != 1) {
                DB_query("UPDATE {$_TABLES['forum_topic']} SET lastupdated = $date WHERE id=$topicparent");
                //Remove any lastviewed records in the log so that the new updated topic indicator will appear
                DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE topic='$topicparent' and time > 0");
                // Check for any users subscribed notifications
                gf_chknotifications($forum,$editid,$uid);
            }

            PLG_itemSaved($editid, 'forum');
            COM_rdfUpToDateCheck('forum'); // forum rss feeds update

            $link = $_CONF['site_url'] . "/forum/viewtopic.php?msg=1&amp;showtopic=$topicparent&amp;page=$page#$editid";
            $display = COM_refresh($link);
            COM_output($display);
            exit;

        } else {
            $display .= alertMessage($LANG_GF01['msg18'], $LANG_GF02['msg180']);
        }
    }

    $display = gf_createHTMLDocument($display);
    COM_output($display);
    exit;
}

// ADD TOPIC
if (($submit == $LANG_GF01['SUBMIT']) && (($uid == 1) || SEC_checkToken())) {
    $msg = '';
    $date = time();
    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];

    if ($method == 'newtopic') {
        if ($aname != '') {
            $name = gf_preparefordb($aname,'text');
        } else {
            $name = gf_preparefordb($_POST['name'],'text');
        }

        if ( function_exists('plugin_itemPreSave_captcha') || function_exists('plugin_itemPreSave_recaptcha') ) {
            if ( function_exists('plugin_itemPreSave_captcha') ) {
                $msg = plugin_itemPreSave_captcha('forum',$_POST['captcha']);
            } else {
                $msg = plugin_itemPreSave_recaptcha('forum',$_POST['captcha']);
            }
            if ( $msg != '' ) {
                $preview = 'Preview';
                $subject = COM_stripslashes($_POST['subject']);
                $display .= COM_startBlock ($LANG03[17], '',
                              COM_getBlockTemplate ('_msg_block', 'header'))
                         . $msg
                         . COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
            }
        }
        if ( $msg == '' ) {
            if (strlen(trim($name)) > $CONF_FORUM['min_username_length'] AND
                strlen(trim($_POST['subject'])) > $CONF_FORUM['min_subject_length'] AND
                strlen(trim($_POST['comment'])) > $CONF_FORUM['min_comment_length']) {

                COM_clearSpeedlimit ($CONF_FORUM['post_speedlimit'], 'forum');
                $last = COM_checkSpeedlimit ('forum');
                if ($last > 0) {
                    $message = sprintf($LANG_GF01['SPEEDLIMIT'],$last,$CONF_FORUM['post_speedlimit']);
                    $display .= alertMessage($message, $LANG_GF02['msg180']);

                } else {
                    if ( $CONF_FORUM['use_spamx_filter'] == 1 ) {
                        // Check for SPAM
                        $spamcheck = '<h1>' . $_POST['subject'] . '</h1><p>' . $_POST['comment'] . '</p>';
                        $result = PLG_checkforSpam($spamcheck, $_CONF['spamx']);
                        // Now check the result and redirect to index.php if spam action was taken
                        if ($result > 0) {
                            // then tell them to get lost ...
                            $display .= COM_showMessage( $result, 'spamx' );
                            $display = gf_createHTMLDocument($display);
                            COM_output($display);
                            exit;
                        }
                    }
                    $postmode = gf_chkpostmode($postmode,$mode_switch);
                    $subject = gf_preparefordb(strip_tags($_POST['subject']),'text');

                    if ( strlen ( $subject ) > 100 ) {
                        $subject = COM_truncate($subject, 99, '...');
                    }
                    $comment = gf_preparefordb($_POST['comment'],$postmode);
                    $locked = 0;
                    $sticky = 0;
                    if ($_POST['modedit'] == 1) {
                        if ($_POST['locked_switch'] == 1)  $locked = 1;
                        if ($_POST['sticky_switch'] == 1)  $sticky = 1;
                    }

                    $fields = "forum,name,date,lastupdated,subject,comment,postmode,ip,mood,uid,pid,sticky,locked";
                    $sql  = "INSERT INTO {$_TABLES['forum_topic']} ($fields) ";
                    $sql .= "VALUES ('$forum','$name','$date',$date,'$subject','$comment', ";
                    $sql .= "'$postmode','$REMOTE_ADDR','$mood','$uid','0','$sticky','$locked')";
                    DB_query($sql);

                    // Find the id of the last inserted topic
                    list ($lastid) = DB_fetchArray(DB_query("SELECT max(id) FROM {$_TABLES['forum_topic']} "));

                    PLG_itemSaved($lastid, 'forum');
                    COM_rdfUpToDateCheck('forum'); // forum rss feeds update

                    // Update forums record
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET post_count=post_count+1, topic_count=topic_count+1, last_post_rec=$lastid WHERE forum_id=$forum");

                    // Check for any users subscribed notifications - would only be for users subscribed to the forum
                    gf_chknotifications($forum,$lastid,$uid,"forum");
                    //NOTIFY - Checkbox variable in form set to "on" when checked and they have not already subscribed to forum
                    $currentNotifyRecID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forum' AND topic_id=0 AND uid='$uid'");
                    if ($notify == 1 AND $currentNotifyRecID < 1) {
                        DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$lastid','{$_USER['uid']}',now() )");
                    } elseif ($notify == '' AND $currentNotifyRecID > 1) { // Subscribed to forum - but does not want to be notified about this topic
                        $nlastid = -$lastid;  // Negative Value
                        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='$uid' AND forum_id='$forum' and topic_id = '$lastid'");
                        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='$uid' AND forum_id='$forum' and topic_id = '$nlastid'");
                        DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$nlastid','$uid',now() )");
                    }

                    COM_updateSpeedlimit ('forum');

                    // Insert a new log record for all logged in users that posted so it does not appear as new
                    if ($uid != '1') {
                        DB_query("INSERT INTO {$_TABLES['forum_log']} (uid,forum,topic,time) VALUES ('{$_USER['uid']}','$forum','$lastid','$date')");
                    }
                    $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=1&amp;showtopic=$lastid");
                    COM_output($display);
                    exit;
                }

            } else {
                $display .= alertMessage($LANG_GF02['msg18'], $LANG_GF02['msg180']);
            }
        }
// END OF A NEW TOPIC...
     } elseif ($method == 'postreply') {
        if ( function_exists('plugin_itemPreSave_captcha') || function_exists('plugin_itemPreSave_recaptcha') ) {
            if ( function_exists('plugin_itemPreSave_captcha') ) {
                $msg = plugin_itemPreSave_captcha('forum',$_POST['captcha']);
            } else {
                $msg = plugin_itemPreSave_recaptcha('forum',$_POST['captcha']);
            }
            if ( $msg != '' ) {
                $preview = 'Preview';
                $subject = COM_stripslashes($_POST['subject']);
                $display .= COM_startBlock ($LANG03[17], '',
                              COM_getBlockTemplate ('_msg_block', 'header'))
                         . $msg
                         . COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
            }
        }

        if ( $msg == '' ) {
            //Add Reply
            if ($aname != '') {
                $name = gf_preparefordb($aname,'text');
            } else {
                $name = gf_preparefordb($_POST['name'],'text');
            }
            if ($name != '' && strlen(trim($_POST['comment'])) > $CONF_FORUM['min_comment_length']) {

                COM_clearSpeedlimit ($CONF_FORUM['post_speedlimit'], 'forum');
                $last = COM_checkSpeedlimit ('forum');
                if ($last > 0) {
                    $message = sprintf($LANG_GF01['SPEEDLIMIT'],$last,$CONF_FORUM['post_speedlimit']);
                    $display .= alertMessage($message, $LANG_GF02['msg180']);

                } else {
                    if ( $CONF_FORUM['use_spamx_filter'] == 1 ) {
                        // Check for SPAM
                        $spamcheck = '<h1>' . $_POST['subject'] . '</h1><p>' . $_POST['comment'] . '</p>';
                        $result = PLG_checkforSpam($spamcheck, $_CONF['spamx']);
                        // Now check the result and redirect to index.php if spam action was taken
                        if ($result > 0) {
                            // then tell them to get lost ...
                            $display .= COM_showMessage( $result, 'spamx' );
                            $display = gf_createHTMLDocument($display);
                            COM_output($display);
                            exit;
                        }
                    }
                    DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE topic='$id' and time > 0");

                    // Check for any users subscribed notifications
                    gf_chknotifications($forum,$id,$uid);
                    $postmode = gf_chkpostmode($postmode,$mode_switch);
                    $subject = gf_preparefordb($_POST['subject'],'text');
                    $comment = gf_preparefordb($_POST['comment'],$postmode);

                    $fields = "name,date,subject,comment,postmode,ip,mood,uid,pid,forum";
                    $sql  = "INSERT INTO {$_TABLES['forum_topic']} ($fields) ";
                    $sql .= "VALUES  ('$name','$date','$subject','$comment',";
                    $sql .= "'$postmode','$REMOTE_ADDR','$mood','$uid','$id','$forum')";
                    DB_query($sql);

                    // Find the id of the last inserted topic
                    list ($lastid) = DB_fetchArray(DB_query("SELECT max(id) FROM {$_TABLES['forum_topic']} "));

                    PLG_itemSaved($lastid, 'forum');
                    COM_rdfUpToDateCheck('forum'); // forum rss feeds update

                    DB_query("UPDATE {$_TABLES['forum_topic']} SET replies=replies + 1, lastupdated = $date,last_reply_rec=$lastid WHERE id=$id");
                    DB_query("UPDATE {$_TABLES['forum_forums']} SET post_count=post_count+1, last_post_rec=$lastid WHERE forum_id=$forum");

                    //NOTIFY - Checkbox variable in form set to "on" when checked and they don't already have subscribed to forum or topic
                    $nid = -$id;  // Negative Topic ID Value
                
                    $currentForumNotifyRecID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forum' AND topic_id=0 AND uid='$uid'");
                    $currentTopicNotifyRecID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forum' AND topic_id=$id AND uid='$uid'");
                    $currentTopicUnNotifyRecID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forum' AND topic_id=$nid AND uid='$uid'");
                    if ($notify == 1 AND $currentForumNotifyRecID < 1) {
                        $sql = "INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) ";
                        $sql .= "VALUES ('$forum','$id','$_USER[uid]',now() )";
                        DB_query($sql);
                    } elseif ($notify == 1 AND $currentTopicUnNotifyRecID > 1) { // Had un-subcribed to topic and now wants to subscribe
                        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE id=$currentTopicUnNotifyRecID");
                    } elseif ($notify == '' AND $currentTopicNotifyRecID > 1) { // Subscribed to topic - but does not want to be notified anymore
                        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='$uid' AND forum_id='$forum' and topic_id = '$id'");
                    } elseif ($notify == '' AND $currentForumNotifyRecID > 1) { // Subscribed to forum - but does not want to be notified about this topic
                        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='$uid' AND forum_id='$forum' and topic_id = '$id'");
                        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='$uid' AND forum_id='$forum' and topic_id = '$nid'");
                        DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','$nid','$uid',now() )");
                    }
                    COM_updateSpeedlimit ('forum');
                    $display = COM_refresh($_CONF['site_url'] . "/forum/viewtopic.php?msg=1&amp;showtopic=$id&amp;lastpost=true#$lastid");
                    COM_output($display);
                    exit;

                }

            } else {
                $display .= alertMessage($LANG_GF02['msg18'], $LANG_GF02['msg180']);
            }
        }
    }

    if ( $msg == '' ) {
        $display = gf_createHTMLDocument($display);
        COM_output($display);
        exit;
    }
}


// EDIT MESSAGE
$comment = isset($_POST['comment']) ? COM_stripslashes( $_POST['comment'] ) : '';

if ($id > 0) {
    $sql  = "SELECT a.forum,a.pid,a.comment,a.date,a.locked,a.subject,a.mood,a.sticky,a.uid,a.name,a.postmode,b.forum_cat,b.forum_name,b.is_readonly,c.cat_name,c.id ";
    $sql .= "FROM {$_TABLES['forum_topic']} a ";
    $sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON b.forum_id=a.forum ";
    $sql .= "LEFT JOIN {$_TABLES['forum_categories']} c ON c.id=b.forum_cat ";
    $sql .= "WHERE a.id=$id";
    $edittopic = DB_fetchArray(DB_query($sql),false);
} else {
    if (empty($forum)) {
        $display .= alertMessage('', $LANG_GF02['msg171']);
        $display = gf_createHTMLDocument($display);
        COM_output($display);
        exit;
    }
    $sql  = "SELECT a.forum_name,a.is_readonly,b.cat_name,b.id ";
    $sql .= "FROM {$_TABLES['forum_forums']} a ";
    $sql .= "LEFT JOIN {$_TABLES['forum_categories']} b ON b.id=a.forum_cat ";
    $sql .= "WHERE a.forum_id=$forum";
    $newtopic = DB_fetchArray(DB_query($sql),false);
}

if ($method == 'edit') {
    $editAllowed = false;
    if (forum_modPermission($edittopic['forum'],$_USER['uid'],'mod_edit')) {
        $editAllowed = true;
        $display .= '<input type="hidden" name="modedit" value="1"' . XHTML . '>';
    } else {
        // User is trying to edit their topic post - this is allowed
        if ($edittopic['date'] > 0 AND $edittopic['uid'] == $_USER['uid']) {
            if ($CONF_FORUM['allowed_editwindow'] > 0) {   // Check if edit timeframe is still valid
                $t2 = $CONF_FORUM['allowed_editwindow'];
                $time = time();
                if ((time() - $t2) < $edittopic['date']) {
                    $editAllowed = true;
                }
            } else {
                $editAllowed = true;
            }
        }
    }
    // Moderator or logged-in User is editing their topic post
    if (!COM_isAnonUser() AND $editAllowed) {
        // Check to see if user has this topic or complete forum is selected for notifications
        $fields1 = array( 'topic_id','uid' );
        $values1 = array( $id,$edittopic['uid'] );
        $fields2 = array( 'topic_id','forum_id','uid' );
        $values2 = array( 0,$edittopic['forum'],$edittopic['uid']);
        // Check if there are any notification records for the topic or the forum - topic_id = 0
        if ((DB_count($_TABLES['forum_watch'],$fields1,$values1) > 0) OR (DB_count($_TABLES['forum_watch'],$fields2,$values2) > 0)) {
            $notify_val= 'checked="checked"';
        }
    } else {
        $display .= alertMessage($LANG_GF02['msg72'],$LANG_GF02['msg191']);
        exit;
    }
}

// Add JavaScript
$_SCRIPTS->setJavaScriptFile('forum_creattopic', CTL_plugin_themeFindFile('forum', 'javascript', 'createtopic.js'));

// PREVIEW TOPIC
if ($preview == 'Preview') {
    $previewitem = array();
    if ($method == 'edit') {
        $previewitem['uid']  = $edittopic['uid'];
        $previewitem['name'] = $edittopic['name'];
    } else {
        if ($uid > 1) {
            $previewitem['name'] = stripslashes($aname);
            $previewitem['uid'] = $_USER['uid'];
        } else {
            $previewitem['name'] = stripslashes(urldecode($aname));
            $previewitem['uid'] = 1;
        }
    }
    $previewitem['date']      = time();
    $previewitem['subject']   = gf_checkHTML($subject);
    $previewitem['postmode']  = gf_chkpostmode($postmode,$mode_switch);
    $previewitem['mood']      = $mood;
    $previewitem['pid']       = $edittopic['pid'];
    $previewitem['id']        = 0;
    $previewitem['locked']    = $edittopic['locked'];
    $previewitem['views']     = 0;
    $previewitem['forum']     = $edittopic['forum'];

    $previewitem['comment'] = trim($comment);

    $preview_header = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $preview_header->set_file (array ('preview_header'=>'submissionform_preview_header.thtml'));
    $preview_header->set_var ('imgset', $CONF_FORUM['imgset']);
    $preview_header->parse ('output', 'preview_header');
    $display .= $preview_header->finish($preview_header->get_var('output'));

    $display .= showtopic($previewitem,'preview');

    $preview_footer = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $preview_footer->set_file (array ('preview_footer'=>'submissionform_preview_footer.thtml'));
    $preview_footer->set_var ('imgset', $CONF_FORUM['imgset']);
    $preview_footer->parse ('output', 'preview_footer');
    $display .= $preview_footer->finish($preview_footer->get_var('output'));

    // If Moderator and editing the parent topic - see if form has skicky or locked checkbox on
    isset($editmoderator) or $editmoderator = '';
    if ($editmoderator AND $editpid == 0) {
        if ($method == 'edit') {
            if ($_POST['locked_switch'] == 1 ) {
                $locked_val = 'checked="checked"';
            }
            if ($_POST['sticky_switch'] == 1 ) {
                $sticky_val = 'checked="checked"';
            }
        }
    }
}

// NEW TOPIC OR REPLY
if (($method == 'newtopic' || $method == 'postreply' || $method == 'edit') || ($preview == 'Preview')) {
    if ( $preview == 'Preview' ) {
        $edittopic['subject'] = COM_stripslashes($_POST['subject']);
    }
    // validate the forum is actually the forum the topic belongs in...
    if ( $method == 'postreply' || $method=='edit') {
        if ( ($forum != 0) && $forum != $edittopic['forum'] ) {
        	$display .= alertMessage($LANG_GF02['msg87'], $LANG_GF01['ERROR']);
            $display = gf_createHTMLDocument($display);
            COM_output($display);
            
            exit;
        }
    }
    if ( $method == 'newtopic' && ($newtopic['is_readonly'] == 1 ) ) {
        /* Check if this user has moderation rights now to allow a post to a locked topic */
        if (!forum_modPermission($forum,$_USER['uid'],'mod_edit')) {
            $display .= alertMessage($LANG_GF02['msg87'], $LANG_GF01['ERROR']);
            $display = gf_createHTMLDocument($display);
            COM_output($display);
            
            exit;
        }
    }
    if ($method == 'postreply' AND ( $edittopic['locked'] == 1 || $edittopic['is_readonly'] == 1 )) {
        /* Check if this user has moderation rights now to allow a post to a locked topic */
        if (!forum_modPermission($edittopic['forum'],$_USER['uid'],'mod_edit')) {
            $display .= alertMessage($LANG_GF02['msg87'], $LANG_GF01['ERROR']);
            $display = gf_createHTMLDocument($display);
            COM_output($display);
            exit;
        }
    }

    if ($method == 'postreply' OR ($method == 'edit' AND $subject == '')) {
        $subject = $edittopic['subject'];
    } else {
        $subject = COM_stripslashes($subject);
    }

    $topicnavbar = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $topicnavbar->set_file (array ('topicnavbar'=>'submissionform_header.thtml'));
    $topicnavbar->set_var ('imgset', $CONF_FORUM['imgset']);
    $topicnavbar->set_var ('navbreadcrumbsimg','<img alt="" src="'.gf_getImage('nav_breadcrumbs').'"' . XHTML . '>');
    $topicnavbar->set_var ('navtopicimg','<img alt="" src="'.gf_getImage('nav_topic').'"' . XHTML . '>');
    $topicnavbar->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $topicnavbar->set_var ('phpself', $_CONF['site_url'] .'/forum/createtopic.php');

    if ($method == 'newtopic' AND $forum > 0 ) {  // User creating a newtopic
    	$topicnavbar->set_var ('category_id', $newtopic['id']);
        $topicnavbar->set_var ('forum_id', $forum);
        $topicnavbar->set_var ('cat_name',$newtopic['cat_name']);
        $topicnavbar->set_var ('forum_name', $newtopic['forum_name']);
    } else {
    	$topicnavbar->set_var ('category_id', $edittopic['id']);
        $topicnavbar->set_var ('forum_id', $edittopic['forum']);
        $topicnavbar->set_var ('cat_name',$edittopic['cat_name']);
        $topicnavbar->set_var ('forum_name', $edittopic['forum_name']);
    }
    // run the subject through the HTML filter to ensure no XSS
    // issues.
    $subject = gf_checkHTML($subject);
    $topicnavbar->set_var ('topic_id', $id);
    $topicnavbar->set_var ('subject', $subject);
    $topicnavbar->set_var ('LANG_HOME', $LANG_GF01['HOMEPAGE']);
    $topicnavbar->set_var('forum_home',$LANG_GF01['INDEXPAGE']);
    $topicnavbar->set_var ('hidden_id', $id);
    $topicnavbar->set_var ('hidden_editpost','');
    $topicnavbar->set_var ('hidden_editpid', '');
    $topicnavbar->set_var ('hidden_editid', '');
    $topicnavbar->set_var ('hidden_method', '');
    $topicnavbar->set_var ('page', $page);

    $topicnavbar->set_var ('LANG_bhelp', $LANG_GF01['b_help']);
    $topicnavbar->set_var ('LANG_ihelp', $LANG_GF01['i_help']);
    $topicnavbar->set_var ('LANG_uhelp', $LANG_GF01['u_help']);
    $topicnavbar->set_var ('LANG_qhelp', $LANG_GF01['q_help']);
    $topicnavbar->set_var ('LANG_chelp', $LANG_GF01['c_help']);
    $topicnavbar->set_var ('LANG_lhelp', $LANG_GF01['l_help']);
    $topicnavbar->set_var ('LANG_ohelp', $LANG_GF01['o_help']);
    $topicnavbar->set_var ('LANG_phelp', $LANG_GF01['p_help']);
    $topicnavbar->set_var ('LANG_whelp', $LANG_GF01['w_help']);
    $topicnavbar->set_var ('LANG_ahelp', $LANG_GF01['a_help']);
    $topicnavbar->set_var ('LANG_shelp', $LANG_GF01['s_help']);
    $topicnavbar->set_var ('LANG_fhelp', $LANG_GF01['f_help']);
    $topicnavbar->set_var ('LANG_hhelp', $LANG_GF01['h_help']);

    if ((!COM_isAnonUser() AND forum_modPermission($forum, $_USER['uid'], 'mod_edit')) OR SEC_inGroup( 'Root' )) {
        $editmoderator = TRUE;
        $topicnavbar->set_var ('hidden_modedit', '1');
    } else {
        $topicnavbar->set_var ('hidden_modedit', '0');
        $editmoderator = FALSE;
    }

    if ($method == 'newtopic') {
        $postmessage = $LANG_GF02['PostTopic'];
        $topicnavbar->set_var ('hidden_method', 'newtopic');
        $editpid = 0;
    } elseif ($method == 'postreply') {
        $postmessage = $LANG_GF02['PostReply'];
        $topicnavbar->set_var ('hidden_method', 'postreply');
        if ( $preview != 'Preview' ) {
            $subject = $LANG_GF01['RE'] . $subject;
        }
        $edittopic['mood'] = '';
        if ($quoteid > 0) {
            $quotesql = DB_query("SELECT * FROM {$_TABLES['forum_topic']} WHERE id='$quoteid'");
            $quotearray = DB_fetchArray($quotesql);
            $quotearray['comment'] = stripslashes($quotearray['comment']);
            if ($CONF_FORUM['pre2.5_mode'] == true ) {
                if ( $quotearray['postmode'] == 'html' || $quotearray['postmode'] == 'HTML' ) {
                    if (!class_exists('StringParser') ) {
                        require_once $CONF_FORUM['path_include'] . 'bbcode/stringparser_bbcode.class.php';
                    }
                    $comment = gf_formatOldPost($quotearray['comment'],'html');
                    $comment = sprintf($CONF_FORUM['quoteformat'],COM_getDisplayName($quotearray['uid']),$comment);
                } else {
                    $quotearray['comment'] = str_replace("&#36;","$", $quotearray['comment']);
                    $comment = sprintf($CONF_FORUM['quoteformat'],COM_getDisplayName($quotearray['uid']),$quotearray['comment']);
                }
            } else {
                $comment = sprintf($CONF_FORUM['quoteformat'],COM_getDisplayName($quotearray['uid']),$quotearray['comment']);
            }
        }

        $editpid=$id;

    } elseif ($method == 'edit') {
        $postmessage = $LANG_GF02['EditTopic'];
        $topicnavbar->set_var ('hidden_method', 'edit');
        $topicnavbar->set_var ('hidden_editpost','yes');
        if ($editmoderator) {
            $username = COM_getDisplayName($edittopic['uid']);
        } elseif ($uid > 1) {
            $username = COM_getDisplayName($uid);
        }

        $subject = $edittopic['subject'];
        if ($preview != 'Preview') {
            $comment = str_ireplace('</textarea>','&lt;/textarea&gt;',$edittopic['comment']);
            $postmode = $edittopic['postmode'];
        } else {
            $comment = str_ireplace('</textarea>','&lt;/textarea&gt;',$comment);
            //$postmode = $_POST['postmode']; // leave as is
        }
        if (strstr($edittopic['comment'],'<pre class="forumCode">') === false) {
            $comment = htmlspecialchars($comment,ENT_QUOTES, $CONF_FORUM['charset']);
        }
        $editpid = $edittopic['pid'];
        $topicnavbar->set_var ('hidden_editpid', $editpid);
        $topicnavbar->set_var ('hidden_editid', $id);

    }

    if ($uid >= 2) {
        $topicnavbar->set_var('gltoken_name', CSRF_TOKEN);
        $topicnavbar->set_var('gltoken', SEC_createToken());
    } else {
        $topicnavbar->set_var('gltoken_name', 'token');
        $topicnavbar->set_var('gltoken', '1');
    }

    $topicnavbar->parse ('output', 'topicnavbar');
    $display .= $topicnavbar->finish($topicnavbar->get_var('output'));
    
    $submissionform_main = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $submissionform_main->set_file (array ('submissionform_main'=>'submissionform_main.thtml', 
    									   'submissionform_bbcode_help'=>'submissionform_bbcode_help.thtml'));
    
    $blocks = array('submissionform_anontop', 'submissionform_membertop', 'submissionform_moods', 'submissionform_code', 'submissionform_smilies', 'submissionform_options', 'submissionform_option');
    foreach ($blocks as $block) {
        $submissionform_main->set_block('submissionform_main', $block);
    }      

	$submissionform_main->set_var ('layout_url', $CONF_FORUM['layout_url']);
	$submissionform_main->set_var ('post_message', $postmessage);
	$submissionform_main->set_var ('LANG_NAME', $LANG_GF02['msg33']);
    
	// Keep track if submission options have been added
	$options_exist = false;

    if ($uid < 2) {
        $submissionform_main->set_var ('name', stripcslashes($aname));
        $submissionform_main->parse ('user_name', 'submissionform_anontop');
    } else {
        if (!isset($username) OR $username == '') {
            if ($method == 'edit') {
                if ($editmoderator) {
                    $username = $username;
                } elseif ($useredit == $LANG_GF01['YES']) {
                    $username = COM_getDisplayName($_USER['uid']);
                }
            } else {
                $username = COM_getDisplayName($_USER['uid']);
            }
        }

        $submissionform_main->set_var ('username', $username);
        $submissionform_main->set_var ('xusername', $username);
        $submissionform_main->parse ('user_name', 'submissionform_membertop');
    }

    if ($CONF_FORUM['show_moods']) {
        $moodoptions = '';
        if ($mood != '') {
            $edittopic['mood'] = $mood;
        } else {
            $edittopic['mood'] = '';
            $moodoptions = '<option value="" selected="selected">' . $LANG_GF01['NOMOOD'] . "</option>\n";
        }
        if ($dir = @opendir("{$CONF_FORUM['imgset_path']}/moods")) {
            while (($file = readdir($dir)) !== false) {
                if ((strlen($file) > 3) && substr(strtolower(trim($file)), -4, 4) == '.gif') {
                    $file = str_replace('.gif', '', $file);
                    if ($file == $edittopic['mood']) {
                        $moodoptions .= '<option value="' . $file . '" selected="selected">' . $file . "</option>\n";
                    } else {
                        $moodoptions .= '<option value="' . $file . '" style="height:40px; background-repeat: no-repeat; text-align:right; '
                                      . 'background-image:URL(\'' . $CONF_FORUM['layout_url'] . '/image_set/moods/' . $file . '.gif\')">' .$file. "</option>\n";
                    }
                } else {
                    $moodoptions .= '';
                }
            }
            closedir($dir);
        }
        $submissionform_main->set_var ('LANG_MOOD', $LANG_GF02['msg36']);
        $submissionform_main->set_var ('moodoptions', $moodoptions);
        $submissionform_main->parse ('moods', 'submissionform_moods');
    }

    $sub_dot = '...';
    $sub_none = '';
    $subject = str_replace($sub_dot, $sub_none, $subject);
    if ($method == 'newtopic') {
        $required = $LANG_GF01['REQUIRED'];
    } elseif ($method == 'postreply') {
        $required = $LANG_GF01['OPTIONAL'];
    } elseif ($method == 'edit') {
        if ($editpid == 0) {
            $required = $LANG_GF01['REQUIRED'];
        } else {
            $required = $LANG_GF01['OPTIONAL'];
        }
    }

    // Now check if you need to show the HTML attribute editing buttons and BB code display field
    $chkpostmode = gf_chkpostmode($postmode,$mode_switch);
    if ($chkpostmode != $postmode) {
        $postmode = $chkpostmode;
        $mode_switch = 0;
    }

    $submissionform_main->set_var ('LANG_code', $LANG_GF01['CODE']);
    $submissionform_main->set_var ('LANG_fontcolor', $LANG_GF01['FONTCOLOR']);
    $submissionform_main->set_var ('LANG_fontsize', $LANG_GF01['FONTSIZE']);
    $submissionform_main->set_var ('LANG_closetags', $LANG_GF01['CLOSETAGS']);
    $submissionform_main->set_var ('LANG_codetip', $LANG_GF01['CODETIP']);
    $submissionform_main->set_var ('LANG_tiny', $LANG_GF01['TINY']);
    $submissionform_main->set_var ('LANG_small', $LANG_GF01['SMALL']);
    $submissionform_main->set_var ('LANG_normal', $LANG_GF01['NORMAL']);
    $submissionform_main->set_var ('LANG_large', $LANG_GF01['LARGE']);
    $submissionform_main->set_var ('LANG_huge', $LANG_GF01['HUGE']);

    $submissionform_main->set_var ('LANG_default', $LANG_GF01['DEFAULT']);
    $submissionform_main->set_var ('LANG_dkred', $LANG_GF01['DKRED']);
    $submissionform_main->set_var ('LANG_red', $LANG_GF01['RED']);
    $submissionform_main->set_var ('LANG_orange', $LANG_GF01['ORANGE']);
    $submissionform_main->set_var ('LANG_brown', $LANG_GF01['BROWN']);
    $submissionform_main->set_var ('LANG_yellow', $LANG_GF01['YELLOW']);
    $submissionform_main->set_var ('LANG_green', $LANG_GF01['GREEN']);
    $submissionform_main->set_var ('LANG_olive', $LANG_GF01['OLIVE']);
    $submissionform_main->set_var ('LANG_cyan', $LANG_GF01['CYAN']);
    $submissionform_main->set_var ('LANG_blue', $LANG_GF01['BLUE']);
    $submissionform_main->set_var ('LANG_dkblue', $LANG_GF01['DKBLUE']);
    $submissionform_main->set_var ('LANG_indigo', $LANG_GF01['INDIGO']);
    $submissionform_main->set_var ('LANG_violet', $LANG_GF01['VIOLET']);
    $submissionform_main->set_var ('LANG_white', $LANG_GF01['WHITE']);
    $submissionform_main->set_var ('LANG_black', $LANG_GF01['BLACK']);

    if ($CONF_FORUM['allow_img_bbcode']) {
        $submissionform_main->set_var ('hide_imgbutton_begin','');
        $submissionform_main->set_var ('hide_imgbutton_end','');
    } else {
        $submissionform_main->set_var ('hide_imgbutton_begin','<!--');
        $submissionform_main->set_var ('hide_imgbutton_end','-->');
    }

    $submissionform_main->set_var ('site_name', $_CONF['site_name']);
    $submissionform_main->parse ('modal_bbcode_help', 'submissionform_bbcode_help');
    
    $submissionform_main->parse ('code', 'submissionform_code');

    if (!$CONF_FORUM['allow_smilies']) {
        $smilies = '';
    } else {
        $smilies =  forumPLG_showsmilies();
    }

    // if this is the first time showing the new submission form - then check if notify option should be on
    if (!isset($_POST['preview'])) {
        if ($editpid > 0) {
            $notifyTopicid = $editpid;
        } else {
            $notifyTopicid = $id;
        }


        // If not new topic then check if user has unsubscribed
        if ($notifyTopicid != '') {
            $sql  = "(SELECT id FROM {$_TABLES['forum_watch']} WHERE ((topic_id='$notifyTopicid' AND uid='$uid')) ) UNION ALL "
                  . "(SELECT id FROM {$_TABLES['forum_watch']} WHERE ((forum_id='{$forum}') AND (topic_id='0') AND (uid='$uid')) ) ";
            $notifyquery = DB_query($sql);

            if (DB_getItem($_TABLES['forum_userprefs'],'alwaysnotify', "uid='$uid'") == 1 OR DB_numRows($notifyquery) > 0) {
                $notify = 1;
                // check and see if user has un-subscribed to this topic
                $nid = -$notifyTopicid;
                if ($notifyTopicid > 0 AND DB_getItem($_TABLES['forum_watch'],'id', "forum_id='{$edittopic['forum']}' AND topic_id=$nid AND uid='$uid'") > 1) {
                    $notify = '';
                }
            } else {
                $notify = '';
            }
        } else {
            if (DB_getItem($_TABLES['forum_userprefs'],'alwaysnotify', "uid='$uid'") == 1) {
                $notify = 1;
            } else {
                $notify = '';
            }
        }
    }
    $locked_prompt = '';
    $sticky_prompt = '';
    $notify_prompt = '';
    if ($editmoderator) {
        if ($notify == 1 || (isset($_POST['notify']) && $_POST['notify'] == 1)) {
            $notify_val = 'checked="checked"';
        } else {
            $notify_val = '';
        }
        // Notify Option
        $submissionform_main->set_var ('LANG_OPTION', $LANG_GF02['msg38']);
        $submissionform_main->set_var ('option_name', 'notify');
        $submissionform_main->set_var ('option_checked', $notify_val);
        $submissionform_main->set_var ('option_extra', '');
        $submissionform_main->parse ('option', 'submissionform_option', true);
        $options_exist = true;

        // check that this is the parent topic - only able to make it skicky or locked
        if ($editpid == 0) {
            if (!isset($locked_val) AND !isset($sticky_val) AND $method == 'edit') {
				$locked_val = '';
				$sticky_val = '';
            	
                if ((!isset($_POST['locked_switch']) AND $edittopic['locked'] == 1) OR (isset($_POST['locked_switch']) && $_POST['locked_switch'] == 1 )) {
                    $locked_val = 'checked="checked"';
				}
                if ((!isset($_POST['sticky_switch']) AND $edittopic['sticky'] == 1) OR (isset($_POST['sticky_switch']) && $_POST['sticky_switch'] == 1 )) {
                    $sticky_val = 'checked="checked"';
                }
			} else { 
				$locked_val = '';
				$sticky_val = '';				
			}

			// Locked Option
			$submissionform_main->set_var ('LANG_OPTION', $LANG_GF02['msg109']);
			$submissionform_main->set_var ('option_name', 'locked_switch');
			$submissionform_main->set_var ('option_checked', $locked_val);
			$submissionform_main->set_var ('option_extra', '');
			$submissionform_main->parse ('option', 'submissionform_option', true);
			// Sticky Option
			$submissionform_main->set_var ('LANG_OPTION', $LANG_GF02['msg61']);
			$submissionform_main->set_var ('option_name', 'sticky_switch');
			$submissionform_main->set_var ('option_checked', $sticky_val);
			$submissionform_main->set_var ('option_extra', '');
			$submissionform_main->parse ('option', 'submissionform_option', true);
			$options_exist = true;
        }
    } else {
        if ($uid > 1) {
            if ($notify == 1) {
                $notify_val = 'checked="checked"';
            } else {
                $notify_val = '';
            }
            //$notify_prompt = '<label for="notify">' . $LANG_GF02['msg38']. '</label><br' . XHTML . '><input type="checkbox" name="notify" id="notify" value="on" ' . $notify_val. XHTML . '>';
            // Notify Option
			$submissionform_main->set_var ('LANG_OPTION', $LANG_GF02['msg38']);
			$submissionform_main->set_var ('option_name', 'notify');
			$submissionform_main->set_var ('option_checked', $notify_val);
			$submissionform_main->set_var ('option_extra', '');
			$submissionform_main->parse ('option', 'submissionform_option', true);
			$options_exist = true;
        }
    }

    if ($postmode == 'html' || $postmode == 'HTML') {
        $postmode_msg = $LANG_GF01['TEXTMODE'];
    } else {
         $postmode_msg = $LANG_GF01['HTMLMODE'];
    }
    if ($CONF_FORUM['allow_html'] || SEC_inGroup( 'Root' )) {
        
		// Mode Option
		$submissionform_main->set_var ('LANG_OPTION', $postmode_msg);
		$submissionform_main->set_var ('option_name', 'postmode_switch');
		$submissionform_main->set_var ('option_checked', '');
		$postmode_extra = '<input type="hidden" name="postmode" value="' . $postmode . '"' . XHTML . '>';
		$submissionform_main->set_var ('option_extra', $postmode_extra);
		$submissionform_main->parse ('option', 'submissionform_option', true);
		$options_exist = true;
    }

    if ($method == 'edit') {
        if ($CONF_FORUM['pre2.5_mode']) {
            /* Reformat code blocks - version 2.3.3 and prior */
            $comment = str_replace( '<pre class="forumCode">', '[code]', $comment );
            $comment = str_replace( '<pre>', '[code]', $comment );
            $comment = str_replace( '</pre>', '[/code]', $comment );
        }
        if ($silentedit == 1 OR ( !isset($_POST['modedit']) AND $CONF_FORUM['silent_edit_default'])) {
             $edit_val = 'checked="checked"';
        }

		// Edit Option
		$submissionform_main->set_var ('LANG_OPTION', $LANG_GF02['msg190']);
		$submissionform_main->set_var ('option_name', 'silentedit');
		$submissionform_main->set_var ('option_checked', $edit_val);
		$submissionform_main->set_var ('option_extra', '');
		$submissionform_main->parse ('option', 'submissionform_option', true); 
		$options_exist = true;
    }

    $subject = str_replace('"', '&quot;',$subject);

    $submissionform_main->set_unknowns('keep');
    $submissionform_main->set_var ('LANG_SUBJECT', $LANG_GF01['SUBJECT']);
    if ($options_exist) {
    	$submissionform_main->set_var ('LANG_OPTIONS', $LANG_GF01['OPTIONS']);
    	$submissionform_main->parse ('options', 'submissionform_options');
	} else {
		$submissionform_main->set_var ('options', '');
	}
    $submissionform_main->set_var ('LANG_SUBMIT', $LANG_GF01['SUBMIT']);
    $submissionform_main->set_var ('LANG_PREVIEW', $LANG_GF01['PREVIEW']);
    $submissionform_main->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
    $submissionform_main->set_var ('required', $required);
    $submissionform_main->set_var ('subject', $subject);
    $submissionform_main->set_var ('smilies', $smilies);
    if (!empty($smilies)) {
		$submissionform_main->parse ('smilies', 'submissionform_smilies');
	}
    $submissionform_main->set_var ('hide_notify', ($uid == 1) ? 'none' : '');
    if ( function_exists('plugin_templatesetvars_captcha') ) {
        plugin_templatesetvars_captcha('forum', $submissionform_main);
    } else {
        if ( function_exists('plugin_templatesetvars_recaptcha') ) {
            plugin_templatesetvars_recaptcha('forum', $submissionform_main);
        } else {
            $submissionform_main->set_var ('captcha','');
        }
    }

    if ($method == 'edit') {
        if ($CONF_FORUM['allow_smilies']) {
            if (function_exists('msg_restoreEmoticons') AND $CONF_FORUM['use_smilies_plugin']) {
                $comment = msg_restoreEmoticons($comment);
            } else {
                $comment = forum_xchsmilies($comment,true);
            }
        }
        $submissionform_main->set_var ('post_message', $comment);
    } else {
        $submissionform_main->set_var ('post_message', htmlspecialchars($comment,ENT_QUOTES, $CONF_FORUM['charset']));
    }
    
    $submissionform_main->set_var ('postmode', $postmode);
    $submissionform_main->parse ('output', 'submissionform_main');
    $display .= $submissionform_main->finish($submissionform_main->get_var('output'));
    
    $topicfooter = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $topicfooter->set_file (array (	'topicfooter'=>'submissionform_footer.thtml'));
    
    $topicfooter->set_block('topicfooter', 'topic_review');
    
    $topicfooter->set_var ('imgset', $CONF_FORUM['imgset']);
	$topicfooter->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $topicfooter->set_var ('site_url', $_CONF['site_url']);
	
    //Topic Review
    if (($method != 'newtopic' && $editpost != 'yes') && ($method == 'postreply' || $preview == 'Preview')) {
        if ($CONF_FORUM['show_topicreview']) {
        	$topicfooter->set_var ('topic_id', $id);
        	$topicfooter->parse ('topic_review', 'topic_review');
        } else {
        	$topicfooter->set_var ('topic_review', '');
		}
	} else {
		$topicfooter->set_var ('topic_review', '');
    }
	
	$topicfooter->parse ('output', 'topicfooter');
    $display .= $topicfooter->finish ($topicfooter->get_var('output'));

}

$display = gf_createHTMLDocument($display, '', true);
COM_output($display);


/*
* Function is called to check for notifications that may be setup by forum users
* A record in the forum_watch table is created for each users's subsctribed notifications
* Users can subscribe to a complete forum or individual topics.
* If they have both selected - we only want to send one notification - hense the SQL LIMIT 1
*
* This function needs to be called when there is a new topic or a reply
*/
function gf_chknotifications($forumid,$topicid,$userid,$type='topic') {
    global $_TABLES,$LANG_GF01,$LANG_GF02,$_CONF,$CONF_FORUM;

    $pid = DB_getItem($_TABLES['forum_topic'],'pid',"id='$topicid'");
    if ($pid == 0) {
        $pid = $topicid;
    }

    $sql = "SELECT * FROM {$_TABLES['forum_watch']} WHERE ((topic_id='$pid') OR ((forum_id='$forumid') AND (topic_id='0') )) GROUP BY uid";
    $sqlresult = DB_query($sql);
    $postername = COM_getDisplayName($userid);
    $nrows = DB_numRows($sqlresult);

    $site_language = unserialize(DB_getItem($_TABLES['conf_values'], 'value', "group_name='Core' AND name='language'")); // Retrieve original language of site
    $mail_language = $_CONF['language'];
    $last_mail_language = $mail_language;
    $plugin_path = $_CONF['path'] . 'plugins/forum/';
    
    for ($i =1; $i <= $nrows; $i++) {
        $N = DB_fetchArray($sqlresult);
        // Don't need to send a notification to the user that posted this message and users with NOTIFY disabled
        if ($N['uid'] > 1 AND $N['uid'] != $userid AND $CONF_FORUM['allow_notification'] == '1' ) {

            // if the topic_id is 0 for this record - user has subscribed to complete forum. Check if they have opted out of this forum topic.
            if (DB_count($_TABLES['forum_watch'],array('uid','forum_id','topic_id'),array($N['uid'],$forumid,-$topicid)) == 0) {

                // Check if user does not want to receive multiple notifications for same topic and already has been notified
                $userNotifyOnceOption = DB_getItem($_TABLES['forum_userprefs'],'notify_once',"uid='{$N['uid']}'");
                // Retrieve the log record for this user if it exists then check if user has viewed this topic yet
                // The logtime value may be 0 which indicates the user has not yet viewed the topic
                $lsql = DB_query("SELECT time FROM {$_TABLES['forum_log']} WHERE uid='{$N['uid']}' AND forum='$forumid' AND topic='$topicid'");
                if (DB_numRows($lsql) == 1) {
                    $nologRecord = false;
                    list ($logtime) = DB_fetchArray($lsql);
                } else {
                    $nologRecord = true;
                    $logtime = 0;
                }

                if  ($userNotifyOnceOption == 0 OR ($userNotifyOnceOption == 1 AND ($nologRecord OR $logtime != 0)) ) {
                    $topicrec = DB_query("SELECT subject,name,forum FROM {$_TABLES['forum_topic']} WHERE id='$pid'");
                    $A = DB_fetchArray($topicrec);
                    $userrec = DB_query("SELECT username,email,language,status FROM {$_TABLES['users']} WHERE uid='{$N['uid']}'");
                    $B = DB_fetchArray($userrec);
                    if ($B['status'] == USER_ACCOUNT_ACTIVE) {
                        // Need to send email in user own language if set, else site default
                        // Should not use current user language if does not match
                        if (empty($B['language'])) {
                            $mail_language = $site_language;
                        } else {
                            $mail_language = $B['language'];
                        }
                        
                        if ($mail_language != $last_mail_language) {
                            $langfile = $plugin_path . 'language/' . $mail_language . '.php';
                            if (file_exists($langfile)) {
                                require $langfile;
                                $last_mail_language = $mail_language;
                            } else {
                                // Use site default language as backup
                                $langfile = $plugin_path . 'language/' . $site_language . '.php';
                                if (file_exists($langfile)) {
                                    require $langfile;
                                    $last_mail_language = $site_language;
                                } else {
                                    require $plugin_path . 'language/english.php';
                                    $last_mail_language = 'english';
                                }
                            }
                        }
                        
                        $subjectline = "{$_CONF['site_name']} {$LANG_GF02['msg22']}";
                        $message  = "{$LANG_GF01['HELLO']} {$B['username']},\n\n";
                        if ($type=='forum') {
                            $forum_name = DB_getItem($_TABLES['forum_forums'],forum_name, "forum_id='$forumid'");
                            $message .= sprintf($LANG_GF02['msg23b'],$A['subject'],$A['name'],$forum_name, $_CONF['site_name'],$_CONF['site_url'],$pid);
                        } else {
                            $message .= sprintf($LANG_GF02['msg23a'],$A['subject'],$postername, $A['name'],$_CONF['site_name']);
                            $message .= sprintf($LANG_GF02['msg23c'],$_CONF['site_url'],$pid);
                        }
                        $message .= $LANG_GF02['msg26'];
                        $message .= sprintf($LANG_GF02['msg27'],"{$_CONF['site_url']}/forum/notify.php");
                        $message .= "{$LANG_GF02['msg25']}{$_CONF['site_name']} {$LANG_GF01['ADMIN']}\n";
                        // Check and see if Site admin has enabled email notifications
                        if ($CONF_FORUM['allow_notification']) {
                            if ($nologRecord and $userNotifyOnceOption == 1 ) {
                                DB_query("INSERT INTO {$_TABLES['forum_log']} (uid,forum,topic,time) VALUES ('{$N['uid']}', '$forumid', '$topicid','0') ");
                            }
                            if (($B['email'] != '')  AND COM_isEmail($B['email'])) {
                                COM_mail($B['email'], $subjectline, $message);
                            }
                        }
                    }
                }
            }
        }
    }
}

?>
