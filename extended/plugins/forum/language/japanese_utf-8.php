<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.9.0                                               |
// +---------------------------------------------------------------------------+
// | japanese_utf-8.php                                                        |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011 by the following authors:                              |
// |    Geeklog Japanese Group                                                 |
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
    'pluginlabel' => '掲示板',
    'searchlabel' => '掲示板',
    'statslabel' => '全掲示板投稿',
    'statsheading1' => '掲示板上位10位閲覧数',
    'statsheading2' => '掲示板上位10位書き込み数',
    'statsheading3' => '投稿はありません。',
    'useradminmenu' => '掲示板の機能',
    'access_denied' => 'アクセスが拒否されました',
    'autotag_desc_forum' => '[forum: id alternate title] - 掲示板トピックのタイトルで掲示板トピックへのリンクを表示。アンカーテキストの指定は任意。'
);

$LANG_GF01 = array(
    'FORUM' => '掲示板',
    'ALL' => 'すべて',
    'YES' => 'はい',
    'NO' => 'いいえ',
    'NEW' => '新着',
    'NEXT' => '次へ',
    'ERROR' => 'エラー!',
    'CONFIRM' => '確認',
    'UPDATE' => '更新',
    'SAVE' => '保存',
    'CANCEL' => '取り消し',
    'ON' => '投稿日: ',
    'ON2' => '&nbsp;&nbsp;<b>オン: </b>',
    'BY' => '投稿者: ',
    'RE' => '書込: ',
    'DATE' => '日付',
    'VIEWS' => '閲覧数',
    'REPLIES' => '書込数',
    'NAME' => '名前:',
    'DESCRIPTION' => '説明: ',
    'TOPIC' => '件名',
    'TOPICS' => '投稿',
    'TOPICSUBJECT' => '件名',
    'HOMEPAGE' => 'ホーム',
    'SUBJECT' => '件名',
    'HELLO' => 'こんにちは！ ',
    'MOVED' => '移動',
    'POSTS' => '投稿数',
    'LASTPOST' => '最新投稿',
    'POSTEDON' => '投稿日',
    'POSTEDBY' => '投稿者',
    'PAGES' => 'ページ',
    'TODAY' => '今日の',
    'REGISTERED' => '登録日',
    'ORDERBY' => '並び換え:',
    'ORDER' => '順番:',
    'USER' => 'ユーザ',
    'GROUP' => 'グループ',
    'ANON' => 'ゲストユーザ: ',
    'ADMIN' => '管理者',
    'AUTHOR' => '投稿者',
    'NOMOOD' => '-気分アイコン-',
    'REQUIRED' => '[要求]',
    'OPTIONAL' => '[オプション]',
    'SUBMIT' => '投稿する',
    'PREVIEW' => 'プレビュー',
    'REMOVE' => '解除',
    'EDIT' => '編集',
    'DELETE' => '削除',
    'MERGE' => 'Merge',
    'OPTIONS' => 'オプション:',
    'MISSINGSUBJECT' => '件名なし',
    'MIGRATE_NOW' => 'インポート実行',
    'FILTERLIST' => 'フィルタリスト',
    'SELECTFORUM' => '掲示板を選択',
    'DELETEAFTER' => '実行後に削除',
    'TITLE' => 'タイトル',
    'COMMENTS' => 'コメント',
    'SUBMISSIONS' => '投稿したもの',
    'HTML_FILTER_MSG' => '一部のHTMLを許可',
    'HTML_FULL_MSG' => 'すべてのHTMLを許可',
    'HTML_MSG' => 'HTML許可',
    'CENSOR_PERM_MSG' => 'バッドワードをチェック',
    'ANON_PERM_MSG' => 'ゲストユーザの投稿を見る',
    'POST_PERM_MSG1' => '投稿可能',
    'POST_PERM_MSG2' => 'ゲストユーザ投稿可能',
    'GO' => '実行',
    'STATUS' => '状態:',
    'ONLINE' => 'オンライン',
    'OFFLINE' => 'オフライン',
    'back2parent' => '親の投稿',
    'forumname' => '',
    'category' => 'カテゴリ: ',
    'loginreqview' => '<b>掲示板に参加するためには、 %s 登録</a> または %s ログイン </a> してください。</b>',
    'loginreqpost' => '<b>投稿するためには、登録またはログインしてください。</b>',
    'nolastpostmsg' => 'N/A',
    'no_one' => '1つではない。',
    'back2top' => 'トップへ戻る',
    'TEXTMODE' => 'テキストモード',
    'HTMLMODE' => 'HTMLモード',
    'TopicPreview' => '投稿プレビュー',
    'moderator' => 'モデレータ',
    'admin' => '管理者',
    'DATEADDED' => '登録日',
    'PREVTOPIC' => '前のトピックへ',
    'NEXTTOPIC' => '次のトピックへ',
    'RESYNC' => '更新',
    'RESYNCCAT' => 'カテゴリを更新',
    'EDITICON' => '編集',
    'QUOTEICON' => '引用して書き込む',
    'ProfileLink' => 'プロフィール',
    'WebsiteLink' => 'ホームページ',
    'PMLink' => 'PM',
    'EmailLink' => 'メール',
    'FORUMSUBSCRIBE' => 'メール通知を開始',
    'FORUMUNSUBSCRIBE' => 'メール通知を解除',
    'FORUMSUBSCRIBE_TRUE' => 'この掲示板のメール通知:有効',
    'FORUMSUBSCRIBE_FALSE' => 'この掲示板のメール通知:無効',
    'NEWTOPIC' => '新規投稿',
    'POSTREPLY' => '返信投稿',
    'SubscribeLink' => 'メール通知を開始',
    'unSubscribeLink' => 'メール通知を解除',
    'SubscribeLink_TRUE' => 'このトピックのメール通知:有効',
    'SubscribeLink_FALSE' => 'このトピックのメール通知:無効',
    'SUBSCRIPTIONS' => '投稿オプション',
    'TOP' => 'トップ',
    'PRINTABLE' => '印刷用ページ',
    'USERPREFS' => 'ユーザ設定',
    'SPEEDLIMIT' => '"あなたの最新の投稿は %s 秒前でした。<br' . XHTML . '>次の投稿まで、最低 %s 秒お待ちください。"',
    'ACCESSERROR' => 'アクセスエラー',
    'ACTIONS' => 'アクション',
    'DELETEALL' => 'すべての選択したデータを削除',
    'DELCONFIRM' => '選択したデータを削除してよろしいですか？',
    'DELALLCONFIRM' => 'すべてのデータを削除してよろしいですか？',
    'STARTEDBY' => '初期投稿',
    'WARNING' => 'ご注意',
    'MODERATED' => 'モデレータ: %s',
    'LASTREPLYBY' => '最新の書き込み者:&nbsp;%s',
    'UID' => 'UID',
    'FORUMMENU' => '掲示板メニュー',
    'INDEXPAGE' => '掲示板目次',
    'FEATURE' => '機能',
    'SETTING' => '設定',
    'MARKALLREAD' => 'すべて既読にする',
    'MSG_NO_CAT' => 'カテゴリーまたは掲示板が定義されていません。',
    'FORUMPOSTS' => '掲示板投稿',
    'CODE' => 'コード',
    'FONTCOLOR' => '文字色',
    'FONTSIZE' => '文字サイズ',
    'CLOSETAGS' => 'タグを閉じる',
    'CODETIP' => 'ヒント: 選択した文字列にすぐにスタイルを適用できます',
    'TINY' => '小さい',
    'SMALL' => '小さめ',
    'NORMAL' => '標準',
    'LARGE' => '大きめ',
    'HUGE' => '大きい',
    'DEFAULT' => '既定',
    'DKRED' => '濃赤',
    'RED' => '赤',
    'ORANGE' => 'オレンジ',
    'BROWN' => '茶',
    'YELLOW' => '黄',
    'GREEN' => '緑',
    'OLIVE' => 'オリーブ',
    'CYAN' => '水色',
    'BLUE' => '青',
    'DKBLUE' => '濃青',
    'INDIGO' => '藍色',
    'VIOLET' => '紫',
    'WHITE' => '白',
    'BLACK' => '黒',
    'b_help' => '太字にする: [b]text[/b]',
    'i_help' => 'イタリック体にする: [i]text[/i]',
    'u_help' => '下線を引く: [u]text[/u]',
    'q_help' => '引用する: [quote]text[/quote]',
    'c_help' => 'コードを表示する: [code]code[/code]',
    'l_help' => '数字なしリストにする: [list]text[/list]',
    'o_help' => '数字付きリストにする: [olist]text[/olist]',
    'p_help' => '[img]http://画像のurl[/img]  または  [img w=100 h=200][/img]',
    'w_help' => 'URLを挿入する: [url]http://url[/url] または [url=http://url]URLテキスト[/url]',
    'a_help' => '閉じていないbbCodeのタグをすべて閉じる',
    's_help' => '文字色: [color=red]text[/color]  ヒント: color=#FF0000 という形式でも指定できます',
    'f_help' => '文字サイズ: [size=7]小さめの文字[/size]',
    'h_help' => '詳細を見るにはクリックしてください'
);

