<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | norwegian.php                                                             |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |    casper                                                                 |
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
    'statslabel' => 'Antall innlegg i forumet',
    'statsheading1' => 'Forum Topp Ti Viste Emner',
    'statsheading2' => 'Forum Topp TI Besvarte Emner',
    'statsheading3' => 'Ingen emner � vise',
    'useradminmenu' => 'Forum Innstillinger',
    'access_denied' => 'Adgang nektet',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'Alle',
    'YES' => 'Ja',
    'NO' => 'Nei',
    'NEW' => 'Ny',
    'NEXT' => 'Neste',
    'ERROR' => 'Feil!',
    'CONFIRM' => 'Bekreft',
    'UPDATE' => 'Oppdater',
    'SAVE' => 'Lagre',
    'CANCEL' => 'Avbryt',
    'ON' => 'Tid: ',
    'ON2' => '&nbsp;&nbsp;<b>Den: </b>',
    'BY' => 'Av: ',
    'RE' => 'Sv: ',
    'DATE' => 'Dato',
    'VIEWS' => 'Visninger',
    'REPLIES' => 'Svar',
    'NAME' => 'Navn:',
    'DESCRIPTION' => 'Beskrivelse: ',
    'TOPIC' => 'Emne',
    'TOPICS' => 'Emner:',
    'TOPICSUBJECT' => 'Emnenavn',
    'HOMEPAGE' => 'Hjem',
    'SUBJECT' => 'Overskrift',
    'HELLO' => 'Hallo ',
    'MOVED' => 'Flyttet',
    'POSTS' => 'Innlegg',
    'LASTPOST' => 'Siste innlegg',
    'POSTEDON' => 'Skrevet den',
    'POSTEDBY' => 'Skrevet av',
    'PAGES' => 'Sider',
    'TODAY' => 'I dag ',
    'REGISTERED' => 'Registrert',
    'ORDERBY' => 'Sorter:&nbsp;',
    'ORDER' => 'Sorter:',
    'USER' => 'Bruker',
    'GROUP' => 'Gruppe',
    'ANON' => 'Anonym: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Author',
    'NOMOOD' => 'No Mood',
    'REQUIRED' => '[P�krevd]',
    'OPTIONAL' => '[Valgfritt]',
    'SUBMIT' => 'Send inn',
    'PREVIEW' => 'Forh�ndsvis',
    'REMOVE' => 'Fjern',
    'EDIT' => 'Endre',
    'DELETE' => 'Slett',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Valg:',
    'MISSINGSUBJECT' => 'Overskrift tom',
    'MIGRATE_NOW' => 'Migrer n�',
    'FILTERLIST' => 'Filtrer Liste',
    'SELECTFORUM' => 'Velg Forum',
    'DELETEAFTER' => 'Slett etterp�',
    'TITLE' => 'Tittel',
    'COMMENTS' => 'Kommentarer',
    'SUBMISSIONS' => 'Submissions',
    'HTML_FILTER_MSG' => 'Filtrert HTML Tillatt',
    'HTML_FULL_MSG' => 'Full HTML Tillatt',
    'HTML_MSG' => 'HTML Tillatt',
    'CENSOR_PERM_MSG' => 'Sensurert Innhold',
    'ANON_PERM_MSG' => 'Vis Anonyme Innlegg',
    'POST_PERM_MSG1' => 'Kan skrive',
    'POST_PERM_MSG2' => 'Anonyme brukere kan skrive',
    'GO' => 'G�',
    'STATUS' => 'Status:',
    'ONLINE' => 'online',
    'OFFLINE' => 'offline',
    'back2parent' => 'Hovedemne',
    'forumname' => '',
    'category' => 'Kategori: ',
    'loginreqview' => '<b>Du m� %s registrere deg</a> eller %s logge inn </a> for � lese i forumet</b>',
    'loginreqpost' => '<b>Du m� registrere deg eller logge inn for � skrive i forumet</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Ingen.',
    'back2top' => 'Til toppen',
    'TEXTMODE' => 'Tekstmodus:',
    'HTMLMODE' => 'HTML-modus:',
    'TopicPreview' => 'Forh�ndsvisning',
    'moderator' => 'Moderator',
    'admin' => 'Admin',
    'DATEADDED' => 'Dato lagt til',
    'PREVTOPIC' => 'Forrige&nbsp;emne',
    'NEXTTOPIC' => 'Neste&nbsp;emne',
    'RESYNC' => 'ReSynkroniser',
    'RESYNCCAT' => 'ReSynkroniser Category Forums',
    'EDITICON' => 'Endre',
    'QUOTEICON' => 'Sit�r',
    'ProfileLink' => 'Profil',
    'WebsiteLink' => 'Webside',
    'PMLink' => 'PM',
    'EmailLink' => 'Email',
    'FORUMSUBSCRIBE' => 'Abbonner p� dette forumet',
    'FORUMUNSUBSCRIBE' => 'Stopp abbonnement',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => 'Nytt&nbsp;Emne',
    'POSTREPLY' => 'Skriv&nbsp;Svar',
    'SubscribeLink' => 'Abbonner',
    'unSubscribeLink' => 'Stopp Abbonnement',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => 'Varslinger',
    'TOP' => 'Til toppen',
    'PRINTABLE' => 'Utskriftsvennlig',
    'USERPREFS' => 'Forum innstillinger',
    'SPEEDLIMIT' => '"Ditt siste innlegg var for %s sekunder siden.<br' . XHTML . '>Systemet krever minst %s sekunder mellom innlegg."',
    'ACCESSERROR' => 'ADGANGSFEIL',
    'ACTIONS' => 'Handlinger',
    'DELETEALL' => 'Slett alle valgte',
    'DELCONFIRM' => 'Er du sikker p� � slette alle valgte?',
    'DELALLCONFIRM' => 'Er du sikker p� � slette alle valgte?',
    'STARTEDBY' => 'Startet av:',
    'WARNING' => 'Advarsel',
    'MODERATED' => 'Moderatorer: %s',
    'LASTREPLYBY' => 'Siste svar av:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Forum forsiden',
    'FEATURE' => 'Funksjon',
    'SETTING' => 'Innstilling',
    'MARKALLREAD' => 'Merk alle som lest',
    'MSG_NO_CAT' => 'No Categories or Forums Defined',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Kode',
    'FONTCOLOR' => 'Font farge',
    'FONTSIZE' => 'Font st�rrelse',
    'CLOSETAGS' => 'Lukk tagger',
    'CODETIP' => 'Tips: Stiler kan raskt legges til valgt tekst',
    'TINY' => 'X-Liten',
    'SMALL' => 'Liten',
    'NORMAL' => 'Normal',
    'LARGE' => 'Stor',
    'HUGE' => 'X-Stor',
    'DEFAULT' => 'Standard',
    'DKRED' => 'M�rk r�d',
    'RED' => 'Rod',
    'ORANGE' => 'Oransj',
    'BROWN' => 'Brun',
    'YELLOW' => 'Gul',
    'GREEN' => 'Gr�nn',
    'OLIVE' => 'Oliven',
    'CYAN' => 'Cyan',
    'BLUE' => 'Bl�',
    'DKBLUE' => 'M�rk Bl�',
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Fiolett',
    'WHITE' => 'Hvit',
    'BLACK' => 'Svart',
    'b_help' => 'Fet skrift: [b]tekst[/b]',
    'i_help' => 'Skr�stillt skrift: [i]tekst[/i]',
    'u_help' => 'Underlinjer skrift: [u]tekst[/u]',
    'q_help' => 'Siter tekst: [quote]tekst[/quote]',
    'c_help' => 'Vis kode: [code]kode[/code]',
    'l_help' => 'Liste: [list]tekst[/list]',
    'o_help' => 'Ordnet liste: [olist]tekst[/olist]',
    'p_help' => '[img]http://bilde_url[/img]  eller [img w=100 h=200][/img]',
    'w_help' => 'Sett inn URL: [url]http://url[/url] eller [url=http://url]URL tekst[/url]',
    'a_help' => 'Lukk alle �pne bbKode tagger',
    's_help' => 'Skriftfarge: [color=red]tekst[/color]  Tips: du kan ogs� bruke color=#FF0000',
    'f_help' => 'Skriftst�rrelse: [size=x-small]small tekst[/size]',
    'h_help' => 'Klikk for � vise mer detaljert hjelp'
);

