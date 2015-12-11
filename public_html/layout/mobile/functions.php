<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | functions.php                                                             |
// |                                                                           |
// | Functions implementing the theme API                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
// |          Rouslan Placella  - rouslan AT placella DOT com                  |
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

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Return the configuration values for the theme
 */
function theme_config_mobile()
{
    return array(
        'image_type' => 'png',
        'doctype' => 'xhtml10strict'
    );
}

/**
 * Return an array of CSS files to be loaded
 */
function theme_css_mobile()
{
    global $_CONF, $LANG_DIRECTION;
    return array(
        array(
        )
    );
}

/**
 * Return an array of JS libraries to be loaded
 */
function theme_js_libs_mobile()
{
    return array();
}

/**
 * Return an array of JS files to be loaded
 */
function theme_js_files_mobile()
{
    global $_CONF;
    return array(
    );
}

/**
 * Do any other initialisation here
 */
function theme_init_mobile()
{
    global $_BLOCK_TEMPLATE, $_CONF;

     /*
     * For left/right block support there is no longer any need for the theme to
     * put code into functions.php to set specific templates for the left/right
     * versions of blocks. Instead, Geeklog will automagically look for
     * blocktemplate-left.thtml and blocktemplate-right.thtml if given
     * blocktemplate.thtml from $_BLOCK_TEMPLATE. So, if you want different left
     * and right templates from admin_block, just create blockheader-list-left.thtml
     * etc.
     */
    $_BLOCK_TEMPLATE['_msg_block'] = 'blockheader-message.thtml,blockfooter-message.thtml';
    $_BLOCK_TEMPLATE['configmanager_block'] = 'blockheader-config.thtml,blockfooter-config.thtml';
    $_BLOCK_TEMPLATE['configmanager_subblock'] = 'blockheader-config.thtml,blockfooter-config.thtml';
    $_BLOCK_TEMPLATE['whats_related_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';
    $_BLOCK_TEMPLATE['story_options_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';

    // Define the blocks that are a list of links styled as an unordered list - using class="blocklist"
    $_BLOCK_TEMPLATE['admin_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    $_BLOCK_TEMPLATE['section_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';

    if (! COM_isAnonUser()) {
        $_BLOCK_TEMPLATE['user_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    }
}

function mobile_siteFooter( $rightblock = -1, $custom = '' )
{
    global $_CONF, $_TABLES, $LANG01, $_PAGE_TIMER, $topic, $LANG_BUTTONS, $_USER;

    // use the right blocks here only if not in header already
    if ($_CONF['right_blocks_in_footer'] == 1)
    {
        if( $rightblock < 0)
        {
            if( isset( $_CONF['show_right_blocks'] ))
            {
                $rightblock = $_CONF['show_right_blocks'];
            }
            else
            {
                $rightblock = false;
            }
        }
    }

    COM_hit();

    // Set template directory
    $footer = new Template( $_CONF['path_layout'] );

    // Set template file
    $footer->set_file( array(
            'footer'      => 'footer.thtml',
            'rightblocks' => 'rightblocks.thtml',
            'leftblocks'  => 'leftblocks.thtml'
            ));

    // Do variable assignments
    $footer->set_var( 'xhtml', XHTML );
    $footer->set_var( 'site_url', $_CONF['site_url']);
    $footer->set_var( 'site_admin_url', $_CONF['site_admin_url']);
    $footer->set_var( 'layout_url',$_CONF['layout_url']);
    $footer->set_var( 'site_mail', "mailto:{$_CONF['site_mail']}" );
    $footer->set_var( 'site_name', $_CONF['site_name'] );
    $footer->set_var( 'site_slogan', $_CONF['site_slogan'] );
    $rdf = substr_replace( $_CONF['rdf_file'], $_CONF['site_url'], 0,
                           strlen( $_CONF['path_html'] ) - 1 );
    $footer->set_var( 'rdf_file', $rdf );
    $footer->set_var( 'rss_url', $rdf );

    $year = date( 'Y' );
    $copyrightyear = $year;
    if( !empty( $_CONF['copyrightyear'] ))
    {
        $copyrightyear = $_CONF['copyrightyear'];
    }
    $footer->set_var( 'copyright_notice', '&nbsp;' . $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $_CONF['site_name'] . '<br' . XHTML . '>&nbsp;'
            . $LANG01[94] );
    $footer->set_var( 'copyright_msg', $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $_CONF['site_name'] );
    $footer->set_var( 'current_year', $year );
    $footer->set_var( 'lang_copyright', $LANG01[93] );
    $footer->set_var( 'trademark_msg', $LANG01[94] );
    $footer->set_var( 'powered_by', $LANG01[95] );
    $footer->set_var( 'geeklog_url', 'http://www.geeklog.net/' );
    $footer->set_var( 'geeklog_version', VERSION );
    // Now add variables for buttons like e.g. those used by the Yahoo theme
    $footer->set_var( 'button_home', $LANG_BUTTONS[1] );
    $footer->set_var( 'button_contact', $LANG_BUTTONS[2] );
    $footer->set_var( 'button_contribute', $LANG_BUTTONS[3] );
    $footer->set_var( 'button_sitestats', $LANG_BUTTONS[7] );
    $footer->set_var( 'button_personalize', $LANG_BUTTONS[8] );
    $footer->set_var( 'button_search', $LANG_BUTTONS[9] );
    $footer->set_var( 'button_advsearch', $LANG_BUTTONS[10] );
    $footer->set_var( 'button_directory', $LANG_BUTTONS[11] );

    /* Check if an array has been passed that includes the name of a plugin
     * function or custom function.
     * This can be used to take control over what blocks are then displayed
     */
    if( is_array( $custom ))
    {
        $function = $custom['0'];
        if( function_exists( $function ))
        {
            $rblocks = $function( $custom['1'], 'right' );
        }
    }
    elseif( $rightblock )
    {
        $rblocks = COM_showBlocks( 'right', $topic );
    }

    if( $_CONF['left_blocks_in_footer'] == 1 )
    {
        $lblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $custom ))
        {
            $function = $custom[0];
            if( function_exists( $function ))
            {
                $lblocks = $function( $custom[1], 'left' );
            }
        }
        else
        {
            $lblocks = COM_showBlocks( 'left', $topic );
        }

        if( empty( $lblocks ))
        {
            $footer->set_var( 'left_blocks', '' );
            $footer->set_var( 'geeklog_blocks', '');
        }
        else
        {
            $footer->set_var( 'geeklog_blocks', $lblocks);
            $footer->parse( 'left_blocks', 'leftblocks', true );
            $footer->set_var( 'geeklog_blocks', '');
        }
    }

    if( $_CONF['right_blocks_in_footer'] == 1 && $rightblock)
    {
        $rblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( isset( $what) && is_array( $what ))
        {
            $function = $what[0];
            if( function_exists( $function ))
            {
                $rblocks = $function( $what[1], 'right' );
            }
            else
            {
                $rblocks = COM_showBlocks( 'right', $topic );
            }
        }
        else if( !isset( $what ) || ( $what <> 'none' ))
        {
            // Now show any blocks -- need to get the topic if not on home page
            $rblocks = COM_showBlocks( 'right', $topic );
        }

        if( empty( $rblocks ))
        {
            $footer->set_var( 'geeklog_blocks', '');
            $footer->set_var( 'right_blocks', '' );
        }
        else
        {
            $footer->set_var( 'geeklog_blocks', $rblocks);
            $footer->parse( 'right_blocks', 'rightblocks', true );
            $footer->set_var( 'geeklog_blocks', '');
        }
    }

    // Global centerspan variable set in index.php
    if( isset( $GLOBALS['centerspan'] ))
    {
        $footer->set_var( 'centerblockfooter-span', '</td></tr></table>' );
    }

    $exectime = $_PAGE_TIMER->stopTimer();
    $exectext = $LANG01[91] . ' ' . $exectime . ' ' . $LANG01[92];

    $footer->set_var( 'execution_time', $exectime );
    $footer->set_var( 'execution_textandtime', $exectext );

    /*
     * メニュー
     */
	$akey = 1;
	
    // ホ�Eム
    $footer->set_var( 'mn_tohome', '<a href="'. $_CONF['site_url'] .
                      '/" accesskey="' . $akey . '">' . $LANG01['68'] . '</a>' );
	$akey ++;
	
    // ログイン/ログアウチE
    if (!empty ($_USER['uid']) && ($_USER['uid'] > 1)) {
        	$footer->set_var( 'mn_login_or_logout',
						  '<a href="'. $_CONF['site_url'] .
                              '/users.php?mode=logout" accesskey="' . $akey . '">' . $LANG01['19'] . '</a>' );
    } else {
        	$footer->set_var( 'mn_login_or_logout',
						  '<a href="'. $_CONF['site_url'] .
                              '/users.php?mode=login" accesskey="' . $akey . '">' . $LANG01['47'] . '</a>' );
    }
	$akey ++;
	
    // 記事投稿
    $footer->set_var( 'mn_submit', '<a href="' . $_CONF['site_url'] .
                      '/submit.php?type=story" accesskey="' . $akey . '">' . $LANG01['71'] . '</a>' );
	$akey ++;
	
    // 掲示板
	$temp = DB_query("SELECT 1 AS cnt FROM {$_TABLES['plugins']} WHERE (pi_name = 'forum') AND (pi_enabled = '1')");
	if (DB_numRows($temp) == 1) {
	    $footer->set_var( 'mn_forum', '<a href="' . $_CONF['site_url'] .
    	                  '/forum/index.php" accesskey="' . $akey . '">' . "掲示板</a>" );
		$akey ++;
	}
	
    // 記事一覧
    $footer->set_var( 'mn_directory', '<a href="' . $_CONF['site_url'] .
                      '/directory.php" accesskey="' . $akey . '">' . $LANG01['117'] . '</a>' );
	$akey ++;
	
    // 検索
    $footer->set_var( 'mn_search', '<a href="' . $_CONF['site_url'] .
                      '/search.php" accesskey="' . $akey . '">' . $LANG01['75'] . '</a>' );
	$akey ++;
	
    // ブロチE��
    $footer->set_var( 'mn_block', '<a href="' . $_CONF['site_url'] .
                      '/mobileblocks.php" accesskey="' . $akey . '">サブメニュー</a>' );
	$akey ++;
	
    if (!empty ($_USER['uid']) && ($_USER['uid'] > 1)) {
    // マイアカウンチE
        $footer->set_var( 'mn_myaccount', '<a href="' . $_CONF['site_url'] .
                      '/usersettings.php?mode=edit" accesskey="' . $akey . '">' . $LANG01['48'] . '</a>' );
	$akey ++;
    } else if ($_CONF['disable_new_user_registration']==0) {
    // 新規登録
        	$footer->set_var( 'mn_myaccount', '<a href="' . $_CONF['site_url'] .
                      '/users.php?mode=new" accesskey="' . $akey . '">会員登録</a>' );
	$akey ++;
    }

    // Call to plugins to set template variables in the footer
    PLG_templateSetVars( 'footer', $footer );

    // Actually parse the template and make variable substitutions
    $footer->parse( 'index_footer', 'footer' );

    // Return resulting HTML
    return $footer->finish( $footer->get_var( 'index_footer' ));
}

?>
