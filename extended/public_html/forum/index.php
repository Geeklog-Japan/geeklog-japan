<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// | Main program to view forum                                                |
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

require_once '../lib-common.php'; // Path to your lib-common.php

if (!in_array('forum', $_PLUGINS)) {
    COM_handle404();
    exit;
}

require_once $CONF_FORUM['path_include'] . 'gf_format.php';

// Pass thru filter any get or post variables to only allow numeric values and remove any hostile data
$op        = isset($_REQUEST['op'])        ? COM_applyFilter($_REQUEST['op'])          : '';
$msg       = isset($_GET['msg'])           ? COM_applyFilter($_GET['msg'])             : '';
$show      = isset($_REQUEST['show'])      ? COM_applyFilter($_REQUEST['show'],true)   : '';
$page      = isset($_REQUEST['page'])      ? COM_applyFilter($_REQUEST['page'],true)   : '';
$sort      = isset($_REQUEST['sort'])      ? COM_applyFilter($_REQUEST['sort'],true)   : '';
$order     = isset($_REQUEST['order'])     ? COM_applyFilter($_REQUEST['order'],true)  : '';
$query     = isset($_REQUEST['query'])     ? addslashes(strip_tags(COM_stripslashes($_REQUEST['query']))) : '';
$forum     = isset($_REQUEST['forum'])     ? COM_applyFilter($_REQUEST['forum'],true)  : '';
$cat_id    = isset($_REQUEST['cat_id'])    ? COM_applyFilter($_REQUEST['cat_id'],true) : ''; // Used by marking posts read by category
$category  = isset($_REQUEST['category'])  ? COM_applyFilter($_REQUEST['category'],true) : ''; // Used for display category forum index
$populartype = isset($_REQUEST['populartype']) ? COM_applyFilter($_REQUEST['populartype']) : '';

$display = '';

//Check is anonymous users can access - and need to be signed in
forum_chkUsercanAccess();

$todaysdate = date($_CONF['shortdate']);

// Check to see if request to mark all topics read was requested
if (!COM_isAnonUser() && $op == 'markallread') {
    $now = time();
    $categories = array();
    if ($cat_id == 0) {
        $csql = DB_query("SELECT id FROM {$_TABLES['forum_categories']} ORDER BY id");
        while (list ($categoryID) = DB_fetchArray($csql)) {
            $categories[] = $categoryID;
        }
    } else {
        $categories[] = $cat_id;
    }

    foreach ($categories as $category) {
        $fsql = DB_query("SELECT forum_id,grp_id FROM {$_TABLES['forum_forums']} WHERE forum_cat=$category");
        while ($frecord = DB_fetchArray($fsql)) {
            $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='{$frecord['grp_id']}'");
            if (SEC_inGroup($groupname)) {
                DB_query("DELETE FROM {$_TABLES['forum_log']} WHERE uid={$_USER['uid']} AND forum={$frecord['forum_id']}");
                $tsql = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE forum={$frecord['forum_id']} AND pid=0");
                while($trecord = DB_fetchArray($tsql)){
                    $log_sql = DB_query("SELECT * FROM {$_TABLES['forum_log']} WHERE uid={$_USER['uid']} AND topic={$trecord['id']} AND forum={$frecord['forum_id']}");
                    if (DB_numRows($log_sql) == 0) {
                        DB_query("INSERT INTO {$_TABLES['forum_log']} (uid,forum,topic,time) VALUES ('{$_USER['uid']}','{$frecord['forum_id']}','{$trecord['id']}','$now')");
                    }
                }
            }
        }
    }
    echo COM_refresh($_CONF['site_url'] .'/forum/index.php');
    exit();
}

//Check if anonymous users allowed to access forum
forum_chkUsercanAccess();

// Debug Code to show variables
$display .= gf_showVariables();

if ($msg==1) {
    $display .= COM_showMessageText($LANG_GF02['msg134'] . "<br" . XHTML . ">" . $LANG_GF02['msg135']);
}
if ($msg==2) {
    $display .= COM_showMessageText($LANG_GF02['msg166']);
}
if ($msg==3) {
    $display .= COM_showMessageText($LANG_GF02['msg55']);
}

if ($msg==9) {
	// Forum Post Canceld
	$display .= COM_showMessageText($LANG_GF02['msg149']);
}

// Check if this is the first page.
if ($page == 0) {
    $page = 1;
}

