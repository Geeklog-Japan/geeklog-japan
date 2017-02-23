<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | hebrew_utf-8.php                                                          |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006 by the following authors:                              |
// |    LWC                                               lior.weissbrod.com   |
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
    'pluginlabel' => 'פורום',
    'searchlabel' => 'פורומים',
    'statslabel' => 'סך הכל דיונים (תגובות) בפורומים',
    'statsheading1' => '%s הדיונים הכי נצפים בפורומים',
    'statsheading2' => '%s הדיונים עם הכי הרבה תגובות בפורומים',
    'statsheading3' => 'אין דיונים לדווח עליהם',
    'useradminmenu' => 'הגדרות פורום',
    'access_denied' => 'הגישה לא אושרה',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => 'פורום',
    'ALL' => 'All',
    'YES' => 'כן',
    'NO' => 'לא',
    'NEW' => 'New',
    'NEXT' => 'Next',
    'ERROR' => 'שגיאה!',
    'CONFIRM' => 'אישור',
    'UPDATE' => 'עידכון',
    'SAVE' => 'שמירה',
    'CANCEL' => 'ביטול',
    'ON' => 'מתי: ',
    'ON2' => '&nbsp;&nbsp;<b>On: </b>',
    'BY' => 'נכתב על ידי: ',
    'RE' => 'Re: ',
    'DATE' => 'תאריך',
    'VIEWS' => 'צפיות',
    'REPLIES' => 'תגובות',
    'NAME' => 'השם:',
    'DESCRIPTION' => 'התיאור: ',
    'TOPIC' => 'דיון',
    'TOPICS' => 'דיונים',
    'TOPICSUBJECT' => 'נושא הדיון',
    'HOMEPAGE' => 'Home',
    'SUBJECT' => 'נושא',
    'HELLO' => 'Hello ',
    'MOVED' => 'הועבר לפה',
    'POSTS' => 'הודעות',
    'LASTPOST' => 'הודעה אחרונה',
    'POSTEDON' => 'נכתב ב',
    'POSTEDBY' => 'Posted By',
    'PAGES' => 'Pages',
    'TODAY' => 'היום ב-',
    'REGISTERED' => 'נרשם',
    'ORDERBY' => 'Order:&nbsp;',
    'ORDER' => 'סדר המיון:',
    'USER' => 'שם משתמש',
    'GROUP' => 'קבוצה',
    'ANON' => 'Anonymous: ',
    'ADMIN' => 'Admin',
    'AUTHOR' => 'מחבר',
    'NOMOOD' => 'ללא מצב רוח',
    'REQUIRED' => '[Required]',
    'OPTIONAL' => '[Optional]',
    'SUBMIT' => 'שליחה',
    'PREVIEW' => 'תצוגה מקדימה',
    'REMOVE' => 'מחיקה',
    'EDIT' => 'עריכה',
    'DELETE' => 'מחיקה',
    'MERGE' => 'Merge',
    'OPTIONS' => 'אפשרויות:',
    'MISSINGSUBJECT' => 'בלי נושא',
    'MIGRATE_NOW' => 'Migrate Now',
    'FILTERLIST' => 'Filter List',
    'SELECTFORUM' => 'Select Forum',
    'DELETEAFTER' => 'Delete after',
    'TITLE' => 'Title',
    'COMMENTS' => 'Comments',
    'SUBMISSIONS' => 'Submissions',
    'HTML_FILTER_MSG' => '<span dir="rtl">מאופשר HTML מסונן</span>',
    'HTML_FULL_MSG' => '<span dir="rtl">מאופשר HTML מלא</span>',
    'HTML_MSG' => '<span dir="rtl">שימוש ב-HTML</span>',
    'CENSOR_PERM_MSG' => 'התוכן מצונזר',
    'ANON_PERM_MSG' => 'מוצגות הודעות אנונימיות',
    'POST_PERM_MSG1' => 'אתם יכולים לכתוב',
    'POST_PERM_MSG2' => 'משתמשים אנונימיים יכולים לכתוב',
    'GO' => 'בצעו',
    'STATUS' => 'Status:',
    'ONLINE' => 'online',
    'OFFLINE' => 'offline',
    'back2parent' => 'Parent Topic',
    'forumname' => '',
    'category' => 'Category: ',
    'loginreqview' => '<b>אנו מצטערים, עליכם %s להירשם</a> או %s להיכנס למערכת</a> כדי להשתמש בפורומים אלו',
    'loginreqpost' => '<b>אנו מצטערים, עליכם להירשם או להיכנס למערכת כדי לכתוב בפורומים אלו</b>',
    'nolastpostmsg' => 'אין',
    'no_one' => 'No one.',
    'back2top' => 'Back to top',
    'TEXTMODE' => 'מצב טקסט פשוט:',
    'HTMLMODE' => 'מצב HTML:',
    'TopicPreview' => 'תצוגה מקדימה של הודעת הדיון',
    'moderator' => 'מפקח',
    'admin' => 'מנהל',
    'DATEADDED' => 'תאריך הוספה',
    'PREVTOPIC' => 'הדיון הקודם',
    'NEXTTOPIC' => 'הדיון הבא',
    'RESYNC' => 'בצעו סינכרוניזציה מחדש',
    'RESYNCCAT' => 'ReSync Category Forums',
    'EDITICON' => 'עריכה&',
    'QUOTEICON' => 'צטטו&',
    'ProfileLink' => 'פרופיל&',
    'WebsiteLink' => 'אתר אינטרנט&',
    'PMLink' => 'PM',
    'EmailLink' => 'אי מייל&',
    'FORUMSUBSCRIBE' => 'Subscribe to this forum',
    'FORUMUNSUBSCRIBE' => 'Un-Subscribe to this forum',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => 'דיון חדש',
    'POSTREPLY' => 'Post Reply',
    'SubscribeLink' => 'הרשמה',
    'unSubscribeLink' => 'מחיקה מההרשמה',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => 'Subscriptions',
    'TOP' => 'Top of Post',
    'PRINTABLE' => 'גירסה להדפסה',
    'USERPREFS' => 'User Preferences',
    'SPEEDLIMIT' => 'תגובתכם הקודמת הייתה לפני %s שניות.<br' . XHTML . '>אתר זה דורש לפחות %s שניות בין שליחת הודעות פורומים.',
    'ACCESSERROR' => 'שגיאה בגישה',
    'ACTIONS' => 'פעולות',
    'DELETEALL' => 'מחיקת כל הפריטים המסומנים',
    'DELCONFIRM' => 'האם הנכם בטוחים שאתם רוצים למחוק את הפריטים המסומנים',
    'DELALLCONFIRM' => 'האם הנכם בטוחים שאתם רוצים למחוק את *כל* הפריטים המסומנים',
    'STARTEDBY' => 'נוצר על ידי:',
    'WARNING' => 'אזהרה',
    'MODERATED' => 'מפקחים: %s',
    'LASTREPLYBY' => 'התגובה האחרונה היא של:&nbsp;%s',
    'UID' => 'קוד זיהוי משתמש',
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
    'msg05' => '<center><em>Sorry, no topics have been created yet.</em></center>',
    'msg07' => 'משתמשים מחוברים:',
    'msg14' => 'Sorry, You have been banned from making entries.<br' . XHTML . '>',
    'msg15' => 'If you feel this is an error, contact <a href="mailto:%s?subject=Forum IP Ban">Site Admin</a>.',
    'msg18' => 'שגיאה! לא כל השדות הושלמו או שהם היו קצרים מדי באורכם.',
    'msg19' => 'הודעתכם נשלחה.',
    'msg22' => '- Forum Post Notification',
    'msg23a' => "A reply has been made to the thread '%s' by %s.\n\nThis topic was started by %s in the %s forum. ",
    'msg23b' => "A new topic '%s' has been posted by %s in the %s forum on the %s website. You may view it at:\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "You may view it at:\n%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\nHave a great day! \n",
    'msg26' => "\nYou are receiving this email because you have chosen to be notified when a reply has been made to this topic. ",
    'msg27' => "To stop receiving notifications on this topic go to <%s> to remove it.\n",
    'msg33' => 'מחבר: ',
    'msg36' => 'מצב רוח:',
    'msg38' => 'הודיעו לי על תגובות ',
    'msg40' => '<br' . XHTML . '>Sorry, but you have already asked to be notified of replies to this topic.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">אין לכם כרגע שום התראות.</p>',
    'msg49' => '(נצפה %s פעמים) ',
    'msg55' => 'ההודעה נמחקה.',
    'msg56' => 'כתובת ה-IP הוחרמה.',
    'msg59' => 'דיון רגיל',
    'msg60' => 'הודעה חדשה',
    'msg61' => 'דיון דביק',
    'msg62' => 'Notify me of replies',
    'msg64' => 'האם הנכם מעוניינים למחוק את נושא %s שכותרתו: %s ?',
    'msg65' => '<br' . XHTML . '>זהו נושא ראשי, ולכן כל התגובות לו ימחקו גם.',
    'msg68' => 'שימו לב: *היזהרו כשאתם מחרימים*, רק מנהלים יכולים להפסיק חרם.',
    'msg69' => 'האם הנכם באמת מעוניינים להחרים את הכתובת: %s?',
    'msg71' => 'שום פונקציה לא נבחרה. ביחרו הודעה ואז פונקציית מפקח.<br' . XHTML . '>שימו לב: הנכם חייבים להיות מפקחים כדי לבצע פונקציות אלה.',
    'msg72' => 'אזהרה, אין לכם הרשאה לבצע פעולת פיקוח זו.',
    'msg74' => 'Latest %s Forum Posts',
    'msg75' => 'Top %s Topics By Views',
    'msg76' => 'Top %s Topics By Posts',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;">You should not be here!<br' . XHTML . '>Restricted access to this forum only.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>You need to be signed in to use this forum feature.</p>',
    'msg84' => 'סמנו את כל הדיונים ככאלו שנקראו',
    'msg85' => 'עמוד:',
    'msg86' => '&nbsp;%s ההודעות האחרונות&nbsp;',
    'msg87' => '<br' . XHTML . '>אזהרה: דיון זה ננעל על ידי המפקחים.<br' . XHTML . '>שום תגובות אליו לא מותרות',
    'msg88' => 'משתמשי האתר',
    'msg88b' => 'Site Members with Forum Activity',
    'msg89' => 'My Enabled Notifications',
    'msg101' => 'Forum Rules:',
    'msg103' => 'Forum Jump:',
    'msg106' => 'ביחרו פורום',
    'msg108' => 'אין הודעות חדשות מאז כניסתך האחרונה למערכת',
    'msg109' => 'דיון נעול',
    'msg110' => 'מעביר לעמוד עריכת ההודעות...',
    'msg111' => 'הודעות חדשות מאז כניסתך האחרונה למערכת',
    'msg112' => 'צפו בכל ההודעות החדשות',
    'msg113' => 'View new posts',
    'msg114' => 'דיון נעול',
    'msg115' => 'דיון דביק עם הודעה חדשה',
    'msg116' => 'דיון נעול עם הודעה חדשה',
    'msg117' => 'חיפוש כללי',
    'msg118' => 'חיפוש בפורום זה',
    'msg119' => 'תוצאות חיפוש בפורום עבור:',
    'msg120' => 'ההודעות הפופולריות ביותר על פי',
    'msg121' => 'השעה עכשיו היא %s',
    'msg122' => 'סף הפופולריות:',
    'msg123' => 'מספר ההודעות הדרושות כדי להחשיב נושא כפופולרי',
    'msg126' => 'שורות בחיפוש:',
    'msg127' => 'מספר השורות שיוצגו בתוצאות חיפושים',
    'msg128' => 'משתמשים בכל עמוד:',
    'msg129' => 'במסך רשימת המשתמשים',
    'msg130' => 'הצגת הודעות אנונימיות',
    'msg131' => 'בחירה בלא תסנן הודעות אנונימיות',
    'msg132' => 'Always Notify',
    'msg133' => 'Setting of Yes will enable auto notifcation for any topics you create or reply',
    'msg134' => 'Subscription Added',
    'msg135' => 'You will now be notified of all posts to this forum.',
    'msg136' => 'You must choose a forum to subscribe to.',
    'msg137' => 'Notification for topic enabled',
    'msg138' => '<b>רשום לכל הפורום</b>',
    'msg142' => 'בקשת ההרשמה נשמרה.',
    'msg144' => 'Return to topic',
    'msg146' => 'ההתראה נמחקה',
    'msg147' => 'פורום [גירסה מודפסת של נושא %s',
    'msg148' => 'ליחצו <a href="javascript:history.back()">כאן</a> כדי לחזור',
    'msg155' => 'No user posts.',
    'msg156' => 'Total number of forum posts',
    'msg157' => 'Last 10 Forum posts',
    'msg158' => 'Last 10 Forum posts by ',
    'msg159' => 'האם הנכם בטוחים שאתם רוצים *למחוק* את רשומת פיקוח זו',
    'msg160' => 'View last page of topic',
    'msg163' => 'הדיון הועבר',
    'msg164' => 'Mark all Categories and Topics Read',
    'msg166' => 'ERROR: Invalid topic or Topic not found',
    'msg167' => 'התראות באימייל',
    'msg168' => 'קבלו התראות דרך האימייל',
    'msg169' => 'חזרה לרשימת המשתמשים',
    'msg170' => 'Latest Forum Posts',
    'msg171' => 'שגיאה בגישה לפורום',
    'msg172' => 'הדיון לא קיים. אולי הוא נמחק.',
    'msg173' => 'עובר לעמוד כתיבת ההודעות...',
    'msg174' => 'Unable to BAN Member - Invalid or Empty IP Address',
    'msg175' => 'חזרה לרשימת הפורומים',
    'msg176' => 'ביחרו משתמש',
    'msg177' => 'כל המשתמשים',
    'msg178' => 'הודעות ראשיות בלבד',
    'msg179' => 'התוכן נטען תוך: %s שניות',
    'msg180' => 'התרעת כתיבה בפורומים',
    'msg181' => 'אין לכם גישה לשום פורום אחר כמפקחים',
    'msg182' => 'אישור מפקח',
    'msg183' => 'דיון חדש נוצר מהודעה זו בפורום: %s',
    'msg184' => 'Notify Once Only',
    'msg185' => 'Notifications will only be sent once for forums and topics which have multiple new posts since your last visit.',
    'msg186' => 'כותרת דיון חדשה',
    'msg187' => 'חיזרו לדיון - ליחצו <a href="%s">כאן</a>',
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
    'PostReply' => 'הוסיפו תגובה חדשה',
    'PostTopic' => 'הוסיפו דיון חדש',
    'EditTopic' => 'Edit Topic',
    'quietforum' => 'Forum has no new topics'
);

