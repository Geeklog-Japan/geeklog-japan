<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |                                                                           |
// | Copyright (C) 2000,2001 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

/**
* Include language file
*/
$plugin_path = $_CONF['path'] . 'plugins/forum/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}
/**
 * This language string is inherited from Geeklog Core, which makes
 * it static, so we define it here instead of in the language files.
 */
global $LANG32;

$PLG_forum_MESSAGE3002 = $LANG32[9]; // This plugin requires a newer version of Geeklog

/**
* Add to $_TABLES array the tables forum plugin uses
*/
$_TABLES['forum_userprefs']    = $_DB_table_prefix . 'forum_userprefs';
$_TABLES['forum_topic']        = $_DB_table_prefix . 'forum_topic';
$_TABLES['forum_categories']   = $_DB_table_prefix . 'forum_categories';
$_TABLES['forum_forums']       = $_DB_table_prefix . 'forum_forums';
$_TABLES['forum_watch']        = $_DB_table_prefix . 'forum_watch';
$_TABLES['forum_moderators']   = $_DB_table_prefix . 'forum_moderators';
$_TABLES['forum_banned_ip']    = $_DB_table_prefix . 'forum_banned_ip';
$_TABLES['forum_log']          = $_DB_table_prefix . 'forum_log';
$_TABLES['forum_userinfo']     = $_DB_table_prefix . 'forum_userinfo';

/**
 * DEPRECATED references to tables.
 * Do not use these, as they will be soon removed.
 *
 * TODO: remove these references in version 2.10.0
 */
$_TABLES['gf_userprefs']  = $_DB_table_prefix . 'forum_userprefs';
$_TABLES['gf_topic']      = $_DB_table_prefix . 'forum_topic';
$_TABLES['gf_categories'] = $_DB_table_prefix . 'forum_categories';
$_TABLES['gf_forums']     = $_DB_table_prefix . 'forum_forums';
$_TABLES['gf_watch']      = $_DB_table_prefix . 'forum_watch';
$_TABLES['gf_moderators'] = $_DB_table_prefix . 'forum_moderators';
$_TABLES['gf_banned_ip']  = $_DB_table_prefix . 'forum_banned_ip';
$_TABLES['gf_log']        = $_DB_table_prefix . 'forum_log';
$_TABLES['gf_userinfo']   = $_DB_table_prefix . 'forum_userinfo';

/**
* Load the plugin configuration
*/
$CONF_FORUM = array();
require_once $_CONF['path_system'] . 'classes/config.class.php';
$plg_config = config::get_instance();
$temp = $plg_config->get_config('forum');
if (is_array($temp)) {
    $CONF_FORUM = array_merge($CONF_FORUM, $temp);
}

/**
* Include forum config file
*/
require_once $_CONF['path'] . 'plugins/forum/config.php';

$CONF_FORUM['debug'] = false;

$CONF_FORUM['layout_url']  = $_CONF['site_url'] . '/forum';
$CONF_FORUM['css_smilies_url'] = "{$_CONF['site_url']}/forum/css/smilies.css.php";
$CONF_FORUM['imgset']       = CTL_plugin_dirLocation('forum', 'image_set', true);
$CONF_FORUM['imgset_path']  = CTL_plugin_dirLocation('forum', 'image_set', false);
$CONF_FORUM['path_include'] = $_CONF['path'] . 'plugins/forum/include/';
$CONF_FORUM['charset']      = COM_getCharset();
$CONF_FORUM['add_forum_menu_check'] = 0; // Reset Check to false. If needed it is set to true in gf_format.php where then used by plugin_getBlocks_forum

// User Preference Config Parms. Check if user has set their preference or use defaults
if (!empty($_USER['uid']) AND ($_USER['uid'] > 1) AND DB_getItem($_TABLES['forum_userprefs'],"uid","uid='{$_USER['uid']}'") == $_USER['uid']) {
    $sql = DB_query("Select * FROM {$_TABLES['forum_userprefs']} WHERE uid = '{$_USER['uid']}'");
    $userprefs = DB_fetchArray($sql);
    $CONF_FORUM['show_topics_perpage']  = $userprefs['topicsperpage'];
    $CONF_FORUM['show_posts_perpage']   = $userprefs['postsperpage'];
    $CONF_FORUM['popular_limit']        = $userprefs['popularlimit'];
    $CONF_FORUM['show_members_perpage'] = $userprefs['membersperpage'];
    $CONF_FORUM['show_search_perpage']  = $userprefs['searchlines'];
    $CONF_FORUM['show_topicreview']     = $userprefs['showiframe'];
    $CONF_FORUM['show_anonymous_posts'] = $userprefs['viewanonposts'];
    $CONF_FORUM['notify_once']          = $userprefs['notify_once'];
}

