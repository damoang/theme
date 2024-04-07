<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키], mo[배열키] 형태로 등록
// 기본은 wset[배열키], 모바일 설정은 mo[배열키] 형식을 가짐

?>
<ul class="list-group list-group-flush border-top">
	<li class="list-group-item">
		<div class="row gx-2">
			<label class="col-md-2 col-form-label">
				추출 대상
				<div class="form-text">
					콤마(,)로 구분해서 복수 등록 가능하며, 그룹 또는 복수 게시판 추출시 검색 가능한 게시판만 추출됨
				</div>
			</label>
			<div class="col-md-10">
				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						게시판그룹
					</label>
					<div class="col-md-10">
						<div class="input-group">
							<?php $wset['gr_list'] = isset($wset['gr_list']) ? $wset['gr_list'] : ''; ?>
							<input type="text" name="wset[gr_list]" value="<?php echo $wset['gr_list'] ?>" id="idInput<?php echo $idn ?>" class="form-control" placeholder="그룹아이디(gr_id)">
							<div class="input-group-text">
								<div class="form-check form-check-inline me-0">
									<?php $wset['gr_except'] = isset($wset['gr_except']) ? $wset['gr_except'] : ''; ?>
									<input class="form-check-input" type="checkbox" name="wset[gr_except]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $wset['gr_except'])?>>
									<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">제외</label>
								</div>
							 </div>
						</div>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						게시판
					</label>
					<div class="col-md-10">
						<div class="input-group">
							<?php $wset['bo_list'] = isset($wset['bo_list']) ? $wset['bo_list'] : ''; ?>
							<input type="text" name="wset[bo_list]" value="<?php echo $wset['bo_list'] ?>" id="idInput<?php echo $idn ?>" class="form-control" placeholder="게시판아이디(bo_table)">
							<div class="input-group-text">
								<div class="form-check form-check-inline me-0">
									<?php $wset['bo_except'] = isset($wset['bo_except']) ? $wset['bo_except'] : ''; ?>
									<input class="form-check-input" type="checkbox" name="wset[bo_except]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $wset['bo_except'])?>>
									<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">제외</label>
								</div>
							 </div>
						</div>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						글분류
					</label>
					<div class="col-md-10">
						<div class="input-group">
							<?php $wset['ca_list'] = isset($wset['ca_list']) ? $wset['ca_list'] : ''; ?>
							<input type="text" name="wset[ca_list]" value="<?php echo $wset['ca_list'] ?>" id="idInput<?php echo $idn ?>" class="form-control" placeholder="분류명(ca_name) - 단일게시판 추출시에만 작동">
							<div class="input-group-text">
								<div class="form-check form-check-inline me-0">
									<?php $wset['ca_except'] = isset($wset['ca_except']) ? $wset['ca_except'] : ''; ?>
									<input class="form-check-input" type="checkbox" name="wset[ca_except]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $wset['ca_except'])?>>
									<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">제외</label>
								</div>
							 </div>
						</div>
					</div>
				</div>

				<div class="row gx-2">
					<label class="col-md-2 col-form-label">
						회원
					</label>
					<div class="col-md-10">
						<div class="input-group">
							<?php $wset['mb_list'] = isset($wset['mb_list']) ? $wset['mb_list'] : ''; ?>
							<input type="text" name="wset[mb_list]" value="<?php echo $wset['mb_list'] ?>" id="idInput<?php echo $idn ?>" class="form-control" placeholder="회원아이디(mb_id)">
							<div class="input-group-text">
								<div class="form-check form-check-inline me-0">
									<?php $wset['mb_except'] = isset($wset['mb_except']) ? $wset['mb_except'] : ''; ?>
									<input class="form-check-input" type="checkbox" name="wset[mb_except]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $wset['mb_except'])?>>
									<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">제외</label>
								</div>
							 </div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row gx-2">
			<label class="col-md-2 col-form-label">
				추출 설정
			</label>
			<div class="col-md-10">
				<div class="row align-items-center gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						추출 옵션
					</label>
					<div class="col-md-10">
						<div class="form-check form-check-inline">
							<?php $wset['wr_notice'] = isset($wset['wr_notice']) ? $wset['wr_notice'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_notice]" id="wr_comment" value="1"<?php echo get_checked('1', $wset['wr_notice'])?>>
							<label class="form-check-label" for="wr_notice">공지글(최우선)</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['wr_comment'] = isset($wset['wr_comment']) ? $wset['wr_comment'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_comment]" id="wr_comment" value="1"<?php echo get_checked('1', $wset['wr_comment'])?>>
							<label class="form-check-label" for="wr_comment">코멘트</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['wr_image'] = isset($wset['wr_image']) ? $wset['wr_image'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_image]" id="wr_image" value="1"<?php echo get_checked('1', $wset['wr_image'])?>>
							<label class="form-check-label" for="wr_image">이미지</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['wr_video'] = isset($wset['wr_video']) ? $wset['wr_video'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_video]" id="wr_video" value="1"<?php echo get_checked('1', $wset['wr_video'])?>>
							<label class="form-check-label" for="wr_video">유튜브</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['wr_secret'] = isset($wset['wr_secret']) ? $wset['wr_secret'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_secret]" id="wr_secret" value="1"<?php echo get_checked('1', $wset['wr_secret'])?>>
							<label class="form-check-label" for="wr_secret">비밀글</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['wr_singo'] = isset($wset['wr_singo']) ? $wset['wr_singo'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_singo]" id="wr_singo" value="1"<?php echo get_checked('1', $wset['wr_singo'])?>>
							<label class="form-check-label" for="wr_singo">잠금글</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['wr_chadan'] = isset($wset['wr_chadan']) ? $wset['wr_chadan'] : ''; ?>
							<input class="form-check-input" type="checkbox" name="wset[wr_chadan]" id="wr_chadan" value="1"<?php echo get_checked('1', $wset['wr_chadan'])?>>
							<label class="form-check-label" for="wr_chadan">차단글</label>
						</div>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						PC 추출수
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['rows'] = isset($wset['rows']) ? $wset['rows'] : ''; ?>
							<input type="text" name="wset[rows]" value="<?php echo $wset['rows'] ?>" class="form-control">
							<span class="input-group-text">개</span>
						</div>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						모바일 추출수
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $mo['rows'] = isset($mo['rows']) ? $mo['rows'] : ''; ?>
							<input type="text" name="mo[rows]" value="<?php echo $mo['rows'] ?>" class="form-control">
							<span class="input-group-text">개</span>
						</div>
					</div>
				</div>

				<div class="row align-items-center gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						추출 페이지
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['page'] = isset($wset['page']) ? $wset['page'] : ''; ?>
							<input type="text" name="wset[page]" value="<?php echo $wset['page'] ?>" class="form-control">
							<span class="input-group-text">쪽</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-text my-1">
							PC/모바일 추출 목록수 기준 페이지
						</div>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						정렬 방법
					</label>
					<div class="col-md-4">
						<?php $wset['sort'] = isset($wset['sort']) ? $wset['sort'] : ''; ?>
						<select name="wset[sort]" class="form-select">
							<?php echo na_sort_options($wset['sort']);?>
						</select>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						추출 기간
					</label>
					<div class="col-md-4">
						<?php $wset['term'] = isset($wset['term']) ? $wset['term'] : ''; ?>
						<select name="wset[term]" class="form-select">
							<?php echo na_term_options($wset['term']);?>
						</select>
					</div>
				</div>

				<div class="row gx-2 align-items-center">
					<label class="col-md-2 col-form-label">
						일자 지정
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['dayterm'] = isset($wset['dayterm']) ? $wset['dayterm'] : ''; ?>
							<input type="text" name="wset[dayterm]" value="<?php echo $wset['dayterm'];?>" class="form-control">
							<span class="input-group-text">일</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-text my-1">
							추출 기간에서 일자 지정시 작동함
						</div>
					</div>
				</div>

			</div>
		</div>
	</li>

</ul>
