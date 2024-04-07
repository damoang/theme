<?php
require "_common.php";
$data = array();
if(!$is_member){
    alert('로그인 하세요.', G5_BBS_URL.'/login.php');
}
$json = "";
if(!isset($_GET['bo_table'])){
    alert();
    die();
}
if($member['mb_somoim_favorite'] == null){
    $data = array();
} else {
    $data = json_decode($member['mb_somoim_favorite']);
}
if(in_array($_GET['bo_table'], $data)){
    $data = array_diff($data, array($_GET['bo_table']));
    $data = array_values($data);
} else {
    array_push($data, $_GET['bo_table']);
}
$json = json_encode($data);
sql_Query("UPDATE g5_member SET mb_somoim_favorite = '{$json}' WHERE mb_id = '{$member['mb_id']}' ");
header("Location: ".G5_URL."/somoim/favorite.php");