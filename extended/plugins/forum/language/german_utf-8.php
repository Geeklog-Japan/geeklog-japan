<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | german_utf-8.php                                                          |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 200? by the following authors:                              |
// |    Dirk Haun        dirk AT haun-online DOT de                            |
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
    'statslabel' => 'Gesamte Forenbeiträge',
    'statsheading1' => 'Forum Top10 der aufgerufenen Themen',
    'statsheading2' => 'Forum Top10 der beantworteten Themen',
    'statsheading3' => 'Keine Themen zum Report',
    'useradminmenu' => 'Forum-Einstellungen',
    'access_denied' => 'Zugriff verweigert',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'All',
    'YES' => 'Ja',
    'NO' => 'Nein',
    'NEW' => 'Neu',
    'NEXT' => 'weiter',
    'ERROR' => 'Fehler!',
    'CONFIRM' => 'Bestätigen',
    'UPDATE' => 'Update',
    'SAVE' => 'Sichern',
    'CANCEL' => 'Abbruch',
    'ON' => 'Am: ',
    'ON2' => '&nbsp;&nbsp;<b>Am: </b>',
    'BY' => 'Von: ',
    'RE' => 'Re: ',
    'DATE' => 'Datum',
    'VIEWS' => 'Gelesen',
    'REPLIES' => 'Antworten',
    'NAME' => 'Name:',
    'DESCRIPTION' => 'Beschreibung: ',
    'TOPIC' => 'Thema',
    'TOPICS' => 'Themen',
    'TOPICSUBJECT' => 'Betreff',
    'HOMEPAGE' => 'Home',
    'SUBJECT' => 'Betreff',
    'HELLO' => 'Hallo ',
    'MOVED' => 'Verschoben',
    'POSTS' => 'Beiträge',
    'LASTPOST' => 'Letzter Beitrag',
    'POSTEDON' => 'Geschrieben am',
    'POSTEDBY' => 'Geschrieben von',
    'PAGES' => 'Seiten',
    'TODAY' => 'Heute um ',
    'REGISTERED' => 'Mitglied seit',
    'ORDERBY' => 'Sortieren nach:&nbsp;',
    'ORDER' => 'Order:',
    'USER' => 'User',
    'GROUP' => 'Group',
    'ANON' => 'Gast: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Autor',
    'NOMOOD' => 'Keine Stimmung',
    'REQUIRED' => '[benötigt]',
    'OPTIONAL' => '[optional]',
    'SUBMIT' => 'Abschicken',
    'PREVIEW' => 'Vorschau',
    'REMOVE' => 'Löschen',
    'EDIT' => 'Ändern',
    'DELETE' => 'Löschen',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Optionen:',
    'MISSINGSUBJECT' => 'Leerer Betreff',
    'MIGRATE_NOW' => 'Migrate Now',
    'FILTERLIST' => 'Gefiltertes',
    'SELECTFORUM' => 'Select Forum',
    'DELETEAFTER' => 'Delete after',
    'TITLE' => 'Title',
    'COMMENTS' => 'Kommentare',
    'SUBMISSIONS' => 'Submissions',
    'HTML_FILTER_MSG' => 'Gefiltertes HTML erlaubt',
    'HTML_FULL_MSG' => 'Alle HTML-Tags erlaubt',
    'HTML_MSG' => 'HTML erlaubt',
    'CENSOR_PERM_MSG' => 'Beiträge "entschärfen"',
    'ANON_PERM_MSG' => 'Beiträge von Gästen',
    'POST_PERM_MSG1' => 'Schreiben erlaubt',
    'POST_PERM_MSG2' => 'Gäste können schreiben',
    'GO' => 'los',
    'STATUS' => 'Status:',
    'ONLINE' => 'online',
    'OFFLINE' => 'offline',
    'back2parent' => 'Parent Topic',
    'forumname' => '',
    'category' => 'Kategory: ',
    'loginreqview' => '<b>Sorry you must %s register</a> or %s login </a> to use these forums</b>',
    'loginreqpost' => '<b>Sorry you must register or login to post on these forums</b>',
    'nolastpostmsg' => 'n/v',
    'no_one' => 'No one.',
    'back2top' => 'Back to top',
    'TEXTMODE' => 'Text-Modus',
    'HTMLMODE' => 'HTML-Modus',
    'TopicPreview' => 'Vorschau',
    'moderator' => 'Moderator',
    'admin' => 'Admin',
    'DATEADDED' => 'Hinzugefügt',
    'PREVTOPIC' => 'Vorheriges Thema',
    'NEXTTOPIC' => 'Nächstes Thema',
    'RESYNC' => 'ReSync',
    'RESYNCCAT' => 'ReSync Category Forums',
    'EDITICON' => 'Ändern',
    'QUOTEICON' => 'Zitat',
    'ProfileLink' => 'Profil',
    'WebsiteLink' => 'Website',
    'PMLink' => 'PM',
    'EmailLink' => 'E-Mail',
    'FORUMSUBSCRIBE' => 'Forum abonnieren',
    'FORUMUNSUBSCRIBE' => 'Forum-Abo beenden',
    'FORUMSUBSCRIBE_TRUE' => 'Abonnieren:Aktiviert',
    'FORUMSUBSCRIBE_FALSE' => 'Abonnieren:Behinderte',
    'NEWTOPIC' => 'Neues Thema',
    'POSTREPLY' => 'Antwort schreiben',
    'SubscribeLink' => 'Abonnieren',
    'unSubscribeLink' => 'Abo beenden',
    'SubscribeLink_TRUE' => 'Abonnieren:Aktiviert',
    'SubscribeLink_FALSE' => 'Abonnieren:Behinderte',
    'SUBSCRIPTIONS' => 'Abonnements',
    'TOP' => 'Top of Post',
    'PRINTABLE' => 'Druckfähige Version',
    'USERPREFS' => 'Forum-Einstellungen',
    'SPEEDLIMIT' => '"Your last comment was %s seconds ago.<br' . XHTML . '>This site requires at least %s seconds between forum posts."',
    'ACCESSERROR' => 'ACCESS ERROR',
    'ACTIONS' => 'Aktionen',
    'DELETEALL' => 'Alle ausgewählten Einträge löschen',
    'DELCONFIRM' => 'Bist Du sicher, dass Du die ausgewählten Einträge löschen willst?',
    'DELALLCONFIRM' => 'Bist Du sicher, dass Du ALLE ausgewählten Einträge löschen willst?',
    'STARTEDBY' => 'Begonnen von ',
    'WARNING' => 'Warnung',
    'MODERATED' => 'Moderatoren: %s',
    'LASTREPLYBY' => 'Letzter Beitrag von:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Alle Foren',
    'FEATURE' => 'Feature',
    'SETTING' => 'Einstellung',
    'MARKALLREAD' => 'Als gelesen markieren',
    'MSG_NO_CAT' => 'No Categories or Forums Defined',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Code',
    'FONTCOLOR' => 'Schriftfarbe',
    'FONTSIZE' => 'Schriftgröße',
    'CLOSETAGS' => 'Tags schließen',
    'CODETIP' => 'Tip: Styles can be applied quickly to selected text',
    'TINY' => 'Winzig',
    'SMALL' => 'Klein',
    'NORMAL' => 'Normal',
    'LARGE' => 'Groß',
    'HUGE' => 'Riesig',
    'DEFAULT' => 'Standard',
    'DKRED' => 'Dunkelrot',
    'RED' => 'Rot',
    'ORANGE' => 'Orange',
    'BROWN' => 'Braun',
    'YELLOW' => 'Gelb',
    'GREEN' => 'Grün',
    'OLIVE' => 'Olive',
    'CYAN' => 'Cyan',
    'BLUE' => 'Blau',
    'DKBLUE' => 'Dunkelblau',
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Lila',
    'WHITE' => 'Weiß',
    'BLACK' => 'Schwarz',
    'b_help' => 'Fettschrift: [b]text[/b]',
    'i_help' => 'Schräg gestellt: [i]text[/i]',
    'u_help' => 'Unterstrichen: [u]text[/u]',
    'q_help' => 'Zitat: [quote]text[/quote]',
    'c_help' => 'Quelltext: [code]code[/code]',
    'l_help' => 'Liste: [list]text[/list]',
    'o_help' => 'Nummerierte Liste: [olist]text[/olist]',
    'p_help' => '[img]http://image_url[/img] oder [img w=100 h=200][/img]',
    'w_help' => 'URL: [url]http://url[/url] or [url=http://url]URL text[/url]',
    'a_help' => 'Alle offenen BBcode-Tags schließen',
    's_help' => 'Schriftfarbe: [color=red]text[/color]  Tipp: Du kannst auch color=#FF0000 benutzen',
    'f_help' => 'Schriftgröße: [size=7]small text[/size]',
    'h_help' => 'Ausführliche Hilfe'
);

