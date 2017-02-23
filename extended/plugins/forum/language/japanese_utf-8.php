<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
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

$PLG_forum_MESSAGE1 = '掲示板プラグインアップグレード: 成功しました。';
$PLG_forum_MESSAGE2 = '掲示板プラグインアップグレード: 自動インストール失敗。プラグインドキュメントをご覧ください。';
$PLG_forum_MESSAGE5 = '掲示板プラグインのアップグレードに失敗しました。エラーログ(error.log)をご覧ください。';

$LANG_GF00 = array (
    'pluginlabel'       => '掲示板',
    'searchlabel'       => '掲示板',
    'statslabel'        => '全掲示板投稿',
    'statsheading1'     => '掲示板上位10位閲覧数',
    'statsheading2'     => '掲示板上位10位書き込み数',
    'statsheading3'     => '投稿はありません。',
    'useradminmenu'     => '掲示板の機能',
    'access_denied'     => 'アクセスが拒否されました',
    'autotag_desc_forum' => '[forum: id alternate title] - 掲示板トピックのタイトルで掲示板トピックへのリンクを表示。アンカーテキストの指定は任意。'
);


$LANG_GF01['FORUM']          = '掲示板';
$LANG_GF01['ALL']            = 'すべて';
$LANG_GF01['YES']            = 'はい';
$LANG_GF01['NO']             = 'いいえ';
$LANG_GF01['NEW']            = '新着';
$LANG_GF01['NEXT']           = '次へ';
$LANG_GF01['ERROR']          = 'エラー!';
$LANG_GF01['CONFIRM']        = '確認';
$LANG_GF01['UPDATE']         = '更新';
$LANG_GF01['SAVE']           = '保存';
$LANG_GF01['CANCEL']         = '取り消し';
$LANG_GF01['ON']             = '投稿日: ';
$LANG_GF01['ON2']            = '&nbsp;&nbsp;<b>オン: </b>';
$LANG_GF01['BY']             = '投稿者: ';
$LANG_GF01['RE']             = '書込: ';
$LANG_GF01['DATE']           = '日付';
$LANG_GF01['VIEWS']          = '閲覧数';
$LANG_GF01['REPLIES']        = '書込数';
$LANG_GF01['NAME']           = '名前:';
$LANG_GF01['DESCRIPTION']    = '説明: ';
$LANG_GF01['TOPIC']          = '件名';
$LANG_GF01['TOPICS']         = '投稿';
$LANG_GF01['TOPICSUBJECT']   = '件名';
$LANG_GF01['HOMEPAGE']       = 'ホーム';
$LANG_GF01['SUBJECT']        = '件名';
$LANG_GF01['HELLO']          = 'こんにちは！ ';
$LANG_GF01['MOVED']          = '移動';
$LANG_GF01['POSTS']          = '投稿数';
$LANG_GF01['LASTPOST']       = '最新投稿';
$LANG_GF01['POSTEDON']       = '投稿日';
$LANG_GF01['POSTEDBY']       = '投稿者';
$LANG_GF01['PAGES']          = 'ページ';
$LANG_GF01['TODAY']          = '今日の';
$LANG_GF01['REGISTERED']     = '登録日';
$LANG_GF01['ORDERBY']        = '並び換え:';
$LANG_GF01['ORDER']          = '順番:';
$LANG_GF01['USER']           = 'ユーザ';
$LANG_GF01['GROUP']          = 'グループ';
$LANG_GF01['ANON']           = 'ゲストユーザ: ';
$LANG_GF01['ADMIN']          = '管理者';
$LANG_GF01['AUTHOR']         = '投稿者';
$LANG_GF01['NOMOOD']         = '-気分アイコン-';
$LANG_GF01['REQUIRED']       = '[要求]';
$LANG_GF01['OPTIONAL']       = '[オプション]';
$LANG_GF01['SUBMIT']         = '投稿する';
$LANG_GF01['PREVIEW']        = 'プレビュー';
$LANG_GF01['REMOVE']         = '解除';
$LANG_GF01['EDIT']           = '編集';
$LANG_GF01['DELETE']         = '削除';
$LANG_GF01['MERGE']          = 'マージ';
$LANG_GF01['OPTIONS']        = 'オプション:';
$LANG_GF01['MISSINGSUBJECT'] = '件名なし';
$LANG_GF01['MIGRATE_NOW']    = 'インポート実行';
$LANG_GF01['no_articles_found']    = '記事がありません。';
$LANG_GF01['FILTERLIST']     = 'フィルタリスト';
$LANG_GF01['SELECTFORUM']    = '掲示板を選択';
$LANG_GF01['DELETEAFTER']    = '実行後に削除';
$LANG_GF01['MIGRATEARTICLES']    = '選択された記事のインポート先';
$LANG_GF01['TITLE']          = 'タイトル';
$LANG_GF01['COMMENTS']       = 'コメント';
$LANG_GF01['SUBMISSIONS']    = '投稿したもの';
$LANG_GF01['HTML_FILTER_MSG']  = '一部のHTMLを許可';
$LANG_GF01['HTML_FULL_MSG']  = 'すべてのHTMLを許可';
$LANG_GF01['HTML_MSG']       = 'HTML許可';
$LANG_GF01['CENSOR_PERM_MSG']= 'バッドワードをチェック';
$LANG_GF01['ANON_PERM_MSG']  = 'ゲストユーザの投稿を見る';
$LANG_GF01['POST_PERM_MSG1'] = '投稿可能';
$LANG_GF01['POST_PERM_MSG2'] = 'ゲストユーザ投稿可能';
$LANG_GF01['GO']             = '実行';
$LANG_GF01['STATUS']         = '状態:';
$LANG_GF01['ONLINE']         = 'オンライン';
$LANG_GF01['OFFLINE']        = 'オフライン';
$LANG_GF01['back2parent']    = '親の投稿';
$LANG_GF01['forumname']      = '';
$LANG_GF01['category']       = 'カテゴリ: ';
$LANG_GF01['loginreqview']   = '掲示板に参加するためには、 %s 登録</a> または %s ログイン </a> してください。';
$LANG_GF01['loginreqfeature']   = '掲示板の機能を使用するためには、 %s 登録</a> または %s ログイン </a> してください。';
$LANG_GF01['loginreqpost']   = '投稿するためには、登録またはログインしてください。';
$LANG_GF01['nolastpostmsg']  = 'N/A';
$LANG_GF01['no_one']         = '1つではない。';
$LANG_GF01['back2top']       = 'トップへ戻る';
$LANG_GF01['TEXTMODE']       = 'テキストモード';
$LANG_GF01['HTMLMODE']       = 'HTMLモード';
$LANG_GF01['TopicPreview']   = '投稿プレビュー';
$LANG_GF01['moderator']      = 'モデレータ';
$LANG_GF01['admin']          = '管理者';
$LANG_GF01['DATEADDED']      = '登録日';
$LANG_GF01['PREVTOPIC']      = '前のトピックへ';
$LANG_GF01['NEXTTOPIC']      = '次のトピックへ';
$LANG_GF01['RESYNC']         = "更新";
$LANG_GF01['RESYNCCAT']      = "カテゴリを更新";
$LANG_GF01['EDITICON']       = '編集';
$LANG_GF01['QUOTEICON']      = '引用して書き込む';
$LANG_GF01['ProfileLink']    = 'プロフィール';
$LANG_GF01['WebsiteLink']    = 'ホームページ';
$LANG_GF01['PMLink']         = 'PM';
$LANG_GF01['EmailLink']      = 'メール';
$LANG_GF01['FORUMSUBSCRIBE'] = 'メール通知を開始';
$LANG_GF01['FORUMUNSUBSCRIBE'] = 'メール通知を解除';
$LANG_GF01['FORUMSUBSCRIBE_TRUE'] = 'この掲示板のメール通知:有効';
$LANG_GF01['FORUMSUBSCRIBE_FALSE'] = 'この掲示板のメール通知:無効';
$LANG_GF01['NEWTOPIC']       = '新規トピック';
$LANG_GF01['NEWPOSTS']       = '新規投稿';
$LANG_GF01['NEWFORUMPOSTS']  = '新規投稿';
$LANG_GF01['POSTREPLY']      = '返信投稿';
$LANG_GF01['SubscribeLink']  = 'メール通知を開始';
$LANG_GF01['unSubscribeLink'] = 'メール通知を解除';
$LANG_GF01['SubscribeLink_TRUE']  = 'このトピックのメール通知:有効';
$LANG_GF01['SubscribeLink_FALSE'] = 'このトピックのメール通知:無効';
$LANG_GF01['SUBSCRIPTIONS']  = '投稿オプション';
$LANG_GF01['TOP']            = 'トップ';
$LANG_GF01['PRINTABLE']      = '印刷用ページ';
$LANG_GF01['USERPREFS']      = 'ユーザ設定';
$LANG_GF01['SPEEDLIMIT']     = '"あなたの最新の投稿は %s 秒前でした。<br' . XHTML . '>次の投稿まで、最低 %s 秒お待ちください。"';
$LANG_GF01['ACCESSERROR']    = 'アクセスエラー';
$LANG_GF01['ACTIONS']        = 'アクション';
$LANG_GF01['DELETEALL']      = 'すべての選択したデータを削除';
$LANG_GF01['DELCONFIRM']     = '選択したデータを削除してよろしいですか？';
$LANG_GF01['DELALLCONFIRM']  = 'すべてのデータを削除してよろしいですか？';
$LANG_GF01['STARTEDBY']      = '初期投稿';
$LANG_GF01['WARNING']        = 'ご注意';
$LANG_GF01['MODERATED']      = 'モデレータ: %s';
$LANG_GF01['LASTREPLYBY']    = '最新の書き込み者:&nbsp;%s';
$LANG_GF01['UID']            = 'UID';
$LANG_GF01['FORUMMENU']      = '掲示板メニュー';
$LANG_GF01['INDEXPAGE']      = '掲示板目次';
$LANG_GF01['FEATURE']        = '機能';
$LANG_GF01['SETTING']        = '設定';
$LANG_GF01['MARKALLREAD']    = 'すべて既読にする';
$LANG_GF01['MSG_NO_CAT']     = 'カテゴリーまたは掲示板が定義されていません。';
$LANG_GF01['FORUMPOSTS']     = '掲示板投稿';
$LANG_GF01['FORUMPOST']      = '掲示板投稿';
$LANG_GF01['MESSAGE']        = 'メッセージ';

