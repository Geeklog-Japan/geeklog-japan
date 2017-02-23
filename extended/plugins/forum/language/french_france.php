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
    'statsheading2' => 'Les 10 sujets du forum comportant le plus de réponses',
    'statsheading3' => 'Aucun sujet',
    'useradminmenu' => 'Préférences du forum',
    'access_denied' => 'Accès réservé aux membres',
    'autotag_desc_forum' => '[forum: id titre alternatif] - Affiche un lien vers un sujet du forum en utilisant le texte "ici" comme titre. Un titre alternatif peut être spécifié.'
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
    'UPDATE' => 'Mise à jour',
    'SAVE' => 'Sauver',
    'CANCEL' => 'Annuler',
    'ON' => 'Le ',
    'ON2' => '&nbsp;&nbsp;<b>On: </b>',
    'BY' => 'Par : ',
    'RE' => 'Re : ',
    'DATE' => 'Date',
    'VIEWS' => 'Vu',
    'REPLIES' => 'Réponses',
    'NAME' => 'Nom :',
    'DESCRIPTION' => 'Description : ',
    'TOPIC' => 'Sujet',
    'TOPICS' => 'Sujets',
    'TOPICSUBJECT' => 'Contributions',
    'HOMEPAGE' => 'Accueil',
    'SUBJECT' => 'Sujet',
    'HELLO' => 'Bonjour ',
    'MOVED' => 'Déplacé',
    'POSTS' => 'Contributions',
    'LASTPOST' => 'Dernière',
    'POSTEDON' => 'Posté le',
    'POSTEDBY' => 'Posté par',
    'PAGES' => 'Pages',
    'TODAY' => 'Aujourd\'hui à ',
    'REGISTERED' => 'Enregistré',
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
    'PREVIEW' => 'Prévisualiser',
    'REMOVE' => 'Enlever',
    'EDIT' => 'Editer',
    'DELETE' => 'Effacer',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Options',
    'MISSINGSUBJECT' => 'Sujet vide',
    'MIGRATE_NOW' => 'Migrer maintenant',
    'FILTERLIST' => 'Filtrer la liste',
    'SELECTFORUM' => 'Choisir le forum',
    'DELETEAFTER' => 'Supprimer après',
    'TITLE' => 'Titre',
    'COMMENTS' => 'Commentaires',
    'SUBMISSIONS' => 'Soumissions',
    'HTML_FILTER_MSG' => 'HTML filtré permis',
    'HTML_FULL_MSG' => 'Tout HTML autorisé',
    'HTML_MSG' => 'HTML autorisé',
    'CENSOR_PERM_MSG' => 'Contrôle vocabulaire',
    'ANON_PERM_MSG' => 'Vous pouvez lire ce forum',
    'POST_PERM_MSG1' => 'Vous pouvez poster dans ce forum',
    'POST_PERM_MSG2' => 'Les anonymes peuvent dans ce forum',
    'GO' => 'Ok',
    'STATUS' => 'Status :',
    'ONLINE' => 'en ligne',
    'OFFLINE' => 'hors ligne',
    'back2parent' => 'Sujet Parent',
    'forumname' => '',
    'category' => 'Catégorie: ',
    'loginreqview' => '<B>Merci de vous %s inscrire</A> ou vous %s identifier</A> pour utiliser ce forum.</B>',
    'loginreqpost' => '<B>Merci de vous inscrire ou vous identifier pour utiliser ce forum. Vous allez être redirigé.</B>',
    'nolastpostmsg' => 'N/A',
    'no_one' => 'Aucun.',
    'back2top' => 'Retour en haut',
    'TEXTMODE' => 'Mode Texte',
    'HTMLMODE' => 'Mode HTML',
    'TopicPreview' => 'Prévisualisation de la Réponse',
    'moderator' => 'Moderateur',
    'admin' => 'Admin',
    'DATEADDED' => 'Ajouté le',
    'PREVTOPIC' => 'Sujet Précédent',
    'NEXTTOPIC' => 'Sujet Suivant',
    'RESYNC' => 'ReSynchroniser',
    'RESYNCCAT' => 'ReSynchroniser les catégories',
    'EDITICON' => '&nbsp;Editer&nbsp;',
    'QUOTEICON' => '&nbsp;Citer&nbsp;',
    'ProfileLink' => '&nbsp;Profile&nbsp;',
    'WebsiteLink' => '&nbsp;Site web&nbsp;',
    'PMLink' => '&nbsp;Envoyer un Message Privé&nbsp;',
    'EmailLink' => '&nbsp;Email&nbsp;',
    'FORUMSUBSCRIBE' => 'Surveiller ce forum',
    'FORUMUNSUBSCRIBE' => 'Ne plus surveiller ce forum',
    'FORUMSUBSCRIBE_TRUE' => 'Souscription : Activée',
    'FORUMSUBSCRIBE_FALSE' => 'Souscription : Désactivée',
    'NEWTOPIC' => 'Nouveau Sujet',
    'POSTREPLY' => 'Répondre',
    'SubscribeLink' => 'Surveiller',
    'unSubscribeLink' => 'Ne plus souscrire à ce forum',
    'SubscribeLink_TRUE' => 'Souscription : Activée',
    'SubscribeLink_FALSE' => 'Souscription : Désactivée',
    'SUBSCRIPTIONS' => 'Souscriptions',
    'TOP' => 'En haut',
    'PRINTABLE' => 'Version imprimante',
    'USERPREFS' => 'Préférences utilisateur',
    'SPEEDLIMIT' => '"Votre dernier message a été posté il y a %s secondes.<br' . XHTML . '>Pour des raisons de sécurité, %s secondes sont nécessaires entre chacune de vos publication."',
    'ACCESSERROR' => 'ACCESS ERROR',
    'ACTIONS' => 'Actions',
    'DELETEALL' => 'Supprimer tous les enregistrements sélectionnés',
    'DELCONFIRM' => 'Etes-vous sûre de vouloir supprimer les enregistrements sélectionnés ?',
    'DELALLCONFIRM' => 'Etes-vous sûre de vouloir supprimer TOUS les enregistrements sélectionnés ?',
    'STARTEDBY' => 'Commencé par',
    'WARNING' => 'Attention',
    'MODERATED' => 'Modérateurs: %s',
    'LASTREPLYBY' => 'Dernière réponse par :&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Index du forum',
    'FEATURE' => 'Fonction',
    'SETTING' => 'Réglage',
    'MARKALLREAD' => 'Marquer tout comme lu',
    'MSG_NO_CAT' => 'Aucune catégorie ou forum définis',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Code',
    'FONTCOLOR' => 'Couleur de police',
    'FONTSIZE' => 'Taille de police',
    'CLOSETAGS' => 'Fermer les balises',
    'CODETIP' => 'Astuce: Les styles peuvent être rapidement appliqués en sélectionnant le texte',
    'TINY' => 'Très petit',
    'SMALL' => 'Petit',
    'NORMAL' => 'Normal',
    'LARGE' => 'Grand',
    'HUGE' => 'Très grand',
    'DEFAULT' => 'Défaut',
    'DKRED' => 'Rouge foncé',
    'RED' => 'Rouge',
    'ORANGE' => 'Orange',
    'BROWN' => 'Marron',
    'YELLOW' => 'Jaune',
    'GREEN' => 'Vert',
    'OLIVE' => 'Olive',
    'CYAN' => 'Cyan',
    'BLUE' => 'Bleu',
    'DKBLUE' => 'Bleu foncé',
    'INDIGO' => 'Indigo',
    'VIOLET' => 'Violet',
    'WHITE' => 'Blanc',
    'BLACK' => 'Noir',
    'b_help' => 'Gras : [b]texte[/b]',
    'i_help' => 'Italique : [i]texte[/i]',
    'u_help' => 'Souligné : [u]texte[/u]',
    'q_help' => 'Citation : [quote]texte[/quote]',
    'c_help' => 'Code : [code]code[/code]',
    'l_help' => 'Liste : [list]texte[/list]',
    'o_help' => 'Liste ordonnée : [olist]texte[/olist]',
    'p_help' => '[img]http://image_url[/img]  ou [img w=100 h=200][/img]',
    'w_help' => 'URL : [url]http://url[/url] ou [url=http://url]URL texte[/url]',
    'a_help' => 'Fermer tous les tags ouverts',
    's_help' => 'Couleur : [color=red]text[/color]  Astuce: Vous pouvez aussi utiliser color=#FF0000',
    'f_help' => 'Taille : [size=x-small]Petit texte[/size]',
    'h_help' => 'Cliquez pour plus d\'aide'
);

