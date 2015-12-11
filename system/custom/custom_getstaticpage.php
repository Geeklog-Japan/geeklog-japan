<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'custom_getstaticpage.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Returns the content of a given staticpage
*
* @author   mystral-kk - geeklog AT mystral-kk DOT net
* @license  GPL v2
* @param    $sp_id  string  an id of a staticpage
* @return           string  the content of the staticpage
*/
function CUSTOM_getStaticpage($sp_id) {
    global $_TABLES, $_PLUGINS, $_SP_CONF, $LANG_STATIC;
    
    $retval = '';
    
    if (!in_array('staticpages', $_PLUGINS)) {
        return $retval;
    }
    
    $sql = "SELECT sp_php, sp_content FROM {$_TABLES['staticpage']} "
         . "WHERE (sp_id = '" . addslashes($sp_id) . "') "
         . "AND " . SP_getPerms();
    $result = DB_query($sql);
    if (DB_error() OR (DB_numRows($result) == 0)) {
        return $retval;
    } else {
        $A = DB_fetchArray($result);
        $sp_php     = $A['sp_php'];
        $sp_content = stripslashes($A['sp_content']);
    }
    
    if ($_SP_CONF['allow_php'] == 1) {
        // Check for type (i.e. html or php)
        if ($sp_php == 1) {
            $retval .= eval($sp_content);
        } else if ($sp_php == 2) {
            ob_start();
            eval($sp_content);
            $retval .= ob_get_contents();
            ob_end_clean();
        } else {
            $retval .= PLG_replacetags($sp_content);
        }
    } else {
        if ($sp_php != 0) {
            COM_errorLog("PHP in static pages is disabled.  Cannot display page '{$sp_id}'.", 1);
            $retval .= $LANG_STATIC['deny_msg'];
        } else {
            $retval .= $sp_content;
        }
    }
    
    return $retval;
}
