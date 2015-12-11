<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v3.5 Plugin                                                       |
// +---------------------------------------------------------------------------+
// | Geeklog integration functions.                                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                         |
// |                                                                           |
// | ben           cordiste AT free DOT fr                                     |
// |                                                                           |
// | Based on the original CAPTCHA Plugin                                      |
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Mark R. Evans - mark AT glfusion DOT org                                  | 
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
//

// this file can't be used on its own
if (strpos ($_SERVER['PHP_SELF'], 'functions.inc') !== false)
{
    die ('This file can not be used on its own.');
}

$langfile = $_CONF['path'] . 'plugins/captcha/language/' . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . 'plugins/captcha/language/english.php');
}

$_TABLES['cp_sessions'] = $_DB_table_prefix . 'cp_sessions';

/*
* Check and see if we need to load the plugin configuration
*/
if (!isset($_CP_CONF['debug'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $cp_config = config::get_instance();
    $_CP_CONF = $cp_config->get_config('captcha');
	$_CP_CONF['version'] = plugin_chkVersion_captcha();
	$_CP_CONF['expire'] = 900; // number of seconds to expire a session (900 = 15 min)
}

function CAPTCHA_sid() {
    return dechex(time()).dechex(mt_rand(1,65535));
}

function plugin_commentPreSave_captcha($uid, $title, $comment, $sid, $pid, $type, $postmode) {

    global $_CP_CONF, $_USER, $_POST;

    if ( $_CP_CONF['enable_comment'] != 1 ) {
        return 0;
    }

    if ( ($_CP_CONF['anonymous_only'] && $_USER['uid'] < 2) || $_CP_CONF['anonymous_only'] == 0 || ($_CP_CONF['remoteusers'] == 1 && SEC_inGroup("Remote Users") ) ) {
        $str = $_POST['captcha'];
        list( $rc, $msg )  = CAPTCHA_checkInput( 'comment',$str );
        if ( $rc == 1 )
            return 0;
        else
            return 1;
    }
    return 0;
}

function plugin_itemPreSave_captcha( $type='registration', $content='' ) {
    global $_CP_CONF, $_USER, $_POST;

    $msg = '';

    switch( $type ) {
        case 'comment' :
            if ( $_CP_CONF['enable_comment'] != 1 ) {
                return '';
            }
            break;
        case 'story' :
            if ( $_CP_CONF['enable_story'] != 1 ) {
                return '';
            }
            break;
        case 'registration' :
            if ( $_CP_CONF['enable_registration'] != 1 ) {
                return '';
            }
            break;
        case 'contact' :
            if ( $_CP_CONF['enable_contact'] != 1 ) {
                return '';
            }
            break;
        case 'emailstory' :
            if ( $_CP_CONF['enable_emailstory'] != 1 ) {
                return '';
            }
            break;
        case 'forum' :
            if ( $_CP_CONF['enable_forum'] != 1 ) {
                return '';
            }
            break;
        case 'mediagallery' :
            if ( $_CP_CONF['enable_mediagallery'] != 1 ) {
                return '';
            }
            break;
        case 'rating' :
            if ( $_CP_CONF['enable_rating'] != 1 ) {
                return '';
            }
            break;
        case 'links' :
            if ( $_CP_CONF['enable_links'] != 1 ) {
                return '';
            }
            break;
        case 'calendar' :
            if ( $_CP_CONF['enable_calendar'] != 1 ) {
                return '';
            }
            break;
        default :
            return '';
    }
    if ( !isset($_USER['uid']) ) {
        $_USER['uid'] = 1;
    }
    if ( ($_CP_CONF['anonymous_only'] && $_USER['uid'] < 2) || $_CP_CONF['anonymous_only'] == 0 || ($_CP_CONF['remoteusers'] == 1 && SEC_inGroup("Remote Users") ) ) {
        $str = COM_applyFilter($_POST['captcha']);
        list( $rc, $msg )  = CAPTCHA_checkInput( $type, $str );
        return $msg;
    }
    return '';
}

function plugin_templatesetvars_captcha($name, &$template) {
    global $_CP_CONF, $_USER, $_TABLES;

    switch( $name ) {
        case 'comment' :
            if ( $_CP_CONF['enable_comment'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'story' :
            if ( $_CP_CONF['enable_story'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'registration' :
            if ( $_CP_CONF['enable_registration'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'contact' :
            if ( $_CP_CONF['enable_contact'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'emailstory' :
            if ( $_CP_CONF['enable_emailstory'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'forum' :
            if ( $_CP_CONF['enable_forum'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'mediagallery' :
            if ( $_CP_CONF['enable_mediagallery'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'rating' :
            if ( $_CP_CONF['enable_rating'] != 1 ) {
                $template->set_var('captcha','');
                return;
            }
            break;
        case 'links' :
            if ( $_CP_CONF['enable_links'] != 1 ) {
                $template->set_var('captcha','');
                return;
            }
            break;
        case 'calendar' :
            if ( $_CP_CONF['enable_calendar'] != 1 ) {
                $template->set_var('captcha','');
                return;
            }
            break;
        default :
            $template->set_var('captcha', '');
            return;
            break;
    }
    if ( !isset($_USER['uid']) ) {
        $_USER['uid'] = 1;
    }

    if ( ($_CP_CONF['anonymous_only'] && $_USER['uid'] < 2) || $_CP_CONF['anonymous_only'] == 0 || ($_CP_CONF['remoteusers'] == 1 && SEC_inGroup("Remote Users") ) ) {
        // housekeeping, delete old captcha sessions
        $oldSessions = time() - ($_CP_CONF['expire']+900);
        DB_query("DELETE FROM {$_TABLES['cp_sessions']} WHERE cptime < " . $oldSessions,1);

        // OK, we need to insert the CAPTCHA, so now we need to setup the session_id:

        // check to see if a failed entry happened...
        if ( isset($_POST['csid']) ) {
            $csid = COM_applyFilter($_POST['csid']);
        } else {
            $csid    = CAPTCHA_sid();
        }
        $time    = time();
        $counter = 0;
        $validation = '';  // this will be filled in by the CAPTCHA

        DB_save($_TABLES['cp_sessions'],"session_id,cptime,validation,counter","'$csid','$time','','0'");

        $captcha = CAPTCHA_getHTML($csid,$name);
        $template->set_var('captcha', $captcha);
    } else {
        $template->set_var('captcha', '');
    }
}

// Internal CAPTCHA functions...

function CAPTCHA_getHTML($csid, $type='general' ) {
    
	global $_CONF, $_CP_CONF, $LANG_CP00, $_SCRIPTS;
	
	if(	$_CP_CONF['use_slider'] == 1 || !isset($_CP_CONF['use_slider']) ) {
	
		$_SCRIPTS->setJavaScriptLibrary('jquery');
		$_SCRIPTS->setJavaScriptLibrary('jquery.ui.draggable');
		
		$js .= '<script type="text/javascript" src="'
				 . $_CONF['site_url'] . '/captcha/jquery/jquery.ui.touch.js"></script>';
		$js .= '<script type="text/javascript" src="'
				 . $_CONF['site_url'] . '/captcha/jquery/QapTcha.jquery.js"></script>';
		$_SCRIPTS->setJavaScript($js, false, true);	
		
		$js = '<script type="text/javascript">
		  var captchagurl = "' . $_CONF['site_url'] . '/captcha/";
		  var txtLock_lang = "' . addslashes($LANG_CP00['txtLock']) . '";
		  var txtUnlock_lang = "' . addslashes($LANG_CP00['txtUnlock']) . '";' .
		  "$(document).ready(function(){
			$('.QapTcha').QapTcha();
		  });
		</script>";
		
		$_SCRIPTS->setJavaScript($js, false);
	}
	
	$retval = '';

    $T = new Template($_CONF['path'] . 'plugins/captcha/templates');
    switch ( $type ) {
        case 'comment' :
            $T->set_file('page', 'captcha_comment.thtml');
            break;
        case 'story' :
            $T->set_file('page', 'captcha_story.thtml');
            break;
        case 'registration' :
            $T->set_file('page', 'captcha_registration.thtml');
            break;
        case 'contact' :
            $T->set_file('page', 'captcha_contact.thtml');
            break;
        case 'emailstory' :
		    $T->set_file('page', 'captcha_emailstory.thtml');
            break;
        case 'links' :
		    $T->set_file('page', 'captcha_links.thtml');
            break;
        case 'calendar' :
            $T->set_file('page', 'captcha_calendar.thtml');
            break;
        case 'forum' :
            $T->set_file('page', 'captcha_forum.thtml');
            break;
        case 'mediagallery' :
            $T->set_file('page', 'captcha_mediagallery.thtml');
            break;
        case 'rating' :
            $T->set_file('page', 'captcha_rating.thtml');
            break;
        default :
            return '';
            break;
    }

    $T->set_var(array(
        'csid'                  => $csid,
		'xhtml'                 => XHTML,
    ));
	
	if(	$_CP_CONF['use_slider'] == 1 || !isset($_CP_CONF['use_slider']) ) {
	    
		$slider = '		<div id="captcha-form">
			<p><strong>' . $LANG_CP00['captcha'] . '</strong><br' . XHTML . '>
			' . $LANG_CP00['question'] . '<p>
			<div class="QapTcha"></div>
		</div>
        <div style="clear:both;"></div>';
		
		$T->set_var(array(
		    'slider'                => $slider
        ));
	}
	
	//input
	$input = '<div style="display:none"><label for="no_email">No email *</label><input id="no_email" name="no_email" type="email"{xhtml}></div>
	<div style="width:1px; height:1px; overflow:hidden; position:relative"><div style="position: absolute; height: 1px; width: 1px; right: -100px; overflow:hidden;"><label for="comment">Comment *</label><input id="comment_' . $_CP_CONF['input_id'] . '" name="comment_' . $_CP_CONF['input_id'] . '"' . XHTML .'></div></div>';
			
	$T->set_var('input', $input);

    $T->parse('output', 'page');
    $retval .= $T->finish($T->get_var('output'));

    return $retval;
}

function CAPTCHA_checkInput( $type, $str ) {
    
	global $_CONF, $_CP_CONF, $_TABLES, $LANG_CP00, $_SERVER;

    $msg = '';
    $rc = 0;
	
	if ($_CP_CONF['debug'] == 1) $debug = true;
	
	if ($debug) CAPTCHA_errorLog("Debug: Check input - Type: " . $type, 1);

	// housekeeping, delete old captcha sessions
    $oldSessions = time() - ($_CP_CONF['expire']+900);
    DB_query("DELETE FROM {$_TABLES['cp_sessions']} WHERE cptime < " . $oldSessions,1);

    if ( !isset($_POST['csid']) ) {
        CAPTCHA_errorLog("CAPTCHA: Detected an attempt to bypass CAPTCHA (no session id) in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
        $msg = $LANG_CP00['bypass_error_blank'];
        $rc = 0;
    } else {
        $csid = COM_applyFilter($_POST['csid']);
        // check the time
        $cTime = DB_getItem($_TABLES['cp_sessions'],'cptime',"session_id='" . $csid . "'");
        $now = time();
        if ( $cTime == '' || $cTime+$_CP_CONF['expire'] < $now ) {
			CAPTCHA_errorLog("CAPTCHA: Detected an attempt to use an expired CAPTCHA in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
            $msg = $LANG_CP00['session_expired'];
            $rc = 0;
            return ( array( $rc, $msg ) );
        }
		
		if ( $_POST['no_email'] == '' && isset($_POST['no_email']) && $_POST["comment_{$_CP_CONF['input_id']}"] == '' && isset($_POST["comment_{$_CP_CONF['input_id']}"]) ) {
            
			if ($debug) CAPTCHA_errorLog("Debug: Blank input ok", 1);
			
			if(	$_CP_CONF['use_slider'] == 1 || !isset($_CP_CONF['use_slider']) ) {
			
				$validation = DB_getItem($_TABLES['cp_sessions'],'validation',"session_id='" . $csid . "'");
				if( $validation != '' ) {
					// check if the random input created exists and is empty
					if(isset($_POST[''. $validation . '']) && empty($_POST['' . $validation . '']))
					{
						if ($debug) CAPTCHA_errorLog("Debug: All tests passed!", 1);
						$rc = 1;
					} else {
						if ($debug) CAPTCHA_errorLog("Debug: Random input issue", 1);
						if ($debug && !isset($_POST['' . $validation . ''])) CAPTCHA_errorLog("Debug: Random input do not exists", 1);
						if ($debug && empty($_POST['' . $validation . ''])) CAPTCHA_errorLog("Debug: Random input is empty", 1);
					}
				} else {
					if ($debug) {
						CAPTCHA_errorLog("Debug: Ajax issue with qatcha key. Validation is blank in cp_sessions table where session_id = " . $csid, 1);
					}
				}
			} else {
			    // slider not use
				if ($debug) CAPTCHA_errorLog("Debug: Slider is not active. All tests passed!", 1);
				$rc = 1;
			}
			DB_query("DELETE FROM {$_TABLES['cp_sessions']} WHERE session_id='" . $csid . "'",1);
		} else { 
			CAPTCHA_errorLog("CAPTCHA: CAPTCHA failed in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
			$msg = $LANG_CP00['entry_error'];
		}
    }
    return ( array( $rc, $msg ) );
}

function CAPTCHA_errorLog( $logentry, $override = 0) {
    
	global $_CONF, $_CP_CONF;

    if ( !isset($_CP_CONF['logging']) ) {
        $_CP_CONF['logging'] = 0;
    }

    if ( $_CP_CONF['logging'] != 1 && $override == 0) {
        return;
    }

    if( !empty( $logentry )) {
        $timestamp = strftime( '%c' );
        $logfile = $_CONF['path_log'] . 'captcha.log';

        if( $file = fopen( $logfile, 'a+' )) {
            fputs( $file, "$timestamp - $logentry \n" );
            fclose($file);
        }
    }
}


/**
 * Returns the current plugin code version
 *
 * @return string    plugin version
 */
function plugin_chkVersion_captcha()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/captcha/autoinstall.php';

    $inst_parms = plugin_autoinstall_captcha('captcha');

    return $inst_parms['info']['pi_version'];

}

/**
* This will put an option for the plugin in the command and control block on moderation.php
*
* Add the plugin name, icon and link to the command and control block in moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*
*/

function plugin_cclabel_captcha() {
    global $_CONF, $LANG_CP00;

    if (SEC_inGroup('Root') ) {
        return array($LANG_CP00['plugin'],
            $_CONF['site_admin_url'] . '/plugins/captcha/index.php',
            $_CONF['site_url'] . '/captcha/captcha.png');
    } else {
        return '';
    }
}

/**
* Returns the administrative option for this plugin
*
* Adds the plugin to the Admin menu
*
* @return   array   Array containing (plugin name, plugin admin url, # of items in plugin or '')
*
*/
function plugin_getadminoption_captcha() {

    global $_CONF, $_TABLES, $LANG_CP00, $_SCRIPTS;

    if (SEC_inGroup('Root')) 
	{
        return array($LANG_CP00['plugin'], $_CONF['site_admin_url'] . '/plugins/captcha/index.php', $message);
    }
}

/**
 * Filters submitted variables
 *
 * Uses geeklog functions to filter submitted variables for illegal content.  Any editing is
 * done in place and no value is returned
 *
 * @param array $vars associative array of variable name => type (type in (number,alpha,text,html))
 * @param array &$arr reference to associative array of variable name => value
 */
function CAPTCHA_filterVars($vars, &$arr) 
{
    // cycle through each variable applying the appropriate filter
    foreach ($vars as $var => $type) {
        switch ($type) {
            case 'number':
                $arr[$var] = COM_applyFilter($arr[$var], true);
                break;

            case 'html':
                $arr[$var] = COM_checkHTML($arr[$var], 'classifieds.admin');
                break;

            case 'text':
                $arr[$var] = htmlspecialchars(strip_tags(COM_stripslashes($arr[$var])));
                break;

            case 'alpha':
            default:
                $arr[$var] = COM_applyFilter($arr[$var], false);
                break;
        }
    }
}

function plugin_getheadercode_captcha()
{
    global $_CONF, $_CP_CONF;
			 
    //captcha css
    $str1 = '<link rel="stylesheet" type="text/css" href="'
             . $_CONF['site_url'] . '/captcha/style.css"' . XHTML . '>';
        
	if(	$_CP_CONF['use_slider'] == 1 || !isset($_CP_CONF['use_slider']) ) {
	
		$str1 .= LB .
			 '<link rel="stylesheet" type="text/css" href="'
             . $_CONF['site_url'] . '/captcha/jquery/QapTcha.jquery.css" media="screen" ' . XHTML . '>';
	}

    return $str1;
}

/**
* Removes the data structures for this plugin from the Geeklog database.
* This routine will get called from the Plugin install program if user select De-Install or if Delete is used in the Plugin Editor.
* The Plugin Installer will also call this routine upon and install error to remove anything it has created.
* The Plugin installer will pass the optional parameter which will then double check that plugin has first been disabled.
*
* For this plugin, this routine will also remove the Block definition.
*
* Returns True if all Plugin related data is removed without error
*
* @param    string   $installCheck     Defult is blank but if set, check if plugin is disabled first
*
* @return   boolean True if successful false otherwise
*
*/
function plugin_autouninstall_captcha() 
{
	    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('cp_sessions'),
        /* give the full name of the group, as in the db */
        'groups' => array('Captcha Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('config.captcha.tab_main'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
}

function plugin_upgrade_captcha()
{
    global $_TABLES, $_CONF, $_CP_CONF;

    $currentVersion = DB_getItem($_TABLES['plugins'],'pi_version',"pi_name='captcha'");
    $code_version = plugin_chkVersion_captcha();
    if ($currentVersion == $_CP_CONF['version']) {
        // nothing to do
        return true;
    }
    switch( $currentVersion ) {
        case "2.0.0" :
        case "2.0.1" :
        case "2.0.2" :
            $_SQL['cp_config'] =
                "CREATE TABLE {$_TABLES['cp_config']} ( " .
                "  `config_name` varchar(255) NOT NULL default '', " .
                "  `config_value` varchar(255) NOT NULL default '', " .
                "   PRIMARY KEY  (`config_name`) " .
                " );";

            foreach ($_SQL as $table => $sql) {
                COM_errorLog("Creating $table table",1);
                DB_query($sql,1);
                if (DB_error()) {
                    COM_errorLog("Error Creating $table table",1);
                }
                COM_errorLog("Success - Created $table table",1);
            }

            $SQL_DEFAULTS = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES " .
                            " ('anonymous_only', '1'), " .
                            " ('debug', '0'), " .
                            " ('enable_comment', '0'), " .
                            " ('enable_contact', '0'), " .
                            " ('enable_emailstory', '0'), " .
                            " ('enable_forum', '0'), " .
                            " ('enable_registration', '0'), " .
                            " ('enable_story', '0'), " .
                            " ('gfxDriver', '2'), " .
                            " ('gfxFormat', 'jpg'), " .
                            " ('gfxPath', '');";

            DB_query($SQL_DEFAULTS,1);
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version='2.1.0' WHERE pi_name='captcha' LIMIT 1");
        case "2.1.0" :
        case "2.1.1" :
        case "2.1.2" :
            $_SQL['cp_sessions'] =
                            "CREATE TABLE {$_TABLES['cp_sessions']} ( " .
                            "  `session_id` varchar(40) NOT NULL default '', " .
                            "  `cptime`  INT(11) NOT NULL default 0, " .
                            "  `validation` varchar(40) NOT NULL default '', " .
                            "  `counter`    TINYINT(4) NOT NULL default 0, " .
                            "  PRIMARY KEY (`session_id`) " .
                            " );";

            foreach ($_SQL as $table => $sql) {
                COM_errorLog("Creating $table table",1);
                DB_query($sql,1);
                if (DB_error()) {
                    COM_errorLog("Error Creating $table table",1);
                }
                COM_errorLog("Success - Created $table table",1);
            }

            $SQL_DEFAULTS = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES " .
                            " ('enable_mediagallery', '0'), " .
                            " ('remoteusers', '0');";

            DB_query($SQL_DEFAULTS,1);
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version='3.0.0' WHERE pi_name='captcha' LIMIT 1");
        case "3.0.0" :
        case "3.0.1" :
        case "3.0.2" :
            $SQL_DEFAULTS = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES " .
                            " ('logging', '0'), " .
                            " ('enable_rating', '0');";
            DB_query($SQL_DEFAULTS,1);
		case "3.1.0" :
		case "3.1.1" :
		case "3.1.2" :
		    $SQL_DEFAULTS = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES " .
                            " ('enable_calendar', '0'), " .
                            " ('enable_links', '0');";
			DB_query($SQL_DEFAULTS,1);
		case "3.2.0" :	
		case "3.3.0" :	
		case "3.3.0.1" :	
		case "3.3.1" :
		
		    require_once $_CONF['path'] . 'plugins/captcha/autoinstall.php';
	        require_once $_CONF['path'] . 'plugins/captcha/install_defaults.php';
	        require_once $_CONF['path_system'] . 'classes/config.class.php';
			
			// remove table cp_config 
			DB_query("DROP TABLE " . $_TABLES['cp_config'],1);
			
			//add config values
			$c = config::get_instance();

			$c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'captcha', 0);
			$c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'captcha', 0);
			
			$c->add('fs_config', NULL, 'fieldset', 0, 0, NULL, 0, true, 'captcha', 0);
			
			$c->add('gfxDriver', $_CP_DEFAULT['gfxDriver'],
					'select', 0, 0, 2, 10, true, 'captcha', 0);
			$c->add('imageset', $_CP_DEFAULT['imageset'],
					'select', 0, 0, 3, 20, true, 'captcha', 0);
			$c->add('gfxFormat', $_CP_DEFAULT['gfxFormat'],
					'select', 0, 0, 4, 30, true, 'captcha', 0);
			$c->add('gfxPath', $_CP_DEFAULT['gfxPath'],
					'text', 0, 0, 0, 40, true, 'captcha', 0);
			$c->add('debug', $_CP_DEFAULT['debug'],
					'select', 0, 0, 0, 50, true, 'captcha', 0);
			$c->add('logging', $_CP_DEFAULT['logging'],
					'select', 0, 0, 0, 60, true, 'captcha', 0);

			$c->add('fs_integration', NULL, 'fieldset', 0, 10, NULL, 0, true, 'captcha', 0);
			
			$c->add('anonymous_only', $_CP_DEFAULT['anonymous_only'],
					'select', 0, 10, 0, 10, true, 'captcha', 0);
			 $c->add('remoteusers', $_CP_DEFAULT['remoteusers'],
					'select', 0, 10, 0, 20, true, 'captcha', 0);
			$c->add('enable_comment', $_CP_DEFAULT['enable_comment'],
					'select', 0, 10, 0, 40, true, 'captcha', 0);
			$c->add('enable_contact', $_CP_DEFAULT['enable_contact'],
					'select', 0, 10, 0, 50, true, 'captcha', 0);
			$c->add('enable_emailstory', $_CP_DEFAULT['enable_emailstory'],
					'select', 0, 10, 0, 60, true, 'captcha', 0);
			$c->add('enable_forum', $_CP_DEFAULT['enable_forum'],
					'select', 0, 10, 0, 70, true, 'captcha', 0);
			$c->add('enable_registration', $_CP_DEFAULT['enable_registration'],
					'select', 0, 10, 0, 80, true, 'captcha', 0);
			$c->add('enable_mediagallery', $_CP_DEFAULT['enable_mediagallery'],
					'select', 0, 10, 0, 90, true, 'captcha', 0);
			$c->add('enable_rating', $_CP_DEFAULT['enable_rating'],
					'select', 0, 10, 0, 100, true, 'captcha', 0);
			$c->add('enable_story', $_CP_DEFAULT['enable_story'],
					'select', 0, 10, 0, 110, true, 'captcha', 0); 
			$c->add('enable_calendar', $_CP_DEFAULT['enable_calendar'],
					'select', 0, 10, 0, 120, true, 'captcha', 0);
			$c->add('enable_links', $_CP_DEFAULT['enable_links'],
					'select', 0, 10, 0, 130, true, 'captcha', 0);			
			
			//Set flag to display message
			DB_query("INSERT INTO {$_TABLES['vars']} SET name = 'captcha_upgrade', value = '1'");
			
		case "3.4.0" :
        case "3.4.1" :
        case "3.4.2" :
        case "3.4.3" :
		    $c = config::get_instance();
			$c->del('gfxDriver', 'captcha');
			$c->del('imageset', 'captcha');
			$c->del('gfxFormat', 'captcha');
			$c->del('gfxPath', 'captcha');
			$c->add('input_id', rand(),
                'text', 0, 0, 0, 70, true, 'captcha', 0);
			
		case "3.5.0":
		case "3.5.1":
		case "3.5.2":
		    $c = config::get_instance();
			$c->add('use_slider', 1,
					'select', 0, 0, 0, 80, true, 'captcha', 0);
		    $_CP_CONF['use_slider'] = 1;
		case "3.5.3":
		case "3.5.4":
		    if (!isset($_CP_CONF['use_slider'])) {
			    $c = config::get_instance();
			    $c->add('use_slider', 1,
					'select', 0, 0, 0, 80, true, 'captcha', 0);
			}
		case "3.5.5":
		
        default :
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version='{$_CP_CONF['version']}' WHERE pi_name='captcha' LIMIT 1");
			DB_query("UPDATE {$_TABLES['plugins']} SET pi_homepage = 'http://geeklog.fr' WHERE pi_name = 'captcha'",1);
			
			/* This code is for statistics ONLY */
            $message =  'Completed captcha plugin upgrade: ' . date('m d Y',time()) . "   AT " . date('H:i', time()) . "\n";
            $message .= 'Site: ' . $_CONF['site_url'] . ' and Sitename: ' . $_CONF['site_name'] . "\n";
            COM_mail("ben@geeklog.fr","Updated captcha plugin from $currentVersion to {$_CP_CONF['version']}",$message);
			
            break;
    }
    if ( DB_getItem($_TABLES['plugins'],'pi_version',"pi_name='captcha'") == $_CP_CONF['version']) {
        return 1;
    } else {
        return 2;
    }
}
?>