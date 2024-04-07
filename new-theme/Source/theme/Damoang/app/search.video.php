<?php
include_once('./_common.php');

if(!$is_admin)
	alert_close('관리자만 가능합니다.');

$youkey = (isset($nariya['youtube_key']) && $nariya['youtube_key']) ? $nariya['youtube_key'] : '';

if(!$youkey)
	alert_close('나리야 설정에서 유튜브 API 키를 등록해 주세요.');

$order = (isset($_REQUEST['order']) && $_REQUEST['order']) ? na_fid($_REQUEST['order']) : '';
$mode = (isset($_REQUEST['mode']) && $_REQUEST['mode']) ? na_fid($_REQUEST['mode']) : '';
$pg = (isset($_REQUEST['pg']) && $_REQUEST['pg']) ? na_fid($_REQUEST['pg']) : '';
$q = (isset($_REQUEST['q']) && $_REQUEST['q']) ? $_REQUEST['q'] : '';

if($mode === 'search') {

	$url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&order='.$order.'&maxResults=50&key='.$youkey.'&q='.urlencode($q).'&pageToken='.$pg;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	$json = curl_exec($ch);
	curl_close($ch);
	echo $json;
	exit;

} else if($mode === 'write') {

	if(!$bo_table)
		die(json_encode(array('msg' => '값이 제대로 넘어오지 않았습니다.')));

	$check = (isset($_POST['vid']) && is_array($_POST['vid'])) ? count($_POST['vid']) : 0;

	if(!$check)
		die(json_encode(array('msg' => '등록할 동영상을 선택해 주세요.')));

	$ids = implode(',', $_POST['vid']);

	$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.urlencode($ids).'&key='.$youkey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	$feed = json_decode(curl_exec($ch));
    curl_close($ch);

	$count = is_array($feed->items) ? count($feed->items) : 0;

	if($count) {

		// 등록자 정보
		$mb_id = $member['mb_id'];
		$wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
		$wr_password = '';
		$wr_email = addslashes($member['mb_email']);
		$wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
		$ca_name = isset($_POST['ca_name']) ? trim($_POST['ca_name']) : '';
		$wr_option = 'html1';
		$wr_num = 0;
		$wr_reply = '';
		$w = '';

		$boset['xp_write'] = isset($boset['xp_write']) ? (int)$boset['xp_write'] : 0;

		$j = 0;
		for($i=0; $i < $count; $i++){ 

			$item = $feed->items[$i]; 

			$id = trim($item->id);

			$wr_subject = trim($item->snippet->title);

			if(!$id || !$wr_subject) 
				continue;

			$wr_link1 = 'https://youtu.be/'.$id;

			$row = sql_fetch("select wr_id from $write_table where wr_link1 = '".addslashes($wr_link1)."'");

			// 이미 등록된 것이면 통과
			if(isset($row['wr_id']) && $row['wr_id']) 
				continue;

			$wr_seo_title = exist_seo_title_recursive('bbs', generate_seo_title($wr_subject), $write_table, $wr_id);
			
			$wr_content = nl2br(trim($item->snippet->description));

			// 유튜브
			$wr_9 = $wr_link1;

			// 이미지
			$video = array();
			$video['video_url'] = $wr_link1;
			$video['vid'] = $id;
			$video['type'] = 'youtube';

			$wr_10 = na_video_img($video);

			$sql = " insert into $write_table
						set wr_num = " . ($w == 'r' ? "'$wr_num'" : "(SELECT IFNULL(MIN(wr_num) - 1, -1) FROM $write_table sq) ") . ",
							 wr_reply = '$wr_reply',
							 wr_comment = 0,
							 ca_name = '$ca_name',
							 wr_option = '$wr_option',
							 wr_subject = '".addslashes($wr_subject)."',
							 wr_content = '".addslashes($wr_content)."',
							 wr_seo_title = '$wr_seo_title',
							 wr_link1 = '".addslashes($wr_link1)."',
							 wr_link1_hit = 0,
							 wr_link2_hit = 0,
							 wr_hit = 1,
							 wr_good = 0,
							 wr_nogood = 0,
							 mb_id = '{$member['mb_id']}',
							 wr_password = '$wr_password',
							 wr_name = '$wr_name',
							 wr_email = '$wr_email',
							 wr_homepage = '$wr_homepage',
							 wr_datetime = '".G5_TIME_YMDHIS."',
							 wr_last = '".G5_TIME_YMDHIS."',
							 wr_ip = '{$_SERVER['REMOTE_ADDR']}',
							 wr_9 = '$wr_9',
							 wr_10 = '$wr_10' ";
			sql_query($sql);

			$wr_id = sql_insert_id();

			// 부모 아이디에 UPDATE
			sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

			// 새글 INSERT
			sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id, wr_video, wr_image ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}', '{$wr_9}', '{$wr_10}' ) ");

			// 게시글 1 증가
			sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");

			// 포인트
	        insert_point($member['mb_id'], $board['bo_write_point'], "{$board['bo_subject']} {$wr_id} 글쓰기", $bo_table, $wr_id, '쓰기');

			// 경험치
			na_insert_xp($member['mb_id'], $boset['xp_write'], "{$board['bo_subject']} {$wr_id} 글쓰기", $bo_table, $wr_id, '쓰기');

			$j++;
		}

		// 분류별 게시물수 캐시 생성
		na_cate_cnt($bo_table, $board, 1);

		// 분류별 새게시물수 캐시 생성	
		na_cate_new($bo_table, $board, 1);

		// 새게시물 카운팅 캐시 생성
		na_post_new(1);

		die(json_encode(array('msg' => $j.'개의 동영상을 등록하였습니다.')));

	} else {

		die(json_encode(array('msg' => '등록 가능한 동영상이 없습니다.')));
	}

	exit;
}

