<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// | File: index.php                                                         |
// | Main admin script                                                       |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// |                                                                         |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
// +-------------------------------------------------------------------------+
// |                                                                         |
// | This program is free software; you can redistribute it and/or           |
// | modify it under the terms of the GNU General Public License             |
// | as published by the Free Software Foundation; either version 2          |
// | of the License, or (at your option) any later version.                  |
// |                                                                         |
// | This program is distributed in the hope that it will be useful,         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                    |
// | See the GNU General Public License for more details.                    |
// |                                                                         |
// | You should have received a copy of the GNU General Public License       |
// | along with this program; if not, write to the Free Software Foundation, |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.         |
// |                                                                         |
// +-------------------------------------------------------------------------+
//
//@@@@@20080917 CSRF checks

require_once '../../../lib-common.php';
include_once $_CONF['path_html'] . 'filemgmt/include/header.php';
include_once $_CONF['path_html'] . 'filemgmt/include/functions.php';
include_once $_CONF['path_html'] . 'filemgmt/include/xoopstree.php';
include_once $_CONF['path_html'] . 'filemgmt/include/textsanitizer.php';
include_once $_CONF['path_html'] . 'filemgmt/include/errorhandler.php';
include_once $_CONF['path'] . 'system/classes/navbar.class.php';

$op = '';
if (isset($_REQUEST['op'])) {
    $op = COM_applyFilter($_REQUEST['op']);
}
$display = '';
if (!SEC_hasRights('filemgmt.edit')) {
    if ($op != 'comment') {
        $display .= COM_startBlock(_GL_ERRORNOACCESS);
        $display .= _MD_USER . " " . $_USER['username'] . " " . _GL_NOUSERACCESS;
        $display .= COM_endBlock();
        if (function_exists('COM_createHTMLDocument')) {
            $display = COM_createHTMLDocument($display);
        } else {
            $display = COM_siteHeader() . $display . COM_siteFooter();
        }
        COM_output($display);
        exit;
    }
}

function filemgmt_navbar($selected='') {
    global $_CONF, $LANG_FM02, $_FM_TABLES;

    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_brokenlinks']}");
    list($totalbrokendownloads) = DB_fetchArray($result);
    if ($totalbrokendownloads > 0) {
        $totalbrokendownloads = '<span style="display:inline; background-image:none; padding:0; color:#ff0000; font-weight:bold;">' . $totalbrokendownloads . '</span>';
    }
    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE status=0");
    list($totalnewdownloads) = DB_fetchArray($result);
    if ($totalnewdownloads > 0) {
        $totalnewdownloads = '<span style="display:inline; background-image:none; padding:0; color:#ff0000; font-weight:bold;">' . $totalnewdownloads . '</span>';
    }

    $navbar = new navbar;
    $navbar->add_menuitem($LANG_FM02['nav1'], $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php?op=filemgmtConfigAdmin');
    $navbar->add_menuitem($LANG_FM02['nav2'], $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php?op=categoryConfigAdmin');
    $navbar->add_menuitem($LANG_FM02['nav3'], $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php?op=newfileConfigAdmin');
    $navbar->add_menuitem(sprintf($LANG_FM02['nav4'], $totalnewdownloads), $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php?op=listNewDownloads');
    $navbar->add_menuitem(sprintf($LANG_FM02['nav5'], $totalbrokendownloads), $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php?op=listBrokenDownloads');

    if ($selected == $LANG_FM02['nav4']) {
        $navbar->set_selected(sprintf($LANG_FM02['nav4'], $totalnewdownloads));
    } elseif ($selected == $LANG_FM02['nav5']) {
        $navbar->set_selected(sprintf($LANG_FM02['nav5'], $totalbrokendownloads));
    } else {
        $navbar->set_selected($selected);
    }

    return $navbar->generate();

}

$myts = new MyTextSanitizer;
$mytree = new XoopsTree($_DB_name, $_FM_TABLES['filemgmt_cat'], "cid", "pid");
$eh = new ErrorHandler;

function mydownloads() {
    global $_FM_TABLES;

    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE);
    $display .= filemgmt_navbar();
    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE status > 0");
    list($numrows) = DB_fetchArray($result);
    $display .= '<br' . XHTML . '><br' . XHTML . '><div style="text-align:center;padding:10px;">';
    $display .= sprintf(_MD_THEREARE, $numrows);
    $display .= '</div>';
    $display .= '<br' . XHTML . '>';
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}

function listNewDownloads() {
    global $_CONF, $_TABLES, $_FM_TABLES, $myts, $mytree,
           $filemgmt_FileStoreURL, $filemgmt_FileSnapURL, $LANG_FM02;

    // List downloads waiting for validation
    $sql = "SELECT lid, cid, title, url, homepage, version, size, logourl, submitter, comments, platform ";
    $sql .= "FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE status=0 ORDER BY date DESC";
    $result = DB_query($sql);
    $numrows = DB_numRows($result);
    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE) . LB;
    $display .= filemgmt_navbar($LANG_FM02['nav4']);

    $i = 1;
    if ($numrows > 0) {
        $display .= '<table border="0" class="plugin" style="width:100%;">' . LB;
        $display .= '<tr><td class="pluginHeader" style="width:100%; padding:5px;">' . _MD_DLSWAITING . '&nbsp;(' . $numrows . ')</td></tr>' . LB;
        while (list($lid, $cid, $title, $url, $homepage, $version, $size, $logourl, $submitter, $comments, $tmpnames) = DB_fetchArray($result)) {
            $result2 = DB_query("SELECT description FROM {$_FM_TABLES['filemgmt_filedesc']} WHERE lid='$lid'");
            list($description) = DB_fetchArray($result2);
            $title = $myts->makeTboxData4Edit($title);
            $url = rawurldecode($myts->makeTboxData4Edit($url));
            $logourl = rawurldecode($myts->makeTboxData4Edit($logourl));
            $homepage = $myts->makeTboxData4Edit($homepage);
            $version = $myts->makeTboxData4Edit($version);
            $size = $myts->makeTboxData4Edit($size);
            $description = $myts->makeTareaData4Edit($description);
            $tmpfilenames = explode(";", $tmpnames);
            $tempfileurl = $filemgmt_FileStoreURL . 'tmp/' . $tmpfilenames[0];
            if (isset($tmpfilenames[1]) and $tmpfilenames[1] != '') {
                $tempsnapurl = $filemgmt_FileSnapURL . 'tmp/' . $tmpfilenames[1];
            } else {
                $tempsnapurl = '';
            }
            $display .= '<tr><td>' . LB;
            $display .= '<form action="index.php" method="post" enctype="multipart/form-data" style="margin:0px;">' . LB;
            $display .= '<table border="0" class="plugin" style="width:100%;">' . LB;
            $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_SUBMITTER . '</td><td>' . LB;
            $display .= '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $submitter . '">'  . COM_getDisplayName($submitter) . '</a>' . LB;
            $display .= '</td></tr>' . LB;
            $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_FILETITLE . '</td><td>' . LB;
            $display .= '<input type="text" name="title" size="50" maxlength="100" value="' . $title . '"' . XHTML . '>' . LB;
            $display .= '</td></tr><tr><td style="text-align:right; white-space:nowrap;">' . _MD_DLFILENAME . '</td><td>' . LB;
            $display .= '<input type="text" name="url" size="50" maxlength="250" value="' . $url . '"' . XHTML . '>' . LB;
            $display .= '</td></tr>' . LB;
            $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_CATEGORYC . '</td><td>' . LB;
            $display .= $mytree->makeMySelBox('title', 'title', $cid) . LB;
            $display .= '</td></tr>' . LB;
            $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_HOMEPAGEC . '</td><td>' . LB;
            $display .= '<input type="text" name="homepage" size="50" maxlength="100" value="' . $homepage . '"' . XHTML . '></td></tr>' . LB;
            $display .= '<tr><td style="text-align:right;">' . _MD_VERSIONC . '</td><td>' . LB;
            $display .= '<input type="text" name="version" size="10" maxlength="10" value="' . $version . '"' . XHTML . '></td></tr>' . LB;
            $display .= '<tr><td style="text-align:right;">' . _MD_FILESIZEC . '</td><td>' . LB;
            $display .= '<input type="text" name="size" size="10" maxlength="8" value="' . $size . '"' . XHTML . '>&nbsp;' . _MD_BYTES . '</td></tr>' . LB;
            $display .= '<tr><td style="text-align:right; vertical-align:top; white-space:nowrap;">' . _MD_DESCRIPTIONC . '</td><td>' . LB;
            $display .= '<textarea name="description" cols="60" rows="5">' . $description . '</textarea>' . LB;
            $display .= '</td></tr>' . LB;
            $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_SHOTIMAGE . '</td><td>' . LB;
            $display .= '<input type="text" name="logourl" size="50" maxlength="250" value="' . $logourl . '"' . XHTML . '>' . LB;
            if ($tempsnapurl != '') {
                $display .= '<span style="padding-left:20px;"><a href="' . $tempsnapurl . '">Preview</a></span>' . LB;
            }
            $display .= '</td></tr>' . LB;
            $display .= '<tr><td></td><td>' . LB;
            $display .= '</td></tr><tr><td style="text-align:right; white-space:nowrap;">' . _MD_COMMENTOPTION . '</td><td>' . LB;
            if ($comments) {
                $display .= '<input type="radio" name="commentoption" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;' . LB;
                $display .= '<input type="radio" name="commentoption" value="0"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;' . LB;
            } else {
                $display .= '<input type="radio" name="commentoption" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;' . LB;
                $display .= '<input type="radio" name="commentoption" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;' . LB;
            }
            $display .= '</td></tr>' . LB;
            $display .= '<tr><td style="text-align:right;padding:10px;">' . LB;
            $display .= '<input type="submit" onclick=\'this.form.op.value="delNewDownload"\' value="' . _MD_DELETE . '"' . XHTML . '>' . LB;
            $display .= '<input type="hidden" name="op" value=""' . XHTML . '>' . LB;
            $display .= '<input type="hidden" name="lid" value="' . $lid . '"' . XHTML . '>' . LB;
            //@@@@@20080917add CSRF checks ---->
            $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . SEC_createToken() . '"' . XHTML . '>' . LB;
            //@@@@@20080917add CSRF checks <----
            $display .= '<span style="padding-left:10px;">' . LB;
            $display .= '<input type="submit" value="' . _MD_APPROVE . '" onclick=\'this.form.op.value="approve"\'' . XHTML . '></span>' . LB;
            $display .= '</td><td style="padding:10px;">' . _MD_DLTEMPFILE . '<a href="' . $tempfileurl . '">' . _MD_TEMPFILE . '</a></td></tr>' . LB;
            if ($numrows > 1 and $i < $numrows) {
               $i++;
            }
            $display .= '</table></form></td></tr>' . LB;
        }
        $display .= '</table>' . LB;
    } else {
        $display .= '<div style="padding:20px">' . _MD_NOSUBMITTED . '</div>' . LB;
    }

    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}


function categoryConfigAdmin() {
    global $_TABLES, $LANG_FM02, $_FM_TABLES, $mytree;

    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE) . LB;
    $display .= filemgmt_navbar($LANG_FM02['nav2']) . LB;
    $display .= '<table cellpadding="0" cellspacing="0" style="width:100%;"><tr><td style="width:100%;">' . LB;
    $display .= '<form action="index.php" method="post" enctype="multipart/form-data" style="margin:0px;"><div>' . LB;
    $display .= '<table border="0" class="plugin" style="width:100%;">' . LB;
    $display .= '<tr><td colspan="2" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_ADDMAIN . '</td></tr>' . LB;
    $display .= '<tr><td>' . _MD_TITLEC. '</td><td><input type="text" name="title" size="30" maxlength="50"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_CATSEC. '</td><td><select name="sel_access">' . LB;
    $display .= COM_optionList($_TABLES['groups'], "grp_id,grp_name") . '</select></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_ADDCATEGORYSNAP . '<br' . XHTML . '><span style="text-size:-2">' . _MD_ADDIMAGENOTE . '</span></td>' . LB;
    $display .= '<td><input type="file" name="uploadfile" size="50" maxlength="200"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td colspan="2" style="text-align:center;padding:10px;">' . LB;
    $display .= '<input type="hidden" name="cid" value="0"' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="op" value="addCat"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks ---->
    $wk_token = SEC_createToken();
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $wk_token . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks <----
    $display .= '<input type="submit" value="' . _MD_ADD . '"' . XHTML . '>' . LB;
    $display .= '</td></tr></table></div></form>' . LB;

    // Add a New Sub-Category
    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_cat']}");
    $numrows = DB_numRows($result);
    if ($numrows > 0) {
        $display .= '</td></tr><tr><td>' . LB;
        $display .= '<form method="post" action="index.php" style="margin:0px;"><div>' . LB;
        $display .= '<table border="0" class="plugin" style="width:100%; margin-top:10px;">' . LB;
        $display .= '<tr><td colspan="2" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_ADDSUB . '</td></tr>' . LB;

        $display .= '<tr><td style="width:20%">' . _MD_TITLEC . '</td><td><input type="text" name="title" size="30" maxlength="50"' . XHTML . '>&nbsp;' . _MD_IN . '&nbsp;';
        $display .= $mytree->makeMySelBox('title', 'title') . '</td></tr>' . LB;
        $display .= '<tr><td colspan="2" style="text-align:center;padding:10px;">' . LB;
        $display .= '<input type="hidden" name="op" value="addCat"' . XHTML . '>' . LB;
        //@@@@@20080917add CSRF checks ---->
        $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $wk_token . '"' . XHTML . '>' . LB;
        //@@@@@20080917add CSRF checks <----
        $display .= '<input type="submit" value="' . _MD_ADD . '"' . XHTML . '>' . LB;
        $display .= '</td></tr></table></div></form>' . LB;
        // Modify Category
        $display .= '</td></tr><tr><td>';
        $display .= '<form method="post" action="index.php" style="margin:0px;"><div>';
        $display .= '<table border="0" class="plugin" style="width:100%; margin-top:10px;">';
        $display .= '<tr><td colspan="2" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_MODCAT . '</td></tr>';
        $display .= '<tr><td style="width:20%">' . _MD_CATEGORYC . '</td><td>';
        $display .= $mytree->makeMySelBox('title', 'title') . '</td></tr>';
        $display .= '<tr><td colspan="2" style="text-align:center;padding:10px;">';
        $display .= '<input type="hidden" name="op" value="modCat"' . XHTML . '>' . LB;
        //@@@@@20080917add CSRF checks ---->
        $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $wk_token . '"' . XHTML . '>' . LB;
        //@@@@@20080917add CSRF checks <----
        $display .= '<input type="submit" value="' . _MD_MODIFY . '"' . XHTML . '>' . LB;
        $display .= '</td></tr></table></div></form>';
    }
    $display .= '</td></tr></table>';

    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);

}

function newfileConfigAdmin() {
    global $mytree, $LANG_FM02;

    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE);
    $display .= filemgmt_navbar($LANG_FM02['nav3']);
    $display .= '<form method="post" enctype="multipart/form-data" action="index.php" style="margin:0px;">';
    $display .= '<table border="0" class="plugin" style="width:100%;">';
    $display .= '<tr><td colspan="2" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_ADDNEWFILE . '</td></tr>';
    $display .= '<tr><td style="text-align:right;">' . _MD_FILETITLE . '</td><td>';
    $display .= '<input type="text" name="title" size="50" maxlength="100"' . XHTML . '>';
    $display .= '</td></tr><tr><td style="text-align:right; white-space:nowrap;">File:</td><td>';
    $display .= '<input type="file" name="newfile" size="50" maxlength="100"' . XHTML . '>';
    $display .= '</td></tr>';
    $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_CATEGORYC . '</td><td>';
    $display .= $mytree->makeMySelBox('title', 'title');
    $display .= '</td></tr><tr><td></td><td></td></tr>';
    $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_HOMEPAGEC . '</td><td>';
    $display .= '<input type="text" name="homepage" size="50" maxlength="100"' . XHTML . '></td></tr>';
    $display .= '<tr><td style="text-align:right;">' . _MD_VERSIONC . '</td><td>';
    $display .= '<input type="text" name="version" size="10" maxlength="10"' . XHTML . '></td></tr>';
    $display .= '<tr><td style="text-align:right; vertical-align:top; white-space:nowrap;">' . _MD_DESCRIPTIONC . '</td><td>';
    $display .= '<textarea name="description" cols="60" rows="5"></textarea>';
    $display .= '</td></tr>';
    $display .= '<tr><td style="text-align:right; white-space:nowrap;">' . _MD_SHOTIMAGE . '</td><td>';
    $display .= '<input type="file" name="newfileshot" size="50" maxlength="60"' . XHTML . '></td></tr>';
    $display .= '<tr><td style="text-align:right;"></td><td>';
    $display .= '</td></tr><tr><td style="text-align:right;">' . _MD_COMMENTOPTION . '</td><td>';
    $display .= '<input type="radio" name="commentoption" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
    $display .= '<input type="radio" name="commentoption" value="0"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    $display .= '</td></tr>';
    $display .= '<tr><td colspan="2" style="text-align:center; padding:10px;">';
    $display .= '<input type="hidden" name="op" value="addDownload"' . XHTML . '>';
    $display .= '<input type="submit" class="button" value="' . _MD_ADD . '"' . XHTML . '>';
    //@@@@@20080917add CSRF checks ---->
    $display .= LB;
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . SEC_createToken() . '"' . XHTML . '>';
    $display .= LB;
    //@@@@@20080917add CSRF checks <----
    $display .= '</td></tr></table>';
    $display .= '</form>';
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);

}

