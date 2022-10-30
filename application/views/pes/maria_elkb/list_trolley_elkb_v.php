<script>
    $(document).ready(function() {
        var table = $('#dataTables1').DataTable({
            processing: true
        });

        $('#btn_refresh').on('click', function() {
            $(".dataTables_processing").show();
            setTimeout(function() {

                table.draw();
                $(".dataTables_processing").hide();
            }, 1000);
        });

    });
</script>
<style type="text/css">
    #table-luar {
        font-size: 12px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
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

    input[type=checkbox].css-checkbox {
        position: absolute;
        z-index: -1000;
        left: -1000px;
        overflow: hidden;
        clip: rect(0 0 0 0);
        height: 1px;
        width: 1px;
        margin: -1px;
        padding: 0;
        border: 0;
    }

    input[type=checkbox].css-checkbox+label.css-label {
        padding-left: 30px;
        height: 25px;
        display: inline-block;
        line-height: 25px;
        background-repeat: no-repeat;
        background-position: 0 0;
        font-size: 12px;
        vertical-align: middle;
        cursor: pointer;
    }

    input[type=checkbox].css-checkbox:checked+label.css-label {
        background-position: 0 -25px;
    }

    label.css-label {
        background-image: url(http://csscheckbox.com/checkboxes/u/csscheckbox_391ce065f36b1460c4845fa9b5173fba.png);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/maria_elkb_c/trolley_data"') ?>"><strong>List Prod Nomor</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LIST PROD NOMOR</strong></span>
                        <!-- <div class="pull-right">
                            <a href="<?php echo base_url('index.php/pes/maria_elkb_c/create_data_trolley/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Create</a>
                        </div> -->
                    </div>


                    <div class="grid-body" style="padding-top: 10px">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>Prod Nomor</th>
                                        <th style='text-align:center;'>Part No</th>
                                        <th style='text-align:center;'>Back No</th>
                                        <th style='text-align:center;'>Line</th>
                                        <th style='text-align:center;'>Qty</th>
                                        <th style='text-align:center;'>Create D/T</th>
                                        <th style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_elina as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PRD_ORDER_NO</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PART_NO_FG</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_BACK_NO_FG</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_QTY_FG</td>";
                                        echo "<td style='text-align:center;'>" . date("d-M-Y", strtotime($isi->CHR_DATE_ORDER)) . " / " . date("H:i", strtotime($isi->CHR_TIME_ORDER)) . "</td>";
                                    ?>
                                        <td style='text-align:center;'>
                                            <a href="<?php echo base_url('index.php/pes/maria_elkb_c/reexplode') . "/" . trim($isi->INT_ID) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin ingin re-explode?');"><span class="fa fa-pencil"></span></a>

                                        </td>
                                        </tr>
                                    <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });

    document.getElementById("uploadBtn").onchange = function() {
        document.getElementById("uploadFile").value = this.value;
    };
</script>