<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<ul class="list-group list-group-flush lh-lg mb-4">
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-3 col-lg-2 fw-bold">
				1. 설치
			</div>
			<div class="col-sm-9 col-lg-10">
				<ol>
					<li>신규/기존 나리야에서 업그레이드/아미나에서 업그레이드 모두 설치/설정 과정이 동일</li>
					<li><a href="https://sir.kr/g5_pds" target="_blank">그누보드/영카트 5.5.10 이상 버전 설치</a></li>
					<li><a href="https://amina.co.kr/1/download" target="_blank">나리야 다운로드</a></li>
					<li>다운받은 나리야 파일 압축푼 후 FTP로 설치된 그누의 각 폴더에 업로드
						<p class="small text-danger mb-0">
							※ 주의! 기존 나리야에서 업그레이드할 경우 /bbs 폴더 내 noti.php 파일 등 기존 나리야 파일을 덮어씀
						</p>
					</li>
					<li>관리자 > 환경설정 > 테마설정에서 나리야 테마(마리골드 테마) 지정</li>
					<li>관리자 > 나리야 > 나리야 설정 > DB관리에서 나리야 설치하기 실행</li>
					<li>나리야 설치 완료 후 나리야 설정 저장하기</li>
				</ol>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-3 col-lg-2 fw-bold">
				2. 스킨
			</div>
			<div class="col-sm-9 col-lg-10">
				<ol>
					<li>관리자 > 환경설정 > 기본환경설정과 관리자 > 게시판관리에서 각 스킨 변경
						<div class="table-responsive mt-1">
							<table class="table table-sm table-bordered text-nowrap">
							<thead>
							<tr>
								<td class="text-center bg-body-tertiary">구분</td>
								<td class="text-center bg-body-tertiary">PC 스킨</td>
								<td class="text-center bg-body-tertiary">모바일 스킨</td>
								<td class="text-center bg-body-tertiary">비고</td>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td class="text-center">최근 게시물</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
								<td>새글모음</td>
							</tr>
							<tr>
								<td class="text-center">검색 스킨</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
								<td>전체검색</td>
							</tr>
							<tr>
								<td class="text-center">접속자 스킨</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
								<td>현재 접속자</td>
							</tr>
							<tr>
								<td class="text-center">FAQ 스킨</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
							<td>자주하는 질문</td>
							</tr>
							<tr>
								<td class="text-center">회원 스킨</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
							<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="text-center">각 게시판 스킨</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
							<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="text-center">1:1문의</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
							<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="text-center">내용관리</td>
								<td class="text-center">(테마)basic</td>
								<td class="text-center">(테마)PC-Skin</td>
							<td>&nbsp;</td>
							</tr>
							</tbody>
							</table>
						</div>					
					</li>
					<li>쇼핑몰관리 > 쇼핑몰설정에서 쇼핑몰 PC 스킨을 (테마)basic 으로, 쇼핑몰 모바일 스킨을 (테마)basic 으로 변경</li>
				</ol>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-3 col-lg-2 fw-bold">
				3. 메뉴
			</div>
			<div class="col-sm-9 col-lg-10">
				<ol>
					<li>관리자 > 환경설정 > 메뉴설정에서 커뮤니티 메뉴 설정</li>
					<li>관리자 > 나리야 > 쇼핑몰 메뉴에서 쇼핑몰 메뉴 설정</li>
				</ol>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-3 col-lg-2 fw-bold">
				4. 게시판
			</div>
			<div class="col-sm-9 col-lg-10">
				<ol>
					<li>게시판 목록 상단의 관리자 아이콘 > 스킨 설정에서 게시판 목록 스타일(리스트, 갤러리, 웹진 등) 및 게시판 추가 기능 설정</li>
				</ol>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-3 col-lg-2 fw-bold">
				5. 내용관리
			</div>
			<div class="col-sm-9 col-lg-10">
				<ol>
					<li>내용관리 아이디(co_id)와 동일한 파일명의 php 파일을 테마 내 /page 폴더에 넣으면, 해당 php 파일이 출력됨</li>
				</ol>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-3 col-lg-2 fw-bold">
				6. 테마/위젯
			</div>
			<div class="col-sm-9 col-lg-10">
				<ol>
					<li>테마 내 /layout 폴더 내 각 레이아웃 내 폴더 및 파일에서 수정</li>
					<li>나리야는 테마 기반으로 작동하기 때문에 기존 테마의 역할을 현재는 테마 내 레이아웃(layout)에서 수행함</li>
				</ol>
			</div>
		</div>
	</li>

</ul>