if ($op == 'newposts' AND !COM_isAnonUser()) {
	// Check if the number of records was specified to show - part of page navigation.
	if ($show == 0 AND $CONF_FORUM['show_newposts_perpage'] > 0) {
		$show = $CONF_FORUM['show_newposts_perpage'];
	} elseif ($show == 0) {
		$show = 20;
	}	
    $report = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $report->set_file (array (
                    'report'         => 'reports/report_results.thtml',
                    'forum_icons'    => 'forum_icons.thtml', 
                    'forum_links'    => 'forum_links.thtml'));                    

    $report->set_block('report', 'report_record');
    $report->set_block('report', 'title');
    $report->set_block('report', 'links');
    $report->set_block('report', 'no_records_message');
    $report->set_block('forum_links', 'return_link');
    $report->set_block('forum_links', 'returnmarkread_link');
    
    $blocks = array('sort_desc', 'sort_desc_on', 'sort_asc', 'sort_asc_on');
    foreach ($blocks as $block) {
        $report->set_block('forum_icons', $block);
    }
	
    $report->parse ('img_asc1', 'sort_asc');
    $report->parse ('img_asc2', 'sort_asc');
    $report->parse ('img_asc3', 'sort_asc');
    $report->parse ('img_asc4', 'sort_asc');
    $report->parse ('img_desc1', 'sort_desc');
    $report->parse ('img_desc2', 'sort_desc');
    $report->parse ('img_desc3', 'sort_desc');
    $report->parse ('img_desc4', 'sort_desc');
    
    switch($sort) {
        case 1:
        	$orderby = 'subject';
            break;
        case 2:
        	$orderby = 'replies';
            break;
        case 3:
        	$orderby = 'views';
            break;
        case 4:
        	$orderby = 'date';
            break;            
        default:
        	$sort = 4;
        	$order = 1;
        	$orderby = 'date';
            break;
    }
	if ($order == 0) {
		$sortOrder = "$orderby ASC";
		$report->parse ("img_asc$sort", 'sort_asc_on');
	} else {
		$sortOrder = "$orderby DESC";
		$report->parse ("img_desc$sort", 'sort_desc_on');
	}    
	
	$base_url .= "&amp;order=$order&amp;sort=$sort&amp;populartype=$populartype"; 

    $report->set_var ('imgset', $CONF_FORUM['imgset']);
    $report->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $report->set_var ('phpself',$_CONF['site_url'] . '/forum/index.php?op=newposts');
	$report->set_var('report_title', $LANG_GF02['msg111']);
    $report->parse('title', 'title');
    
    $report->set_var ('LANG_returnmarkread', $LANG_GF02['msg164']);
    $report->set_var ('returnmarkreadlink', $_CONF['site_url'] .'/forum/index.php?op=markallread');
	$report->parse ('link2','returnmarkread_link');    
    
	$report->set_var ('LANG_return', $LANG_GF02['msg175']);
	if ($forum > 0) {
    	$report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php?forum=$forum");
	} else {
		$report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php");
	}
	$report->parse ('link1','return_link');
    
	$report->parse ('links','links');
    
    $report->set_var ('spacerwidth', '40%');
    
    if ($CONF_FORUM['usermenu'] == 'navbar') {
        $report->set_var('navmenu', forumNavbarMenu());
    } else {
        $report->set_var('navmenu','');
    }

    $report->set_var ('LANG_Heading1', $LANG_GF01['SUBJECT']);
    $report->set_var ('LANG_Heading2', $LANG_GF01['REPLIES']);
    $report->set_var ('LANG_Heading3', $LANG_GF01['VIEWS']);
    $report->set_var ('LANG_Heading4', $LANG_GF01['DATE']);

    if ($forum > 0) {
        $inforum = "AND ft.forum = '$forum'";
    } else {
        $inforum = "";
    }
    
    $grouplist = implode (',', $_GROUPS);    
    $grouplist = " AND (ff.grp_id IN ($grouplist))";
    
    $sql  = "SELECT ft.id 
    		FROM {$_TABLES['forum_topic']} ft
    		JOIN {$_TABLES['forum_forums']} ff ON ft.forum = ff.forum_id 
    		LEFT JOIN {$_TABLES['forum_log']} fl ON fl.topic = ft.id AND fl.uid={$_USER['uid']}
			WHERE ft.pid = 0  
			AND ((ft.lastupdated > fl.time) OR ISNULL(fl.time)) 
    		$grouplist $inforum";	
    
	$result = DB_query($sql);
	$topicCount = DB_numRows($result);
	$numpages = ceil($topicCount / $show);
	if ($numpages == 0) {
		$numpages = 1;
	}
	$offset = ($page - 1) * $show;
	$base_url = "{$_CONF['site_url']}/forum/index.php?op=newposts&amp;show=$show";
	if ($forum > 0) {
		$base_url .= "&amp;order=$order&amp;sort=$sort&amp;forum=$forum";  	
		$report->set_var ('sort_url_extra', "&amp;forum=$forum");
	} else {
		$base_url .= "&amp;order=$order&amp;sort=$sort";  	
		$report->set_var ('sort_url_extra', "");
	}	
	// Check to see if requesting a page that does not exist
	if ($page > $numpages) {
		COM_handle404($base_url);    
	}    
    
	$sql = "SELECT ft.lastupdated, ft.subject, ft.comment, ft.replies, ft.views, ft.id, ft.forum 
    		FROM {$_TABLES['forum_topic']} ft
    		JOIN {$_TABLES['forum_forums']} ff ON ft.forum = ff.forum_id 
    		LEFT JOIN {$_TABLES['forum_log']} fl ON fl.topic = ft.id AND fl.uid={$_USER['uid']}
			WHERE ft.pid = 0  
			AND ((ft.lastupdated > fl.time) OR ISNULL(fl.time)) 
    		$grouplist $inforum";	
    
	/* Un-comment if you want users to see new posts since last login only */
    //$lastlogin = DB_getItem($_TABLES['userinfo'],'lastlogin',"uid='" . $_USER['uid'] ."'");
    //$sql .= "AND lastupdated > {$lastlogin} ";
    $sql .= " ORDER BY $sortOrder, id DESC LIMIT $offset, $show";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    $csscode = 1;
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $P = DB_fetchArray($result);

			$link = "<a href=\"{$_CONF['site_url']}/forum/viewtopic.php?forum={$P['forum']}&amp;showtopic={$P['id']}\">";
			$report->set_var('post_start_ahref', $link);
			$report->set_var('post_subject', $P['subject']);
			$report->set_var('csscode', $csscode);
			$report->set_var('post_end_ahref', '</a>');
            $postdate = COM_getUserDateTimeFormat($P['lastupdated']);
			$report->set_var('post_date',$postdate[0]);
			$report->set_var('post_replies', $P['replies']);
			$report->set_var('post_views', $P['views']);
			$report->parse ('report_record', 'report_record',true);
			if ($csscode == 2) {
				$csscode = 1;
			} else {
				$csscode++;
			}
        }
    } else {
        $report->set_var ('message', $LANG_GF02['msg202']);
        $report->parse ('no_records_message', 'no_records_message');
    }
        
    $report->set_var ('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));

    $report->parse ('output', 'report');
    $display .= $report->finish ($report->get_var('output'));
    $title = $LANG_GF01['NEWFORUMPOSTS'];
    $display = gf_createHTMLDocument($display, $title);
    COM_output($display);
    exit();
}

