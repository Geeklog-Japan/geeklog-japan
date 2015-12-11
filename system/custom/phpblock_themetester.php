<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'phpblock_themetester.php') !== FALSE) {
    die('This file can not be used on its own!');
}

/**
* Theme Tester Block for Geeklog
*
* @authors SaY (Yushuke SAKATA)
*          mystral-kk (Kenji ITO) - geeklog AT mystral-kk DOT net
*
* @license GPL v2
*
* @caution 1. このスクリプトはUTF-8で書かれています。EUC-JPで使う場合は、EUC-JP
*            で保存し直してください。
*
*          2. glfusion（旧gllabs）が公開していたテーマの一部（2008年7月20日の時
*            点では、カメレオンとnouveau）は、特殊な処理を行っているため、この
*            テーマテスタで完全に対応することができません。いったんglfusion系の
*            テーマを選ぶと、クッキーを消さない限り、他のテーマへ変更できなくな
*            ります。対応策は、次の1, 2のうちのいずれかです。
*
*              1. glfusion系のテーマのfunctions.phpをハックします。カメレオンの
*                場合は、functions.phpの328行目にある
*                    ob_start();
*                を324行目付近の
*                    $retval = eval( '?>' . $tmp );
*                の前に移動させます。nouveauの場合は、361行目付近にある
*                    ob_start();
*                を358行目付近にある
*                    echo $retval;
*                の前に移動させます。この対策を行うと、テーマテスターは正常に動
*                作するようになります。
*
*              2. 上記1.の変更を行えない場合は、下記設定の
*                THEMETESTER_IGNORE_GLFUSION を TRUE にして、glfusion系統のテー
*                マを選択できないようにしてください。初期値は FALSE になってい
*                ます。
*
*          3. テーマテスター全体は、<div id="themetester">と</div>で囲まれていま
*            す。
*/

//=====================================
//  CHANGES
//=====================================

/**
* 2011-05-21
*
*   1. [Fix] Modified to prevent users from selecting the "touch" and "touch2"
*     themes.
*
* 2011-04-10
*
*   1. [Fix] THEMETESTER_escape($str) caused an error.
*
* 2008-09-20
*
*   1. [Fix] Modified to prevent errors with PHP-4.x when html_entity_decode()
*     is used.
*
* 2008-07-20
*
*   1. [Fix] Modified to prevent a possible error when a certain theme is
*     seleced and HTML header is already sent.
*
* 2008-02-28
*
*   1. [New] Added an option to ignore chameleon plugin, because the current
*     chamelon doesn't go with theme tester.
*   2. [New] Modified to hide themes for mobile user agents.
*   3. [New] Modified to hide theme tester in case of mobile user agents.
*
* 2007-10-15
*
*   1. [Fix] Fixed the possible XSS vulnerabilities reported by Phize.
*   2. [Fix] Fixed to respect $_CONF['allow_user_themes'] and $_CONF['cookie
*    _theme'].
*   3. [New] Like dengen's version, we changed to show the name of the current
*     theme.
*   4. [New] Like dengen's version, we changed to save the registered users'
*     choice to DB immediately.
*   5. [New] Made XHTML availabe optionally.
*
* 2006-04-07
*
*   1. Modified to work properly in case the "register_long_arrays" directive
*    is off.
*   2. Modified to work properly in case JavaScript is disabled (added <input 
*     type="submit" ...>)
*   3. Removed the </center> tag near the bottom, which has no corresponding
*     <center> tag and replaced with <div style="align: center;">.
*   4. When anonymous users change their themes, we try to store them in cookies
*     (this feature is not available for logged-in users).
*/

//=====================================
//  設定
//=====================================

// glfusion（旧gllabs）系統のテーマ('chameleon'や'nouveau')を選択可能にするには、
//  TRUE を FALSE に変えてください。
define('THEMETESTER_IGNORE_GLFUSION', FALSE);
# define('THEMETESTER_IGNORE_GLFUSION', TRUE);

//=====================================
//  Functions
//=====================================

