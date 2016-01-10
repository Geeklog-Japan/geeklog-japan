<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | danish.php                                                                |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004 by the following authors:                              |
// |    Sniper12                                                               |
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
    'statslabel' => 'Samlet antal indl詒',
    'statsheading1' => 'Forum Top 10 Sete Emner',
    'statsheading2' => 'Forum Top 10 Besvarede Emner',
    'statsheading3' => 'Der er ingen relevante emner',
    'useradminmenu' => 'Forum Indstillinger',
    'access_denied' => 'Adgang N詒tet',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'All',
    'YES' => 'Ja',
    'NO' => 'Nej',
    'NEW' => 'Ny',
    'NEXT' => 'N誑te',
    'ERROR' => 'Fejl!',
    'CONFIRM' => 'Bekr詛t',
    'UPDATE' => 'Opdat駻',
    'SAVE' => 'Gem indstillinger',
    'CANCEL' => 'Fortryd',
    'ON' => 'On: ',
    'ON2' => '&nbsp;&nbsp;<b>P </b>',
    'BY' => 'Af: ',
    'RE' => 'Vedr.: ',
    'DATE' => 'Dato',
    'VIEWS' => 'Set',
    'REPLIES' => 'Svar',
    'NAME' => 'Navn:',
    'DESCRIPTION' => 'Beskrivelse: ',
    'TOPIC' => 'Emne',
    'TOPICS' => 'Emner',
    'TOPICSUBJECT' => 'Emne Titel',
    'HOMEPAGE' => 'Hjem',
    'SUBJECT' => 'Titel',
    'HELLO' => 'Hej ',
    'MOVED' => 'Moved',
    'POSTS' => 'Indl詒',
    'LASTPOST' => 'Nyeste Indl詒',
    'POSTEDON' => 'Postet p,
    'POSTEDBY' => 'Posted By',
    'PAGES' => 'Sider',
    'TODAY' => 'I dag kl ',
    'REGISTERED' => 'Bruger fra',
    'ORDERBY' => 'Sort駻 efter:',
    'ORDER' => 'Sorteret efter:',
    'USER' => 'Bruger',
    'GROUP' => 'Group',
    'ANON' => 'Anonym:',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Forfatter',
    'NOMOOD' => 'Intet Hum',
    'REQUIRED' => '[Obligatorisk]',
    'OPTIONAL' => '[Frivillig]',
    'SUBMIT' => 'Godkend',
    'PREVIEW' => 'Gennemse',
    'REMOVE' => 'Fjern',
    'EDIT' => 'Redig駻',
    'DELETE' => 'Slet',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Indstillinger:',
    'MISSINGSUBJECT' => 'Blankt Emne',
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
    'back2parent' => 'Overordnet Debat',
    'forumname' => '',
    'category' => 'Kategori: ',
    'loginreqview' => '<b>Beklager, du skal %s registrere en brugerkonto</a> eller %s logge ind</a> for at bruge disse forummer</b>',
    'loginreqpost' => '<b>Beklager, kun registrerede brugere mskrive indl詒.</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Ingen.',
    'back2top' => 'Tilbage til toppen',
    'TEXTMODE' => 'Text Mode:',
    'HTMLMODE' => 'HTML Mode:',
    'TopicPreview' => 'Gennemse debat indl詒',
    'moderator' => 'Moderator',
    'admin' => 'Admin',
    'DATEADDED' => 'Tilfet pDato',
    'PREVTOPIC' => 'Forrige Emne',
    'NEXTTOPIC' => 'N誑te Emne',
    'RESYNC' => 'Synkronis駻',
    'RESYNCCAT' => 'ReSync Category Forums',
    'EDITICON' => 'Redig駻',
    'QUOTEICON' => 'Cit駻',
    'ProfileLink' => 'Profil',
    'WebsiteLink' => 'Hjemmeside',
    'PMLink' => 'PM',
    'EmailLink' => 'Email',
    'FORUMSUBSCRIBE' => 'Fg dette forum',
    'FORUMUNSUBSCRIBE' => 'Un-Subscribe to this forum',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => 'Nyt Emne',
    'POSTREPLY' => 'Svar',
    'SubscribeLink' => 'Subscribe',
    'unSubscribeLink' => 'Un-Subscribe',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => 'Adviseringer',
    'TOP' => 'Gtil toppen',
    'PRINTABLE' => 'Udskriftsvenlig Udgave',
    'USERPREFS' => 'Bruger Indstillinger',
    'SPEEDLIMIT' => '"Dit sidste indl詒 var for %s sekunder siden.<br' . XHTML . '>Denne hjemmeside kr誚er mindst %s sekunder mellem hvert indl詒."',
    'ACCESSERROR' => 'ADGANG NニGTET',
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
    'msg05' => '<center><em>Beklager, der er endnu ikke lavet nogen emner.</em></center>',
    'msg07' => 'Brugere online:',
    'msg14' => 'Beklager, du har f蘰t forbud mod at poste indl詒.<br' . XHTML . '>',
    'msg15' => 'Hvis du mener at dette er en fejl, skal du kontakte <a href="mailto:%s?subject=Guestbook IP Ban">hjemmesidens Webmaster</a>.',
    'msg18' => 'Fejl! Ikke alle de kr誚ede felter er udfyldt eller ogser de for korte.',
    'msg19' => 'Dit indl詒 er blevet gemt.',
    'msg22' => '- Forum Indl詒 Advisering',
    'msg23a' => "Der er kommet et svar vedrende emnet '%s' af %s\n\nDette emne blev startet af: %s i %s forummet.\n",
    'msg23b' => "Et nyt emne '%s' er oprettet af %s i %s's forummer p%s hjemmesiden.\nDu kan se det her: %s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "\nDu kan se det her: %s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nFortsat god dag! \n",
    'msg26' => "\nDu modtager denne email fordi du har valgt at blive adviseret n蚌 der kommer et svar pdette emne. \n",
    'msg27' => 'Du kan stoppe adviseringen: <a href="%s">her</a>.',
    'msg33' => 'Forfatter: ',
    'msg36' => 'Hum:',
    'msg38' => "Advis駻 mig\n ved svar ",
    'msg40' => '<br' . XHTML . '>Beklager, men du har allerede bedt om at blive adviseret, n蚌 der kommer svar pdette emne.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">Du har for nuv誡ende ingen adviseringer.</p>',
    'msg49' => '(L誑t %s gange) ',
    'msg55' => 'Indl詒 slettet.',
    'msg56' => 'IP-adresse Forbudt.',
    'msg59' => 'Normalt Emne',
    'msg60' => 'Nyt Indl詒',
    'msg61' => 'Fastgjort Emne',
    'msg62' => 'Advis駻 mig ved svar',
    'msg64' => 'Er du sikker pat du vil slette Emne %s med titlen: %s ?',
    'msg65' => '<br' . XHTML . '>Dette er fste indl詒 i emnet, salle andre efterfgende indl詒 vil ogsblive slettet.',
    'msg68' => 'Bem誡k: VニR FORSIGTIG MED AT FORBYDE NOGEN, kun Adminstratorer kan oph誚e et forbud.',
    'msg69' => '<br' . XHTML . '>Vil du virkeligt forbyde IP-addressen: %s?',
    'msg71' => 'Ingen funktion valgt, v詬g et indl詒 og dern誑t en Moderator funktion.<br' . XHTML . '>Bem誡k: Du skal v誡e Moderator for at anvende disse funktioner.',
    'msg72' => 'Hvis dette indl詒 l誑es online, har du ikke ret til at udfe Moderator funktionen.',
    'msg74' => 'Nyeste %s Forum Indl詒',
    'msg75' => 'Top %s Emner Sorteret Efter L誑t',
    'msg76' => 'Top %s Emner Sorteret Efter Besvaret',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">Du burde ikke v誡e her!<br' . XHTML . '>Der er begr誅set adgang til Forummet.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>Du skal v誡e logget ind for at anvende denne Forum facilitet.</p>',
    'msg84' => 'Mark駻 alle emner l誑t',
    'msg85' => 'Side:',
    'msg86' => '&nbsp;Nyeste %s indl詒 af&nbsp;',
    'msg87' => '<br' . XHTML . '>Advarsel: Dette emne er l蚶t af en moderator.<br' . XHTML . '>Det er ikke tilladt at skrive nye poster for emnet',
    'msg88' => 'Brugere med Forum Aktivitet',
    'msg88b' => 'Forum Activity Only',
    'msg89' => 'Mine Aktiverede Adviseringer',
    'msg101' => 'Forum Regler:',
    'msg103' => 'Forum Skift:',
    'msg106' => 'V詬g et Forum',
    'msg108' => 'Normalt Forum',
    'msg109' => 'L蚶t Emne',
    'msg110' => 'Skifter til rettelse af indl詒..',
    'msg111' => 'Nye indl詒 siden dit sidste bes:',
    'msg112' => 'Se alle nye indl詒',
    'msg113' => 'Se nye indl詒',
    'msg114' => 'L蚶t Emne',
    'msg115' => 'Fastgjort Emne med Nye Indl詒',
    'msg116' => 'L蚶t Emne med Nye Indl詒',
    'msg117' => 'S i Alle',
    'msg118' => 'S i dette Forum',
    'msg119' => 'Forum Snings Resusltater for forspgsel:',
    'msg120' => 'Mest popul誡e indl詒 efter',
    'msg121' => 'Alle tider er %s. Klokken er nu %s.',
    'msg122' => 'Popul誡 Gr誅se:',
    'msg123' => 'Antal indl詒 f et emne betegnes som popul誡t',
    'msg126' => 'Se Linier:',
    'msg127' => 'Antal Linier der vises i se resultater',
    'msg128' => 'Brugere Pr. Side:',
    'msg129' => 'G詬der for oversigten over aktive brugere',
    'msg130' => 'Se Anonyme Indl詒:',
    'msg131' => 'Hvis du v詬ger Nej vil anonyme indl詒 ikke vises',
    'msg132' => 'Advis駻 Altid:',
    'msg133' => 'Hvis du v詬ger Ja vil du altid blive adviseret om svar<br' . XHTML . '>pemner du opretter eller besvarer',
    'msg134' => 'Advisering tilfet',
    'msg135' => 'Du vil nu blive adviseret, hver gang der kommer et nyt indl詒 i dette Forum.',
    'msg136' => 'Du skal v詬ge et Forum du vil adviseres om.',
    'msg137' => 'Advisering for emne aktiveret',
    'msg138' => '<b>F蚌 adviseringer for hele forummet</b>',
    'msg142' => 'Advisering gemt.',
    'msg144' => 'Retur til emne',
    'msg146' => 'Asvisering Slettet',
    'msg147' => 'Forum [udskriftsvenlig udgave af emne',
    'msg148' => 'Klik <a href="javascript:history.back()">HER</a> for at vende tilbage',
    'msg155' => 'Ingen indl詒 af bruger.',
    'msg156' => 'Samlet antal Forum indl詒',
    'msg157' => 'Nyeste 10 Forum indl詒',
    'msg158' => 'Nyeste 10 Forum indl詒 af ',
    'msg159' => 'Er du sikker pat du vil SLETTE de valgte Moderator poster?',
    'msg160' => 'Gtil Emnets sidste side',
    'msg163' => 'Indl詒 flyttet',
    'msg164' => 'Mark駻 alle Kategorier og Emner L誑t',
    'msg166' => 'FEJL: Ugyldigt Emne, eller Emne ikke fundet',
    'msg167' => 'Adviseringsvalg',
    'msg168' => 'Hvis du v詬ger Nej, deaktiverer du alle email adviseringer',
    'msg169' => 'Retur til Brugerliste',
    'msg170' => 'Nyeste Forum Indl詒',
    'msg171' => 'Forum Adgangs Fejl',
    'msg172' => 'Emne findes ikke. Muligvis er det slettet.',
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
    'PostReply' => 'Opret nyt svar',
    'PostTopic' => 'Opret nyt emne',
    'EditTopic' => 'Ret Emne',
    'quietforum' => 'Forum has no new topics'
);