$LANG_GF02 = array(
    'msg01' => 'Vous devez vous connecter à l\'espace membre pour consulter les forum.',
    'msg02' => 'Ce forum est en accès restreint.',
    'msg03' => 'Merci de patienter, vous allez être redirigé.',
    'msg05' => '<CENTER><em>Désolé, aucun sujet n\'a encore été posté.</em></CENTER>',
    'msg07' => 'Utilisateurs en ligne :',
    'msg14' => 'Désolé, Vous avez été banni du forum.<br' . XHTML . '>',
    'msg15' => 'Si vous pensez que c\'est une erreur, contactez <A HREF="mailto:%s?subject=forum IP Ban">l\'administrateur</A>.',
    'msg18' => 'Erreur! Tous les champs requis n\'ont pas été remplis ou sont trop courts.',
    'msg19' => 'Votre message a été posté.',
    'msg22' => '- Notification de réponse au sujet',
    'msg23a' => "\nUne réponse a été faite au sujet '%s' par %s.\nCe sujet a été créé par : %s dans le forum de %s.\n",
    'msg23b' => "Un nouveau sujet '%s' a été posté par %s dans le forum %s sur %s.\nVous pouvez le voir sur la page : %s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "\nVous pouvez utiliser le lien suivant pour voir la réponse : %s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nMerci et bonne journée ! \n",
    'msg26' => "\nVous avez reçu ce mail parce que vous avez choisi d'être averti quand une réponse est faite à ce sujet. \n",
    'msg27' => 'Si vous ne souhaitez plus surveiller ce sujet, vous pouvez cliquer sur le lien suivant : <a href="%s">here</a>',
    'msg33' => 'Auteur : ',
    'msg36' => 'Humeur',
    'msg38' => ' M\'avertir des réponses ',
    'msg40' => '<br' . XHTML . '>Désolé, mais vous avez déjà abonné aux réponses de ce sujet.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">Vous ne surveillez aucun sujet actuellement.</p>',
    'msg49' => '(Lu %s fois) ',
    'msg55' => 'Contribution effacée.',
    'msg56' => 'IP Bannie.',
    'msg59' => 'Sujet Normal',
    'msg60' => 'Nouvelle Contribution',
    'msg61' => ' Sujet important',
    'msg62' => 'M\'avertir en cas de réponse',
    'msg64' => 'Etes vous sûr de vouloir effacer le sujet %s : %s ?',
    'msg65' => '<br' . XHTML . '>Ceci est un sujet parent, toutes les réponses postées seront aussi effacées.',
    'msg68' => 'Note: ATTENTION QUAND VOUS BANISSEZ, seuls les administrateurs ont le droit de dé-bannir quelqu\'un.',
    'msg69' => '<br' . XHTML . '>Voulez vous vraiment bannir l\'adresse IP : %s?',
    'msg71' => 'Aucune fonction sélectionnée, choisissez une contribution puis une fonction de modération.<br' . XHTML . '>Note: Vous devez être modérateur pour utiliser ces fonctions.',
    'msg72' => 'Attention,  vous n\'avez pas le droit d\'utiliser cette fonction de modération.',
    'msg74' => '%s Dernières Contributions Postées',
    'msg75' => 'Les %s sujets les plus affichés',
    'msg76' => 'Les %s sujets avec le plus de réponses',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">Vous ne devriez pas être ici !<br' . XHTML . '>Accès restreint à ce forum seulement.<p />',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>Vous avez besoin d\'être authentifié pour utiliser cette fonction du forum.<p />',
    'msg84' => 'Marquer tout comme lu',
    'msg85' => 'Page :',
    'msg86' => '10 dernières contributions par : ',
    'msg87' => '<br' . XHTML . '>Avertissement : Ce sujet a été verrouillé par un modérateur.<br' . XHTML . '>Aucune nouvelle contribution n\'est possible.',
    'msg88' => 'Liste des membres',
    'msg88b' => 'Voir seulement les membres actifs dans le forum',
    'msg89' => 'Les sujets que je surveille',
    'msg101' => 'Règles du forum :',
    'msg103' => 'Aller dans le forum :',
    'msg106' => 'Choisir un forum',
    'msg108' => 'Forum actif',
    'msg109' => ' Sujet Verrouillé',
    'msg110' => 'Transfert à la page d\'édition...',
    'msg111' => 'Nouvelles contributions depuis votre dernière visite :',
    'msg112' => 'Lire nouveaux messages',
    'msg113' => 'Nouveaux messages',
    'msg114' => 'Sujet clos',
    'msg115' => 'Nouveau sujet important',
    'msg116' => 'Nouveau sujet clos',
    'msg117' => 'Chercher dans tous les forums',
    'msg118' => 'Chercher dans ce forum',
    'msg119' => 'Résultats de la recherche dans le forum pour la requête :',
    'msg120' => 'Sujets les plus populaires par ',
    'msg121' => 'Le fuseau horaire est %s. Il est maintenant %s.',
    'msg122' => 'Minimum Populaire :',
    'msg123' => 'Nombre de contributions d\'un sujet avant de l\'appeller populaire',
    'msg126' => 'Lignes de Recherche :',
    'msg127' => 'Nombre de lignes à afficher dans les résultats d\'une recherche',
    'msg128' => 'Membres par Page :',
    'msg129' => 'Nombre de membres à afficher dans la page listant les membres',
    'msg130' => 'Contributions Anonymes :',
    'msg131' => 'Configuré à Non va cacher les messages sans auteur',
    'msg132' => 'Surveillance :',
    'msg133' => 'Configuré à Oui va activer la surveillance automatique pour n\'importe quel sujet où vous écrivez',
    'msg134' => 'Surveillance ajoutée',
    'msg135' => 'Vous serez averti de toutes les contributions de ce forum.',
    'msg136' => 'Vous devez choisir un forum à surveiller.',
    'msg137' => 'Surveillance pour le sujet activé',
    'msg138' => '<b>forum complet surveillé</b>',
    'msg142' => 'Surveillance enregistrée.',
    'msg144' => 'Retourner au sujet',
    'msg146' => 'Surveillance effacé',
    'msg147' => 'Forum [version imprimable du sujet %s]',
    'msg148' => '<br' . XHTML . '>Cliquez <a href="javascript:history.back()">ici</a> pour revenir à la page précédante.',
    'msg155' => 'Aucune contribution de l\'utilisateur.',
    'msg156' => 'Nombre total de contributions :',
    'msg157' => '10 dernières Contributions',
    'msg158' => 'les 10 dernières contributions de ',
    'msg159' => 'Etes vous sûr de vouloir EFFACER les modérateurs sélectionnés ?',
    'msg160' => 'Voir la dernière page du sujet',
    'msg163' => 'Contribution déplacée',
    'msg164' => 'Marquer toutes les catégories et sujets comme Lus',
    'msg166' => 'ERREUR: Sujet invalide ou sujet non trouvé',
    'msg167' => 'Surveillance',
    'msg168' => 'Configuré à Non pour ne plus recevoir d\'email de surveillance',
    'msg169' => 'Retour à la liste des membres',
    'msg170' => 'Dernières contributions',
    'msg171' => 'Message - Accès au forum',
    'msg172' => 'Sujet inexistant. Il peut avoir été effacé.',
    'msg173' => 'Transfert à la page de rédaction des contributions...',
    'msg174' => 'Impossible de bannir le membre - Adresse IP non valide ou vide.',
    'msg175' => 'Retourner à la liste des forums',
    'msg176' => 'Choisir un membre',
    'msg177' => 'Tous les membres',
    'msg178' => 'Uniquement les contributions parentes',
    'msg179' => 'Contenu généré en %s seconde(s)',
    'msg180' => 'Alerte de publication du forum',
    'msg181' => 'Vous n\'avez accès à aucun autre forum en tant que comme modérateur',
    'msg182' => 'Confirmation du modérateur',
    'msg183' => 'Un nouveau sujet a été créé à partir de cette contribution dans le forum : %s',
    'msg184' => 'Notifier une fois seulement',
    'msg185' => 'Les notifications seront expédiées une seule fois pour les forums et les sujets qui recoivent plusieurs contributions depuis votre dernière visite.',
    'msg186' => 'Nouveau titre',
    'msg187' => 'Retourner au sujet - Cliquez <a href="%s">ici</a>',
    'msg188' => 'Cliquer pour aller directement au dernier message',
    'msg189' => 'Désolé vous ne pouvez plus éditer ce message',
    'msg190' => 'Edition silencieuse',
    'msg191' => 'L\'édition n\'est plus possible. La durée pendant laquelle vous pouviez modifier votre message a expirée.',
    'msg192' => 'Terminé... %s sujet(s) et %s commentaire(s) ont été créés.',
    'msg193' => 'Utilitaire de migration d\'article vers le forum',
    'msg194' => 'Forum au repos',
    'msg195' => 'Cliquer pour aller au forum',
    'msg196' => 'Voir l\'index principal du forum',
    'msg197' => 'Marquer tous les sujets comme lus',
    'msg198' => 'Mettre à jour vos préférences pour le forum',
    'msg199' => 'Voir ou supprimer les notifications du forum',
    'msg200' => 'Voir la liste des membres',
    'msg201' => 'Voir les sujets les plus populaires',
    'msg202' => 'Pas de nouvelles contributions',
    'msg300' => 'Vos préférences ne permettent pas l\'affichage des contributions anonymes.',
    'msg301' => 'Marquer toutes les catégories comme lues ?',
    'msg302' => 'Marquer tous les sujets comme lus ?',
    'PostReply' => 'Poster une nouvelle réponse',
    'PostTopic' => 'Poster un nouveau sujet',
    'EditTopic' => 'Editer le sujet',
    'quietforum' => 'Le forum n{a pas de nouveau sujet.'
);

