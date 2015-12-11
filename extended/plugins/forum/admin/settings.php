<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | settings.php                                                              |
// | Redirect to the settings forum page in Geeklog configuration UI           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |    Rouslan Placella            rouslan AT placella DOT com                |
// |                                                                           |
// | Copyright (C) 2000,2001,2002,2003 by the following authors:               |
// |    Tony Bibbs       tony AT tonybibbs DOT com                             |
// |                                                                           |
// | Forum Plugin Authors                                                      |
// |    Mr.GxBlock                                        www.gxblock.com      |
// |    Matthew DeWyer   matt AT mycws DOT com            www.cweb.ws          |
// |    Blaine Lang      geeklog AT langfamily DOT ca     www.langfamily.ca    |
// +---------------------------------------------------------------------------+
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
// +---------------------------------------------------------------------------+

require_once '../../../lib-common.php';

$token = SEC_createToken();

$display  = '';
$display .= COM_startBlock($LANG_GF92['gfsettings']);
$display .= "<div><form method='POST' name='redirect' action='" . $_CONF['site_admin_url'] . "/configuration.php'><div>";
$display .= "<noscript><meta http-equiv='refresh' content='0; URL=" . $_CONF['site_admin_url'] . "/configuration.php'></noscript>";
$display .= COM_showMessageText($LANG_GF02['msg03']);
$display .= "<input type='hidden' name='" . CSRF_TOKEN . "' value='$token'" . XHTML . ">";
$display .= "<input type='hidden' name='conf_group' value='forum'" . XHTML . ">";
$display .= "</div></form></div>";
$display .= COM_endBlock();
$display .= "<script type='text/javascript'>document.redirect.submit();</script>";
$display = COM_createHTMLDocument($display, array('what' => 'none'));

COM_output($display);

?>
