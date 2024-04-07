<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 레이아웃 스킨
if(is_file(LAYOUT_PATH.'/shop/couponzone.10.skin.php')) {
	include_once(LAYOUT_PATH.'/shop/couponzone.10.skin.php');
	return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);

?>

<section class="couponzone-list mb-4">
	<h2 class="fs-4 px-3 py-2 mb-0">
		다운로드 쿠폰
	</h2>
	<ul class="list-group list-group-flush line-top">
		<li class="list-group-item bg-body-tertiary">
			<?php echo $default['de_admin_company_name']; ?> 회원이시라면 쿠폰 다운로드 후 바로 사용하실 수 있습니다.
		</li>
		<li class="list-group-item">
			<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
			<?php
				$result = sql_query(" select * $sql_common and cz_type = '0' $sql_order ");
				for($i=0; $row=sql_fetch_array($result); $i++) {

					if(!$row['cz_file'])
						continue;

					$img_file = G5_DATA_PATH.'/coupon/'.$row['cz_file'];

					if(!is_file($img_file))
						continue;

					$subj = get_text($row['cz_subject']);
					
					switch($row['cp_method']) {
						case '0':
							$row3 = get_shop_item($row['cp_target'], true);
							$cp_target = '개별상품할인';
							$cp_link ='<a href="'.shop_item_url($row3['it_id']).'" target="_blank">'.get_text($row3['it_name']).'</a>';
							break;
						case '1':
							$row3 = sql_fetch(" select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ");
							$cp_target = '카테고리할인';
							$cp_link = '<a href="'.shop_category_url($row3['ca_id']).'" target="_blank">'.get_text($row3['ca_name']).'</a>';
							break;
						case '2':
							$cp_target = '주문금액할인';
							$cp_link = '';
							break;
						case '3':
							$cp_target = '배송비할인';
							$cp_link = '';
							break;
					}

					// 다운로드 쿠폰인지
					$disabled = (is_coupon_downloaded($member['mb_id'], $row['cz_id'])) ? ' disabled' : '';

					// $row['cp_type'] 값이 있으면 % 이며 없으면 원 입니다.
					$print_cp_price = $row['cp_type'] ? '<b>'.$row['cp_price'].'</b> %' : '<b>'.number_format($row['cp_price']).'</b> 원';

				?>
					<div class="col">

						<div class="card h-100">
							<div class="position-relative overflow-hidden">
								<div class="ratio card-img-top">
									<img src="<?php echo str_replace(G5_PATH, G5_URL, $img_file) ?>" class="object-fit-cover" alt="<?php echo $subj ?>">
								</div>
								<?php if($disabled) { ?>
									<div class="label-band text-bg-danger">DOWNLOAD</div>
								<?php } ?>
							</div>
							<div class="card-body d-flex flex-column">
								<div class="card-title">
									<h4 class="fs-5 ellipsis-2 lh-base m-0">
										<?php echo $subj ?>
									</h4>
								</div>
								<div class="mt-auto w-100">
									<div class="d-flex align-items-end">
										<div>
											<?php echo $cp_target ?>
										</div>
										<div class="ms-auto text-end">
											<?php echo $print_cp_price ?>
										</div>
									</div>
								</div>
							</div>
							<ul class="list-group list-group-flush">
								<?php if($cp_link) { ?>
									<li class="list-group-item">
										<?php echo $cp_link ?>
									</li>
								<?php } ?>
								<?php if($row['cp_minimum']){   // 쿠폰에 최소주문금액이 있다면 ?>
									<li class="list-group-item clearfix">
										최소주문금액 
										<span class="float-end"><b><?php echo number_format($row['cp_minimum']) ?></b>원</span>
									</li>
								<?php } ?>
								<li class="list-group-item clearfix">
									다운로드 후 <?php echo number_format($row['cz_period']) ?>일 기한
								</li>
							</ul>
							<div class="card-footer text-center">
								<button type="button" class="coupon_download btn btn-primary btn-sm<?php echo $disabled ?>" data-cid="<?php echo $row['cz_id'] ?>">
									쿠폰 다운로드
								</button>
							</div>
						</div>

					</div>
				<?php } ?>
				<?php if(!$i) { ?>
					<div class="col-12 text-center py-5">
						사용할 수 있는 쿠폰이 없습니다.
					</div>
				<?php } ?>
			</div>
		</li>
	</ul>
