<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | ips.php                                                                   |
// | Program to administrate IP access/restriction to forum                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |    Rouslan Placella            rouslan AT placella DOT                    |
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

include_once 'gf_functions.php';

// Filter input variables
$ip    = isset($_REQUEST['ip'])   ? COM_applyFilter($_REQUEST['ip'])    : '';
$msg   = isset($_GET['msg'])      ? COM_applyFilter($_GET['msg'], true) : '';
$op    = isset($_REQUEST['op'])   ? COM_applyFilter($_REQUEST['op'])    : '';
$sure  = isset($_REQUEST['sure']) ? COM_applyFilter($_REQUEST['sure'])  : '';
$submit   = isset($_REQUEST['submit'])   ? COM_applyFilter($_REQUEST['submit'])     : '';

// Initialise output variable
$display = '';

// Debug Code to show variables
$display .= gf_showVariables();

// Display a message if an action was performed
if ($msg == 1) {
    $display .= COM_showMessageText($LANG_GF96['ipbanned']);
} else if ($msg == 2) {
    $display .= COM_showMessageText($LANG_GF96['ipunbanned']);
} else if ($msg == 3) {
    $display .= COM_showMessageText(sprintf($LANG_GF96['ipnotvalid'], $ip));
}

$display .= COM_startBlock($LANG_GF96['gfipman']);

$navbar->set_selected($LANG_GF06['7']);
$display .= $navbar->generate();

if ($op == 'banip' && $ip != '' && $submit != $LANG_GF01['CANCEL']) {
    if ($sure == 'yes' && SEC_checkToken()) {
        DB_query("INSERT INTO {$_TABLES['forum_banned_ip']} (host_ip) VALUES ('$ip')");
        $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/ips.php?msg=1');
        COM_output($display);
        exit;
    } else {
    	if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
			$ips_unban = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
			$ips_unban->set_file(array ('ips_ban_question'=>'ips_ban_question.thtml'));
			$ips_unban->set_var('phpself', $_CONF['site_admin_url'] .'/plugins/forum/ips.php');
			$ips_unban->set_var('ip', $ip);
			$ips_unban->set_var('alert_title', $LANG_GF02['adminconfirmation']);
			$ips_unban->set_var('alert_message', sprintf($LANG_GF96['banipmsg'], $ip));
			$ips_unban->set_var('ban', $LANG_GF96['ban']);
			$ips_unban->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
			$ips_unban->set_var('gltoken_name', CSRF_TOKEN);
			$ips_unban->set_var('gltoken', SEC_createToken());
			$ips_unban->parse('output', 'ips_ban_question');
			$display .= $ips_unban->finish($ips_unban->get_var('output'));
		} else {
			$display = COM_refresh("{$_CONF['site_admin_url']}/plugins/forum/ips.php?msg=3&amp;ip=$ip");
			COM_output($display);
			exit;			
		}
    }
} else if ($op == 'unban' && $ip != '' && SEC_checkToken()) {
    // Remove the entry from the database
    DB_query ("DELETE FROM {$_TABLES['forum_banned_ip']} WHERE (host_ip='$ip')");
    // ... and assume that everything went well
    $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/ips.php?msg=2');
    COM_output($display);
    exit;
} else {
    // Default case:
    // Show the list of banned IPs and quit
    $bannedsql = DB_query("SELECT * FROM {$_TABLES['forum_banned_ip']} ORDER BY host_ip DESC");
    $bannum = DB_numRows($bannedsql);
    $p = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
    $p->set_file(array ('page' => 'ips.thtml'));
    
    $p->set_block('page', 'report_record');
    $p->set_block('page', 'no_records_message');
    
    if ($bannum == 0) {
        $p->set_var('alertmessage', $LANG_GF96['noips']);
        $p->set_var('showalert','');
        
        $p->set_var('records_message', $LANG_GF96['noips']);
        $p->parse('no_records_message', 'no_records_message');
    } else {
        $p->set_var('showalert','none');
    }
    $p->set_var('phpself', $_CONF['site_admin_url'] .'/plugins/forum/ips.php');
    $p->set_var('lang_noip', $LANG_GF96['noip']);
    $p->set_var('LANG_IP',$LANG_GF96['ipbanned']);
    $p->set_var('lang_ban', $LANG_GF96['ban']);
    $p->set_var('lang_ip2', $LANG_GF96['ip']);
    $p->set_var('lang_ipaddress', $LANG_GF96['ipaddress']);
    $p->set_var('legend', $LANG_GF96['enterip']);
    $p->set_var('msg', $LANG_GF96['banipmsg']);
    $p->set_var('LANG_Actions', $LANG_GF01['ACTIONS']);
    $p->set_var('gltoken_name', CSRF_TOKEN);
    $p->set_var('gltoken', SEC_createToken());    
    $i = 1;
    while($A = DB_fetchArray($bannedsql)) {
        $p->set_var('ip', $A['host_ip']);
        $p->set_var('unban', $LANG_GF96['unban']);
        $p->set_var('csscode', $i);
        $p->parse('report_record', 'report_record',true);
        $i = ($i == 1 ) ? 2 : 1;
    }
    $p->parse('output', 'page');
    $display .= $p->finish($p->get_var('output'));
}

$display .= COM_endBlock();
$display = COM_createHTMLDocument($display);

// Show output
COM_output($display);
?>
