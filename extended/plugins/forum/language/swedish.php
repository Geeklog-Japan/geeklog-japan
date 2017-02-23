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
    'statslabel' => 'Totalt antal inlägg',
    'statsheading1' => 'Topp-10 lästa ämnen',
    'statsheading2' => 'Topp-10 besvarade ämnen',
    'statsheading3' => 'Inga ämnen att rapportera',
    'useradminmenu' => 'Foruminställningar',
    'access_denied' => 'Åtkomst nekad',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'All',
    'YES' => 'Ja',
    'NO' => 'Nej',
    'NEW' => 'Nya',
    'NEXT' => 'Nästa',
    'ERROR' => 'Fel!',
    'CONFIRM' => 'Bekräfta',
    'UPDATE' => 'Uppdatera',
    'SAVE' => 'Spara',
    'CANCEL' => 'Avbryt',
    'ON' => ' ',
    'ON2' => '&nbsp;&nbsp;<b>On: </b>',
    'BY' => 'Av: ',
    'RE' => 'Ämne: ',
    'DATE' => 'Datum',
    'VIEWS' => 'Lästa',
    'REPLIES' => 'Svar',
    'NAME' => 'Namn:',
    'DESCRIPTION' => 'Beskrivning: ',
    'TOPIC' => 'Ämne',
    'TOPICS' => 'Ämnen:',
    'TOPICSUBJECT' => 'Titelämne',
    'HOMEPAGE' => 'Home',
    'SUBJECT' => 'Ämne',
    'HELLO' => 'Hej ',
    'MOVED' => 'Moved',
    'POSTS' => 'Postningar',
    'LASTPOST' => 'Senaste Inlägg',
    'POSTEDON' => 'Posted on',
    'POSTEDBY' => 'Posted By',
    'PAGES' => 'Sidor',
    'TODAY' => 'Idag klockan ',
    'REGISTERED' => 'Registrerad',
    'ORDERBY' => 'Sorteringsordning:',
    'ORDER' => 'Ordning:',
    'USER' => 'Användare',
    'GROUP' => 'Group',
    'ANON' => 'Anonym: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Författare',
    'NOMOOD' => 'No Mood',
    'REQUIRED' => '[Krävs]',
    'OPTIONAL' => '[Valfritt]',
    'SUBMIT' => 'Skicka',
    'PREVIEW' => 'Förhandsgrandska',
    'REMOVE' => 'Ta bort',
    'EDIT' => 'Redigera',
    'DELETE' => 'Ta bort',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Val:',
    'MISSINGSUBJECT' => 'Ämne tomt',
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
    'back2parent' => 'Föregående Ämne',
    'forumname' => '',
    'category' => 'Kategori: ',
    'loginreqview' => '<b>Du måste tyvärr %s registrera dig</a> eller %s logga in </a> för att använda detta forum</b>',
    'loginreqpost' => '<b>Du måste tyvärr registrera dig eller logga in för att skriva inlägg på dessa forum</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Ingen.',
    'back2top' => 'Tillbaks till toppen',
    'TEXTMODE' => 'Text Mode:',
    'HTMLMODE' => 'HTML Mode:',
    'TopicPreview' => 'Förhandsgrandska ämne',
    'moderator' => 'Moderator',
    'admin' => 'Admin',
    'DATEADDED' => 'Tillagd',
    'PREVTOPIC' => 'Föregående ämne',
    'NEXTTOPIC' => 'Nästa ämne',
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
    'msg05' => '<center><em>Inga ämnen har skapats ännu.</em></center>',
    'msg07' => 'Användare Online:',
    'msg14' => 'Du har blivit avstängd och får inte delta.<br' . XHTML . '>',
    'msg15' => 'Om du tycker att detta inte stämmer, kontakta <A HREF="mailto:%s?subject=Guestbook IP Ban">Site Admin</A>.',
    'msg18' => 'Problem! Alla fälten är inte ifyllda eller för kort skrivna.',
    'msg19' => 'Ditt meddelande har postats.',
    'msg22' => '- Forum Inläggsnotis',
    'msg23a' => "\nEtt svar har gjorts i tråden '%s' av %s\n\nDetta ämne påbörjades av: %s i %s forum.\n",
    'msg23b' => "Ett nytt ämne '%s' har skickats av %s i %s's forum på %s websidan.\nDu kan läsa det på: %s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "\nDu kan läsa det på: %s/forum/index.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nHa en bra dag! \n",
    'msg26' => "\nDu har fått detta mail för att du har valt att få en notis när ett svar har gjorts till ämnet. \n",
    'msg27' => 'För att sluta bevaka detta ämne tryck <a href="%s">här</a> för att avbryta det.',
    'msg33' => 'Namn: [Krävs]',
    'msg36' => 'Humör: [Valfritt]',
    'msg38' => 'Meddela mig vid svar ',
    'msg40' => '<br' . XHTML . '>Du har redan bett om att få meddelande vid svar på detta ämne.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => 'Du har inga nya rapporter.',
    'msg49' => '(Läst %s gånger) ',
    'msg55' => 'Inlägget raderat.',
    'msg56' => 'IP Bannlyst.',
    'msg59' => 'Normalt ämne',
    'msg60' => 'Nytt inlägg',
    'msg61' => 'Klistrat ämne',
    'msg62' => 'Meddela mig vid svar',
    'msg64' => 'Är du säker på att du vill ta bort ämnet %s som heter: %s ?',
    'msg65' => '<br' . XHTML . '>Detta är ett huvudämne, så alla svar som postats i kedjan kommer också raderas.',
    'msg68' => 'OBS! VAR FÖRSIKTIG NÄR DU BANNAR/UTESLUTER, endast administratörer har rättigheter att ta bort sådant.',
    'msg69' => '<br' . XHTML . '>Vill du verkligen utesluta ipadressen %s?',
    'msg71' => 'Ingen funktion är vald, välj en post och sedan en moderatorfunktion.<br' . XHTML . '>OBS! Du måste vara moderator för att få utföra dessa funktioner.',
    'msg72' => 'Om meddelandet är online så har du inte rätt att utföra denna moderatorfunktion.',
    'msg74' => 'Senaste %s foruminlägg',
    'msg75' => 'Topp %s ämnen efter visningar',
    'msg76' => 'Topp %s ämnen efter postningar',
    'msg77' => '<br' . XHTML . '>Du skall inte vara här!<br' . XHTML . '>Detta forum har begränsad tillgång.',
    'msg83' => '<br' . XHTML . '>Du måste vara inloggad för att använda denna funktion.<br' . XHTML . '><br' . XHTML . '>',
    'msg84' => 'Markera alla ämnen som lästa',
    'msg85' => 'Gå till sida:',
    'msg86' => '&nbsp;Senaste %s inläggen av&nbsp;',
    'msg87' => '<br' . XHTML . '>Varning: Detta ämnet är låst av moderatorn.<br' . XHTML . '>Inga fler inlägg är tillåtna',
    'msg88' => 'Mitt forums medlemmar',
    'msg88b' => 'Forum Activity Only',
    'msg89' => 'Mina aktiva bevakningar',
    'msg101' => 'Forum Regler:',
    'msg103' => 'Hoppa till forum:',
    'msg106' => 'Välj ett forum',
    'msg108' => 'Normalt Forum',
    'msg109' => 'Låst ämne',
    'msg110' => 'Går till sida för meddelanderedigering..',
    'msg111' => 'Nya inlägg sedan senaste besöket:',
    'msg112' => 'Läs nya inlägg',
    'msg113' => 'Läs nya inlägg i detta forum',
    'msg114' => 'Låst ämne',
    'msg115' => 'Klistrat ämne M/ Nya inlägg',
    'msg116' => 'Låst ämne M/ Nya inlägg',
    'msg117' => 'Sök alla',
    'msg118' => 'Sök i detta forum',
    'msg119' => 'Sökresultat:',
    'msg120' => 'Mest lästa inlägg',
    'msg121' => 'All times are %s. Klockan är nu %s.',
    'msg122' => 'Populär Gräns:',
    'msg123' => 'Antal inlägg innan populärgränsen uppnås',
    'msg126' => 'Sök rader:',
    'msg127' => 'Antal rader att visa i sökresultat',
    'msg128' => 'Medlemmar per sida:',
    'msg129' => 'For the Members listing screen',
    'msg130' => 'Visa anonyma inlägg:',
    'msg131' => 'Tillåter dig att filtrera bort anonyma inlägg?',
    'msg132' => 'Meddela alltid:',
    'msg133' => 'Aktivera automatisk bevakning på alla dina ämnen',
    'msg134' => 'Prenumerationen är upplagd',
    'msg135' => 'Du kommer nu meddelas om alla nya inlägg på detta forum.',
    'msg136' => 'Du måste välja ett forum att prenumerera på.',
    'msg137' => 'Bevakning av ämnet är aktiverat',
    'msg138' => '<b>Prenumerera på hela forumet</b>',
    'msg142' => 'Bevakning sparad.',
    'msg144' => 'Återgå till ämne',
    'msg146' => 'Raderat',
    'msg147' => 'Forum [utskriftsvänlig version av ämne %s]',
    'msg148' => 'Tryck <a href="javascript:history.back()">HÄR</a> för att återvända',
    'msg155' => 'Inga inlägg.',
    'msg156' => 'Totalt antal foruminlägg',
    'msg157' => 'Senaste 10 inläggen',
    'msg158' => 'Senaste 10 inläggen av ',
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
    'delete' => 'Radera inlägg',
    'edit' => 'Redigera inlägg',
    'move' => 'Flytta ämne',
    'split' => 'Split Topic',
    'ban' => 'Bannlys IP',
    'movetopic' => 'Flytta ämne',
    'movetopicmsg' => '<br' . XHTML . '> Du har tillstånd att flytta ämnet <b>%s</b> till följande forum:',
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
    'label_occupation' => 'Sysselsättning'
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
    'statsmsg' => 'Nuvarande statistik för ditt forum:',
    'totalcats' => 'Totalt antal Kategorier:',
    'totalforums' => 'Totalt antal Forum:',
    'totaltopics' => 'Totalt antal Ämnen:',
    'totalposts' => 'Totalt antal Inlägg:',
    'totalviews' => 'Totalt antal Visningar:',
    'avgpmsg' => 'Genomsnittligt antal inlägg per:',
    'category' => 'Kategori:',
    'forum' => 'Forum:',
    'topic' => 'Topic:',
    'avgvmsg' => 'Genomsnittligt antal visningar per:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Geekforum Inställningar',
    'showiframe' => 'Visa ämnesgranskningar:',
    'showiframedscp' => 'Visa ämnesgranskningar (Iframe) i botten vid besvarande av ämne',
    'topicspp' => 'Ämnen per sida:',
    'topicsppdscp' => 'Antal ämnen att visa i forumindex',
    'postspp' => 'Inlägg per sida:',
    'postsppdscp' => 'Antal inlägg att visa per sida',
    'setsavemsg' => 'Inställningar sparade.'
);

