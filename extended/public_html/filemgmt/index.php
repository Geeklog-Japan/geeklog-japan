<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// | File: index.php                                                         |
// | Main public script to view filemgmt categories and files                |
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
//@@@@@20090602update urlrewrite

require_once '../lib-common.php';
require_once $_CONF['path_html'] . 'filemgmt/include/header.php';
require_once $_CONF['path_html'] . 'filemgmt/include/functions.php';
require_once $_CONF['path_html'] . 'filemgmt/include/xoopstree.php';
require_once $_CONF['path_html'] . 'filemgmt/include/textsanitizer.php';

// Setup how many categories you want to show in the category row display
$numCategoriesPerRow = 2;
$numSubCategories2Show = 5;

if (SEC_hasRights('filemgmt.user') OR $mydownloads_publicpriv == 1) {

    $p = new Template($_CONF['path'] . 'plugins/filemgmt/templates');
    $p->set_file(array(
        'page'     => 'filelisting.thtml',
        'records'  => 'filelisting_record.thtml',
        'category' => 'filelisting_category.thtml'
    ));
    $p->set_var('layout_url', $_CONF['layout_url']);
    $p->set_var('site_url', $_CONF['site_url']);
    $p->set_var('site_admin_url', $_CONF['site_admin_url']);
    $p->set_var('xhtml', XHTML);
    $p->set_var('target', ($CONF_FM['ignore_target']) ? '' : 'target="_blank"');

    $myts = new MyTextSanitizer;
    $mytree = new XoopsTree($_DB_name, $_FM_TABLES['filemgmt_cat'], "cid", "pid");
    $mytree->setGroupAccessFilter($_GROUPS);

    $display = '';
    //@@@@@20090602update urlrewrite ---->
    //$lid = COM_applyFilter($_GET['id'],true);
    COM_setArgNames(array('id'));
    $lid = COM_applyFilter(COM_getArgument('id'), true);
    //@@@@@20090602update urlrewrite<-----

    if ($lid == 0) {  // Check if the script is being called from the commentbar
        $lid = str_replace('fileid_', '', $_POST['id']);
    }

    $groupsql = filemgmt_buildAccessSql();

    $sql = "SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
    $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
    $sql .= "WHERE a.lid='$lid' $groupsql AND a.status > 0";
    list($fileAccessCnt) = DB_fetchArray(DB_query($sql));

    if ($fileAccessCnt > 0 AND DB_count($_FM_TABLES['filemgmt_filedetail'], "lid", $lid) == 1) {

        $p->set_var('block_header', COM_startBlock("<b>" . $LANG_FILEMGMT['plugin_name'] . "</b>"));
        $p->set_var('block_footer', COM_endBlock());

        require_once $_CONF['path_system'] . 'lib-comment.php';

        $sql = "SELECT d.lid, d.cid, d.title, d.url, d.homepage, d.version, d.size, d.logourl, d.submitter, d.status, d.date, ";
        $sql .= "d.hits, d.rating, d.votes, d.comments, t.description FROM {$_FM_TABLES['filemgmt_filedetail']} d, ";
        $sql .= "{$_FM_TABLES['filemgmt_filedesc']} t WHERE d.lid='$lid' AND d.lid=t.lid AND status > 0";

        $result = DB_query($sql);
        list($lid, $cid, $dtitle, $url, $homepage, $version, $size, $logourl, $submitter,
             $status, $time, $hits, $rating, $votes, $comments, $description) = DB_fetchArray($result);

        $pathstring = '<a href="' . $_CONF['site_url'] . '/filemgmt/index.php">' . _MD_MAIN . '</a>&nbsp;:&nbsp;';
        $nicepath = $mytree->getNicePathFromId($cid, "title", "{$_CONF['site_url']}/filemgmt/viewcat.php");
        $pathstring .= $nicepath;
        $p->set_var('category_path_link', $pathstring);

        $rating = number_format($rating, 2);
        $dtitle = $myts->makeTboxData4Show($dtitle);
        $url = $myts->makeTboxData4Show($url);
        $homepage = $myts->makeTboxData4Show($homepage);
        $version = $myts->makeTboxData4Show($version);
        $size = $myts->makeTboxData4Show($size);
        $platform = $myts->makeTboxData4Show($platform);
        $logourl = $myts->makeTboxData4Show($logourl);
        $datetime = formatTimestamp($time);
        $description = $myts->makeTareaData4Show($description, 0); //no html
        $result2 = DB_query("SELECT username,fullname,photo FROM {$_TABLES['users']} WHERE uid = $submitter");
        list($submitter_name, $submitter_fullname, $photo) = DB_fetchArray($result2);
        $submitter_name = COM_getDisplayName($submitter, $submitter_name, $submitter_fullname);
        include $_CONF['path_html'] . '/filemgmt/include/dlformat.php';
        $p->set_var('cssid', 1);
        $p->parse('filelisting_records', 'records');
        $delete_option = SEC_hasRights('filemgmt.edit');
        $order = '';
        if (isset($_POST['order'])) {
            $order = COM_applyFilter($_POST['order']);
        }
        $mode = '';
        if (isset($_POST['mode'])) {
            $mode = COM_applyFilter($_POST['mode']);
        }
        $p->set_var('comment_records', CMT_userComments("fileid_{$lid}", $dtitle,
                    'filemgmt', $order, $mode, 0, 1, false, $delete_option));
        $p->set_var('subcategories', '');
        $p->set_var('new_table_row', '<tr>');
        $p->set_var('end_of_row', '</tr>');
        $p->parse('category_records', 'category');

        $p->parse('output', 'page');
        $display .= $p->finish($p->get_var('output'));

    } else {

        $p = new Template($_CONF['path'] . 'plugins/filemgmt/templates');
        $p->set_file(array(
            'page'     => 'filelisting.thtml',
            'records'  => 'filelisting_record.thtml',
            'category' => 'filelisting_category.thtml'
        ));
        $p->set_var('layout_url', $_CONF['layout_url']);
        $p->set_var('site_url', $_CONF['site_url']);
        $p->set_var('site_admin_url', $_CONF['site_admin_url']);
        $p->set_var('xhtml', XHTML);
        $p->set_var('target', ($CONF_FM['ignore_target']) ? '' : 'target="_blank"');
        $p->set_var('imgset', $_CONF['layout_url'] . '/nexflow/images');
        $p->set_var('tablewidth', $mydownloads_shotwidth + 10);

        $page = COM_applyFilter($_GET['page'], true);
        if (!isset($page) OR $page == 0) {
            $page = 1;
        }
        $show = $mydownloads_perpage;

        $groupsql = filemgmt_buildAccessSql();
        $sql = "SELECT cid, title, imgurl, grp_access "
             . "FROM {$_FM_TABLES['filemgmt_cat']} WHERE pid = 0 "
             . $groupsql . " ORDER BY cid";
        $result = DB_query($sql);
        $nrows = DB_numRows($result);

        // Need to use a SQL stmt that does a join on groups user has access to  - for file count
        $sql  = "SELECT count(*) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
        $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid WHERE status > 0 ";
        $sql .= $groupsql;
        $countsql = DB_query($sql);
        list($maxrows) = DB_fetchArray($countsql);
        $numpages = ceil($maxrows / $show);

        $p->set_var('block_header', COM_startBlock(sprintf(_MD_LISTINGHEADING, $maxrows)));
        $p->set_var('block_footer', COM_endBlock());
        $count = 0;

        if ($nrows > 0) {        // Display the categories - Top Level (plus #files) with links to sub categories
            for ($i = 1; $i <= $nrows; $i++) {
                $myrow = DB_fetchArray($result);
                $secGroup = DB_getItem($_TABLES['groups'], "grp_name", "grp_id='{$myrow['grp_access']}'");
                if (SEC_inGroup($secGroup)) {
                    $p->set_var('cid', $myrow['cid']);
                    $p->set_var('category_name', $myts->makeTboxData4Show($myrow['title']));

                    if ($mydownloads_useshots && $myrow['imgurl'] && $myrow['imgurl'] != "http://") {
                        $imgurl = $myts->makeTboxData4Edit($myrow['imgurl']);
                        $category_image_link = '<a href="' . $_CONF[site_url]
                            . '/filemgmt/viewcat.php?cid=' . $myrow['cid'] . '">'
                            . '<img src="' . $filemgmt_SnapCatURL . $imgurl
                            . '" width="' . $mydownloads_shotwidth
                            . '" style="border:none;" alt=""' . XHTML . '></a>';
                        $p->set_var('category_link', $category_image_link);
                    } else {
                        $p->set_var('category_link', '');
                    }

                    $downloadsWaitingSubmission = getTotalItems($myrow['cid'], 0);
                    $p->set_var('num_files',getTotalItems($myrow['cid'], 1));
                    if ($downloadsWaitingSubmission > 0) {
                        $p->set_var('files_waiting_submission', '(' . getTotalItems($myrow['cid'], 0) . ')');
                    } else {
                        $p->set_var('files_waiting_submission', '');
                    }

                    // get child category objects
                    $subcategories = '';
                    $arr = array();
                    $arr = $mytree->getFirstChild($myrow['cid'], 'title');
                    $space = 0;
                    $chcount = 0;
                    foreach ($arr as $ele) {
                        $chtitle = $myts->makeTboxData4Show($ele['title']);
                        if ($chcount >= $numSubCategories2Show) {
                            $subcategories .= "...";
                            break;
                        }
                        if ($space>0) {
                            $subcategories .= ", ";
                        }
                        $subcategories .= "<a href=\"{$_CONF[site_url]}/filemgmt/viewcat.php?cid={$ele['cid']}\">{$chtitle}</a>";
                        $space++;
                        $chcount++;
                    }
                    $p->set_var('subcategories', $subcategories);
                    $count++;
                    $p->set_var('new_table_row', ($count == 1) ? '<tr>' : '');
                    $p->set_var('end_of_row', ($count == $numCategoriesPerRow) ? '</tr>' : (($count == $nrows) ? '</tr>' : ''));

                    if ($count == $numCategoriesPerRow) $count = 0;
                    $p->parse('category_records', 'category', true);
                }
            }
        }

        $offset = ($page - 1) * $show;

        $sql = "SELECT d.lid, d.cid, d.title, url, homepage, version, size, platform, submitter, logourl, status, ";
        $sql .= "date, hits, rating, votes, comments, description, grp_access FROM ({$_FM_TABLES['filemgmt_filedetail']} d, ";
        $sql .= "{$_FM_TABLES['filemgmt_filedesc']} t) LEFT JOIN {$_FM_TABLES['filemgmt_cat']} c ON d.cid=c.cid ";
        $sql .= "WHERE status > 0 AND d.lid=t.lid ORDER BY date DESC LIMIT $offset, $show";
        $result = DB_query($sql);
        $numrows = DB_numRows($result);
        $countsql = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE status > 0");

        $p->set_var('listing_heading', _MD_LATESTLISTING);
        if ($numrows > 0) {
            $cssid = 1;
            for ($x = 1; $x <= $numrows; $x++) {
                list($lid, $cid, $dtitle, $url, $homepage, $version, $size, $platform, $submitter, $logourl,
                     $status, $time, $hits, $rating, $votes, $comments, $description, $grp_access) = DB_fetchArray($result);
                $secGroup = DB_getItem($_TABLES['groups'], "grp_name", "grp_id='$grp_access'");
                if (SEC_inGroup($secGroup)) {
                    $rating = number_format($rating, 2);
                    $dtitle = $myts->makeTboxData4Show($dtitle);
                    $url = $myts->makeTboxData4Show($url);
                    $homepage = $myts->makeTboxData4Show($homepage);
                    $version = $myts->makeTboxData4Show($version);
                    $size = $myts->makeTboxData4Show($size);
                    $platform = $myts->makeTboxData4Show($platform);
                    $logourl = $myts->makeTboxData4Show($logourl);
                    $datetime = formatTimestamp($time);
                    $description = $myts->makeTareaData4Show($description, 0); //no html
                    $breakPosition = strpos($description, "<br /><br />");
                    if (($breakPosition > 0) AND ($breakPosition < strlen($description)) AND $mydownloads_trimdesc) {
                        $description = substr($description, 0, $breakPosition)
                            . "<p style=\"text-align:left\"><a href=\"{$_CONF[site_url]}/filemgmt/index.php?"
                            . "id=$lid&amp;comments=1\">{$LANG_FILEMGMT['more']}</a></p>";
                    }
                    $result2 = DB_query("SELECT username,fullname,photo FROM {$_TABLES['users']} WHERE uid = $submitter");
                    list($submitter_name, $submitter_fullname, $photo) = DB_fetchArray($result2);
                    $submitter_name = COM_getDisplayName($submitter, $submitter_name, $submitter_fullname);
                    include $_CONF['path_html'] . '/filemgmt/include/dlformat.php';
                    $p->set_var('cssid', $cssid);
                    $p->parse('filelisting_records', 'records', true);
                    $cssid = ($cssid == 2) ? 1 : 2;
                }
            }

            // Print Google-like paging navigation
            $base_url = $_CONF['site_url'] . '/filemgmt/index.php';
            $p->set_var('page_navigation', COM_printPageNavigation($base_url, $page, $numpages));
        }

        $p->parse('output', 'page');
        $display .= $p->finish($p->get_var('output'));
    }

    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);

} else {
    COM_errorLog("Index.php => Filemgmt Plugin Access denied. Attempted direct (not via menu) "
        . "to FileMgmt Plugin, Remote address is: {$_SERVER['REMOTE_ADDR']}");
    redirect_header($_CONF['site_url'] . "/index.php", 1, _GL_ERRORNOACCESS);
    exit;
}

?>