$LANG_GF02 = array(
    'msg01' => '申し訳ありませんが、掲示への参加には登録が必要です。 ',
    'msg02' => '申し訳ありませんが、この掲示板への参加には登録が必要です。',
    'msg03' => 'リダイレクト中です。しばらくお待ちください。',
    'msg05' => '<center><em>まだ登録されていません。</em></center>',
    'msg07' => 'オンラインユーザ:',
    'msg14' => '登録が必要です。<br' . XHTML . '>',
    'msg15' => 'エラーだと思われたら、 <a href="mailto:%s?subject=Guestbook IP Ban">掲示板管理者</a>まで。',
    'msg18' => 'エラー! 必須項目が入力されていないかまたは短すぎます。',
    'msg19' => 'メッセージが登録されました',
    'msg22' => '- 掲示板投稿通知',
    'msg23a' => "掲示板[%s]に%sさんから新しく書き込みがありました。\n（トピック作成者：%sさん　掲示板：%s）",
    'msg23b' => "新しいトピック '%s' が\n%s さんによって %s 掲示板に投稿されました。\n（サイト：%s）\n\n%s/forum/viewtopic.php?showtopic=%s\n",
    'msg23c' => "%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n",
    'msg25' => "\n",
    'msg26' => "\n※このトピックはメール通知が設定されています。",
    'msg27' => "\nメール通知解除: \n%s\n",
    'msg33' => '投稿者: ',
    'msg36' => '気分アイコン:',
    'msg38' => 'メール通知',
    'msg40' => '<br' . XHTML . '>既にメール通知に設定されています。<br' . XHTML . '><br' . XHTML . '>',
    'msg44' => '<p style="margin:0px; padding:5px;">メール通知が解除されています</p>',
    'msg49' => '(参照数 %s回) ',
    'msg55' => '削除されました。',
    'msg56' => 'IPアドレスは禁止されました。',
    'msg59' => '通常',
    'msg60' => '新着',
    'msg61' => '注目トピック',
    'msg62' => '書き込みがあればメール通知する',
    'msg64' => 'トピック %s 件名: %s 　を本当に削除してもよろしいですか?',
    'msg65' => '<br' . XHTML . '>これは親投稿です。そのためこのトピックの中のすべての書き込みもあわせて削除されます。',
    'msg68' => '注意: 禁止は注意深く行ってください。管理者だけが禁止者を解除できます。',
    'msg69' => '<br' . XHTML . '>本当にこのIPアドレスを禁止しますか: %s?',
    'msg71' => '機能が選択されていません。投稿を選択しモデレータの機能を実行してください。<br' . XHTML . '>注意:あなたはモデレータとなってこれらの機能を使ってください。',
    'msg72' => 'このメッセージがオンラインなら管理者機能は成功しません。',
    'msg74' => '最近の投稿 %s 件',
    'msg75' => '閲覧数トップ %s 件',
    'msg76' => '投稿数トップ %s 件',
    'msg77' => '<br' . XHTML . '><p style="padding-left: 10px;">申し訳ありません。先にログインしてください。アカウントがなければ新規登録してください。</p>',
    'msg83' => '<br' . XHTML . '><br' . XHTML . '><p>掲示板のタイトルを入力してください。</p>',
    'msg84' => '全て既読にする',
    'msg85' => 'ページ:',
    'msg86' => '&nbsp;最新 %s 投稿　投稿者&nbsp;',
    'msg87' => '<br' . XHTML . '>警告:このトピックはロックされています。<br' . XHTML . '>追加の投稿はできません。',
    'msg88' => '掲示板投稿者リスト',
    'msg88b' => '掲示板発言者のみ',
    'msg89' => 'メール通知設定リスト',
    'msg101' => 'ルール:',
    'msg103' => '掲示板ジャンプ:',
    'msg106' => '掲示板を選択',
    'msg108' => '新規投稿のある掲示板',
    'msg109' => 'ロックされたトピック',
    'msg110' => '編集ページに移動中...',
    'msg111' => '未読リスト:',
    'msg112' => '未読を表示する',
    'msg113' => '未読を表示する',
    'msg114' => 'ロック済',
    'msg115' => '注目トピック 新着',
    'msg116' => 'ロック済トピック 新着',
    'msg117' => 'サイト検索',
    'msg118' => '掲示板検索',
    'msg119' => '検索結果:',
    'msg120' => '人気順 by',
    'msg121' => '時刻はすべて %s , 現在の時刻は %s',
    'msg122' => '人気順リスト件数',
    'msg123' => '人気順リストに表示する件数',
    'msg126' => '検索ライン',
    'msg127' => '探索結果に表示するラインの数',
    'msg128' => '投稿者数/1ページ',
    'msg129' => '投稿者リストの1ページに表示する人数',
    'msg130' => 'ゲストユーザ投稿表示',
    'msg131' => 'ゲストユーザ投稿を表示する',
    'msg132' => 'メール通知モード',
    'msg133' => '書き込みがあればメール通知を既定値にする',
    'msg134' => 'メール通知を開始しました。',
    'msg135' => 'この掲示板への全ての投稿があなたに通知されます。',
    'msg136' => '投稿先の掲示板を選んでください。',
    'msg137' => '書き込みがあればメールで通知されます。',
    'msg138' => '<b>掲示板全体</b>',
    'msg142' => 'メール通知を開始しました。',
    'msg144' => 'トピックへ',
    'msg146' => 'メール通知を解除しました。',
    'msg147' => '掲示板の印刷',
    'msg148' => '<a href="javascript:history.back()">戻る</a>',
    'msg155' => '投稿なし',
    'msg156' => '投稿数',
    'msg157' => '最新10投稿',
    'msg158' => '最新10投稿者 ',
    'msg159' => 'モデレータのデータを本当に削除してもよいですか？',
    'msg160' => '投稿の最後のページを見る',
    'msg163' => '投稿を移動しました。',
    'msg164' => '全て既読にする',
    'msg166' => 'エラー: 記事が壊れたか、見つかりません。',
    'msg167' => '通知オプション',
    'msg168' => 'メール通知を無効にする',
    'msg169' => 'メンバーリストへ戻る',
    'msg170' => '最新の投稿',
    'msg171' => '掲示板アクセスエラー',
    'msg172' => '投稿がないか、削除されています。',
    'msg173' => 'メッセージ投稿ページへ移ります...',
    'msg174' => 'BAN Memberが見れません。 - IPアドレスが不正',
    'msg175' => '掲示板一覧へ戻る',
    'msg176' => 'メンバー選択',
    'msg177' => 'すべてのメンバー',
    'msg178' => '親の投稿のみ',
    'msg179' => '内容生成: %s 秒',
    'msg180' => '掲示板投稿警告',
    'msg181' => 'あなたは掲示板管理者としてアクセスできません。',
    'msg182' => 'モデレータ確認',
    'msg183' => '新規投稿: %s',
    'msg184' => '1回のみ通知',
    'msg185' => '次に訪問するまでに、複数の投稿があっても通知は1回のみする',
    'msg186' => '新投稿件名',
    'msg187' => '<a href="%s">投稿へ戻る</a>',
    'msg188' => 'クリックすると最新投稿へジャンプします。',
    'msg189' => 'エラー: もうこの投稿は編集できません。',
    'msg190' => 'こっそり編集',
    'msg191' => '編集できません。編集可能期間が終了したか、モデレータ権限がありません。',
    'msg192' => '完了しました。%s個のトピックと %s個のコメントをインポートしました。',
    'msg193' => '記事を掲示板にインポートするユーティリティ',
    'msg194' => '新規投稿のない掲示板',
    'msg195' => 'クリックすると掲示板へジャンプします',
    'msg196' => '掲示板の目次を見る',
    'msg197' => '全カテゴリを既読にする',
    'msg198' => '掲示板の設定を更新する',
    'msg199' => '掲示板通知を見る/削除する',
    'msg200' => '投稿者リスト',
    'msg201' => '人気トピック',
    'msg202' => '新規書込なし',
    'msg300' => 'ゲストユーザの書き込みは非表示の設定になっています。',
    'msg301' => '全カテゴリを既読にしてもいいですか?',
    'msg302' => 'このカテゴリの全ての投稿を既読にしてもいいですか?',
    'PostReply' => '新しく書き込む',
    'PostTopic' => '新規投稿',
    'EditTopic' => '投稿編集',
    'quietforum' => '掲示板に新規投稿がありません。'
);