if ($op == 'search') {
	// Figure out page stuff
	// Check if the number of records was specified to show - part of page navigation.
	if ($show == 0 AND $CONF_FORUM['show_search_perpage'] > 0) {
		$show = $CONF_FORUM['show_search_perpage'];
	} elseif ($show == 0) {
		$show = 20;
	}
	
    $report = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $report->set_file (array (
                    'report'         => 'reports/report_results.thtml',
                    'forum_icons'    => 'forum_icons.thtml', 
                    'forum_links'    => 'forum_links.thtml'));                    

	$report->set_block('report', 'report_record');
	$report->set_block('report', 'title');
	$report->set_block('report', 'links');
	$report->set_block('report', 'no_records_message');
	$report->set_block('forum_links', 'return_link');

    $blocks = array('sort_desc', 'sort_desc_on', 'sort_asc', 'sort_asc_on');
    foreach ($blocks as $block) {
        $report->set_block('forum_icons', $block);
    }
	
    $report->parse ('img_asc1', 'sort_asc');
    $report->parse ('img_asc2', 'sort_asc');
    $report->parse ('img_asc3', 'sort_asc');
    $report->parse ('img_asc4', 'sort_asc');
    $report->parse ('img_desc1', 'sort_desc');
    $report->parse ('img_desc2', 'sort_desc');
    $report->parse ('img_desc3', 'sort_desc');
    $report->parse ('img_desc4', 'sort_desc');
    
    switch($sort) {
        case 1:
        	$orderby = 'subject';
            break;
        case 2:
        	$orderby = 'replies';
            break;
        case 3:
        	$orderby = 'views';
            break;
        case 4:
        	$orderby = 'lastupdated';
            break;            
        default:
        	$sort = 4;
        	$order = 1;
        	$orderby = 'lastupdated';
            break;
    }
	if ($order == 0) {
		$sortOrder = "$orderby ASC";
		$report->parse ("img_asc$sort", 'sort_asc_on');
	} else {
		$sortOrder = "$orderby DESC";
		$report->parse ("img_desc$sort", 'sort_desc_on');
	}

	if ($forum > 0) {
		$base_url = "&amp;order=$order&amp;sort=$sort&amp;query=$query&amp;forum=$forum";  	
		$report->set_var ('sort_url_extra', "&amp;query=$query&amp;forum=$forum");
	} else {
		$base_url = "&amp;order=$order&amp;sort=$sort&amp;query=$query";  	
		$report->set_var ('sort_url_extra', "&amp;query=$query");
	}
    
	$title = sprintf($LANG_GF02['forumsearchfor'], $query);
	$report->set_var('report_title', $title);
	$report->parse('title', 'title');    

    $report->set_var ('imgset', $CONF_FORUM['imgset']);
    $report->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $report->set_var ('phpself',$_CONF['site_url'] . '/forum/index.php?op=search');
    $report->set_var ('spacerwidth', '70%');
    if ($forum > 0) {
    	$report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php?forum=$forum");
	} else {
		$report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php");
	}
    $report->set_var ('LANG_return', $LANG_GF02['msg175']);
    $report->parse ('link1','return_link');
    $report->parse ('links','links');

    $report->set_var ('LANG_Heading1', $LANG_GF01['SUBJECT']);
    $report->set_var ('LANG_Heading2', $LANG_GF01['REPLIES']);
    $report->set_var ('LANG_Heading3', $LANG_GF01['VIEWS']);
    $report->set_var ('LANG_Heading4', $LANG_GF01['DATE']);

    if ($CONF_FORUM['usermenu'] == 'navbar') {
        $report->set_var('navmenu', forumNavbarMenu());
    } else {
        $report->set_var('navmenu','');
    }

    if ($forum > 0) {
        $inforum = "AND (ft.forum = '$forum')";
    } else {
        $inforum = "";
    }
    
    $grouplist = implode (',', $_GROUPS);    
    $grouplist = " AND (ff.grp_id IN ($grouplist))";
    $sql  = "SELECT id FROM {$_TABLES['forum_topic']} ft, {$_TABLES['forum_forums']} ff
    		 WHERE ft.forum = ff.forum_id 
    		 $grouplist 
    		 AND ((subject LIKE '%$query%') OR (comment LIKE '%$query%')) $inforum";	
	$result = DB_query($sql);
	$topicCount = DB_numRows($result);
	$numpages = ceil($topicCount / $show);
	if ($numpages == 0) {
		$numpages = 1;
	}
	$offset = ($page - 1) * $show;
	$base_url = "{$_CONF['site_url']}/forum/index.php?op=search&amp;show=$show" . $base_url;
	// Check to see if requesting a page that does not exist
	if ($page > $numpages) {
		COM_handle404($base_url);    
	}	
	
    $sql  = "SELECT ft.* FROM {$_TABLES['forum_topic']} ft, {$_TABLES['forum_forums']} ff
    		 WHERE ft.forum = ff.forum_id
    		 $grouplist  
    		 AND ((subject LIKE '%$query%') OR (comment LIKE '%$query%')) $inforum ";
	$sql .= "ORDER BY $sortOrder, id DESC LIMIT $offset, $show";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $csscode = 1;
        for ($i = 1; $i <= $nrows; $i++) {
            $P = DB_fetchArray($result);
            
			// ***********************************************************************
			// Need to link to correct page etc.. and jump down to right post
			// A bit of a dog to figure out
			$jumppoint = "";
			$topicid = $P['id'];
			if ($P['pid'] == 0) {
				$topicparentid = $P['id'];
				
				$topicCount = $P['replies'];
			} else {
				$topicparentid = $P['pid'];
				$jumppoint = "#{$P['id']}";
				
				// Retrive Parent info
				$sql = "SELECT * FROM {$_TABLES['forum_topic']} WHERE id=$topicparentid";
				$result2  = DB_query($sql);	
				$P2 = DB_fetchArray($result2);
				
				$topicCount = $P2['replies'];
				$P['replies'] = $P2['replies'];
				$P['views'] = $P2['views'];
			}
			if ($CONF_FORUM['sort_order_asc']) {
				$order2 = 'ASC';
			} else {
				$order2 = 'DESC';
			}			
			if ($show2 == 0 AND $CONF_FORUM['show_topics_perpage'] > 0) {
				$show2 = $CONF_FORUM['show_topics_perpage'];
			} elseif ($show2 == 0) {
				$show2 = 20;
			}
			
			$pageurl = "";
			$showcount = 0;
			$pagecount = 1;
			$sql  = "(SELECT * FROM {$_TABLES['forum_topic']} WHERE id='$topicparentid') "
				  . "UNION ALL (SELECT * FROM {$_TABLES['forum_topic']} WHERE pid='$topicparentid') "
				  . "ORDER BY id $order2";
			$result2  = DB_query($sql);	
			$nrows2 = DB_numRows($result2);
			if ($nrows2 > 0) {
				for ($z = 1; $z <= $nrows2; $z++) {			
					$P2 = DB_fetchArray($result2);
					$showcount++; 
					if ($showcount > $show2) {
						
						$showcount = 0;
						$pagecount++;
					}
					if ($P2['id'] == $topicid) {	
						// Found post now set page stuff
						if ($pagecount > 1) {
							$pageurl = "&amp;show=$show2&amp;page=$pagecount";
						}
						$z = $nrows2;
					}
				}
			}
			// ***********************************************************************

			$link = "<a href=\"{$_CONF['site_url']}/forum/viewtopic.php?showtopic=$topicid$pageurl&amp;highlight=$query$jumppoint\">";
			$report->set_var('post_start_ahref',$link);
			$report->set_var('post_subject', $P['subject']);
			$report->set_var('post_end_ahref', '</a>');
			$postdate = COM_getUserDateTimeFormat($P['date']);
			$report->set_var('post_date',$postdate[0]);
			$report->set_var('post_replies', $P['replies']);
			$report->set_var('post_views', $P['views']);
			$report->set_var ('csscode', $csscode);
			if ($csscode == 2) {
				$csscode = 1;
			} else {
				$csscode++;
			}
			
			$report->parse ('report_record', 'report_record',true);			
        }
    } else {
        $report->set_var ('message', $LANG_GF02['msg203']);
        $report->parse ('no_records_message', 'no_records_message');
    }
    
    $report->set_var ('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));

    $report->parse ('output', 'report');
    $display .= $report->finish($report->get_var('output'));
    $title = $LANG_GF02['forumsearchresults'];
    $display = gf_createHTMLDocument($display, $title);
    COM_output($display);
    exit();
}

