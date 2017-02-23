<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | messages.php                                                              |
// | Forum admin program to view all messages in a compressed format           |
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

include_once 'gf_functions.php';
require_once $CONF_FORUM['path_include'] . 'gf_format.php';

$id         = isset($_REQUEST['id'])         ? COM_applyFilter($_REQUEST['id'],true)         : '';
$op         = isset($_REQUEST['op'])  		 ? COM_applyFilter($_REQUEST['op'])       		 : '';
$show       = isset($_REQUEST['show'])       ? COM_applyFilter($_REQUEST['show'], true)      : '';
$page       = isset($_REQUEST['page'])       ? COM_applyFilter($_REQUEST['page'],true)       : '';
$forum      = isset($_REQUEST['forum'])      ? COM_applyFilter($_REQUEST['forum'],true)      : '';
$member     = isset($_REQUEST['member'])     ? COM_applyFilter($_REQUEST['member'],true)     : '';
$parentonly = isset($_REQUEST['parentonly']) ? COM_applyFilter($_REQUEST['parentonly'],true) : '';

function selectHTML_forum($selected='') {
    global $_CONF,$_TABLES;
    $selectHTML = '';
    $asql = DB_query("SELECT * FROM {$_TABLES['forum_categories']} ORDER BY cat_order ASC");
    while($A = DB_fetchArray($asql)) {
        $firstforum=true;
        $bsql = DB_query("SELECT * FROM {$_TABLES['forum_forums']} WHERE forum_cat='{$A['id']}' ORDER BY forum_order ASC");
        while($B = DB_fetchArray($bsql)) {
            $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='{$B['grp_id']}'");
            if (SEC_inGroup($groupname)) {
                if ($firstforum) {
                    $selectHTML .= '<option value="-1">-------------------</option>';
                    $selectHTML .= '<option value="-1">' .$A['cat_name']. '</option>';
                 }
                $firstforum = false;
                if ($B['forum_id'] == $selected) {
                    $selectHTML .= LB .'<option value="' .$B['forum_id']. '" selected="selected">&nbsp;&#187;&nbsp;&nbsp;' .$B['forum_name']. '</option>';
                } else {
                    $selectHTML .= LB .'<option value="' .$B['forum_id']. '">&nbsp;&#187;&nbsp;&nbsp;' .$B['forum_name']. '</option>';
                }
            }
        }
    }
    return $selectHTML;
}

function selectHTML_members($selected='') {
    global $_CONF,$_TABLES,$LANG_GF02;
    $selectHTML = '';
    $sql  = "SELECT  user.uid,user.username FROM {$_TABLES['users']} user, {$_TABLES['forum_topic']} topic ";
    $sql .= "WHERE user.uid=topic.uid GROUP BY uid ORDER BY user.username";
    $memberlistsql = DB_query($sql);
    if ($selected == -1) {
        $selectHTML .= LB .'<option value="-1" selected="selected">' .$LANG_GF02['msg177']. '</option>';
    } else {
        $selectHTML .= LB .'<option value="-1">' .$LANG_GF02['msg177']. '</option>';
    }
    while($A = DB_fetchArray($memberlistsql)) {
        if ($A['uid'] == $selected) {
            $selectHTML .= LB .'<option value="' .$A['uid']. '" selected="selected">' .$A['username']. '</option>';
        } else {
            $selectHTML .= LB .'<option value="' .$A['uid']. '">' .$A['username']. '</option>';
        }
    }
    return $selectHTML;

}

/* Check to see if user has checked multiple records to delete */
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') === 0 AND $op == 'delchecked' AND SEC_checkToken()) {
    $chk_record_delete = array();
    if (isset($_POST['chk_record_delete'])) {
        $chk_record_delete = $_POST['chk_record_delete'];
    }
    foreach ($chk_record_delete as $id) {
        $id = COM_applyFilter($id,true);
        DB_query("DELETE FROM {$_TABLES['forum_topic']} WHERE id='$id'");
        PLG_itemDeleted($id, 'forum');
    }
    COM_rdfUpToDateCheck('forum'); // forum rss feeds update
} elseif ($op == 'delrecord' AND SEC_checkToken()) {
    DB_query("DELETE FROM {$_TABLES['forum_topic']} WHERE id='$id'");
    PLG_itemDeleted($id, 'forum');
    COM_rdfUpToDateCheck('forum'); // forum rss feeds update
}

// Page Navigation Logic

if (empty($show)) {
    $show = $CONF_FORUM['show_messages_perpage'];
}
// Check if this is the first page.
if (empty($page)) {
     $page = 1;
}

$whereSQL = '';
$forumname = '';

