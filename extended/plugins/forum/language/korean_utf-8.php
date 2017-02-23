<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | korean_utf-8.php                                                          |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |    IvySOHO Ivy(KOMMA Tetsuko/Kim Younghie)                                |
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
    'pluginlabel' => '게시판',
    'searchlabel' => '게시판',
    'statslabel' => '게시판 전체덧글',
    'statsheading1' => '게시판 최다조회 톱 10',
    'statsheading2' => '게시판 최다덧글달기 톱 10 ',
    'statsheading3' => '덧글은 없습니다',
    'useradminmenu' => '게시판의 기능',
    'access_denied' => '접속에 실패 하였습니다',
    'autotag_desc_forum' => '[forum: id alternate title] - Displays a link to a forum topic using the text \'here\' as the title. An alternate title may be specified but is not required.'
);

$LANG_GF01 = array(
    'FORUM' => '게시판',
    'ALL' => '전부',
    'YES' => '예',
    'NO' => '아니오',
    'NEW' => '신착',
    'NEXT' => '다음으로',
    'ERROR' => '에러!',
    'CONFIRM' => '확인',
    'UPDATE' => '갱신',
    'SAVE' => '보존',
    'CANCEL' => '취소',
    'ON' => '글쓴날: ',
    'ON2' => '&nbsp;&nbsp;<b>켜짐: </b>',
    'BY' => '글쓴이: ',
    'RE' => '글달기: ',
    'DATE' => '날짜',
    'VIEWS' => '조회수',
    'REPLIES' => '글달기 수',
    'NAME' => '이름:',
    'DESCRIPTION' => '설명: ',
    'TOPIC' => '토픽이름',
    'TOPICS' => '덧글:',
    'TOPICSUBJECT' => '토픽주제',
    'HOMEPAGE' => '홈',
    'SUBJECT' => '주제',
    'HELLO' => '안녕하세요',
    'MOVED' => '이동',
    'POSTS' => '덧글 수',
    'LASTPOST' => '최신덧글',
    'POSTEDON' => '덧글쓴 날',
    'POSTEDBY' => '글쓴이',
    'PAGES' => '페이지',
    'TODAY' => '오늘의',
    'REGISTERED' => '등록일',
    'ORDERBY' => '동시교체;',
    'ORDER' => '차례:',
    'USER' => '사용자',
    'GROUP' => '그룹',
    'ANON' => '손님: ',
    'ADMIN' => '관리자',
    'AUTHOR' => '글쓴이',
    'NOMOOD' => '-기분 아이콘',
    'REQUIRED' => '[요구]',
    'OPTIONAL' => '[옵션]',
    'SUBMIT' => '보존',
    'PREVIEW' => '미리보기',
    'REMOVE' => '삭제',
    'EDIT' => '편집',
    'DELETE' => '삭제',
    'MERGE' => 'Merge',
    'OPTIONS' => '옵션:',
    'MISSINGSUBJECT' => '주제없슴',
    'MIGRATE_NOW' => '인포트 실행',
    'FILTERLIST' => '필터목록',
    'SELECTFORUM' => '게시판을 선택',
    'DELETEAFTER' => '실행후 삭제',
    'TITLE' => '제목',
    'COMMENTS' => '제안 및 의견',
    'SUBMISSIONS' => '덧글 쓴 것',
    'HTML_FILTER_MSG' => '일부 HTML을 허가',
    'HTML_FULL_MSG' => '모든 HTML을 허가',
    'HTML_MSG' => 'HTML 허가',
    'CENSOR_PERM_MSG' => 'Censored Content',
    'ANON_PERM_MSG' => '손님의 덧글보기',
    'POST_PERM_MSG1' => '덧글쓰기 가능',
    'POST_PERM_MSG2' => '손님도 덧글가능',
    'GO' => '실행',
    'STATUS' => '상태:',
    'ONLINE' => '온라인',
    'OFFLINE' => '오프라인',
    'back2parent' => '부모의 덧글',
    'forumname' => '',
    'category' => '카테고리: ',
    'loginreqview' => '<b> 게시판에 참가하기 위해서는  %s 등록</a> 혹은 %s 로그인 </a> 하시기 바랍니다</b>',
    'loginreqpost' => '<b> 덧글을 쓰기 위해서는 등록 혹은 로그인 해 주시기 바랍니다</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => '한가지는 아님.',
    'back2top' => '첫머리로 돌아가기',
    'TEXTMODE' => '택스트모드:',
    'HTMLMODE' => 'HTML 모드:',
    'TopicPreview' => '덧글 미리보기',
    'moderator' => '모더레이터',
    'admin' => 'Admin',
    'DATEADDED' => '등록일',
    'PREVTOPIC' => '이전 토픽으로',
    'NEXTTOPIC' => '다음 토픽으로',
    'RESYNC' => '갱신',
    'RESYNCCAT' => '카테고리를 갱신',
    'EDITICON' => '편집',
    'QUOTEICON' => '인용한 글',
    'ProfileLink' => '프로파일',
    'WebsiteLink' => '홈페이지',
    'PMLink' => 'PM',
    'EmailLink' => '메일',
    'FORUMSUBSCRIBE' => '이 게시판의 갱신을 메일로 통지하도록 설정하기',
    'FORUMUNSUBSCRIBE' => '이 게시판의 갱신을 메일로 통지하지 않도록 설정하기',
    'FORUMSUBSCRIBE_TRUE' => 'Subscribe:Enabled',
    'FORUMSUBSCRIBE_FALSE' => 'Subscribe:Disabled',
    'NEWTOPIC' => '신규덧글',
    'POSTREPLY' => '덧글쓰기',
    'SubscribeLink' => '메일통지 설정',
    'unSubscribeLink' => '메일통지 설정해제',
    'SubscribeLink_TRUE' => 'Subscribe:Enabled',
    'SubscribeLink_FALSE' => 'Subscribe:Disabled',
    'SUBSCRIPTIONS' => '메일통지 설정목록',
    'TOP' => '토픽 첫머리',
    'PRINTABLE' => '인쇄용 페이지',
    'USERPREFS' => '게시판의 사용자설정',
    'SPEEDLIMIT' => '"귀하의 최신 덧글은 %s 초 전이었습니다. <br' . XHTML . '> 다음의 덧글쓰기 까지 최소한 %s 초 이상 기다려 주시기 바랍니다."',
    'ACCESSERROR' => '접속 에러',
    'ACTIONS' => '동작',
    'DELETEALL' => '선택한 데이터를 전부 삭제',
    'DELCONFIRM' => '선택한 데이터를 전부 삭제해도 괜찮겠습니까?',
    'DELALLCONFIRM' => '데이터를 전부 삭제해도 괜찮겠습니까?',
    'STARTEDBY' => '초기덧글:',
    'WARNING' => '요주의',
    'MODERATED' => '모더레이터: %s',
    'LASTREPLYBY' => '마지막 글쓴이:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => 'Forum Menu',
    'INDEXPAGE' => '게시판 목차',
    'FEATURE' => '기능',
    'SETTING' => '설정',
    'MARKALLREAD' => '읽은 글 전부모음',
    'MSG_NO_CAT' => 'No Categories or Forums Defined',
    'FORUMPOSTS' => 'Forum Posts',
    'CODE' => '코드',
    'FONTCOLOR' => '글자색',
    'FONTSIZE' => '글자크기',
    'CLOSETAGS' => '태그 닫기',
    'CODETIP' => '힌트: 선택한 글자순서에 대해 즉각 스타일을 적용할 수 있습니다',
    'TINY' => '작다',
    'SMALL' => '작은',
    'NORMAL' => '표준',
    'LARGE' => '큰',
    'HUGE' => '커다란',
    'DEFAULT' => '기정',
    'DKRED' => '진한 빨강',
    'RED' => '빨강',
    'ORANGE' => '오랜지',
    'BROWN' => '갈색',
    'YELLOW' => '노랑',
    'GREEN' => '초록',
    'OLIVE' => '올리브',
    'CYAN' => '물색',
    'BLUE' => '파랑',
    'DKBLUE' => '진한 파랑',
    'INDIGO' => '남색',
    'VIOLET' => '바이올렛',
    'WHITE' => '하양',
    'BLACK' => '까망',
    'b_help' => '굵은 글씨로 하기 : [b]text[/b]',
    'i_help' => '이태릭체로 하기: [i]text[/i]',
    'u_help' => '밑줄치기: [u]text[/u]',
    'q_help' => '네모로 둘러쌓기: [quote]text[/quote]',
    'c_help' => '코드를 표시하기: [code]code[/code]',
    'l_help' => '숫자없는 목록으로: [list]text[/list]',
    'o_help' => '숫자달린 목록으로: [olist]text[/olist]',
    'p_help' => '[img]http://동영상의_url[/img]  혹은 [img w=100 h=200][/img]',
    'w_help' => 'URL 끼우기: [url]http://url[/url] 혹은 [url=http://url]URL 텍스트[/url]',
    'a_help' => '닫지 않은bbCode의 태그를 전부 닫기',
    's_help' => '글자색: [color=red]text[/color]  힌트:  color=#FF0000의 형식에서도 지정할 수 있습니다',
    'f_help' => '문자크기: [size=x-small] 작은 글씨 [/size]',
    'h_help' => '더 자세한 것을 보기 위해서는 클릭하시기 바랍니다'
);

