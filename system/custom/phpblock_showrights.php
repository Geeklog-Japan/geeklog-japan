<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'phpblock_showrights.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Shows a list of rights that the current user has
*
* @authors  Tony Bibbs       - tony AT tonybibbs DOT com
*           Blaine Lang      - blaine AT portalparts DOT com
*           Dirk Haun        - dirk AT haun-online DOT de
*           mystral-kk       - geeklog AT mystral-kk DOT net
* @license  GPL v2
* @version  2008-09-20
*/
function phpblock_showrights() {
    global $_RIGHTS, $_CONF, $LANG_CHARSET;
    
    if (isset($LANG_CHARSET)) {
        $encoding = $LANG_CHARSET;
    } else if (isset($_CONF['default_charset'])) {
        $encoding = $_CONF['default_charset'];
    } else {
        $encoding = 'utf-8';
    }
    
	$rights = $_RIGHTS;
	sort($rights);
    $retval = '<ul>' . LB;
    
    foreach ($rights as $R) {
        $R = str_replace(
            array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
            array(   '<',    '>',     '&',      '"',      "'"),
            $R
        );
        $R = htmlspecialchars($R, ENT_QUOTES, $encoding);
        $retval .=  '<li>' . $R . '</li>' . LB;
    }
    
    $retval .= '</ul>' . LB;
    
    return $retval;
}
