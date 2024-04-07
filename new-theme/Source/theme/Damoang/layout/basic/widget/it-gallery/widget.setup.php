<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키], mo[배열키] 형태로 등록
// 기본은 wset[배열키], 모바일 설정은 mo[배열키] 형식을 가짐

// 위젯 설정 타입
$widget = 'item';

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
						썸네일 설정
					</label>
					<div class="col-md-4">
						<div class="input-group mb-2">
							<?php $wset['thumb_w'] = isset($wset['thumb_w']) ? $wset['thumb_w'] : 400; ?>
							<span class="input-group-text">썸네일 너비</span>
							<input type="text" name="wset[thumb_w]" value="<?php echo $wset['thumb_w'] ?>" class="form-control">
							<span class="input-group-text">px</span>
						</div>

						<div class="input-group mb-2">
							<?php $wset['thumb_h'] = isset($wset['thumb_h']) ? $wset['thumb_h'] : 300; ?>
							<span class="input-group-text">썸네일 높이</span>
							<input type="text" name="wset[thumb_h]" value="<?php echo $wset['thumb_h'] ?>" class="form-control">
							<span class="input-group-text">px</span>
						</div>

						<div class="input-group">
							<?php $wset['ratio'] = isset($wset['ratio']) ? $wset['ratio'] : 75; ?>
							<span class="input-group-text">썸네일 비율</span>
							<input type="text" name="wset[ratio]" value="<?php echo $wset['ratio'] ?>" class="form-control">
							<span class="input-group-text">%</span>
						</div>

					</div>
				</div>

				<div class="row gx-2 mb-2">
					<label class="col-md-2 col-form-label">
						이미지 없음
					</label>
					<div class="col-md-10">
						<?php $wset['no_img'] = isset($wset['no_img']) ? $wset['no_img'] : ''; ?>
						<div class="input-group">
							<span class="input-group-text">
								<a href="<?php echo G5_THEME_URL ?>/app/image.php?fid=no_img&amp;type=noimg" class="win_point">
									<i class="bi bi-image"></i>
								</a>
							</span>
							<input type="text" id="no_img" name="wset[no_img]" value="<?php echo $wset['no_img'] ?>" class="form-control" placeholder="https://...">
						</div>
					</div>
				</div>

				<div class="row gx-2">
					<label class="col-md-2 col-form-label">
						그리드 설정
					</label>
					<div class="col-md-10">
						<?php $wset['grid'] = isset($wset['grid']) ? $wset['grid'] : 'g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4'; ?>
						<textarea name="wset[grid]" rows="2" class="form-control"><?php echo (isset($wset['grid'])) ? $wset['grid'] : ''; ?></textarea>
						<div class="form-text">
							아이템 가로수 및 간격 등 설정
							<a href="https://getbootstrap.kr/docs/5.3/layout/grid/#%ed%96%89%ec%97%b4" target="_blank">
								※ 그리드 등 관련 내용은 부트스트랩 가이드 참고
								<i class="bi bi-box-arrow-up-right"></i>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</li>
</ul>