$LANG_GF03 = array(
    'delete' => 'Effacer le message',
    'edit' => 'Editer le message',
    'move' => 'Déplacer le message',
    'split' => 'Ceinder le sujet',
    'ban' => 'Bannir l\'IP',
    'movetopic' => 'Déplacer et créer un nouveau fil',
    'movetopicmsg' => '<br' . XHTML . '>Sujet à déplacer : "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>Créer un nouveau sujet avec ce message: "<b>%s</b>"<br' . XHTML . '><em>De :</em>&nbsp;%s&nbsp <em>Le :</em>&nbsp;%s',
    'selectforum' => 'Choisir un nouveau forum :',
    'lockedpost' => 'Ajouter une réponse',
    'splitheading' => 'Option de scission du fil :',
    'splitopt1' => 'Déplacer tous les messages à partir d\'ici',
    'splitopt2' => 'Déplacer seulement ce message'
);

$LANG_GF04 = array(
    'label_forum' => 'Profile pour le forum',
    'label_location' => 'Localisation',
    'label_aim' => 'Pseudo AIM',
    'label_yim' => 'Pseudo Yahoo',
    'label_icq' => 'Numéro ICQ',
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
    4 => 'Modérateur',
    5 => 'Conversion',
    6 => 'Messages',
    7 => 'Gestion IP'
);

