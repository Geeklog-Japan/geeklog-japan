<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
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
//@@@@@20080115,20060405,20060418 what's new mojigire
//@@@@@20080926 include check

//@@@@@20080926add include check ---->
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}
//@@@@@20080926add include check <----

if (!defined('GL_VERSION_15')) {
    define('GL_VERSION_15', (version_compare(VERSION, '1.5') >= 0));
}
if (!defined('GL_VERSION_16')) {
    define('GL_VERSION_16', (version_compare(VERSION, '1.6') >= 0));
}

$langfile = $_CONF['path'] . 'plugins/filemgmt/language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/filemgmt/language/english.php';
}

include $_CONF['path'] . 'plugins/filemgmt/config.php';

/**
* Check and see if we need to load the plugin configuration
*/
if (GL_VERSION_15) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $plg_config = config::get_instance();
    $temp = $plg_config->get_config('filemgmt');
    if (is_array($temp)) {
        $_FM_CONF = array_merge($_FM_CONF, $temp);
    }
    foreach ($_FM_CONF as $key => $val) $$key = $_FM_CONF[$key];
}

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
*/
function plugin_getmenuitems_filemgmt()
{
    global $_CONF, $LANG_FILEMGMT;
    $menuitems = array();
    $menuitems["{$LANG_FILEMGMT['downloads']}"] = $_CONF['site_url'] . '/filemgmt/index.php';
    return $menuitems;
}


/**
* Called by the plugin Editor to display the current plugin code version
* This may be different then the version installed and registered currently.
* If newer then you may want to run the update
*/
function plugin_chkVersion_filemgmt()
{
    global $CONF_FM;

    return $CONF_FM['version'];
}


/**
* Called by the plugin Editor to run the SQL Update for a plugin update
*/
function plugin_upgrade_filemgmt()
{
    global $_TABLES, $_FM_TABLES, $CONF_FM, $_CONF, $_FM_CONF;

    $cur_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name='filemgmt'");
    if (version_compare(VERSION, '1.6') < 0) return 3;

    if (version_compare($cur_version, '1.3') <= 0) {
        DB_query("ALTER TABLE {$_FM_TABLES['filemgmt_cat']} ADD `grp_access` mediumint(8) DEFAULT '2' NOT NULL AFTER imgurl");

        // Update all the comment records
        $result = DB_query("SELECT cid,sid FROM {$_TABLES['comments']} WHERE type='filemgmt'");
        while (list($cid, $sid) = DB_fetchArray($result)) {
            if (strpos($sid, 'fileid_') === FALSE) {
                $sid = "fileid_{$sid}";
                DB_query("UPDATE {$_TABLES['comments']} SET sid='$sid' WHERE cid='$cid'");
            }
        }
    }

    if (version_compare($cur_version, '1.6.0.jp') < 0) {
        require_once $_CONF['path'] . 'plugins/filemgmt/install_defaults.php';
        plugin_initconfig_filemgmt();
    }

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_FM_CONF['version']}' WHERE pi_name = 'filemgmt'");
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_gl_version = '1.6.0' WHERE pi_name = 'filemgmt'");

    return true;
}


/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_filemgmt($old_conf)
{
    global $_CONF;

    $tables = array(
        'filemgmt_category'   => 'cid, imgurl',
        'filemgmt_filedetail' => 'lid, homepage',
        'filemgmt_filedesc'   => 'lid, description'
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    return true;
}


/**
 * Include if plugin will be supporting comments
 *
 * @author Blaine Lang blaine@portalparts.com
 * @return  boolean  true indicates comments are suppported
 */
function plugin_commentsupport_filemgmt()
{
    // Filemgmt Module will use comments
    return true;
}


/**
 * Plugin function that is called after comment form is submitted.
 * Needs to atleast save the comment and check return value.
 * Add any additional logic your plugin may need to perform on comments.
 *
 * @author Blaine Lang blaine@portalparts.com
 * @param   string  $title   Comment title field in comment form
 * @param   string  $comment comment text
 * @param   string  $id     Item id to which $cid belongs
 * @param   int     $pid    comment parent
 * @param   string  $postmode 'html' or 'text'
 * @return  mixed   HTML string (redirect?) for success or comment form if failure.
 */
function plugin_savecomment_filemgmt($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $_FM_TABLES, $LANG03, $_TABLES;

    $retval = '';

    $sid = $id;
    if (strpos($sid, 'fileid_') === FALSE) {
        $sid = 'fileid_' . $id;
    }
    $id = str_replace('fileid_', '', $id);

    $ret = CMT_saveComment($title, $comment, $sid, $pid, 'filemgmt', $postmode);
    if ($ret > 0) { // failure
        $retval = CMT_commentform($title, $comment, $sid, $pid, 'filemgmt',
                                  $LANG03[14], $postmode);
        if (!defined('COMMENT_ON_SAME_PAGE') || !COMMENT_ON_SAME_PAGE) {
            if (function_exists('COM_createHTMLDocument')) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
            } else {
                $retval = COM_siteHeader('menu', $LANG03[1]) . $retval . COM_siteFooter();
            }
        }
    } else { // success
        $comments = DB_count($_TABLES['comments'], 'sid', $sid);
        DB_change($_FM_TABLES['filemgmt_filedetail'], 'comments', $comments, 'lid', $id);
        $retval = COM_refresh(COM_buildUrl($_CONF['site_url'] . "/filemgmt/index.php?id=$id"));
    }

    return $retval;
}