$LANG_GF03 = array(
    'delete' => 'מחיקת תגובה',
    'edit' => 'עריכת תגובה',
    'move' => 'הזזת דיון',
    'split' => 'פצלו את הדיון',
    'ban' => 'החרמת כתובת IP',
    'movetopic' => 'הזיזו את הדיון',
    'movetopicmsg' => '<br' . XHTML . '>הדיון להזזה: "<b>%s</b>"',
    'splittopicmsg' => '<br' . XHTML . '>צרו דיון חדש עם הודעה זו: "<b>%s</b>"<br' . XHTML . '><em>מאת:</em>&nbsp;%s&nbsp <em>נכתבה ב:</em>&nbsp;%s',
    'selectforum' => 'ביחרו פורום חדש',
    'lockedpost' => 'הוסיפו תגובה',
    'splitheading' => 'אפשרות פיצול הדיון:',
    'splitopt1' => 'הזיזו את כל ההודעות מנקודה זו',
    'splitopt2' => 'הזיזו רק את ההודעה הספציפית הזו'
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
    1 => 'סטטיסטיקות',
    2 => 'הגדרות',
    3 => 'פורומים',
    4 => 'מפקחים',
    5 => 'המרות',
    6 => 'הודעות',
    7 => 'ניהול ה-IP'
);

