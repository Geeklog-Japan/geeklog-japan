<?php

/**
* Disable incompatible plugins to prevent an error which will occur during
* the upgrade process.
*
* @link  http://code.google.com/p/geeklog-jp/wiki/manage151
*/
function GEEKLOGJP_disablePlugins() {
    global $_TABLES;
    
	/**
	* Geeklog-1.5.xで動作確認の取れているプラグインのリスト。
	* $allowed_plugins['プラグイン英語名'] = '動作する最低バージョン' のフォー
	* マット。Geeklogに同梱されているプラグインはチェック不要なので、バージョン
	* は '*' とする。
	*/
	$allowed_plugins = array(
		'staticpages'  => '*',
		'links'        => '*',
		'polls'        => '*',
		'calendar'     => '*',
		'autotags'     => '1.01',
		'calendarjp'   => '1.1.6',
		'captcha'      => '3.5.5',
		'custommenu'   => '0.2.2',
		'dataproxy'    => '2.0.0',
		'dbman'        => '0.7.1',
		'filemgmt'     => '1.6.0.jp3',
		'forum'        => '2.9.0hg',
		'japanize'     => '2.1.0',
		'mycaljp'      => '2.0.5',
		'nmoxtopicown' => '1.0.12',
		'sitemap'      => '1.1.2',
		'themedit'     => '1.2.1',
	);
	
	$sqls = array();
	
	$sql = "SELECT pi_name, pi_version "
		 . "FROM {$_TABLES['plugins']} "
		 . "WHERE (pi_enabled = '1') ";
	$result = DB_query($sql);
	if (!DB_error()) {
		while (($A = DB_fetchArray($result)) !== false) {
			$pi_name    = $A['pi_name'];
			$pi_version = $A['pi_version'];
			if (array_key_exists($pi_name, $allowed_plugins)) {
				if (($allowed_plugins[$pi_name] == '*')
				 OR (version_compare($pi_version, $allowed_plugins[$pi_name]) >= 0)) {
					continue;
				}
			}
			
			$sqls[] = "UPDATE {$_TABLES['plugins']} "
   				    . "SET pi_enabled = '0' "
         			. "WHERE (pi_name = '" . addslashes($pi_name) . "') ";
		}
		
		if (count($sqls) > 0) {
			foreach ($sqls as $sql) {
    			DB_query($sql);
			}
		}
	}
}

/**
* Geeklog日本語拡張版に同梱のプラグインを、Geeklog本体のインストールと同時に
* インストールするかどうかを制御する。
* TRUE:インストールする。 FALSE:インストールしない。
*/
$_GEEKLOGJP_pi_preinstall = array(
    'calendar'     => TRUE,
    'links'        => TRUE,
    'polls'        => TRUE,
    'spamx'        => TRUE,
    'staticpages'  => TRUE,
    'xmlsitemap'   => FALSE,
    'autotags'     => FALSE,
    'calendarjp'   => FALSE,
    'captcha'      => FALSE,
    'custommenu'   => FALSE,
    'dataproxy'    => FALSE,
    'dbman'        => FALSE,
    'filemgmt'     => FALSE,
    'forum'        => FALSE,
    'japanize'     => FALSE,
    'mycaljp'      => FALSE,
    'nmoxqrblock'  => FALSE,
    'nmoxtopicown' => FALSE,
    'sitemap'      => FALSE,
    'themedit'     => FALSE,
    'tkgmaps'      => FALSE
);

