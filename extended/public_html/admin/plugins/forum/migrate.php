<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | migrate.php                                                               |
// | Story Migration Utility for Geeklog to the Forum                          |
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


require_once 'gf_functions.php';
require_once $_CONF['path_system'] . 'lib-story.php';

$page     = isset($_GET['page'])            ? COM_applyFilter($_GET['page'],true)            : '';
$show     = isset($_GET['show'])            ? COM_applyFilter($_GET['show'],true)            : '';
$migrate  = isset($_POST['migrate'])        ? COM_applyFilter($_POST['migrate'])             : '';
$selforum = isset($_POST['selforum'])       ? COM_applyFilter($_POST['selforum'])            : '';
$curtopic = isset($_POST['seltopic'])       ? COM_applyFilter($_POST['seltopic'])            : '';
$dpm      = isset($_POST['delPostMigrate']) ? COM_applyFilter($_POST['delPostMigrate'],true) : '';

if ($migrate == $LANG_GF01['MIGRATE_NOW'] && $selforum != "select"
        && !empty($_POST['chk_record_delete']) && SEC_checkToken()) {
    $num_stories = 0;
    $num_posts = 0;
    foreach ($_POST['chk_record_delete'] as $sid) {
        if ($curtopic == 'submissions') {
            $sql = "SELECT sid,date,uid,title,introtext "
                 . "FROM {$_TABLES['storysubmission']} WHERE sid='$sid'";
            $result = DB_query($sql);
            list($sid, $storydate, $uid, $subject, $introtext) = DB_fetchArray($result);
            $num_posts = migratetopic($selforum, $sid, $storydate, $uid,
                             $subject, $introtext, '', '0') + $num_posts;
            $num_stories++;
            if ($dpm == 1) {
                PLG_deleteSubmission('story', $sid);
            }
        } else {
            $sql = "SELECT sid,date,uid,title,introtext,bodytext,hits "
                 . "FROM {$_TABLES['stories']} WHERE sid='$sid'";
            $result = DB_query($sql);
            list($sid, $storydate, $uid, $subject, $introtext, $bodytext, $hits)
                = DB_fetchArray($result);
            $num_posts = migratetopic($selforum, $sid, $storydate, $uid,
                             $subject, $introtext, $bodytext, $hits) + $num_posts;
            $num_stories++;
            if ($dpm == 1) {
                STORY_doDeleteThisStoryNow($sid);
            }
        }
    }
    gf_resyncforum($selforum);
    
    COM_rdfUpToDateCheck('forum'); // forum rss feeds update
    
    echo COM_refresh($_CONF['site_admin_url']
                     . "/plugins/forum/migrate.php?num_stories="
                     . $num_stories . "&num_posts=" . $num_posts);
    exit;
}

function migratetopic($forum, $sid, $storydate, $uid, $subject, $introtext, $bodytext, $hits)
{
    global $_TABLES;

    $comment = $introtext . $bodytext;
    $comment = prepareStringForDB($comment);
    $subject = prepareStringForDB($subject);
    $postmode = "HTML";
    $name = DB_getItem($_TABLES['users'], 'username', "uid=$uid");
    $email = DB_getItem($_TABLES['users'], 'email', "uid=$uid");
    $website = DB_getItem($_TABLES['users'], 'homepage', "uid=$uid");

    $datetime = explode(" ", $storydate);
    $date = explode("-", $datetime[0]);
    $time = explode(":", $datetime[1]);
    $year  = ($date[0] > 1969) ? $date[0] : "2001";
    $month = $date[1];
    $day   = $date[2];
    $hour  = $time[0];
    $min   = $time[1];
    $timestamp = mktime($hour, $min, 0, $month, $day, $year);

    DB_query("INSERT INTO {$_TABLES['forum_topic']} "
        . "(forum, name, date, lastupdated, email, website, subject, "
        . "comment, views, postmode, ip, mood, uid, pid, sticky, locked) "
        . "VALUES ('$forum','$name','$timestamp','$timestamp','$email',"
        . "'$website','$subject','$comment','$hits','$postmode','','',"
        . "'$uid','0','0','0')");
    $parent = DB_insertID();
    PLG_itemSaved($parent, 'forum');
//    $i++;
    $num_posts = 0;
	$comments  = 0;
	
    if (isset($_POST['seltopic']) && $_POST['seltopic'] != 'submissions') {
        $comments = migrateComments($forum, $sid, $parent);
    }
	
    $num_posts = $num_posts + $comments;
    return $num_posts;
}

