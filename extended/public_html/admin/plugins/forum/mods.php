<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | mods.php                                                                  |
// | Handles all the Moderation Admin functions                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
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

require_once $CONF_FORUM['path_include'] . 'gf_format.php';

$msg     	= isset($_GET['msg'])      ? COM_applyFilter($_GET['msg'], true)     : '';
$submit     = isset($_POST['submit'])  ? COM_applyFilter($_POST['submit']) 		 : '';

$display = '';

// Debug Code to show variables
$display .= gf_showVariables();

if ($submit != $LANG_GF01['CANCEL']) {
	if ($msg==1) {
		$display .= COM_showMessageText($LANG_GF93['modadded']);
	}
	if ($msg==2) {
		$display .= COM_showMessageText($LANG_GF93['moddeleted']);
	}
	if ($msg==3) {
		$display .= COM_showMessageText($LANG_GF93['modedited']);
	}
}

$display .= COM_startBlock($LANG_GF93['mod_title']);

$navbar->set_selected($LANG_GF06['4']);
$display .= $navbar->generate();

if (DB_count($_TABLES['forum_forums']) == 0) {
	$display .= alertMessage($LANG_GF93['moderatorwarning'], $LANG_GF93['moderatorwarningtitle']);
} else {
    if ($submit != $LANG_GF01['CANCEL']) {
		$id        = isset($_POST['recid']) ? COM_applyFilter($_POST['recid'],true) : '';
		$op 	   = isset($_POST['op']) 	? COM_applyFilter($_POST['op'])  		: '';
	
		switch ($op) {
			case 'update':
				if (($id > 0) && SEC_checkToken()) {
					if (!isset($_POST["chk_delete$id"])) {
						$mod_delete = "0";
					} else {
						$mod_delete = "1";
					}
					if (!isset($_POST["chk_ban$id"])) {
						$mod_ban = "0";
					} else {
						$mod_ban = "1";
					}
					if (!isset($_POST["chk_edit$id"])) {
						$mod_edit = "0";
					} else {
						$mod_edit = "1";
					}
					if (!isset($_POST["chk_move$id"])) {
						$mod_move = "0";
					} else {
						$mod_move = "1";
					}
					if (!isset($_POST["chk_stick$id"])) {
						$mod_stick = "0";
					} else {
						$mod_stick = "1";
					}
	
					DB_query("UPDATE {$_TABLES['forum_moderators']} SET mod_delete='$mod_delete', mod_ban='$mod_ban', mod_edit='$mod_edit', mod_move='$mod_move', mod_stick='$mod_stick' WHERE (mod_id='$id')");
					
					$display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/mods.php?msg=3');
					COM_output($display);
					exit();					
				}
				break;
	
			case 'delete':
	
				if (($id > 0) && SEC_checkToken()) {
					DB_query("DELETE FROM {$_TABLES['forum_moderators']} WHERE (mod_id='$id')");
					
					$display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/mods.php?msg=2');
					COM_output($display);
					exit();					
				}
				break;
	
			case 'delchecked':
				if  (SEC_checkToken()) {
					foreach ($_POST['chk_record_delete'] as $delrecord) {
						$delrecord = COM_applyFilter($delrecord,true);
						DB_query("DELETE FROM {$_TABLES['forum_moderators']} WHERE (mod_id='$delrecord')");
					}
					
					$display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/mods.php?msg=2');
					COM_output($display);
					exit();					
				}
				break;
	
		   case 'addrecord':
				if  (SEC_checkToken()) {
					if (!isset($_POST['chk_delete'])) {
						$mod_delete = "0";
					} else {
						$mod_delete = "1";
					}
					if (!isset($_POST['chk_ban'])) {
						$mod_ban = "0";
					} else {
						$mod_ban = "1";
					}
					if (!isset($_POST['chk_edit'])) {
						$mod_edit = "0";
					} else {
						$mod_edit = "1";
					}
					if (!isset($_POST['chk_move'])) {
						$mod_move = "0";
					} else {
						$mod_move = "1";
					}
					if (!isset($_POST['chk_stick'])) {
						$mod_stick = "0";
					} else {
						$mod_stick = "1";
					}
					if (count($_POST['sel_forum']) > 0) {
						if ($_POST['modtype'] == 'user') {
							foreach ($_POST['sel_user'] as $modMemberUID) {
								$modMemberUID = COM_applyFilter($modMemberUID,true);
								$modMemberName = DB_getItem($_TABLES['users'], "username","uid='$modMemberUID'");
								foreach ($_POST['sel_forum'] as $modForum) {
									$modForum = COM_applyFilter($modForum,true);
									$modquery = DB_query("SELECT * FROM {$_TABLES['forum_moderators']} WHERE mod_uid='$modMemberUID' AND mod_forum='$modForum'");
									if ( DB_numrows($modquery) == 1) {
										DB_query("DELETE FROM {$_TABLES['forum_moderators']} WHERE mod_uid='$modMemberUID' AND mod_forum='$modForum'");
									}
									$fields = 'mod_username,mod_uid,mod_groupid, mod_forum,mod_delete,mod_ban,mod_edit,mod_move,mod_stick';
									$values = "'$modMemberName','$modMemberUID','0', '$modForum','$mod_delete','$mod_ban','$mod_edit','$mod_move','$mod_stick'";
									DB_query("INSERT INTO {$_TABLES['forum_moderators']} ($fields) VALUES ($values)");
								}
							}
						} elseif ($_POST['modtype'] == 'group' AND$_POST['sel_group'] > 0)  {
							$modGroupid = COM_applyfilter($_POST['sel_group'], true);
							foreach ($_POST['sel_forum'] as $modForum) {
								$modForum = COM_applyFilter($modForum,true);
								$modquery = DB_query("SELECT * FROM {$_TABLES['forum_moderators']} WHERE mod_groupid='$modGroupid' AND mod_forum='$modForum'");
								if ( DB_numrows($modquery) == 1) {
									DB_query("DELETE FROM {$_TABLES['forum_moderators']} WHERE mod_groupid='$modGroupid' AND mod_forum='$modForum'");
								}
								$fields = 'mod_username,mod_uid,mod_groupid, mod_forum,mod_delete,mod_ban,mod_edit,mod_move,mod_stick';
								$values = "'','0','$modGroupid', '$modForum','$mod_delete','$mod_ban','$mod_edit','$mod_move','$mod_stick'";
								DB_query("INSERT INTO {$_TABLES['forum_moderators']} ($fields) VALUES ($values)");
							}
						}
					}
					
					$display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/mods.php?msg=1');
					COM_output($display);
					exit();					
				}
				
				break;
		}
	}

    // MAIN
    $filtermode     = isset($_POST['filtermode']) ? COM_applyFilter($_POST['filtermode'])      : '';
    $promptadd      = isset($_POST['promptadd'])  ? COM_applyFilter($_POST['promptadd'])       : '';

    if (isset($_POST['sel_forum']) && !is_array($_POST['sel_forum'])) {
        $selected_forum = COM_applyFilter($_POST['sel_forum']);
    } else {
        $selected_forum = '';
	}

    if ($promptadd == $LANG_GF93['addmoderator']) {
        $addmod= COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
        $addmod->set_file (array ('moderator'=>'mod_add.thtml'));
        
        $addmod->set_var ('action_url', $_CONF['site_admin_url'] . '/plugins/forum/mods.php');
        $addmod->set_var ('imgset', $CONF_FORUM['imgset']);
        $addmod->set_var ('LANG_filtertitle', 'Type' );
        $addmod->set_var ('LANG_ADDMessage', $LANG_GF93['addmessage']);
        $addmod->set_var ('LANG_CANCEL', $LANG_GF01['CANCEL']);
        $addmod->set_var ('sel_forums', COM_optionList($_TABLES['forum_forums'], 'forum_id,forum_name'));
        $addmod->set_var ('sel_users', COM_optionList($_TABLES['users'], 'uid,username'));
        $addmod->set_var ('sel_groups', COM_optionList($_TABLES['groups'], 'grp_id,grp_name'));
        $addmod->set_var ('LANG_functions', $LANG_GF93['allowedfunctions']);
        $addmod->set_var ('LANG_addmod', $LANG_GF93['addmoderator']);
        $addmod->set_var ('LANG_forum', $LANG_GF01['FORUM']);
        $addmod->set_var ('LANG_user', $LANG_GF01['USER']);
        $addmod->set_var ('LANG_group', $LANG_GF01['GROUP']);
        $addmod->set_var ('LANG_BAN', $LANG_GF93['ModBan']);
        $addmod->set_var ('LANG_EDIT', $LANG_GF93['ModEdit']);
        $addmod->set_var ('LANG_MOVE', $LANG_GF93['ModMove']);
        $addmod->set_var ('LANG_STICK', $LANG_GF93['ModStick']);
        $addmod->set_var ('LANG_DELETE', $LANG_GF01['DELETE']);

        $addmod->set_var('gltoken_name', CSRF_TOKEN);
        $addmod->set_var('gltoken', SEC_createToken());

        $addmod->parse ('output', 'moderator');
        $display .= $addmod->finish ($addmod->get_var('output'));

    } else {
        $showforumssql = DB_query("SELECT forum_name,forum_id FROM {$_TABLES['forum_forums']}");
        $sel_forums = '<option value="0">'.$LANG_GF93['allforums'].'</option>';
        while($showforum = DB_fetchArray($showforumssql)){
            if ($selected_forum == $showforum['forum_id']) {
                $sel_forums .= '<option value="' .$showforum['forum_id']. '" selected="selected">' .$showforum['forum_name']. '</option>';
            } else {
                $sel_forums .= '<option value="' .$showforum['forum_id']. '">' .$showforum['forum_name']. '</option>';
            }
        }

        $moderators = COM_newTemplate(CTL_plugin_templatePath('forum'));
        $moderators->set_file(array(
        				'moderators'	=>'admin/moderators.thtml', 
        				'forum_links'   => 'forum_links.thtml')); 
        
        $moderators->set_block('moderators', 'report_record');
        $moderators->set_block('moderators', 'no_records_message');
        $moderators->set_block('forum_links', 'trash_link');
        
        $moderators->set_var ('action_url', $_CONF['site_admin_url'] . '/plugins/forum/mods.php');
        $moderators->set_var ('imgset', $CONF_FORUM['imgset']);
        $moderators->set_var ('userfilter', '');
        if ($filtermode == 'group') {
            $moderators->set_var ('groupfilter', 'checked="checked"');
            $moderators->set_var ('LANG_HEADING2', $LANG_GF01['GROUP']);
        } else {
            $moderators->set_var ('userfilter', 'checked="checked"');
            $moderators->set_var ('LANG_HEADING2', $LANG_GF01['USER']);
        }
        $moderators->set_var ('LANG_filtertitle', $LANG_GF93['filtertitle']);
        $moderators->set_var ('LANG_addmodtitle', $LANG_GF93['LANG_addmodtitle']);
        
        $moderators->set_var ('LANG_username', $LANG_GF01['USER'] );
        $moderators->set_var ('LANG_FORUM', $LANG_GF01['FORUM']);
        $moderators->set_var ('LANG_BAN', $LANG_GF93['ModBan']);
        $moderators->set_var ('LANG_EDIT', $LANG_GF93['ModEdit']);
        $moderators->set_var ('LANG_MOVE', $LANG_GF93['ModMove']);
        $moderators->set_var ('LANG_STICK', $LANG_GF93['ModStick']);
        $moderators->set_var ('sel_forums', $sel_forums);
        $moderators->set_var ('LANG_addmod', $LANG_GF93['addmoderator']);
        $moderators->set_var ('LANG_delmod', $LANG_GF93['delmoderator']);
        $moderators->set_var ('LANG_DELALLCONFIRM',$LANG_GF02['msg159'] );
        $moderators->set_var ('LANG_DELCONFIRM',$LANG_GF02['msg159'] );
        $moderators->set_var ('LANG_deleteall', $LANG_GF01['DELETEALL']);
        $moderators->set_var ('LANG_OPERATION', $LANG_GF01['ACTIONS']);
        $moderators->set_var ('LANG_UPDATE', $LANG_GF01['UPDATE']);
        $moderators->set_var ('LANG_DELETE', $LANG_GF01['DELETE']);
        $moderators->set_var ('LANG_userrecords', $LANG_GF93['userrecords']);
        $moderators->set_var ('LANG_grouprecords', $LANG_GF93['grouprecords']);
        $moderators->set_var ('LANG_filterview', $LANG_GF93['filterview']);
        
        $moderators->parse ('trash_link','trash_link');

        $sql = "SELECT * FROM {$_TABLES['forum_moderators']} ";
        if ($selected_forum > 0) {
            $sql .= "WHERE mod_forum='{$selected_forum}' ";
            if ($filtermode == 'group') {
                $sql .= " AND  mod_groupid > '0' ";
            } else {
                $sql .= " AND mod_groupid = '0' ";
            }
        } elseif ($filtermode == 'group') {
            $sql .= " WHERE mod_groupid > '0' ";
        } else {
            $sql .= " WHERE mod_groupid = '0' ";
        }

        $sql .= " ORDER BY 'mod_username' ASC";
        $modsql = DB_query($sql);
        $nrows = DB_numRows($modsql);
        if ($nrows > 0) {
        	for ($i = 0; $i < $nrows; $i++) {
        		$M = DB_fetchArray($modsql);
	
				if ($M['mod_delete'] == "1") {
					$chk_delete = 'checked="checked"';
				} else {
					$chk_delete = "";
				}
				if ($M['mod_ban'] == "1") {
					$chk_ban = 'checked="checked"';
				} else {
					$chk_ban = "";
				}
				if ($M['mod_edit'] == "1") {
					$chk_edit = 'checked="checked"';
				} else {
					$chk_edit = "";
				}
				if ($M['mod_move'] == "1") {
					$chk_move = 'checked="checked"';
				} else {
					$chk_move = "";
				}
				if ($M['mod_stick'] == "1") {
					$chk_stick = 'checked="checked"';
				} else {
					$chk_stick = "";
				}
	
				$moderators->set_var ('id', $M['mod_id']);
				if ($filtermode == 'group') {
					$moderators->set_var ('name', DB_getItem($_TABLES['groups'],'grp_name', "grp_id='{$M['mod_groupid']}'"));
				} else {
					$moderators->set_var ('name', $M['mod_username']);
				}
				$moderators->set_var ('forum', DB_getItem($_TABLES['forum_forums'],"forum_name","forum_id={$M['mod_forum']}"));
				$moderators->set_var ('delete_yes', $chk_delete);
				$moderators->set_var ('ban_yes', $chk_ban);
				$moderators->set_var ('edit_yes', $chk_edit);
				$moderators->set_var ('move_yes', $chk_move);
				$moderators->set_var ('stick_yes', $chk_stick);
				$moderators->set_var ('cssid', ($i%2)+1 );
				$moderators->parse ('report_record', 'report_record',true);
			}
		} else {
			$moderators->set_var ('records_message', $LANG_GF93['nomoderatorfound']);
			$moderators->parse ('no_records_message', 'no_records_message');
		}  

        $moderators->set_var('gltoken_name', CSRF_TOKEN);
        $moderators->set_var('gltoken', SEC_createToken());

        $moderators->parse ('output', 'moderators');
        $display .= $moderators->finish ($moderators->get_var('output'));
    }
}

$display .= COM_endBlock();
$display = COM_createHTMLDocument($display);
COM_output($display);

?>
