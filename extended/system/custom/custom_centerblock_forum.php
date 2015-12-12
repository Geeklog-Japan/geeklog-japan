<?php
/**
* Display latest forum posts in the center block.
*
* @param   where   int      where the block will be displayed (0..2)
* @param   page    int      page number
* @param   topic   string   topic ID
* @return          string   HTML for the center blcok (can be empty)
*/
function CUSTOM_centerblock_forum ($limit='')
{
    global $_CONF, $_USER, $_TABLES, $LANG_GF01, $CONF_FORUM;
    global $LANG_GF02, $mode, $order;

    //$TIMER = new timerobject();
    //$TIMER->startTimer();
    //$exectime = $TIMER->stopTimer();

    if ($CONF_FORUM['installed_version'] < 2.6) {
        return;
    }

    if ($CONF_FORUM['registration_required'] && $_USER['uid'] < 2) {
        return;
    }

    $retval = '';

    $cb_enable = $CONF_FORUM['show_centerblock'];
    $cb_where  = $CONF_FORUM['centerblock_where'];

    // If enabled only for homepage and this is not page 1 or a topic page,
    // then set disable flag
    if ($CONF_FORUM['centerblock_homepage'] == 1 AND ($page > 1 OR !empty ($topic))) {
        $cb_enable = 0;
    } elseif ($CONF_FORUM['centerblock_homepage'] == 0 and $page > 1) {
        $cb_where = 1;      // Top of Page
    }

    // Check if there are no featured articles in this topic
    // and if so then place it at the top of the page
    if (!empty ($topic)) {
        $fromsql = ", {$_TABLES['topic_assignments']} ta";
        $wheresql = "WHERE ta.id = sid AND ta.tid='$topic' AND featured > 0";
    } else {
        $fromsql = '';
        $wheresql = 'WHERE featured = 1';
    }
    $query = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} $fromsql $wheresql");
    $result = DB_fetchArray ($query);
    if ($result['count'] == 0 and $cb_where == 2) {
        $cb_where = 1;
    }

     $block = new Template ($_CONF['path'] . 'system/custom/forum');



    $block->set_file (array ('block' => 'centerblock.thtml','record' => 'centerblock_displayline.thtml'));
    $block->set_var ('xhtml', XHTML);
    $block->set_var ('phpself', $_CONF['site_url'] .'/index.php');
    $block->set_var ('startblock', COM_startBlock($LANG_GF02['msg170']));
    $block->set_var ('endblock', COM_endBlock());
    $block->set_var ('site_url', $_CONF['site_url']);
    $block->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $block->set_var ('LANG_title', $LANG_GF02['msg170']);
    $block->set_var ('LANG_FORUM', $LANG_GF01['FORUM']);
    $block->set_var ('LANG_TOPIC', $LANG_GF01['TOPIC']);
    $block->set_var ('LANG_LASTPOST', $LANG_GF01['LASTPOST']);
    $block->set_var ('LANG_viewlastpost', $LANG_GF02['msg160']);
    $block->set_var ('LANG_forumjump', $LANG_GF02['msg195']);

    $groups = array ();
    $usergroups = SEC_getUserGroups();
    foreach ($usergroups as $group) {
        $groups[] = $group;
    }
    $grouplist = implode(',',$groups);

    if ($limit != '') $CONF_FORUM['centerblock_numposts'] = $limit;
    
        $sql  = "SELECT a.id, a.forum, a.name, a.date, a.lastupdated, a.last_reply_rec, a.subject, ";

    $sql .= "a.comment, a.uid, a.name, a.pid, a.replies, a.views, b.forum_name  ";
    $sql .= "FROM {$_TABLES['forum_topic']} a ";
    $sql .= "LEFT JOIN {$_TABLES['forum_forums']} b ON a.forum=b.forum_id ";
    $sql .= "WHERE pid=0 AND b.grp_id IN ($grouplist) AND b.no_newposts = 0 ";
    $sql .= "ORDER BY lastupdated DESC LIMIT {$CONF_FORUM['centerblock_numposts']}";
    $result = DB_query ($sql);

    if (DB_numRows($result) == 0) {
        return;
    }

    $f_tooltip = function_exists('COM_getTooltip');
    $cssid = 0;
    while ($A = DB_fetchArray ($result)) {
//        $fullsubject = "{$A['subject']}\n{$LANG_GF01['POSTEDBY']}:{$A['name']}{$LANG_GF01['VIEWS']}:{$A['views']}, {$LANG_GF01['REPLIES']}:{$A['replies']}";

        $fullsubject = "{$LANG_GF01['POSTEDBY']}:{$A['name']}{$LANG_GF01['VIEWS']}:{$A['views']}";

        if (strlen ($A['subject']) > $CONF_FORUM['cb_subject_size']) {
            $A['subject'] = COM_truncate($A['subject'], $CONF_FORUM['cb_subject_size'], '...');
        }

        if ($CONF_FORUM['allow_user_dateformat']) {
            $firstdate = COM_getUserDateTimeFormat ($A['date']);
            $firstdate = $firstdate[0];
            $lastdate = COM_getUserDateTimeFormat ($A['lastupdated']);
            $lastdate = $lastdate[0];
        } else {
            $firstdate = strftime($CONF_FORUM['default_Datetime_format'], $A['date']);
            $lastdate = strftime($CONF_FORUM['default_Datetime_format'], $A['lastupdated']);
        }
        if ($A['uid'] > 1) {
            $topicinfo = COM_getDisplayName($A['uid']) ;
            //$topicinfo .= sprintf($LANG_GF01['LASTREPLYBY'],COM_getDisplayName($A['uid']));
        } else {
            $topicinfo = "{$A['name']}";
        }

//        $topicinfo .= "{$firstdate} " . " {$LANG_GF01['VIEWS']}:{$A['views']}, {$LANG_GF01['REPLIES']}:{$A['replies']}</span>";
//        $topicinfo .= "{$firstdate} " . " {$LANG_GF01['VIEWS']}:{$A['views']}"."</span>";

        if (empty ($A['last_reply_rec']) OR $A['last_reply_rec'] < 1) {
            $lastid = $A['id'];
            $lastcomment = $A['comment'];
        } else {
            $qlreply = DB_query("SELECT id,uid,name,comment FROM {$_TABLES['forum_topic']} WHERE id={$A['last_reply_rec']}");
            $B = DB_fetchArray($qlreply);
            $lastid = $B['id'];
            $lastcomment = $B['comment'];
            if ($B['uid'] > 1) {
	          $lastpostuser = sprintf("%s",COM_getDisplayName($B['uid']));
            } else {
	          $lastpostuser = sprintf("%s",$B['name']);
            }
        }
        $lastpostinfo = strip_tags(COM_truncate($lastcomment, $CONF_FORUM['contentinfo_numchars'], '...'));
        $lastpostinfo = str_replace(LB, "<br" . XHTML . ">", forum_mb_wordwrap($lastpostinfo, $CONF_FORUM['linkinfo_width'], LB));

        $cssid = ($cssid == 1) ? 2 : 1;
$f_tooltip=0;
        if ($f_tooltip) {
            $lastpostlink = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}&amp;lastpost=true#{$lastid}";
            $block->set_var ('tooltip_date', COM_getTooltip($lastdate, $lastpostinfo, $lastpostlink));
            $topiclink = "{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}";
            $block->set_var ('tooltip_topic_subject', COM_getTooltip($A['subject'], $topicinfo, $topiclink));
        } else {
            $block->set_var ('lastpostinfo', $lastpostinfo);
            $block->set_var ('topicinfo', $topicinfo);
            $block->set_var ('date', $firstdate);
            $block->set_var ('lastdate', $lastdate);
            $block->set_var ('topic_subject', $A['subject']);
        }

        $block->set_var ('lastpostuser', $lastpostuser);



        $block->set_var ('lastpostid', $lastid);
        $block->set_var ('cssid', $cssid);
        $block->set_var ('img_dir', $CONF_FORUM['imgset']);
        $block->set_var ('forum_id', $A['forum']);
        $block->set_var ('forum_name', $A['forum_name']);
        $block->set_var ('topic_id', $A['id']);
        $block->set_var ('fullsubject', $fullsubject);
        $block->set_var ('views', $A['views']);
        $block->set_var ('replies', $A['replies']);
        $block->set_var ('posts', $A['replies']+1);
        $block->set_var ('lastpostby',$A['name']);
        $block->parse ('block_records', 'record',true);
    }

    $block->parse ('output', 'block');
    $retval .= $block->finish ($block->get_var ('output'));

    //$exectime = $TIMER->stopTimer();
    //COM_errorLog("Centerblock Execution Time: $exectime seconds");

    return $retval;
}
