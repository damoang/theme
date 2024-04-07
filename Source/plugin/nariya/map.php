<?php
include_once('./_common.php');

if(!isset($nariya['kakaomap_key']) || !$nariya['kakaomap_key'])
	exit;

// 좌표 정보
$arr = explode(",",$geo);
$lat = (isset($arr[0]) && $arr[0]) ? $arr[0] : '37.566535';
$lng = (isset($arr[1]) && $arr[1]) ? $arr[1] : '126.977969';
$zoom = (isset($arr[2]) && $arr[2]) ? $arr[2] : 13;
$marker = (isset($marker) && $marker) ? $marker : '자세히 보기';

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>카카오맵 보기</title>
<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/css/nariya.css" type="text/css">
<style>
	.customoverlay {position:relative;bottom:85px;border-radius:6px;border: 1px solid #ccc;border-bottom:2px solid #ddd;float:left;}
	.customoverlay:nth-of-type(n) {border:0; box-shadow:0px 1px 2px #888;}
	.customoverlay a {
		display:block;text-decoration:none;color:#000;text-align:center;border-radius:6px;font-size:14px;font-weight:bold;overflow:hidden;
		background: #d95050 url('https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/arrow_white.png') no-repeat right 14px center;
	}
	.customoverlay .title {display:block;text-align:center;background:#fff;margin-right:35px;padding:10px 15px;font-size:14px;font-weight:bold;}
	.customoverlay:after {
		content:'';position:absolute;margin-left:-12px;left:50%;bottom:-12px;width:22px;height:12px;background:url('https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/vertex_white.png')
	}
</style>
</head>
<body>
<div class="na-mapwrap" style="padding-bottom:56.25%;">
	<div id="map" class="na-map">
		<div id="map_canvas" class="na-canvas"></div>
	</div>
</div>
<script src="<?php echo G5_THEME_URL ?>/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $nariya['kakaomap_key'] ?>&libraries=services"></script>
<script>
var mapContainer = document.getElementById('map_canvas'), // 지도를 표시할 div 
  mapOption = { 
		center: new kakao.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>), // 지도의 중심좌표
		level: 3 // 지도의 확대 레벨
};

var map = new kakao.maps.Map(mapContainer, mapOption);

var imageSrc = 'https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_red.png', // 마커이미지의 주소입니다.
	imageSize = new kakao.maps.Size(64, 69), // 마커이미지의 크기입니다
	imageOption = {offset: new kakao.maps.Point(27, 69)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

// 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다.
var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
	markerPosition = new kakao.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>); // 마커가 표시될 위치입니다.

// 마커를 생성합니다
var marker = new kakao.maps.Marker({
  position: markerPosition,
  image: markerImage // 마커이미지 설정 
});

// 마커가 지도 위에 표시되도록 설정합니다.
marker.setMap(map);  

// 커스텀 오버레이에 표출될 내용으로 HTML 문자열이나 document element가 가능합니다.
var content = '<div class="customoverlay">' +
    '  <a href="https://map.kakao.com/link/map/<?php echo $marker ?>,<?php echo $lat ?>,<?php echo $lng ?>" target="_blank">' +
    '    <span class="title"><?php echo $marker ?></span>' +
    '  </a>' +
    '</div>';

// 커스텀 오버레이가 표시될 위치입니다.
var position = new kakao.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>);

// 커스텀 오버레이를 생성합니다.
var customOverlay = new kakao.maps.CustomOverlay({
	map: map,
	position: position,
	content: content,
	yAnchor: 1 
});

// 마커를 기준으로 가운데 정렬이 될 수 있도록 추가
var markerPosition = marker.getPosition(); 
map.relayout();
map.setCenter(markerPosition);

$(window).on('resize', function () {
	var markerPosition = marker.getPosition(); 
	map.relayout();
	map.setCenter(markerPosition)
});
</script>
</body>
</html>