function modDownload() {
    global $_CONF, $_FM_TABLES, $_USER, $myts, $mytree,
           $filemgmt_SnapStore, $filemgmt_FileSnapURL;

    $lid = 0;
    if (isset($_GET['lid'])) {
        $lid = COM_applyFilter($_GET['lid'], true);
    }
    $result = DB_query("SELECT cid, title, url, homepage, version, size, logourl, comments "
                     . "FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
    $nrows = DB_numRows($result);
    if ($nrows == 0) {
        redirect_header("index.php", 2, _MD_NOMATCH);
        exit;
    }

    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE) . LB;

    $display .= '<form method="post" enctype="multipart/form-data" action="index.php"><div>' . LB;
    $display .= '<input type="hidden" name="op" value="modDownloadS"' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="lid" value="' . $lid . '"' . XHTML . '>' . LB;
    $display .= '<table border="0" class="plugin" style="width:100%;">' . LB;

    list($cid, $title, $url, $homepage, $version, $size, $logourl, $comments) = DB_fetchArray($result);
    $title = $myts->makeTboxData4Edit($title);
    $pathstring = "<a href=\"{$_CONF['site_url']}/filemgmt/index.php\">" . _MD_MAIN . "</a>&nbsp;:&nbsp;";
    $nicepath = $mytree->getNicePathFromId($cid, "title", "{$_CONF['site_url']}/filemgmt/viewcat.php?op=");
    $pathstring .= $nicepath;
    $pathstring .= "<a href=\"{$_CONF['site_url']}/filemgmt/index.php?id=$lid\">{$title}</a>";

    $display .= '<tr><td colspan="3" style="width:100%; padding:5px;">' . $pathstring . '</td></tr>' . LB;
    $display .= '<tr><td colspan="3" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_MODDL . '</td></tr>' . LB;

    $url = rawurldecode($myts->makeTboxData4Edit($url));
    $homepage = $myts->makeTboxData4Edit($homepage);
    $version = $myts->makeTboxData4Edit($version);
    $size = $myts->makeTboxData4Edit($size);
    $logourl = rawurldecode($myts->makeTboxData4Edit($logourl));
    $result2 = DB_query("SELECT description FROM {$_FM_TABLES['filemgmt_filedesc']} WHERE lid=$lid");
    list($description) = DB_fetchArray($result2);
    $description = $myts->makeTareaData4Edit($description);
    $display .= '<tr><td>' . _MD_FILEID . '</td><td colspan="2"><b>' . $lid . '</b></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_FILETITLE . '</td><td colspan="2"><input type="text" name="title" value="' . $title . '" size="50" maxlength="200"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_DLFILENAME . '</td><td colspan="2"><input type="text" name="url" value="' . $url . '" size="50" maxlength="200"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td style="width:25%;">' . _MD_REPLFILENAME . '</td><td colspan="2"><input type="file" name="newfile" size="50" maxlength="200"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_HOMEPAGEC . '</td><td colspan="2"><input type="text" name="homepage" value="' . $homepage . '" size="50" maxlength="150"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_VERSIONC . '</td><td colspan="2"><input type="text" name="version" value="' . $version . '" size="10" maxlength="10"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_FILESIZEC . '</td><td colspan="2"><input type="text" name="size" value="' . $size . '" size="10" maxlength="20"' . XHTML . '> ' . _MD_BYTES . '</td></tr>' . LB;
    $display .= '<tr><td style="vertical-align:top;">' . _MD_DESCRIPTIONC . '</td><td colspan="2"><textarea name="description" cols="55" rows="10">' . $description . '</textarea></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_CATEGORYC . '</td><td colspan="2">';
    $display .= $mytree->makeMySelBox("title", "title", $cid, 0, "cid");
    $display .= '</td></tr>' . LB;

    if (!empty($logourl) AND file_exists($filemgmt_SnapStore . $logourl)) {
        $display .= '<tr><td>' . _MD_SHOTIMAGE . '</td><td style="width:5%;"><img src="' . $filemgmt_FileSnapURL . $logourl . '" style="width:80px;" alt=""' . XHTML . '></td>' . LB;
        $display .= '<td style="width:35%;"><input type="file" size="40" name="newfileshot"' . XHTML . '><br' . XHTML . '><br' . XHTML . '><input type="checkbox" name="deletesnap"' . XHTML . '>&nbsp;Delete</td></tr>' . LB;
    } else {
        $display .= '<tr><td>' . _MD_SHOTIMAGE . '</td>' . LB;
        $display .= '<td colspan="2"><input type="file" size="40" name="newfileshot"' . XHTML . '></td></tr>' . LB;
    }

    $display .= '<tr><td>' . _MD_COMMENTOPTION . '</td><td colspan="2">' . LB;
    if ($comments) {
        $display .= '<input type="radio" name="commentoption" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;' . LB;
        $display .= '<input type="radio" name="commentoption" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;' . LB;
    } else {
        $display .= '<input type="radio" name="commentoption" value="1" ' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;' . LB;
        $display .= '<input type="radio" name="commentoption" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;' . LB;
    }
    $display .= '</td></tr>' . LB;

    $display .= '<tr><td>' . _MD_MODOPT . '</td><td colspan="2">' . LB;
    $display .= '<input type="checkbox" name="updateregdate"' . XHTML . '>&nbsp;' . _MD_OPTUPDATE . LB;
    $display .= '</td></tr>' . LB;

    $display .= '<tr><td colspan="3" style="text-align:center;padding:10px;">' . LB;
    $display .= '<input type="submit" value="' . _MD_SUBMIT . '"' . XHTML . '><span style="padding-left:15px;padding-right:15px;">' . LB;
    $display .= '<input type="submit" value="' . _MD_DELETE . '" onclick=\'if (confirm("Delete this file ?")) {this.form.op.value="delDownload";return true}; return false\'' . XHTML . '>' . LB;
    $display .= '</span><input type="button" value="' . _MD_CANCEL . '" onclick="javascript:history.go(-1)"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks ---->
    $wk_token = SEC_createToken();
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $wk_token . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks <----
    $display .= '</td></tr></table></div></form>' . LB;


    /* Display File Voting Information */
    $result5 = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_votedata']}");
    list($totalvotes) = DB_fetchArray($result5);

    $display .= '<form method="post" action="index.php"><div>' . LB;
    $display .= '<input type="hidden" name="op" value=""' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="rid" value=""' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="lid" value="' . $lid . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks ---->
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $wk_token . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks <----
    $display .= '<table class="pluginSubTable" style="vertical-align:top; width:100%;">' . LB;
    $display .= '<tr><th colspan="7">';
    if ($totalvotes == '')
       $totalvotes = 0;
    $display .= sprintf(_MD_DLRATINGS, $totalvotes);
    $display .= '</th></tr>' . LB;
    // Show Registered Users Votes
    $result5 = DB_query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp "
                      . "FROM {$_FM_TABLES['filemgmt_votedata']} WHERE lid='$lid' "
                      . "AND ratinguser != 0 ORDER BY ratingtimestamp DESC");
    $votes = DB_numRows($result5);
    $display .= '<tr><td colspan="7">';
    $display .= sprintf(_MD_REGUSERVOTES, $votes);
    $display .= '</td></tr>' . LB;
    $display .= '<tr><th>' . _MD_USER . '</th><th>' . _MD_IP . '</th><th>' . _MD_RATING . '</th><th>'
              . _MD_USERAVG . '</th><th>' . _MD_TOTALRATE . '</th><th>'
              . _MD_DATE  . '</th><th style="text-align:center;">' . _MD_DELETE . '</th></tr>';
    if ($votes == 0) {
        $display .= '<tr><td style="text-align:center;" colspan="7">'
                  . _MD_NOREGVOTES . '<br' . XHTML . '></td></tr>' . LB;
    }
    $x = 0;
    $cssid = 1;
    while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = DB_fetchArray($result5)) {
        $formatted_date = formatTimestamp($ratingtimestamp);

        //Individual user information
        $result2 = DB_query("SELECT rating FROM {$_FM_TABLES['filemgmt_votedata']} WHERE ratinguser='$ratinguser'");
        $uservotes = DB_numRows($result2);
        $useravgrating = 0;
        while (list($rating2) = DB_fetchArray($result2)) {
             $useravgrating = $useravgrating + $rating2;
        }
        $useravgrating = $useravgrating / $uservotes;
        $useravgrating = number_format($useravgrating, 1);
        $ratinguname = $_USER['username'];
        $display .= '<tr class="pluginRow' . $cssid . '"><td>' . $ratinguname . '</td><td>' . $ratinghostname . '</td><td>' . $rating . '</td>';
        $display .= '<td>' . $useravgrating . '</td><td>' . $uservotes . '</td><td>' . $formatted_date . '</td><td style="text-align:right;padding-right:20px;">' . LB;
        $display .= '<input type="image" src="' . $_CONF['site_url'] . '/filemgmt/images/delete.gif" ';
        $display .= 'onclick=\'if (confirm("Delete this record")) {this.form.op.value="delVote";this.form.lid.value="' . $lid . '";this.form.rid.value="' . $ratingid . '";return true};return false;\' value="Delete"' . XHTML . '>' . LB;
        $display .= '</td></tr>' . LB;
        $x++;
        $cssid = ($cssid == 1) ? 2 : 1;
    }

    $display .= '</table></div></form>' .LB;
    // Show Unregistered Users Votes
    $result5 = DB_query("SELECT ratingid, rating, ratinghostname, ratingtimestamp "
                      . "FROM {$_FM_TABLES['filemgmt_votedata']} WHERE lid='$lid' "
                      . "AND ratinguser=0 ORDER BY ratingtimestamp DESC");
    $votes = DB_numRows($result5);
    $display .= '<form method="post" action="index.php" onsubmit="alert(this.form.op.value)"><div>' . LB;
    $display .= '<input type="hidden" name="op" value=""' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="rid" value=""' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="lid" value="' . $lid . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks ---->
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $wk_token . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks <----
    $display .= '<table class="pluginSubTable" style="vertical-align:top; width:100%;">' . LB;
    $display .= '<tr><th colspan="7">';
    $display .= sprintf(_MD_ANONUSERVOTES, $votes);
    $display .= '</th></tr>' . LB;
    $display .= '<tr><th colspan="2">' . _MD_IP . '</th><th colspan="3">' . _MD_RATING . '</th><th colspan="2">' . _MD_DATE . '</th></tr>' . LB;
    if ($votes == 0) {
        $display .= '<tr><td colspan="7" style="text-align:center;">' . _MD_NOUNREGVOTES . '<br' . XHTML . '></td></tr>' . LB;
    }
    $x = 0;
    $cssid = 1;
    while (list($ratingid, $rating, $ratinghostname, $ratingtimestamp) = DB_fetchArray($result5)) {
        $formatted_date = formatTimestamp($ratingtimestamp);
        $display .= '<tr class="pluginRow' . $cssid . '" style="vertical-align:bottom;"><td colspan="2">' . $ratinghostname . '</td><td colspan="3">' . $rating . '</td>' . LB;
        $display .= '<td>' . $formatted_date . '</td>' . LB . '<td style="text-align:right;padding-right:20px;">' . LB;
        $display .= '<input type="image" src="' . $_CONF['site_url'] . '/filemgmt/images/delete.gif" ';
        $display .= 'onclick=\'if (confirm("Delete this record")) {this.form.op.value="delVote";this.form.lid.value="' . $lid . '";this.form.rid.value="' . $ratingid . '";return true};return false;\' value="Delete"' . XHTML . '>' . LB;
        $display .= '</td></tr>' . LB;
        $x++;
        $cssid = ($cssid == 1) ? 2 : 1;
    }
    $display .= '<tr><td colspan="6">&nbsp;<br' . XHTML . '></td></tr>' . LB;
    $display .= '</table></div></form>' . LB;
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}

