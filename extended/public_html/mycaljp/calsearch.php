<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | public_html/mycaljp/calsearch.php                                         |
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

if ( isset($_GET['moon']) )
    $GLOBALS['WorkDate'] = $_GET['moon'];
elseif ( isset($_GET['datestart']) )
    $GLOBALS['WorkDate'] = $_GET['datestart'];

// Checks if user has right to access this page
$uid = 1;
if (isset($_USER['uid'])) {
    $uid = $_USER['uid'];
} else {
    $_USER['uid']   = 1;
}

/**
* Builds items belonging to a category
*
* @param $T       reference to Template object
* @param $driver  reference to driver object
* @param $pid     id of parent category
* @return         array of ( num_items, html )
*
* @destroy        $T->var( 'items', 'item', 'item_list' )
*/
function MYCALJP_buildItems(&$driver, $driver_name, $pid) {
    global $_MYCALJP2_CONF, $T;
    
    $html = '';
    $T->clear_var('items');
    $sp_except = explode(' ', $_MYCALJP2_CONF['sp_except']);

    $items = $driver->getItemsByDate($pid);

    $num_items = count($items);
    if ($num_items > 0) {
        foreach ($items as $item) {
            // Static pages
            if ($driver_name == 'staticpages') {
                if (in_array($item['id'], $sp_except)) {
                    $num_items --;
                    continue;
                }
                
                $temp = $driver->getItemById($item['id']);
                $raw  = $temp['raw_data'];
                if ((($_MYCALJP2_CONF['sp_type'] == 1) AND ($raw['sp_centerblock'] != 1))
                 OR (($_MYCALJP2_CONF['sp_type'] == 2) AND ($raw['sp_centerblock'] == 1))) {
                    $num_items --;
                    continue;
                }
            }
            
            $link = '<a href="' . $item['uri'] . '">'
                  . $driver->escape($item['title']) . '</a>';
            $T->set_var('item', $link);
            if ($item['date'] !== false) {
                $date = date($_MYCALJP2_CONF['date_format'], $item['date']);
                $T->set_var('date', $date);
            }
            $T->parse('items', 't_item', true);
        }
        
        $T->parse('item_list', 't_item_list');
        $html = $T->finish($T->get_var('item_list'));
    }
    
    return array($num_items, $html);
}

/**
* Builds a category and items belonging to it
*
* @param $T       reference to Template object
* @param $driver  reference to driver object
* @param $cat     array of category data
* @return         string HTML
*
* @destroy        $T->var( 'child_categories', 'category', 'num_items' )
*/
function MYCALJP_buildCategory(&$driver, $driver_name, $cat) {
    global $T;
    
    $num_total_items = 0;
    $temp = $T->get_var('child_categories');    // Push $T->var('child_categories')

    // Builds {child_categories}
    $child_categories = $driver->getChildCategories($cat['id']);

    if (count($child_categories) > 0) {
        $child_cats = '';
        
        foreach ($child_categories as $child_category) {
            list($num_child_category, $child_cat) = MYCALJP_buildCategory($driver, $driver_name, $child_category);
            $num_total_items += $num_child_category;
            $child_cats      .= $child_cat;
        }
        
        $T->set_var('categories', $child_cats);
        $T->parse('temp', 't_category_list');
        $child_cats = $T->get_var('temp');
        $T->set_var(
            'child_categories',
            '<br' . XHTML . '>' . $child_cats . '<br' . XHTML . '>'
        );
    }
    
    // Builds {items}
    list($num_items, $items) = MYCALJP_buildItems($driver, $driver_name, $cat['id']);
    $num_total_items += $num_items;
    $T->set_var('num_items', $num_items);
    if (!empty($items)) {
        $T->set_var(
            'items',
            '<br' . XHTML . '>' . $items . '<br' . XHTML . '>'
        );
    }
    
    // Builds {category}
    if ($cat['uri'] !== false) {
        $category_link = '<a href="' . $cat['uri'] . '">'
              . $driver->escape($cat['title']) . '</a>';
    } else {
        $category_link = $driver->escape($cat['title']);
    }
    
    $T->set_var('category', $category_link);
    $T->parse('category', 't_category');
    $retval = $T->finish($T->get_var('category'));
    
    $T->set_var('child_categories', $temp);     // Pop $T->var('child_categories')
    
    return array($num_total_items, $retval);
}


