<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<ul class="list-group list-group-flush border-bottom mb-0">
	<li class="list-group-item bg-body-tertiary">
		<b>스킨 설정</b>
	</li>
	<li class="list-group-item">
		<div class="row align-items-center gx-2">
			<label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">분류 스킨</label>
			<div class="col-md-4">
				<select id="idCheck<?php echo $idn; $idn++; ?>" name="boset[cate_skin]" class="form-select">
				<?php
					$boset['category_skin'] = isset($boset['category_skin']) ? $boset['category_skin'] : 'basic';
					$skinlist = na_dir_list($board_skin_path.'/category');
					for ($k=0; $k<count($skinlist); $k++) {
						echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['category_skin']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
					} 
				?>
				</select>				
			</div>
			<div class="col-md-6">
				<span class="form-text">
					보드스킨 내 /category 폴더
				</span>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row align-items-center gx-2">
			<label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">목록 스킨</label>
			<div class="col-md-4">
				<select id="idCheck<?php echo $idn; $idn++; ?>" name="boset[list_skin]" class="form-select">
				<?php
					$boset['list_skin'] = isset($boset['list_skin']) ? $boset['list_skin'] : 'list';
					$skinlist = na_dir_list($board_skin_path.'/list');
					for ($k=0; $k<count($skinlist); $k++) {
						echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['list_skin']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
					} 
				?>
				</select>				
			</div>
			<div class="col-md-6">
				<span class="form-text">
					보드스킨 내 /list 폴더
				</span>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row align-items-center gx-2">
			<label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">내용 스킨</label>
			<div class="col-md-4">
				<select id="idCheck<?php echo $idn; $idn++; ?>" name="boset[view_skin]" class="form-select">
				<?php
					$boset['view_skin'] = isset($boset['view_skin']) ? $boset['view_skin'] : 'basic';
					$skinlist = na_dir_list($board_skin_path.'/view');
					for ($k=0; $k<count($skinlist); $k++) {
						echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['view_skin']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
					} 
				?>
				</select>
			</div>
			<div class="col-md-6">
				<span class="form-text">
					보드스킨 내 /view 폴더
				</span>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<div class="row align-items-center gx-2">
			<label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">댓글 스킨</label>
			<div class="col-md-4">
				<select id="idCheck<?php echo $idn; $idn++; ?>" name="boset[comment_skin]" class="form-select">
				<?php
					$boset['comment_skin'] = isset($boset['comment_skin']) ? $boset['comment_skin'] : 'basic';
					$skinlist = na_dir_list($board_skin_path.'/comment');
					for ($k=0; $k<count($skinlist); $k++) {
						echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['comment_skin']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
					} 
				?>
				</select>		
			</div>
			<div class="col-md-6">
				<span class="form-text">
					보드스킨 내 /comment 폴더
				</span>
			</div>
		</div>
	</li>
</ul>