$LANG_GF02 = array(
    'msg01' => 'Du m� v�re registrert for � bruke forumet',
    'msg02' => 'Her skulle du ikke v�rt!<br' . XHTML . '>Begrenset adgang til dette forumet',
    'msg03' => 'Please wait while you are redirected',
    'msg05' => '<center><em>Beklager, ingen emner er satt opp enn�.</em></center>',
    'msg07' => 'Online brukere:',
    'msg14' => 'Du er sperret fra � lage innlegg.<br' . XHTML . '>',
    'msg15' => 'Om du mener dette er feil, kontakt <A HREF="mailto:%s?subject=Forum IP Ban">Webmaster</A>.',
    'msg18' => 'Feil! Alle felt er ikke fylt i, elle er for korte i lengde.',
    'msg19' => 'Ditt innlegg er postet.',
    'msg22' => '- Forumvarsel',
    'msg23a' => "Et svar er skrevet i tr�den '%s' av %s.\n\nInnlegget ble startet av %s i emnet %s . ",
    'msg23b' => "Et nytt innlegg '%s' er postet av %s i emnet %s p� %s webside. Du kan vise det her:\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "Du kan vise det her:\n%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nHa en str�lende dag! \n",
    'msg26' => "\nDu mottar denne mailen fordi du har valgt � bli varslet n�r et svar har blitt skrevet i denne tr�den. ",
    'msg27' => "For � stoppe mottak av varsler g� til <%s> for � fjerne varsling.\n",
    'msg33' => 'Av: ',
    'msg36' => 'Mood:',
    'msg38' => 'Varsle svar ',
    'msg40' => '<br' . XHTML . '>Du har allerde bedt om varsling p� dette emnet.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">Du har ingen varslinger.</p>',
    'msg49' => '(Vist %s ganger) ',
    'msg55' => 'Innlegg Slettet.',
    'msg56' => 'IP Banned.',
    'msg59' => 'Normalt Emne',
    'msg60' => 'Nytt Innlegg',
    'msg61' => 'Prioritert Emne',
    'msg62' => 'Varsle meg ved svar',
    'msg64' => 'Er du sikker p� at du vil slette emnet %s med navn: %s ?',
    'msg65' => '<br' . XHTML . '>Dette er hovedinnlegget, s� alle svar vil ogs� bli slettet.',
    'msg68' => 'Note: BE CAREFUL WHEN YOU BAN, only admins have the rights to unban someone.',
    'msg69' => 'Do you really want to ban the ip address: %s?',
    'msg71' => 'No function selected, choose a post and then a moderator function.<br' . XHTML . '>Note: You must be a moderator to perform these functions.',
    'msg72' => 'Warning, you do not have rights to perform this moderation function.',
    'msg74' => 'Siste %s Foruminnlegg',
    'msg75' => 'Topp %s Emner Etter Visninger',
    'msg76' => 'Topp %s Emner Etter Innlegg',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">Her skulle du ikke v�rt!<br' . XHTML . '>Begrenset adgang til dette emnet.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>Du m� v�re logget inn for � bruke denne forumfunksjonen.</p>',
    'msg84' => 'Merk alle emner som lest',
    'msg85' => 'Side:',
    'msg86' => '&nbsp;Siste %s innlegg&nbsp;',
    'msg87' => '<br' . XHTML . '>Advarsel: Dette emnet er l�st.<br' . XHTML . '>Ingen fler innlegg er mulig',
    'msg88' => 'Registrete brukere',
    'msg88b' => 'Kun forumaktivitet',
    'msg89' => 'Mine varslinger',
    'msg101' => 'Forum Regler:',
    'msg103' => 'Forum Valg:',
    'msg106' => 'Velg et Forum',
    'msg108' => 'Aktivt Emne',
    'msg109' => 'L�st Emne',
    'msg110' => 'Overf�rer til endringssiden..',
    'msg111' => 'Nye innlegg siden ditt forrige bes�k',
    'msg112' => 'Vis alle nye innlegg',
    'msg113' => 'Vis nye innlegg',
    'msg114' => 'L�st Emne',
    'msg115' => 'Prioritert emne med nytt innlegg',
    'msg116' => 'L�st emne med nytt innlegg',
    'msg117' => 'S�k Alle',
    'msg118' => 'S�k i denne kategorien',
    'msg119' => 'S�keresultat for foresp�rselen:',
    'msg120' => 'Mest popul�re innlegg',
    'msg121' => 'Alle tider er %s. Tiden er n� %s.',
    'msg122' => 'Popul�r Begrensning:',
    'msg123' => 'Antall innlegg f�r emnet skal kalles popul�rt',
    'msg126' => 'S�kelinjer:',
    'msg127' => 'Antall linjer � vise pr side i s�keresultat',
    'msg128' => 'Medlemmer pr side:',
    'msg129' => 'For medlemslisting',
    'msg130' => 'Vis Innlegg fra Anonyme:',
    'msg131' => 'Ved � velge Nei blir anonyme brukere filtrert vekk',
    'msg132' => 'Alltid varsle:',
    'msg133' => 'Ved � velge Ja vil automatisk varsling bli aktivert for alle innlegg du skriver',
    'msg134' => 'Abbonnering lagt til',
    'msg135' => 'Du blir n� varlset om alle innlegg i denne kategorien.',
    'msg136' => 'Du m� velge kategori � abbonnere p�.',
    'msg137' => 'Varsling for kategori aktivert',
    'msg138' => '<b>Varsling for komplett forum</b>',
    'msg142' => 'Varlsing lagret.',
    'msg144' => 'Returner til emne',
    'msg146' => 'Varlsing slettet',
    'msg147' => 'Forum [utskriftsvennlig versjon av emnet',
    'msg148' => 'Klikk <a href="javascript:history.back()">HER</a> for � returnere',
    'msg155' => 'Ingen brukerinnlegg.',
    'msg156' => 'Totalt antall foruminnlegg',
    'msg157' => 'Siste 10 Foruminnlegg',
    'msg158' => 'Siste 10 Foruminnlegg av ',
    'msg159' => 'Er du sikker p� at du �nsker � slette valge moderatoroppf�ringer?',
    'msg160' => 'Vis siste side av emnet',
    'msg163' => 'Innlegg flyttet',
    'msg164' => 'Merk alle kategorier og emner som lest',
    'msg166' => 'FEIL: Ygyldig eller ikke funnet emne',
    'msg167' => 'Varslingsvalg',
    'msg168' => 'Ved � velge Nei vil du deaktivere emailvarslinger',
    'msg169' => 'Returner til medlemsliste',
    'msg170' => 'Siste foruminnlegg',
    'msg171' => 'Forum Adgangsfeil',
    'msg172' => 'Emnet eksisterer ikke. Det kan v�re slettet',
    'msg173' => 'Overf�rer til innleggsmeldingsside..',
    'msg174' => 'Unable to BAN Member - Invalid or Empty IP Address',
    'msg175' => 'Returner til Forumlisting',
    'msg176' => 'Velg medlem',
    'msg177' => 'Alle Medlemmer',
    'msg178' => 'Kun Hovedinnlegg',
    'msg179' => 'Innhold generert p�: %s sekunder',
    'msg180' => 'Forum Innleggsvarsel',
    'msg181' => 'Du har ikke adgang til andre kategorier som moderator',
    'msg182' => 'Moderatorbekreftelse',
    'msg183' => 'Nytt emne ble lagd fra dette innlegget i kategorien: %s',
    'msg184' => 'Varsle kun en gang',
    'msg185' => 'Varsling blir kun sendt en gang for kategorier og innlegg selvom det har flere innlegg siden ditt siste bes�k.',
    'msg186' => 'Nytt emne Tittel',
    'msg187' => 'Returner til emne - klikk <a href="%s">her</a>',
    'msg188' => 'Klikk for � g� direkte til siste innlegg',
    'msg189' => 'Feil: Du kan ikke endre dette innlegget lenger',
    'msg190' => 'Stille endring',
    'msg191' => 'Endring ikke tillatt. Tillatt tid for endring er utl�pt eller du trenger moderatorrettigheter',
    'msg192' => 'Ferdig ... Migrert %s emner og %s innlegg.',
    'msg193' => 'STORY&nbsp;&nbsp;TO&nbsp;&nbsp;FORUM&nbsp;&nbsp;MIGRATION&nbsp;&nbsp;UTILITY',
    'msg194' => 'Vanlig Emne',
    'msg195' => 'Klikk for � hoppe til Kategori',
    'msg196' => 'Vis forumforsiden',
    'msg197' => 'Merk emner i alle kategorier som lest',
    'msg198' => 'Oppdater foruminstillinger',
    'msg199' => 'Vis eller slett varslinger',
    'msg200' => 'Vis meldemsrapport',
    'msg201' => 'Vis rapport over popul�re emner',
    'msg202' => 'No new posts',
    'msg300' => 'Your preferences have block anonymous posts enabled',
    'msg301' => 'Realy mark all categories read?',
    'msg302' => 'Realy mark all topics read?',
    'PostReply' => 'Skriv svar',
    'PostTopic' => 'Nytt emne',
    'EditTopic' => 'Endre emne',
    'quietforum' => 'Forumet har ingen nye emner'
);