$CONF_FORUM['installed_version'] = floatval(DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'forum'"));

/**
* Initialise the handling of smilies
*/
require_once $CONF_FORUM['path_include'] . 'ForumSmilies.class.php';
$_SMILIES = new ForumSmilies();

/**
* Returns the items for this plugin that should appear on the main menu
*/
function plugin_getmenuitems_forum()
{
    global $CONF_FORUM,$_CONF,$LANG_GF00;
    if ($CONF_FORUM['registration_required'] == 0 || SEC_hasRights('forum.user')) {
        $menuitems["{$LANG_GF00['pluginlabel']}"] = "{$_CONF['site_url']}/forum/index.php";
        return $menuitems;
    }
}


function plugin_autotags_forum($op,$content='',$autotag='') {
    global $_CONF, $LANG_GF00;

    if ($op == 'tagname') {
        return 'forum';
    } elseif ($op == 'description') {
        return array('forum' => $LANG_GF00['autotag_desc_forum']);
    } elseif ($op == 'parse') {
        $id = COM_applyFilter($autotag['parm1']);
        if (!empty($id)) {
            $linktext = 'here';
            if (!empty($autotag['parm2'])) $linktext = $autotag['parm2'];
            $url = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $id;
            $filelink = COM_createLink($linktext, $url);
            $content = str_replace($autotag['tagstr'], $filelink, $content);
        }
        return $content;
    }
}


/**
* This will put an option for forum admin in the command and control block on moderation.php
*
*/
function plugin_cclabel_forum()
{
    global $_CONF;
    if (SEC_hasRights('forum.edit')) {
        return array('Forum',$_CONF['site_admin_url'] . "/plugins/forum/index.php",$_CONF['site_url'] . '/forum/images/forum.png');
    }
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_forum()
{
    global $_TABLES, $_CONF, $LANG_GF00;

    if (SEC_hasRights('forum.edit')) {
        $numtopics = DB_getItem($_TABLES['forum_topic'],"COUNT(*)");
        return array($LANG_GF00['pluginlabel'], $_CONF['site_admin_url'] . '/plugins/forum/index.php', $numtopics);
    }
}

/**
* Returns the user menuitem option for this plugin
* Only one menu item can be returned.
*/
function plugin_getuseroption_forum()
{
    global $CONF_FORUM, $_CONF, $LANG_GF00;

    if ($CONF_FORUM['registration_required'] == 0 || SEC_hasRights('forum.user')) {
        return array($LANG_GF00['useradminmenu'], $_CONF['site_url'] . '/forum/userprefs.php', 0);
    }
}


function plugin_user_create_forum ($uid)
{
    global $_TABLES;

    DB_query ("INSERT INTO {$_TABLES['forum_userinfo']} (uid) VALUES ('{$uid}')");
}

/**
* Called if admin deletes a user - Removes any moderator and Watch Records for user
*/
function plugin_user_delete_forum ($uid)
{
    global $_TABLES;

    DB_query("DELETE FROM {$_TABLES['forum_moderators']} WHERE mod_uid ='$uid'");
    DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid ='$uid'");
    DB_query("DELETE FROM {$_TABLES['forum_userinfo']} WHERE uid ='$uid'");
    DB_query("DELETE FROM {$_TABLES['forum_userprefs']} WHERE uid ='$uid'");
    DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE uid ='$uid'");
    DB_query("UPDATE {$_TABLES['forum_topic']} SET uid = 1 WHERE uid = '$uid'");
}

function plugin_profileextrassave_forum()
{
    global $_CONF,$_USER, $HTTP_POST_VARS, $_TABLES, $CONF_FORUM;

    require_once $CONF_FORUM['path_include'] . 'gf_format.php';
    $uid = $_USER['uid'];
    if ($uid > 1) {
        $aim        = gf_preparefordb($_POST['forum_aim'],'html');
        $icq        = gf_preparefordb($_POST['forum_icq'],'html');
        $yim        = gf_preparefordb($_POST['forum_yim'],'html');
        $msnm       = gf_preparefordb($_POST['forum_msnm'],'html');
        $interests  = gf_preparefordb($_POST['forum_interests'],'html');
        $occupation = gf_preparefordb($_POST['forum_occupation'],'html');
        DB_save ($_TABLES['forum_userinfo'], "uid,aim,yim,icq,msnm,interests,occupation",
                 "'$uid','$aim','$yim','$icq','$msnm','$interests','$occupation'");
   }
}


function plugin_profilevariablesedit_forum($uid, &$template)
{
    global $_TABLES, $LANG_GF04;

    $result = DB_query ("SELECT uid,aim,yim,icq,yim,msnm,interests,occupation FROM {$_TABLES['forum_userinfo']} WHERE uid = $uid");
    $A = DB_fetchArray ($result);
    $template->set_var('forum_aim', $A['aim']);
    $template->set_var('forum_icq', $A['icq']);
    $template->set_var('forum_yim', $A['yim']);
    $template->set_var('forum_msnm', $A['msnm']);
    $template->set_var('forum_interests', $A['interests']);
    $template->set_var('forum_occupation', $A['occupation']);

    $template->set_var ('lang_forum', $LANG_GF04['label_forum']);
    $template->set_var ('lang_aim', $LANG_GF04['label_aim']);
    $template->set_var ('lang_icq', $LANG_GF04['label_icq']);
    $template->set_var ('lang_yim', $LANG_GF04['label_yim']);
    $template->set_var ('lang_msnm', $LANG_GF04['label_msnm']);
    $template->set_var ('lang_interests', $LANG_GF04['label_interests']);
    $template->set_var ('lang_occupation', $LANG_GF04['label_occupation']);
}

function plugin_profilevariablesdisplay_forum ($uid, &$template)
{

    global $_TABLES, $_CONF, $LANG_GF02, $LANG_GF04;
    $postlimit = "10";        // How many posts you want displayed

    $query = DB_query ("SELECT id,date,forum,subject FROM {$_TABLES['forum_topic']} WHERE uid = {$uid} ORDER BY date DESC LIMIT 100");
    $numposts = 0;

    while (list($postid,$date,$forum_id,$subject) = DB_fetchArray($query))  {
        $grp_id = DB_getItem($_TABLES['forum_forums'],'grp_id',"forum_id='$forum_id'");
        $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='$grp_id'");
        if (SEC_inGroup($groupname) OR $grp_id == 2) {
            $numposts++;
            $postdate = COM_getUserDateTimeFormat ($date);
            $template->set_var ('row_number', $numposts . '.');
            $articleUrl = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $postid;
            $template->set_var('story_title',
                COM_createLink(
                    stripslashes($subject),
                    $articleUrl,
                    array('class'=>'b'))
            );
            $template->set_var ('story_date', $postdate[0]);
            $template->parse ('forum_post_row', 'strow', true);
            if ($numposts >= $postlimit) {
                break;
            }
        }
    }

    if ($numposts == 0) {
        $template->set_var ('forum_post_row', '<tr><td>' .$LANG_GF02['msg155']. '</td></tr>');
    }

    $count = DB_count ($_TABLES['forum_topic'], 'uid', $uid);
    $template->set_var ('forum_lang_number_posts', $LANG_GF02['msg156']);
    $template->set_var ('forum_number_posts', $count);
    
    $username = DB_getItem ($_TABLES['users'], 'username', "uid = $uid");
    $title = sprintf($LANG_GF02['msg158'], $postlimit, $username);
    $template->set_var ('forum_start_block_last10posts', COM_startBlock
        ($title));    
    $template->set_var ('forum_headline_last10posts', $LANG_GF02['msg157']);

    /* Display Instant Messaging Handles */
    $result = DB_query ("SELECT uid,aim,yim,icq,yim,msnm,interests,occupation FROM {$_TABLES['forum_userinfo']} WHERE uid = $uid");
    $A = DB_fetchArray ($result);
    $template->set_var('forum_aim', $A['aim']);
    $template->set_var('forum_icq', $A['icq']);
    $template->set_var('forum_yim', $A['yim']);
    $template->set_var('forum_msnm', $A['msnm']);
    $template->set_var('forum_interests', $A['interests']);
    $template->set_var('forum_occupation', $A['occupation']);

    $template->set_var ('lang_forum', $LANG_GF04['label_forum']);
    $template->set_var ('lang_aim', $LANG_GF04['label_aim']);
    $template->set_var ('lang_icq', $LANG_GF04['label_icq']);
    $template->set_var ('lang_yim', $LANG_GF04['label_yim']);
    $template->set_var ('lang_msnm', $LANG_GF04['label_msnm']);
    $template->set_var ('lang_interests', $LANG_GF04['label_interests']);
    $template->set_var ('lang_occupation', $LANG_GF04['label_occupation']);
}

function plugin_statssummary_forum() {
    global $_CONF, $_TABLES, $LANG_GF00;

    // This shows in the summary box
    $total_items = DB_count($_TABLES['forum_topic']);      // Total number of Forum Posts
    $summary_label = $LANG_GF00['statslabel'];
    $retval[] = $summary_label;
    $retval[] = $total_items;
    return $retval;
}

/**
* shows the statistics for the plugin when stats.php is called.
* If $showsitestats is 1 then we are to only print the overall stats in the 'site statistics box'
* otherwise we show the detailed stats for the photo album
*
* @showsitestate        int         Flag to let us know which stats to get
*/
function plugin_showstats_forum($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_GF00,$LANG_GF01, $CONF_FORUM;

    // Use themes stats template files
    $stat_templates = COM_newTemplate($_CONF['path_layout'] . '/stats');
    $stat_templates->set_file(array('itemstats'=>'itemstatistics.thtml',
                            'statrow'=>'singlestat.thtml'));
    
    $retval = '';

    $header_arr = array(
        array('text' => $LANG_GF01['TOPICSUBJECT'], 'field' => 'topicsubject'),
        array('text' => $LANG_GF01['VIEWS'], 'field' => 'views'),
    );
    $data_arr = array();
    $text_arr = array('has_menu'     => false,
                      'title'        => $LANG_GF00['statsheading1'],
    );
    $result = DB_query("SELECT forum,subject,views,id FROM {$_TABLES['forum_topic']} WHERE pid='0' ORDER BY views DESC");
    $nrows  = DB_numRows($result);
    if ($nrows > 0) {
        $displaycount = 0;
        while (list ($forum,$subject, $views,$id) = DB_fetchARRAY($result)) {
            $forum_id = DB_getItem($_TABLES['forum_topic'],'forum',"id='$id'");
            $grp_id = DB_getItem($_TABLES['forum_forums'],'grp_id',"forum_id='$forum_id'");
            $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='$grp_id'");
            if (SEC_inGroup($groupname) OR $grp_id == 2) {
                $url = $_CONF['site_url']. "/forum/viewtopic.php?showtopic=$id";
                $S['topicsubject'] = '<a href="' . $url . '">' . $subject . '</a>';
                $S['views']  = $views;
                $data_arr[$displaycount] = $S;
                $displaycount++;
                if ($displaycount > 10) {
                    break;
                }
            }
        }
        $retval .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    } else {
        $retval .= $LANG_GF00['statsheading3'];
    }
    $header_arr = array(
        array('text' => $LANG_GF01['TOPICSUBJECT'], 'field' => 'topicsubject'),
        array('text' => $LANG_GF01['REPLIES'], 'field' => 'replies'),
    );
    $data_arr = array();
    $text_arr = array('has_menu'     => false,
                      'title'        => $LANG_GF00['statsheading2'],
    );
    $result = DB_query("SELECT forum,subject,replies,id FROM {$_TABLES['forum_topic']} WHERE pid='0' ORDER BY replies DESC");
    $nrows  = DB_numRows($result);
    if ($nrows > 0) {
        $stat_templates->set_var('item_label',$LANG_GF01['TOPICSUBJECT']);
        $stat_templates->set_var('stat_name',$LANG_GF01['REPLIES']);
        $displaycount=0;
        while (list ($forum,$subject, $replies,$id) = DB_fetchARRAY($result)) {
            $forum_id = DB_getItem($_TABLES['forum_topic'],'forum',"id='$id'");
            $grp_id = DB_getItem($_TABLES['forum_forums'],'grp_id',"forum_id='$forum_id'");
            $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='$grp_id'");
            if (SEC_inGroup($groupname) OR $grp_id == 2) {
                $url = $_CONF['site_url']. "/forum/viewtopic.php?showtopic=$id";
                $url = $_CONF['site_url']. "/forum/viewtopic.php?showtopic=$id";
                $S['topicsubject'] = '<a href="' . $url . '">' . $subject . '</a>';
                $S['replies']  = $replies;
                $data_arr[$displaycount] = $S;
                $displaycount++;
                if ($displaycount > 10) {
                    break;
                }
            }
        }
        $retval .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    } else {
        $retval .= $LANG_GF00['statsheading3'];
    }
    
    return $retval;
}


/**
* Geeklog is asking us to provide any new items that show up in the type drop-down
* on search.php.  Let's let users search the Filelistings in the Filemgmt Plugin
*
*/
function plugin_searchtypes_forum()
{
    global $LANG_GF00;

    $tmp['forum'] = $LANG_GF00['searchlabel'];
    return $tmp;
}


/**
* this searches for files matching the user query and returns an array of
* for the header and table rows back to search.php where it will be formated and
* printed
*
* @param    string  $query      Keywords user is looking for
* @param    date    $datestart  Start date to get results for
* @param    date    $dateend    End date to get results for
* @param    string  $topic      The topic they were searching in
* @param    string  $type       Type of items they are searching, or 'all' (deprecated)
* @param    int     $author     Get all results by this author
* @param    string  $keyType    search key type: 'all', 'phrase', 'any'
* @param    int     $page       page number of current search (deprecated)
* @param    int     $perpage    number of results per page (deprecated)
* @return   object              search result object
*
*/
function plugin_dopluginsearch_forum($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $LANG_GF01, $_TABLES, $_GROUPS;

    // Make sure the query is SQL safe
    $query = trim(addslashes($query));

    $sql = "SELECT ft.id, ft.date, ft.subject AS title, ft.comment AS description, ft.views AS hits, ft.uid, "
         . "CONCAT('/forum/viewtopic.php?showtopic=', ft.id) AS url "
         . "FROM {$_TABLES['forum_topic']} ft, {$_TABLES['forum_forums']} ff "
         . "WHERE ft.forum = ff.forum_id AND (ff.grp_id IN ('" . implode( "','", $_GROUPS ) . "')) AND ft.date <> 1 ";

	if (!empty($datestart) || !empty($dateend)) {
		// Do some date checking and fill in missing dates
		$delim = '-';
		if (empty($datestart) || (strtotime($datestart) == false)) {
			$datestart = "0000-00-00";
		} else {
			$datestart = date('Y-m-d', strtotime($datestart));
		}
		if (empty($dateend) || (strtotime($dateend) == false)) {
			$dateend = date('Y-m-d');
		} else {
			$dateend = date('Y-m-d', strtotime($dateend));
		}
		
		$DS = explode($delim, $datestart);
		$DE = explode($delim, $dateend);
		$startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
		$enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
		
		//return " $type (UNIX_TIMESTAMP($column) BETWEEN '$startdate' AND '$enddate') ";
		$sql .= "AND (date BETWEEN '$startdate' AND '$enddate') ";
	}
	
    if (!empty($author)) {
        $sql .= "AND (uid = '$author') ";
    }

    $search = new SearchCriteria('forum', $LANG_GF01['FORUM']);
    $columns = array('title' => 'subject', 'comment');
    list($sql,$ftsql) = $search->buildSearchSQL($keyType, $query, $columns, $sql);
    $search->setSQL($sql);
    $search->setFTSQL($ftsql);
    $search->setRank(3);
    $search->setAppendQuery(false);

    return $search;
}


/* RSS FEED Related API functions */

function plugin_getfeednames_forum ()
{
    global $_TABLES;

    $feeds = array ();
    $result = DB_query ("SELECT forum_id,forum_name FROM {$_TABLES['forum_forums']} ORDER BY forum_order");
    $num = DB_numRows ($result);

    if ($num > 0) {
        $feeds[] = array ('id' => '0', 'name' => 'all forums');
    }

    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray ($result);
        $feeds[] = array ('id' => $A['forum_id'], 'name' => $A['forum_name']);
    }

    return $feeds;
}

function forum_buildFeedsSql ($forumID, $limits)
{
    global $CONF_FORUM;

    $where = '';
    if ($CONF_FORUM['installed_version'] < 2.6) {
        return '';
    }

    $groups = array ();
    $usergroups = SEC_getUserGroups(1);
    foreach ($usergroups as $group) {
        $groups[] = $group;
    }
    $grouplist = implode(',',$groups);

    if ($forumID > 0) {
        $where = " WHERE forum=$forumID AND no_newposts=0 AND forum.grp_id IN ($grouplist) ";
    } else {
        $where = " WHERE no_newposts=0 AND forum.grp_id IN ($grouplist) ";
    }
    $limitsql = '';
    if (!empty ($limits)) {
        if (substr ($limits, -1) == 'h') { // last xx hours
            $limitsql = '';
            $hours = substr ($limits, 0, -1);
            if (!empty ($where)) {
                $where .= ' AND ';
            }
            $where .= "date >= DATE_SUB(NOW(),INTERVAL $hours HOUR) ORDER BY date DESC";
        } else {
            $limitsql = ' ORDER BY date DESC LIMIT ' . $limits;
        }
    }
    else
    {
        $limitsql = ' ORDER BY date DESC LIMIT 10';
    }

    $sql = $where . $limitsql;

    return $sql;
}

function plugin_getfeedcontent_forum ($feed, &$link, &$update)
{
    global $_CONF, $_TABLES, $CONF_FORUM, $LANG_GF01;

    $content = array();
    $lids = array();
    $ids = array();

    if ($CONF_FORUM['installed_version'] < 2.6) {
        return $content;
    }

    $allow_smilies = $CONF_FORUM['allow_smilies'];
    $CONF_FORUM['allow_smilies']=0;

    require_once $CONF_FORUM['path_include'] . 'gf_format.php';
    if ( !function_exists('str_ireplace'))
    {
        require_once 'PHP/Compat.php';
        PHP_Compat::loadFunction( 'str_ireplace' );
    }
    require_once $CONF_FORUM['path_include'] . 'bbcode/stringparser_bbcode.class.php';

    $result = DB_query ("SELECT topic,limits,content_length FROM {$_TABLES['syndication']} WHERE fid = $feed");
    $F = DB_fetchArray ($result);

    $sql = "SELECT topic.id,topic.forum,topic.subject,topic.uid,topic.name,topic.comment,topic.date,topic.postmode,forum.forum_name,forum.grp_id ";
    $sql .= "FROM {$_TABLES['forum_topic']} topic LEFT JOIN {$_TABLES['forum_forums']} forum ON topic.forum=forum.forum_id ";
    $sql .= forum_buildFeedsSql ($F['topic'], $F['limits']);
    $result = DB_query ($sql);

    while ( $A=DB_fetchArray($result) ) {
        $preface = '';
        if ($F['content_length'] == 0) {
            $comment = '';
        } elseif ($F['content_length'] > 1) {
            $comment = COM_truncate($A['comment'], $F['content_length'], '...');
        } else {
            $comment = $A['comment'];
            $preface = $LANG_GF01['BY'] . ' ';
            if ( $A['uid'] > 1 ) {
                $preface .= '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '">' . $A['name'] . '</a>';
            } else {
                $preface .= $A['name'];
            }
            $preface .= '<br' . XHTML . '><br' . XHTML . '>';
        }
        // Handle Pre ver 2.5 quoting and New Line Formatting - consider adding this to a migrate function
        if ($CONF_FORUM['pre2.5_mode']) {
            if ( stristr($comment,'[code') == false ) {
                $comment = str_replace('<pre>','[code]',$comment);
                $comment = str_replace('</pre>','[/code]',$comment);
            }
            $comment = str_replace(array("<br" . XHTML . ">\r\n","<br" . XHTML . ">\n\r","<br" . XHTML . ">\r","<br" . XHTML . ">\n"), '<br' . XHTML . '>', $comment );
            $comment = preg_replace("/\[QUOTE\sBY=\s(.+?)\]/i","[QUOTE] Quote by $1:",$comment);
            /* Reformat code blocks - version 2.3.3 and prior */
            $comment = str_replace( '<pre class="forumCode">', '[code]', $comment );
            $comment = preg_replace("/\[QUOTE\sBY=(.+?)\]/i","[QUOTE] Quote by $1:",$comment);
        }

        $comment = gf_formatTextBlock($comment,$A['postmode'],'preview');

        $comment = str_replace('{','&#123;',$comment);
        $comment = str_replace('}','&#125;',$comment);

        // we don't have a stylesheet in the news feed, so replace our div with the style...
        $comment = str_replace('<div class="quotemain">','<div style="border: 1px dotted #000;border-left: 4px solid #8394B2;color:#465584;  padding: 4px;  margin: 5px auto 8px auto;">',$comment);

        $desc = $preface . $comment;

        $link = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}";

        $content[] = array ('title'     => $A['forum_name'] . ' :: ' . $A['subject'],
                            'summary'   => $desc,
                            'text'      => $desc,
                            'link'      => $link,
                            'uid'       => $A['uid'],
                            'date'      => $A['date'],
                            'format'    => $A['postmode'],
                           );
        $ids[] = $A['id'];
    }

    if ($F['topic'] == 0) {
        $link = "{$_CONF['site_url']}/forum/index.php";
    } else {
        $link = "{$_CONF['site_url']}/forum/index.php.php?forum={$F['topic']}";
    }

    if (count($ids) > 0 ) {
        $update = implode (',', $ids);
    }

    $CONF_FORUM['allow_smilies'] = $allow_smilies;

    return $content;
}

