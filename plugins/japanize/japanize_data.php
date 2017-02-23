<?php

// +---------------------------------------------------------------------------+
// | Japanize Plugin for Geeklog - The Ultimate Weblog                         |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/japanize/japanize_data.php                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tsuchi           - tsuchi AT geeklog DOT jp                      |
// |          mystral-kk       - geeklog AT mystral-kk DOT net                 |
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
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own.');
}

// Prepares locale data
$locale = array();

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $locale['ja'] = array(
        'locale'    => (version_compare(VERSION, '2.1.2', '>=') ? 'ja_JP' : 'C'),
        'date'      => '%Y年%m月%d日 %H:%M',
        'daytime'   => '%m月%d日 %H:%M',
        'shortdate' => '%d日',
        'dateonly'  => '%m月%d日',
        'timeonly'  => '%H:%M',
    );
} else {
    $locale['ja'] = array(
        'locale'    => ((strtoupper(substr(PHP_OS, 0, 7)) === 'FREEBSD')
                            ? 'ja_JP'
                            : 'ja_JP.UTF-8'
                       ),
        'date'      => '%Y年%B%e日(%a) %H:%M %Z',
        'daytime'   => '%m/%d %H:%M %Z',
        'shortdate' => '%Y年%B%e日',
        'dateonly'  => '%B%e日',
        'timeonly'  => '%H:%M %Z',
    );
}

$locale['en'] = array(
    'locale'    => 'en_GB',
    'date'      => '%A, %B %d %Y @ %I:%M %p %Z',
    'daytime'   => '%m/%d %I:%M%p',
    'shortdate' => '%x',
    'dateonly'  => '%d-%b',
    'timeonly'  => '%I:%M %p %Z',
);

$htmlfilter = array();
$htmlfilter['ja'] = array(
    'user' => array(
        'a'             => array('href' => 1, 'title' => 1, 'rel' => 1),
        'b'             => array(),
        'blockquote'    => array(),
        'br'            => array('clear' => 1),
        'code'          => array(),
        'div'           => array('class' => 1),
        'em'            => array(),
        'font'          => array('color' => 1),
        'h'             => array(),
        'hr'            => array(),
        'i'             => array(),
        'li'            => array(),
        'ol'            => array(),
        'p'             => array('lang' => 1),
        'pre'           => array(),
        'strong'        => array(),
        'tt'            => array(),
        'ul'            => array(),
    ),
    'admin' => array(
        'a'             => array(
                                'href' => 1, 'title' => 1, 'id' => 1, 'lang' => 1,
                                'name' => 1, 'type' => 1, 'rel' => 1,
                            ),
        'br'            => array('clear' => 1, 'style' => 1,),
        'caption'       => array('style' => 1,),
        'div'           => array('class' => 1, 'id' => 1, 'style' => 1,),
        'embed'         => array(
                                'src' => 1, 'loop' => 1, 'quality' => 1, 'width' => 1,
                                'height' => 1, 'type' => 1, 'pluginspage' => 1,
                                'align' => 1,
                            ),
        'h1'            => array('class' => 1, 'id' => 1, 'style' => 1,),
        'h2'            => array('class' => 1, 'id' => 1, 'style' => 1,),
        'h3'            => array('class' => 1, 'id' => 1, 'style' => 1,),
        'h4'            => array('class' => 1, 'id' => 1, 'style' => 1,),
        'h5'            => array('class' => 1, 'id' => 1, 'style' => 1,),
        'h6'            => array('class' => 1, 'id' => 1, 'style' => 1,),
        'hr'            => array('class' => 1, 'id' => 1, 'align' => 1,),
        'img'           => array(
                                'src' => 1, 'width' => 1, 'height' => 1, 'vspace' => 1,
                                'hspace' => 1, 'dir' => 1, 'align' => 1, 'valign' => 1,
                                'border' => 1, 'lang' => 1, 'longdesc' => 1,
                                'title' => 1, 'id' => 1, 'alt' => 1, 'style' => 1,
                            ),
        'noscript'      => array(),
        'object'        => array(
                                'type' => 1, 'data' => 1, 'classid' => 1, 
                                'codebase' => 1, 'width' => 1, 'height' => 1,
                                'align' => 1,
                            ),
        'ol'            => array('class' => 1, 'style' => 1,),
        'p'             => array('class' => 1, 'id' => 1, 'align' => 1, 'lang' => 1,),
        'param'         => array('name' => 1, 'value' => 1,),
        'script'        => array('src' => 1, 'language' => 1, 'type' => 1,),
        'span'          => array('class' => 1, 'id' => 1, 'lang' => 1,),
        'table'         => array(
                                'class' => 1, 'id' => 1, 'width' => 1, 'border' => 1,
                                'cellspacing' => 1, 'cellpadding' => 1,
                            ),
        'tbody'         => array(),
        'td'            => array(
                                'class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1,
                                'colspan' => 1, 'rowspan' => 1,
                            ),
        'th'            => array(
                                'class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1,
                                'colspan' => 1, 'rowspan' => 1,
                            ),
        'tr'            => array(
                                'class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1,
                            ),
        'ul'            => array('class' => 1, 'style' => 1,),
    ),
);

$htmlfilter['en'] = array(
    'user' => array(
        'p'      => array(),
        'b'      => array(),
        'strong' => array(),
        'i'      => array(),
        'a'      => array('href' => 1, 'title' => 1, 'rel' => 1),
        'em'     => array(),
        'br'     => array(),
        'tt'     => array(),
        'hr'     => array(), 
        'li'     => array(),
        'ol'     => array(),
        'ul'     => array(),
        'code'   => array(),
        'pre'    => array(),
    ),
    'admin' => array(
        'p'      => array('class' => 1, 'id' => 1, 'align' => 1),
        'div'    => array('class' => 1, 'id' => 1),
        'span'   => array('class' => 1, 'id' => 1),
        'table'  => array(
            'class' => 1, 'id' => 1, 'width' => 1, 'border' => 1, 'cellspacing' => 1,
            'cellpadding' => 1,
        ),
        'tr'     => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1),
        'th'     => array(
            'class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1,
            'rowspan' => 1,
        ),
        'td'     => array(
            'class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1,
            'rowspan' => 1,
        ),
    ),
);