$LANG_GF02 = array(
    'msg01' => 'Sorry you must register to use these forums',
    'msg02' => '등록',
    'msg03' => 'Please wait while you are redirected',
    'msg05' => '<center><em> 또는 등록되지 않았습니다.</em></center>',
    'msg07' => '온라인 사용자:',
    'msg14' => '등록이 필요합니다.<br' . XHTML . '>',
    'msg15' => '에러 라고 생각 하시면, <a href="mailto:%s?subject=Forum IP Ban"> 게시판 관리자 </A>까지.',
    'msg18' => '에러! 필수 기입항목에 입력 되지 않은 부분이 있거나 너무 짧습니다.',
    'msg19' => '메세지는 등록 되었습니다.',
    'msg22' => '- Forum Post Notification',
    'msg23a' => "게시판 [%s] 에 '%s' 씨의 글달기가 있었습니다. \n\n (덧글쓴이 %s 씨 게시판: %s) ",
    'msg23b' => "새 덧글 '%s'는  %s 씨에 의해서 %s 게시판에 덧글을 쓰셨습니다. (사이트 : %s) :\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "n%s/forum/viewtopic.php?showtopic=%s&lastpost=true 에서 열람할 수 있습니다. \n",
    'msg25' => "\n",
    'msg26' => "\n* 이 덧글에 메일통지를 지정하고 있으므로 메일을 보내시기 바랍니다. ",
    'msg27' => "메일통지 지정을 해제하기 위해서는 <a href=  <%s>여기를 클릭 </a> 하시기 바랍니다.\n",
    'msg33' => '글쓴이: ',
    'msg36' => '기분:',
    'msg38' => '신규 덧글달기를 메일로 알림',
    'msg40' => '<br' . XHTML . '> 이미 메일통지 설정이 되었습니다.<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">메일통지 설정을 한 덧글은 없습니다.</p>',
    'msg49' => '(참조수 %s 회) ',
    'msg55' => '삭제 되었습니다.',
    'msg56' => 'IP 주소는 금지 되었습니다.',
    'msg59' => '통상',
    'msg60' => '신착',
    'msg61' => '주목토픽',
    'msg62' => '글달기 있으면 메일로 알리기',
    'msg64' => '토픽 %s  제목: %s 을 정말 삭제해도 괜찮겠습니까?',
    'msg65' => '<br' . XHTML . '> 이것은 부모덧글입니다.  그러므로 이 토픽 의 모든 글달기도 함께 삭제 됩니다.',
    'msg68' => '주의: 금지는 주의깊게 행하시기 바랍니다. 관리자만이 금지자를 해제 할 수 있습니다.',
    'msg69' => '<br' . XHTML . '>정말 이 IP 주소를 금지 하시겠습니까: %s씨?',
    'msg71' => '기능이 선택되지 않습니다. 덧글을 선택하여 모더레이터의 기능을 실행 하시기 바랍니다.<br' . XHTML . '>주의: 직접 모더레이터가 되셔서 이 기능을 사용하시기 바랍니다.',
    'msg72' => '이 메세지는 온라인에서는 관리자 기능이 성공하지 않습니다.',
    'msg74' => '최신 덧글 %s 건',
    'msg75' => '조회수 톱 %s 건',
    'msg76' => '덧글수 Top %s 건',
    'msg77' => '<br' . XHTML . '><p style="padding-left:10px;"> 죄송합니다만, 먼저 로그인 하시기 바랍니다.  어카운트가 없다면 신규등록을 하시기 바랍니다.</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '>게시판 제목을 입력하시기 바랍니다.</p>',
    'msg84' => '전부 읽은 것으로 하기',
    'msg85' => '페이지:',
    'msg86' => '&nbsp;최신 덧글 %s  글쓴이;&nbsp;',
    'msg87' => '<br' . XHTML . '>경고: 이 토픽은 잠겨져 있습니다.<br' . XHTML . '> 추가 덧글은 할 수 없습니다.',
    'msg88' => '게시판의 덧글쓴이 목록',
    'msg88b' => '게시판 발언자 전용',
    'msg89' => '메일통지 설정목록',
    'msg101' => '규칙:',
    'msg103' => '게시판 점프:',
    'msg106' => '게시판 선택',
    'msg108' => '신규덧글 있는 게시판',
    'msg109' => '잠겨진 토픽',
    'msg110' => '편집페이지로 이동 중.',
    'msg111' => '안읽은 목록',
    'msg112' => '안읽음을 표시',
    'msg113' => '안읽음을 표시',
    'msg114' => '잠겨진 토픽',
    'msg115' => '주목토픽 신착',
    'msg116' => '잠겨진 토픽 신착',
    'msg117' => '사이트 검색',
    'msg118' => '게시판 검색',
    'msg119' => '검색결과:',
    'msg120' => '인기순 by',
    'msg121' => '전부의 시각은 %s. 현재 %s.',
    'msg122' => '인기순 목록수:',
    'msg123' => '인기순 목록에 표시된 건수',
    'msg126' => '검색라인:',
    'msg127' => '검색결과로 표시되는 라인 수',
    'msg128' => '각 페이지 별 글쓴이 수:',
    'msg129' => '글쓴이 목록의 각 페이지에 표시된 사람 수',
    'msg130' => '손님 덧글표시:',
    'msg131' => '손님 덧글 선별하기',
    'msg132' => '메일통지 설정모드:',
    'msg133' => '글달기가 있으면 메일통지를 기정치로 하기',
    'msg134' => '덧글이 추가 되었습니다',
    'msg135' => '귀하의 덧글 전부가 게시판에 통지 됩니다.',
    'msg136' => '덧글을 쓰고자 하는 게시판을 선택해 주시기 바랍니다.',
    'msg137' => '글달기가 있으면 메일로 통지 됩니다',
    'msg138' => '<b>게시판 전체</b>',
    'msg142' => '메일통지 설정모드로 변경 하였습니다.',
    'msg144' => '토픽으로',
    'msg146' => '메일통지 설정모드는 해제 되었습니다',
    'msg147' => '게시판 인쇄 %s',
    'msg148' => '<a href="javascript:history.back()"> 돌아가기</a>',
    'msg155' => '덧글 없슴',
    'msg156' => '덧글 수',
    'msg157' => '최신 덧글 10 ',
    'msg158' => '최신 글쓴이 10 ',
    'msg159' => '모더레이터의 데이터를 정말 삭제해도 괜찮겠습니까?',
    'msg160' => '덧글의 마지막 페이지 보기',
    'msg163' => '덧글은 이동 되었습니다',
    'msg164' => '전부 읽은것으로 하기',
    'msg166' => '에러: 기사가 깨졌거나 찾을 수 없습니다',
    'msg167' => '통지 옵션',
    'msg168' => '메일통지를 무효로 하기',
    'msg169' => '회원 목록으로 돌아가기',
    'msg170' => '최신 덧글',
    'msg171' => '게시판 접속에러',
    'msg172' => '덧글이 없거나 삭제 되었습니다',
    'msg173' => '메세지 투고 페이지로 이동하기.',
    'msg174' => '금지회원(BAN Member)을 찾을 수 없습니다. ‘IP 주소가 부적절합니다:Address',
    'msg175' => '게시판 전체보기로 돌아가기',
    'msg176' => '회원 선택',
    'msg177' => '회원 전체',
    'msg178' => '부모의 덧글전용',
    'msg179' => '내용생성: %s 초',
    'msg180' => '게시판 덧글경고',
    'msg181' => '게시판 관리자로서 접속할 수 없습니다',
    'msg182' => '모더레이터 확인',
    'msg183' => '신규덧글: %s',
    'msg184' => '한번만 알림',
    'msg185' => '다음 방문까지, 덧글이 다수 있어도 통지는 한번만 합니다.',
    'msg186' => '새 덧글 제목',
    'msg187' => '<a href="%s">덧글로 돌아가기</a>',
    'msg188' => '클릭하면 최신 덧글로 점프',
    'msg189' => '에러: 이제 이 덧글은 편집할 수 없습니다',
    'msg190' => '조용히 편집',
    'msg191' => '편집 불가능. 편집가능한 기간이 지났거나 모더레이터 권한이 없습니다.',
    'msg192' => '완료 되었습니다...  %s개의 토픽과  %s개의 코멘트를 인포트 하였습니다.',
    'msg193' => '기사를 게시판에 인포트 가능한 유용성 STORY&nbsp;&nbsp;TO&nbsp;&nbsp;FORUM&nbsp;&nbsp;MIGRATION&nbsp;&nbsp;',
    'msg194' => '신규덧글이 없는 게시판',
    'msg195' => '클릭하면 게시판으로 점프',
    'msg196' => '게시판 목차보기',
    'msg197' => '모든 카테고리 토픽을 읽은것으로 하기',
    'msg198' => '게시판 설정을 갱신하기',
    'msg199' => '게시판통지 읽기/삭제하기 ',
    'msg200' => '게시판 사이트 회원의 레포트 읽기',
    'msg201' => '인기토픽 레포트 읽기',
    'msg202' => 'No new posts',
    'msg300' => 'Your preferences have block anonymous posts enabled',
    'msg301' => 'Realy mark all categories read?',
    'msg302' => 'Realy mark all topics read?',
    'PostReply' => '새로 글달기',
    'PostTopic' => '신규덧글',
    'EditTopic' => '덧글편집',
    'quietforum' => '게시판에 신규덧글은 없습니다'
);

