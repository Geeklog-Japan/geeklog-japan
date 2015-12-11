<?php

###############################################################################
# lang.php
# This is the english language page for the Geeklog File Mgmt Page Plug-in!
#
# Copyright (C) 2002 Blaine Lang
# blaine@portalparts.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################
# Tranlated by mystral_kk 2006/03/23
// 最終更新 2006/04/18 for Ver1.5.2
// Language variables used by the Plug-in API
# これは、Geeklogファイル管理プラグイン用日本語言語ファイルです。
# plugins/filemgmt/language/japanese_utf-8.php
# もし万一エンコードの種類がUTF-8でない場合は、UTF-8に変換してください。
# Last Update 2007/06/16 by Ivy (Geeklog Japanese)

$LANG_FM00 = array (
    'access_denied'     => 'アクセス拒否',
    'access_denied_msg' => 'Rootユーザーしかこのページにはアクセスできません。あなたのユーザー名とIPアドレスを記録しました。',
    'admin'             => 'プラグイン管理者',
    'install_header'    => 'プラグインのインストール/アンインストール',
    'installed'         => 'このプラグインとブロックはインストール済みです。<p><i>楽しんでください。<br><a href="MAILTO:blaine@portalparts.com">Blaine</a></i>',
    'uninstalled'       => 'このプラグインはインストールしていません。',
    'install_success'   => 'インストールに成功しました。<p><b>これからすべき手順は、</b>: 
        <ol><li>ファイル管理をクリックして、プラグインの設定を行う。</ol>
        <p>詳細情報は、<a href="%s">Install Notes</a>を参照。',
    'install_failed'    => 'インストールに失敗しました。エラーログを見てください。',
    'uninstall_msg'     => 'プラグインのアンインストールに成功しました。',
    'install'           => 'インストール',
    'uninstall'         => 'アンインストール',
    'editor'            => 'プラグインエディター',
    'warning'           => 'アンインストール前の警告',
    'enabled'           => '<p style="padding: 15px 0px 5px 25px;">プラグインをインストールして有効となっています。<br>プラグインをアンインストールしたい場合は、最初に無効にしてください。</p><div style="padding: 5px 0px 5px 25px;"><a href="'.$_CONF['site_admin_url'].'/plugins.php">プラグインエディター</a></div',
    'WhatsNewLabel'    => 'ファイル',
    'WhatsNewPeriod'   => '(%s日)'
);

// Admin Navbar
$LANG_FM02 = array(
    'nav1'  => '設定',
    'nav2'  => 'カテゴリ',
    'nav3'  => 'ファイルを追加',
    'nav4'  => 'ダウンロード (%s)',
    'nav5'  => '破損ファイル (%s)'
);