$_JAPANIZE_DATA = array();

// 1. テーブル構造とデータを変更する
$_JAPANIZE_DATA[1] = array(
    array(
        'ja' => "ALTER TABLE {$_TABLES['syndication']} "
            . "MODIFY language VARCHAR(20) NOT NULL DEFAULT 'ja' ",
        'en' => "ALTER TABLE {$_TABLES['syndication']} "
            . "MODIFY language VARCHAR(20) NOT NULL DEFAULT 'en-gb' ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['syndication']} "
            . "SET language = 'ja' ",
        'en' => "UPDATE {$_TABLES['syndication']} "
            . "SET language = 'en-gb' ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['syndication']} "
            . "SET charset = 'utf-8' ",
        'en' => "UPDATE {$_TABLES['syndication']} "
            . "SET charset = '" . COM_getCharset() . "' ",
    ),
    array(
        'ja' => "ALTER TABLE {$_TABLES['users']} "
            . "MODIFY username VARCHAR(108) NOT NULL DEFAULT '' ",
        'en' => "ALTER TABLE {$_TABLES['users']} "
            . "MODIFY username VARCHAR(16) NOT NULL DEFAULT '' ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['users']} "
            . "SET username = '" . DB_escapeString('ゲストユーザー') . "', "
            . "    fullname = '" . DB_escapeString('ゲストユーザー') . "' "
            . "WHERE (uid = 1) ",
        'en' => "UPDATE {$_TABLES['users']} "
            . "SET username = 'Anonymous', fullname = 'Anonymous' "
            . "WHERE (uid = 1) ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['users']} "
            . "SET fullname= '" . DB_escapeString('サイト管理者') . "', homepage='"
            . DB_escapeString($_CONF['site_url']) . "' "
            . "WHERE (uid = 2) ",
        'en' => "UPDATE {$_TABLES['users']} "
            . "SET fullname= 'Geeklog SuperUser', homepage='https://www.geeklog.net/' "
            . "WHERE (uid = 2) ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['stories']} "
            . "SET title = '" . DB_escapeString('Geeklogへようこそ!') . "', "
            . "introtext = '" . DB_escapeString("<p>無事インストールが完了したようですね。おめでとうございます。できれば、<a href=\"docs/japanese/index.html\">docs ディレクトリ</a>のすべての文書に一通り目を通しておいてください。Geeklogはユーザーを中心としたセキュリティモデルを実装しています。Geeklogを管理・運用するにはこの仕組みを理解する必要があります。</p>\n<p>サイトにログインするには、次のアカウントを使用してください:</p>\n<p>ユーザー名: <strong>Admin</strong><br />\nパスワード: <strong>password</strong></p><p><strong>ログインしたら、忘れずに<a href=\"{$_CONF['site_url']}/usersettings.php?mode=edit\">パスワードを変更</a>してください。</strong></p><p>Geeklogのサポートは、<a href=\"https://www.geeklog.jp\">Geeklog Japanese</a>へ。追加ドキュメントは <a href=\"https://wiki.geeklog.jp\">Geeklog Wiki ドキュメント</a>をどうぞ。</p>") . "' "
                    . "WHERE (sid = 'welcome') ",
        'en' => "UPDATE {$_TABLES['stories']} "
            . "SET title = 'Welcome to Geeklog!', "
            . "introtext = '" . DB_escapeString("<p>Welcome and let me be the first to congratulate you on installing Geeklog. Please take the time to read everything in the <a href=\"docs/english/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.</p>\n<p>To log into your new Geeklog site, please use this account:</p>\n<p>Username: <b>Admin</b><br />\nPassword: <b>password</b></p><p><b>And don't forget to <a href=\"{$_CONF['site_url']}/usersettings.php?mode=edit\">change your password</a> after logging in!</b></p>") . "' "
            . "WHERE (sid = 'welcome') ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['storysubmission']} "
            . "SET title = '" . DB_escapeString('セキュリティを確認してください。') . "', "
            . "introtext = '" . DB_escapeString("<p>インストールが終了したら、次のことを実行してセキュリティを高めてください。</p><ol>\n<li>Adminアカウントのパスワードを変更する。</li>\n<li>installディレクトリを削除する（もう必要ありません）。</li>\n</ol>") . "' "
            . "WHERE (sid = 'security-reminder') ",
        'en' => "UPDATE {$_TABLES['storysubmission']} "
            . "SET title = 'Are you secure?', "
            . "introtext = '" . DB_escapeString("<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\n\n<ol>\n<li>Change the default password for the Admin account.</li>\n<li>Remove the install directory (you won't need it any more).</li>\n</ol>") . "' "
            . "WHERE (sid = 'security-reminder') ",
    ),
    array(
        'ja' => "UPDATE {$_TABLES['topics']} "
            . "SET topic = '" . DB_escapeString('おしらせ') . "' "
            . "WHERE (tid = 'General') ",
        'en' => "UPDATE {$_TABLES['topics']} "
            . "SET topic = '" . DB_escapeString('General News') . "' "
            . "WHERE (tid = 'General') ",
    ),
);

if (DB_checkTableExists('events')) {
    // イベントの郵便番号を16桁に
    $_JAPANIZE_DATA[1][] = array(
        'ja' => "ALTER TABLE {$_TABLES['events']} MODIFY zipcode VARCHAR(16)",
        'en' => "SELECT 1", // Dummy
    );
    $_JAPANIZE_DATA[1][] = array(
        'ja' => "ALTER TABLE {$_TABLES['eventsubmission']} MODIFY zipcode VARCHAR(16)",
        'en' => "SELECT 1", // Dummy
    );
    $_JAPANIZE_DATA[1][] = array(
        'ja' => "ALTER TABLE {$_TABLES['personal_events']} MODIFY zipcode VARCHAR(16)",
        'en' => "SELECT 1", // Dummy
    );
}