$LANG_GF03 = array(
    'delete' => '삭제',
    'edit' => '편집',
    'move' => '이동',
    'split' => '투고분할',
    'ban' => 'IP 주소금지',
    'movetopic' => '이동&map;삭제',
    'movetopicmsg' => '<br' . XHTML . '> 다음 게시판으로"<b>%s</b>를 이동하기"',
    'splittopicmsg' => '<br' . XHTML . '> 신규덧글 :"<b>%s</b>"<br' . XHTML . '><em> 글쓴이 :</em>&nbsp;%s&nbsp <em>원래 덧글:</em>&nbsp;%s',
    'selectforum' => '신규게시판 선택:',
    'lockedpost' => '글달기 추가',
    'splitheading' => '스랫옵션 분할:',
    'splitopt1' => '여기부터 덧글 전부를 이동',
    'splitopt2' => '덧글 하나만 이동'
);

$LANG_GF04 = array(
    'label_forum' => '게시판 개요',
    'label_location' => '장소',
    'label_aim' => 'AIM 핸들 이름',
    'label_yim' => 'YIM 핸들 이름',
    'label_icq' => 'ICQ 핸들 이름',
    'label_msnm' => 'MSN 메센저 이름',
    'label_interests' => '취미',
    'label_occupation' => '직업'
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
    1 => '통계',
    2 => '설정',
    3 => '게시판 관리',
    4 => '모더레이터',
    5 => '기사를 게시판으로',
    6 => '메세지',
    7 => '금지IP 주소'
);