/**
 * Plugin API to delete a comment
 *
 * @author Blaine Lang blaine@portalparts.com
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_deletecomment_filemgmt($cid, $id)
{
    global $_CONF, $_USER;

    $retval = '';

    $sid = $id;
    if (strpos($sid, 'fileid_') === FALSE) {
        $sid = 'fileid_' . $id;
    }
    $id = str_replace('fileid_', '', $id);

    if (SEC_hasRights('filemgmt.edit')) {
        CMT_deleteComment($cid, $sid, 'filemgmt');
        $retval = COM_refresh($_CONF['site_url'] . "/filemgmt/index.php?id=$id");
    } else {
        COM_errorLog("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                   . "tried to illegally delete comment $cid from filemgmt $id");
        $retval .= COM_refresh($_CONF['site_url'] . '/index.php');
    }

    return $retval;
}


/**
 * Plugin API to display a specific comment thread
 *
 * @author Blaine Lang blaine@portalparts.com
 * @param   string  $id     Unique idenifier for item comment belongs to
 * @param   int     $commentid    Comment id to display (possibly including sub-comments)
 * @param   string  $title  comment title
 * @param   string  $order  'ASC' or 'DSC' or blank
 * @param   string  $format 'threaded', 'nested', or 'flat'
 * @param   int     $page   Page number of comments to display
 * @param   boolean $view   True to view comment (by cid), false to display (by $pid)
 * @return  mixed   results of calling the CMT_userComments function
 */
function plugin_displaycomment_filemgmt($id, $commentid, $title, $order, $format, $page, $view)
{
    global $LANG_FILEMGMT, $_TABLES, $_FM_TABLES, $_CONF, $LANG01;

    $sid = $id;
    if (strpos($sid, 'fileid_') === FALSE) {
        $sid = 'fileid_' . $id;
    }
    $id = str_replace('fileid_', '', $id);

    /* Plugin specific code to display relevant content above the comment thread */
    /* Example: Display the file details */
    include $_CONF['path_html'] . 'filemgmt/include/functions.php';
    include_once $_CONF['path_html'] . 'filemgmt/include/xoopstree.php';
    include_once $_CONF['path_html'] . 'filemgmt/include/textsanitizer.php';

    $comments = true;   // Checked in filemgmt code in dlformat.php

    $myts = new MyTextSanitizer; // MyTextSanitizer object
    $mytree = new XoopsTree($_DB_name, $_FM_TABLES['filemgmt_cat'], 'cid', 'pid');

    $display = COM_startBlock('<b>' . $LANG_FILEMGMT['plugin_name'] . '</b>');
    $fields = 'd.lid, d.cid, d.title, d.url, d.homepage, d.version, d.size, d.logourl,';
    $fields .= 'd.submitter, d.status, d.date, d.hits, d.rating, d.votes, t.description';

    $sql = "SELECT $fields FROM {$_FM_TABLES['filemgmt_filedetail']} d, ";
    $sql .= "{$_FM_TABLES['filemgmt_filedesc']} t ";
    $sql .= "WHERE d.lid='$id' AND d.lid=t.lid AND status > 0";
    $result = DB_query($sql);
    list($lid, $cid, $dtitle, $url, $homepage, $version, $size, $logourl, $submitter,
        $status, $time, $hits, $rating, $votes, $description) = DB_fetchArray($result);

    $p = new Template($_CONF['path'] . 'plugins/filemgmt/templates');
    $p->set_file(array(
        'page'     => 'filelisting.thtml',
        'records'  => 'filelisting_record.thtml',
        'category' => 'filelisting_category.thtml'
    ));
    $p->set_var('layout_url', $_CONF['layout_url']);
    $p->set_var('site_url', $_CONF['site_url']);
    $p->set_var('xhtml', XHTML);

    $pathstring = '<a href="index.php">' . _MD_MAIN . '</a>&nbsp;:&nbsp;';
    $nicepath = $mytree->getNicePathFromId($cid, 'title', "{$_CONF['site_url']}/filemgmt/viewcat.php?op=");
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
    $p->parse('output', 'page');
    $display .= $p->finish($p->get_var('output'));

    $display .= COM_endBlock();

    /* Get formatted comment thread */
    $delete_option = SEC_hasRights('filemgmt.edit');

    $display .= CMT_userComments($sid, $title, 'filemgmt', $order, $format, $commentid, $page, $view, $delete_option);

    return $display;
}


