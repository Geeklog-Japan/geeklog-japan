<?php

/**
* This is a modified version of RSS Aggregator originally created by Mr. Sakata
* ("SaY").  I (mystral-kk) have made several changes to enable it to work with
* Geeklog-1.4.0 and Geeklog-1.4.1.  There is no need to hack lib-common.php.
*
* @usage	1. Edit configuration in the phpblock_rssAggregator() function.
*			  You can change feed URLs, the life span of a cache_file, the max
*			  number of headlines to display, date format and display format.
*
*			2. Place this file (phpblock_rssaggregator.php) in the
*			  "<private>/system/custom" directory.
*
*			3. Add a line to "<private>/system/lib-custom.php" to include the file.
*			  e.g.  require_once 'custom/phpblock_rssaggregator.php';
*			4. Log in as admin
*
*			5. If you want to use the RSS Aggregator in left/right blocks,
*			  then create a PHP block and enter "phpblock_rssaggregator" into
*			  the "Block Function" field.
*
*			6. If you want to use the RSS Aggregator in a static page, then
*			  create a static page and enter "echo phpblock_rssAggregator();"
*			  into the "Content" field.  Unlike in PHP blocks, you can supply
*			  (optional) arguments.  For example:
*
*			  $urls = array(
*				'the link to a feed file at site1',
*				'the link to a feed file at site2',
*			  );
*			  echo phpblock_rssAggregator($urls, 10);
*
*           7. If you want to stripe the display of RSS Aggregator, then define
*             ".rssag_even" and ".rssag_odd" classes in the CSS you're using.
*
*           8. If you want to use a number or string unique to each feed, you
*             have to set $RSSAG_CONF['urls'] value like this:
*
*             $RSSAG_CONF['urls'] = array(
*                  1 => 'http://www.geeklog.jp/backend/index.xml',
*                  2 => 'http://www.geeklog.jp/backend/forum_all.xml',
*             );
*
*             Then, use the {index} placeholder in $RSSAG_CONF['format'] and
*             the {index} placeholder will be replaced with the key unique to
*             each feed (in the above example, '1' or '2' according to the feed
*             URL).
*
* @author	Sakata (SaY)
* @author	mystral-kk (geeklog AT mystral-kk DOT net)
* @date		2010-04-24
* @version	1.3.2
* @todo     better XML parser
* @todo		better caching mechanism
* @todo		better way to sanitize URLs
* @license	GPL
*
* +---------------------------------------------------------------------------+
* | This program is free software; you can redistribute it and/or             |
* | modify it under the terms of the GNU General Public License               |
* | as published by the Free Software Foundation; either version 2            |
* | of the License, or (at your option) any later version.                    |
* |                                                                           |
* | This program is distributed in the hope that it will be useful,           |
* | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
* | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
* | GNU General Public License for more details.                              |
* |                                                                           |
* | You should have received a copy of the GNU General Public License         |
* | along with this program; if not, write to the Free Software Foundation,   |
* | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
* +---------------------------------------------------------------------------+
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'phpblock_rssaggregator.php') !== FALSE) {
	die('No direct access.');
}

//===============================================
// User Configuration -->
//===============================================

$RSSAG_CONF = array();

// Feed URLs from which you'd like to fetch information

$RSSAG_CONF['urls'] = array(
	1 => 'https://www.rotary.org/ja/rss.xml',		// rotary.ri
//	2 => 'http://www.sinsai.info/ushahidi/feed/',	// sinsai.info
);

// The life span of a cache file in seconds.  If you specify 0, no data will be
// cached (UNRECOMMENDED!).

$RSSAG_CONF['cache_lifespan'] = 3600;

/**
* The HTML format with which to print headline data
*
* {site}  will be replaced with the site name.
* {title} will be replaced with the title of the article.
* {link}  will be replaced with the link to the article.
* {date}  will be replaced with the date when the article was published.
* {desc}  will be replaced with the description of the site.
* {sw}    will be replaced with 'odd' or 'even' automatically.  Don't remove
*         this.
* {index} will be replaced with the index (key) of a given feed URL.  In the
*         above $RSSAG_CONF['urls'], '1' and '2' are indices.  ALL INDICES MUST
*         BE UNIQUE.
*/
$RSSAG_CONF['format'] = '<li class="rssag_{sw}"><a href="{link}" title="{title}">{title}({site})</a>  {date}<br' . XHTML . '>{desc}</li>';