$LANG_GF07 = array(
    1 => 'ראו את הפורומים',
    2 => 'Preferences',
    3 => 'דיונים פופולריים',
    4 => 'ההרשמות שלכם',
    5 => 'רשימת המשתמשים'
);

$LANG_GF08 = array(
    1 => 'התראות דיונים',
    2 => 'התראות פורומים',
    3 => 'התראות יוצאות דופן של דיונים'
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
    'gfstats' => 'סטטיסטיקות פורומים',
    'statsmsg' => 'להלן הסטטיסטיקות הנוכחיות עבור הפורומים שלכם:',
    'totalcats' => 'סך הכל קטגוריות:',
    'totalforums' => 'סך הכל פורומים:',
    'totaltopics' => 'סך הכל דיונים:',
    'totalposts' => 'סך הכל הודעות:',
    'totalviews' => 'סך הכל צפיות:',
    'avgpmsg' => 'ממוצע הודעות ל:',
    'category' => 'קטגוריה:',
    'forum' => 'פורום:',
    'topic' => 'נושא:',
    'avgvmsg' => 'ממוצע צפיות ל:'
);

$LANG_GF92 = array(
    'gfsettings' => 'הגדרות הפורומים',
    'showiframe' => 'הראו סקירת דיון',
    'showiframedscp' => 'הראו סקירת דיון (ב-Iframe) למטה כאשר מגיבים לדיון',
    'topicspp' => 'דיונים בכל עמוד',
    'topicsppdscp' => 'מספר הדיונים שיוצגו בעמוד האינדקס של הפורומים',
    'postspp' => 'הודעות בכל עמוד של דיון',
    'postsppdscp' => 'מספר ההודעות שיוצגו בכל עמוד של דיון',
    'setsavemsg' => 'ההעדפות נשמרו.'
);