function listBrokenDownloads() {
    global $_CONF, $_TABLES, $_FM_TABLES, $LANG_FM02;

    $result = DB_query("SELECT * FROM {$_FM_TABLES['filemgmt_brokenlinks']} ORDER BY reportid");
    $totalbrokendownloads = DB_numRows($result);

    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE) . LB;
    $display .= filemgmt_navbar($LANG_FM02['nav5']);

    if ($totalbrokendownloads == 0) {
        $display .= '<div style="padding:20px">' . _MD_NOBROKEN . '</div>' . LB;
    } else {
        $display .= '<form method="post" action="index.php"><div>' . LB;
        $display .= '<input type="hidden" name="op" value=""' . XHTML . '>' . LB;
        $display .= '<input type="hidden" name="lid" value=""' . XHTML . '>' . LB;
        //@@@@@20080917add CSRF checks ---->
        $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . SEC_createToken() . '"' . XHTML . '>' . LB;
        //@@@@@20080917add CSRF checks <----
        $display .= '<table border="0" class="plugin" style="width:100%;">' . LB;
        $display .= '<tr><td colspan="5" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_BROKENREPORTS . '&nbsp;(' . $totalbrokendownloads . ')</td></tr>' . LB;
        $display .= '<tr><td colspan="5">' . _MD_IGNOREDESC . '<br' . XHTML . '>' . _MD_DELETEDESC . '</td></tr>' . LB;
        $display .= '<tr class="pluginHeader"><th>' . _MD_FILETITLE . '</th><th>' . _MD_REPORTER . '</th>' . LB;
        $display .= '<th>' . _MD_FILESUBMITTER . '</th><th>' . _MD_IGNORE . '</th><th>' . _MD_DELETE . '</th></tr>' . LB;

        $cssid = 1;
        while (list($reportid, $lid, $sender, $ip) = DB_fetchArray($result)) {
            $result2 = DB_query("SELECT title, url, submitter FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
            if ($sender != 0) {
                $result3 = DB_query("SELECT username, email FROM {$_TABLES['users']} WHERE uid='$sender'");
                list($sendername, $email) = DB_fetchArray($result3);
            }
            list($title, $url, $owner) = DB_fetchArray($result2);
            $result4 = DB_query("SELECT username, email FROM {$_TABLES['users']} WHERE uid='$owner'");
            list($ownername, $owneremail) = DB_fetchArray($result4);
            $display .= '<tr class="pluginRow' . $cssid . '"><td><a href="' . $_CONF['site_url'] . '/filemgmt/visit.php?lid=' . $lid . '">' . $title . '</a></td>' . LB;

            if ($email == '') {
                $display .= '<td>' . $sendername . ' (' . $ip . ')' . LB;
            } else {
                $display .= '<td><a href="mailto:' . $email . '">' . $sendername . '</a> (' . $ip . ')' . LB;
            }
            $display .= '</td>' . LB;
            if ($owneremail == '') {
                $display .= '<td>' . $ownername;
            } else {
                $display .= '<td><a href="mailto:' . $owneremail . '">' . $ownername . '</a>';
            }
            $display .= '</td><td style="text-align:center">' . LB;
            $display .= '<input type="image" src="' . $_CONF['site_url'] . '/filemgmt/images/delete.gif" ';
            $display .= 'onclick=\'if (confirm("Delete this broken file report?")) {this.form.op.value="ignoreBrokenDownloads";';
            $display .= 'this.form.lid.value="' . $lid . '";return true};return false;\'' . XHTML . '>' . LB;
            $display .= '</td>' . LB;
            $display .= '<td style="text-align:center">' . LB;
            $display .= '<input type="image" src="' . $_CONF['site_url'] . '/filemgmt/images/delete.gif" ';
            $display .= 'onclick=\'if (confirm("Delete the file from your repository?")) {this.form.op.value="delBrokenDownloads";';
            $display .= 'this.form.lid.value="' . $lid . '";return true};return false;\'' . XHTML . '>' . LB;
            $display .= '</td></tr>' . LB;
            $cssid = ($cssid == 1) ? 2 : 1;
        }
        $display .= '</table></div></form>' . LB;
    }
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}