// If you don't use the {desc} field, uncomment and use the next line instead.
# $RSSAG_CONF['format'] = '<li class="rssag_{sw}"><a href="{link}" title="{title}">{title}({site})</a>  {date}</li>';

// The format with which to print date.  See PHP's date() function

$RSSAG_CONF['date_format'] = "n/d H:i";

/**
* With some PHP versions, if the BOM (\0xef 0xbb 0xbf) header is missing,
* PHP's xml_parser_create() function fails to detect UTF-8 encoding even when
* you specify the target encoding.  If such is the case, try setting
* $RSSAG_CONF['auto_prepend_BOM'] to TRUE (default).
*/
$RSSAG_CONF['auto_prepend_BOM'] = TRUE;

/**
* To display the description of the site as HTML, set this to TRUE
*/
$RSSAG_CONF['desc_as_html'] = FALSE;

/**
* The max length of the description.  0 means no trimming will be performed
*/
$RSSAG_CONF['desc_max_len'] = 100;

//===============================================
// User Configuration <--
//===============================================

if (!defined('RSSAG_CACHE_PATH')) {
	define('RSSAG_CACHE_PATH', $_CONF['path_data']);
}

if (version_compare(PHP_VERSION, '5.1.0') == -1) {	// Prior to PHP-5.1.0?
	define('RSSAG_OLDER_PHP_VERSION', 1);
}

if (is_callable('mb_convert_encoding')) {
	define('RSSAG_HAVE_MBSTRING', 1);
} else if (is_callable('iconv')) {
	define('RSSAG_HAVE_ICONV', 1);
}

// Imports the feed handling classes:

require_once $_CONF['path_system'] . '/classes/syndication/parserfactory.class.php';
require_once $_CONF['path_system'] . '/classes/syndication/feedparserbase.class.php';

/**
* Wrapper class of FeedParserFactory
*
* Retrieves RSS feed file and converts its content into UTF-8
*/
class FeedParserFactoryEx extends FeedParserFactory
{
	function reader($url, $targetformat = '')
	{
		if ($data = $this->_getFeed($url)) {
			$data = $this->convertIntoUTF8($data);
			// $targetformat is always 'UTF-8' with FeedParserFactoryEx class
			return $this->_findFeed($data, 'UTF-8');
		} else {
			return FALSE;
		}
	}
	
	/**
	* Converts a string into UTF-8 and prepends the BOM header if so specified
	*
	* @access	public
	* @param	$data	string
	* @return			string
	*/
	function convertIntoUTF8($data)
	{
		global $RSSAG_CONF;
		
		// Decides the encoding of the data
		
		$encoding  = 'UNKNOWN';
		$converted = FALSE;
		$BOM       = pack('C*', 0xEF, 0xBB, 0xBF);
		$has_BOM   = FALSE;
		
		// XML documents should be in UTF8 or UTF16; otherwise encoding must be
		// defined explicitly with the "encoding='foo'" declaration
		
		if (($data[0] == chr(0xfe)) AND ($data[1] == chr(0xff))) {			// UTF-16LE
			$encoding = 'UTF-16LE';
		} else if (($data[0] == chr(0xff)) AND ($data[1] == chr(0xfe))) {	// UTF-16BE
			$encoding = 'UTF-16BE';
		} else if (strncasecmp($data, $BOM, 3) == 0) {	// UTF-8+BOM
			$encoding = 'UTF-8';
			$has_BOM = TRUE;
		} else if (preg_match('/encoding=[\x22\x27]([0-9A-Z_-]+)[\x22\x27]/mi', $data, $match)) {
			$encoding = strtoupper($match[1]);
		}
		
		// If the feed's encoding is found and is different from 'UTF-8', it
		// should be converted into 'UTF-8'.
		
		if (($encoding != 'UNKNOWN') AND ($encoding != 'UTF-8')) {
			if (defined('RSSAG_HAVE_MBSTRING')) {
				$data = @mb_convert_encoding($data, 'UTF-8', $encoding);
				$converted = TRUE;
			} else if (defined('RSSAG_HAVE_ICONV')) {
				$temp = iconv($encoding, 'UTF-8', $data);
				if ($temp !== FALSE) {
					$data = $temp;
					$converted = TRUE;
				}
			} else {
				RSSAG_log("FeedParserFactoryEx->convertIntoUTF8(): encoding '{encoding}' was found, but couldn't be converted into UTF-8.");
			}
			
			// Rewrites 'encoding="foo"' --> 'encoding="UTF-8"'
			if ($converted === TRUE) {
				$data = preg_replace(
					'/(.*encoding=[\x22\x27])([0-9A-Z_-]+)([\x22\x27].*)/mi',
					'$1UTF-8$3',
					$data,
					1
				);
			}
		}
		
		// Replaces some chars which are likely to be converted into different ones
		// depending on the environment with safer ones.
		// Reference: http://www.adobe.com/jp/support/coldfusion/ts/documents/
		//            jp_char_corruption.htm
		
		$data = str_replace(
			array("\xff5e", "\x2225", "\xff0d", "\xffe0", "\xffe1", "\xffe2"),
			array("\x301c", "\x2016", "\x2212", "\x00a2", "\x00a3", "\x00ac"),
			$data
		);
		
		// Prepends the BOM header if necessary
		
		if (($has_BOM === FALSE) AND ($RSSAG_CONF['auto_prepend_BOM'] === TRUE)) {
			$data = $BOM . $data;
		}
		
		return $data;
	}
}

