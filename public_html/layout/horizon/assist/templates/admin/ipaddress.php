<?php
header("Content-Type: application/x-javascript; charset=UTF-8");
$ip = getenv("REMOTE_ADDR");
echo "document.write(\"あなたのIPアドレスは".$ip."\")";
?>
