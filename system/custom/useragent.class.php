<?php

// +---------------------------------------------------------------------------+
// | useragent.class.php                                                       |
// |                                                                           |
// | Copyright (C) 2011 by the following authors:                              |
// |                                                                           |
// | Author: Kenji ITO          - geeklog AT mystral-kk DOT net                |
// |                                                                           |
// | Permission is hereby granted, free of charge, to any person obtaining a   |
// | copy of this software and associated documentation files (the "Software"),|
// | to deal in the Software without restriction, including without limitation |
// | the rights to use, copy, modify, merge, publish, distribute, sublicense,  |
// | and/or sell copies of the Software, and to permit persons to whom the     |
// | Software is furnished to do so, subject to the following conditions:      |
// | The above copyright notice and this permission notice shall be included   |
// | in all copies or substantial portions of the Software.                    |
// |                                                                           |
// | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS   |
// | OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF                |
// | MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN |
// | NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,  |
// | DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR     |
// | OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE |
// | USE OR OTHER DEALINGS IN THE SOFTWARE.                                    |          
// +---------------------------------------------------------------------------+

/**
* useragent.class.php
*
* @copyright    (C) 2011 Kenji ITO
* @author       Kenji ITO - geeklog AT mystral-kk DOT net
* @license      MIT
* @version      1.0.0 alpha (2011-11-16)
* @description  This class retrieves the information about a user agent.
* @note         This class doesn't require Geeklog.
*/
class Useragent
{
	// OS
	const WINDOWS             = 'win';
	const WINDOWS_CE          = 'win-ce';
	const WINDOWS_PHONE       = 'win-ce';
	const IOS                 = 'ios';
	const MACINTOSH           = 'mac';
	const ANDROID             = 'android';
	const BLACKBERRY          = 'blackberry';
	const SYMBIAN             = 'symbian';
	const WEBOS               = 'webos';
	const CHROME_OS           = 'cros';
	const LINUX               = 'unix';
	const BSD                 = 'unix';
	const UNIX                = 'unix';
	const J2ME_MIDP           = 'midp';
	const WII                 = 'wii';
	const OS_OTHERS           = 'unknown';
	
	// Browser names
	const INTERNET_EXPLORER   = 'ie';
	const FIREFOX             = 'firefox';
	const GOOGLE_CHROME       = 'chrome';
	const SAFARI              = 'safari';
	const OPERA               = 'opera';
	const CAMINO              = 'camino';
	const KONQUEROR           = 'konqueror';
	const IE_MOBILE           = 'ie-mobile';
	const OPERA_MINI          = 'opera-mini';
	const OPERA_MOBILE        = 'opera-mobile';
	const OMNIWEB             = 'omniweb';
	const NETFRONT            = 'netfront';
	const DOCOMO              = 'docomo';
	const AU                  = 'au';
	const SOFTBANK            = 'softbank';
	const WILCOM              = 'wilcom';
	const EMOBILE             = 'emobile';
	const BROWSER_OTHERS      = 'default';
	
	// Brower name aliases
	const A_INTERNET_EXPLORER = 'ie';
	const A_FIREFOX           = 'fx';
	const A_GOOGLE_CHROME     = 'ch';
	const A_SAFARI            = 'sf';
	const A_OPERA             = 'op';
	const A_CAMINO            = 'ca';
	const A_KONQUEROR         = 'ko';
	const A_IE_MOBILE         = 'im';
	const A_OPERA_MINI        = 'oi';
	const A_OPERA_MOBILE      = 'om';
	const A_OMNIWEB           = 'ow';
	const A_NETFRONT          = 'nf';
	const A_DOCOMO            = 'dc';
	const A_AU                = 'au';
	const A_SOFTBANK          = 'sb';
	const A_WILCOM            = 'wc';
	const A_EMOBILE           = 'em';
	const A_BROWSER_OTHERS    = '';
	
	// Parsed data
	private $_data;
	
	/**
	* Constructor
	*
	* @param  string  $user_agent (optional)
	*/
	private function __construct($user_agent = NULL)
	{
		$this->_data = $this->parseUserAgent($user_agent);
	}
	
