<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | viewtopic.php                                                             |
// | Main program to view topics and posts in the forum                        |
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

require_once $_CONF['path_system'] . 'classes/timer.class.php';
$mytimer = new timerobject();
$mytimer->setPrecision(2);
$mytimer->startTimer();

require_once $CONF_FORUM['path_include'] . 'gf_showtopic.php';
require_once $CONF_FORUM['path_include'] . 'gf_format.php';

$mytimer = new timerobject();
$mytimer->startTimer();

$display = '';

// Pass thru filter any get or post variables to only allow numeric values and remove any hostile data
$highlight = isset($_REQUEST['highlight']) ? COM_applyFilter($_REQUEST['highlight'])      : '';
$lastpost  = isset($_REQUEST['lastpost'])  ? COM_applyFilter($_REQUEST['lastpost'])       : '';
$mode      = isset($_REQUEST['mode'])      ? COM_applyFilter($_REQUEST['mode'])           : '';
$msg       = isset($_GET['msg'])           ? COM_applyFilter($_GET['msg'])                : '';
$onlytopic = isset($_REQUEST['onlytopic']) ? COM_applyFilter($_REQUEST['onlytopic'])      : '';
$page      = isset($_REQUEST['page'])      ? COM_applyFilter($_REQUEST['page'],true)      : '';
$show      = isset($_REQUEST['show'])      ? COM_applyFilter($_REQUEST['show'],true)      : '';
$showtopic = isset($_REQUEST['showtopic']) ? COM_applyFilter($_REQUEST['showtopic'],true) : '';

$result = DB_query("SELECT forum, pid, subject FROM {$_TABLES['forum_topic']} WHERE id = '$showtopic'"); // <- new
list($forum, $topic_pid, $subject) = DB_fetchArray($result); // <- new

if ($topic_pid == '') {
    // Topic doesn't exist so exit gracefully
    COM_handle404('/forum/index.php');
    exit;
}
if ($topic_pid != 0) {
    $showtopic = $topic_pid;
}

if ($onlytopic == 1) {
    // Send out the HTML headers and load the stylesheet for the iframe preview
    switch ($_CONF['doctype']) {
    case 'html401transitional':
        $display .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' . LB;
        break;

    case 'html401strict':
        $display .= '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . LB;
        break;

    case 'xhtml10transitional':
        $display .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . LB;
        break;

    case 'xhtml10strict':
        $display .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . LB;
        break;

    case 'html5':
    case 'xhtml5':
        $display .= '<!DOCTYPE html>';
        break;        

    default: // fallback: HTML 4.01 Transitional w/o system identifier
        $display .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
        break;
    }
    $display .= '<html class="glforum-preview-html">' . LB;
    $display .= '<head>' . LB;
    $display .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$LANG_CHARSET\"" . XHTML . ">" . LB;
    $display .= '<meta name="robots" content="NOINDEX"' . XHTML . '>' . LB;
    $display .= '<title>Forum Preview</title>' . LB;
    if (version_compare($_CONF['supported_version_theme'], '2.0.0', '>=')) {
    	/*
        $func = "theme_css_" . $_CONF['theme'];
        if (function_exists($func)) {
            $FORUM_SCRIPTS = new scripts();
            foreach ($func() as $info) {
                $file = $info['file'];
                $name = md5($file);
                $constant   = (!empty($info['constant']))   ? $info['constant']   : true;
                $attributes = (!empty($info['attributes'])) ? $info['attributes'] : array();
                $FORUM_SCRIPTS->setCssFile($name, $file, $constant, $attributes);
            }
            
            $display .= $FORUM_SCRIPTS->getHeader();
        }
        */
		// need to call this incase plugin doesnt use script class OR headercode function is used to set css file
		$display .= PLG_getHeaderCode();
		$display .= $_SCRIPTS->getHeader();
        $display .= '</head>' . LB;
    } else {
        $display .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$_CONF['site_url']}/layout/{$_CONF['theme']}/style.css\"></head>\n";
    }
    $display .= '<body class="glforum-preview-body">';
} else {
    //Check is anonymous users can access
    forum_chkUsercanAccess();
    // Debug Code to show variables
    $display .= gf_showVariables();

    if ($msg==1) {
        $display .= COM_showMessageText($LANG_GF02['msg19']);
    }
    if ($msg==2) {
        // Notification Saved
        $display .= COM_showMessageText($LANG_GF02['msg142']);
    }
    if ($msg==3) {
        $display .= COM_showMessageText($LANG_GF02['msg40']);
    }
    if ($msg==4) {
        // Notification deleted
        $display .= COM_showMessageText($LANG_GF02['msg146']);
    }
    if ($msg==5) {
        $display .= COM_showMessageText($LANG_GF02['msg55']);
    }
    if ($msg==6) {
        $display .= COM_showMessageText($LANG_GF02['msg56']);
    }
    if ($msg==7) {
        $display .= COM_showMessageText($LANG_GF02['msg183']);
    }
    if ($msg==8) {
        $display .= COM_showMessageText($LANG_GF02['msg163']);
    }
    if ($msg==9) {
    	// Forum Post Canceled
        $display .= COM_showMessageText($LANG_GF02['msg149']);
    }
    if ($msg==10) {
    	// Ban added
        $display .= COM_showMessageText($LANG_GF03['banipmsg']);
    }    
    if ($msg==11) {
    	// Ban Deleted
        $display .= COM_showMessageText($LANG_GF03['banipremovemsg']);
    }    
    if ($msg==12) {
    	// Notification Saved but no email address reminder
        $display .= COM_showMessageText($LANG_GF02['msg143']);
    }      
    
    // Now display the forum header
    ForumHeader($forum, $showtopic, $display);
}