// Language for bbcode toolbar
$LANG_GF01['CODE']           = 'コード';
$LANG_GF01['FONTCOLOR']      = '文字色';
$LANG_GF01['FONTSIZE']       = '文字サイズ';
$LANG_GF01['CLOSETAGS']      = 'タグを閉じる';
$LANG_GF01['CODETIP']        = 'ヒント: 選択した文字列にすぐにスタイルを適用できます';
$LANG_GF01['TINY']           = '小さい';
$LANG_GF01['SMALL']          = '小さめ';
$LANG_GF01['NORMAL']         = '標準';
$LANG_GF01['LARGE']          = '大きめ';
$LANG_GF01['HUGE']           = '大きい';
$LANG_GF01['DEFAULT']        = '既定';
$LANG_GF01['DKRED']          = '濃赤';
$LANG_GF01['RED']            = '赤';
$LANG_GF01['ORANGE']         = 'オレンジ';
$LANG_GF01['BROWN']          = '茶';
$LANG_GF01['YELLOW']         = '黄';
$LANG_GF01['GREEN']          = '緑';
$LANG_GF01['OLIVE']          = 'オリーブ';
$LANG_GF01['CYAN']           = '水色';
$LANG_GF01['BLUE']           = '青';
$LANG_GF01['DKBLUE']         = '濃青';
$LANG_GF01['INDIGO']         = '藍色';
$LANG_GF01['VIOLET']         = '紫';
$LANG_GF01['WHITE']          = '白';
$LANG_GF01['BLACK']          = '黒';