function MYCALJP_showStoriesIntro() {

    global $_CONF, $_TABLES, $_MYCALJP2_CONF;

    if (!$_MYCALJP2_CONF['showstoriesintro']) return '';

    $retval = '';

    $_dateStart = COM_applyFilter($_GET['datestart']);
    $_dateEnd   = COM_applyFilter($_GET['dateend']);
    if (!empty($_dateStart) && !empty($_dateEnd)) {
        $ds = explode("-", $_dateStart);
        $de = explode("-", $_dateEnd);
        $startdate = mktime( 0, 0, 0,$ds[1],$ds[2],$ds[0]);
        $enddate   = mktime(23,59,59,$de[1],$de[2],$de[0]);
        $sql = "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
    }
    
    $sql .= "AND (draft_flag = 0) ";
    $sql .= COM_getPermSQL('AND', 0, 2, 's') . ' ';
    $sql .= COM_getTopicSQL('AND', 0, 'ta') . ' ';
    $sql .= COM_getLangSQL('sid', 'AND', 's') . ' ';

    $userfields = 'u.username, u.fullname';
    if ($_CONF['allow_user_photo'] == 1) {
        $userfields .= ', u.photo';
        if ($_CONF['use_gravatar']) {
            $userfields .= ', u.email';
        }
    }

    $msql = array();
    $msql['mysql']="SELECT DISTINCT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) AS unixdate, "
             . "UNIX_TIMESTAMP(s.expire) AS expireunix, "
             . $userfields . ", t.topic, t.imageurl "
             . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
             . "{$_TABLES['topics']} AS t, {$_TABLES['topic_assignments']} AS ta "
             . "WHERE (ta.type = 'article') AND (ta.tdefault = 1) AND (s.uid = u.uid) AND (ta.tid = t.tid) AND (s.sid = ta.id) "
             . $sql . "ORDER BY featured DESC, date DESC";

/*
    $msql['mssql']="SELECT STRAIGHT_JOIN s.sid, s.uid, s.draft_flag, s.tid, s.date, s.title, cast(s.introtext as text) as introtext, cast(s.bodytext as text) as bodytext, s.hits, s.numemails, s.comments, s.trackbacks, s.related, s.featured, s.show_topic_icon, s.commentcode, s.trackbackcode, s.statuscode, s.expire, s.postmode, s.frontpage, s.in_transit, s.owner_id, s.group_id, s.perm_owner, s.perm_group, s.perm_members, s.perm_anon, s.advanced_editor_mode, "
             . " UNIX_TIMESTAMP(s.date) AS unixdate, "
             . 'UNIX_TIMESTAMP(s.expire) as expireunix, '
             . $userfields . ", t.topic, t.imageurl "
             . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
             . "{$_TABLES['topics']} AS t, {$_TABLES['topic_assignments']} AS ta "
             . "WHERE (ta.type = 'article') AND (ta.tdefault = 1) AND (s.uid = u.uid) AND (ta.tid = t.tid) AND (s.sid = ta.id) "
             . $sql . "ORDER BY featured DESC, date DESC";
*/
    $result = DB_query($msql);

    require_once $_CONF['path_system'] . 'lib-story.php';
    $story = new Story();
    while ($A = DB_fetchArray($result)) {
        $story->loadFromArray($A);
        $retval .= STORY_renderArticle($story, 'y');
    }
    return $retval;
}


// MAIN

if (!class_exists('Dataproxy')) {
    $display = COM_createHTMLDocument('');
    COM_output($display);
    exit;
}

// Retrieves vars
$_GET  = MYCALJP_stripslashes($_GET);
$_POST = MYCALJP_stripslashes($_POST);

$template = $_CONF['path_html'] . 'mycaljp/templates_search';
$T = new Template($template);
$T->set_file(array(
    't_index'             => 'index.thtml',
    't_data_source'       => 'data_source.thtml',
    't_data_source_no_hr' => 'data_source_no_hr.thtml',
    't_category_list'     => 'category_list.thtml',
    't_category'          => 'category.thtml',
    't_item_list'         => 'item_list.thtml',
    't_item'              => 'item.thtml' ));
$T->set_var('xhtml', XHTML);

// Collects data sources

$_dateStart = COM_applyFilter($_GET['datestart']);
$_dateEnd   = COM_applyFilter($_GET['dateend']);

// $dataproxy is a global object in this script and functions.inc
$dataproxy = Dataproxy::getInstance($uid);
$drivers = Dataproxy::getAllDriverNames();
$dataproxy->setDateStart($_dateStart);
$dataproxy->setDateEnd($_dateEnd);

foreach ($drivers as $driver_name) {
    $content = $driver_name;
    if ($driver_name == 'article') $content = 'stories';
    if (!in_array($content, $_MYCALJP2_CONF['supported_contents'])) continue;
    if (!($_MYCALJP2_CONF['enabled_contents'][$content] == 1)) continue;

    $num_items = 0;
    $driver = $dataproxy->$driver_name;
    $entry  = $driver->getEntryPoint();
    $lang_driver_name = (!empty($LANG_SMAP[$driver_name])) ? $LANG_SMAP[$driver_name] : $driver_name;
    if ($entry === false) {
        $entry = $lang_driver_name;
    } else {
        $entry = '<a href="' . $entry . '">' . $lang_driver_name . '</a>';
    }

    $T->set_var('lang_data_source', $entry);
    
    $categories = $driver->getChildCategories(false);
    if (count($categories) == 0) {
        list($num_items, $items) = MYCALJP_buildItems($driver, $driver_name, false);
        $T->set_var('category_list', $items);
    } else {
        $cats = '';
        foreach ($categories as $category) {
            list($num_cat, $cat) = MYCALJP_buildCategory($driver, $driver_name, $category);
            if ($num_cat > 0) $cats .= $cat;
            $num_items += $num_cat;
        }
        $T->set_var('categories', $cats);
        $T->parse('category_list', 't_category_list');
    }
    
    if ($num_items > 0) {
        $T->set_var('num_items', $num_items);
        if ($content == 'stories' && $_MYCALJP2_CONF['showstoriesintro']) {
            $T->set_var('contents', MYCALJP_showStoriesIntro());
            $T->parse('data_sources', 't_data_source_no_hr', true);
        } else {
            $T->parse('data_sources', 't_data_source', true);
        }
    }
}

$T->set_var('lang_site_calendar_result', $LANG_MYCALJP['pickup_title']); // ハードコード
$T->parse('output', 't_index');
$display = $T->finish($T->get_var('output'));
$display = COM_createHTMLDocument($display, array('rightblock' => $_MYCALJP2_CONF['enablesrblocks']));

COM_output($display);
