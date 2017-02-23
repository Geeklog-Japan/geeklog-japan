<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | dutch_utf-8.php                                                           |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Zippo            Zippohontas AT gmail DOT com                          |
// |                                                                           |
// | Copyright (C) 2000,2001 by the following authors:                         |
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_GF00 = array(
    'pluginlabel' => 'Forum',
    'searchlabel' => 'Forum',
    'statslabel' => 'Totaal Aantal Forum Berichten',
    'statsheading1' => 'Forum Top 10 Gelezen Berichten',
    'statsheading2' => 'Forum Top 10 Reageer Berichten',
    'statsheading3' => 'Geen Onderwerpen om over te rapporten',
    'useradminmenu' => 'Forum Opties',
    'access_denied' => 'Toegang Geweigerd',
    'autotag_desc_forum' => '[forum: id alternate title] - Laat een link zien naar een forum bericht met de tekst \'here\' als de titel. Een alternatieve titel mag gegeven worden maar is niet verplicht.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'Alle',
    'YES' => 'Ja',
    'NO' => 'Nee',
    'NEW' => 'Nieuw',
    'NEXT' => 'Volgende',
    'ERROR' => 'Fout!',
    'CONFIRM' => 'Bevestig',
    'UPDATE' => 'Update',
    'SAVE' => 'Bewaar',
    'CANCEL' => 'Annuleer',
    'ON' => 'Aan: ',
    'ON2' => '&nbsp;&nbsp;<b>Aan: </b>',
    'BY' => 'Door: ',
    'RE' => 'Re: ',
    'DATE' => 'Datum',
    'VIEWS' => 'Gelezen',
    'REPLIES' => 'Reacties',
    'NAME' => 'Naam:',
    'DESCRIPTION' => 'Omschrijving: ',
    'TOPIC' => 'Topic',
    'TOPICS' => 'Topics:',
    'TOPICSUBJECT' => 'Topic Onderwerp',
    'HOMEPAGE' => 'Home',
    'SUBJECT' => 'Onderwerp',
    'HELLO' => 'Hallo ',
    'MOVED' => 'Verplaatst',
    'POSTS' => 'Berichten',
    'LASTPOST' => 'Laatste Bericht',
    'POSTEDON' => 'Geplaatst op',
    'POSTEDBY' => 'Geplaatst door',
    'PAGES' => 'Paginas',
    'TODAY' => 'Vandaag om ',
    'REGISTERED' => 'Geregistreerd',
    'ORDERBY' => 'Order:&nbsp;',
    'ORDER' => 'Order:',
    'USER' => 'Gebruiker',
    'GROUP' => 'Groep',
    'ANON' => 'Anoniem: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Schrijver',
    'NOMOOD' => 'Geen Humeur',
    'REQUIRED' => '[Verplicht]',
    'OPTIONAL' => '[Optioneel]',
    'SUBMIT' => 'Verstuur',
    'PREVIEW' => 'Voorbeeld',
    'REMOVE' => 'Verwijder',
    'EDIT' => 'Bewerk',
    'DELETE' => 'Verwijder',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Opties:',
    'MISSINGSUBJECT' => 'Onderwerp is leeg',
    'MIGRATE_NOW' => 'Voeg samen NU',
    'FILTERLIST' => 'Filter Lijst',
    'SELECTFORUM' => 'Selecteer Forum',
    'DELETEAFTER' => 'Verwijder na',
    'TITLE' => 'Titel',
    'COMMENTS' => 'Commentaar',
    'SUBMISSIONS' => 'Plaatsingen',
    'HTML_FILTER_MSG' => 'Beperkt HTML Toegestaan',
    'HTML_FULL_MSG' => 'Volledig HTML Toegestaan',
    'HTML_MSG' => 'HTML Toegestaan',
    'CENSOR_PERM_MSG' => 'Gecensoreerde Inhoud',
    'ANON_PERM_MSG' => 'Bekijk Anonieme Berichten',
    'POST_PERM_MSG1' => 'kan plaatsen',
    'POST_PERM_MSG2' => 'Anonieme gebruikers kunnen plaatsen',
    'GO' => 'GA',
    'STATUS' => 'Status:',
    'ONLINE' => 'online',
    'OFFLINE' => 'offline',
    'back2parent' => 'Hoofd Topic',
    'forumname' => '',
    'category' => 'Categorie: ',
    'loginreqview' => '<b>Sorry je moet %s geregistreerd zijn</a> of %s login </a> om deze fora te gebruiken</b>',
    'loginreqpost' => '<b>Sorry je moet registreren of inloggen op deze fora te plaatsen</b>',
    'nolastpostmsg' => 'Nvt',
    'no_one' => 'Geen een.',
    'back2top' => 'Naar boven',
    'TEXTMODE' => 'Tekst Mode:',
    'HTMLMODE' => 'HTML Mode:',
    'TopicPreview' => 'Topic voorbeeld',
    'moderator' => 'Moderator',
    'admin' => 'Admin',
    'DATEADDED' => 'Datum toegevoegd',
    'PREVTOPIC' => 'Vorig Topic',
    'NEXTTOPIC' => 'Volgend Topic',
    'RESYNC' => 'ReSync',
    'RESYNCCAT' => 'ReSync Categorie Fora',
    'EDITICON' => 'Bewerk',
    'QUOTEICON' => 'Quote',
    'ProfileLink' => 'Profiel',
    'WebsiteLink' => 'Website',
    'PMLink' => 'PM',
    'EmailLink' => 'Email',
    'FORUMSUBSCRIBE' => 'Abonneer op dit forum',
    'FORUMUNSUBSCRIBE' => 'Stop Abonnement op dit forum',
    'FORUMSUBSCRIBE_TRUE' => 'Abonnement: Aan',
    'FORUMSUBSCRIBE_FALSE' => 'Abonnement:Uit',
    'NEWTOPIC' => 'Nieuw Topic',
    'POSTREPLY' => 'Plaats Reactie',
    'SubscribeLink' => 'Abonneer',
    'unSubscribeLink' => 'Stop Abonnement',
    'SubscribeLink_TRUE' => 'Abonnement: Aan',
    'SubscribeLink_FALSE' => 'Abonnement:Uit',
    'SUBSCRIPTIONS' => 'Abonnementen',
    'TOP' => 'Bovenkant van bericht',
    'PRINTABLE' => 'Afdruk Versie',
    'USERPREFS' => 'Gebruiker Voorkeuren',
    'SPEEDLIMIT' => '"Je laatste commentaar was %s seconden geleden.<br' . XHTML . '>Deze site verplicht minstens %s seconden tussen plaatsingen."',
    'ACCESSERROR' => 'TOEGANG FOUT',
    'ACTIONS' => 'Acties',
    'DELETEALL' => 'Verwijder alle geselecteerde records',
    'DELCONFIRM' => 'Ben je zeker om de gelecteerde records te VERWIJDEREN?',
    'DELALLCONFIRM' => 'Ben je zeker om ALLE gelecteerde records te VERWIJDEREN?',
    'STARTEDBY' => 'Gestart door:',
    'WARNING' => 'Waarschuwing',
    'MODERATED' => 'Moderators: %s',
    'LASTREPLYBY' => 'Laatste reactie door:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Forum Index',
    'FEATURE' => 'Optie',
    'SETTING' => 'Instelling',
    'MARKALLREAD' => 'Markeer AllE als gelezen',
    'MSG_NO_CAT' => 'Geen Categorieen of Fora Gedefineerd',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Code',
    'FONTCOLOR' => 'Font Kleur',
    'FONTSIZE' => 'Font Grootte',
    'CLOSETAGS' => 'Sluit Tags',
    'CODETIP' => 'Tip: Stijlen kunnen snel geactiveerd worden aan geselecteerde tekst',
    'TINY' => 'Erg klein',
    'SMALL' => 'Klein',
    'NORMAL' => 'Normaal',
    'LARGE' => 'Groot',
    'HUGE' => 'Enorm',
    'DEFAULT' => 'Standaard',
    'DKRED' => 'Donker Rood',
    'RED' => 'Rood',
    'ORANGE' => 'Oranje',
    'BROWN' => 'Bruin',
    'YELLOW' => 'Geel',
    'GREEN' => 'Groen',
    'OLIVE' => 'Olijf',
    'CYAN' => 'Cyaan',
    'BLUE' => 'Blauw',
    'DKBLUE' => 'Donker Blauw',
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Violet',
    'WHITE' => 'Wit',
    'BLACK' => 'Zwart',
    'b_help' => 'Vet tekst: [b]tekst[/b]',
    'i_help' => 'Italic tekst: [i]tekst[/i]',
    'u_help' => 'Onderstreept tekst: [u]tekst[/u]',
    'q_help' => 'Quote tekst: [quote]tekst[/quote]',
    'c_help' => 'Code laten zien: [code]code[/code]',
    'l_help' => 'Lijst: [list]tekst[/list]',
    'o_help' => 'Geordende lijst: [olist]tekst[/olist]',
    'p_help' => '[img]http://image_url[/img]  or [img w=100 h=200][/img]',
    'w_help' => 'Voeg in URL: [url]http://url[/url] or [url=http://url]URL tekst[/url]',
    'a_help' => 'Sluit alle geopende bbCode tags',
    's_help' => 'Font kleur: [color=red]tekst[/color]  Tip: je can also use color=#FF0000',
    'f_help' => 'Font grootte: [size=7]small tekst[/size]',
    'h_help' => 'Klik voor meer gedetailleerde hulp'
);

