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
if (isset($_GET['lid'])) {
    $lid = COM_applyFilter($_GET['lid'], true);
}

// Comment out the following security check if you want general filemgmt users access to this report
if (!SEC_hasRights("filemgmt.edit")) {
    COM_errorLog("Downloadhistory.php => Filemgmt Plugin Access denied. "
        . "Attempted access for file ID:{$lid}, Remote address is:{$_SERVER['REMOTE_ADDR']}");
    redirect_header($_CONF['site_url'] . "/index.php", 1, _GL_ERRORNOADMIN);
    exit;
}

$result=DB_query("SELECT title FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE lid=$lid");
list($dtitle) = DB_fetchArray($result);

$result = DB_query("SELECT date,uid,remote_ip FROM {$_FM_TABLES['filemgmt_history']} WHERE lid=$lid");
$display = '';
$display .= '<table width="100%" border="0" cellspacing="1" cellpadding="4" class="plugin"><tr>';
$display .= '<td colspan="3"><div style="text-align:center;"><h2>' . $LANG_FILEMGMT['DownloadReport'] . '</h2></div></td></tr><tr>';
$display .= '<td colspan="3"><h4>File: ' . $dtitle . '</h4></td></tr><tr>';
$display .= '<td style="background-color:#000000; width:20%;"><b><span style="text-align:center; color:#ffffff;">Date</span></b></td>';
$display .= '<td style="background-color:#000000; width:20%;"><b><span style="text-align:center; color:#ffffff;">User</span></b></td>';
$display .= '<td style="background-color:#000000; width:20%;"><b><span style="text-align:center; color:#ffffff;">Remote IP</span></b></td>';
$display .= '</tr>';

$highlight = true;
while (list($date, $uid, $remote_ip) = DB_fetchArray($result)) {
    $result2 = DB_query("SELECT username FROM {$_TABLES['users']} WHERE uid = $uid");
    list($username) = DB_fetchArray($result2);
    $result2 = DB_query("SELECT username FROM {$_TABLES['users']} WHERE uid = $uid");
    list($username) = DB_fetchArray($result2);

    if ($highlight) {
        $highlight = false;
        $display .= '<tr>';
        $display .= '<td style="background-color:#f5f5f5; width:20%;">' . $date . '</td>';
        $display .= '<td style="background-color:#f5f5f5; width:20%;">' . $username . '</td>';
        $display .= '<td style="background-color:#f5f5f5; width:20%;">' . $remote_ip . '</td>';
        $display .= '</tr>';
    } else {
        $highlight = true;
        $display .= '<tr>';
        $display .= '<td style="width:20%;">' . $date . '</td>';
        $display .= '<td style="width:20%;">' . $username . '</td>';
        $display .= '<td style="width:20%;">' . $remote_ip . '</td>';
        $display .= '</tr>';
    }

}
$display .= '</table>';
$display .= '<br' . XHTML . '>';
if (function_exists('COM_createHTMLDocument')) {
    $information = array('menu' => 'none');
    $display = COM_createHTMLDocument($display, $information);
} else {
    $display = COM_siteHeader() . $display . COM_siteFooter();
}
COM_output($display);

?>