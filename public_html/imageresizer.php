<?php

/**
* 画像縮小プロキシスクリプト
* 
* imageresizer.php?image=[imagename]&size=[size]&quality=[quality]&type=[type]
* [imagename]: 画像のURL
* [size]: リサイズ後のサイズ(単位: pixel)
* [quality]: jpegのクオリティ(0-100: 0 = lowest, 100 = highest)
* [type]: 出力画像の形式('png' or 'gif' or 'jpeg')
*
* sizeで指定された大きさより縦横いずれかが大きければ、sizeにあわせて縮小する。
* アスペクト比は保存される。
* 縦横どちらもsizeより小さければ、jpegへの変換だけを行う。
*/
require_once dirname(__FILE__) . '/lib-common.php';
require_once 'HTTP/Request.php';

# define('RESIZER_DEBUG', TRUE);
define('SCRIPT_NAME', basename(__FILE__));
define('RESIZER_CACHE_DIRECTORY', $_CONF['path_data']);
define('RESIZER_DEFAULT_IMAGE_SIZE', 160);		// 画像サイズの既定値(単位: pixel)
define('RESIZER_DEFAULT_IMAGE_QUALITY', 50);	// 画像クオリティの既定値
define('RESIZER_DEFAULT_PNG_IMAGE_QUALITY', 9);	// PNGの圧縮レベルの既定値

//===================================================================
// Functions
//===================================================================

/**
* Logs a message for debugging
*
* @param   string  $var
* @return  (void)
*/
function RESIZER_debug($var) {
	if (defined('RESIZER_DEBUG')) {
		COM_errorLog(__FUNCTION__ . ': ' . $var);
	}
}

/**
* Returns an HTTP request header
*
* @param   string  $key
* @return  string
*/
function RESIZER_getHeader($key) {
	$retval = '';

	if (is_callable('getallheaders')) {
		foreach (getallheaders() as $k => $v) {
			if (strcasecmp($key, $k) === 0) {
				$retval = $v;
				break;
			}
		}
	}

	return $retval;
}

function RESIZER_getContentType($image_uri) {
	$retval = '';

	$req = new HTTP_Request($image_uri);
	$req->setMethod(HTTP_REQUEST_METHOD_HEAD);

	if (!PEAR::isError($req->sendRequest())) {
		$code = (int) $req->getResponseCode();

		 if (($code === 200) OR ($code === 304)) {
			$retval = RESIZER_getHeader('Content-Type');
		}
	}

	return $retval;
}

/**
* Checks if an imgae file is a local one
*
* @param   string  $image_uri
* @return  boolean TRUE = local, FALSE = remote
*/
function RESIZER_isLocal($image_uri) {
	global $_CONF;

	$retval = FALSE;

	if (stripos($image_uri, $_CONF['site_url']) === 0) {
		$path = RESIZER_uriToPath($image_uri);
		clearstatcache();
		$retval = file_exists($path);
	}

	return $retval;
}

/**
* Converts an URI to an absolute path
*
* @param   string  $image_uri
* @return  string
*/
function RESIZER_uriToPath($image_uri) {
	global $_CONF;

	return $_CONF['path_html'] . str_replace($_CONF['site_url'] . '/', '', $image_uri);
}

/**
* Checks if an image has been updated since the last access
*
* @param   string  $image_uri
* @param   int     $last_access  UNIX timestamp
* @return  boolean TRUE = updated, FALSE = otherwise
*/
function RESIZER_isUpdated($image_uri, $last_access) {
	if (RESIZER_isLocal($image_uri)) {
		$retval = (filemtime(RESIZER_uriToPath($image_uri)) > $last_access);
	} else {
		$req = new HTTP_Request($image_uri);
		$req->setMethod(HTTP_REQUEST_METHOD_GET);
		$req->addHeader(
			'If-Modified-Since',
			gmdate('D, d M Y H:i:s ', $last_access) . 'GMT'
		);

		if (!PEAR::isError($req->sendRequest()) AND ($req->getResponseCode() == 304)) {
			$retval = FALSE;
		} else {
			$retval = TRUE;
		}
	}

	RESIZER_debug($retval ? 'Cache is stale' : 'Cache is fresh');
	return $retval;
}

