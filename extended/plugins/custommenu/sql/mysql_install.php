<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/sql/mysql_install.php                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2013 dengen - taharaxp AT gmail DOT com                |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett               -    twillett AT users DOT sourceforge DOT net  |
// | Blaine Lang               -    langmail AT sympatico DOT ca               |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                -    tony AT tonybibbs DOT com                  |
// | Modified by:                                                              |
// | mystral-kk                -    geeklog AT mystral-kk DOT net              |
// | dengen                    -    taharaxp AT gmail DOT com                  |
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
// $Id$

$_SQL[] = "
CREATE TABLE {$_TABLES['menuitems']} (
  mid varchar(40) NOT NULL default '',
  pmid varchar(40) NOT NULL default '',
  is_enabled tinyint(1) unsigned NOT NULL default '1',
  type varchar(20) NOT NULL default 'custom',
  mode varchar(20) NOT NULL default 'fixation',
  label varchar(48) default NULL,
  label_var varchar(48) default NULL,
  php_function varchar(48) default NULL,
  url varchar(255) default NULL,
  icon_url varchar(255) default NULL,
  class_name varchar(48) default NULL,
  tid varchar(20) NOT NULL default 'all',
  menuorder smallint(5) unsigned NOT NULL default '1',
  pattern varchar(255) default NULL,
  is_preg tinyint(1) NOT NULL default '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY (mid)
) ENGINE=MyISAM
";
?>
