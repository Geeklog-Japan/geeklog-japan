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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'header.php') !== false) {
    die ('This file can not be used on its own.');
}

$FilemgmtUser  = false;
if (SEC_hasRights('filemgmt.user') OR $mydownloads_publicpriv == 1) {
    $FilemgmtUser = true;
}

$FilemgmtAdmin = false;
if (SEC_hasRights('filemgmt.edit')) {
    $FilemgmtAdmin = true;
}

$uid = 1;    // Set to annonymous GL User ID
if (isset($_USER['uid'])) {
    $uid = $_USER['uid'];
}

if ((!$FilemgmtUser) && (!$FilemgmtAdmin)) {
    $display .= COM_startBlock(_GL_ERRORNOACCESS);
    $display .= _MD_USER . " " . $_USER['username'] . " " . _GL_NOUSERACCESS;
    $display .= COM_endBlock();
    if (!isset($_USER['username'])) {
        $_USER['username'] = 'anonymous';
    }
    COM_errorLog("UID:$uid ({$_USER['username']}), Remote address is: {$_SERVER['REMOTE_ADDR']} " . _GL_NOUSERACCESS, 1);
    if (function_exists('COM_createHTMLDocument')) {
        $display = COM_createHTMLDocument($display);
    } else {
        $display = COM_siteHeader() . $display . COM_siteFooter();
    }
    COM_output($display);
    exit;
}

?>