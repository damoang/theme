<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

$widget = 'banner';
?>

<ul class="list-group">
    <li class="list-group-item">
        <div class="form-group row mb-0">
            <label class="col-sm-2 col-form-label">배너 설정</label>
            <div class="col-sm-10">
                <style>
                    #widgetData.table {
                        border-left: 0;
                        border-right: 0;
                    }

                    #widgetData thead th {
                        border-bottom: 0;
                    }

                    #widgetData th,
                    #widgetData td {
                        vertical-align: middle;
                        border-left: 0;
                        border-right: 0;
                    }
                </style>

                <p class="form-control-plaintext">
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                    이미지 주소 있는 것만 출력되며, 마우스 드래그로 위치 이동이 가능함
                </p>

                <div class="table-responsive">
                    <table id="widgetData" class="table table-bordered order-list mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center nw-20">이미지</th>
                                <th class="text-center nw-18">링크</th>
                                <th class="text-center">설명</th>
                                <th class="text-center nw-10">타켓</th>
                                <th class="text-center nw-4">삭제</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <?php

                            // 직접등록 입력폼
                            $data = array();
                            $data_cnt = (isset($wset['d']['img']) && is_array($wset['d']['img'])) ? count($wset['d']['img']) : 1;

                            for ($i = 0; $i < $data_cnt; $i++) {
                                $n = $i + 1;
                                $d_img = isset($wset['d']['img'][$i]) ? $wset['d']['img'][$i] : '';
                                $d_link = isset($wset['d']['link'][$i]) ? $wset['d']['link'][$i] : '';
                                $d_captitle = isset($wset['d']['captitle'][$i]) ? $wset['d']['captitle'][$i] : '';
                                $d_captitle_size = isset($wset['d']['captitle_size'][$i]) ? $wset['d']['captitle_size'][$i] : '';
                                $d_capdesc = isset($wset['d']['capdesc'][$i]) ? $wset['d']['capdesc'][$i] : '';
                                $d_capdesc_size = isset($wset['d']['capdesc_size'][$i]) ? $wset['d']['capdesc_size'][$i] : '';
                                $d_alt = isset($wset['d']['alt'][$i]) ? $wset['d']['alt'][$i] : '';
                                $d_target = isset($wset['d']['target'][$i]) ? $wset['d']['target'][$i] : '';

                                ?>
                                <tr class="bg-light<?php echo ($i % 2 != 0) ? '' : '-1'; ?>">
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="img_<?php echo $n ?>" name="wset[d][img][]" value="<?php echo $d_img ?>" class="form-control" placeholder="http://...">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" id="link_<?php echo $n ?>" name="wset[d][link][]" value="<?php echo $d_link ?>" class="form-control" placeholder="http://...">
                                    </td>
                                    <td>
                                        <input type="text" id="alt_<?php echo $n ?>" name="wset[d][alt][]" value="<?php echo $d_alt ?>" class="form-control">
                                    </td>
                                    <td>
                                        <select id="target_<?php echo $n ?>" name="wset[d][target][]" class="custom-select">
                                            <option value="_blank" <?php echo get_selected('_blank', $d_target) ?>>새 창</option>
                                            <option value="_self">현재 창</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($i > 0) { ?>
                                            <a href="javascript:;" class="ibtnDel"><i class="fa fa-times-circle fa-2x text-muted"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="row gx-2 mb-2">
                    <label class="col-md-2 col-form-label">
                        data-dd-action-name
                    </label>
                    <div class="col-md-10">
                        <input type="text" name="wset[action_name]" value="<?php echo $wset['action_name'] ?>" class="form-control" placeholder="배너 효율 측정용 action-name" />
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-primary btn-lg en" id="addrow">
                        배너 추가
                    </button>
                </div>
            </div>
        </div>
    </li>
</ul>

<script>
    $(document).ready(function () {
        var counter = <?php echo $data_cnt + 1 ?>;
        $("#addrow").on("click", function () {
            var trbg = (counter % 2 === 1) ? 'bg-light-1' : 'bg-light';
            var newRow = $("<tr class=" + trbg + ">");
            var cols = "";

            cols += '<td>';
            cols += '	<div class="input-group">';
            cols += '		<input type="text" id="img_' + counter + '" name="wset[d][img][]" class="form-control" placeholder="http://...">';
            cols += '	</div>';
            cols += '</td>';
            cols += '<td>';
            cols += '	<input type="text" id="link_' + counter + '" name="wset[d][link][]" class="form-control" placeholder="http://...">';
            cols += '</td>';
            cols += '<td>';
            cols += '	<input type="text" id="alt_' + counter + '" name="wset[d][alt][]" class="form-control">';
            cols += '</td>';
            cols += '<td>';
            cols += '	<select id="target_' + counter + '" name="wset[d][target][]" class="custom-select">';
            cols += '	<option value="_blank">새 창</option>';
            cols += '	<option value="_self">현재 창</option>';
            cols += '	</select>';
            cols += '</td>';
            cols += '<td class="text-center">';
            cols += '	<a href="javascript:;" class="ibtnDel"><i class="fa fa-times-circle fa-2x text-muted"></i></a>';
            cols += '</td>';

            newRow.append(cols);
            $("table.order-list").append(newRow);
            counter++;
        });

        $("table.order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
        });

        $("#sortable").sortable();
    });
</script>