if ($forum > 0) {
    $whereSQL = " WHERE forum='$forum'";
    $forumname = stripslashes(DB_getItem($_TABLES['forum_forums'],'forum_name',"forum_id='$forum'"));
}
if ($member > 0) {
    if ($whereSQL == '') {
        $whereSQL = ' WHERE ';
    } else {
        $whereSQL .= ' AND ';
    }
    $whereSQL .= " uid='$member'";
}
if ($parentonly == 1) {
    if ($whereSQL == '') {
        $whereSQL = ' WHERE ';
    } else {
        $whereSQL .= ' AND ';
    }
    $whereSQL .= " pid='0'";
}
$sql = "SELECT * FROM {$_TABLES['forum_topic']} $whereSQL ORDER BY id DESC";
$result = DB_query($sql);
$nrows = DB_numRows($result);

$display = '';
$report = COM_newTemplate(CTL_plugin_templatePath('forum'));
$report->set_file(array ('messages'=>'admin/messages.thtml', 
        				'forum_links'   => 'forum_links.thtml')); 

$report->set_block('messages', 'report_record');
$report->set_block('messages', 'no_records_message');
$report->set_block('forum_links', 'trash_link');

$report->set_var('phpself', $_CONF['site_admin_url'] .'/plugins/forum/messages.php');
$report->set_var('imgset', $CONF_FORUM['imgset']);
$report->set_var('LANG_deleteall', $LANG_GF01['DELETEALL']);
$report->set_var('LANG_DELCONFIRM', $LANG_GF01['DELCONFIRM']);
$report->set_var('LANG_DELALLCONFIRM', $LANG_GF01['DELALLCONFIRM']);
$report->set_var('LANG_selectforum', $LANG_GF02['msg106']);
$report->set_var('LANG_select1', $LANG_GF93['allforums']);
$report->set_var('LANG_selectmember', $LANG_GF02['msg107']);
$report->set_var('LANG_select2', $LANG_GF02['msg176']);
$report->set_var('LANG_Parent',  $LANG_GF02['msg178']);
$report->set_var('LANG_Author',  $LANG_GF01['AUTHOR']);
$report->set_var('LANG_Subject', $LANG_GF01['SUBJECT']);
$report->set_var('LANG_Views',   $LANG_GF01['VIEWS']);
$report->set_var('LANG_Replies', $LANG_GF01['REPLIES']);
$report->set_var('LANG_Actions', $LANG_GF01['ACTIONS']);
$report->set_var('LANG_Moderate', $LANG_GF95['moderate']);
$report->set_var('LANG_Delete', $LANG_GF01['DELETE']);
$report->set_var('LANG_all', $LANG_GF01['ALL']);

$report->parse ('trash_link','trash_link');

$report->set_var('select_forum',selectHTML_forum($forum));
$report->set_var('select_member',selectHTML_members($member));

$navbar->set_selected($LANG_GF06['6']);
$report->set_var('navbar', $navbar->generate());

if ($parentonly == 1) {
    $report->set_var('chk_parentonly', 'checked="checked"');
}

if ($forumname == '') {
	$report->set_var('startblock', COM_startBlock($LANG_GF95['header1']));
} else {
	$report->set_var('startblock', COM_startBlock(sprintf($LANG_GF95['header2'], $forumname)));
}

if ($nrows > 0) {
    $numpages = ceil($nrows / $show);
    $offset = ($page - 1) * $show;
    $base_url = $_CONF['site_admin_url'] . '/plugins/forum/messages.php?forum='.$forum;
    $report->set_var('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));

    $query = DB_query("SELECT * FROM {$_TABLES['forum_topic']} $whereSQL ORDER BY id DESC LIMIT $offset, $show");
    $csscode = 1;
    while($A = DB_fetchArray($query)){
        $report->set_var('id', $A['id']);
        if ($A['uid'] > 1) {
               $report->set_var('name', '<a href="' .$_CONF['site_url']. '/users.php?mode=profile&amp;uid=' .$A['uid']. '">' .COM_getDisplayName($A['uid']). '</a>');
        } else {
            $report->set_var('name', COM_getDisplayName($A['uid']));
        }
        if ($A['pid'] == "0") {
            $id = $A['id'];
            $report->set_var('topicid', $id);
        } else {
            $report->set_var('topicid', $A['pid']);
        }
        $report->set_var('csscode', $csscode);
        $report->set_var('subject', $A['subject']);
        $report->set_var('siteurl', $_CONF['site_url']);
        $report->set_var('forum', $A['forum']);
        $report->set_var('views', $A['views']);
        $report->set_var('replies', $A['replies']);
        $report->set_var('uid', $A['uid']);
        $report->parse('report_record', 'report_record',true);
        if ($csscode == 2) {
            $csscode = 1;
        } else {
            $csscode++;
        }
    }
} else {
	$report->set_var ('records_message', $LANG_GF95['nomess']);
	$report->parse ('no_records_message', 'no_records_message');
}  

$report->set_var('gltoken_name', CSRF_TOKEN);
$report->set_var('gltoken', SEC_createToken());

$report->set_var('endblock', COM_endBlock());

$report->parse('output', 'messages');
$display .= $report->finish($report->get_var('output'));
$display = COM_createHTMLDocument($display);

COM_output($display);
?>
