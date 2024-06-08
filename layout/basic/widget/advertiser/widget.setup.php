<?php
if (!defined('_GNUBOARD_'))
{
    exit;
}

$widget = 'advertiser';
?>

<ul class="list-group">
    <li class="list-group-item">
        <div class="form-group row mb-0">
            <label class="col-sm-2 col-form-label">페이지 설정</label>
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
                    긴 배너와 사이드배너는 현재 등록된 광고가 자동으로 표시되고 있습니다. 
                </p>

                <div class="table-responsive">
                    <table id="widgetData" class="table table-bordered order-list mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center nw-20">직접홍보 names</th>
                                <th class="text-center nw-4">삭제</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <?php

                            // 직접등록 입력폼
                            $data = array();
                            $data_cnt = (isset($wset['d']['names']) && is_array($wset['d']['names'])) ? count($wset['d']['names']) : 1;

                            for ($i = 0; $i < $data_cnt; $i++)
                            {
                                $n = $i + 1;
                                $d_names = isset($wset['d']['names'][$i]) ? $wset['d']['names'][$i] : '';


                            ?>
                                <tr class="bg-light<?php echo ($i % 2 != 0) ? '' : '-1'; ?>">
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="img_<?php echo $n ?>" name="wset[d][names][]" value="<?php echo $d_names ?>" class="form-control" placeholder="직홍게 이름 입력">
                                        </div>
                                    </td>
            
                                    <td class="text-center">
                                        <?php if ($i > 0)
                                        { ?>
                                            <a href="javascript:;" class="ibtnDel"><i class="fa fa-times-circle fa-2x text-muted"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>


                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-primary btn-lg en" id="addrow">
                        추가
                    </button>
                </div>
            </div>
        </div>
    </li>
</ul>

<script>
    $(document).ready(function() {
        var counter = <?php echo $data_cnt + 1 ?>;
        $("#addrow").on("click", function() {
            var trbg = (counter % 2 === 1) ? 'bg-light-1' : 'bg-light';
            var newRow = $("<tr class=" + trbg + ">");
            var cols = "";

            cols += '<td>';
            cols += '	<div class="input-group">';
            cols += '		<input type="text" id="img_' + counter + '" name="wset[d][names][]" class="form-control" placeholder="직홍게 이름 입력">';
            cols += '	</div>';
            cols += '</td>';
            cols += '<td class="text-center">';
            cols += '	<a href="javascript:;" class="ibtnDel"><i class="fa fa-times-circle fa-2x text-muted"></i></a>';
            cols += '</td>';

            newRow.append(cols);
            $("table.order-list").append(newRow);
            counter++;
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
            $(this).closest("tr").remove();
        });

        $("#sortable").sortable();
    });
</script>