// Check if the number of records was specified to show
if (empty($show) AND $CONF_FORUM['show_posts_perpage'] > 0) {
    $show = $CONF_FORUM['show_posts_perpage'];
} elseif (empty($show)) {
    $show = 20;
}

$sql  = "SELECT a.forum,a.pid,a.locked,a.subject,a.replies,b.forum_cat,b.forum_name,b.is_readonly,c.cat_name ";
$sql .= "FROM {$_TABLES['forum_topic']} a ";
$sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON b.forum_id=a.forum ";
$sql .= "LEFT JOIN {$_TABLES['forum_categories']} c ON c.id=b.forum_cat ";
$sql .= "WHERE a.id=$showtopic";
$viewtopic = DB_fetchArray(DB_query($sql),false);
$numpages = ceil(($viewtopic['replies'] + 1) / $show);

if ($CONF_FORUM['sort_order_asc']) {
    if ($lastpost) {
        if ($page == 0) {
            $page = $numpages;
        }
        $order = 'ASC';
    } else {
        if ($page == 0) {
            $page = 1;
        }
        if ($onlytopic == 1) {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }
    }
} else {
    if ($page == 0) {
        $page = 1;
    }
    $order = 'DESC';
}
if ($page > 1) {
    $offset = ($page - 1) * $show;
} else {
    $offset = 0;
}

if ($onlytopic == 1) {
	// If using submission forum post read preview mode
	$base_url = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic=$showtopic&amp;mode=$mode&amp;onlytopic=1";
} else {	
	$base_url = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic=$showtopic&amp;mode=$mode&amp;show=$show";
}

// Check to see if requesting a forum topic page that does not exist
if ($page > $numpages) {
    COM_handle404($base_url);    
}

$pagenavigation = '';
if ($numpages > 1) {
    $pagenavigation = COM_printPageNavigation($base_url, $page, $numpages);
}

// Stop timer and print elapsed time
//$intervalTime = $mytimer->stopTimer();
//COM_errorLog("Start Topic Display Time: $intervalTime");

