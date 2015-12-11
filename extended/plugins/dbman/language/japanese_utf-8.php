<?php

// +---------------------------------------------------------------------------+
// | Geeklog Dbman Plugin for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/language/japanese_utf-8.php                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2014 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// +---------------------------------------------------------------------------+

$LANG_DBMAN = array(
	'access_denied'                 => 'アクセスできません',
	'access_denied_msg'             => 'このプラグインの管理権限がないのに管理画面にアクセスしようとしました。あなたのユーザー名とIPアドレスを記録しました。',
	'add_drop_table'                => '"DROP TABLE IF EXISTS"を追加する',
	'admin'                         => 'プラグイン管理',
	'backup_blob'                   => 'BLOBもバックアップする(phpMyAdminと互換性はありません!)',
	'backup_failure'                => 'バックアップできませんでした。詳しくはエラーログをご覧ください。',
	'backup_file'                   => 'バックアップしたファイル',
	'backup_now'                    => '今すぐバックアップ!',
	'backup_success'                => 'バックアップを完了しました。',
	'bytes'                         => 'バイト',
	'check_all'                     => 'すべてチェックする',
	'compress_data'                 => 'gzip(\'.gz\') で圧縮する',
	'couldnt_get_table_contents'    => "(テーブルの内容を取得できませんでした。",
	'couldnt_get_table_contents2'   => 'を削除してから、やり直してください。)',
	'couldnt_write_backup'          => "データをバックアップファイルに書き込めませんでした。",
	'db_explanation_backup'         => 'データベースのバックアップを取るには「バックアップ作成」をクリックしてください。',
	'db_explanation_list'           => 'バックアップ/リストアを選択してください。バックアップファイルのリンクをクリックすると、ダウンロードできます。',
	'db_explanation_restore'        => 'リストアするデータベースにチェックマークを入れから、「次へ」をクリックしてください。',
	'db_explanation_restore_option' => '%s からリストアする際のオプションを選択してください。<strong>テーブル構造</strong>をチェックすると、テーブルを作り直します(既存のデータを削除します)。<strong>データ</strong>をチェックすると、既存のデータを削除せずにデータをリストアします。重複するレコードがあると、既存のレコードを上書します。<br><strong>警告: リストアの機能は開発中で単純な荒削りです。Dbman プラグインはリストアするテーブルがどれかや、どのレコードを上書きするか気にしていません。Geeklogが使用しているテーブルにデータをリストアしたり、リストアするレコードのサイズが大きすぎる場合は、リストアに失敗してテーブルを破損するかもしれません。データベースのリストアにはphpMyAdmin等を使用する方が良いでしょう。</strong>',  /* %s = backup file */
	'download_as_file'              => 'ファイルとしてダウンロードする',
	'enabled'                       => 'アンインストールの前にプラグインを無効にしてください。',
	'install'                       => 'インストール',
	'installdoc'                    => 'インストール文書',
	'installed'                     => 'プラグインはインストール済みです。',
  'install_failed'                  => 'インストールに失敗しました。エラーログをご覧ください。',
	'install_header'                => 'プラグインのインストール/アンインストール',
	'install_success'               => 'インストールに成功しました。',
	'last_ten_backups'              => 'サーバーに保存しているバックアップ',
	'menu_backup'                   => 'バックアップ作成',
	'menu_list'                     => 'ファイル一覧',
	'menu_restore'                  => 'データベースのリストア',
	'next'                          => '次へ &gt;&gt;',
	'no_file_selected'              => 'バックアップファイルを選択していません。',
	'not_writable'                  => 'backupsディレクトリに書き込めません。',
	'operation'                     => '操作',
	'option'                        => 'バックアップのオプション',
	'other_options'                 => '&lt;他のオプション&gt;',
	'plugin'                        => 'Dbmanプラグイン',
	'readme'                        => 'ちょっと待ってください。「インストール」をクリックする前に、お読みください: ',
	'restore'                       => 'リストア',
	'restore_blob'                  => 'BLOBフィールドもリストア',
	'restore_failure'               => 'リストアできませんでした。詳しくはエラーログをご覧ください。',
	'restore_now'                   => '今すぐリストア!',
	'restore_success'               => 'リストアしました。',
	'restore_header1'               => 'テーブル名',
	'restore_header2'               => 'テーブル構造',
	'restore_header3'               => 'データ',
	'size'                          => 'サイズ',
	'uncheck_all'                   => 'すべてチェックを外す',
	'uninstall'                     => 'アンインストール',
	'uninstalled'                   => 'プラグインはインストールしていません。',
	'uninstall_msg'                 => 'アンインストールに成功しました。',
	'warning'                       => '警告! まだプラグインが有効です。',
	'dbman'                         => 'Dbman',

// Since ver 0.4.3
	'invalid_filename'              => 'ファイル名が不正です。',
	'file_not_exist'                => 'ファイルが存在しません。',
	'lbl_delete_file'               => 'チェックを入れたファイルを削除',
	'ttl_delete_file'               => 'バックアップファイルの削除',
	'menu_console'                  => 'SQLコンソール',
	'lbl_exec_sql'                  => 'SQLを実行',
	'desc_exec_sql'                 => '下のテキストボックスに入力したSQLを実行します。SELECT, INSERT, UPDATE, DELETE文しか実行できません。',
	'sql_executed'                  => '実行したSQL: ',
	'sql_result'                    => '結果: ',
	'sql_error_siud'                => 'エラー!  SQLコンソールではSELECT、INSERT、DELETE、UPDATEだけ実行できます。',
	'no_backup_file'                => 'バックアップファイルはありません。',
	'admin_home'                    => '管理画面',
	'menu_import'                   => 'インポート',
	'menu_export'                   => 'エクスポート',
	'desc_import'                   => 'Movable Type &reg;のエクスポートファイルからGeeklogに記事を取り込みます。',
	'desc_export'                   => 'Geeklogの記事をMovable Type &reg;のエクスポートファイルの形式で出力します。',
	'errmsg1'                       => 'CSRFチェックに引っかかりました。Webブラウザーの「戻る」ボタンを使用しないでください。',
);

// For Config UI
$LANG_configsections['dbman'] = array(
	'label' => 'Dbman',
	'title' => 'Dbmanの設定'
);

$LANG_confignames['dbman'] = array(
	'allow_restore'     => 'リストアを許可する',
	'add_drop_table'    => '"DROP TABLE IF EXISTS"を追加する',
	'chunk_size'        => 'バッファーのサイズ(デフォルト: 100)',
	'compress_data'     => 'データを圧縮する',
	'compression_level' => '圧縮レベル',
	'download_as_file'  => 'ファイルとしてダウンロードする',
	'backup_except'     => 'バックアップしないテーブル',
	'cron_backup'       => '定期的にバックアップする',
	'max_backup'        => 'バックアップファイル数の上限(0=上限なし)',
);

$LANG_configsubgroups['dbman'] = array(
	'sg_main' => 'Dbmanの設定'
);

$LANG_fs['dbman'] = array(
	'fs_main'   => '主要設定',
	'fs_backup' => 'バックアップ時の初期値',
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['dbman'] = array(
	0 => array('はい' => TRUE, 'いいえ' => FALSE),
	1 => array(
			'1(最低)' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6,
			'7' => 7, '8(デフォルト)' => 8, '9(最高)' => 9
		 ),
);