if (DB_checkTableExists('linkcategories')) {
    $_JAPANIZE_DATA[1][] = array(
        'ja' => "UPDATE {$_TABLES['linkcategories']} "
            . "SET description = '" . DB_escapeString('Geeklog関係のサイト') . "' "
            . "WHERE (cid = '" . DB_escapeString('geeklog-sites') . "') ",
        'en' => "UPDATE {$_TABLES['linkcategories']} "
            . "SET description = '"
            . DB_escapeString('Sites using or related to the Geeklog CMS') . "' "
            . "WHERE (cid = '" . DB_escapeString('geeklog-sites') . "') ",
    );
}

if (DB_checkTableExists('links')) {
    if (DB_count($_TABLES['links'], 'lid', 'geeklog.jp') == 0) {
        $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Links Admin'");
        $_JAPANIZE_DATA[1][] = array(
            'ja' => "INSERT INTO {$_TABLES['links']} "
                . "(lid, cid, url, description, title, hits, date, "
                . "owner_id, group_id, perm_owner, perm_group, "
                . "perm_members, perm_anon) "
                . "VALUES ('geeklog.jp', 'geeklog-sites', 'https://www.geeklog.jp/', "
                . "'" . DB_escapeString('Geeklog日本公式サイト') . "', '"
                . DB_escapeString('Geeklog Japanese') . "', 0, NOW(), 1, {$group_id}, "
                . "3, 3, 2, 2) ",
            'en' => "DELETE FROM {$_TABLES['links']} "
                . "WHERE (lid = 'geeklog.jp')",
        );
    } else {
        $_JAPANIZE_DATA[1][] = array(
            'ja' => "SELECT 1", // Dummy
            'en' => "DELETE FROM {$_TABLES['links']} "
                . "WHERE (lid = 'geeklog.jp')",
        );
    }
}

// 2. グループ詳細を変更する
//
// UPDATE {$_TABLES['groups']}
//   SET grp_descr = '{en/ja}'
//   WHERE (grp_name = '{group}')
$_JAPANIZE_DATA[2] = array(
    array(
        'en'    => 'Has full access to the site',
        'ja'    => 'サイト管理者',
        'group' => 'Root',
    ),
    array(
        'en'    => 'Group that a typical user is added to',
        'ja'    => 'すべてのユーザー',
        'group' => 'All Users',
    ),
    array(
        'en'    => 'Has full access to story features',
        'ja'    => '記事管理者',
        'group' => 'Story Admin',
    ),
    array(
        'en'    => 'Has full access to block features',
        'ja'    => 'ブロック管理者',
        'group' => 'Block Admin',
    ),
    array(
        'en'    => 'Has full access to topic features',
        'ja'    => '話題管理者',
        'group' => 'Topic Admin',
    ),
    array(
        'en'    => 'Has full access to topic features',
        'ja'    => 'ユーザー管理者',
        'group' => 'User Admin',
    ),
    array(
        'en'    => 'Has full access to plugin features',
        'ja'    => 'プラグイン管理者',
        'group' => 'Plugin Admin',
    ),
    array(
        'en'    => 'Has full access to plugin features',
        'ja'    => 'グループ管理者兼ユーザー管理者',
        'group' => 'Group Admin',
    ),
    array(
        'en'    => 'Can use Mail Utility',
        'ja'    => 'メール管理者',
        'group' => 'Mail Admin',
    ),
    array(
        'en'    => 'All registered members',
        'ja'    => 'すべての登録ユーザー',
        'group' => 'Logged-in Users',
    ),
    array(
        'en'    => 'Users in this group can have authenticated against a remote server.',
        'ja'    => 'リモートユーザー',
        'group' => 'Remote Users',
    ),
    array(
        'en'    => 'Can create and modify web feeds for the site',
        'ja'    => 'フィード管理者',
        'group' => 'Syndication Admin',
    ),
    array(
        'en'    => 'Has full access to configuration',
        'ja'    => 'コンフィギュレーション管理者',
        'group' => 'Configuration Admin',
    ),
    array(
        'en'    => 'Has full access to calendar features',
        'ja'    => 'カレンダー管理者',
        'group' => 'Calendar Admin',
    ),
    array(
        'en'    => 'Has full access to links features',
        'ja'    => 'リンク管理者',
        'group' => 'Links Admin',
    ),
    array(
        'en'    => 'Has full access to polls features',
        'ja'    => 'アンケート管理者',
        'group' => 'Polls Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the Spam-x plugin',
        'ja'    => 'スパム管理者',
        'group' => 'spamx Admin',
    ),
    array(
        'en'    => 'Can administer static pages',
        'ja'    => '静的ページ管理者',
        'group' => 'Static Page Admin',
    ),
    array(
        'en'    => 'Has full access to japanize features',
        'ja'    => '日本語化管理者',
        'group' => 'japanize Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the filemgmt plugin',
        'ja'    => 'ファイル管理者',
        'group' => 'filemgmt Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the forum plugin',
        'ja'    => '掲示板管理者',
        'group' => 'forum Admin',
    ),
    array(
        'en'    => 'Can use the Webservices API (if restricted)',
        'ja'    => 'WebサービスAPIユーザー',
        'group' => 'Webservices Users',
    ),
    array(
        'en'    => 'Can moderate comments',
        'ja'    => 'コメント管理者',
        'group' => 'Comment Admin',
    ),
    array(
        'en'    => 'Can submit comments',
        'ja'    => 'コメント承認者',
        'group' => 'Comment Submitters',
    ),
    array(
        'en'    => 'Has full access to File Manager',
        'ja'    => 'ファイルマネージャー管理者',
        'group' => 'Filemanager Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the Autotags plugin',
        'ja'    => 'Autotagsプラグイン管理者',
        'group' => 'Autotags Admin',
    ),
    array(
        'en'    => 'Has full access to custommenu features',
        'ja'    => 'カスタムメニュー管理者',
        'group' => 'CustomMenu Admin',
    ),
    array(
        'en'    => 'Has full access to DataProxy features',
        'ja'    => 'DataProxyプラグイン管理者',
        'group' => 'DataProxy Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the sitemap plugin',
        'ja'    => 'Sitemapプラグイン管理者',
        'group' => 'Sitemap Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the dbman plugin',
        'ja'    => 'Dbmanプラグイン管理者',
        'group' => 'dbman Admin',
    ),
    array(
        'en'    => 'Has full access to Mycaljp features',
        'ja'    => 'Mycaljpプラグイン管理者',
        'group' => 'Mycaljp Admin',
    ),
//  array(
//      'en'    => 'nmoxqrblock Admin',
//      'ja'    => 'nmoxqrblockプラグイン管理者',
//      'group' => 'nmoxqrblock Admin',
//  ),
    array(
        'en'    => 'Users in this group can administer the nmoxtopicown plugin',
        'ja'    => '話題譲渡プラグイン管理者',
        'group' => 'nmoxtopicown Admin',
    ),
    array(
        'en'    => 'Users in this group can administer the themedit plugin',
        'ja'    => 'テーマエディタプラグイン管理者',
        'group' => 'themedit Admin',
    ),
//  array(
//      'en'    => 'Has full access to GoogleMaps features',
//      'ja'    => 'GoogleMapsプラグイン管理者',
//      'group' => 'GoogleMaps Admin',
//  ),
);