	/**
	* Returns the only instance of this class (singleton)
	*
	* @param   string  $user_agent (optional)
	* @return  object of Useragent class
	*/
	static public function getInstance($user_agent = NULL)
	{
		static $instance = NULL;
		
		if ($instance === NULL) {
			$instance = new self($user_agent);
		}
		
		return $instance;
	}
	
	public function __get($name)
	{
		if (array_key_exists($name, $this->_data)) {
			return $this->_data[$name];
		} else {
			return '';
		}
	}
	
	public final function __clone()
	{
		throw new Exception('You cannot clone this object.');
	}
	
	/**
	* Parses a user agent string and returns info
	*
	* @param    string  $useragent  a user agent expression (optional)
	* @return   array(
	*               string   'class'      class name to be used in <body> tag
	*               string   'os'         OS name
	*               string   'browser'    browser name
	*               string   'version'    browser version
	*               string   'alias'      alias for browser name
	*               boolean  'mobile'     TRUE = mobile, FALSE = otherwise
	*               string   'raw'        raw user agent string
	*           )
	*
	*           'class'     - 'os' . ' ' . 'browser' . (' ' . 'alias' . 'version')
	*                         . (' mobile')
	*           'os'        - 'win', 'win-ce', 'ios', 'mac', 'android',
	*                         'blackberry', 'symbian', 'webos', 'cros', 'unix',
	*                         'midp', 'wii', 'unknown'
	*           'browser'   - 'ie', 'firefox', 'chrome', 'safari', 'opera',
	*                         'camino', 'konqueror', 'ie-mobile', 'opera-mini',
	*                         'opera-mobile',  'omniweb', 'netfront', 'docomo',
	*                         'au', 'softbank', 'willcom', 'emobile', 'default'
	*           'shorthand' - 'ie', 'fx', 'ch', 'sf', 'op', 'ca', 'ko', 'im',
	*                         'oi', 'om', 'ow', 'nf', 'dc', 'au', 'sb', 'wc',
	*                         'em', ''
	* @note     This function doesn't require Geeklog.
	*/
	public function parseUserAgent($user_agent = NULL)
	{
		// Sets default values
		$os      = self::OS_OTHERS;
		$browser = self::BROWSER_OTHERS;
		$version = '';
		$alias   = self::A_BROWSER_OTHERS;
		$mobile  = FALSE;
		$class   = '';
		
		if ($user_agent === NULL) {
			$user_agent = @$_SERVER['HTTP_USER_AGENT'];
		}
		
		$ua = preg_replace('@[^ \.0-9a-zA-Z/;()_-]@', '', $user_agent);
		
		// Checks OS
		if (strpos($ua, 'Windows') !== FALSE) {
			if (strpos($ua, 'Windows CE') !== FALSE) {
				$os      = self::WINDOWS_CE;
				$browser = self::IE_MOBILE;
				$alias   = self::A_IE_MOBILE;
				$mobile  = TRUE;
			} else if (strpos($ua, 'Windows Phone OS') !== FALSE) {
				$os      = self::WINDOWS_PHONE;
				$browser = self::IE_MOBILE;
				$alias   = self::A_IE_MOBILE;
				$mobile  = TRUE;
			} else {
				$os = self::WINDOWS;
			}
			
			if (preg_match('|IEMobile[ /](\d+)|', $ua, $M)) {
				$version = $M[1];
			}
		} else if (strpos($ua, 'iPhone') !== FALSE) {
			$os     = self::IOS;
			$mobile = (strpos($ua, 'iPad') === FALSE);
		} else if ((strpos($ua, 'Macintosh') !== FALSE) OR
				   (strpos($ua, 'Mac OSX') !== FALSE) OR
				   (strpos($ua, 'Mac OS X') !== FALSE) OR
				   (strpos($ua, 'Mac_PowerPC') !== FALSE)) {
			$os = self::MACINTOSH;
		} else if (strpos($ua, 'Android') !== FALSE) {
			$os     = self::ANDROID;
			
			if (stripos($ua, 'mobile') !== FALSE) {
				$mobile = TRUE;
			}
		} else if (strpos($ua, 'BlackBerry') !== FALSE) {
			$os     = self::BLACKBERRY;
			$mobile = TRUE;
		} else if ((strpos($ua, 'Symbian') !== FALSE) OR
				   (strpos($ua, 'SymbOS') !== FALSE) OR
				   (strpos($ua, 'Series 60') !== FALSE)) {
			$os = self::SYMBIAN;
			
			if (strpos($ua, 'Tablet') === FALSE) {
				$mobile = TRUE;
			}
		} else if (strpos($ua, 'webOS') !== FALSE) {
			$os = self::WEBOS;
		} else if (strpos($ua, 'Linux') !== FALSE) {
			$os = self::LINUX;
		} else if ((strpos($ua, 'FreeBSD') !== FALSE) OR
				   (strpos($ua, 'NetBSD') !== FALSE) OR
				   (strpos($ua, 'OpenBSD') !== FALSE) OR
				   (strpos($ua, 'DragonFly') !== FALSE)) {
			$os = self::BSD;
		} else if ((strpos($ua, 'SunOS') !== FALSE) OR
				   (strpos($ua, 'OpenSolaris') !== FALSE) OR
				   (strpos($ua, 'UNIX') !== FALSE) OR
				   (strpos($ua, 'BeOS') !== FALSE)) {
			$os = self::UNIX;
		} else if (strpos($ua, 'CrOS') !== FALSE) {
			$os = self::CHROME_OS;
		} else if (strpos($ua, 'J2ME/MIDP') !== FALSE) {
			$os = self::J2ME_MIDP;
		} else if (preg_match('|^DoCoMo\/([12])\.0|i', $ua, $M)) {
			$os      = self::DOCOMO;
			$browser = self::DOCOMO;
			$version = $M[1];
			$alias   = self::A_DOCOMO;
			$mobile  = TRUE;
		} else if ((strpos($ua, 'SoftBank') !== FALSE) OR
				   (strpos($ua, 'J-PHONE') !== FALSE) OR
				   (strpos($ua, 'Vodafone') !== FALSE) OR
				   (strpos($ua, 'MOT-C') !== FALSE) OR
				   (strpos($ua, 'MOT-V') !== FALSE) OR
				   (strpos($ua, 'Semulator') !== FALSE)) {
			$os      = self::SOFTBANK;
			$browser = self::SOFTBANK;
			$alias   = self::A_SOFTBANK;
			$mobile  = TRUE;
		} else if ((strpos($ua, 'UP.Browser') !== FALSE) OR
				   (strpos($ua, 'KDDI-') !== FALSE)) {
			$os      = self::AU;
			$browser = self::AU;
			$alias   = self::A_AU;
			$mobile  = TRUE;
		} else if ((strpos($ua, 'DDIPOCKET') !== FALSE) OR
				   (strpos($ua, 'WILLCOM') !== FALSE)) {
			$os      = self::WILCOM;
			$browser = self::WILCOM;
			$alias   = self::A_WILCOM;
			$mobile  = TRUE;
		} else if ((strpos($ua, 'jigbrowserweb') !== FALSE) OR
				   (strpos($ua, 'Y!J-SRD/1.0') !== FALSE) OR
				   (strpos($ua, 'Y!J-MBS/1.0') !== FALSE)) {
			$mobile = TRUE;
		} else if (strpos($ua, 'emobile/') === 0) {
			$os      = self::EMOBILE;
			$browser = self::EMOBILE;
			$alias   = self::A_EMOBILE;
			$mobile  = TRUE;
		} else if (strpos($ua, 'Nintendo Wii') !== FALSE) {
			$os = self::WII;
		}
		
		// Checks browser
		if (strpos($ua, 'Opera') !== FALSE) {
			if (preg_match('|Opera Mini/(\d+)|', $ua, $M)) {
				$browser = self::OPERA_MINI;
				$version = $M[1];
				$alias   = self::A_OPERA_MINI;
				$mobile  = TRUE;
			} else {
				if (strpos($ua, 'Opera Mobi') !== FALSE) {
					$browser = self::OPERA_MOBILE;
					$alias   = self::A_OPERA_MOBILE;
					$mobile  = TRUE;
				} else {
					$browser = self::OPERA;
					$alias   = self::A_OPERA;
				}
				
				if (preg_match('|Version/(\d+)|', $ua, $M)) {
					$version = $M[1];
				} else if (preg_match('|Opera[ /](\d+)|', $ua, $M)) {
					$version = $M[1];
				}
			}
		} else if (preg_match('|MSIE (\d+)|', $ua, $M)) {
			$version = $M[1];
			
			if (!$mobile) {
				$browser = self::INTERNET_EXPLORER;
				$alias   = self::A_INTERNET_EXPLORER;
			}
		} else if (preg_match('@(?:Chrome|Chromium)/(\d+)?@', $ua, $M)) {
			$browser = self::GOOGLE_CHROME;
			$version = (count($M) === 2) ? $M[1] : '';
			$alias   = self::A_GOOGLE_CHROME;
		} else if (preg_match('|[Ff]irefox(?:[/ ](\d+))?|', $ua, $M)) {
			$browser = self::FIREFOX;
			$version = (count($M) === 2) ? $M[1] : '';
			$alias   = self::A_FIREFOX;
		} else if ((strpos($ua, 'Safari') !== FALSE) OR
				   (strpos($ua, 'AppleWebKit') !== FALSE)) {
			if (preg_match('|OmniWeb[ /]v?(\d+)|', $ua, $M)) {
				$browser = self::OMNIWEB;
				$version = $M[1];
				$alias   = self::A_OMNIWEB;
			} else {
				$browser = self::SAFARI;
				$alias   = self::A_SAFARI;
				
				if (preg_match('|Version/(\d+)|', $ua, $M)) {
					$version = $M[1];
				}
			}
		} else if (preg_match('|Konqueror/(\d+)|', $ua, $M)) {
			$browser = self::KONQUEROR;
			$version = $M[1];
			$alias   = self::A_KONQUEROR;
		} else if (preg_match('|NetFront/(\d+)|', $ua, $M)) {
			$browser = self::NETFRONT;
			$version = $M[1];
			$alias   = self::A_NETFRONT;
			$mobile = (strpos($ua, 'Kindle') === FALSE);
		}
		
		if (preg_match('|Camino/(\d+)|', $ua, $M)) {
			$browser = self::CAMINO;
			$version = $M[1];
			$alias   = self::A_CAMINO;
		}
		
		// Builds a class name
		$parts = array($os, $browser);
		
		if (!empty($alias)) {
			$parts[] = $alias . $version;
		}
		
		if ($mobile) {
			$parts[] = 'mobile';
		}
		
		$class = implode(' ', array_unique($parts));
		
		$this->_data = array(
			'class'   => $class,
			'os'      => $os,
			'browser' => $browser,
			'version' => $version,
			'alias'   => $alias,
			'mobile'  => $mobile,
			'raw'     => $ua,
		);
		
		return $this->_data;
	}
	
	/**
	* Exports information about a user agent as template variables that can be
	* referenced in template files in Geeklog
	*
	* @param   object  $template  reference to a Template(-like) object
	* @param   string  $prefix    prefix to the names of template vars
	* @return  (void)
	*/
	public function setTemplateVars($template, $prefix = 'custom') {
		if (is_object($template) AND method_exists($template, 'set_var')) {
			$prefix = preg_replace('/[^0-9a-zA-Z_]/s', '', $prefix);
			
			if (empty($prefix)) {
				$prefix = 'custom_';
			} else if (substr($prefix, -1) !== '_') {
				$prefix .= '_';
			}
			
			$template->set_var($prefix . 'class', $this->_data['class']);
			$template->set_var($prefix . 'os', $this->_data['os']);
			$template->set_var($prefix . 'browser', $this->_data['browser']);
			$template->set_var($prefix . 'alias', $this->_data['alias']);
			$template->set_var($prefix . 'version', $this->_data['version']);
			$template->set_var($prefix . 'mobile', ($this->_data['mobile'] ? 'mobile' : ''));
		} else {
			throw new Exception(__METHOD__ . ': Error!  $template must be a reference to a Template(-like) class object.');
		}
	}
}
