<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/dataproxy.php                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own.');
}

/**
* @class dpxyDriver
* @description the parent class of all classes to retrieve data from plugins
*/
abstract class dpxyDriver
{
	protected $_options;
	
	/**
	* Constructor
	*
	* @param  array  $options
	*/
	public function __construct($options = array())
	{
		$this->_options = $options;
	}
	
	/**
	* Returns the location of index.php of each plugin
	*
	* @return  mixed  uri(string) / false(no entry)
	*/
	abstract public function getEntryPoint();
	
	/**
	* Returns meta data of child categories
	*
	* @param  mixed    $pid        id (int/string) of the parent category.
	*                              false means the top category (with no parent).
	* @param  boolean  $all_langs  true = all languages, false = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	abstract public function getChildCategories($pid = false, $all_langs = false);
	
	/**
	* Returns meta data of child categories recursively
	*
	* @param  mixed    $pid        id (int/string) of the parent category.
	*                              false means the top category (with no parent).
	* @param  boolean  $all_langs  true = all languages, false = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	protected function _getChildCategoriesRecursive($pid = false, $all_langs = false)
	{
		$retval = array();
		$entries = $this->getChildCategories($pid, $all_langs);
		
		if (is_array($entries) && (count($entries) > 0)) {
			foreach ($entries as $entry) {
				$retval[] = $entry;
				$retval = array_merge(
					$retval, $this->getChildCategories($entry['id'], $all_langs)
				);
			}
		}
		
		return $retval;
	}
	
	/**
	* @param  boolean  $all_langs  true = all languages, false = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	public function getAllCategories($all_langs = false)
	{
		return $this->_getChildCategoriesRecursive(false, $all_langs);
	}
	
	/**
	* @param  boolean  $all_langs  true = all languages, false = current language
	*/
	public function getAllCategoriesAsLinks($all_langs = false)
	{
		$retval = array();
		$entries = $this->getAllCategories($all_langs);
		
		if (is_array($entries) && (count($entries) > 0)) {
			foreach ($entries as $entry) {
				$link = '';
				
				if ($entry['date'] !== false) {
					$link .= date($this->date_format, $entry['date']);
				}
				
				$link .= '<a href="' . $entry['uri'] . '">'
					  .  $this->escape($entry['title']) . '</a>' . LB;
				$retval[] = $link;
			}
		}
		
		return $retval;
	}
	
	/**
	* Returns the info of the corresponding item
	*
	* @param  boolean  $all_langs  true = all languages, false = current language
	* @return array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*   'raw_data'  => raw data of the item (stripslashed)
	*)
	*/
	abstract public function getItemById($id, $all_langs = false);
	
	/**
	* Returns meta data of items under a given category
	*
	* @param  boolean  $all_langs  true = all languages, false = current language
	* @return array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*)
	*/
	abstract public function getItems($category, $all_langs = false);
	
	/**
	* Returns meta data of items under a given date
	*
	* @param  boolean  $all_langs  true = all languages, false = current language
	* @return array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*)
	*/
	public function getItemsByDate($category = '', $all_langs = false)
	{
		return array();
	}
	
	/**
	* @param  boolean  $all_langs  true = all languages, false = current language
	*/
	public function getItemsAsLinks($category = '', $all_langs = false)
	{
		$retval  = array();
		$entries = $this->getItems($category, $all_langs);
		
		if (is_array($entries) && (count($entries) > 0)) {
			foreach ($entries as $entry) {
				$link = '';
				
				if ($entry['date'] !== false) {
					$link .= date($this->_options['date_format'], $entry['date']);
				}
				
				$link .= '<a href="' . $entry['uri'] . '">'
					  .  $this->escape($entry['title']) . '</a>' . LB;
				$retval[] = $link;
			}
		}
		
		return $retval;
	}
	
	/**
	* @param  boolean  $all_langs  true = all languages, false = current language
	*/
	public function getAllItems($all_langs = false)
	{
		$retval = $this->getItems(false, $all_langs);
		$cats   = $this->getAllCategories($all_langs);
		
		if (is_array($cats) && (count($cats > 0))) {
			foreach ($cats as $cat) {
				$retval = array_merge($retval, $this->getItems($cat['id'], $all_langs));
			}
		}
		
		return $retval;
	}
	
	/**
	* Escapes a string for display
	*
	* @param   string  $str  a string to escape
	* @return  string  an escaped string
	*/
	public function escape($str)
	{
		return Dataproxy::escape($str);
	}
	
