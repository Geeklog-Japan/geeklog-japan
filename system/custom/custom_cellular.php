<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'custom_cellular.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Geeklog hack for cellular phones.
 * Copyright (c) 2006 - 2008 Tatsumi Imai(http://im-ltd.ath.cx)
 * License: GPL v2 or later
 * Time-stamp: <2009-03-09 03:13:44 imai>
 */

// 設定
$CUSTOM_MOBILE_CONF['debug'] = false;
$CUSTOM_MOBILE_CONF['use_mobile_content'] = true; // モバイル用、PC用のコンテンツ変換を行う
$CUSTOM_MOBILE_CONF['force_2g_content'] = false; // 強制的に2G用コンテンツを表示する
$CUSTOM_MOBILE_CONF['force_wm_as_pc'] = false; // Windows MobileデバイスをPCとして認識する
$CUSTOM_MOBILE_CONF['force_cut_table'] = true; // 強制的にテーブルを削除する
$CUSTOM_MOBILE_CONF['cut_comment'] = true; // コメントを削除する
$CUSTOM_MOBILE_CONF['convert_to_sjis'] = true; // SJISに変換する
$CUSTOM_MOBILE_CONF['host_charset'] = "UTF-8"; // サーバはUTF-8
$CUSTOM_MOBILE_CONF['refresh_use_location'] = true; // refreshにLocationヘッダを使用する
/**
 * 画像の縮小用パラメータ
 */
$CUSTOM_MOBILE_CONF['resize_image'] = true;
$CUSTOM_MOBILE_CONF['image_size'] = 150; // 縦または横の最大値
$CUSTOM_MOBILE_CONF['image_quality'] = 60; // jpegの変換品質

/**
 * 表示する記事の数(データ量制限のため)
 */
$CUSTOM_MOBILE_CONF['max_stories'] = 3;


/**
 * start_session()がコールされるたびにgc_probability/gc_divisorの確率で
 * gc_maxlifetimeを過ぎたセッションを破棄する。
 */
$CUSTOM_MOBILE_CONF['gc_maxlifetime'] = 1440; //
$CUSTOM_MOBILE_CONF['gc_probability'] = "1"; //
$CUSTOM_MOBILE_CONF['gc_divisor'] = "10"; //

$CUSTOM_MOBILE_UA = 0;

define("MOBILE_3G", 16);
define("MOBILE_UA_NOT_CELLULAR", 0);
define("MOBILE_UA_OTHER", 1);
define("MOBILE_UA_DOCOMO", 2);
define("MOBILE_UA_AU", 3);
define("MOBILE_UA_SOFTBANK", 4);
define("MOBILE_UA_WILCOM", 5);
define("MOBILE_UA_WM", 6);

define("MOBILE_UA_OTHER_3G", 17);
define("MOBILE_UA_DOCOMO_3G", 18);
define("MOBILE_UA_AU_3G", 19);
define("MOBILE_UA_SOFTBANK_3G", 20);
define("MOBILE_UA_WILCOM_3G", 21);
define("MOBILE_UA_WM_3G", 22);

// 補助URL
define("RESIZER", "/imageresizer.php");
define("BLOCKS", $_CONF['site_url'] . "/mobileblocks.php");

// ユーザエージェントを解析して端末のタイプを判定する
function _mobile_parse_ua()
{
    global $CUSTOM_MOBILE_UA, $CUSTOM_MOBILE_CONF;
    $agent = $_SERVER["HTTP_USER_AGENT"];

    /**
     * ケータイの判定基準を変えるには以下のif文を修正する
     */
    if(preg_match("/^(DoCoMo\/1|DoCoMo\/2)\.0/i", $agent)) {
        // DoCoMo
        $CUSTOM_MOBILE_UA = MOBILE_UA_DOCOMO;
    } else if(preg_match("/^(Softbank|J\-PHONE|Vodafone|MOT\-[CV]|Semulator)/i", $agent)) {
        // SoftBank
        $CUSTOM_MOBILE_UA = MOBILE_UA_SOFTBANK;
    } else if(preg_match("/(UP\.Browser|KDDI\-)/i", $agent)) {
        // AU
        $CUSTOM_MOBILE_UA = MOBILE_UA_AU;
    } else if(preg_match("/(DDIPOCKET|WILLCOM)/i", $agent)) {
        // Wilcom
        $CUSTOM_MOBILE_UA = MOBILE_UA_WILCOM;
    } else if(preg_match("/Windows *CE/i", $agent) ||
              preg_match("/jigbrowserweb/i", $agent) ||
              preg_match("/NetFront/i", $agent) ||
              preg_match("/(Y!J-SRD\/1.0|Y!J-MBS\/1.0)/i", $agent)) {
        // その他ケータイと判定するもの
        $CUSTOM_MOBILE_UA = MOBILE_UA_OTHER;
    } else {
        $CUSTOM_MOBILE_UA = MOBILE_UA_NOT_CELLULAR;
    }

    if($CUSTOM_MOBILE_UA > MOBILE_UA_NOT_CELLULAR) {
        // 3Gかどうかの判定
        /**
         * ここで3Gとは以下のものを示す。
         * DoCoMo: FOMAでHTML5.0以上
         * AU: WAP2.0対応
         * SoftBank: SoftBank 3Gシリーズ
         * その他: Windows Mobile, PDAのNetFront
         */
        if(preg_match("/Windows *CE/i", $agent) ||
           preg_match("/.*PDA;.*NetFront/i", $agent)){
            if($CUSTOM_MOBILE_CONF['force_wm_as_pc']) {
                $CUSTOM_MOBILE_UA = MOBILE_UA_NOT_CELLULAR;
            } else {
                $CUSTOM_MOBILE_UA = MOBILE_UA_WM_3G;
            }
        } else if (preg_match("/^DoCoMo\/2.0/i", $agent) ||
           preg_match("/^(Softbank|Vodafone|MOT\-[CV]|Semulator)/i", $agent) ||
           preg_match("/^KDDI\-/i", $agent)
           ) {
            $CUSTOM_MOBILE_UA = $CUSTOM_MOBILE_UA + MOBILE_3G;
        }
    }

    CUSTOM_MOBILE_debug("User Agent: " . $_SERVER["HTTP_USER_AGENT"]);
    CUSTOM_MOBILE_debug("CUSTOM_MOBILE_UA: $CUSTOM_MOBILE_UA");
}

// ユーザエージェントからケータイかどうか判定する
function CUSTOM_MOBILE_is_cellular()
{
    global $CUSTOM_MOBILE_UA;
    return ($CUSTOM_MOBILE_UA > MOBILE_UA_NOT_CELLULAR);
}

// ユーザエージェントから3G端末かどうか判定する
function CUSTOM_MOBILE_is_3g()
{
    global $CUSTOM_MOBILE_UA;
    return ($CUSTOM_MOBILE_UA > MOBILE_3G);
}

// テーブルが使える端末か判定する
function CUSTOM_MOBILE_is_table_enabled()
{
    global $CUSTOM_MOBILE_UA;
    /**
     * ここでは以下のものをテーブルが使える端末と判定する
     * AUまたはSoftBankで3Gのもの
     * Wiondows Mobile
     */
    return (
            $CUSTOM_MOBILE_UA == MOBILE_UA_OTHER_3G ||
            $CUSTOM_MOBILE_UA == MOBILE_UA_AU_3G ||
            $CUSTOM_MOBILE_UA == MOBILE_UA_SOFTBANK_3G
            );
}


// GeeklogのセッションIDとIPアドレスをケータイ用のセッションに保存する
function CUSTOM_MOBILE_save_session($sessid, $remote_ip) {
    global $CUSTOM_MOBILE_CONF;

    CUSTOM_MOBILE_debug("*** in CUSTOM_MOBILE_save_session");
    _mobile_session_check();
    CUSTOM_MOBILE_debug("SID: " . SID);
    if(SID != '' || SID != 'SID') {
        // $sessidをPHPのセッション変数に格納する
        $_SESSION['mobile_sid'] = $sessid;
        $_SESSION['remote_ip'] = $remote_ip;
        CUSTOM_MOBILE_debug("save sessid and remote_ip to mobile session: " . $sessid . ", " . $remote_ip);
    }
    CUSTOM_MOBILE_debug("*** leaving CUSTOM_MOBILE_save_session");
}

// ケータイ用のセッションをチェックし、必要に応じて初期化する
function _mobile_session_check() {
    CUSTOM_MOBILE_debug("*** in session_check");
    session_start();
    CUSTOM_MOBILE_debug("SID: ". SID);
    // 端末から送られたセッションIDの正当性をチェックする
    if (!isset($_SESSION['_SESSION_CHECK'])) {
        // 正当なIDでなければ送られてきたセッションを破壊し、初期化する
        session_destroy();
        session_start();
        session_regenerate_id();
        CUSTOM_MOBILE_debug("new session created");
        CUSTOM_MOBILE_debug("SID: ". SID);
        // 正当性の保証として現在時刻を保存する
        $_SESSION['_SESSION_CHECK'] = time();
    }
    CUSTOM_MOBILE_debug("*** leaving session_check");
}

// ケータイ用セッションからGeeklogのセッションIDを読み出す
function CUSTOM_MOBILE_load_session() {
    global $CUSTOM_MOBILE_CONF;

    CUSTOM_MOBILE_debug("*** in CUSTOM_MOBILE_load_session");
    CUSTOM_MOBILE_debug("SID: " . SID);
    $ret = null;
    if (! isset ($_COOKIE[$_CONF['cookie_session']])) {
        // Cookieにsession IDが設定されていない
        CUSTOM_MOBILE_debug("no session id found in cookie");
        CUSTOM_MOBILE_debug("session id: " . $_SESSION['mobile_sid']);
        if ( isset ($_SESSION['mobile_sid'])) {
            // ケータイセッションIDがPHPのセッション変数にセットされている
            CUSTOM_MOBILE_debug("session id found in mobile session: " .
                $_SESSION['mobile_sid']);
            $ret = $_SESSION['mobile_sid'];
        }
    }
    CUSTOM_MOBILE_debug("*** leaving CUSTOM_MOBILE_load_session");
    return $ret;
}

// ケータイ用セッションから接続時のIPアドレスを読み出す
function CUSTOM_MOBILE_load_ip() {
    global $CUSTOM_MOBILE_CONF;

    CUSTOM_MOBILE_debug("*** in CUSTOM_MOBILE_load_ip");
    CUSTOM_MOBILE_debug("SID: " . SID);
    $ret = null;
    if ( isset ($_SESSION['remote_ip'])) {
        // IPがPHPのセッション変数にセットされている
        CUSTOM_MOBILE_debug("remote ip found in mobile session: " . $_SESSION['remote_ip']);
        $ret = $_SESSION['remote_ip'];
    }
    CUSTOM_MOBILE_debug("*** leaving CUSTOM_MOBILE_load_ip");
    return $ret;
}

// ケータイ用セッションを削除する(ログアウト時)
function CUSTOM_MOBILE_remove_session() {
    $_old_session_id = session_id();
    $_SESSION = array();
    session_destroy();
    session_start();
    session_regenerate_id();
    $_old_session_file = session_save_path() . '/sess_' . $_old_session_id;
    if (file_exists($_old_session_file)) {
        //unlink($_old_session_file);
    }
}

// デバッグメッセージをerror.logに出力する
function CUSTOM_MOBILE_debug($msg) {
    global $CUSTOM_MOBILE_CONF;

    if($CUSTOM_MOBILE_CONF['debug']) {
        COM_ErrorLog($msg,1);
    }
}

// iモードや他の多くの端末は'<meta http-equiv="refresh"... を正しく扱えない。
// そこでlib-commonのCOM_refresh()をハックする。
function CUSTOM_refresh($url)
{
    global $LANG05,$CUSTOM_MOBILE_CONF;
    if(CUSTOM_MOBILE_is_cellular()) {
        // ページ内リンクを探す
        $pos = strpos($url, '#');
        if($pos === false) {
            //CUSTOM_MOBILE_debug("not matched: " . $url);
            $link = "";
        } else {
            //CUSTOM_MOBILE_debug("matched: " . $url);
            $link = substr($url, $pos);
            $url = substr($url, 0, $pos);
        }
        if($CUSTOM_MOBILE_CONF['refresh_use_location']) {
            $sepa = '?';
            if (strpos($url, '?') > 0)
            {
                // 2009-02-19 Kunitsuji update
                $sepa = '&';
                //$sepa = '&amp;';
            }
            $url = str_replace('&amp;', '&', $url);
            $location_url = 'Location: ' . $url . $sepa . SID . $link;
            header( $location_url );
            exit;
        } else {
            $msg = mb_convert_encoding($LANG05['5'], 'sjis-win',
                               mb_detect_encoding($LANG05['5'], "UTF-8,EUC-JP,JIS,sjis-win"));
            $sepa = '?';
            if (strpos($url, '?') > 0) {
                $sepa = '&amp;';
            }
            $location_url = $url . $sepa . SID . $link;
            return "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"" .
                "\"http://www.w3.org/TR/html4/loose.dtd\">\n" .
                "<html><head><title>$msg</title></head>" .
                "<body><a href=\"$location_url\">$msg</a></body></html>\n";
        }
    } else {
        return "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
    }
}

// テーブル削除用のパターン配列
$_mobile_table =
array(
    '@<\s*table[^>]*?>@si'  => '',
    '@<\s*/table[^>]*?>@si' => '',
    '@<\s*thead[^>]*?>@si'  => '',
    '@<\s*/thead[^>]*?>@si' => '',
    '@<\s*tbody[^>]*?>@si'  => '',
    '@<\s*/tbody[^>]*?>@si' => '',
    '@<\s*tfoot[^>]*?>@si'  => '',
    '@<\s*/tfoot[^>]*?>@si' => '',
    '@<\s*tr[^>]*?>@si'     => '',
    '@<\s*/tr[^>]*?>@si'    => '<br>',
    '@<\s*th[^>]*?>@si'     => '',
    '@<\s*/th[^>]*?>@si'    => '&nbsp;',
    '@<\s*td[^>]*?>@si'     => '',
    '@<\s*/td[^>]*?>@si'    => '&nbsp;',
);

// コメント削除用のパターン配列
$_mobile_comment =
array(
    '@<!--.*?-->@sm' => '',
    '@<!--@'         => '',
    '@-->@'          => '',
);

// 3Gケータイ専用コンテンツのパターン配列
$_mobile_3g =
array(
    // cut "div"
    '@<\s*div[^>]*?>@si'        => '',
    '@<\s*/div[^>]*?>@si'       => "<br>\n",
    // cut style
    '@style="[^"].*?"@i'        => '',
    // cut class
    '@class="[^"].*?"@i'        => '',
    // cut embed
    '@<embed[^>]*?></embed>@si' => '',
);


// ケータイ専用コンテンツのパターン配列
$_mobile_content =
array(
    '@<!--mobile_only@' => '',
    '@/mobile_only-->@' => '',
    '@<!--not_for_mobile-->.*?<!--/not_for_mobile-->@ms' => '',
);



// ケータイ用のアウトプットハンドラ
function _mobile_output_handler($content, $status)
{
    global $CUSTOM_MOBILE_CONF,
        $_mobile_table,
        $_mobile_comment,
        $_mobile_3g,
        $_mobile_content,
        $_mobile_images;

    // モバイル用のコンテンツを表示、PC用のコンテンツを非表示
    // これは単独で一番先に実行する必要がある
    if ($CUSTOM_MOBILE_CONF['use_mobile_content']) {
        $content = preg_replace(
            array_keys($_mobile_content), array_values($_mobile_content), $content
        );
    }
    // コメントを削除
    // これは単独で2番目に実行する必要がある
    if ($CUSTOM_MOBILE_CONF['cut_comment']) {
        $content = preg_replace(
            array_keys($_mobile_comment), array_values($_mobile_comment), $content
        );
    }

    // テーブルを削除
    if ($CUSTOM_MOBILE_CONF['force_2g_content'] ||
       $CUSTOM_MOBILE_CONF['force_cut_table'] ||
       !CUSTOM_MOBILE_is_table_enabled()) {
        $content = preg_replace(
            array_keys($_mobile_table), array_values($_mobile_table), $content
        );
    }

    // 3G端末用コンテンツを削除
    if ($CUSTOM_MOBILE_CONF['force_2g_content'] ||
       !CUSTOM_MOBILE_is_3g()) {
        $content = preg_replace(
            array_keys($_mobile_3g), array_values($_mobile_3g), $content
        );
    }

    // 画像の縮小
    if ($CUSTOM_MOBILE_CONF['resize_image']) {
        //CUSTOM_MOBILE_debug("search: " . $_mobile_images[0][0]);
        $content = preg_replace(
            array_keys($_mobile_images), array_values($_mobile_images), $content
        );
    }

    // その他雑多な変換
    if ($CUSTOM_MOBILE_CONF['convert_to_sjis']) {
        $charset ='Shift_JIS';
    } else {
        $charset = $CUSTOM_MOBILE_CONF['host_charset'];
    }

    $search =
        array(// topic icon
              '@(<img .+?src=.+?/images/topics/.+? alt=")(.+?)" [^>]*?>@i',
              // charset
              '@charset=' . $CUSTOM_MOBILE_CONF['host_charset'] . '@i',
              // for phones can't treat ' />' xhtml notation
              //'@ */>@i',
              // cut script
              '@<script[^>]*?>.*?</script>@si',
              // 変換の結果生じた無駄なタグの削除
              '@<dt></dt>@i',
              '@<dd></dd>@i',
              '@<li></li>@i',
              '@^\s*<dl>([\s\n]*)</dl>@mi',
              '@^\s*<li>([\s\n]*)</li>@mi',
              '@\s*?&nbsp;@',
              '@\s*\n+@m',
              '@((\s)*<br>)+@sm',
              );

    $replace=
        array(// topic icon
              '$2',
              // charset
              'charset='. $charset,
              // for phones can't treat ' />' xhtml notation
              //'>',
              '',
              // 変換の結果生じた無駄なタグの削除
              '',
              '',
              '',
              '',
              '',
              '',
              "\n",
              '<br>',
              );
    $content = preg_replace($search, $replace, $content);

    // セッションIDの埋め込み
    if(SID != '' || SID != 'SID') {
        // Cookieが使える場合はSIDに''が設定されるため、埋め込みを行わない
        CUSTOM_MOBILE_debug("SID: " . SID);
        $content = _mobile_add_sessid($content);
        // (Issue 96) 検索対策として一時的な対応
        list($sid_key, $sid_val) = explode('=', SID);
        $content = str_replace('%MOBILE_SID_NAME%', $sid_key, $content);
        $content = str_replace('%MOBILE_SID_VALUE%', $sid_val, $content);
    }

    header ('Content-Type: text/html; charset=' . "Shift_JIS");
    return mb_convert_encoding($content, 'sjis-win', mb_detect_encoding($content));
}

// ページ内のURIにセッションIDを付加する
function _mobile_add_sessid($content) {
    global $_CONF;

    // ページ内の<a>タグ、<form>タグのurlを抽出
    $pat1 = '!(<a\s+.*?href=)([\'"])([^\2]*?)(\2)!i';
    $pat2 = '!(<form\s+.*?action=)([\'"])([^\2]*?)(\2)!i';
    $search = array($pat1, $pat2,);
    // コールバック関数に渡してセッションIDを追加する
    return preg_replace_callback($search, _mobile_session_callback, $content);
}

// ページ内のURIにセッションIDを付加するためのコールバック関数
function _mobile_session_callback($matches) {
    global $_CONF;
    $pat = $_CONF['site_url'];
    $ret = substr($matches[0], 0, -1);
    $delim = substr($matches[0], -1);

    // forumのバグ? cf: forum/createtopic.php line 342 & forum/viewtopic.php line 100.
    $ret = preg_replace('!true#\d+!', 'true', $ret);

    if(preg_match("!https*?:\/\/!", $ret)) {
        // 絶対アドレス
        if(!preg_match("!$pat!", $ret)) {
            // 外部サイトだったらそのまま返す
            return $ret . $delim;
        } else {
            ; // 自サイト
        }
    } else if(preg_match("![a-z]+:.+!", $ret)){
        // http以外のプロトコル
        return $ret . $delim;
    } else {
        ; // 相対アドレス
    }
    // ページ内リンクを探す
    $pos = strpos($ret, '#');
    if($pos === false) {
        //CUSTOM_MOBILE_debug("not matched: " . $ret);
        $link = "";
    } else {
        //CUSTOM_MOBILE_debug("matched: " . $ret);
        $link = substr($ret, $pos);
        $ret = substr($ret, 0, $pos);
    }
    // Softbank対応
    // Softbank(Vodafone)のアクセスポイントはpid, sid, uidなどを正しく扱わない。
    // そのためこれらをURLエンコードする。
    $search = array(
                    '@pid=@i',
                    '@sid=@i',
                    '@uid=@i',
                    );
    $replace = array(
                     '%70%69%64=',//pid
                     '%73%69%64=',//sid
                     '%75%69%64=',//uid
                     );
    $ret = preg_replace($search, $replace, $ret);

    // URLクエリのセパレータ
    $sep = strpos($ret, '?')?'&amp;':'?';
    // SIDを追加する
    $ret = $ret . $sep . htmlspecialchars(SID) . $link . $delim;
    //CUSTOM_MOBILE_debug("sid added: " . $ret);
    return $ret;
}

// stripslashes（配列対応版）
function _mobile_stripslashes_deep($data) {
    if (is_array($data)) {
        return array_map('_mobile_stripslashes_deep', $data);
    } else {
        return stripslashes($data);
    }
}

// urldecode（配列対応版）
function _mobile_urldecode_deep($data) {
    if (is_array($data)) {
        return array_map('_mobile_urldecode_deep', $data);
    } else {
        return urldecode($data);
    }
}

// 入力をURLデコードする
function _mobile_prepare_input(&$array) {
    reset($array);
    $copy = $array;
    while (list($key, $val) = each($copy)) {
        if (get_magic_quotes_gpc()) {
            $key = _mobile_stripslashes_deep($key);
            $val = _mobile_stripslashes_deep($val);
        }
        $keyconv = urldecode($key);
        if( $key != $keyconv ) {
            unset($array[$key]);
        }
        $array[$keyconv] = _mobile_urldecode_deep($val);
    }
    reset($array);
}

// ブロック一覧の取得
function CUSTOM_MOBILE_getBlocks($side = 'left')
{
    global $_CONF, $_TABLES, $_USER, $LANG21, $topic, $page;

    $retval = '';

    // Get user preferences on blocks
    if( !isset( $_USER['noboxes'] ) || !isset( $_USER['boxes'] ))
    {
        if( !empty( $_USER['uid'] ))
        {
            $result = DB_query( "SELECT boxes,noboxes FROM {$_TABLES['userindex']} "
                               ."WHERE uid = '{$_USER['uid']}'" );
            list($_USER['boxes'], $_USER['noboxes']) = DB_fetchArray( $result );
        }
        else
        {
            $_USER['boxes'] = '';
            $_USER['noboxes'] = 0;
        }
    }

    $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) AS date "
         . "FROM {$_TABLES['blocks']} WHERE is_enabled = 1";

    if( $side == 'left' )
    {
        $sql .= " AND onleft = 1";
    }
    else
    {
        $sql .= " AND onleft = 0";
    }

    if( !empty( $_USER['boxes'] ))
    {
        $BOXES = str_replace( ' ', ',', $_USER['boxes'] );

        $sql .= " AND (bid NOT IN ($BOXES) OR bid = '-1')";
    }

    $sql .= ' ORDER BY blockorder,title asc';

    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    // convert result set to an array of associated arrays
    $blocks = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $blocks[] = DB_fetchArray( $result );
    }

    // sort the resulting array by block order
    $column = 'blockorder';
    $sortedBlocks = $blocks;
    for( $i = 0; $i < sizeof( $sortedBlocks ) - 1; $i++ )
    {
        for( $j = 0; $j < sizeof( $sortedBlocks ) - 1 - $i; $j++ )
        {
            if( $sortedBlocks[$j][$column] > $sortedBlocks[$j+1][$column] )
            {
                $tmp = $sortedBlocks[$j];
                $sortedBlocks[$j] = $sortedBlocks[$j + 1];
                $sortedBlocks[$j + 1] = $tmp;
            }
        }
    }
    $blocks = $sortedBlocks;
    return $blocks;
}