function delBrokenDownloads() {
    global $_FM_TABLES;

    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_brokenlinks']} WHERE lid='$lid'");
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedetail']}  WHERE lid='$lid'");
    redirect_header("index.php?op=listBrokenDownloads", 1, _MD_FILEDELETED);
    exit;
}

function ignoreBrokenDownloads() {
    global $_FM_TABLES;

    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_brokenlinks']} WHERE lid='$lid'");
    redirect_header("index.php?op=listBrokenDownloads", 1, _MD_BROKENDELETED);
    exit;
}

function delVote() {
    global $_CONF, $_FM_TABLES;

    $rid = 0;
    if (isset($_POST['rid'])) {
        $rid = COM_applyFilter($_POST['rid'], true);
    }
    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_votedata']} WHERE ratingid='$rid'");
    updaterating($lid);
    redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php?lid=$lid&op=modDownload", 2, _MD_VOTEDELETED);
    exit;
}


function modDownloadS() {
    global $_CONF, $_FM_TABLES, $myts,
           $filemgmt_SnapStore, $filemgmt_FileStore;

    $cid = 0;
    if (isset($_POST['cid'])) {
        $cid = COM_applyFilter($_POST['cid'], true);
    }
    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    $url = '';
    if (isset($_POST['url'])) {
        $url = rawurlencode($myts->makeTboxData4Save($_POST['url']));
    }

    $currentfile = DB_getItem($_FM_TABLES['filemgmt_filedetail'], 'url', "lid='$lid'");
    $currentfileFQN = $filemgmt_FileStore . $myts->makeTboxData4Save(rawurldecode($currentfile));
    $newfile = rawurlencode($myts->makeTboxData4Save($_FILES['newfile']['name']));
    COM_errorLog("Currentfilename is:'$currentfile' and new file is:'$newfile'");
    if (($newfile != '' AND $currentfile != $newfile)  OR ($newfile != '' and $currentfile == '')) {
        COM_errorLog("Download file has changed");
        if (uploadNewFile($_FILES["newfile"], $filemgmt_FileStore)) {
            if (file_exists($currentfileFQN) && (!is_dir($currentfileFQN))) {
                $err=@unlink ($currentfileFQN);
            }
            $url = rawurlencode($myts->makeTboxData4Save($_FILES['newfile']['name']));
            DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} SET url='$url' WHERE lid='$lid'");
        }
    }

    $currentsnapfile = DB_getItem($_FM_TABLES['filemgmt_filedetail'], 'logourl', "lid='$lid'");
    $currentSnapFQN = $filemgmt_SnapStore . $myts->makeTboxData4Save(rawurldecode($currentsnapfile));
    $newsnapfile = rawurlencode($myts->makeTboxData4Save($_FILES['newfileshot']['name']));
    if (($newsnapfile !="" AND $currentsnapfile != $newsnapfile)  OR ($newsnapfile != '' and $currentsnapfile == '')) {
        //COM_errorLog("Snap file has changed");
        if (uploadNewFile($_FILES["newfileshot"], $filemgmt_SnapStore)) {
            if (file_exists($currentSnapFQN) && (!is_dir($currentSnapFQN))) {
                $err = @unlink($currentSnapFQN);
            }
            $logourl = rawurlencode($myts->makeTboxData4Save($_FILES['newfileshot']['name']));
            DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} SET logourl='$logourl' WHERE lid='$lid'");
        }
    } elseif (isset($_POST['deletesnap'])) {
        if (file_exists($currentSnapFQN) && (!is_dir($currentSnapFQN))) {
            $err = @unlink($currentSnapFQN);
            DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} SET logourl='' WHERE lid='$lid'");
            COM_errorLog("Delete repository snapfile:$currentSnapFQN.");
        }
    }

    $title = $myts->makeTboxData4Save($_POST['title']);
    $homepage = $myts->makeTboxData4Save($_POST['homepage']);
    $version = $myts->makeTboxData4Save($_POST['version']);
    $size = $myts->makeTboxData4Save($_POST['size']);
    $description = $myts->makeTareaData4Save($_POST['description']);
    $commentoption = 0;
    if (isset($_POST['commentoption'])) {
        $commentoption = COM_applyFilter($_POST['commentoption'], true);
    }
    $update = (isset($_POST['updateregdate'])) ? "date=" . time() . ", " : "";
    DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} "
           . "SET cid='$cid', title='$title', url='$url', homepage='$homepage', "
           . "version='$version', size='$size', status=1, " . $update
           . "comments='$commentoption' WHERE lid='$lid'");
    DB_query("UPDATE {$_FM_TABLES['filemgmt_filedesc']} "
           . "SET description='$description' WHERE lid='$lid'");
    redirect_header("{$_CONF['site_url']}/filemgmt/index.php", 2, _MD_DBUPDATED);
    exit;
}

function delDownload() {
    global $_FM_TABLES, $_CONF, $myts,
           $filemgmt_FileStore, $filemgmt_SnapStore;

    $lid = $myts->makeTboxData4Save($_POST['lid']);
    $name = $myts->makeTboxData4Save(rawurldecode($_POST['url']));
    $tmpurl = rawurlencode($_POST['url']);
    $tmpfile = $filemgmt_FileStore . $name;

    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE url='$tmpurl'");
    list($numrows) = DB_fetchArray($result);
    $tmpsnap = DB_getItem($_FM_TABLES['filemgmt_filedetail'], 'logourl', "lid='$lid'");
    $tmpsnap = $filemgmt_SnapStore . $tmpsnap;

    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedetail']}  WHERE lid='$lid'");
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedesc']}    WHERE lid='$lid'");
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_votedata']}    WHERE lid='$lid'");
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_brokenlinks']} WHERE lid='$lid'");

    // Check for duplicate files of the same filename (actual filename in repository)
    // We don't want to delete actual file if there are more then 1 record linking to it.
    // Site may be allowing more then 1 file listing to duplicate files
    if ($numrows > 1) {
         redirect_header("{$_CONF['site_url']}/filemgmt/index.php", 2, _MD_FILENOTDELETED);
         exit;
    } else {
        if ($tmpfile != "" && file_exists($tmpfile) && (!is_dir($tmpfile))) {
            $err = @unlink($tmpfile);
        }
        if ($tmpsnap != "" && file_exists($tmpsnap) && (!is_dir($tmpsnap))) {
            $err = @unlink($tmpsnap);
        }
    }
    redirect_header("{$_CONF['site_url']}/filemgmt/index.php", 2, _MD_FILEDELETED);
    exit;
}

function modCat() {
    global $_TABLES, $_FM_TABLES, $myts, $mytree, $LANG_FM02;

    $cid = 0;
    if (isset($_POST['cid'])) {
        $cid = COM_applyFilter($_POST['cid'], true);
    }
    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE) . LB;
    $display .= filemgmt_navbar($LANG_FM02['nav2']) . LB;
    $display .= '<form action="index.php" method="post" enctype="multipart/form-data" style="margin:0px;"><div>' . LB;
    $display .= '<input type="hidden" name="op" value="modCatS"' . XHTML . '>' . LB;
    $display .= '<input type="hidden" name="cid" value="' . $cid . '"' . XHTML . '>' . LB;
    $display .= '<table border="0" class="plugin" style="width:100%;">' . LB;
    $display .= '<tr><td colspan="2" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_MODCAT . '</td></tr>' . LB;

    $result = DB_query("SELECT pid, title, imgurl, grp_access FROM {$_FM_TABLES['filemgmt_cat']} WHERE cid='$cid'");
    list($pid, $title, $imgurl, $grp_access) = DB_fetchArray($result);
    $title = $myts->makeTboxData4Edit($title);
    $imgurl = rawurldecode($myts->makeTboxData4Edit($imgurl));

    $display .= '<tr><td>' . _MD_TITLEC . '</td><td><input type="text" name="title" value="' . $title . '" size="51" maxlength="50"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_CATSEC . '</td><td><select name="sel_access"><option value="0">Select Access</option>' . LB;
    $display .= COM_optionList($_TABLES['groups'], "grp_id,grp_name", $grp_access) . '</select></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_IMGURLMAIN . '</td><td><input type="file" name="imgurl" value="' . $imgurl . '" size="50" maxlength="100"' . XHTML . '></td></tr>' . LB;
    $display .= '<tr><td>' . _MD_PARENT . '</td><td>' . LB;
    $display .= $mytree->makeMySelBox("title", "title", $pid, 1, "pid") . LB;
    $display .= '</td></tr>' . LB;
    $display .= '<tr><td colspan="2" style="text-align:center;padding:10px;">' . LB;
    $display .= '<input type="submit" value="' . _MD_SAVE . '"' . XHTML . '>' . LB;
    $display .= '<input type="submit" value="' . _MD_DELETE . '" onclick=\'if (confirm("Delete this file ?")) {this.form.op.value="delCat";return true}; return false\'' . XHTML . '>' . LB;
    $display .= '&nbsp;<input type="button" value="' . _MD_CANCEL . '" onclick="javascript:history.go(-1)"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks ---->
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . SEC_createToken() . '"' . XHTML . '>' . LB;
    //@@@@@20080917add CSRF checks <----
    $display .= '</td></tr></table>';
    $display .= '</div></form>';
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}


