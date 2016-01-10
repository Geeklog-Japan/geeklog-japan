<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | french_france.php                                                         |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Community Members   geeklog-forum AT googlegroups DOT com      |
// |                                                                           |
// | Copyright (C) 2000,2001 by the following authors:                         |
// |    Tony Bibbs       tony AT tonybibbs DOT com                             |
// |                                                                           |
// | forum Plugin Authors                                                      |
// |    Mr.GxBlock                                        www.gxblock.com      |
// |    Matthew DeWyer   matt AT mycws DOT com            www.cweb.ws          |
// |    Blaine Lang      geeklog AT langfamily DOT ca     www.langfamily.ca    |
// |                                                                           |
// | Translation Author :                                                      |
// |    David Gaussinel  geeklog AT wipsa DOT net                              | 
// |    Ben              ben AT geeklog DOT fr                                 |
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
    'statslabel' => 'Total de contributions dans le forum',
    'statsheading1' => 'Les 10 sujets les plus lus du forum',
    'statsheading2' => 'Les 10 sujets du forum comportant le plus de r駱onses',
    'statsheading3' => 'Aucun sujet',
    'useradminmenu' => 'Pr馭駻ences du forum',
    'access_denied' => 'Acc鑚 r駸ervaux membres',
    'autotag_desc_forum' => '[forum: id titre alternatif] - Affiche un lien vers un sujet du forum en utilisant le texte "ici" comme titre. Un titre alternatif peut 黎re sp馗ifi'
);