$LANG_GF03 = array(
    'delete' => '削除',
    'edit' => '編集',
    'move' => '移動',
    'split' => '投稿分割',
    'ban' => 'IPアドレス禁止',
    'movetopic' => '移動&amp;削除',
    'movetopicmsg' => '<br' . XHTML . '> 次の掲示板へ <b>%s</b> を移動します',
    'splittopicmsg' => '<br' . XHTML . '>新規投稿: "<b>%s</b>"<br' . XHTML . '><em>投稿者:</em>&nbsp;%s&nbsp; <em>元の投稿:</em>&nbsp;%s',
    'selectforum' => '新規掲示板選択:',
    'lockedpost' => '書き込みを追加',
    'splitheading' => 'スレッドオプション分割:',
    'splitopt1' => 'ここからすべての投稿を移動',
    'splitopt2' => '1投稿のみ移動'
);

$LANG_GF04 = array(
    'label_forum' => '掲示板の概要',
    'label_location' => '場所',
    'label_aim' => 'AIMハンドル名',
    'label_yim' => 'YIMハンドル名',
    'label_icq' => 'ICQハンドル名',
    'label_msnm' => 'MSNメッセンジャー名',
    'label_interests' => '趣味',
    'label_occupation' => '仕事'
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
    1 => '統計',
    2 => '設定',
    3 => '掲示板管理',
    4 => 'モデレータ',
    5 => '記事を掲示板へ',
    6 => 'メッセージ',
    7 => '禁止IPアドレス'
);

