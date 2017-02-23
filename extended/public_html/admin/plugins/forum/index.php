<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// | Main Forum Admin program                                                  |
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

$display = '';
$display .= COM_startBlock($LANG_GF91['gfstats']);

$navbar->set_selected($LANG_GF06['1']);
$display .= $navbar->generate();

// CATEGORIES
$numcats     = DB_query("SELECT id FROM {$_TABLES['forum_categories']}");
$totalcats   = DB_numRows($numcats);
// FORUMS
$numforums   = DB_query("SELECT forum_id FROM {$_TABLES['forum_forums']}");
$totalforums = DB_numRows($numforums);
// TOPICS
$numtopics   = DB_query("SELECT id FROM {$_TABLES['forum_topic']} WHERE pid = 0");
$totaltopics = DB_numRows($numtopics);
// POSTS
$numposts    = DB_query("SELECT id FROM {$_TABLES['forum_topic']}");
$totalposts  = DB_numRows($numposts);
// VIEWS
$numviews    = DB_query("SELECT SUM(views) AS TOTAL FROM {$_TABLES['forum_topic']}");
$totalviews  = DB_fetchArray($numviews);
if ($totalviews['TOTAL'] === NULL) {
    $totalviews['TOTAL'] = 0;
}

// AVERAGE POSTS
if ($totalposts != 0) {
    $avgcposts = $totalposts / $totalcats;
    $avgcposts = round($avgcposts);
    $avgfposts = $totalposts / $totalforums;
    $avgfposts = round($avgfposts);
    $avgtposts = $totalposts / $totaltopics;
    $avgtposts = round($avgtposts);
} else {
    $avgcposts = 0;
    $avgfposts = 0;
    $avgtposts = 0;
}


// AVERAGE VIEWS
if ($totalviews['TOTAL'] != 0) {
    $avgcviews = $totalviews['TOTAL'] / $totalcats;
    $avgcviews = round($avgcviews);
    $avgfviews = $totalviews['TOTAL'] / $totalforums;
    $avgfviews = round($avgfviews);
    $avgtviews = $totalviews['TOTAL'] / $totaltopics;
    $avgtviews = round($avgtviews);
} else {
    $avgcviews = 0;
    $avgfviews = 0;
    $avgtviews = 0;
}


$indextemplate = COM_newTemplate(CTL_plugin_templatePath('forum', 'admin'));
$indextemplate->set_file (array ('indextemplate'=>'index.thtml'));

$indextemplate->set_var('statsmsg', $LANG_GF91['statsmsg']);
$indextemplate->set_var('totalcatsmsg', $LANG_GF91['totalcats']);
$indextemplate->set_var('totalcats', $totalcats);
$indextemplate->set_var('totalforumsmsg', $LANG_GF91['totalforums']);
$indextemplate->set_var('totalforums', $totalforums);
$indextemplate->set_var('totaltopicsmsg', $LANG_GF91['totaltopics']);
$indextemplate->set_var('totaltopics', $totaltopics);
$indextemplate->set_var('totalpostsmsg', $LANG_GF91['totalposts']);
$indextemplate->set_var('totalposts', $totalposts);
$indextemplate->set_var('totalviewsmsg', $LANG_GF91['totalviews']);
$indextemplate->set_var('totalviews', $totalviews['TOTAL']);
$indextemplate->set_var('category', $LANG_GF91['category']);
$indextemplate->set_var('forum', $LANG_GF91['forum']);
$indextemplate->set_var('topic', $LANG_GF91['topic']);
$indextemplate->set_var('avgpmsg', $LANG_GF91['avgpmsg']);
$indextemplate->set_var('avgcposts', $avgcposts);
$indextemplate->set_var('avgfposts', $avgfposts);
$indextemplate->set_var('avgtposts', $avgtposts);
$indextemplate->set_var('avgvmsg', $LANG_GF91['avgvmsg']);
$indextemplate->set_var('avgcviews', $avgcviews);
$indextemplate->set_var('avgfviews', $avgfviews);
$indextemplate->set_var('avgtviews', $avgtviews);

$indextemplate->parse ('output', 'indextemplate');
$display .= $indextemplate->finish ($indextemplate->get_var('output'));
$display .= COM_endBlock();
$display = COM_createHTMLDocument($display);

COM_output($display);
?>