$LANG_GF01['b_help']         = "太字にする: [b]text[/b]";
$LANG_GF01['i_help']         = "イタリック体にする: [i]text[/i]";
$LANG_GF01['u_help']         = "下線を引く: [u]text[/u]";
$LANG_GF01['q_help']         = "引用する: [quote]text[/quote]";
$LANG_GF01['c_help']         = "コードを表示する: [code]code[/code]";
$LANG_GF01['l_help']         = "数字なしリストにする: [list]text[/list]";
$LANG_GF01['o_help']         = "数字付きリストにする: [olist]text[/olist]";
$LANG_GF01['p_help']         = "[img]http://画像のurl[/img]  または  [img w=100 h=200][/img]";
$LANG_GF01['w_help']         = "URLを挿入する: [url]http://url[/url] または [url=http://url]URLテキスト[/url]";
$LANG_GF01['a_help']         = "閉じていないbbCodeのタグをすべて閉じる";
$LANG_GF01['s_help']         = "文字色: [color=red]text[/color]  ヒント: color=#FF0000 という形式でも指定できます";
$LANG_GF01['f_help']         = "文字サイズ: [size=7]小さめの文字[/size]";
$LANG_GF01['h_help']         = "詳細を見るにはクリックしてください";


$LANG_GF02['msg01']    = '申し訳ありませんが、掲示への参加には登録が必要です。 ';
$LANG_GF02['msg02']    = '申し訳ありませんが、この掲示板への参加には登録が必要です。';
$LANG_GF02['msg03']    = 'リダイレクト中です。しばらくお待ちください。';
$LANG_GF02['msg05']    = 'まだ登録されていません。';
$LANG_GF02['msg07']    = 'オンラインユーザ:';
$LANG_GF02['msg14']    = '登録が必要です。エラーだと思われたら、 <a href="mailto:%s?subject=Guestbook IP Ban">掲示板管理者</a>まで。';
$LANG_GF02['msg18']    = 'エラー! 必須項目が入力されていないかまたは短すぎます。';
$LANG_GF02['msg19']    = 'メッセージが登録されました';
$LANG_GF02['msg22']    = '- 掲示板投稿通知';
$LANG_GF02['msg23a']   = "掲示板[%s]に%sさんから新しく書き込みがありました。\n（トピック作成者：%sさん　掲示板：%s）";
$LANG_GF02['msg23b']   = "新しいトピック '%s' が\n%s さんによって %s 掲示板に投稿されました。\n（サイト：%s）\n\n%s/forum/viewtopic.php?showtopic=%s\n";
$LANG_GF02['msg23c']   = "%s/forum/viewtopic.php?showtopic=%s&lastpost=true\n";
$LANG_GF02['msg25']    = "\n";
$LANG_GF02['msg26']    = "\n※このトピックはメール通知が設定されています。";
$LANG_GF02['msg27']    = "\nメール通知解除: \n%s\n";
$LANG_GF02['msg33']    = '投稿者: ';
$LANG_GF02['msg36']    = '気分アイコン:';
$LANG_GF02['msg38']    = 'メール通知';
$LANG_GF02['msg40']    = '既にメール通知に設定されています。';
$LANG_GF02['msg44']    = 'メール通知が解除されています。';
$LANG_GF02['msg49']    = '(参照数 %s回) ';
$LANG_GF02['msg55']    = '削除されました。';
$LANG_GF02['msg56']    = 'IPアドレスは禁止されました。';
$LANG_GF02['msg59']    = '通常';
$LANG_GF02['msg60']    = '新着';
$LANG_GF02['msg61']    = '注目トピック';
$LANG_GF02['msg62']    = '書き込みがあればメール通知する';
$LANG_GF02['msg64']    = 'トピック %s 件名: %s 　を本当に削除してもよろしいですか?';
$LANG_GF02['msg65']    = 'これは親投稿です。そのためこのトピックの中のすべての書き込みもあわせて削除されます。';
$LANG_GF02['msg68']    = '注意: 禁止は注意深く行ってください。管理者だけが禁止者を解除できます。';
$LANG_GF02['msg69']    = '本当にこのIPアドレスを禁止しますか: %s?';
$LANG_GF02['msg71']    = '機能が選択されていません。投稿を選択しモデレータの機能を実行してください。<br' . XHTML . '>注意:あなたはモデレータとなってこれらの機能を使ってください。';
$LANG_GF02['msg72']    = 'このメッセージがオンラインなら管理者機能は成功しません。';
$LANG_GF02['msg74']    = '最近の投稿 %s 件';
$LANG_GF02['msg75']    = '閲覧数トップ %s 件';
$LANG_GF02['msg76']    = '投稿数トップ %s 件';
$LANG_GF02['msg77']    = '<br' . XHTML . '><p style="padding-left: 10px;">申し訳ありません。先にログインしてください。アカウントがなければ新規登録してください。</p>';
$LANG_GF02['msg83']    = '<br' . XHTML . '><br' . XHTML . '><p>掲示板のタイトルを入力してください。</p>';
$LANG_GF02['msg84']    = '全て既読にする';
$LANG_GF02['msg85']    = 'ページ:';
$LANG_GF02['msg86']    = '最新 %s 投稿　投稿者: ';
$LANG_GF02['msg87']    = '警告:このトピックはロックされています。<br' . XHTML . '>追加の投稿はできません。';
$LANG_GF02['msg88']    = '掲示板投稿者リスト';
$LANG_GF02['msg88b']   = '掲示板発言者のみ';
$LANG_GF02['msg89']    = 'メール通知設定リスト';
$LANG_GF02['msg101']   = 'ルール:';
$LANG_GF02['msg103']   = '掲示板ジャンプ:';
$LANG_GF02['msg106']   = '掲示板を選択';
$LANG_GF02['msg107']   = 'メンバーを選択';
$LANG_GF02['msg108']   = '新規投稿のある掲示板';
$LANG_GF02['msg109']   = 'ロックされたトピック';
$LANG_GF02['msg110']   = '編集ページに移動中...';
$LANG_GF02['msg111']   = '未読リスト:';
$LANG_GF02['msg112']   = '未読を表示する';
$LANG_GF02['msg113']   = '未読を表示する';
$LANG_GF02['msg114']   = 'ロック済';
$LANG_GF02['msg115']   = '注目トピック 新着';
$LANG_GF02['msg116']   = 'ロック済トピック 新着';
$LANG_GF02['msg117']   = 'サイト検索';
$LANG_GF02['msg118']   = '掲示板検索';
$LANG_GF02['msg121']   = '時刻はすべて %s , 現在の時刻は %s';
$LANG_GF02['msg134']   = 'メール通知を開始しました。';
$LANG_GF02['msg135']   = 'この掲示板への全ての投稿があなたに通知されます。';
$LANG_GF02['msg136']   = '投稿先の掲示板を選んでください。';
$LANG_GF02['msg137']   = '書き込みがあればメールで通知されます。';
$LANG_GF02['msg138']   = '<b>掲示板全体</b>';
$LANG_GF02['msg142']   = 'メール通知を開始しました。';
$LANG_GF02['msg143']   = 'Notification saved but, no email is associated with your user account (or it is invalid). Please add one to your <a href="/usersettings.php">account</a> or you will not receive any notifications.';
$LANG_GF02['msg144']   = 'トピックへ';
$LANG_GF02['msg145']   = 'No email is associated with your user account (or it is invalid). Please add one to your <a href="/usersettings.php">account</a> or you will not receive any notifications.';
$LANG_GF02['msg146']   = 'メール通知を解除しました。';
$LANG_GF02['msg147']   = 'Forum [printable version of topic %s]';
$LANG_GF02['msg148']   = '<a href="javascript:history.back()">戻る</a>';
$LANG_GF02['msg149']   = '掲示板への投稿は中止されました。';
$LANG_GF02['msg155']   = '投稿なし';
$LANG_GF02['msg156']   = '投稿数';
$LANG_GF02['msg157']   = '最新%s投稿';
$LANG_GF02['msg158']   = '最新%s投稿者 by %s';
$LANG_GF02['msg159']   = 'モデレータのデータを本当に削除してもよいですか？';
$LANG_GF02['msg160']   = '投稿の最後のページを見る';
$LANG_GF02['msg163']   = '投稿を移動しました。';
$LANG_GF02['msg164']   = '全て既読にする';
$LANG_GF02['msg166']   = 'エラー: 記事が壊れたか、見つかりません。';
$LANG_GF02['msg167']   = '通知オプション';
$LANG_GF02['msg168']   = 'メール通知を無効にする';
$LANG_GF02['msg169']   = 'メンバーリストへ戻る';
$LANG_GF02['msg170']   = '最新の投稿';
$LANG_GF02['msg171']   = '掲示板アクセスエラー';
$LANG_GF02['msg172']   = '投稿がないか、削除されています。';
$LANG_GF02['msg173']   = 'メッセージ投稿ページへ移ります...';
$LANG_GF02['msg174']   = 'BAN Memberが見れません。 - IPアドレスが不正';
$LANG_GF02['msg175']   = '掲示板一覧へ戻る';
$LANG_GF02['msg176']   = 'メンバー選択';
$LANG_GF02['msg177']   = 'すべてのメンバー';
$LANG_GF02['msg178']   = '親の投稿のみ';
$LANG_GF02['msg179']   = '内容生成: %s 秒';
$LANG_GF02['msg180']   = '掲示板投稿警告';
$LANG_GF02['msg181']   = 'あなたは掲示板管理者としてアクセスできません。';
$LANG_GF02['msg182']   = 'モデレータ確認';
$LANG_GF02['msg183']   = '新規投稿: %s';
$LANG_GF02['msg186']   = '新投稿件名';
$LANG_GF02['msg187']   = '<a href="%s">投稿へ戻る</a>';
$LANG_GF02['msg188']   = 'クリックすると最新投稿へジャンプします。';
$LANG_GF02['msg189']   = 'エラー: もうこの投稿は編集できません。';
$LANG_GF02['msg190']   = 'こっそり編集';
$LANG_GF02['msg191']   = '編集できません。編集可能期間が終了したか、モデレータ権限がありません。';
$LANG_GF02['msg192']   = '完了しました。%s個のトピックと %s個のコメントをインポートしました。';
$LANG_GF02['msg193']   = '記事を掲示板にインポートするユーティリティ';
$LANG_GF02['msg194']   = '新規投稿のない掲示板';
$LANG_GF02['msg195']   = 'クリックすると掲示板へジャンプします';
$LANG_GF02['msg196']   = '掲示板の目次を見る';
$LANG_GF02['msg197']   = '全カテゴリを既読にする';
$LANG_GF02['msg198']   = '掲示板の設定を更新する';
$LANG_GF02['msg199']   = '掲示板通知を見る/削除する';
$LANG_GF02['msg200']   = '投稿者リスト';
$LANG_GF02['msg201']   = '人気トピック';
$LANG_GF02['popularforumtopics']   = '人気トピック';
$LANG_GF02['poptopisby']   = '%sによる人気トピック';
$LANG_GF02['by']   = 'By';
$LANG_GF02['replies']   = '書込数';
$LANG_GF02['views']   = '閲覧数';
$LANG_GF02['forumsearchresults']   = '掲示板の検索結果';
$LANG_GF02['forumsearchfor']   = '掲示板の検索結果: "%s"';
$LANG_GF02['msg202']   = '新規書込なし';
$LANG_GF02['msg203']   = '投稿はありません。';
$LANG_GF02['msg300']   = 'ゲストユーザの書き込みは非表示の設定になっています。';
$LANG_GF02['msg301']   = '全カテゴリを既読にしてもいいですか?';
$LANG_GF02['msg302']   = 'このカテゴリの全ての投稿を既読にしてもいいですか?';
$LANG_GF02['PostReply']   = '新しく書き込む';
$LANG_GF02['PostTopic']   = '新規投稿';
$LANG_GF02['EditTopic']   = '投稿編集';
$LANG_GF02['quietforum']  = '掲示板に新規投稿がありません。';
$LANG_GF02['adminconfirmation']   = '管理者への確認';

