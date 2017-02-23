<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | italian_utf-8.php                                                         |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Rouslan Placella    rouslan AT placella DOT com                        |
// |                                                                           |
// | Copyright (C) 2004 by the following authors:                              |
// |    magomarcelo      magomarcelo AT gmail DOT com                          |
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
    'statslabel' => 'Totale Messaggi Forum',
    'statsheading1' => 'Top 10 Argomenti Forum per Numero Visite',
    'statsheading2' => 'Top 10 Argomenti Forum per Numero Risposte',
    'statsheading3' => 'Nessun argomento sul quale riportare',
    'useradminmenu' => 'Funzionalitá del Forum',
    'access_denied' => 'Accesso Negato',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'Tutti',
    'YES' => 'Si',
    'NO' => 'No',
    'NEW' => 'Nuovo',
    'NEXT' => 'Successivo',
    'ERROR' => 'Errore!',
    'CONFIRM' => 'Conferma',
    'UPDATE' => 'Aggiorna',
    'SAVE' => 'Registra',
    'CANCEL' => 'Annulla',
    'ON' => 'Il: ',
    'ON2' => '&nbsp;&nbsp;<b>Il: </b>',
    'BY' => 'Da: ',
    'RE' => 'Re: ',
    'DATE' => 'Data',
    'VIEWS' => 'Visite',
    'REPLIES' => 'Risposte',
    'NAME' => 'Nome:',
    'DESCRIPTION' => 'Descrizione: ',
    'TOPIC' => 'Argomento',
    'TOPICS' => 'Argomenti',
    'TOPICSUBJECT' => 'Oggetto Argomento',
    'HOMEPAGE' => 'Home',
    'SUBJECT' => 'Argomenti',
    'HELLO' => 'Ciao ',
    'MOVED' => 'Spostato',
    'POSTS' => 'Messaggi',
    'LASTPOST' => 'Ultimo Messaggio',
    'POSTEDON' => 'Inviato il',
    'POSTEDBY' => 'Inviato Da',
    'PAGES' => 'Pagine',
    'TODAY' => 'Oggi alle ',
    'REGISTERED' => 'Registrato il',
    'ORDERBY' => 'Ordina Per:',
    'ORDER' => 'Ordine:',
    'USER' => 'Utente',
    'GROUP' => 'Gruppo',
    'ANON' => 'Anonimo: ',
    'ADMIN' => 'Amministratore',
    'AUTHOR' => 'Autore',
    'NOMOOD' => 'Nessun Umore',
    'REQUIRED' => '[Richiesto]',
    'OPTIONAL' => '[Opzionale]',
    'SUBMIT' => 'Invia',
    'PREVIEW' => 'Anteprima',
    'REMOVE' => 'Rimuovi',
    'EDIT' => 'Modifica',
    'DELETE' => 'Elimina',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Opzioni:',
    'MISSINGSUBJECT' => 'Oggetto mancante',
    'MIGRATE_NOW' => 'Migrate Now',
    'FILTERLIST' => 'Filter List',
    'SELECTFORUM' => 'Seleziona un Forum',
    'DELETEAFTER' => 'Rimouvi dopo',
    'TITLE' => 'Titolo',
    'COMMENTS' => 'Commenti',
    'SUBMISSIONS' => 'Submissions',
    'HTML_FILTER_MSG' => 'HTML Filtrato Consentito',
    'HTML_FULL_MSG' => 'Tutto HTML Consentito',
    'HTML_MSG' => 'HTML Consentito',
    'CENSOR_PERM_MSG' => 'Contenuto Censurato',
    'ANON_PERM_MSG' => 'Vedi Messaggi Anonimi',
    'POST_PERM_MSG1' => 'Able to post',
    'POST_PERM_MSG2' => 'Utenti anonimi possono scrivere',
    'GO' => 'VAI',
    'STATUS' => 'Stato:',
    'ONLINE' => 'online',
    'OFFLINE' => 'offline',
    'back2parent' => 'Argomento Superiore',
    'forumname' => '',
    'category' => 'Categoria: ',
    'loginreqview' => '<b>Spiacente, devi %s registrarti</a> o %s loggarti </a> per usare questi forum</b>',
    'loginreqpost' => '<b>Spiacente, devi registrarti o loggarti per inviare messaggi su questi forum</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Nessuno.',
    'back2top' => 'Inizio Pagina',
    'TEXTMODE' => 'Modo Testo:',
    'HTMLMODE' => 'Modo HTML:',
    'TopicPreview' => 'Anteprima invio argomento',
    'moderator' => 'Moderatore',
    'admin' => 'Admin',
    'DATEADDED' => 'Data Aggiunto',
    'PREVTOPIC' => 'Argomento Precedente',
    'NEXTTOPIC' => 'Argomento Successivo',
    'RESYNC' => 'Sicronizza',
    'RESYNCCAT' => 'Sicronizza Categorie Forum',
    'EDITICON' => 'Modifica',
    'QUOTEICON' => 'Quote',
    'ProfileLink' => 'Profilo',
    'WebsiteLink' => 'Sito Internet',
    'PMLink' => 'MP',
    'EmailLink' => 'Email',
    'FORUMSUBSCRIBE' => 'Iscriviti a questo forum',
    'FORUMUNSUBSCRIBE' => 'Un-Subscribe to this forum',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => 'Nuovo Argomento',
    'POSTREPLY' => 'Risposta al Messaggio',
    'SubscribeLink' => 'Iscriviti',
    'unSubscribeLink' => 'Un-Subscribe',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => 'Iscrizioni',
    'TOP' => 'Inizio Messaggio',
    'PRINTABLE' => 'Versione Stampabile',
    'USERPREFS' => 'Preferenze Utente',
    'SPEEDLIMIT' => '"Your last comment was %s seconds ago.<br' . XHTML . '>This site requires at least %s seconds between forum posts."',
    'ACCESSERROR' => 'ERRORE DI ACCESSO',
    'ACTIONS' => 'Azioni',
    'DELETEALL' => 'Elimina tutti gli oggetti selezionati',
    'DELCONFIRM' => 'Sei sicuro di volr eliminare gli oggetti selezionati?',
    'DELALLCONFIRM' => 'Sei sicuro di volr Eliminare TUTTI gli oggetti selezionati??',
    'STARTEDBY' => 'Iniziato da:',
    'WARNING' => 'Avviso',
    'MODERATED' => 'Moderatori: %s',
    'LASTREPLYBY' => 'Ultima risposta da:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Lista dei Forum',
    'FEATURE' => 'Funzionalitá',
    'SETTING' => 'Impostazione',
    'MARKALLREAD' => 'Segna Tutti come Visti',
    'MSG_NO_CAT' => 'Nessuna Categoria o Forum Disponibili',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Codice',
    'FONTCOLOR' => 'Colore Font',
    'FONTSIZE' => 'Dimensioni Font',
    'CLOSETAGS' => 'Chiudi Tag',
    'CODETIP' => 'Suggerimento: Gli stili possono essere applicati rapidamente al testo selezionato',
    'TINY' => 'Minuscolo',
    'SMALL' => 'Piccolo',
    'NORMAL' => 'Normale',
    'LARGE' => 'Grande',
    'HUGE' => 'Enorme',
    'DEFAULT' => 'Predefinito',
    'DKRED' => 'Rosso Scuro',
    'RED' => 'Rosso',
    'ORANGE' => 'Arancione',
    'BROWN' => 'Marrone',
    'YELLOW' => 'Giallo',
    'GREEN' => 'Verde',
    'OLIVE' => 'Olivastro',
    'CYAN' => 'Ciano',
    'BLUE' => 'Blu',
    'DKBLUE' => 'Blu Scuro',
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Violetto',
    'WHITE' => 'Bianco',
    'BLACK' => 'Nero',
    'b_help' => 'Grassetto: [b]testo[/b]',
    'i_help' => 'Corsivo: [i]testo[/i]',
    'u_help' => 'Sottolineato: [u]testo[/u]',
    'q_help' => 'Quote text: [quote]testo[/quote]',
    'c_help' => 'Visualizzazione code: [code]code[/code]',
    'l_help' => 'Lista: [list]testo[/list]',
    'o_help' => 'Lista ordinata: [olist]testo[/olist]',
    'p_help' => '[img]http://url_immagine[/img]  o [img w=100 h=200][/img]',
    'w_help' => 'Insert URL: [url]http://url[/url] o [url=http://url]Titolo[/url]',
    'a_help' => 'Cliudi tuuti i tag bbCode aperti',
    's_help' => 'Colore font: [color=red]testo[/color]  suggerimento: puoi anche usari i colori in questo formato #FF0000',
    'f_help' => 'Dimensione font: [size=7]testo piccolo[/size]',
    'h_help' => 'Clicca qui per vedere una guida piú dettagliata'
);