if ($mode != 'preview') {

    $topicnavbar = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $topicnavbar->set_file (array (
            'topicnavbar' => 'topic_navbar.thtml',
			'forum_links'    => 'forum_links.thtml'));                    

    $blocks = array('subscribetopic_link', 'print_link', 'prevtopic_link', 'nexttopic_link', 'newtopic_link', 'replytopic_link', 'topicmenu_link');
    foreach ($blocks as $block) {
        $topicnavbar->set_block('forum_links', $block);
    }      
    
    $topicnavbar->set_var('layout_url', $CONF_FORUM['layout_url']);

    if ($topic_pid > 0) {
        $replytopic_id = $topic_pid;
    } else {
        $replytopic_id = $showtopic;
    }

    if ($viewtopic['is_readonly'] == 0 OR forum_modPermission($viewtopic['forum'],$_USER['uid'],'mod_edit')) {
        $newtopiclink = "{$_CONF['site_url']}/forum/createtopic.php?method=newtopic&amp;forum=$forum";
        $newtopiclinktext = $LANG_GF09['newtopic'];
        $newtopiclinkimg = gf_getImage('post_newtopic');
        if ($viewtopic['locked'] != 1) {
            $replytopiclink = "{$_CONF['site_url']}/forum/createtopic.php?method=postreply&amp;forum=$forum&amp;id=$replytopic_id";
            $topicnavbar->set_var ('replytopiclink', $replytopiclink);
            $topicnavbar->set_var ('replytopiclinkimg', gf_getImage('post_reply'));
            $topicnavbar->set_var ('replytopiclinktext', $LANG_GF09['replytopic']);
            $topicnavbar->set_var ('LANG_reply', $LANG_GF01['POSTREPLY']);
            $topicnavbar->parse ('replytopic_link', 'replytopic_link');
        }
    } else {
        $newtopiclink = '';
        $newtopiclinkimg = '';
        $newtopiclinktext = '';
    }


    $prev_sql = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE (forum='$forum') AND (pid=0) AND (id < '$showtopic') ORDER BY id DESC LIMIT 1");
    $P = DB_fetchArray($prev_sql);
    if ($P['id'] != "") {
        $prevlink = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$P['id']}";
        $topicnavbar->set_var ('prevlink', $prevlink);
        $topicnavbar->set_var ('LANG_prevlink',$LANG_GF01['PREVTOPIC']);
        $topicnavbar->parse ('prevtopic_link', 'prevtopic_link');
    }

    $next_sql = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE (forum='$forum') AND (pid=0) AND (id > '$showtopic') ORDER BY id ASC LIMIT 1");
    $N = DB_fetchArray($next_sql);
    if ($N['id'] > 0) {
        $nextlink = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$N['id']}";
        $topicnavbar->set_var ('nextlink', $nextlink);
        $topicnavbar->set_var ('LANG_nextlink',$LANG_GF01['NEXTTOPIC']);
        $topicnavbar->parse ('nexttopic_link', 'nexttopic_link');
    }

    // Enable TOPIC NOTIFY IF THE USER IS A MEMBER
    if (!COM_isAnonUser()) {
        $forumid = $viewtopic['forum'];

        /* Check for a un-subscribe record */
        $ntopicid = -$showtopic;  // Negative value
        if (DB_count($_TABLES['forum_watch'], array('forum_id', 'topic_id', 'uid'), array($forumid, $ntopicid,$_USER['uid'])) > 0) {
            $notifylinktext = $LANG_GF02['msg62'];
            $notifylink = "{$_CONF['site_url']}/forum/notify.php?forum=$forumid&amp;submit=save&amp;id=$showtopic";
            $topicnavbar->set_var ('LANG_notify', $LANG_GF01['SubscribeLink']);
            $topicnavbar->set_var ('LANG_notify_state', $LANG_GF01['SubscribeLink_FALSE']);

        /* Check if user has subscribed to complete forum */
        } elseif (DB_count($_TABLES['forum_watch'], array('forum_id', 'topic_id', 'uid'), array($forumid, '0',$_USER['uid'])) > 0) {
            $notifyID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forumid' AND topic_id='0' AND uid='{$_USER['uid']}'");
            $notifylinktext = $LANG_GF02['msg137'];
            $notifylink = "{$_CONF['site_url']}/forum/notify.php?submit=delete2&amp;id=$notifyID&amp;forum=$forumid&amp;topic=$showtopic";
            $topicnavbar->set_var ('LANG_notify', $LANG_GF01['unSubscribeLink']);
            $topicnavbar->set_var ('LANG_notify_state', $LANG_GF01['SubscribeLink_TRUE']);

        /* Check if user is subscribed to this specific topic */
        } elseif (DB_count($_TABLES['forum_watch'], array('forum_id', 'topic_id', 'uid'), array($forumid, $showtopic,$_USER['uid'])) > 0) {
            $notifyID = DB_getItem($_TABLES['forum_watch'],'id', "forum_id='$forumid' AND topic_id='$showtopic' AND uid='{$_USER['uid']}'");
            $notifylinktext = $LANG_GF02['msg137'];
            $notifylink = "{$_CONF['site_url']}/forum/notify.php?submit=delete2&amp;id=$notifyID&amp;forum=$forumid&amp;topic=$showtopic";
            $topicnavbar->set_var ('LANG_notify', $LANG_GF01['unSubscribeLink']);
            $topicnavbar->set_var ('LANG_notify_state', $LANG_GF01['SubscribeLink_TRUE']);

        } else {
            $notifylinktext = $LANG_GF02['msg62'];
            $notifylink = "{$_CONF['site_url']}/forum/notify.php?forum=$forumid&amp;submit=save&amp;id=$showtopic";
            $topicnavbar->set_var ('LANG_notify', $LANG_GF01['SubscribeLink']);
            $topicnavbar->set_var ('LANG_notify_state', $LANG_GF01['SubscribeLink_FALSE']);
        }

        $topicnavbar->set_var ('notifylinktext', $notifylinktext);
        $topicnavbar->set_var ('notifylink', $notifylink);
        $topicnavbar->parse ('subscribetopic_link', 'subscribetopic_link');

    }

    /* Blaine: Commented out this section of code that will trim the displayed title */
    //if (strlen($viewtopic['subject']) > $CONF_FORUM['show_subject_length'])  {
    //    $viewtopic['subject'] = substr($viewtopic['subject'], 0, $CONF_FORUM['show_subject_length']);
    //   $viewtopic['subject'] .= "..";
    //}

    if (function_exists('prj_getSessionProject')) {
        $projectid = prj_getSessionProject();
        if ($projectid > 0) {
            $link = "<a href=\"{$_CONF['site_url']}/projects/viewproject.php?pid=$projectid\">{$strings['RETURN2PROJECT']}</a>";
            $topicnavbar->set_var ('return2project',$link);
        }
    }

    $topicnavbar->set_var ('printlink', "{$_CONF['site_url']}/forum/print.php?id=$showtopic");
    $topicnavbar->set_var ('printlinktext', $LANG_GF01['PRINTABLE']);
    $topicnavbar->set_var ('LANG_print', $LANG_GF01['PRINTABLE']);
    $topicnavbar->parse ('print_link', 'print_link');

    $topicnavbar->set_var ('imgset', $CONF_FORUM['imgset']);
    $topicnavbar->set_var ('navbreadcrumbsimg','<img alt="" src="'.gf_getImage('nav_breadcrumbs').'"' . XHTML . '>');
    $topicnavbar->set_var ('navtopicimg','<img alt="" src="'.gf_getImage('nav_topic').'"' . XHTML . '>');
    $topicnavbar->set_var ('forum_home',$LANG_GF01['INDEXPAGE']);
    $topicnavbar->set_var ('category_id', $viewtopic['forum_cat']);
    $topicnavbar->set_var ('cat_name', DB_getItem($_TABLES['forum_categories'],"cat_name","id={$viewtopic['forum_cat']}"));
    $topicnavbar->set_var ('forum_id', $forum);
    $topicnavbar->set_var ('forum_name', $viewtopic['forum_name']);

    $topicnavbar->set_var ('topic_id', $replytopic_id);

    $topicnavbar->set_var ('newtopiclink', $newtopiclink);
    $topicnavbar->set_var ('newtopiclinkimg', $newtopiclinkimg);
    $topicnavbar->set_var ('newtopiclinktext', $newtopiclinktext);
    $topicnavbar->set_var ('LANG_newtopic', $LANG_GF01['NEWTOPIC']);
    $topicnavbar->parse ('newtopic_link', 'newtopic_link');

    $topicnavbar->set_var ('LANG_next', $LANG_GF01['NEXT']);
    $topicnavbar->set_var ('LANG_TOP', $LANG_GF01['TOP']);
    $topicnavbar->set_var ('subject', $viewtopic['subject']);
    $topicnavbar->set_var ('LANG_HOME', $LANG_GF01['HOMEPAGE']);
    $topicnavbar->set_var ('pagenavigation', $pagenavigation);
    
	$topicnavbar->parse ('topicmenu_link', 'topicmenu_link');
    
    $topicnavbar->parse ('output', 'topicnavbar');
    $display .= $topicnavbar->finish($topicnavbar->get_var('output'));
} else {
    $preview_header = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $preview_header->set_file ('header', 'submissionform_preview_header.thtml');
    $preview_header->set_var ('imgset', $CONF_FORUM['imgset']);
    $preview_header->parse ('output', 'header');
    $display .= $preview_header->finish($preview_header->get_var('output'));
}

