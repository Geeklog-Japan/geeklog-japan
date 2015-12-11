<?php
/**
 * 携帯用ブロック表示スクリプト
 * 
 * mobileblocks.php?bid=ブロックID
 * bid: ブロックID
 *
 * bidに表示するブロックIDを指定する。
 * bidが指定されていなければブロックの一覧を表示する。
 */

require_once('lib-common.php');

$display = COM_siteHeader();
if (isset ($_GET['bid'])) {
	$bid = COM_applyFilter($_GET['bid'], true);
    $block = CUSTOM_MOBILE_getBlock($bid);
    if($block) {
        $display .= COM_formatBlock($block);
    }
 } else {
    $display .= CUSTOM_MOBILE_blockMenu();
 }

$display .= COM_siteFooter();
echo $display;
?>