function delNewDownload() {
    global $_FM_TABLES, $filemgmt_FileStore, $filemgmt_SnapStore;

    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    if (DB_count($_FM_TABLES['filemgmt_filedetail'], 'lid', $lid) == 1) {
        $tmpnames = explode(";", DB_getItem($_FM_TABLES['filemgmt_filedetail'], 'platform', "lid='$lid'"));
        $tmpfilename = $tmpnames[0];
        $tmpshotname = $tmpnames[1];
        $tmpfilename = $filemgmt_FileStore . "tmp/" . $tmpfilename;
        $tmpshotname = $filemgmt_SnapStore . "tmp/" . $tmpshotname;

        DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
        DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedesc']} WHERE lid='$lid'");
        if ($tmpfilename != '' && file_exists($tmpfilename) && (!is_dir($tmpfilename))) {
            $err = @unlink($tmpfilename);
            //COM_errorLog("Delete submitted file: " . $tmpfilename . " Return status of unlink is: " . $err);
        }
        if ($tmpshotname != '' && file_exists($tmpshotname) && (!is_dir($tmpshotename))) {
            $err = @unlink($tmpshotname);
            //COM_errorLog("Delete submitted snapshot: " . $tmpshotname . " Return status of unlink is: " . $err);
        }
        redirect_header("index.php?op=listNewDownloads", 1, _MD_FILEDELETED);
    } else {
        redirect_header("index.php?op=listNewDownloads", 1, _MD_ERRORNOFILE);
    }
    exit;
}



function modCatS() {
    global $_CONF, $_FM_TABLES, $myts;

    $cid = 0;
    if (isset($_POST['cid'])) {
        $cid = COM_applyFilter($_POST['cid'], true);
    }
    $sid = 0;
    if (isset($_POST['pid'])) {
        $sid = COM_applyFilter($_POST['pid'], true);
    }
    $title = $myts->makeTboxData4Save($_POST['title']);
    $title = str_replace('/', '&#47', $title);
    $grp_access = $_POST['sel_access'];
    if ($grp_access < 1) {
        $grp_access = 2;  // All Users Group
    }
    if (($_POST["imgurl"]) || ($_POST["imgurl"]!="")) {
        $imgurl = $myts->makeTboxData4Save($_POST["imgurl"]);
    }
    DB_query("UPDATE {$_FM_TABLES['filemgmt_cat']} "
           . "SET title='$title', imgurl='$imgurl', pid='$sid', "
           . "grp_access='$grp_access' WHERE cid='$cid'");
    redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php", 2, _MD_DBUPDATED);
    exit;
}

function delCat() {
    global $_CONF, $_FM_TABLES, $mytree,
           $filemgmt_FileStore,
           $filemgmt_SnapCat,
           $filemgmt_SnapStore;

    $cid = 0;
    if (isset($_POST['cid'])) {
        $cid = COM_applyFilter($_POST['cid'], true);
    }
    //get all subcategories under the specified category
    $arr = $mytree->getAllChildId($cid);
    for ($i=0; $i < sizeof($arr); $i++) {
        //get all downloads in each subcategory
        $result = DB_query("SELECT lid,url,logourl FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE cid='{$arr[$i]}'");
        //now for each download, delete the text data and votes associated with the download
        while (list($lid, $url, $logourl) = DB_fetchArray($result)) {
            DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedesc']} WHERE lid='$lid'");
            DB_query("DELETE FROM {$_FM_TABLES['filemgmt_votedata']} WHERE lid='$lid'");
            DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
            DB_query("DELETE FROM {$_FM_TABLES['filemgmt_brokenlinks']} WHERE lid='$lid'");
            $name = rawurldecode($url);
            $fullname = $filemgmt_FileStore . $name;
            if ($fullname != "" && file_exists($fullname) && (!is_dir($fullname))) {
                $err = @unlink($fullname);
            }
            $name = rawurldecode($logourl);
            $fullname = $filemgmt_SnapStore . $name;
            if ($fullname != "" && file_exists($fullname) && (!is_dir($fullname))) {
                $err = @unlink($fullname);
            }
        }
        //all downloads for each subcategory is deleted, now delete the subcategory data
        $catimage = DB_getItem($_FM_TABLES['filemgmt_cat'], 'imgurl', "cid='{$arr[$i]}'");
        $catimage_filename = $filemgmt_SnapCat . $catimage;
        if ($catimage != '' && file_exists($catimage_filename) && (!is_dir($catimage_filename))) {
            // Check that there is only one category using this image
            if (DB_count($_FM_TABLES['filemgmt_cat'], 'imgurl', $catimage) == 1) {
                @unlink($catimage_filename);
            }
        }
        DB_query("DELETE FROM {$_FM_TABLES['filemgmt_cat']} WHERE cid='{$arr[$i]}'");
    }
    //all subcategory and associated data are deleted, now delete category data and its associated data
    $result = DB_query("SELECT lid,url,logourl FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE cid='$cid'");
    while (list($lid, $url, $logourl) = DB_fetchArray($result)) {
        DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
        DB_query("DELETE FROM {$_FM_TABLES['filemgmt_filedesc']} WHERE lid='$lid'");
        DB_query("DELETE FROM {$_FM_TABLES['filemgmt_brokenlinks']} WHERE lid='$lid'");

        $name = rawurldecode($url);
        $fullname = $filemgmt_FileStore . $name;
        if ($fullname != "" && file_exists($fullname) && (!is_dir($fullname))) {
            $err = @unlink($fullname);
        }
        $name = rawurldecode($logourl);
        $fullname = $filemgmt_SnapStore . $name;
        if ($fullname != "" && file_exists($fullname) && (!is_dir($fullname))) {
            $err = @unlink($fullname);
        }
    }
    $catimage = DB_getItem($_FM_TABLES['filemgmt_cat'], 'imgurl', "cid='$cid'");
    $catimage_filename = $filemgmt_SnapCat . $catimage;
    if ($catimage != '' && file_exists($catimage_filename) && (!is_dir($catimage_filename))) {
        // Check that there is only one category using this image
        if (DB_count($_FM_TABLES['filemgmt_cat'], 'imgurl', $catimage) == 1) {
            @unlink($catimage_filename);
        }
    }
    DB_query("DELETE FROM {$_FM_TABLES['filemgmt_cat']} WHERE cid='$cid'");
    redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php?op=categoryConfigAdmin", 2, _MD_CATDELETED);
    exit;
}

function addCat() {
    global $_CONF, $_FM_TABLES, $filemgmt_SnapCat, $myts;

    $pid = 0;
    if (isset($_POST['cid'])) {
        $pid = COM_applyFilter($_POST['cid'], true);
    }
    $title = '';
    if (isset($_POST['title'])) {
        $title = COM_applyFilter($_POST['title']);
    }
    $title = str_replace('/', '&#47', $title);
    $grp_access = 0;
    if (isset($_POST['sel_access'])) {
        $grp_access = COM_applyFilter($_POST['sel_access'], true);
    }
    if ($grp_access < 2) {
       $grp_access = 2;
    }
    if ($title != '') {
        $title = $myts->makeTboxData4Save($title);
        if ($_FILES["uploadfile"]["name"]!="") {
            $name = $_FILES["uploadfile"]['name'];        // this is the real name of your file
            $tmp  = $_FILES["uploadfile"]['tmp_name'];    // temporary name of file in temporary directory on server
            $imgurl = rawurlencode($myts->makeTboxData4Save($name));
            if (is_uploaded_file($tmp)) {                       // is this temporary file really uploaded?
                if (!file_exists($filemgmt_SnapCat . $name)) {       // Check to see the file already exists
                    $target = $filemgmt_SnapCat . $name;
                    $returnMove = move_uploaded_file($tmp, $target);    // move temporary file to your upload directory
                }
            }
        }
        DB_query("INSERT INTO {$_FM_TABLES['filemgmt_cat']} "
               . "(pid, title, imgurl,grp_access) "
               . "VALUES ('$pid', '$title', '$imgurl','$grp_access')");
    }
    redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php?"
                  . "op=categoryConfigAdmin", 2, _MD_NEWCATADDED);
    exit;
}