$LANG_FILEMGMT= array(
    'newpage' => '新規ページ',
    'adminhome' => '管理者HOME',
    'plugin_name' => 'ファイル管理',
    'searchlabel' => 'ダウンロード',
    'searchlabel_results' => 'ダウンロード結果',
    'downloads' => 'ダウンロード',
    'report' => 'ダウンロード回数の多いもの',
    'usermenu1' => 'ダウンロード',
    'usermenu2' => '&nbsp;&nbsp;上位',
    'usermenu3' => 'ファイルアップロード',
    'admin_menu' => 'ファイル管理',
    'writtenby' => '作者',
    'date' => '更新日',
    'title' => 'タイトル',
    'content' => '内容',
    'hits' => 'ダウンロード回数',
    'Filelisting' => 'ファイルリスト',
    'DownloadReport' => 'ファイル毎のダウンロード履歴',
    'StatsMsg1' => 'ダウンロード回数(上位10位)',
    'StatsMsg2' => 'このサイトにはファイル管理プラグイン用の定義ファイルがないか、定義ファイルにアクセスした人がいないようです。',
    'usealtheader' => 'Alt. Headerを使用してください。',
    'url' => 'URL',
    'edit' => '編集',
    'lastupdated' => '最新ファイル',
    'pageformat' => 'ページフォーマット',
    'leftrightblocks' => '左・右ブロック',
    'blankpage' => '空白ページ',
    'noblocks' => 'ブロックなし',
    'leftblocks' => '左ブロック',
    'addtomenu' => 'メニュー追加',
    'label' => 'ラベル',
    'nofiles' => 'ファイル数 (ダウンロード)',
    'save' => '保存',
    'preview' => 'プレビュー',
    'delete' => '削除',
    'cancel' => 'キャンセル',
    'access_denied' => 'アクセス拒否',
    'invalid_install' => 'ファイル管理プラグインのインストール/アンインストールページに不正にアクセスしようとした人がいます。ユーザーID: ',
    'start_install' => 'ファイル管理プラグインをインストールしようとしています。',
    'start_dbcreate' => 'ファイル管理プラグイン用にテーブルを作成しようとしています。',
    'install_skip' => '... skipped as per filemgmt.cfg',
    'access_denied_msg' => 'あなたはファイル管理プラグインのadminページに不正にアクセスしようとしていますね。このページへの不正なアクセスは記録しています。',
    'installation_complete' => 'インストールしました',
    'installation_complete_msg' => 'Geeklog用ファイル管理プラグインのデータ構造をGeeklogのデータベースにインストールしました! このプラグインをアンインストールしたい場合は、プラグインに付属のREADMEを読んでください。',
    'installation_failed' => 'インストールに失敗しました',
    'installation_failed_msg' => 'ファイル管理プラグインのインストールに失敗しました。診断情報を得るにはerror.logを参照してください。',
    'system_locked' => 'システムはロック中',
    'system_locked_msg' => 'ファイル管理プラグインは既にインストールしていて、ロックした状態です。このプラグインをアンインストールしたい場合は、プラグインに付属のREADMEを読んでください。',
    'uninstall_complete' => 'アンインストールを完了しました',
    'uninstall_complete_msg' => 'ファイル管理プラグインのデータ構造をGeeklogのデータベースから削除しました。。<br><br>ファイルの置き場(repository)にあるファイルはすべて手作業で削除する必要があるでしょう。',
    'uninstall_failed' => 'アンインストールに失敗しました。',
    'uninstall_failed_msg' => 'ファイル管理プラグインのアンインストールに失敗しました。診断情報を得るにはerror.logを参照してください。',
    'install_noop' => 'プラグインのインストール',
    'install_noop_msg' => 'ファイル管理プラグインのインストールを実行しましたが、何も行う必要がありませんでした。<br><br>プラグインの設定ファイルを確認してください。',
    'all_html_allowed' => 'すべてのHTMLを許可',
    'no_new_files'  => '-',
    'no_comments'   => '-',
    'more'          => '<em>続きを読む</em>',
    'stats_page_title' => 'タイトル',
    'stats_hits' => 'DL回数'
);

$PLG_filemgmt_MESSAGE1 = 'ファイル管理プラグインのインストールを中止しました。<br>ファイル: plugins/filemgmt/filemgmt.php に書き込みできません。';
$PLG_filemgmt_MESSAGE3 = 'このプラグインにはGeeklog Version 1.4 以降が必要です。アップグレードを中断しました。';
$PLG_filemgmt_MESSAGE4 = 'このプラグインの version 1.5 用のコードを検出できません。アップグレードを中止しました。';
$PLG_filemgmt_MESSAGE5 = 'ファイル管理プラグインのアップグレードを中止しました。<br>現在のプラグインのバージョンは 1.3 ではありません。';


// Language variables used by the plugin - general users access code.

define("_MD_THANKSFORINFO","情報提供ありがとうございました。そのうちリクエストを調べてみます。");
define("_MD_BACKTOTOP","ダウンロードトップへ戻る");
define("_MD_THANKSFORHELP","このディレクトリの健全さの維持にご協力いただき、ありがとうございます。");
define("_MD_FORSECURITY","セキュリティ上の理由により、あなたのユーザー名とIPアドレスも一時的に記録します。");

define("_MD_SEARCHFOR","検索対象");
define("_MD_MATCH","一致");
define("_MD_ALL","全部");
define("_MD_ANY","どれか1つでも");
define("_MD_NAME","名前");
define("_MD_DESCRIPTION","説明");
define("_MD_SEARCH","検索");

define("_MD_MAIN","メイン");
define("_MD_SUBMITFILE","ファイル提供");
define("_MD_POPULAR","回数");
define("_MD_NEW","New");
define("_MD_TOPRATED","上位");

define("_MD_NEWTHISWEEK","今週の新規ファイル");
define("_MD_UPTHISWEEK","今週更新しているファイル");