$LANG_GF02 = array(
    'msg01' => 'Sorry you must register to use these forums',
    'msg02' => 'You should not be here!<br' . XHTML . '>Restricted access to this forum only',
    'msg03' => 'Please wait while you are redirected',
    'msg05' => '<center><em>Sorry, no topics have been created yet.</em></center>',
    'msg07' => 'Online Users:',
    'msg14' => 'Sorry, You have been banned from making entries.<br' . XHTML . '>',
    'msg15' => 'If you feel this is an error, contact <a href="mailto:%s?subject=Forum IP Ban">Site Admin</a>.',
    'msg18' => 'Error! Not all required fields were completed or were too short in length.',
    'msg19' => 'Your message has been posted.',
    'msg22' => '- Forum Post Notification',
    'msg23a' => "A reply has been made to the thread '%s' by %s.\n\nThis topic was started by %s in the %s forum. ",
    'msg23b' => "A new topic '%s' has been posted by %s in the %s forum on the %s website. You may view it at:\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "You may view it at:\n%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nHave a great day! \n",
    'msg26' => "\nYou are receiving this email because you have chosen to be notified when a reply has been made to this topic. ",
    'msg27' => "To stop receiving notifications on this topic go to <%s> to remove it.\n",
    'msg33' => 'Author: ',
    'msg36' => 'Mood:',
    'msg38' => 'Notify me of replies ',
    'msg40' => '<br' . XHTML . '>Sorry, but you have already asked to be notified of replies to this topic.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">You have no notifications currently.</p>',
    'msg49' => '(Read %s times) ',
    'msg55' => 'Post Deleted.',
    'msg56' => 'IP Banned.',
    'msg59' => 'Normal Topic',
    'msg60' => 'New Post',
    'msg61' => 'Sticky Topic',
    'msg62' => 'Notify me of replies',
    'msg64' => 'Are you sure you want to delete topic %s titled: %s ?',
    'msg65' => '<br' . XHTML . '>This is a parent topic, so all replies posted to it will also be deleted.',
    'msg68' => 'Note: BE CAREFUL WHEN YOU BAN, only admins have the rights to unban someone.',
    'msg69' => 'Do you really want to ban the ip address: %s?',
    'msg71' => 'No function selected, choose a post and then a moderator function.<br' . XHTML . '>Note: You must be a moderator to perform these functions.',
    'msg72' => 'Warning, you do not have rights to perform this moderation function.',
    'msg74' => 'Latest %s Forum Posts',
    'msg75' => 'Top %s Topics By Views',
    'msg76' => 'Top %s Topics By Posts',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">You should not be here!<br' . XHTML . '>Restricted access to this forum only.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '><p>You need to be signed in to use this forum feature.</p>',
    'msg84' => 'Mark all topics read',
    'msg85' => 'Page:',
    'msg86' => '&nbsp;Last %s posts&nbsp;',
    'msg87' => '<br' . XHTML . '>Warning: This topic has been locked by the moderator.<br' . XHTML . '>No additional posts are permitted',
    'msg88' => 'Site Members',
    'msg88b' => 'Forum Activity Only',
    'msg89' => 'My Enabled Notifications',
    'msg101' => 'Forum Rules:',
    'msg103' => 'Forum Jump:',
    'msg106' => 'Select a Forum',
    'msg108' => 'Active Forum',
    'msg109' => 'Locked Topic',
    'msg110' => 'Transferring to message edit page..',
    'msg111' => 'New posts since your last visit',
    'msg112' => 'View all new posts',
    'msg113' => 'View new posts',
    'msg114' => 'Locked Topic',
    'msg115' => 'Sticky Topic W/ New Post',
    'msg116' => 'Locked Topic W/ New Post',
    'msg117' => 'Search All',
    'msg118' => 'Search This Forum',
    'msg119' => 'Forum Search results for the query:',
    'msg120' => 'Most popular posts by',
    'msg121' => 'All times are %s. The time is now %s.',
    'msg122' => 'Popular Limit',
    'msg123' => 'Number of posts before calling a topic popular',
    'msg126' => 'Search Lines',
    'msg127' => 'Number of lines to display in search results',
    'msg128' => 'Members Per Page',
    'msg129' => 'For the Members listing screen',
    'msg130' => 'View Anonymous Posts',
    'msg131' => 'Setting of No will filter out anonymous posts',
    'msg132' => 'Always Notify',
    'msg133' => 'Setting of Yes will enable auto notification for any topics you create or reply',
    'msg134' => 'Subscription Added',
    'msg135' => 'You will now be notified of all posts to this forum.',
    'msg136' => 'You must choose a forum to subscribe to.',
    'msg137' => 'Notification for topic enabled',
    'msg138' => '<b>Subscribed to complete forum</b>',
    'msg142' => 'Notification saved.',
    'msg144' => 'Return to topic',
    'msg146' => 'Notification Deleted',
    'msg147' => 'Forum [printable version of topic %s]',
    'msg148' => 'Click <a href="javascript:history.back()">HERE</a> to return',
    'msg155' => 'No user posts.',
    'msg156' => 'Total number of forum posts',
    'msg157' => 'Last 10 Forum posts',
    'msg158' => 'Last 10 Forum posts by ',
    'msg159' => 'Are you sure you want to DELETE these selected Moderator records?',
    'msg160' => 'View last page of topic',
    'msg163' => 'Post moved',
    'msg164' => 'Mark all Categories and Topics Read',
    'msg166' => 'ERROR: Invalid topic or Topic not found',
    'msg167' => 'Notification Option',
    'msg168' => 'Setting of No will disable email notifictions',
    'msg169' => 'Return to Members listing',
    'msg170' => 'Latest Forum Posts',
    'msg171' => 'Forum Access Error',
    'msg172' => 'Topic does not exist. It possibly has been deleted',
    'msg173' => 'Transferring to Post Message page..',
    'msg174' => 'Unable to BAN Member - Invalid or Empty IP Address',
    'msg175' => 'Return to Forum Listing',
    'msg176' => 'Select a member',
    'msg177' => 'All Members',
    'msg178' => 'Parent Posts Only',
    'msg179' => 'Content generated in: %s seconds',
    'msg180' => 'Forum Posting Alert',
    'msg181' => 'You don\'t have access to any other forum as a moderator',
    'msg182' => 'Moderator Confirmation',
    'msg183' => 'New topic was created from this post in forum: %s',
    'msg184' => 'Notify Once Only',
    'msg185' => 'Notifications will only be sent once for forums and topics which have multiple new posts since your last visit.',
    'msg186' => 'New Topic Title',
    'msg187' => 'Return to topic - click <a href="%s">here</a>',
    'msg188' => 'Click to go directly to last post',
    'msg189' => 'Error: You can not edit this post anymore',
    'msg190' => 'Silent Edit',
    'msg191' => 'Edit not permitted. Allowable edit timeframe expired or you need moderator rights',
    'msg192' => 'Completed ... Migrated %s topics and %s comments.',
    'msg193' => 'STORY&nbsp;&nbsp;TO&nbsp;&nbsp;FORUM&nbsp;&nbsp;MIGRATION&nbsp;&nbsp;UTILITY',
    'msg194' => 'Quiet Forum',
    'msg195' => 'Click to Jump to Forum',
    'msg196' => 'View the main forum index',
    'msg197' => 'Mark all Categories read',
    'msg198' => 'Update your forum settings',
    'msg199' => 'View or remove forum notifications',
    'msg200' => 'Site members report',
    'msg201' => 'Popular topics',
    'msg202' => 'No new posts',
    'msg300' => 'Your preferences have block anonymous posts enabled',
    'msg301' => 'Realy mark all categories read?',
    'msg302' => 'Realy mark all topics read?',
    'PostReply' => 'Post New Reply',
    'PostTopic' => 'Post New Topic',
    'EditTopic' => 'Edit Topic',
    'quietforum' => 'Forum has no new topics'
);