$LANG_GF01 = array(
    'FORUM' => 'Forum',
    'ALL' => 'Tous',
    'YES' => 'Oui',
    'NO' => 'Non',
    'NEW' => 'Nouveau',
    'NEXT' => 'Suivant',
    'ERROR' => 'Erreur!',
    'CONFIRM' => 'Confirmer',
    'UPDATE' => 'Mise jour',
    'SAVE' => 'Sauver',
    'CANCEL' => 'Annuler',
    'ON' => 'Le ',
    'ON2' => '&nbsp;&nbsp;<b>On: </b>',
    'BY' => 'Par : ',
    'RE' => 'Re : ',
    'DATE' => 'Date',
    'VIEWS' => 'Vu',
    'REPLIES' => 'R駱onses',
    'NAME' => 'Nom :',
    'DESCRIPTION' => 'Description : ',
    'TOPIC' => 'Sujet',
    'TOPICS' => 'Sujets',
    'TOPICSUBJECT' => 'Contributions',
    'HOMEPAGE' => 'Accueil',
    'SUBJECT' => 'Sujet',
    'HELLO' => 'Bonjour ',
    'MOVED' => 'D駱lac,
    'POSTS' => 'Contributions',
    'LASTPOST' => 'Derni鑽e',
    'POSTEDON' => 'Postle',
    'POSTEDBY' => 'Postpar',
    'PAGES' => 'Pages',
    'TODAY' => 'Aujourd\'hui ',
    'REGISTERED' => 'Enregistr,
    'ORDERBY' => 'Ordre:&nbsp;',
    'ORDER' => 'Ordre:',
    'USER' => 'Utilisateur',
    'GROUP' => 'Groupe',
    'ANON' => 'Anonyme: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Auteur',
    'NOMOOD' => 'Aucune humeur',
    'REQUIRED' => '[Requis]',
    'OPTIONAL' => '[Optionel]',
    'SUBMIT' => 'Poster',
    'PREVIEW' => 'Pr騅isualiser',
    'REMOVE' => 'Enlever',
    'EDIT' => 'Editer',
    'DELETE' => 'Effacer',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Options',
    'MISSINGSUBJECT' => 'Sujet vide',
    'MIGRATE_NOW' => 'Migrer maintenant',
    'FILTERLIST' => 'Filtrer la liste',
    'SELECTFORUM' => 'Choisir le forum',
    'DELETEAFTER' => 'Supprimer apr鑚',
    'TITLE' => 'Titre',
    'COMMENTS' => 'Commentaires',
    'SUBMISSIONS' => 'Soumissions',
    'HTML_FILTER_MSG' => 'HTML filtrpermis',
    'HTML_FULL_MSG' => 'Tout HTML autoris,
    'HTML_MSG' => 'HTML autoris,
    'CENSOR_PERM_MSG' => 'Contre vocabulaire',
    'ANON_PERM_MSG' => 'Vous pouvez lire ce forum',
    'POST_PERM_MSG1' => 'Vous pouvez poster dans ce forum',
    'POST_PERM_MSG2' => 'Les anonymes peuvent dans ce forum',
    'GO' => 'Ok',
    'STATUS' => 'Status :',
    'ONLINE' => 'en ligne',
    'OFFLINE' => 'hors ligne',
    'back2parent' => 'Sujet Parent',
    'forumname' => '',
    'category' => 'Cat馮orie: ',
    'loginreqview' => '<B>Merci de vous %s inscrire</A> ou vous %s identifier</A> pour utiliser ce forum.</B>',
    'loginreqpost' => '<B>Merci de vous inscrire ou vous identifier pour utiliser ce forum. Vous allez 黎re redirig</B>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Aucun.',
    'back2top' => 'Retour en haut',
    'TEXTMODE' => 'Mode Texte',
    'HTMLMODE' => 'Mode HTML',
    'TopicPreview' => 'Pr騅isualisation de la R駱onse',
    'moderator' => 'Moderateur',
    'admin' => 'Admin',
    'DATEADDED' => 'Ajoutle',
    'PREVTOPIC' => 'Sujet Pr馗馘ent',
    'NEXTTOPIC' => 'Sujet Suivant',
    'RESYNC' => 'ReSynchroniser',
    'RESYNCCAT' => 'ReSynchroniser les cat馮ories',
    'EDITICON' => '&nbsp;Editer&nbsp;',
    'QUOTEICON' => '&nbsp;Citer&nbsp;',
    'ProfileLink' => '&nbsp;Profile&nbsp;',
    'WebsiteLink' => '&nbsp;Site web&nbsp;',
    'PMLink' => '&nbsp;Envoyer un Message Privnbsp;',
    'EmailLink' => '&nbsp;Email&nbsp;',
    'FORUMSUBSCRIBE' => 'Surveiller ce forum',
    'FORUMUNSUBSCRIBE' => 'Ne plus surveiller ce forum',
    'FORUMSUBSCRIBE_TRUE' => 'Souscription : Activ馥',
    'FORUMSUBSCRIBE_FALSE' => 'Souscription : D駸activ馥',
    'NEWTOPIC' => 'Nouveau Sujet',
    'POSTREPLY' => 'R駱ondre',
    'SubscribeLink' => 'Surveiller',
    'unSubscribeLink' => 'Ne plus souscrire ce forum',
    'SubscribeLink_TRUE' => 'Souscription : Activ馥',
    'SubscribeLink_FALSE' => 'Souscription : D駸activ馥',
    'SUBSCRIPTIONS' => 'Souscriptions',
    'TOP' => 'En haut',
    'PRINTABLE' => 'Version imprimante',
    'USERPREFS' => 'Pr馭駻ences utilisateur',
    'SPEEDLIMIT' => '"Votre dernier message a 騁postil y a %s secondes.<br' . XHTML . '>Pour des raisons de s馗urit %s secondes sont n馗essaires entre chacune de vos publication."',
    'ACCESSERROR' => 'ACCESS ERROR',
    'ACTIONS' => 'Actions',
    'DELETEALL' => 'Supprimer tous les enregistrements s駘ectionn駸',
    'DELCONFIRM' => 'Etes-vous s皞e de vouloir supprimer les enregistrements s駘ectionn駸 ?',
    'DELALLCONFIRM' => 'Etes-vous s皞e de vouloir supprimer TOUS les enregistrements s駘ectionn駸 ?',
    'STARTEDBY' => 'Commencpar',
    'WARNING' => 'Attention',
    'MODERATED' => 'Mod駻ateurs: %s',
    'LASTREPLYBY' => 'Derni鑽e r駱onse par :&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Index du forum',
    'FEATURE' => 'Fonction',
    'SETTING' => 'R馮lage',
    'MARKALLREAD' => 'Marquer tout comme lu',
    'MSG_NO_CAT' => 'Aucune cat馮orie ou forum d馭inis',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Code',
    'FONTCOLOR' => 'Couleur de police',
    'FONTSIZE' => 'Taille de police',
    'CLOSETAGS' => 'Fermer les balises',
    'CODETIP' => 'Astuce: Les styles peuvent 黎re rapidement appliqu駸 en s駘ectionnant le texte',
    'TINY' => 'Tr鑚 petit',
    'SMALL' => 'Petit',
    'NORMAL' => 'Normal',
    'LARGE' => 'Grand',
    'HUGE' => 'Tr鑚 grand',
    'DEFAULT' => 'D馭aut',
    'DKRED' => 'Rouge fonc,
    'RED' => 'Rouge',
    'ORANGE' => 'Orange',
    'BROWN' => 'Marron',
    'YELLOW' => 'Jaune',
    'GREEN' => 'Vert',
    'OLIVE' => 'Olive',
    'CYAN' => 'Cyan',
    'BLUE' => 'Bleu',
    'DKBLUE' => 'Bleu fonc,
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Violet',
    'WHITE' => 'Blanc',
    'BLACK' => 'Noir',
    'b_help' => 'Gras : [b]texte[/b]',
    'i_help' => 'Italique : [i]texte[/i]',
    'u_help' => 'Soulign: [u]texte[/u]',
    'q_help' => 'Citation : [quote]texte[/quote]',
    'c_help' => 'Code : [code]code[/code]',
    'l_help' => 'Liste : [list]texte[/list]',
    'o_help' => 'Liste ordonn馥 : [olist]texte[/olist]',
    'p_help' => '[img]http://image_url[/img]  ou [img w=100 h=200][/img]',
    'w_help' => 'URL : [url]http://url[/url] ou [url=http://url]URL texte[/url]',
    'a_help' => 'Fermer tous les tags ouverts',
    's_help' => 'Couleur : [color=red]text[/color]  Astuce: Vous pouvez aussi utiliser color=#FF0000',
    'f_help' => 'Taille : [size=x-small]Petit texte[/size]',
    'h_help' => 'Cliquez pour plus d\'aide'
);

