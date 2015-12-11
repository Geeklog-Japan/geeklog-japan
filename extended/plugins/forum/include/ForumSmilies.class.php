<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | ForumSmilies.class.php                                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
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

/**
 * Functionality for native forum smilies
 *
 * @package GeeklogForum-Smilies
 */

// This file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'smilies.php') !== false) {
    die ('This file can not be used on its own.');
}

/**
 * This class handles the native forum smilies and is used to
 * generate the CSS code required for the smilies, show the
 * list of smilies when posting a topic, converting symbols
 * from the posts to corresponding images and vice-versa.
 */
class ForumSmilies {
    /**
     * This array defines each smilie. The 'symbol' is the text that will
     * be converted to the corresponding image in the forum posts.
     * The 'offset' is the number of pixels to scroll down in the smilies.png
     * sprite until arriving to the top side of the smilie in question.
     *
     * The order in which the array is sorted will determine in which order
     * the smilies will appear in the list of smilies when posting a topic.
     */
    private $data = array(
        'biggrin'  => array('symbol' => ':D',         'offset' => 208),
        'smile'    => array('symbol' => ':)',         'offset' => 192),
        'frown'    => array('symbol' => ':(',         'offset' => 112),
        'eek'      => array('symbol' => '8O',         'offset' => 272),
        'confused' => array('symbol' => ':?',         'offset' => 224),
        'cool'     => array('symbol' => 'B)',         'offset' => 48),
        'lol'      => array('symbol' => ':lol:',      'offset' => 352),
        'angry'    => array('symbol' => ':x',         'offset' => 384),
        'razz'     => array('symbol' => ':P',         'offset' => 320),
        'oops'     => array('symbol' => ':oops:',     'offset' => 144),
        'surprise' => array('symbol' => ':o',         'offset' => 176),
        'cry'      => array('symbol' => ':cry:',      'offset' => 288),
        'evil'     => array('symbol' => ':evil:',     'offset' => 368),
        'twisted'  => array('symbol' => ':twisted:',  'offset' => 400),
        'rolleye'  => array('symbol' => ':roll:',     'offset' => 240),
        'wink'     => array('symbol' => ';)',         'offset' => 160),
        'exclaim'  => array('symbol' => ':!:',        'offset' => 64),
        'question' => array('symbol' => ':question:', 'offset' => 96),
        'idea'     => array('symbol' => ':idea:',     'offset' => 256),
        'arrow'    => array('symbol' => ':arrow:',    'offset' => 80),
        'neutral'  => array('symbol' => ':|',         'offset' => 128),
        'green'    => array('symbol' => ':mrgreen:',  'offset' => 0),
        'sick'     => array('symbol' => ':sick:',     'offset' => 16),
        'tired'    => array('symbol' => ':tired:',    'offset' => 304),
        'monkey'   => array('symbol' => ':monkey:',   'offset' => 32)
    );

    /**
     * This function returns the HTML code for displaying
     * the list of available smilies when posting a topic
     */
    public function show()
    {
        global $CONF_FORUM, $LANG_GF_SMILIES;

        // Check and see if glMessenger is installed
        if ($CONF_FORUM['use_smilies_plugin']
            && function_exists('msg_showsmilies')
        ) {
            return msg_showsmilies();
        } else {
            // Use native smilies
            $image   =  gf_getImage('pixel');
            $retval  = "\n<!-- LIST OF SMILIES START -->\n";
            $retval .= "<div id='forum_smilies'>\n";
            foreach ($this->data as $key => $value) {
                // each smilie defined in the $this->data array
                $symbol  = $value['symbol'];
                $class   = 'frm_sml_' . $key;
                $alt     = '';
                if (isset($LANG_GF_SMILIES[$key])) {
                    $alt = htmlentities($LANG_GF_SMILIES[$key], ENT_QUOTES);
                }
                $retval .= "    <a href=\"javascript:emoticon('$symbol')\">\n";
                $retval .= "        <img class='frm_sml $class'\n";
                $retval .= "             src='$image'\n";
                $retval .= "             alt='$alt'\n";
                $retval .= "             title='$alt'" . XHTML . ">\n";
                $retval .= "    </a>\n";
            }
            $retval .= "</div>\n";
            $retval .= "<!-- LIST OF SMILIES END -->\n";
        }

        return $retval;
    }

    /**
     * This function will replace the symbols in a forum post
     * with corresponding smilie images or the other way around.
     */
    public function replace($message, $reverse = false)
    {
        global $LANG_GF_SMILIES;

        $search    = array(); // list of smilie symbols
        $replace   = array(); // list of IMG tags
        // The replacement values will be created by filling
        // in the values in this template variable
        $template  = '<img class="frm_sml frm_sml_%s" src="';
        $template .= gf_getImage('pixel');
        $template .= '" alt="%s" title="%s"' . XHTML . '>';
        foreach ($this->data as $key => $value) {
            // each smilie defined in the $this->data array
            $search[] = $value['symbol'];
            $alt = '';
            if (isset($LANG_GF_SMILIES[$key])) {
                $alt = htmlentities($LANG_GF_SMILIES[$key], ENT_QUOTES);
            }
            $replace[] = sprintf($template, $key, $alt, $alt);
        }
        // Do the actual replacement in the input string
        if (! $reverse) {
            $message = str_replace($search, $replace, $message);
        } else {
            $message = str_replace($replace, $search, $message);
        }

        return $message;
    }

    /**
     * Generates the CSS code necessary for displaying
     * the smilies from a sprite image.
     */
    public function css()
    {
        global $CONF_FORUM;

        // Sprite image
        $bg = $CONF_FORUM['imgset'] . '/smilies.png';
        // Common CSS code for all smilies
        $retval  = "";
        $retval .= "div#forum_smilies a {\n";
        $retval .= "	float: left;\n";
        $retval .= "	padding: 0;\n";
        $retval .= "	margin: 3px;\n";
        $retval .= "}\n";
        $retval .= ".frm_sml {\n";
        $retval .= "	border: 0;\n";
        $retval .= "    width: 16px;\n";
        $retval .= "	height: 16px;\n";
        $retval .= "	background: transparent url('$bg') "
                                 . "no-repeat scroll left top;\n";
        $retval .= "}\n";
        // Dynamic CSS code for each individual smilie
        foreach ($this->data as $key => $value) {
            $retval .= ".frm_sml_$key {\n";
            $retval .= "    background-position: 0 -{$value['offset']}px;\n";
            $retval .= "}\n";
        }

        return $retval;
    }
}

?>