$LANG_GF03 = array (
    'delete'            => '削除',
    'edit'              => '編集',
    'move'              => '移動',
    'split'             => '投稿分割',
    'banippost'         => '投稿から禁止IPアドレスを設定',
    'banippostremove'   => '投稿から禁止IPアドレスを削除',
    'banip'             => 'サイトから禁止IPアドレスを設定',
    'banipremove'       => 'サイトから禁止IPアドレスを削除',
    'banipmsg'          => 'サイトから禁止IPアドレスを設定しました。',
    'banipremovemsg'    => '投稿から禁止IPアドレスを設定しました。',
    'movetopic'         => '移動&amp;削除',
    'movetopicmsg'      => '<br' . XHTML . '> 次の掲示板へ <b>%s</b> を移動します',
    'splittopicmsg'     => '<br' . XHTML . '>新規投稿: "<b>%s</b>"<br' . XHTML . '><em>投稿者:</em>&nbsp;%s&nbsp; <em>元の投稿:</em>&nbsp;%s',
    'selectforum'       => '新規掲示板選択:',
    'lockedpost'        => '書き込みを追加',
    'splitheading'      => 'スレッドオプション分割:',
    'splitopt1'         => 'ここからすべての投稿を移動',
    'splitopt2'         => '1投稿のみ移動'
);

