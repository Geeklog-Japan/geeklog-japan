<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.8.0                                               |
// +---------------------------------------------------------------------------+
// | gf_format.php                                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |                                                                           |
// | Copyright (C) 2000,2001,2002,2003 by the following authors:               |
// |    Tony Bibbs       tony AT tonybibbs DOT com                             |
// |                                                                           |
// | Forum Plugin Authors                                                      |
// |    Mr.GxBlock                                        www.gxblock.com      |
// |    Matthew DeWyer   matt AT mycws DOT com            www.cweb.ws          |
// |    Blaine Lang      geeklog AT langfamily DOT ca     www.langfamily.ca    |
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
// +---------------------------------------------------------------------------+

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'gf_format.php') !== false) {
    die ('This file can not be used on its own.');
}

if (!class_exists('StringParser') ) {
    require_once $CONF_FORUM['path_include'] . 'bbcode/stringparser_bbcode.class.php';
}

function gf_createHTMLDocument(&$content = '', $subject = '', $noIndex = 0) {
    global $CONF_FORUM;

    // Display Common headers
    if (!isset($CONF_FORUM['showblocks'])) $CONF_FORUM['showblocks'] = 'leftblocks';
    if (!isset($CONF_FORUM['usermenu'])) $CONF_FORUM['usermenu'] = 'blockmenu';

    $information = array();
    $information['pagetitle'] = $subject;
    $information['what'] = 'menu';
    $information['rightblock'] = false;
    if ($noIndex) {
        $information['headercode'] = '<meta name="robots" content="noindex"' . XHTML . '>';
    }

    if ($CONF_FORUM['showblocks'] == 'noblocks' OR $CONF_FORUM['showblocks'] == 'rightblocks') {
        $information['what'] = 'none';
    } elseif ($CONF_FORUM['showblocks'] == 'leftblocks' OR $CONF_FORUM['showblocks'] == 'allblocks') {
        if ($CONF_FORUM['usermenu'] == 'blockmenu') {
            $CONF_FORUM['add_forum_menu_check'] = 1;
        }
    }

    if ($CONF_FORUM['showblocks'] == 'rightblocks') {
        $information['rightblock'] = true;
        if ($CONF_FORUM['usermenu'] == 'blockmenu') {
            $CONF_FORUM['add_forum_menu_check'] = 1;
        }
    } elseif ($CONF_FORUM['showblocks'] == 'allblocks') {
        $information['rightblock'] = true;
    }

    return COM_createHTMLDocument($content, $information);
}

function convertlinebreaks ($text) {
    return preg_replace ("/\015\012|\015|\012/", "\n", $text);
}

function bbcode_stripcontents ($text) {
    return preg_replace ("/[^\n]/", '', $text);
}

function bbcode_htmlspecialchars($text) {
    global $CONF_FORUM;

    return (htmlspecialchars ($text,ENT_QUOTES, $CONF_FORUM['charset']));
}

function gf_fixtemplate($text) {
    $text = str_replace('{','&#123;',$text);
    $text = str_replace('}','&#125;',$text);

    return $text;
}

function do_bbcode_url ($action, $attributes, $content, $params, $node_object) {
    global $CONF_FORUM;

    if ($action == 'validate') {
        return true;
    }
    if (!isset ($attributes['default'])) {
        if ( stristr($content,'http') ) {
            return '<a href="'.$content.'" target="_blank" rel="nofollow">'.htmlspecialchars ($content,ENT_QUOTES, $CONF_FORUM['charset']).'</a>';
        } else {
            return '<a href="http://'.$content.'" target="_blank" rel="nofollow">'.htmlspecialchars ($content,ENT_QUOTES, $CONF_FORUM['charset']).'</a>';
        }
    }
    if ( stristr($attributes['default'],'http') ) {
        return '<a href="'.strip_tags($attributes['default']).'" target="_blank" rel="nofollow">'.$content.'</a>';
    } else {
        return '<a href="http://'.strip_tags($attributes['default']).'" target="_blank" rel="nofollow">'.$content.'</a>';
    }
}

function do_bbcode_list ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        return true;
    }
    if (!isset ($attributes['default'])) {
        return '<ul>'.$content.'</ul>';
    } else {
        if ( is_numeric($attributes['default']) ) {
            return '<ol>'.$content.'</ol>';
        } else {
            return '<ul>'.$content.'</ul>';
        }
    }
    return '<ul>'.$content.'</ul>';
}