$LANG_GF02 = array(
    'msg01' => 'Sorry you must register to use these forums',
    'msg02' => 'You should not be here!<br' . XHTML . '>Restricted access to this forum only',
    'msg03' => 'Please wait while you are redirected',
    'msg05' => '<center><em>Sorry, es wurden noch keine Themen erstellt.</center></em>',
    'msg07' => 'Wer ist online?',
    'msg14' => 'Sorry, Du wurdest vom Erstellen von Einträgen verbannt.<br' . XHTML . '>',
    'msg15' => 'Wenn Du glaubst das sei falsch, kontaktiere den <a href="mailto:%s?subject=Gästebuch IP-Bann">Site Admin</a>.',
    'msg18' => 'Fehler! Es wurden nicht alle benötigten Felder ausgefüllt oder die Einträge waren zu kurz.',
    'msg19' => 'Dein Beitrag wurde veröffentlicht.',
    'msg22' => '- Neuer Beitrag im Forum',
    'msg23a' => "Zum Thema '%s' hat %s eine Antwort geschrieben.\n\nDas Thema wurde von %s im %s-Forum begonnen. ",
    'msg23b' => "Ein neues Thema, '%s', wurde von %s im %s-Forum auf der %s-Website begonnen. Du kannst den Beitrag hier lesen:\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "Du kannst den Beitrag hier lesen:\n%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nViel Spaß,\n",
    'msg26' => "\nDu bekommst diese E-Mail, da Du die Benachrichtigung für dieses Thema aktiviert hast. ",
    'msg27' => "Deine Benachrichtigungen kannst Du unter <%s> löschen.\n",
    'msg33' => 'Autor: ',
    'msg36' => 'Stimmung:',
    'msg38' => 'Bei Antworten benachrichtigen ',
    'msg40' => '<br' . XHTML . '>Sorry, aber Du hast schon eingestellt, dass Dir Antworten auf dieses Thema mitgeteilt werden.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">Du hast keine Benachrichtigungen aktiviert.</p>',
    'msg49' => '(%s Mal gelesen) ',
    'msg55' => 'Beitrag gelöscht.',
    'msg56' => 'IP gebannet.',
    'msg59' => 'Normales Thema',
    'msg60' => 'Neuer Beitrag',
    'msg61' => 'Wichtiges Thema',
    'msg62' => 'Benachrichtigung bei neuen Beiträgen',
    'msg64' => 'Bist Du sicher, dass Du das Thema %s mit dem Title: %s löschen willst?',
    'msg65' => '<br' . XHTML . '>Dies ist ein Grundsatzthema. Also werden alle Antworten, die hier gepostet werden, gelöscht.',
    'msg68' => 'Notiz: Beachte, WENN DU GEBANNT BIST können Dich nur Administratoren entbannen.',
    'msg69' => '<br' . XHTML . '>Bist Du wirklich sicher, dass Du die IP-Addresse %s bannen willst?',
    'msg71' => 'Keine Funktion gewählt. Wähle einen Eintrag und dann eine Moderatorfunktion.<br' . XHTML . '>Notiz: Du musst Moderator sein um diese Funktion zu ändern.',
    'msg72' => 'Sobald diese Nachricht online ist hast Du keine Rechte mehr die Funktion der Moderation durchzuführen.',
    'msg74' => 'Die %s letzten Forumsbeitr',
    'msg75' => 'Top %s Themen nach Aufrufe',
    'msg76' => 'Top %s Themen nach Beiträgen',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">You should not be here!<br' . XHTML . '>Restricted access to this forum only.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '><p>You need to be signed in to use this forum feature.</p>',
    'msg84' => 'Alle Themen als gelesen markieren',
    'msg85' => 'Seite:',
    'msg86' => '&nbsp;Letzte %s Beiträge&nbsp;',
    'msg87' => '<br' . XHTML . '>Warning: This topic has been locked by the moderator.<br' . XHTML . '>No additional posts are permitted',
    'msg88' => 'Mitglieder',
    'msg88b' => 'Nur im Forum aktive Mitglieder',
    'msg89' => 'Meine Benachrichtigungen',
    'msg101' => 'Forumrichtlinien:',
    'msg103' => 'Zum Forum:',
    'msg106' => 'Forum wählen',
    'msg108' => 'Aktives Forum',
    'msg109' => 'Thema geschlossen',
    'msg110' => 'Transferring to message edit page..',
    'msg111' => 'Neue Beiträge seit Deinem letzten Besuch',
    'msg112' => 'Alle neuen Beiträge anzeigen',
    'msg113' => 'Neue Beiträge anzeigen',
    'msg114' => 'Thema geschlossen',
    'msg115' => 'Wichtiges Thema mit neuen Beiträgen',
    'msg116' => 'Geschlossenes Thema mit neuen Beiträgen',
    'msg117' => 'Suchen',
    'msg118' => 'Im Forum Suchen',
    'msg119' => 'Ergebnisse für die Suche nach:',
    'msg120' => 'Beliebteste Themen, sortiert nach',
    'msg121' => 'Zeitzone: %s. Es ist jetzt %s Uhr.',
    'msg122' => 'Beliebtheits-Limit',
    'msg123' => 'Anzahl Beiträge, ab denen ein Thema als beliebt gilt',
    'msg126' => 'Suchergebnisse',
    'msg127' => 'Anzahl Zeilen im Suchergebnis',
    'msg128' => 'Mitglieder pro Seite',
    'msg129' => 'Für die Mitglieder-Liste',
    'msg130' => 'Beiträge von Gästen',
    'msg131' => 'Beiträge von nicht-angemeldeten Usern zeigen?',
    'msg132' => 'Immer benachrichtigen',
    'msg133' => 'Automatische Benachrichtigung für alle Themen, die ich beginne oder kommentiere?',
    'msg134' => 'Abonnement zugefügt',
    'msg135' => 'Du wirst nun über alle Beiträge in diesem Forum benachrichtigt.',
    'msg136' => 'Du musst ein Forum wählen um es zu abonnieren.',
    'msg137' => 'Benachrichtigung für Thema aktiviert',
    'msg138' => '<b>Ganzes Forum abonniert</b>',
    'msg142' => 'Benachrichtigung gespeichert.',
    'msg144' => 'Zurück zum Thema',
    'msg146' => 'Löschung erfolgreich',
    'msg147' => 'Forum [druckbare Version des Themas %s]',
    'msg148' => '<a href="javascript:history.back()">Zurück.</a>',
    'msg155' => 'Keine Forums-Beiträge.',
    'msg156' => 'Gesamtanzahl Forums-Beiträge',
    'msg157' => 'Die letzten 10 Forums-Beiträge',
    'msg158' => 'Die letzten 10 Forums-Beiträge von ',
    'msg159' => 'Are you sure you want to DELETE these selected Moderator records?',
    'msg160' => 'View last page of topic',
    'msg163' => 'Post moved',
    'msg164' => 'Mark all Categories and Topics Read',
    'msg166' => 'ERROR: Invalid topic or Topic not found',
    'msg167' => 'Notification Option',
    'msg168' => 'Setting of No will disable email notifictions',
    'msg169' => 'Return to Members listing',
    'msg170' => 'Aktuelle Themen im Forum',
    'msg171' => 'Forum Access Error',
    'msg172' => 'Topic does not exist. It possibly has been deleted',
    'msg173' => 'Transferring to Post Message page..',
    'msg174' => 'Unable to BAN Member - Invalid or Empty IP Address',
    'msg175' => 'Zurück zur Forum-Übersicht',
    'msg176' => 'Mitglied auswählen',
    'msg177' => 'Alle Mitglieder',
    'msg178' => 'Nur die Start-Postings',
    'msg179' => 'Erzeugt in %s Sekunden',
    'msg180' => 'Forum Posting Alert',
    'msg181' => 'You don\'t have access to any other forum as a moderator',
    'msg182' => 'Moderator Confirmation',
    'msg183' => 'New topic was created from this post in forum: %s',
    'msg184' => 'Nur einmal benachrichtigen',
    'msg185' => 'Soll für neue Beiträge seit meinem letzten Besuch nur eine Benachrichtigung geschickt werden?',
    'msg186' => 'New Topic Title',
    'msg187' => 'Return to topic - click <a href="%s">here</a>',
    'msg188' => 'Zum letzten Beitrag springen',
    'msg189' => 'Error: You can not edit this post anymore',
    'msg190' => 'Stille Änderung',
    'msg191' => 'Edit not permitted. Allowable edit timeframe expired or you need moderator rights',
    'msg192' => 'Completed ... Migrated %s topics and %s comments.',
    'msg193' => 'STORY&nbsp;&nbsp;TO&nbsp;&nbsp;FORUM&nbsp;&nbsp;MIGRATION&nbsp;&nbsp;UTILITY',
    'msg194' => 'Wenig aktives Forum',
    'msg195' => 'Zum Forum springen',
    'msg196' => 'Zur Forum-Übersicht',
    'msg197' => 'Alle Themen als gelesen markieren',
    'msg198' => 'Forum-Einstellungen anpassen',
    'msg199' => 'Benachrichtigungs-E-Mails an- und abstellen',
    'msg200' => 'Liste aller User dieser Website',
    'msg201' => 'Liste der beliebtesten Forum-Themen',
    'msg202' => 'Keine neuen Beiträge',
    'msg300' => 'Your preferences have block anonymous posts enabled',
    'msg301' => 'Realy mark all categories read?',
    'msg302' => 'Realy mark all topics read?',
    'PostReply' => 'Post New Reply',
    'PostTopic' => 'Post New Topic',
    'EditTopic' => 'Edit Topic',
    'quietforum' => 'Keine neuen Beiträge'
);

