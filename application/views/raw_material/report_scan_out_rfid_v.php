<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'dd-mm-yy'
        }).val();
    });
</script>

<script>
    $(function() {
        $("#datepicker1").datepicker({
            dateFormat: 'dd-mm-yy'
        }).val();
    });
</script>

<script type="text/javascript" language="javascript" class="init">
    $.fn.dataTable.TableTools.defaults.aButtons = ["copy", "csv", "xls", "pdf"];
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'T<"clear">lfrtip',
            tableTools: {
                "sSwfPath": "<?php echo base_url(); ?>assets/swf/copy_csv_xls_pdf.swf"
            }
        });
    });
</script>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>MASTER DATA USER</strong></a></li>
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
                        <span class="grid-title">MASTER DATA USER QUINSA</span>
                        <!-- <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div> -->
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/raw_material/scan_out_rfid_rm_c/create_user/') ?>" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Employee" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">NPK</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Dept</th>
                                <th style="text-align: center;">Status Aktif</th>
                                <th style="text-align: center;">Option</th>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php
                                $no = 1;
                                foreach ($data as $val) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $val->CHR_NPK; ?></td>
                                        <td><?php echo $val->CHR_NAME; ?></td>
                                        <td><?php echo $val->CHR_DEPT; ?></td>
                                        <?php if ($val->CHR_STAT_DEL == 'F') { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                        <?php } ?>
                                        <td>
                                            <a href="<?php echo base_url('index.php/raw_material/scan_out_rfid_rm_c/edit_user') . "/" . trim($val->INT_ID) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                            <a href="<?php echo base_url('index.php/raw_material/scan_out_rfid_rm_c/delete_user') . "/" . trim($val->INT_ID) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin ingin non-aktif data?');"><span class="fa fa-times"></span></a>
                                            <a href="<?php echo base_url('index.php/raw_material/scan_out_rfid_rm_c/undel_user') . "/" . trim($val->INT_ID); ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Aktif Ulang" onclick="return confirm('Yakin ingin aktifkan kembali data?');"><span class="fa fa-check"></span></a>
                                        </td>
                                    <?PHP
                                    $no++;
                                }
                                    ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="grid-header">
                        <div class="pull-left">
                            <div class="form-group">
                                <div class="btn-group">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</aside>