$LANG_GF07 = array(
    1 => 'Voir les forums',
    2 => 'Préférences',
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
    'replytopic' => 'Répondre'
);

$LANG_GF91 = array(
    'gfstats' => 'Statistiques du forum',
    'statsmsg' => 'Statistiques du forum :',
    'totalcats' => 'Total Catégories :',
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
    'showiframedscp' => 'Afficher la revue du Sujet (dans une Iframe) quand vous répondez à un sujet',
    'topicspp' => 'Sujets par Page :',
    'topicsppdscp' => 'Nombre de sujets à afficher quand le forum est affiché',
    'postspp' => 'Contributions par Page :',
    'postsppdscp' => 'Nombre de contributions affichées par page',
    'setsavemsg' => 'Préférences sauvées.'
);

$LANG_GF93 = array(
    'gfboard' => 'Administration du forum de Discussion',
    'addcat' => 'Ajout d\'une Catégorie de forum',
    'addforum' => 'Ajout d\'un forum',
    'catorder' => 'Ordre de catégorie',
    'catadded' => 'Catégorie ajoutée.',
    'catdeleted' => 'Catégorie effacée.',
    'catedited' => 'Catégorie editée.',
    'forumadded' => 'Forum ajouté.',
    'forumaddError' => 'Erreur d\'ajout de forum.',
    'forumdeleted' => 'Forum effacé',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Forum Edited',
    'forumordered' => 'Forum Order Edited',
    'back' => 'Retour',
    'addnote' => 'Note : Vous pouvez éditer ces valeurs.',
    'editforumnote' => 'Edition des caractéristiques du forum : <b>"%s"</b>',
    'deleteforumnote1' => 'Voulez-vous effacer le forum <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Tous les sujets postés en dessous vont être aussi effacés.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Edition des caractéristiques de la catégorie : <b>"%s"</b>',
    'deletecatnote1' => 'Voulez-vous effacer la catégorie <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Tous les forums et sujets postés sous ce forum vont être aussi effacés.',
    'undercat' => 'Sous Catégorie',
    'groupaccess' => 'Accès pour le Groupe : ',
    'action' => 'Actions',
    'forumdescription' => 'Description du forum',
    'posts' => 'Contributions',
    'ordertitle' => 'Ordre',
    'ModEdit' => 'Editer',
    'ModMove' => 'Déplacer',
    'ModStick' => 'Post-it',
    'ModBan' => 'Bannir',
    'addmoderator' => 'Ajouter un modérateur',
    'delmoderator' => 'Effacer la sélection',
    'moderatorwarning' => '<b>Attention: Aucun forum n\'est défini</b><br' . XHTML . '><br' . XHTML . '>Configurez les catégories du forum et ajoutez au moins 1 forum<br' . XHTML . '>avant d\'essayer d\'ajouter des modérateurs',
    'private' => 'Forum privé',
    'filtertitle' => 'Selectionner les modérateurs enregistrés à afficher',
    'addmessage' => 'Ajouter un  nouveau modérateur',
    'allowedfunctions' => 'Fonctions permises',
    'userrecords' => 'Utilisateurs',
    'grouprecords' => 'Groupes',
    'filterview' => 'Filtrer l\'affichage',
    'readonly' => 'Forum en lecture seule',
    'readonlydscp' => 'Uniquement les modérateurs peuvent contribuer dans ce forum',
    'hidden' => 'Forum caché',
    'hiddendscp' => 'Le forum n\'apparait pas à l\'index des forums',
    'hideposts' => 'Cacher les nouvelles cobntributions',
    'hidepostsdscp' => 'Les mises à jour ne seront pas montrées dans le bloc des nouvelles contributions ou dans le flux RSS',
    'mod_title' => 'Modérateurs du forum',
    'allforums' => 'Tous les forums'
);

