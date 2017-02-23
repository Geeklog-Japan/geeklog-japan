<?php

// +---------------------------------------------------------------------------+
// | Japanize Plugin for Geeklog - The Ultimate Weblog                         |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/japanize/functions.inc                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tsuchi           - tsuchi AT geeklog DOT jp                      |
// |          mystral-kk       - geeklog AT mystral-kk DOT net                 |
// +---------------------------------------------------------------------------+
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own.');
}

$langfile = $_CONF['path'] . 'plugins/japanize/language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $_CONF['path'] . 'plugins/japanize/language/japanese_utf-8.php';
}

require_once 'version.php';
require_once $_CONF['path'] . 'plugins/japanize/japanize_data.php';

if (!is_callable('CUSTOM_convertEncoding') &&
    !is_callable('CUSTOM_emailEscape') &&
    !is_callable('CUSTOM_formatEmailAddress') &&
    !is_callable('CUSTOM_splitAddress') &&
    !is_callable('CUSTOM_mail') &&
    version_compare(VERSION, '2.1.2', '<=')) {
    require_once dirname(__FILE__) . '/custom/custom_mail_japanize.php';
}

/**
* Convert language file name to language ID
*
* @param   string   $language
* @return  string
*/
function JAPANIZE_languageToLangId($language) {
    $retval = '';
    
    $lang_mappings = array(
        'afrikaans'           => 'af',
        'bosnian'             => 'bs',
        'bulgarian'           => 'bg',
        'catalan'             => 'ca',
        'chinese_simplified'  => 'zh-cn',
        'chinese_traditional' => 'zh',
        'croatian'            => 'hr',
        'czech'               => 'cs',
        'danish'              => 'da',
        'dutch'               => 'nl',
        'english'             => 'en',
        'estonian'            => 'et',
        'farsi'               => 'fa',
        'finnish'             => 'fi',
        'french_canada'       => 'fr-ca',
        'french_france'       => 'fr',
        'german'              => 'de',
        'german_formal'       => 'de',
        'hebrew'              => 'he',
        'hellenic'            => 'el',
        'indonesian'          => '',
        'italian'             => 'it',
        'japanese'            => 'ja',
        'korean'              => 'ko',
        'norwegian'           => 'no',
        'polish'              => 'pl',
        'portuguese'          => 'pt',
        'portuguese_brazil'   => 'pt-br',
        'romanian'            => 'ro',
        'russian'             => 'ru',
        'slovak'              => 'sk',
        'slovenian'           => 'sl',
        'spanish'             => 'es',
        'spanish_argentina'   => 'es',
        'swedish'             => 'sv',
        'turkish'             => 'tr',
        'ukrainian'           => 'uk',
    );

    if (isset($language)) {
        $lang = str_replace('_utf-8', '', $language);
        
        if (isset($lang_mappings[$lang])) {
            $retval = $lang_mappings[$lang];
        }
    }

    return $retval;
}

/**
* Set a variable to {lang_attribute} / {html_attribute} template var
*
* @param   object  $template
*/
function JAPANIZE_setHtmlAttribute($template) {
    global  $_USER, $_CONF;
    
    $langId = COM_getLanguageId();

    if ($langId === '') {
        $langId = JAPANIZE_languageToLangId(@$_USER['language']);
        
        if ($langId === '') {
            // Tries to derive the language id from the locale
            $l = explode('.', $_CONF['locale']); // get rid of character set
            $langId = $l[0];
            $l = explode('@', $langId); // get rid of '@euro', etc.
            $langId = $l[0];
        }
    }

    if (!empty($langId)) {
        $l = explode('-', str_replace('_', '-', $langId));
        
        if ((count($l) === 1) && (strlen($langId) === 2)) {
            // Do nothing
        } elseif (count($l) === 2) {
            if (($l[0] === 'i') || ($l[0] === 'x')) {
                $langId = implode('-', $l);
            } elseif (strlen($l[0]) === 2) {
                $langId = implode('-', $l);
            } else {
                $langId = $l[0];
            }
        }
    }

    switch ($_CONF['doctype']) {
        case 'html401transitional':
        case 'html401strict':
            $html_attribute = ' lang="' . $langId . '"';
            break;

        case 'xhtml10transitional':
        case 'xhtml10strict':
            $html_attribute = ' xml:lang="' . $langId . '" lang="' . $langId . '"';
            break;

        default:
            $html_attribute = ' lang="' . $langId.'"';
            break;
    }

    $template->set_var('lang_attribute', $html_attribute);
    $template->set_var('html_attribute', $html_attribute);	// Left for compatibility
}