$LANG_GF02 = array(
    'msg01' => 'Vous devez vous connecter l\'espace membre pour consulter les forum.',
    'msg02' => 'Ce forum est en acc鑚 restreint.',
    'msg03' => 'Merci de patienter, vous allez 黎re redirig',
    'msg05' => '<CENTER><em>D駸ol aucun sujet n\'a encore 騁post</em></CENTER>',
    'msg07' => 'Utilisateurs en ligne :',
    'msg14' => 'D駸ol Vous avez 騁banni du forum.<br' . XHTML . '>',
    'msg15' => 'Si vous pensez que c\'est une erreur, contactez <A HREF="mailto:%s?subject=forum IP Ban">l\'administrateur</A>.',
    'msg18' => 'Erreur! Tous les champs requis n\'ont pas 騁remplis ou sont trop courts.',
    'msg19' => 'Votre message a 騁post',
    'msg22' => '- Notification de r駱onse au sujet',
    'msg23a' => "\nUne r駱onse a 騁faite au sujet '%s' par %s.\nCe sujet a 騁cr蜑 par : %s dans le forum de %s.\n",
    'msg23b' => "Un nouveau sujet '%s' a 騁postpar %s dans le forum %s sur %s.\nVous pouvez le voir sur la page : %s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "\nVous pouvez utiliser le lien suivant pour voir la r駱onse : %s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nMerci et bonne journ馥 ! \n",
    'msg26' => "\nVous avez re輹 ce mail parce que vous avez choisi d'黎re averti quand une r駱onse est faite ce sujet. \n",
    'msg27' => 'Si vous ne souhaitez plus surveiller ce sujet, vous pouvez cliquer sur le lien suivant : <a href="%s">here</a>',
    'msg33' => 'Auteur : ',
    'msg36' => 'Humeur',
    'msg38' => ' M\'avertir des r駱onses ',
    'msg40' => '<br' . XHTML . '>D駸ol mais vous avez d駛abonnaux r駱onses de ce sujet.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">Vous ne surveillez aucun sujet actuellement.</p>',
    'msg49' => '(Lu %s fois) ',
    'msg55' => 'Contribution effac馥.',
    'msg56' => 'IP Bannie.',
    'msg59' => 'Sujet Normal',
    'msg60' => 'Nouvelle Contribution',
    'msg61' => ' Sujet important',
    'msg62' => 'M\'avertir en cas de r駱onse',
    'msg64' => 'Etes vous s皞 de vouloir effacer le sujet %s : %s ?',
    'msg65' => '<br' . XHTML . '>Ceci est un sujet parent, toutes les r駱onses post馥s seront aussi effac馥s.',
    'msg68' => 'Note: ATTENTION QUAND VOUS BANISSEZ, seuls les administrateurs ont le droit de dbannir quelqu\'un.',
    'msg69' => '<br' . XHTML . '>Voulez vous vraiment bannir l\'adresse IP : %s?',
    'msg71' => 'Aucune fonction s駘ectionn馥, choisissez une contribution puis une fonction de mod駻ation.<br' . XHTML . '>Note: Vous devez 黎re mod駻ateur pour utiliser ces fonctions.',
    'msg72' => 'Attention,  vous n\'avez pas le droit d\'utiliser cette fonction de mod駻ation.',
    'msg74' => '%s Derni鑽es Contributions Post馥s',
    'msg75' => 'Les %s sujets les plus affich駸',
    'msg76' => 'Les %s sujets avec le plus de r駱onses',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">Vous ne devriez pas 黎re ici !<br' . XHTML . '>Acc鑚 restreint ce forum seulement.<p />',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>Vous avez besoin d\'黎re authentifipour utiliser cette fonction du forum.<p />',
    'msg84' => 'Marquer tout comme lu',
    'msg85' => 'Page :',
    'msg86' => '10 derni鑽es contributions par : ',
    'msg87' => '<br' . XHTML . '>Avertissement : Ce sujet a 騁verrouillpar un mod駻ateur.<br' . XHTML . '>Aucune nouvelle contribution n\'est possible.',
    'msg88' => 'Liste des membres',
    'msg88b' => 'Voir seulement les membres actifs dans le forum',
    'msg89' => 'Les sujets que je surveille',
    'msg101' => 'R鑒les du forum :',
    'msg103' => 'Aller dans le forum :',
    'msg106' => 'Choisir un forum',
    'msg108' => 'Forum actif',
    'msg109' => ' Sujet Verrouill,
    'msg110' => 'Transfert la page d\'馘ition...',
    'msg111' => 'Nouvelles contributions depuis votre derni鑽e visite :',
    'msg112' => 'Lire nouveaux messages',
    'msg113' => 'Nouveaux messages',
    'msg114' => 'Sujet clos',
    'msg115' => 'Nouveau sujet important',
    'msg116' => 'Nouveau sujet clos',
    'msg117' => 'Chercher dans tous les forums',
    'msg118' => 'Chercher dans ce forum',
    'msg119' => 'R駸ultats de la recherche dans le forum pour la requ黎e :',
    'msg120' => 'Sujets les plus populaires par ',
    'msg121' => 'Le fuseau horaire est %s. Il est maintenant %s.',
    'msg122' => 'Minimum Populaire :',
    'msg123' => 'Nombre de contributions d\'un sujet avant de l\'appeller populaire',
    'msg126' => 'Lignes de Recherche :',
    'msg127' => 'Nombre de lignes afficher dans les r駸ultats d\'une recherche',
    'msg128' => 'Membres par Page :',
    'msg129' => 'Nombre de membres afficher dans la page listant les membres',
    'msg130' => 'Contributions Anonymes :',
    'msg131' => 'ConfigurNon va cacher les messages sans auteur',
    'msg132' => 'Surveillance :',
    'msg133' => 'ConfigurOui va activer la surveillance automatique pour n\'importe quel sujet ovous 馗rivez',
    'msg134' => 'Surveillance ajout馥',
    'msg135' => 'Vous serez averti de toutes les contributions de ce forum.',
    'msg136' => 'Vous devez choisir un forum surveiller.',
    'msg137' => 'Surveillance pour le sujet activ,
    'msg138' => '<b>forum complet surveill/b>',
    'msg142' => 'Surveillance enregistr馥.',
    'msg144' => 'Retourner au sujet',
    'msg146' => 'Surveillance effac,
    'msg147' => 'Forum [version imprimable du sujet',
    'msg148' => '<br' . XHTML . '>Cliquez <a href="javascript:history.back()">ici</a> pour revenir la page pr馗馘ante.',
    'msg155' => 'Aucune contribution de l\'utilisateur.',
    'msg156' => 'Nombre total de contributions :',
    'msg157' => '10 derni鑽es Contributions',
    'msg158' => 'les 10 derni鑽es contributions de ',
    'msg159' => 'Etes vous s皞 de vouloir EFFACER les mod駻ateurs s駘ectionn駸 ?',
    'msg160' => 'Voir la derni鑽e page du sujet',
    'msg163' => 'Contribution d駱lac馥',
    'msg164' => 'Marquer toutes les cat馮ories et sujets comme Lus',
    'msg166' => 'ERREUR: Sujet invalide ou sujet non trouv,
    'msg167' => 'Surveillance',
    'msg168' => 'ConfigurNon pour ne plus recevoir d\'email de surveillance',
    'msg169' => 'Retour la liste des membres',
    'msg170' => 'Derni鑽es contributions',
    'msg171' => 'Message - Acc鑚 au forum',
    'msg172' => 'Sujet inexistant. Il peut avoir 騁effac',
    'msg173' => 'Transfert la page de r馘action des contributions...',
    'msg174' => 'Impossible de bannir le membre - Adresse IP non valide ou vide.',
    'msg175' => 'Retourner la liste des forums',
    'msg176' => 'Choisir un membre',
    'msg177' => 'Tous les membres',
    'msg178' => 'Uniquement les contributions parentes',
    'msg179' => 'Contenu g駭駻en %s seconde(s)',
    'msg180' => 'Alerte de publication du forum',
    'msg181' => 'Vous n\'avez acc鑚 aucun autre forum en tant que comme mod駻ateur',
    'msg182' => 'Confirmation du mod駻ateur',
    'msg183' => 'Un nouveau sujet a 騁cr鳬 partir de cette contribution dans le forum : %s',
    'msg184' => 'Notifier une fois seulement',
    'msg185' => 'Les notifications seront exp馘i馥s une seule fois pour les forums et les sujets qui recoivent plusieurs contributions depuis votre derni鑽e visite.',
    'msg186' => 'Nouveau titre',
    'msg187' => 'Retourner au sujet - Cliquez <a href="%s">ici</a>',
    'msg188' => 'Cliquer pour aller directement au dernier message',
    'msg189' => 'D駸olvous ne pouvez plus 馘iter ce message',
    'msg190' => 'Edition silencieuse',
    'msg191' => 'L\'馘ition n\'est plus possible. La dur馥 pendant laquelle vous pouviez modifier votre message a expir馥.',
    'msg192' => 'Termin.. %s sujet(s) et %s commentaire(s) ont 騁cr蜑s.',
    'msg193' => 'Utilitaire de migration d\'article vers le forum',
    'msg194' => 'Forum au repos',
    'msg195' => 'Cliquer pour aller au forum',
    'msg196' => 'Voir l\'index principal du forum',
    'msg197' => 'Marquer tous les sujets comme lus',
    'msg198' => 'Mettre jour vos pr馭駻ences pour le forum',
    'msg199' => 'Voir ou supprimer les notifications du forum',
    'msg200' => 'Voir la liste des membres',
    'msg201' => 'Voir les sujets les plus populaires',
    'msg202' => 'Pas de nouvelles contributions',
    'msg300' => 'Vos pr馭駻ences ne permettent pas l\'affichage des contributions anonymes.',
    'msg301' => 'Marquer toutes les cat馮ories comme lues ?',
    'msg302' => 'Marquer tous les sujets comme lus ?',
    'PostReply' => 'Poster une nouvelle r駱onse',
    'PostTopic' => 'Poster un nouveau sujet',
    'EditTopic' => 'Editer le sujet',
    'quietforum' => 'Le forum n{a pas de nouveau sujet.'
);