//=============================================================================
// Helper Functions
//=============================================================================

/**
* Writes into an error log
*/
function RSSAG_log($str) {
	COM_errorLog($str, 1);
}

/**
* Used to be named "COM_rdfSort", a function to compare headline data
*/
function RSSAG_rdfSort($a, $b) {
	// Sorts by date (Unix timestamp) in the descending order
	return $b['date'] - $a['date'];
}

/**
* Parses a date expression and converts it into a Unix timestamp (UTC+00:00)
*/
function RSSAG_rdfParseDate($str) {
	// in RFC822 format? (RSS 2.0)
	$retval = @strtotime($str);
	if (defined('RSSAG_OLDER_PHP_VERSION')) {	// PHP < 5.1.0
		if ($retval != -1) {
			return $retval;
		}
	} else {										// PHP >= 5.1.0
		if ($retval !== FALSE) {
			return $retval;
		}
	}
	
	// Well, maybe in ISO.8601.1988 format (Atom 1.0)
	$str = strtoupper($str);
	if (preg_match("/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})/", $str, $A)) {
		list($whole, $Y, $M, $D, $h, $n, $s) = $A;
		$retval = mktime($h, $n, $s, $M, $D, $Y);
		$str = substr($str, strlen($whole));
		com_errorLog($whole);
		
		// Checks time zone
		$str = preg_replace("/\.\d+/", '', $str);	// Ignores a fraction of a second
		if ($str[0] == 'Z') {	// UTC Zulu
			$offset = 0;
		} else if (preg_match("/(\+|-)(\d{2}):(\d{2})/", $str, $match)) {
			$offset = 3600 * $match[2] + 60 * $match[3];
			if ($match[1] == '-') {
				$offset = - $offset;
			}
		} else {	// Unknown time zone.  Let's ignore it according to RFC3339
			$offset = 0;
		}
		
		$retval -= $offset;		// UTC = Local time - offset
		return $retval;
	} else {	// Unknown date expression
		if ($str !== '') {
			RSSAG_log("RSSAG_rdfParseDate: unknown date expression '{$str}'");
		}
		return time();
	}
}