function JAPANIZE_execute($type, $lang) {
    global $_CONF, $_TABLES, $_JAPANIZE_DATA;
    
    if (!SEC_hasRights('japanize.edit')) {
        return;
    }
    
    $type = (string) $type;
    
    switch ($type) {
        case '1':
            foreach ($_JAPANIZE_DATA[1] as $sqls) {
                DB_query($sqls[$lang]);
            }
            break;
        
        case '2':
            foreach ($_JAPANIZE_DATA[2] as $d) {
                $sql = "UPDATE {$_TABLES['groups']} "
                     . "SET grp_descr = '" . DB_escapeString($d[$lang]) . "' "
                     . "WHERE (grp_name = '" . DB_escapeString($d['group']) . "') ";
                DB_query($sql);
            }
            break;
    
        case '3':
            foreach ($_JAPANIZE_DATA[3] as $d) {
                if (isset($d['type']) && ($d['type'] === 'sql')) {
                    $sql = $d[$lang];
                } else {
                    $sql = "UPDATE {$_TABLES['blocks']} "
                         . "SET title = '" . DB_escapeString($d[$lang]) . "' "
                         . "WHERE (name = '" . DB_escapeString($d['name']) . "') ";
                }
                
                DB_query($sql);
            }
            break;
    
        case '4':
            require_once $_CONF['path_system'] . 'classes/config.class.php';
            
            $c = config::get_instance();

            foreach ($_JAPANIZE_DATA[4] as $method => $groups) {
                foreach ($groups as $groupName => $items) {
                    foreach ($items as $itemName => $data) {
                        if ($method === 'set') {
                            $c->set($itemName, $data[$lang], $groupName);
                        } elseif ($method === 'set_default') {
                            $c->set_default($itemName, $data[$lang], $groupName);
                        }
                    }
                }
            }
            break;
    
        case '5':
            foreach ($_JAPANIZE_DATA[5] as $d) {
                if ($lang === 'ja') {
                    if (DB_getItem($_TABLES['pingservice'], 'COUNT(*)', "site_url = '" . DB_escapeString($d['site_url']) . "'") === '0') {
                        DB_query($d['sql']);
                    }
                } else {
                    $sql = "DELETE FROM {$_TABLES['pingservice']} "
                         . "WHERE (site_url = '" . DB_escapeString($d['site_url']) . "') "
                         . "LIMIT 1 ";
                    DB_query($sql);
                }
            }
            break;
        
        case '6':
            foreach ($_JAPANIZE_DATA[6] as $ft_name => $ft_descr) {
                $sql = "UPDATE {$_TABLES['features']} "
                     . "SET ft_descr = '" . DB_escapeString($ft_descr[$lang]) . "' "
                     . "WHERE (ft_name = '" . DB_escapeString($ft_name) . "') ";
                DB_query($sql);
            }
            break;
        
        default:
            COM_errorLog(__FUNCTION__ . ': Unknown type "' . $type . '" was called.');
            break;
    }
}

function JAPANIZE_str($str) {
    global $LANG_JPN;
    
    return isset($LANG_JPN[$str]) ? $LANG_JPN[$str] : '(undefined)';
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+

function plugin_chkVersion_japanize() {
    global $_JPN_CONF;

    return $_JPN_CONF['version'];
}

function plugin_upgrade_japanize() {
    global $_TABLES, $_JPN_CONF;

    // the plugin needs these functions so complain when they doesn't exist
    if (!is_callable('COM_truncate') || !function_exists('MBYTE_strpos') || !function_exists('DB_escapeString')) {
        return 3002;
    }

    // No db changes - just update the version numbers
    $sql = "UPDATE {$_TABLES['plugins']} "
         . "SET pi_version = '" . DB_escapeString($_JPN_CONF['version']) . "', "
         . "    pi_gl_version = '" . DB_escapeString(VERSION) . "' "
         . "WHERE (pi_name = 'japanize') ";
    DB_query($sql);

    return true;
}

function plugin_autouninstall_japanize() {
    // Undo all Japanizations
    for ($type = 1; $type <= 5; $type ++) {
        JAPANIZE_execute($type, 'en');
    }
    
    return array(
        'tables'     => array(),
        'groups'     => array('japanize Admin'),
        'features'   => array('japanize.edit'),
        'php_blocks' => array(),
        'vars'       => array('japanize_plugin'),
    );
}

# /**
# * @return        boolean       Returns true if moderator
# */
# function plugin_ismoderator_japanize() {
#   return true;
# }
# 
function plugin_geticon_japanize() {
    global $_CONF;

    return $_CONF['site_url'] . '/japanize/images/japanize.png';
}

function plugin_cclabel_japanize() {
    global $_CONF;

    if (SEC_hasRights('japanize.edit')) {
        return array(
            'japanize',
            $_CONF['site_admin_url'] . '/plugins/japanize/index.php',
            plugin_geticon_japanize()
        );
    } else {
        return false;
    }
}

function plugin_getadminoption_japanize() {
    global $_CONF, $_TABLES, $LANG_JPN;

    if (SEC_hasRights('japanize.edit')){
        $count = 0;
        $current = (int) @DB_getItem($_TABLES['vars'], 'value', "name='japanize_plugin'");
        
        for ($i = 1; $i <= 6; $i ++) {
            $v = pow(2, $i - 1);
            
            if (($current & $v) === $v) {
                $count ++;
            }
        }
        
        return array(
            $LANG_JPN['piname'],
            $_CONF['site_admin_url'] . '/plugins/japanize/index.php',
            (string) $count . '/6'
        );
    } else {
        return false;
    }
}

function plugin_templatesetvars_japanize($templatename, &$template) {
    global $LANG01, $LANG_JPN;

    switch ($templatename) {
        case 'header':
            // Override {welcome_msg}
            $welcome_msg_jp = COM_isAnonUser()
                            ? ''
                            : $LANG01[67] . COM_getDisplayName() . $LANG_JPN['keisyo'];
            $template->set_var('welcome_msg', $welcome_msg_jp);

            // Override {lang_attribute}
            JAPANIZE_setHtmlAttribute($template);
    }
}
