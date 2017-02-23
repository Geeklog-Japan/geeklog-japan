<?php

// +---------------------------------------------------------------------------+
// | Geeklog Dbman Plugin for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/sql/dbman-mysql.inc                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2012 mystral-kk - geeklog AT mystral-kk DOT net        |
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

if (stripos($_SERVER['PHP_SELF'], 'dbman-mysql.inc.php') !== false) {
	die('This file cannot be used on its own.');
}

class Dbman
{
	const LB = "\n";
	
	// Data types to be quoted with dbman_quoteString()
	public static $stringTypes = array(
		'CHAR', 'VARCHAR', 'DATE', 'TIME', 'DATETIME', 'TIMESTAMP', 'TINYTEXT',
		'TEXT', 'MEDIUMTEXT', 'LONGTEXT', 'ENUM',
	);

	// Data types to be identified with BLOB
	public static $blobTypes = array(
		'BLOB', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB',
	);

	/**
	* Return DB server version
	*
	* @return string
	*/
	public static function getDBVersion()
	{
		$rst = DB_query("SHOW VARIABLES");
	
		if (!DB_error()) {
			while (($r = DB_fetchArray($rst)) !== false) {
				if ($r['Variable_name'] === 'version') {
					return $r['Value'];
				}
			}
		}
	
		return 'unavailable';
	}

	/**
	* Returns table definition used in the current database
	*
	* @param  string $table_name
	* @return string|false
	*/
	public static function getTableDefinition($table_name)
	{
		$rst = DB_query("SHOW CREATE TABLE {$table_name}");
	
		if ($rst !== false) {
			$r = DB_fetchArray($rst);
		
			if ($r !== false) {
				$retval = rtrim($r['Create Table']);
				$retval = str_replace(array("\r\n", "\r"), self::LB, $retval);
			
				return $retval . ';';
			}
		}
	
		return false;
	}

	/**
	* Return table definition extracted from backup file
	*
	* @param  string $table_name
	* @param  string $filename
	* @return string
	*/
	public static function extractTableDefinitionFromBackup($table_name, $filename)
	{
		$retval = array();
	
		$table_name = dbman_quoteItem($table_name);
		$data = file_get_contents($filename);
		$data = str_replace(array("\r\n", "\r"), self::LB, trim($data));
		$data = explode(self::LB, $data);
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
			
				return implode(self::LB, $retval);
			}
		}
	
		return false;
	}

	/**
	* Return an array of table names
	*
	* @return array
	*/
	public static function getTableList()
	{
		global $_DB_name, $_DB_table_prefix;
	
		$retval = array();
	
		$sql = 'SHOW TABLES LIKE "'
			 . self::escapeString(str_replace('_', '\\_', $_DB_table_prefix)) . '%"';
		$rst = DB_query($sql);
	
		if ($rst !== false) {
			while (($r = DB_fetchArray($rst, MYSQL_NUM)) !== false) {
				$table_name = $r[0];
				$retval[$table_name]['name'] = $table_name;
			}
		}
	
		return $retval;
	}
	
	/**
	* Escape a string
	*
	* @param  string $str
	* @return string
	*/
	public static function escapeString($str)
	{
		if (is_callable('DB_escapeString')) {
			return DB_escapeString($str);
		} else {
			return addslashes($str);
		}
	}

	/**
	* Return a quoted name of database, table and column
	*
	* @param  string $item
	* @return string
	*/
	public function quoteIdentifier($item)
	{
		return '`' . $item . '`';
	}

	/**
	* Return quoted string
	*
	* @param  string $item
	* @return string
	*/
	public static function quoteString($item) {
		$item = str_replace(array("\r", "\n"), array('\\r', '\\n'), $item);
	
		if (!get_magic_quotes_gpc()) {
			$item = self::escapeString($item);
			$item = str_replace(array('\\\\r', '\\\\n'), array('\\r', '\\n'), $item);
		}
	
		return "'" . $item . "'";
	}

	/**
	* Checks if the designated table has any BLOB field
	*
	* @param   string   $table_name  the table name to check for
	* @return  boolean               true = has a BLOB field, false = none
	*/
	public function dbman_isHasBLOBField($table_name)
	{
		global $dbman_blob_types;
	
		$defs = explode(self::LB, dbman_getTableDef($table_name));
	
		foreach ($defs as $def) {
			if (preg_match('/^[ ]*`(.*)`[ ]+([a-zA-Z0-9_]*).*$/i', $def, $match)) {
				$column_name = $match[1];
				$column_def  = strtoupper(trim($match[2]));
			
				if (in_array($column_def, $dbman_blob_types)) {
					return true;
				}
			}
		}
	
		return false;
	}

	/**
	* Returns tables name included in the {$filename} file
	*
	* @param  string $filename
	* @return string
	* @note   backquote char '`' may be mysql-specific
	*/
	public function getTableNameFromBackup($filename)
	{
		$retval = array();
	
		if (substr($filename, -3) === '.gz') {
			$fh = gzopen($filename, 'r');
		
			if ($fh === false) {
				return $retval;
			} else {
				$f = '';
			
				while (!gzeof($fh)) {
					$f .= gzread($fh, 10000);
				}
				gzclose($fh);
			}
		} else {
			$f = @file_get_contents($filename);
		}
	
		$f = str_replace(array("\r\n", "\r"), self::LB, $f);
		$f = explode(self::LB, trim($f));
	
		foreach ($f as $line) {
			if (preg_match("/CREATE[ ]+TABLE[ ]+`(.*)`[ ]*\(/i", $line, $match)) {
				$retval[] = $match[1];
			}
		}
	
		return $retval;
	}
}
