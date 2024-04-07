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
						슬라이드 옵션
					</label>
					<div class="col-md-10">
						<div class="alert alert-light small py-2 mb-2" role="alert">
							<b>※ 중요! 옵션 마지막에 반드시 콤마(,) 있어야 합니다. 없으면 스크립트 오류 발생!</b>
						</div>
						<?php
							$wset['option'] = isset($wset['option']) ? $wset['option'] : "
								loop:true,
								margin: 20,
								responsive:{
									0:{ items: 1, stagePadding: 60 },
									576:{ items: 2, stagePadding: 80 },
									768:{ items: 2, stagePadding: 100 },
									992:{ items: 3, stagePadding: 120 }
								}, ";
						?>
						<textarea name="wset[option]" rows="10" class="form-control"><?php echo $wset['option'] ?></textarea>
						<div class="form-text">
							<a href="https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html" target="_blank">
								※ 옵션 설정 방법은 Owl Carousel 사이트 참고
								<i class="bi bi-box-arrow-up-right"></i>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</li>
</ul>
