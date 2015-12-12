<?php
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
// |                                                                         |
// | Based on:                                                               |
// | myPHPNUKE Web Portal System - http://myphpnuke.com/                     |
// | PHP-NUKE Web Portal System - http://phpnuke.org/                        |
// | Thatware - http://thatware.org/                                         |
// +-------------------------------------------------------------------------+
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

require_once '../lib-common.php';
require_once $_CONF['path_html'] . 'filemgmt/include/header.php';
require_once $_CONF['path_html'] . 'filemgmt/include/functions.php';
require_once $_CONF['path_html'] . 'filemgmt/include/xoopstree.php';
require_once $_CONF['path_html'] . 'filemgmt/include/textsanitizer.php';

$_GROUPS = SEC_getUserGroups($uid);       // List of groups user is a member of
$numCategoriesPerRow = 6;

$myts = new MyTextSanitizer;
$mytree = new XoopsTree($_DB_name, $_FM_TABLES['filemgmt_cat'], 'cid', 'pid');
$mytree->setGroupAccessFilter($_GROUPS);

$cid = 0;
if (isset($_GET['cid'])) {
    $cid = COM_applyFilter($_GET['cid'], true);
}

$groupsql = filemgmt_buildAccessSql();
$sql = "SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_cat']} WHERE cid='$cid' $groupsql";
list($category_rows) = DB_fetchArray(DB_query($sql));
if ($cid == 0 OR $category_rows == 0) {
    echo COM_refresh($_CONF['site_url'] . '/filemgmt/index.php');
    exit;
}

$display = '';
$p = new Template($_CONF['path'] . 'plugins/filemgmt/templates');
$p->set_file(array(
    'page'     => 'filelisting.thtml',
    'records'  => 'filelisting_record.thtml',
    'category' => 'filelisting_subcategory.thtml',
    'sortmenu' => 'sortmenu.thtml'
));
$p->set_var('layout_url', $_CONF['layout_url']);
$p->set_var('site_url', $_CONF['site_url']);
$p->set_var('site_admin_url', $_CONF['site_admin_url']);
$p->set_var('xhtml', XHTML);
$p->set_var('imgset', $_CONF['layout_url'] . '/nexflow/images');
$p->set_var('tablewidth', $mydownloads_shotwidth+10);
$p->set_var('block_header', COM_startBlock(_MD_CATEGORYTITLE));
$p->set_var('block_footer', COM_endBlock());

$trimDescription = true; // Set to false if you do not want to auto trim the description and insert the <more..> link

$page = 1; // If no page sent then assume the first.
if (isset($_GET['page'])) {
    $page = COM_applyFilter($_GET['page'], true);
    if ($page == 0) {
        $page = 1;
    }
}
$show = $mydownloads_perpage;
$offset = ($page - 1) * $show;

$orderby = '';
if (isset($_GET['orderby'])) {
    $orderby = COM_applyFilter($_GET['orderby']);
}
$orderby = convertorderbyin($orderby);

$pathstring = '<a href="index.php">' . _MD_MAIN . '</a>&nbsp;:&nbsp;';
$nicepath = $mytree->getNicePathFromId($cid, "title", "{$_CONF['site_url']}/filemgmt/viewcat.php");
$pathstring .= $nicepath;
$p->set_var('category_path_link', $pathstring);
$p->set_var('cid', $cid);

// get child category objects
$subcategories = '';
$arr = array();
$arr = $mytree->getFirstChild($cid, 'title');

if (count($arr) > 0) {
    $count = 1;
    foreach ($arr as $ele) {
        $totalfiles = 0;
        $chtitle=$myts->makeTboxData4Show($ele['title']);
        $totalfiles = $totalfiles + getTotalItems($ele['cid'], 1);
        $subcategories = '<a href="' . $_CONF[site_url] . '/filemgmt/viewcat.php?cid=' . $ele['cid'] . '">'
            . $chtitle . '</a>&nbsp;(' . $totalfiles . ')&nbsp;&nbsp;';
        $p->set_var('subcategories', $subcategories);
        $p->set_var('new_table_row', ($count == 1) ? '<tr>' : '');
        $p->set_var('end_of_row', ($count == $numCategoriesPerRow) ? '</tr>' : '');
        $count = ($count == $numCategoriesPerRow) ? 1 : ($count + 1);
        $p->parse('category_records', 'category', true);
    }
} else {
    $p->set_var('subcategories', '');
    $p->set_var('new_table_row', '<tr>');
    $p->set_var('end_of_row', '</tr>');
    $p->parse('category_records', 'category');
}

