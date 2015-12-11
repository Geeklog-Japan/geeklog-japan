<?php

// +---------------------------------------------------------------------------+
// | Geeklog Dbman Plugin for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/sql/dbman-mysql.inc                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2014 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
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
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], 'dbman-mysql.inc.php') !== FALSE) {
	die('This file cannot be used on its own.');
}

/*
* Dbman plugin DB-specific functions file for MySQL
*/
if (!defined('LB')) {
	define('LB', "\n");
}

// Data types to be quoted with dbman_quoteString()
$dbman_string_types = array(
	'CHAR', 'VARCHAR', 'DATE', 'TIME', 'DATETIME', 'TIMESTAMP', 'TINYTEXT',
	'TEXT', 'MEDIUMTEXT', 'LONGTEXT', 'ENUM',
);

// Data types to be identified with BLOB
$dbman_blob_types = array(
	'BLOB', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB',
);

/**
* Returns DB server version
*/
function dbman_getDBVersion() {
	$rst = DB_query("SHOW VARIABLES");
	
	if (!DB_error()) {
		while (($r = DB_fetchArray($rst)) !== FALSE) {
			if ($r['Variable_name'] === 'version') {
				return $r['Value'];
			}
		}
	}
	
	return 'unavailable';
}

/**
* Returns table definition used in the current database
*/
function dbman_getTableDef($table_name) {
	$rst = DB_query("SHOW CREATE TABLE {$table_name}");
	
	if ($rst !== FALSE) {
		$r = DB_fetchArray($rst);
		
		if ($r !== FALSE) {
			$retval = rtrim($r['Create Table']);
			$retval = str_replace(array("\r\n", "\r"), LB, $retval);
			
			return $retval . ';';
		}
	}
	
	return FALSE;
}

/**
* Returns table definition extracted from backup file
*/
function dbman_extractTableDefFromBackup($table_name, $filename) {
	
	$retval = array();
	
	$table_name = dbman_quoteItem($table_name);
	$data = file_get_contents($filename);
	$data = str_replace(array("\r\n", "\r"), LB, trim($data));
	$data = explode(LB, $data);
	$num_data = count($data);
	
	for ($i = 0; $i < $num_data; $i ++) {
		if (preg_match("/^[ \t]*CREATE[ \t]+TABLE[ \t]+/i" . $table_name, $data[$i], $dummy)) {
			$retval[] = $data[$i];
			$lbrc = substr_count($data[$i], '(');
			$rbrc = substr_count($data[$i], ')');
			
			while ($lbrc !== $rbrc) {
				$i ++;
				$retval[] = $data[$i];
				$lbrc += substr_count($data[$i], '(');
				$rbrc += substr_count($data[$i], ')');
			}
			
			return implode(LB, $retval);
		}
	}
	
	return FALSE;
}

/**
* Returns an array of table names
*/
function dbman_getTableList() {
	global $_DB_name, $_DB_table_prefix;
	
	$retval = array();
	
	$sql = 'SHOW TABLES LIKE "'
		 . addslashes(str_replace('_', '\\_', $_DB_table_prefix)) . '%"';
	$rst = DB_query($sql);
	
	if ($rst !== FALSE) {
		while (($r = DB_fetchArray($rst, MYSQL_NUM)) !== FALSE) {
			$table_name = $r[0];
			$retval[$table_name]['name'] = $table_name;
		}
	}
	
	return $retval;
}

/**
* Returns quoted name of database, table and column
*/
function dbman_quoteItem($item) {
	return '`' . $item . '`';
}

/**
* Returns quoted string.
*/
function dbman_quoteString($item) {
	$item = str_replace(array("\r", "\n"), array('\\r', '\\n'), $item);
	
	if (!get_magic_quotes_gpc()) {
		$item = addslashes($item);
		$item = str_replace(array('\\\\r', '\\\\n'), array('\\r', '\\n'), $item);
	}
	
	return "'" . $item . "'";
}

/**
* Checks if the designated table has any BLOB field
*
* @param   string   $table_name  the table name to check for
* @return  boolean               TRUE = has a BLOB field, FALSE = none
*/
function dbman_isHasBLOBField($table_name) {
	global $dbman_blob_types;
	
	$defs = explode(LB, dbman_getTableDef($table_name));
	
	foreach ($defs as $def) {
		if (preg_match('/^[ ]*`(.*)`[ ]+([a-zA-Z0-9_]*).*$/i', $def, $match)) {
			$column_name = $match[1];
			$column_def  = strtoupper(trim($match[2]));
			
			if (in_array($column_def, $dbman_blob_types)) {
				return TRUE;
			}
		}
	}
	
	return FALSE;
}

/**
* Returns tables name included in the {$filename} file
*
* @note  backquote char '`' may be mysql-specific
*/
function dbman_getTableNameFromBackup($filename) {
	$retval = array();
	
	if (substr($filename, -3) === '.gz') {
		$fh = gzopen($filename, 'r');
		
		if ($fh === FALSE) {
			return $retval;
		} else {
			$f = '';
			
			while (!gzeof($fh)) {
				$f .= gzread($fh, 10000);
			}
			gzclose($fh);
		}
	} else {
		$f = file_get_contents($filename);
	}
	
	$f = str_replace(array("\r\n", "\r"), LB, $f);
	$f = explode(LB, trim($f));
	
	foreach ($f as $line) {
		if (preg_match("/CREATE[ ]+TABLE[ ]+`(.*)`[ ]*\(/i", $line, $match)) {
			$retval[] = $match[1];
		}
	}
	
	return $retval;
}
