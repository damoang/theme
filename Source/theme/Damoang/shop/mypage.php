<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
// 사용안함
return;

$g5['title'] = '마이페이지';
include_once(G5_SHOP_PATH.'/_head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}
?>

<div id="mypage" class="row">
	<div class="col-sm-5 col-lg-3">
		<div class="sticky-top pb-4">

			<ul class="list-group list-group-flush">
				<li class="list-group-item line-bottom">
					<h2 class="fs-5 mb-0">내정보</h2>
				</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-center align-items-center mb-2">
						<div class="pe-2">
							<a href="<?php echo G5_BBS_URL ?>/myphoto.php" target="_blank" class="win_memo" title="내 사진 관리">
								<img src="<?php echo na_member_photo($member['mb_id']); ?>" class="rounded-circle" style="max-width:60px;">
							</a>
						</div>
						<div>
							<h4 class="mb-1 pb-0 fs-5">
								<strong style="letter-spacing:-1px;"><?php echo $member['sideview'] ?></strong>
							</h4>
							<?php echo ($member['mb_grade']) ? $member['mb_grade'] : $member['mb_level'].'등급'; ?>
						</div>
					</div>
					<div class="d-flex gap-2">
						<div class="flex-grow-1">
							<a href="#loginOffcanvas" class="btn btn-basic btn-sm w-100" data-bs-toggle="offcanvas" data-bs-target="#loginOffcanvas" aria-controls="loginOffcanvas">
								마이메뉴
								<i class="bi bi-arrow-bar-right"></i>
							</a>
						</div>
						<div>
				        	<a href="<?php echo G5_SHOP_URL ?>/coupon.php" target="_blank" class="win_coupon btn btn-basic btn-sm">
								<i class="bi bi-ticket"></i>
								쿠폰<?php echo $cp_count ? ' <b class="orangered">'.number_format($cp_count).'</b>' : ''; ?>
							</a>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<dl class="mb-0">
						<dt>연락처</dt>
						<dd><?php echo $member['mb_tel'] ? $member['mb_tel'] : '미등록'; ?></dd>
						<dt>E-Mail</dt>
						<dd><?php echo $member['mb_email'] ? $member['mb_email'] : '미등록'; ?></dd>
						<dt>최종접속일시</dt>
						<dd><?php echo $member['mb_today_login']; ?></dd>
						<dt>회원가입일시</dt>
						<dd><?php echo $member['mb_datetime']; ?></dd>
						<dt id="smb_my_ovaddt">주소</dt>
						<dd id="smb_my_ovaddd"><?php echo ($member['mb_zip1']) ? sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']) : '미등록'; ?></dd>
					</dl>
				</li>


			</ul>

		</div>
	</div>

	<div class="col-sm-7 col-lg-4">
		<div class="sticky-top pb-4">

			<ul class="list-group list-group-flush">
				<li class="list-group-item line-bottom">
					<div class="d-flex align-items-end gap-2">
						<div>
							<h2 class="fs-5 mb-0">주문내역</h2>
						</div>
						<div class="ms-auto small">
							<?php
								$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' ");
								$total_count = isset($row['cnt']) ? $row['cnt'] : 0;
							?>
							총 <?php echo number_format($total_count) ?> 건
						</div>
					</div>
				</li>
				<?php
				$result = sql_query(" select * from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' order by od_id desc limit 2 ");
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

					switch($row['od_status']) {
						case '주문':
							$od_status = '<span class="status_01">입금확인중</span>';
							break;
						case '입금':
							$od_status = '<span class="status_02">입금완료</span>';
							break;
						case '준비':
							$od_status = '<span class="status_03">상품준비중</span>';
							break;
						case '배송':
							$od_status = '<span class="status_04">상품배송</span>';
							break;
						case '완료':
							$od_status = '<span class="status_05">배송완료</span>';
							break;
						default:
							$od_status = '<span class="status_06">주문취소</span>';
							break;
					}
				?>
					<li class="list-group-item">
						<table class="table table-borderless table-sm mb-1">
						<tr>
							<th>주문번호</th>
							<td class="text-end">
								<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>
							</td>
						</tr>
						<tr>
							<th>주문일시</th> 
							<td class="text-end"><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
						</tr>
						<tr>
							<th>상품수</th> 
							<td class="text-end"><?php echo $row['od_cart_count']; ?>개</td>
						</tr>
						<tr>
							<th>주문금액</th> 
							<td class="text-end"><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
						</tr>
						<tr>
							<th>입금액</th> 
							<td class="text-end"><?php echo display_price($row['od_receipt_price']); ?></td>
						</tr>
						<tr>
							<th>미입금액</th> 
							<td class="text-end"><?php echo display_price($row['od_misu']); ?></td>
						</tr>
						<tr>
							<th>상태</th> 
							<td class="text-end">
								<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>">
									<?php echo $od_status; ?>
								</a>
							</td>
						</tr>
						</table>

						<a class="btn btn-basic btn-sm w-100" href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>">
							상세내역보기
							<i class="bi bi-arrow-bar-right"></i>
						</a>
					</tr>
					</li>
			    <?php } ?>
				<?php if(!$i) { ?>
					<li class="list-group-item py-5 text-center">
				        주문 내역이 없습니다
					</li>
			    <?php } ?>
				<li class="list-group-item text-end small">
					<a href="<?php echo G5_SHOP_URL ?>/orderinquiry.php">
						<i class="bi bi-arrow-right"></i>
						더보기
					</a>
				</li>
			</ul>



		</div>
	</div>

	<div class="col-md-12 col-lg-5">
		<div class="sticky-top pb-4">

			<div class="d-flex align-items-end gap-2 line-bottom px-3 py-2">
				<div>
					<h2 class="fs-5 mb-0">사용후기</h2>
				</div>
				<div class="ms-auto small">
					<?php
						$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_use_table']} where mb_id = '{$member['mb_id']}' ");
						$total_count = isset($row['cnt']) ? $row['cnt'] : 0;
					?>
					총 <?php echo number_format($total_count) ?> 개
				</div>
			</div>

			<div id="myis" class="accordion accordion-flush border-bottom">
			<?php
			$result = sql_query(" select * from {$g5['g5_shop_item_use_table']} where mb_id = '{$member['mb_id']}' order by is_id desc limit 4 ");
			for ($i=0; $row = sql_fetch_array($result); $i++) {

				$row = na_is_data($row, 400);
				$row['it'] = na_it_data(get_shop_item($row['it_id'], true));
				$thumb = na_thumb($row['it']['img'], 100, 100);

				$uid = 'myis'.$i;
			?>
				<div class="accordion-item">
					<h2 class="accordion-header">
						<a href="#<?php echo $uid ?>" class="accordion-button collapsed py-2" data-bs-toggle="collapse" data-bs-target="#<?php echo $uid ?>" aria-expanded="false" aria-controls="<?php echo $uid ?>">
							<div class="d-flex align-items-center gap-2 pe-2">
								<div>
									<img src="<?php echo $thumb ?>" alt="<?php echo $row['it']['name'] ?>" style="max-width:50px;">
								</div>
								<div>
									<div class="small text-body-secondary ellipsis-1 lh-lg">
										<span class="text-primary me-1">
											<?php echo $row['star'] ?>
											<strong class="visually-hidden">별 <?php echo $row['star_score'] ?> 개</strong>
										</span>
										<strong class="visually-hidden">후기 상품</strong>
										<?php echo $row['it']['name'] ?>
									</div>
									<div class="ellipsis-1">
										<?php if(!$row['is_confirm']) { ?>
											<span class="badge text-bg-secondary fw-normal">대기</span>
										<?php } ?>
										<strong class="visually-hidden">후기 제목</strong>
										<?php echo $row['subject'] ?>
									</div>
								</div>
							</div>
						</a>
					</h2>
					<div id="<?php echo $uid ?>" class="accordion-collapse collapse">
						<div class="accordion-body">
							<div class="small mb-2">
								<?php echo na_date($row['is_time'], 'orangered', 'Y.m.d H:i', 'Y.m.d H:i', 'Y.m.d H:i') ?>
							</div>
							<div class="mb-3">
								<strong class="visually-hidden">후기 내용</strong>
								<?php echo $row['content'] ?> 
							</div>
							<?php if($row['re_subject']) { // 답변 ?>
								<div class="d-flex border-top mt-2 pt-2">
									<div class="pe-2">
										<i class="bi bi-arrow-return-right"></i>
									</div>
									<div class="flex-grow-1">
										<strong class="visually-hidden">후기 답변</strong>
										<?php
											// echo $row['re_subject'];
											// echo $row['re_name']

											// 답변 내용만 출력함
											echo $row['re_content']
										?>
									</div>	
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>

			<div class="text-end small px-3 py-2 mb-4">
				<a href="<?php echo G5_SHOP_URL ?>/itemuselist.php?sfl=<?php echo urlencode('a.mb_id') ?>&amp;stx=<?php echo urlencode($member['mb_id']) ?>">
					<i class="bi bi-arrow-right"></i>
					더보기
				</a>
			</div>


			<div id="myiq" class="d-flex align-items-end gap-2 line-bottom px-3 py-2">
				<div>
					<h2 class="fs-5 mb-0">상품문의</h2>
				</div>
				<div class="ms-auto small">
					<?php
						$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_qa_table']} where mb_id = '{$member['mb_id']}' ");
						$total_count = isset($row['cnt']) ? $row['cnt'] : 0;
					?>
					총 <?php echo number_format($total_count) ?> 개
				</div>
			</div>

			<div class="accordion accordion-flush border-bottom">
			<?php
			$result = sql_query(" select * from {$g5['g5_shop_item_qa_table']} where mb_id = '{$member['mb_id']}' order by iq_id desc limit 4 ");
			for ($i=0; $row = sql_fetch_array($result); $i++) {

				$row = na_iq_data($row, 400);
				$row['it'] = na_it_data(get_shop_item($row['it_id'], true));
				$thumb = na_thumb($row['it']['img'], 100, 100);

				$uid = 'myiq'.$i;
			?>
				<div class="accordion-item">
					<h2 class="accordion-header">
						<a href="#<?php echo $uid ?>" class="accordion-button collapsed py-2" data-bs-toggle="collapse" data-bs-target="#<?php echo $uid ?>" aria-expanded="false" aria-controls="<?php echo $uid ?>">
							<div class="d-flex align-items-center gap-2 pe-2">
								<div>
									<img src="<?php echo $thumb ?>" alt="<?php echo $row['it']['name'] ?>" style="max-width:50px;">
								</div>
								<div>
									<div class="small text-body-secondary ellipsis-1 lh-lg">
										<span class="me-1">
											<?php echo $row['answer'] ? '답변완료 ' : '<span class="orangered">답변대기</span>'; // 답변 ?>
										</span>
										<strong class="visually-hidden">문의 상품</strong>
										<?php echo $row['it']['name'] ?>
									</div>
									<div class="ellipsis-1">
										<strong class="visually-hidden">문의 제목</strong>
										<?php echo $row['iq_secret'] ? '<span class="na-icon na-secret"></span>' : ''; // 비밀 ?>
										<?php echo $row['subject'] ?>
									</div>
								</div>
							</div>
						</a>
					</h2>
					<div id="<?php echo $uid ?>" class="accordion-collapse collapse">
						<div class="accordion-body">
							<div class="small mb-2">
								<?php echo na_date($row['iq_time'], 'orangered', 'Y.m.d H:i', 'Y.m.d H:i', 'Y.m.d H:i') ?>
							</div>
							<div class="mb-3">
								<strong class="visually-hidden">문의 내용</strong>
								<?php echo $row['question'] ?> 
							</div>
							<?php if($row['answer']) { // 답변 ?>
								<div class="d-flex border-top mt-2 pt-2">
									<div class="pe-2">
										<i class="bi bi-arrow-return-right"></i>
									</div>
									<div class="flex-grow-1">
										<strong class="visually-hidden">문의 답변</strong>
										<?php echo $row['answer'] ?>
									</div>	
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>

			<div class="text-end small px-3 py-2 mb-4">
				<a href="<?php echo G5_SHOP_URL ?>/itemqalist.php?sfl=<?php echo urlencode('a.mb_id') ?>&amp;stx=<?php echo urlencode($member['mb_id']) ?>">
					<i class="bi bi-arrow-right"></i>
					더보기
				</a>
			</div>

		</div>
	</div>
</div>

<?php
//썸네일 크기
$img_w = 400;
$img_h = 300;
$ratio = na_img_ratio($img_w, $img_h, '75');
?>
<style>
	#mywl .ratio { --bs-aspect-ratio: <?php echo $ratio ?>%; overflow:hidden; }
</style>
<ul id="mywl" class="list-group list-group-flush">
	<li class="list-group-item line-bottom">
		<div class="d-flex align-items-end gap-2">
			<div>
				<h2 class="fs-5 mb-0">위시리스트</h2>
			</div>
			<div class="ms-auto small">
				<?php
					$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_wish_table']} where mb_id = '{$member['mb_id']}' ");
					$total_count = isset($row['cnt']) ? $row['cnt'] : 0;
				?>
				총 <?php echo number_format($total_count) ?> 개
			</div>
		</div>
	</li>
	<li class="list-group-item py-3">

		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
		<?php
		$sql = " select *
				   from {$g5['g5_shop_wish_table']} a,
						{$g5['g5_shop_item_table']} b
				  where a.mb_id = '{$member['mb_id']}'
					and a.it_id  = b.it_id
				  order by a.wi_id desc
				  limit 0, 12 ";
		$result = sql_query($sql);
		for ($i=0; $row = sql_fetch_array($result); $i++) {

			$row = na_it_data($row);
			$row['thumb'] = na_thumb($row['img'], $img_w, $img_h);
		?>

			<div class="col">
				<div class="card h-100">
					<a href="<?php echo $row['href'] ?>" class="position-relative overflow-hidden">
						<div class="ratio card-img-top">
							<img src="<?php echo $row['thumb'] ?>" class="object-fit-cover" alt="<?php echo $row['name'] ?>">
						</div>
						<?php if($row['icon']) { ?>
							<div class="position-absolute start-0 bottom-0 p-3">
								<?php echo $row['icon'] ?>
							</div>
						<?php } ?>
						<?php if($row['soldout']) { ?>
							<div class="label-band text-bg-danger">SOLD OUT</div>
						<?php } ?>
					</a>
					<div class="card-body d-flex align-items-start flex-column">
						<div class="card-title">
							<h5 class="fs-6 lh-base m-0">
								<a href="<?php echo $row['href'] ?>">
									<?php echo $row['name'] ?>
								</a>
							</h5>
						</div>
						<?php if($row['content']) { ?>
							<div class="card-text small text-secondary ellipsis-2">
								<?php echo $row['content'] ?>
							</div>
						<?php } ?>
						<div class="mt-auto w-100 pt-4">
							<div class="d-flex align-items-end">
								<div>
									<?php if($row['star_score']) { ?>
										<div class="text-primary mb-1">
											<?php echo $row['star'] ?>
										</div>
									<?php } ?>
									<?php if($row['cur_price']) { ?>
										<div class="form-text text-decoration-line-through">
											<?php echo $row['cur_price'] ?>
										</div>
									<?php } ?>
								</div>
								<div class="ms-auto text-end">
									<strong class="fw-bold">
										<?php echo $row['price'] ?>
									</strong>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-center">
						<button type="button" onclick="na_cart('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="장바구니">
							<i class="bi bi-cart"></i>
							<span class="visually-hidden">장바구니</span>
						</button>
						<button type="button" onclick="na_use('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="사용후기">
							<i class="bi bi-chat-square-text"></i>
							<span class="visually-hidden">사용후기</span>
						</button>
						<button type="button" onclick="na_qa('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="상품문의">
							<i class="bi bi-pencil-square"></i>
							<span class="visually-hidden">상품문의</span>
						</button>
						<button type="button" onclick="na_sns_share('<?php echo na_seo_text($row['name']) ?>', '<?php echo $row['href'] ?>', '<?php echo $row['img'] ?>');" class="btn btn-basic btn-sm" title="SNS 공유">
							<i class="bi bi-share-fill"></i>
							<span class="visually-hidden">SNS 공유</span>
						</button>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if ($i == 0) { ?>
			<div class="text-center py-5">보관 내역이 없습니다.</div>
		<?php } ?>
		</div>
	</li>
	<li class="list-group-item text-end small">
		<a href="<?php echo G5_SHOP_URL ?>/wishlist.php">
			<i class="bi bi-arrow-right"></i>
			더보기
		</a>
	</li>
</ul>

<?php
include_once(G5_SHOP_PATH."/_tail.php");