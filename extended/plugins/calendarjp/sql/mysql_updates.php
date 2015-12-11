<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendarjp Plugin for Geeklog                                             |
// +---------------------------------------------------------------------------+
// | Upgrade SQL                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2012 by dengen - taharaxp AT gmail DOT com             |
// |                                                                           |
// | Calendarjp plugin is based on prior work by:                              |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
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

/**
* MySQL updates
*
* @package Calendarjp
*/

$_UPDATES = array(

    '1.1.0' => array(
        "ALTER TABLE {$_TABLES['eventsubmissionjp']} ADD owner_id mediumint(8) unsigned NOT NULL default '1' AFTER timeend"
    ),

    '1.1.4' => array(
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.calendarjp.tab_main', 'Access to configure general calendar settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.calendarjp.tab_permissions', 'Access to configure event default permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.calendarjp.tab_autotag_permissions', 'Access to configure event autotag usage permissions', 0)"        
    ),     

    '1.1.5' => array(
        // Delete Events block since moved to dynamic
        "DELETE FROM {$_TABLES['blocks']} WHERE phpblockfn = 'phpblock_calendarjp'", 
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.calendarjp.tab_events_block', 'Access to configure events block', 0)"
    ),
    
    '1.1.6' => array(
        "ALTER TABLE {$_TABLES['eventsjp']} CHANGE zipcode zipcode varchar(16) default NULL",
        "ALTER TABLE {$_TABLES['eventsubmissionjp']} CHANGE zipcode zipcode varchar(16) default NULL",
        "ALTER TABLE {$_TABLES['personal_eventsjp']} CHANGE zipcode zipcode varchar(16) default NULL",
    ),
);

/**
 * Add is new security rights for the Group "Calendarjp Admin"
 *
 */
function calendarjp_update_ConfigSecurity_1_1_4()
{
    global $_TABLES;
    
    // Add in security rights for Calendarjp Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Calendarjp Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.calendarjp.tab_main';
        $ft_names[] = 'config.calendarjp.tab_permissions';
        $ft_names[] = 'config.calendarjp.tab_autotag_permissions';
        
        foreach ($ft_names as $name) {
            $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$name'");         
            if ($ft_id > 0) {
                $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
                DB_query($sql);
            }
        }        
    }    

}

/**
 * Add in new security rights for the Group "Calendarjp Admin"
 *
 */
function calendarjp_update_ConfigSecurity_1_1_5()
{
    global $_TABLES;
    
    // Add in security rights for Calendarjp Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Calendarjp Admin'");

    if ($group_id > 0) {
        $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'config.calendarjp.tab_events_block'");   
        $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
        DB_query($sql);    
    }    

}

/**
 * Modify zipcode field
 *
 */
function calendarjp_update_Zipcode_1_1_5()
{
    // Nothing to do
}

?>
