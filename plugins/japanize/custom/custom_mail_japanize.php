<?php

// ==================================================================
//  日本語メール関数
//
//  @summary  Geeklog-1.4.1以降のメールを従来のISO-2022-JP(JIS)
//            メールに戻します。
//  @author   mystral-kk - geeklog AT mystral-kk DOT net
//  @license  LGPL
//  @version  2013-01-02
//  @note     このハックが不要な場合は、system/lib-custom.phpの中の
//            require_once('custom/custom_mail_jp.php');
//            を削除してください。
// ==================================================================

// *** ご注意 ***
//
// ・jpmailプラグインと同時に使用できません。先にjpmailプラグインをアンインス
//   トールしてください。
//
// ・メールが送れない場合や見出しなどが乱れる場合の対処法
//
//   最新情報は、http://wiki.geeklog.jp/index.php/CUSTOM_mail を参照してくださ
//   い。
//
//   1. コンフィギュレーション - サイト - メール - メール設定[backend]
//     （Geeklog-1.4.1では、config.phpの $_CONF['mail_settings']['backend']）
//      を smtp に変えてみる。この場合、「メール設定[host]」、
//     「メール設定[username]」、「メール設定[password]」なども設定する必要があ
//      ります（Geeklog-1.4.1では、それぞれ、config.phpの
//      $_CONF['mail_settings']['host']、$_CONF['mail_settings']['username']、
//      $_CONF['mail_settings']['password']）。
//
//   2. 「メールヘッダの改行文字」を \n に変えてみる。
//
//   3. 「ヘッダのエンコード方法」を ICONV_MIME_ENCODE や CUSTOM_ENCODE に変え
//      てみる。CUSTOM_ENCODEの場合は、「メールヘッダの1行の長さの最大値」を既
//      定値の76を大きくすることで改善される場合があります。

if (strpos(strtolower($_SERVER['PHP_SELF']), 'custom_mail_japanize.php') !== false) {
	die('This file cannot be used on its own!');
}

global $_CONF, $LANG_CHARSET, $_TABLES;

// デバッグ用
//define('CUSTOM_MAIL_DEBUG', true);

/**
* メールヘッダ・本文で使用するエンコーディング
*
* UI言語を日本語にしている場合のみISO-2022-JPにし、それ以外の場合はutf-8にします。
*/
if (strpos(strtolower(COM_getLanguage()), 'japanese') !== false) {
	define('CUSTOM_MAIL_ENCODING', 'ISO-2022-JP');
} else {
	define('CUSTOM_MAIL_ENCODING', 'utf-8');
}

/**
* ヘッダのエンコード方法
*
* MB_ENCODE_MIMEHEADER: PHPのmb_encode_mimeheader()を使用する（既定値）
*    ICONV_MIME_ENCODE: iconv_mime_encode()を使用する
*        CUSTOM_ENCODE: mb_encode_mimeheader()が正常に動作しないPHPのバージョ
*                       ン(4.3.11, 4.4.0, 4.4.1, 5.0.0～5.1.0など)用に独自の
*                       エンコード方法を使用する
*/
define('CUSTOM_MAIL_HEADER_ENCODE', 'CUSTOM_ENCODE');
// define('CUSTOM_MAIL_HEADER_ENCODE', 'MB_ENCODE_MIMEHEADER');

/**
* CUSTOM_ENCODEを使用する場合のメールヘッダの1行の長さの最大値
*
* 既定値を変更する必要はまずないでしょう（上記の「ご注意」参照）。400 にするのは、
* 他の方法がうまくいかない場合の最終的な手段です。
*/
// define('CUSTOM_MAIL_HEADER_LENGTH', 76);
define('CUSTOM_MAIL_HEADER_LENGTH', 400);

/**
* メールヘッダの改行文字
*
* サーバの環境によってはメールの件名や差出人が乱れて、本文に流れ込むことがあり
* ます。その場合は \n にする必要があるかもしれません。特に「ヘッダのエンコード
* 方法」に CUSTOM_ENCODE を指定した場合は、\n にしないと動作しないことが多いよ
* うです。
*/
define('CUSTOM_MAIL_HEADER_LINEBREAK', "\n");
// define('CUSTOM_MAIL_HEADER_LINEBREAK', "\r\n");

