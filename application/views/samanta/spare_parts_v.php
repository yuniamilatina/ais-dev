<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    #table-luar {
        font-size: 11px;
        padding-top: 10px;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c/'); ?>"><span><strong>Manage Spare Parts</strong></span></a></li>
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
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>MANAGE SPARE PARTS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%">
                                <tr>
                                    <td width="60%">
                                        <select class="ddl2" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_area as $row) { ?>
                                                <?php if (trim($row->LOCATION) == trim($area)) { ?>
                                                    <option value="<?php echo site_url('samanta/spare_parts_c/index/' . trim($row->LOCATION)); ?>" selected><?php echo $row->CHR_SLOC_DESC; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo site_url('samanta/spare_parts_c/index/' . trim($row->LOCATION)); ?>"><?php echo $row->CHR_SLOC_DESC; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width='40%' style='text-align:right;'>
                                        <a onclick="get_data_detail('<?php echo $area; ?>');" class="btn btn-primary" data-toggle="modal" data-target="#modalOrder" data-placement="left" title="Add Order"><i class="fa fa-reorder"></i>&nbsp;Add Order List</a>&nbsp;
                                        <a href="<?php echo base_url('index.php/samanta/spare_parts_c/create_sp/') ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Add Spare Part"><i class="fa fa-plus"></i>&nbsp;Add Spare Part</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id='table-luar'>
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Part No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Component</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Model</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Back No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Type</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Specification</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Price</th>
                                        <th colspan="4" style="text-align:center;">Qty</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Action</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center;">Used</th>
                                        <th style="text-align:center;">Min</th>
                                        <th style="text-align:center;">Max</th>
                                        <th style="text-align:center;">Actl</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) { ?>
                                        <tr class='gradeX'>
                                            <td style=text-align:center;><?php echo $i; ?></td>
                                            <?php if ($isi->CHR_PART_TYPE == '1') { ?>
                                                <td style='text-align:center;color:#FFF;font-weight:600;'><a style='cursor: pointer;' onclick="get_data_detail('<?php echo trim($isi->CHR_PART_NO); ?>');" class='badge bg-green' data-toggle="modal" data-target="#modal_<?php echo trim($isi->CHR_PART_NO); ?>" data-placement="left" title="View Rak"><?php echo $isi->CHR_PART_NO; ?></a></td>
                                            <?php } else if ($isi->CHR_PART_TYPE == '2') { ?>
                                                <td style=text-align:center;color:#FFF;font-weight:600;'><a style='cursor: pointer;' onclick="get_data_detail('<?php echo trim($isi->CHR_PART_NO); ?>');" class='badge bg-grey' data-toggle="modal" data-target="#modal_<?php echo trim($isi->CHR_PART_NO); ?>" data-placement="left" title="View Rak"><?php echo $isi->CHR_PART_NO; ?></a></td>
                                            <?php } else { ?>
                                                <td style='text-align:center;font-weight:600;color:#A2A2A2;'><a style='cursor: pointer;' onclick="get_data_detail('<?php echo trim($isi->CHR_PART_NO); ?>');" data-toggle="modal" data-target="#modal_<?php echo trim($isi->CHR_PART_NO); ?>" data-placement="left" title="View Rak"><?php echo $isi->CHR_PART_NO; ?></a></td>
                                            <?php } ?>

                                            <td style=text-align:left;><?php echo $isi->CHR_SPARE_PART_NAME; ?></td>
                                            <td style=text-align:center;><?php echo $isi->CHR_COMPONENT; ?></td>
                                            <td style=text-align:left;><?php echo $isi->CHR_MODEL; ?></td>
                                            <td style=text-align:center;><?php echo $isi->CHR_BACK_NO; ?></td>
                                            <td style=text-align:center;><?php echo $isi->CHR_TYPE; ?></td>
                                            <td style=text-align:left;><?php echo $isi->CHR_SPECIFICATION; ?></td>
                                            <td style=text-align:center;><?php echo number_format($isi->CHR_PRICE); ?></td>
                                            <td style=text-align:center;><?php echo $isi->INT_QTY_USE; ?></td>
                                            <td style=text-align:center;><?php echo $isi->INT_QTY_MIN; ?></td>
                                            <td style=text-align:center;><?php echo $isi->INT_QTY_MAX; ?></td>

                                            <?php if ($isi->INT_QTY_ACT < $isi->INT_QTY_MIN) {
                                                echo "<td style=text-align:center;><span class='badge bg-red'>$isi->INT_QTY_ACT</span></td>";
                                            } elseif ($isi->INT_QTY_ACT == $isi->INT_QTY_MIN) {
                                                echo "<td style=text-align:center;><span class='badge bg-yellow'>$isi->INT_QTY_ACT</span></td>";
                                            } else {
                                                echo "<td style=text-align:center;>$isi->INT_QTY_ACT</td>";
                                            }
                                            ?>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <a href='<?php echo base_url('index.php/samanta/spare_parts_c/goto_edit_sp') . '/' . trim($isi->INT_ID) ?>' class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <a href='<?php echo base_url('index.php/samanta/spare_parts_c/delete_sp') . '/' . trim($isi->INT_ID) ?>' class="label label-danger" data-placement="left" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="pull">
                            <table>
                                <tr>
                                    <td>Legend &nbsp;</td>
                                    <td><span class='badge bg-green'>Controlled by Accounting</span></td>
                                    <td><span class='badge bg-grey'>Special Part</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php
                    foreach ($data as $isi) {
                    ?>
                        <div class="modal fade" id="modal_<?php echo trim($isi->CHR_PART_NO); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" role="form" action="<?php echo base_url('#'); ?>" enctype="multipart/form-data" role="form">
                                            <div class="modal-header bg-primary">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3">(<?php echo trim($isi->CHR_PART_NO) . ")  -  <strong>" . trim($isi->CHR_SPARE_PART_NAME) ?></strong>&nbsp;</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="table-luar">
                                                    <table id="dataTables4" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th style="vertical-align: middle;text-align:center;">No</th>
                                                                <th style="vertical-align: middle;text-align:center;">Back No</th>
                                                                <th style="vertical-align: middle;text-align:center;">Alamat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="data_detail<?php echo trim($isi->CHR_PART_NO); ?>">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="modal fade" id="modalOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <?php echo form_open('samanta/spare_parts_c/saveOrderList', 'class="form-horizontal"'); ?>
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel3"><strong>Add Order List</strong></h4>
                                </div>
                                <div class="modal-body">

                                    <input type='hidden' name='area' value='<?php echo $area; ?>' class='form-control'></input>

                                    <div id="table-luar">
                                        <table id="dataTables1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">#</th>
                                                    <th style="text-align:center;">No</th>
                                                    <th style="text-align:center;">Part No</th>
                                                    <th style="text-align:center;">Name</th>
                                                    <th style="text-align:center;">Spesification</th>
                                                    <th style="text-align:center;">Model</th>
                                                    <th style="text-align:center;">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($data as $isi) { ?>
                                                    <tr class='gradeX'>
                                                        <td style='text-align:right;'><input class='icheck' type='checkbox' name='part_no[]' value='<?php echo $isi->CHR_PART_NO; ?>'></td>
                                                        <td style='text-align:center;'><?php echo $i; ?></td>
                                                        <td style='text-align:center;'><?php echo $isi->CHR_PART_NO; ?></td>
                                                        <td style='text-align:left;'><?php echo $isi->CHR_SPARE_PART_NAME; ?></td>
                                                        <td style='text-align:left;'><?php echo $isi->CHR_SPECIFICATION; ?></td>
                                                        <td style='text-align:left;'><?php echo $isi->CHR_MODEL; ?></td>
                                                        <td style='text-align:center;'><?php echo $isi->INT_QTY_USE; ?></td>
                                                    </tr>
                                                <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button> &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Submit this Order"><i class="fa fa-check"></i> Submit</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>ORDER LIST</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php echo form_open('samanta/spare_parts_c/publishOrderList', 'class="form-horizontal"'); ?>
                    <div class="grid-body">
                        <div id='table-luar'>
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Order No</th>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Name</th>
                                        <th style="text-align:center;">Component</th>
                                        <th style="text-align:center;">Model</th>
                                        <th style="text-align:center;">Specification</th>
                                        <th style="text-align:center;">Price</th>
                                        <th style="text-align:center;">Qty</th>
                                        <th style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_order as $isi) { ?>
                                        <tr class='gradeX'>
                                            <td style=text-align:center;><?php echo $i; ?></td>
                                            <td style='text-align:center;'><?php echo $isi->CHR_ORDER_NO; ?></td>
                                            <td style='text-align:center;'><?php echo $isi->CHR_PART_NO; ?></td>
                                            <td style=text-align:left;><?php echo $isi->CHR_SPARE_PART_NAME; ?></td>
                                            <td style=text-align:center;><?php echo $isi->CHR_COMPONENT; ?></td>
                                            <td style=text-align:left;><?php echo $isi->CHR_MODEL; ?></td>
                                            <td style=text-align:left;><?php echo $isi->CHR_SPECIFICATION; ?></td>
                                            <td style=text-align:center;><?php echo number_format($isi->CHR_PRICE); ?></td>
                                            <td style=text-align:center;><?php echo $isi->INT_QTY_ORDER ?></td>
                                            <td style="vertical-align: middle;text-align:center;">
                                                <a href='<?php echo base_url('index.php/samanta/spare_parts_c/goto_edit_sp') . '/' . trim($isi->INT_ID) ?>' class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <a href='<?php echo base_url('index.php/samanta/spare_parts_c/delete_sp') . '/' . trim($isi->INT_ID) ?>' class="label label-danger" data-placement="left" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-body" style="margin-top:20px;">
                        <div class="pull-right" style="margin-top:-40px;">
                            <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Publish</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>

<script>
    function get_data_detail(part_no) {
        $("#data_detail").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('samanta/spare_parts_c/view_detail_spare_parts'); ?>",
            data: "part_no=" + part_no,
            success: function(data) {
                $("#data_detail" + part_no).html(data);
            }
        });
    }
</script>