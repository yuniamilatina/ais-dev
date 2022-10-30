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
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE GROUPING PART</strong></a></li>
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
                        <i class="fa fa-puzzle-piece"></i>
                        <span class="grid-title"><strong>MANAGE GROUPING PART</strong></span>
                        <div class="pull-right grid-tools">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary">Upload</button>
                            <!-- <a href="<?php echo base_url('index.php/patricia/master_spec_part_c/create_spec_part/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Create Data</a> -->
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 10px;">
                        <?php echo form_open('', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Group</td>
                                    <td width="10%">
                                        <select id="e1" name="CHR_GROUP" class="form-control">
                                            <option value="">- Silahkan Pilih -</option>
                                            <option value="OEM">OEM</option>
                                            <option value="AM">AM</option>
                                            <option value="GNP">GNP</option>
                                        </select>
                                    </td>
                                    <td width="60%"><button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="15%"></td>
                                    <td width="20%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </form>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='vertical-align: middle;text-align:center;'>No</th>
                                    <th style='vertical-align: middle;text-align:center;'>Part No</th>
                                    <th style='vertical-align: middle;text-align:center;'>Back No</th>
                                    <th style='vertical-align: middle;text-align:center;'>Group</th>
                                    <th style='vertical-align: middle;text-align:center;'>Create By</th>
                                    <th style='vertical-align: middle;text-align:center;'>Create D/T</th>
                                    <th style='vertical-align: middle;text-align:center;'>Update By</th>
                                    <th style='vertical-align: middle;text-align:center;'>Update D/T</th>
                                    <th style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($data != NULL) {
                                    $i = 1;
                                    foreach ($data as $row) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$i</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_PART_NO</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_BACK_NO</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_GROUP</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_CREATE_BY</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>" . date("d-M-Y", strtotime($row->CHR_CREATE_DATE)) . " / " . date("H:i", strtotime($row->CHR_CREATE_TIME)) . "</td>";
                                        if ($row->CHR_UPDATE_BY == NULL) { ?>
                                            <td style='text-align:center;'></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><?php echo $row->CHR_UPDATE_BY ?></td>
                                        <?php }
                                        if ($row->CHR_UPDATE_DATE == NULL) { ?>
                                            <td style='text-align:center;'></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><?php echo date("d-M-Y", strtotime($row->CHR_UPDATE_DATE)) . " / " . date("H:i", strtotime($row->CHR_UPDATE_TIME)) ?></td>
                                        <?php }
                                        ?>
                                        <td style='text-align:center;'>
                                            <a href="<?php echo base_url('index.php/patricia/master_spec_part_c/edit_groupfg') . '/' . trim($row->INT_ID); ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        </td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
        <div class="modal fade" id="modalPrimary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post" role="form" action="<?php echo base_url('index.php/patricia/master_spec_part_c/upload_data_group'); ?>" enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2">Upload Grouping Part FG</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/patricia/master_spec_part_c/generate_data_group'); ?>">Download Template Group FG</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Input File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_stock" id="import_stock" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
            // fixedColumns: {
            //     leftColumns: 0,
            //     rightColumns: 0
            // }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {});
        }).draw();
    });
</script>