function addDownload() {
    global $_CONF, $_USER, $_FM_TABLES,
           $filemgmt_FileStore, $filemgmt_SnapStore, $myts, $eh;

    $filename = $myts->makeTboxData4Save($_FILES['newfile']['name']);
    $url = $myts->makeTboxData4Save(rawurlencode($filename));
    $snapfilename = $myts->makeTboxData4Save($_FILES['newfileshot']['name']);
    $logourl = $myts->makeTboxData4Save(rawurlencode($snapfilename));
    $title = $myts->makeTboxData4Save($_POST['title']);
    $homepage = $myts->makeTboxData4Save($_POST['homepage']);
    $version = $myts->makeTboxData4Save($_POST['version']);
    $description = $myts->makeTareaData4Save($_POST['description']);
    $commentoption = $_POST['commentoption'];
    $submitter = $_USER['uid'];
    $size = $myts->makeTboxData4Save(intval($_FILES['newfile']['size']));
    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE url='$url'");
    list($numrows) = DB_fetchArray($result);
    $errormsg = "";

    // Check if Title blank
    if ($title=="") {
        $eh->show("1104");
    }
    // Check if Description blank
    if ($description=="") {
        $eh->show("1105");
    }
    // Check if a file was uploaded
    if ($_FILES['newfile']['size'] == 0) {
        $eh->show("1017");
    }

    if (!empty($_POST['cid'])) {
        $cid = $_POST['cid'];
    } else {
        $cid = 0;
    }

    if (uploadNewFile($_FILES["newfile"], $filemgmt_FileStore)) {
        $AddNewFile = true;
    }
    if (uploadNewFile($_FILES["newfileshot"], $filemgmt_SnapStore)) {
        $AddNewFile = true;
    }

    if ($AddNewFile) {
        DB_query("INSERT INTO {$_FM_TABLES['filemgmt_filedetail']} "
               . "(cid, title, url, homepage, version, size, "
               . "logourl, submitter, status, date, hits, rating, votes, comments) "
               . "VALUES ('$cid', '$title', '$url', '$homepage', '$version', '$size', '$logourl', "
               . "'$submitter', 1, " . time() . ", 0, 0, 0,'$commentoption')");
        $newid = DB_insertID();
        DB_query("INSERT INTO {$_FM_TABLES['filemgmt_filedesc']} "
               . "(lid, description) VALUES ($newid, '$description')");
        if ($duplicatefile) {
            redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php", 2, _MD_NEWDLADDED_DUPFILE);
        } elseif ($duplicatesnap) {
            redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php", 2, _MD_NEWDLADDED_DUPSNAP);
        } else {
            redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php", 2, _MD_NEWDLADDED);
        }
        exit;
    } else {
        redirect_header("index.php", 2, _MD_ERRUPLOAD . "");
        exit;
    }
}


function approve() {
    global $_FM_TABLES, $_TABLES, $_CONF, $myts, $eh,
           $filemgmt_FileStore, $filemgmt_SnapStore,
           $filemgmt_Emailoption, $filemgmtFilePermissions;

    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    $title = '';
    if (isset($_POST['title'])) {
        $title = COM_applyFilter($_POST['title']);
    }
    $cid = 0;
    if (isset($_POST['cid'])) {
        $cid = COM_applyFilter($_POST['cid'], true);
    }
    $homepage = $_POST['homepage'];
    $version = $_POST['version'];
    $size = $_POST['size'];
    $description = $_POST['description'];
    if (($_POST['url']) || ($_POST['url'] != '')) {
        $name = $myts->makeTboxData4Save($_POST['url']);
        $url = rawurlencode($name);
    }
    if (($_POST['logourl']) || ($_POST['logourl'] != '')) {
        $shotname = $myts->makeTboxData4Save($_POST['logourl']);
        $logourl = $myts->makeTboxData4Save(rawurlencode($_POST['logourl']));
    }

    $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE url='$url' AND status=1");
    list($numrows) = DB_fetchArray($result);

    // Comment out this check if you want to allow duplicate filelistings for same file in the repository
    // Check for duplicate files of the same filename (actual filename in repository)
    if ($numrows > 0) {
        $eh->show("1108");
    }

    $title = $myts->makeTboxData4Save($title);
    $homepage = $myts->makeTboxData4Save($homepage);
    $version = $myts->makeTboxData4Save($_POST['version']);
    $size = $myts->makeTboxData4Save($_POST['size']);
    $description = $myts->makeTareaData4Save($description);
    $commentoption = $_POST["commentoption"];

    // Move file from tmp directory under the document filestore to the main file directory
    // Now to extract the temporary names for both the file and optional thumbnail.
    // I've used th platform field which I'm not using now for anything.
    $tmpnames = explode(";", DB_getItem($_FM_TABLES['filemgmt_filedetail'], 'platform', "lid='$lid'"));
    $tmpfilename = $tmpnames[0];
    $tmpshotname = $tmpnames[1];
    $tmp = $filemgmt_FileStore . "tmp/" . $tmpfilename;
    if (file_exists($tmp) && (!is_dir($tmp))) {  // if this temporary file was really uploaded?
        $newfile = $filemgmt_FileStore .$name;
        COM_errorLog("File move from " . $tmp . " to " . $newfile);
        $rename = @rename($tmp, $newfile);
        COM_errorLog("Results of rename is: " . $rename);
        $chown = @chmod($newfile, $filemgmtFilePermissions);
        if (!file_exists($newfile)) {
            COM_errorLog("Filemgmt upload approve error: "
                       . "New file does not exist after move of tmp file: '" . $newfile . "'");
            $AddNewFile = false;    // Set false again - in case it was set true above for actual file
            $eh->show("1101");
        } else {
            $AddNewFile = true;
        }
    } else {
        COM_errorLog("Filemgmt upload approve error: Temporary file does not exist: '" . $tmp . "'");
        $eh->show("1101");
    }

    if ($tmpshotname != "") {
        $tmp = $filemgmt_SnapStore . "tmp/" . $tmpshotname;
        if (file_exists($tmp) && (!is_dir($tmp))) {                // if this temporary Thumbnail was really uploaded?
            $newfile = $filemgmt_SnapStore . $shotname;
            $rename = @rename($tmp, $newfile);
            $chown = @chmod ($newfile, $filemgmtFilePermissions);
            if (!file_exists($newfile)) {
                COM_errorLog("Filemgmt upload approve error: "
                           . "New file does not exist after move of tmp file: '" . $newfile . "'");
                $AddNewFile = false;    // Set false again - in case it was set true above for actual file
                $eh->show("1101");
            }
        } else {
            COM_errorLog("Filemgmt upload approve error: Temporary file does not exist: '" . $tmp . "'");
            $eh->show("1101");
        }
    }
    if ($AddNewFile) {
        DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} "
               . "SET cid='$cid', title='$title', url='$url', homepage='$homepage', "
               . "version='$version', size='$size', logourl='$logourl', status=1, "
               . "date=" . time() . ", comments='$commentoption' WHERE lid='$lid'");
        DB_query("UPDATE {$_FM_TABLES['filemgmt_filedesc']} "
               . "SET description='$description' WHERE lid='$lid'");

        // Send a email to submitter notifying them that file was approved
        if ($filemgmt_Emailoption) {
            $result = DB_query("SELECT username, email FROM {$_TABLES['users']} a, "
                             . "{$_FM_TABLES['filemgmt_filedetail']} b "
                             . "WHERE a.uid=b.submitter AND b.lid='$lid'");
            list($submitter_name, $emailaddress) = DB_fetchArray($result);
            $mailtext  = sprintf(_MD_HELLO, $submitter_name);
            $mailtext .= ",\n\n" . _MD_WEAPPROVED . " " . $title . " \n" . _MD_THANKSSUBMIT . "\n\n";
            $mailtext .= "{$_CONF["site_name"]}\n";
            $mailtext .= "{$_CONF['site_url']}\n";
            //COM_errorLog("email: " . $emailaddress.", text: " . $mailtext);
            if (function_exists(COM_mail)) {
                COM_mail($emailaddress, _MD_APPROVED, $mailtext);
            } else {
                mail($emailaddress, "{$_CONF["site_name"]}: " . _MD_UPLOADAPPROVED ,
                     $mailtext, "From: {$_CONF["site_name"]} <{$_CONF["site_mail"]}>\n"
                              . "Return-Path: <{$_CONF["site_mail"]}>\nX-Mailer: GeekLog $VERSION");
            }
        }
    }
    redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php?op=listNewDownloads", 2, _MD_NEWDLADDED);
    exit;
}


