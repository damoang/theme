<?php
include_once('./_common.php');

if(!isset($nariya['kakaomap_key']) || !$nariya['kakaomap_key'])
	exit;

// 지도 초기값
$lat = isset($lat) ? $lat : '37.566535';
$lng = isset($lng) ? $lng : '126.977969';
$zoom = isset($zoom) ? $zoom : 16; // 구글맵
$marker = isset($marker) ? $marker : '';

$g5['title'] = '지도';
include_once(G5_PATH.'/head.sub.php');

include_once(G5_THEME_PATH.'/app/clipboard.php');

//다음 주소 js
add_javascript(G5_POSTCODE_JS, 0);
?>
<form id="fmap" name="fmap">
	<div class="input-group pt-2 mb-2">
		<input type="text" name="address" value="" id="address" class="form-control nofocus" placeholder="주소" readonly>
		<button type="button" class="btn btn-basic nofocus" id="btn_addr">
			주소 검색
		</button>
	</div>
	<input type="hidden" id="map_lat" value="<?php echo $lat ?>">
	<input type="hidden" id="map_lng" value="<?php echo $lng ?>">
	<input type="hidden" id="map_zoom" value="<?php echo $zoom ?>">

	<div class="input-group mb-3">
		<input type="text" name="marker" value="<?php echo $marker; ?>" id="map_marker" class="form-control nofocus" placeholder="마커 입력">
		<button type="button" class="btn btn-primary nofocus" onclick="map_submit()">
			코드 생성
		</button>
	</div>
</form>

<div id="map_canvas" class="w-100"></div>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $nariya['kakaomap_key'] ?>&libraries=services"></script>
<script>
function mapHeight() {
	let height = $('#naClipContent', parent.document).height() - $('#fmap').height() - 20;
	document.getElementById('map_canvas').style.height = height + "px";
}

mapHeight();

$(window).on('resize', function () {
	mapHeight();
});

var mapContainer = document.getElementById('map_canvas'), // 지도를 표시할 div 
	mapOption = {
		center: new daum.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>), // 지도의 중심좌표
		level: 3 // 지도의 확대 레벨
	};

// 지도를 생성
var map = new daum.maps.Map(mapContainer, mapOption);

// 주소-좌표 변환 객체 생성
var geocoder = new daum.maps.services.Geocoder();

// 마커
var marker = new daum.maps.Marker({
	map: map,
	// 지도 중심좌표에 마커를 생성
	position: map.getCenter()
});

// 클릭한 위치에 마커 표시하기
kakao.maps.event.addListener(map, 'click', function(mouseEvent) {        
	
	// 클릭한 위도, 경도 정보를 가져옵니다 
	var latlng = mouseEvent.latLng; 

	// 좌표값을 넣어준다.
	document.getElementById('map_lat').value = latlng.getLat();
	document.getElementById('map_lng').value = latlng.getLng();

	// 마커 위치를 클릭한 위치로 옮깁니다
	marker.setPosition(latlng);

});

// 주소검색 API (주소 > 좌표변환처리)
$(function() {
	$("#address, #btn_addr").on("click", function() {
		new daum.Postcode({
			oncomplete: function(data) {
				// console.log(data);
				$("#address").val(data.address);
				geocoder.addressSearch(data.address, function(results, status) {
					// 정상적으로 검색이 완료됐으면
					if (status === daum.maps.services.Status.OK) {

						// 첫번째 결과의 값을 활용
						var result = results[0];

						// 해당 주소에 대한 좌표를 받아서
						var latlng = new daum.maps.LatLng(result.y, result.x);

						// 지도를 보여준다.
						map.relayout();

						// 지도 중심을 변경한다.
						map.setCenter(latlng);

						// 좌표값을 넣어준다.
						document.getElementById('map_lat').value = latlng.getLat();
						document.getElementById('map_lng').value = latlng.getLng();

						// 마커를 결과값으로 받은 위치로 옮긴다.
						marker.setPosition(latlng);

					} else if (status === daum.maps.services.Status.ZERO_RESULT) {
						na_alert('찾으신 주소에 대한 좌표가 존재하지 않습니다.');
						return false;
					} else if (status === daum.maps.services.Status.ERROR) {
						na_alert('오류가 발생하였습니다.');
						return false;
					}
				});
			}
		}).open();
	});
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

function map_submit() {
	var code_lat = document.getElementById("map_lat").value;
	var code_lng = document.getElementById("map_lng").value;
	var code_zoom = document.getElementById("map_zoom").value;
	var code_marker = document.getElementById("map_marker").value;
	var code_place = document.getElementById("address").value;

	var code_geo = " geo=\"" + code_lat + "," + code_lng + "," + code_zoom + "\"";

	if(code_marker) 
		code_marker = " m=\"" + code_marker + "\"";

	if(code_place) 
		code_place = " p=\"" + code_place + "\"";

	var map_code = "{map: " + code_geo + code_marker + code_place + " }";

	<?php if($is_clip) { ?>
		$("#txtClip").val(map_code);
		$('#clipModal').modal('show');
	<?php } else { ?>
		parent.document.getElementById("wr_content").value += map_code;
		window.parent.naClipClose();
	<?php } ?>
}
</script>
<?php 
include_once(G5_PATH.'/tail.sub.php');