$LANG_GF93 = array(
    'gfboard' => 'ניהול הפורומים',
    'addcat' => 'הוספת קטגוריית פורומים',
    'addforum' => 'הוספת פורום',
    'catorder' => 'סדר מיון הקטגוריה',
    'catadded' => 'הקטגוריה התווספה.',
    'catdeleted' => 'הקטגוריה נמחקה',
    'catedited' => 'הקטגוריה נערכה.',
    'forumadded' => 'הפורום התווסף.',
    'forumaddError' => 'שגיאה בהוספת הפורום.',
    'forumdeleted' => 'הפורום נמחק',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => 'הפורום נערך',
    'forumordered' => 'סדר הפורומים עודכן',
    'back' => 'חזרה',
    'addnote' => 'Note: You can edit these values.',
    'editforumnote' => 'עירכו את פרטי הפורום: <b>"%s"</b>',
    'deleteforumnote1' => 'האם הנכם רוצים למחוק את הפורום <b>"%s"</b>&nbsp;?',
    'deleteforumnote2' => 'כל הדיונים שנכתבו תחתיו ימחקו גם.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => 'עירכו את פרטי הקטגוריה: <b>"%s"</b>',
    'deletecatnote1' => 'האם ברצונכם למחוק את הקטגוריה <b>"%s"</b>&nbsp;?',
    'deletecatnote2' => 'כל הפורומים והדיונים שנכתבו תחתיהם ימחקו גם.',
    'undercat' => 'תחת הקטגוריה',
    'groupaccess' => 'גישה קבוצתית: ',
    'action' => 'פעולות',
    'forumdescription' => 'תיאור הפורום',
    'posts' => 'הודעות',
    'ordertitle' => 'סדר המיון',
    'ModEdit' => 'עריכה',
    'ModMove' => 'הזזה',
    'ModStick' => 'הדבקה',
    'ModBan' => 'החרמה',
    'addmoderator' => 'הוספת רשומה',
    'delmoderator' => " Delete\nSelected",
    'moderatorwarning' => '<b>אזהרה: לא הוגדרו פורומים</b><br' . XHTML . '><br' . XHTML . '>הגדירו קטגוריות פורומים והוסיפו לפחות פורום אחד<br' . XHTML . '>לפני שתנסו להוסיף מפקחים',
    'private' => 'Private Forum',
    'filtertitle' => 'ביחרו אילו רשומות פיקוח לראות',
    'addmessage' => 'הוספת מפקחים חדשים',
    'allowedfunctions' => 'פונקציות מורשות',
    'userrecords' => 'רשומות משתמשים',
    'grouprecords' => 'רשומות קבוצות',
    'filterview' => 'סינון בעזרת הפילטרים',
    'readonly' => 'פורום לקריאה בלבד',
    'readonlydscp' => 'רק המפקחים יכולים לכתוב הודעות בפורום זה',
    'hidden' => 'פורום סודי',
    'hiddendscp' => 'הסתירו את הפורום מאינדקס הפורומים',
    'hideposts' => 'החביאו הודעות חדשות',
    'hidepostsdscp' => 'עדכונים לא יופיעו בקוביות מידע של הודעות חדשות או בהזנות RSS',
    'mod_title' => 'מפקחי הפורומים',
    'allforums' => 'כל הפורומים'
);