/**
* アドレスのコメント部分の引用符
*
* 既定値はGeeklog本家版の動作に合わせてあります。
*/
define('CUSTOM_MAIL_COMMENT_ENCLOSER', '"');    // ""でくるむ
// define('CUSTOM_MAIL_COMMENT_ENCLOSER', '');   // 引用符なし

///////////////////////////////////////////////////////////////////////////////
// ここから下は変更しないでください。
///////////////////////////////////////////////////////////////////////////////

// Geeklogの内部エンコーディング
if (isset($LANG_CHARSET)) {
	define('CUSTOM_MAIL_INTERNAL_ENCODING', $LANG_CHARSET);
} else if (isset($_CONF['default_charset'])) {
	define('CUSTOM_MAIL_INTERNAL_ENCODING', $_CONF['default_charset']);
} else {
	define('CUSTOM_MAIL_INTERNAL_ENCODING', 'utf-8');
}

// 本文の改行文字
define(
	'CUSTOM_MAIL_BODY_LINEBREAK',
	(substr(PHP_OS, 0, 3) === 'WIN') ? "\r\n" : "\n"
);

/**
* Converts encoding
*/
function CUSTOM_convertEncoding($string, $to_encoding, $from_encoding = NULL) {
	if ($from_encoding === NULL) {
		if (is_callable('mb_detect_encoding')) {
			$from_encoding = @mb_detect_encoding(
				$string,
				array(
					CUSTOM_MAIL_INTERNAL_ENCODING, 'utf-8', 'eucjp-win', 'euc-jp',
					'sjis-win', 'sjis', 'iso-8859-1', 'ascii'
				)
			);
		}
	}

	if (empty($from_encoding)) {
		$from_encoding = CUSTOM_MAIL_INTERNAL_ENCODING;
	}

	if (is_callable('mb_convert_encoding')) {
		return mb_convert_encoding($string, $to_encoding, $from_encoding);
	} else if (is_callable('iconv')) {
		return iconv($from_encoding, $to_encoding, $string);
	} else {
		COM_errorLog('CUSTOM_convertEncoding: no way to convert encoding.');
		return $string;
	}
}

