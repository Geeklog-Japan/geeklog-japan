<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | upgrade.php                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'upgrade.inc') !== false) {
    die('This file can not be used on its own.');
}

function upgrade_232() {
    global $_TABLES;

    $_SQL = array();

    /* Drop these extra fields in case they still exist */
    $dropfields = array('img_width','img_height','topicnumchars','newtopic','newreply','mouseover','mouseout');
    $fields = DB_query("SHOW COLUMNS FROM {$_TABLES['forum_settings']}");
    while ($A = DB_fetchArray($fields)) {
        if (in_array($A['Field'],$dropfields)) {
            $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} DROP {$A['Field']}";
        }
    }

    // Version 2.3 to 2.3.2 added one field - Add if this field does not exist
    $fields = DB_query("SHOW COLUMNS FROM {$_TABLES['forum_userprefs']}");
    while ($A = DB_fetchArray($fields)) {
        if (in_array($A['Field'],array('enablenotify'))) {         
            $fieldfound = true;
        }
    }
    if (!$fieldfound) {    
        $_SQL[] = "ALTER TABLE {$_TABLES['forum_userprefs']} ADD enablenotify tinyint(1) DEFAULT '1' NOT NULL AFTER viewanonposts";
    }
    
    /* Rename this field */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} CHANGE  `msgauto` `autorefresh` TINYINT(1) DEFAULT '1' NOT NULL ";

    /* Add these new fields after `allow_notify` */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD post_htmlmode tinyint(1) DEFAULT '1' NOT NULL AFTER allow_notify";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD allow_userdatefmt tinyint(1) DEFAULT '0' NOT NULL AFTER post_htmlmode";

    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD refresh_delay tinyint(1) DEFAULT '0' NOT NULL AFTER autorefresh";

    /* Add these new fields after `postsperpage` */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD messagesperpage int(4) DEFAULT '20' NOT NULL AFTER postsperpage";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD searchesperpage int(4) DEFAULT '20' NOT NULL AFTER messagesperpage";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD popular int(4) DEFAULT '0' NOT NULL AFTER searchesperpage";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD speedlimit int(1) DEFAULT '60' NOT NULL AFTER popular";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD use_spamxfilter tinyint(1) DEFAULT '1' NOT NULL AFTER speedlimit";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD use_smiliesplugin tinyint(1) DEFAULT '0' NOT NULL AFTER use_spamxfilter";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD use_pmplugin tinyint(1) DEFAULT '0' NOT NULL AFTER use_smiliesplugin";


    /* Add these new fields after `cb_where` */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD cb_subjectsize tinyint(1) DEFAULT '40' NOT NULL AFTER cb_where";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD cb_numposts tinyint(1) DEFAULT '5' NOT NULL AFTER cb_subjectsize";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD sb_subjectsize tinyint(1) DEFAULT '20' NOT NULL AFTER cb_numposts";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD sb_numposts tinyint(1) DEFAULT '5' NOT NULL AFTER sb_subjectsize";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD sb_latestposts tinyint(1) DEFAULT '5' NOT NULL AFTER sb_numposts";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD min_comment_len tinyint(1) DEFAULT '5' NOT NULL AFTER sb_latestposts";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD min_name_len tinyint(1) DEFAULT '2' NOT NULL AFTER min_comment_len";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD min_subject_len tinyint(1) DEFAULT '2' NOT NULL AFTER min_name_len";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD html_newline tinyint(1) DEFAULT '0' NOT NULL AFTER min_subject_len";

    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD use_geshi_formatting tinyint(1) DEFAULT '0' NOT NULL AFTER glfilter";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} ADD edit_timewindow int(11) DEFAULT '300' NOT NULL AFTER speedlimit";

    /* Add new forum table fields */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_forums']} ADD is_hidden tinyint(1) DEFAULT '0' NOT NULL AFTER grp_id";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_forums']} ADD is_readonly tinyint(1) DEFAULT '0' NOT NULL AFTER is_hidden";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_forums']} ADD no_newposts tinyint(1) DEFAULT '0' NOT NULL AFTER is_readonly";

    $_SQL[] = "ALTER TABLE {$_TABLES['forum_moderators']} ADD mod_uid mediumint(8) DEFAULT '0' NOT NULL AFTER mod_id";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_moderators']} ADD mod_groupid mediumint(8) DEFAULT '0' NOT NULL AFTER mod_uid";
    
    /* Add new userprefs field */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_userprefs']} ADD notify_once tinyint(1) DEFAULT '0' NOT NULL AFTER showiframe"; 

    /* Execute SQL now to perform the upgrade */
    for ($i = 1; $i <= count($_SQL); $i++) {
        COM_errorLOG("Forum Plugin 2.5 update: Executing SQL => " . current($_SQL));
        DB_query(current($_SQL),'1');
        if (DB_error()) {
            COM_errorLog("SQL Error during Forum plugin update",1);
            return 1;
            break;
        }
        next($_SQL);
    }
    
    // Update the moderator records - now that we have a uid field
    $query = DB_query("SELECT mod_id,mod_username FROM {$_TABLES['forum_moderators']}");
    while ($A = DB_fetchArray($query)) {
        $mod_uid = DB_getItem($_TABLES['users'],'uid',"username='{$A['mod_username']}'");
        if ($mod_uid > 0) {
            DB_query("UPDATE {$_TABLES['forum_moderators']} SET mod_uid = $mod_uid WHERE mod_id={$A['mod_id']}");
        }
    }
    COM_errorLog("Success - Completed Forum plugin version 2.5 update",1);
    return 0;
}