// 3. 初期ブロックタイトル等を変更する
//
// UPDATE {$_TABLES['blocks']}
//   SET title = '{en/ja}'
//   WHERE (name = '{name}')
$_JAPANIZE_DATA[3] = array(
    array(
        'en'   => 'User Functions',
        'ja'   => 'ユーザー情報',
        'name' => 'user_block',
    ),
    array(
        'en'   => 'Admins Only',
        'ja'   => '管理者専用メニュー',
        'name' => 'admin_block',
    ),
    array(
        'en'   => 'Topics',
        'ja'   => '記事カテゴリ',
        'name' => 'section_block',
    ),
    array(
        'en'   => 'Poll',
        'ja'   => 'アンケート',
        'name' => 'polls_block',
    ),
    array(
        'en'   => 'Events',
        'ja'   => 'イベント',
        'name' => 'events_block',
    ),
    array(
        'en'   => 'What\'s New',
        'ja'   => '新着情報',
        'name' => 'whats_new_block',
    ),
    array(
        'en'   => 'Who\'s Online',
        'ja'   => 'オンラインユーザー',
        'name' => 'whosonline_block',
    ),
    array(
        'en'   => 'Older Stories',
        'ja'   => '過去の記事',
        'name' => 'older_stories',
    ),
    array(
        'type' => 'sql',
        'en'   => "UPDATE {$_TABLES['blocks']} "
                    . "SET title = 'About Geeklog', content = '" . DB_escapeString('<p><strong>Welcome to Geeklog!</strong></p><p>If you\'re already familiar with Geeklog - and especially if you\'re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href="docs/changes.html">release notes</a>. If you need help, please see the <a href="docs/support.html">support options</a>.</p>') . "' "
                    . "WHERE (name = 'first_block') ",
        'ja'   => "UPDATE {$_TABLES['blocks']} "
                    . "SET title = 'Geeklogについて', content = '" . DB_escapeString('<p><strong>ようこそ、Geeklogへ!</strong><p>Geeklogについてのサポートは、 <a href="https://www.geeklog.jp">Geeklog Japanese</a>へ。ドキュメントは <a href="https://wiki.geeklog.jp">Geeklog Wiki ドキュメント</a>をどうぞ。') . "' "
                    . "WHERE (name = 'first_block') ",
    ),
);