/**
* Returns the content of an image file
*
* @param   string  $image_uri
* @return  string
*/
function RESIZER_getFile($image_uri) {
	if (RESIZER_isLocal($image_uri)) {
		$retval = file_get_contents(RESIZER_uriToPath($image_uri));
		RESIZER_debug('Got a local file from "' . $image_uri . '"');
	} else {
		$req = new HTTP_Request($image_uri);
		$req->setMethod(HTTP_REQUEST_METHOD_GET);
		$result = $req->sendRequest();

		if (!PEAR::isError($result)) {
			$code = (int) $req->getResponseCode();

			if ($code === 200) {
				$retval = $req->getResponseBody();
				RESIZER_debug('Got a remote file from "' . $image_uri . '"');
			} else {
				throw new Exception(__FUNCTION__ . ': Cannot get image file from "' . $image_uri . '"  HTTP response code = ' . $code);
			}
		} else {
			throw new Exception(__FUNCTION__ . ': Cannot get image file from "' . $image_uri . '"');
		}
	}

	return $retval;
}

//===================================================================
// Main
//===================================================================

RESIZER_debug('***** Start *****');

// lib-common.php内の出力バッファリングを無効にする
while (@ob_end_clean()) { }

/**
* 画像の縮小用パラメータ（既定値）
*/
$size        = RESIZER_DEFAULT_IMAGE_SIZE;
$quality     = RESIZER_DEFAULT_IMAGE_QUALITY;
$quality_png = RESIZER_DEFAULT_PNG_IMAGE_QUALITY;

// ファイルタイプ
$type = '';

// 出力ファイルタイプ
$out_type = 'jpeg';