$LANG_GF04 = array (
    'label_forum'             => '掲示板の概要',
    'label_location'          => '場所',
    'label_aim'               => 'AIMハンドル名',
    'label_yim'               => 'YIMハンドル名',
    'label_icq'               => 'ICQハンドル名',
    'label_msnm'              => 'MSNメッセンジャー名',
    'label_interests'         => '趣味',
    'label_occupation'        => '仕事',
);

/* Settings for Additional User profile - Instant Messenging links */
$LANG_GF05 = array ( // No used
    'aim_link'               => '&nbsp;<a href="aim:goim?screenname=',
    'aim_linkend'            => '>',
    'aim_hello'              => '&amp;message=Hi.+Are+you+there?',
    'aim_alttext'            => 'AIM:&nbsp;',
    'icq_link'               => '&nbsp;',
    'icq_alttext'            => 'ICQ #:&nbsp;',
    'msn_link'               => '&nbsp;<a href="javascript:MsgrApp.LaunchIMUI(',
    'msn_linkend'            => ')">',
    'msn_alttext'            => 'Messenger:&nbsp;',
    'yim_link'               => '&nbsp;<a href="ymsgr:sendIM?',
    'yim_linkend'            => '">',
    'yim_alttext'            => 'YIM:&nbsp;',
);