$LANG_GF03 = array(
    'delete' => 'Delete Post',
    'edit' => 'Edit Post',
    'move' => 'Move Topic',
    'split' => 'Split Topic',
    'ban' => 'Ban IP',
    'movetopic' => 'Move Topic',
    'movetopicmsg' => '<br' . XHTML . '>Topic to be moved: "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>Create a new Topic with this post: "<b>%s</b>"<br' . XHTML . '><em>By:</em>&nbsp;%s&nbsp <em>On:</em>&nbsp;%s',
    'selectforum' => 'Select new forum:',
    'lockedpost' => 'Add Reply Post',
    'splitheading' => 'Split thread option:',
    'splitopt1' => 'Move all posts from this point',
    'splitopt2' => 'Move only this one post'
);

$LANG_GF04 = array(
    'label_forum' => 'Forum Profile',
    'label_location' => 'Location',
    'label_aim' => 'AIM Handle',
    'label_yim' => 'YIM Handle',
    'label_icq' => 'ICQ Identity',
    'label_msnm' => 'MS Messenger Name',
    'label_interests' => 'Interests',
    'label_occupation' => 'Occupation'
);

$LANG_GF05 = array(
    'aim_link' => '&nbsp;<a href="aim:goim?screenname=',
    'aim_linkend' => '>',
    'aim_hello' => '&amp;message=Hi.+Are+you+there?',
    'aim_alttext' => 'AIM:&nbsp;',
    'icq_link' => '&nbsp;',
    'icq_alttext' => 'ICQ #:&nbsp;',
    'msn_link' => '&nbsp;<a href="javascript:MsgrApp.LaunchIMUI(',
    'msn_linkend' => ')">',
    'msn_alttext' => 'Messenger:&nbsp;',
    'yim_link' => '&nbsp;<a href="ymsgr:sendIM?',
    'yim_linkend' => '">',
    'yim_alttext' => 'YIM:&nbsp;'
);