// 4. コンフィギュレーションを変更する
$_JAPANIZE_DATA[4] = array(
    'set' => array(
        'Core' => array(
            // サイト･･･無効のメッセージまたはURL
            'site_disabled_msg' => array(
                'ja' => $_CONF['site_url'] . '/japanize/disabledmsg.html', 'Core',
                'en' => 'Geeklog Site is down. Please come back soon.',
            ),
            
            // シンジケーション･･･フィードの言語
            'rdf_language' => array(
                'ja' => 'ja',
                'en' => 'en-gb',
            ),
            
            // 管理者ブロック･･･リンクをソートする=false
            'sort_admin' => array(
                'ja' => false,
                'en' => true,
            ),
            
            // 話題ブロック･･･記事投稿数を表示する=いいえ
            'showsubmissioncount' => array(
                'ja' => false,
                'en' => true,
            ),
            
            // 話題ブロック･･･Homeへのリンクを表示しない=はい
            'hide_home_link' => array(
                'ja' => true,
                'en' => false,
            ),
            
            // コメント･･･コメント形状=flat
            'comment_mode' => array(
                'ja' => 'flat',
                'en' => 'nested',
            ),
            
            // 画像ライブラリ･･･画像ライブラリ=GD
            'image_lib' => array(
                'ja' => (is_callable('gd_info') ? 'gdlib' : 'none'),
                'en' => 'none',
            ),
            
            // 画像ライブラリ･･･記事の画像高さの最大値=120ピクセル
            'max_image_height' => array(
                'ja' => 120,
                'en' => 160,
            ),
            
            // ロケール･･･ロケール
            'locale' => array(
                'ja' => $locale['ja']['locale'],
                'en' => $locale['en']['locale'],
            ),
            
            // ロケール･･･日付
            'date' => array(
                'ja' => $locale['ja']['date'],
                'en' => $locale['en']['date'],
            ),
            
            // ロケール･･･日時
            'daytime' => array(
                'ja' => $locale['ja']['daytime'],
                'en' => $locale['en']['daytime'],
            ),
            
            // ロケール･･･日付短表記
            'shortdate' => array(
                'ja' => $locale['ja']['shortdate'],
                'en' => $locale['en']['shortdate'],
            ),
            
            // ロケール･･･日付けのみ
            'dateonly' => array(
                'ja' => $locale['ja']['dateonly'],
                'en' => $locale['en']['dateonly'],
            ),
            
            // ロケール･･･時間のみ
            'timeonly' => array(
                'ja' => $locale['ja']['timeonly'],
                'en' => $locale['en']['timeonly'],
            ),
            
            // hour_mode･･･時間制
            'hour_mode' => array(
                'ja' => 24,
                'en' => 12,
            ),
            
            // decimal_count･･･小数点以下の桁数
            'decimal_count' => array(
                'ja' => 0,
                'en' => 2,
            ),
            
            // timezone タイムゾーン
            'timezone' => array(
                'ja' => 'Asia/Tokyo',
                'en' => 'UTC',
            ),
            
            // アドバンストエディタ
            'advanced_editor' => array(
                'ja' => true,
                'en' => false,
            ),
            
            // HTMLフィルタ･･･ユーザーHTML
            'user_html' => array(
                'ja' => $htmlfilter['ja']['user'],
                'en' => $htmlfilter['en']['user'],
            ),
            
            // HTMLフィルタ･･･管理者HTML
            'admin_html' => array(
                'ja' => $htmlfilter['ja']['admin'],
                'en' => $htmlfilter['en']['admin'],
            ),
            
            // HTMLフィルタ･･･RootユーザーはHTMLフィルタを無効にする
            'skip_html_filter_for_root' => array(
                'ja' => 1,
                'en' => 0,
            ),
            
            // バッドワードチェック･･･チェックモード いいえ
            'censormode' => array(
                'ja' => 0,
                'en' => 1,
            ),
            
            // コメントフィード･･･記事のタグ
            'comment_feeds_article_tag' => array(
                'ja' => "<p>[元の記事: <a href=\"%s\">%s</a>%s%s]\n",
                'en' => "<p>[Original Article: <a href=\"%s\">%s</a>%s%s]\n",
            ),
            
            // コメントフィード･･･コメントの投稿者のタグ
            'comment_feeds_comment_author_tag' => array(
                'ja' => ", Comment By: <a href=\"%s\">%s</a>",
                'en' => ", コメント投稿者: <a href=\"%s\">%s</a>",
            ),
        ),
        
        'calendar' => array(
            'event_types' => array(
                'ja' => array(
                            '記念日', '約束', '誕生日', '打ち合わせ',
                            'セミナー', '休日', '会議', '用事', '個人の用事',
                            '電話', '特別な行事', '旅行', '休暇',
                ),
                'en' => array(
                            'Anniversary', 'Appointment', 'Birthday',
                            'Business', 'Education', 'Holiday', 'Meeting',
                            'Miscellaneous', 'Personal', 'Phone Call',
                            'Special Occasion', 'Travel', 'Vacation',
                ),
            ),
        ),
    ),
    
    'set_default' => array(
        'Core' => array(
            'rdf_language' => array(
                'ja' => 'ja',
                'en' => 'en-gb',
            ),
        ),
    ),
);
    
// 5. 更新Pingサーバーを変更する
$_JAPANIZE_DATA[5] = array(
    array(
        'site_url' => 'http://www.blogpeople.net/',
        'sql'      => "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
                    . "site_url, ping_url, method, is_enabled) VALUES "
                    . "(0, 'BlogPeople', 'http://www.blogpeople.net/', "
                    . "'http://www.blogpeople.net/servlet/weblogUpdates', "
                    . "'weblogUpdates.ping', 1) ",
    ),
    
    array(
        'site_url' => 'http://ping.bloggers.jp/',
        'sql'      => "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
                    . "site_url, ping_url, method, is_enabled) VALUES "
                    . "(0, 'ping.bloggers.jp', 'http://ping.bloggers.jp/', "
                    . "'http://ping.bloggers.jp/rpc/', "
                    . "'weblogUpdates.ping', 1) ",
    ),
    
    array(
        'site_url' => 'http://blog.goo.ne.jp/',
        'sql'      => "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
                    . "site_url, ping_url, method, is_enabled) VALUES "
                    . "(0, 'gooブログ', 'http://blog.goo.ne.jp/', "
                    . "'http://blog.goo.ne.jp/XMLRPC', "
                    . "'weblogUpdates.ping', 1) ",
    ),
    
    array(
        'site_url' => 'http://blogsearch.google.co.jp/',
        'sql'      => "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
                    . "site_url, ping_url, method, is_enabled) VALUES "
                    . "(0, 'Googleブログ検索', 'http://blogsearch.google.co.jp/', "
                    . "'http://blogsearch.google.co.jp/ping/RPC2', "
                    . "'weblogUpdates.extendedPing', 1) ",
    ),
);