	/**
	* Converts a string into utf-8 if necessary
	*/
	public function toUtf8($str)
	{
		if (strcasecmp(Dataproxy::encoding(), 'utf-8') !== 0) {
			if (is_callable('mb_convert_encoding')) {
				$str = mb_convert_encoding($str, 'utf-8', Dataproxy::encoding());
			} else if (is_callable('iconv')) {
				$str = iconv(Dataproxy::encoding(), 'utf-8', $str);
			} else if ((strcasecmp(Dataproxy::encoding(), 'iso-8859-1') === 0) &&
					    is_callable('utf8_encode')) {
				$str = utf8_encode($str);
			} else {
				COM_errorLog('Dataproxy: Error!  No way to convert data into UTF-8.');
			}
		}
		
		return $str;
	}
	
	/**
	* Call back function for cleanUrl method
	*
	* @param  array $matches
	* @return string
	*/
	public function cleanUrlCallBack($matches)
	{
		return chr(hexdec($matches[1]));
	}
	
	/**
	* Another call back function for cleanUrl method
	*
	* @param  array $matches
	* @return string
	*/
	public function cleanUrlCallBack2($matches)
	{
		return chr($matches[1]);
	}

	/**
	* Cleans a URL
	*
	* @note This function removes the strings 'JavaScript:', '<script>', 
	*       '</script>', or 'document.write' in a given URL.  This might be
	*       a bit too strict.
	*/
	public function cleanUrl($url)
	{
		/**
		* Decodes HTML entities
		*/
		
		// %dd --> chr(0xdd)
		$url = preg_replace_callback('/%([\dA-F]{2})/i', array($this, 'cleanUrlCallBack'), $url);
		
		// \xdd --> chr(0xdd)
		$url = preg_replace_callback('/\\\\x([\dA-F]{2})/i', array($this, 'cleanUrlCallBack'), $url);
		
		// \udddd --> chr(0xdddd)
		$url = preg_replace_callback('/\\\\u([\dA-F]{4})/i', array($this, 'cleanUrlCallBack'), $url);
		
		// &[lL][tT](;) --> &
		$search  = array('/&lt;?/i', '/&gt;?/i', '/&quot;?/i', '/&raquo;?/i');
		$replace = array('<', '>', '"', "'");
		$url = preg_replace($search, $replace, $url);
		
		// &#\d{1,7}(;) --> d
		$url = preg_replace_callback('/&#(\d{1,7});?/', array($this, 'cleanUrlCallBack2'), $url);
		
		// &#x[0-9a-fA-F]{1,7}(;) --> d
		$url = preg_replace_callback('/&#x([\dA-F]{1,7});?/i', array($this, 'cleanUrlCallBack'), $url);
		
		/**
		* Starts cleaning
		*/
		
		// Removes control codes
		$url = preg_replace('/[\x00-\x20\x7F\xAD]/', '', $url);
		
		// '+' --> ' '
		$url = str_replace('+', ' ', $url);
		
		// Removes 'JavaScript:'
		$url = preg_replace('/J\s*A\s*V\s*A\s*S\s*C\s*R\s*I\s*P\s*T\s*/i', '', $url);
		
		/**
		* Maybe, the follwoing three functions are not necessary to sanitize
		* URLs
		*/
		// Removes '<script>'
		$url = preg_replace('/<SCRIPT[^>]*>/i', '', $url);
		
		// Removes '</script>'
		$url = preg_replace('/<\/SCRIPT>/i', '', $url);
		
		// Removes 'document.write'
		$url = preg_replace('/DOCUMENT\.WRITE/i', '', $url);
		
		return $url;
	}
	
	public function escapeString($str)
	{
		return is_callable('DB_escapeString') ? DB_escapeString($str) : addslashes($str);
	}
}

/**
* @class Dataproxy
*/
class Dataproxy
{
	static private $_uid      = 1;
	static private $_encoding = 'utf-8';
	static private $_options  = array();
	
	static public $startDate  = null;
	static public $endDate    = null;
	static public $isGL150    = true;
	static public $isGL170    = true;
	static public $isGL200    = true;
	
	/**
	* Dataproxy drivers are loaded in the following order
	*
	* @caution NEW DRIVERS must be added to the following list
	*/
	static private $_supported_drivers = array(
			'article', 'comments', 'trackback',
			'staticpages', 'calendar', 'links', 'polls',
			'dokuwiki', 'forum', 'filemgmt', 'faqman', 'mediagallery',
			'calendarjp', 'downloads',
		);
	
