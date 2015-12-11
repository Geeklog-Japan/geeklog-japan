<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'phpblock_sitemapmenu.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Returns a simple sitemap menu (topics and stories)
*
* @authors  ivy AT geeklog DOT jp
*           mystral-kk - geeklog AT mystral-kk DOT net
* @license  GPL v2
* @version  2008-09-20
*/
function phpblock_sitemapmenu($tid = '', $lst = '') {
	$retval = '<div class="sitemapmenu">' . LB;
	
	if ($lst == 'topics') {
	    $retval .= SITEMAPMENU_listTopics('all', $tid)
				.  SITEMAPMENU_navBar($tid);
	} else if ($lst == 'topicsonly') {
	    $retval .= SITEMAPMENU_listTopics('', '');
	} else {
	    $retval .= SITEMAPMENU_listTopics('all', '');
	}
	$retval .= '</div>' . LB;
	
	return $retval;
}

/**
* Escapes a string for output
*/
function SITEMAPMENU_esc($str) {
	global $_CONF, $LANG_CHARSET;
	
	static $encoding = null;
	
	if ($encoding === null) {
		if (isset($LANG_CHARSET)) {
			$encoding = $LANG_CHARSET;
		} else if (isset($_CONF['default_charset'])) {
			$encoding = $_CONF['default_charset'];
		} else {
			$encoding = 'utf-8';
		}
	}
	
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	return htmlspecialchars($str, ENT_QUOTES, $encoding);
}

/**
* Returns all topics (and their icons).
*
* @return   string      HTML for the topic list
*/
function SITEMAPMENU_listTopics($lst, $tid) {
    global $_CONF, $_TABLES, $_USER;
	
    $sql = "SELECT tid, topic, imageurl FROM {$_TABLES['topics']}";
	
    if ($tid != ''){
        $sql .= " WHERE (tid = '" . addslashes($tid) . "') ";
    }
	
    if(!empty($_USER['uid']) AND ($_USER['uid'] > 1)) {
        $tids = DB_getItem($_TABLES['userindex'], 'tids', "uid = '{$_USER['uid']}'" );
        if(!empty($tids)) {
            if ($tid == '') {
                 $sql .= ' WHERE ';
            } else {
				$sql .= ' AND ';
			}
            $sql .= " (tid NOT IN ('" . str_replace(' ', "','", $tids)
                 . "'))" . COM_getPermSQL('AND');
        } else {
            if ($tid != '') {
				$sql .= COM_getPermSQL('AND');
			} else {
				$sql .= COM_getPermSQL();
			}
        }
    } else {
        if ($tid != ''){
			$sql .= COM_getPermSQL('AND');
		} else {
			$sql .= COM_getPermSQL();
		}
    }
    
    if($_CONF['sortmethod'] == 'alpha') {
        $sql .= ' ORDER BY topic ASC';
    } else {
        $sql .= ' ORDER BY sortnum';
    }
	
    $result = DB_query($sql);
    $retval = '';
	
    while (($A = DB_fetchArray($result)) !== false) {
        $retval .= '<h3 class="nav-title">'
				.  SITEMAPMENU_esc(stripslashes($A['topic']))
				. '</h3>' . LB;
        if ($lst== 'all') {
            $retval .= SITEMAPMENU_listStory($A['tid']);
        }
    }
	
    return $retval;
}

/**
* Returns a list of stories with a give topic id
*/
function SITEMAPMENU_listStory($tid) {
    global $_CONF, $_TABLES, $LANG_DIR;
	
    $retval = '';
	
    $sql = "SELECT sid, title, UNIX_TIMESTAMP(date) AS day "
		 . "FROM {$_TABLES['stories']} "
		 . "WHERE (draft_flag = 0) AND (date <= NOW())";
    if ($tid != 'all') {
        $sql .= " AND (tid = '$tid')";
    }
    $sql .= COM_getTopicSql('AND') . COM_getPermSql('AND')
		 .  " ORDER BY date DESC";
	
    $result  = DB_query($sql);
    $numrows = DB_numRows($result);
	
    if ($numrows > 0) {
        $entries = array();
		
        for ($i = 0; $i < $numrows; $i ++) {
            $A   = DB_fetchArray($result);
            $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $A['sid']);
            $entries[] = '<a class="nav-link" href="' . $url . '">'
					   . SITEMAPMENU_esc(stripslashes($A['title'])) . '</a>';
        }
		
		$retval .= COM_makeList($entries) . LB;
    }
	
    return $retval;
}

/**
* Returns a nav bar
*/
function SITEMAPMENU_navBar($tid) {
    global $_CONF, $_TABLES, $LANG05, $LANG_DIR;
	
    $retval = '<div class="pagenav">'
			. '<a href="' . $_CONF['site_url'] . '/index.php' . '">'
			. SITEMAPMENU_esc($LANG_DIR['nav_top']) . '</a>'
			. '</div>' . LB;
    return $retval;
}