$LANG_GF07 = array(
    1 => '掲示板の表示',
    2 => 'ユーザ設定',
    3 => '書き込み数人気順',
    4 => 'メール通知設定リスト',
    5 => '投稿者リスト'
);

$LANG_GF08 = array(
    1 => 'トピックのメール通知',
    2 => '掲示板のメール通知',
    3 => 'トピック通知の例外'
);

$LANG_GF09 = array(
    'edit' => '編集',
    'email' => 'メール',
    'home' => 'ホーム',
    'lastpost' => '最近の投稿',
    'pm' => 'PM',
    'profile' => 'プロファイル',
    'quote' => '引用',
    'website' => 'Webサイト',
    'newtopic' => '新規トピック',
    'replytopic' => '返信'
);

$LANG_GF91 = array(
    'gfstats' => '掲示板の統計',
    'statsmsg' => '現在:',
    'totalcats' => '合計 カテゴリー数:',
    'totalforums' => '合計 掲示板数:',
    'totaltopics' => '合計 トピック数:',
    'totalposts' => '合計 投稿数:',
    'totalviews' => '合計 閲覧数:',
    'avgpmsg' => '平均投稿数:',
    'category' => 'カテゴリー:',
    'forum' => '掲示板:',
    'topic' => 'トピック:',
    'avgvmsg' => '平均閲覧数:'
);