$category_option = '';
if ($board['bo_use_category']) {
    $ca_name = "";
    if (isset($write['ca_name']))
        $ca_name = $write['ca_name'];
    $category_option = get_category_option($bo_table, $ca_name);
}

$g5['title'] = '동영상 검색 및 등록';
include_once(G5_PATH.'/head.sub.php');
?>
<script>
function search_video(page) {
	var items;
	var order = $('#searchorder option:selected').val();
	var next = $('#searchnext').val().trim();
	var prev = $('#searchprev').val().trim();
	var q = $('#searchquery').val().trim();
	var results = $('#videoList');

	var url = '<?php echo G5_THEME_URL ?>/app/search.video.php?mode=search&bo_table=' + g5_bo_table + '&order=' + order + '&q=' + encodeURI(q);

	// Page
	if(page == 'next') {
		if(next == '') {
			na_alert('마지막 페이지입니다.');
			return false;
		}
		url += '&pg=' + next;
	} else if(page == 'prev') {
		if(prev == '') {
			na_alert('처음 페이지입니다.');
			return false;
		}
		url += '&pg=' + prev;
	} else {
		url += '&pg=';
	}

	var html = '';
	var count = 0;
	$.get(url, function(data) {
		$('#searchnext').val(data.nextPageToken);
		$('#searchprev').val(data.prevPageToken);
		if (data.items) {
			items = data.items;
			items.forEach(function (item) {
				html += '<div class="col"><div class="card small h-100">';
				html += '<img src="' + item.snippet.thumbnails.high.url + '" class="card-img-top">';
				html += '<div class="d-flex flex-column justify-content-center text-center gap-2 p-3">';
				html += '<div><input class="form-check-input" type="checkbox" name="vid[]" id="vid-' + count + '" value="' + item.id.videoId + '"></div>'; 
				html += '<div><label for="vid-'+ count +'">'+ item.snippet.title +'</label></div>';
				html += '</div>';
				html += '</div></div>';
				count++;
			});
		}

		if (count === 0) {
			results.html('<div class="col text-center py-5">검색된 동영상이 없습니다.</div>');
		} else {
			results.html(html);
		}
	}, "json");
}

function write_video() {

	var url = '<?php echo G5_THEME_URL ?>/app/search.video.php';

	$.ajax({
		url : url,
		type : 'POST',
		cache : false,
		data : $("#fvideo").serialize(),
		dataType : "json",
		async: true,
		cache: false,
		success : function(data) {
			if(data.msg == '')
				data.msg = '오류가 발생했습니다.';

			na_alert(data.msg);
			return false;
		},
		error : function(request,status,error){
			let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
			na_alert(msg);
			return false;
		}
	});
}

$(function(){
	document.addEventListener('keydown', function(event) {
	  if (event.keyCode === 13) {
		event.preventDefault();
	  };
	}, true);
});
</script>

<form class="p-3 border-bottom bg-body-tertiary">
<input type="hidden" id="searchnext" name="searchnext" value="">
<input type="hidden" id="searchprev" name="searchprev" value="">
	<div class="row gx-3">
		<div class="col-2">
			<select id="searchorder" name="order" class="form-select">
				<option value="relevance">관련</option>
				<option value="date">최신</option>
				<option value="rating">추천</option>
				<option value="viewCount">조회</option>
				<option value="title">제목</option>
			</select>
		</div>
		<div class="col-7">
			<input hidden="hidden" />
			<input type="text" id="searchquery" name="q" value="" class="form-control">
		</div>
		<div class="col-3">
			<button type="button" class="btn btn-primary w-100" onclick="search_video();">
				<i class="bi bi-search"></i>
				검색
			</button>
		</div>
	</div>
</form>

<div class="p-3">
	<form id="fvideo" name="fvideo">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="mode" value="write">

		<div id="videoList" class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-colos-lg-4"></div>

		<div class="py-5"></div>

		<div class="fixed-bottom p-3 border-top bg-body-tertiary">
			<div class="row g-2">
				<div class="col">
					<button type="button" onclick="search_video('prev');" class="btn btn-basic w-100">
						이전
					</button>
				</div>
				<?php if ($category_option) { ?>
					<div class="col">
						<select name="ca_name" class="form-select">
							<?php echo $category_option ?>
						</select>
					</div>
				<?php } ?>
				<div class="col">
					<button type="button" class="btn btn-primary w-100" onclick="write_video();">
						<i class="bi bi-pencil"></i>
						등록하기
					</button>
				</div>
				<div class="col">
					<button type="button" onclick="search_video('next');" class="btn btn-basic w-100">
						다음
					</button>
				</div>
			</div>
		</div>
	</form>

</div>

<?php 
include_once(G5_PATH.'/tail.sub.php');