function do_bbcode_img ($action, $attributes, $content, $params, $node_object) {
    global $CONF_FORUM;

    if ($action == 'validate') {
        if (isset($attributes['caption'])) {
            $node_object->setFlag('paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
            if ($node_object->_parent->type() == STRINGPARSER_NODE_ROOT OR
                in_array($node_object->_parent->_codeInfo['content_type'], array('block', 'list', 'listitem'))) {
                return true;
            }
            else return false;
        }
        else return true;
    }

    if ($CONF_FORUM['allow_img_bbcode']) {
        if ( isset($attributes['h']) AND isset ($attributes['w']) ) {
            $dim = 'width="' . COM_applyFilter($attributes['w'], true) . '" height="' . COM_applyFilter($attributes['h'], true) . '" ';
        } else {
            $dim = '';
        }
        if ( isset($attributes['align'] ) ) {
            $align = ' align="' . COM_applyFilter($attributes['align']) . '" ';
        } else {
            $align = '';
        }

        return '<img src="'.htmlspecialchars($content,ENT_QUOTES, $CONF_FORUM['charset']).'" ' . $dim . $align . 'alt=""'. XHTML .'>';
    } else {
        return '[img]' . $content . '[/img]';
    }
}

function do_bbcode_size  ($action, $attributes, $content, $params, $node_object) {
    if ( $action == 'validate') {
        return true;
    }
    return '<span style="font-size: '.COM_applyFilter($attributes['default'], true).'px;">'.$content.'</span>';
}

function do_bbcode_color  ($action, $attributes, $content, $params, $node_object) {
    if ( $action == 'validate') {
        return true;
    }
    return '<span style="color: '.COM_applyFilter($attributes['default']).';">'.$content.'</span>';
}

function do_bbcode_code($action, $attributes, $content, $params, $node_object) {
    global $CONF_FORUM, $oldPost;

    if ( $action == 'validate') {
        return true;
    }

    if ( $oldPost ) {
        $content = str_replace("&#36;","$", $content);
        $content = html_entity_decode($content);
    }

    if ($CONF_FORUM['allow_smilies']) {
        if (function_exists('msg_restoreEmoticons') AND $CONF_FORUM['use_smilies_plugin']) {
            $content = msg_restoreEmoticons($content);
        } else {
            $content = forum_xchsmilies($content,true);
        }
    }
    if ($CONF_FORUM['use_geshi']) {
        /* Support for formatting various code types : [code=java] for example */
        if (!isset ($attributes['default'])) {
            $codeblock = geshi_formatted($content);
        } else {
            $codeblock = geshi_formatted($content,strtoupper(COM_applyFilter($attributes['default'])));
        }
    } else {
        $codeblock = '<pre class="codeblock">'  . htmlspecialchars($content,ENT_QUOTES, $CONF_FORUM['charset']) . '</pre>';
    }
    $codeblock = str_replace('{','&#123;',$codeblock);
    $codeblock = str_replace('}','&#125;',$codeblock);

    return $codeblock;
}


function forumNavbarMenu($current='') {
    global $_CONF, $CONF_FORUM, $_USER, $LANG_GF01, $LANG_GF02;

    require_once $_CONF['path_system'] . 'classes/navbar.class.php';
    $navmenu = new navbar; 
    $navmenu->add_menuitem($LANG_GF01['INDEXPAGE'],"{$_CONF['site_url']}/forum/index.php");
    $navmenu->set_onclick($LANG_GF01['INDEXPAGE'], 'location.href="' . "{$_CONF['site_url']}/forum/index.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
    if (!COM_isAnonUser()) {  
        $navmenu->add_menuitem($LANG_GF02['msg197'],"{$_CONF['site_url']}/forum/index.php?op=markallread");
        // Added as a fix for the navbar class (since uikit tabs do not support urls)
        //$navmenu->set_onclick($LANG_GF02['msg197'], 'return confirm("' . $LANG_GF02['msg301'] . '");');
        $navmenu->set_onclick($LANG_GF02['msg197'], '
          if (confirm("' . $LANG_GF02['msg301'] . '")) {
            window.location.href="' . "{$_CONF['site_url']}/forum/index.php?op=markallread" . '";
          }
          return false;        
        ');
        $navmenu->add_menuitem($LANG_GF01['USERPREFS'],"{$_CONF['site_url']}/forum/userprefs.php");
        $navmenu->set_onclick($LANG_GF01['USERPREFS'], 'location.href="' . "{$_CONF['site_url']}/forum/userprefs.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
        $navmenu->add_menuitem($LANG_GF01['SUBSCRIPTIONS'],"{$_CONF['site_url']}/forum/notify.php");
        $navmenu->set_onclick($LANG_GF01['SUBSCRIPTIONS'], 'location.href="' . "{$_CONF['site_url']}/forum/notify.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
    }
    if (($CONF_FORUM['show_memberslist_anonymous'] && COM_isAnonUser()) OR !COM_isAnonUser()) {
    	$navmenu->add_menuitem($LANG_GF02['msg200'],"{$_CONF['site_url']}/forum/memberlist.php");
        $navmenu->set_onclick($LANG_GF02['msg200'], 'location.href="' . "{$_CONF['site_url']}/forum/memberlist.php" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
	}
    $navmenu->add_menuitem($LANG_GF02['msg201'],"{$_CONF['site_url']}/forum/index.php?op=popular");
    $navmenu->set_onclick($LANG_GF02['msg201'], 'location.href="' . "{$_CONF['site_url']}/forum/index.php?op=popular" . '";'); // Added as a fix for the navbar class (since uikit tabs do not support urls)
    if ($current != '') {
        $navmenu->set_selected($current);
    }
    return $navmenu->generate();
}

function ForumHeader($forum, $showtopic, &$display) {
    global $_TABLES, $_CONF, $CONF_FORUM, $LANG_GF01, $LANG_GF02;

    $navbar = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $navbar->set_file (array ('topicheader'=>'navbar.thtml'));
    $navbar->set_var ('search_forum', f_forumsearch());
    $navbar->set_var ('select_forum', f_forumjump());
    if ($CONF_FORUM['usermenu'] == 'navbar') {
        if ($forum == 0) {
            $navbar->set_var('navmenu', forumNavbarMenu($LANG_GF01['INDEXPAGE']));
        } else {
            $navbar->set_var('navmenu', forumNavbarMenu());
        }
    } else {
        $navbar->set_var('navmenu','');
    }
    $navbar->parse ('output', 'topicheader');
    $display .= $navbar->finish($navbar->get_var('output'));

    if (($forum != '') || ($showtopic != '')) {
        if ($showtopic != '') {
            $forum_id = DB_getItem($_TABLES['forum_topic'],'forum',"id='$showtopic'");
            $grp_id = DB_getItem($_TABLES['forum_forums'],'grp_id',"forum_id='$forum_id'");
        } elseif ($forum != "") {
            $grp_id = DB_getItem($_TABLES['forum_forums'],'grp_id',"forum_id='$forum'");
        }
        $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='$grp_id'");
        if (!SEC_inGroup($groupname)) {
        	$display .= alertMessage($LANG_GF02['msg77'], $LANG_GF01['ACCESSERROR']);
            COM_handle404("{$_CONF['site_url']}/forum/index.php");
            exit;
        }
    }
}

function gf_checkHTMLforSQL($str,$postmode='html') {
    global $CONF_FORUM;

    $bbcode = new StringParser_BBCode ();
    $bbcode->setGlobalCaseSensitive (false);
    // It is impossible to include block level elements in a <p> element. Therefore I fix this.
    $bbcode->setParagraphHandlingParameters ("\n\n", "", "");

    if ( $CONF_FORUM['use_glfilter'] == 1 && ($postmode == 'html' || $postmode == 'HTML')) {
        $bbcode->addParser(array('block','inline'), 'gf_cleanHTML');
    }
    $bbcode->addCode ('code', 'simple_replace', null, array ('start_tag' => '[code]', 'end_tag' => '[/code]'),
                      'code', array ('listitem', 'block', 'inline', 'link'), array ());
    $str = $bbcode->parse ($str);
    return $str;
}

/**
* Cleans (filters) HTML - only allows HTML tags specified in the
* $_CONF['user_html'] string.  This function is designed to be called
* by the stringparser class to filter everything except [code] blocks.
*
* @param        string      $message        The topic post to filter
* @return       string      filtered HTML code
*/
function gf_cleanHTML($message) {
    global $_CONF, $CONF_FORUM;

    if ( isset( $_CONF['skip_html_filter_for_root'] ) &&
             ( $_CONF['skip_html_filter_for_root'] == 1 ) &&
            SEC_inGroup( 'Root' ))
    {
        return $message;
    }
    
    // If user has story edit previlages then can use html allowed by admins
    return gf_htmLawed($str, 'story.edit');
    
}


function gf_preparefordb($message,$postmode) {
    global $CONF_FORUM, $_CONF;

    // if magic quotes is on, remove the slashes from the $_POST
    if (get_magic_quotes_gpc() ) {
       $message = stripslashes($message);
    }
    
    // Remove Icons if database cannot store them (ie table collation needs to be utf8mb4)
    $message = GLText::remove4byteUtf8Chars($message);

    if ( $CONF_FORUM['use_glfilter'] == 1 && ($postmode == 'html' || $postmode == 'HTML') ) {
        $message = gf_checkHTMLforSQL($message,$postmode);
    }

    if ($CONF_FORUM['use_censor']) {
        $message = COM_checkWords($message);
    }
    $message = addslashes($message);
    return $message;
}

function geshi_formatted($str,$type='PHP') {
    global $_CONF, $CONF_FORUM;

    include_once 'geshi.php';

    $geshi = new Geshi($str,$type,"{$CONF_FORUM['path_include']}geshi");
    $geshi->set_header_type(GESHI_HEADER_DIV);
    //$geshi->enable_strict_mode(true);
    //$geshi->enable_classes();
    $geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS, 5);
    $geshi->set_overall_style('font-size: 12px; color: #000066; border: 1px solid #d0d0d0; background-color: #FAFAFA;', true);
    // Note the use of set_code_style to revert colours...
    $geshi->set_line_style('font: normal normal 95% \'Courier New\', Courier, monospace; color: #003030;', 'font-weight: bold; color: #006060;', true);
    $geshi->set_code_style('color: #000020;', 'color: #000020;');
    $geshi->set_line_style('background: red;', true);
    $geshi->set_link_styles(GESHI_LINK, 'color: #000060;');
    $geshi->set_link_styles(GESHI_HOVER, 'background-color: #f0f000;');

    $geshi->set_header_content("$type Formatted Code");
    $geshi->set_header_content_style('font-family: Verdana, Arial, sans-serif; color: #808080; font-size: 90%; font-weight: bold; background-color: #f0f0ff; border-bottom: 1px solid #d0d0d0; padding: 2px;');

    return $geshi->parse_code();
}

function gf_htmLawed($str, $permissions = '') {
    global $_CONF;

    // Sets config options for htmLawed.  See http://www.bioinformatics.org/
    // phplabware/internal_utilities/htmLawed/htmLawed_README.htm
    $config = array(
        'balance'        => 1, // Balance tags for well-formedness and proper nesting
        'comment'        => 3, // Allow HTML comment
        'css_expression' => 1, // Allow dynamic CSS expression in "style" attributes
//            'keep_bad'       => 1, // Neutralize both tags and element content
        'keep_bad'       => 0, // Neutralize both tags and element content
        'tidy'           => 0, // Don't beautify or compact HTML code
        'unique_ids'     => 1, // Remove duplicate and/or invalid ids
        'valid_xhtml'    => 1, // Magic parameter to make input the most valid XHTML
    );

    if (isset($_CONF['allowed_protocols']) &&
            is_array($_CONF['allowed_protocols']) &&
            (count($_CONF['allowed_protocols']) > 0)) {
        $schemes = $_CONF['allowed_protocols'];
    } else {
        $schemes = array('http:', 'https:', 'ftp:');
    }

    $schemes = str_replace(':', '', implode(', ', $schemes));
    $config['schemes'] = 'href: ' . $schemes . '; *: ' . $schemes;

    if (empty($permissions) || !SEC_hasRights($permissions) || empty($_CONF['admin_html'])) {
        $html = $_CONF['user_html'];
    } else {
        $html = array_merge_recursive($_CONF['user_html'], $_CONF['admin_html']);
    }

    foreach ($html as $tag => $attr) {
        if (is_array($attr) && (count($attr) > 0)) {
            $spec[] = $tag . '=' . implode(', ', array_keys($attr));
        } else {
            $spec[] = $tag . '=-*';
        }

        $elements[] = $tag;
    }

    $config['elements'] = implode(', ', $elements);
    $spec = implode('; ', $spec);
    $str = htmLawed($str, $config, $spec);

    return $str;
}

function gf_checkHTML($str) {
    global $CONF_FORUM, $_CONF;

    // just return if admin doesn't want to filter html
    if ( $CONF_FORUM['use_glfilter'] != 1 ) {
        return $str;
    }
    // if Geeklog is configured to allow root to use all html, no need to call
    if ( isset( $_CONF['skip_html_filter_for_root'] ) &&
             ( $_CONF['skip_html_filter_for_root'] == 1 ) &&
            SEC_inGroup( 'Root' ))
    {
        return $str;
    }
    
    // If user has story edit previlages then can use html allowed by admins
    return gf_htmLawed($str, 'story.edit');
}


function gf_formatTextBlock($str,$postmode='html',$mode='') {
    global $CONF_FORUM;

    $bbcode = new StringParser_BBCode ();
    $bbcode->setGlobalCaseSensitive (false);
    // It is impossible to include block level elements in a <p> element. Therefore I fix this.
    $bbcode->setParagraphHandlingParameters ("\n\n", "", "");

    if ( $postmode == 'text') {
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'bbcode_htmlspecialchars');
    }
    if ( $CONF_FORUM['use_glfilter'] == 1 && ($postmode == 'html')) {
        $bbcode->addParser(array('block','inline','link','listitem'), 'gf_checkHTML');      // calls GL's checkHTML on all text blocks
    }
    if ( $postmode == 'text' OR $mode == 'subject') {
    	$bbcode->addParser(array('block','inline','link','listitem'), 'nl2br');
	}
    if ( $mode != 'subject' ) {
        $bbcode->addParser(array('block','inline','link','listitem'), 'gf_replacesmilie');      // calls replacesmilie on all text blocks
    }
    $bbcode->addParser(array('block','inline','link','listitem'), 'gf_fixtemplate');
    if ( $mode != 'subject' ) {
        $bbcode->addParser(array('block','inline','link','listitem'), 'PLG_replacetags');
    }

    $bbcode->addParser ('list', 'bbcode_stripcontents');
    $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<b>', 'end_tag' => '</b>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<i>', 'end_tag' => '</i>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<span style="text-decoration: underline;">', 'end_tag' => '</span>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('p', 'simple_replace', null, array ('start_tag' => '<p>', 'end_tag' => '</p>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('s', 'simple_replace', null, array ('start_tag' => '<del>', 'end_tag' => '</del>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('size', 'usecontent?', 'do_bbcode_size', array ('usercontent_param' => 'default'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('color', 'usecontent?', 'do_bbcode_color', array ('usercontent_param' => 'default'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    if ( $mode != 'subject' ) {                      
        $bbcode->addCode ('list', 'callback_replace', 'do_bbcode_list', array ('usecontent_param' => 'default'),
                          'list', array ('inline','block', 'listitem'), array ());
        $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'),
                          'listitem', array ('list'), array ());
        $bbcode->addCode ('quote','simple_replace',null,array('start_tag' => '<div class="quotemain">', 'end_tag' => '</div>'),
                          'inline', array('listitem','block','inline','link'), array());                          
        $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));
        $bbcode->addCode ('link', 'callback_replace_single', 'do_bbcode_url', array (),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));
        $bbcode->addCode ('img', 'usecontent', 'do_bbcode_img', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());
        $bbcode->addCode ('code', 'usecontent', 'do_bbcode_code', array ('usecontent_param' => 'default'),
                          'code', array ('listitem', 'block', 'inline', 'link'), array ());
    }              
    $bbcode->setCodeFlag ('quote', 'paragraph_type', BBCODE_PARAGRAPH_ALLOW_INSIDE);
    $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
    $bbcode->setCodeFlag ('*', 'paragraphs', true);
    $bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
    $bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);

    $bbcode->setRootParagraphHandling (true);

    if ($CONF_FORUM['use_censor'] and $mode == 'preview') {
        $str = COM_checkWords($str);
    }
    $str = $bbcode->parse ($str);

    return $str;
}


function bbcode_oldpost($text) {
    global $CONF_FORUM;

    if ($CONF_FORUM['pre2.5_mode'] == true ) {
        $comment = str_replace("&#36;","$", $text);
        $comment = str_replace("<br />","\r",$comment);
        $comment = str_replace("<br>","\r",$comment);
        $comment = str_replace ( '&amp;', '&', $comment );
        $comment = str_replace ( '&#039;', '\'', $comment );
        $comment = str_replace ( '&quot;', '"', $comment );
        $comment = str_replace ( '&lt;', '<', $comment );
        $comment = str_replace ( '&gt;', '>', $comment );
        $comment = str_replace ( '<b>', '[b]', $comment );
        $comment = str_replace ( '</b>', '[/b]', $comment );
        $comment = str_replace ( '<i>', '[i]', $comment );
        $comment = str_replace ( '</i>', '[/i]', $comment );
        $comment = str_replace ( '<p>', '[p]', $comment );
        $comment = str_replace ( '</p>', '[/p]', $comment );
    } else {
        return $text;
    }
    return $comment;
}

function gf_formatOldPost($str,$postmode='html',$mode='') {
    global $CONF_FORUM;

    $oldPost = 0;

    if ( $CONF_FORUM['pre2.5_mode'] != true ) {
        return $str;
    }

    if (strstr($str,'<pre class="forumCode">') !== false)  $oldPost = 1;
    if (strstr($str,"[code]<code>") !== false) $oldPost = 1;
    if (strstr($str,"<pre>") !== false ) $oldPost = 1;

    if ( stristr($str,'[code') == false || stristr($str,'[code]<code>') == true) {
        if (strstr($str,"<pre>") !== false)  $oldPost = 1;
        $str = str_replace('<pre>','[code]',$str);
        $str = str_replace('</pre>','[/code]',$str);
    }
    $str = str_ireplace("[code]<code>",'[code]',$str);
    $str = str_ireplace("</code>[/code]",'[/code]',$str);
    $str = str_replace(array("<br />\r\n","<br />\n\r","<br />\r","<br />\n","<br>\r\n","<br>\n\r","<br>\r","<br>\n",), '<br' . XHTML . '>', $str );
    $str = preg_replace("/\[QUOTE\sBY=\s(.+?)\]/i","[QUOTE] Quote by $1:",$str);
    /* Reformat code blocks - version 2.3.3 and prior */
    $str = str_replace( '<pre class="forumCode">', '[code]', $str );
    $str = preg_replace("/\[QUOTE\sBY=(.+?)\]/i","[QUOTE] Quote by $1:",$str);

    $bbcode = new StringParser_BBCode ();
    $bbcode->setGlobalCaseSensitive (false);
    // It is impossible to include block level elements in a <p> element. Therefore I fix this.
    $bbcode->setParagraphHandlingParameters ("\n\n", "", "");

    if ( $postmode == 'text') {
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'bbcode_htmlspecialchars');
    }
    if ( $CONF_FORUM['use_glfilter'] == 1 && ($postmode == 'html' || $postmode == 'HTML') ) {
        $bbcode->addParser(array('block','inline','link','listitem'), 'gf_checkHTML');      // calls checkHTML on all text blocks
    }
    $bbcode->addParser(array('block','inline','link','list','listitem'), 'bbcode_oldpost');

    $bbcode->addCode ('code', 'simple_replace', null, array ('start_tag' => '[code]', 'end_tag' => '[/code]'),
                      'code', array ('listitem', 'block', 'inline', 'link'), array ());

    if ( $CONF_FORUM['use_censor'] ) {
        $str = COM_checkWords($str);
    }
    $str = $bbcode->parse ($str);

    // If we have identified an old post based on the checks above
    // it is possible that code blocks will have htmlencoded items
    // we need to reverse that ...
    if ( $oldPost ) {
        if ( strstr($str,"\\'") !== false ) {
            $str = stripslashes($str);
        }
        $str = str_replace("&#36;","$", $str);
        $str = str_replace("<br />","\r",$str);
        $str = str_replace("<br>","\r",$str);
        $str = str_replace ( '&amp;', '&', $str );
        $str = str_replace ( '&#039;', '\'', $str );
        $str = str_replace ( '&quot;', '"', $str );
        $str = str_replace ( '&lt;', '<', $str );
        $str = str_replace ( '&gt;', '>', $str );
    }

    $str = str_replace ( '&#92;', '\\',$str);

    return $str;
}

function gf_replacesmilie($str) {
    global $_CONF,$_TABLES,$CONF_FORUM;

    if ($CONF_FORUM['allow_smilies']) {
        if (function_exists('msg_showsmilies') AND $CONF_FORUM['use_smilies_plugin']) {
            $str = msg_replaceEmoticons($str);
        } else {
            $str = forum_xchsmilies($str);
        }
    }

    return $str;
}

/* Function gf_getImage - used to return the image URL for icons
 * The forum uses a number of icons and you may have a need to use a mixture of image types.
 * Enabling the $CONF_FORUM['autoimagetype'] feature will invoke a test that will first
 * check for an image of the type set in your themes function.php $_IMAGE_TYPE
 * If the icon of that image type is not found, then it will use an image of type
 * specified by the $CONF_FORUM['image_type_override'] setting.

 * Set $CONF_FORUM['autoimagetype'] to false in the plugins config.php to disable this feature and
 * only icons of type set by the themes $_IMAGE_TYPE setting will be used
*/
function gf_getImage($image,$directory='') {
    global $CONF_FORUM,$_IMAGE_TYPE;

    if ($directory != '')  {
        $fullImagePath = "{$CONF_FORUM['imgset_path']}/{$directory}/{$image}.{$_IMAGE_TYPE}";
    } else {
        $fullImagePath = "{$CONF_FORUM['imgset_path']}/{$image}.{$_IMAGE_TYPE}";
    }
    if ($CONF_FORUM['autoimagetype']) {
        $fullImageURL = "{$CONF_FORUM['imgset']}/";
        if ($directory != '')  $fullImageURL .= "{$directory}/";

        if (file_exists($fullImagePath)) {
            $fullImageURL .= "{$image}.{$_IMAGE_TYPE}";
        } else {
            $CONF_FORUM['image_type_override'] = ($_IMAGE_TYPE == 'gif') ? 'png' : 'gif'; // added
            $fullImageURL .= "{$image}.{$CONF_FORUM['image_type_override']}";
        }
    } else {
        $fullImageURL = "{$CONF_FORUM['imgset']}/{$image}.{$_IMAGE_TYPE}";
    }
    return $fullImageURL;
}

function alertMessage($message, $title = '', $prompt = '') {
    global $_CONF, $CONF_FORUM, $LANG_GF01, $LANG_GF02;

    $retval = '';
    
    if (empty($title)) {
    	$title = $LANG_GF01['MESSAGE'];
	}
    
    $alertmsg = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $alertmsg->set_file (array('alertmsg'=>'alertmsg.thtml'));

    $alertmsg->set_var ('imgset', $CONF_FORUM['imgset']);
    $alertmsg->set_var ('layout_url', $CONF_FORUM['layout_url']);
    $alertmsg->set_var ('alert_title', $title);
    $alertmsg->set_var ('alert_message', $message);
    if ($prompt == "0") {
        $alertmsg->set_var ('prompt', ''); // No Prompt
	} elseif (empty($prompt)) {
		$alertmsg->set_var ('prompt', $LANG_GF02['msg148']);
    } else {
        $alertmsg->set_var ('prompt', $prompt);
    }
    
    $alertmsg->parse ('output', 'alertmsg');
    $retval .= $alertmsg->finish ($alertmsg->get_var('output'));
    
    return $retval;
}


function BaseFooter($showbottom=true) {
    global $_USER,$_CONF,$LANG_GF02,$forum,$CONF_FORUM;

    $retval = '';
    if (!$CONF_FORUM['registration_required'] OR !COM_isAnonUser()) {
        $footer = COM_newTemplate(CTL_plugin_templatePath('forum'));
        $footer->set_file (array ('footerblock'=>'footer/footer.thtml'));
        
        $footer->set_var ('imgset', $CONF_FORUM['imgset']);
        if ($forum == '') {
            $footer->set_var ('forum_time', f_forumtime() );
            if ($showbottom == "true") {
                $footer->set_var ('forum_legend', f_legend() );
                $footer->set_var ('forum_whosonline', f_whosonline() );
            }
          } else {
            $footer->set_var ('forum_time', f_forumtime() );
            if ($showbottom == "true") {
                $footer->set_var ('forum_legend', f_legend() );
                $footer->set_var ('forum_rules', f_forumrules() );
            }
        }
        $footer->set_var ('search_forum', f_forumsearch() );
        $footer->set_var ('select_forum', f_forumjump() );
        $footer->parse ('output', 'footerblock');
        $retval .= $footer->finish($footer->get_var('output'));
    }
    return $retval;
}

function f_forumsearch() {
    global $_CONF,$_TABLES,$LANG_GF01,$LANG_GF02,$forum,$CONF_FORUM;

    $forum_search = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $forum_search->set_file (array ('forum_search'=>'forum_search.thtml'));
    $forum_search->set_var ('forum', $forum);
    if ($forum == "") {
        $forum_search->set_var ('search', $LANG_GF02['msg117']);
    } else {
        $forum_search->set_var ('search', $LANG_GF02['msg118']);
    }
    $forum_search->set_var ('jumpheading', $LANG_GF02['msg103']);
    $forum_search->set_var ('LANG_GO', $LANG_GF01['GO']);
    $forum_search->parse ('output', 'forum_search');
    return $forum_search->finish($forum_search->get_var('output'));
}

function f_forumjump($action='',$selected=0) {
    global $CONF_FORUM, $_CONF,$_TABLES,$LANG_GF01,$LANG_GF02;

    $selecthtml = '';
    $asql = DB_query("SELECT * FROM {$_TABLES['forum_categories']} ORDER BY cat_order ASC");
    while($A = DB_fetchArray($asql)) {
    	
        $catthtml = '<optgroup label="' .$A['cat_name']. '">' . LB;
        $formhtml = '';
        $bsql = DB_query("SELECT * FROM {$_TABLES['forum_forums']} WHERE forum_cat='{$A['id']}' ORDER BY forum_order ASC");
        while($B = DB_fetchArray($bsql)) {
            $groupname = DB_getItem($_TABLES['groups'],'grp_name',"grp_id='{$B['grp_id']}'");
            if (SEC_inGroup($B['grp_id'])) {
                if ($selected > 0 AND $selected == $B['forum_id']) {
                    $formhtml .= '<option value="' .$B['forum_id']. '" selected="selected">&#187;&nbsp;' .$B['forum_name']. '</option>' . LB;
                } else {
                    $formhtml .= '<option value="' .$B['forum_id']. '">&#187;&nbsp;' .$B['forum_name']. '</option>' . LB;
                }
            }
        }
        if (!empty($formhtml)) {
        	$selecthtml .= $catthtml . $formhtml . '</optgroup>' . LB;
		}
    }
    $forum_jump = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $forum_jump->set_file (array ('forum_jump'=>'forum_jump.thtml'));
    $forum_jump->set_var ('LANG_msg103', $LANG_GF02['msg103']);
    $forum_jump->set_var ('LANG_msg106', $LANG_GF02['msg106']);
    $forum_jump->set_var ('jumpheading', $LANG_GF02['msg103']);
    $forum_jump->set_var ('imgset', $CONF_FORUM['imgset']);
    if ($action == '') {
        $forum_jump->set_var ('action', $_CONF['site_url'] . '/forum/index.php');
    } else {
        $forum_jump->set_var ('action', $action);
    }
    $forum_jump->set_var ('selecthtml', $selecthtml);
    $forum_jump->set_var ('LANG_GO', $LANG_GF01['GO']);
    $forum_jump->parse ('output', 'forum_jump');
    return $forum_jump->finish($forum_jump->get_var('output'));
}

function f_forumtime() {
    global $CONF_FORUM, $_CONF,$_TABLES,$LANG_GF01,$LANG_GF02,$forum;

    $forum_time = COM_newTemplate(CTL_plugin_templatePath('forum', 'footer'));
    $forum_time->set_file (array ('forum_time'=>'forum_time.thtml'));
    $timezone = strftime('%Z');
    $time = strftime('%I:%M %p');
    $forum_time->set_var ('imgset', $CONF_FORUM['imgset']);
    $forum_time->set_var ('message', sprintf($LANG_GF02['msg121'],$timezone,$time));
    $forum_time->parse ('output', 'forum_time');
    return $forum_time->finish($forum_time->get_var('output'));
}

function f_legend() {
    global $CONF_FORUM,$forum,$_CONF,$LANG_GF01,$LANG_GF02;
    
    $forum_legend = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $forum_legend->set_file (array ('forum_legend'	=> 'footer/forum_legend.thtml',         
    								'forum_icons'   => 'forum_icons.thtml'
    ));
    $blocks = array('new_icon', 'quiet_icon', 'active_icon', 'normal_icon', 'normalnew_icon', 'sticky_icon', 'stickynew_icon', 'locked_icon', 'lockednew_icon');
    foreach ($blocks as $block) {
        $forum_legend->set_block('forum_icons', $block);
    }
    
    $forum_legend->set_var ('imgset', $CONF_FORUM['imgset']);

    if ($forum == '') {
        $forum_legend->set_var ('normal_msg', $LANG_GF02['msg194']);
        $forum_legend->set_var ('normalnew_msg', $LANG_GF02['msg108']);
        

        $forum_legend->parse ('normal_icon', 'quiet_icon');
        $forum_legend->parse ('normalnew_icon', 'active_icon');
        
        
        
        $forum_legend->parse ('viewnew_icon', 'new_icon');
        $forum_legend->set_var ('viewnew_msg', $LANG_GF02['msg112']);
        
        $forum_legend->set_var ('markread_icon','<img src="'.gf_getImage('allread').'" alt="' . $LANG_GF02['msg84'] .'" title="' .$LANG_GF02['msg84']. '"'. XHTML .'>');
        $forum_legend->set_var ('markread_msg', $LANG_GF02['msg84']);
    } else {
        $forum_legend->parse ('normal_icon', 'normal_icon');
        $forum_legend->parse ('normalnew_icon', 'normalnew_icon');
        $forum_legend->parse ('sticky_icon', 'sticky_icon');
        $forum_legend->parse ('stickynew_icon', 'stickynew_icon');
        $forum_legend->parse ('locked_icon', 'locked_icon');
        $forum_legend->parse ('lockednew_icon', 'lockednew_icon');
        
        $forum_legend->set_var ('normal_msg', $LANG_GF02['msg59']);
        $forum_legend->set_var ('normalnew_msg', $LANG_GF02['msg60']);
        $forum_legend->set_var ('sticky_msg',$LANG_GF02['msg61']);
        $forum_legend->set_var ('locked_msg', $LANG_GF02['msg114']);
        $forum_legend->set_var ('stickynew_msg', $LANG_GF02['msg115']);
        $forum_legend->set_var ('lockednew_msg', $LANG_GF02['msg116']);
    }

    $forum_legend->parse ('output', 'forum_legend');
    return $forum_legend->finish($forum_legend->get_var('output'));
}

function f_whosonline(){
    global $CONF_FORUM, $_CONF,$_TABLES,$LANG_GF02;

    $onlineusers = phpblock_whosonline();
    $forum_users = COM_newTemplate(CTL_plugin_templatePath('forum', 'footer'));
    $forum_users->set_file (array ('forum_users'=>'forum_users.thtml'));
    $forum_users->set_var ('LANG_msg07', $LANG_GF02['msg07']);
    $forum_users->set_var ('imgset', $CONF_FORUM['imgset']);
    $forum_users->set_var ('onlineusers', $onlineusers);
    $forum_users->parse ('output', 'forum_users');
    return $forum_users->finish($forum_users->get_var('output'));
}

function f_forumrules() {
    global $_CONF,$_USER,$LANG_GF01,$LANG_GF02,$CONF_FORUM;
    
    $forum_rules = COM_newTemplate(CTL_plugin_templatePath('forum'));
    $forum_rules->set_file (array ( 'forum_rules'	=> 'footer/forum_rules.thtml',         
    								'forum_icons'   => 'forum_icons.thtml'
    ));
    
    $blocks = array('status_yes', 'status_no');
    foreach ($blocks as $block) {
        $forum_rules->set_block('forum_icons', $block);
    }     

    if ( $CONF_FORUM['registered_to_post'] AND ($_USER['uid'] < 2 OR empty($_USER['uid'])) ) {
        $postperm_msg = $LANG_GF01['POST_PERM_MSG2'];
        $post_perm_image = "status_no";
    } else {
        $postperm_msg = $LANG_GF01['POST_PERM_MSG1'];
        $post_perm_image = "status_yes";
    }
    if ($CONF_FORUM['allow_html']) {
        $html_perm_image = "status_yes";
        if ($CONF_FORUM['use_glfilter']) {
            $htmlmsg = $LANG_GF01['HTML_FILTER_MSG'];
        } else {
            $htmlmsg = $LANG_GF01['HTML_FULL_MSG'];
        }
    } else {
        $htmlmsg = $LANG_GF01['HTML_MSG'];
        $html_perm_image = "status_no";
    }
    if ($CONF_FORUM['use_censor']) {
        $censor_perm_image = "status_yes";
    } else {
        $censor_perm_image = "status_no";
    }

    if ($CONF_FORUM['show_anonymous_posts']) {
        $anon_perm_image = "status_yes";
    } else {
        $anon_perm_image = "status_no";
    }
    
    $forum_rules->set_var ('imgset', $CONF_FORUM['imgset']);
    $forum_rules->set_var ('LANG_title', $LANG_GF02['msg101']);

    $forum_rules->set_var ('anonymous_msg', $LANG_GF01['ANON_PERM_MSG']);
    $forum_rules->parse ('anon_perm_image', $anon_perm_image);

    $forum_rules->set_var ('postingperm_msg',$postperm_msg);
    $forum_rules->parse ('post_perm_image', $post_perm_image);

    $forum_rules->set_var ('html_msg', $htmlmsg);
    $forum_rules->parse ('html_perm_image', $html_perm_image);
    $forum_rules->set_var ('censor_msg', $LANG_GF01['CENSOR_PERM_MSG']);
    $forum_rules->parse ('censor_perm_image', $censor_perm_image);

    $forum_rules->parse ('output', 'forum_rules');
    return $forum_rules->finish($forum_rules->get_var('output'));

}


function gf_updateLastPost($forumid,$topicparent=0) {
    global $_TABLES;

    if ($topicparent == 0) {
        // Get the last topic in this forum
        $query = DB_query("SELECT MAX(id) FROM {$_TABLES['forum_topic']} WHERE forum=$forumid");
        list($topicparent) = DB_fetchArray($query);
        if ($topicparent > 0) {
            $lastrecid = $topicparent;
            DB_query("UPDATE {$_TABLES['forum_forums']} SET last_post_rec=$lastrecid WHERE forum_id=$forumid");
        }
    } else {
        $query = DB_query("SELECT MAX(id) FROM {$_TABLES['forum_topic']} WHERE pid=$topicparent");
        list($lastrecid) = DB_fetchArray($query);
    }

    if ($lastrecid == NULL AND $topicparent > 0) {
        $topicdatecreated = DB_getItem($_TABLES['forum_topic'],'date',"id=$topicparent");
        DB_query("UPDATE {$_TABLES['forum_topic']} SET last_reply_rec=$topicparent, lastupdated='$topicdatecreated' WHERE id=$topicparent");
    } elseif ($topicparent > 0) {
        $topicdatecreated = DB_getItem($_TABLES['forum_topic'],'date',"id=$lastrecid");
        DB_query("UPDATE {$_TABLES['forum_topic']}  SET last_reply_rec=$lastrecid, lastupdated='$topicdatecreated' WHERE id=$topicparent");
    }
    if ($topicparent > 0) {
        // Recalculate and Update the number of replies
        $numreplies = DB_Count($_TABLES['forum_topic'], "pid", $topicparent);
        DB_query("UPDATE {$_TABLES['forum_topic']} SET replies = '$numreplies' WHERE id=$topicparent");
    }
}

function forum_chkUsercanAccess($secure = false) {
    global $_CONF, $LANG_GF01, $LANG_GF02, $CONF_FORUM, $_USER;

    if ($CONF_FORUM['registration_required'] && COM_isAnonUser()) {
        $display = COM_siteHeader();
    	$message = sprintf($LANG_GF01['loginreqview'], '<a href="' .$_CONF['site_url']. '/users.php?mode=new">', '<a href="' .$_CONF['site_url']. '/users.php">');
    	$display .= alertMessage($message);
        $display .= COM_siteFooter();
        COM_output($display);

        exit;
    //} elseif ($secure AND empty($_USER['uid'])) {
    } elseif ($secure AND empty($_USER['uid'])) {
		$display = COM_siteHeader();
		$message = sprintf($LANG_GF01['loginreqfeature'], '<a href="' .$_CONF['site_url']. '/users.php?mode=new">', '<a href="' .$_CONF['site_url']. '/users.php">');
		$display .= alertMessage($message, $LANG_GF01['ACCESSERROR']);
		$display .= COM_siteFooter();
		COM_output($display);
	
		exit;    	
    }
}

/**
 * This function will replace the symbols in a forum post
 * with corresponding smilie images or the other way around.
 */
function forum_xchsmilies($message, $reverse = false) {
    global $_SMILIES;
    // Let the ForumSmilies class handle this
    return $_SMILIES->replace($message, $reverse);
}

?>