$LANG_GF02 = array(
    'msg01' => 'Spiacente, vedi registrarti per utilizzare questo forum',
    'msg02' => 'Non dovresti essere qui!<br' . XHTML . '>L\'accesso a questo forum é ristretto',
    'msg03' => 'Attendi mentre vieni trasferito',
    'msg05' => '<center><em>Spiacente, non é ancora stato creato alcun argomento.</center></em>',
    'msg07' => 'Utenti Online:',
    'msg14' => 'Spiacente, Ti é stato impedito di creare nuovi inserimenti.<br' . XHTML . '>',
    'msg15' => 'Se pensi che si tratti di un errore, contatta <a href="mailto:%s?subject=Guestbook IP Ban">l\'Amministratore del Sito</a>.',
    'msg18' => 'Errore! Non tutti i campi richiesti sono stati completati oppure erano troppo corti come lunghezza.',
    'msg19' => 'Il tuo messaggio é stato inviato.',
    'msg22' => '- Notifica Nuovo Messaggio sul Forum',
    'msg23a' => "\nUna risposta è stata aggiunta all'argomento '%s' da %s\n\nQuesto argomento è stato aperto da %s nel forum %s.\n",
    'msg23b' => "Il nuovo argomento '%s' è stato aggiunto da %s nel forum %s sul sito web %s.\nPuoi vederlo su: %s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "\nPuoi leggerlo su: %s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nBuona giornata! \n",
    'msg26' => "\nHai ricevuto questa e-mail perchè hai scelto di ricevere una notifica\nper ogni risposta aggiunta.",
    'msg27' => 'Per non ricevere più notifiche su questo argomento vai <a href="%s">qui</a> per rimuoverti.',
    'msg33' => 'Autore: ',
    'msg36' => 'Umore:',
    'msg38' => 'Inviami una Notifica per ogni risposta ',
    'msg40' => '<br' . XHTML . '>Spiacente, ma hai giá chiesto di ricevere notifiche per risposte a questo argomento.<br/><br/>',
    'msg44' => '<p style="margin:0px; padding:5px;">Al momento non hai nessuna notifica attiva.</p>',
    'msg49' => '(Letto %s volte) ',
    'msg55' => 'Messaggio Eliminato.',
    'msg56' => 'IP Bloccato.',
    'msg59' => 'Argomento Normale',
    'msg60' => 'Nuovo Messaggio',
    'msg61' => 'Argomento Segnalato',
    'msg62' => 'Inviami una notifica ad ogni risposta',
    'msg64' => 'Sei sicuro di voler eliminare l\'argomento %s con titolo: %s ?',
    'msg65' => '<br' . XHTML . '>C\'é un argomento superiore, per cui saranno eliminate anche tutte le risposte a questo.',
    'msg68' => 'Nota: FAI ATTENZIONI QUANDO BLOCCHI QUALCUNO, solo gli amministratori hanno i diritti per sbloccare qualcuno.',
    'msg69' => '<br' . XHTML . '>Vuoi davvero bloccare l\'indirizzo IP: %s?',
    'msg71' => 'Nessuna funzione selezionata, scegli un messaggio e poi una funzione di moderazione.<br' . XHTML . '>Nota: Devi essere un moderatore per utilizzare queste funzionalitá.',
    'msg72' => 'Se questo messaggio é online non hai i diritti per eseguire questa operazione di moderazione.',
    'msg74' => 'Ultimi %s Messaggi sul Forum',
    'msg75' => 'Top %s Argomenti Per Visite',
    'msg76' => 'Top %s Argomenti Per Numero Messaggi',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">Non dovresti essere qui!<br' . XHTML . '>Questo forum é ad accesso riservato.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>Devi essere loggato per utilizzare questa funzionalitá di questo forum.</p>',
    'msg84' => 'Segnala tutti gli argomenti come giá letti',
    'msg85' => 'Pagina:',
    'msg86' => '&nbsp;Ultimi %s messaggi&nbsp;',
    'msg87' => '<br' . XHTML . '>Attenzione: Questo argomento é stato bloccato dal moderatore.<br' . XHTML . '>Non é possibile inviare altri messaggi',
    'msg88' => 'Utenti con Attivitá sul Forum',
    'msg88b' => 'Forum Activity Only',
    'msg89' => 'Notifiche Attive',
    'msg101' => 'Regole Forum:',
    'msg103' => 'Vai al Forum:',
    'msg106' => 'Selezionate un Forum',
    'msg108' => 'Forum Normale',
    'msg109' => 'Argomento Bloccato',
    'msg110' => 'Trasferimento a pagina di modifica messaggio..',
    'msg111' => 'Nuovi Messaggi dalla vostra ultima visita:',
    'msg112' => 'Leggi tutti i nuovi messaggi',
    'msg113' => 'Leggi i nuovi messaggi',
    'msg114' => 'Argomento Bloccato',
    'msg115' => 'Argomento Segnalato C/ Nuovi Messaggi',
    'msg116' => 'Argomento Bloccato C/ Nuovi Messaggi',
    'msg117' => 'Cerca Ovunque',
    'msg118' => 'Cerca in questo Forum',
    'msg119' => 'Risultati Ricerca Forum per:',
    'msg120' => 'Messaggi piú visti per',
    'msg121' => 'Tutti gli orari sono %s. L\'ora attuale é %s.',
    'msg122' => 'Limite Messaggi Popolari:',
    'msg123' => 'Numero messaggi prima di chiamare un argomento popolare',
    'msg126' => 'Cerca Righe:',
    'msg127' => 'Numero righe da visualizzare come risultato della ricerca',
    'msg128' => 'Utenti Per Pagina:',
    'msg129' => 'Per la pagina elenco Utenti',
    'msg130' => 'Vedi Messaggi Anonimi:',
    'msg131' => 'L\'impostazione No filtrerá i messaggi anonimi',
    'msg132' => 'Notifica Sempre:',
    'msg133' => 'Impostando Si attiverai la notifica automatica<br' . XHTML . '>per ogni argomento creato o in risposta',
    'msg134' => 'Iscrizione Aggiunta',
    'msg135' => 'Riceverai una notifica per ogni messaggio inviato su questo forum.',
    'msg136' => 'Devi scegliere un forum cui iscrivervi.',
    'msg137' => 'Notifica per argomento attiva',
    'msg138' => '<b>Iscritto all\'intero forum</b>',
    'msg142' => 'Notifica registrata.',
    'msg144' => 'Ritorna all\'argomento',
    'msg146' => 'Notifica Eliminata',
    'msg147' => 'Forum [versione stampabile dell\'argomento %s]',
    'msg148' => 'Fate clic <a href="javascript:history.back()">QUI</a> per ritornare',
    'msg155' => 'Nessun messaggio dall\'utente.',
    'msg156' => 'Numero totale messaggi nel forum',
    'msg157' => 'Ultimi 10 messaggi nel Forum',
    'msg158' => 'Ultimi 10 messaggi nel Forum per ',
    'msg159' => 'Sei sicuro di voler ELIMINARE i record Moderatori selezionati?',
    'msg160' => 'Vai all\'ultima pagina dell\'argomento',
    'msg163' => 'Messaggio spostato',
    'msg164' => 'Segnala tutte le Categorie e gli Argomento come Letti',
    'msg166' => 'ERRORE: Argomento non valido o non trovato',
    'msg167' => 'Opzione di Notifica',
    'msg168' => 'Impostando No disabiliterai le notifiche via e-mail',
    'msg169' => 'Torna alla lista Utenti',
    'msg170' => 'Ultimi Messaggi sul Forum',
    'msg171' => 'Errore di Accesso al Forum',
    'msg172' => 'L\'argomento non esiste. Probabilmente é stato eliminato',
    'msg173' => 'Trasferimento alla Pagina del Messaggio..',
    'msg174' => 'Impossibile BLOCCARE l\'utente - Indirizzo IP non valido o vuoto',
    'msg175' => 'Ritorna alla Lista dei Forum',
    'msg176' => 'Seleziona un utente',
    'msg177' => 'Tutti gli Utenti',
    'msg178' => 'Solo i Messaggi Iniziali',
    'msg179' => 'Contenuto creato in: %s secondi',
    'msg180' => 'Avviso Forum Posting',
    'msg181' => 'Come moderatore, non hai accesso ad altri forum',
    'msg182' => 'Conferma di Moderazione',
    'msg183' => 'In nuovo argomento é stato creato nel forum: %s',
    'msg184' => 'Notifica Solo Una Volta',
    'msg185' => 'Notifiche verranno solo inviato una volta per i forum e argomenti che potrebbero contenere multipli messaggi dalla tua ultima visita.',
    'msg186' => 'Titolo del Nuovo Argomento',
    'msg187' => 'Ritorna al argomento - clicca <a href="%s">qui</a>',
    'msg188' => 'Clicca per andare direttamente all\'ulmito messaggio',
    'msg189' => 'Errore: Non puoi piú modificare questo messaggio',
    'msg190' => 'Modifica Nascosta',
    'msg191' => 'Modifica non permessa. Il tempo di modifica consentito é scaduto o hai bisogno di permessi da moderatore',
    'msg192' => 'Completato ... Migrato %s argomenti e %s commenti.',
    'msg193' => 'ATRICOLO&nbsp;&nbsp;A&nbsp;&nbsp;FORUM&nbsp;&nbsp;MIGRAZIONE&nbsp;&nbsp;EXTRA',
    'msg194' => 'Quiet Forum',
    'msg195' => 'Clicca per Andare al Forum',
    'msg196' => 'Mostra la lista principale di Forum',
    'msg197' => 'Segna tutte le Categorie come viste',
    'msg198' => 'Aggiorna le tue impostazioni del forum',
    'msg199' => 'Vedi o rimuovi notifiche dei forum',
    'msg200' => 'Relazione sugli Utenti del Sito',
    'msg201' => 'Argomenti Popolari',
    'msg202' => 'Nessun nuovo messaggio',
    'msg300' => 'Il blocco per messaggi anonimi é attivo nelle tue preferenze',
    'msg301' => 'Davvero segnare tutte le categorie come lette?',
    'msg302' => 'Davvero segnare tutti gli argomenti come letti?',
    'PostReply' => 'Invia Nuova Risposta',
    'PostTopic' => 'Invia Nuovo Argomento',
    'EditTopic' => 'Modifica Argomento',
    'quietforum' => 'Il forum non ha nuovi argomenti'
);