$LANG_GF03 = array(
    'delete' => 'Slet Indl詒',
    'edit' => 'Ret Indl詒',
    'move' => 'Flyt Emne',
    'split' => 'Split Topic',
    'ban' => 'Forbyd IP-adresse',
    'movetopic' => 'Flyt Emne',
    'movetopicmsg' => '<br' . XHTML . '> Du kan flytte emnet <b>%s</b> til fgende forummer:',
    'splittopicmsg' => '<br' . XHTML . '>Create a new Topic with this post: "<b>%s</b>"<br' . XHTML . '><em>By:</em>&nbsp;%s&nbsp <em>On:</em>&nbsp;%s',
    'selectforum' => 'Select new forum:',
    'lockedpost' => 'Add Reply Post',
    'splitheading' => 'Split thread option:',
    'splitopt1' => 'Move all posts from this point',
    'splitopt2' => 'Move only this one post'
);

$LANG_GF04 = array(
    'label_forum' => 'Forum Profil',
    'label_location' => 'Sted',
    'label_aim' => 'AIM Navn',
    'label_yim' => 'YIM Navn',
    'label_icq' => 'ICQ Identitet',
    'label_msnm' => 'MSN Messenger Navn',
    'label_interests' => 'Interesser',
    'label_occupation' => 'Erhverv'
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
    'gfstats' => 'Forum Statistik',
    'statsmsg' => 'Her er de nuv誡ende statistikker for dit forum:',
    'totalcats' => 'Antal Kategorier:',
    'totalforums' => 'Antal Forummer:',
    'totaltopics' => 'Antal Emner:',
    'totalposts' => 'Antal Indl詒:',
    'totalviews' => 'Antal L誑t:',
    'avgpmsg' => 'Gennemsnitligt antal indl詒 pr.:',
    'category' => 'Kategori:',
    'forum' => 'Forum:',
    'topic' => 'Emne:',
    'avgvmsg' => 'Gennemsnitlig antal l誑t pr.:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Forum Indstillinger',
    'showiframe' => 'Vis Emne gennemsyn:',
    'showiframedscp' => 'Vis emne gennemsyn (i en ramme) i bunden ved svar pet indl詒',
    'topicspp' => 'Emner pr. Side:',
    'topicsppdscp' => 'Antallet af emner der skal vises pforum startsiden',
    'postspp' => 'Indl詒 per Side:',
    'postsppdscp' => 'Antallet af indl詒 der skal vises pr. side',
    'setsavemsg' => 'Indstillinger gemt.'
);

