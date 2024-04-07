<?php
include "_common.php";

$temp_1 = $_POST['loader_k'];
$target = $_POST['target'];
$before = $_POST['before'];
$text = $_POST["{$temp_1}"];
$text = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $text);
sql_Query("DELETE FROM memo WHERE mb_id = '{$member['mb_id']}' AND memo_mb_id = '{$target}' ORDER BY wr_id DESC LIMIT 1");
if(mb_strlen($text) > 2){
    sql_Query("INSERT INTO memo(mb_id, memo_mb_id, message) VALUES('{$member['mb_id']}','{$target}','{$text}')");
}
header("Location: ".G5_URL.$before);