$LANG_GF07 = array(
    1 => '게시판 표시',
    2 => '사용자 설정',
    3 => '덧글달기 인기순위',
    4 => '메일통지 설정목록',
    5 => '글쓴이 목록'
);

$LANG_GF08 = array(
    1 => '덧글 쓸 때의 주의 ',
    2 => '게시판 트랙의 주의',
    3 => '덧글 예외 시의 주의'
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
    'gfstats' => '게시판 통계',
    'statsmsg' => '현재:',
    'totalcats' => '카테고리 총계:',
    'totalforums' => '게시판 총수:',
    'totaltopics' => '토픽 총수:',
    'totalposts' => '덧글 총수:',
    'totalviews' => '조회 총수:',
    'avgpmsg' => '평균 덧글 수:',
    'category' => '카테고리:',
    'forum' => '게시판:',
    'topic' => '토픽:',
    'avgvmsg' => '평균 조회수:'
);

$LANG_GF92 = array(
    'gfsettings' => '설정',
    'showiframe' => '토픽 미리보기',
    'showiframedscp' => '토픽에 새 글달기를 할 경우 다음의 토픽 내용을 표시하기',
    'topicspp' => '각 페이지 별 토픽 수',
    'topicsppdscp' => '각 게시판 별 토픽 전체보기를 표시 할 경우, 페이지 마다 표시되는 토픽 수',
    'postspp' => '각 페이지 별 덧글 수',
    'postsppdscp' => '각 토픽마다 덧글메세지를 표시 할 경우 페이지당 표시되는 덧글 수',
    'setsavemsg' => '설정은 보존 되었습니다.'
);