$LANG_GF06 = array(
    1 => 'Statistics',
    2 => 'Settings',
    3 => 'Forums',
    4 => 'Moderator',
    5 => 'Convert',
    6 => 'Messages',
    7 => 'IP Mgmt'
);

$LANG_GF07 = array(
    1 => 'View Forums',
    2 => 'Preferences',
    3 => 'Popular Topics',
    4 => 'Subscriptions',
    5 => 'Members'
);

$LANG_GF08 = array(
    1 => 'Topic Notifications',
    2 => 'Track Forum Notifications',
    3 => 'Topic Exception Notifications'
);

$LANG_GF09 = array(
    'edit' => 'Edit',
    'email' => 'Email',
    'home' => 'Home',
    'lastpost' => 'Last Post',
    'pm' => 'PM',
    'profile' => 'Profile',
    'quote' => 'Quote',
    'website' => 'Website',
    'newtopic' => 'New Topic',
    'replytopic' => 'Post Reply'
);

$LANG_GF91 = array(
    'gfstats' => 'Discussion Forum Stats',
    'statsmsg' => 'Here are the current statistics for your forum:',
    'totalcats' => 'Total Categories:',
    'totalforums' => 'Total Forums:',
    'totaltopics' => 'Total Topics:',
    'totalposts' => 'Total Posts:',
    'totalviews' => 'Total Views:',
    'avgpmsg' => 'Average posts per:',
    'category' => 'Category:',
    'forum' => 'Forum:',
    'topic' => 'Topic:',
    'avgvmsg' => 'Average views per:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Discussion Forum Settings',
    'showiframe' => 'Show Topic Review',
    'showiframedscp' => 'Show Topic Review (Iframe) at bottom when replying to a topic',
    'topicspp' => 'Topics Per Page',
    'topicsppdscp' => 'Number of topics to display when viewing the forum index',
    'postspp' => 'Posts Per Page',
    'postsppdscp' => 'Number of posts to show per page',
    'setsavemsg' => 'Settings saved.'
);