$LANG_GF92 = array(
    'gfsettings' => '設定',
    'showiframe' => 'トピックレビュー表示',
    'showiframedscp' => 'トピックに新しく書き込む場合、下にトピックの内容を表示する',
    'topicspp' => '1ページごとのトピック数',
    'topicsppdscp' => '各掲示板でトピックの一覧を表示する場合の1ページに表示するトピックの数',
    'postspp' => '1ページごとの投稿数',
    'postsppdscp' => '各トピックで投稿メッセージを表示する場合の1ページ当に表示する投稿数',
    'setsavemsg' => '設定は保存されました。'
);

$LANG_GF93 = array(
    'gfboard' => '掲示板管理',
    'addcat' => 'カテゴリーを追加',
    'addforum' => '掲示板を追加',
    'catorder' => 'カテゴリーの順番',
    'catadded' => 'カテゴリーが追加されました。',
    'catdeleted' => 'カテゴリーが削除されました。',
    'catedited' => 'カテゴリーが更新されました。',
    'forumadded' => '掲示板が追加されました。',
    'forumaddError' => '掲示板追加エラー',
    'forumdeleted' => '掲示板が削除されました。',
    'forummerged' => 'Forum Merged',
    'forumnotmerged' => 'Forum cannot be merged since no other forums available to be merged with.',
    'forumedited' => '掲示板が更新されました。',
    'forumordered' => '掲示板の順番を更新しました。',
    'back' => '戻る',
    'addnote' => '注意: これらの変数を編集できます。',
    'editforumnote' => '編集: <b>"%s"</b>',
    'deleteforumnote1' => '掲示板&nbsp;<b>"%s"</b>&nbsp;を削除してもよろしいですか ?',
    'deleteforumnote2' => 'この掲示板に属する全てのトピックも削除されます。',
    'mergeforumnote1' => 'Merge the forum <b>"%s"</b> with?',
    'mergeforumnote2' => 'Forum to merge into:',
    'editcatnote' => '編集: <b>"%s"</b>',
    'deletecatnote1' => 'カテゴリー&nbsp;<b>"%s"</b>&nbsp;を削除してもよろしいですか ?',
    'deletecatnote2' => 'このカテゴリーのすべての掲示板とトピックも削除されます。',
    'undercat' => 'カテゴリー:',
    'groupaccess' => 'グループ: ',
    'action' => 'アクション',
    'forumdescription' => '掲示板の説明',
    'posts' => '投稿数',
    'ordertitle' => '順番',
    'ModEdit' => '編集',
    'ModMove' => '移動',
    'ModStick' => '注目',
    'ModBan' => '禁止',
    'addmoderator' => 'モデレータを追加',
    'delmoderator' => "選択したモデレータを削除\n",
    'moderatorwarning' => '<b>注意: 掲示板がみつかりません。</b><br' . XHTML . '><br' . XHTML . '>モデレータ追加の前に、掲示板カテゴリを作成して少なくとも掲示板を1つ作成してください。',
    'private' => 'プライベート掲示板',
    'filtertitle' => 'モデレータ情報表示',
    'addmessage' => '新しいモデレータを追加',
    'allowedfunctions' => '許可されている権限',
    'userrecords' => 'ユーザレコード',
    'grouprecords' => 'グループレコード',
    'filterview' => 'フィルタービュー',
    'readonly' => '閲覧掲示板',
    'readonlydscp' => 'モデレータだけが投稿できる掲示板',
    'hidden' => '隠された掲示板',
    'hiddendscp' => '掲示板の目次を隠す',
    'hideposts' => '新規投稿を隠す',
    'hidepostsdscp' => '新規投稿ブロックとRSSフィードから投稿を隠す',
    'mod_title' => 'モデレータ',
    'allforums' => 'すべての掲示板'
);