/* Admin Navbar */
$LANG_GF06 = array (
    1   => '統計',
    2   => '設定',
    3   => '掲示板管理',
    4   => 'モデレータ',
    5   => '記事のインポート',
    6   => 'メッセージ',
    7   => '禁止IPアドレス'
);


/* User Functions Navbar */
$LANG_GF07 = array (
    1   => '掲示板の表示', // No used
    2   => 'ユーザ設定', // No used
    3   => '人気トピック',
    4   => 'メール通知設定リスト', // No used
    5   => '投稿者リスト' // No used
);


/* Forum User Features */
$LANG_GF08 = array (
    1   => 'トピックのメール通知',
    2   => '掲示板のメール通知',
    3   => 'トピック通知の例外'
);

/* Text for the buttons */
$LANG_GF09 = array (
    'edit'     => '編集',
    'email'    => 'メール',
    'home'     => 'ホーム',
    'lastpost' => '最近の投稿',
    'pm'       => 'PM', // private message
    'profile'  => 'プロファイル',
    'quote'    => '引用',
    'website'  => 'Webサイト',
    'newtopic' => '新規トピック',
    'replytopic' => '返信'
);

// Admin Stats page
$LANG_GF91 = array (
    'gfstats'            => '掲示板の統計',
    'statsmsg'           => '現在:',
    'totalcats'          => 'カテゴリー数:',
    'totalforums'        => '掲示板数:',
    'totaltopics'        => 'トピック数:',
    'totalposts'         => '投稿数:',
    'totalviews'         => '閲覧数:',
    'avgpmsg'            => '平均投稿数:',
    'category'           => 'カテゴリー:',
    'forum'              => '掲示板:',
    'topic'              => 'トピック:',
    'avgvmsg'            => '平均閲覧数:'
);

// User Preference Page
$LANG_GF92 = array (
    'userpreferences'    => 'ユーザ設定',
    'setsavemsg'         => '設定を保存しました。',
    'topicspp'           => '1ページごとのトピック数',
    'topicsppdscp'       => '各掲示板でトピックの一覧を表示する場合の1ページに表示するトピックの数',
    'postspp'            => '1ページごとの投稿数',
    'postsppdscp'        => '各トピックで投稿メッセージを表示する場合の1ページに表示する投稿数',
    'newpp'              => '1ページごとの新規投稿数',
    'newppdscp'          => '各トピックで新規投稿メッセージを表示する場合の1ページに表示する投稿数',
    'popularpp'          => '1ページごとの人気トピック数',
    'popularppdscp'      => '人気トピックページに表示されるトピックの1ページあたり表示数',
    'popularl'           => '人気トピックのしきい値',
    'popularldscp'       => '人気トピックに位置づけるために必要な投稿数または閲覧数',
    'searchpp'           => '1ページごとの検索結果数',
    'searchppdscp'       => '掲示板の検索結果ページに表示される検索結果の1ページあたり表示数',
    'memberspp'          => '1ページごとのメンバー数',
    'membersppdscp'      => 'メンバーリストに表示されるメンバーの1ページあたり表示数',
    'viewap'             => '匿名の投稿を表示',
    'viewapdscp'         => '「いいえ」に設定すると匿名の投稿の表示を制限します',
    'alwaysn'            => 'メール通知を常に有効',
    'alwaysndscp'        => '「はい」に設定するとあなたが作成・書込みしたトピックのメール通知を常に有効にします',
    'notifyoo'           => '1度だけメール通知',
    'notifyoodscp'       => 'あなたが最後に訪れてから複数回投稿した掲示板やトピックのメール通知を1度だけ送信します',
    'showiframe'         => 'トピックレビュー表示',
    'showiframedscp'     => 'トピックに新しく書き込む場合、下にトピックの内容を表示します'
);

