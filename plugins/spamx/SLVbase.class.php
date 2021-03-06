<?php

/**
 * File: SLVbase.class.php
 * Spam Link Verification (SLV) Base Class
 * Copyright (C) 2006 by the following authors:
 * Author        Dirk Haun       dirk AT haun-online DOT de
 * Licensed under the GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

/**
 * Sends posts to SLV (linksleeve.org) for examination
 *
 * @author  Dirk Haun     dirk AT haun-online DOT de
 *          based on the works of Tom Willet (Spam-X) and Russ Jones (SLV)
 * @package Spam-X
 */
class SLVbase
{
    private $_debug = false;
    private $_verbose = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_debug = false;
        $this->_verbose = false;
    }

    /**
     * Check for spam links
     *
     * @param    string $post post to check for spam
     * @return   boolean         true = spam found, false = no spam
     *                        Note: Also returns 'false' in case of problems communicating with SLV.
     *                        Error messages are logged in Geeklog's error.log
     */
    public function CheckForSpam($post)
    {
        global $_SPX_CONF;

        $retval = false;

        if (empty($post)) {
            return $retval;
        }

        $links = $this->prepareLinks($post);
        if (empty($links)) {
            return $retval;
        }

        if (!isset($_SPX_CONF['timeout'])) {
            $_SPX_CONF['timeout'] = 5; // seconds
        }

        if ($this->_verbose) {
            SPAMX_log("Sending to SLV: $links");
        }

        $params = array(new XML_RPC_Value($links, 'string'));
        $msg = new XML_RPC_Message('slv', $params);
        $cli = new XML_RPC_Client('/slv.php', 'http://www.linksleeve.org');

        if ($this->_debug) {
            $cli->setDebug(1);
        }

        $resp = $cli->send($msg, $_SPX_CONF['timeout']);
        if (!$resp) {
            COM_errorLog('Error communicating with SLV: ' . $cli->getErrorString()
                . '; Message was ' . $msg->serialize());
        } else if ($resp->faultCode()) {
            COM_errorLog('Error communicating with SLV. Fault code: '
                . $resp->faultCode() . ', Fault reason: '
                . $resp->faultString() . '; Message was '
                . $msg->serialize());
        } else {
            $val = $resp->value();
            // note that SLV returns '1' for acceptable posts and '0' for spam
            if ($val->scalarval() != '1') {
                $retval = true;
                SPAMX_log("SLV: spam detected");
            } else if ($this->_verbose) {
                SPAMX_log("SLV: no spam detected");
            }
        }

        return $retval;
    }

    /**
     * Check whitelist
     * Check against our whitelist of sites not to report to SLV. Note that
     * URLs starting with $_CONF['site_url'] have already been removed earlier.
     *
     * @param    array &$links array of URLs from a post
     * @return   void ($links is passed by reference and modified in place)
     */
    public function checkWhitelist(&$links)
    {
        global $_TABLES;

        $timestamp = DB_escapeString(date('Y-m-d H:i:s'));

        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='SLVwhitelist'", 1);
        $nrows = DB_numRows($result);

        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $val = $A['value'];
            $pattern = '#' . preg_quote($val, '#') . '#i';

            foreach ($links as $key => $link) {
                if (!empty($link)) {
                    if (preg_match($pattern, $link)) {
                        $links[$key] = '';
                        DB_query("UPDATE {$_TABLES['spamx']} SET counter = counter + 1, regdate = '$timestamp' WHERE name='SLVwhitelist' AND value='" . DB_escapeString($A['value']) . "'", 1);
                    }
                }
            }
        }
    }

    /**
     * Extract links
     * Extracts all the links from a post; expects HTML links, i.e. <a> tags
     *
     * @param    string $comment The post to check
     * @return   array               All the URLs in the post
     */
    public function getLinks($comment)
    {
        global $_CONF;

        $links = array();

        preg_match_all("|<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)</a>|i", $comment, $matches);
        for ($i = 0; $i < count($matches[0]); $i++) {
            $url = $matches[1][$i];
            if (empty($_CONF['site_url']) || stripos($url, $_CONF['site_url']) !== 0) {
                $links[] = $url;
            }
        }

        return $links;
    }

    /**
     * Extract only the links from the post
     * SLV has a problem with non-ASCII character sets, so we feed it the URLs
     * only. We also remove all URLs containing our site's URL.
     * Since we don't know if the post is in HTML or plain ASCII, we run it
     * through getLinks() twice.
     *
     * @param    string $comment The post to check
     * @return   string          All the URLs in the post, sep. by line feeds
     */
    public function prepareLinks($comment)
    {
        $linkList = '';

        // some spam posts have extra backslashes
        $comment = stripslashes($comment);

        // some spammers have yet to realize that we're not supporting BBcode
        // but since we want the URLs, convert it here ...
        $comment = preg_replace('/\[url=([^\]]*)\]/i', '<a href="\1">', $comment);
        $comment = str_ireplace('[/url]', '</a>', $comment);

        // get all links from <a href="..."> tags
        $links = $this->getLinks($comment);

        // strip all HTML, then get all the plain text links
        $comment = COM_makeClickableLinks(GLText::stripTags($comment));
        $links += $this->getLinks($comment);

        if (count($links) > 0) {
            $this->checkWhitelist($links);
            $linkList = implode("\n", $links);
        }

        return trim($linkList);
    }
}