$LANG_GF93 = array(
    'gfboard' => '게시판 관리',
    'addcat' => '카테고리 추가',
    'addforum' => '게시판 추가',
    'catorder' => '카테고리 순위',
    'catadded' => '카테고리가 추가 되었습니다.',
    'catdeleted' => '카테고리가 삭제 되었습니다.',
    'catedited' => '카테고리가 갱신 되었습니다.',
    'forumadded' => '게시판이 추가 되었습니다.',
    'forumaddError' => '게시판 추가 에러.',
    'forumdeleted' => '게시판이 삭제 되었습니다',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => '게시판이 갱신 되었습니다',
    'forumordered' => '게시판 순위를 편집',
    'back' => '돌아가기',
    'addnote' => '주의: 이들의 변수를 편집 할 수 있습니다.',
    'editforumnote' => '편집: <b>"%s"</b>',
    'deleteforumnote1' => '<b>"%s"</b>&nbsp;삭제해도 괜찮겠습니까?',
    'deleteforumnote2' => '이 바로 아래의 덧글은 전부 삭제 됩니다.',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => '편집: <b>"%s"</b>',
    'deletecatnote1' => '<b>"%s"</b>&nbsp;삭제해도 괜찮겠습니까?',
    'deletecatnote2' => '이 카테고리의 모든 게시판과 토픽이 함께 삭제 됩니다.',
    'undercat' => '카테고리',
    'groupaccess' => '그룹: ',
    'action' => '실시',
    'forumdescription' => '게시판 설명',
    'posts' => '덧글 수',
    'ordertitle' => '순위',
    'ModEdit' => '편집',
    'ModMove' => '이동',
    'ModStick' => '주목',
    'ModBan' => '금지',
    'addmoderator' => '모더레이트를 추가',
    'delmoderator' => " 선택한 모더레이트를 삭제\n",
    'moderatorwarning' => '<b>주의: 게시판을 찾을 수 없습니다. </b><br' . XHTML . '><br' . XHTML . '> 모더레이터 추가에 앞서서 게시판 카테고리를 작성 하시고 최소한 게시판 하나는 만드시기 바랍니다.',
    'private' => '개인정보 게시판',
    'filtertitle' => '모더레이터 정보표시',
    'addmessage' => '새 모더레이터 추가',
    'allowedfunctions' => '허가를 받은 권한',
    'userrecords' => '사용자의 기록',
    'grouprecords' => '그룹의 기록',
    'filterview' => '필터 살펴보기',
    'readonly' => 'Readonly Forum',
    'readonlydscp' => 'Only the Moderator can post to this forum',
    'hidden' => 'Hidden Forum',
    'hiddendscp' => 'Forum does not show in the forum index',
    'hideposts' => 'Hide New posts',
    'hidepostsdscp' => 'Updates will not show in the New Posts Blocks or RSS Feeds',
    'mod_title' => 'Forum Moderators',
    'allforums' => 'All Forums'
);

$LANG_GF95 = array(
    'header1' => '투고된 토픽에 관하여 논의해 보기로 합시다.',
    'header2' => '투고된 토픽에 관한 논의 &nbsp;&raquo;&nbsp;%s',
    'notyet' => '이 기능은 아직 완전히 꾸며지지 않았습니다',
    'delall' => '전부 삭제',
    'delallmsg' => '모든 메세지를 삭제 하시겠습니까,: %s씨?',
    'underforum' => '<b> %s (ID #%s)',
    'moderate' => '모더레이터 하기',
    'nomess' => '투고된 메세지는 아직 없습니다.'
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => 'Enter below an IP address to ban',
    'gfipman' => '금지IP 주소',
    'ban' => '금지',
    'noips' => '<p style="margin:0px; padding:5px;"> 금지 된 IP 주소는 없습니다!</p>',
    'unban' => '금지취소',
    'ipbanned' => '금지IP 주소',
    'banip' => '금지IP 주소확정',
    'banipmsg' => '금지 하시겠습니까, IP %s씨?',
    'specip' => '금지 IP 주소를 지정 하시기 바랍니다!',
    'ipunbanned' => '금지는 해제 되었습니다.',
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
