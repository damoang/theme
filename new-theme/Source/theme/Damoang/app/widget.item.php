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
					상품 분류는 콤마(,)로 구분해서 최대 3개까지 복수 등록 가능하며, 상위 분류설정시 하위 분류는 자동 적용됨
				</div>
			</label>
			<div class="col-md-10">

				<div class="row align-items-center gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						상품유형
					</label>
					<div class="col-md-10 sit_icon">

						<div class="form-check form-check-inline">
							<?php $wset['type1'] = isset($wset['type1']) ? $wset['type1'] : ''; ?>
							<input class="form-check-input" type="checkbox" id="idCheck<?php echo $idn ?>" name="wset[type1]" value="1"<?php echo get_checked($wset['type1'], "1") ?>>
							<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">
								<span class="shop_icon shop_icon_1">히트</span>							
							</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['type2'] = isset($wset['type2']) ? $wset['type2'] : ''; ?>
							<input class="form-check-input" type="checkbox" id="idCheck<?php echo $idn ?>" name="wset[type2]" value="1"<?php echo get_checked($wset['type2'], "1") ?>>
							<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">
								<span class="shop_icon shop_icon_2">추천</span>
							</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['type3'] = isset($wset['type3']) ? $wset['type3'] : ''; ?>
							<input class="form-check-input" type="checkbox" id="idCheck<?php echo $idn ?>" name="wset[type3]" value="1"<?php echo get_checked($wset['type3'], "1") ?>>
							<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">
								<span class="shop_icon shop_icon_3">최신</span>
							</label>
						</div>

						<div class="form-check form-check-inline">
							<?php $wset['type4'] = isset($wset['type4']) ? $wset['type4'] : ''; ?>
							<input class="form-check-input" type="checkbox" id="idCheck<?php echo $idn ?>" name="wset[type4]" value="1"<?php echo get_checked($wset['type4'], "1") ?>>
							<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">
								<span class="shop_icon shop_icon_4">인기</span>
							</label>
						</div>
						
						<div class="form-check form-check-inline">
							<?php $wset['type5'] = isset($wset['type5']) ? $wset['type5'] : ''; ?>
							<input class="form-check-input" type="checkbox" id="idCheck<?php echo $idn ?>" name="wset[type5]" value="1"<?php echo get_checked($wset['type5'], "1") ?>>
							<label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">
								<span class="shop_icon shop_icon_5">할인</span>
							</label>
						</div>
					
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						상품분류
					</label>
					<div class="col-md-10">
						<?php $wset['ca_list'] = isset($wset['ca_list']) ? $wset['ca_list'] : ''; ?>
						<input type="text" name="wset[ca_list]" value="<?php echo $wset['ca_list'] ?>" id="idInput<?php echo $idn ?>" class="form-control" placeholder="상품분류(ca_id)를 콤마(,)로 구분해서 복수 등록">
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						상품지정
					</label>
					<div class="col-md-10">
						<?php $wset['it_list'] = isset($wset['it_list']) ? $wset['it_list'] : ''; ?>
						<textarea class="form-control" name="wset[it_list]" rows="4" placeholder="상품코드(it_id)를 콤마(,)로 구분해서 복수 등록"><?php echo $wset['it_list'] ?></textarea>
						<div class="form-text">
							※ 상품지정시 상품분류, 상품유형 설정을 포함해서 추출설정은 적용되지 않습니다.
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
							<?php echo na_item_options($wset['sort']);?>
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