$LANG_GF95 = array(
    'header1' => 'Messages du forum',
    'header2' => 'Messages du forum pour le forum&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Fonction non encore implémentée.',
    'delall' => 'Effacer Tout',
    'delallmsg' => 'Etes vous sûr de vouloir effacer tous les messages de : %s?',
    'underforum' => '<b>Sous forum: %s (ID #%s)',
    'moderate' => 'Modérer',
    'nomess' => 'Il n\'y a encore aucun message posté ! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Saisir ci-dessous l\'IP a bannir',
    'gfipman' => 'Gestion IP',
    'ban' => 'Bannir',
    'noips' => '<p style="margin:0px; padding:5px;">Aucune adresse IP n\'a encore été bannie !</p>',
    'unban' => 'Dé-Bannir',
    'ipbanned' => 'Adresse IP bannies',
    'banip' => 'Confirmation de Bannissement de l\'IP',
    'banipmsg' => 'Etes-vous sûre de vouloir bannir l\'adresse ip %s?',
    'specip' => 'Veuillez spécifier une adresse IP à bannir !',
    'ipunbanned' => 'Adresse IP n\'est plus bannie.',
    'noip' => 'Vous n\'avez pas fourni une adresse IP !'
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
$PLG_forum_MESSAGE1 = 'Mise à niveau du plugin forum : Mise à jour réussie.';
$PLG_forum_MESSAGE2 = 'Mise à niveau du plugin forum : Impossible de mettre à jour automatiquement cette version. Merci de vous référer à la documentation.';
$PLG_forum_MESSAGE5 = 'La mise à niveau du plugin forum a échouée - Consultez le fichier error.log';

// Messages for the plugin upgrade
$PLG_forum_MESSAGE3001 = '';
$PLG_forum_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['forum'] = array(
    'label' => 'Forum',
    'title' => 'Configuration du forum'
);

$LANG_confignames['forum'] = array(
    'registration_required' => 'Connexion nécessaire pour voir les contributions ?',
    'registered_to_post' => 'Connexion nécessaire pour contribuer ?',
    'allow_notification' => 'Permettre les notifications ?',
    'show_topicreview' => 'Montrer les messages précédants lors de la rédaction d\'une réponse ?',
    'allow_user_dateformat' => 'Permettre à l\'utilisateur de définir le format de la date ?',
    'use_pm_plugin' => 'Utiliser le plugin Private Message ?',
    'show_topics_perpage' => 'Nombre de sujets par page',
    'show_posts_perpage' => 'Nombre de contributions par page',
    'show_messages_perpage' => 'Nombre de lignes d\'un message par page',
    'show_searches_perpage' => 'Nombre de résultats de la recherche par page',
    'showblocks' => 'Colonne des blocs à montrer dans le forum',
    'usermenu' => 'Type du menu utilisateur',
    'use_themes_template' => 'Use templates in the theme directory',
    'show_subject_length' => 'Longueur maximale du sujet',
    'min_username_length' => 'Longueur minimale du nom d\'utiliateur',
    'min_subject_length' => 'Longueur minimale du sujet',
    'min_comment_length' => 'Longueur minimale de la contribution',
    'views_tobe_popular' => 'Nombre de vues pour être populaire',
    'post_speedlimit' => 'Limitation entre chaque contribution en secondes',
    'allowed_editwindow' => 'Permission de modification des contributions en secondes',
    'allow_html' => 'Permettre le mode HTML ?',
    'post_htmlmode' => 'Définir le mode HTML par défaut ?',
    'convert_break' => 'Convertir les sauts à la ligne par une balise HTML &lt;BR&gt;?',
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
    'centerblock_numposts' => 'Nombre de contribution à afficher dans le bloc central',
    'cb_subject_size' => 'Longueur maximale des sujets',
    'centerblock_where' => 'Placement du bloc central sur la page',
    'sideblock_numposts' => 'Nombre de contributions à afficher',
    'sb_subject_size' => 'Longueur lmaximale des sujets',
    'sb_latestpostonly' => 'Afficher uniquement les dernières contributions ?',
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
    'sg_main' => 'Paramètres principaux'
);

$LANG_tab['forum'] = array(
    'tab_main' => 'Paramètres généraux du forum',
    'tab_topicposting' => 'Publier une contribution',
    'tab_centerblock' => 'Le bloc central',
    'tab_sideblock' => 'Les barres latérales',
    'tab_rank' => 'Les niveaux',
    'tab_menublock' => 'Menu Block'
);

$LANG_fs['forum'] = array(
    'fs_main' => 'Paramètres généraux du forum',
    'fs_topicposting' => 'Publier une contribution',
    'fs_centerblock' => 'Le bloc central',
    'fs_sideblock' => 'Les barres latérales',
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
    5 => array('En haut de la page' => 1, 'Après l \'article en vedette' => 2, 'En bas de la page' => 3),
    6 => array('Blocs de gauche' => 'leftblocks', 'Blocs de droite' => 'rightblocks', 'Tous les blocs' => 'allblocks', 'Aucun bloc' => 'noblocks'),
    7 => array('Menu dans un bloc' => 'blockmenu', 'Barre de navigation' => 'navbar', 'Aucun' => 'none'),
    12 => array('Pas d\'accès' => 0, 'Lecture-Seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
