<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | spanish.php                                                               |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |    jrvalverde                                                             |
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
    'pluginlabel' => 'Foro',
    'searchlabel' => 'Foro',
    'statslabel' => 'Total de mensajes en el foro',
    'statsheading1' => '10 temas más visitados',
    'statsheading2' => '10 temas más comentados',
    'statsheading3' => 'No hay temas sobre los que informar',
    'useradminmenu' => 'Características del foro',
    'access_denied' => 'Acceso Denegado',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'Foro',
    'ALL' => 'Todo',
    'YES' => 'Si',
    'NO' => 'No',
    'NEW' => 'Nuevo',
    'NEXT' => 'Siguiente',
    'ERROR' => '¡Error!',
    'CONFIRM' => 'Confirmar',
    'UPDATE' => 'Actualizar',
    'SAVE' => 'Guardar',
    'CANCEL' => 'Cancelar',
    'ON' => 'En: ',
    'ON2' => '&nbsp;&nbsp;<b>En: </b>',
    'BY' => 'Por: ',
    'RE' => 'Re: ',
    'DATE' => 'Fecha',
    'VIEWS' => 'Visitas',
    'REPLIES' => 'Respuestas',
    'NAME' => 'Nombre:',
    'DESCRIPTION' => 'Descripción: ',
    'TOPIC' => 'Tópico',
    'TOPICS' => 'Tópicos:',
    'TOPICSUBJECT' => 'Tema del tópico',
    'HOMEPAGE' => 'Inicio',
    'SUBJECT' => 'Tema',
    'HELLO' => 'Hola ',
    'MOVED' => 'Movido',
    'POSTS' => 'Mensajes',
    'LASTPOST' => 'Último mensaje',
    'POSTEDON' => 'Enviado en',
    'POSTEDBY' => 'Enviado por',
    'PAGES' => 'Páginas',
    'TODAY' => 'Hoy a ',
    'REGISTERED' => 'Identificado',
    'ORDERBY' => 'Orden:&nbsp;',
    'ORDER' => 'Orden:',
    'USER' => 'Usuario/a',
    'GROUP' => 'Grupo',
    'ANON' => 'Anónimo: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'Autor',
    'NOMOOD' => 'Sin ánimo',
    'REQUIRED' => '[Requerido]',
    'OPTIONAL' => '[Opcional]',
    'SUBMIT' => 'Enviar',
    'PREVIEW' => 'Vista previa',
    'REMOVE' => 'Eliminar',
    'EDIT' => 'Editar',
    'DELETE' => 'Borrar',
    'MERGE' => 'Merge',
    'OPTIONS' => 'Opciones:',
    'MISSINGSUBJECT' => 'Sin tema',
    'MIGRATE_NOW' => 'Migrar Ahora',
    'FILTERLIST' => 'Lista de filtros',
    'SELECTFORUM' => 'Elegir foro',
    'DELETEAFTER' => 'Borrar después',
    'TITLE' => 'Título',
    'COMMENTS' => 'Comentarios',
    'SUBMISSIONS' => 'Envíos',
    'HTML_FILTER_MSG' => 'Se permite HTML Filtrado',
    'HTML_FULL_MSG' => 'Se permite todo HTML',
    'HTML_MSG' => 'Se permite HTML',
    'CENSOR_PERM_MSG' => 'Contenido censurado',
    'ANON_PERM_MSG' => 'Ver mensajes anónimos',
    'POST_PERM_MSG1' => 'Puede enviar',
    'POST_PERM_MSG2' => 'Los usuarios anónimos pueden enviar',
    'GO' => 'Ir',
    'STATUS' => 'Estado:',
    'ONLINE' => 'conectado',
    'OFFLINE' => 'desconectado',
    'back2parent' => 'Tema principal',
    'forumname' => '',
    'category' => 'Categoría: ',
    'loginreqview' => '<b>Lo siento, debe %s inscribirse</a> o %s identificarse </a> para usar estos foros</b>',
    'loginreqpost' => '<b>Lo siento, debe inscribirse o identificarse para usar este foro</B>',
    'nolastpostmsg' => 'N/D',
    'no_one' => 'Ninguno.',
    'back2top' => 'Volver al principio',
    'TEXTMODE' => 'Modo Texto:',
    'HTMLMODE' => 'Modo HTML:',
    'TopicPreview' => 'Vista previa del mensaje',
    'moderator' => 'Moderador',
    'admin' => 'Admin',
    'DATEADDED' => 'Fecha de adición',
    'PREVTOPIC' => 'Tópico anterior',
    'NEXTTOPIC' => 'Tópico siguiente',
    'RESYNC' => 'ReSync',
    'RESYNCCAT' => 'ReSync Foros de la Categoría',
    'EDITICON' => 'Editar',
    'QUOTEICON' => 'Cita',
    'ProfileLink' => 'Perfil',
    'WebsiteLink' => 'Website',
    'PMLink' => 'PM',
    'EmailLink' => 'Email',
    'FORUMSUBSCRIBE' => 'Seguir este foro',
    'FORUMUNSUBSCRIBE' => 'Borrarse de este foro',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => 'Tópico nuevo',
    'POSTREPLY' => 'Enviar respuesta',
    'SubscribeLink' => 'Subscribirse',
    'unSubscribeLink' => 'Borrarse',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => 'Subscripciones',
    'TOP' => 'Inicio del mensaje',
    'PRINTABLE' => 'Versión para imprimir',
    'USERPREFS' => 'Preferencias de usuario',
    'SPEEDLIMIT' => '"Tu último comentario fué hace %s segundos.<br' . XHTML . '>Hace falta que pasen al menos %s segundos entre envíos a los foros."',
    'ACCESSERROR' => 'ERROR DE ACCESO',
    'ACTIONS' => 'Acciones',
    'DELETEALL' => 'Borrar todos los registros seleccionados',
    'DELCONFIRM' => '¿Seguro que quieres Borrar los registros seleccionados?',
    'DELALLCONFIRM' => '¿Seguro que quieres borrar TODOS los registros seleccionados?',
    'STARTEDBY' => 'Iniciado por:',
    'WARNING' => 'Aviso',
    'MODERATED' => 'Moderadores: %s',
    'LASTREPLYBY' => 'Última respuesta por:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => 'Índice del foro',
    'FEATURE' => 'Característica',
    'SETTING' => 'Preferencia',
    'MARKALLREAD' => 'Marcar todos como leídos',
    'MSG_NO_CAT' => 'No Categories or Forums Defined',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => 'Código',
    'FONTCOLOR' => 'Color de letra',
    'FONTSIZE' => 'Tamaño de letra',
    'CLOSETAGS' => 'Cerrar Marcas',
    'CODETIP' => 'Truco: Puedes aplicar rápidamente Estilos al texto seleccionado',
    'TINY' => 'Diminuto',
    'SMALL' => 'Pequeño',
    'NORMAL' => 'Normal',
    'LARGE' => 'Grande',
    'HUGE' => 'Inmenso',
    'DEFAULT' => 'Por defecto',
    'DKRED' => 'Rojo Oscuro',
    'RED' => 'Rojo',
    'ORANGE' => 'Naranja',
    'BROWN' => 'Marrón',
    'YELLOW' => 'Amarillo',
    'GREEN' => 'Verde',
    'OLIVE' => 'Oliva',
    'CYAN' => 'Cián',
    'BLUE' => 'Azul',
    'DKBLUE' => 'Azul Oscuro',
    'INDIGO' => 'Índigo',
    'VIOLET' => 'Violeta',
    'WHITE' => 'Blanco',
    'BLACK' => 'Negro',
    'b_help' => 'Negrita: [b]texto[/b]',
    'i_help' => 'Cursiva: [i]texto[/i]',
    'u_help' => 'subrayado: [u]texto[/u]',
    'q_help' => 'Cita: [quote]texto[/quote]',
    'c_help' => 'Código: [code]código[/code]',
    'l_help' => 'Lista: [list]texto[/list]',
    'o_help' => 'Lista ordenada: [olist]texto[/olist]',
    'p_help' => '[img]http://image_url[/img]  o [img w=100 h=200][/img]',
    'w_help' => 'Insertar URL: [url]http://url[/url] o [url=http://url]URL text[/url]',
    'a_help' => 'Cerrar todas las etiquetas bbCode abiertas',
    's_help' => 'Color de texto: [color=red]texto[/color]  Truco: también puedes usar color=#FF0000',
    'f_help' => 'Tamaño: [size=x-small]texto pequeño[/size]',
    'h_help' => 'Pulsa para obtener ayuda detallada'
);