$LANG_GF03 = array(
    'delete' => 'Slett',
    'edit' => 'Endre',
    'move' => 'Flytt',
    'split' => 'Splitt',
    'ban' => 'Ban IP',
    'movetopic' => 'Flytt emne',
    'movetopicmsg' => '<br' . XHTML . '>Emne som flyttes: "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>Lag nytt emne med dette innlegget: "<b>%s</b>"<br' . XHTML . '><em>Av:</em>&nbsp;%s&nbsp <em>Den:</em>&nbsp;%s',
    'selectforum' => 'Velg nytt forum:',
    'lockedpost' => 'Legg til svar',
    'splitheading' => 'Splitt tr�dvalg:',
    'splitopt1' => 'Flytt alle innlegg fra her',
    'splitopt2' => 'Flytt bare dentte innlegget'
);

$LANG_GF04 = array(
    'label_forum' => 'Faktaboks',
    'label_location' => 'Bosted',
    'label_aim' => 'F�dt',
    'label_yim' => 'Sivilstatus',
    'label_icq' => 'ICQ Identity',
    'label_msnm' => 'MS Messenger Name',
    'label_interests' => 'Interests',
    'label_occupation' => 'Yrke'
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
    1 => 'Statistikk',
    2 => 'Innstilling',
    3 => 'Forums',
    4 => 'Moderator',
    5 => 'Convert',
    6 => 'Messages',
    7 => 'IP Mgmt'
);