// Board Admin
$LANG_GF93 = array (
    'gfboard'            => '掲示板管理',
    'addcat'             => 'カテゴリーを追加',
    'forum'              => '掲示板',
    'addforum'           => '掲示板を追加',
    'noforum'            => '掲示板はありません。',
    'category'           => 'カテゴリー',
    'catorder'           => 'カテゴリーの順番',
    'catadded'           => 'カテゴリーが追加されました。',
    'catdeleted'         => 'カテゴリーが削除されました。',
    'catedited'          => 'カテゴリーが更新されました。',
    'forumadded'         => '掲示板が追加されました。',
    'forumaddError'      => '掲示板追加エラー',
    'forumdeleted'       => '掲示板が削除されました。',
    'forummerged'        => '掲示板がマージされました。',
    'forumnotmerged'     => 'マージ可能な掲示板がありません。',
    'forumedited'        => '掲示板が更新されました。',
    'forumordered'       => '掲示板の順番を更新しました。',
    'back'               => '戻る',
    'addnote'            => '注意: これらの変数を編集できます。',
    'editforumnote'      => '編集: <b>"%s"</b>',
    'deleteforumnote'    => '掲示板&nbsp;<b>"%s"</b>&nbsp;を削除してもよろしいですか ? この掲示板に属する全てのトピックも削除されます。',
    'mergeforumnote'     => '掲示板 <b>"%s"</b> のマージ先:',
    'editcatnote'        => '編集: <b>"%s"</b>',
    'deletecatnote'      => 'カテゴリー&nbsp;<b>"%s"</b>&nbsp;を削除してもよろしいですか ? このカテゴリーのすべての掲示板とトピックも削除されます。',
    'undercat'           => 'カテゴリー:',
    'groupaccess'        => 'グループ: ',
    'action'             => 'アクション',
    'forumdescription'   => '掲示板の説明',
    'posts'              => '投稿数',
    'ordertitle'         => '順番',
    'title'              => 'タイトル',
    'description'        => '説明',
    'ModEdit'            => '編集',
    'ModMove'            => '移動',
    'ModStick'           => '注目',
    'ModBan'             => '禁止',
    'addmoderator'       => 'モデレータを追加',
    'delmoderator'       => "選択したモデレータを削除\n",
    'moderatorwarningtitle' => '警告: 掲示板が定義されていません。',
    'moderatorwarning'   => 'モデレータを追加する前にカテゴリーを設定し、少なくとも1つの掲示板を追加してください。',
    'nomoderatorfound'   => "モデレータが見つかりません。",
    'modadded'           => "モデレータが追加されました。",
    'moddeleted'         => "モデレータが削除されました。",
    'modedited'          => "モデレータが更新されました。",
    'private'            => 'プライベート掲示板',
    'filtertitle'        => 'モデレータ情報表示',
    'LANG_addmodtitle'   => '新規モデレータ',
    'addmessage'         => '新しいモデレータを追加',
    'allowedfunctions'   => '許可されている権限',
    'userrecords'        => 'ユーザレコード',
    'grouprecords'       => 'グループレコード',
    'filterview'         => 'フィルタービュー',
    'readonly'           => '閲覧掲示板',
    'readonlydscp'       => 'モデレータだけが投稿できる掲示板',
    'hidden'             => '隠された掲示板',
    'hiddendscp'         => '掲示板の目次を隠す',
    'hideposts'          => '新規投稿を隠す',
    'hidepostsdscp'      => '新規投稿ブロックとRSSフィードから投稿を隠す',
    'mod_title'          => 'モデレータ',
    'allforums'          => 'すべての掲示板'
);

// Posts
$LANG_GF95 = array (
    'header1'           => '投稿されたトピックを議論しましょう。',
    'header2'           => '投稿されたトピックの議論&nbsp;&raquo;&nbsp;%s',
    'notyet'            => 'この機能はまだ実装されていません。', // No used
    'delall'            => 'すべて削除', // No used
    'delallmsg'         => 'すべてのメッセージを削除しますか？: %s?', // No used
    'underforum'        => ' %s (ID #%s)', // No used
    'moderate'          => 'モデレートする',
    'nomess'            => 'まだメッセージは投稿されていません。'
);

// Banned IPs
$LANG_GF96 = array (
    'ip'                 => 'IP',
    'ipaddress'          => 'IPアドレス',
    'enterip'            => '禁止IPアドレス入力',
    'gfipman'            => '禁止IPアドレス',
    'ban'                => '禁止',
    'noips'              => '禁止されているIPアドレスはありません!',
    'unban'              => '禁止取消',
    'ipbanned'           => '禁止IPアドレス',
    'banipmsg'           => 'IP %sを禁止したいですか？',
    'specip'             => '禁止IPアドレスを指定してください!',
    'ipunbanned'         => '禁止は解除されました。',
    'ipnotvalid'         => 'IPアドレス %s は有効ではありません。 したがって追加されていません。',
    'noip'               => 'IPアドレスが入力されていません!'
);

// Smilies
$LANG_GF_SMILIES = array(
    // These strings are used for the "alt" and
    // "title" attribute for the smilies images
    'biggrin'  => 'Big Grin',
    'smile'    => 'Smile',
    'frown'    => 'Frown',
    'eek'      => 'Geek',
    'confused' => 'Confused',
    'cool'     => 'Cool',
    'lol'      => 'LOL',
    'angry'    => 'Angry',
    'razz'     => 'Razz',
    'oops'     => 'Oops!',
    'surprise' => 'Surprised!',
    'cry'      => 'Cry',
    'evil'     => 'Evil',
    'twisted'  => 'Twisted',
    'rolleye'  => 'Rolling Eyes',
    'wink'     => 'Wink',
    'exclaim'  => 'Exclaimation',
    'question' => 'Question',
    'idea'     => 'Idea',
    'arrow'    => 'Arrow',
    'neutral'  => 'Neutral',
    'green'    => 'Mr. Green',
    'sick'     => 'Sick',
    'tired'    => 'Tired',
    'monkey'   => 'Monkey'
);

// Localization of the Admin Configuration UI
$LANG_configsections['forum'] = array(
    'label' => '掲示板',
    'title' => '掲示板の設定'
);