$LANG_GF93 = array(
    'gfboard' => 'Forum Administrator',
    'addcat' => 'Tilf Kategori',
    'addforum' => 'Tilf Forum',
    'catorder' => 'Kategori r詭kefge',
    'catadded' => 'Kategori tilfet.',
    'catdeleted' => 'Kategori slettet',
    'catedited' => 'Kategori slettet.',
    'forumadded' => 'Forum tilfet.',
    'forumaddError' => 'Fejl ved oprettelse af forum.',
    'forumdeleted' => 'Forum slettet',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum rettet',
    'forumordered' => 'Forum r詭kefge 誅dret',
    'back' => 'Tilbage',
    'addnote' => 'Bem誡k: Du kan rette disse v誡dier.',
    'editforumnote' => 'Ret Forum Detaljer for: <b>"%s"</b>',
    'deleteforumnote1' => 'リnsker du at slette forummet <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Alle emner under den vil ogsblive slettet.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Ret Kategori detaljer for: <b>"%s"</b>',
    'deletecatnote1' => 'リnsker du at slette kategorien <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Alle forummer og emner postet under denne kategori vil ogsblive slettet.',
    'undercat' => 'Under kategori',
    'groupaccess' => 'Gruppe Adgang: ',
    'action' => 'Handlinger',
    'forumdescription' => 'Forum Beskrivelse',
    'posts' => 'Indl詒',
    'ordertitle' => 'R詭kefge',
    'ModEdit' => 'Ret',
    'ModMove' => 'Flyt',
    'ModStick' => 'Fastg',
    'ModBan' => 'Forbyd',
    'addmoderator' => "Tilf\nModerator",
    'delmoderator' => " Slet\nValgte",
    'moderatorwarning' => '<b>Advarsel: Ingen forummer defineret</b><br' . XHTML . '><br' . XHTML . '>Opret Forum Kategorier og opret mindst 騁 forum<br' . XHTML . '>f du tilfer Moderatorer',
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
    'notyet' => 'Faciliteten findes endnu ikke',
    'delall' => 'Slet Alle',
    'delallmsg' => 'Er du sikker pat du vil slette alle indl詒 i: %s?',
    'underforum' => '<b>Under Forum: %s (ID #%s)',
    'moderate' => 'Moderatorfunktioner',
    'nomess' => 'Der er endnu ikke postet noget! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'IP-adresse Administration',
    'ban' => 'Forbyd',
    'noips' => 'Ingen IP-adresser er blevet forbudt endnu!',
    'unban' => 'Tillad',
    'ipbanned' => 'IP-addresse Forbudt',
    'banip' => 'Bekr詛t IP-adresse Forbud',
    'banipmsg' => 'Er du sikker pat du vil forbyde disse ip-adresser %s?',
    'specip' => 'V詬g hvilken IP-addresse du vil forbyde!',
    'ipunbanned' => 'IP-address Tilladt.',
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
