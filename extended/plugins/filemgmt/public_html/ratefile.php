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
require_once $_CONF['path_html'] . 'filemgmt/include/errorhandler.php';
require_once $_CONF['path_html'] . 'filemgmt/include/textsanitizer.php';

//$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
$myts = new MyTextSanitizer;

if ($_POST['submit']) {
    $eh = new ErrorHandler; //ErrorHandler object
    if (!FilemgmtUser) {
        $ratinguser = 0;
    } else {
        $ratinguser = $uid;
    }
    //Make sure only 1 anonymous from an IP in a single day.
    $anonwaitdays = 1;
    $ip = $_SERVER['REMOTE_ADDR'];
    $lid = 0;
    if (isset($_POST['lid'])) {
        $lid = COM_applyFilter($_POST['lid'], true);
    }
    $rating = 0;
    if (isset($_POST['rating'])) {
        $rating = COM_applyFilter($_POST['rating'], true);
    }
    // Check if Rating is Null
    if ($rating == "--") {
        redirect_header("ratefile.php?lid=" . $lid . "", 4, _MD_NORATING);
        exit;
    }

       // Check if Download POSTER is voting (UNLESS Anonymous users allowed to post)
    if ($ratinguser != 0) {
        $result=DB_query("SELECT submitter FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
        while (list($ratinguserDB) = DB_fetchArray($result)) {
            if ($ratinguserDB == $ratinguser) {
                redirect_header("index.php", 4, _MD_CANTVOTEOWN);
                exit;
            }
        }

        // Check if REG user is trying to vote twice.
        $result = DB_query("SELECT ratinguser FROM {$_FM_TABLES['filemgmt_votedata']} WHERE lid='$lid'");
        while (list($ratinguserDB) = DB_fetchArray($result)) {
            if ($ratinguserDB == $ratinguser) {
                redirect_header("index.php", 4, _MD_VOTEONCE);
                exit;
            }
        }
    }
    // Check if ANONYMOUS user is trying to vote more than once per day.
    if ($ratinguser==0) {
        $yesterday = (time() - (86400 * $anonwaitdays));
        $result = DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_votedata']} "
            . "WHERE lid='$lid' AND ratinguser=0 AND ratinghostname = '$ip' "
            . "AND ratingtimestamp > $yesterday");
        list($anonvotecount) = DB_fetchArray($result);
        if ($anonvotecount >= 1) {
            redirect_header("index.php", 4, _MD_VOTEONCE);
            exit;
        }
    }

    //All is well.  Add to Line Item Rate to DB.
    $datetime = time();
    DB_query("INSERT INTO {$_FM_TABLES['filemgmt_votedata']} "
        . "(lid, ratinguser, rating, ratinghostname, ratingtimestamp) "
        . "VALUES ('$lid', '$ratinguser', '$rating', '$ip', '$datetime')");
    //All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
    updaterating($lid);
    $ratemessage = _MD_VOTEAPPRE . "<br>" . sprintf(_MD_THANKYOU, $_CONF[site_name]);
    redirect_header("index.php", 4, $ratemessage);
    exit;

} else {

    $lid = 0;
    if (isset($_GET['lid'])) {
        $lid = COM_applyFilter($_GET['lid'], true);
    }
    $display = '';
    $display .= COM_startBlock("<b>" . _MD_RATEFILETITLE . "</b>");
    $result = DB_query("SELECT title FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid='$lid'");
    list($title) = DB_fetchArray($result);
    $title = $myts->makeTboxData4Show($title);
    $display .= '<table border="0" cellpadding="1" cellspacing="0" width="80%" class="plugin"><tr>';
    $display .= '<td class="pluginHeader">' . _MD_FILE . ':&nbsp;' . $title . '</td></tr>';
    $display .= '<tr><td style="padding:10px;"><ul>';
    $display .= '<li>' . _MD_VOTEONCE . '</li>';
    $display .= '<li>' . _MD_RATINGSCALE . '</li>';
    $display .= '<li>' . _MD_BEOBJECTIVE . '</li>';
    $display .= '<li>' . _MD_DONOTVOTE . '</li>';
    $display .=  "
         </ul></td></tr><tr><td style=\"text-align:center;\">
         <form method=\"post\" action=\"ratefile.php\"><div>
         <input type=\"hidden\" name=\"lid\" value=\"$lid\"" . XHTML . ">
         <select name=\"rating\"><option>--</option>";
         for ($i=10; $i>0; $i--) {
            $display .= "<option value=\"" . $i . "\">" . $i . "</option>\n";
        }
    $display .= "</select><br" . XHTML . "><br" . XHTML . ">";
    $display .= "<input type=\"submit\" name=\"submit\" value=\"" . _MD_RATEIT . "\"" . XHTML . ">\n";
    $display .= "&nbsp;<input type=\"button\" value=\"" . _MD_CANCEL;
    $display .= "\" onclick=\"javascript:history.go(-1)\"" . XHTML . ">\n";
    $display .= "</div></form></td></tr></table>";
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}

?>