
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE WORK CENTER</strong></a></li>
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
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>MANAGE WORK CENTER</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/direct_backflush_general_c/create_direct_backflush_general/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Work Center" style="height:30px;font-size:13px;width:100px;color:#000000;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='vertical-align: middle;text-align:center;'>No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Group Product</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Department</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Work Center</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Rotation Kanban (m)</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Flag Breakdown</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Status</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td  style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align: center'>$row->CHR_PRODUCT_GROUP</td>";
                                    echo "<td style='text-align: center'>$row->TYPE_PRODUCTION</td>";
                                    echo "<td style='text-align: center'>$row->CHR_WCENTER</td>";
                                    echo "<td style='text-align: center'>$row->CHR_REMARK</td>";
                                    echo "<td style='text-align: center'>$row->INT_FLG_BREAKDOWN</td>";
                                    echo "<td style='text-align: center'>$row->TYPE_ACTIVE</td>";
                                   
                                    ?>
                                <td  style='text-align:center;'>
                                    <a href="<?php echo base_url('index.php/prd/direct_backflush_general_c/edit_direct_backflush_general') . '/' . trim($row->INT_DEPT .'/'. $row->CHR_WCENTER); ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                </td>
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