$LANG_GF02 = array(
    'msg01' => 'Lo sentimos, debe inscribirse parea usar estos foros',
    'msg02' => '¡No deberías estar aquí!<br' . XHTML . '>Acceso restringido a este foro solamente',
    'msg03' => 'Please wait while you are redirected',
    'msg05' => '<center><em>Lo sentimos, aún no se ha creado ningún tópico.</em></center>',
    'msg07' => 'Usuarios conectados:',
    'msg14' => 'Lo sentimos. Se le ha prohibido realizar nuevas entradas.<br' . XHTML . '>',
    'msg15' => 'Si cree que es un error contacte con el <s href="mailto:%s?subject=Forum IP Ban">Administrador</a>.',
    'msg18' => '¡Error! No has rellenado todos los campos requeridos o eran demasiado cortos.',
    'msg19' => 'Tu mensaje ha sido enviado.',
    'msg22' => '- Notificación de envío al foro',
    'msg23a' => "Hay una respuesta a la discusión '%s' por %s.\n\nEste tópico lo inició %s en el foro %s. ",
    'msg23b' => "Hay un tópico nuevo '%s' enviado por %s en el foro %s en el servidor %s. Puedes verlo en:\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "Puedes verlo en:\n%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\n¡Que tengas un gran día! \n",
    'msg26' => "\nEstas recibiendo este mensaje por que has elegido ser notificado cuando hubiera una respuesta a este tópico. ",
    'msg27' => "Para dejar de recibir notificaciones en este tópico ve a <%s> para eliminarlas.\n",
    'msg33' => 'Autor: ',
    'msg36' => 'Ánimo:',
    'msg38' => 'Avisarme de las respuestas ',
    'msg40' => '<br' . XHTML . '>Lo siento, ya has pedido que te avisemos de las respuestas a este tópico.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">No tienes ninguna notificación.</p>',
    'msg49' => '(Leído %s veces) ',
    'msg55' => 'Mensaje Borrado.',
    'msg56' => 'IP Prohibida.',
    'msg59' => 'Tópico normal',
    'msg60' => 'Mensaje Nuevo',
    'msg61' => 'Tópico Pegado',
    'msg62' => 'Avisarme de las respuestas',
    'msg64' => '¿Seguro que quieres borrar el tópico %s titulado: %s ?',
    'msg65' => '<br' . XHTML . '>Este es un tópico principal, así que todas las respuestas enviadas se borrarán también.',
    'msg68' => 'Nota: TEN CUIDADO AL EXPULSAR, solo los administradores tienen derecho a readmitir a alguien.',
    'msg69' => '¿Realmente quieres expulsar la dirección IP: %s?',
    'msg71' => 'No has elegido ninguna acción, elige un mensaje y entonces una acción de moderación..<br' . XHTML . '>Nota: Debes ser un moderador para realizar estas acciones.',
    'msg72' => 'Aviso, no tienes derecho a realizare esta acción de moderación.',
    'msg74' => 'Últimos %s Mensajes al Foro',
    'msg75' => ' %s Tópicos más visitados',
    'msg76' => '%s Tópics con más mensajes',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">¡No deberías estar aquí!<br' . XHTML . '>Acceso restringido solo a este foro.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>Necesitas identificarte para usar esta característica del foro.</p>',
    'msg84' => 'Marcar todos los tópicos como leídos',
    'msg85' => 'Página:',
    'msg86' => '&nbsp;Últimos %s mensajes&nbsp;',
    'msg87' => '<br' . XHTML . '>Aviso: Este tópico ha sido bloqueado por el moderador.<br' . XHTML . '>No se permiten más mensajes',
    'msg88' => 'Miembros del sitio',
    'msg88b' => 'Solo Actividad del Foro',
    'msg89' => 'Mis avisos activos',
    'msg101' => 'Reglas del foro:',
    'msg103' => 'Saltar a Foro:',
    'msg106' => 'Elegir un Foro',
    'msg108' => 'Foro Activo',
    'msg109' => 'Tópico bloqueado',
    'msg110' => 'Yendo a la página de corrección de mensajes..',
    'msg111' => 'Mensajes nuevos desde tu última visita',
    'msg112' => 'Ver todos los mensajes nuevos',
    'msg113' => 'Ver mensajes nuevos',
    'msg114' => 'Tópico bloqueado',
    'msg115' => 'Tópico pegado con nuevo mensaje',
    'msg116' => 'Tópico bloqueado con nuevo mensaje',
    'msg117' => 'Buscar en todo',
    'msg118' => 'Buscar en este foro',
    'msg119' => 'Resultados de la búsqueda en el Foro:',
    'msg120' => 'Mensajes más populares por',
    'msg121' => 'Todas las horas son %s. Hora actual %s.',
    'msg122' => 'Límite Popular:',
    'msg123' => 'Número de mensajes antes de llamar popular a un tópico',
    'msg126' => 'Líneas de búsqueda:',
    'msg127' => 'Número de líneas a mostrar en los resultados de la búsqueda',
    'msg128' => 'Miembros por página:',
    'msg129' => 'Pantalla de listado para los miembros',
    'msg130' => 'Ver mensajes anónimos:',
    'msg131' => 'Elegir No eliminará los mensajes anónimos',
    'msg132' => 'Avisar siempre:',
    'msg133' => 'Elegir Si permitirá la notificación automática para cualquier tópico quie crées o respondas.',
    'msg134' => 'Subscripción Añadida',
    'msg135' => 'A partir de ahora se te avisará de todos los mensajes a este foro.',
    'msg136' => 'Debes elegir un foro al que suscribirte.',
    'msg137' => 'Permitida la notificación para tópicos',
    'msg138' => '<b>Subscrito a todo el foro</b>',
    'msg142' => 'Notificación guardada.',
    'msg144' => 'Volver al tópico',
    'msg146' => 'Notificación Borrada',
    'msg147' => 'Foro [versión imprimible del tópico %s]',
    'msg148' => 'Pulsa <a href="javascript:history.back()">AQUÍ</a> para volver',
    'msg155' => 'Sin mensajes de usuario.',
    'msg156' => 'Número total de mensajes al foro',
    'msg157' => 'Últimos 10 mensajes en el foro',
    'msg158' => 'Últimos 10 mensajes en el foro por ',
    'msg159' => '¿Estás seguro de querer BORRAR estos registros de Moderador seleccionados?',
    'msg160' => 'Ver última página del tópico',
    'msg163' => 'Mensaje movido',
    'msg164' => 'Marcar todas las categorías y tópicos como leídos',
    'msg166' => 'ERROR: tópico inválido o no encontrado',
    'msg167' => 'Opción de notificación',
    'msg168' => 'Eligiendo No se desactivan las notificaciones por email',
    'msg169' => 'Volver al listado de miembros',
    'msg170' => 'Últimos mensajes del foro',
    'msg171' => 'Error de acceso al foro',
    'msg172' => 'Tópico inexistente. Puede que haya sido borrado',
    'msg173' => 'Transfiriendo a la página de envío de mensaje..',
    'msg174' => 'imposible EXPULSAR miembro - dirección IP inválida o vacía',
    'msg175' => 'Volver al listado de foros',
    'msg176' => 'Elegir miembro',
    'msg177' => 'Todos los miembros',
    'msg178' => 'Solo mensajes iniciales',
    'msg179' => 'Contenido generado en: %s segundos',
    'msg180' => 'Alerta de envío a foro',
    'msg181' => 'No tienes acceso a ningún otro foro como moderador',
    'msg182' => 'Confirmación de moderador',
    'msg183' => 'Se ha creado un tópico nuevo en este foro: %s',
    'msg184' => 'Notificar solo una vez',
    'msg185' => 'Sólo se enviará una notificación para los foros y tópicos que tengan múltiples mensajes desde tu última visita.',
    'msg186' => 'Nuevo título de tópico',
    'msg187' => 'Volver al tópico - pulsa <a href="%s">aquí</a>',
    'msg188' => 'Pulsa para ir directamente al último mensaje',
    'msg189' => 'Error: Ya no puedes corregir este mensaje',
    'msg190' => 'Corrección silenciosa',
    'msg191' => 'Corrección no permitida. El margen de tiempo permitido ha expirado o bien necesitas derechos de moderador.',
    'msg192' => 'Completado ... Migrados %s tópicos y %s comentarioss.',
    'msg193' => 'HISTORIA&nbsp;&nbsp;A&nbsp;&nbsp;FORO&nbsp;&nbsp;MIGRACIÓN&nbsp;&nbsp;UTILIDAD',
    'msg194' => 'Foro tranquilo',
    'msg195' => 'Pulsa para saltar al foro',
    'msg196' => 'Ver el índice principal del foro',
    'msg197' => 'Marcar todos los tópicos como leídos',
    'msg198' => 'Actualizar tus preferencias del foro',
    'msg199' => 'Ver o eliminar notificaciones del foro',
    'msg200' => 'Informe de miembros del sitio',
    'msg201' => 'Tópicos populares',
    'msg202' => 'No hay mensajes nuevos',
    'msg300' => 'Your preferences have block anonymous posts enabled',
    'msg301' => 'Realy mark all categories read?',
    'msg302' => 'Realy mark all topics read?',
    'PostReply' => 'Enviar nueva respuesta',
    'PostTopic' => 'Enviar nuevo tópico',
    'EditTopic' => 'Editar tópico',
    'quietforum' => 'No hay tópicos nuevos en el foro'
);

