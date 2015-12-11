<?php

// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | public_html/admin/install/fb.php                                          |
// |                                                                           |
// | Part of Geeklog pre-installation check scripts                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2011 by the following authors:                         |
// |                                                                           |
// | Authors: mystral-kk - geeklog AT mystral-kk DOT net                       |
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

/**
* This script enables a Geeklog user to traverse the file tree and search for
* "db-config.php" visually.
*
* @author   mystral-kk <geeklog AT mystral-kk DOT net>
* @date     2011-01-05
* @version  1.4.0
* @license  GPLv2 or later
*/
define('DS', DIRECTORY_SEPARATOR);
define('LB', "\n");
define('OS_WIN', strcasecmp(substr(PHP_OS, 0, 3), 'WIN') === 0);
define('TARGET', 'db-config.php');
define('PRECHECK_VERSION', '1.3.4');

/**
* Convert charset of a string to SJIS
*/
function convertCharset($str) {
	if (OS_WIN) {
		return mb_convert_encoding($str, 'utf-8', 'sjis');
	} else {
		return $str;
	}
}

if (isset($_GET['path'])) {
	$path = $_GET['path'];
	$path = str_replace('\\\\', '\\', $path);
} else {
//	$path = dirname(__FILE__);
	$path = realpath(dirname(__FILE__) . DS . '..' . DS . '..' . DS . '..' . DS);
}
if (isset($_GET['mode'])) {
	$mode = $_GET['mode'];
} else {
	$mode = 'install';
}

$result = FALSE;
$header = <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Geeklog インストール前チェック - ファイルブラウザ</title>
    <link href="precheck.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    <!--
    a {
        color: blue;
    }
    a:hover {
        color: blue;
    }
    a:visted {
        color: blue;
    }
    p.curpath {
        color: white;
        background-color: black;
        color: black;
        background-color: #f7f7f7;
        border: solid 1px #cccccc;
        padding: 5px;
    }
    p.found {
        padding: 5px;
        background-color: #dcfedc;
        border: solid 1px #32cd32;
    }
    p.info {
        padding: 5px;
    }
    -->
    </style>
</head>
<body>
<div class="header-navigation-container">
   <div class="header-navigation-line">
       <a href="http://www.geeklog.jp/forum/index.php?forum=6" class="header-navigation">インストールで困ったら、こちらのサイトへ</a>&nbsp;&nbsp;&nbsp;
   </div>
</div>
<div class="header-logobg-container-inner">
    <a class="header-logo" href="http://www.geeklog.net/">
        <img src="layout/logo.png"  width="151" height="56" alt="Geeklog" />
    </a>
    <div class="header-slogan">The Ultimate Weblog System <br /><br />
    </div>
</div>
<div class="installation-container">
<div class="installation-body-container">
<h1 class="heading">ファイルブラウザ</h1>
EOD;

$body = '';
$parent = @realpath($path . DS . '..');
if ($parent !== FALSE) {
	$body .= '<p>[ <a href="fb.php?mode=' . $mode . '&amp;path='
		  .  rawurlencode($parent) . '">一つ上のフォルダへ</a> ]</p>' . LB;
}

if (($dh = @opendir($path)) === FALSE) {
	$body .= '<p>エラー：ディレクトリを開けません。検索を終了します。</p>' . LB;
} else {
	while (($entry = readdir($dh)) !== FALSE) {
		$fullpath = $path . DS . $entry;
		if (is_dir($fullpath)) {
			if (($entry != '.') AND ($entry != '..')) {
				$body .= '<img alt="フォルダのアイコン" src="layout/folder.png" />&nbsp;<a href="fb.php?mode='
					  . $mode . '&amp;path=' . rawurlencode($fullpath) . '">'
					  .  htmlspecialchars(convertCharset($entry), ENT_QUOTES)
					  .  '</a><br />' . LB;
			}
		} else {
			if ($entry == TARGET) {
				$body .= '<img alt="ファイルのアイコン" src="layout/text.png" />  '
					  .  '<span style="color: green;">'
					  . TARGET . '</span>  [ <a href="precheck.php?mode='
					  . $mode . '&amp;step=0&amp;path='
					  .  rawurlencode(dirname($fullpath) . DS)
					  .  '">このファイルを使用する</a> ]<br />' . LB;
				$result = TRUE;
			}
		}
	}
	
	closedir($dh);
}

if ($result === TRUE) {
	$msg = '<p class="info"><strong>' . TARGET . '</strong>が見つかりました。このファイルでよければ、<strong>[ このファイルを使用する ]</strong>をクリックしてください。</p>' . LB;
	$curpath = '<p class="found">';
} else {
	$msg = '<p class="info">下に表示されているリンクをクリックして、<strong>' . TARGET . '</strong>を探してください。</p>' . LB;
	$curpath = '<p class="curpath">';
}
$curpath .= '<strong>現在のパス</strong>：' . convertCharset($path) . '</p>' . LB;

$body .= '<br /><p class="precheck-version">Geeklogインストール前チェック&nbsp;&nbsp;Ver' . PRECHECK_VERSION . '</p>' . LB
       . '</div>' . LB . '</div>' . LB . '</body>' . LB . '</html>' . LB;

header('Content-Type: text/html; charset=utf-8');
echo $header . $msg . $curpath . $body;
