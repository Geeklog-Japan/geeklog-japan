<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | swedish.php                                                               |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003 by the following authors:                              |
// |    Insikt           postmaster AT insikt DOT org                          |
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
    'statslabel' => 'Totalt antal inl臠g',
    'statsheading1' => 'Topp-10 l舖ta 舂nen',
    'statsheading2' => 'Topp-10 besvarade 舂nen',
    'statsheading3' => 'Inga 舂nen att rapportera',
    'useradminmenu' => 'Foruminst舁lningar',
    'access_denied' => 'ナtkomst nekad',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'All',
    'YES' => 'Ja',
    'NO' => 'Nej',
    'NEW' => 'Nya',
    'NEXT' => 'N舖ta',
    'ERROR' => 'Fel!',
    'CONFIRM' => 'Bekr臟ta',
    'UPDATE' => 'Uppdatera',
    'SAVE' => 'Spara',
    'CANCEL' => 'Avbryt',
    'ON' => ' ',
    'ON2' => '&nbsp;&nbsp;<b>On: </b>',
    'BY' => 'Av: ',
    'RE' => 'トmne: ',
    'DATE' => 'Datum',
    'VIEWS' => 'L舖ta',
    'REPLIES' => 'Svar',
    'NAME' => 'Namn:',
    'DESCRIPTION' => 'Beskrivning: ',
    'TOPIC' => 'トmne',
    'TOPICS' => 'トmnen:',
    'TOPICSUBJECT' => 'Titel舂ne',
    'HOMEPAGE' => 'Home',
    'SUBJECT' => 'トmne',
    'HELLO' => 'Hej ',
    'MOVED' => 'Moved',
    'POSTS' => 'Postningar',
    'LASTPOST' => 'Senaste Inl臠g',
    'POSTEDON' => 'Posted on',
    'POSTEDBY' => 'Posted By',
    'PAGES' => 'Sidor',
    'TODAY' => 'Idag klockan ',
    'REGISTERED' => 'Registrerad',
    'ORDERBY' => 'Sorteringsordning:',
    'ORDER' => 'Ordning:',
    'USER' => 'Anv舅dare',
    'GROUP' => 'Group',
    'ANON' => 'Anonym: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Ffattare',
    'NOMOOD' => 'No Mood',
    'REQUIRED' => '[Kr舸s]',
    'OPTIONAL' => '[Valfritt]',
    'SUBMIT' => 'Skicka',
    'PREVIEW' => 'Fhandsgrandska',
    'REMOVE' => 'Ta bort',
    'EDIT' => 'Redigera',
    'DELETE' => 'Ta bort',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Val:',
    'MISSINGSUBJECT' => 'トmne tomt',
    'MIGRATE_NOW' => 'Migrate Now',
    'FILTERLIST' => 'Filter List',
    'SELECTFORUM' => 'Select Forum',
    'DELETEAFTER' => 'Delete after',
    'TITLE' => 'Title',
    'COMMENTS' => 'Comments',
    'SUBMISSIONS' => 'Submissions',
    'HTML_FILTER_MSG' => 'Filtered HTML Allowed',
    'HTML_FULL_MSG' => 'Full HTML Allowed',
    'HTML_MSG' => 'HTML Allowed',
    'CENSOR_PERM_MSG' => 'Censored Content',
    'ANON_PERM_MSG' => 'View Anonymous Posts',
    'POST_PERM_MSG1' => 'Able to post',
    'POST_PERM_MSG2' => 'Anonymous users can post',
    'GO' => 'GO',
    'STATUS' => 'Status:',
    'ONLINE' => 'online',
    'OFFLINE' => 'offline',
    'back2parent' => 'Feg蘰nde トmne',
    'forumname' => '',
    'category' => 'Kategori: ',
    'loginreqview' => '<b>Du m蚶te tyv舐r %s registrera dig</a> eller %s logga in </a> f att anv舅da detta forum</b>',
    'loginreqpost' => '<b>Du m蚶te tyv舐r registrera dig eller logga in f att skriva inl臠g pdessa forum</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Ingen.',
    'back2top' => 'Tillbaks till toppen',
    'TEXTMODE' => 'Text Mode:',
    'HTMLMODE' => 'HTML Mode:',
    'TopicPreview' => 'Fhandsgrandska 舂ne',
    'moderator' => 'Moderator',
    'admin' => 'Admin',
    'DATEADDED' => 'Tillagd',
    'PREVTOPIC' => 'Feg蘰nde 舂ne',
    'NEXTTOPIC' => 'N舖ta 舂ne',
    'RESYNC' => 'Synkronisera',
    'RESYNCCAT' => 'ReSync Category Forums',
    'EDITICON' => 'Edit',
    'QUOTEICON' => 'Quote',
    'ProfileLink' => 'Profile',
    'WebsiteLink' => 'Website',
    'PMLink' => 'PM',
    'EmailLink' => 'Email',
    'FORUMSUBSCRIBE' => 'Subscribe to this forum',
    'FORUMUNSUBSCRIBE' => 'Un-Subscribe to this forum',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => 'New Topic',
    'POSTREPLY' => 'Post Reply',
    'SubscribeLink' => 'Subscribe',
    'unSubscribeLink' => 'Un-Subscribe',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => 'Subscriptions',
    'TOP' => 'Top of Post',
    'PRINTABLE' => 'Printable Version',
    'USERPREFS' => 'User Preferences',
    'SPEEDLIMIT' => '"Your last comment was %s seconds ago.<br' . XHTML . '>This site requires at least %s seconds between forum posts."',
    'ACCESSERROR' => 'ACCESS ERROR',
    'ACTIONS' => 'Actions',
    'DELETEALL' => 'Delete all selected records',
    'DELCONFIRM' => 'Are you sure you want to Delete selected records?',
    'DELALLCONFIRM' => 'Are you sure you want to Delete ALL selected records?',
    'STARTEDBY' => 'Started by:',
    'WARNING' => 'Warning',
    'MODERATED' => 'Moderators: %s',
    'LASTREPLYBY' => 'Last reply by:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Forum Index',
    'FEATURE' => 'Feature',
    'SETTING' => 'Setting',
    'MARKALLREAD' => 'Mark All Read',
    'MSG_NO_CAT' => 'No Categories or Forums Defined',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Code',
    'FONTCOLOR' => 'Font Color',
    'FONTSIZE' => 'Font Size',
    'CLOSETAGS' => 'Close Tags',
    'CODETIP' => 'Tip: Styles can be applied quickly to selected text',
    'TINY' => 'Tiny',
    'SMALL' => 'Small',
    'NORMAL' => 'Normal',
    'LARGE' => 'Large',
    'HUGE' => 'Huge',
    'DEFAULT' => 'Default',
    'DKRED' => 'Dark Red',
    'RED' => 'Red',
    'ORANGE' => 'Orange',
    'BROWN' => 'Brown',
    'YELLOW' => 'Yellow',
    'GREEN' => 'Green',
    'OLIVE' => 'Olive',
    'CYAN' => 'Cyan',
    'BLUE' => 'Blue',
    'DKBLUE' => 'Dark Blue',
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Violet',
    'WHITE' => 'White',
    'BLACK' => 'Black',
    'b_help' => 'Bold text: [b]text[/b]',
    'i_help' => 'Italic text: [i]text[/i]',
    'u_help' => 'Underline text: [u]text[/u]',
    'q_help' => 'Quote text: [quote]text[/quote]',
    'c_help' => 'Code display: [code]code[/code]',
    'l_help' => 'List: [list]text[/list]',
    'o_help' => 'Ordered list: [olist]text[/olist]',
    'p_help' => '[img]http://image_url[/img]  or [img w=100 h=200][/img]',
    'w_help' => 'Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]',
    'a_help' => 'Close all open bbCode tags',
    's_help' => 'Font color: [color=red]text[/color]  Tip: you can also use color=#FF0000',
    'f_help' => 'Font size: [size=7]small text[/size]',
    'h_help' => 'Click to view more detailed help'
);