function filemgmtConfigAdmin() {
    global $LANG_FM02;
    global $mydownloads_perpage, $mydownloads_popular, $mydownloads_newdownloads, $mydownloads_trimdesc, $mydownloads_dlreport;
    global $mydownloads_selectpriv, $mydownloads_uploadselect, $mydownloads_publicpriv, $mydownloads_uploadpublic;
    global $mydownloads_useshots, $mydownloads_shotwidth, $mydownloads_whatsnew, $filemgmt_Emailoption;
    global $filemgmt_FileStoreURL, $filemgmt_FileSnapURL, $filemgmt_FileStore, $filemgmt_SnapStore, $filemgmt_SnapCat, $filemgmt_SnapCatURL;

    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE);
    $display .= filemgmt_navbar($LANG_FM02['nav1']);
    $display .= '<form action="index.php" method="post" style="margin:0px;">';
    $display .= '<table border="0" class="plugin" style="width:100%;">';
    $display .= '<tr><td colspan="2" class="pluginHeader" style="width:100%; padding:5px;">' . _MD_GENERALSET . '</td></tr>';
    $display .= '<tr><td style="white-space:nowrap;">' . _MD_DLSPERPAGE . '</td>';
    $display .= '<td>
        <select name="xmydownloads_perpage">
        <option value="' . $mydownloads_perpage . '" selected="selected">' . $mydownloads_perpage . '</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="50">50</option>
        </select>
        </td></tr><tr><td style="white-space:nowrap;">
        ' . _MD_HITSPOP . '</td><td>
        <select name="xmydownloads_popular">
        <option value="' . $mydownloads_popular . '" selected="selected">' . $mydownloads_popular . '</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="500">500</option>
        <option value="1000">1000</option>
        </select>
        </td></tr><tr><td style="white-space:nowrap;">
        ' . _MD_DLSNEW . '</td><td>
        <select name="xmydownloads_newdownloads">
        <option value="' . $mydownloads_newdownloads . '" selected="selected">' . $mydownloads_newdownloads . '</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="50">50</option>
       </select><br' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_DLREPORT . ' </td><td>';
    if ($mydownloads_dlreport == 1) {
        $display .= '<input type="radio" name="xmydownloads_dlreport" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_dlreport" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_dlreport" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_dlreport" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_TRIMDESC . ' </td><td>';
    if ($mydownloads_trimdesc == 1) {
        $display .= '<input type="radio" name="xmydownloads_trimdesc" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_trimdesc" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_trimdesc" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_trimdesc" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_WHATSNEWDESC . ' </td><td>';
    if ($mydownloads_whatsnew == 1) {
        $display .= '<input type="radio" name="xmydownloads_whatsnew" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_whatsnew" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_whatsnew" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_whatsnew" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td colspan="2"><hr' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_SELECTPRIV . ' </td><td>';
    if ($mydownloads_selectpriv == 1) {
        $display .= '<input type="radio" name="xmydownloads_selectpriv" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_selectpriv" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_selectpriv" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_selectpriv" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_UPLOADSELECT . ' </td><td>';
    if ($mydownloads_uploadselect == 1) {
        $display .= '<input type="radio" name="xmydownloads_uploadselect" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_uploadselect" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_uploadselect" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_uploadselect" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_ACCESSPRIV . ' </td><td>';
    if ($mydownloads_publicpriv == 1) {
        $display .= '<input type="radio" name="xmydownloads_publicpriv" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_publicpriv" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_publicpriv" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_publicpriv" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_UPLOADPUBLIC . ' </td><td>';
    if ($mydownloads_uploadpublic == 1) {
        $display .= '<input type="radio" name="xmydownloads_uploadpublic" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_uploadpublic" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_uploadpublic" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_uploadpublic" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr><tr><td colspan="2"><hr' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_USESHOTS . ' </td><td>';
    if ($mydownloads_useshots == 1) {
        $display .= '<input type="radio" name="xmydownloads_useshots" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_useshots" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="xmydownloads_useshots" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="xmydownloads_useshots" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }
    $display .= '</td></tr>';
    $display .= '<tr><td style="white-space:nowrap;">' . _MD_IMGWIDTH . ' </td><td>';
    if ($mydownloads_shotwidth != '') {
        $display .= '<input type="text" size="10" name="xmydownloads_shotwidth" value="' . $mydownloads_shotwidth . '"' . XHTML . '>';
    } else {
        $display .= '<input type="text" size="10" name="xmydownloads_shotwidth" value="140"' . XHTML . '>';
    }

    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_EMAILOPTION . '</td><td>';
    if ($filemgmt_Emailoption == true) {
        $display .= '<input type="radio" name="my_emailoption" value="1" checked="checked"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="my_emailoption" value="0" ' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    } else {
        $display .= '<input type="radio" name="my_emailoption" value="1"' . XHTML . '>&nbsp;' . _MD_YES . '&nbsp;';
        $display .= '<input type="radio" name="my_emailoption" value="0" checked="checked"' . XHTML . '>&nbsp;' . _MD_NO . '&nbsp;';
    }

    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_DIRFILES . '</td><td>';
    $display .= '<input type="text" size="60" maxlength="150" name="my_filestore" value="' . $filemgmt_FileStore . '"' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_DIRTHUMBS . '</td><td>';
    $display .= '<input type="text" size="60" maxlength="150" name="my_snapstore" value="' . $filemgmt_SnapStore . '"' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_DIRCATTHUMBS . '</td><td>';
    $display .= '<input type="text" size="60" maxlength="150" name="my_snapcat" value="' . $filemgmt_SnapCat . '"' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_URLFILES . '</td><td>';
    $display .= '<input type="text" size="60" maxlength="150" name="my_filestoreurl" value="' . $filemgmt_FileStoreURL . '"' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_URLTHUMBS . '</td><td>';
    $display .= '<input type="text" size="60" maxlength="150" name="my_filesnapurl" value="' . $filemgmt_FileSnapURL . '"' . XHTML . '>';
    $display .= '</td></tr><tr><td style="white-space:nowrap;">' . _MD_URLCATTHUMBS . '</td><td>';
    $display .= '<input type="text" size="60" maxlength="150" name="my_snapcaturl" value="' . $filemgmt_SnapCatURL . '"' . XHTML . '>';
    $display .= '</td></tr>';
    $display .= '<tr><td colspan="2" style="padding:10px;text-align:center">';
    $display .= '<input type="hidden" name="op" value="filemgmtConfigChange"' . XHTML . '>';
    $display .= '<input type="submit" value="' . _MD_SAVE . '"' . XHTML . '>';
    $display .= '&nbsp;<input type="button" value="' . _MD_CANCEL . '" onclick="javascript:history.go(-1)"' . XHTML . '>';
    //@@@@@20080917add CSRF checks ---->
    $display .= LB;
    $display .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . SEC_createToken() . '"' . XHTML . '>';
    $display .= LB;
    //@@@@@20080917add CSRF checks <----

    $display .= '</td></tr></table>';
    $display .= '</form>';
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}

function filemgmtConfigChange($op='') {
    global $_TABLES, $_CONF, $_FM_CONF;
    global $mydownloads_perpage, $mydownloads_popular, $mydownloads_newdownloads, $mydownloads_trimdesc, $mydownloads_dlreport;
    global $mydownloads_selectpriv, $mydownloads_uploadselect, $mydownloads_publicpriv, $mydownloads_uploadpublic;
    global $mydownloads_useshots, $mydownloads_shotwidth, $mydownloads_whatsnew, $filemgmt_Emailoption;
    global $filemgmt_FileStoreURL, $filemgmt_FileSnapURL, $filemgmt_FileStore, $filemgmt_SnapStore, $filemgmt_SnapCat, $filemgmt_SnapCatURL;

    $configfile = $_CONF['path'] . 'plugins/filemgmt/filemgmt.php';

    if ($op == 'init') {
        $xmydownloads_popular       = $mydownloads_popular;
        $xmydownloads_newdownloads  = $mydownloads_newdownloads;
        $xmydownloads_perpage       = $mydownloads_perpage;
        $xmydownloads_dlreport      = $mydownloads_dlreport;
        $xmydownloads_trimdesc      = $mydownloads_trimdesc;
        $xmydownloads_selectpriv    = $mydownloads_selectpriv;
        $xmydownloads_publicpriv    = $mydownloads_publicpriv;
        $xmydownloads_uploadselect  = $mydownloads_uploadselect;
        $xmydownloads_uploadpublic  = $mydownloads_uploadpublic;
        $xmydownloads_useshots      = $mydownloads_useshots;
        $xmydownloads_shotwidth     = $mydownloads_shotwidth;
        $xmydownloads_whatsnew      = $mydownloads_whatsnew;
        $my_emailoption             = $filemgmt_Emailoption;
        $my_filestoreurl            = $_CONF['site_url'] . '/filemgmt_data/files/';
        $my_filesnapurl             = $_CONF['site_url'] . '/filemgmt_data/snaps/';
        $my_snapcaturl              = $_CONF['site_url'] . '/filemgmt_data/category_snaps/';
        $my_filestore               = $_CONF['path_html'] . 'filemgmt_data/files/';
        $my_snapstore               = $_CONF['path_html'] . 'filemgmt_data/snaps/';
        $my_snapcat                 = $_CONF['path_html'] . 'filemgmt_data/category_snaps/';
    } else {
        $xmydownloads_popular       = $_POST['xmydownloads_popular'];
        $xmydownloads_newdownloads  = $_POST['xmydownloads_newdownloads'];
        $xmydownloads_perpage       = $_POST['xmydownloads_perpage'];
        $xmydownloads_dlreport      = $_POST['xmydownloads_dlreport'];
        $xmydownloads_trimdesc      = $_POST['xmydownloads_trimdesc'];
        $xmydownloads_selectpriv    = $_POST['xmydownloads_selectpriv'];
        $xmydownloads_publicpriv    = $_POST['xmydownloads_publicpriv'];
        $xmydownloads_uploadselect  = $_POST['xmydownloads_uploadselect'];
        $xmydownloads_uploadpublic  = $_POST['xmydownloads_uploadpublic'];
        $xmydownloads_useshots      = $_POST['xmydownloads_useshots'];
        $xmydownloads_shotwidth     = $_POST['xmydownloads_shotwidth'];
        $xmydownloads_whatsnew      = $_POST['xmydownloads_whatsnew'];
        $my_emailoption             = $_POST['my_emailoption'];
        $my_filestoreurl            = $_POST['my_filestoreurl'];
        $my_filesnapurl             = $_POST['my_filesnapurl'];
        $my_snapcaturl              = $_POST['my_snapcaturl'];
        $my_filestore               = $_POST['my_filestore'];
        $my_snapstore               = $_POST['my_snapstore'];
        $my_snapcat                 = $_POST['my_snapcat'];
    }

    // Check to see if Access Priv or Upload priv have changed
    // Will need to update the GL access table if they have

    $feature1_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'filemgmt.user'");
    $feature2_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'filemgmt.upload'");

    if ($xmydownloads_selectpriv != $mydownloads_selectpriv) {
        // Note: assuming "Logged-in Users" group is 13 - always has been
        $result = DB_query("SELECT COUNT(*) FROM {$_TABLES['access']} WHERE acc_ft_id = '$feature1_id' AND acc_grp_id = 13");
        list($nrows) = DB_fetchArray($result);
        if ($xmydownloads_selectpriv == 1 && $nrows == 0) {   // Enable and there is no record now
            COM_errorLog('Granting Logged-In users access to filemgmt.user feature', 1);
            DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ('$feature1_id', 13)");
        } elseif ($xmydownloads_selectpriv == 0 && $nrows == 1) {  // Disable and there is a record
            COM_errorLog('Removing Logged-In users access with filemgmt.user feature', 1);
            DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_grp_id = 13 AND acc_ft_id = '$feature1_id'");
        }
    }
    if ($xmydownloads_publicpriv != $mydownloads_publicpriv) {
        $result = DB_query("SELECT COUNT(*) FROM {$_TABLES['access']} WHERE acc_ft_id = '$feature1_id' AND acc_grp_id = 2");
        list($nrows) = DB_fetchArray($result);
        if ($xmydownloads_publicpriv == 1 && $nrows == 0) {   // Enable and there is no record now
            COM_errorLog('Granting anonymous access to filemgmt.user feature', 1);
            DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ('$feature1_id', 2)");
        } elseif ($xmydownloads_publicpriv == 0 && $nrows == 1) {  // Disable and there is a record
            COM_errorLog('Removing anonymous access with filemgmt.user feature', 1);
            DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_grp_id = 2 AND acc_ft_id = '$feature1_id'");
        }
    }
    if ($xmydownloads_uploadselect != $mydownloads_uploadselect) {
        // Note: assuming "Logged-in Users" group is 13 - always has been
        $result = DB_query("SELECT COUNT(*) FROM {$_TABLES['access']} WHERE acc_ft_id = '$feature2_id' AND acc_grp_id = 13");
        list($nrows) = DB_fetchArray($result);
        if ($xmydownloads_uploadselect == 1 && $nrows == 0) {   // Enable and there is no record now
            COM_errorLog('Granting Logged-In users upload privilage to filemgmt.user feature', 1);
            DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ('$feature2_id', 13)");
        } elseif ($xmydownloads_uploadselect == 0 && $nrows == 1) {  // Disable and there is a record
            COM_errorLog('Removing Logged-In users upload privilage with filemgmt.user feature', 1);
            DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_grp_id = 13 AND acc_ft_id = '$feature2_id'");
        }
    }
    if ($xmydownloads_uploadpublic != $mydownloads_uploadpublic) {
        $result = DB_query("SELECT COUNT(*) FROM {$_TABLES['access']} WHERE acc_ft_id = '$feature2_id' AND acc_grp_id = 2");
        list($nrows) = DB_fetchArray($result);
        if ($xmydownloads_uploadpublic == 1 && $nrows == 0) {   // Enable and there is no record now
            COM_errorLog('Granting anonymous upload privilage to filemgmt.user feature',1);
            DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ('$feature2_id', 2)");
        } elseif ($xmydownloads_uploadpublic == 0 && $nrows == 1) {  // Disable and there is a record
            COM_errorLog('Removing anonymous upload privilage with filemgmt.user feature',1);
            DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_grp_id = 2 AND acc_ft_id = '$feature2_id'");
        }
    }

    if (empty($_FM_CONF['version']) || !GL_VERSION_15) {
        $file = fopen($configfile, "w");
        $content = "";
        $content .= "<?php\n";
        $content .= "\n";
        $content .= "\$mydownloads_popular      = $xmydownloads_popular;\n";
        $content .= "\$mydownloads_newdownloads = $xmydownloads_newdownloads;\n";
        $content .= "\$mydownloads_perpage      = $xmydownloads_perpage;\n";
        $content .= "\$mydownloads_trimdesc     = $xmydownloads_trimdesc;\n";
        $content .= "\$mydownloads_whatsnew     = $xmydownloads_whatsnew;\n";
        $content .= "\$mydownloads_dlreport     = $xmydownloads_dlreport;\n";
        $content .= "\$mydownloads_selectpriv   = $xmydownloads_selectpriv;\n";
        $content .= "\$mydownloads_publicpriv   = $xmydownloads_publicpriv;\n";
        $content .= "\$mydownloads_uploadselect = $xmydownloads_uploadselect;\n";
        $content .= "\$mydownloads_uploadpublic = $xmydownloads_uploadpublic;\n";
        $content .= "\$mydownloads_useshots     = $xmydownloads_useshots;\n";
        $content .= "\$mydownloads_shotwidth    = $xmydownloads_shotwidth;\n";
        $content .= "\$filemgmt_Emailoption     = $my_emailoption;\n";
        $content .= "\$filemgmt_FileStore        = \"$my_filestore\";\n";
        $content .= "\$filemgmt_SnapStore        = \"$my_snapstore\";\n";
        $content .= "\$filemgmt_SnapCat          = \"$my_snapcat\";\n";
        $content .= "\$filemgmt_FileStoreURL     = \"$my_filestoreurl\";\n";
        $content .= "\$filemgmt_FileSnapURL      = \"$my_filesnapurl\";\n";
        $content .= "\$filemgmt_SnapCatURL       = \"$my_snapcaturl\";\n";
        $content .= "\n";
        $content .= "?>\n";

        fwrite($file, $content);
        fclose($file);
    } else {
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $plg_config = config::get_instance();
        $n = 'filemgmt';
        $plg_config->set('mydownloads_popular'      , $xmydownloads_popular,      $n);
        $plg_config->set('mydownloads_newdownloads' , $xmydownloads_newdownloads, $n);
        $plg_config->set('mydownloads_perpage'      , $xmydownloads_perpage,      $n);
        $plg_config->set('mydownloads_trimdesc'     , $xmydownloads_trimdesc,     $n);
        $plg_config->set('mydownloads_whatsnew'     , $xmydownloads_whatsnew,     $n);
        $plg_config->set('mydownloads_dlreport'     , $xmydownloads_dlreport,     $n);
        $plg_config->set('mydownloads_selectpriv'   , $xmydownloads_selectpriv,   $n);
        $plg_config->set('mydownloads_publicpriv'   , $xmydownloads_publicpriv,   $n);
        $plg_config->set('mydownloads_uploadselect' , $xmydownloads_uploadselect, $n);
        $plg_config->set('mydownloads_uploadpublic' , $xmydownloads_uploadpublic, $n);
        $plg_config->set('mydownloads_useshots'     , $xmydownloads_useshots,     $n);
        $plg_config->set('mydownloads_shotwidth'    , $xmydownloads_shotwidth,    $n);
        $plg_config->set('filemgmt_Emailoption'     , $my_emailoption,            $n);
        $plg_config->set('filemgmt_FileStore'       , $my_filestore,              $n);
        $plg_config->set('filemgmt_SnapStore'       , $my_snapstore,              $n);
        $plg_config->set('filemgmt_SnapCat'         , $my_snapcat,                $n);
        $plg_config->set('filemgmt_FileStoreURL'    , $my_filestoreurl,           $n);
        $plg_config->set('filemgmt_FileSnapURL'     , $my_filesnapurl,            $n);
        $plg_config->set('filemgmt_SnapCatURL'      , $my_snapcaturl,             $n);
    }
}

function uploadNewFile($newfile, $directory) {
    global $myts, $eh, $filemgmtDuplicatesAllowed, $filemgmtFilePermissions;

    if ($newfile["name"] != "") {
        $name = $newfile['name'];        // this is the real name of your file
        $tmp  = $newfile['tmp_name'];    // temporary name of file in temporary directory on server
        $name = $myts->makeTboxData4Save($name);
        $logourl = rawurlencode($name);
        COM_errorLog("AddNewFileShot - Upload filename  is " . $directory.$myts->makeTboxData4Save($name));
        if (is_uploaded_file($tmp)) {             // is this temporary file really uploaded?
            $newfile = $directory . $name;
            if (!file_exists($newfile)) {   // Check to see the snapfile already exists
                $returnMove = move_uploaded_file($tmp, $newfile);    // move temp file to upload directory
                if (!$returnMove) {
                    COM_errorLog("Filemgmt File add by admin error: New file could not be created: " . $tmp . " to " . $name);
                    $eh->show("1106");
                    return false;
                } else {
                    $chown = @chmod($newfile, $filemgmtFilePermissions);
                    COM_errorLog("File uploaded and moved ok");
                    return true;
                }
            } else {
                // Allow duplicate file names, user may want to have two filelisting to same file or has already copied the files manually
                COM_errorLog("Filemgmt - Warning: Added new filelisting for a file that already exists " . $directory . $name);
                if (!$filemgmtDuplicatesAllowed) {
                    $eh->show("1108");
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            COM_errorLog("Filemgmt upload error: Temporary file does not exist: '" . $tmp . "'");
            $eh->show("1107");
            return false;
        }
    }
    return false;
}



function filemgmt_comments($firstcomment) {
    global $_CONF;

    $lid = 0;
    if (isset($_GET['lid'])) {
        $lid = COM_applyFilter($_GET['lid'], true);
    }
    $comment_id  = "filemgmt-" . $lid;
    $file = '';
    if (isset($_GET['filename'])) {
        $file = COM_applyFilter($_GET['filename']);
    }
    if ($firstcomment) {
        $story = $comment_id;
        $pid = 0;
        $type = "filemgmt";
        echo COM_refresh($_CONF['site_url'] . "/comment.php?sid=$story&amp;pid=$pid&amp;type=$type");
        exit;
    }
    $display = COM_userComments($comment_id, $file, 'filemgmt', '', 'nested');
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
    exit;
}

if (empty($_FM_CONF['filemgmt_FileStoreURL'])) {
    // Check and see if the current config has values for the filemgmt repository set.
    // If not - then initialize these variables and write the filemgmt.php - config file.
    if ($filemgmt_FileStoreURL == '' OR $filemgmt_FileStore == '') {
        // Set default values and write over the config file
        filemgmtConfigChange('init');
        // Read in the new values
        include ($_CONF['path'] . 'plugins/filemgmt/filemgmt.php');
    }
}

//@@@@@20080917add CSRF checks ---->
$op_ary = array();
$op_ary[]= "filemgmtConfigChange";
$op_ary[]= "addCat";
$op_ary[]= "modCatS";
$op_ary[]= "delCat";
$op_ary[]= "addDownload";
$op_ary[]= "approve";
$op_ary[]= "delNewDownload";
$op_ary[]= "ignoreBrokenDownloads";
$op_ary[]= "delBrokenDownloads";
$op_ary[]= "modDownloadS";
$op_ary[]= "delDownload";
$op_ary[]= "delVote";
if (in_array($op, $op_ary)) {
    if (!SEC_checkToken()) {
        COM_accessLog("User {$_USER['username']} tried to illegally and failed CSRF checks. filemgmt $op");
        echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php');
        exit;
    }
}
//@@@@@20080917add CSRF checks <----


switch ($op) {
    case "comment":
        filemgmt_comments($firstcomment);
        break;
    case "delNewDownload":
        delNewDownload();
        break;
    case "addCat":
        addCat();
        break;
    case "addSubCat":
        addSubCat();
        break;
    case "addDownload":
        addDownload();
        break;
    case "listBrokenDownloads":
        listBrokenDownloads();
        break;
    case "delBrokenDownloads":
        delBrokenDownloads();
        break;
    case "ignoreBrokenDownloads":
        ignoreBrokenDownloads();
        break;
    case "approve":
        approve();
        break;
    case "delVote":
        delVote();
        modDownload();
        break;
    case "delCat":
        delCat();
        break;
    case "modCat":
        modCat();
        break;
    case "modCatS":
        modCatS();
        break;
    case "modDownload":
        modDownload();
        break;
    case "modDownloadS":
        modDownloadS();
        break;
    case "delDownload":
        delDownload();
        break;
    case "filemgmtConfigAdmin":
        filemgmtConfigAdmin();
        break;
    case "filemgmtConfigChange":
        filemgmtConfigChange();
        redirect_header("{$_CONF['site_admin_url']}/plugins/filemgmt/index.php", 2, _MD_CONFIGUPDATED);
        exit;
        break;
    case "categoryConfigAdmin":
        categoryConfigAdmin();
        break;
    case "newfileConfigAdmin":
          newfileConfigAdmin();
        break;
    case "listNewDownloads":
        listNewDownloads();
        break;
    default:
        mydownloads();
        break;
}

?>