$LANG_GF03 = array(
    'delete' => 'Beitrag löschen',
    'edit' => 'Beitrag ändern',
    'move' => 'Thema verschieben',
    'split' => 'Thema aufteilen',
    'ban' => 'IP sperren',
    'movetopic' => 'Thema verschieben',
    'movetopicmsg' => '<br' . XHTML . '>Topic to be moved: "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>Create a new Topic with this post: "<b>%s</b>"<br' . XHTML . '><em>By:</em>&nbsp;%s&nbsp <em>On:</em>&nbsp;%s',
    'selectforum' => 'Select new forum:',
    'lockedpost' => 'Add Reply Post',
    'splitheading' => 'Split thread option:',
    'splitopt1' => 'Move all posts from this point',
    'splitopt2' => 'Move only this one post'
);

$LANG_GF04 = array(
    'label_forum' => 'Forenprofil',
    'label_location' => 'Standort',
    'label_aim' => 'AIM Handhabe',
    'label_yim' => 'YIM Handhabe',
    'label_icq' => 'ICQ Identität',
    'label_msnm' => 'MS Messengername',
    'label_interests' => 'Interessen',
    'label_occupation' => 'Beschäftigung'
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
    1 => 'Statistik',
    2 => 'Einstellungen',
    3 => 'Foren',
    4 => 'Moderatoren',
    5 => 'Konvertieren',
    6 => 'Beiträge',
    7 => 'IP-Verw.'
);