define("_MD_POPULARITYLTOM","ダウンロード回数 (少ないもの順)");
define("_MD_POPULARITYMTOL","ダウンロード回数 (多い順)");
define("_MD_TITLEATOZ","タイトル(A to Z)");
define("_MD_TITLEZTOA","タイトル(Z to A)");
define("_MD_DATEOLD","日付(逆順)");
define("_MD_DATENEW","日付(新着順)");
define("_MD_RATINGLTOH","評価(低い順)");
define("_MD_RATINGHTOL","評価(高い順)");

define("_MD_NOSHOTS","サムネイル画像なし");
define("_MD_EDITTHISDL","ダウンロードファイル編集");

define("_MD_LISTINGHEADING","<b>ファイルリスト:  %s 件あります。</b>");
define("_MD_LATESTLISTING","<b>最新リスト:</b>");
define("_MD_DESCRIPTIONC","説明:");
define("_MD_EMAILC","Email: ");
define("_MD_CATEGORYC","カテゴリ: ");
define("_MD_LASTUPDATEC","最新アップデート: ");
define("_MD_DLNOW","ダウンロードしてください!");
define("_MD_VERSION","バージョン");
define("_MD_SUBMITDATE","日付");
define("_MD_DLTIMES","ダウンロード %s 回");
define("_MD_FILESIZE","ファイルサイズ");
define("_MD_SUPPORTEDPLAT","サポートしているプラットフォーム");
define("_MD_HOMEPAGE","ホームページ");
define("_MD_HITSC","ダウンロード回数: ");
define("_MD_RATINGC","評価: ");
define("_MD_ONEVOTE","1 投票");
define("_MD_NUMVOTES","(%s)");
define("_MD_NOPOST","なし");
define("_MD_NUMPOSTS","投票数: %s");
define("_MD_COMMENTSC","コメント: ");
define("_MD_ENTERCOMMENT", "コメント作成");
define("_MD_RATETHISFILE","このファイルを評価");
define("_MD_MODIFY","編集");
define("_MD_REPORTBROKEN","破損ファイル");
define("_MD_TELLAFRIEND","友だちに教える");
define("_MD_VSCOMMENTS","コメントを見る/送る");
define("_MD_EDIT","編集");

define("_MD_THEREARE"," %s ファイルあります。");
define("_MD_LATESTLIST","最新リスト");

define("_MD_REQUESTMOD","ダウンロードファイル編集");
define("_MD_FILE","ファイル");
define("_MD_FILEID","ファイルID: ");
define("_MD_FILETITLE","タイトル: ");
define("_MD_DLURL","ダウンロードURL: ");
define("_MD_HOMEPAGEC","ホームページ: ");
define("_MD_VERSIONC","バージョン: ");
define("_MD_FILESIZEC","ファイルサイズ: ");
define("_MD_NUMBYTES","%s バイト");
define("_MD_PLATFORMC","プラットフォーム: ");
define("_MD_CONTACTEMAIL","連絡先E-mail: ");
define("_MD_SHOTIMAGE","サムネイル画像: ");
define("_MD_SENDREQUEST","送信要求");

define("_MD_VOTEAPPRE","投票に感謝します。");
define("_MD_THANKYOU","%s で投票していただき、ありがとうございました。"); // %s is your site name
define("_MD_VOTEFROMYOU","ユーザー、まさにあなた自身に入力していただくと、他の訪問者がダウンロードするファイルを決めるのに役立ちます。");
define("_MD_VOTEONCE","同じファイルには1回しか投票できません。");
define("_MD_RATINGSCALE","評価基準は 1 (低い)から 10 (高い)までです。");
define("_MD_BEOBJECTIVE","客観的にお願いします。全員が 1 か 10 の評価しか受けないなら、評価はあまり役に立ちません。");
define("_MD_DONOTVOTE","自分自身が提供したファイルには投票できません。");
define("_MD_RATEIT","評価してください。");

define("_MD_INTFILEAT","%s での注目ダウンロード"); // %s is your site name
define("_MD_INTFILEFOUND","%s で見つけた面白いファイルです。"); // %s is your site name

define("_MD_RECEIVED","ダウンロード情報をいただきました。ありがとうございます。");
define("_MD_WHENAPPROVED","承認が済むとメールが届きます。");
define("_MD_SUBMITONCE","一度だけ実行してください。");
define("_MD_APPROVED", "あなたのファイルを承認しました。");
define("_MD_ALLPENDING","投稿したすべてのファイルやスクリプトの情報は未承認の状態です。");
define("_MD_DONTABUSE","ユーザー名とIPアドレスを記録していますので、システムを不正使用しないでください。");
define("_MD_TAKEDAYS","ファイルやスクリプトをデータベースに登録するまで数日かかるかもしれません。");