$LANG_GF93 = array(
    'gfboard' => 'Discussion Forum Board Admin',
    'addcat' => 'Add Forum Category',
    'addforum' => 'Add A Forum',
    'catorder' => 'Category Order',
    'catadded' => 'Category Added.',
    'catdeleted' => 'Category Deleted',
    'catedited' => 'Category Edited.',
    'forumadded' => 'Forum Added.',
    'forumaddError' => 'Error Adding Forum.',
    'forumdeleted' => 'Forum Deleted',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum Edited',
    'forumordered' => 'Forum Order Edited',
    'back' => 'Back',
    'addnote' => 'Note: You can edit these values.',
    'editforumnote' => 'Edit Forum Details for: <b>"%s"</b>',
    'deleteforumnote1' => 'Do you want to delete the forum <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'All topics posted under it will also be deleted.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Edit Category Details for: <b>"%s"</b>',
    'deletecatnote1' => 'Do you want to delete the category <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'All forums and topics posted under those forums will also be deleted.',
    'undercat' => 'Under Category',
    'groupaccess' => 'Group Access: ',
    'action' => 'Actions',
    'forumdescription' => 'Forum Description',
    'posts' => 'Posts',
    'ordertitle' => 'Order',
    'ModEdit' => 'Edit',
    'ModMove' => 'Move',
    'ModStick' => 'Stick',
    'ModBan' => 'Ban',
    'addmoderator' => 'Add Record',
    'delmoderator' => " Delete\nSelected",
    'moderatorwarning' => '<b>Warning: No Forums Defined</b><br' . XHTML . '><br' . XHTML . '>Setup Forum Categories and Add at least 1 forum<br' . XHTML . '>before attempting to add Modertators',
    'private' => 'Private Forum',
    'filtertitle' => 'Select Moderator records to view',
    'addmessage' => 'Add new Moderator',
    'allowedfunctions' => 'Allowed Functions',
    'userrecords' => 'User Records',
    'grouprecords' => 'Group Records',
    'filterview' => 'Filter View',
    'readonly' => 'Readonly Forum',
    'readonlydscp' => 'Only the Moderator can post to this forum',
    'hidden' => 'Hidden Forum',
    'hiddendscp' => 'Forum does not show in the forum index',
    'hideposts' => 'Hide New posts',
    'hidepostsdscp' => 'Updates will not show in the New Posts Blocks or RSS Feeds',
    'mod_title' => 'Forum Moderators',
    'allforums' => 'All Forums'
);