function plugin_statssummary_filemgmt()
{
    global $_FM_TABLES, $LANG_FILEMGMT;

    $sql = "SELECT COUNT(*), SUM(hits) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
    $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
    $sql .= filemgmt_buildAccessSql('WHERE');
    list($total_files, $total_downloads) = DB_fetchArray(DB_query($sql));

    return array($LANG_FILEMGMT['nofiles'], COM_numberFormat($total_files)
                 . '(' . COM_numberFormat($total_downloads) . ')');
}


/**
* shows the statistics for the Filemgmot plugin on stats.php.  If $showsitestats
* is 1 then we are to only print the overall stats in the 'site statistics box'
* otherwise we show the detailed stats for the photo album
*
* @showsitestats        int         Flag to let us know which stats to get
*/
function plugin_showstats_filemgmt($showsitestats)
{
    global $LANG_FILEMGMT, $_FM_TABLES, $_CONF;

    if ($showsitestats == 1) {
        $sql = "SELECT COUNT(*), SUM(hits) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
        $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
        $sql .= filemgmt_buildAccessSql('WHERE');
        list($total_files, $total_downloads) = DB_fetchArray(DB_query($sql));
        $retval = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
        $retval .= '<tr><td>' . $LANG_FILEMGMT['nofiles'] . '</td>';
        $retval .= '<td align="right">' . $total_files . ' (' . $total_downloads . ')&nbsp;&nbsp;&nbsp;</td></tr></table>';
    } else {
        require_once $_CONF['path_system'] . 'lib-admin.php';
        $retval = '';
        $sql  = "SELECT a.lid, a.title, hits FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
        $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
        $sql .= filemgmt_buildAccessSql('WHERE');
        $sql .= " AND hits > 0 ORDER BY hits desc LIMIT 10";
        $result = DB_query($sql);
        $nrows  = DB_numRows($result);
        if ($nrows > 0) {
            $header_arr = array(
                array('text'         => $LANG_FILEMGMT['stats_page_title'],
                      'field'        => 'sid',
                      'header_class' => 'stats-header-title'
                ),
                array('text'         => $LANG_FILEMGMT['stats_hits'],
                      'field'        => 'hits',
                      'header_class' => 'stats-header-count',
                      'field_class'  => 'stats-list-count'
                )
            );
            $data_arr = array();
            $text_arr = array('has_menu' => false,
                              'title'    => $LANG_FILEMGMT['StatsMsg1'],
                              'form_url' => $_CONF['site_url'] . '/stats.php'
            );
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray($result);
                $title = stripslashes($A['title']);
                $url = COM_buildUrl($_CONF['site_url']. '/filemgmt/index.php?id=' . $A['lid']);
                $sid = COM_createLink($title, $url);
                $hits = COM_numberFormat($A['hits']);
                $data_arr[] = array('title' => $title,
                                    'sid'   => $sid,
                                    'hits'  => $hits);
            }
            $retval .= ADMIN_simpleList('', $header_arr, $text_arr, $data_arr);
        } else {
            $retval .= COM_startBlock($LANG_FILEMGMT['StatsMsg1']);
            $retval .= $LANG_FILEMGMT['StatsMsg2'];
            $retval .= COM_endBlock();
        }
    }
    return $retval;
}

/**
* Geeklog is asking us to provide any new items that show up in the type drop-down
* on search.php.  Let's let users search the Filelistings in the Filemgmt Plugin
*
*/

function plugin_searchtypes_filemgmt()
{
    global $LANG_FILEMGMT;

    $tmp['filemgmt'] = $LANG_FILEMGMT['searchlabel'];

    return $tmp;
}