function plugin_feedupdatecheck_forum ($feed, $topic, $update_data, $limit)
{
    global $_TABLES;

    $sql = "SELECT id,forum.grp_id FROM {$_TABLES['forum_topic']} topic LEFT JOIN {$_TABLES['forum_forums']} forum ON topic.forum=forum.forum_id " . forum_buildFeedsSql ($topic, $limits);
    $result = DB_query ($sql);
    $num = DB_numRows ($result);

    $ids = array ();
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray ($result);
        $ids[] = $A['id'];
    }
    $current = implode (',', $ids);

    //COM_errorLog ("Update check for downloads: comparing new list ($current) with old list ($update_data)", 1);

    return ( $current != $update_data ) ? false : true;
}

/* End of RSS Feed Related Functions */



/**
* Called by the plugin Editor to display the current plugin code version
* This may be different then the version installed and registered currently.
* If newer then you may want to run the update
*/
function plugin_chkVersion_forum() {
    global $_CONF;
    static $pi_version = NULL;

    if ($pi_version === NULL) {
        require_once $_CONF['path'] . 'plugins/forum/autoinstall.php';
        $inst_parms = plugin_autoinstall_forum('forum');
        $pi_version = $inst_parms['info']['pi_version'];
    }
    return $pi_version;
}