$LANG_GF03 = array(
    'delete' => 'Elimina Messaggio',
    'edit' => 'Modifica Messaggio',
    'move' => 'Sposta Argomento',
    'split' => 'Split Topic',
    'ban' => 'Blocca IP',
    'movetopic' => 'Sposta Argomento',
    'movetopicmsg' => '<br' . XHTML . '>É possibile spostare l\'argomento <b>%s</b> nei seguenti forum:',
    'splittopicmsg' => '<br' . XHTML . '>Create a new Topic with this post: "<b>%s</b>"<br' . XHTML . '><em>By:</em>&nbsp;%s&nbsp <em>On:</em>&nbsp;%s',
    'selectforum' => 'Select new forum:',
    'lockedpost' => 'Add Reply Post',
    'splitheading' => 'Split thread option:',
    'splitopt1' => 'Move all posts from this point',
    'splitopt2' => 'Move only this one post'
);

$LANG_GF04 = array(
    'label_forum' => 'Profilo Forum',
    'label_location' => 'Localitá',
    'label_aim' => 'AIM',
    'label_yim' => 'Yahoo IM',
    'label_icq' => 'ICQ',
    'label_msnm' => 'MSN Messenger',
    'label_interests' => 'Interessi',
    'label_occupation' => 'Occupazione'
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
    1 => 'Statistiche',
    2 => 'Impostazioni',
    3 => 'Forum',
    4 => 'Moderatori',
    5 => 'Converti',
    6 => 'Messaggi',
    7 => 'Gestione IP'
);