/**
* This searches for links matching the user query and returns an array for the
* header and table rows back to search.php where it will be formated and printed
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
function plugin_dopluginsearch_filemgmt($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $_FM_TABLES, $LANG_DLM, $LANG_FILEMGMT;

    // Make sure the query is SQL safe
    $query = trim(addslashes($query));

    // filemgmt search
    $sql  = "SELECT a.lid AS id, a.title AS title, date, a.submitter AS uid, hits, "
          . "c.description AS description, "
          . "CONCAT('/filemgmt/index.php?id=', a.lid) AS url "
          . "FROM {$_FM_TABLES['filemgmt_filedetail']} AS a "
          . "LEFT JOIN {$_FM_TABLES['filemgmt_filedesc']} c ON c.lid=a.lid "
          . "WHERE date <> 1 "
          . "AND date<=UNIX_TIMESTAMP(NOW()) ";

    if (!empty($datestart) && !empty($dateend)) {
        $delim = substr($datestart, 4, 1);
        if (!empty($delim)) {
            $DS = explode($delim, $datestart);
            $DE = explode($delim, $dateend);
            $startdate = mktime(0,  0,  0,  $DS[1], $DS[2], $DS[0]);
            $enddate   = mktime(23, 59, 59, $DE[1], $DE[2], $DE[0]);
            $sql .= "AND (date BETWEEN '$startdate' AND '$enddate') ";
        }
    }

    if (!empty ($author)) {
        $sql .= "AND (a.submitter = '$author') ";
    }

    $search = new SearchCriteria('filemgmt', $LANG_FILEMGMT['downloads']);
    $columns = array('title' => 'a.title', 'description');
    list($sql_tmp, $ftsql_tmp) = $search->buildSearchSQL($keyType, $query, $columns, $sql);
    $search->setSQL($sql_tmp);
    $search->setFTSQL($ftsql_tmp);
    $search->setRank(3);
    $search->setAppendQuery(false);

    return $search;
}


/**
* This will put an option for Filemgmt Admin in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_filemgmt()
{
    global $LANG_FILEMGMT, $_CONF;

    if (SEC_hasRights('filemgmt.edit')) {
        return array($LANG_FILEMGMT['plugin_name'],
                     $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php',
                     $_CONF['site_url'] . '/filemgmt/images/filemgmt.jpg');
    } else {
        return false;
    }

}

/**
* Setup the user menu options for this plugin
*
*/

function plugin_getuseroption_filemgmt()
{
    global $_CONF, $_FM_TABLES, $LANG_FILEMGMT, $mydownloads_uploadselect;

    if (SEC_hasRights('filemgmt.upload') OR $mydownloads_uploadselect == 1) {
        return array($LANG_FILEMGMT['usermenu3'], $_CONF['site_url'] . '/filemgmt/submit.php');
    }
    return false;
}


/**
* returns the administrative option for this plugin
* *
*/

