<?php
// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Site Calendar - Mycaljp Plugin for Geeklog                                |
// +---------------------------------------------------------------------------+
// | plugins/mycaljp/functions.inc                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// | Geeklog Author:        Tony Bibbs - tony AT tonybibbs DOT com             |
// | mycal Block Author:    Blaine Lang - geeklog AT langfamily DOT ca         |
// | Mycaljp Plugin Author: dengen - taharaxp AT gmail DOT com                 |
// | Original PHP Calendar by Scott Richardson - srichardson@scanonline.com    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/mycaljp/language/'
          . $_CONF['language'] . '.php';

if ( file_exists( $langfile ) ) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/mycaljp/language/english.php';
}

$_MYCALJP2_CONF = MYCALJP_loadConfig();

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+


/**
* This will put an option for the plugin in the command and control block on moderation.php
*
* Add the plugin name, icon and link to the command and control block in moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*
*/
function plugin_cclabel_mycaljp()
{
    global $_CONF;

    $pi_name   = ucfirst( 'mycaljp' );
    $admin_url = '';
    $icon_url  = $_CONF['site_url'] . '/mycaljp/images/mycaljp.png';

    return array ( $pi_name, $admin_url, $icon_url );
}

/**
 * Returns the version for this plugin
 *
 * @return string VersionNo
 */
function plugin_chkVersion_mycaljp()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/mycaljp/autoinstall.php';

    $inst_parms = plugin_autoinstall_mycaljp('mycaljp');

    return $inst_parms['info']['pi_version'];
}

/**
* Upgrade the plugin
*
* @return   boolean true (= success)
*
*/
function plugin_upgrade_mycaljp()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/mycaljp/autoinstall.php';

    return MYCALJP_upgrade();
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_mycaljp()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/mycaljp/autoinstall.php';

    return MYCALJP_autouninstall();
}