	/**
	* References to the loaded drivers
	*/
	static private $_loaded_drivers = array();
	
	/**
	* Constructor
	*
	* @param  int     $uid       0 (= Root), 1(= anon), user id
	* @param  string  $encoding  encoding of the content
	* @param  array   $options
	*/
	private function __construct($uid = 1, $encoding = 'utf-8', $options = array())
	{
		global $_CONF, $_PLUGINS, $_DPXY_CONF;
		
		if (count($options) === 0) {
			$options = $_DPXY_CONF;
		}
		
		if (empty($encoding)) {
			$encoding = COM_getCharset();
		}
		
		// Initializes settings
		self::$_uid      = (int) $uid;
		self::$_encoding = $encoding;
		self::$_options  = $options;
		
		$gl_version = preg_replace("/[^0-9.]/", '', VERSION);
		self::$isGL150 = (version_compare($gl_version, '1.5.0') >= 0);
		self::$isGL170 = (version_compare($gl_version, '1.7.0') >= 0);
		self::$isGL200 = (version_compare($gl_version, '2.0.0') >= 0);
		
		// Loads drivers whose driver exists and plugin is enabled
		$base_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'drivers';
		$enabled_plugins = array_merge(
			$_PLUGINS, array('article', 'comments', 'trackback')
		);
		
		foreach (self::$_supported_drivers as $driver) {
			$file = $driver;
			
			if (($file === 'article') && self::$isGL200) {
				$file = 'article2';
			}
			
			$path = $base_path . DIRECTORY_SEPARATOR . $file . '.class.php';
			
			if (is_file($path) && in_array($driver, $enabled_plugins)) {
				require_once $path;
				$class_name = 'dpxyDriver_' . ucfirst($driver);
				self::$_loaded_drivers[$driver] = new $class_name(self::$_options);
			}
		}
	}
	
	/**
	* Returns the only instance of the class (singleton)
	*
	* @param  int     $uid       0 (= Root), 1(= anon), user id
	* @param  string  $encoding  encoding of the content
	* @param  array   $options
	*/
	static public function getInstance($uid = 1, $encoding = 'utf-8', $options = array())
	{
		static $instance = null;
		
		if ($instance === null) {
			$instance = new self($uid, $encoding, $options);
		}
		
		return $instance;
	}
	
	public function __clone()
	{
		throw new Exception('You cannot clone this object.');
	}
	
	public function __get($name)
	{
		if (array_key_exists($name, self::$_loaded_drivers)) {
			return self::$_loaded_drivers[$name];
		} else {
			throw new Exception(__METHOD__ . ': unknown driver name "' . $name . '" was supplied.');
		}
	}
	
	static public function uid()
	{
		return self::$_uid;
	}
	
	static public function encoding()
	{
		return self::$_encoding;
	}
	
	static public function options()
	{
		return self::$_options;
	}
	
	static public function isRoot()
	{
		return (self::$_uid === 0);
	}
	
	static public function isAnon()
	{
		return (self::$_uid === 1);
	}
	
	public function setDateStart($datestart = '')
	{
		if (!empty($datestart)) {
			$delim = substr($datestart, 4, 1);
			
			if (!empty($delim)) {
				$DS = explode($delim, $datestart);
				self::$startDate = mktime(0, 0, 0, $DS[1], $DS[2], $DS[0]);
			}
		}
	}
	
	public function setDateEnd($dateend = '')
	{
		if (!empty($dateend)) {
			$delim = substr($dateend, 4, 1);
			
			if (!empty($delim)) {
				$DE = explode($delim, $dateend);
				self::$endDate = mktime(23, 59, 59, $DE[1], $DE[2], $DE[0]);
			}
		}
	}
	
	/**
	* Returns an array of all loaded driver names
	*/
	static public function getAllDriverNames()
	{
		return array_keys(self::$_loaded_drivers);
	}
	
	/**
	* Returns an array of all supported driver names
	*/
	static public function getAllSupportedDriverNames()
	{
		return self::$_supported_drivers;
	}
	
	/**
	* Escapes a string for display
	*
	* @param   string  $str  a string to escape
	* @return  string  an escaped string
	*/
	static public function escape($str)
	{
		$str = str_replace(
			array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
			array(   '<',    '>',     '&',      '"',      "'"),
			$str
		);
		
		return htmlspecialchars($str, ENT_QUOTES, self::$_encoding);
	}
}