$LANG_GF07 = array(
    1 => 'Visita Forum',
    2 => 'Preferenze',
    3 => 'Argomenti Popolari',
    4 => 'Iscrizioni',
    5 => 'Utenti'
);

$LANG_GF08 = array(
    1 => 'Notifiche degli Argomenti',
    2 => 'Segui le Notifiche del Forum',
    3 => 'Segui le Notifiche delle Eccezioni'
);

$LANG_GF09 = array(
    'edit' => 'Modifica',
    'email' => 'Email',
    'home' => 'Home',
    'lastpost' => 'Ultimo Messaggio',
    'pm' => 'MP',
    'profile' => 'Profilo',
    'quote' => 'Quote',
    'website' => 'Sito Internet',
    'newtopic' => 'Nuovo Argomento',
    'replytopic' => 'Rispondi al Messaggio'
);

$LANG_GF91 = array(
    'gfstats' => 'Statistiche Forum di Discussione',
    'statsmsg' => 'Queste sono le statistiche attuali per il vostro forum:',
    'totalcats' => 'Totale Categorie:',
    'totalforums' => 'Totale Forum:',
    'totaltopics' => 'Totale Argomenti:',
    'totalposts' => 'Totale Messaggi:',
    'totalviews' => 'Totale Visite:',
    'avgpmsg' => 'Media messaggi per:',
    'category' => 'Categoria:',
    'forum' => 'Forum:',
    'topic' => 'Argomento:',
    'avgvmsg' => 'Media visite per:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Impostazioni Forum di Discussione',
    'showiframe' => 'Mostra Rivedi Argomento:',
    'showiframedscp' => 'Mostra Rivedi Argomento (Iframe) in basso quando<br' . XHTML . '>si risponde ad un argomento',
    'topicspp' => 'Argomenti Per Pagina:',
    'topicsppdscp' => 'Numero argomenti da visualizzare sulla pagina indice del forum',
    'postspp' => 'Messaggi Per Pagina:',
    'postsppdscp' => 'Numero di messaggi da mostrare in una pagina',
    'setsavemsg' => 'Impostazioni registrate.'
);