function plugin_getadminoption_filemgmt()
{
    global $_CONF, $_FM_TABLES, $LANG_FILEMGMT;

    if (SEC_hasRights('filemgmt.edit')) {
        $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE status=1");
        list($submittedfiles) = DB_fetchArray($result);
        return array($LANG_FILEMGMT['admin_menu'],
                     $_CONF['site_admin_url'] . '/plugins/filemgmt/index.php',
                     $submittedfiles);
    }
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
function plugin_autouninstall_filemgmt()
{
    $out = array(
        // give the name of the tables, without $_TABLES[]
        'tables' => array('filemgmt_category', 'filemgmt_filedetail', 'filemgmt_filedesc',
                          'filemgmt_broken', 'filemgmt_votedata', 'filemgmt_downloadhistory'),
        // give the full name of the group, as in the db
        'groups' => array('filemgmt Admin'),
        // give the full name of the feature, as in the db
        'features' => array('filemgmt.edit', 'filemgmt.user', 'filemgmt.upload'),
        // give the full name of the block, including 'phpblock_', etc
        'php_blocks' => array('phpblock_NewDownloads'),
        // give all vars with their name
        'vars'=> array('filemgmt_admingrp_id', 'filemgmt_usersgrp_id') // no use now
    );
    return $out;
}

/**
* Removes the datastructures for this plugin from the Geeklog database
* This may get called by the install routine to undue anything created during the install.
* Added check to see that plugin is first disabled.
*/
function plugin_uninstall_filemgmt($installCheck='')
{
    global $_CONF, $LANG_FM00, $LANG_FILEMGMT, $_TABLES, $_FM_TABLES;

    $pi_name='filemgmt';
    $FEATURES = array('filemgmt.edit', 'filemgmt.user', 'filemgmt.upload');
    $TABLES = array('filemgmt_cat', 'filemgmt_filedetail', 'filemgmt_filedesc',
                    'filemgmt_brokenlinks', 'filemgmt_votedata', 'filemgmt_history');

     // Check and see if plugin is still enabled - if so display warning and exit
    if ($installCheck != '' && DB_getItem($_TABLES['plugins'], 'pi_enabled', 'pi_name = "' . $pi_name . '"')) {
        COM_errorLog("Plugin is installed and enabled. Disable first if you want to de-install it", 1);
        $display = '';
        $display .= COM_startBlock($LANG_FM00['warning']);
        $display .= $LANG_FM00['enabled'];
        $display .= COM_endBlock();
        if (function_exists('COM_createHTMLDocument')) {
            $retval = COM_createHTMLDocument($display);
        } else {
            $retval = COM_siteHeader() . $display . COM_siteFooter();
        }
        COM_output($display);
        exit;
    }

    // Ok to proceed and delete plugin - Unregister the plugin with Geeklog
    COM_errorLog('Attempting to unregister the Forum plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'filemgmt'", 1);
    // Drop tables
    foreach ($TABLES as $table) {
        $t = $_FM_TABLES["$table"];
        COM_errorLog("Removing Table $t", 1);
        DB_query("DROP TABLE $t", 1);
    }

    // Remove the Admin group definition for this plugin
    $grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_admingrp_id'");
    COM_errorLog("Removing $pi_name Admin Group", 1);
    DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id", 1);
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_admingrp_id'");
    COM_errorLog("Removing root users from Admin Group of $pi_name");
    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id", 1);

    // Remove User group definition for this plugin
    $grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_usersgrp_id'");
    COM_errorLog("Removing $pi_name User Group", 1);
    DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id", 1);
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_usersgrp_id'");
    COM_errorLog("Removing root users from Users Group of $pi_name");
    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id", 1);

    // Remove all the associated features - access rights. The feature ID's were stored in the vars table during install.
    foreach ($FEATURES as $feature) {
        COM_errorLog("Removing $feature feature and rights to it", 1);
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
        COM_errorLog("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id", 1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id", 1);
    }

    DB_query("DELETE FROM {$_TABLES['comments']} WHERE type='filemgmt'");
    COM_errorLog("Removing all comments for plugin $pi_name");
    DB_query("DELETE FROM {$_TABLES['blocks']} WHERE phpblockfn='phpblock_NewDownloads'");
    COM_errorLog("Removing block definition for plugin $pi_name");

    // Delete config info
    if (GL_VERSION_15) {
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $plg_config = config::get_instance();
        if ($plg_config->group_exists('filemgmt')) {
            $param_names = array();
            $param_names = $plg_config->get_config('filemgmt');
            $param_names['sg_main'] = NULL;
            $param_names['fs_main'] = NULL;
            $param_names['fs_path'] = NULL;
            $param_names['fs_url']  = NULL;
            foreach ($param_names as $key => $val) {
                $plg_config->del($key, 'filemgmt');
            }
        }
    }

    COM_errorLog('...success', 1);
    return true;
}

// Common function used to build group access SQL
function filemgmt_buildAccessSql($clause='AND')
{
    global $_TABLES, $_USER;

    $pi_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name='filemgmt'");
    if (version_compare($pi_version, '1.5') < 0) {
        return '';
    }

    if (isset($_USER) AND $_USER['uid'] > 1) {
        $uid = $_USER['uid'];
    } else {
        $uid = 1;
    }

    $_GROUPS = SEC_getUserGroups($uid);
    $groupsql = '';
    if (count($_GROUPS) == 1) {
        $groupsql .= " $clause grp_access = '" . current($_GROUPS) . "'";
    } else {
        $groupsql .= " $clause grp_access IN (" . implode(',', array_values($_GROUPS)) . ")";
    }
    return $groupsql;
}

function plugin_getfeednames_filemgmt()
{
    global $_FM_TABLES;

    $feeds = array();
    $groupsql = filemgmt_buildAccessSql('WHERE');
    $result = DB_query("SELECT cid,title FROM {$_FM_TABLES['filemgmt_cat']} $groupsql ORDER BY title ASC");
    $num = DB_numRows($result);

    if ($num > 0) {
        $feeds[] = array('id' => '0', 'name' => 'all files');
    }

    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray($result);
        $feeds[] = array('id' => $A['cid'], 'name' => $A['title']);
    }

    return $feeds;
}

function filemgmt_buildSql($topic, $limits)
{
    $where = '';
    if ($topic > 0) {
        $where = 'cid=' . $topic;
    }

    $limitsql = '';
    if (!empty($limits)) {
        if (substr($limits, -1) == 'h') { // last xx hours
            $limitsql = '';
            $hours = substr($limits, 0, -1);
            if (!empty($where)) {
                $where .= ' AND ';
            }
            $where .= "date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        } else {
            $limitsql = ' LIMIT ' . $limits;
        }
    } else {
        $limitsql = ' LIMIT 10';
    }

    if (!empty($where)) {
        $where = ' WHERE ' . $where;
    }

    $sql = $where . $limitsql;

    return $sql;
}

function plugin_getfeedcontent_filemgmt($feed, &$link, &$update)
{
    global $_CONF, $_TABLES, $_FM_TABLES;

    $content = array();
    $lids = array();

    $result = DB_query("SELECT topic,limits FROM {$_TABLES['syndication']} WHERE fid = $feed");
    $F = DB_fetchArray($result);

    $sql = "SELECT lid,title,submitter,date FROM {$_FM_TABLES['filemgmt_filedetail']} ORDER BY date DESC "
         . filemgmt_buildSql($F['topic'], $F['limits']);
    $result = DB_query($sql);
    $num = DB_numRows($result);
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray($result);
        $desc = DB_getItem($_FM_TABLES['filemgmt_filedesc'], 'description',
                           "lid = {$A['lid']}");
        $filelink = $_CONF['site_url'] . '/filemgmt/index.php?id='
                  . $A['lid'];
        $content[] = array('title'  => $A['title'],
                           'text'   => $desc,
                           'link'   => $filelink,
                           'uid'    => $A['submitter'],
                           'date'   => $A['date'],
                           'format' => 'text'
                          );
        $lids[] = $A['lid'];
    }

    if ($F['topic'] == 0) {
        $link = $_CONF['site_url'] . '/filemgmt/index.php';
    } else {
        $link = $_CONF['site_url'] . '/filemgmt/viewcat.php?cid=' . $F['topic'];
    }
    $update = implode(',', $lids);

    return $content;
}

function plugin_feedupdatecheck_filemgmt($feed, $topic, $update_data, $limit)
{
    global $_FM_TABLES;

    $is_current = true;

    $sql = "SELECT lid FROM {$_FM_TABLES['filemgmt_filedetail']}" . filemgmt_buildSql($topic, $limits);
    $result = DB_query($sql);
    $num = DB_numRows($result);

    $lids = array();
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray($result);
        $lids[] = $A['lid'];
    }
    $current = implode(',', $lids);
    return ($current != $update_data) ? false : true;
}

