<?php
if (!defined('_GNUBOARD_')) exit;

function na_options($opt, $value) {

	$opt_cnt = count($opt);
	$options = '';
	for($i=0; $i < $opt_cnt; $i++) {
		if(isset($opt[$i][2]) && $opt[$i][2])
			$options .= '<optgroup label="'.$opt[$i][2].'">'.PHP_EOL;

		$options .= '<option value="'.$opt[$i][0].'"'.get_selected($opt[$i][0], $value).'>'.$opt[$i][1].'</option>'.PHP_EOL;

		if(isset($opt[$i][3]) && $opt[$i][3])
			$options .= '</optgroup>'.PHP_EOL;
	}

	return $options;
}

function na_options_color($opt, $value) {

	$opt_cnt = count($opt);
	$options = '';
	for($i=0; $i < $opt_cnt; $i++) {
		if(isset($opt[$i][2]) && $opt[$i][2])
			$options .= '<optgroup label="'.$opt[$i][2].'">'.PHP_EOL;

		$options .= '<option class="bg-'.$opt[$i][0].'" value="'.$opt[$i][0].'"'.get_selected($opt[$i][0], $value).'>'.$opt[$i][1].'</option>'.PHP_EOL;

		if(isset($opt[$i][3]) && $opt[$i][3])
			$options .= '</optgroup>'.PHP_EOL;
	}

	return $options;
}

function na_sort_options($value) {

	$opt = array();
	$opt[] = array('', '최근순');
	$opt[] = array('asc', '등록순');
	$opt[] = array('date', '날짜순');
	$opt[] = array('hit', '조회순');
	$opt[] = array('comment', '댓글순');
	$opt[] = array('good', '추천순');
	$opt[] = array('nogood', '비추천순');
	$opt[] = array('like', '추천-비추천순');
	$opt[] = array('rand', '랜덤');

	return na_options($opt, $value);
}

function na_item_options($value) {

	$opt = array();
	$opt[] = array('', '최근순');
	$opt[] = array('sales', '판매순');
	$opt[] = array('hit', '조회순');
	$opt[] = array('pricehigh', '낮은 가격순');
	$opt[] = array('pricelow', '높은 가격순');
	$opt[] = array('star', '평점높은순');
	$opt[] = array('use', '후기많은순');
	$opt[] = array('rand', '랜덤');

	return na_options($opt, $value);
}

function na_member_options($value) {

	$opt = array();
	$opt[] = array('point', '포인트');
	$opt[] = array('exp', '경험치');
	$opt[] = array('post', '글등록');
	$opt[] = array('comment', '댓글등록');
	$opt[] = array('new', '신규가입');
	$opt[] = array('recent', '최근접속');
	$opt[] = array('connect', '현재접속');

	return na_options($opt, $value);
}

function na_grade_options($value) {

	$options = '';
	for($i=10; $i > 0; $i--) {
		$options .= '<option value="'.$i.'"'.get_selected($i, $value).'>'.$i.'</option>'.PHP_EOL;
	}

	return $options;
}

function na_term_options($value) {

	$opt = array();
	$opt[] = array('', '사용안함');
	$opt[] = array('day', '일자 지정');
	$opt[] = array('today', '오늘');
	$opt[] = array('yesterday', '어제');
	$opt[] = array('week', '주간');
	$opt[] = array('month', '이번달');
	$opt[] = array('prev', '지난달');

	return na_options($opt, $value);
}

function na_skin_options($path, $dir, $value, $opt) {

	$path = $path.'/'.$dir;
	$skin = ($opt) ? na_skin_file_list($path, $opt) : na_skin_dir_list($path);
	$options = '';
	for ($i=0; $i<count($skin); $i++) {
		$options .= "<option value=\"".$skin[$i]."\"".get_selected($value, $skin[$i]).">".$skin[$i]."</option>\n";
	} 

	return $options;
}

function na_banner_options($value) {

	$opt = array();
	$opt[] = array('메인', '메인');
	$opt[] = array('왼쪽', '왼쪽');

	return na_options($opt, $value);
}

function na_rank_options($value) {

	$opt = array();
	$opt[] = array('', '표시안함');
	$opt[] = array('rounded-0', '박스형');
	$opt[] = array('rounded', '라운드형');
	$opt[] = array('rounded-pill', '써클형');
	$opt[] = array('rounded-0 rounded-end-circle', '우측써클');
	$opt[] = array('rounded-0 rounded-start-pill', '좌측써클');
	$opt[] = array('rounded-5 rounded-bottom-0', '상단써클');
	$opt[] = array('rounded-5 rounded-top-0', '하단써클');

	return na_options($opt, $value);
}

function na_bgcolor_options($value) {

	$opt = array();
	$opt[] = array('text-bg-primary', 'Primary');
	$opt[] = array('text-bg-secondary', 'Secondary');
	$opt[] = array('text-bg-success', 'Success');
	$opt[] = array('text-bg-danger', 'Danger');
	$opt[] = array('text-bg-warning', 'Warning');
	$opt[] = array('text-bg-info', 'Info');
	$opt[] = array('text-bg-light', 'Light');
	$opt[] = array('text-bg-dark', 'Dark');

	return na_options($opt, $value);
}