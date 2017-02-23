<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | boards.php                                                                |
// | Forum Plugin admin - Main program to setup Forums                         |
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

$catorder = isset($_REQUEST['catorder']) ? COM_applyFilter($_POST['catorder'],true) : '';
$confirm  = isset($_REQUEST['confirm'])  ? COM_applyFilter($_POST['confirm'],true)  : '';
$id       = isset($_REQUEST['id'])       ? COM_applyFilter($_POST['id'],true)       : '';
$mode     = isset($_REQUEST['mode'])     ? COM_applyFilter($_REQUEST['mode'])       : '';
$msg      = isset($_GET['msg'])          ? COM_applyFilter($_GET['msg'], true)      : '';
$type     = isset($_REQUEST['type'])     ? COM_applyFilter($_REQUEST['type'])       : '';
$submit   = isset($_REQUEST['submit'])   ? COM_applyFilter($_REQUEST['submit'])     : '';

$display = '';

// Debug Code to show variables
$display .= gf_showVariables();

if ($submit != $LANG_GF01['CANCEL']) {
	if ($msg==1) {
		$display .= COM_showMessageText($LANG_GF93['catadded']);
	}
	if ($msg==2) {
		$display .= COM_showMessageText($LANG_GF93['catdeleted']);
	}
	if ($msg==3) {
		$display .= COM_showMessageText($LANG_GF93['catedited']);
	}
	if ($msg==4) {
		$display .= COM_showMessageText($LANG_GF93['forumadded']);
	}
	if ($msg==5) {
		$display .= COM_showMessageText($LANG_GF93['forumaddError']);
	}
	if ($msg==6) {
		$display .= COM_showMessageText($LANG_GF93['forumdeleted']);
	}
	if ($msg==7) {
		$display .= COM_showMessageText($LANG_GF93['forumordered']);
	}
	if ($msg==8) {
		$display .= COM_showMessageText($LANG_GF93['forumedited']);
	}
	if ($msg==9) {
		$display .= COM_showMessageText($LANG_GF93['forummerged']);
	}
	if ($msg==10) {
		$display .= COM_showMessageText($LANG_GF93['forumnotmerged']);
	}
}

$display .= COM_startBlock($LANG_GF93['gfboard']);

$navbar->set_selected($LANG_GF06['3']);
$display .= $navbar->generate();

