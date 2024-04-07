<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키], mo[배열키] 형태로 등록
// 기본은 wset[배열키], 모바일 설정은 mo[배열키] 형식을 가짐

// 위젯 설정 타입
$widget = 'banner';

?>
<ul class="list-group list-group-flush">
	<li class="list-group-item">

		<div class="row gx-2">
			<label class="col-md-2 col-form-label">
				출력 설정
			</label>
			<div class="col-md-10">

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						캐시 설정
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['cache'] = isset($wset['cache']) ? $wset['cache'] : '0'; ?>
							<input type="text" name="wset[cache]" value="<?php echo $wset['cache'] ?>" class="form-control">
							<span class="input-group-text">분</span>
						</div>
					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						배너 종류
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['position'] = isset($wset['position']) ? $wset['position'] : '메인'; ?>
							<select name="wset[position]" class="form-select">
								<?php echo na_banner_options($wset['position']) ?>>
							</select>
						</div>
					</div>
				</div>

				<div class="row align-items-center gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						배너 높이
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['height'] = isset($wset['height']) ? $wset['height'] : '100'; ?>
							<input type="text" name="wset[height]" value="<?php echo $wset['height'] ?>" class="form-control">
							<span class="input-group-text">vh</span>
						</div>
					</div>
				</div>

				<div class="row align-items-center gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						최소 높이
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['min_height'] = isset($wset['min_height']) ? $wset['min_height'] : '200'; ?>
							<input type="text" name="wset[min_height]" value="<?php echo $wset['min_height'] ?>" class="form-control">
							<span class="input-group-text">px</span>
						</div>
					</div>
				</div>

				<div class="row align-items-center gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						내용 위치
					</label>
					<div class="col-md-4">
						<div class="input-group">
							<?php $wset['align'] = isset($wset['align']) ? $wset['align'] : 'order'; ?>
							<select name="wset[content]" class="form-select">
								<option value="order"<?php echo get_selected('order', $wset['align']) ?>>순차적</option>
								<option value="rand"<?php echo get_selected('rand', $wset['align']) ?>>무작위</option>
								<option value="text-start"<?php echo get_selected('text-start', $wset['align']) ?>>왼쪽</option>
								<option value="text-center"<?php echo get_selected('text-center', $wset['align']) ?>>가운데</option>
								<option value="text-end"<?php echo get_selected('text-end', $wset['align']) ?>>오른쪽</option>
							</select>
						</div>
					</div>
				</div>

				<div class="form-text">
					<i class="bi bi-info-circle"></i>
					배너 등록시 테두리 사용함을 설정하면 해당 배너의 레스터 배경은 적용되지 않습니다.
				</div>

			</div>
		</div>
	</li>
</ul>
