
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE PART CUSTOMER WI</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE PART CUSTOMER WI</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/part/part_customer_c/create_part_customer_wi/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Part Cust. WI" style="height:30px;font-size:13px;width:100px;color:#000000;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='vertical-align: middle;text-align:center;'>No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part No Customer</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part Name</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Back No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Coordinate</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $row) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td  style='text-align:center;'>$i</td>";
                                    echo "<td>$row->CHR_CUS_PART_NO</td>";
                                    echo "<td>$row->CHR_PART_NO</td>";
                                    echo "<td>$row->CHR_PART_NAME</td>";
                                    echo "<td>$row->CHR_BACK_NO</td>";
                                    if($row->INT_FLG_MODIFIED == 0){
                                        echo "<td class='bg bg-red' style='text-align:center;'>NG</td>";
                                    }else{
                                        echo "<td class='bg bg-green' style='text-align:center;'>OK</td>";
                                    }
                                    
                                    ?>
                                <td  style='text-align:center;'>
                                    <a href="<?php echo base_url('index.php/part/part_customer_c/view_part_customer_wi') . "/" . $row->CHR_CUS_PART_NO; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/part/part_customer_c/edit_part_customer_wi') . "/" . $row->CHR_CUS_PART_NO; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/part/part_customer_c/delete_part_customer_wi') . "/" . $row->CHR_CUS_PART_NO ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this part customer wi?');"><span class="fa fa-times"></span></a>
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