$LANG_GF07 = array(
    1 => 'View Forums',
    2 => 'Einstellungen',
    3 => 'Beliebte Themen',
    4 => 'Abonnements',
    5 => 'Mitglieder'
);

$LANG_GF08 = array(
    1 => 'Benachrichtigungen für Themen',
    2 => 'Benachrichtigungen für ganze Foren',
    3 => 'Ausnahmen'
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
    'gfstats' => 'Forumsstatistik',
    'statsmsg' => 'Hier ist die aktuelle Statistik für Dein Forum:',
    'totalcats' => 'Kategorien insgesamt:',
    'totalforums' => 'Foren gesamt:',
    'totaltopics' => 'Themen gesamt:',
    'totalposts' => 'Beiträge gesamt:',
    'totalviews' => 'Aufrufe gesamt:',
    'avgpmsg' => 'Durchschnittliche Beiträge pro:',
    'category' => 'Kategorie:',
    'forum' => 'Forum:',
    'topic' => 'Thema:',
    'avgvmsg' => 'Durchschnittliche Aufrufe pro:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Forum-Einstellungen',
    'showiframe' => 'Themenübersicht',
    'showiframedscp' => 'Beim Beantworten die bisherige Diskussion in einem IFRAME einblenden',
    'topicspp' => 'Themen pro Seite:',
    'topicsppdscp' => 'Anzahl der Themen die im Forumindex angezeigt werden',
    'postspp' => 'Beiträge pro Seite:',
    'postsppdscp' => 'Anzahl der Beiträge, die pro Seite angezeigt werden',
    'setsavemsg' => 'Einstellungen gespeichert.'
);