$LANG_GF03 = array(
    'delete' => 'Borrar mensaje',
    'edit' => 'Editar mensaje',
    'move' => 'Mover tópico',
    'split' => 'Dividir tópico',
    'ban' => 'Expulsar IP',
    'movetopic' => 'Mover tópico',
    'movetopicmsg' => '<br' . XHTML . '>Tópico a mover: "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>Crear un tópico nuevo con este mensaje: "<b>%s</b>"<br' . XHTML . '><em>Por:</em>&nbsp;%s&nbsp <em>En:</em>&nbsp;%s',
    'selectforum' => 'Elegir nuevo foro:',
    'lockedpost' => 'Añadir mensaje de respuesta',
    'splitheading' => 'Opción de dividir discusión:',
    'splitopt1' => 'Mover todos los mensajes a aprtir de éste',
    'splitopt2' => 'Mover solo este mensaje'
);

$LANG_GF04 = array(
    'label_forum' => 'Perfil del foro',
    'label_location' => 'Localización',
    'label_aim' => 'Identidad AIM',
    'label_yim' => 'Identidad YIM',
    'label_icq' => 'Identidad ICQ',
    'label_msnm' => 'Nombre MS Messenger',
    'label_interests' => 'Intereses',
    'label_occupation' => 'Ocupación'
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
    1 => 'Estadísticas',
    2 => 'Preferencias',
    3 => 'Foros',
    4 => 'Moderador',
    5 => 'Convertir',
    6 => 'Mensajes',
    7 => 'Gestión IP'
);