// ブロックメニューの表示
function CUSTOM_MOBILE_blockMenu()
{

    $blockmenu .= "<h1>サブメニュー</h1>\n";
    $blockmenu .= "<ul>\n";
    $b = CUSTOM_MOBILE_getBlocks();
    $rb = CUSTOM_MOBILE_getBlocks('right');
    $b = array_merge($b, $rb);
    foreach($b as $A) {
        if( $A['type'] == 'dynamic' or
            SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'],
                           $A['perm_group'], $A['perm_members'], $A['perm_anon'] ) > 0 )
            {
                $blockmenu .= "<li><a href=\"" . BLOCKS . "?bid=". $A['bid'] . "\">" .
                        $A['title'] . "</a></li>\n";
            }
    }
    $blockmenu .= "</ul>\n";
    return $blockmenu;
}


// ブロックの取得
function CUSTOM_MOBILE_getBlock($bid) {
    global $_CONF, $_TABLES, $_USER, $LANG21;

    if(empty($bid)) {
        return NULL;
    }
    $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) AS date "
        . "FROM {$_TABLES['blocks']} WHERE is_enabled = 1 "
        . "AND bid = {$bid}";
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );
    if($nrows == 0) {
        exit("no block found.");
    } else if($nrows > 1) {
        exit("2 or more blocks found.");
    }
    $block = DB_fetchArray( $result );

    return $block;
}