define("_MD_RANK","ランク");
define("_MD_CATEGORY","カテゴリ");
define("_MD_HITS","ダウンロード回数");
define("_MD_RATING","評価");
define("_MD_VOTE","投票");

define("_MD_SEARCHRESULT4","検索結果 <b>%s</b>:");
define("_MD_MATCHESFOUND","%s 件一致しました。");
define("_MD_SORTBY","並べ替え方法:");
define("_MD_TITLE","タイトル");
define("_MD_DATE","日付");
define("_MD_POPULARITY","人気");
define("_MD_CURSORTBY","並べ替え順: ");
define("_MD_FOUNDIN","見つかりました:");
define("_MD_PREVIOUS","前へ");
define("_MD_NEXT","次へ");
define("_MD_NOMATCH","検索条件に一致するものはありません。");

define("_MD_TOP10","%s の上位10"); // %s is a downloads category name
define("_MD_CATEGORIES","カテゴリ");

define("_MD_SUBMIT","実行");
define("_MD_CANCEL","キャンセル");

define("_MD_BYTES","Bytes");
define("_MD_ALREADYREPORTED","破損ファイルに関するレポートを提出しました。");
define("_MD_MUSTREGFIRST","このアクションを実行するパーミッションがありません。<br>登録するかログインしてください。");
define("_MD_NORATING","評価を選択していません。");
define("_MD_CANTVOTEOWN","自分自身が提供したファイルには投票できません。<br>投票はすべて記録して検査しています。");

// Language variables used by the plugin - Admin code.