try {
	/**
	* パラメータ取得
	*/
	if (!isset($_GET['image'])) {
		throw new Exception(SCRIPT_NAME . ': No image file specified.');
	}

	$image_uri = COM_applyFilter($_GET['image']);

	// 相対URLを絶対URLに変換する
	if (!preg_match("@^https?://@i", $image_uri)) {
		if (stripos($image_uri, 'dokuwiki/lib/exe') === FALSE) {
			$image_uri = $_CONF['site_url'] . $image_uri;
		} else {
			// DokuWikiは特別扱い
			if (stripos($image_uri, 'indexer.php') !== FALSE) {
				// 画像ファイルではなく、アクセス解析用のビーコンなので無視する
				header('HTTP/1.0 404 Not Found');
				exit(1);
			}

			preg_match('@^(https?://[^/]+)@i', $_CONF['site_url'], $match);
			$image_uri = $match[1] . $image_uri;

			if (stripos($image_uri, 'fetch.php') !== FALSE) {
				$image_uri .= '&media=' . urlencode(COM_applyFilter($_GET['media']));
			}
		}
	}

	RESIZER_debug('image = ' . $image_uri);

	if (isset($_GET['size'])) {
		$size = (int) COM_applyFilter($_GET['size'], TRUE);

		if (($size < 1) OR ($size > 1024)) {
			$size = RESIZER_DEFAULT_IMAGE_SIZE;
		}

		RESIZER_debug('size = ' . $size);
	}

	if (isset($_GET['quality'])) {
		$quality = (int) COM_applyFilter($_GET['quality'], TRUE);

		if (($quality < 0) OR ($quality > 100)) {
			$quality = RESIZER_DEFAULT_IMAGE_QUALITY;
		}

		RESIZER_debug('quality = ' . $quality);
	}

	if (isset($_GET['type'])) {
		$temp_str = strtolower(COM_applyFilter($_GET['type']));

		if (($temp_str == 'png') OR ($temp_str == 'gif')) {
			$out_type = $temp_str;
		}

		RESIZER_debug('out_type = ' . $out_type);
	}

	// 画像ファイル名の後にクエリストリングがついている場合を考慮して、パターン
	// に(\?.*)? を追加する
	if (preg_match('/\.png(\?.*)?$/i', $image_uri)) {
		$type = 'png';
	} else if (preg_match('/\.jpe?g(\?.*)?$/i', $image_uri)) {
		$type = 'jpg';
	} else if (preg_match('/\.gif(\?.*)?$/i', $image_uri)) {
		$type = 'gif';
	} else {
		// スクリプトで画像を出力しているものはヘッダーのContent-Typeから判断す
		// る
		$content_type = RESIZER_getContentType($image_uri);

		if (stripos($content_type, 'image/png') !== FALSE) {
			$type = 'png';
		} else if (stripos($content_type, 'image/jpeg') !== FALSE) {
			$type = 'jpg';
		} else if (stripos($content_type, 'image/gif') !== FALSE) {
			$type = 'gif';
		} else {
			throw new Exception(SCRIPT_NAME . ': Unknown image format.  The URL in question: ' . $image_uri);
		}
	}

	RESIZER_debug('type = ' . $type);

	// 画像取得用の一時ファイルは常に作成する
	$temp_filename  = tempnam(RESIZER_CACHE_DIRECTORY, 'img');
	$thumb_filename = RESIZER_CACHE_DIRECTORY . 'thm_' . md5($image_uri) . '.' . $type;
	RESIZER_debug('thumb_filename = ' . $thumb_filename);
	clearstatcache();

	if (!file_exists($thumb_filename)
	 OR RESIZER_isUpdated($image_uri, filemtime($thumb_filename))) {
		if ($temp_filename === FALSE) {
			$msg = SCRIPT_NAME . ': Cannot create a temporary file in "'
				 . RESIZER_CACHE_DIRECTORY . '"';
			COM_errorLog($msg);
			throw new Exception($msg);
		}

		// 取得した画像を一時ファイルに保存する
		if (file_put_contents($temp_filename, RESIZER_getFile($image_uri)) === FALSE) {
			$msg = SCRIPT_NAME . ': Cannot save a work file into "'
				 . RESIZER_CACHE_DIRECTORY . '"';
			COM_errorLog($msg);
			throw new Exception($msg);
		}

		// 元イメージのサイズを取得する
		list($s_width, $s_height) = getimagesize($temp_filename);

		switch ($type) {
			case 'jpg':
				$src_img = @imagecreatefromjpeg($temp_filename);
				break;

			case 'gif':
				$src_img = @imagecreatefromgif($temp_filename);
				break;

			case 'png':
				$src_img = @imagecreatefrompng($temp_filename);
				break;
		}

		if ($src_img === FALSE) {
			$msg = SCRIPT_NAME . ': Cannot read an image file "'
				 . $temp_filename . '"';
			COM_errorLog($msg);
			throw new Exception($msg);
		}

		// GDを使用して、画像を縮小する
		if (($s_width > $size) OR ($s_height > $size)) {
			if ($s_width > $s_height) {
				$height = intval($size * ($s_height / $s_width));
				$width  = $size;
			} else {
				$width  = intval($size * ($s_width / $s_height));
				$height = $size;
			}

			$dst_img = imagecreatetruecolor($width, $height);

			if ($dst_img === FALSE) {
				$msg = SCRIPT_NAME . ': Cannot create image.';
				COM_errorLog($msg);
				throw new Exception($msg);
			}

			imagefill($dst_img, 0, 0, imagecolorallocate($dst_img, 255, 255, 255));

			if (imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $width, $height, $s_width, $s_height) === FALSE) {
				$msg = SCRIPT_NAME . ': Cannot copy image.';
				COM_errorLog($msg);
				throw new Exception($msg);
			}

			// 縮小した画像をローカルに保存する
			switch ($out_type) {
				case 'png':
					imagepng($dst_img, $thumb_filename, $quality_png);
					break;

				case 'gif':
					imagegif($dst_img, $thumb_filename);
					break;

				default:
					imagejpeg($dst_img, $thumb_filename, $quality);
					break;
			}

			imagedestroy($dst_img);
		} else {
			// 縮小した画像をローカルに保存する
			switch ($out_type) {
				case 'png':
					imagepng($src_img, $thumb_filename, $quality_png);
					break;

				case 'gif':
					imagegif($src_img, $thumb_filename);
					break;

				default:
					imagejpeg($src_img, $thumb_filename, $quality);
					break;
			}
		}

		imagedestroy($src_img);
	}

	// ローカルに保存した画像を出力する
	mb_http_output('pass');
	header('Content-Type: image/' . $out_type);
	readfile($thumb_filename);

	@unlink($temp_filename);
} catch (Exception $e) {
	// エラー発生。エラーメッセージをログに残すには、18行目の行頭の#を消して、
	// define('RESIZER_DEBUG', TRUE);
	// とする。

	RESIZER_debug($e->getMessage());
	$broken_image = $_CONF['path_html'] . 'layout/mobile/images/icons/broken.jpg';
	clearstatcache();

	// "公開領域/layout/mobile/images/icons/broken.jpg"がある場合は、代わりに出
	// 力する。
	if (file_exists($broken_image)) {
		mb_http_output('pass');
		header('Content-Type: image/jpeg');
		readfile($broken_image);
	} else {
		header('HTTP/1.0 404 Not Found');
	}

	@unlink($temp_filename);
}

RESIZER_debug('***** End *****');