function migrateComments($forum, $sid, $parent)
{
    global $verbose,$_TABLES,$_CONF,$migratedcomments;

    $sql = "SELECT sid,date,uid,title,comment "
         . "FROM {$_TABLES['comments']} WHERE sid = '$sid' ORDER BY date ASC";
    $result = DB_query($sql);
    $num_comments = DB_numRows($result);
    if ($verbose) {
        echo "Found $num_comments Comments to migrate for this topic";
    }
    $i = 0;
    while (list($sid,$commentdate,$uid,$subject,$comment) = DB_fetchArray($result)) {

        $sqlid = DB_query("SELECT id FROM {$_TABLES['forum_topic']} ORDER BY id DESC LIMIT 1");
        list ($lastid) = DB_fetchArray($sqlid);

        $comment = prepareStringForDB($comment);
        $subject = prepareStringForDB($subject);
        $postmode = "HTML";
        $name = DB_getItem($_TABLES['users'], 'username', "uid=$uid");
        $email = DB_getItem($_TABLES['users'], 'email', "uid=$uid");
        $website = DB_getItem($_TABLES['users'], 'homepage', "uid=$uid");

        $datetime = explode(" ", $commentdate);
        $date = explode("-",$datetime[0]);
        $time = explode(":",$datetime[1]);
        $year  = ($date[0] > 1969) ? $date[0] : "2001";
        $month = $date[1];
        $day   = $date[2];
        $hour  = $time[0];
        $min   = $time[1];
        $timestamp = mktime($hour,$min,0,$month,$day,$year);
        $lastupdated = $timestamp;
        $migratedcomments++;

        DB_query("INSERT INTO {$_TABLES['forum_topic']} "
            . "(forum,name,date,lastupdated, email, website, subject, "
            . "comment, postmode, ip, mood, uid, pid, sticky, locked) "
            . "VALUES ('$forum','$name','$timestamp','$lastupdated','$email',"
            . "'$website','$subject','$comment','$postmode','','',"
            . "'$uid','$parent','0','0')");
        PLG_itemSaved(DB_insertID(), 'forum');
        $i++;
    }

    DB_query("UPDATE {$_TABLES['forum_topic']} SET replies = $num_comments WHERE id=$parent");
    return $num_comments;
}

function prepareStringForDB($message, $postmode="html", $censor=TRUE, $htmlfilter=TRUE)
{
    global $CONF_FORUM;

    if ($censor) {
        $message = COM_checkWords($message);
    }
    if ($postmode == 'html') {
        if ($htmlfilter) {
            // Need to call addslahes again as COM_checkHTML stips it out
            $message = addslashes(COM_checkHTML($message));
        } elseif (!get_magic_quotes_gpc()) {
            $message = addslashes($message);
        }
    } else {
        if (get_magic_quotes_gpc()) {
            $message = @htmlspecialchars($message,ENT_QUOTES,$CONF_FORUM['charset']);
        } else {
            $message = addslashes(@htmlspecialchars($message,ENT_QUOTES,$CONF_FORUM['charset']));
        }
    }
    return $message;
}

function migrate_topicsList($selected='')
{
    global $LANG_GF01;

    $retval = '<select name="seltopic"><option value="all">'
            . $LANG_GF01['ALL'] . '</option>';
    $retval .= '<option value="submissions"';
    if ($selected == "submissions") {
        $retval .= ' selected="selected"';
    }
    $retval .= '>' . $LANG_GF01['SUBMISSIONS'] . '</option>';
    $retval .= TOPIC_getTopicListSelect(array($selected), 0);
    $retval .= '</select>';

    return $retval;
}

$display = '';

// Debug Code to show variables
$display .= gf_showVariables();


// Check if the number of records was specified to show - part of page navigation.
if ($show == 0 AND $CONF_FORUM['show_messages_perpage'] > 0) {
	$show = $CONF_FORUM['show_messages_perpage'];
} elseif ($show == 0) {
	$show = 20;
}

// Check if this is the first page.
if (empty($page)) {
    $page = 1;
}

$display .= COM_startBlock($LANG_GF02['msg193']);

$navbar->set_selected($LANG_GF06['5']);
$display .= $navbar->generate();

$p = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
$p->set_file(array('page'=>'migrate.thtml'));

$p->set_block('page', 'report_record');
$p->set_block('page', 'message');
$p->set_block('page', 'no_records_message');

