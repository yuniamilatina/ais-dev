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
                        <span class="grid-title"><strong>MASTER DATA INSPECTION PLAN</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/create_data/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 10px;">
                        <?php echo form_open('', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">
                                        <select id="e1" name="CHR_WC" class="form-control">
                                            <option value="">- Silahkan Pilih -</option>
                                            <?php
                                            foreach ($all_work_centers as $isi) {
                                            ?>
                                                <option value="<?php echo $isi->CHR_WORK_CENTER; ?>"><?php echo $isi->CHR_WORK_CENTER; ?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value="QUAR">Quality-Rec</option>
                                        </select>
                                    </td>
                                    <td width="90%"><button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="grid-body" style='font-size:11px;'>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">#</th>
                                    <th style="text-align:center;">DOC ID</th>
                                    <th style="text-align:center;">Line</th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">List Plan ?</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Part Name</th>
                                    <th style="text-align:center;">Model Name</th>
                                    <!-- <th style="text-align:center;">Drawing Part</th> -->
                                    <th style="text-align:center;">Execution By</th>
                                    <th style="text-align:center;">Inspection Type</th>
                                    <th style="text-align:center;">Issue Date</th>
                                    <th style="text-align:center;">Revised Date</th>
                                    <th style="text-align:center;">Create Date</th>
                                    <th style="text-align:center;">Change Date</th>
                                    <th style="text-align:center;">Change By</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                    <th style="text-align:center;">List Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($data_qcwis != NULL) {
                                    $y = 1;
                                    foreach ($data_qcwis as $isi) {
                                        echo "<tr>";
                                        echo "<td>$y</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DOC_ID</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_WORK_CTR</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PARTNO</td>";
                                ?>
                                        <?php if ($isi->CHR_STAT_LIST == 'T') { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                        <?php } ?>
                                        <?php
                                        echo "<td style='text-align:center;'>$isi->CHR_BACKNO</td>";
                                        echo "<td>$isi->CHR_PART_NM</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_MODEL_NM</td>";
                                        // echo "<td style='text-align:center;'><img id='myImg' alt='Drawing' src='" . base_url(trim($isi->CHR_DRAWING_LOC)) . "' width='55px' height='40px'></td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_EXEC_BY</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_INSPEC_TYPE</td>";
                                        ?>
                                        <td style="text-align:center;">
                                            <?php echo date("d-M-Y", strtotime($isi->CHR_ISSUE_DATE)) ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo date("d-M-Y", strtotime($isi->CHR_REVISED_DATE)) ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo date("d-M-Y", strtotime($isi->CHR_CREATE_DATE)) ?>
                                        </td>
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
                                            <a data-toggle="modal" data-target="#modal_<?php echo trim($isi->CHR_DOC_ID); ?>" class="label label-success" data-placement="left" title="Lihat Drawing"><span class="fa fa-file"></span></a>
                                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/del_plan_h') . "/" . $isi->CHR_DOC_ID; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Non-Aktifkan" onclick="return confirm('Yakin ingin non-aktifkan data?');"><span class="fa fa-times"></span></a>
                                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/undel_plan_h') . "/" . $isi->CHR_DOC_ID; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Aktif Ulang" onclick="return confirm('Yakin ingin aktifkan kembali data?');"><span class="fa fa-check"></span></a>
                                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/edit_plan') . "/" . trim($isi->CHR_DOC_ID) ?>" class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="<?php echo base_url('index.php/quality/inspec_plan_c/view_list_plan') . "/" . trim($isi->CHR_DOC_ID) ?>" class="label label-default" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></a>
                                            <?php if ($isi->CHR_STAT_LIST == 'F') { ?>
                                                <a href="<?php echo base_url('index.php/quality/inspec_plan_c/copy_list_plan') . "/" . trim($isi->CHR_DOC_ID) ?>" class="label label-info" data-placement="left" data-toggle="tooltip" title="Copy Data"><span class="fa fa-edit"></span></a>
                                            <?php } ?>
                                        </td>
                                        </tr>
                                <?php
                                        $y++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    if ($data_qcwis != NULL) {
                        foreach ($data_qcwis as $isi) {
                    ?>
                            <div class="modal fade" id="modal_<?php echo trim($isi->CHR_DOC_ID); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3"><strong>(<?php echo trim($isi->CHR_PARTNO) . ") - " . trim($isi->CHR_BACKNO) ?></strong>&nbsp;&nbsp; <?php echo substr($isi->CHR_PART_NM, 0, 20) ?> ...</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div style='text-align:center;'>
                                                    <?php if ($isi->CHR_DRAWING_LOC == NULL) { ?>
                                                        <!-- </?php if (strpos($isi->CHR_DRAWING_LOC, 'pdf') !== false) { ?> -->
                                                        <h1>NO PICTURE</h1>
                                                    <?php } else { ?>
                                                        <img id="myImg" alt="PIS Image" src="<?php echo 'http://192.168.0.231/AIS_PP/' . trim($isi->CHR_DRAWING_LOC); ?>" width='600px' height='450px'>
                                                    <?php } ?>
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
                leftColumns: 4,
                rightColumns: 2
            }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {});
        }).draw();
    });
</script>
<script>
    function yesnoCheck(that) {
        if (that.value == "Inprocess Stage") {
            document.getElementById("ifYes").style.display = "block";
        } else if (that.value == "") {
            document.getElementById("ifYes").style.display = "none";
        };
    }
</script>