<?php

if (!is_callable('DB_escapeString')) {
	return addslashes($str);
}

if (!is_callable('COM_createHTMLDocument')) {
	function COM_createHTMLDocument($content) {
		return COM_siteHeader() . $content . COM_siteFooter();
	}
}

if (!is_callable('COM_redirect')) {
	function COM_redirect($url) {
		echo COM_refresh($url);
		die();
	}
}

if (!is_callable('COM_output')) {
	require_once '../../../lib-common.php';

	function COM_output($str) {
		header('Content-Type: text/html; charset=' . COM_getCharset());
		echo $str;
	}
}