$LANG_GF95 = array(
    'header1' => 'Discussion Board Messages',
    'header2' => 'Discussion Board Messages for forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Feature has not been implemented yet',
    'delall' => 'Delete All',
    'delallmsg' => 'Are you sure you want to delete all messages from: %s?',
    'underforum' => '<b>Under Forum: %s (ID #%s)',
    'moderate' => 'Moderate',
    'nomess' => 'There have been no messages posted yet! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'IP Management',
    'ban' => 'Ban',
    'noips' => '<p style="margin:0px; padding:5px;">No IPs have been banned yet!</p>',
    'unban' => 'Un-Ban',
    'ipbanned' => 'IP Address Banned',
    'banip' => 'Ban IP Confirmation',
    'banipmsg' => 'Are you sure you want to ban the ip %s?',
    'specip' => 'Please specify an IP Address to ban!',
    'ipunbanned' => 'IP Address Un-Banned.',
    'noip' => 'You did not provide an IP address!'
);


$LANG_GF_SMILIES = array(
    'biggrin' => 'Big Grin',
    'smile' => 'Smile',
    'frown' => 'Frown',
    'eek' => 'Geek',
    'confused' => 'Confused',
    'cool' => 'Cool',
    'lol' => 'LOL',
    'angry' => 'Angry',
    'razz' => 'Razz',
    'oops' => 'Oops!',
    'surprise' => 'Surprised!',
    'cry' => 'Cry',
    'evil' => 'Evil',
    'twisted' => 'Twisted',
    'rolleye' => 'Rolling Eyes',
    'wink' => 'Wink',
    'exclaim' => 'Exclaimation',
    'question' => 'Question',
    'idea' => 'Idea',
    'arrow' => 'Arrow',
    'neutral' => 'Neutral',
    'green' => 'Mr. Green',
    'sick' => 'Sick',
    'tired' => 'Tired',
    'monkey' => 'Monkey'
);
$PLG_forum_MESSAGE1 = 'Forum Plugin Upgrade: Update succesvol voltooid.';
$PLG_forum_MESSAGE2 = 'Forum Plugin upgrade: We kunnen deze versie niet automatisch updaten. Kijk in de plugin documentatie.';
$PLG_forum_MESSAGE5 = 'Forum Plugin Upgrade gefaald - controleer error.log';

