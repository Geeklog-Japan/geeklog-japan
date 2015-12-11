<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'phpblock_lastarticles.php') !== FALSE) {
    die('This file can not be used on its own!');
}

// 日付のフォーマットはPHPのdate()関数と同じ。
if (!defined('LASTARTICLES_DATE_FORMAT')) {
	define('LASTARTICLES_DATE_FORMAT', '[Y-m-d]');
}

// 記事の長さ（単位：文字）
if (!defined('LASTARTICLES_ARTICLE_LENGTH')) {
	define('LASTARTICLES_ARTICLE_LENGTH', 200);
}


// 画像の幅（単位：ピクセル）
if (!defined('LASTARTICLES_IMAGE_WIDTH')) {
	define('LASTARTICLES_IMAGE_WIDTH', 50);
}

// 画像の高さ（単位：ピクセル）
if (!defined('LASTARTICLES_IMAGE_HEIGHT')) {
	define('LASTARTICLES_IMAGE_HEIGHT', 50);
}

/***
*
* phpblock_lastarticles()
*
* Geeklog phpblock function to show the title and links of the latest articles
* 
* by Nakanishi
* modified by mystral-kk - geeklog AT mystral-kk DOT net
*
* 使用法：
*
* phpblock_lastarticles(行数, 先頭文字数);
*
* 次の2行を静的ページPHPで記述します。
*
* $exclude = array('cat1', 'cat2');  // 見せたくない記事カテゴリIDをリスト
* echo phpblock_lastarticles(10, 60, $exclude);
*
* 外見を変更する場合は、このファイルと同じディレクトリ内にあるテンプレートファイル
* (phpblock_lastarticles.thtml)を変更してください。
*
*/
function phpblock_lastarticles(
	$numrows = 10
	, $length = 50
	, $exclude = array()
) {
	$additional_sql = LASTARTICLES_createTopicSet($exclude, FALSE);
	
	return phpblock_lastarticles_common($numrows, $length, $additional_sql);
}

/***
*
* phpblock_lastarticles2()
*
* Geeklog phpblock function to show the title and links of the latest articles
* 
* by T.Kinoshita
* modified by mystral-kk - geeklog AT mystral-kk DOT net
*
* phpblock_lastarticles2(行数,先頭文字数);
* 次の2行を静的ページPHPで記述
*
* $include = array('cat1', 'cat2');  // 見せたい記事カテゴリIDをリスト
* echo phpblock_lastarticles2(10, 60, $include);
*
*/
function phpblock_lastarticles2(
	$numrows = 10
	, $length = 50
	, $include = array()
) {
	$additional_sql = LASTARTICLES_createTopicSet($include, TRUE);
	
	return phpblock_lastarticles_common($numrows, $length, $additional_sql);
}

/**
* Returns the currend encoding
*/
function LASTARTICLES_getEncoding(
) {
	global $_CONF, $LANG_CHARSET;
	
	static $encoding = NULL;
	
	if ($encoding === NULL) {
	    if (isset($LANG_CHARSET)) {
	        $encoding = $LANG_CHARSET;
	    } else if (isset($_CONF['default_charset'])) {
	        $encoding = $_CONF['default_charset'];
	    } else {
	        $encoding = 'utf-8';
	    }
	}
	
	return $encoding;
}

/**
* Escapes a string for HTML output
*/
function LASTARTICLES_esc(
	$str
) {
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	
	return htmlspecialchars($str, ENT_QUOTES, LASTARTICLES_getEncoding());
}

/**
* utitility function to create a set of topic ids
*/
function LASTARTICLES_createTopicSet(
	$topics = array()
	, $is_include = TRUE
) {
	if (count($topics) === 0) {
		return ' ';
	}
	
	$retval = " AND (t.tid ";
	
	if ($is_include != TRUE) {
		$retval .= "NOT ";
	}
	
	$retval .= "IN (";
	$topics = array_map('addslashes', $topics);
	$topics = "'" . implode("', '", $topics) . "'";
	$retval .= $topics . ")) ";
	
	return $retval;
}

function LASTARTICLES_getTemplate(
) {
	$file = dirname(__FILE__) . '/phpblock_lastarticles.thtml';
	
	if (file_exists($file)) {
		$retval = file_get_contents($file);
	} else {
		// 使用可能なタグ
		// {date} = 日付、{topic} = 話題、{link} = 記事のURL、
		// {title} = 記事のタイトル、{img} = 1番目の画像タグ、
		// {article} = 記事の冒頭、{xhtml} = XHTML定数
		$retval = <<<EOD
<div style="width: 600px; margin: 5px 0; padding: 5px 0; border-bottom: dotted 1px gray;" class="new-story">
	<span class="new-story-date">{date}</span>&nbsp;<span class="new-story-topic">{topic}</span>::<a href="{link}">{title}</a><br{xhtml}>
	<div style="float: left; width: 400px; margin: 5px 0 0 0;">
		{article}
	</div>
	<div style="float: left; width: 200px; overflow: hidden; margin: 5px 0 0 0;">{img}</div>
	<div style="clear: both;"></div>
</div>
EOD;
	}
	
	$retval = preg_replace('/<!--.*?-->/ms', '', $retval);
	
	return $retval;
}