$LANG_GF03 = array(
    'delete' => 'Effacer le message',
    'edit' => 'Editer le message',
    'move' => 'D駱lacer le message',
    'split' => 'Ceinder le sujet',
    'ban' => 'Bannir l\'IP',
    'movetopic' => 'D駱lacer et cr馥r un nouveau fil',
    'movetopicmsg' => '<br' . XHTML . '>Sujet d駱lacer : "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>Cr馥r un nouveau sujet avec ce message: "<b>%s</b>"<br' . XHTML . '><em>De :</em>&nbsp;%s&nbsp <em>Le :</em>&nbsp;%s',
    'selectforum' => 'Choisir un nouveau forum :',
    'lockedpost' => 'Ajouter une r駱onse',
    'splitheading' => 'Option de scission du fil :',
    'splitopt1' => 'D駱lacer tous les messages partir d\'ici',
    'splitopt2' => 'D駱lacer seulement ce message'
);

$LANG_GF04 = array(
    'label_forum' => 'Profile pour le forum',
    'label_location' => 'Localisation',
    'label_aim' => 'Pseudo AIM',
    'label_yim' => 'Pseudo Yahoo',
    'label_icq' => 'Num駻o ICQ',
    'label_msnm' => 'Adresse MS Messenger',
    'label_interests' => 'Loisirs',
    'label_occupation' => 'Emploi'
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
    1 => 'Statistiques',
    2 => 'Configuration',
    3 => 'Forums',
    4 => 'Mod駻ateur',
    5 => 'Conversion',
    6 => 'Messages',
    7 => 'Gestion IP'
);

