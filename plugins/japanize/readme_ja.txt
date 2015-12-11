--------------------------------------------------------------------------------
Geeklog 日本語化（Japanize)プラグイン
tsuchi AT geeklog DOT jp
2008/09/27
2011/02/07         update
2012/12/31 v2.0.0  modified & updated by mystral-kk (geeklog AT mystral-kk DOT net)
2013/01/02 v2.0.1  modified & updated by mystral-kk (geeklog AT mystral-kk DOT net)
2013/09/07 v2.0.2  a minor bug fix (geeklog AT mystral-kk DOT net)
2014/02/09 v2.1.0  Updated to work with Geeklog-2.1.0

--------------------------------------------------------------------------------
概要: Geeklog-2.1.0 を日本人流にするプラグインです
       詳細については管理画面をご参照ください
--------------------------------------------------------------------------------
ファイル構成
-japanize
  ├ admin
  │ └ index.php
  ├ custom
  │ └ custom_mail_japanize.php
  ├ language
  │ └ japanese_utf-8.php
  ├ public_html
  │ ├ images
  │ │ └ japanize.png
  │ ├ disabledmsg.html
  │ └ index.html
  │ templates
  │ └ admin
  │    ├ index.thtml
  ├ autoinstall.php
  ├ data.php
  ├ functions.inc
  ├ install_defaults.php
  ├ readme_ja.txt
  └ version.php

--------------------------------------------------------------------------------
インストール方法
1. データベースおよびファイルのバックアップをとります。
2. 標準的なプラグインのファイル配置に従い、ファイルをアップします。
   plugins/ 以下に japanize以下をアップ
   admin/plugins/japanize/以下に admin以下のファイルを移動
   public_html/japanize/以下に public_html以下のファイルを移動
3. Rootユーザーとしてログインし、プラグイン管理の画面でインストールを実行します

--------------------------------------------------------------------------------
アンインストール方法
1. データベースおよびファイルのバックアップをとります。
2. Rootユーザーとしてログインし、プラグイン管理の画面で削除を実行します。
3. アップロードしたファイルを削除します。

--------------------------------------------------------------------------------
通常のアップグレード方法
1. データベースおよびファイルのバックアップをとります。
2. 標準的なプラグインのファイル配置に従い、ファイルをアップします。
    plugins/ 以下に japanize以下をアップ、
    admin/plugins/japanize/以下に admin以下のファイルを移動、
    public_html/japanize/以下に public_html以下のファイルを移動。
3. Rootユーザーとしてログインし、プラグイン管理の画面で更新を実行します
