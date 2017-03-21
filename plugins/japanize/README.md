Geeklog 日本語化(Japanize)プラグイン
=====================================

更新履歴
--------

* tsuchi AT geeklog DOT jp
* geeklog AT mystral-kk DOT net
* 2008/09/27
* 2011/02/07 update
* 2012/12/31 v2.0.0   modified & updated by mystral-kk (geeklog AT mystral-kk DOT net)
* 2013/01/02 v2.0.1   modified & updated by mystral-kk (geeklog AT mystral-kk DOT net)
* 2013/09/07 v2.0.2   a minor bug fix (geeklog AT mystral-kk DOT net)
* 2014/02/09 v2.1.0   Updated to work with Geeklog-2.1.0
* 2015/06/10          Added README.md
* 2015/06/13          Changed $_CONF['url_rewrite'] setting to true
* 2016/01/19 v2.1.1   Modified to use {welcome_msg} instead of {welcome_msg_jp}
* 2016/01/30 v2.1.1.1 Modified to use {lang_attribute} instead of {html_attribute}
* 2017/01/10 v2.1.2   Updated to work with Geeklog-2.1.2
* 2017/03/21 v2.1.3   Fixed a bug that occurred when the Links plugin and/or the Calendar plugin was disabled

概要
----

Geeklog-1.6.x - 2.1.2 を日本人流にするプラグインです。詳細については管理画面をご参照ください。

ファイル構成
------------

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
      ├ japanize_data.php
      ├ functions.inc
      ├ install_defaults.php
      ├ readme_ja.txt
      └ version.php

インストール方法
----------------

1. データベースおよびファイルのバックアップをとります。
2. 標準的なプラグインのファイル配置に従い、ファイルをアップロードします。
  * plugins/ 以下に japanize以下をアップロードします。
  * admin/plugins/japanize/以下に admin以下のファイルを移動します。
  * public_html/japanize/以下に public_html以下のファイルを移動します。
3. Rootユーザーとしてログインし、プラグイン管理の画面でインストールを実行します

アンインストール方法
--------------------

1. データベースおよびファイルのバックアップをとります。
2. Rootユーザーとしてログインし、プラグイン管理の画面で削除を実行します。
3. アップしたファイルを削除します。

通常のアップグレード方法
------------------------
1. データベースおよびファイルのバックアップをとります。
2. 標準的なプラグインのファイル配置に従い、ファイルをアップロードします。
  * plugins/ 以下に japanize以下をアップロードします。
  * admin/plugins/japanize/以下に admin以下のファイルを移動します。
  * public_html/japanize/以下に public_html以下のファイルを移動します。
3. Rootユーザーとしてログインし、プラグイン管理の画面で更新を実行します。