$LANG_GF93 = array(
    'gfboard' => 'Discussion Forum Board Admin',
    'addcat' => 'Füge eine Kategorie hinzu',
    'addforum' => 'Füge ein Forum hinzu',
    'catorder' => 'Kategorienreihenfolge',
    'catadded' => 'Kategorie zugefügt.',
    'catdeleted' => 'Kategorie gelöscht',
    'catedited' => 'Kategorie bearbeitet.',
    'forumadded' => 'Forum zugefügt.',
    'forumaddError' => 'Error Adding Forum.',
    'forumdeleted' => 'Forum gelöscht',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum bearbeitet',
    'forumordered' => 'Forenreihenfolge bearbeitet',
    'back' => 'Zurück',
    'addnote' => 'Notiz: Du kannst dies später erneut ändern.',
    'editforumnote' => '<br' . XHTML . '>Bearbeite Forumdetails für: <b>"%s"</b>',
    'deleteforumnote1' => 'Möchtest Du das Forum <b>"%s"</b>&nbsp;löschen?',
    'deleteforumnote2' => 'Alle geposteten Themen unter diesem werden mitgelöscht.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => '<br' . XHTML . '>Bearbeite Kategoriedetails für: <b>"%s"</b>',
    'deletecatnote1' => 'Möchtest Du die Kategorie <b>"%s"</b>&nbsp;löschen?',
    'deletecatnote2' => 'Alle Foren und gepostete Themen dieser Kategorie werden ebenfalls gelöscht.',
    'undercat' => 'Unterkategorie',
    'groupaccess' => 'Gruppenzugriff: ',
    'action' => 'Aktionen',
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
    'mod_title' => 'Forummoderatoren',
    'allforums' => 'All Forums'
);

