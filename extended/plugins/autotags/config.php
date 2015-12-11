<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Plugin 1.0                                                       |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// +---------------------------------------------------------------------------+
// | Autotags Plugin Copyright (C) 2006 by the following authors:              |
// |          Joe Mucchiello    - jmucchiello AT yahoo DOT com                 |
// +---------------------------------------------------------------------------+
// | Based on the Universal Plugin and prior work by the following authors:    |
// |                                                                           |
// | Copyright (C) 2000-2012 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'config.php') !== false) {
    die('This file can not be used on its own.');
}

$_AUTO_CONF = Array();

$_AUTO_CONF['version'] = '1.1.1';

/*
 *  Adds a link to top menu for access to the autotag link in
 *  /public_html/autotags/index.php
 *
 *  There is no other link to this page in the system. Working it into
 *  the submit screen or adding a block with a link to it is up to the
 *  site administrator.
 */
$_AUTO_CONF['link_in_menu'] = 0;

/*
 *  Autotag editor will not allow any value in this array to be used as
 *  a tag. This array is merged with the existing list of autotags to
 *  determine whether or not a given autotag is already in use. You
 *  generally will not need to put anything into this list, but I'm sure
 *  someone will have a use for this.
 *
 *  This defaults to ('geeklog') because the builtin autotags for 'story'
 *  and 'event' claim to be in the 'geeklog' plugin.
 */
$_AUTO_CONF['disallow'] = array('geeklog');

/*
 *  This is similar in function to the static page PHP functions. Access
 *  to executable code requires both this value to be 1 and that the
 *  user have access to the autotags.PHP feature which is NOT granted to
 *  Root by the installer.
 *
 *  Unlike static pages, the autotag callback function for function
 *  based tags has a fixed name in the format phpautotags_$tag. The
 *  parameters to these function are based on the standard autotag code.
 *  Autotags have the format
 *      [tag:parameter1 the remainderis parameter2]
 *  Thus the function specification
 *      phpautotags_$tag($p1, $p2, $fulltext)
 *  puts parameter1 into $p1, parameter2 into $p2 and all the text
 *  between the brackets (including the brackets) is put into $fulltext.
 */
$_AUTO_CONF['allow_php'] = 1;

// Database tables
$_TABLES['autotags']  = $_DB_table_prefix . 'autotags_plg';	

?>