$LANG_GF07 = array(
    1 => 'Ver foros',
    2 => 'Preferencias',
    3 => 'Tópicos populares',
    4 => 'Subscripciones',
    5 => 'Miembros'
);

$LANG_GF08 = array(
    1 => 'Notificaciones de tópico',
    2 => 'Seguir notificaciones de foro',
    3 => 'Notificaciones de excepción de tópico'
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
    'gfstats' => 'Estadísticas de discusión del foro',
    'statsmsg' => 'Éstas son las estadísticas actuales de tu foro:',
    'totalcats' => 'Total de categorías:',
    'totalforums' => 'Total de foros:',
    'totaltopics' => 'Total de tópicos:',
    'totalposts' => 'Total de mensajes:',
    'totalviews' => 'Total de visitas:',
    'avgpmsg' => 'Media de mensajes por:',
    'category' => 'Categoría:',
    'forum' => 'Foro:',
    'topic' => 'Tópico:',
    'avgvmsg' => 'Media de visitas por:'
);

$LANG_GF92 = array(
    'gfsettings' => 'Preferencias foro de discusión',
    'showiframe' => 'Mostrar revisión de tópico',
    'showiframedscp' => 'Mostrar revisión de tópico (Iframe) abajo al replicar a un tópico',
    'topicspp' => 'Tópicos por página',
    'topicsppdscp' => 'Número de tópicos a mostrar cuando se vé el índice del foro',
    'postspp' => 'Mensajes por página',
    'postsppdscp' => 'Número de mensajes a mostrar en cada página',
    'setsavemsg' => 'Preferencias guardadas.'
);

