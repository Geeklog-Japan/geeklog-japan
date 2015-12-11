<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
// +-------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or           |
// | modify it under the terms of the GNU General Public License             |
// | as published by the Free Software Foundation; either version 2          |
// | of the License, or (at your option) any later version.                  |
// |                                                                         |
// | This program is distributed in the hope that it will be useful,         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                    |
// | See the GNU General Public License for more details.                    |
// |                                                                         |
// | You should have received a copy of the GNU General Public License       |
// | along with this program; if not, write to the Free Software Foundation, |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.         |
// |                                                                         |
// +-------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Filemgmt default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */

global $_FM_DEFAULT;

$_FM_DEFAULT['mydownloads_perpage']      = 5;
$_FM_DEFAULT['mydownloads_popular']      = 20;
$_FM_DEFAULT['mydownloads_newdownloads'] = 10;
$_FM_DEFAULT['mydownloads_dlreport']     = 1;
$_FM_DEFAULT['mydownloads_trimdesc']     = 1;
$_FM_DEFAULT['mydownloads_whatsnew']     = 1;
$_FM_DEFAULT['mydownloads_selectpriv']   = 0;
$_FM_DEFAULT['mydownloads_uploadselect'] = 1;
$_FM_DEFAULT['mydownloads_publicpriv']   = 1;
$_FM_DEFAULT['mydownloads_uploadpublic'] = 1;
$_FM_DEFAULT['mydownloads_useshots']     = 1;
$_FM_DEFAULT['mydownloads_shotwidth']    = 50;
$_FM_DEFAULT['filemgmt_Emailoption']     = 1;
$_FM_DEFAULT['filemgmt_FileStore']       = $_CONF['path_html'] . 'filemgmt_data/files/';
$_FM_DEFAULT['filemgmt_SnapStore']       = $_CONF['path_html'] . 'filemgmt_data/snaps/';
$_FM_DEFAULT['filemgmt_SnapCat']         = $_CONF['path_html'] . 'filemgmt_data/category_snaps/';
$_FM_DEFAULT['filemgmt_FileStoreURL']    = $_CONF['site_url'] . '/filemgmt_data/files/';
$_FM_DEFAULT['filemgmt_FileSnapURL']     = $_CONF['site_url'] . '/filemgmt_data/snaps/';
$_FM_DEFAULT['filemgmt_SnapCatURL']      = $_CONF['site_url'] . '/filemgmt_data/category_snaps/';