// CATEGORY Maintenance Section
if ($type == "category") {

    if ($mode == 'add' AND $submit != $LANG_GF01['CANCEL']) {
        if (($submit == $LANG_GF01['SAVE']) && SEC_checkToken()) {
            $name = gf_preparefordb($_POST['name'],'text');
            $dscp = gf_preparefordb($_POST['dscp'],'text');
            DB_query("INSERT INTO {$_TABLES['forum_categories']} (cat_order,cat_name,cat_dscp) VALUES ('$catorder','$name','$dscp')");
            $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=1');
            COM_output($display);
            exit();
        } else {
            $boards_addcategory = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
            $boards_addcategory->set_file (array ('boards_addcategory'=>'boards_edtcategory.thtml'));
            $boards_addcategory->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
            $boards_addcategory->set_var ('title', $LANG_GF93['addcat']);
            $boards_addcategory->set_var ('mode', 'add');
            $boards_addcategory->set_var ('confirm', '1');
            $boards_addcategory->set_var ('LANG_ADDNOTE', $LANG_GF93['addnote']);
            $boards_addcategory->set_var ('LANG_NAME', $LANG_GF01['NAME']);
            $boards_addcategory->set_var ('LANG_DESCRIPTION', $LANG_GF01['DESCRIPTION']);
            $boards_addcategory->set_var ('LANG_ORDER', $LANG_GF01['ORDER']);
            $boards_addcategory->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
            $boards_addcategory->set_var ('LANG_SAVE', $LANG_GF01['SAVE']);
            $boards_addcategory->set_var ('gltoken_name', CSRF_TOKEN);
            $boards_addcategory->set_var ('gltoken', SEC_createToken());
            $boards_addcategory->parse ('output', 'boards_addcategory');
            $display .= $boards_addcategory->finish ($boards_addcategory->get_var('output'));
            $display .= COM_endBlock();
            $display = COM_createHTMLDocument($display);
            COM_output($display);
            exit();
        }

    } elseif ($mode == $LANG_GF01['DELETE'] AND $submit != $LANG_GF01['CANCEL']) {
        if (($confirm == 1) && SEC_checkToken()) {
            DB_query("DELETE FROM {$_TABLES['forum_categories']} WHERE id='$id'");
            DB_query("DELETE FROM {$_TABLES['forum_forums']} WHERE forum_cat='$id'");
            $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=2');
            COM_output($display);
            exit();
        } else {
            $catname = DB_getItem($_TABLES['forum_categories'], "cat_name","id=$id");
            $boards_delcategory = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
            $boards_delcategory->set_file (array ('boards_delcategory'=>'boards_delete.thtml'));
            $boards_delcategory->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
            $boards_delcategory->set_var ('alert_title', $LANG_GF02['adminconfirmation']);
            $boards_delcategory->set_var ('alert_message', sprintf($LANG_GF93['deletecatnote'], $catname));
            $boards_delcategory->set_var ('id', $id);
            $boards_delcategory->set_var ('type', 'category');
            $boards_delcategory->set_var ('LANG_DELETE', $LANG_GF01['DELETE']);
            $boards_delcategory->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
            $boards_delcategory->set_var ('gltoken_name', CSRF_TOKEN);
            $boards_delcategory->set_var ('gltoken', SEC_createToken());
            $boards_delcategory->parse ('output', 'boards_delcategory');
            $display .= $boards_delcategory->finish ($boards_delcategory->get_var('output'));
            $display .= COM_endBlock();
            $display = COM_createHTMLDocument($display);
            COM_output($display);
            exit();
        }

    } elseif (($mode == 'save') && SEC_checkToken() && ($submit != $LANG_GF01['CANCEL'])) {
        $name = gf_preparefordb($_POST['name'],'text');
        $dscp = gf_preparefordb($_POST['dscp'],'text');
        DB_query("UPDATE {$_TABLES['forum_categories']} SET cat_order='$catorder',cat_name='$name',cat_dscp='$dscp' WHERE id='$id'");
        $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=3');
        COM_output($display);
        exit();

    } elseif ($mode == $LANG_GF01['EDIT']) {
        $esql = DB_query("SELECT * FROM {$_TABLES['forum_categories']} WHERE (id='$id')");
        $E = DB_fetchArray($esql);
        $boards_edtcategory = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
        $boards_edtcategory->set_file (array ('boards_edtcategory'=>'boards_edtcategory.thtml'));
        $boards_edtcategory->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
        $boards_edtcategory->set_var ('title', sprintf($LANG_GF93['editcatnote'], stripslashes($E['cat_name'])));
        $boards_edtcategory->set_var ('catname', $E['cat_name']);
        $boards_edtcategory->set_var ('catorder', $E['cat_order']);
        $boards_edtcategory->set_var ('catdscp', $E['cat_dscp']);
        $boards_edtcategory->set_var ('id', $id);
        $boards_edtcategory->set_var ('mode', 'save');
        $boards_edtcategory->set_var ('confirm', '0');
        $boards_edtcategory->set_var ('LANG_NAME', $LANG_GF01['NAME']);
        $boards_edtcategory->set_var ('LANG_DESCRIPTION', $LANG_GF01['DESCRIPTION']);
        $boards_edtcategory->set_var ('LANG_ORDER', $LANG_GF01['ORDER']);
        $boards_edtcategory->set_var ('LANG_SAVE', $LANG_GF01['SAVE']);
        $boards_edtcategory->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
        $boards_edtcategory->set_var ('gltoken_name', CSRF_TOKEN);
        $boards_edtcategory->set_var ('gltoken', SEC_createToken());
        $boards_edtcategory->parse ('output', 'boards_edtcategory');
        $display .= $boards_edtcategory->finish ($boards_edtcategory->get_var('output'));
        $display .= COM_endBlock();
        $display = COM_createHTMLDocument($display);
        COM_output($display);
        exit();

    } elseif ($mode == $LANG_GF01['RESYNCCAT'])  {
        // Resync each forum in this category
        $query = DB_query("SELECT forum_id FROM {$_TABLES['forum_forums']} WHERE forum_cat='$id'");
        while (list($forum_id) = DB_fetchArray($query)) {
            gf_resyncforum($forum_id);
        }
    }

}