/**
  * Whats New Block API Support
  * Return the Headline and Byline for the new section in the Whatsnew Block
*/
function plugin_whatsnewsupported_filemgmt()
{
    global $_CONF, $LANG_FM00, $mydownloads_whatsnew, $filemgmtWhatsNewPeriodDays;

    if ($mydownloads_whatsnew == 1) {
        return array(
            $LANG_FM00['WhatsNewLabel'],
            sprintf($LANG_FM00['WhatsNewPeriod'], $filemgmtWhatsNewPeriodDays)
            );
    } else {
        return false;
    }
}


/**
  * API function provides the content of our "What's New" feed
*/
function plugin_getwhatsnew_filemgmt()
{
    global $_TABLES, $_FM_TABLES, $_CONF, $LANG_FILEMGMT, $LANG01;
    global $filemgmtWhatsNewTitleLength, $filemgmtWhatsNewPeriodDays, $filemgmt_showWhatsNewComments;

    $items = array();
    if (SEC_hasRights('filemgmt.user') OR $mydownloads_publicpriv == 1) {
        $sql  = "SELECT a.lid, a.title FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
        $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
        $sql .= "WHERE date >= UNIX_TIMESTAMP( DATE_SUB(NOW(), INTERVAL $filemgmtWhatsNewPeriodDays DAY )) ";
        $sql .= filemgmt_buildAccessSql();
        $sql .= "AND STATUS=1 ORDER BY date DESC LIMIT 15";
        $result = DB_query($sql);
        $nrows1 = DB_numRows($result);
        if ($nrows1 == 0) {
            $retval .= $LANG_FILEMGMT['no_new_files'] . '<br' . XHTML . '>' . LB;
        } else {
            for ($i = 0; $i < $nrows1; $i++) {
                list($lid, $title) = DB_fetchArray($result);
                $str = "<a href=\"{$_CONF['site_url']}/filemgmt/index.php?id=$lid\">";
                //@@@@@ 20080115 mystral_kk ----->
                //$str .= stripslashes(substr($title, 0, $filemgmtWhatsNewTitleLength));
                $str .= COM_truncate(stripslashes($title), $filemgmtWhatsNewTitleLength, '...');
                //@@@@@ 20080115 mystral_kk <-----

                $str .= '</a>';
                $items[] = $str;
            }
        }
        if ($filemgmt_showWhatsNewComments) {
            // Search for new comments
            $sql  = "SELECT a.lid,c.title FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
            $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
            $sql .= "LEFT JOIN {$_TABLES['comments']} c ON c.sid = concat('fileid_' ,a.lid )";
            $sql .= filemgmt_buildAccessSql('WHERE');
            $sql .= " AND c.date >=  DATE_SUB(NOW(), INTERVAL $filemgmtWhatsNewPeriodDays DAY ) AND c.type='filemgmt' ";
            $sql .= "GROUP BY c.sid ORDER  BY c.date DESC LIMIT 15 ";

            $result = DB_query($sql);
            $nrows2 = DB_numRows($result);
            if ($nrows2 == 0) {
                $retval .= $LANG_FILEMGMT['no_comments'] . '<br' . XHTML . '>' . LB;
            } else {
                for ($i = 0; $i < $nrows2; $i++) {
                    list($lid, $title) = DB_fetchArray($result);
                    $titleLength = $filemgmtWhatsNewTitleLength + 13;        // Compensate for the added HTML
                    $title = "<b>C:</b>&nbsp;" . $title;
                    $str = "<a href=\"{$_CONF['site_url']}/filemgmt/index.php?id=$lid\">";
                    //@@@@@ 2008/01/15 mystral_kk update----->
                    //$str .= stripslashes(substr($title, 0, $titleLength));
                    $str .= COM_truncate(stripslashes($title), $titleLength, '...');
                    //@@@@@ 2008/01/15 mystral_kk update<-----

                    $str .= '</a>';
                    $items[] = $str;
                }
            }
        }

        if ($nrows1 == 0 and $nrows2 == 0) {
            return $retval;
        } else {
            return $items;
        }
    } else {
        return $items;
    }
}