// 6. 権限のツールチップを変更する
$_JAPANIZE_DATA[6] = array(
// 権限名の降順
    'block.delete' => array(
        'ja' => 'ブロックを削除する権限',
        'en' => 'Ability to delete a block',
    ),
    'block.edit' => array(
        'ja' => 'ブロックを編集する権限',
        'en' => 'Access to block editor',
    ),
    'calendar.edit' => array(
        'ja' => 'イベントを編集する権限',
        'en' => 'Access to event editor',
    ),
    'calendar.moderate' => array(
        'ja' => '承認待ちのイベントを承認・却下する権限',
        'en' => 'Ability to moderate pending events',
    ),
    'calendar.submit' => array(
        'ja' => '承認待ちなしでイベントを掲載する権限',
        'en' => 'May skip the event submission queue',
    ),
    'comment.moderate' => array(
        'ja' => '承認待ちのコメントを承認・却下する権限',
        'en' => 'Ability to moderate comments',
    ),
    'comment.submit' => array(
        'ja' => '承認待ちなしでコメントを投稿する権限',
        'en' => 'Comments are automatically published',
    ),
    'filemanager.admin' => array(
        'ja' => 'ファイルマネージャーを使用する権限',
        'en' => 'Ability to use File Manager',
    ),
    'group.assign' => array(
        'ja' => 'ユーザーをグループに加入させる権限',
        'en' => 'Ability to assign users to groups',
    ),
    'group.delete' => array(
        'ja' => 'グループを削除する権限',
        'en' => 'Ability to delete groups',
    ),
    'group.edit' => array(
        'ja' => 'グループを編集する権限',
        'en' => 'Ability to edit groups',
    ),
    'htmlfilter.skip' => array(
        'ja' => 'HTMLフィルターをバイパスする権限',
        'en' => 'Skip filtering posts for HTML',
    ),
    'japanize.edit' => array(
        'ja' => 'Japanizeプラグインを管理する権限',
        'en' => 'Access to Japanize editor',
    ),
    'links.edit' => array(
        'ja' => 'リンクを編集する権限',
        'en' => 'Access to links editor',
    ),
    'links.moderate' => array(
        'ja' => '承認待ちのリンクを承認・却下する権限',
        'en' => 'Ability to moderate pending links',
    ),
    'links.submit' => array(
        'ja' => '承認待ちなしでリンクを掲載する権限',
        'en' => 'May skip the links submission queue',
    ),
    'ogp.edit' => array(
        'ja' => 'OGP (Open Graph Protocol)プラグインを管理する権限',
        'en' => 'Access to Open Graph Protocol editor',
    ),
    'plugin.edit' => array(
        'ja' => 'プラグインを編集する権限',
        'en' => 'Access to plugin editor',
    ),
    'polls.edit' => array(
        'ja' => 'アンケートを編集する権限',
        'en' => 'Access to polls editor',
    ),
    'plugin.install' => array(
        'ja' => 'プラグインをインストール・アンインストールする権限',
        'en' => 'Can install/uninstall plugins',
    ),
    'plugin.upload' => array(
        'ja' => 'プラグインを新規にアップロードする権限',
        'en' => 'Can upload new plugins',
    ),
    'spamx.admin' => array(
        'ja' => 'Spam-xプラグインを管理する権限',
        'en' => 'Full access to Spam-x plugin',
    ),
    'spamx.skip' => array(
        'ja' => 'スパムチェックをバイパスする権限',
        'en' => 'Skip checking posts for Spam',
    ),
    'staticpages.delete' => array(
        'ja' => '静的ページを削除する権限',
        'en' => 'Ability to delete a static page',
    ),
    'staticpages.edit' => array(
        'ja' => '静的ページを編集する権限',
        'en' => 'Ability to edit a static page',
    ),
    'staticpages.PHP' => array(
        'ja' => '静的ページでPHPを使用する権限',
        'en' => 'Ability use PHP in static pages',
    ),
    'story.edit' => array(
        'ja' => '記事を編集する権限',
        'en' => 'Access to story editor',
    ),
    'story.moderate' => array(
        'ja' => '承認待ちの記事を承認・却下する権限',
        'en' => 'Ability to moderate pending stories',
    ),
    'story.ping' => array(
        'ja' => '記事の更新ピング、ピングバック、トラックバックを送信する権限',
        'en' => 'Ability to send pings, pingbacks, or trackbacks for stories',
    ),
    'story.submit' => array(
        'ja' => '承認待ちなしで記事を掲載する権限',
        'en' => 'May skip the story submission queue',
    ),
    'syndication.edit' => array(
        'ja' => 'フィードを管理する権限',
        'en' => 'Access to Content Syndication',
    ),
    'topic.edit' => array(
        'ja' => '話題を編集する権限',
        'en' => 'Access to topic editor',
    ),
    'user.delete' => array(
        'ja' => 'ユーザーを削除する権限',
        'en' => 'Ability to delete a user',
    ),
    'user.edit' => array(
        'ja' => 'ユーザーを編集する権限',
        'en' => 'Access to user editor',
    ),
    'user.mail' => array(
        'ja' => 'メンバーにメールを送信する権限',
        'en' => 'Ability to send email to members',
    ),
    'webservices.atompub' => array(
        'ja' => 'Atompubウェブサービスを使用する権限',
        'en' => 'May use Atompub Webservices (if restricted)',
    ),

// コンフィギュレーションのタブ
    'config.Core.tab_site' => array(
        'ja' => 'コンフィギュレーションの「サイト」タブにアクセスする権限',
        'en' => 'Access to configure site',
    ),
    'config.Core.tab_mail' => array(
        'ja' => 'コンフィギュレーションの「メール」タブにアクセスする権限',
        'en' => 'Access to configure mail',
    ),
    'config.Core.tab_syndication' => array(
        'ja' => 'コンフィギュレーションの「フィード」タブにアクセスする権限',
        'en' => 'Access to configure syndication',
    ),
    'config.Core.tab_paths' => array(
        'ja' => 'コンフィギュレーションの「パス」タブにアクセスする権限',
        'en' => 'Access to configure paths',
    ),
    'config.Core.tab_pear' => array(
        'ja' => 'コンフィギュレーションの「PEAR」タブにアクセスする権限',
        'en' => 'Access to configure PEAR',
    ),
    'config.Core.tab_mysql' => array(
        'ja' => 'コンフィギュレーションの「MySQL」タブにアクセスする権限',
        'en' => 'Access to configure MySQL',
    ),
    'config.Core.tab_search' => array(
        'ja' => 'コンフィギュレーションの「検索」タブにアクセスする権限',
        'en' => 'Access to configure search',
    ),
    'config.Core.tab_story' => array(
        'ja' => 'コンフィギュレーションの「記事」タブにアクセスする権限',
        'en' => 'Access to configure story',
    ),
    'config.Core.tab_trackback' => array(
        'ja' => 'コンフィギュレーションの「トラックバック」タブにアクセスする権限',
        'en' => 'Access to configure trackback',
    ),
    'config.Core.tab_pingback' => array(
        'ja' => 'コンフィギュレーションの「ピングバック」タブにアクセスする権限',
        'en' => 'Access to configure pingback',
    ),
    'config.Core.tab_theme' => array(
        'ja' => 'コンフィギュレーションの「テーマ」タブにアクセスする権限',
        'en' => 'Access to configure theme',
    ),
    'config.Core.tab_theme_advanced' => array(
        'ja' => 'コンフィギュレーションの「テーマの拡張設定」タブにアクセスする権限',
        'en' => 'Access to configure advanced settings',
    ),
    'config.Core.tab_admin_block' => array(
        'ja' => 'コンフィギュレーションの「管理者ブロック」タブにアクセスする権限',
        'en' => 'Access to configure admin block',
    ),
    'config.Core.tab_topics_block' => array(
        'ja' => 'コンフィギュレーションの「話題ブロック」タブにアクセスする権限',
        'en' => 'Access to configure topics block',
    ),
    'config.Core.tab_whosonline_block' => array(
        'ja' => 'コンフィギュレーションの「オンラインユーザーブロック」タブにアクセスする権限',
        'en' => 'Access to configure who\'s online block',
    ),
    'config.Core.tab_whatsnew_block' => array(
        'ja' => 'コンフィギュレーションの「新着ブロック」タブにアクセスする権限',
        'en' => 'Access to configure what\'s new block',
    ),
    'config.Core.tab_users' => array(
        'ja' => 'コンフィギュレーションの「ユーザー」タブにアクセスする権限',
        'en' => 'Access to configure users',
    ),
    'config.Core.tab_spamx' => array(
        'ja' => 'コンフィギュレーションの「Spam-x」タブにアクセスする権限',
        'en' => 'Access to configure Spam-x',
    ),
    'config.Core.tab_login' => array(
        'ja' => 'コンフィギュレーションの「ログイン」タブにアクセスする権限',
        'en' => 'Access to configure login settings',
    ),
    'config.Core.tab_user_submission' => array(
        'ja' => 'コンフィギュレーションの「ユーザー登録」タブにアクセスする権限',
        'en' => 'Access to configure user submission',
    ),
    'config.Core.tab_submission' => array(
        'ja' => 'コンフィギュレーションの「投稿」タブにアクセスする権限',
        'en' => 'Access to configure submission',
    ),
    'config.Core.tab_comments' => array(
        'ja' => 'コンフィギュレーションの「コメント」タブにアクセスする権限',
        'en' => 'Access to configure comments',
    ),
    'config.Core.tab_imagelib' => array(
        'ja' => 'コンフィギュレーションの「画像処理ライブラリ」タブにアクセスする権限',
        'en' => 'Access to configure image library',
    ),
    'config.Core.tab_upload' => array(
        'ja' => 'コンフィギュレーションの「アップロード」タブにアクセスする権限',
        'en' => 'Access to configure upload',
    ),
    'config.Core.tab_articleimg' => array(
        'ja' => 'コンフィギュレーションの「記事の画像」タブにアクセスする権限',
        'en' => 'Access to configure images in article',
    ),
    'config.Core.tab_topicicon' => array(
        'ja' => 'コンフィギュレーションの「話題アイコン」タブにアクセスする権限',
        'en' => 'Access to configure topic icons',
    ),
    'config.Core.tab_userphoto' => array(
        'ja' => 'コンフィギュレーションの「ユーザーの写真」タブにアクセスする権限',
        'en' => 'Access to configure photos',
    ),
    'config.Core.tab_gravatar' => array(
        'ja' => 'コンフィギュレーションの「Gravatar」タブにアクセスする権限',
        'en' => 'Access to configure gravatar',
    ),
    'config.Core.tab_language' => array(
        'ja' => 'コンフィギュレーションの「言語」タブにアクセスする権限',
        'en' => 'Access to configure language',
    ),
    'config.Core.tab_locale' => array(
        'ja' => 'コンフィギュレーションの「ロケール」タブにアクセスする権限',
        'en' => 'Access to configure locale',
    ),
    'config.Core.tab_cookies' => array(
        'ja' => 'コンフィギュレーションの「クッキー」タブにアクセスする権限',
        'en' => 'Access to configure cookies',
    ),
    'config.Core.tab_misc' => array(
        'ja' => 'コンフィギュレーションの「その他」タブにアクセスする権限',
        'en' => 'Access to configure miscellaneous settings',
    ),
    'config.Core.tab_debug' => array(
        'ja' => 'コンフィギュレーションの「デバッグ」タブにアクセスする権限',
        'en' => 'Access to configure debug',
    ),
    'config.Core.tab_daily_digest' => array(
        'ja' => 'コンフィギュレーションの「デイリーダイジェスト」タブにアクセスする権限',
        'en' => 'Access to configure daily digest',
    ),
    'config.Core.tab_htmlfilter' => array(
        'ja' => 'コンフィギュレーションの「HTMLフィルタ」タブにアクセスする権限',
        'en' => 'Access to configure HTML filtering',
    ),
    'config.Core.tab_censoring' => array(
        'ja' => 'コンフィギュレーションの「バッドワードチェック」タブにアクセスする権限',
        'en' => 'Access to configure censoring',
    ),
    'config.Core.tab_iplookup' => array(
        'ja' => 'コンフィギュレーションの「IP検索」タブにアクセスする権限',
        'en' => 'Access to configure IP lookup',
    ),
    'config.Core.tab_permissions' => array(
        'ja' => 'コンフィギュレーションの「パーミッション」タブにアクセスする権限',
        'en' => 'Access to configure permissions for story, topic, block and autotags',
    ),
    'config.Core.tab_webservices' => array(
        'ja' => 'コンフィギュレーションの「Webサービス」タブにアクセスする権限',
        'en' => 'Access to configure webservices',
    ),
    'config.Core.calendar.tab_autotag_permissions' => array(
        'ja' => 'コンフィギュレーションの「カレンダー - 自動タグのパーミッション」タブにアクセスする権限',
        'en' => 'Access to configure event autotag usage permissions',
    ),
    'config..calendar.tab_permissions' => array(
        'ja' => 'コンフィギュレーションの「カレンダー - パーミッションのデフォルト」タブにアクセスする権限',
        'en' => 'Access to configure event default permissions',
    ),
    'config.calendar.tab_events_block' => array(
        'ja' => 'コンフィギュレーションの「カレンダー - イベントブロック」タブにアクセスする権限',
        'en' => 'Access to configure events block',
    ),
    'config.calendar.tab_main' => array(
        'ja' => 'コンフィギュレーションの「カレンダー - カレンダーのメイン設定」タブにアクセスする権限',
        'en' => 'Access to configure general calendar settings',
    ),
    'config.polls.tab_main' => array(
        'ja' => 'コンフィギュレーションの「アンケート - アンケートのメイン設定」タブにアクセスする権限',
        'en' => 'Access to configure general polls settings',
    ),
    'config.polls.tab_autotag_permissions' => array(
        'ja' => 'コンフィギュレーションの「アンケート - 自動タグのパーミッション」タブにアクセスする権限',
        'en' => 'Access to configure polls autotag usage permissions',
    ),
    'config.polls.tab_poll_block' => array(
        'ja' => 'コンフィギュレーションの「アンケート - アンケートブロック」タブにアクセスする権限',
        'en' => 'Access to configure polls block',
    ),
    'config.polls.tab_permissions' => array(
        'ja' => 'コンフィギュレーションの「アンケート - パーミッションのデフォルト」タブにアクセスする権限',
        'en' => 'Access to configure polls default permissions',
    ),
    'config.polls.tab_whatsnew' => array(
        'ja' => 'コンフィギュレーションの「アンケート - 新着情報ブロック」タブにアクセスする権限',
        'en' => 'Access to configure polls what\'s new block',
    ),
    'config.links.tab_permissions' => array(
        'ja' => 'コンフィギュレーションの「リンク - パーミッション」タブにアクセスする権限',
        'en' => 'Access to configure link permissions',
    ),
    'config.links.tab_autotag_permissions' => array(
        'ja' => 'コンフィギュレーションの「リンク - 自動タグのパーミッション」タブにアクセスする権限',
        'en' => 'Access to configure link\'s autotag usage permissions',
    ),
    'config.links.tab_cpermissions' => array(
        'ja' => 'コンフィギュレーションの「リンク - カテゴリのパーミッション」タブにアクセスする権限',
        'en' => 'Access to configure link\'s category permissions',
    ),
    'config.links.tab_admin' => array(
        'ja' => 'コンフィギュレーションの「リンク - 管理」タブにアクセスする権限',
        'en' => 'Access to configure links admin settings',
    ),
    'config.links.tab_public' => array(
        'ja' => 'コンフィギュレーションの「リンク - 公開リンク設定」タブにアクセスする権限',
        'en' => 'Access to configure public links list settings',
    ),
    'config.spamx.tab_main' => array(
        'ja' => 'コンフィギュレーションの「Spam-x - Spam-xのメイン設定」タブにアクセスする権限',
        'en' => 'Access to configure Spam-x main settings',
    ),
    'config.spamx.tab_modules' => array(
        'ja' => 'コンフィギュレーションの「Spam-x - Modules」タブにアクセスする権限',
        'en' => 'Access to configure Spam-x modules',
    ),
    'config.staticpages.tab_autotag_permissions' => array(
        'ja' => 'コンフィギュレーションの「静的ページ - 自動タグのパーミッション」タブにアクセスする権限',
        'en' => 'Access to configure static pages autotag usage permissions',
    ),
    'config.staticpages.tab_permissions' => array(
        'ja' => 'コンフィギュレーションの「静的ページ - パーミッションのデフォルト」タブにアクセスする権限',
        'en' => 'Access to configure static pages default permissions',
    ),
    'config.staticpages.tab_main' => array(
        'ja' => 'コンフィギュレーションの「静的ページ - 静的ページのメイン設定」タブにアクセスする権限',
        'en' => 'Access to configure static pages main settings',
    ),
    'config.staticpages.tab_search' => array(
        'ja' => 'コンフィギュレーションの「静的ページ - 検索」タブにアクセスする権限',
        'en' => 'Access to configure static pages search results',
    ),
    'config.staticpages.tab_whatsnew' => array(
        'ja' => 'コンフィギュレーションの「静的ページ - 新着情報ブロック」タブにアクセスする権限',
        'en' => 'Access to configure static pages what\'s new block',
    ),
    'config.calendar.tab_autotag_permissions' => array(
        'ja' => 'コンフィギュレーションの「カレンダー - 自動タグのパーミッション」タブにアクセスする権限',
        'en' => 'Access to configure event autotag usage permissions',
    ),
    'config.calendar.tab_permissions' => array(
        'ja' => 'コンフィギュレーションの「カレンダー - パーミッションのデフォルト」タブにアクセスする権限',
        'en' => 'Access to configure event default permissions',
    ),
    'config.Filemanager.tab_general' => array(
        'ja' => 'コンフィギュレーションの「ファイルマネージャー - 全般」タブにアクセスする権限',
        'en' => 'Access to configure Filemanager General Settings',
    ),
    'config.Filemanager.tab_upload' => array(
        'ja' => 'コンフィギュレーションの「ファイルマネージャー - アップロード」タブにアクセスする権限',
        'en' => 'Access to configure Filemanager Upload Settings',
    ),
    'config.Filemanager.tab_images' => array(
        'ja' => 'コンフィギュレーションの「ファイルマネージャー - 画像」タブにアクセスする権限',
        'en' => 'Access to configure Filemanager Images Settings',
    ),
    'config.Filemanager.tab_videos' => array(
        'ja' => 'コンフィギュレーションの「ファイルマネージャー - ビデオ」タブにアクセスする権限',
        'en' => 'Access to configure Filemanager Videos Settings',
    ),
    'config.Filemanager.tab_audios' => array(
        'ja' => 'コンフィギュレーションの「ファイルマネージャー - オーディオ」タブにアクセスする権限',
        'en' => 'Access to configure Filemanager Audios Settings',
    ),
);