/**
* Encodes a string such that it can be used in an email header
*
* @param    string  $string     the text to be encoded.  The encoding should be
*                               the same as that of GL's internal encoding,
*                               which will returned from COM_getCharset().
* @return   string              encoded text
*/
function CUSTOM_emailEscape($string) {
	global $_CONF, $LANG_CHARSET;

	$retval = '';

	if (defined('CUSTOM_MAIL_DEBUG')) {
		COM_errorLog('CUSTOM_emailEscape: input=' . $string);
	}

	// PHPのmb_encode_mimeheader()を使用する場合
	if (CUSTOM_MAIL_HEADER_ENCODE === 'MB_ENCODE_MIMEHEADER') {
		if (is_callable('mb_encode_mimeheader')) {
			if (is_callable('mb_convert_encoding')) {
				$string = mb_convert_encoding(
					$string, CUSTOM_MAIL_ENCODING, CUSTOM_MAIL_INTERNAL_ENCODING
				);
			} else {
				COM_errorLog('CUSTOM_emailEscape: function mb_convert_encoding() not callable.');
			}

			$old_mb_internal_encoding = mb_internal_encoding();
			mb_internal_encoding(CUSTOM_MAIL_ENCODING);
			$string = mb_encode_mimeheader(
				$string, CUSTOM_MAIL_ENCODING, 'B', CUSTOM_MAIL_HEADER_LINEBREAK
			);
			mb_internal_encoding($old_mb_internal_encoding);

			return $string;
		} else {
			COM_errorLog('CUSTOM_emailEscape: function mb_encode_mimeheader() not callable.');
		}
	}

	// ASCIIだけの場合は"(\x22)だけエスケープする
	if (!preg_match("/[^\\x00-\\x7f]/", $string)) {
		return str_replace('"', '\\"', $string);
	}

	// PHPのiconv_mime_encode()を使用する場合
	if (CUSTOM_MAIL_HEADER_ENCODE === 'ICONV_MIME_ENCODE') {
		if (is_callable('iconv_mime_encode')) {
			$prefs = array(
				'scheme'           => 'B',
				'input-charset'    => CUSTOM_MAIL_INTERNAL_ENCODING,
				'output-charset'   => CUSTOM_MAIL_ENCODING,
				'line-length'      => CUSTOM_MAIL_HEADER_LENGTH,
				'line-break-chars' => CUSTOM_MAIL_HEADER_LINEBREAK
			);
			$string = iconv_mime_encode('subject', $string, $prefs);
			$string = ltrim(substr($string, strpos($string, ':') + 1));

			return $string;
		} else {
			COM_errorLog('CUSTOM_emailEscape: function iconv_mime_encode() not callable.  Tries to use custom encoding method instead.');
		}
	}

	// 独自のエンコード方法を使用する。従来の処理と同じ。
	if (is_callable('mb_convert_encoding')) {
		$string = mb_convert_encoding(
			$string, CUSTOM_MAIL_ENCODING, CUSTOM_MAIL_INTERNAL_ENCODING
		);

		$len_mime = strlen('=?' . CUSTOM_MAIL_ENCODING . '?B?' . '?=');
		$cnt      = strlen('Subject: ');
		$parts    = array();
		$old_mb_internal_encoding = mb_internal_encoding();
		mb_internal_encoding(CUSTOM_MAIL_ENCODING);

		while ($string != '') {
			$maxlen = mb_strlen($string);
			$cut    = $maxlen;

			for ($i = 1; $i <= $maxlen; $i ++) {
				$temp = base64_encode(mb_substr($string, 0, $i));
				if (strlen($temp) + $len_mime + $cnt > CUSTOM_MAIL_HEADER_LENGTH) {
					$cut = $i - 1;
					break;
				}
			}

			$temp    = base64_encode(mb_substr($string, 0, $cut));
			$parts[] = '=?' . CUSTOM_MAIL_ENCODING . '?B?' . $temp . '?=';
			$string  = mb_substr($string, $cut);
			$cnt     = 1;
		}

		mb_internal_encoding($old_mb_internal_encoding);
		$string = implode(CUSTOM_MAIL_HEADER_LINEBREAK . ' ', $parts);
		
		if (defined('CUSTOM_MAIL_DEBUG')) {
			COM_errorLog('CUSTOM_emailEscape: output=' . $string);
		}

		return $string;
	}

	// どのエンコード方法も使用できなかった...
	COM_errorLog('CUSTOM_emailEscape: no function found to convert encodings.');
	return $string;
}

/**
* Takes a name and an email address and returns a string that vaguely
* resembles an email address specification conforming to RFC(2)822 ...
*
* @param    string  $name       name, e.g. John Doe
* @param    string  $address    email address only, e.g. john.doe@example.com
* @return   string              formatted email address
*/
function CUSTOM_formatEmailAddress($name, $address) {
	if (empty($name)) {
		return $address;
	}

	$formatted_name = CUSTOM_emailEscape($name);
	
	if ($formatted_name == $name) {
		$formatted_name = str_replace('"', '\\"', $formatted_name);
	}
	
	if (strlen('From: ' . $formatted_name . $address) > CUSTOM_MAIL_HEADER_LENGTH) {
		$address = CUSTOM_MAIL_HEADER_LINEBREAK . ' ' . $address;
	}

	$retval = CUSTOM_MAIL_COMMENT_ENCLOSER . $formatted_name
			. CUSTOM_MAIL_COMMENT_ENCLOSER . ' <' . $address . '>';
	
	if (defined('CUSTOM_MAIL_DEBUG')) {
		COM_errorLog('CUSTOM_formatEmailAddress: output=' . $retval);
	}

	return $retval;
}

/**
* Splits "comment <address>" into comment and address
*
* @note  This function will not be called since Geeklog-1.5.2
*/
function CUSTOM_splitAddress($string) {
	$comment = '';
	$string  = rtrim($string);

	if (substr($string, -1) !== '>') {
		$address = $string;
	} else {
		$address = strrchr($string, '<');
		
		if ($address === false) {
			COM_errorLog('CUSTOM_splitAddress: "<" not found.');
			$address = $string;
		} else {
			$comment = rtrim(substr($string, 0, strlen($string) - strlen($address)));
			$address = substr($address, 1, strlen($address) - 2);
		}
	}

	if (defined('CUSTOM_MAIL_DEBUG')) {
		COM_errorLog('CUSTOM_splitAddress: comment=' . $comment . ' address=' . $address);
	}

	return array($comment, $address);
}

