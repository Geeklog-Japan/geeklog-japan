<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | memberlist.php                                                            |
// | Display a formatted listing of users                                      |
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

// Use filter to remove all possible hostile SQL injections - only expecting numeric data
$chkactivity = isset($_REQUEST['chkactivity']) ? COM_applyFilter($_REQUEST['chkactivity'],true) : '';
$direction   = isset($_GET['direction'])       ? COM_applyFilter($_GET['direction'])            : '';
$op          = isset($_GET['op'])              ? COM_applyFilter($_GET['op'])                   : '';
$order       = isset($_GET['order'])           ? COM_applyFilter($_GET['order'],true)           : '';
$page        = isset($_GET['page'])            ? COM_applyFilter($_GET['page'],true)            : '';
$prevorder   = isset($_GET['prevorder'])       ? COM_applyFilter($_GET['prevorder'],true)       : '';
$show        = isset($_GET['show'])            ? COM_applyFilter($_GET['show'],true)            : '';
$showuser    = isset($_GET['showuser'])        ? COM_applyFilter($_GET['showuser'],true)        : '';
$sort        = isset($_GET['sort'])            ? COM_applyFilter($_GET['sort'],true)            : '';

//Check is anonymous users can access
forum_chkUsercanAccess();

$display = '';

// Debug Code to show variables
$display .= gf_showVariables();