$LANG_GF93 = array(
    'gfboard' => 'Panel de administración de foros de discusión',
    'addcat' => 'Añadir categoría de foros',
    'addforum' => 'Añadir un foro',
    'catorder' => 'Orden de categorías',
    'catadded' => 'Categoría añadida.',
    'catdeleted' => 'Categoría borrada',
    'catedited' => 'Category cambiada.',
    'forumadded' => 'Foro añadido.',
    'forumaddError' => 'Error añadiendo foro.',
    'forumdeleted' => 'Foro borrado',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'Foro cambiado',
    'forumordered' => 'Orden de foros cambiado',
    'back' => 'Atrás',
    'addnote' => 'Nota: Puedes cambiar estos valores.',
    'editforumnote' => 'Cambiar detalles del foro para: <b>"%s"</b>',
    'deleteforumnote1' => '¿Quieres borrar el foro <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'Se borrarán también todos los tópicos contenidos.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'Cambiar detalles de categoría para: <b>"%s"</b>',
    'deletecatnote1' => '¿Quieres borrar la categoría <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'Se borrarán también todos los foros y sus tópicos.',
    'undercat' => 'Bajo la categoría',
    'groupaccess' => 'Acceso de grupo: ',
    'action' => 'Acciones',
    'forumdescription' => 'Descripción del foro',
    'posts' => 'Mensajes',
    'ordertitle' => 'Orden',
    'ModEdit' => 'Cambiar',
    'ModMove' => 'Mover',
    'ModStick' => 'Fijar',
    'ModBan' => 'Expulsar',
    'addmoderator' => 'Añadir entrada',
    'delmoderator' => " Borrar\nElegido",
    'moderatorwarning' => '<b>Aviso: No se han definido foros</b><br' . XHTML . '><br' . XHTML . '>Define las categorías de foros y añade al menos un foro<br' . XHTML . '>antes de intentar añadir moderadores',
    'private' => 'Foro privado',
    'filtertitle' => 'Elegir moderadores a ver',
    'addmessage' => 'Añadir nuevo moderador',
    'allowedfunctions' => 'Funciones permitidas',
    'userrecords' => 'Entradas de usuarios',
    'grouprecords' => 'Entradas de grupos',
    'filterview' => 'Filtrar vista',
    'readonly' => 'Foro de solo lectura',
    'readonlydscp' => 'Solo el moderador puede enviar mensajes a este foro',
    'hidden' => 'Foro oculto',
    'hiddendscp' => 'El foro no aparece en el índice',
    'hideposts' => 'Ocultar mensajjes nuevos',
    'hidepostsdscp' => 'Las actualizaciones no aparecerán en el bloque de mensajes nuevos o alimentaciones RSS',
    'mod_title' => 'Moderadores de foro',
    'allforums' => 'Todos los foros'
);