$LANG_GF95 = array(
    'header1' => 'הודעות בפורומים',
    'header2' => 'הודעות בפורום&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'Feature has not been implemented yet',
    'delall' => 'Delete All',
    'delallmsg' => 'Are you sure you want to delete all messages from: %s?',
    'underforum' => '<b>Under Forum: %s (ID #%s)',
    'moderate' => 'פיקוח',
    'nomess' => 'עוד לא נכתבו שום הודעות! '
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => 'ניהול ה-IP',
    'ban' => 'Ban',
    'noips' => '<p style="margin:0px; padding:5px;">שום כתובות IP לא הוחרמו עדיין!</p>',
    'unban' => 'להפסיק להחרים',
    'ipbanned' => 'IP Address Banned',
    'banip' => 'Ban IP Confirmation',
    'banipmsg' => 'Are you sure you want to ban the ip %s?',
    'specip' => 'אנא ציינו את כתובת ה-IP שברצונכם להחרים!',
    'ipunbanned' => 'כתובת ה-IP כבר לא מוחרמת.',
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
$PLG_forum_MESSAGE1 = 'התקנת ה-forum plugin הסתיימה בהצלחה!';
$PLG_forum_MESSAGE2 = 'Forum Plugin upgrade: We are unable to update this version automatically. Refer to the plugin documentation.';
$PLG_forum_MESSAGE5 = 'התקנה ה-forum plugin נכשלה - בידקו את ה-error.log';

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
