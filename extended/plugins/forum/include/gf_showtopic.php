<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | gf_showtopic.php                                                          |
// | Main functions to show - format topics in the forum                       |
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

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'gf_showtopic.php') !== false) {
    die ('This file can not be used on its own.');
}

if (!function_exists( 'str_ireplace' ))
{
    require_once 'PHP/Compat.php';
    PHP_Compat::loadFunction( 'str_ireplace' );
}

require_once $_CONF['path'] . 'system/lib-user.php';

/**
* Creates an HTML string with the pictures that display a given rank
*/
function showrank($rank, $rankname)
{
    global $LANG_GF01, $CONF_FORUM;

    $i = '';
    $retval = '';
    $starimage = "<img src=\"%s\" alt=\"%s\" title=\"$rankname\"" . XHTML . ">";
    if ($rank <= 5) {
        $on  = sprintf($starimage, gf_getImage('rank_on','ranks'), '+');
        $off = sprintf($starimage, gf_getImage('rank_off','ranks'), '-');
        for ($i=1; $i<=$rank; $i++) {
            $retval .= $on;
        }
        for ($i=$rank+1; $i<=5; $i++) {
            $retval .= $off;
        }
    } else {
        if ($rank == 6) {
            $i = sprintf($starimage, gf_getImage('rank_mod','ranks'), 'M');
        } else if ($rank == 7) {
            $i = sprintf($starimage, gf_getImage('rank_admin','ranks'), 'A');
        }
        $retval = $i . $i . $i . $i. $i;
    }

    return $retval;
}

