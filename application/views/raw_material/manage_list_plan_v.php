<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 12px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }

    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-left-width: 0.4em;
        border-left-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-left-width: 0.4em;
        border-left-color: #bce8f1;
    }
</style>
<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/inspec_plan_c/"') ?>"><span><strong>Master Data Inspection Plan</strong></span></a></li>
            <li class="active"> <a href="#"><strong>List Inspection Plan</strong></a></li>
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
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>LIST INSPECTION PLAN - <?php echo $doc_id; ?></strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/') ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Back</a>
                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/add_list_plan/') . "/" . $doc_id ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Data Baru</a>
                        </div>
                    </div>

                    <div class="grid-body" style='font-size:11px;'>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Seq</th>
                                    <th style="text-align:center;">Check Point</th>
                                    <th style="text-align:center;">Type</th>
                                    <th style="text-align:center;">Recording</th>
                                    <th style="text-align:center;">Special Char</th>
                                    <th style="text-align:center;">Control</th>
                                    <th style="text-align:center;">Target SL</th>
                                    <th style="text-align:center;">Range SL</th>
                                    <th style="text-align:center;">LSL</th>
                                    <th style="text-align:center;">USL</th>
                                    <th style="text-align:center;">Uom (SL)</th>
                                    <th style="text-align:center;">Target CL</th>
                                    <th style="text-align:center;">Range CL</th>
                                    <th style="text-align:center;">LCL</th>
                                    <th style="text-align:center;">UCL</th>
                                    <th style="text-align:center;">Uom (CL)</th>
                                    <th style="text-align:center;">Qlt CL</th>
                                    <th style="text-align:center;">Qlt Val</th>
                                    <th style="text-align:center;">Sampling</th>
                                    <th style="text-align:center;">Frequency</th>
                                    <th style="text-align:center;">Strategy</th>
                                    <th style="text-align:center;">Repetition</th>
                                    <th style="text-align:center;">Test Equipment ID</th>
                                    <th style="text-align:center;">Remark</th>
                                    <th style="text-align:center;">Create Date</th>
                                    <th style="text-align:center;">Create By</th>
                                    <th style="text-align:center;">Change Date</th>
                                    <th style="text-align:center;">Change By</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $y = 1;
                                foreach ($data_qcwis as $isi) {
                                    echo "<tr>";
                                    echo "<td style='text-align:center;'>$isi->CHR_SEQ</td>";
                                    echo "<td style='text-align:left;'>$isi->CHR_CHECK_POINT</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_TYPE</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_RECORDING</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_SPECIAL_CHAR</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_CONTROL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_TARGET_SL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_RANGE_SL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_LSL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_USL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_UOM_SL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_TARGET_CL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_RANGE_CL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_LCL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_UCL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_UOM_CL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_QLT_CL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_QLT_VAL</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_SAMPLING</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_FREQ</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_STRATEGY</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_REPETITION</td>";
                                    if($isi->CHR_DEVICE_ID != NULL || $isi->CHR_DEVICE_ID != ""){
                                        $dbqua = $this->load->database("dbqua", TRUE);
                                        $get_device = $dbqua->query("SELECT * FROM TM_DEVICE WHERE CHR_DEVICE_ID = '$isi->CHR_DEVICE_ID'");
                                        if($get_device->num_rows() > 0){
                                            $device = $get_device->row();
                                            echo "<td style='text-align:center;'>$device->CHR_DEVICE_NAME</td>";
                                        } else {
                                            echo "<td style='text-align:center;'>-</td>";
                                        }
                                    } else {
                                        echo "<td style='text-align:center;'>-</td>";
                                    }                                    
                                    
                                    echo "<td style='text-align:center;'>$isi->CHR_REMARK</td>";
                                ?>
                                    <td style="text-align:center;">
                                        <?php echo date("d-M-Y", strtotime($isi->CHR_CREATE_DATE)) ?>
                                    </td>
                                    <?php
                                    echo "<td style='text-align:center;'>$isi->CHR_CREATE_BY</td>";
                                    ?>
                                    <?php if ($isi->CHR_CHANGE_DATE == '') { ?>
                                        <td style='text-align:center;'></td>
                                    <?php } else { ?>
                                        <td style="text-align:center;">
                                            <?php echo date("d-M-Y", strtotime($isi->CHR_CHANGE_DATE)) ?>
                                        </td>
                                    <?php } ?>
                                    <?php
                                    echo "<td style='text-align:center;'>$isi->CHR_CHANGE_BY</td>";
                                    ?>
                                    <?php if ($isi->CHR_STAT_DEL == 'F') { ?>
                                        <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                    <?php } else { ?>
                                        <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                    <?php } ?>
                                    <td style="text-align:center;">
                                        <a data-toggle="modal" data-target="#modal_<?php echo trim($isi->CHR_DOC_ID); ?>_<?php echo trim($isi->CHR_SEQ); ?>" class="label label-success" data-placement="left" title="Lihat Drawing"><span class="fa fa-eye"></span></a>
                                        <a href="<?php echo base_url('index.php/quality/inspec_plan_c/delete_list_plan') . "/" . trim($isi->CHR_DOC_ID) . "/" . trim($isi->CHR_SEQ) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Non-Aktifkan" onclick="return confirm('Yakin ingin non-aktifkan data?');"><span class="fa fa-times"></span></a>
                                        <a href="<?php echo base_url('index.php/quality/inspec_plan_c/undelete_list_plan') . "/" . trim($isi->CHR_DOC_ID) . "/" . trim($isi->CHR_SEQ) ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Aktif Ulang" onclick="return confirm('Yakin ingin aktifkan kembali data?');"><span class="fa fa-check"></span></a>
                                        <a href="<?php echo base_url('index.php/quality/inspec_plan_c/edit_list_plan') . "/" . trim($isi->CHR_DOC_ID) . "/" . trim($isi->CHR_SEQ) ?>" class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    </td>
                                    </tr>
                                <?php
                                    $y++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    foreach ($data_qcwis as $isi) {
                    ?>
                        <div class="modal fade" id="modal_<?php echo trim($isi->CHR_DOC_ID); ?>_<?php echo trim($isi->CHR_SEQ); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3"><strong>KEY POINT - (<?php echo trim($isi->CHR_CHECK_POINT) ?>)</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div style='text-align:center;'>
                                                <img id="myImg" alt="PIS Image" src="<?php echo 'http://192.168.0.231/AIS_PP/' . $isi->CHR_IMG_CHECK; ?>" width='600px' height='450px'>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [0, 'asc']
            ],
            fixedColumns: {
                leftColumns: 3,
                rightColumns: 2
            }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();
    });

    document.getElementById("uploadBtn").onchange = function() {
        document.getElementById("uploadFile").value = this.value;
    };
</script>