define("_MD_RATEFILETITLE","ファイル評価を記録してください。");
define("_MD_ADMINTITLE","ファイル管理 管理者メニュー");
define("_MD_UPLOADTITLE","ファイル管理 - ファイルのアップロード");
define("_MD_CATEGORYTITLE","リスト - カテゴリ");
define("_MD_DLCONF","ダウンロード設定");
define("_MD_GENERALSET","ファイル管理設定");
define("_MD_ADDMODFILENAME","ファイルのアップロード");
define("_MD_ADDCATEGORYSNAP", "画像: <small>(オプション、トップレベルカテゴリのみ)</small>");
define("_MD_ADDIMAGENOTE", "(画像の高さ制限 50)");
define("_MD_ADDMODCATEGORY","<b>カテゴリ:</b> カテゴリの追加/修正/削除");
define("_MD_DLSWAITING","ダウンロード許可待ち");
define("_MD_BROKENREPORTS","破損ファイルレポート");
define("_MD_MODREQUESTS","ダウンロード情報修正要求");
define("_MD_EMAILOPTION","承認時にメールを送信する: ");
define("_MD_COMMENTOPTION","コメント許可:");
define("_MD_SUBMITTER","提供者: ");
define("_MD_DOWNLOAD","ダウンロード");
define("_MD_FILELINK","全文表示");
define("_MD_SUBMITTEDBY","ファイル提供: ");
define("_MD_APPROVE","承認");
define("_MD_DELETE","削除");
define("_MD_NOSUBMITTED","新しく提供のあったダウンロードファイルはありません");
define("_MD_ADDMAIN","主カテゴリ追加");
define("_MD_TITLEC","タイトル: ");
define("_MD_CATSEC", "カテゴリへのアクセス: ");
define("_MD_IMGURL","<br>画像ファイル名 <font size='-2'> (filemgmt_data/category_snapsにあります - 画像の高さ制限 50)</font>");
define("_MD_ADD","追加");
define("_MD_ADDSUB","サブカテゴリ追加");
define("_MD_IN","in");
define("_MD_ADDNEWFILE","新規ファイルアップロード");
define("_MD_MODCAT","カテゴリ修正");
define("_MD_MODDL","ダウンロード情報変更");
define("_MD_USER","ユーザー");
define("_MD_IP","IPアドレス");
define("_MD_USERAVG","ユーザー評価の平均");
define("_MD_TOTALRATE","全評価");
define("_MD_NOREGVOTES","登録済みユーザーによる投票なし");
define("_MD_NOUNREGVOTES","未登録済みユーザーによる投票なし");
define("_MD_VOTEDELETED","投票のデータを削除しました。");
define("_MD_NOBROKEN","破損ファイルはありません。");
define("_MD_IGNOREDESC","無視(レポートを無視して、レポートのあったこの項目だけを削除する)");
define("_MD_DELETEDESC","削除(<b>レポートのあったダウンロードのデータ</b>を削除する)");
define("_MD_REPORTER","レポート提出者");
define("_MD_FILESUBMITTER","ファイル提供者");
define("_MD_IGNORE","無視");
define("_MD_FILEDELETED","ファイルを削除しました。");
define("_MD_FILENOTDELETED","レコードを削除しましたが、ファイルを削除していません。<p>複数のレコードが同じファイルを指しています。</p>");
define("_MD_BROKENDELETED","破損ファイルのレポートを削除しました。");
define("_MD_USERMODREQ","ユーザーによるダウンロード情報修正要求");
define("_MD_ORIGINAL","オリジナル");
define("_MD_PROPOSED","提案");
define("_MD_OWNER","所有者: ");
define("_MD_NOMODREQ","ダウンロード修正要求はありません。");
define("_MD_DBUPDATED","データベースを更新しました。");
define("_MD_MODREQDELETED","修正要求を削除しました。");
define("_MD_IMGURLMAIN","画像(画像の高さは50に変更): ");
define("_MD_PARENT","上位カテゴリ:");
define("_MD_SAVE","変更を保存");
define("_MD_CATDELETED","カテゴリを削除しました。");
define("_MD_WARNING","警告: このカテゴリとカテゴリ内の全ファイル/コメントを削除しますか?");
define("_MD_YES","Yes");
define("_MD_NO","No");
define("_MD_NEWCATADDED","カテゴリを新たに追加しました。");
define("_MD_CONFIGUPDATED","設定を保存しました。");
define("_MD_ERROREXIST","エラー: あなたが提供したダウンロード情報は既にデータベースに登録してあります。");
define("_MD_ERRORNOFILE","エラー: ファイルがデータベースの記録にありません。");  
define("_MD_ERRORTITLE","エラー: タイトルを入力してください。");
define("_MD_ERRORDESC","エラー: 説明を入力してください。");
define("_MD_NEWDLADDED","ダウンロードファイルを新たにデータベースに追加しました。");
define("_MD_NEWDLADDED_DUPFILE","警告: 重複したファイルです。新しいダウンロードファイルをデータベースに追加しました。");
define("_MD_NEWDLADDED_DUPSNAP","警告: 重複したスナップです。新しいダウンロードファイルをデータベースに追加しました。");
define("_MD_HELLO","こんにちは、%s さん");
define("_MD_WEAPPROVED","提供していただいたダウンロードファイルを承認しました。ファイル名: ");
define("_MD_THANKSSUBMIT","ご提供ありがとうございました。");
define("_MD_UPLOADAPPROVED","あなたがアップロードしたファイルを承認しました。");
define("_MD_DLSPERPAGE","1 ページあたりの表示件数: ");
define("_MD_HITSPOP","ダウンロード件数の多い順表示件数: ");
define("_MD_DLSNEW","新規ページの 1 ページあたりの表示件数: ");
define("_MD_DLSSEARCH","検索結果中のダウンロードファイル数: ");
define("_MD_TRIMDESC","ファイルリストで説明の一部を表示する: ");
define("_MD_DLREPORT","ダウンロード履歴のアクセスを制限する: ");
define("_MD_WHATSNEWDESC","新着情報リストを表示する: ");
define("_MD_SELECTPRIV","ユーザーのダウンロードを許可: ");
define("_MD_ACCESSPRIV","ゲストユーザーのダウンロードを許可: ");
define("_MD_UPLOADSELECT","ユーザーのアップロードを許可: ");
define("_MD_UPLOADPUBLIC","ゲストユーザーのアップロードを許可: ");
define("_MD_USESHOTS","カテゴリ画像を表示する: ");
define("_MD_IMGWIDTH","画像横幅: ");
define("_MD_MUSTBEVALID","サムネイル画像は %s ディレクトリ内の有効な画像ファイルでなければなりません(例 shot.gif)。画像ファイルがなければ空白にしておいてください。");
define("_MD_REGUSERVOTES","登録済みユーザーによる投票(投票総数: %s)");
define("_MD_ANONUSERVOTES","未登録ユーザーによる投票(投票総数: %s)");
define("_MD_YOURFILEAT","あなたが %s に提供したファイル"); // this is an approved mail subject. %s is your site name
define("_MD_VISITAT","%s のダウンロード部門をごらんください。");
define("_MD_DLRATINGS","ダウンロード評価(投票総数: %s)");
define("_MD_CONFUPDATED","設定を更新しました。");
define("_MD_NOFILES","ファイルがありません。");   