$LANG_GF93 = array(
    'gfboard' => 'Amministrazione Forum di Discussione',
    'addcat' => 'Aggiungi Categoria Forum',
    'addforum' => 'Aggiungi Un Forum',
    'catorder' => 'Ordina per Categorie',
    'catadded' => 'Categoria Aggiunta.',
    'catdeleted' => 'Categoria Eliminata',
    'catedited' => 'Categoria Modificate.',
    'forumadded' => 'Forum Aggiunto.',
    'forumaddError' => 'Errore in Aggiunta Forum.',
    'forumdeleted' => 'Forum Eliminato',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum Modificato',
    'forumordered' => 'Ordine dei Forum Modificato',
    'back' => 'Indietro',
    'addnote' => 'Nota: Puoi modificare questi valori.',
    'editforumnote' => 'Modifica Dettagli Forum per: <b>"%s"</b>',
    'deleteforumnote1' => 'Vuoi eliminare il forum <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Tutti gli argomenti inviati sotto saranno pure eliminati.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Modifica Dettagli Categoria per: <b>"%s"</b>',
    'deletecatnote1' => 'Vuoi elimiare la categoria <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Saranno eliminati i forum ed anche tutti messaggi inviati in tali forum.',
    'undercat' => 'Sotto Categoria',
    'groupaccess' => 'Accesso Gruppo: ',
    'action' => 'Azioni',
    'forumdescription' => 'Descrizione Forum',
    'posts' => 'Messaggi',
    'ordertitle' => 'Ordina',
    'ModEdit' => 'Modifica',
    'ModMove' => 'Sposta',
    'ModStick' => 'Evidenzia',
    'ModBan' => 'Blocca',
    'addmoderator' => "Aggiungi\nModeratore",
    'delmoderator' => " Elimina\nSelezionato",
    'moderatorwarning' => '<b>Attenzione: Non é stato definito alcun Forum</b><br' . XHTML . '><br' . XHTML . '>Imposta le Categorie dei Forum e Aggiungi almeni 1 forum<br' . XHTML . '>prima di provare ad aggiungere Moderatori',
    'private' => 'Forum Privato',
    'filtertitle' => 'Seleziona i Moderatori da Vedere',
    'addmessage' => 'Aggiungi unj Nuovo Moderatore',
    'allowedfunctions' => 'Functioni Consentite',
    'userrecords' => 'Elenco Utenti',
    'grouprecords' => 'Elenco Gruppi',
    'filterview' => 'Mostra',
    'readonly' => 'Forum in Sola Lettura',
    'readonlydscp' => 'Solo Moderatori posso scrivere in questo forum',
    'hidden' => 'Forum Nascosti',
    'hiddendscp' => 'Forum non verrá mostrato nell\'elenco dei forum',
    'hideposts' => 'Nascondi i Nuovi Messaggi',
    'hidepostsdscp' => 'Gli aggiornamenti non verranno mostrati nel Blocco dei Nuovi Messaggi o i flussi RSS',
    'mod_title' => 'Moderatori Forum',
    'allforums' => 'Tutti i Forum'
);

