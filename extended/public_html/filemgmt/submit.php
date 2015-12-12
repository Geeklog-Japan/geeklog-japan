<?php
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
// |                                                                         |
// | Based on:                                                               |
// | myPHPNUKE Web Portal System - http://myphpnuke.com/                     |
// | PHP-NUKE Web Portal System - http://phpnuke.org/                        |
// | Thatware - http://thatware.org/                                         |
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
//

require_once '../lib-common.php';
require_once $_CONF['path_html'] . 'filemgmt/include/header.php';
require_once $_CONF['path_html'] . 'filemgmt/include/functions.php';
require_once $_CONF['path_html'] . 'filemgmt/include/xoopstree.php';
require_once $_CONF['path_html'] . 'filemgmt/include/errorhandler.php';
require_once $_CONF['path_html'] . 'filemgmt/include/textsanitizer.php';

/**
* Send an email notification for a new submission.
*
* @param    array   $A      submission data
*
*/
function filemgmt_sendNotification($A)
{
    global $_CONF, $LANG08;

    $mailbody = _MD_SUBMITTER . $A['username'] . "\n"
              . _MD_DLFILENAME . $A['title'] . "\n"
              . _MD_CATEGORYC . $A['category'] . "\n\n";
    $mailbody .= "<{$_CONF['site_admin_url']}/plugins/filemgmt/index.php?op=listNewDownloads>\n\n";
    $mailsubject = $_CONF['site_name'] . ' - ' . _MD_SUBMITNOTIFY;

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

if (SEC_hasRights("filemgmt.upload") OR $mydownloads_uploadselect) {

    // Get the number of files in the database and post it in the title.
    $_GROUPS = SEC_getUserGroups($uid);

    $myts = new MyTextSanitizer; // MyTextSanitizer object
    $eh = new ErrorHandler; //ErrorHandler object
    $mytree = new XoopsTree($_DB_name, $_FM_TABLES['filemgmt_cat'], "cid", "pid");
    $mytree->setGroupAccessFilter($_GROUPS);
    
    if ($_POST['submit']) {

        if (isset($_USER['uid']) AND $_USER['uid'] > 1) {
            $submitter = $_USER['uid'];
        } else {
            $submitter = 1;
        }
        // Check if Title entered
        if ($_POST["title"] == '') {
            $eh->show("1001");
        }
        // Check if filename entered
        if ($_FILES['newfile']['name'] != '') {
            $name = ($_FILES['newfile']['name']);
            $url = rawurlencode($name);
            $name = $myts->makeTboxData4Save($name);
            $url = $myts->makeTboxData4Save($url);
        } else {
            $eh->show("1016");
        }

        // Check if Description entered
        if ($_POST['description'] == '') {
            $eh->show("1008");
        }

        $uploadfilename = $myts->makeTboxData4Save($_FILES['newfile']['name']);

        // Check if file is already on file
        if (DB_COUNT($_FM_TABLES['filemgmt_filedetail'], 'url', $uploadfilename) > 0) {
            $eh->show("1108");
        }

        if (!empty($_POST['cid'])) {
            $cid = intval($_POST['cid']);
        } else {
            $cid = 0;
        }

        $AddNewFile = false;    // Set true if fileupload was sucessfull
        $name = $myts->makeTboxData4Save($name);
        $title = $myts->makeTboxData4Save($_POST['title']);
        $homepage = $myts->makeTboxData4Save($_POST['homepage']);
        $version = $myts->makeTboxData4Save($_POST['version']);
        $size = intval($_FILES['newfile']['size']);
        $description = $myts->makeTareaData4Save($_POST['description']);
        $comments = intval($_POST['commentoption']);
        $date = time();
        $tmpfilename = randomfilename();

        // Upload New file
        if ($uploadfilename != '') {
            $pos = strrpos($uploadfilename, '.') + 1;
            $fileExtension = strtolower(substr($uploadfilename, $pos));
            if (array_key_exists($fileExtension, $_FMDOWNLOAD)) {
                if ($_FMDOWNLOAD[$fileExtension] == 'reject') {
                    COM_errorLog("AddNewFile - New Upload file is rejected by config rule:$uploadfilename");
                    $eh->show("1109");
                } else {
                    $fileExtension = $_FMDOWNLOAD[$fileExtension];
                    $tmpfilename = $tmpfilename . ".$fileExtension";

                    /* Need to also rename the uploaded filename or URL that will be used for the approval name */
                    /* Grab the filename without extension and add the mapped extension */
                    $pos = strrpos($url, '.') + 1;
                    $url = strtolower(substr($url, 0, $pos)) . $fileExtension;
                }
            } else {
                $tmpfilename = $tmpfilename . ".$fileExtension";
            }
            $tmp = $_FILES["newfile"]['tmp_name'];    // temporary name of file in temporary directory on server
            if (is_uploaded_file($tmp)) {                               // is this temporary file really uploaded?
                $returnMove = move_uploaded_file($tmp, $filemgmt_FileStore . "tmp/" . $tmpfilename);    // move temporary file to your upload directory
                if (!$returnMove) {
                    COM_errorLog("Filemgmt submit error: Temporary file could not be created: "
                        . $tmp . " to " . $filemgmt_FileStore . "tmp/" . $tmpfilename);
                    $eh->show("1102");
                } else {
                    $AddNewFile = true;
                }
            }
        }

        // Upload New file snapshot image  - but only is file was uploaded ok
        $uploadfilename = $myts->makeTboxData4Save($_FILES['newfileshot']['name']);
        if ($uploadfilename != '' AND $AddNewFile) {
            $shotname = $uploadfilename;
            $logourl = rawurlencode($shotname);
            $shotname = $myts->makeTboxData4Save($shotname);
            $logourl = $myts->makeTboxData4Save($logourl);
            $tmpshotname = randomfilename();

            $tmp = $_FILES['newfileshot']['tmp_name'];    // temporary name of file in temporary directory on server
            $pos = strrpos($uploadfilename, '.') + 1;
            $fileExtension = strtolower(substr($uploadfilename, $pos));

            if (array_key_exists($fileExtension, $_FMDOWNLOAD)) {
                if ($_FMDOWNLOAD[$fileExtension] == 'reject') {
                    COM_errorLog("AddNewFile - New Upload file snapshot is rejected by config rule:$uploadfilename");
                    $eh->show("1109");
                } else {
                    $fileExtension = $_FMDOWNLOAD[$fileExtension];
                    $tmpshotname = $tmpshotname . ".$fileExtension";

                    /* Need to also rename the uploaded filename or URL that will be used for the approval name */
                    /* Grab the filename without extension and add the mapped extension */
                    $pos = strrpos($logourl, '.') + 1;
                    $logourl = strtolower(substr($logourl, 0, $pos)) . $fileExtension;
                }
            } else {
                $tmpshotname = $tmpshotname . ".$fileExtension";
            }
            // Append the temporary name for the file, using a ; as delimiter. We will be able to store both names in one field
            $tmpfilename .= ';' . $tmpshotname;

            if (is_uploaded_file($tmp)) {
                $returnMove = move_uploaded_file($tmp, $filemgmt_SnapStore . "tmp/" . $tmpshotname);    // move temporary snapfile to your upload directory
                if (!$returnMove) {
                    COM_errorLog("Filemgmt submit error: Temporary file could not be created: "
                        . $tmp . " to " . $filemgmt_SnapStore . "tmp/" . $tmpshotname);
                    $AddNewFile = false;    // Set false again - in case it was set true above for actual file
                    $eh->show("1102");
                } else {
                    $AddNewFile = true;
                }
            }
        }

        if ($AddNewFile) {
            DB_query("INSERT INTO {$_FM_TABLES['filemgmt_filedetail']} "
                   . "(cid, title, url, homepage, version, size, platform, logourl, "
                   . "submitter, status, date, hits, rating, votes, comments) "
                   . "VALUES ('$cid', '$title', '$url', '$homepage', '$version', "
                   . "'$size', '$tmpfilename', '$logourl', '$submitter', 0, "
                   . "'$date', 0, 0, 0, '$comments')") or $eh->show("0013");
            $newid = DB_insertID();
            DB_query("INSERT INTO {$_FM_TABLES['filemgmt_filedesc']} (lid, description) "
                   . "VALUES ($newid, '$description')") or $eh->show("0013");

            if ($_FM_CONF['notification']) {
                filemgmt_sendNotification(
                    array('username' => $_USER['username'],
                          'title'    => stripslashes($title),
                          'category' => DB_getItem($_FM_TABLES['filemgmt_cat'], 'title', "cid='$cid'")
                         ));
            }

            redirect_header("index.php", 2, _MD_RECEIVED . "<br>" . _MD_WHENAPPROVED . "");
            exit;
        } else {
            redirect_header("index.php", 2, _MD_ERRUPLOAD . "");
            exit;
        }

    } else {

        $display = '';
        $display .= COM_startBlock("<b>" . _MD_UPLOADTITLE . "</b>");
        $display .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"8\" class=\"plugin\">" . LB;
        $display .= "<tr><td style=\"padding-top:10px;padding-left:50px;\">" . LB;
        $display .= "<ul><li>" . _MD_SUBMITONCE . "</li>" . LB;
        $display .= "<li>" . _MD_ALLPENDING . "</li>" . LB;
        $display .= "<li>" . _MD_DONTABUSE . "</li>" . LB;
        $display .= "<li>" . _MD_TAKEDAYS . "</li></ul>" . LB;
        $display .= '<form action="submit.php" method="post" enctype="multipart/form-data"><div>' . LB;
        $display .= "<table width=\"80%\"><tr>";
        $display .= "<td style=\"text-align:right; white-space:nowrap;\"><b>" . _MD_FILETITLE . "</b></td><td>";
        $display .= "<input type=\"text\" name=\"title\" size=\"50\" maxlength=\"100\"" . XHTML . ">";
        $display .= "</td></tr><tr><td style=\"text-align:right; white-space:nowrap;\"><b>" . _MD_DLFILENAME . "</b></td><td>";
        $display .= "<input type=\"file\" name=\"newfile\" size=\"50\" maxlength=\"100\"" . XHTML . ">";
        $display .= "</td></tr>";
        $display .= "<tr><td style=\"text-align:right; white-space:nowrap;\"><b>" . _MD_CATEGORY . "</b></td><td>";
        $display .= $mytree->makeMySelBox('title', 'title');
        $display .= "</td></tr>" . LB;
        $display .= "<tr><td style=\"text-align:right; white-space:nowrap;\"><b>" . _MD_HOMEPAGEC . "</b></td><td>" . LB;
        $display .= "<input type=\"text\" name=\"homepage\" size=\"50\" maxlength=\"100\"" . XHTML . "></td></tr>" . LB;
        $display .= "<tr><td style=\"text-align:right; white-space:nowrap;\"><b>" . _MD_VERSIONC . "</b></td><td>" . LB;
        $display .= "<input type=\"text\" name=\"version\" size=\"10\" maxlength=\"10\"" . XHTML . "></td></tr>" . LB;
        $display .= "<tr><td style=\"text-align:right; vertical-align:top; white-space:nowrap;\"><b>" . _MD_DESCRIPTIONC . "</b></td><td>" . LB;
        $display .= '<textarea name="description" cols="50" rows="6"></textarea>' . LB;
        $display .= "</td></tr>" . LB;
        $display .= "<tr><td style=\"text-align:right; white-space:nowrap;\"><b>" . _MD_SHOTIMAGE . "</b></td><td>" . LB;
        $display .= "<input type=\"file\" name=\"newfileshot\" size=\"50\" maxlength=\"60\"" . XHTML . "></td></tr>" . LB;
        $display .= "<tr><td align=\"right\"></td><td>";
        $display .= "</td></tr><tr><td align=\"right\"><b>" . _MD_COMMENTOPTION . "</b></td><td>";
        $display .= "<input type=\"radio\" name=\"commentoption\" value=\"1\" checked=\"checked\"" . XHTML . ">&nbsp;" . _MD_YES . "&nbsp;";
        $display .= "<input type=\"radio\" name=\"commentoption\" value=\"0\"" . XHTML . ">&nbsp;" . _MD_NO . "&nbsp;";
        $display .= "</td></tr>" . LB;
        $display .= "</table>" . LB;
        $display .= "<br" . XHTML . ">";
        $display .= "<input type=\"hidden\" name=\"submitter\" value=\"" . $uid . "\"" . XHTML . ">";
        $display .= "<div style=\"text-align:center;\"><input type=\"submit\" name=\"submit\" class=\"button\" value=\"" . _MD_SUBMIT . "\"" . XHTML . ">" . LB;
        $display .= "&nbsp;<input type=\"button\" value=\"" . _MD_CANCEL . "\" onclick=\"javascript:history.go(-1)\"" . XHTML . "></div>" . LB;
        $display .= "</div></form>" . LB;
        $display .= "</td></tr></table>" . LB;
        $display .= COM_endBlock();
        if (function_exists('COM_createHTMLDocument')) {
            $display = COM_createHTMLDocument($display);
        } else {
            $display = COM_siteHeader() . $display . COM_siteFooter();
        }
        COM_output($display);
    }

} else {
    COM_errorLog("Submit.php => FileMgmt Plugin Access denied. "
        . "Attempted user upload of a file, Remote address is:{$_SERVER['REMOTE_ADDR']}");
    redirect_header($_CONF['site_url'] . "/index.php", 1, _GL_ERRORNOUPLOAD);
}

?>