$LANG_GF07 = array(
    1 => 'Voir les forums',
    2 => 'Pr馭駻ences',
    3 => 'Sujets les plus populaires',
    4 => 'Surveillance',
    5 => 'Membres'
);

$LANG_GF08 = array(
    1 => 'Surveillance des sujets',
    2 => 'Surveillance des forums',
    3 => 'Exception des notifications de sujet'
);

$LANG_GF09 = array(
    'edit' => 'Edit',
    'email' => 'Email',
    'home' => 'Accueil',
    'lastpost' => 'Dernier message',
    'pm' => 'PM',
    'profile' => 'Profil',
    'quote' => 'Citer',
    'website' => 'Website',
    'newtopic' => 'Nouveau',
    'replytopic' => 'R駱ondre'
);

$LANG_GF91 = array(
    'gfstats' => 'Statistiques du forum',
    'statsmsg' => 'Statistiques du forum :',
    'totalcats' => 'Total Cat馮ories :',
    'totalforums' => 'Total forums :',
    'totaltopics' => 'Total Sujets :',
    'totalposts' => 'Total Contributions :',
    'totalviews' => 'Total Affichages :',
    'avgpmsg' => 'Moyenne des contributions par :',
    'category' => 'Categorie :',
    'forum' => 'Forum :',
    'topic' => 'Sujet :',
    'avgvmsg' => 'Moyenne des affichages par :'
);