$LANG_GF95 = array(
    'header1' => '投稿されたトピックを議論しましょう。',
    'header2' => '投稿されたトピックの議論&nbsp;&raquo;&nbsp;%s',
    'notyet' => 'この機能はまだ実装されていません。',
    'delall' => 'すべて削除',
    'delallmsg' => 'すべてのメッセージを削除しますか？: %s?',
    'underforum' => '<b> %s (ID #%s)',
    'moderate' => 'モデレートする',
    'nomess' => 'まだメッセージは投稿されていません。'
);

$LANG_GF96 = array(
    'ip' => 'IP',
    'enterip' => '禁止IPアドレス入力',
    'gfipman' => '禁止IPアドレス',
    'ban' => '禁止',
    'noips' => '<p style="margin: 0px; padding: 5px;">禁止されているIPアドレスはありません!</p>',
    'unban' => '禁止取消',
    'ipbanned' => '禁止IPアドレス',
    'banip' => '禁止IPアドレス確定',
    'banipmsg' => '禁止したいですか？IP %s?',
    'specip' => '禁止IP アドレスを指定してください!',
    'ipunbanned' => '禁止は解除されました。',
    'noip' => 'IPアドレスが入力されていません!'
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
$PLG_forum_MESSAGE1 = '掲示板プラグインアップグレード: 成功しました。';
$PLG_forum_MESSAGE2 = '掲示板プラグインアップグレード: 自動インストール失敗。プラグインドキュメントをご覧ください。';
$PLG_forum_MESSAGE5 = '掲示板プラグインのアップグレードに失敗しました。エラーログ(error.log)をご覧ください。';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['forum'] = array(
    'label' => '掲示板',
    'title' => '掲示板の設定'
);

$LANG_confignames['forum'] = array(
    'registration_required' => '閲覧にはログインが必要',
    'registered_to_post' => '投稿にはログインが必要',
    'allow_notification' => 'メールで通知する',
    'show_topicreview' => '返信作成時に投稿履歴を表示',
    'allow_user_dateformat' => 'ユーザーの日付書式を使用',
    'use_pm_plugin' => 'PMプラグインを使用',
    'show_topics_perpage' => 'トピックの1ページあたり表示数',
    'show_posts_perpage' => '投稿の1ページあたり表示数',
    'show_messages_perpage' => 'メッセージの1ページあたり表示数',
    'show_searches_perpage' => '検索結果の1ページあたり表示数',
    'showblocks' => '掲示板で表示するブロックカラム',
    'usermenu' => 'ユーザーメニューの種類',
    'use_themes_template' => 'テーマ内の掲示板用テンプレートを使用',
    'show_subject_length' => '件名の最大文字数',
    'min_username_length' => 'ユーザ名の最小文字数',
    'min_subject_length' => '件名の最小文字数',
    'min_comment_length' => '投稿本文の最小文字数',
    'views_tobe_popular' => '人気度を判断する投稿数',
    'post_speedlimit' => '投稿間隔の最小時間(秒)',
    'allowed_editwindow' => '投稿の編集を許可する制限時間(秒)',
    'allow_html' => 'HTMLによる投稿を許可',
    'post_htmlmode' => '既定の投稿モードをHTMLにする',
    'convert_break' => '改行をHTML(&lt;br&gt;)に変換',
    'use_censor' => 'Geeklogの検閲機能を使用',
    'use_glfilter' => 'GeeklogのHTMLフィルタを使用',
    'use_geshi' => 'GeSHiを使用',
    'use_spamx_filter' => 'Spam-Xプラグインを使用',
    'show_moods' => '気分アイコンを使用',
    'allow_smilies' => 'スマイリーアイコンを使用',
    'use_smilies_plugin' => 'スマイリープラグインを使用',
    'avatar_width' => 'アバター画像の幅',
    'show_centerblock' => 'センターブロックを表示',
    'centerblock_homepage' => 'トップページのみ表示',
    'centerblock_numposts' => 'センターブロックの表示投稿数',
    'cb_subject_size' => 'トピック件名の表示文字数',
    'centerblock_where' => 'センターブロックの表示位置',
    'sideblock_numposts' => 'サイドブロックの表示投稿数',
    'sb_subject_size' => 'トピック件名の表示文字数',
    'sb_latestpostonly' => '最新投稿のみ表示',
    'sideblock_enable' => '有効化',
    'sideblock_isleft' => 'ブロックを左側に表示',
    'sideblock_order' => 'ブロックの順番',
    'sideblock_topic_option' => '話題オプション',
    'sideblock_topic' => '話題',
    'sideblock_group_id' => 'グループ',
    'sideblock_permissions' => 'パーミッション',
    'level1' => 'レベル1の最小投稿数',
    'level2' => 'レベル2の最小投稿数',
    'level3' => 'レベル3の最小投稿数',
    'level4' => 'レベル4の最小投稿数',
    'level5' => 'レベル5の最小投稿数',
    'level1name' => 'レベル1の名前',
    'level2name' => 'レベル2の名前',
    'level3name' => 'レベル3の名前',
    'level4name' => 'レベル4の名前',
    'level5name' => 'レベル5の名前',
    'menublock_enable' => '有効化',
    'menublock_isleft' => 'ブロックを左側に表示',
    'menublock_order' => 'ブロックの順番',
    'menublock_topic_option' => '話題オプション',
    'menublock_topic' => '話題',
    'menublock_group_id' => 'グループ',
    'menublock_permissions' => 'パーミッション'
);

$LANG_configsubgroups['forum'] = array(
    'sg_main' => 'メイン'
);

$LANG_tab['forum'] = array(
    'tab_main' => '一般設定',
    'tab_topicposting' => '投稿設定',
    'tab_centerblock' => 'センターブロック',
    'tab_sideblock' => 'サイドブロック',
    'tab_rank' => 'ランク',
    'tab_menublock' => 'メニューブロック'
);

$LANG_fs['forum'] = array(
    'fs_main' => '一般設定',
    'fs_topicposting' => '投稿設定',
    'fs_centerblock' => 'センターブロック',
    'fs_sideblock' => 'サイドブロック',
    'fs_sideblock_settings' => 'ブロック設定',
    'fs_sideblock_permissions' => 'ブロックのパーミッションのデフォルト（[0]所有者 [1]グループ [2]メンバー [3]ゲスト）',
    'fs_rank' => 'ランク',
    'fs_menublock' => 'メニューブロック',
    'fs_menublock_settings' => 'ブロック設定',
    'fs_menublock_permissions' => 'ブロックのパーミッション'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['forum'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    5 => array('ページのトップ' => 1, '注目記事のあと' => 2, 'ページのボトム' => 3),
    6 => array('左ブロック' => 'leftblocks', '右ブロック' => 'rightblocks', '全ブロック' => 'allblocks', 'ブロック無し' => 'noblocks'),
    7 => array('ブロックメニュー' => 'blockmenu', 'ナビゲーションバー' => 'navbar', '無し' => 'none'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('アクセス不可' => 0, 'Use' => 2),
    14 => array('アクセス不可' => 0, 'Read-Only' => 2),
    15 => array('すべて' => 'TOPIC_ALL_OPTION', 'ホームページのみ' => 'TOPIC_HOMEONLY_OPTION', '話題を選択' => 'TOPIC_SELECTED_OPTION')
);

?>
