<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

$widget = 'banner';
?>

<ul class="list-group">
    <li class="list-group-item">
        <div class="form-group row mb-0">
            <label class="col-sm-2 col-form-label">로고 설정</label>
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
                    이미지 높이는 미입력시 48px
                </p>

                <div class="table-responsive">
                    <table id="widgetData" class="table table-bordered order-list mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center nw-20">이미지</th>
                                <th class="text-center nw-18">문구</th>
                                <th class="text-center nw-18">높이</th>
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
                                $d_alt = isset($wset['d']['alt'][$i]) ? $wset['d']['alt'][$i] : '';
                                $d_height = isset($wset['d']['height'][$i]) ? $wset['d']['height'][$i] : '';
                                ?>
                                <tr class="bg-light<?php echo ($i % 2 != 0) ? '' : '-1'; ?>">
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="img_<?php echo $n ?>" name="wset[d][img][]" value="<?php echo $d_img ?>" class="form-control" placeholder="http://...">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" id="alt_<?php echo $n ?>" name="wset[d][alt][]" value="<?php echo $d_alt ?>" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" id="height_<?php echo $n ?>" name="wset[d][height][]" value="<?php echo $d_height ?>" class="form-control">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </li>
</ul>
