<?php
global $bo_table;
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$targetCategory = $_POST['targetCategory'];
$targetWrId = $_POST['targetWrId'];

require_once __DIR__ . '/lib/PostCategoryChanger.php';

$postCategoryChanger = PostCategoryChanger::getInstance();
$postCategoryChanger->changeCategory($targetWrId, $targetCategory);

// 분류별 게시물수 캐시 생성
na_cate_cnt($bo_table, $board, 1);

// 분류별 새게시물수 캐시 생성
na_cate_new($bo_table, $board, 1);