$LANG_GF93 = array(
    'gfboard' => 'Geekforum Ämnesområden',
    'addcat' => 'Lägg till kategori',
    'addforum' => 'Lägg till forum',
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
    'addnote' => 'OBS: Du kan ändra detta senare.',
    'editforumnote' => '<br' . XHTML . '>Ändra egenskaper i forum för: <b>"%s"</b>',
    'deleteforumnote1' => 'Vill du ta bort forumet <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Alla ämnen som postats under kommer också att raderas.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => '<br' . XHTML . '>Redigera kategoriegenskaper för: <b>"%s"</b>',
    'deletecatnote1' => 'Vill du radera kategorin <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Alla forum och ämnen som skickats under dessa forum kommer också att raderas.',
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
    'notyet' => 'Funktionen har inte lagts till än',
    'delall' => 'Radera alla',
    'delallmsg' => 'Är du säker på att du vill radera alla meddelanden från: %s?',
    'underforum' => '<b>Under Forum: %s (ID #%s)',
    'moderate' => 'Moderera',
    'nomess' => 'Det har inte skickats några meddelanden än! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'IP-Hantering',
    'ban' => 'Banna',
    'noips' => '<p style="margin:0px; padding:5px;">Inga ipdresser har bannats ännu!</p>',
    'unban' => 'Ta bort ban',
    'ipbanned' => 'Bannad IPAdress',
    'banip' => 'Bekräfta bannad ip',
    'banipmsg' => 'Är du säker på att du vill banna %s?',
    'specip' => 'Specificera en ipadress som skall bannas!',
    'ipunbanned' => 'IPAdressen bannas inte längre.',
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
$PLG_forum_MESSAGE1 = 'Forum Plugin Upgrade: Update completed successfully.';
$PLG_forum_MESSAGE2 = 'Forum Plugin upgrade: We are unable to update this version automatically. Refer to the plugin documentation.';
$PLG_forum_MESSAGE5 = 'Forum Plugin Upgrade failed - check error.log';

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