$LANG_GF02 = array(
    'msg01' => 'Sorry you must register to use these forums',
    'msg02' => 'You should not be here!<br' . XHTML . '>Restricted access to this forum only',
    'msg03' => 'Please wait while you are redirected',
    'msg05' => '<center><em>Inga 舂nen har skapats 舅nu.</em></center>',
    'msg07' => 'Anv舅dare Online:',
    'msg14' => 'Du har blivit avst舅gd och f蚌 inte delta.<br' . XHTML . '>',
    'msg15' => 'Om du tycker att detta inte st舂mer, kontakta <A HREF="mailto:%s?subject=Guestbook IP Ban">Site Admin</A>.',
    'msg18' => 'Problem! Alla f舁ten 舐 inte ifyllda eller f kort skrivna.',
    'msg19' => 'Ditt meddelande har postats.',
    'msg22' => '- Forum Inl臠gsnotis',
    'msg23a' => "\nEtt svar har gjorts i tr蘚en '%s' av %s\n\nDetta 舂ne p蘆jades av: %s i %s forum.\n",
    'msg23b' => "Ett nytt 舂ne '%s' har skickats av %s i %s's forum p%s websidan.\nDu kan l舖a det p %s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "\nDu kan l舖a det p %s/forum/index.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nHa en bra dag! \n",
    'msg26' => "\nDu har f蚯t detta mail f att du har valt att fen notis n舐 ett svar har gjorts till 舂net. \n",
    'msg27' => 'F att sluta bevaka detta 舂ne tryck <a href="%s">h舐</a> f att avbryta det.',
    'msg33' => 'Namn: [Kr舸s]',
    'msg36' => 'Hum: [Valfritt]',
    'msg38' => 'Meddela mig vid svar ',
    'msg40' => '<br' . XHTML . '>Du har redan bett om att fmeddelande vid svar pdetta 舂ne.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => 'Du har inga nya rapporter.',
    'msg49' => '(L舖t %s g蚣ger) ',
    'msg55' => 'Inl臠get raderat.',
    'msg56' => 'IP Bannlyst.',
    'msg59' => 'Normalt 舂ne',
    'msg60' => 'Nytt inl臠g',
    'msg61' => 'Klistrat 舂ne',
    'msg62' => 'Meddela mig vid svar',
    'msg64' => 'トr du s臾er patt du vill ta bort 舂net %s som heter: %s ?',
    'msg65' => '<br' . XHTML . '>Detta 舐 ett huvud舂ne, salla svar som postats i kedjan kommer ocksraderas.',
    'msg68' => 'OBS! VAR FヨRSIKTIG NトR DU BANNAR/UTESLUTER, endast administrater har r舩tigheter att ta bort s蘚ant.',
    'msg69' => '<br' . XHTML . '>Vill du verkligen utesluta ipadressen %s?',
    'msg71' => 'Ingen funktion 舐 vald, v舁j en post och sedan en moderatorfunktion.<br' . XHTML . '>OBS! Du m蚶te vara moderator f att futfa dessa funktioner.',
    'msg72' => 'Om meddelandet 舐 online shar du inte r舩t att utfa denna moderatorfunktion.',
    'msg74' => 'Senaste %s foruminl臠g',
    'msg75' => 'Topp %s 舂nen efter visningar',
    'msg76' => 'Topp %s 舂nen efter postningar',
    'msg77' => '<br' . XHTML . '>Du skall inte vara h舐!<br' . XHTML . '>Detta forum har begr舅sad tillg蚣g.',
    'msg83' => '<br' . XHTML . '>Du m蚶te vara inloggad f att anv舅da denna funktion.<br' . XHTML . '><br' . XHTML . '>',
    'msg84' => 'Markera alla 舂nen som l舖ta',
    'msg85' => 'Gtill sida:',
    'msg86' => '&nbsp;Senaste %s inl臠gen av&nbsp;',
    'msg87' => '<br' . XHTML . '>Varning: Detta 舂net 舐 l蚶t av moderatorn.<br' . XHTML . '>Inga fler inl臠g 舐 till蚯na',
    'msg88' => 'Mitt forums medlemmar',
    'msg88b' => 'Forum Activity Only',
    'msg89' => 'Mina aktiva bevakningar',
    'msg101' => 'Forum Regler:',
    'msg103' => 'Hoppa till forum:',
    'msg106' => 'V舁j ett forum',
    'msg108' => 'Normalt Forum',
    'msg109' => 'L蚶t 舂ne',
    'msg110' => 'G蚌 till sida f meddelanderedigering..',
    'msg111' => 'Nya inl臠g sedan senaste beset:',
    'msg112' => 'L舖 nya inl臠g',
    'msg113' => 'L舖 nya inl臠g i detta forum',
    'msg114' => 'L蚶t 舂ne',
    'msg115' => 'Klistrat 舂ne M/ Nya inl臠g',
    'msg116' => 'L蚶t 舂ne M/ Nya inl臠g',
    'msg117' => 'S alla',
    'msg118' => 'S i detta forum',
    'msg119' => 'Sresultat:',
    'msg120' => 'Mest l舖ta inl臠g',
    'msg121' => 'All times are %s. Klockan 舐 nu %s.',
    'msg122' => 'Popul舐 Gr舅s:',
    'msg123' => 'Antal inl臠g innan popul舐gr舅sen uppn蚶',
    'msg126' => 'S rader:',
    'msg127' => 'Antal rader att visa i sresultat',
    'msg128' => 'Medlemmar per sida:',
    'msg129' => 'For the Members listing screen',
    'msg130' => 'Visa anonyma inl臠g:',
    'msg131' => 'Till蚯er dig att filtrera bort anonyma inl臠g?',
    'msg132' => 'Meddela alltid:',
    'msg133' => 'Aktivera automatisk bevakning palla dina 舂nen',
    'msg134' => 'Prenumerationen 舐 upplagd',
    'msg135' => 'Du kommer nu meddelas om alla nya inl臠g pdetta forum.',
    'msg136' => 'Du m蚶te v舁ja ett forum att prenumerera p',
    'msg137' => 'Bevakning av 舂net 舐 aktiverat',
    'msg138' => '<b>Prenumerera phela forumet</b>',
    'msg142' => 'Bevakning sparad.',
    'msg144' => 'ナtergtill 舂ne',
    'msg146' => 'Raderat',
    'msg147' => 'Forum [utskriftsv舅lig version av 舂ne',
    'msg148' => 'Tryck <a href="javascript:history.back()">HトR</a> f att 蚯erv舅da',
    'msg155' => 'Inga inl臠g.',
    'msg156' => 'Totalt antal foruminl臠g',
    'msg157' => 'Senaste 10 inl臠gen',
    'msg158' => 'Senaste 10 inl臠gen av ',
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
    'delete' => 'Radera inl臠g',
    'edit' => 'Redigera inl臠g',
    'move' => 'Flytta 舂ne',
    'split' => 'Split Topic',
    'ban' => 'Bannlys IP',
    'movetopic' => 'Flytta 舂ne',
    'movetopicmsg' => '<br' . XHTML . '> Du har tillst蚣d att flytta 舂net <b>%s</b> till fjande forum:',
    'splittopicmsg' => '<br' . XHTML . '>Create a new Topic with this post: "<b>%s</b>"<br' . XHTML . '><em>By:</em>&nbsp;%s&nbsp <em>On:</em>&nbsp;%s',
    'selectforum' => 'Select new forum:',
    'lockedpost' => 'Add Reply Post',
    'splitheading' => 'Split thread option:',
    'splitopt1' => 'Move all posts from this point',
    'splitopt2' => 'Move only this one post'
);