function upgrade_25() {
    global $_TABLES;

    $_SQL = array();

    /* Add new fields */
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_forums']} ADD topic_count mediumint(8) DEFAULT '0' NOT NULL AFTER no_newposts";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_forums']} ADD post_count mediumint(8) DEFAULT '0' NOT NULL AFTER topic_count";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_forums']} ADD last_post_rec mediumint(8) DEFAULT '0' NOT NULL AFTER post_count";
    $_SQL[] = "ALTER TABLE {$_TABLES['forum_topic']} ADD last_reply_rec mediumint(8) DEFAULT '0' NOT NULL AFTER lastupdated";

    // Check if the field 'allow_htmlsig' exists - from a ver2.5 install
    $query = DB_query("SELECT * FROM {$_TABLES['forum_settings']} ");
    $numfields =  DB_numFields($query);
    $A = DB_fetchArray($query,false);
    $fieldname = DB_fieldName($query,1);
    if (array_key_exists('allow_htmlsig',$A)) {
        /* Rename this field */
        $_SQL[] = "ALTER TABLE {$_TABLES['forum_settings']} CHANGE  `allow_htmlsig` `post_htmlmode` TINYINT(1) DEFAULT '1' NOT NULL ";
    }

    // Disable the convert new lines to BR tags - may not even be needed anymore but will add extra newlines if enabled.
    $_SQL[] = "UPDATE {$_TABLES['forum_settings']} SET html_newline=0";
    /* Execute SQL now to perform the upgrade */
    for ($i = 1; $i <= count($_SQL); $i++) {
        COM_errorLOG("Forum Plugin 2.6 update: Executing SQL => " . current($_SQL));
        DB_query(current($_SQL),'1');
        if (DB_error()) {
            COM_errorLog("SQL Error during Forum plugin update",1);
            return 1;
            break;
        }
        next($_SQL);
    }    

    COM_errorLog("Success - Completed Forum plugin version 2.6 update",1);
    return 0;

}

function upgrade_274() {
    global $_CONF, $_TABLES;

    // Geeklog User profile already has location
    DB_query("ALTER TABLE {$_TABLES['forum_userinfo']} DROP `location`");
    
    require_once $_CONF['path'] . 'plugins/forum/install_defaults.php';
    forum_update_ConfValues_2_7_4();
    
    // Drop Forum settings table since now in Geeklog Configuration (must be done after config update
    DB_query("DROP TABLE {$_TABLES['forum_settings']}");    

    COM_errorLog("Success - Completed Forum plugin version 2.8.0 update",1);
    return 0;
}


function upgrade_280() {
    global $_CONF, $_TABLES;
    
    // Delete Old Forum Blocks since now dynamic blocks
    DB_query("DELETE FROM {$_TABLES['blocks']} WHERE phpblockfn = 'phpblock_forum_newposts' OR phpblockfn = 'phpblock_forum_menu'");

    require_once $_CONF['path'] . 'plugins/forum/install_defaults.php';
    forum_update_ConfValues_2_8_0();

    COM_errorLog("Success - Completed Forum plugin version 2.9.0 update",1);
    return 0;
}

function upgrade_290() {
    global $_CONF, $_TABLES;

    require_once $_CONF['path'] . 'plugins/forum/install_defaults.php';
    forum_update_ConfValues_2_9_0();
    
    // Fix postmode column with "{postmode}"
    DB_query("UPDATE {$_TABLES['forum_topic']} SET postmode = 'text' WHERE postmode = '{postmode}'");
    
    // Convert all HTML postmodes to html
    DB_query("UPDATE {$_TABLES['forum_topic']} SET postmode = 'html' WHERE postmode = 'HTML'");

    // Fix up User Preference Table
    DB_query("ALTER TABLE {$_TABLES['forum_userprefs']} ADD `newperpage` INT NOT NULL DEFAULT '20' AFTER `postsperpage` , ADD `popularperpage` INT NOT NULL DEFAULT '20' AFTER `newperpage`");     
    DB_query("ALTER TABLE {$_TABLES['forum_userprefs']} DROP `messagesperpage`");
    DB_query("ALTER TABLE {$_TABLES['forum_userprefs']} CHANGE `topicsperpage` `topicsperpage` INT( 3 ) NOT NULL DEFAULT '10', CHANGE `postsperpage` `postsperpage` INT( 3 ) NOT NULL DEFAULT '10'");  
    

    COM_errorLog("Success - Completed Forum plugin version 2.9.1 update",1);
    return 0;
}
?>