// FORUM Maintenance Section
if ($type == "forum") {
    if ($mode == 'add') {
        if (($submit == $LANG_GF01['SAVE']) && SEC_checkToken()) {
            $category    = isset($_POST['category'])    ? COM_applyFilter($_POST['category'],true)    : 0;
            $dscp        = isset($_POST['dscp'])        ? gf_preparefordb($_POST['dscp'],'text')      : '';
            $is_hidden   = isset($_POST['is_hidden'])   ? COM_applyFilter($_POST['is_hidden'],true)   : 0;
            $is_readonly = isset($_POST['is_readonly']) ? COM_applyFilter($_POST['is_readonly'],true) : 0;
            $name        = isset($_POST['name'])        ? gf_preparefordb($_POST['name'],'text')      : '';
            $no_newposts = isset($_POST['no_newposts']) ? COM_applyFilter($_POST['no_newposts'],true) : 0;
            $order       = isset($_POST['order'])       ? COM_applyFilter($_POST['order'],true)       : 0;
            $privgroup   = isset($_POST['privgroup'])   ? COM_applyFilter($_POST['privgroup'],true)   : 0;
            if ($privgroup == 0) $privgroup = 2;
            if (forum_addForum($name,$category,$dscp,$order,$privgroup,$is_readonly,$is_hidden,$no_newposts) > 0 ) {
                $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=4');
            } else {
                $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=5');
            }
            COM_output($display);
            exit();

        } else {
			$grouplist = '';
			$groupname = '';
            $result    = DB_query("SELECT DISTINCT grp_id, grp_name FROM {$_TABLES['groups']}");
            $nrows    = DB_numRows($result);
            if ($nrows > 0) {
                for ($i = 1; $i <= $nrows; $i++) {
                    $G = DB_fetchArray($result);
                    if ($G['grp_id'] == 2) {
                        $grouplist .= '<option value="' . $G['grp_id'] . '" Selected >' . $G['grp_name'] . '</option>';
                    } else {
                        $grouplist .= '<option value="' . $G['grp_id'] . '">' . $G['grp_name'] . '</option>';
                    }
                }
            }
            
            $category_id = isset($_GET['category']) ? COM_applyFilter($_GET['category'],true) : '';
			$categorylist = '';
            $result    = DB_query("SELECT id, cat_name FROM {$_TABLES['forum_categories']} ORDER BY cat_order");
            $nrows    = DB_numRows($result);
            if ($nrows > 0) {
                for ($i = 1; $i <= $nrows; $i++) {
                    $G = DB_fetchArray($result);
                    if ($G['id'] == $category_id) {
                        $categorylist .= '<option value="' . $G['id'] . '" Selected >' . $G['cat_name'] . '</option>';
                    } else {
                        $categorylist .= '<option value="' . $G['id'] . '">' . $G['cat_name'] . '</option>';
                    }
                }
            }            
            
            $boards_addforum = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
            $boards_addforum->set_file (array ('boards_addforum'=>'boards_edtforum.thtml'));
            $boards_addforum->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
            $boards_addforum->set_var ('title', $LANG_GF93['addforum']);
            $boards_addforum->set_var ('mode', 'add');
            $boards_addforum->set_var ('id', $id);
            $boards_addforum->set_var ('confirm', '1');
            $boards_addforum->set_var ('LANG_CATEGORY', $LANG_GF01['category']);
            $boards_addforum->set_var ('categorylist', $categorylist);
            $boards_addforum->set_var ('LANG_DESCRIPTION', $LANG_GF01['DESCRIPTION']);
            $boards_addforum->set_var ('LANG_NAME', $LANG_GF01['NAME']);
            $boards_addforum->set_var ('LANG_ORDER', $LANG_GF01['ORDER']);
            $boards_addforum->set_var ('LANG_GROUPACCESS', $LANG_GF93['groupaccess']);

            $boards_addforum->set_var ('LANG_readonly', $LANG_GF93['readonly']);
            $boards_addforum->set_var ('LANG_readonlydscp', $LANG_GF93['readonlydscp']);
            $boards_addforum->set_var ('LANG_hidden', $LANG_GF93['hidden']);
            $boards_addforum->set_var ('LANG_hiddendscp', $LANG_GF93['hiddendscp']);
            $boards_addforum->set_var ('LANG_hideposts', $LANG_GF93['hideposts']);
            $boards_addforum->set_var ('LANG_hidepostsdscp', $LANG_GF93['hidepostsdscp']);

            $boards_addforum->set_var ('groupname', $groupname);
            $boards_addforum->set_var ('grouplist', $grouplist);
            $boards_addforum->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
            $boards_addforum->set_var ('LANG_SAVE', $LANG_GF01['SAVE']);
            $boards_addforum->set_var ('gltoken_name', CSRF_TOKEN);
            $boards_addforum->set_var ('gltoken', SEC_createToken());
            $boards_addforum->parse ('output', 'boards_addforum');
            $display .= $boards_addforum->finish ($boards_addforum->get_var('output'));
            $display .= COM_endBlock();
            $display = COM_createHTMLDocument($display);
            COM_output($display);
            exit();
        }
    } elseif ($mode == $LANG_GF01['MERGE'] AND $submit != $LANG_GF01['CANCEL']) {
        if (($confirm == 1) && SEC_checkToken()) {
            $new_id   = isset($_REQUEST['new_id'])   ? COM_applyFilter($_POST['new_id'],true)   : '';
            forum_mergeForum($id, $new_id);
            $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=9');
            COM_output($display);
            exit();
        } else {
            $result = DB_query("SELECT forum_id, forum_name FROM {$_TABLES['forum_forums']} ORDER BY forum_cat, forum_order");
            $nrows = DB_numRows($result);
            if ($nrows > 1) {
                $boards_mergeforum = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
                $boards_mergeforum->set_file (array ('boards_mergeforum'=>'boards_merge.thtml'));
                $boards_mergeforum->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
				$boards_mergeforum->set_var ('alert_title', $LANG_GF02['adminconfirmation']);
				$boards_mergeforum->set_var ('alert_message', sprintf($LANG_GF93['mergeforumnote'],  COM_applyFilter($_POST['forumname'])));
                $boards_mergeforum->set_var ('id', $id);
                $boards_mergeforum->set_var ('type', 'forum');
                $forumlist = '';
                $sql = "SELECT forum_id, forum_name, cat_name 
                    FROM {$_TABLES['forum_forums']} ff, {$_TABLES['forum_categories']} fc 
                    WHERE fc.id = ff.forum_cat
                    ORDER BY cat_order, forum_order";     
                $result    = DB_query($sql);
                $nrows    = DB_numRows($result);
                if ($nrows > 1) {
                    for ($i = 1; $i <= $nrows; $i++) {
                        $G = DB_fetchArray($result);
                        if ($G['forum_id'] != $id) { // Do not include own forum
                            $forumlist .= '<option value="' . $G['forum_id'] . '">' . $G['cat_name'] . '&nbsp;&#62;&nbsp;' . $G['forum_name'] . '</option>';
                        }
                    }
                }             
                $boards_mergeforum->set_var ('forumlist', $forumlist);
                
                $boards_mergeforum->set_var ('LANG_MERGE', $LANG_GF01['MERGE']);
                $boards_mergeforum->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
                $boards_mergeforum->set_var ('gltoken_name', CSRF_TOKEN);
                $boards_mergeforum->set_var ('gltoken', SEC_createToken());
                $boards_mergeforum->parse ('output', 'boards_mergeforum');
                $display .= $boards_mergeforum->finish ($boards_mergeforum->get_var('output'));
                $display .= COM_endBlock();
                $display = COM_createHTMLDocument($display);
            } else {
                $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=10');
            }
            COM_output($display);
            exit();
        }

    } elseif ($mode == $LANG_GF01['DELETE'] AND $submit != $LANG_GF01['CANCEL']) {
        if (($confirm == 1) && SEC_checkToken()) {
            forum_deleteForum($id);
            $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=6');
            COM_output($display);
            exit();
        } else {
            $boards_delforum = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
            $boards_delforum->set_file (array ('boards_delforum'=>'boards_delete.thtml'));
            $boards_delforum->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
			$boards_delforum->set_var ('alert_title', $LANG_GF02['adminconfirmation']);
			$boards_delforum->set_var ('alert_message', sprintf($LANG_GF93['deleteforumnote'],  COM_applyFilter($_POST['forumname'])));
            $boards_delforum->set_var ('id', $id);
            $boards_delforum->set_var ('type', 'forum');
            $boards_delforum->set_var ('LANG_DELETE', $LANG_GF01['DELETE']);
            $boards_delforum->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
            $boards_delforum->set_var ('gltoken_name', CSRF_TOKEN);
            $boards_delforum->set_var ('gltoken', SEC_createToken());
            $boards_delforum->parse ('output', 'boards_delforum');
            $display .= $boards_delforum->finish ($boards_delforum->get_var('output'));
            $display .= COM_endBlock();
            $display = COM_createHTMLDocument($display);
            COM_output($display);
            exit();
        }

    } elseif (($mode == $LANG_GF01['EDIT'] && isset($_POST['what']) && COM_applyFilter($_POST['what']) == 'order') && SEC_checkToken()) {
        $order = COM_applyFilter($_POST['order'],true);
        DB_query("UPDATE {$_TABLES['forum_forums']} SET forum_order='$order' WHERE forum_id='$id'");
        $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=7');
        COM_output($display);
        exit();

    } elseif (($mode == 'save') && SEC_checkToken() && ($submit != $LANG_GF01['CANCEL'])) {
        $category    = isset($_REQUEST['category']) ? COM_applyFilter($_POST['category'],true)    : 0;
        $order       = isset($_POST['order'])       ? COM_applyFilter($_POST['order'],true)       : 0;
        $name = gf_preparefordb($_POST['name'],'text');
        $dscp = gf_preparefordb($_POST['dscp'],'text');
        $is_hidden   = isset($_POST['is_hidden'])   ? COM_applyFilter($_POST['is_hidden'],true)   : 0;
        $is_readonly = isset($_POST['is_readonly']) ? COM_applyFilter($_POST['is_readonly'],true) : 0;
        $no_newposts = isset($_POST['no_newposts']) ? COM_applyFilter($_POST['no_newposts'],true) : 0;
        $privgroup   = isset($_POST['privgroup'])   ? COM_applyFilter($_POST['privgroup'],true)   : 0;
        if ($privgroup == 0) $privgroup = 2;
        DB_query("UPDATE {$_TABLES['forum_forums']} SET forum_cat=$category,forum_name='$name', forum_order=$order,forum_dscp='$dscp', grp_id=$privgroup,
                is_hidden='$is_hidden', is_readonly='$is_readonly', no_newposts='$no_newposts' WHERE forum_id='$id'");
        $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/boards.php?msg=8');
        COM_output($display);
        exit();

    } elseif ($mode == $LANG_GF01['RESYNC'])  {
        gf_resyncforum($id);

    } elseif ($mode == $LANG_GF01['EDIT']) {
		$grouplist = '';
        $sql  = "SELECT forum_name,forum_cat,forum_dscp,grp_id,forum_order,is_hidden,is_readonly,no_newposts ";
        $sql .= "FROM {$_TABLES['forum_forums']} WHERE (forum_id='$id')";
        $resForum  = DB_query($sql);
        list ($forum_name, $forum_category,$forum_dscp,$privgroup, $forum_order,$is_hidden,$is_readonly,$no_newposts) = DB_fetchArray($resForum);
        $resGroups = DB_query("SELECT DISTINCT grp_id,grp_name FROM {$_TABLES['groups']}");
        $nrows     = DB_numRows($resGroups);
        while ( list($grp, $name) = DB_fetchARRAY($resGroups)) {
            if ($grp == $privgroup) {
                $grouplist .= '<option value="' .$grp. '" SELECTED >' . $name. '</option>';
            } else {
                $grouplist .= '<option value="' .$grp. '">' . $name. '</option>';
            }
        }
        
        $categorylist = '';
        $result    = DB_query("SELECT id, cat_name FROM {$_TABLES['forum_categories']} ORDER BY cat_order");
        $nrows    = DB_numRows($result);
        if ($nrows > 0) {
            for ($i = 1; $i <= $nrows; $i++) {
                $G = DB_fetchArray($result);
                if ($G['id'] == $forum_category) {
                    $categorylist .= '<option value="' . $G['id'] . '" SELECTED >' . $G['cat_name'] . '</option>';
                } else {
                    $categorylist .= '<option value="' . $G['id'] . '">' . $G['cat_name'] . '</option>';
                }
            }
        }          

        $boards_edtforum = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
        $boards_edtforum->set_file (array ('boards_edtforum'=>'boards_edtforum.thtml'));
        $boards_edtforum->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
        $boards_edtforum->set_var ('title', sprintf($LANG_GF93['editforumnote'], $forum_name));
        $boards_edtforum->set_var ('id', $id);
        $boards_edtforum->set_var ('mode', 'save');
        $boards_edtforum->set_var ('confirm', '0');
        $boards_edtforum->set_var ('forum_name', $forum_name);
        $boards_edtforum->set_var ('forum_order', $forum_order);
        $boards_edtforum->set_var ('forum_dscp', $forum_dscp);
        $boards_edtforum->set_var ('chk_hidden', ($is_hidden) ? 'checked="checked"' : '');
        $boards_edtforum->set_var ('chk_readonly', ($is_readonly) ? 'checked="checked"' : '');
        $boards_edtforum->set_var ('chk_newposts', ($no_newposts) ? 'checked="checked"' : '');

        $boards_edtforum->set_var ('LANG_CATEGORY', $LANG_GF01['category']);
        $boards_edtforum->set_var ('categorylist', $categorylist);
        $boards_edtforum->set_var ('LANG_DESCRIPTION', $LANG_GF01['DESCRIPTION']);
        $boards_edtforum->set_var ('LANG_NAME', $LANG_GF01['NAME']);
        $boards_edtforum->set_var ('LANG_ORDER', $LANG_GF01['ORDER']);
        $boards_edtforum->set_var ('LANG_GROUPACCESS', $LANG_GF93['groupaccess']);

        $boards_edtforum->set_var ('LANG_readonly', $LANG_GF93['readonly']);
        $boards_edtforum->set_var ('LANG_readonlydscp', $LANG_GF93['readonlydscp']);
        $boards_edtforum->set_var ('LANG_hidden', $LANG_GF93['hidden']);
        $boards_edtforum->set_var ('LANG_hiddendscp', $LANG_GF93['hiddendscp']);
        $boards_edtforum->set_var ('LANG_hideposts', $LANG_GF93['hideposts']);
        $boards_edtforum->set_var ('LANG_hidepostsdscp', $LANG_GF93['hidepostsdscp']);

        $boards_edtforum->set_var ('grouplist', $grouplist);
        $boards_edtforum->set_var ('LANG_SAVE', $LANG_GF01['SAVE']);
        $boards_edtforum->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
        $boards_edtforum->set_var ('gltoken_name', CSRF_TOKEN);
        $boards_edtforum->set_var ('gltoken', SEC_createToken());
        $boards_edtforum->parse ('output', 'boards_edtforum');
        $display .= $boards_edtforum->finish ($boards_edtforum->get_var('output'));
        $display .= COM_endBlock();
        $display = COM_createHTMLDocument($display);
        COM_output($display);
        exit();
    }
}


// MAIN CODE

$boards = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
$boards->set_file (array ('boards'=>'boards.thtml'));

$boards->set_block('boards', 'category_record');
$boards->set_block('boards', 'forum_record');
$boards->set_block('boards', 'no_records_message');

$boards->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/boards.php');
$boards->set_var ('siteurl', $_CONF['site_url']);
$boards->set_var ('adminurl', $_CONF['site_admin_url']);
$boards->set_var ('imgset', $CONF_FORUM['imgset']);
$boards->set_var ('addcat', $LANG_GF93['addcat']);
$boards->set_var ('cat', $LANG_GF01['category']);
$boards->set_var ('edit', $LANG_GF01['EDIT']);
$boards->set_var ('delete', $LANG_GF01['DELETE']);
$boards->set_var ('merge', $LANG_GF01['MERGE']);
$boards->set_var ('topic', $LANG_GF01['TOPIC']);
$boards->set_var ('LANG_forum', $LANG_GF93['forum']);
$boards->set_var ('LANG_category', $LANG_GF93['category']);
$boards->set_var ('LANG_posts', $LANG_GF93['posts']);
$boards->set_var ('LANG_order', $LANG_GF93['ordertitle']);
$boards->set_var ('LANG_title', $LANG_GF93['title']);
$boards->set_var ('LANG_description', $LANG_GF93['description']);
$boards->set_var ('LANG_catorder', $LANG_GF93['catorder']);
$boards->set_var ('LANG_action', $LANG_GF93['action']);
$boards->set_var ('LANG_forumdesc', $LANG_GF93['forumdescription']);
$boards->set_var ('addforum', $LANG_GF93['addforum']);
$boards->set_var ('addcat', $LANG_GF93['addcat']);
$boards->set_var ('description', $LANG_GF01['DESCRIPTION']);
$boards->set_var ('resync', $LANG_GF01['RESYNC']);
$boards->set_var ('edit', $LANG_GF01['EDIT']);
$boards->set_var ('resync_cat', $LANG_GF01['RESYNCCAT']);
$boards->set_var ('submit', $LANG_GF01['SUBMIT']);

/* Display each Forum Category */
$asql = DB_query("SELECT * FROM {$_TABLES['forum_categories']} ORDER BY cat_order");
while ($A = DB_FetchArray($asql)) {
    $boards->set_var ('catid', $A['id']);
    $boards->set_var ('catname', $A['cat_name']);
    $boards->set_var ('catdesc', $A['cat_dscp']);
    $boards->set_var ('catorder', $A['cat_order']);

    /* Display each forum within this category */
    $bsql = DB_query("SELECT * FROM {$_TABLES['forum_forums']} WHERE forum_cat={$A['id']} ORDER BY forum_order");
    $bnrows = DB_numRows($bsql);

    for ($j = 1; $j <= $bnrows; $j++) {
        $B = DB_FetchArray($bsql);
        $boards->set_var ('forumname', $B['forum_name']);
        $boards->set_var ('forumid', $B['forum_id']);
        $boards->set_var ('messagecount', $B['post_count']);

        /* Check if this is a private forum */
        if ($B['grp_id'] != '2') {
            $grp_name = DB_getItem($_TABLES['groups'],'grp_name', "grp_id='{$B['grp_id']}'");
            $boards->set_var ('forumdscp', "[{$LANG_GF93['private']}&nbsp;-&nbsp;{$grp_name}]<br" . XHTML . ">{$B['forum_dscp']}");
        } else {
            $boards->set_var ('forumdscp', $B['forum_dscp']);
        }
        $boards->set_var ('forumorder', $B['forum_order']);
		$boards->set_var('gltoken_name', CSRF_TOKEN);
		$boards->set_var('gltoken', SEC_createToken());        
        if ($j == 1) {
            $boards->parse ('forum_record', 'forum_record');
        } else {
            $boards->parse ('forum_record', 'forum_record',true);
        }
    }
    if ($bnrows == 0) {
        $boards->set_var('hide_options','none');
        $boards->set_var('forum_record', '');
        
        $boards->set_var ('records_message', $LANG_GF93['noforum']);
        $boards->parse ('no_records_message', 'no_records_message');
    }  else {
    	$boards->set_var ('no_records_message', '');
        $boards->set_var('hide_options','');
    }
    
	$boards->set_var('gltoken_name', CSRF_TOKEN);
	$boards->set_var('gltoken', SEC_createToken());    
    $boards->parse ('category_record', 'category_record',true);

}

$boards->set_var('gltoken_name', CSRF_TOKEN);
$boards->set_var('gltoken', SEC_createToken());
$boards->parse ('output', 'boards');
$display .= $boards->finish ($boards->get_var('output'));
$display .= COM_endBlock();
$display = COM_createHTMLDocument($display);
COM_output($display);


/* Function to create a new forum
*
* @param        string     $name        Forum name
* @param        string     $category    Category id to add the forum
* @param        string     $dscp        Optional Category Description
* @param        string     $order       Optional Display order
* @param        string     $order       Optional Group ID if a private group - Default Group 'All Users'
* @param        string     $order       Optional Readonly flag
* @param        string     $order       Optional Hidden flag
* @param        string     $order       Optional Don't show in newposts and centerblock
* @return       string                  Returns the Forum ID for the new forum if successful
*/
function forum_addForum($name,$category,$dscp="",$order="",$grp_id=2,$is_readonly=0,$is_hidden=0,$no_newposts=0) {
    global $_TABLES, $_USER;

    DB_query("INSERT INTO {$_TABLES['forum_forums']} (forum_order,forum_name,forum_dscp,forum_cat,grp_id,is_readonly,is_hidden,no_newposts)
        VALUES ('$order','$name','$dscp','$category','$grp_id','$is_readonly','$is_hidden','$no_newposts')");

    $query = DB_query("SELECT MAX(forum_id) FROM {$_TABLES['forum_forums']} ");
    list ($forumid) = DB_fetchArray($query);
    $modquery = DB_query("SELECT * FROM {$_TABLES['forum_moderators']} WHERE mod_uid='{$_USER['uid']}' AND mod_forum='$forumid'");
    if (DB_numrows($modquery) < 1){
        DB_query("INSERT INTO {$_TABLES['forum_moderators']} (mod_uid,mod_username,mod_forum,mod_delete,mod_ban,mod_edit,mod_move,mod_stick) VALUES ('{$_USER['uid']}','{$_USER[username]}', '$forumid','1','1','1','1','1')");
    }
    return $forumid;
}

/* Function to delete a forum
*
* @param        string     $id        Forum id to delete
* @return       boolean               Returns true
*/
function forum_deleteForum($id) {
    global $_TABLES;
    
    DB_query("DELETE FROM {$_TABLES['forum_forums']} WHERE forum_id='$id'");
    DB_query("DELETE FROM {$_TABLES['forum_topic']} WHERE forum='$id'");
    DB_query("DELETE FROM {$_TABLES['forum_moderators']} WHERE mod_forum='$id'");
    DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE forum_id ='$id'");
    DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE forum='$id'");
    
    return true;
}

/* Function to merge a forum into another forum
*
* @param        string     $id        Forum id to merge
* @param        string     $id        New Forum id 
* @return       boolean               Returns true
*/
function forum_mergeForum($id, $new_id) {
    global $_TABLES;
    
    DB_query("UPDATE {$_TABLES['forum_topic']} SET forum='$new_id' WHERE forum='$id'");
    DB_query("UPDATE {$_TABLES['forum_watch']} SET forum_id='$new_id' WHERE forum_id='$id'");
    DB_query("UPDATE {$_TABLES['forum_log']} SET forum='$new_id' WHERE forum='$id'");

    // Resynch forum now    
    gf_resyncforum($new_id);
    
    // Delete old forum now and any records we do not need
    forum_deleteForum($id);
    
    return true;
}

?>