/**
* Called by the plugin Editor to run the SQL Update for a plugin update
*/
function plugin_upgrade_forum() {
    global $_CONF, $_TABLES, $CONF_FORUM;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'forum'");
    $code_version = plugin_chkVersion_forum();
    if ($installed_version == $code_version) return true; // nothing to do

    require_once $_CONF['path'] . 'plugins/forum/autoinstall.php';
    if (!plugin_compatible_with_this_version_forum('forum')) return 3002;
    
    $current_version = $installed_version;

    // Include the upgrade functions
    require_once $_CONF['path'] . 'plugins/forum/upgrade.inc';

    $done = false;
    while (!$done) {
        switch ($current_version) {
            case "2.3" :
            case "2.3.2" :
                if (upgrade_232() != 0) break 2;

                $current_version = "2.5RC1";
                
                break;

            case "2.5RC1" :
                if (upgrade_25() != 0) break 2;
                
                $current_version = "2.6";
                
                break;

            case "2.6" :
            case "2.7" :
            case "2.7.1" :
            case "2.7.2" :
            case "2.7.2.JPr5" :
            case "2.7.2.JPr6" :
            case "2.7.3" :
            case "2.7.3.JPr1" :
            case "2.7.4" :
            case "2.7.4.JPr1" :
            case "2.7.5.JPr1" :
                if (upgrade_274() != 0) break 2;
                
                $current_version = "2.8.0";

                break;

            case "2.8.0" :
                if (upgrade_280() != 0) break 2;
                
                $current_version = "2.9.0";

                break;

            case "2.9.0" :
                if (upgrade_290() != 0) break 2;

                $current_version = "2.9.1";
                
                break;
                
            case "2.9.1" :

                $current_version = "2.9.2";
                
                break;                

            default:
                $done = true;
                break;
        }
    }

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$installed_version' WHERE pi_name = 'forum'");
    
    // Check if update completed and return a message number to be shown
    if (DB_getItem($_TABLES['plugins'],'pi_version',"pi_name = 'forum'") == $code_version) {
        return 1;
    } else {
        return 5;
    }
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_forum($old_conf)
{
    global $_CONF;

    $tables = array(
        'forum_topic'      => 'id, comment',
        'forum_categories' => 'id, cat_dscp',
        'forum_forums'     => 'forum_id, forum_dscp'
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_forum()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('forum_topic','forum_categories','forum_forums',
                          'forum_watch','forum_moderators','forum_banned_ip',
                          'forum_log', 'forum_userprefs','forum_userinfo'),
        /* give the full name of the group, as in the db */
        'groups' => array('forum Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('forum.edit', 'forum.user'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array('phpblock_forum_newposts', 'phpblock_forum_menu'), // Keep this in for old installs
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
}

/**
* Return information for a topic
*
* @param    string  $id         link ID or '*'
* @param    string  $what       comma-separated list of properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
*/
function plugin_getiteminfo_forum($id, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
        case 'date-modified':
            $fields[] = 'date';
            break;
        case 'description':
        case 'excerpt':
            $fields[] = 'comment';
            break;
        case 'id':
            $fields[] = 'id';
            break;
        case 'title':
            $fields[] = 'subject';
            break;
        case 'url':
            // needed for $id == '*', but also in case we're only requesting
            // the URL (so that $fields isn't emtpy)
            $fields[] = 'id';
            break;
        default:
            // nothing to do
            break;
        }
    }

    $fields = array_unique($fields);

    if (count($fields) == 0) {
        $retval = array();

        return $retval;
    }

    // prepare SQL request
    if ($id == '*') {
        $where = '';
        $permOp = 'WHERE';
    } else {
        $where = " WHERE id = '" . addslashes($id) . "'";
        $permOp = 'AND';
    }
    
    $sql = "SELECT " . implode(',', $fields)
            . " FROM {$_TABLES['forum_topic']}" . $where;
    if ($id != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $props = array();
        foreach ($properties as $p) {
            switch ($p) {
            case 'date-modified':
                $props['date-modified'] = $A['date'];
                break;
            case 'description':
            case 'excerpt':
                $props[$p] = stripslashes($A['comment']);
                break;
            case 'id':
                $props['id'] = $A['id'];
                break;
            case 'title':
                $props['title'] = stripslashes($A['subject']);
                break;
            case 'url':
                if (empty($A['id'])) {
                    $props['url'] = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $id;
                } else {
                    $props['url'] = $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $A['id'];
                }
                break;
            default:
                // return empty string for unknown properties
                $props[$p] = '';
                break;
            }
        }

        $mapped = array();
        foreach ($props as $key => $value) {
            if ($id == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($id == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($id != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

function phpblock_forum_newposts() {
    global $_CONF, $_USER, $_TABLES, $LANG_GF01, $LANG_GF02, $CONF_FORUM;

    $post_limit = $CONF_FORUM['sideblock_numposts'];
    if ($CONF_FORUM['installed_version'] < 2.6) {
        return;
    }

    $mode  = isset($_GET['mode'])  ? COM_applyFilter($_GET['mode'])  : '';
    $order = isset($_GET['order']) ? COM_applyFilter($_GET['order']) : '';

    if (DB_getItem($_TABLES['plugins'],'pi_enabled', 'pi_name="forum"')) {
        // Check if user has clicked on a sort option in the block
        if ($mode == 'forumblock') {
            if (($order == 'new') OR ($order == '')) {
                $view_modemsg = sprintf($LANG_GF02['msg74'],$post_limit);
                if ($CONF_FORUM['sb_latestpostonly']) {
                    $orderby = 'lastupdated';
                } else {
                    $orderby = 'date';
                }
            } elseif ($order == 'views') {
                $view_modemsg = sprintf($LANG_GF02['msg75'],$post_limit);
                $orderby = 'views';
            } elseif ($order == 'posts') {
                $view_modemsg = sprintf($LANG_GF02['msg76'],$post_limit);
                $orderby = 'replies';
            }
        } else {
            $view_modemsg = sprintf($LANG_GF02['msg74'],$post_limit);
                if ($CONF_FORUM['sb_latestpostonly']) {
                    $orderby = 'lastupdated';
                } else {
                    $orderby = 'date';
                }
        }

        $block = COM_newTemplate(CTL_plugin_templatePath('forum', 'blocks'));
        $block->set_file (array ('block'=>'latestpostsblock.thtml'));
        
        $block->set_block('block', 'block_record');
        
        $block->set_var ('phpself', $_CONF['site_url'] .'/index.php');
        $block->set_var ('layout_url', $CONF_FORUM['layout_url']);
        $block->set_var ('LANG_ORDERBY', $LANG_GF01['ORDERBY']);
        $block->set_var ('LANG_NEW', $LANG_GF01['NEW']);
        $block->set_var ('LANG_VIEWS', $LANG_GF01['VIEWS']);
        $block->set_var ('LANG_POSTS', $LANG_GF01['POSTS']);
        $block->set_var ('view_modemsg', $view_modemsg);

        // Select SQL to either show the latest posts even if they are for the same topic
        // Or show only the lastest post for each of the last updated topics
        if ($CONF_FORUM['sb_latestpostonly']) {
            $sql = "SELECT a.id,a.forum,a.name,a.date,a.subject,a.replies,a.views,a.uid,a.pid FROM {$_TABLES['forum_topic']} a ";
            $sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON a.forum=b.forum_id ";
            $sql .= "WHERE a.pid=0 AND b.no_newposts = 0 ORDER BY $orderby DESC";
            $result = DB_query($sql);
        } else {
            $sql = "SELECT a.id,a.forum,a.name,a.date,a.subject,a.replies,a.views,a.uid,a.pid FROM {$_TABLES['forum_topic']} a ";
            $sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON a.forum=b.forum_id ";
            $sql .= "WHERE b.no_newposts = 0 ORDER BY $orderby DESC";
            $result = DB_query($sql);
        }

        $nrows  = DB_numrows($result);
        if ($nrows == 0) {
            return;
        }
        $onetwo = 1;
        $displaycount = 0;

        for ($i =1; $i <= $nrows; $i++) {

            $A = DB_fetchArray($result,false);
            if (trim($A['subject']) == '') {
                $A['subject'] = DB_getItem($_TABLES['forum_topic'],'subject',"id='{$A['pid']}'");
            }

            $fresult = DB_query ("SELECT grp_id, no_newposts FROM {$_TABLES['forum_forums']} WHERE forum_id='{$A['forum']}'");
            list ($grp_id, $no_newposts) = DB_fetchArray ($fresult);
            $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='$grp_id'");

            if ($no_newposts==0 AND (SEC_inGroup($groupname) OR $grp_id == 2)) {
                $displaycount++;
                $fullsubject = $A['subject'];
                if (strlen ($A['subject']) > $CONF_FORUM['sb_subject_size']) {
                    $A['subject'] = COM_truncate($A['subject'], $CONF_FORUM['sb_subject_size'], '..');
                    $profilelink = '';
                }

                if ($A['replies'] > 0 AND $CONF_FORUM['sb_latestpostonly']) {
                    $lastreplySQL = DB_query("SELECT uid,name,date FROM {$_TABLES['forum_topic']} WHERE pid={$A['id']} ORDER BY date DESC LIMIT 1");
                    list ($uid,$postername,$postdate) = DB_fetchArray($lastreplySQL);
                } else {
                    $postername = $A['name'];
                    $postdate = $A['date'];
                    $uid = $A['uid'];
                }
                if ($uid > 1) {
                    $postername = COM_getDisplayName($uid);
                    $profilelink = "<a href='{$_CONF['site_url']}/users.php?mode=profile&amp;uid={$uid}'>";
                } else {
                    $profilelink = '';
                }

                if ($profilelink != '') {
                    $postername = $profilelink . $postername . '</a>';
                }

                $block->set_var ('css_id', $onetwo);
                $block->set_var ('img_dir', $CONF_FORUM['imgset']);
                $block->set_var ('forum_id', $A['forum']);
                $block->set_var ('forum_name', DB_getItem($_TABLES['forum_forums'],'forum_name',"forum_id='{$A['forum']}'"));
                $block->set_var ('topic_id', $A['id']);
                $block->set_var ('topic_subject', $A['subject']);
                $block->set_var ('fullsubject', $fullsubject);
                $block->set_var ('topic_id', $A['id']);
                $block->set_var ('user_name', $postername);
                $block->set_var ('LANG_BY', $LANG_GF01['BY']);
                $block->set_var ('LANG_ON', $LANG_GF01['ON']);
                $block->set_var ('LANG_VIEWS', $LANG_GF01['VIEWS']);
                $block->set_var ('LANG_REPLIES', $LANG_GF01['REPLIES']);
                $block->set_var ('views', $A['views']);
                $block->set_var ('replies', $A['replies']);
                if ($CONF_FORUM['allow_user_dateformat']) {
                    $date = COM_getUserDateTimeFormat ($postdate);
                    $block->set_var ('date', $date[0]);
                } else {
                    $block->set_var ('date', strftime($CONF_FORUM['default_Datetime_format'], $postdate));
                }

                $block->parse ('block_record', 'block_record',true);

                if ($onetwo == 1) {
                    $onetwo = 2;
                } else {
                    $onetwo = 1;
                }
                if ($displaycount >= $CONF_FORUM['sideblock_numposts']) {
                    break;
                }
            }
        }

        if ($displaycount == 0) {
            return;
        }

        $block->parse ('output', 'block');
        $retval = $block->finish($block->get_var('output'));
        return $retval;
    } else {
        return;
    }
}


/**
* Display latest forum posts in the center block.
*
* @param   where   int      where the block will be displayed (0..2)
* @param   page    int      page number
* @param   topic   string   topic ID
* @return          string   HTML for the center blcok (can be empty)
*/
function plugin_centerblock_forum ($where = 1, $page = 1, $topic = '')
{
    global $_CONF, $_USER, $_TABLES, $LANG_GF01, $CONF_FORUM;
    global $LANG_GF02, $mode, $order;

    //$TIMER = new timerobject();
    //$TIMER->startTimer();
    //$exectime = $TIMER->stopTimer();

    if ($CONF_FORUM['installed_version'] < 2.6) {
        return;
    }

    if ($CONF_FORUM['registration_required'] && $_USER['uid'] < 2) {
        return;
    }

    $retval = '';

    $cb_enable = $CONF_FORUM['show_centerblock'];
    $cb_where  = $CONF_FORUM['centerblock_where'];

    // If enabled only for homepage and this is not page 1 or a topic page,
    // then set disable flag
    if ($CONF_FORUM['centerblock_homepage'] == 1 AND ($page > 1 OR !empty ($topic))) {
        $cb_enable = 0;
    } elseif ($CONF_FORUM['centerblock_homepage'] == 0 and $page > 1) {
        $cb_where = 1;      // Top of Page
    }

    // Check if there are no featured articles in this topic
    // and if so then place it at the top of the page
    if (!empty ($topic)) {
        $fromsql = ", {$_TABLES['topic_assignments']} ta";
        $wheresql = "WHERE ta.id = sid AND ta.tid='$topic' AND featured > 0";
    } else {
        $fromsql = '';
        $wheresql = 'WHERE featured = 1';
    }
    $query = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} $fromsql $wheresql");
    $result = DB_fetchArray ($query);
    if ($result['count'] == 0 and $cb_where == 2) {
        $cb_where = 1;
    }

    if (!$cb_enable OR $cb_where != $where) {
        return;
    }

    $block = COM_newTemplate(CTL_plugin_templatePath('forum', 'blocks'));
    $block->set_file (array ('block' => 'centerblock.thtml'));
            
	$block->set_block('block', 'block_record');
        
    $block->set_var ('phpself', $_CONF['site_url'] .'/index.php');
    $block->set_var ('startblock', COM_startBlock($LANG_GF02['msg170']));
    $block->set_var ('endblock', COM_endBlock());
    $block->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $block->set_var ('LANG_title', $LANG_GF02['msg170']);
    $block->set_var ('LANG_FORUM', $LANG_GF01['FORUM']);
    $block->set_var ('LANG_TOPIC', $LANG_GF01['TOPIC']);
    $block->set_var ('LANG_LASTPOST', $LANG_GF01['LASTPOST']);
    $block->set_var ('LANG_NEWPOST', $LANG_GF01['NEWPOSTS']);
    
    $block->set_var ('LANG_viewlastpost', $LANG_GF02['msg160']);
    $block->set_var ('LANG_forumjump', $LANG_GF02['msg195']);

    $groups = array ();
    $usergroups = SEC_getUserGroups();
    foreach ($usergroups as $group) {
        $groups[] = $group;
    }
    $grouplist = implode(',',$groups);

    $sql  = "SELECT a.id, a.forum, a.name, a.date, a.lastupdated, a.last_reply_rec, a.subject, ";
    $sql .= "a.comment, a.uid, a.name, a.pid, a.replies, a.views, b.forum_name  ";
    $sql .= "FROM {$_TABLES['forum_topic']} a ";
    $sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON a.forum=b.forum_id ";
    $sql .= "WHERE pid=0 AND b.grp_id IN ($grouplist) AND b.no_newposts = 0 ";
    $sql .= "ORDER BY lastupdated DESC LIMIT {$CONF_FORUM['centerblock_numposts']}";
    $result = DB_query ($sql);

    if (DB_numRows($result) == 0) {
        return;
    }

    $f_tooltip = function_exists('COM_getTooltip');
    $cssid = 0;
    while ($A = DB_fetchArray ($result)) {
        $fullsubject = "{$A['subject']}\n{$LANG_GF01['POSTEDBY']}:{$A['name']}{$LANG_GF01['VIEWS']}:{$A['views']}, {$LANG_GF01['REPLIES']}:{$A['replies']}";
        if (($CONF_FORUM['cb_subject_size'] > 0) AND (strlen ($A['subject']) > $CONF_FORUM['cb_subject_size'])) {
            $A['subject'] = COM_truncate($A['subject'], $CONF_FORUM['cb_subject_size'], '...');
        }

        if ($CONF_FORUM['allow_user_dateformat']) {
            $firstdate = COM_getUserDateTimeFormat ($A['date']);
            $firstdate = $firstdate[0];
            $lastdate = COM_getUserDateTimeFormat ($A['lastupdated']);
            $lastdate = $lastdate[0];
        } else {
            $firstdate = strftime($CONF_FORUM['default_Datetime_format'], $A['date']);
            $lastdate = strftime($CONF_FORUM['default_Datetime_format'], $A['lastupdated']);
        }
        if ($A['uid'] > 1) {
            $topicinfo = "{$A['subject']}<br" . XHTML . ">{$LANG_GF01['STARTEDBY']} " . COM_getDisplayName($A['uid']) . ', ';
            $topicinfo_short = "{$LANG_GF01['STARTEDBY']} " . COM_getDisplayName($A['uid']) . ', ';
        } else {
            $topicinfo = "{$A['subject']}<br" . XHTML . ">{$LANG_GF01['STARTEDBY']} {$A['name']},";
            $topicinfo_short = "{$LANG_GF01['STARTEDBY']} {$A['name']}";
        }

        $topicinfo .= "{$firstdate}<br" . XHTML . ">{$LANG_GF01['VIEWS']}:{$A['views']}, {$LANG_GF01['REPLIES']}:{$A['replies']}<br" . XHTML . ">";
        $topicinfo_short .= " &raquo; {$firstdate}";
        $repliesinfo = " {$LANG_GF01['REPLIES']}:{$A['replies']}";

        if (empty ($A['last_reply_rec']) OR $A['last_reply_rec'] < 1) {
            $lastid = $A['id'];
            $lastcomment = $A['comment'];
        } else {
            $qlreply = DB_query("SELECT id,uid,name,comment FROM {$_TABLES['forum_topic']} WHERE id={$A['last_reply_rec']}");
            $B = DB_fetchArray($qlreply);
            $lastid = $B['id'];
            $lastcomment = $B['comment'];
            if ($B['uid'] > 1) {
                $topicinfo .= sprintf($LANG_GF01['LASTREPLYBY'],COM_getDisplayName($B['uid']));
                $repliesinfo = sprintf($LANG_GF01['LASTREPLYBY'],COM_getDisplayName($B['uid'])) . " &raquo; $lastdate $repliesinfo";
            } else {
                $topicinfo .= sprintf($LANG_GF01['LASTREPLYBY'],$B['name']);
                $repliesinfo = sprintf($LANG_GF01['LASTREPLYBY'],$B['name']) . " &raquo; $lastdate $repliesinfo";
            }
        }
        $lastpostinfo = strip_tags(COM_truncate($lastcomment, $CONF_FORUM['contentinfo_numchars'], '...'));
        $lastpostinfo = stripBBCode($lastpostinfo); // Simple function to strip out bbcode so tooltips display better
        $lastpostinfo = forum_mb_wordwrap($lastpostinfo, $CONF_FORUM['linkinfo_width'], LB);
        $lastpostinfo = htmlspecialchars($lastpostinfo); // Escape things like " so it displays properly in tooltip
        $lastpostinfo = str_replace(LB, "<br" . XHTML . ">", $lastpostinfo); // Do this last
        
        $cssid = ($cssid == 1) ? 2 : 1;

        if ($f_tooltip) {
        	$block->set_var('gl-tooltip', true); // Used to verify gl tooltip is being set
            $lastpostlink = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}&amp;lastpost=true#{$lastid}";
            $block->set_var ('tooltip_date', COM_getTooltip($lastdate, $lastpostinfo, $lastpostlink));
            $topiclink = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}";
            $block->set_var ('tooltip_topic_subject', COM_getTooltip($A['subject'], $topicinfo, $topiclink));
        }
         
        $block->set_var ('lastpostinfo', $lastpostinfo);
        $block->set_var ('topicinfo', $topicinfo);
        $block->set_var ('topicinfo_short', $topicinfo_short);
        $block->set_var ('repliesinfo', $repliesinfo);
        $block->set_var ('date', $lastdate);
        $block->set_var ('topic_subject', $A['subject']);
        
        $block->set_var ('lastpostid', $lastid);
        $block->set_var ('cssid', $cssid);
        $block->set_var ('img_dir', $CONF_FORUM['imgset']);
        $block->set_var ('forum_id', $A['forum']);
        $block->set_var ('forum_name', $A['forum_name']);
        $block->set_var ('topic_id', $A['id']);
        $block->set_var ('fullsubject', $fullsubject);
        $block->set_var ('views', $A['views']);
        $block->set_var ('replies', $A['replies']);
        $block->set_var ('lastpostby',$A['name']);
        $block->parse ('block_record', 'block_record',true);
    }

    $block->parse ('output', 'block');
    $retval .= $block->finish ($block->get_var ('output'));

    //$exectime = $TIMER->stopTimer();
    //COM_errorLog("Centerblock Execution Time: $exectime seconds");

    return $retval;
}

function stripBBCode($text_to_search) {
	// Replace paragraph tags
	$pattern = '[p]';
	$replace = LB;
	$text_to_search = str_replace($pattern, $replace, $text_to_search);
	$pattern = '[/p]';
	$replace = LB;
	$text_to_search = str_replace($pattern, $replace, $text_to_search);
	
	// Replace everything else with nothing
	$pattern = '|[[\/\!]*?[^\[\]]*?]|si';
	$replace = '';
	$text_to_search = preg_replace($pattern, $replace, $text_to_search);
	
	return $text_to_search;
}

/**
* Get header code for inclusion
*
* @return   string
*
*/
function plugin_getheadercode_forum()
{
    global $_SCRIPTS, $CONF_FORUM;

    $_SCRIPTS->setCSSFile('forum', CTL_plugin_themeFindFile('forum', 'css', 'forum.css'));
    
    // Look for forum templates functions.php for current theme. If exist add in its required javascript and css
    CTL_plugin_setTemplatesFunctions("forum");

    // Left this as is since it is a php file that returns css
	$retval = '<link rel="stylesheet" type="text/css" href="' . $CONF_FORUM['css_smilies_url'] . '"' . XHTML . '>';
    
    return $retval;
}

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_forum($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'forum/docs/' . $doclang . '/forum.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/forum/docs/english/forum.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, NULL to use config
*                           tooltip hack, or empty string when not available
*
*/
function plugin_getconfigtooltip_forum($id)
{
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

// +---------------------------------------------------------------------------+
// | Commmon Forum Functions                                                   |
// +---------------------------------------------------------------------------+

function forum_modPermission($forum,$uid='',$permission='') {
    global $_USER,$_TABLES;

    if ($uid == '') {
        $uid = $_USER['uid'];
    }

    if ($uid <=1) {
        return FALSE;  // Invalid ID or anonymous user
    }

    /* Retrieve all moderator records for this forum */
    $modrecords = DB_query("SELECT * FROM {$_TABLES['forum_moderators']} WHERE mod_forum='$forum'");
    while ($A = DB_fetchArray($modrecords)) {
        if ($A['mod_groupid'] > 0) {
            if (SEC_inGroup($A['mod_groupid'],$uid)) {
                if ($permission != '') {
                    if ($A[$permission] == '1') {
                        return TRUE;
                    }
                } else {
                    return TRUE;
                }
            }
        } else {
            if ($A['mod_uid'] == $uid) {
                if ($permission != '') {
                    if ($A[$permission] == '1') {
                        return TRUE;
                    }
                } else {
                    return TRUE;
                }
            }
        }
    }

    /* If I get this far then I exited the loop without finding a permission record */
    return FALSE;

}


/**
* Gets Geeklog blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param    string  $side   Side to get blocks for (right or left for now)
* @param    string  $topic  Only get blocks for this topic
* @return   array           array of block data
* @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
*
*/
function plugin_getBlocks_forum($side, $topic='')
{
    global $_TABLES, $_CONF, $CONF_FORUM, $LANG_GF01;

    $retval = array();

    $owner_id = SEC_getDefaultRootUser();

    // Forum Posts Block
    // Check permissions first
    if ($CONF_FORUM['sideblock_enable'] && SEC_hasAccess($owner_id, $CONF_FORUM['sideblock_group_id'], $CONF_FORUM['sideblock_permissions'][0], $CONF_FORUM['sideblock_permissions'][1], $CONF_FORUM['sideblock_permissions'][2], $CONF_FORUM['sideblock_permissions'][3])) {
        // Check if right topic
        if (($CONF_FORUM['sideblock_topic_option'] == TOPIC_ALL_OPTION) || ($CONF_FORUM['sideblock_topic_option'] == TOPIC_HOMEONLY_OPTION && COM_onFrontpage()) || ($CONF_FORUM['sideblock_topic_option'] == TOPIC_SELECTED_OPTION && in_array($topic, $CONF_FORUM['sideblock_topic']))) {
            if (($side=='left' && $CONF_FORUM['sideblock_isleft'] == 1) || ($side=='right' && $CONF_FORUM['sideblock_isleft'] == 0)) {
                // Create a block
                $display = phpblock_forum_newposts();

                $retval[] = array('name'           => 'forum_posts',
                                  'type'           => 'dynamic',
                                  'onleft'         => $CONF_FORUM['sideblock_isleft'],
                                  'title'          => $LANG_GF01['FORUMPOSTS'],
                                  'blockorder'     => $CONF_FORUM['sideblock_order'],
                                  'content'        => $display,
                                  'allow_autotags' => false,
                                  'help'           => '');

            }
        }
    }

    // Forum Menu Block
    if ($CONF_FORUM['usermenu'] == 'blockmenu' && $CONF_FORUM['add_forum_menu_check']) {
        if (($side=='left' && $CONF_FORUM['menublock_isleft'] == 1) || ($side=='right' && $CONF_FORUM['menublock_isleft'] == 0)) {
            // Create a block
            $display = phpblock_forum_menu();

            $retval[] = array('name'           => 'forum_menu',
                              'type'           => 'dynamic',
                              'onleft'         => $CONF_FORUM['menublock_isleft'],
                              'title'          => $LANG_GF01['FORUMMENU'],
                              'blockorder'     => $CONF_FORUM['menublock_order'],
                              'content'        => $display,
                              'allow_autotags' => false,
                              'help'           => '');

        }
    }

    return $retval;
}

/**
* Gets config information for dynamic blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param    string  $side   Side to get blocks for (right or left for now)
* @param    string  $topic  Only get blocks for this topic
* @return   array           array of block data
* @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
*
*/
function plugin_getBlocksConfig_forum($side, $topic='')
{
    global $_TABLES, $_CONF, $CONF_FORUM, $LANG_GF01;

    $retval = array();

    $owner_id = SEC_getDefaultRootUser();

    // Forum Posts Block
    // Check permissions first
    if (SEC_hasAccess($owner_id, $CONF_FORUM['sideblock_group_id'], $CONF_FORUM['sideblock_permissions'][0], $CONF_FORUM['sideblock_permissions'][1], $CONF_FORUM['sideblock_permissions'][2], $CONF_FORUM['sideblock_permissions'][3])) {
        if (($side=='left' && $CONF_FORUM['sideblock_isleft'] == 1) || ($side=='right' && $CONF_FORUM['sideblock_isleft'] == 0)) {
            $retval[] = array('plugin'         => $LANG_GF01['FORUM'],
                              'name'           => 'forum_posts',
                              'title'          => $LANG_GF01['FORUMPOSTS'],
                              'type'           => 'dynamic',
                              'onleft'         => $CONF_FORUM['sideblock_isleft'],
                              'blockorder'     => $CONF_FORUM['sideblock_order'],
                              'allow_autotags' => false,
                              'help'           => '',
                              'enable'         => $CONF_FORUM['sideblock_enable'],
                              'topic_option'   => $CONF_FORUM['sideblock_topic_option'],
                              'topic'          => $CONF_FORUM['sideblock_topic'],
                              'inherit'        => array()
                              );
        }
    }

    // Forum Menu Block
    if (($side=='left' && $CONF_FORUM['menublock_isleft'] == 1) || ($side=='right' && $CONF_FORUM['menublock_isleft'] == 0)) {

        if ($CONF_FORUM['usermenu'] == 'blockmenu') {
            $menublock_enable = 1;
        } else {
            $menublock_enable = 0;
        }

        $retval[] = array('plugin'         => $LANG_GF01['FORUM'],
                          'name'           => 'forum_menu',
                          'title'          => $LANG_GF01['FORUMMENU'],
                          'type'           => 'dynamic',
                          'onleft'         => $CONF_FORUM['menublock_isleft'],
                          'blockorder'     => $CONF_FORUM['menublock_order'],
                          'allow_autotags' => false,
                          'help'           => '',
                          'enable'         => $menublock_enable,
                          'topic_option'   => '',
                          'topic'          => array(),
                          'inherit'        => array()
                          );
    }

    return $retval;
}

function forum_mb_wordwrap($str, $width, $break)
{
    static $mb_enabled;

    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }
    if (!$mb_enabled) {
        return wordwrap($str, $width, $break);
    }

   // Return short or empty strings untouched
    if(empty($str) || mb_strlen($str, 'UTF-8') <= $width)
        return $str;

    $br_width  = mb_strlen($break, 'UTF-8');
    $str_width = mb_strlen($str, 'UTF-8');
    $return = '';
    $last_space = false;

    for($i = 0, $count = 0; $i < $str_width; $i++, $count++) {
        // If we're at a break
        if (mb_substr($str, $i, $br_width, 'UTF-8') == $break) {
            $count = 0;
            $return .= mb_substr($str, $i, $br_width, 'UTF-8');
            $i += $br_width - 1;
            continue;
        }

        // Keep a track of the most recent possible break point
        if(mb_substr($str, $i, 1, 'UTF-8') == " ") {
            $last_space = $i;
        }

        // It's time to wrap
        if ($count > $width) {
            // There are no spaces to break on!  Going to truncate :(
            if(!$last_space) {
                $return .= $break;
                $count = 0;
            } else {
                // Work out how far back the last space was
                $drop = $i - $last_space;

                // Cutting zero chars results in an empty string, so don't do that
                if($drop > 0) {
                    $return = mb_substr($return, 0, -$drop);
                }

                // Add a break
                $return .= $break;

                // Update pointers
                $i = $last_space + ($br_width - 1);
                $last_space = false;
                $count = 0;
            }
        }

        // Add character from the input string to the output
        $return .= mb_substr($str, $i, 1, 'UTF-8');
    }
    return $return;
}

function gf_showVariables()
{
    global $CONF_FORUM;

    if (!$CONF_FORUM['debug']) return '';

    ob_start();
    if (!empty($_POST)) {
        echo COM_startBlock("_POST");
        var_dump($_POST);
        echo COM_endBlock();
    }
    if (!empty($_GET)) {
        echo COM_startBlock("_GET");
        var_dump($_GET);
        echo COM_endBlock();
    }
    if (!empty($_FILES)) {
        echo COM_startBlock("_FILES");
        var_dump($_FILES);
        echo COM_endBlock();
    }
    $retval = ob_get_contents();
    ob_end_clean();

    return $retval;
}

// +---------------------------------------------------------------------------+
// | Forum's OWN Plugin API Functions                                          |
// +---------------------------------------------------------------------------+

/**
 * This function returns the HTML code for displaying
 * the list of available smilies when posting a topic
 */
function forumPLG_showsmilies() {
    global $_SMILIES;
    // Let the ForumSmilies class handle this
    return $_SMILIES->show();
}

function forumPLG_restoreEmoticons($str) {
    global $CONF_FORUM;

    // Check and see if glMessenger is installed
    if (function_exists('msg_showsmilies')) {
        return msg_restoreEmoticons($str);
    } else {
        require_once $CONF_FORUM['path_include'] . 'gf_format.php';
        forum_xchsmilies($str);
    }
}

function forumPLG_getPMlink($member) {
    global $_TABLES,$_CONF;
    if (DB_getItem($_TABLES['plugins'],'pi_enabled',"pi_name='messenger'") == 1) {
        return "{$_CONF['site_url']}/messenger/index.php?action=newpm&amp;toname={$member};";
    } else {
        return '';
    }
}

function forumPLG_getMemberBadge($uid) {
    global $_CONF,$CONF_FORUM;

    $memberbadge = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $memberbadge->set_file (array('forum_icons' => 'forum_icons.thtml')); 
    
	$memberbadge->set_block('forum_icons', 'memberbadge_icon');
	
	$memberbadge->set_var ('imgset', $CONF_FORUM['imgset']);
        
    if ($uid > 1) {
        if (!SEC_inGroup('Root',$uid)) {
            foreach ($CONF_FORUM['grouptags'] as $groupid => $buttonimg) {
                if (SEC_inGroup($groupid,$uid)) {
					$memberbadge->set_var ('buttonimg', $buttonimg);
					$memberbadge->set_var ('memberbadgetitle', $CONF_FORUM['groupnames'][$groupid]);
					
					return $memberbadge->parse ('output', 'memberbadge_icon');                	
                }
            }
        } else {
			$memberbadge->set_var ('buttonimg', $CONF_FORUM['grouptags']['Root']);
			$memberbadge->set_var ('memberbadgetitle', $CONF_FORUM['groupnames']['Root']);
			
			return $memberbadge->parse ('output', 'memberbadge_icon');                	
        }
    }
}

/* GL-Menu 2.5 version of the Forum Menu */
function phpblock_forum_menu() {
    global $_TABLES,$_CONF,$_USER,$CONF_FORUM,$LANG_GF01,$LANG_GF02,$LANG_GF07,$CONF_GLMENU,$_BLOCK_TEMPLATE;

    $retval = '';
    if (isset($CONF_GLMENU) AND $CONF_GLMENU['installed_version'] >= 2.5) {
        if ($CONF_GLMENU['milonicmode']) {
            $retval = COM_startBlock( $LANG_GF00['forumblock'], '', 'glmenu/milonicmenu/blockheader-blockmenu.thtml');
            $retval .= 'aI("text='.$LANG_GF01['INDEXPAGE'].';url='.$_CONF['site_url'].'/forum/index.php;");' . LB;
            if (!COM_isAnonUser()) {
                $retval .= 'aI("text='.$LANG_GF01['USERPREFS'].';url='.$_CONF['site_url'].'/forum/userprefs.php;");' . LB;
                $retval .= 'aI("text='.$LANG_GF01['SUBSCRIPTIONS'].';url='.$_CONF['site_url'].'/forum/notify.php;");' . LB;
            }
            $retval .= 'aI("text='.$LANG_GF02['msg88'].';url='.$_CONF['site_url'].'/forum/memberlist.php;");' . LB;
            $retval .= 'aI("text='.$LANG_GF07['3'].';url='.$_CONF['site_url'].'/forum/index.php?op=popular;");' . LB;
            $retval .= COM_endBlock('glmenu/milonicmenu/blockfooter-blockmenu.thtml');
        } else {
            $retval = COM_startBlock( $LANG01[47], '', 'glmenu/blockheader.thtml');
            $t = COM_newTemplate($_CONF['path_layout'] . 'glmenu/cssmenu');
            $t->set_file('menu','blockmenu.thtml');
            $links = "<li><a href=\"{$_CONF['site_url']}/forum/index.php\" title=\"{$LANG_GF02['msg196']}\">{$LANG_GF01['INDEXPAGE']}</a></li>" . LB;
            if (!COM_isAnonUser()) {
                $links .= "<li><a href=\"{$_CONF['site_url']}/forum/index.php?op=markallread\" title=\"{$LANG_GF02['msg197']}\">{$LANG_GF01['MARKALLREAD']}</a></li>" . LB;
                $links .= "<li><a href=\"{$_CONF['site_url']}/forum/userprefs.php\" title=\"{$LANG_GF02['msg198']}\">{$LANG_GF01['USERPREFS']}</a></li>" . LB;
                $links .= "<li><a href=\"{$_CONF['site_url']}/forum/notify.php\" title=\"{$LANG_GF02['msg199']}\">{$LANG_GF01['SUBSCRIPTIONS']}</a></li>" . LB;
            }
            if (($CONF_FORUM['show_memberslist_anonymous'] && COM_isAnonUser()) OR !COM_isAnonUser()) {
            	$links .= "<li><a href=\"{$_CONF['site_url']}/forum/memberlist.php\" title=\"{$LANG_GF02['msg200']}\">{$LANG_GF02['msg88']}</a></li>" . LB;
			}
            $links .= "<li><a href=\"{$_CONF['site_url']}/forum/index.php?op=popular\" title=\"{$LANG_GF02['msg201']}\">{$LANG_GF07['3']}</a></li>" . LB;

            $t->set_var('menuitems', $links);
            $t->parse ('output', 'menu');
            $retval .= $t->finish ($t->get_var('output'));
            $retval .= COM_endBlock('glmenu/blockfooter.thtml');
        }
    } else {
        $base = $_CONF['site_url'] . '/forum/';
        $items = array();
        $items[] = COM_createLink($LANG_GF01['INDEXPAGE'], $base.'index.php', array('title' => $LANG_GF02['msg196']));
        if (!COM_isAnonUser()) {
            $items[] = COM_createLink($LANG_GF01['MARKALLREAD'], $base.'index.php?op=markallread',
                       array('title' => $LANG_GF02['msg197'], 'onclick' => 'return confirm(\'' . $LANG_GF02['msg301'] . '\');'));
            $items[] = COM_createLink($LANG_GF01['USERPREFS'], $base.'userprefs.php', array('title' => $LANG_GF02['msg198']));
            $items[] = COM_createLink($LANG_GF01['SUBSCRIPTIONS'], $base.'notify.php', array('title' => $LANG_GF02['msg199']));
        }
        if (($CONF_FORUM['show_memberslist_anonymous'] && COM_isAnonUser()) OR !COM_isAnonUser()) {
        	$items[] = COM_createLink($LANG_GF02['msg88'], $base.'memberlist.php', array('title' => $LANG_GF02['msg200']));
		}
        $items[] = COM_createLink($LANG_GF07['3'], $base.'index.php?op=popular', array('title' => $LANG_GF02['msg201']));
        $retval .= COM_makeList($items, 'forum_menu');
    }

    return $retval;
}


function glmenu_showforums() {
    global $_CONF,$_TABLES,$CONF_GLMENU;

    $retval = '';
    $glMenu_version = DB_getItem($_TABLES['plugins'],'pi_version',"pi_name = 'glmenu'");
    $qforums = DB_query("SELECT forum_name,forum_id,grp_id FROM {$_TABLES['forum_forums']} ORDER BY forum_cat, forum_order ASC");
    while (list($forum_name,$forum_id, $forum_grp) = DB_fetchArray($qforums)) {
        $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='$forum_grp'");
        if (SEC_inGroup($groupname)) {
            if ($CONF_GLMENU['milonicmode']) {
                $retval .= 'aI("text='.$forum_name.';url='.$_CONF['site_url'].'/forum/index.php?forum='.$forum_id.';");';
            } else {
                $retval .= "<li><a href=\"{$_CONF['site_url']}/forum/index.php?forum={$forum_id}\">$forum_name</a></li>";
            }
        }
    }
    return $retval;
}


/**
* This function is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
* @return   void
*
*/
function plugin_group_changed_forum($grp_id, $mode)
{
    global $_TABLES, $_GROUPS, $CONF_FORUM;

    if ($mode == 'delete') {
        // Change any deleted group ids to Forum Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['forum Admin'])) {
            $new_group_id = $_GROUPS['forum Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'forum Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }

        // Update Forum Side Block group if need be
        if ($CONF_FORUM['sideblock_group_id'] == $grp_id) {
            // Now save it to the configuration
            $c = config::get_instance();
            $c->set('sideblock_group_id', $new_group_id, 'forum');

        }
   }
}

/**
 * Config Manager function
 *
 * @return   array   Array of (groud id, group name) pairs
 *
 */
function plugin_configmanager_select_sideblock_group_id_forum()
{
    return SEC_getUserGroups();
}

/**
 * Config Manager function
 *
 * @return   array   Array of (topic id, topic name) pairs
 *
 */
function plugin_configmanager_select_sideblock_topic_forum()
{
    return array_flip(TOPIC_getList());
}

/**
* Callback function when an item was saved
*
* @param    string  $id     (unused) ID of item being saved
* @param    string  $type   type of item ('article', 'staticpages', ...)
* @param    string  $old_id (unused) previous ID of item, if != $id
* @return   void
* @see      PLG_itemSaved
*
*/
function plugin_itemsaved_forum($id, $type, $old_id)
{
    global $_TABLES, $CONF_FORUM;

    // we're really only interested in Topic ID changes
    if (($type == 'topic') && !empty($old_id) && ($id != $old_id)) {
        $key = array_search($old_id, $CONF_FORUM['sideblock_topic']);

        if ($key > 0) {
            // Update config
            $CONF_FORUM['sideblock_topic'][$key] = $id;

            // Now save it to the configuration
            $c = config::get_instance();
            $c->set('sideblock_topic', $CONF_FORUM['sideblock_topic'], 'forum');
        }
    }
}

/**
* Callback function when an item was deleted
*
* @param    string  $id     ID of item being deleted
* @param    string  $type   type of item ('article', 'staticpages', ...)
* @return   void
* @see      PLG_itemDeleted
*
*/
function plugin_itemdeleted_forum($id, $type)
{
    global $_TABLES, $CONF_FORUM;

    // we're really only interested in Topic Deletes
    if ($type == 'topic') {
        $key = array_search($id, $CONF_FORUM['sideblock_topic']);

        if ($key > 0) {
            // delete item from config
            unset($CONF_FORUM['sideblock_topic'][$key]);

            // Now save it to the configuration
            $c = config::get_instance();
            $c->set('sideblock_topic', $CONF_FORUM['sideblock_topic'], 'forum');
        }
        // Note: All topics could get deleted from array which would mean the block would not display untill user adds more in config
    }
}

?>