// Messages for the plugin upgrade
$PLG_forum_MESSAGE3001 = '';
$PLG_forum_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['forum'] = array(
    'label' => 'Forum',
    'title' => 'Forum Configuration'
);

$LANG_confignames['forum'] = array(
    'registration_required' => 'Login Required to View Posts?',
    'registered_to_post' => 'Login Required to Post?',
    'allow_notification' => 'Allow Notification?',
    'show_topicreview' => 'Show Topic Review when Replying?',
    'allow_user_dateformat' => 'Allow User defined Date Format?',
    'use_pm_plugin' => 'Use Private Message Plugin?',
    'show_topics_perpage' => 'Number of Topics to Show per Page',
    'show_posts_perpage' => 'Number of Posts to Show per Page',
    'show_messages_perpage' => 'Number of Message Lines per Page',
    'show_searches_perpage' => 'Number of Search Results per Page',
    'showblocks' => 'Block Columns to Show with Forum',
    'usermenu' => 'Type of User Menu',
    'use_themes_template' => 'Use Templates in the Theme Directory',
    'show_subject_length' => 'Max Length of Subject',
    'min_username_length' => 'Min Length of Username',
    'min_subject_length' => 'Min Length of Subject',
    'min_comment_length' => 'Min Length of Post Content',
    'views_tobe_popular' => 'Number of Views to have Popular',
    'post_speedlimit' => 'Posting Speedlimit(sec)',
    'allowed_editwindow' => 'Timeframe(sec) to Allow Edit Posts',
    'allow_html' => 'Allow HTML Mode?',
    'post_htmlmode' => 'Set HTML Mode as Default?',
    'convert_break' => 'Convert Newlines to HTML &lt;BR&gt;?',
    'use_censor' => 'Use Geeklog Censoring?',
    'use_glfilter' => 'Use Geeklog Filtering?',
    'use_geshi' => 'Use Geshi Code Formatting?',
    'use_spamx_filter' => 'Use Spam-X Plugin?',
    'show_moods' => 'Enable Moods?',
    'allow_smilies' => 'Enable Smilies?',
    'use_smilies_plugin' => 'Use Smilies Plugin?',
    'avatar_width' => 'Width of Member Avatar',
    'show_centerblock' => 'Enable Centerblock?',
    'centerblock_homepage' => 'Enable Homepage Only?',
    'centerblock_numposts' => 'Number of Posts to Show',
    'cb_subject_size' => 'Max Length of Subject',
    'centerblock_where' => 'Placement on Page',
    'sideblock_numposts' => 'Number of Posts to Show',
    'sb_subject_size' => 'Max Length of Subject',
    'sb_latestpostonly' => 'Show Latest Post Only?',
    'sideblock_enable' => 'Enabled',
    'sideblock_isleft' => 'Display Block on Left',
    'sideblock_order' => 'Block Order',
    'sideblock_topic_option' => 'Topic Options',
    'sideblock_topic' => 'Topic',
    'sideblock_group_id' => 'Group',
    'sideblock_permissions' => 'Permissions',
    'level1' => 'Number of Posts of Level1',
    'level2' => 'Number of Posts of Level2',
    'level3' => 'Number of Posts of Level3',
    'level4' => 'Number of Posts of Level4',
    'level5' => 'Number of Posts of Level5',
    'level1name' => 'Name of Level1',
    'level2name' => 'Name of Level2',
    'level3name' => 'Name of Level3',
    'level4name' => 'Name of Level4',
    'level5name' => 'Name of Level5',
    'menublock_enable' => 'Enabled',
    'menublock_isleft' => 'Display Block on Left',
    'menublock_order' => 'Block Order',
    'menublock_topic_option' => 'Topic Options',
    'menublock_topic' => 'Topic',
    'menublock_group_id' => 'Group',
    'menublock_permissions' => 'Permissions'
);