function showtopic($showtopic,$mode='',$onetwo=1,$page=1)
{
    global $CONF_FORUM, $_CONF, $_TABLES, $_USER, $LANG_GF01, $LANG_GF02, $LANG_GF09;
    global $fromblock,$highlight;
    global $oldPost;

    $oldPost = 0;

    //$mytimer = new timerobject();
    //$mytimer->setPercision(2);
    //$mytimer->startTimer();
    //$intervalTime = $mytimer->stopTimer();
    //COM_errorLog("Show Topic Display Time1: $intervalTime");

    if (!class_exists('StringParser') ) {
        require_once $CONF_FORUM['path_include'] . 'bbcode/stringparser_bbcode.class.php';
    }

    $topictemplate = COM_newTemplate($CONF_FORUM['path_layout'] . 'forum/layout');
    $topictemplate->set_file (array (
            'topictemplate' =>  'topic.thtml',
            'profile'       =>  'links/profile.thtml',
            'pm'            =>  'links/pm.thtml',
            'email'         =>  'links/email.thtml',
            'website'       =>  'links/website.thtml',
            'quote'         =>  'links/quotetopic.thtml',
            'edit'          =>  'links/edittopic.thtml'));

    // if preview, only stripslashes is gpc=on, else assume from db so strip        
    if ( $mode == 'preview' ) {
        $showtopic['subject'] = COM_stripslashes($showtopic['subject']);
    } else {
        $showtopic['subject'] = stripslashes($showtopic['subject']);
    }

    $min_height = 50;     // Base minimum  height of topic - will increase if avatar or sig is used
    $date = strftime( $CONF_FORUM['default_Topic_Datetime_format'], $showtopic['date'] );

    $userQuery = DB_query("SELECT * FROM {$_TABLES['users']} WHERE uid='{$showtopic['uid']}'");
    if ($showtopic['uid'] > 1 AND DB_numRows($userQuery) == 1) {
        $userarray = DB_fetchArray($userQuery);
        $username = COM_getDisplayName($showtopic['uid']);
        $userlink = "<a href=\"{$_CONF['site_url']}/users.php?mode=profile&amp;uid={$showtopic['uid']}\" ";
        $userlink .= "class=\"authorname {$onetwo}\"><b>{$username}</b></a>";
        $uservalid = true;
        $postcount = DB_query("SELECT * FROM {$_TABLES['forum_topic']} WHERE uid='{$showtopic['uid']}'");
        $posts = DB_numRows($postcount);
        // STARS CODE
        if (SEC_inGroup(1,$showtopic['uid'])) {
            $user_level = showrank(7, $LANG_GF01['admin']);
            $user_levelname=$LANG_GF01['admin'];
        } else if (forum_modPermission($showtopic['forum'],$showtopic['uid'])) {
            $user_level = showrank(6, $LANG_GF01['moderator']);
            $user_levelname=$LANG_GF01['moderator'];
        } else {
            if ($posts < $CONF_FORUM['level2']) {
                $user_level = showrank(1, $CONF_FORUM['level1name']);
                $user_levelname = $CONF_FORUM['level1name'];
            } elseif (($posts >= $CONF_FORUM['level2']) && ($posts < $CONF_FORUM['level3'])){
                $user_level = showrank(2, $CONF_FORUM['level2name']);
                $user_levelname = $CONF_FORUM['level2name'];
            } elseif (($posts >= $CONF_FORUM['level3']) && ($posts < $CONF_FORUM['level4'])){
                $user_level = showrank(3, $CONF_FORUM['level3name']);
                $user_levelname = $CONF_FORUM['level3name'];
            } elseif (($posts >= $CONF_FORUM['level4']) && ($posts < $CONF_FORUM['level5'])){
                $user_level = showrank(4, $CONF_FORUM['level4name']);
                $user_levelname = $CONF_FORUM['level4name'];
            } elseif (($posts > $CONF_FORUM['level5'])){
                $user_level = showrank(5, $CONF_FORUM['level5name']);
                $user_levelname = $CONF_FORUM['level5name'];
            }
        }

        if ($userarray['photo'] != "") {
            $avatar = USER_getPhoto($showtopic['uid'],'','',$CONF_FORUM['avatar_width']);
            $min_height = $min_height + 50;
        } else {
			$avatar = '';
		}

        $regdate = $LANG_GF01['REGISTERED']. ': ' . strftime($_CONF['shortdate'],strtotime($userarray['regdate'])). '<br' . XHTML . '>';
        $numposts = $LANG_GF01['POSTS']. ': ' .$posts;
        if (DB_count( $_TABLES['sessions'], 'uid', $showtopic['uid']) > 0 AND DB_getItem($_TABLES['userprefs'],'showonline',"uid={$showtopic['uid']}") == 1) {
            $avatar .= '<br' . XHTML . '>' .$LANG_GF01['STATUS']. ' ' .$LANG_GF01['ONLINE'];
        } else {
            $avatar .= '<br' . XHTML . '>' .$LANG_GF01['STATUS']. ' ' .$LANG_GF01['OFFLINE'];
        }

        if ($userarray['sig'] != '') {
            $sig = '<hr size="1" style="width: 95%; color:black; text-align:left; margin-left:0; margin-bottom:0.5em; padding:0;" noshade' . XHTML . '>';
            $sig .= '<b>' .$userarray['sig']. '</b>';
            $min_height = $min_height + 30;
        } else {
			$sig = '';
		}


    } else {
        $uservalid = false;
        $userlink = '<b>' .$showtopic['name']. '</b>';
        $userlink = '<span style="font-size: 0.8em;">' .$LANG_GF01['ANON']. '</span>' .urldecode($showtopic['name']);
    }

    if ($CONF_FORUM['show_moods'] &&  $showtopic['mood'] != "") {
        $moodimage = '<img style="vertical-align:middle;" src="'.gf_getImage($showtopic['mood'],'moods') .'" title="'.$showtopic['mood'].'" alt="'.$showtopic['mood'].'"' . XHTML . '><br'. XHTML . '>';
        $min_height = $min_height + 30;
    } else {
		$moodimage = '';
	}


    //$intervalTime = $mytimer->stopTimer();
    //COM_errorLog("Show Topic Display Time3: $intervalTime");

    // Handle Pre ver 2.5 quoting and New Line Formatting - consider adding this to a migrate function
    if ($CONF_FORUM['pre2.5_mode']) {
        // try to determine if we have an old post...
        if (strstr($showtopic['comment'],'<pre class="forumCode">') !== false)  $oldPost = 1;
        if (strstr($showtopic['comment'],"[code]<code>") !== false) $oldPost = 1;
        if (strstr($showtopic['comment'],"<pre>") !== false ) $oldPost = 1;

        if ( stristr($showtopic['comment'],'[code') == false || stristr($showtopic['comment'],'[code]<code>') == true) {
            if (strstr($showtopic['comment'],"<pre>") !== false)  $oldPost = 1;
            $showtopic['comment'] = str_replace('<pre>','[code]',$showtopic['comment']);
            $showtopic['comment'] = str_replace('</pre>','[/code]',$showtopic['comment']);
        }
        $showtopic['comment'] = str_ireplace("[code]<code>",'[code]',$showtopic['comment']);
        $showtopic['comment'] = str_ireplace("</code>[/code]",'[/code]',$showtopic['comment']);
        $showtopic['comment'] = str_replace(array("<br />\r\n","<br />\n\r","<br />\r","<br />\n","<br>\r\n","<br>\n\r","<br>\r","<br>\n"), '<br' . XHTML . '>', $showtopic['comment'] );
        $showtopic['comment'] = preg_replace("/\[QUOTE\sBY=\s(.+?)\]/i","[QUOTE] Quote by $1:",$showtopic['comment']);
        /* Reformat code blocks - version 2.3.3 and prior */
        $showtopic['comment'] = str_replace( '<pre class="forumCode">', '[code]', $showtopic['comment'] );
        $showtopic['comment'] = preg_replace("/\[QUOTE\sBY=(.+?)\]/i","[QUOTE] Quote by $1:",$showtopic['comment']);

        if ( $oldPost ) {
            if ( strstr($showtopic['comment'],"\\'") !== false ) {
                $showtopic['comment'] = stripslashes($showtopic['comment']);
            }
        }
    }

    $showtopic['comment'] = gf_formatTextBlock($showtopic['comment'],$showtopic['postmode'],$mode);
    $showtopic['subject'] = gf_formatTextBlock($showtopic['subject'],'text',$mode);

    if (strlen ($showtopic['subject']) > $CONF_FORUM['show_subject_length']) {
        $showtopic['subject'] = COM_truncate("$showtopic[subject]", $CONF_FORUM['show_subject_length'], '...');
    }

    //$intervalTime = $mytimer->stopTimer();
    //COM_errorLog("Show Topic Display Time2: $intervalTime");

    if ($mode != 'preview' && $uservalid && !COM_isAnonUser() && ($_USER['uid'] == $showtopic['uid'])) {
        /* Check if user can still edit this post - within allowed edit timeframe */
        $editAllowed = false;
        if ($CONF_FORUM['allowed_editwindow'] > 0) {
            $t1 = $showtopic['date'];
            $t2 = $CONF_FORUM['allowed_editwindow'];
            if ((time() - $t2) < $t1) {
                $editAllowed = true;
            }
        } else {
            $editAllowed = true;
        }
        if ($editAllowed) {
            $editlink = "{$_CONF['site_url']}/forum/createtopic.php?method=edit&amp;forum={$showtopic['forum']}&amp;id={$showtopic['id']}&amp;editid={$showtopic['id']}&amp;page=$page";
            $editlinktext = $LANG_GF09['edit'];
            $topictemplate->set_var ('editlink', $editlink);
            $topictemplate->set_var ('editlinktext', $editlinktext);
            $topictemplate->set_var ('LANG_edit', $LANG_GF01['EDITICON']);
            $topictemplate->parse ('edittopic_link', 'edit');
        }
    }

    if ($highlight != '') {
        $showtopic['subject'] = str_replace("$highlight","<span class=\"highlight\">$highlight</span>", $showtopic['subject']);
        $showtopic['comment'] = str_replace("$highlight","<span class=\"highlight\">$highlight</span>", $showtopic['comment']);
    }
	
	if (!isset($showtopic['pid'])) {
		$showtopic['pid'] = 0;
	}
	
    if ($showtopic['pid'] == 0) {
        $replytopicid = $showtopic['id'];
        $is_lockedtopic = $showtopic['locked'];
        $views = $showtopic['views'];
        $topictemplate->set_var ('read_msg', sprintf($LANG_GF02['msg49'],$views) );
        if ($is_lockedtopic) {
            $topictemplate->set_var('locked_icon','<img src="'.gf_getImage('padlock').'" title="'.$LANG_GF02['msg114'].'"' . XHTML . '>');
        }
    } else {
        $replytopicid = $showtopic['pid'];
        $is_lockedtopic = DB_getItem($_TABLES['forum_topic'],'locked', "id={$showtopic['pid']}");
        $topictemplate->set_var ('read_msg','');
    }

    if ($CONF_FORUM['allow_user_dateformat']) {
        $date = COM_getUserDateTimeFormat($showtopic['date']);
        $topictemplate->set_var ('posted_date', $date[0]);
    } else {
        $date = strftime( $CONF_FORUM['default_Topic_Datetime_format'], $showtopic['date'] );
        $topictemplate->set_var ('posted_date', $date);
    }

    if ($mode != 'preview') {
        if ($is_lockedtopic == 0) {
            $is_readonly = DB_getItem($_TABLES['forum_forums'],'is_readonly','forum_id=' . $showtopic['forum']);
            if ($is_readonly == 0 OR forum_modPermission($showtopic['forum'],$_USER['uid'],'mod_edit')) {
                $quotelink = "{$_CONF['site_url']}/forum/createtopic.php?method=postreply&amp;forum={$showtopic['forum']}&amp;id=$replytopicid&amp;quoteid={$showtopic['id']}";
                $quotelinktext = '<img style="margin: 0 0.5em 0.1em 0;" src="'.gf_getImage('quotes').'" alt=""' . XHTML . '>&nbsp;' . $LANG_GF09['quote'];
                $topictemplate->set_var ('quotelink', $quotelink);
                $topictemplate->set_var ('quotelinktext', $quotelinktext);
                $topictemplate->set_var ('LANG_quote', $LANG_GF01['QUOTEICON']);
                $topictemplate->parse ('quotetopic_link', 'quote');
            }
        }

        $topictemplate->set_var ('topic_post_link_begin', '<a name="'.$showtopic['id'].'">');
//      $topictemplate->set_var ('topic_post_link_begin', '<a id="post_'.$showtopic['id'].'" name="post_'.$showtopic['id'].'">'); // Probably this cord is more desirable
        $topictemplate->set_var ('topic_post_link_end', '</a>');

        $mod_functions = forum_getmodFunctions($showtopic);
        if ($showtopic['uid'] > 1 && $uservalid) {
            $profile_link = "{$_CONF['site_url']}/users.php?mode=profile&amp;uid={$showtopic['uid']}";
            $profile_linktext = $LANG_GF09['profile'];
            $topictemplate->set_var ('profilelink', $profile_link);
            $topictemplate->set_var ('profilelinktext', $profile_linktext);
            $topictemplate->set_var ('LANG_profile',$LANG_GF01['ProfileLink']);
            $topictemplate->parse ('profile_link', 'profile');
            if ($CONF_FORUM['use_pm_plugin']) {
                $pmusernmame = COM_getDisplayName($showtopic['uid']);
                $pmplugin_link = forumPLG_getPMlink($pmusernmame);
                if ($pmplugin_link != '') {
                    $pm_link = $pmplugin_link;
                    $pm_linktext = $LANG_GF09['pm'];
                    $topictemplate->set_var ('pmlink', $pm_link);
                    $topictemplate->set_var ('pmlinktext', $pm_linktext);
                    $topictemplate->set_var ('LANG_pm', $LANG_GF01['PMLink']);
                    $topictemplate->parse ('pm_link', 'pm');
                }
            }
        }

        if ($userarray['email'] != '' && $showtopic["uid"] > 1) {
            $email_link = "{$_CONF['site_url']}/profiles.php?uid={$showtopic['uid']}";
            $email_linktext = $LANG_GF09['email'];
            $topictemplate->set_var ('emaillink', $email_link);
            $topictemplate->set_var ('emaillinktext', $email_linktext);
            $topictemplate->set_var ('LANG_email', $LANG_GF01['EmailLink']);
            $topictemplate->parse ('email_link', 'email');
        }
        if ($userarray['homepage'] != '') {
            $homepage = trim($userarray['homepage']);
            if (strtolower(substr($homepage, 0, 4)) != 'http') {
                $homepage = 'http://' .$homepage;
            }
            $homepagetext = $LANG_GF09['website'];
            $topictemplate->set_var ('websitelink', $homepage);
            $topictemplate->set_var ('websitelinktext', $homepagetext);
            $topictemplate->set_var ('LANG_website', $LANG_GF01['WebsiteLink']);
            $topictemplate->parse ('website_link', 'website');
        }

        if ($fromblock != "") {
            $back2 = $LANG_GF01['back2parent'];
        } else {
            $back2 = $LANG_GF01['back2top'];
        }
        $backlink = '<center><a href="' . $_CONF['site_url'] . '/forum/viewtopic.php?showtopic=' . $replytopicid. '">' .$back2. '</a></center>';
    } else {
        if (isset($_GET['onlytopic']) AND $_GET['onlytopic'] != 1) {
            $topictemplate->set_var ('posted_date', '');
            $topictemplate->set_var ('preview_topic_subject', $showtopic['subject']);
        } else {
            $topictemplate->set_var ('preview_topic_subject', '');
        }
        $topictemplate->set_var ('read_msg', '');
        $topictemplate->set_var ('locked_icon', '');

        $topictemplate->set_var ('preview_mode', 'none');
		$backlink = '';
    }

    //$intervalTime = $mytimer->stopTimer();
    //COM_errorLog("Show Topic Display Time4: $intervalTime");

    $showtopic['comment'] = str_replace('{','&#123;',$showtopic['comment']);
    $showtopic['comment'] = str_replace('}','&#125;',$showtopic['comment']);

    // Temporary correspondence. You should cope in more roots.
    $showtopic['comment'] = str_replace(array("<br />","<br>"), '<br' . XHTML . '>', $showtopic['comment'] );
	$mod_functions = forum_getmodFunctions($showtopic);

    $topictemplate->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $topictemplate->set_var ('csscode', $onetwo);
    $topictemplate->set_var ('postmode', $showtopic['postmode']);
    $topictemplate->set_var ('userlink', $userlink);
    $topictemplate->set_var ('lang_forum', $LANG_GF01['FORUM']);
    $topictemplate->set_var ('user_levelname', $user_levelname);
    $topictemplate->set_var ('user_level', $user_level);
    $topictemplate->set_var ('magical_image', $moodimage);
    $topictemplate->set_var ('avatar', $avatar);
    $topictemplate->set_var ('regdate', $regdate);
    $topictemplate->set_var ('numposts', $numposts);
//    $topictemplate->set_var ('location', $location);
    $topictemplate->set_var ('imgset', $CONF_FORUM['imgset']);
    $topictemplate->set_var ('topic_subject', $showtopic['subject']);
    $topictemplate->set_var ('LANG_ON2', $LANG_GF01['ON2']);
    $topictemplate->set_var ('mod_functions', $mod_functions);
    $topictemplate->set_var ('topic_comment', $showtopic['comment']);
    $topictemplate->set_var ('comment_minheight', "min-height:{$min_height}px");
    if (trim($sig) != '') {
        $topictemplate->set_var ('sig', PLG_replaceTags(($sig)));
        $topictemplate->set_var ('show_sig', '');
    } else {
        $topictemplate->set_var ('sig', '');
        $topictemplate->set_var ('show_sig', 'none');
    }
    $topictemplate->set_var ('forumid', $showtopic['forum']);
    $topictemplate->set_var ('topic_id', $showtopic['id']);
    $topictemplate->set_var ('back_link', $backlink);
    $topictemplate->set_var ('member_badge',forumPLG_getMemberBadge($showtopic['uid']));
    $topictemplate->parse ('output', 'topictemplate');
    $retval = $topictemplate->finish ($topictemplate->get_var('output'));

    //$intervalTime = $mytimer->stopTimer();
    //COM_errorLog("Show Topic Display Time5: $intervalTime");

    return $retval;
}