if ($op == "last10posts") {

    $report = COM_newTemplate($CONF_FORUM['path_layout'] . 'forum/layout');
    $report->set_file (array (
                    'report'         => 'reports/report_results.thtml',
                    'records'        => 'reports/report_record.thtml',
                    'outline_header' => 'forum_outline_header.thtml',
                    'outline_footer' => 'forum_outline_footer.thtml',
                    'return1'        => 'links/return.thtml',
                    'return2'        => 'links/return.thtml'));

    $report->set_var ('imgset', $CONF_FORUM['imgset']);
    $report->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $report->set_var ('phpself', $_CONF['site_url'] .'/forum/memberlist.php?op=last10posts&amp;showuser='.$showuser);
    $report->set_var ('startblock', COM_startBlock($LANG_GF02['msg86'] . DB_getItem($_TABLES['users'],"username", "uid=$showuser")) );
    $report->set_var ('endblock', COM_endBlock());

    $report->set_var ('LANG_TITLE', $LANG_GF02['msg86'] . DB_getItem($_TABLES['users'],"username", "uid=$showuser"));
    $report->set_var ('spacerwidth', '50%');
    $report->set_var ('returnlink', "href=\"{$_CONF['site_url']}/forum/memberslist.php\"");
    $report->set_var ('LANG_return', $LANG_GF02['msg169']);
    $report->parse ('link1','return1');
    $report->set_var ('returnlink', "href=\"{$_CONF['site_url']}/forum/index.php\"");
    $report->set_var ('LANG_return', $LANG_GF02['msg175']);
    $report->parse ('link2','return2');
    $report->parse ('header_outline','outline_header');
    $report->parse ('footer_outline','outline_footer');

    $report->set_var ('LANG_Heading1', $LANG_GF01['SUBJECT']);
    $report->set_var ('LANG_Heading2', $LANG_GF01['REPLIES']);
    $report->set_var ('LANG_Heading3', $LANG_GF01['VIEWS']);
    $report->set_var ('LANG_Heading4', $LANG_GF01['DATE']);
    if ($CONF_FORUM['usermenu'] == 'navbar') {
        $report->set_var('navmenu', forumNavbarMenu($LANG_GF02['msg200']));
    } else {
        $report->set_var('navmenu','');
    }

    $groups = array ();
    $usergroups = SEC_getUserGroups();
    foreach ($usergroups as $group) {
        $groups[] = $group;
    }
    $grouplist = implode(',',$groups);

    $sql = "SELECT a.date,a.subject,a.comment,a.replies,a.views,a.id,a.forum FROM {$_TABLES['forum_topic']} a ";
    $sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON a.forum=b.forum_id ";
    $sql .= "WHERE (a.uid = $showuser) AND b.grp_id IN ($grouplist) ";
    $sql .= "ORDER BY a.date DESC LIMIT {$CONF_FORUM['show_last_post_count']}";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $postdate = COM_getUserDateTimeFormat($P['date']);
            $P = DB_fetchArray($result);
            $report->set_var('post_start_ahref', '<a href="' . $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $P['id'] . '">');
            $report->set_var('post_subject', $P['subject']);
            $report->set_var('post_end_ahref', '</a>');
            $report->set_var('post_date', $postdate[0]);
            $report->set_var('post_replies', $P['replies']);
            $report->set_var('post_views', $P['views']);
            $report->set_var('csscode', $i%2+1);
            $report->parse ('report_records', 'records',true);
        }
    }
    $link = "<p><a href=\"{$_CONF['site_url']}/forum/memberlist.php?order=$order&amp;prevorder=$prevorder";
    $link .= "&amp;direction=$direction&amp;page=$page\">{$LANG_GF02['msg169']}</a></p>";
    $report->set_var ('bottomlink', $link);
    $report->parse ('output', 'report');
    $display .= $report->finish($report->get_var('output'));
    $display = gf_createHTMLDocument($display);
    COM_output($display);
    exit();

} else {

    $report = COM_newTemplate($CONF_FORUM['path_layout'] . 'forum/layout');
    $report->set_file (array (
                    'report'         => 'reports/memberlist.thtml',
                    'records'        => 'reports/memberlist_line.thtml',
                    'link'           => 'reports/memberlist_link.thtml',
                    'outline_header' => 'forum_outline_header.thtml',
                    'outline_footer' => 'forum_outline_footer.thtml'));

    // Check if the number of records was specified to show
    if (empty($show) AND $CONF_FORUM['show_members_perpage'] > 0) {
        $show = $CONF_FORUM['show_members_perpage'];
    } elseif (empty($show)) {
        $show = 20;
    }
    // Check if this is the first page.
    if ($page == 0) {
        $page = 1;
    }

    if ($prevorder != $order) {
        $direction = 'desc';
    }

    switch($order) {
        case 1:
            $orderby = 'uid';
            break;
        case 2:
            $orderby = 'username';
            break;
        case 3:
            $orderby = 'regdate';
            break;
        case 4:
            $orderby = 'posts';
            break;
        default:
            $orderby = 'uid';
            $order = 1;
            break;
    }

    if ($direction == "asc") {
        $prevdirection = 'asc';
        $direction = 'desc';
    } else {
        $prevdirection = 'desc';
        $direction = 'asc';
    }

    if ($chkactivity) {
        $memberlistsql = DB_query("SELECT user.uid FROM {$_TABLES['users']} user, {$_TABLES['forum_topic']} topic WHERE user.uid <> 1 AND user.uid=topic.uid GROUP BY uid");
    } else {
        $memberlistsql = DB_query("SELECT user.uid FROM {$_TABLES['users']} user, {$_TABLES['userprefs']} userprefs WHERE user.uid > 1 AND user.uid=userprefs.uid");
    }

    $membercount = DB_numRows($memberlistsql);
    $numpages = ceil($membercount / $show);
    $offset = ($page - 1) * $show;
    $base_url = "{$_CONF['site_url']}/forum/memberlist.php?&amp;show={$show}&amp;order={$order}&amp;prevorder={$prevorder}";
    $base_url .= "&amp;direction={$prevdirection}&amp;chkactivity=$chkactivity";

    if ($chkactivity) {
        $sql = "SELECT user.uid,user.uid,user.username,user.regdate,user.email,user.homepage, COUNT(*) AS posts, userprefs.emailfromuser ";
        $sql .= " FROM {$_TABLES['users']} user, {$_TABLES['userprefs']} userprefs, {$_TABLES['forum_topic']} topic WHERE";
        $sql .= " user.uid <> 1 AND user.uid=topic.uid AND user.uid=userprefs.uid ";
        $sql .= "GROUP BY uid ORDER BY $orderby $direction LIMIT $offset,$show ";
    } else {
        // Option to order by posts - only valid if option for 'forum activity' checked
        $orderby = ($orderby == 'posts') ? 'username' : $orderby;
        $sql = "SELECT user.uid,user.uid,user.username,user.regdate,user.email,user.homepage, userprefs.emailfromuser ";
        $sql .= " FROM {$_TABLES['users']} user, {$_TABLES['userprefs']} userprefs WHERE user.uid > 1 ";
        $sql .= "AND user.uid=userprefs.uid ORDER BY $orderby $direction LIMIT $offset,$show ";
    }

    $query = DB_query($sql);

    $report->set_var ('imgset', $CONF_FORUM['imgset']);
    $report->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $report->set_var ('startblock', COM_startBlock($LANG_GF02['msg88']) );
    $report->set_var ('endblock', COM_endBlock());
    $report->set_var ('LANG_TITLE', $LANG_GF02['msg88'] . "&nbsp;($membercount)");
    $report->set_var ('spacerwidth', '70%');
    $report->set_var ('chk_activity',($chkactivity == 1) ? 'CHECKED' : '');
    $report->set_var ('chkactivity', $chkactivity);
    $report->set_var ('phpself', $_CONF['site_url'] .'/forum/memberlist.php');
    $report->set_var ('prevorder', $order);
    $report->set_var ('direction', $direction);
    $report->set_var ('page', $page);
    $report->set_var ('LANG_Heading1', $LANG_GF01['UID']);
    $report->set_var ('LANG_Heading2', $LANG_GF01['USER']);
    $report->set_var ('LANG_Heading3', $LANG_GF01['REGISTERED']);
    $report->set_var ('LANG_Heading4',$LANG_GF01['POSTS']);
    $report->parse ('header_outline','outline_header');
    $report->parse ('footer_outline','outline_footer');
    $report->set_var ('LANG_lastposts',sprintf($LANG_GF02['msg86'],$CONF_FORUM['show_last_post_count']));
    $report->set_var ('LANG_website',$LANG_GF01['WebsiteLink']);
    $report->set_var ('LANG_ACTIVITY',$LANG_GF02['msg88b']);
    if ($CONF_FORUM['usermenu'] == 'navbar') {
        $report->set_var('navmenu', forumNavbarMenu($LANG_GF02['msg200']));
    } else {
        $report->set_var('navmenu','');
    }
    $csscode = 1;

    while ($siteMembers = DB_fetchArray($query)) {
        $siteMembers['posts'] = DB_count($_TABLES['forum_topic'],'uid',$siteMembers['uid']);
        if ($siteMembers['posts'] > 0) {
            $reportlinkURL = $_CONF['site_url'] .'/forum/memberlist.php?op=last10posts&amp;showuser='.$siteMembers['uid'];
            $reportlinkURL .= '&amp;prevorder='.$order.'&amp;direction='.$direction.'&amp;page='.$page;
            $report->set_var ('link_url', $reportlinkURL);
            $report->set_var ('link_text', $LANG_GF09['lastpost']);
            $report->parse('lastposts_link','link');
        } else {
            $report->set_var ('lastposts_link', '');
        }

        if ($siteMembers['emailfromuser'] == '1') {
            $emaillinkURL = "{$_CONF['site_url']}/profiles.php?uid={$siteMembers['uid']}";
            $report->set_var ('link_url', $emaillinkURL);
            $report->set_var ('link_text', $LANG_GF09['email']);
            $report->parse('email_link','link');
        } else {
            $report->set_var ('email_link', '');
        }
        if ($CONF_FORUM['use_pm_plugin']) {
            $pmplugin_link = forumPLG_getPMlink($siteMembers['username']);
            if ($pmplugin_link != '') {
                $report->set_var ('link_url', $pmplugin_link);
                $report->set_var ('link_text', $LANG_GF09['pm']);
                $report->parse('pm_link','link');
            } else {
                $report->set_var ('pm_link', '');
            }
        } else {
            $report->set_var ('pm_link', '');
        }
        if ($siteMembers['homepage'] != '') {
            $homepage = trim($siteMembers['homepage']);
            if (strtolower(substr($homepage, 0, 4)) != 'http') {
                $homepage = 'http://' .$homepage;
            }
            $report->set_var ('link_url', $homepage);
            $report->set_var ('link_text', $LANG_GF09['home']);
            $report->parse('website_link','link');
        } else {
            $report->set_var ('website_link', '');
        }

        $regdate = explode(" ", $siteMembers['regdate']);
        $report->set_var ('member_uid', $siteMembers['uid']);
        $report->set_var ('member_name', COM_getDisplayName($siteMembers['uid']));
        $report->set_var ('csscode', $csscode);
        $report->set_var ('member_regdate', $regdate[0]);
        $report->set_var ('member_numposts', $siteMembers['posts']);
        $report->set_var ('member_uid', $siteMembers['uid']);

        $report->parse ('report_records', 'records',true);
        if ($csscode == 2) {
            $csscode = 1;
        } else {
            $csscode++;
        }
    }

    $report->set_var ('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));
    $report->parse ('output', 'report');
    $display .= $report->finish($report->get_var('output'));

}

$display = gf_createHTMLDocument($display);

COM_output($display);
?>