</section>

<section class="couponzone-list" id="point_coupon">
	<h2 class="fs-4 px-3 py-2 mb-0">
		포인트 쿠폰
	</h2>
	<ul class="list-group list-group-flush line-top">
		<li class="list-group-item bg-body-tertiary">
			보유하신 <?php echo $default['de_admin_company_name']; ?> 회원 포인트를 쿠폰으로 교환하실 수 있습니다.
		</li>
		<li class="list-group-item">
			<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
			<?php
				$result = sql_query(" select * $sql_common and cz_type = '1' $sql_order ");

				for($i=0; $row=sql_fetch_array($result); $i++) {

					if(!$row['cz_file'])
						continue;

					$img_file = G5_DATA_PATH.'/coupon/'.$row['cz_file'];

					if(!is_file($img_file))
						continue;

					$subj = get_text($row['cz_subject']);

					switch($row['cp_method']) {
						case '0':
							$row3 = get_shop_item($row['cp_target'], true);
							$cp_link = '<a href="'.shop_item_url($row3['it_id']).'" target="_blank">'.get_text($row3['it_name']).'</a>';
							$cp_target = '개별상품할인';
							break;
						case '1':
							$row3 = sql_fetch(" select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ");
							$cp_link = '<a href="'.shop_category_url($row3['ca_id']).'" target="_blank">'.get_text($row3['ca_name']).'</a>';
							$cp_target = '카테고리할인';
							break;
						case '2':
							$cp_link = '';
							$cp_target = '주문금액할인';
							break;
						case '3':
							$cp_link = '';
							$cp_target = '배송비할인';
							break;
					}

					// 다운로드 쿠폰인지
					$disabled = (is_coupon_downloaded($member['mb_id'], $row['cz_id'])) ? ' disabled' : '';

					// $row['cp_type'] 값이 있으면 % 이며 없으면 원 입니다.
					$print_cp_price = $row['cp_type'] ? '<b>'.$row['cp_price'].'</b> %' : '<b>'.number_format($row['cp_price']).'</b> 원';
			?>
					<div class="col">

						<div class="card h-100">
							<div class="position-relative overflow-hidden">
								<div class="ratio card-img-top">
									<img src="<?php echo str_replace(G5_PATH, G5_URL, $img_file) ?>" class="object-fit-cover" alt="<?php echo $subj ?>">
								</div>
								<?php if($disabled) { ?>
									<div class="label-band text-bg-danger">DOWNLOAD</div>
								<?php } ?>
							</div>
							<div class="card-body d-flex align-items-start flex-column">
								<div class="card-title">
									<h4 class="fs-5 ellipsis-2 lh-base m-0">
										<?php echo $subj ?>
									</h4>
								</div>
								<div class="mt-auto w-100">
									<div class="d-flex align-items-end">
										<div>
											<?php echo $cp_target ?>
										</div>
										<div class="ms-auto text-end">
											<?php echo $print_cp_price ?>
										</div>
									</div>
								</div>
							</div>
							<ul class="list-group list-group-flush">
								<?php if($cp_link) { ?>
									<li class="list-group-item">
										<?php echo $cp_link ?>
									</li>
								<?php } ?>
								<?php if($row['cp_minimum']){   // 쿠폰에 최소주문금액이 있다면 ?>
									<li class="list-group-item clearfix">
										최소주문금액 
										<span class="float-end"><b><?php echo number_format($row['cp_minimum']) ?></b>원</span>
									</li>
								<?php } ?>
								<li class="list-group-item clearfix">
									다운로드 후 <?php echo number_format($row['cz_period']) ?>일 기한
								</li>
							</ul>
							<div class="card-footer text-center">
								<button type="button" class="coupon_download btn btn-primary btn-sm<?php echo $disabled ?>" data-cid="<?php echo $row['cz_id'] ?>">
									포인트 <?php echo number_format($row['cz_point']) ?>점 차감
								</button>
							</div>
						</div>

					</div>
				<?php } ?>
				<?php if(!$i) { ?>
					<div class="col-12 text-center py-5">
						사용할 수 있는 쿠폰이 없습니다.
					</div>
				<?php } ?>
			</div>
		</li>
	</ul>
</section>