if (!empty($_GET['num_stories']) && !empty($_GET['num_posts'])) {
    $p->set_var('status_message',
        sprintf($LANG_GF02['msg192'], $_GET['num_stories'], $_GET['num_posts']));
    $p->parse('message','message');
} else {
    $p->set_var('show_message', 'none');
}

if (!empty($curtopic) && $curtopic != 'all') {
    if ($curtopic == "submissions") {
        $table_name = $_TABLES['storysubmission'];
        $sql_part0 = "SELECT ta.tid,s.sid,s.title,s.date,0 AS comments ";
        $sql_part2 = '';
    } else {
        $table_name = $_TABLES['stories'];
        $sql_part0 = "SELECT ta.tid,s.sid,s.title,s.date,s.comments ";
        $sql_part2 = "AND tid='$curtopic' ";
    }
} else {
    $table_name = $_TABLES['stories'];
    $sql_part0 = "SELECT ta.tid,s.sid,s.title,s.date,s.comments ";
    $sql_part2 = '';
}
$sql_part1 = "FROM $table_name AS s, {$_TABLES['topic_assignments']} AS ta "
           . "WHERE ta.id=s.sid AND ta.type='article' ";
           
$sql_part3 = "GROUP BY s.sid ";           

$result = DB_query("SELECT s.sid " . $sql_part1 . $sql_part2 . $sql_part3);
$nrows = DB_numRows($result);
$numpages = ceil($nrows / $show);
$offset = ($page - 1) * $show;

$sql_part4 = "ORDER BY s.sid DESC LIMIT $offset, $show";

$result = DB_query($sql_part0 . $sql_part1 . $sql_part2 . $sql_part3 . $sql_part4);
$nrows = DB_numRows($result);

$p->set_var('action_url', $_CONF['site_admin_url'] . '/plugins/forum/migrate.php');
$p->set_var('filter_topic_selection', migrate_topicsList($curtopic));
$p->set_var('select_filter_options',
    COM_optionList($_TABLES['forum_forums'], "forum_id,forum_name", $selforum));
$p->set_var('LANG_migrate', $LANG_GF01['MIGRATE_NOW']);
$p->set_var('LANG_filterlist', $LANG_GF01['FILTERLIST']);
$p->set_var('LANG_selectforum', $LANG_GF01['SELECTFORUM']);
$p->set_var('LANG_deleteafter', $LANG_GF01['DELETEAFTER']);
$p->set_var('LANG_migratearticles', $LANG_GF01['MIGRATEARTICLES']);
$p->set_var('LANG_all', $LANG_GF01['ALL']);
$p->set_var('LANG_topic', $LANG_GF01['TOPIC']);
$p->set_var('LANG_title', $LANG_GF01['TITLE']);
$p->set_var('LANG_date', $LANG_GF01['DATE']);
$p->set_var('LANG_comments', $LANG_GF01['COMMENTS']);

if ($nrows > 0) {
    $base_url = $_CONF['site_admin_url'] . '/plugins/forum/migrate.php';
    if (!empty($curtopic)) {
        $base_url .= '?tid=' . $curtopic;
    }
    for ($i = 0; $i < $nrows; $i++) {
        list($topic, $sid, $story, $date, $comments) = DB_fetchArray($result);
        $p->set_var('sid', $sid);
        $p->set_var('topic', stripslashes($topic));
        if ($curtopic == "submissions") {
            $story_link = $_CONF['site_admin_url']
                        . '/story.php?mode=editsubmission&amp;id=' . $sid;
        } else {
            $story_link = COM_buildUrl($_CONF['site_url']
                                       . '/article.php?story=' . $sid);
        }
        $p->set_var('story_link', $story_link);
        $p->set_var('story_title', $story);
        $p->set_var('date', $date);
        $p->set_var('num_comments', $comments);
        $p->set_var('cssid', ($i%2)+1);
        $p->parse('report_record', 'report_record', true);
    }
    $p->set_var('pagenavigation', COM_printPageNavigation($base_url, $page, $numpages));
} else {
	$p->set_var ('message', $LANG_GF01['no_articles_found']);
	$p->parse ('no_records_message', 'no_records_message');
}    

$p->set_var('gltoken_name', CSRF_TOKEN);
$p->set_var('gltoken', SEC_createToken());

$p->parse('output', 'page');
$display .= $p->finish($p->get_var('output'));
$display .= COM_endBlock();
$display = COM_createHTMLDocument($display);

COM_output($display);
?>