$LANG_GF04 = array(
    'label_forum' => 'Forum Profil',
    'label_location' => 'Plats',
    'label_aim' => 'AIM-Namn',
    'label_yim' => 'YIM-Namn',
    'label_icq' => 'ICQ-Identitet',
    'label_msnm' => 'MS Messenger-Namn',
    'label_interests' => 'Intressen',
    'label_occupation' => 'Syssels舩tning'
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
    'gfstats' => 'Geekforum Statistik',
    'statsmsg' => 'Nuvarande statistik f ditt forum:',
    'totalcats' => 'Totalt antal Kategorier:',
    'totalforums' => 'Totalt antal Forum:',
    'totaltopics' => 'Totalt antal トmnen:',
    'totalposts' => 'Totalt antal Inl臠g:',
    'totalviews' => 'Totalt antal Visningar:',
    'avgpmsg' => 'Genomsnittligt antal inl臠g per:',
    'category' => 'Kategori:',
    'forum' => 'Forum:',
    'topic' => 'Topic:',
    'avgvmsg' => 'Genomsnittligt antal visningar per:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Geekforum Inst舁lningar',
    'showiframe' => 'Visa 舂nesgranskningar:',
    'showiframedscp' => 'Visa 舂nesgranskningar (Iframe) i botten vid besvarande av 舂ne',
    'topicspp' => 'トmnen per sida:',
    'topicsppdscp' => 'Antal 舂nen att visa i forumindex',
    'postspp' => 'Inl臠g per sida:',
    'postsppdscp' => 'Antal inl臠g att visa per sida',
    'setsavemsg' => 'Inst舁lningar sparade.'
);