/**
* Initialize Filemgmt plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_FM_CONF if available (e.g. from
* an old config.php), uses $_FM_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_filemgmt()
{
    global $_CONF, $_FM_CONF, $_FM_DEFAULT;

    if (is_array($_FM_CONF) && (count($_FM_CONF) > 1)) {
        $_FM_DEFAULT = array_merge($_FM_DEFAULT, $_FM_CONF);
    }

    $c = config::get_instance();
    $n = 'filemgmt';
    $o = 0;
    if ($c->group_exists($n)) return true;
    $c->add('sg_main',                  NULL,                                     'subgroup', 0, 0, NULL, 0,    true, $n);
    // ----------------------------------
    $c->add('fs_main',                  NULL,                                     'fieldset', 0, 0, NULL, 0,    true, $n);
    $c->add('mydownloads_perpage',      $_FM_DEFAULT['mydownloads_perpage'],      'text',     0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_popular',      $_FM_DEFAULT['mydownloads_popular'],      'text',     0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_newdownloads', $_FM_DEFAULT['mydownloads_newdownloads'], 'text',     0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_dlreport',     $_FM_DEFAULT['mydownloads_dlreport'],     'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_trimdesc',     $_FM_DEFAULT['mydownloads_trimdesc'],     'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_whatsnew',     $_FM_DEFAULT['mydownloads_whatsnew'],     'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_selectpriv',   $_FM_DEFAULT['mydownloads_selectpriv'],   'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_uploadselect', $_FM_DEFAULT['mydownloads_uploadselect'], 'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_publicpriv',   $_FM_DEFAULT['mydownloads_publicpriv'],   'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_uploadpublic', $_FM_DEFAULT['mydownloads_uploadpublic'], 'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_useshots',     $_FM_DEFAULT['mydownloads_useshots'],     'select',   0, 0, 0,    $o++, true, $n);
    $c->add('mydownloads_shotwidth',    $_FM_DEFAULT['mydownloads_shotwidth'],    'text',     0, 0, 0,    $o++, true, $n);
    $c->add('filemgmt_Emailoption',     $_FM_DEFAULT['filemgmt_Emailoption'],     'select',   0, 0, 0,    $o++, true, $n);
    // ----------------------------------
    $c->add('fs_path',                  NULL,                                     'fieldset', 0, 1, NULL, 0,    true, $n);
    $c->add('filemgmt_FileStore',       $_FM_DEFAULT['filemgmt_FileStore'],       'text',     0, 1, 0,    $o++, true, $n);
    $c->add('filemgmt_SnapStore',       $_FM_DEFAULT['filemgmt_SnapStore'],       'text',     0, 1, 0,    $o++, true, $n);
    $c->add('filemgmt_SnapCat',         $_FM_DEFAULT['filemgmt_SnapCat'],         'text',     0, 1, 0,    $o++, true, $n);
    // ----------------------------------
    $c->add('fs_url',                   NULL,                                     'fieldset', 0, 2, NULL, 0,    true, $n);
    $c->add('filemgmt_FileStoreURL',    $_FM_DEFAULT['filemgmt_FileStoreURL'],    'text',     0, 2, 0,    $o++, true, $n);
    $c->add('filemgmt_FileSnapURL',     $_FM_DEFAULT['filemgmt_FileSnapURL'],     'text',     0, 2, 0,    $o++, true, $n);
    $c->add('filemgmt_SnapCatURL',      $_FM_DEFAULT['filemgmt_SnapCatURL'],      'text',     0, 2, 0,    $o++, true, $n);

    $old_config_file = $_CONF['path'] . 'plugins/filemgmt/filemgmt.php';
    if (file_exists($old_config_file)) {
        include ($old_config_file);
        $c->set('mydownloads_popular'      , $mydownloads_popular,      $n);
        $c->set('mydownloads_newdownloads' , $mydownloads_newdownloads, $n);
        $c->set('mydownloads_perpage'      , $mydownloads_perpage,      $n);
        $c->set('mydownloads_trimdesc'     , $mydownloads_trimdesc,     $n);
        $c->set('mydownloads_whatsnew'     , $mydownloads_whatsnew,     $n);
        $c->set('mydownloads_dlreport'     , $mydownloads_dlreport,     $n);
        $c->set('mydownloads_selectpriv'   , $mydownloads_selectpriv,   $n);
        $c->set('mydownloads_publicpriv'   , $mydownloads_publicpriv,   $n);
        $c->set('mydownloads_uploadselect' , $mydownloads_uploadselect, $n);
        $c->set('mydownloads_uploadpublic' , $mydownloads_uploadpublic, $n);
        $c->set('mydownloads_useshots'     , $mydownloads_useshots,     $n);
        $c->set('mydownloads_shotwidth'    , $mydownloads_shotwidth,    $n);
        $c->set('filemgmt_Emailoption'     , $filemgmt_Emailoption,     $n);
        if (!empty($filemgmt_FileStore))    $c->set('filemgmt_FileStore'    , $filemgmt_FileStore,    $n);
        if (!empty($filemgmt_SnapStore))    $c->set('filemgmt_SnapStore'    , $filemgmt_SnapStore,    $n);
        if (!empty($filemgmt_SnapCat))      $c->set('filemgmt_SnapCat'      , $filemgmt_SnapCat,      $n);
        if (!empty($filemgmt_FileStoreURL)) $c->set('filemgmt_FileStoreURL' , $filemgmt_FileStoreURL, $n);
        if (!empty($filemgmt_FileSnapURL))  $c->set('filemgmt_FileSnapURL'  , $filemgmt_FileSnapURL,  $n);
        if (!empty($filemgmt_SnapCatURL))   $c->set('filemgmt_SnapCatURL'   , $filemgmt_SnapCatURL,   $n);
    }

    return true;
}

?>