$LANG_GF07 = array(
    1 => 'Vis Forum',
    2 => 'Innstillinger',
    3 => 'Popul�re emner',
    4 => 'Varslinger',
    5 => 'Medlemmer'
);

$LANG_GF08 = array(
    1 => 'Emnevarslinger',
    2 => 'F�lg forumvarslinger',
    3 => 'Ekskluderte emnevarslinger'
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
    'gfstats' => 'Forumstatistikk',
    'statsmsg' => 'Dette er n�v�rende statistikk for forumet:',
    'totalcats' => 'Totalt Kategorier:',
    'totalforums' => 'Totalt Forum:',
    'totaltopics' => 'Totalt Emner:',
    'totalposts' => 'Totalt Innlegg:',
    'totalviews' => 'Totalt Vist:',
    'avgpmsg' => 'Snitt innlegg pr:',
    'category' => 'Kategori:',
    'forum' => 'Forum:',
    'topic' => 'Emne:',
    'avgvmsg' => 'Snitt visninger pr:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Foruminnstillinger',
    'showiframe' => 'Vis emnesammendrag',
    'showiframedscp' => 'Vis emnesammendrag (Iframe) i bunn n�r det skrives svar',
    'topicspp' => 'Emner pr side',
    'topicsppdscp' => 'Antall emner som vises pr side p� forsiden',
    'postspp' => 'Innlegg pr side',
    'postsppdscp' => 'Antall innlegg som vises pr side',
    'setsavemsg' => 'Innstillinger lagret.'
);

