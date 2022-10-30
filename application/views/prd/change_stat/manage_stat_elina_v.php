<script>     var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                }
        , format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
                return c[p];
            })
        }
        return function (table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/change_status_elina_c/'); ?>"><span><strong>Explode by Digital Chute</strong></span></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title">Daftar Explode Material by Digital Chute</span>
                                               <div class="pull-right">
                                                    <!-- <input type="button" onclick="tableToExcel('exportToExcel', 'W3C Example Table')" value="Export to Excel" class="btn btn-primary"> -->
                                                    <?php echo form_open('prd/change_status_elina_c/export_explode_setup_chute', 'class="form-horizontal"'); ?>
                                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                                    <?php echo form_close() ?>
                                                </div>
                    </div>
                    <div class="grid-body">  
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Prod. No</th>
                                    <th>Sequence</th>
                                    <th style="text-align: center">Work Center</th>
                                    <th style="text-align: center">Part No</th>
                                    <th style="text-align: center">Back No</th>
                                    <th style="text-align: center">Qty Order(Box)</th>
                                    <th style="text-align: center">Qty Order(Pcs)</th>
                                    <th style="text-align: center">Area</th>
                                    <!-- <th style="text-align: center">Date Order</th>
                                    <th style="text-align: center">Time Order</th> -->
                                    <!--<th>Action</th>-->
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $btn = 'success';
                                    $color = NULL;
                                    $level = null;
                                    $late = NULL;
                                    // $id = $isi->INT_ID;

                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PRD_ORDER_NO</td>";
                                    echo "<td>$isi->CHR_SEQ</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_WORK_CT</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_BACK_NO</td>";
                                    echo "<td style='text-align: center'>$isi->INT_ORDER_BOX</td>";
                                    echo "<td style='text-align: center'>$isi->INT_ORDER_PCS</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_PREPARE_AREA</td>";
                                    ?>
                                    <!-- <?php if ($isi->CHR_PREPARE_AREA == 'A') { ?>
                                        <td>CKD ATAS</td>
                                    <?php } elseif ($isi->CHR_PREPARE_AREA == 'B') { ?>
                                        <td>OUTHOUSE</td>
                                    <?php } elseif ($isi->CHR_PREPARE_AREA == 'C') { ?>
                                        <td>INHOUSE</td>
                                    <?php } ?>     -->
                                    <!-- <td style="text-align: center"><?php echo date("d-m-Y", strtotime($isi->CHR_DATE_ORDER)); ?></td>
                                    <td style="text-align: center"><?php echo date("H:i", strtotime($isi->CHR_TIME_ORDER)); ?></td> -->
                                    <!--<td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/prd/change_status_elina_c/edit_data') . "/" . rtrim($isi->INT_ID) . "/" . rtrim($isi->CHR_PART_NO) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Data"><span class="fa fa-pencil"></span></a>                                        
                                    </td>-->                           
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                <th>No</th>
                                    <th>Prod. No</th>
                                    <th>Sequence</th>
                                    <th style="text-align: center">Work Center</th>
                                    <th style="text-align: center">Part No</th>
                                    <th style="text-align: center">Back No</th>
                                    <th style="text-align: center">Qty Order(Box)</th>
                                    <th style="text-align: center">Qty Order(Pcs)</th>
                                    <th style="text-align: center">Area</th>
                                    <!-- <th style="text-align: center">Date Order</th>
                                    <th style="text-align: center">Time Order</th> -->
                                    <!--<th>Action</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $btn = 'success';
                                    $color = NULL;
                                    $level = null;
                                    $late = NULL;
                                    // $id = $isi->INT_ID;

                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PRD_ORDER_NO</td>";
                                    echo "<td>$isi->CHR_SEQ</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_WORK_CT</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_BACK_NO</td>";
                                    echo "<td style='text-align: center'>$isi->INT_ORDER_BOX</td>";
                                    echo "<td style='text-align: center'>$isi->INT_ORDER_PCS</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_PREPARE_AREA</td>";
                                    ?>
                                    <!-- <?php if ($isi->CHR_PREPARE_AREA == 'A') { ?>
                                        <td>CKD ATAS</td>
                                    <?php } elseif ($isi->CHR_PREPARE_AREA == 'B') { ?>
                                        <td>OUTHOUSE</td>
                                    <?php } elseif ($isi->CHR_PREPARE_AREA == 'C') { ?>
                                        <td>INHOUSE</td>
                                    <?php } ?>     -->
                                    <!-- <td style="text-align: center"><?php echo date("d-m-Y", strtotime($isi->CHR_DATE_ORDER)); ?></td>
                                    <td style="text-align: center"><?php echo date("H:i", strtotime($isi->CHR_TIME_ORDER)); ?></td> -->
                                                              
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>