$LANG_GF93 = array(
    'gfboard' => 'Geekforum トmnesomr蘚en',
    'addcat' => 'L臠g till kategori',
    'addforum' => 'L臠g till forum',
    'catorder' => 'Kategori-Ordning',
    'catadded' => 'Kategori Tillagd.',
    'catdeleted' => 'Kategori Borttagen',
    'catedited' => 'Kategori Redigerad.',
    'forumadded' => 'Forum tillagt.',
    'forumaddError' => 'Error Adding Forum.',
    'forumdeleted' => 'Forum borttaget',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum redigerat',
    'forumordered' => 'Forum-Ordning Redigerad',
    'back' => 'Tillbaks',
    'addnote' => 'OBS: Du kan 舅dra detta senare.',
    'editforumnote' => '<br' . XHTML . '>トndra egenskaper i forum f: <b>"%s"</b>',
    'deleteforumnote1' => 'Vill du ta bort forumet <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Alla 舂nen som postats under kommer ocksatt raderas.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => '<br' . XHTML . '>Redigera kategoriegenskaper f: <b>"%s"</b>',
    'deletecatnote1' => 'Vill du radera kategorin <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Alla forum och 舂nen som skickats under dessa forum kommer ocksatt raderas.',
    'undercat' => 'Under kategori',
    'groupaccess' => 'Grupp Access: ',
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
    'mod_title' => 'Forum Moderatorer',
    'allforums' => 'All Forums'
);