$LANG_GF93 = array(
    'gfboard' => 'Forum Admin',
    'addcat' => 'Legg til hovedkategori',
    'addforum' => 'Legg til kategori',
    'catorder' => 'Kategorirekkef�lge',
    'catadded' => 'Kategori lagt til.',
    'catdeleted' => 'Kategori slettet',
    'catedited' => 'Kategori endret.',
    'forumadded' => 'Forum lagt til.',
    'forumaddError' => 'Feil ved � legge til forum.',
    'forumdeleted' => 'Forum slettet',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum endret',
    'forumordered' => 'Forumrekkef�lge endret',
    'back' => 'Tilbake',
    'addnote' => 'Merk: Du kan endre disse verdiene.',
    'editforumnote' => 'Endre forumdetaljer for: <b>"%s"</b>',
    'deleteforumnote1' => 'Vil du slette forumet <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Alle emner skrevet blir ogs� slettet.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Endre kategoridetaljer for: <b>"%s"</b>',
    'deletecatnote1' => 'Vil du slette kategorien <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Alle kategorier og emner under dette forumet blir ogs� slettet.',
    'undercat' => 'Underkategori',
    'groupaccess' => 'Gruppeaksess: ',
    'action' => 'Handlinger',
    'forumdescription' => 'Forumbeskrivelse',
    'posts' => 'Innlegg',
    'ordertitle' => 'Rekkef�lge',
    'ModEdit' => 'Endre',
    'ModMove' => 'Flytt',
    'ModStick' => 'Stick',
    'ModBan' => 'Ban',
    'addmoderator' => 'Add Record',
    'delmoderator' => " Delete\nSelected",
    'moderatorwarning' => '<b>Warning: No Forums Defined</b><br' . XHTML . '><br' . XHTML . '>Setup Forum Categories and Add at least 1 forum<br' . XHTML . '>before attempting to add Modertators',
    'private' => 'Privat Forum',
    'filtertitle' => 'Velg moderatoroppf�ringer � vise',
    'addmessage' => 'Legg til ny Moderator',
    'allowedfunctions' => 'Tillatte funksjoner',
    'userrecords' => 'Brukeroppf�ringer',
    'grouprecords' => 'Gruppeoppf�ringer',
    'filterview' => 'Filtrer visning',
    'readonly' => 'KunLes Forum',
    'readonlydscp' => 'Kun Moderator kan skrive i dette forumet',
    'hidden' => 'Skjult Forum',
    'hiddendscp' => 'Forum vises ikke p� forumforsiden',
    'hideposts' => 'Skjul nye innlegg',
    'hidepostsdscp' => 'Oppdateringer vises ikke i blokker eller RSS Feeds',
    'mod_title' => 'Forum Moderatorer',
    'allforums' => 'Alle Forum'
);

$LANG_GF95 = array(
    'header1' => 'Innlegg',
    'header2' => 'Innlegg for forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Feature has not been implemented yet',
    'delall' => 'Slett Alle',
    'delallmsg' => 'Vil du slette alle innlegg fra: %s?',
    'underforum' => '<b>Under Forum: %s (ID #%s)',
    'moderate' => 'Moderer',
    'nomess' => 'Ingen innlegg er skrevet enn�! '
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
