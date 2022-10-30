<script>
    $(document).ready(function () {
        var table = $('#dataTables1').DataTable({
            processing: true
        });

        $('#btn_refresh').on('click', function () {
            $(".dataTables_processing").show();
            setTimeout(function () {

                table.draw();
                $(".dataTables_processing").hide();
            }, 1000);
        });

    });
</script>
<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    input[type=checkbox].css-checkbox {
        position:absolute; z-index:-1000; left:-1000px; overflow: hidden; clip: rect(0 0 0 0); 
        height:1px; width:1px; margin:-1px; padding:0; border:0;
    }

    input[type=checkbox].css-checkbox + label.css-label {
        padding-left:30px;
        height:25px; 
        display:inline-block;
        line-height:25px;
        background-repeat:no-repeat;
        background-position: 0 0;
        font-size:12px;
        vertical-align:middle;
        cursor:pointer;
    }

    input[type=checkbox].css-checkbox:checked + label.css-label {
        background-position: 0 -25px;
    }
    label.css-label {
        background-image:url(http://csscheckbox.com/checkboxes/u/csscheckbox_391ce065f36b1460c4845fa9b5173fba.png);
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
            <li><a href="<?php echo base_url('index.php/inventory/temp_part_c"') ?>"><strong>Manage Data Temp Part</strong></a></li>
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
                        <span class="grid-title"><strong>MASTER DATA TEMP PART</strong></span>
                       <div class="pull-right">
                            <a href="<?php echo base_url('index.php/inventory/temp_part_c/create_data_temp/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Create</a>
                        </div>
                    </div>
                    

                    <div class="grid-body" style="padding-top: 10px">
                        <div id="table-luar">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>Temp ID</th>
                                        <th style='text-align:center;'>PIC</th>
                                        <th style='text-align:center;'>Dept</th>
                                        <th style='text-align:center;'>Deskripsi</th>
                                        <th style='text-align:center;'>Start Date</th>
                                        <th style='text-align:center;'>Finish Date</th>
                                        <th style='text-align:center;'>Status Delete</th>
                                        <!-- <th style='text-align:center;'>Create D/T</th>
                                        <th style='text-align:center;'>Create By</th> -->
                                        <th style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_temp as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_TEMP_ID</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PIC</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DEPT</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DESC</td>";
                                        echo "<td style='text-align:center;'>".date("d-M-Y", strtotime($isi->CHR_START_DT))."</td>";
                                        echo "<td style='text-align:center;'>".date("d-M-Y", strtotime($isi->CHR_FINISH_DT))."</td>";
                                        // echo "<td style='text-align:center;'>".date("d-M-Y", strtotime($isi->CHR_DATE_CREATE))." / ".date("H:i", strtotime($isi->CHR_TIME_CREATE))."</td>";
                                        // echo "<td style='text-align:center;'>$isi->CHR_NPK_CREATE</td>";
                                        if($isi->CHR_FLAG_DEL=='T'){ ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                        <?php }
                                        ?>
                                    <td style='text-align:center;'>
                                        <a target='_blank' href="<?php echo base_url('index.php/inventory/temp_part_c/pdf_tempdt')."/". $isi->CHR_TEMP_ID; ?>" data-placement="left" data-toggle="tooltip" title="Download PDF" class="label label-default"><span class="fa fa-download"></span></a>
                                        <!-- <a href="<?php echo base_url('index.php/inventory/temp_part_c/edit_dt_temp') . "/" . $isi->CHR_TEMP_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Status Aktif"><span class="fa fa-pencil"></span></a> -->
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                        $(document).ready(function () {
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

                                        document.getElementById("uploadBtn").onchange = function () {
                                            document.getElementById("uploadFile").value = this.value;
                                        };
</script>