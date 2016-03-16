<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | public_html/mycaljp/index.php                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// | Geeklog Author:        Tony Bibbs - tony AT tonybibbs DOT com             |
// | mycal Block Author:    Blaine Lang - geeklog AT langfamily DOT ca         |
// | Mycaljp Plugin Author: dengen - taharaxp AT gmail DOT com                 |
// | Original PHP Calendar by Scott Richardson - srichardson@scanonline.com    |
// +---------------------------------------------------------------------------+
// |                                                                           |
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
// |                                                                           |
// +---------------------------------------------------------------------------+

require_once '../lib-common.php';

if (!in_array('mycaljp', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

// Check user has rights to access this page
if (!SEC_hasRights('mycaljp.edit,mycaljp.view,mycaljp.admin','OR')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the mycaljp page.  "
               . "User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR", 1);
    $display = COM_startBlock( $LANG_mycaljp['access_denied'] );
    $display .= $LANG_MYCALJP['access_denied_msg'];
    $display .= COM_endBlock();
    $display = COM_createHTMLDocument($display);
    COM_output($display);
    exit;
}

echo COM_refresh($_CONF['site_url'] . '/index.php');
exit;
?>