$LANG_GF92 = array(
    'gfsettings' => 'Configuration du forum',
    'showiframe' => 'Revue du Sujet :',
    'showiframedscp' => 'Afficher la revue du Sujet (dans une Iframe) quand vous r駱ondez un sujet',
    'topicspp' => 'Sujets par Page :',
    'topicsppdscp' => 'Nombre de sujets afficher quand le forum est affich,
    'postspp' => 'Contributions par Page :',
    'postsppdscp' => 'Nombre de contributions affich馥s par page',
    'setsavemsg' => 'Pr馭駻ences sauv馥s.'
);

$LANG_GF93 = array(
    'gfboard' => 'Administration du forum de Discussion',
    'addcat' => 'Ajout d\'une Cat馮orie de forum',
    'addforum' => 'Ajout d\'un forum',
    'catorder' => 'Ordre de cat馮orie',
    'catadded' => 'Cat馮orie ajout馥.',
    'catdeleted' => 'Cat馮orie effac馥.',
    'catedited' => 'Cat馮orie edit馥.',
    'forumadded' => 'Forum ajout',
    'forumaddError' => 'Erreur d\'ajout de forum.',
    'forumdeleted' => 'Forum effac,
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum Edited',
    'forumordered' => 'Forum Order Edited',
    'back' => 'Retour',
    'addnote' => 'Note : Vous pouvez 馘iter ces valeurs.',
    'editforumnote' => 'Edition des caract駻istiques du forum : <b>"%s"</b>',
    'deleteforumnote1' => 'Voulez-vous effacer le forum <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Tous les sujets post駸 en dessous vont 黎re aussi effac駸.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Edition des caract駻istiques de la cat馮orie : <b>"%s"</b>',
    'deletecatnote1' => 'Voulez-vous effacer la cat馮orie <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Tous les forums et sujets post駸 sous ce forum vont 黎re aussi effac駸.',
    'undercat' => 'Sous Cat馮orie',
    'groupaccess' => 'Acc鑚 pour le Groupe : ',
    'action' => 'Actions',
    'forumdescription' => 'Description du forum',
    'posts' => 'Contributions',
    'ordertitle' => 'Ordre',
    'ModEdit' => 'Editer',
    'ModMove' => 'D駱lacer',
    'ModStick' => 'Post-it',
    'ModBan' => 'Bannir',
    'addmoderator' => 'Ajouter un mod駻ateur',
    'delmoderator' => 'Effacer la s駘ection',
    'moderatorwarning' => '<b>Attention: Aucun forum n\'est d馭ini</b><br' . XHTML . '><br' . XHTML . '>Configurez les cat馮ories du forum et ajoutez au moins 1 forum<br' . XHTML . '>avant d\'essayer d\'ajouter des mod駻ateurs',
    'private' => 'Forum priv,
    'filtertitle' => 'Selectionner les mod駻ateurs enregistr駸 afficher',
    'addmessage' => 'Ajouter un  nouveau mod駻ateur',
    'allowedfunctions' => 'Fonctions permises',
    'userrecords' => 'Utilisateurs',
    'grouprecords' => 'Groupes',
    'filterview' => 'Filtrer l\'affichage',
    'readonly' => 'Forum en lecture seule',
    'readonlydscp' => 'Uniquement les mod駻ateurs peuvent contribuer dans ce forum',
    'hidden' => 'Forum cach,
    'hiddendscp' => 'Le forum n\'apparait pas l\'index des forums',
    'hideposts' => 'Cacher les nouvelles cobntributions',
    'hidepostsdscp' => 'Les mises jour ne seront pas montr馥s dans le bloc des nouvelles contributions ou dans le flux RSS',
    'mod_title' => 'Mod駻ateurs du forum',
    'allforums' => 'Tous les forums'
);