define("_MD_DIRFILES","リポジトリのパス - ファイル: ");
define("_MD_DIRTHUMBS","リポジトリのパス - ファイル画像: ");
define("_MD_DIRCATTHUMBS","リポジトリのパス - カテゴリ画像: ");
define("_MD_URLFILES","リポジトリのURL - ファイル: ");
define("_MD_URLTHUMBS","リポジトリのURL - ファイル画像: ");
define("_MD_URLCATTHUMBS","リポジトリのURL - カテゴリ画像: ");
define("_MD_MODOPT","オプション: ");
define("_MD_OPTUPDATE","登録日を更新する");

// Additional Geeklog Defines
define("_MD_NOVOTE","まだ評価がありません。");
define("_IFNOTRELOAD","ページを自動的にリロードしない場合は、<a href='%s'>ここ</a>をクリックしてください。");
define("_GL_ERRORNOACCESS","エラー: ドキュメント部門のファイル置き場にアクセスできません。");
define("_GL_ERRORNOUPLOAD","エラー: ファイルをアップロードする権限がありません。");
define("_GL_ERRORNOADMIN","エラー: この機能は制限されています。");
define("_GL_NOUSERACCESS","ドキュメント部門のファイル置き場にアクセスできません。");
define("_MD_ERRUPLOAD","ファイル管理: アップロードできませんでした。ファイルを保存するディレクトリのパーミッションを確認してください。");
define("_MD_DLFILENAME","ファイル名: ");
define("_MD_REPLFILENAME","取り替え用ファイル: ");
define("_MD_SCREENSHOT","画像を見る");
define("_MD_SCREENSHOT_NA","&nbsp;");
define("_MD_COMMENTSWANTED","コメントを歓迎します");
define("_MD_CLICK2SEE","クリックしてください: ");
define("_MD_CLICK2DL","クリックして、ダウンロードしてください: ");
define("_MD_ORDERBY","並べ替え: ");

define("_MD_DLTEMPFILE","投稿ファイルをダウンロードする: ");
define("_MD_TEMPFILE","ダウンロード");
define("_MD_SUBMITNOTIFY","ファイル提供のお知らせ");

// Localization of the Admin Configuration UI
$LANG_configsections['filemgmt'] = array(
    'label' => 'ファイル管理',
    'title' => 'ファイル管理の設定'
);

$LANG_confignames['filemgmt'] = array(
    'mydownloads_popular'         => '人気を判断する表示回数のしきい値',
    'mydownloads_newdownloads'    => '新着ファイルの表示件数',
    'mydownloads_perpage'         => '1ページあたりのファイル表示件数',

    'mydownloads_dlreport'        => 'ダウンロード履歴のアクセスを制限する',
    'mydownloads_trimdesc'        => 'ファイルリストで説明の一部を表示',
    'mydownloads_whatsnew'        => '新着情報リストを表示する',

    'mydownloads_selectpriv'      => 'ユーザーのダウンロードを許可',
    'mydownloads_uploadselect'    => 'ユーザーのアップロードを許可',
    'mydownloads_publicpriv'      => 'ゲストユーザーのダウンロードを許可',
    'mydownloads_uploadpublic'    => 'ゲストユーザーのアップロードを許可',

    'mydownloads_useshots'        => 'カテゴリ画像を表示する',
    'mydownloads_shotwidth'       => 'サムネイル画像の横幅',
    'filemgmt_Emailoption'        => '承認時にメールを送信する',

    'filemgmt_FileStore'       => 'ファイル',
    'filemgmt_SnapStore'       => 'ファイル画像',
    'filemgmt_SnapCat'         => 'カテゴリ画像',
    'filemgmt_FileStoreURL'    => 'ファイル',
    'filemgmt_FileSnapURL'     => 'ファイル画像',
    'filemgmt_SnapCatURL'      => 'カテゴリ画像',
);

$LANG_configsubgroups['filemgmt'] = array(
    'sg_main' => 'メイン'
);

$LANG_fs['filemgmt'] = array(
    'fs_main'            => 'ファイル管理のメイン設定',
    'fs_path'            => 'リポジトリのパス',
    'fs_url'             => 'リポジトリのURL'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['filemgmt'] = array(
    0 => array('はい' => 1, 'いいえ' => 0)
);

?>