function LASTARTICLES_renderImageTag(
	$text
) {
	$retval = '';
	
	if (preg_match('/<img\s[^>]+>/ims', $text, $M)) {
		$image_url = '';
		
		if (preg_match('/src="([^"]+)"/ims', $M[0], $s)) {
			$image_url = $s[1];
		}
		
		if (!empty($image_url)) {
			$image_alt = '';
			
			if (preg_match('/alt="([^"]*)"/ims', $M[0], $a)) {
				$image_alt = $a[1];
			}
			
			if (preg_match('/height="([^"]*)"/ims', $M[0], $h)) {
				$height = $h[1];
			} else {
				$height = LASTARTICLES_IMAGE_HEIGHT;
			}
			
			if (preg_match('/width="([^"]*)"/ims', $M[0], $w)) {
				$width = $w[1];
			} else {
				$width = LASTARTICLES_IMAGE_WIDTH;
			}
			
			if ($width > LASTARTICLES_IMAGE_WIDTH) {
				$height = $height * $width / LASTARTICLES_IMAGE_WIDTH;
				$width  = LASTARTICLES_IMAGE_WIDTH;
			}
			
			if ($height > LASTARTICLES_IMAGE_HEIGHT) {
				$width = $width * $height / LASTARTICLES_IMAGE_HEIGHT;
				$height = LASTARTICLES_IMAGE_HEIGHT;
			}
			$retval = '<img style="background:#EEEEEE; padding:5px; border:1px solid #CCC;" src="' . $image_url . '" height="' . floor($height)
					. '" width="' . floor($width) . '" alt="'
					. LASTARTICLES_esc($image_alt) . '"' . XHTML . '>';

/*
$retval = '<a class="lightbox" href="' . $image_url . '" alt=""><img class="lightbox" style="background:#EEEEEE; padding:5px; border:1px solid #CCC;" src="/jquery/timthumb.php?src=' . $image_url . '&w=50&h=50&zc=1&q=100" alt="' . LASTARTICLES_esc($image_alt) . '" title="" /></a>';
*/
		}
	}
	
	return $retval;
}

/**
* Common function to be called from phpblock_lastarticles() and
* phpblock_lastarticles2()
*/
function phpblock_lastarticles_common(
	$numrows = 10
	, $length = 50
	, $additional_sql = ''
) {
	global $_CONF, $_TABLES;
	
	if (!defined('XHTML')) {
		define('XHTML', '');
	}
	
	$numrows = intval($numrows);
	
	if ($numrows < 1) {
		$numrows = 10;
	}
	
	$length = intval($length);
	
	if ($length < 1) {
		$length = 50;
	}
	
	$sql  = "SELECT STRAIGHT_JOIN ".LB;
	$sql .= " s.sid";
	$sql .= " , t.tid";
	$sql .= " , s.title, s.date, s.group_id ".LB;
	$sql .= " , s.introtext, s.bodytext, t.topic ".LB;
	$sql .= "  FROM {$_TABLES['stories']} AS s".LB;
	$sql .= ", {$_TABLES['topics']} AS t ".LB;
	//FOR GL2.0.0 
	if (COM_versionCompare(VERSION, "2.0.0",  '>=')){
		$sql.=" ,{$_TABLES['topic_assignments']} AS t2".LB;
	}
	
	$sql .= "  WHERE ".LB;
	$sql .= " (s.title <> '') ".LB;
	//FOR GL2.0.0 
	if (COM_versionCompare(VERSION, "2.0.0",  '>=')){
		$sql.="  AND s.sid = t2.id".LB;
		$sql.="  AND t2.tid = t.tid".LB;
	}else{
		$sql .= " AND (s.tid = t.tid) ".LB;
	}
	
	$sql .= " AND (s.draft_flag = 0) ".LB;
	$sql .= " AND (s.date <= NOW()) ".LB;
    $sql .=  COM_getTopicSQL('AND', 0, 't').LB;
	
	if (function_exists('COM_getLangSQL')) {
		$sql .= COM_getLangSQL('sid', 'AND', 's').LB;
	}
	
	$sql .= $additional_sql.LB
		 . "ORDER BY s.date DESC "
		 . "LIMIT " . $numrows;
	$result   = DB_query($sql);
	$template = LASTARTICLES_getTemplate();
	$encoding = LASTARTICLES_getEncoding();
	$retval   = '';
	
	while (($A = DB_fetchArray($result, FALSE)) !== FALSE) {
		$introtext = PLG_replaceTags(stripslashes($A['introtext']));
		$bodytext  = PLG_replaceTags(stripslashes($A['bodytext']));
		
		$article = mb_strimwidth(
						strip_tags($introtext), 0, LASTARTICLES_ARTICLE_LENGTH,
						'...', $encoding
		);
		$date    = date(LASTARTICLES_DATE_FORMAT, strtotime($A['date']));
		$img     = LASTARTICLES_renderImageTag($introtext . $bodytext);
		$link    = COM_buildUrl(
						$_CONF['site_url'] . '/article.php?story=' . $A['sid']
		);
		$title   = mb_strimwidth(
						stripslashes($A['title']), 0, $length, '...', $encoding
		);
		$topic   = LASTARTICLES_esc($A['topic']);
		
		$retval .= str_replace(
						array(
							'{article}', '{date}', '{img}', '{link}', '{title}',
							'{topic}', '{xhtml}',
						),
						array(
							$article, $date, $img, $link, $title, $topic, XHTML,
						),
						$template
		);
	}
	
	return $retval;
}