/**
* Cleans a URL
*
* @NOTE: this function removes the strings 'JavaScript:', '<script>', 
*        '</script>', or 'document.write' in a given URL.  This might be a bit
*        too strict.
*/
function RSSAG_cleanUrl($url) {
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
* Returns a cache file name
*
* @param	string	$rdfurl
* @return	string	the name of a cache file
*/
function RSSAG_createCacheFileName($rdfurl) {
	$retval = 'rssag_' . substr(md5($rdfurl), 0, 20);

	return $retval;
}

/**
* Checks if cache is fresh
*
* @param	$rdfurl			string	a url to feed data
* @param	$cache_lifespan	int		the life span of a cache file
* @return					mixed	an array of feed data (cache is still fresh)
*									FALSE (cache is stale)
*/
function RSSAG_rdfCheckCache($rdfurl, $cache_lifespan = 3600) {
	// We don't cache when lifespan is 0
	if ($cache_lifespan == 0) {
		return FALSE;
	}
	
	$cache_file = RSSAG_CACHE_PATH . RSSAG_createCacheFileName($rdfurl);
	if (!file_exists($cache_file)) {	// cache file is not created yet
		return FALSE;
	}
	
	$modified = filemtime($cache_file);
	clearstatcache();
	if (time() > $modified + $cache_lifespan) {
		return FALSE;
	} else {
		$retval = @unserialize(file_get_contents($cache_file));
		return $retval;
	}
}

/**
* Used to named "COM_rdfFetch", a function to actually fetch feed data
*
* NOTE: All feed data are in UTF-8.
*
* @param	$rdfurl			string	a url to feed data
* @param	$cache_lifespan	int		the life span of a cache file
* @param	$maxheadlines	int		the max number of headlines to be fetched
*                                   0 = all items
* @return					mixed	array of feed data
*									FALSE (failed)
*/
function RSSAG_rdfFetch($rdfurl, $cache_lifespan = 3600, $maxheadlines = 0) {
	global $_CONF;
	
	// Checks if cache is fresh
	$maxheadlines = (int) $maxheadlines;
	$result = RSSAG_rdfCheckCache($rdfurl, $cache_lifespan);
	if ($result !== FALSE) {
		if ($maxheadlines !== 0) {
			$result = array_slice($result, 0, $maxheadlines);
		}
		
		return $result;
	}
	
    // Loads the actual feed handlers:
    $factory = new FeedParserFactoryEx($_CONF['path_system'] . '/classes/syndication/');
    $factory->userAgent = 'GeekLog/' . VERSION;
    $feed = $factory->reader($rdfurl);
    
    if ($feed === FALSE) {
        RSSAG_log("Unable to aquire feed reader for {$rdfurl}");
		return FALSE;
    } else if (!isset($feed->articles) OR !is_array($feed->articles)
	 OR (count($feed->articles) === 0)) {
        RSSAG_log("No items found in {$rdfurl}");
		return FALSE;
	}
	
	// Converts a feed object into an array
	$retval  = array();
	$site    = $feed->title;
	$basekey = time();
	
	foreach ($feed->articles as $A) {
		$item = array();
		// Appends site name to each entry
		$item['site']  = $site;
		// Converts a date expression into a Unix timestamp (UTC+00:00)
		$item['date']  = RSSAG_rdfParseDate($A['date']);
		// Cleans a URL
		$item['link']  = RSSAG_cleanUrl($A['link']);
		$item['title'] = $A['title'];
		$item['desc']  = $A['summary'];
		$item['feed']  = $rdfurl;
		$retval[$site . (string) $basekey] = $item;
		$basekey ++;
	}
	
	// Sorts feeds in new-to-old order
	usort($retval, 'RSSAG_rdfSort');
	
	if ($maxheadlines !== 0) {
		$retval = array_slice($retval, 0, $maxheadlines);
	}
	
	// Saves data into a cache file
	if (!is_writable(RSSAG_CACHE_PATH)) {
		RSSAG_log('RSSAG_rdfFetch: ' . RSSAG_CACHE_PATH . ' is not writable.');
	} else {
		$cache_file = RSSAG_CACHE_PATH . RSSAG_createCacheFileName($rdfurl);
		$fh = @fopen($cache_file, 'r+b');
		if ($fh === FALSE) {
			RSSAG_log("RSSAG_rdfFetch: cache file '{$cache_file}' is not writable.");
		} else {
			if (flock($fh, LOCK_EX) === TRUE) {
				ftruncate($fh, 0);
				rewind($fh);
				fwrite($fh, serialize($retval));
				flock($fh, LOCK_UN);
			} else {
				RSSAG_log("RSSAG_rdfFetch: can't lock the cache file '{$cache_file}'");
			}
			
			fclose($fh);
		}
	}
	
    return $retval;
}

/**
* Escapes a string for HTML output
*
* @param  $str = a string to be esapced
* @retuen an escaped string
*/
function RSSAG_escapeHTML($str) {
	$src = array('&amp;', '&quot;', '&#39;', '&lt;', '&gt;');
	$rpl = array('&',     '"',      "'",     '<',    '>');
	
	$str = str_replace($src, $rpl, $str);
	$str = str_replace($rpl, $src, $str);
	
	return $str;
}

//=============================================================================
// Main Function
//=============================================================================

/**
* RSS Aggregator
*
* @access  public
* @param   array   $url_list  an keyed array of feed URLs
* @param   int     $maxlist   max count of items to display
* @param   string  $format    custom display format @since v1.2.9
* @param   string  $callback  callback function
* @return  string
*
* Usage: in a PHP block or a static page, call "phpblock_rssAggregator()"
*/
function phpblock_rssAggregator($url_list = array(), $maxlist = 10,
 $format = '', $callback = NULL) {
	global $LANG33, $_CONF, $LANG_CHARSET, $RSSAG_CONF;
	
	// Checks parameters
	if (isset($maxlist) AND is_numeric($maxlist)) {
		$maxlist = (int) $maxlist;
	} else {
		$maxlist = 10;
	}
	
	if (is_array($url_list) AND (count($url_list) > 0)) {
		$urls = $url_list;
	} else {
		$urls = $RSSAG_CONF['urls'];
	}
	
	// Fetches headline data in UTF-8
	$articles = array();
	
	foreach ($urls as $url) {
		$feed = RSSAG_rdfFetch($url, $RSSAG_CONF['cache_lifespan'], 0);
		
		if ($feed !== FALSE) {
			$articles = array_merge($articles, $feed);
		}
	}
	
	if (count($articles) !== 0) {
# 		// Filters out some contents
# 		$temp = $articles;
# 		$articles = array();
# 		
# 		foreach ($temp as $item) {
# 			if (strpos($item['title'], 'PR:') === FALSE) {
# 				$articles[] = $item;
# 			}
# 		}
		
		// Sorts articles by date
		usort($articles, 'RSSAG_rdfSort');
		
		// Truncates articles
		$num_articles = count($articles);
		if ($maxlist > $num_articles) {
			$maxlist = $num_articles;
		}
		$articles = array_slice($articles, 0, $maxlist);
		
		// Decides the charset to print headline data in
		$out_charset = empty($LANG_CHARSET) ? $_CONF['default_charset'] : $LANG_CHARSET;
		if (empty($out_charset)) {
			$out_charset = 'UTF-8';	// Or 'EUC-JP'
		}
		
		// Renders articles
		$sw = 'odd';
		$feedURLtoIndex = array_flip($urls);
		$items = array();
		
		foreach ($articles as $A) {
			$link  = $A['link'];
			$title = $A['title'];
			$site  = $A['site'];
			$desc  = $A['desc'];
			$date  = $A['date'];
			$index = isset($feedURLtoIndex[$A['feed']]) ? $feedURLtoIndex[$A['feed']] : 0;
			
			// Converts encoding if we have mbstring functions or iconv functions
			if (defined('RSSAG_HAVE_MBSTRING')) {
				$title = mb_convert_encoding($title, $out_charset, 'UTF-8');
				$site  = mb_convert_encoding($site, $out_charset, 'UTF-8');
				$desc  = mb_convert_encoding($desc, $out_charset, 'UTF-8');
			} else if (defined('RSSAG_HAVE_ICONV')) {
				$title = iconv('UTF-8', $out_charset, $title);
				$site  = iconv('UTF-8', $out_charset, $site);
				$desc  = iconv('UTF-8', $out_charset, $desc);
			}
			
			// If a callback function exists, then we call it.  If the callback
			// function returns false, we don't include the item in the output.
			if (is_callable($callback)
			 AND !$callback($link, $title, $site, $desc, $date)) {
				continue;
			}
			
			$link4html  = RSSAG_escapeHTML($link);
			$title4html = RSSAG_escapeHTML($title);
			$site4html  = RSSAG_escapeHTML($site);
			
			if ($RSSAG_CONF['desc_as_html'] === TRUE) {
				$desc4html = $desc;
			} else {
				$desc = strip_tags($desc);
				$desc4html = RSSAG_escapeHTML($desc);
			}
			
			if (($RSSAG_CONF['desc_max_len'] > 0) AND is_callable('mb_strimwidth')) {
				$desc4html = mb_strimwidth(
					$desc4html, 0, $RSSAG_CONF['desc_max_len'], '...', $out_charset
				);
			}
			
			// Formats headlines to display
			if ($format != '') {
				$temp = $format;
			} else {
				$temp = $RSSAG_CONF['format'];
			}
			
			$content = str_replace(
				array('{site}', '{title}', '{link}', '{date}', '{desc}', '{sw}', '{index}'),
				array($site4html, $title4html, $link4html, date($RSSAG_CONF['date_format'], $date), $desc4html, $sw, $index),
				$temp
			);
			$items[] = $content; 
			$sw = ($sw === 'odd') ? 'even' : 'odd';
		}

		// Builds a list
		$retval = '<ul class="list-feed">' . LB
				. implode(LB, $items)
				. '</ul>' . LB;
	} else {
		$retval = $LANG33[22];
	}
	
	return $retval;
}
