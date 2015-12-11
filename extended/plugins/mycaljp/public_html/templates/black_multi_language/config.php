<?php
// Configulation for Mycaljp

switch ( COM_getLanguageId() ) {
case 'ja': // Japanese
    $_MYCALJP2_CONF['headertitleyear'] = 'Y年';
    $_MYCALJP2_CONF['headertitlemonth'] = 'm月';
    $_MYCALJP2_CONF['titleorder'] = true;
    $_MYCALJP2_CONF['sunday']    = '日';
    $_MYCALJP2_CONF['monday']    = '月';
    $_MYCALJP2_CONF['tuesday']   = '火';
    $_MYCALJP2_CONF['wednesday'] = '水';
    $_MYCALJP2_CONF['thursday']  = '木';
    $_MYCALJP2_CONF['friday']    = '金';
    $_MYCALJP2_CONF['saturday']  = '土';
    break;
    
case 'en': // English
    $_MYCALJP2_CONF['headertitleyear'] = 'Y';
    $_MYCALJP2_CONF['headertitlemonth'] = 'F';
    $_MYCALJP2_CONF['titleorder'] = false;
    $_MYCALJP2_CONF['sunday']    = 'Su';
    $_MYCALJP2_CONF['monday']    = 'M';
    $_MYCALJP2_CONF['tuesday']   = 'Tu';
    $_MYCALJP2_CONF['wednesday'] = 'W';
    $_MYCALJP2_CONF['thursday']  = 'Th';
    $_MYCALJP2_CONF['friday']    = 'F';
    $_MYCALJP2_CONF['saturday']  = 'Sa';
    break;
}

?>
