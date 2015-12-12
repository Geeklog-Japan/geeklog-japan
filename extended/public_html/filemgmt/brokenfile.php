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

$lid = 0;
if (isset($_REQUEST['lid'])) {
    $lid = COM_applyFilter($_REQUEST['lid'], true);
}
if ($lid == 0) {
    echo COM_refresh($_CONF['site_url'] . '/filemgmt/index.php');
    exit;
}

if (isset($_POST['submit'])) {
    if (!$FilemgmtUser) {
        $sender = 0;
    } else {
        $sender = $uid;
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($sender != 0) {
        // Check if REG user is trying to report twice.
        $result=DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_brokenlinks']} "
                       . "WHERE lid='$lid' AND sender='$sender'");
        list($count) = DB_fetchArray($result);
        if ($count > 0) {
            redirect_header("index.php", 2, _MD_ALREADYREPORTED);
            exit;
        }
    } else {
        // Check if the sender is trying to vote more than once.
        $result=DB_query("SELECT COUNT(*) FROM {$_FM_TABLES['filemgmt_brokenlinks']} "
                       . "WHERE lid='$lid' AND ip='$ip'");
        list($count) = DB_fetchArray($result);
        if ($count > 0) {
            redirect_header("index.php", 2, _MD_ALREADYREPORTED);
            exit;
        }
    }
    DB_query("INSERT INTO {$_FM_TABLES['filemgmt_brokenlinks']} "
           . "(lid, sender, ip) VALUES ('$lid', '$sender', '$ip')") or die('');
    redirect_header("index.php", 2, _MD_THANKSFORINFO);
    exit;

} else {
    $display = '';
    $display .= COM_startBlock(_MD_ADMINTITLE) . LB;
    $display .= '<form action="brokenfile.php" method="post"><div>' . LB;
    $display .= '<input type="hidden" name="lid" value="' . $lid . '"' . XHTML . '>' . LB;
    $display .= '<table border="0" cellpadding="1" cellspacing="0" width="100%" class="plugin"><tr>' . LB;
    $display .= '<td class="pluginHeader">' . _MD_REPORTBROKEN . '</td></tr>' . LB;
    $display .= '<tr><td style="padding:10px;">' . LB;
    $display .= _MD_THANKSFORHELP . '<br' . XHTML . '>' . LB;
    $display .= _MD_FORSECURITY . '<br' . XHTML . '><br' . XHTML . '>' . LB;
    $display .= '</td></tr><tr><td style="padding:0px 0px 10px 10px;">' . LB;
    $display .= '<input type="submit" name="submit" value="' . _MD_REPORTBROKEN . '"' . XHTML . '>' . LB;
    $display .= '&nbsp;<input type="button" value="' . _MD_CANCEL . '" onclick="javascript:history.go(-1)"' . XHTML . '>' . LB;
    $display .= '</td></tr></table></div></form>' . LB;
    $display .= COM_endBlock();
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
}

?>