//$intervalTime = $mytimer->stopTimer();
//COM_errorLog("Topic Display Time2: $intervalTime");

// Update the topic view counter and user access log
DB_query("UPDATE {$_TABLES['forum_topic']} SET views=views+1 WHERE id='$showtopic'");
if (!COM_isAnonUser()) {
    $query = DB_query("SELECT pid,forum FROM {$_TABLES['forum_topic']} WHERE id='$showtopic'");
    list ($showtopicpid,$forumid) = DB_fetchArray($query);
    if ($showtopicpid == 0 ) {
        $showtopicpid = $showtopic;
    }
    $lrows = DB_count($_TABLES['forum_log'],array('uid','topic'),array($_USER['uid'],$showtopic));
    $logtime = time();
    if ($lrows < 1) {
        DB_query("INSERT INTO {$_TABLES['forum_log']} (uid,forum,topic,time) VALUES ('{$_USER['uid']}','$forum','$showtopic','$logtime')");
    } else {
        DB_query("UPDATE {$_TABLES['forum_log']} SET time=$logtime WHERE uid={$_USER['uid']} AND topic=$showtopic");
    }
}

// Retrieve all the records for this topic
//$intervalTime = $mytimer->stopTimer();
//COM_errorLog("Topic Display Time2b: $intervalTime");
$sql  = "(SELECT * FROM {$_TABLES['forum_topic']} WHERE id='$showtopic') "
      . "UNION ALL (SELECT * FROM {$_TABLES['forum_topic']} WHERE pid='$showtopic') "
      . "ORDER BY id $order LIMIT $offset, $show";