/**
* Returns a string in HTML to be safely displayed
*/
function THEMETESTER_escape($str) {
	static $charset = NULL;

	if ($charset === NULL) {
		$charset = COM_getCharset();
	}

	if (version_compare(PHP_VERSION, '5.2.3') >= 0) {
		return htmlspecialchars($str, ENT_QUOTES, $charset, FALSE);
	} else {
		return str_replace(
			array('&amp;&amp;', '&amp;&lt;', '&amp;&gt;', '&amp;&quot;', '&amp;&#039;'),
			array('&amp;', '&lt:', '&gt;', '&quot;', '&#039;'),
			htmlspecialchars($str, ENT_QUOTES, $charset)
		);
	}
}

/**
* Cleans a URL
*
* @note This function removes the strings 'JavaScript:', '<script>', 
*       '</script>', or 'document.write' in a given URL.  This might be a bit
*       too strict.
*/
function THEMETESTER_cleanUrl($url) {

	/**
	* Decodes HTML entities
	*/

	// %dd --> chr(0xdd)
	$url = preg_replace('/%([\dA-F]{2})/ie', "chr(hexdec('\\1'))", $url);

	// \xdd --> chr(0xdd)
	$url = preg_replace('/\\\\x([\dA-F]{2})/ie', "chr(hexdec('\\1'))", $url);

	// \udddd --> chr(0xdddd)
	$url = preg_replace('/\\\\u([\dA-F]{4})/ie', "chr(hexdec('\\1'))", $url);

	// &[lL][tT](;) --> &
	$search  = array('/&lt;?/i', '/&gt;?/i', '/&quot;?/i', '/&raquo;?/i');
	$replace = array('<', '>', '"', "'");
	$url = preg_replace($search, $replace, $url);

	// &#\d{1,7}(;) --> d
	$url = preg_replace('/&#(\d{1,7});?/e', "chr('\\1')", $url);

	// &#x[0-9a-fA-F]{1,7}(;) --> d
	$url = preg_replace('/&#x([\dA-F]{1,7});?/ie', "chr(hexdec('\\1'))", $url);

	/**
	* Starts cleaning
	*/

	// Removes control codes
	$url = preg_replace('/[\x00-\x20\x7F\xAD]/', '', $url);

	// '+' --> ' '
	$url = str_replace('+', ' ', $url);

	// Removes 'JavaScript:'
	$url = preg_replace('/J\s*A\s*V\s*A\s*S\s*C\s*R\s*I\s*P\s*T\s*/i', '', $url);

	// Maybe, the three functions are not necessary to sanitize URLs
	// Removes '<script>'
	$url = preg_replace('/<SCRIPT[^>]*>/i', '', $url);

	// Removes '</script>'
	$url = preg_replace('/<\/SCRIPT>/i', '', $url);

	// Removes 'document.write'
	$url = preg_replace('/DOCUMENT\.WRITE/i', '', $url);

	return $url;
}