$LANG_GF95 = array(
    'header1' => 'Mensajes de discusión',
    'header2' => 'Mensajes de discusión para el foro &nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Característica no implementada todavía',
    'delall' => 'Borrar todo',
    'delallmsg' => '¿Seguro que quieres borrar todos los mensajes de: %s?',
    'underforum' => '<b>En el foro: %s (ID #%s)',
    'moderate' => 'Moderar',
    'nomess' => '¡Aún no se han enviado mensajes! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'Gestión IP',
    'ban' => 'Expulsar',
    'noips' => '<p style="margin:0px; padding:5px;">¡Aún no se ha expulsado ninguna IP!</p>',
    'unban' => 'Perdonar',
    'ipbanned' => 'Dirección IP expulsada',
    'banip' => 'Confirmación de expulsión IP',
    'banipmsg' => '¿Seguro que deseas expulsar la IP %s?',
    'specip' => 'Por favor, especifica una dirección IP a expulsar!',
    'ipunbanned' => 'Dirección IP perdonada.',
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
$PLG_forum_MESSAGE1 = 'Actualización del plugin Forum completada - sin errores';
$PLG_forum_MESSAGE2 = 'Actualización de plugin Foro: No hemos podido actualizar esta versión automáticamente. Consulta la documentación del Plugin.';
$PLG_forum_MESSAGE5 = 'Actualización del plugin Forum fallida - revisa error.log';

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