$LANG_GF95 = array(
    'header1' => 'Discussion Board Messages',
    'header2' => 'Discussion Board Messages for forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Funktionen har inte lagts till 舅',
    'delall' => 'Radera alla',
    'delallmsg' => 'トr du s臾er patt du vill radera alla meddelanden fr蚣: %s?',
    'underforum' => '<b>Under Forum: %s (ID #%s)',
    'moderate' => 'Moderera',
    'nomess' => 'Det har inte skickats n虍ra meddelanden 舅! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'IP-Hantering',
    'ban' => 'Banna',
    'noips' => '<p style="margin:0px; padding:5px;">Inga ipdresser har bannats 舅nu!</p>',
    'unban' => 'Ta bort ban',
    'ipbanned' => 'Bannad IPAdress',
    'banip' => 'Bekr臟ta bannad ip',
    'banipmsg' => 'トr du s臾er patt du vill banna %s?',
    'specip' => 'Specificera en ipadress som skall bannas!',
    'ipunbanned' => 'IPAdressen bannas inte l舅gre.',
    'noip' => 'You did not provide an IP address!'
);


$LANG25 = array(
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
$PLG_forum_MESSAGE1 = 'Forum Plugin Upgrade: Update completed successfully.';
$PLG_forum_MESSAGE2 = 'Forum Plugin upgrade: We are unable to update this version automatically. Refer to the plugin documentation.';
$PLG_forum_MESSAGE5 = 'Forum Plugin Upgrade failed - check error.log';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '';
$PLG_polls_MESSAGE3002 = $LANG32[9];

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
    'use_themes_template' => 'Use templates in the theme directory',
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