$LANG_GF95 = array(
    'header1' => 'Discussion Board Messages',
    'header2' => 'Discussion Board Messages for forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Eigenschaft ist noch nicht implementiert worden',
    'delall' => 'Alles löschen',
    'delallmsg' => 'Bist Du sicher, dass Du alle Nachrichten von: %s löschen willst?',
    'underforum' => '<b>Unterforum: %s (ID #%s)',
    'moderate' => 'Moderiert',
    'nomess' => 'Es wurden noch keine Nachrichten gepostet!'
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'IP-Verwaltung',
    'ban' => 'Bann',
    'noips' => '<p style="margin:0px; padding:5px;">Es wurden noch keine IPs gebannt!</p>',
    'unban' => 'Entbannen',
    'ipbanned' => 'IP-Addresse gebannt',
    'banip' => 'Bann-IP Bestätigung',
    'banipmsg' => 'Bist Du sicher, dass Du die IP %s bannen willst?',
    'specip' => 'Bitte spezifiziere eine IP-Addresse zum bannen!',
    'ipunbanned' => 'IP-Address entbannt.',
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
    0 => array('Ja' => 1, 'Nein' => 0),
    1 => array('Ja' => true, 'Nein' => false),
    5 => array('Top Of Page' => 1, 'After Featured Story' => 2, 'Bottom Of Page' => 3),
    6 => array('Left Blocks' => 'leftblocks', 'Right Blocks' => 'rightblocks', 'All Blocks' => 'allblocks', 'No Blocks' => 'noblocks'),
    7 => array('Block Menu' => 'blockmenu', 'Navigation Bar' => 'navbar', 'None' => 'none'),
    12 => array('Kein Zugang' => 0, 'Nur lesen' => 2, 'Lesen-schreiben' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