/**
* Callback function when configuration was changed
*
* @param    string  $group      'mycaljp'
* @param    array   $changes    array of strings: config var key
* @return   void
* @see      PLG_configChange
*/
function plugin_configchange_mycaljp($group, $changes = array())
{
    global $_MYCALJP2_CONF;

    if ($group != 'mycaljp') return;
    if (!is_array($changes)) return;
    if (count($changes) == 0) return;

    /**
    * At this time, changes in configuration is not reflected in
    * $_MYCALJP2_CONF yet.  So we have to reload them from DB.
    */
    $_MYCALJP2_CONF = MYCALJP_loadConfig();
    foreach ($changes as $name) MYCALJP_checkChange($name);
}

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_mycaljp($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'mycaljp/docs/' . $doclang . '/mycaljp.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/mycaljp/docs/english/mycaljp.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, NULL to use config
*                           tooltip hack, or empty string when not available
*
*/
function plugin_getconfigtooltip_mycaljp($id)
{
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

/**
* Loads config infor with config.class.php
*
* @return   mixed   Mycaljp config array or FALSE
*/
function MYCALJP_loadConfig()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $config = config::get_instance();
    return $config->get_config('mycaljp');
}

/**
* Check if changed types, priorities, or frequencies are valid
*
* @param  string    $name   either 'supported_contents' or 'enabled_contents'
* @return void
*/
function MYCALJP_checkChange($name)
{
    global $_CONF, $_PLUGINS, $_TABLES, $_MYCALJP2_CONF;

    $valids = array();

    require_once $_CONF['path'] . 'plugins/mycaljp/install_defaults.php';
    global $_MYCALJP2_DEFAULT;

    // Check and add a valid value to $valids
    switch ($name) {
        case 'supported_contents':
            foreach ($_MYCALJP2_CONF[$name] as $value) {
                if (!in_array($value, $_MYCALJP2_DEFAULT[$name])) continue;
                $valids[] = $value;
            }
            break;

        case 'enabled_contents':
            foreach ($_MYCALJP2_CONF['supported_contents'] as $value) {
                $valids[$value] = 0;
                if (array_key_exists($value, $_MYCALJP2_CONF[$name])) {
                    $valids[$value] = $_MYCALJP2_CONF[$name][$value];
                    if ($valids[$value] !== 1) $valids[$value] = 0;
                }
            }

            break;
    }

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $config = config::get_instance();
    if (!empty($valids)) {
        $config->set($name, $valids, 'mycaljp');
        $_MYCALJP2_CONF = $config->get_config('mycaljp');
    }

    switch ($name) {
        case 'supported_contents':
            $enabled_contents = array();
            foreach ($_MYCALJP2_CONF[$name] as $value) {
                $enabled_contents[$value] = 1;
                if (array_key_exists($value, $_MYCALJP2_CONF['enabled_contents'])) {
                    $enabled_contents[$value] = $_MYCALJP2_CONF['enabled_contents'][$value];
                }
            }
            $config->set('enabled_contents', $enabled_contents, 'mycaljp');
            break;
    }

}

// +-------------------------------------------------------------------------+
// | Main Program                                                            |
// +-------------------------------------------------------------------------+

if ( empty($_MYCALJP2_CONF['template']) ) {
    $_MYCALJP2_CONF['template'] = 'default';
}

// テンプレートパスおよびCSSのURLを設定する
if ($_MYCALJP2_CONF['use_theme'] && is_dir($_CONF['path_layout'] . 'mycaljp')) {
    $_MYCALJP2_CONF['path_layout'] = $_CONF['path_layout'] . 'mycaljp';
    // location of css file relative to public_html directory
    $_MYCALJP2_CONF['css_location'] = '/layout/' . $_CONF['theme'] . '/mycaljp';
} else {
    $_MYCALJP2_CONF['path_layout'] = $_CONF['path_html'] . 'mycaljp/templates/' . $_MYCALJP2_CONF['template'];
    $_MYCALJP2_CONF['css_location'] =                     '/mycaljp/templates/' . $_MYCALJP2_CONF['template'];
}

// テンプレートのパスを設定する
// slidecalendarのために残す。
if ( ! function_exists('mycaljp_setlayoutpath') ) {
    function mycaljp_setlayoutpath(){}
}

function MYCALJP_setLayoutPath_old() // for slidecalendar
{
    global $_CONF, $_MYCALJP2_CONF;

    if ( is_dir( $_CONF['path_layout'] . 'mycaljp' ) ) {
        $_MYCALJP2_CONF['path_layout'] = $_CONF['path_layout'] . 'mycaljp';
        // location of css file relative to public_html directory
        $_MYCALJP2_CONF['css_location'] = '/layout/' . $_CONF['theme'] . '/mycaljp';
    } else {
        $_MYCALJP2_CONF['path_layout'] = $_CONF['path_html'] . 'mycaljp/templates/' . $_MYCALJP2_CONF['template'];
        $_MYCALJP2_CONF['css_location'] =                     '/mycaljp/templates/' . $_MYCALJP2_CONF['template'];
    }
}


// もし、テンプレートパス内に config.php があればインクルードする
if (file_exists($_MYCALJP2_CONF['path_layout'] . '/config.php')) {
    include($_MYCALJP2_CONF['path_layout'] . '/config.php');
}

function MYCALJP_getTemplates()
{
    global $_CONF, $_MYCALJP2_CONF;

    $templates = array();
    $index = 0;
    $path_mycaljp = $_CONF['path_html'] . 'mycaljp/templates/';
    $fd = opendir($path_mycaljp);
    clearstatcache();
    while (($dir = @readdir($fd)) == true) {
        if (is_dir($path_mycaljp . $dir) && $dir <> '.' && $dir <> '..' && substr($dir, 0 , 1) <> '.') {
            $templates[$index] = $dir;
            $index++;
        }
    }
    sort($templates);

    return $templates;
}


/**
* Get header code for inclusion
*
* @return   string
*
*/
function plugin_getheadercode_mycaljp()
{
    global $_CONF, $_SCRIPTS, $_MYCALJP2_CONF;

    if (!$_MYCALJP2_CONF['block_enable']) return '';

    $_SCRIPTS->setCssFile('mycaljp.style', $_MYCALJP2_CONF['css_location'] . '/mycaljp.css');
    $_SCRIPTS->setJavaScriptFile('mycaljp.xmlhttp', '/mycaljp/xmlhttp.js');

    return '';
}

define ( "_MYCAL_DAY_", 86400 ); // 60 * 60 * 24
define ( "_STORY_"  , 1 );
define ( "_ACTIVE_" , 2 );

function MYCALJP_showCalendar( $caltype = 1 )
{
    global $_TABLES, $_CONF, $_PLUGINS, $_USER, $_MYCALJP2_CONF, $LANG_MYCALJP;

    if ( isset( $_USER['uid'] ) AND ( $_USER['uid'] > 1 ) ) {
        $uid = $_USER['uid'];
    } else {
        $uid = 1;
    }

    setlocale(LC_TIME, $_CONF['locale']);

    $tmpmonth = $_GET['moon'];
    if( isset( $GLOBALS['WorkDate'] ) )
        $WorkDate = $GLOBALS['WorkDate'];
    else if( !isset($tmpmonth) )
        $WorkDate = date("Y-m-d");
    else {
        $WorkDate = $tmpmonth;
        $GLOBALS['WorkDate'] = $WorkDate;
    }

    // Determine the first and last day to display
    $base               = strtotime($WorkDate) + 60 * 60 * 12;
    $firstdayofmonth    = $base - ((date("d", $base) - 1) * _MYCAL_DAY_);
    $daysinmonth        = date("t", $firstdayofmonth);
    $lastdayofmonth     = $firstdayofmonth + (($daysinmonth - 1) * _MYCAL_DAY_);
    $firstdaytodisplay  = $firstdayofmonth - (strftime ('%w', $firstdayofmonth) * _MYCAL_DAY_);
    $lastdaytodisplay   = $lastdayofmonth + ((6 - strftime ('%w', $lastdayofmonth)) * _MYCAL_DAY_);
    $totaldays          = ((($lastdaytodisplay - $firstdaytodisplay) / _MYCAL_DAY_) + 1);
    $totalweeks         = 6; // 固定してみる

    $firststr = date("Y-m-d", $firstdaytodisplay);
    $laststr  = date("Y-m-d", $lastdaytodisplay);
    $ds = explode("-", $firststr);
    $de = explode("-", $laststr);
    $startdate = mktime( 0, 0, 0,$ds[1],$ds[2],$ds[0]);
    $enddate   = mktime(23,59,59,$de[1],$de[2],$de[0]);

    $thismonth = date("Y-m-01", $base);
    $prevmonth = date("Y-m-01", strtotime($thismonth . "-1 month"));
    $nextmonth = date("Y-m-01", strtotime($thismonth . "+1 month"));

    $firstdayofmonthstr = date("Y-m-d", $firstdayofmonth);
    $lastdayofmonthstr  = date("Y-m-d", $lastdayofmonth);

    $firstdayofyearstr  = date("Y-01-01", $base);
    $lastdayofyearstr   = date("Y-12-31", $base);

    $dataproxy = Dataproxy::getInstance($uid);
    $drivers = Dataproxy::getAllDriverNames();
    $dataproxy->setDateStart($firststr);
    $dataproxy->setDateEnd($laststr);

    $days = array();

    if ( isset($_MYCALJP2_CONF['enabled_contents']) ) {
        foreach ($drivers as $driver) {

            $content = $driver;
            if ($driver=='article') $content = 'stories';
            if (!in_array($content, $_MYCALJP2_CONF['supported_contents'])) continue;
            if (!($_MYCALJP2_CONF['enabled_contents'][$content] == 1)) continue;
            $items = $dataproxy->$driver->getItemsByDate();
            if (count($items) == 0) continue;
            foreach ($items as $item) {
                $item_date = date("Y-m-d", $item['date']);
                switch ($driver) {
                    case 'article':
                        $days[$item_date] |= _STORY_;
                        break;

                    case 'calendar':
                    case 'calendarjp':
                        break;

                    default:
                        $days[$item_date] |= _ACTIVE_;
                        break;
                }
            }
        }

        $events = array();
        foreach ( $_MYCALJP2_CONF['enabled_contents'] as $pi_name => $val )
        {
            if ( in_array( $pi_name, $_PLUGINS ) )
            {
                switch ( $pi_name ) {
                case "calendar":
                case "calendarjp":
                    if ( ! MYCALJP_pi_enabled($pi_name) ) continue;
                    if ($pi_name == "calendar") {
                        $table = $_TABLES['events'];
                    } else if ($pi_name == "calendarjp") {
                        $table = $_TABLES['eventsjp'];
                    }
                    $sql = "SELECT eid,title,url,datestart,dateend,timestart,timeend,"
                         . "group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon "
                         . "FROM {$table} "
                         . "WHERE (datestart >= '$firststr') AND (datestart <= '$laststr') "
                         . COM_getPermSQL('AND');
                    $result = DB_query($sql);
                    while ( $o = DB_fetchArray($result) ) {
                        $events[ $o['datestart'] ][ $o['eid'] ] = $o; // $o['datestart']は"Y-m-d"形式文字列
                        if ( $o['datestart'] != $o['dateend'] ) {
                            $e_ds = explode("-", $o['datestart']);
                            $e_de = explode("-", $o['dateend']);
                            $e_ts = explode(":", $o['timestart']);
                            $e_te = explode(":", $o['timeend']);
                            $event_startdate = mktime($e_ts[0],$e_ts[1],$e_ts[2],$e_ds[1],$e_ds[2],$e_ds[0]);
                            $event_enddate   = mktime($e_te[0],$e_te[1],$e_te[2],$e_de[1],$e_de[2],$e_de[0]);

                            if ( $event_enddate - $event_startdate >= _MYCAL_DAY_ ) {
                                $event_middledate = $event_startdate + _MYCAL_DAY_;
                                while ( $event_enddate >= $event_middledate ) {
                                    $events[ date( "Y-m-d", $event_middledate ) ][ $o['eid'] ] = $o;
                                    $event_middledate += _MYCAL_DAY_;
                                }
                                $events[ $o['dateend'] ][ $o['eid'] ] = $o;
                            }
                        }
                    }

                    break;
                }
            }
        }
    }

    if ( $caltype == 2 ) { // for slidecalendar
        MYCALJP_setLayoutPath_old();
        // もし、テンプレートパス内に config.php があればインクルードする
        if (file_exists($_MYCALJP2_CONF['path_layout'] . '/config.php')) {
            include($_MYCALJP2_CONF['path_layout'] . '/config.php');
        }
    }
    $cal = new Template( $_MYCALJP2_CONF['path_layout'] );
    $cal->set_file( array(
        'calendar' => 'calendar.thtml',
        'header'   => 'header.thtml',
        'week'     => 'week.thtml',
        'day'      => 'day.thtml'
    ));
    $cal->set_var ( 'site_url', $_CONF['site_url'] );

    if ( $_MYCALJP2_CONF['headertitleyear'] )
        $headertitleyear = date( $_MYCALJP2_CONF['headertitleyear'], $base );
    else
        $headertitleyear = ucfirst( strftime( ( substr($_CONF['locale'],0,2) == "ja" ) ? "%Y年" : "%Y", $base ) );
    $anchor = '<a href="' . $_CONF["site_url"] . '/mycaljp/calsearch.php?datestart=' . $firstdayofyearstr
        . '&amp;dateend=' . $lastdayofyearstr . '&amp;type=all&amp;mode=search&amp;topic=0&amp;author=0&amp;moon=' . $thismonth
        . '" title="'. $LANG_MYCALJP['headeroflink'] . $headertitleyear . $LANG_MYCALJP['footeroflink'] . '">' . $headertitleyear . '</a>';
    $cal->set_var('title_' . ( ( $_MYCALJP2_CONF['titleorder'] == '1' ) ? '1' : '2' ) ,$anchor);
    $cal->set_var('title_year',$anchor); // for slidecalendar

    if ( $_MYCALJP2_CONF['headertitlemonth'] )
        $headertitlemonth = date( $_MYCALJP2_CONF['headertitlemonth'], $base );
    else
        $headertitlemonth = ucfirst( strftime( ( substr($_CONF['locale'],0,2) == "ja" ) ? "%m月" : "%B", $base ) );
    $anchor = '<a href="' . $_CONF["site_url"] . '/mycaljp/calsearch.php?datestart=' . $firstdayofmonthstr
        . '&amp;dateend=' . $lastdayofmonthstr . '&amp;type=all&amp;mode=search&amp;topic=0&amp;author=0'
        . '" title="'. $LANG_MYCALJP['headeroflink'] . $headertitlemonth . $LANG_MYCALJP['footeroflink'] . '">' . $headertitlemonth . '</a>';
    $cal->set_var('title_' . ( ( $_MYCALJP2_CONF['titleorder'] == '1' ) ? '2' : '1' ) ,$anchor);
    $cal->set_var('title_month',$anchor); // for slidecalendar

    // Header with Month Title and Next/Prev links
    $qstr = preg_replace( '/[&]*moon=[0-9]{4}-[0-9]{2}-[0-9]{2}/', '', $_SERVER["QUERY_STRING"] );
    $qstr = MYCALJP_htmlspecialchars( $qstr );

    $url = MYCALJP_htmlspecialchars( $_SERVER['PHP_SELF'] );

    $cal->set_var('lang_skipcalendar', $LANG_MYCALJP['skipcalendar'] ); // I consider the visually impaired.

    $tmp = $url . "?" . $qstr . "&amp;moon=" . $prevmonth;
    $tmp = str_replace( '?&amp;', '?', $tmp );
    $cal->set_var('prevmonth', $tmp );

    $tmp = $url . "?" . $qstr . "&amp;moon=" . $nextmonth;
    $tmp = str_replace( '?&amp;', '?', $tmp );
    $cal->set_var('nextmonth', $tmp );

    $cal->set_var('testprevmonth', $_CONF["site_url"] . "/mycaljp/showcal.php" . "?moon=" . $prevmonth );
    $cal->set_var('testnextmonth', $_CONF["site_url"] . "/mycaljp/showcal.php" . "?moon=" . $nextmonth );

    $cal->set_var('lang_prevmonth', $LANG_MYCALJP['prevmonth'] );
    $cal->set_var('lang_nextmonth', $LANG_MYCALJP['nextmonth'] );

    $wdays = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
    for ( $i = 0; $i < 7; $i++ )
    {
        $cal->set_var( 'weekday_class', $wdays[$i] );

        if ( $_MYCALJP2_CONF[ $wdays[$i] ] )
            $cal->set_var( 'title_weekday', $_MYCALJP2_CONF[ $wdays[$i] ] );
        else
            $cal->set_var( 'title_weekday', ucfirst(strftime("%a", $firstdaytodisplay + ($i * _MYCAL_DAY_))) );

        $cal->parse( 'dayofweeks_title', 'header', true );
    }

    for ( $w = 0; $w < $totalweeks; $w++ )
    {
        for ( $d = 0; $d < 7; $d++ )
        {
            $cal->set_var( 'daylink', MYCALJP_getDaysURL($events, $firstdaytodisplay + (_MYCAL_DAY_ * ($d + ($w * 7))), $base, $days, $d, $caltype) );
            $cal->parse( 'calendar_days','day', ($d > 0) );
        }
        $cal->parse( 'calendar_week', 'week', true );
    }

    return $cal->parse ( 'output', 'calendar' );
}


function MYCALJP_getDaysURL(&$events, $timestamp, $base, &$days, $weekday, $caltype=1)
{
    global $_TABLES, $_CONF, $_MYCALJP2_CONF, $CUSTOM_MOBILE_UA;

    $day = date( "j", $timestamp );
    $space = '';
    if ($CUSTOM_MOBILE_UA) {
        $day = substr('__' . $day, -2);
        $space = '--';
    }
    $key = date( "Y-m-d", $timestamp );
    $today = ( date("Y-m-d") == $key );
    $story  = ( ( $days[ $key ] & _STORY_  ) > 0 );
    $active = ( ( $days[ $key ] & _ACTIVE_ ) > 0 );
    $thismonth = ( date( "m", $timestamp ) == date( "m", $base ) );
    $sunday = false;
    $saturday = false;
    $holiday = false;

    if ( $_MYCALJP2_CONF['showholiday'] )
    {
        $sunday   = ( $weekday == 0 );
        $saturday = ( $weekday == 6 );
        if ( $_MYCALJP2_CONF['checkjpholiday'] )
            $holiday  = is_Japanese_Holiday($timestamp);
    }

    $event = '';
    if ( ( ! empty($events) ) && count( $events[$key] ) )
    {
        while ( list($k,$v) = each($events[$key]) )
        {
            if (SEC_hasAccess($v['owner_id'],$v['group_id'],$v['perm_owner'],$v['perm_group'],$v['perm_members'],$v['perm_anon']) > 0)
            {
                if ($event != '') $event .= ', ';
                $event .= $v['title'];
            }
        }
    }

    if ( $event || $active || $story )
    {
        $anchor = '<a href="' . $_CONF["site_url"] . '/mycaljp/calsearch.php?datestart=' . $key
            . '&amp;dateend=' . $key . '&amp;type=all&amp;mode=search&amp;topic=0&amp;author=0';
        $anchor .= $event ? '" title="'. $event : '';
        $anchor .= '">' . $day . '</a>';
    }

    $holidayclass = '';
    if ( $sunday )
        $holidayclass = ' sunday';
    elseif ( $saturday )
        $holidayclass = ' saturday';
    if ( $holiday )
        $holidayclass .= ' holiday';

    if ( ( ! $thismonth ) && ( $caltype != 1 ) ) return ''; // for slidecalender

    if ( $event )
    {
        if ( ! $thismonth )
        {
            $event_url = '<td class="NotThisMonth">' . $space;
        }
        else
        {
            $event_url = '<td class="' . ( $today ? 'TodayEvent' : 'Event' ) . $holidayclass . '">' . $anchor;
        }
    }
    elseif ( $story )
    {
        if ( ! $thismonth )
        {
            $event_url = '<td class="NotThisMonth">' . $space;
        }
        else
        {
            if ( $today )
            {
                $event_url = '<td class="Today' . $holidayclass . '">' . $day;

                if ( $story )
                {
                    $event_url = '<td class="TodayStory' . $holidayclass . '">' . $anchor;
                }
            }
            else
            {
                $event_url = ( $holidayclass ? '<td class="' . ltrim($holidayclass) . '">' : '<td>' ) . $day;

                if ( $story )
                {
                    $event_url = '<td class="Story' . $holidayclass . '">' . $anchor;
                }
            }
        }
    }
    else
    {
        if ( ! $thismonth )
        {
            $event_url = '<td class="NotThisMonth">' . $space;
        }
        else
        {
            if ( $today )
            {
                $event_url = '<td class="Today' . $holidayclass . '">' . $day;

                if ( $active )
                {
                    $event_url = '<td class="TodayActive' . $holidayclass . '">' . $anchor;
                }
            }
            else
            {
                $event_url = ( $holidayclass ? '<td class="' . ltrim($holidayclass) . '">' : '<td>' ) . $day;

                if ( $active )
                {
                    $event_url = '<td class="Active' . $holidayclass . '">' . $anchor;
                }
            }
        }
    }

    $event_url .= "</td>";

    return $event_url;
}


//
// Unixタイムスタンプ形式の日付が日本の休日かどうか判定する関数
//
// 判定ロジックは次のサイトを参照しています。
// http://www.h3.dion.ne.jp/~sakatsu/holiday_logic.htm
//
function is_Japanese_Holiday($timestamp)
{
  $weekday = strftime("%w",$timestamp);  // 日(0),月(1)‥土(6)
  $year    = strftime("%Y",$timestamp);
  $month   = strftime("%m",$timestamp);
  $day     = strftime("%d",$timestamp);

  switch ( $month )
  {
      case 1:// 1月
          if ( $day == 1 ) return true; //元日
          if ( $day == 2 && $weekday == 1 ) return true; //振替休日
          if ( $year >= 2000 )
          {
              $week = floor( ( $day - 1 ) / 7 ) + 1;
              if ( $week == 2 && $weekday == 1 ) return true; //成人の日(第2月曜日)
          }
          break;

      case 2:// 2月
          if ( $year >= 1967 )
          {
              if ( $day == 11 ) return true; //建国記念の日
              if ( $day == 12 && $weekday == 1 ) return true; //振替休日
          }
          break;

      case 3:// 3月
          if( $year > 1979 && $year < 2100 )
          {
              $SpringEquinox = floor( 20.8431 + 0.242194 * ( $year - 1980 ) - floor( ( $year - 1980 ) / 4 ) );
              if ( $day == $SpringEquinox ) return true; //春分の日
              if ( ( $day == $SpringEquinox + 1 ) && $weekday == 1 ) return true; //振替休日
          }
          break;

      case 4:// 4月
          if ( $day == 29 ) return true; //昭和の日
          if ( $day == 30 && $weekday == 1 ) return true; //振替休日
          break;

      case 5:// 5月
          if ( $day == 3 ) return true; //憲法記念日
          if ( $day == 4 )
          {
              if ( $year >= 2007 ) return true; //みどりの日
              if ( $year >= 1986 )
              {
                  // 5/4が日曜日は『只の日曜』､月曜日は『憲法記念日の振替休日』(～2006年)
                  if ( $weekday > 1 ) return true; //国民の休日
              }
          }
          if ( $day == 5 ) return true; //こどもの日
          if ( $year >= 2007 )
          {
              if ( $day == 6 && ( $weekday == 2 || $weekday == 3 ) ) return true; //振替休日
          }
          break;

      case 7:// 7月
          if ( $year >= 2003 )
          {
              $week = floor( ( $day - 1 ) / 7 ) + 1;
              if ( $week == 3 && $weekday == 1 ) return true; //海の日(第3月曜日)
          }
          elseif ( $year >= 1996 )
          {
              if ( $day == 20 ) return true; //海の日
          }
          break;

      case 9:// 9月
          $AutumnEquinox = floor( 23.2488 + 0.242194 * ( $year - 1980 ) - floor( ( $year - 1980 ) / 4 ) );
          if( $year > 1979 && $year < 2100 )
          {
              if ( $day == $AutumnEquinox ) return true; //秋分の日
              if ( ( $day == $AutumnEquinox + 1 ) && $weekday == 1 ) return true; //振替休日
          }
          if ( $year >= 2003 )
          {
              $week = floor( ( $day - 1 ) / 7 ) + 1;
              if ( $week == 3 && $weekday == 1 ) return true; //敬老の日(第3月曜日)
              if ( ( $day == $AutumnEquinox - 1 ) && $weekday == 2 ) return true; //国民の休日(敬老の日と秋分の日にはさまれた日)
          }
          elseif ( $year >= 1966 )
          {
              if ( $day == 15 ) return true; //敬老の日
          }
          break;

      case 10:// 10月
          if ( $year >= 2000 )
          {
              $week = floor( ( $day - 1 ) / 7 ) + 1;
              if ( $week == 2 && $weekday == 1 ) return true; //体育の日(第2月曜日)
          }
          elseif ( $year >= 1966 )
          {
              if ( $day == 10 ) return true; //体育の日
          }
          break;

      case 11:// 11月
          if ( $day == 3 ) return true; //文化の日
          if ( $day == 4 && $weekday == 1 ) return true; //振替休日
          if ( $day == 23 ) return true; //勤労感謝の日
          if ( $day == 24 && $weekday == 1 ) return true; //振替休日
          break;

      case 12:// 12月
          if ( $year >= 1989 )
          {
              if ( $day == 23 ) return true; //天皇誕生日
              if ( $day == 24 && $weekday == 1 ) return true; //振替休日
          }
          break;
  }
  return false;
}

/**
* Strips slashes if magic_quotes_gpc is on
*/
function MYCALJP_stripslashes($var)
{
    if (get_magic_quotes_gpc()) {
        if (is_array($var)) {
            return array_map('MYCALJP_stripslashes', $var);
        }
        return stripslashes($var);
    }
    return $var;
}


function MYCALJP_htmlspecialchars( $str )
{
    global $_CONF, $LANG_CHARSET;

    $encoding = 'utf-8';
    if (isset($LANG_CHARSET)) {
        $encoding = $LANG_CHARSET;
    } else if (isset($_CONF['default_charset'])) {
        $encoding = $_CONF['default_charset'];
    }
    $str = str_replace('%27', "'", $str);

    return htmlspecialchars($str, ENT_QUOTES, $encoding);
}


function MYCALJP_pi_enabled($pi_name)
{
    global $_TABLES, $_MYCALJP2_CONF;

    if ($_MYCALJP2_CONF['enabled_contents'][$pi_name] != 1) return false;
    return ( DB_getItem($_TABLES['plugins'], 'pi_enabled', "pi_name = '$pi_name'") == 1 );
}

// PHPブロック関数
function phpblock_mycaljp2()
{
    global $LANG_MYCALJP;

    if (!class_exists('Dataproxy')) return $LANG_MYCALJP['no_dataproxy'];
    return MYCALJP_showCalendar();
}

if (!function_exists('phpblock_mycaljp'))
{
    // PHPブロック関数
    function phpblock_mycaljp()
    {
        global $LANG_MYCALJP;

        if (!class_exists('Dataproxy')) return $LANG_MYCALJP['no_dataproxy'];
        return MYCALJP_showCalendar();
    }
}

if (!function_exists('mycaljp_slidecalender'))
{
    // slidecalender
    function mycaljp_slidecalender()
    {
        global $LANG_MYCALJP;

        if (!class_exists('Dataproxy')) return $LANG_MYCALJP['no_dataproxy'];
        return MYCALJP_showCalendar( 2 );
    }
}

/**
* Gets Geeklog blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param    string  $side   Side to get blocks for (right or left for now)
* @param    string  $topic  Only get blocks for this topic
* @return   array           array of block data
* @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
*
*/
function plugin_getBlocks_mycaljp($side, $topic='')
{
    global $_TABLES, $_CONF, $_MYCALJP2_CONF, $LANG_MYCALJP;

    $retval = array();

    if (!$_MYCALJP2_CONF['block_enable']) return $retval;

    $owner_id = SEC_getDefaultRootUser();

    // Check permissions first
    if (!SEC_hasAccess($owner_id,
                      $_MYCALJP2_CONF['block_group_id'],
                      $_MYCALJP2_CONF['block_permissions'][0],
                      $_MYCALJP2_CONF['block_permissions'][1],
                      $_MYCALJP2_CONF['block_permissions'][2],
                      $_MYCALJP2_CONF['block_permissions'][3])) {
        return $retval;
    }

    // Check if right topic
    if (($_MYCALJP2_CONF['block_topic_option'] == TOPIC_ALL_OPTION) ||
        ($_MYCALJP2_CONF['block_topic_option'] == TOPIC_HOMEONLY_OPTION && COM_onFrontpage()) ||
        ($_MYCALJP2_CONF['block_topic_option'] == TOPIC_SELECTED_OPTION && in_array($topic, $_MYCALJP2_CONF['block_topic']))) {

        if (($side=='left'  && $_MYCALJP2_CONF['block_isleft'] == 1) ||
            ($side=='right' && $_MYCALJP2_CONF['block_isleft'] == 0)) {

            $retval[] = array('name'           => 'sitecalendar',
                              'type'           => 'dynamic',
                              'onleft'         => $_MYCALJP2_CONF['block_isleft'],
                              'title'          => $LANG_MYCALJP['block_title'],
                              'blockorder'     => $_MYCALJP2_CONF['block_order'],
                              'content'        => phpblock_mycaljp2(),
                              'allow_autotags' => false,
                              'help'           => '');
        }
    }

    return $retval;
}


/**
* Gets config information for dynamic blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param    string  $side   Side to get blocks for (right or left for now)
* @param    string  $topic  Only get blocks for this topic
* @return   array           array of block data
* @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
*
*/
function plugin_getBlocksConfig_mycaljp($side, $topic='')
{
    global $_TABLES, $_CONF, $_MYCALJP2_CONF, $LANG_MYCALJP;

    $retval = array();

    $owner_id = SEC_getDefaultRootUser();

    // Check permissions first
    if (!SEC_hasAccess($owner_id,
                      $_MYCALJP2_CONF['block_group_id'],
                      $_MYCALJP2_CONF['block_permissions'][0],
                      $_MYCALJP2_CONF['block_permissions'][1],
                      $_MYCALJP2_CONF['block_permissions'][2],
                      $_MYCALJP2_CONF['block_permissions'][3])) {
        return $retval;
    }

    if (($side=='left'  && $_MYCALJP2_CONF['block_isleft'] == 1) ||
        ($side=='right' && $_MYCALJP2_CONF['block_isleft'] == 0)) {

        $retval[] = array('plugin'         => $LANG_MYCALJP['plugin_name'],
                          'name'           => 'sitecalendar',
                          'title'          => $LANG_MYCALJP['block_title'],
                          'type'           => 'dynamic',
                          'onleft'         => $_MYCALJP2_CONF['block_isleft'],
                          'blockorder'     => $_MYCALJP2_CONF['block_order'],
                          'allow_autotags' => false,
                          'help'           => '',
                          'enable'         => $_MYCALJP2_CONF['block_enable'],
                          'topic_option'   => $_MYCALJP2_CONF['block_topic_option'],
                          'topic'          => $_MYCALJP2_CONF['block_topic'],
                          'inherit'        => array()
                          );
    }

    return $retval;
}

/**
* This function is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
* @return   void
*
*/
function plugin_group_changed_mycaljp($grp_id, $mode)
{
    global $_TABLES, $_GROUPS, $_MYCALJP2_CONF;

    if ($mode == 'delete') {
        // Change any deleted group ids to Mycaljp Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['Mycaljp Admin'])) {
            $new_group_id = $_GROUPS['Mycaljp Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Mycaljp Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }

        // Update Site Calendar Block group if need be
        if ($_MYCALJP2_CONF['block_group_id'] == $grp_id) {
            // Now save it to the configuration
            $c = config::get_instance();
            $c->set('block_group_id', $new_group_id, 'mycaljp');
        }
   }
}

/**
* Helper function: Provide templates dropdown
*
* @return   array   Array of (filename, displayname) pairs
*
*/
function plugin_configmanager_select_template_mycaljp()
{
    $themes = array();

    $themeFiles = MYCALJP_getTemplates();

    foreach ($themeFiles as $theme) {
        $words = explode('_', $theme);
        $bwords = array();
        foreach ($words as $th) {
            if ((strtolower($th[0]) == $th[0]) &&
                (strtolower($th[1]) == $th[1])) {
                $bwords[] = ucfirst($th);
            } else {
                $bwords[] = $th;
            }
        }
        $themes[implode(' ', $bwords)] = $theme;
    }

    return $themes;
}

/**
* Config Manager function
*
* @return   array   Array of (groud id, group name) pairs
*
*/
function plugin_configmanager_select_block_group_id_mycaljp()
{
    return SEC_getUserGroups();
}

/**
* Config Manager function
*
* @return   array   Array of (topic id, topic name) pairs
*
*/
function plugin_configmanager_select_block_topic_mycaljp()
{
    return array_flip(TOPIC_getList());
}

?>