if ($op == 'popular') {
	// Figure out page stuff
	// Check if the number of records was specified to show - part of page navigation.
	if ($show == 0 AND $CONF_FORUM['show_popular_perpage'] > 0) {
		$show = $CONF_FORUM['show_popular_perpage'];
	} elseif ($show == 0) {
		$show = 20;
	}
	
	// Number of posts before calling a topic popular
    if ($populartype == 'views') {
    	$populartype = 'views';
	} else {
		$populartype = 'replies';
	}	
	$popular_limit = "";
	if ($CONF_FORUM['popular_limit'] > 0) {
		$popular_limit = " AND (ft.$populartype >= {$CONF_FORUM['popular_limit']})";
	}
	
    $grouplist = implode (',', $_GROUPS);    
    $grouplist = " AND (ff.grp_id IN ($grouplist))";
    		
	$sql = "SELECT id FROM {$_TABLES['forum_topic']} ft, {$_TABLES['forum_forums']} ff 
			WHERE ft.forum = ff.forum_id AND (ft.pid = '0') $popular_limit $grouplist ";
	$result = DB_query($sql);
	$topicCount = DB_numRows($result);
	$numpages = ceil($topicCount / $show);
	if ($numpages == 0) {
		$numpages = 1;
	}
	$offset = ($page - 1) * $show;
	$base_url = "{$_CONF['site_url']}/forum/index.php?op=popular&amp;populartype=$populartype&amp;show=$show";
	// Check to see if requesting a page that does not exist
	if ($page > $numpages) {
		COM_handle404($base_url);    
	}	

    $report = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $report->set_file (array (
                    'report'         => 'reports/report_results.thtml',
                    'forum_icons'    => 'forum_icons.thtml', 
                    'forum_links'    => 'forum_links.thtml'));  
    
    $report->set_block('report', 'report_record');
    $report->set_block('report', 'title');
    $report->set_block('report', 'links');
    $report->set_block('report', 'no_records_message');
    $report->set_block('report', 'report_controls_popular');
	$report->set_block('forum_links', 'return_link');
	
    $blocks = array('sort_desc', 'sort_desc_on', 'sort_asc', 'sort_asc_on');
    foreach ($blocks as $block) {
        $report->set_block('forum_icons', $block);
    }
	
    $report->parse ('img_asc1', 'sort_asc');
    $report->parse ('img_asc2', 'sort_asc');
    $report->parse ('img_asc3', 'sort_asc');
    $report->parse ('img_asc4', 'sort_asc');
    $report->parse ('img_desc1', 'sort_desc');
    $report->parse ('img_desc2', 'sort_desc');
    $report->parse ('img_desc3', 'sort_desc');
    $report->parse ('img_desc4', 'sort_desc');
    
    switch($sort) {
        case 1:
        	$orderby = 'subject';
            break;
        case 2:
        	$orderby = 'replies';
            break;
        case 3:
        	$orderby = 'views';
            break;
        case 4:
        	$orderby = 'date';
            break;            
        default:
        	if ($populartype == 'views') {
				$sort = 3;
				$order = 1;
				$orderby = 'views';
			} else {
				$sort = 2;
				$order = 1;
				$orderby = 'replies';
			}        	
            break;
    }
	if ($order == 0) {
		$sortOrder = "$orderby ASC";
		$report->parse ("img_asc$sort", 'sort_asc_on');
	} else {
		$sortOrder = "$orderby DESC";
		$report->parse ("img_desc$sort", 'sort_desc_on');
	}
    
    $base_url .= "&amp;order=$order&amp;sort=$sort&amp;populartype=$populartype";    
    
    $report->set_var ('imgset', $CONF_FORUM['imgset']);
    $report->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $report->set_var ('phpself',$_CONF['site_url'] . '/forum/index.php?op=popular');
    $report->set_var ('endblock', COM_endBlock());
    $report->set_var ('spacerwidth', '70%');
    if ($forum > 0) {
    	$report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php?forum=$forum");    	
	} else {
		$report->set_var ('returnlink', "{$_CONF['site_url']}/forum/index.php");
	}
    $report->set_var ('LANG_return', $LANG_GF02['msg175']);
    $report->set_var ('LANG_Heading1', $LANG_GF01['SUBJECT']);
    $report->set_var ('LANG_Heading2', $LANG_GF01['REPLIES']);
    $report->set_var ('LANG_Heading3', $LANG_GF01['VIEWS']);
    $report->set_var ('LANG_Heading4', $LANG_GF01['DATE']);

    if ($CONF_FORUM['usermenu'] == 'navbar') {
        $report->set_var('navmenu', forumNavbarMenu($LANG_GF02['msg201']));
    } else {
        $report->set_var('navmenu','');
    }
    $report->parse ('link1','return_link');
    $report->parse ('links','links');

    $report->set_var ('sort_url_extra', "&amp;populartype=$populartype");
    if ($populartype == 'views') {
    	$report->set_var ('replies_checked', '');
    	$report->set_var ('views_checked', 'CHECKED');
    	
    	$report->set_var('report_title', sprintf($LANG_GF02['poptopisby'], $LANG_GF02['views']));
	} else {
		$report->set_var ('replies_checked', 'CHECKED');
		$report->set_var ('views_checked', '');
		
		$report->set_var('report_title', sprintf($LANG_GF02['poptopisby'], $LANG_GF02['replies']));
	}
	$report->set_var ('LANG_By', $LANG_GF02['by']);
	$report->set_var ('LANG_Replies', $LANG_GF02['replies']);
	$report->set_var ('LANG_Views', $LANG_GF02['views']);
    $report->parse ('report_controls', 'report_controls_popular');
	$report->parse('title', 'title');

    $sql = "SELECT date,subject,comment,replies,views,id,forum FROM {$_TABLES['forum_topic']} ft, {$_TABLES['forum_forums']} ff 
    		WHERE ft.forum = ff.forum_id AND (ft.pid = '0') $popular_limit $grouplist ";
    $sql .= "ORDER BY $sortOrder, id DESC LIMIT $offset, $show";
    
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {    
		for ($i = 0; $i < $nrows; $i++) {
			$P = DB_fetchArray($result);
				
			$link = "<a href=\"{$_CONF['site_url']}/forum/viewtopic.php?forum={$P['forum']}&amp;showtopic={$P['id']}\">";
			$report->set_var('post_start_ahref',$link);
			$report->set_var('post_subject', $P['subject']);
			$report->set_var('post_end_ahref', '</a>');
			$postdate = COM_getUserDateTimeFormat($P['date']);
			$report->set_var('post_date',$postdate[0]);
			$report->set_var('post_replies', $P['replies']);
			$report->set_var('post_views', $P['views']);
			$report->set_var('csscode', $i%2+1);
			$report->parse ('report_record', 'report_record',true);
		}
    } else {
        $report->set_var ('message', $LANG_GF02['msg203']);
        $report->parse ('no_records_message', 'no_records_message');
    }    
    
    $report->set_var ('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));
    
    $report->parse ('output', 'report');
    $display .= $report->finish($report->get_var('output'));
    $title = $LANG_GF02['popularforumtopics'] ;
    $display = gf_createHTMLDocument($display, $title);
    COM_output($display);
    exit();
}

if ($op == 'subscribe') {
    if ($forum != 0) {
        DB_query("INSERT INTO {$_TABLES['forum_watch']} (forum_id,topic_id,uid,date_added) VALUES ('$forum','0','{$_USER['uid']}', now() )");
        // Delete all individual topic notification records
        DB_query("DELETE FROM {$_TABLES['forum_watch']} WHERE uid='{$_USER['uid']}' AND forum_id='$forum' and topic_id > '0' " );
        $display = COM_refresh($_CONF['site_url'] .'/forum/index.php?msg=1&amp;forum=' .$forum);
        COM_output($display);
        exit();
    } else {
        $display .= alertMessage($LANG_GF02['msg136'], $LANG_GF01['ERROR']);
    }
    $display = gf_createHTMLDocument($display);
    COM_output($display);
    exit();
}

// MAIN CODE BEGINS to view forums or topics within a forum

isset($showtopic) or $showtopic = ''; // FIXME
ForumHeader($forum,$showtopic,$display);

// Check if the number of records was specified to show - part of page navigation.
// Will be 0 if not set - as I'm now passing this tru gf_applyFilte() at top of script
if ($show == 0 AND $CONF_FORUM['show_topics_perpage'] > 0) {
    $show = $CONF_FORUM['show_topics_perpage'];
} elseif ($show == 0) {
    $show = 20;
}

if ($forum > 0) {
    $addforumvar = "&amp;forum=" .$forum;
    $topicCount = DB_count($_TABLES['forum_topic'], array('pid', 'forum'), array(0, $forum));
} else {
    $topicCount = DB_count($_TABLES['forum_topic'], 'pid', 0);
}

$numpages = ceil($topicCount / $show);
if ($numpages == 0) {
    $numpages = 1;
}
$offset = ($page - 1) * $show;
$base_url = $_CONF['site_url'] . '/forum/index.php?forum='.$forum.'&amp;show='.$show;
// Check to see if requesting a page that does not exist
if ($page > $numpages) {
	COM_handle404($base_url);    
}

//Display Categories
if ($forum == 0) {
    //$mytimer = new timerobject();
    //$mytimer->startTimer();
    //$exectime = $mytimer->stopTimer();
    //COM_errorLog("Forum Listing - time:$exectime");

    $groups = array ();
    $usergroups = SEC_getUserGroups();
    foreach ($usergroups as $group) {
        $groups[] = $group;
    }
    $groupAccessList = implode(',',$groups);
    //$category = 1;
    $sql = "SELECT * FROM {$_TABLES['forum_categories']}";
    if ($category > 0) {
    	$sql .= " WHERE id = $category";
	}
	$sql .= " ORDER BY cat_order ASC";
	
    $categoryQuery = DB_query($sql);
    $numCategories = DB_numRows($categoryQuery);
    
    // Check to see if requesting a category that does not exist
    if ($category == "0"  OR ($category > 0 AND $numCategories == 0)) {
		$base_url = "{$_CONF['site_url']}/forum/index.php";
		COM_handle404($base_url);    
	}
    
    $forumlisting = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $forumlisting->set_file (array (
            'forumlisting'         => 'homepage.thtml',
            'category_record'      => 'categorylisting.thtml',
            'forum_icons'   	   => 'forum_icons.thtml', 
    		'forum_links'   	   => 'forum_links.thtml'));
    
    $forumlisting->set_block('category_record', 'forum_record');
    
    $blocks = array('new_icon', 'quiet_icon', 'active_icon', 'normal_icon', 'normalnew_icon', 'sticky_icon', 'stickynew_icon', 'locked_icon', 'lockednew_icon');
    foreach ($blocks as $block) {
        $forumlisting->set_block('forum_icons', $block);
    }
        
    $blocks = array('newpost_link', 'markread_link', 'categorymenu_link');
    foreach ($blocks as $block) {
        $forumlisting->set_block('forum_links', $block);
    }    

    $forumlisting->set_var ('imgset', $CONF_FORUM['imgset']);
    $forumlisting->set_var ('forumindeximg','<img alt="forum index" src="'.gf_getImage('forumindex').'"' . XHTML . '>');
    $forumlisting->set_var ('phpself', $_CONF['site_url'] .'/forum/index.php');
    $forumlisting->set_var('layout_url', $CONF_FORUM['layout_url']);
    $viewnewpostslink = false;  // Set true when we have set the view newposts link template var

    for ($i=1; $i <= $numCategories; $i++) {
        //$exectime = $mytimer->stopTimer();
        //COM_errorLog("Start Category Listing - time:$exectime");
        $A = DB_FetchArray($categoryQuery,false);

		$forumlisting->set_var ('LANG_HOME', $LANG_GF01['HOMEPAGE']);
		$forumlisting->set_var ('forum_home',$LANG_GF01['INDEXPAGE']);
        $forumlisting->set_var ('cat_name', $A['cat_name']);
        $forumlisting->set_var ('cat_desc', $A['cat_dscp']);
        $forumlisting->set_var ('cat_id', $A['id']);
        $forumlisting->set_var ('category_id', $A['id']);
        $forumlisting->set_var ('LANGGF91_forum', $LANG_GF91['forum']);
        $forumlisting->set_var ('LANGGF01_TOPICS', $LANG_GF01['TOPICS']);
        $forumlisting->set_var ('LANGGF01_POSTS', $LANG_GF01['POSTS']);
        $forumlisting->set_var ('LANGGF01_LASTPOST', $LANG_GF01['LASTPOST']);

        //Display all forums under each cat
        $sql = "SELECT * FROM {$_TABLES['forum_forums']} AS f LEFT JOIN {$_TABLES['forum_topic']} AS t ON f.last_post_rec=t.id WHERE forum_cat='{$A['id']}' ";
        $sql .= "AND grp_id IN ($groupAccessList) AND is_hidden=0 ORDER BY forum_order ASC";

        $forumQuery = DB_query($sql);
        $numForums = DB_numRows($forumQuery);

        $numForumsDisplayed = 0;
        $forumlisting->parse ('forum_record', ''); // This is just to reset the forum record so duplicates don't happen in next category

        while ($B = DB_FetchArray($forumQuery)) {
            //$exectime = $mytimer->stopTimer();
            //COM_errorLog("Start Forum Listing - time:$exectime");

            $lastforum_noaccess = false;
            $topicCount = $B['topic_count'];
            $postCount = $B['post_count'];
            if ( $CONF_FORUM['show_moderators'] ) {
                $modsql = DB_query("SELECT * FROM {$_TABLES['forum_moderators']} WHERE mod_forum='{$B['forum_id']}'");
                $moderatorcnt = 1;
                if (DB_numRows($modsql) > 0) {
                    while($showmods = DB_fetchArray($modsql,false)) {
                        if ($showmods['mod_uid'] == '0') {
                            if ($showmods['mod_groupid'] > 0) {
                                $showmods['mod_username'] = DB_getItem($_TABLES['groups'], 'grp_name', "grp_id='{$showmods['mod_groupid']}'");
                            }
                            if ($moderatorcnt == 1 OR $moderators == '') {
                                $moderators = $showmods['mod_username'];
                            } else {
                                $moderators .= ', ' . $showmods['mod_username'];
                            }
                        } else {
                            if ($moderatorcnt == 1 OR $moderators == '') {
                                $moderators = COM_getDisplayName($showmods['mod_uid']);
                            } else {
                                $moderators .= ', ' . COM_getDisplayName($showmods['mod_uid']);
                            }
                        }
                        $moderatorcnt++;
                    }
                } else {
                    $moderators = $LANG_GF01['no_one'];
                }
                $forumlisting->set_var ('moderator', sprintf($LANG_GF01['MODERATED'],$moderators));
            } else {
                $forumlisting->set_var ('moderator', '');
            }
            $numForumsDisplayed ++;
            if ($postCount > 0) {
                if ( strlen($B['subject']) > 25 ) {
                    $B['subject'] = COM_truncate($B['subject'], 25, '..');
                }
                if (!COM_isAnonUser()) {
                    // Determine if there are new topics since last visit for this user.
                    if ($topicCount > DB_getItem($_TABLES['forum_log'], 'COUNT(*)', "uid='{$_USER['uid']}' AND forum='{$B['forum_id']}' AND time > 0")) {
                        $folderimg = "active_icon";
                    } else {
                        $folderimg = "quiet_icon";
                    }
                } else {
                    $folderimg = "quiet_icon";
                }

                $lastdate1 = strftime('%d', $B['date']);
                if ($lastdate1 == date('d')) {
                    $lasttime = (substr($_USER['language'],0,2) == "ja") ? strftime('%p&nbsp;%I:%M', $B['date']) : strftime('%I:%M&nbsp;%p', $B['date']); // need examination
                    $lastdate = $LANG_GF01['TODAY'] .$lasttime;
                } elseif (isset($CONF_FORUM['use_userdate_format']) && $CONF_FORUM['use_userdate_format']) { // FIXME: why would it not be set?
                    $lastdate = COM_getUserDateTimeFormat($B['date']);
                    $lastdate = $lastdate[0];
                } else {
                    $lastdate =strftime($CONF_FORUM['default_Datetime_format'],$B['date']);
                }

                $lastpostmsgDate  = '<span class="forumtxt">' . $LANG_GF01['ON']. '</span>' .$lastdate;
                if ($B['uid'] > 1) {
                    $lastposterName = COM_getDisplayName($B['uid']);
                    $by = '<a href="' .$_CONF['site_url']. '/users.php?mode=profile&amp;uid=' .$B['uid']. '">' .$lastposterName. '</a>';
                } else {
                    $by = $B['name'];
                }
                $lastpostmsgBy = $LANG_GF01['BY']. $by;
                $forumlisting->set_var ('lastpostmsgDate', $lastpostmsgDate);
                $forumlisting->set_var ('lastpostmsgTopic', $B['subject']);
                $forumlisting->set_var ('lastpostmsgBy', $lastpostmsgBy);

            }  else {
                $forumlisting->set_var ('lastpostmsgDate', $LANG_GF01['nolastpostmsg']);
                $forumlisting->set_var ('lastpostmsgTopic', '');
                $forumlisting->set_var ('lastpostmsgBy', '');
                $folderimg = "quiet_icon";
            }

            if ($B['pid'] == 0) {
                $topicparent = $B['id'];
            } else {
                $topicparent = $B['pid'];
            }

            //$forumlisting->set_var ('folderimg', $folderimg);
            $forumlisting->parse ('folderimg', $folderimg);
            $forumlisting->set_var ('forum_id', $B['forum_id']);
            $forumlisting->set_var ('forum_name', $B['forum_name']);
            $forumlisting->set_var ('forum_desc', $B['forum_dscp']);
            $forumlisting->set_var ('topics', $topicCount);
            $forumlisting->set_var ('posts', $postCount);
            $forumlisting->set_var ('topic_id', $topicparent);
            $forumlisting->set_var ('lastpostid', $B['id']);
            $forumlisting->set_var ('LANGGF01_LASTPOST', $LANG_GF01['LASTPOST']);
            $forumlisting->parse ('forum_record', 'forum_record',true);
        }

        if ($numForumsDisplayed > 0) {
            if (!COM_isAnonUser()) {
                $link = $_CONF['site_url'] . '/forum/index.php?op=markallread&amp;cat_id=' . $A['id'];
                $forumlisting->set_var ('markreadlink', $link);
                $forumlisting->set_var ('LANG_markread', $LANG_GF02['msg84']);
                $forumlisting->parse ('markread_link', 'markread_link');
                if (!$viewnewpostslink) {
                    $newpostslink = $_CONF['site_url'] .'/forum/index.php?op=newposts';
                    $forumlisting->set_var ('newpostslink', $newpostslink);
                    $forumlisting->set_var ('LANG_newposts', $LANG_GF02['msg112']);
                    $viewnewpostslink = true;
                       $forumlisting->parse ('newposts_link', 'newpost_link');
                } else {
                    $forumlisting->set_var ('newposts_link', '');
                }
                
                $forumlisting->parse ('categorymenu_link', 'categorymenu_link');
            } else {
                $forumlisting->set_var ('newposts_link', '');
                $forumlisting->set_var ('markread_link', '');
                $forumlisting->set_var ('categorymenu_link', '');
            }
            $forumlisting->parse ('category_records', 'category_record', true);
            $forumlisting->parse ('forum_records', '');
        }

    }

    if ($numCategories == 0) {         // Do we have any categories defined yet
    	$display .= alertMessage($LANG_GF01['MSG_NO_CAT'], $LANG_GF01['ERROR'], false);
    }

    $forumlisting->parse ('output', 'forumlisting');
    $display .= $forumlisting->finish ($forumlisting->get_var('output'));

    //$exectime = $mytimer->stopTimer();
    //COM_errorLog("End of Listing - time:$exectime");
}

 // Display Forums
if ($forum > 0) {

    $topiclisting = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $topiclisting->set_file (array (
            'topiclisting'         => 'topiclisting.thtml',
            'forum_icons'   	   => 'forum_icons.thtml', 
    		'forum_links'   	   => 'forum_links.thtml'));
    
    $topiclisting->set_block('topiclisting', 'topic_record');
    $topiclisting->set_block('topiclisting', 'no_records_message');
    
    $blocks = array('new_icon', 'quiet_icon', 'active_icon', 'normal_icon', 'normalnew_icon', 'sticky_icon', 'stickynew_icon', 'locked_icon', 'lockednew_icon', 'sort_desc', 'sort_desc_on', 'sort_asc', 'sort_asc_on');
    foreach ($blocks as $block) {
        $topiclisting->set_block('forum_icons', $block);
    }
    
    $blocks = array('newtopic_link', 'subscribeforum_link', 'forummenu_link');
    foreach ($blocks as $block) {
        $topiclisting->set_block('forum_links', $block);
    }       

    $topiclisting->set_var ('imgset', $CONF_FORUM['imgset']);
    $topiclisting->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $topiclisting->set_var ('LANG_HOME', $LANG_GF01['HOMEPAGE']);
    $topiclisting->set_var ('forum_home',$LANG_GF01['INDEXPAGE']);
    $topiclisting->set_var ('navbreadcrumbsimg','<img alt="" src="'.gf_getImage('nav_breadcrumbs').'"' . XHTML . '>');
    
    $topiclisting->parse ('img_asc1', 'sort_asc');
    $topiclisting->parse ('img_asc2', 'sort_asc');
    $topiclisting->parse ('img_asc3', 'sort_asc');
    $topiclisting->parse ('img_asc4', 'sort_asc');
    $topiclisting->parse ('img_asc5', 'sort_asc');
    $topiclisting->parse ('img_desc1', 'sort_desc');
    $topiclisting->parse ('img_desc2', 'sort_desc');
    $topiclisting->parse ('img_desc3', 'sort_desc');
    $topiclisting->parse ('img_desc4', 'sort_desc');
    $topiclisting->parse ('img_desc5', 'sort_desc');
    
    if (function_exists('prj_getSessionProject')) {
        $projectid = prj_getSessionProject();
        if ($projectid > 0) {
            $link = "<a href=\"{$_CONF['site_url']}/projects/viewproject.php?pid=$projectid\">{$strings['RETURN2PROJECT']}</a>";
            $topiclisting->set_var ('return2project',$link);
        }
    }

    switch($sort) {
        case 1:
            if ($order == 0) {
                $sortOrder = "subject ASC";
                $topiclisting->parse ('img_asc1', 'sort_asc_on');
            } else {
                $sortOrder = "subject DESC";
                $topiclisting->parse ('img_desc1', 'sort_desc_on');
            }
            break;
        case 2:
            if ($order == 0) {
                $sortOrder = "views ASC";
                $topiclisting->parse ('img_asc2', 'sort_asc_on');
            } else {
                $sortOrder = "views DESC";
                $topiclisting->parse ('img_desc2', 'sort_desc_on');
            }
            break;
        case 3:
            if ($order == 0) {
                $sortOrder = "replies ASC";
                $topiclisting->parse ('img_asc3', 'sort_asc_on');
            } else {
                $sortOrder = "replies DESC";
                $topiclisting->parse ('img_desc3', 'sort_desc_on');
            }
            break;
        case 4:
            if ($order == 0) {
                $sortOrder = "name ASC";
                $topiclisting->parse ('img_asc4', 'sort_asc_on');
            } else {
                $sortOrder = "name DESC";
                $topiclisting->parse ('img_desc4', 'sort_desc_on');
            }
            break;
        case 5:
            if ($order == 0) {
                $sortOrder = "lastupdated ASC";
                $topiclisting->parse ('img_asc5', 'sort_asc_on');
            } else {
                $sortOrder = "lastupdated DESC";
                $topiclisting->parse ('img_desc5', 'sort_desc_on');
            }
            break;
        default:
            $sortOrder = "lastupdated DESC";
            $topiclisting->parse ('img_desc5', 'sort_desc_on');
            break;
    }

    $base_url .= "&amp;order=$order&amp;sort=$sort";

    // Retrieve all the Topic Records - where pid is 0 - check to see if user does not want to see anonymous posts
    if (!COM_isAnonUser() AND $CONF_FORUM['show_anonymous_posts'] == 0) {
        $sql  = "SELECT * FROM {$_TABLES['forum_topic']} topic WHERE forum = '$forum' AND pid = 0 AND uid > 1 ";
    } else {
        $sql  = "SELECT * FROM {$_TABLES['forum_topic']} topic WHERE forum = '$forum' AND pid = 0 ";
    }
    $sql .= "ORDER BY sticky DESC, $sortOrder, id DESC LIMIT $offset, $show";
    $topicResults = DB_query($sql);
    $totalresults = DB_numRows($topicResults);

    // Retrieve Forum details and Category name
    $sql  = "SELECT forum.forum_name,category.id,category.cat_name,forum.is_readonly FROM {$_TABLES['forum_forums']} forum ";
    $sql .= "LEFT JOIN {$_TABLES['forum_categories']} category ON category.id=forum.forum_cat ";
    $sql .= "WHERE forum.forum_id = $forum";
    $category = DB_fetchArray(DB_query($sql));
    if ($totalresults < 1) {
        $LANG_MSG05 = $LANG_GF02['msg05'];
        $topiclisting->set_var ('records_message', $LANG_GF02['msg05']);
        $topiclisting->parse ('no_records_message', 'no_records_message');
        
    }
    $subscribelink = '';
    if (!COM_isAnonUser()) {
        // Check for user subscription status
        $sub_check = DB_getITEM($_TABLES['forum_watch'],"id","forum_id='$forum' AND topic_id=0 AND uid='{$_USER['uid']}'");
        if ($sub_check == '') {
            $subscribelink = "{$_CONF['site_url']}/forum/index.php?op=subscribe&amp;forum=$forum";
            $topiclisting->set_var ('subscribelink', $subscribelink);
            $topiclisting->set_var ('subscribelinktext', $LANG_GF01['FORUMSUBSCRIBE']);
            $topiclisting->set_var ('LANG_subscribe', $LANG_GF01['FORUMSUBSCRIBE']);
            $topiclisting->set_var ('LANG_subscribe_state', $LANG_GF01['FORUMSUBSCRIBE_FALSE']);
            $topiclisting->parse ('subscribeforum_link','subscribeforum_link');
        } else {
            $subscribelink = "{$_CONF['site_url']}/forum/notify.php?filter=2";
            $topiclisting->set_var ('subscribelink', $subscribelink);
            $topiclisting->set_var ('subscribelinktext', $LANG_GF01['FORUMUNSUBSCRIBE']);
            $topiclisting->set_var ('LANG_subscribe', $LANG_GF01['FORUMUNSUBSCRIBE']);
            $topiclisting->set_var ('LANG_subscribe_state', $LANG_GF01['FORUMSUBSCRIBE_TRUE']);
            $topiclisting->parse ('subscribeforum_link','subscribeforum_link');
        }
    }

    $topiclisting->set_var ('cat_name', $category['cat_name']);
    $topiclisting->set_var ('category_id', $category['id']);
    $topiclisting->set_var ('forum_name', $category['forum_name']);
    $topiclisting->set_var ('forum_id', $forum);
    $topiclisting->set_var ('imgset', $CONF_FORUM['imgset']);
    $topiclisting->set_var ('LANG_TOPIC', $LANG_GF01['TOPICSUBJECT']);
    $topiclisting->set_var ('LANG_STARTEDBY', $LANG_GF01['STARTEDBY']);
    $topiclisting->set_var ('LANG_REPLIES', $LANG_GF01['REPLIES']);
    $topiclisting->set_var ('LANG_VIEWS', $LANG_GF01['VIEWS']);
    $topiclisting->set_var ('LANG_LASTPOST',$LANG_GF01['LASTPOST']);
    $topiclisting->set_var ('LANG_AUTHOR',$LANG_GF01['AUTHOR']);
    $topiclisting->set_var ('LANG_MSG05',$LANG_GF01['LASTPOST']);
    $topiclisting->set_var ('LANG_newforumposts', $LANG_GF02['msg113']);

    if ($category['is_readonly'] == 0 OR forum_modPermission($forum,$_USER['uid'],'mod_edit')) {
        $topiclisting->set_var ('LANG_newtopic', $LANG_GF01['NEWTOPIC']);
        $topiclisting->set_var('newtopiclinktext', $LANG_GF09['newtopic']);
        $topiclisting->set_var('newtopiclinkimg', gf_getImage('post_newtopic'));
        $topiclisting->set_var ('newtopiclink',"{$_CONF['site_url']}/forum/createtopic.php?method=newtopic&amp;forum=$forum");
        $topiclisting->parse ('newtopic_link','newtopic_link');
    } else {
        $topiclisting->set_var ('LANG_newtopic', '');
        $topiclisting->set_var ('newtopiclink','#');
    }

    $displaypostpages = $LANG_GF01['PAGES'] .':'; // FIXME: is this used anywhere?

    while ($record = DB_fetchArray($topicResults,false)) {

        if (($record['replies']+1) <= $CONF_FORUM['show_posts_perpage']) {
            $displaypageslink = "";
            $gotomsg = "";
        } else {
            $displaypageslink = "";
            $gotomsg = $LANG_GF02['msg85'] . "&nbsp;";
            if ($CONF_FORUM['show_posts_perpage'] > 0) {
                $pages = ceil(($record['replies']+1)/$CONF_FORUM['show_posts_perpage']);
            } else {
                 $pages = ceil(($record['replies']+1)/20);
            }
            for ($p=1; $p <= $pages; $p++) {
                $displaypageslink .= "<a href=\"{$_CONF['site_url']}/forum/viewtopic.php?forum=$forum";
                $displaypageslink .= "&amp;showtopic={$record['id']}&amp;show={$CONF_FORUM['show_posts_perpage']}&amp;page=$p\">";
                if ($p > 9) {
                    $displaypageslink .= '...</a>&nbsp;';
                    break;
                } else {
                    $displaypageslink .= "$p</a>&nbsp;";
                }
            }
        }

        // Check if user is an anonymous poster
        if ($record['uid'] > 1) {
            $showuserlink = '<span class="replypagination">';
            $showuserlink .= "<a href=\"{$_CONF['site_url']}/users.php?mode=profile&amp;uid={$record['uid']}\">{$record['name']}";
            $showuserlink .= '</a></span>';
        } else {
            $showuserlink= $record['name'];
        }

        if (isset($_USER['language']) AND substr($_USER['language'],0,2) == "ja") { // need examination
            $format1 = '%Y/%m/%d';
            $format2 = 'Y/m/d';
            $format3 = '%p&nbsp;%H:%M';
        } else {
            $format1 = '%m/%d/%Y';
            $format2 = 'm/d/Y';
            $format3 = '%H:%M&nbsp;%p';
        }

        if ($record['last_reply_rec'] > 0) {
            $lastreplysql = DB_query("SELECT * FROM {$_TABLES['forum_topic']} WHERE id={$record['last_reply_rec']}");
            $lastreply = DB_fetchArray($lastreplysql);
            if (($CONF_FORUM['show_subject_length'] > 0) AND (strlen ($lastreply['subject']) > $CONF_FORUM['show_subject_length'])) {
                $lastreply['subject'] = COM_truncate($record['subject'], $CONF_FORUM['show_subject_length'], '...');
                $lastreply['subject'] .= "...";
            }

            $lastdate1 = strftime($format1, $lastreply['date']);
            if ($lastdate1 == date($format2)) {
                $lasttime = strftime($format3, $lastreply['date']);
                $lastdate = $LANG_GF01['TODAY'] . $lasttime;
            } elseif (isset($CONF_FORUM['use_userdate_format']) AND $CONF_FORUM['use_userdate_format']) {
                $lastdate = COM_getUserDateTimeFormat($lastreply['date']);
                $lastdate = $lastdate[0];
            } else {
                $lastdate = strftime($CONF_FORUM['default_Datetime_format'],$lastreply['date']);
            }
        } else {
            $lastdate = strftime($CONF_FORUM['default_Datetime_format'],$record['lastupdated']);
            $lastreply = $record;
        }

        $firstdate1 = strftime($format1, $record['date']);
        if ($firstdate1 == date($format2)) {
            $firsttime = strftime($format3, $record['date']);
            $firstdate = $LANG_GF01['TODAY'] . $firsttime;
        } elseif (isset($CONF_FORUM['use_userdate_format']) && $CONF_FORUM['use_userdate_format']) { // FIXME: why would it not be set?
            $firstdate = COM_getUserDateTimeFormat($record['date']);
            $firstdate = $firstdate[0];
        } else {
            $firstdate = strftime($CONF_FORUM['default_Datetime_format'],$record['date']);
        }

        if (!COM_isAnonUser()) {
            // Determine if there are new topics since last visit for this user.
            // If topic has been updated or is new - then the user will not have record for this parent topic in the log table
            if (DB_getItem($_TABLES['forum_log'], 'COUNT(*)', "uid='{$_USER['uid']}' AND topic='{$record['id']}' AND time > 0") == 0) {
                if ($record['sticky'] == 1) {
                    $folderimg = "stickynew_icon";
                } elseif ($record['locked'] == 1) {
                    $folderimg = "lockednew_icon";
                } else {
                    $folderimg = "normalnew_icon";
                }
            } elseif ($record['sticky'] == 1) {
                $folderimg = "sticky_icon";
            } elseif ($record['locked'] == 1) {
                $folderimg = "locked_icon";
            } else {
                $folderimg = "normal_icon";
            }
        } elseif ($record['sticky'] == 1) {
            $folderimg = "sticky_icon";
        } elseif ($record['locked'] == 1) {
            $folderimg = "locked_icon";
        } else {
           $folderimg = "normal_icon";
        }

        if ($lastreply['uid'] > 1) {
            $lastposter = COM_getDisplayName($lastreply['uid']);
        } else {
            $lastposter = $lastreply['name'];
        }

        if ($record['moved'] == 1){
            $moved = "{$LANG_GF01['MOVED']}: ";
        } else {
            $moved = "";
        }

        if (($CONF_FORUM['show_subject_length'] > 0) AND (strlen ($record['subject']) > $CONF_FORUM['show_subject_length'])) {
            $subject = COM_truncate($record['subject'], $CONF_FORUM['show_subject_length'], '...');
        } else {
            $subject = $record['subject'];
        }

        if ($record['uid'] > 1) {
            $firstposterName = COM_getDisplayName($record['uid']);
        } else {
            $firstposterName = $record['name'];
        }
        $topicinfo =  "<b>{$LANG_GF01['STARTEDBY']} {$firstposterName}, {$firstdate}</b><br" . XHTML . ">";
        $lastpostinfo = stripBBCode($lastpostinfo); // Simple function to strip out bbcode so tooltips display better
        $lastpostinfo = strip_tags(COM_truncate($record['comment'], $CONF_FORUM['contentinfo_numchars'], '...'));
        $lastpostinfo = htmlspecialchars($lastpostinfo); // Escape things like " so it displays properly in tooltip
        $topicinfo .= str_replace(LB, "<br" . XHTML . ">", forum_mb_wordwrap($lastpostinfo, $CONF_FORUM['linkinfo_width'], LB));
        
        if (function_exists('COM_getTooltip')) {
            $topiclink = "viewtopic.php?showtopic={$record['id']}";
            $tooltip_subject = COM_getTooltip($subject, $topicinfo, $topiclink);
            //$subject = '';
            $topiclisting->set_var ('tooltip_subject', $tooltip_subject);
        }
        $topiclisting->set_var ('topicinfo', $topicinfo);

		$topiclisting->parse ('folderimg', $folderimg);
        $topiclisting->set_var ('topic_id', $record['id']);
        $topiclisting->set_var ('subject', $subject);
        $topiclisting->set_var ('fullsubject', $record['subject']);
        $topiclisting->set_var ('gotomsg', $gotomsg);
        $topiclisting->set_var ('displaypageslink', $displaypageslink);
        $topiclisting->set_var ('showuserlink', $showuserlink);
        $topiclisting->set_var ('lastposter', $lastposter);
        $topiclisting->set_var ('LANG_lastpost', $LANG_GF02['msg188']);
        $topiclisting->set_var ('moved', $moved);
        $topiclisting->set_var ('views', $record['views']);
        $topiclisting->set_var ('replies', $record['replies']);
        $topiclisting->set_var ('lastdate', $lastdate);
        $topiclisting->set_var ('lastpostid', $lastreply['id']);
        $topiclisting->set_var ('LANG_BY', $LANG_GF01['BY']);
        $topiclisting->parse ('topic_record', 'topic_record',true);
    }

    $topiclisting->set_var ('pagenavigation', COM_printPageNavigation($base_url,$page, $numpages));
    
    if (empty($subscribelink)) {
    	$topiclisting->set_var ('forummenu_link', '');
    } else {
    	$topiclisting->parse ('forummenu_link', 'forummenu_link');
	}
    
    $topiclisting->parse ('output', 'topiclisting');
    $display .= $topiclisting->finish ($topiclisting->get_var('output'));
}

$title = $LANG_GF01['FORUM'];
$forum_id = COM_applyFilter($_REQUEST['forum'],true);
if (isset($_REQUEST['forum'])) $title = stripslashes(DB_getItem($_TABLES['forum_forums'],'forum_name',"forum_id='{$forum_id}'"));
if (isset($_REQUEST['category'])) $title = $A['cat_name'];


$display .= BaseFooter();
$display = gf_createHTMLDocument($display, $title);
COM_output($display);
?>