$LANG_configsubgroups['forum'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['forum'] = array(
    'tab_main' => 'General Forum Settings',
    'tab_topicposting' => 'Topic Posting',
    'tab_centerblock' => 'Centerblock',
    'tab_sideblock' => 'Sideblock',
    'tab_rank' => 'Rank',
    'tab_menublock' => 'Menu Block'
);

$LANG_fs['forum'] = array(
    'fs_main' => 'General Forum Settings',
    'fs_topicposting' => 'Topic Posting',
    'fs_centerblock' => 'Centerblock',
    'fs_sideblock' => 'Sideblock',
    'fs_sideblock_settings' => 'Block Settings',
    'fs_sideblock_permissions' => 'Block Permissions',
    'fs_rank' => 'Rank',
    'fs_menublock' => 'Menu Block',
    'fs_menublock_settings' => 'Block Settings',
    'fs_menublock_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['forum'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    5 => array('Top Of Page' => 1, 'After Featured Story' => 2, 'Bottom Of Page' => 3),
    6 => array('Left Blocks' => 'leftblocks', 'Right Blocks' => 'rightblocks', 'All Blocks' => 'allblocks', 'No Blocks' => 'noblocks'),
    7 => array('Block Menu' => 'blockmenu', 'Navigation Bar' => 'navbar', 'None' => 'none'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