/**
* Checks if the user agent is mobile
*
* @note  the code below is borrowed from custom_cellular.php written by IMAI Tatsumi
*/
function THEMETESTER_isMobile() {
	$ua = $_SERVER['HTTP_USER_AGENT'];

	if (preg_match("/^DoCoMo\/[12]\.0/i", $ua)) {
		// DoCoMo
		return TRUE;
	} else if (preg_match("/^(Softbank|J\-PHONE|Vodafone|MOT\-[CV]|Vemulator)/i", $ua)) {
		// SoftBank
		return TRUE;
	} else if (preg_match("/(UP\.Browser|KDDI\-)/i", $ua)) {
		// AU
		return TRUE;
	} else if (preg_match("/(DDIPOCKET|WILLCOM)/i", $ua)) {
		// Wilcom
		return TRUE;
	} else if (preg_match("/Windows *CE/i", $ua)
		 OR preg_match("/jigbrowserweb/i", $ua)
		 OR preg_match("/NetFront/i", $ua)
		 OR preg_match("/(Y!J-SRD\/1.0|Y!J-MBS\/1.0)/i", $ua)) {
		// Other UAs judged to be a mobile phone
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
* Returns an array of available themes
*/
function THEMETESTER_getThemes() {
	global $_PLUGINS;

	// Themes created by glfusion (was: gllabs)
	$gllabs_themes = array(
		'chameleon', 'nouveau',
	);

	$retval = array();
	$themes = COM_getThemes();

	foreach ($themes as $theme) {
		if (defined('THEMETESTER_IGNORE_GLFUSION')
		 AND (THEMETESTER_IGNORE_GLFUSION != FALSE)) {
			if (in_array($theme, $gllabs_themes)) {
				continue;
			}
		} else {
			if (($theme === 'chameleon') AND !in_array($theme, $_PLUGINS)) {
				continue;
			}
		}

		/**
		* Don't include mobile themes
		*/
		if (preg_match("/(mobile|touch2?)/i", $theme)) {
			continue;
		}

		$retval[] = $theme;
	}

	return $retval;
}

/**
* Provides a PHP function to be used in blocks
*/
function phpblock_themetester() {
	global $_CONF, $_PLUGINS, $_TABLES, $_USER;

	$retval = '';

	if (!defined('XHTML')) {
		define('XHTML', '');
	}
	if (!defined('LB')) {
		define('LB', "\n");
	}

 	// Users are not allowed to change the theme or the user is accessing with
	// a mobile phone
	if (($_CONF['allow_user_themes'] == 0)
	 OR (THEMETESTER_isMobile() === TRUE)) {
		return $retval;
	}

	$installed_themes = THEMETESTER_getThemes();

	if (count($installed_themes) <= 1) {
		// No choice
		return $retval;
	}

	if (isset($_POST['themetester_theme'])) {
		$theme = COM_applyFilter($_POST['themetester_theme']);
	} else {
		$theme = '';
	}

	// Gets the current theme
	if (isset($_USER['uid']) AND ($_USER['uid'] > 1)) {	// Logged-in user
		$current_theme = DB_getItem(
			$_TABLES['users'],
			'theme',
			"(uid = '" . addslashes($_USER['uid']) . "')"
		);
	} else {	// Anon
		if (isset($_COOKIE[$_CONF['cookie_theme']])) {
			$current_theme = COM_applyFilter($_COOKIE[$_CONF['cookie_theme']]);
		}
	}
	if ($current_theme == '') {
		$current_theme = $_CONF['theme'];
	}

	// Gets the current URL and XSS-clean it
	$url = COM_getCurrentURL();
	$url = THEMETESTER_cleanUrl($url);
	if (empty($url)) {
		$url = $_CONF['site_url'];
	}
	$url = THEMETESTER_escape($url);

	// The theme was changed
	if (!empty($theme) AND ($theme != $current_theme)
	 AND in_array($theme, $installed_themes)) {
		// In case of a registered user, we save the change into DB
		if (isset($_USER['uid']) AND ($_USER['uid'] > 1)) {
			$sql = "UPDATE {$_TABLES['users']} "
				 . "SET theme='" . addslashes($theme) . "' "
				 . "WHERE (uid = '" . addslashes($_USER['uid']) . "')";
			DB_query($sql);
		}

		// If possible, we save the new theme into cookie and refresh
		if (!headers_sent()) {
			setcookie (
				$_CONF['cookie_theme'],
				THEMETESTER_escape($theme),
				time() + 3600 * 24 * 365,	// one year
				$_CONF['cookie_path'],
				$_CONF['cookiedomain'],
				$_CONF['cookiesecure']
			);

			// Redirects to the current page
			header('Location: ' . $url);
			exit;	// In reality, this is unnecessary
		}
	}

	// Displays a form in which users change the theme
	$retval .= '<div id="themetester">' . LB
			.  '  <form action="' . $url . '" method="post">' . LB
			.  '    <select name="themetester_theme" onchange="this.form.submit()">' . LB;

	foreach ($installed_themes as $theme) {
		$retval .= '      <option value="' . THEMETESTER_escape($theme) . '"';
		if ($theme == $current_theme) {
			$retval .= ' selected="selected"';
		}

		$retval .= '>' . THEMETESTER_escape($theme) . '</option>' . LB;
	}

	$retval .= '    </select>' . LB
			.  '    <noscript>' . LB
			.  '      <input name="submit" type="submit" value="選択"' . XHTML . '>' . LB
			.  '    </noscript>' . LB
			.  '  </form>' . LB
			.  '</div>' . LB;

	return $retval;
}