// メインルーチン
// ユーザエージェントを確認
_mobile_parse_ua();
if(CUSTOM_MOBILE_is_cellular()) {
    // COM_output対応の携帯版
    if ($_CONF['compressed_output']) {
        ob_start("ob_gzhandler");
    }
    // セッション管理の初期化(Cookieを使わない)
    ini_set('session.use_cookies', false);
    ini_set('session.use_only_cookies', false);
    ini_set('session.use_trans_sid', true);
    ini_set('session.gc_probability', "1");
    ini_set('session.gc_divisor', "10");
    ini_set('session.gc_maxlifetime', "691200");

    // ケータイ用のテーマを使用
    $_CONF['theme'] = 'mobile';
    $_POST['usetheme'] = 'mobile';
    $_USER['theme'] = 'mobile';
    define('XHTML', '');

    // 各種デフォルト値を変更
    $_CONF['limitnews'] = $CUSTOM_MOBILE_CONF['max_stories'];
    $_CONF['advanced_editor'] = false;
    $_CONF['hideprintericon'] = 1;
    $_CONF['hideemailicon'] = 1;
    $_CONF['hideviewscount'] = 1;
    $_CONF['show_topic_icon'] = 1;
    $_CONF['postmode'] = 'text';
    //$_CONF['hide_main_page_navigation'] = 1;
    $_CONF['trackback_enabled'] = 0;
    $_CONF['pingback_enabled'] = 0;
    $_CONF['ping_enabled'] = 0;

    /*
    $CONF_FORUM_MOBILE['show_topics_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_posts_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_messages_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_searches_perpage'] = "5";
    $CONF_FORUM_MOBILE['use_autorefresh'] = "0";
    */
    $CONF_FORUM['default_Datetime_format'] = '%y/%m/%d %H:%M';
    $CONF_FORUM['default_Topic_Datetime_format'] = '%y/%m/%d %H:%M';
    $CONF_FORUM['show_topicreview'] = "0";

    // メッセージを短く
    $_CONF['date'] = ' %Y/%m/%d %I:%M %p';
    $LANG12[9] = "";
    $LANG12[19] = "";

    // ADMIN_list()のクエリの上限を設定
    $_REQUEST['query_limit'] = 5;

    $token = ''; // Default to no token.

    /*
     * 記事投稿で一部の端末はrefererを返さないため
     * SEC_checkToken()が偽になる
     * これを避けるためrefererを設定する
     */
    if(array_key_exists(CSRF_TOKEN, $_GET)) {
        $token = COM_applyFilter($_GET[CSRF_TOKEN]);
    } else if(array_key_exists(CSRF_TOKEN, $_POST)) {
        $token = COM_applyFilter($_POST[CSRF_TOKEN]);
    }
    CUSTOM_MOBILE_debug("token: $token");
    CUSTOM_MOBILE_debug("referer: " . $_SERVER['HTTP_REFERER']);
    if(trim($token) != '' && $_SERVER['HTTP_REFERER'] =='') {
        $sql = "SELECT ((DATE_ADD(created, INTERVAL ttl SECOND) < NOW()) AND ttl > 0) "
            . "as expired, owner_id, urlfor FROM "
            . "{$_TABLES['tokens']} WHERE token='$token'";
        $tokens = DB_Query($sql);
        if(DB_numRows($tokens) == 1) {
            $tokendata = DB_fetchArray($tokens);
            CUSTOM_MOBILE_debug("urlfor: " . $tokendata['urlfor']);
            $_SERVER['HTTP_REFERER'] = $tokendata['urlfor'];
        }
    }

    ini_set("url_rewriter.tags", "a=href,area=href,frame=src,fieldset=");
    session_start();

    // 入力をURLデコードする
    _mobile_prepare_input($_POST);
    _mobile_prepare_input($_GET);
    _mobile_prepare_input($_REQUEST);

    if($CUSTOM_MOBILE_CONF['convert_to_sjis']) {
        mb_convert_variables($CUSTOM_MOBILE_CONF['host_charset'],"sjis-win", $_POST, $_GET, $_REQUEST);
                                       //mb_detect_encoding($key, "sjis-win,UTF-8,EUC-JP,JIS"));

        // 出力をシフトJISに変換
        ini_set('mbstring.internal_encoding', $CUSTOM_MOBILE_CONF['host_charset']);
        ini_set('mbstring.encoding_translation', '0');
        ini_set('mbstring.http_output', 'pass');
        ini_set('mbstring.http_input', 'pass');
    }

    ob_start('_mobile_output_handler');
}


// 画像タグのパターン配列
$_mobile_images =
array(
    '@<(\s*img.*?)width="[0-9]+?"(.*?)>@si'  => '<$1$2>',
    '@<(\s*img.*?)height="[0-9]+?"(.*?)>@si' => '<$1$2>',
    '@<(\s*img.*?)src="([^"]*?)"(.*?)>@si'   => '<$1src="' . $_CONF['site_url']
        . RESIZER . '?image=$2&amp;size='. $CUSTOM_MOBILE_CONF['image_size']
        . '&amp;quality=' . $CUSTOM_MOBILE_CONF['image_quality']
        . '&amp;site_url=' . $_CONF['site_url'] . '"$3 ' . XHTML . '>',
);
