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
//@@@@@20080129update datetime format multilang 20080118 hiroron 

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die ('This file can not be used on its own.');
}

function newdownloadgraphic($time, $status) {
    global $_CONF;

    $functionretval = '';
    $count = 7;
    $startdate = time() - (86400 * $count);
    if ($startdate < $time) {
        if ($status == 1) {
            $functionretval = '&nbsp;<img src="' . $_CONF['site_url'] . '/filemgmt/images/newred.gif" alt="' . _MD_NEWTHISWEEK . '"' . XHTML . '>';
        } elseif ($status == 2) {
            $functionretval = '&nbsp;<img src="' . $_CONF['site_url'] . '/filemgmt/images/update.gif" alt="' . _MD_UPTHISWEEK . '"' . XHTML . '>';
        }
    }
    return $functionretval;
}

function popgraphic($hits) {
    global $_CONF, $mydownloads_popular;

    $functionretval = '';
    if ($hits >= $mydownloads_popular) {
        $functionretval = '&nbsp;<img src="' . $_CONF['site_url'] . '/filemgmt/images/pop.gif" alt="' . _MD_POPULAR . '"' . XHTML . '>';
    }
    return $functionretval;
}

//updates rating data in itemtable for a given item
function updaterating($sel_id) {
    global $_FM_TABLES;
    $sel_id = intval($sel_id);
    $voteresult = DB_query("SELECT rating FROM {$_FM_TABLES['filemgmt_votedata']} WHERE lid = '$sel_id'");
    $votesDB = DB_numRows($voteresult);
    $totalrating = 0;
    if ($votesDB > 0) {
           while (list($rating) = DB_fetchArray($voteresult)) {
            $totalrating += $rating;
        }
        $finalrating = $totalrating/$votesDB;
    }
    $finalrating = number_format($finalrating, 4);
    DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} SET rating='$finalrating', votes='$votesDB' WHERE lid = '$sel_id'");
}

//returns the total number of items in items table that are accociated with a given table $table id
function getTotalItems($sel_id, $status='') {
    global $_FM_TABLES, $mytree;
    $count = 0;
    $arr = array();
    $sel_id = intval($sel_id);
    if (!empty($status)) {
        $status = intval($status);
    }
    $sql = "SELECT count(*) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
    $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
    $sql .= "WHERE a.cid='$sel_id' AND a.status='$status' $mytree->filtersql";
    list($thing) = DB_fetchArray(DB_query($sql));
    $count = $thing;
    $arr = $mytree->getAllChildId($sel_id);
    $size = sizeof($arr);
    for ($i=0; $i < $size; $i++) {
        $sql = "SELECT count(*) FROM {$_FM_TABLES['filemgmt_filedetail']} a ";
        $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
        $sql .= "WHERE a.cid='{$arr[$i]}}' AND a.status='$status' $mytree->filtersql";
        list($thing) = DB_fetchArray(DB_query($sql));
        $count += $thing;
    }
    return $count;
}

/*
* Function to display formatted times in user timezone
*/
function formatTimestamp($usertimestamp) {
    global $_CONF;
//@@@@ 2008/01/29 multilang 20080118 hiroron  -->
//  $datetime = date("M.d.y", $usertimestamp);
    $datetime = strftime($_CONF['shortdate'], $usertimestamp);
//@@@@ 2008/01/29 multilang 20080118 hiroron  <--

    return $datetime;
}


function PrettySize($size) {
    $mb = 1024*1024;
    if ($size > $mb) {
        $mysize = sprintf("%01.2f", $size/$mb) . " MB";
    } elseif ($size >= 1024) {
        $mysize = sprintf("%01.2f", $size/1024) . " KB";
    } else {
        $mysize = sprintf(_MD_NUMBYTES, $size);
    }
    return $mysize;
}


function redirect_header($url, $time=3, $message='') {
    $headercode = '<meta http-equiv="Refresh" content="' . $time . ';url=' . $url . '"' . XHTML . '>' . LB;
    $display = COM_startBlock();
    if ($message != '') {
        $display .= '<h4>' . $message . '</h4>';
    }
    $display .= sprintf(_IFNOTRELOAD, $url);
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $information = array('headercode' => $headercode);
        $display = COM_createHTMLDocument($display, $information);
    } else {
        $display = COM_siteHeader('menu', '', $headercode) . $display . COM_siteFooter();
    }
    echo $display;
}

//Reusable Link Sorting Functions
function convertorderbyin($orderby) {
    switch ($orderby) {
        case 'titleA':
            $orderby = 'title ASC';
            break;
        case 'dateA':
            $orderby = 'date ASC';
            break;
        case 'hitsA':
            $orderby = 'hits ASC';
            break;
        case 'ratingA':
            $orderby = 'rating ASC';
            break;
        case 'titleD':
            $orderby = 'title DESC';
            break;
        case 'dateD':
            $orderby = 'date DESC';
            break;
        case 'hitsD':
            $orderby = 'hits DESC';
            break;
        case 'ratingD':
            $orderby = 'rating DESC';
            break;
        default:
            $orderby = 'date DESC';
            break;
    }

    return $orderby;
}

function convertorderbytrans($orderby) {
    switch ($orderby) {
        case 'hits ASC':
            $orderbyTrans = _MD_POPULARITYLTOM;
            break;
        case 'hits DESC':
            $orderbyTrans = _MD_POPULARITYMTOL;
            break;
        case 'title ASC':
            $orderbyTrans = _MD_TITLEATOZ;
            break;
        case 'title DESC':
            $orderbyTrans = _MD_TITLEZTOA;
            break;
        case 'date ASC':
            $orderbyTrans = _MD_DATEOLD;
            break;
        case 'date DESC':
            $orderbyTrans = _MD_DATENEW;
            break;
        case 'rating ASC':
            $orderbyTrans = _MD_RATINGLTOH;
            break;
        case 'rating DESC':
            $orderbyTrans = _MD_RATINGHTOL;
            break;
        default:
            $orderbyTrans = _MD_DATENEW;
            break;
    }

    return $orderbyTrans;
}

function convertorderbyout($orderby) {
    switch ($orderby) {
        case 'title ASC':
            $orderby = 'titleA';
            break;
        case 'date ASC':
            $orderby = 'dateA';
            break;
        case 'hits ASC':
            $orderby = 'hitsA';
            break;
        case 'rating ASC':
            $orderby = 'ratingA';
            break;
        case 'title DESC':
            $orderby = 'titleD';
            break;
        case 'date DESC':
            $orderby = 'dateD';
            break;
        case 'hits DESC':
            $orderby = 'hitsD';
            break;
        case 'rating DESC':
            $orderby = 'ratingD';
            break;
        default:
            $orderby = 'dateD';
            break;
    }

    return $orderby;
}

function randomfilename() {

    $length = 10;
    srand((double)microtime() * 1000000);
    $possible_charactors = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";
    while (strlen($string) < $length) {
        $string .= substr($possible_charactors, rand() % (strlen($possible_charactors)), 1);
    }
    return($string);
}


?>