$sql = "SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
$sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
$sql .= "WHERE a.cid = $cid AND status > 0 $groupsql";
list($maxrows) = DB_fetchArray(DB_query($sql));
$numpages = ceil($maxrows / $show);

if ($maxrows > 0) {
    $sql  = "SELECT a.lid, a.cid, a.title, a.url, a.homepage, a.version, a.size, a.submitter, ";
    $sql .= "a.logourl, a.status, a.date, a.hits, a.rating, a.votes, a.comments, b.description ";
    $sql .= "FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
    $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_filedesc']} b ON a.lid=b.lid ";
    $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} c ON a.cid=c.cid ";
    $sql .= "WHERE a.cid='$cid' AND a.status > 0 $groupsql ORDER BY $orderby LIMIT $offset, $show";
    $result = DB_query($sql);

    $numrows = DB_numRows($result);
    //if 2 or more items in result, show the sort menu
    if ($maxrows > 1) {
        $p->set_var('LANG_SORTBY', _MD_SORTBY);
        $p->set_var('LANG_TITLE', _MD_TITLE);
        $p->set_var('LANG_DATE', _MD_DATE);
        $p->set_var('LANG_RATING', _MD_RATING);
        $p->set_var('LANG_POPULARITY', _MD_POPULARITY);
        $p->set_var('LANG_CURSORTBY', _MD_CURSORTBY);
        $p->set_var('orderbyTrans', $orderbyTrans = convertorderbytrans($orderby));
        $p->parse('sort_menu', 'sortmenu');
    }
    $cssid = 1;
    for ($x = 1; $x <= $numrows; $x++) {
        list($lid, $cid, $dtitle, $url, $homepage, $version, $size, $submitter, $logourl, $status,
             $time, $hits, $rating, $votes, $comments, $description) = DB_fetchArray($result);
        $rating = number_format($rating, 2);
        $dtitle = $myts->makeTboxData4Show($dtitle);
        $url = $myts->makeTboxData4Show($url);
        $homepage = $myts->makeTboxData4Show($homepage);
        $version = $myts->makeTboxData4Show($version);
        $size = $myts->makeTboxData4Show($size);
        $platform = $myts->makeTboxData4Show($platform);
        $logourl = $myts->makeTboxData4Show($logourl);
        $datetime = formatTimestamp($time);
        $description = $myts->makeTareaData4Show($description,0); //no html
        $result2 = DB_query("SELECT username,fullname,photo FROM {$_TABLES['users']} WHERE uid = $submitter");
        list($submitter_name, $submitter_fullname, $photo) = DB_fetchArray($result2);
        $submitter_name = COM_getDisplayName ($submitter, $submitter_name, $submitter_fullname);
        include $_CONF['path_html'] . '/filemgmt/include/dlformat.php';
        $p->set_var('cssid', $cssid);
        $p->parse('filelisting_records', 'records', true);
        $cssid = ($cssid == 2) ? 1 : 2;

        // Print Google-like paging navigation
        $base_url = $_CONF['site_url'] . '/filemgmt/viewcat.php?cid=' . $cid . '&amp;orderby=' . $orderby;
        $p->set_var('page_navigation', COM_printPageNavigation($base_url, $page, $numpages));
    }

    $p->parse('output', 'page');
    $display .= $p->finish($p->get_var('output'));
}  else {
    $p->set_var('filelisting_records', '<tr><td><div class="pluginAlert" '
        . 'style="width:500px;padding:10px;margin:10px;border:1px dashed #CCC;">'
        . _MD_NOFILES . '</div></td></tr>');
    $p->parse('output', 'page');
    $display .= $p->finish($p->get_var('output'));
}

if (function_exists('COM_createHTMLDocument')) {
    $display = COM_createHTMLDocument($display);
} else {
    $display = COM_siteHeader() . $display . COM_siteFooter();
}
COM_output($display);

?>