$LANG_GF95 = array(
    'header1' => 'Messages du forum',
    'header2' => 'Messages du forum pour le forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Fonction non encore impl駑ent馥.',
    'delall' => 'Effacer Tout',
    'delallmsg' => 'Etes vous s皞 de vouloir effacer tous les messages de : %s?',
    'underforum' => '<b>Sous forum: %s (ID #%s)',
    'moderate' => 'Mod駻er',
    'nomess' => 'Il n\'y a encore aucun message post! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Saisir ci-dessous l\'IP a bannir',
    'gfipman' => 'Gestion IP',
    'ban' => 'Bannir',
    'noips' => '<p style="margin:0px; padding:5px;">Aucune adresse IP n\'a encore 騁bannie !</p>',
    'unban' => 'DBannir',
    'ipbanned' => 'Adresse IP bannies',
    'banip' => 'Confirmation de Bannissement de l\'IP',
    'banipmsg' => 'Etes-vous s皞e de vouloir bannir l\'adresse ip %s?',
    'specip' => 'Veuillez sp馗ifier une adresse IP bannir !',
    'ipunbanned' => 'Adresse IP n\'est plus bannie.',
    'noip' => 'Vous n\'avez pas fourni une adresse IP !'
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
$PLG_forum_MESSAGE1 = 'Mise niveau du plugin forum : Mise jour r騏ssie.';
$PLG_forum_MESSAGE2 = 'Mise niveau du plugin forum : Impossible de mettre jour automatiquement cette version. Merci de vous r馭駻er la documentation.';
$PLG_forum_MESSAGE5 = 'La mise niveau du plugin forum a 馗hou馥 - Consultez le fichier error.log';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['forum'] = array(
    'label' => 'Forum',
    'title' => 'Configuration du forum'
);

$LANG_confignames['forum'] = array(
    'registration_required' => 'Connexion n馗essaire pour voir les contributions ?',
    'registered_to_post' => 'Connexion n馗essaire pour contribuer ?',
    'allow_notification' => 'Permettre les notifications ?',
    'show_topicreview' => 'Montrer les messages pr馗馘ants lors de la r馘action d\'une r駱onse ?',
    'allow_user_dateformat' => 'Permettre l\'utilisateur de d馭inir le format de la date ?',
    'use_pm_plugin' => 'Utiliser le plugin Private Message ?',
    'show_topics_perpage' => 'Nombre de sujets par page',
    'show_posts_perpage' => 'Nombre de contributions par page',
    'show_messages_perpage' => 'Nombre de lignes d\'un message par page',
    'show_searches_perpage' => 'Nombre de r駸ultats de la recherche par page',
    'showblocks' => 'Colonne des blocs montrer dans le forum',
    'usermenu' => 'Type du menu utilisateur',
    'use_themes_template' => 'Use templates in the theme directory',
    'show_subject_length' => 'Longueur maximale du sujet',
    'min_username_length' => 'Longueur minimale du nom d\'utiliateur',
    'min_subject_length' => 'Longueur minimale du sujet',
    'min_comment_length' => 'Longueur minimale de la contribution',
    'views_tobe_popular' => 'Nombre de vues pour 黎re populaire',
    'post_speedlimit' => 'Limitation entre chaque contribution en secondes',
    'allowed_editwindow' => 'Permission de modification des contributions en secondes',
    'allow_html' => 'Permettre le mode HTML ?',
    'post_htmlmode' => 'D馭inir le mode HTML par d馭aut ?',
    'convert_break' => 'Convertir les sauts la ligne par une balise HTML &lt;BR&gt;?',
    'use_censor' => 'Utiliser le mode censure du CMS Geeklog ?',
    'use_glfilter' => 'Utiliser le mode filtre du CMS Geeklog ?',
    'use_geshi' => 'Utiliser la colorisation synthaxique Geshi du Code ?',
    'use_spamx_filter' => 'Utiliser le plugin Spam-X ?',
    'show_moods' => 'Activer les humeurs (Moods) ?',
    'allow_smilies' => 'Activer les Smilies?',
    'use_smilies_plugin' => 'Utiliser le plugin Smilies ?',
    'avatar_width' => 'Largeur de l\'avatar',
    'show_centerblock' => 'Activer le bloc central (Centerblock) ?',
    'centerblock_homepage' => 'Activer sur la page d\'accueil seulement ?',
    'centerblock_numposts' => 'Nombre de contribution afficher dans le bloc central',
    'cb_subject_size' => 'Longueur maximale des sujets',
    'centerblock_where' => 'Placement du bloc central sur la page',
    'sideblock_numposts' => 'Nombre de contributions afficher',
    'sb_subject_size' => 'Longueur lmaximale des sujets',
    'sb_latestpostonly' => 'Afficher uniquement les derni鑽es contributions ?',
    'sideblock_enable' => 'Enabled',
    'sideblock_isleft' => 'Display Block on Left',
    'sideblock_order' => 'Block Order',
    'sideblock_topic_option' => 'Topic Options',
    'sideblock_topic' => 'Topic',
    'sideblock_group_id' => 'Group',
    'sideblock_permissions' => 'Permissions',
    'level1' => 'Nombre de contribution niveau 1',
    'level2' => 'Nombre de contribution niveau 2',
    'level3' => 'Nombre de contribution niveau 3',
    'level4' => 'Nombre de contribution niveau 4',
    'level5' => 'Nombre de contribution niveau 5',
    'level1name' => 'Nom du niveau 1',
    'level2name' => 'Nom du niveau 2',
    'level3name' => 'Nom du niveau 3',
    'level4name' => 'Nom du niveau 4',
    'level5name' => 'Nom du niveau 5',
    'menublock_enable' => 'Enabled',
    'menublock_isleft' => 'Display Block on Left',
    'menublock_order' => 'Block Order',
    'menublock_topic_option' => 'Topic Options',
    'menublock_topic' => 'Topic',
    'menublock_group_id' => 'Group',
    'menublock_permissions' => 'Permissions'
);

$LANG_configsubgroups['forum'] = array(
    'sg_main' => 'Param鑼res principaux'
);

$LANG_tab['forum'] = array(
    'tab_main' => 'Param鑼res g駭駻aux du forum',
    'tab_topicposting' => 'Publier une contribution',
    'tab_centerblock' => 'Le bloc central',
    'tab_sideblock' => 'Les barres lat駻ales',
    'tab_rank' => 'Les niveaux',
    'tab_menublock' => 'Menu Block'
);

$LANG_fs['forum'] = array(
    'fs_main' => 'Param鑼res g駭駻aux du forum',
    'fs_topicposting' => 'Publier une contribution',
    'fs_centerblock' => 'Le bloc central',
    'fs_sideblock' => 'Les barres lat駻ales',
    'fs_sideblock_settings' => 'Block Settings',
    'fs_sideblock_permissions' => 'Block Permissions',
    'fs_rank' => 'Les niveaux',
    'fs_menublock' => 'Menu Block',
    'fs_menublock_settings' => 'Block Settings',
    'fs_menublock_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['forum'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    5 => array('En haut de la page' => 1, 'Apr鑚 l \'article en vedette' => 2, 'En bas de la page' => 3),
    6 => array('Blocs de gauche' => 'leftblocks', 'Blocs de droite' => 'rightblocks', 'Tous les blocs' => 'allblocks', 'Aucun bloc' => 'noblocks'),
    7 => array('Menu dans un bloc' => 'blockmenu', 'Barre de navigation' => 'navbar', 'Aucun' => 'none'),
    12 => array('Pas d\'acc鑚' => 0, 'Lecture-Seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