$LANG_confignames['forum'] = array(
    'registration_required' => '閲覧にはログインが必要',
    'registered_to_post'    => '投稿にはログインが必要',
    'allow_notification'    => 'メールで通知する',
    'show_topicreview'      => '返信作成時に投稿履歴を表示',
    'allow_user_dateformat' => 'ユーザーの日付書式を使用',
    'use_pm_plugin'         => 'PMプラグインを使用',
    'show_topics_perpage'   => 'トピックの1ページあたり表示数',
    'show_posts_perpage'    => '投稿の1ページあたり表示数',
    'show_messages_perpage' => 'メッセージの1ページあたり表示数',
    'show_searches_perpage' => '検索結果の1ページあたり表示数',
    'showblocks'            => '掲示板で表示するブロックカラム',
    'usermenu'              => 'ユーザーメニューの種類',
    // ----------------------------------
    'show_subject_length'   => '件名の最大文字数',
    'min_username_length'   => 'ユーザ名の最小文字数',
    'min_subject_length'    => '件名の最小文字数',
    'min_comment_length'    => '投稿本文の最小文字数',
    'views_tobe_popular'    => '人気度を判断する閲覧数',
    'post_speedlimit'       => '投稿間隔の最小時間(秒)',
    'allowed_editwindow'    => '投稿の編集を許可する制限時間(秒)',
    'allow_html'            => 'HTMLによる投稿を許可',
    'post_htmlmode'         => '既定の投稿モードをHTMLにする',
    'convert_break'         => '改行をHTML(&lt;br&gt;)に変換',
    'use_censor'            => 'Geeklogの検閲機能を使用',
    'use_glfilter'          => 'GeeklogのHTMLフィルタを使用',
    'use_geshi'             => 'GeSHiを使用',
    'use_spamx_filter'      => 'Spam-Xプラグインを使用',
    'show_moods'            => '気分アイコンを使用',
    'allow_smilies'         => 'スマイリーアイコンを使用',
    'use_smilies_plugin'    => 'スマイリープラグインを使用',
    'avatar_width'          => 'アバター画像の幅',
    // ----------------------------------
    'show_centerblock'      => 'センターブロックを表示',
    'centerblock_homepage'  => 'トップページのみ表示',
    'centerblock_numposts'  => 'センターブロックの表示投稿数',
    'cb_subject_size'       => 'トピック件名の表示文字数',
    'centerblock_where'     => 'センターブロックの表示位置',
    // ----------------------------------
    'sideblock_numposts'    => 'サイドブロックの表示投稿数',
    'sb_subject_size'       => 'トピック件名の表示文字数',
    'sb_latestpostonly'     => '最新投稿のみ表示',
    'sideblock_enable'          => '有効化',
    'sideblock_isleft'          => 'ブロックを左側に表示',
    'sideblock_order'           => 'ブロックの順番',
    'sideblock_topic_option'    => '話題オプション',
    'sideblock_topic'           => '話題',
    'sideblock_group_id'        => 'グループ',
    'sideblock_permissions'     => 'パーミッション',
    // ----------------------------------
    'level1'                => 'レベル1の最小投稿数',
    'level2'                => 'レベル2の最小投稿数',
    'level3'                => 'レベル3の最小投稿数',
    'level4'                => 'レベル4の最小投稿数',
    'level5'                => 'レベル5の最小投稿数',
    'level1name'            => 'レベル1の名前',
    'level2name'            => 'レベル2の名前',
    'level3name'            => 'レベル3の名前',
    'level4name'            => 'レベル4の名前',
    'level5name'            => 'レベル5の名前',
    // ----------------------------------
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
    'tab_main'         => '一般設定',
    'tab_topicposting' => '投稿設定',
    'tab_centerblock'  => 'センターブロック',
    'tab_sideblock'    => 'サイドブロック',
    'tab_rank'         => 'ランク',
    'tab_menublock'    => 'メニューブロック'
);

$LANG_fs['forum'] = array(
    'fs_main'         => '一般設定',
    'fs_topicposting' => '投稿設定',
    'fs_centerblock'  => 'センターブロック',
    'fs_sideblock'    => 'サイドブロック',
    'fs_sideblock_settings' => 'ブロック設定',
    'fs_sideblock_permissions' => 'ブロックのパーミッション',
    'fs_rank'         => 'ランク',
    'fs_menublock'    => 'メニューブロック',
    'fs_menublock_settings' => 'ブロック設定',
    'fs_menublock_permissions' => 'ブロックのパーミッション'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['forum'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    5 => array('ページのトップ' => 1, '注目記事のあと' => 2, 'ページのボトム' => 3),
    6 => array('左ブロック' => 'leftblocks', '右ブロック' => 'rightblocks', '全ブロック' => 'allblocks', 'ブロック無し' => 'noblocks'),
    7 => array('ブロックメニュー' => 'blockmenu', 'ナビゲーションバー' => 'navbar', '無し' => 'none'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('アクセス不可' => 0, '利用する' => 2),
    14 => array('アクセス不可' => 0, '表示' => 2),
    15 => array('すべて' => TOPIC_ALL_OPTION, 'ホームページのみ' => TOPIC_HOMEONLY_OPTION, '話題を選択' => TOPIC_SELECTED_OPTION)
);
?>