$result  = DB_query($sql);

// Display each post in this topic
$onetwo = 1;
while ($topicRec = DB_fetchArray($result)) {
    //$intervalTime = $mytimer->stopTimer();
    //COM_errorLog("Topic Display Time: $intervalTime");
    if ($CONF_FORUM['show_anonymous_posts'] == 0 AND $topicRec['uid'] == 1) {
        $display .= '<div class="pluginAlert" style="padding:10px;margin:10px;">' . $LANG_GF02['msg300'] . '</div>';
        break;
        //Do nothing - but this way I don't always have to do this check
    } else {
        $display .= showtopic($topicRec,$mode,$onetwo,$page);
        $onetwo = ($onetwo == 1) ? 2 : 1;
    }
}

if ($mode != 'preview') {
    $topic_footer = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $topic_footer->set_file (array ('topicfooter'=>'topicfooter.thtml',
			'forum_links'    => 'forum_links.thtml'));                    

    $blocks = array('newtopic_link', 'replytopic_link');
    foreach ($blocks as $block) {
        $topic_footer->set_block('forum_links', $block);
    }    
    
    if ($viewtopic['is_readonly'] == 0 OR forum_modPermission($viewtopic['forum'],$_USER['uid'],'mod_edit')) {
        $newtopiclink = "{$_CONF['site_url']}/forum/createtopic.php?method=newtopic&amp;forum=$forum";
        $newtopiclinktext = $LANG_GF09['newtopic'];
        $topic_footer->set_var ('layout_url', $CONF_FORUM['layout_url']);
        $topicDisplayTime = $mytimer->stopTimer();
        $topic_footer->set_var ('page_generated_time', sprintf($LANG_GF02['msg179'],$topicDisplayTime));
        $topic_footer->set_var ('newtopiclink', $newtopiclink);
        $topic_footer->set_var ('newtopiclinkimg', gf_getImage('post_newtopic'));
        $topic_footer->set_var ('newtopiclinktext', $newtopiclinktext);
        $topic_footer->set_var ('LANG_newtopic', $LANG_GF01['NEWTOPIC']);
        $topic_footer->parse ('newtopic_link', 'newtopic_link');

        if ($viewtopic['locked'] != 1) {
            $replytopiclink = "{$_CONF['site_url']}/forum/createtopic.php?method=postreply&amp;forum=$forum&amp;id=$replytopic_id";
            $topic_footer->set_var ('replytopiclink', $replytopiclink);
            $topic_footer->set_var ('replytopiclinkimg', gf_getImage('post_reply'));
            $topic_footer->set_var ('replytopiclinktext', $LANG_GF09['replytopic']);
            $topic_footer->set_var ('LANG_reply', $LANG_GF01['POSTREPLY']);
            $topic_footer->parse ('replytopic_link', 'replytopic_link');
        }
    }


} else {
    $topic_footer = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $topic_footer->set_file (array ('topicfooter'=>'topicfooter_preview.thtml'));
}

$topic_footer->set_var ('pagenavigation', $pagenavigation);
$topic_footer->set_var ('forum_id', $forum);
$topic_footer->set_var ('imgset', $CONF_FORUM['imgset']);
$topic_footer->parse ('output', 'topicfooter');
$display .= $topic_footer->finish($topic_footer->get_var('output'));

$intervalTime = $mytimer->stopTimer();
//COM_errorLog("End Topic Display Time: $intervalTime");

if ($onlytopic != 1) {
    $display .= BaseFooter();
    $display = gf_createHTMLDocument($display, $subject);
} else {
	// need to call this incase plugin doesnt use script class OR footercode function is used to set required javascript file
	$display .= PLG_getFooterCode();
	$display .= $_SCRIPTS->getFooter();
    $display .= '</body>' . LB;
    $display .= '</html>' . LB;
}

COM_output($display);
?>