/**
* Custom email function for creating an email message in ISO-2022-JP
*/
function CUSTOM_mail($to, $subject, $message, $from = '', $html = false,
		$priority = 0, $cc = '') {
	global $_CONF, $LANG_CHARSET;

	static $mailobj;

	include_once 'Mail.php';
	include_once 'Mail/RFC822.php';

	if (defined('CUSTOM_MAIL_DEBUG')) {
		COM_errorLog('CUSTOM_mail: to=' . $to . ' subject=' . $subject);
	}

	// 余分なヘッダを追加されないように改行コードを削除
	$to      = substr($to, 0, strcspn($to, "\r\n"));
	$cc      = substr($cc, 0, strcspn($cc, "\r\n"));
	$from    = substr($from, 0, strcspn($from, "\r\n"));
	$subject = substr($subject, 0, strcspn($subject, "\r\n"));

	// Fromが空の場合は、サイト管理者のアドレスにする
	if (empty($from)) {
		$from = COM_formatEmailAddress($_CONF['site_name'], $_CONF['site_mail']);
	}

	// ヘッダをエスケープ（1.5.2では、この時点でエスケープ済み）
	// NOTE: version_compare(VERSION, '1.5.2')とすると、security releaseでは
	//       判定に失敗する
	preg_match("/^(\d+\.\d+\.\d+).*$/", VERSION, $match);

	if (version_compare($match[1], '1.5.2') < 0) {
		list($temp_to_comment, $temp_to_address) = CUSTOM_splitAddress($to);
		$to      = CUSTOM_formatEmailAddress($temp_to_comment, $temp_to_address);
		list($temp_cc_comment, $temp_cc_address) = CUSTOM_splitAddress($cc);
		$cc      = CUSTOM_formatEmailAddress($temp_cc_comment, $temp_cc_address);
		list($temp_from_comment, $temp_from_address) = CUSTOM_splitAddress($from);
		$from    = CUSTOM_formatEmailAddress($temp_from_comment, $temp_from_address);
		$subject = CUSTOM_emailEscape($subject);
	}

	// 本文をエスケープ
	$message = CUSTOM_convertEncoding($message, CUSTOM_MAIL_ENCODING);
	$message = str_replace(
		array("\r\n", "\n", "\r"), CUSTOM_MAIL_BODY_LINEBREAK, $message
	);

	// メールオブジェクトを作成
	$method  = $_CONF['mail_settings']['backend'];
	
	if (!isset($mailobj)) {
		if (($method === 'sendmail') OR ($method === 'smtp')) {
			$mailobj =& Mail::factory($method, $_CONF['mail_settings']);
		} else {
			$mailobj =& Mail::factory($method);
		}
	}

	// ヘッダ組み立て
	$headers = array();
	$headers['From'] = $from;
	
	if ($method != 'mail') {
		$headers['To'] = $to;
	}
	
	if (!empty($cc)) {
		$headers['Cc'] = $cc;
	}
	
	$headers['Date'] = date('r'); // RFC822 formatted date
	
	if ($method === 'smtp') {
		list($usec, $sec) = explode(' ', microtime());
		$m = substr($usec, 2, 5);
		$headers['Message-Id'] = '<' .  date('YmdHis') . '.' . $m
							   . '@' . $_CONF['mail_settings']['host'] . '>';
	}
	
	if($html) {
		$headers['Content-Type'] = 'text/html; charset=' . CUSTOM_MAIL_ENCODING;
		$headers['Content-Transfer-Encoding'] = '8bit';
	} else {
		$headers['Content-Type'] = 'text/plain; charset=' . CUSTOM_MAIL_ENCODING;
	}
	
	$headers['Subject'] = $subject;
	
	if ($priority > 0) {
		$headers['X-Priority'] = $priority;
	}
	
	$headers['X-Mailer'] = 'Geeklog-' . VERSION . ' (' . CUSTOM_MAIL_ENCODING . ')';
	$retval = $mailobj->send($to, $headers, $message);
	
	if ($retval !== true) {
		COM_errorLog($retval->toString(), 1);
	}

	return ($retval === true);
}