function forum_getmodFunctions($showtopic) {
    global $_USER,$_CONF,$_TABLES,$LANG_GF03,$LANG_GF01,$page;

    $retval = '';
    $options = '';
	
	if (COM_isAnonUser()) {
		return $retval;
	}
	
    if (forum_modPermission($showtopic['forum'],$_USER['uid'],'mod_edit')) {
        $options .= '<option value="editpost">' .$LANG_GF03['edit']. '</option>';
        if ($showtopic['locked'] == 1) {
            $options .= '<option value="lockedpost">' .$LANG_GF03['lockedpost']. '</option>';
        }
    }
    if (forum_modPermission($showtopic['forum'],$_USER['uid'],'mod_delete')) {
        $options .= '<option value="deletepost">' .$LANG_GF03['delete']. '</option>';
    }
    if (forum_modPermission($showtopic['forum'],$_USER['uid'],'mod_ban')) {
        $options .= '<option value="banip">' .$LANG_GF03['ban']. '</option>';
    }
    if ($showtopic['pid'] == 0) {
        if (forum_modPermission($showtopic['forum'],$_USER['uid'],'mod_move')) {
            $options .= '<option value="movetopic">' .$LANG_GF03['move']. '</option>';
        }
    } elseif (forum_modPermission($showtopic['forum'],$_USER['uid'],'mod_move')) {
        $options .= '<option value="movetopic">' .$LANG_GF03['split']. '</option>';
    }

    if ($options != '') {
        $retval .= '<form action="'.$_CONF['site_url'].'/forum/moderation.php" method="post" style="margin:0px;"><div><select name="modfunction">';
        $retval .= $options;

        if ($showtopic['pid'] == 0) {
            $msgpid = $showtopic['id'];
            $top = "yes";
        } else {
            $msgpid = $showtopic['pid'];
            $top = "no";
        }
        $retval .= '</select>&nbsp;&nbsp;';
        $retval .= '<input type="submit" name="submit" value="' .$LANG_GF01['GO'].'!"' . XHTML . '>';
        $retval .= '<input type="hidden" name="fortopicid" value="' .$showtopic['id']. '"' . XHTML . '>';
        $retval .= '<input type="hidden" name="forum" value="' .$showtopic['forum']. '"' . XHTML . '>';
        $retval .= '<input type="hidden" name="msgpid" value="' .$msgpid. '"' . XHTML . '>';
        $retval .= '<input type="hidden" name="top" value="' .$top. '"' . XHTML . '>';
        $retval .= '<input type="hidden" name="page" value="' .$page. '"' . XHTML . '>';
        $retval .= '</div></form>';
    }
    return $retval;
}


function gf_chkpostmode($postmode,$postmode_switch) {
    global $_TABLES,$CONF_FORUM;

    if ($postmode == "") {
        if ($CONF_FORUM['allow_html']) {
            $postmode = 'html';
        } else {
            $postmode = 'text';
        }
    } else {
        if ($postmode_switch) {
            if ($postmode == 'html') {
                $postmode = 'text';
            } else {
                $postmode = 'html';
            }
            $postmode_switch = 0;
        }
    }
    return $postmode;
}
?>