$LANG_GF95 = array(
    'header1' => 'Messaggi delle Conversazioni',
    'header2' => 'Messaggi delle Conversazioni per il forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Questa funzionalitá non é stata ancora implementata',
    'delall' => 'Elimina Tutto',
    'delallmsg' => 'Sei sicuro di voler eliminare tutti i messaggi inviati da: %s?',
    'underforum' => '<b>Sotto il Forum: %s (ID #%s)',
    'moderate' => 'Modera',
    'nomess' => 'Non sono ancora stati inviati messaggi! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Entra un indirizzo IP da bloccare',
    'gfipman' => 'Gestione IP',
    'ban' => 'Blocca',
    'noips' => 'Nessun IP é stato ancora bloccato!',
    'unban' => 'Sblocca',
    'ipbanned' => 'Indirizzo IP Bloccato',
    'banip' => 'Conferma Blocco IP',
    'banipmsg' => 'Sei sicuro di voler bloccare l\ip %s?',
    'specip' => 'Prego specifica un indirizzo IP da bloccare!',
    'ipunbanned' => 'Indirizzo IP Sbloccato.',
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
$PLG_forum_MESSAGE1 = 'Aggiornamento dell\'Estensione Forum: Aggiornamento completato con successo.';
$PLG_forum_MESSAGE2 = 'Aggiornamento dell\'Estensione Forum: Non é possibile aggiornare questa versione automaticamente. Vedi la documentazione delle estensioni.';
$PLG_forum_MESSAGE5 = 'L\'aggiornamento dell\'estensione Forum é fallito - vedi file error.log';

// Messages for the plugin upgrade
$PLG_forum_MESSAGE3001 = '';
$PLG_forum_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['forum'] = array(
    'label' => 'Forum',
    'title' => 'Configurazione Forum'
);

$LANG_confignames['forum'] = array(
    'registration_required' => 'Login Necessario per Vedere Messaggi?',
    'registered_to_post' => 'Login Necessario per Inviare Messaggi?',
    'allow_notification' => 'Consentire Notifiche?',
    'show_topicreview' => 'Mostrare Revisione Dell\'Argomento Durante l\'Invio della Risposta?',
    'allow_user_dateformat' => 'Consentire Formati Personalizzati della Data?',
    'use_pm_plugin' => 'Utilizzare l\'Estensione dei Messaggi Privati?',
    'show_topics_perpage' => 'Numbero di Topics to Show per Page',
    'show_posts_perpage' => 'Numbero di Posts to Show per Page',
    'show_messages_perpage' => 'Numbero di Message Lines per Page',
    'show_searches_perpage' => 'Numbero di Search Results per Page',
    'showblocks' => 'Block Columns to Show with Forum',
    'usermenu' => 'Tipo del Menu Utente',
    'use_themes_template' => 'Use templates in the theme directory',
    'show_subject_length' => 'Mass Lunghezza del Oggetto',
    'min_username_length' => 'Min Lunghezza del Nome Utente',
    'min_subject_length' => 'Min Lunghezza del Oggetto',
    'min_comment_length' => 'Min Lunghezza del Contenuto dei Messaggi',
    'views_tobe_popular' => 'Numero di Visualizzazzioni Per Essere Popolare',
    'post_speedlimit' => 'Limite di Velocitá per l\'Inviodei Messaggi (sec)',
    'allowed_editwindow' => 'Tempo(sec) per Consentire la Modifica dei Messaggi',
    'allow_html' => 'Consentire Modalitá HTML?',
    'post_htmlmode' => 'Impostare Modalitá HTML come Predefinita?',
    'convert_break' => 'Convertire i Ritorni a Capo al Tag HTML &lt;BR&gt;?',
    'use_censor' => 'Utilizzare la Funzionalitá di Cenura di Geeklog?',
    'use_glfilter' => 'Utilizzare la Funzionalitá di Filtraggio di Geeklog?',
    'use_geshi' => 'Utilizzare Geshi per Formattare Codice?',
    'use_spamx_filter' => 'Utilizzare l\'Estensione Spam-X?',
    'show_moods' => 'Abilitare Umoris?',
    'allow_smilies' => 'Abilitare Smilies?',
    'use_smilies_plugin' => 'Utilizzare l\Estensione Smilies?',
    'avatar_width' => 'Larghezza dell\'Avatar degli Utenti',
    'show_centerblock' => 'Abilitare il Blocco Centrale?',
    'centerblock_homepage' => 'Abilitare Solo sulla Homepage?',
    'centerblock_numposts' => 'Numbero di Argomenti da Mostare',
    'cb_subject_size' => 'Mass Lunghezza dell\'Oggetto',
    'centerblock_where' => 'Posizionamento nella Pagina',
    'sideblock_numposts' => 'Numbero di Messaggi da Mostrare',
    'sb_subject_size' => 'Mass Lunghezza dell\'Oggetto',
    'sb_latestpostonly' => 'Mostare Solo i Post Recenti?',
    'sideblock_enable' => 'Enabled',
    'sideblock_isleft' => 'Display Block on Left',
    'sideblock_order' => 'Block Order',
    'sideblock_topic_option' => 'Topic Options',
    'sideblock_topic' => 'Topic',
    'sideblock_group_id' => 'Group',
    'sideblock_permissions' => 'Permissions',
    'level1' => 'Numero di Messaggi per Raggiungere Grado 1',
    'level2' => 'Numero di Messaggi per Raggiungere Grado 2',
    'level3' => 'Numero di Messaggi per Raggiungere Grado 3',
    'level4' => 'Numero di Messaggi per Raggiungere Grado 4',
    'level5' => 'Numero di Messaggi per Raggiungere Grado 5',
    'level1name' => 'Nominativo del Grado 1',
    'level2name' => 'Nominativo del Grado 2',
    'level3name' => 'Nominativo del Grado 3',
    'level4name' => 'Nominativo del Grado 4',
    'level5name' => 'Nominativo del Grado 5',
    'menublock_enable' => 'Enabled',
    'menublock_isleft' => 'Display Block on Left',
    'menublock_order' => 'Block Order',
    'menublock_topic_option' => 'Topic Options',
    'menublock_topic' => 'Topic',
    'menublock_group_id' => 'Group',
    'menublock_permissions' => 'Permissions'
);

$LANG_configsubgroups['forum'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['forum'] = array(
    'tab_main' => 'Impostazioni Generali del Forum',
    'tab_topicposting' => 'Invio Argomenti',
    'tab_centerblock' => 'Blocco Centrale',
    'tab_sideblock' => 'Blocchi Laterali',
    'tab_rank' => 'Grado',
    'tab_menublock' => 'Menu Block'
);

$LANG_fs['forum'] = array(
    'fs_main' => 'Impostazioni Generali del Forum',
    'fs_topicposting' => 'Invio Argomenti',
    'fs_centerblock' => 'Blocco Centrale',
    'fs_sideblock' => 'Blocchi Laterali',
    'fs_sideblock_settings' => 'Block Settings',
    'fs_sideblock_permissions' => 'Block Permissions',
    'fs_rank' => 'Grado',
    'fs_menublock' => 'Menu Block',
    'fs_menublock_settings' => 'Block Settings',
    'fs_menublock_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['forum'] = array(
    0 => array('Si' => 1, 'No' => 0),
    1 => array('Si' => true, 'No' => false),
    5 => array('Inizio Pagina' => 1, 'Dopo L\'Articolo in Vetrina' => 2, 'Fine Pagina' => 3),
    6 => array('Con Blocchi Sinistri' => 'leftblocks', 'Con Blocchi Destri' => 'rightblocks', 'Con Tutti i Blocchi' => 'allblocks', 'Senza Blocchi' => 'noblocks'),
    7 => array('Menu nel Blocco' => 'blockmenu', 'Barra di Navigazione' => 'navbar', 'Nessuno' => 'none'),
    12 => array('Nessun accesso' => 0, 'Solo Lettura' => 2, 'Lettura e Scrittura' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
