<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Captcha Plugin 3.4                                                        |
// +---------------------------------------------------------------------------+
// | mysql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013 by the following authors:                              |
// |                                                                           |
// | Authors: Ben         - ben AT geeklog DOT fr                              |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

$_SQL['cp_sessions'] =
            "CREATE TABLE {$_TABLES['cp_sessions']} ( " .
            "  `session_id` varchar(40) NOT NULL default '', " .
            "  `cptime`  INT(11) NOT NULL default 0, " .
            "  `validation` varchar(40) NOT NULL default '', " .
            "  `counter`    TINYINT(4) NOT NULL default 0, " .
            "  PRIMARY KEY (`session_id`) " .
            " );";

?>