/**
* Implements the [file:] autotag.
*
*/
function plugin_autotags_filemgmt($op, $content = '', $autotag = '')
{
    global $_CONF, $_FM_TABLES;

    if ($op == 'tagname') {
        return 'file';
    } else if ($op == 'parse') {
        $file_id = COM_applyFilter($autotag['parm1']);
        $url = COM_buildUrl ($_CONF['site_url'] . '/filemgmt/index.php?id='
                             . $file_id);
        if (empty($autotag['parm2'])) {
            $linktext = stripslashes(DB_getItem($_FM_TABLES['filemgmt_filedetail'],
                                     'title', "lid = '$file_id'"));
        } else {
            $linktext = $autotag['parm2'];
        }
        $link = '<a href="' . $url . '">' . $linktext . '</a>';
        $content = str_replace($autotag['tagstr'], $link, $content);

        return $content;
    }
}

/**
* Return information for a filemgmt
*
* @param    string  $lid        file ID or '*'
* @param    string  $what       comma-separated list of properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
*/

function plugin_getiteminfo_filemgmt($lid, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES, $_FM_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
        case 'date-modified':
            $fields[] = 'date AS unixdate';
            break;
//      case 'description':
//      case 'excerpt':
//          $fields[] = 'description';
//          break;
        case 'id':
            $fields[] = 'lid';
            break;
        case 'title':
            $fields[] = 'title';
            break;
        case 'url':
            // needed for $lid == '*', but also in case we're only requesting
            // the URL (so that $fields isn't emtpy)
            $fields[] = 'lid';
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
    if ($lid == '*') {
        $where = '';
        $permOp = 'WHERE';
    } else {
        $where = " WHERE lid = '" . addslashes($lid) . "'";
        $permOp = 'AND';
    }
    if ($uid > 0) {
        $permSql = '';
    } else {
        $permSql = '';
    }
    $sql = "SELECT " . implode(',', $fields)
            . " FROM {$_FM_TABLES['filemgmt_filedetail']}" . $where . $permSql;
    if ($lid != '*') {
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
                $props['date-modified'] = $A['unixdate'];
                break;
//          case 'description':
//          case 'excerpt':
//              $props[$p] = stripslashes($A['description']);
//              break;
            case 'id':
                $props['id'] = $A['lid'];
                break;
            case 'title':
                $props['title'] = stripslashes($A['title']);
                break;
            case 'url':
                if (empty($A['lid'])) {
                    $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/filemgmt/index.php?id=' . $lid);
                } else {
                    $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/filemgmt/index.php?id=' . $A['lid']);
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
            if ($lid == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($lid == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($lid != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}


/* GLMENU USE ONLY API FUNCTIONS */

/* Function can be used in a Menuitem of type "PHP Function"
*  It will generate the menuitems and submenus for your filemgmt plugin
*  Works with the function plugin_glMenuCreateMenus_filemgmt()
*/
function glmenu_filemgmt()
{
    global $_CONF, $_FM_TABLES, $CONF_FILEMGMT;

    $menu_location = $CONF_FILEMGMT['glmenutype'];

    $retval = '';
    $sql = "SELECT cid,pid,title FROM {$_FM_TABLES['filemgmt_cat']} WHERE pid = 0 ";
    $sql .= filemgmt_buildAccessSql('AND') . ' ORDER BY cid';
    $q1 = DB_query($sql);
    while (list($cid, $pid, $title) = DB_fetchArray($q1)) {
        $retval .= 'aI("image=' . $_CONF['layout_url']
                 . '/glmenu/images/folder.gif;text=' . $title
                 . ';showmenu=filemgmt-' . $cid
                 . ';url=' . $_CONF['site_url'] . '/filemgmt/viewcat.php?cid='
                 . $cid . ';");';
    }
    return $retval;
}



/* GL-Menu API function to generate requires Milonic Javascript functions */
function plugin_glMenuCreateMenus_filemgmt()
{
    global $_CONF, $_FM_TABLES, $CONF_GLMENU, $CONF_FILEMGMT, $_FMDOWNLOAD;

    /* Generate the JS Menu Functions that are needed for the Content Editor submenus */
    $menu_location = $CONF_FILEMGMT['glmenutype'];
    $retval .= '';
    $groupsql = filemgmt_buildAccessSql('WHERE');
    $sql = "SELECT cid,pid,title FROM {$_FM_TABLES['filemgmt_cat']} $groupsql ORDER BY cid";
    $q1 = DB_query($sql);
    while (list($cid, $pid, $title) = DB_fetchArray($q1)) {
       $menudata = '';
       $retval .= ' with(milonic=new menuname("filemgmt-' . $cid . '")) {';
                if ($menu_location == 'block') {
                    $retval .= 'style=' . $CONF_GLMENU['blockmenustyle'] . ';';
                } else {
                    $retval .= 'style=' . $CONF_GLMENU['headersubmenustyle'] . ';';
                }
                /* Find and sub categories - that will be submenus */
                $q2 = DB_query("SELECT cid,pid,title FROM {$_FM_TABLES['filemgmt_cat']} $groupsql AND pid='{$cid}' ");
                while (list($subcid, $subpid, $subtitle) = DB_fetchArray($q2)) {
                   $menudata .= 'aI("image=' . $_CONF['layout_url']
                              . '/glmenu/images/folder.gif;text=' . $subtitle
                              . ';showmenu=filemgmt-' . $subcid
                              . ';url=' . $_CONF['site_url'] . '/filemgmt/viewcat.php?cid='
                              . $subcid . ';");';
                }
                /* Show any links for files that are in this category */
                $q3 = DB_query("SELECT lid,title,url FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE cid='{$cid}'");
                while (list($fileid, $filename, $url) = DB_fetchArray($q3)) {
                    $pos = strrpos($url, '.') + 1;
                    $ext = strtolower(substr($url, $pos));
                    if (array_key_exists($ext, $_FMDOWNLOAD['inconlib'])) {
                        $icon = "{$_CONF['layout_url']}/glmenu/images/{$_FMDOWNLOAD['inconlib'][$ext]}";
                    } else {
                        $icon = "{$_CONF['layout_url']}/glmenu/images/{$_FMDOWNLOAD['inconlib']['none']}";
                    }
                   $menudata .= 'aI("image=' . $icon . ';text=' . $filename
                              . ';url=' . $_CONF['site_url'] . '/filemgmt/singlefile.php?lid='
                              . $fileid . ';");';
                }
                if ($menudata != '') {
                    $retval .=  $menudata;
                }

      $retval .= '}';
    }
    return $retval;

}

if (!function_exists('COM_output')) {
    function COM_output(&$display) {
        echo $display;
    }
}

?>