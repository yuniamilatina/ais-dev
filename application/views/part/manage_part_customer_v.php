
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
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
</style>

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
                    <div id="table-luar">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  style='vertical-align: middle;text-align:center;'>No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part No Cust</th>
                                    <!-- <th  style='vertical-align: middle;text-align:center;'>Cust Code</th> -->
                                    <th  style='vertical-align: middle;text-align:center;'>Part No Aisin</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Part Name</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Back No</th>
                                    <th  style='vertical-align: middle;text-align:center;'>Coordinate</th>
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
                                    echo "<td>$row->CHR_CUS_PART_NO</td>";
                                    // echo "<td>$row->CHR_CUS_NO</td>";
                                    echo "<td>$row->CHR_PART_NO</td>";
                                    echo "<td>$row->CHR_PART_NAME</td>";
                                    echo "<td>$row->CHR_BACK_NO</td>";
                                    if($row->INT_FLG_MODIFIED == 0){
                                        echo "<td style='text-align:center;'>NOT OK</td>";
                                    }else{
                                        echo "<td style='text-align:center;'>OK</td>";
                                    }
                                    if($row->INT_FLG_DELETE == 1){
                                        echo "<td class='bg bg-red' style='text-align:center;'>NON-AKTIF</td>";
                                    }else{
                                        echo "<td class='bg bg-green' style='text-align:center;'>AKTIF</td>";
                                    }
                                    
                                    ?>
                                <td  style='text-align:center;'>
                                    <a href="<?php echo base_url('index.php/part/part_customer_c/view_part_customer_wi') . "/" . trim($row->CHR_CUS_PART_NO); ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/part/part_customer_c/edit_part_customer_wi') . "/" . trim($row->CHR_CUS_PART_NO). "/" . $row->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>

                                    <?php
                                        if($row->INT_FLG_DELETE == 1){ ?>
                                            <a href="<?php echo base_url('index.php/part/part_customer_c/undelete_part_customer_wi') . "/" . trim($row->CHR_CUS_PART_NO) ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Non Active" onclick="return confirm('Are you sure want to non activing this part customer wi?');"><span class="fa fa-times"></span></a>
                                        <?php }else{ ?>
                                            <a href="<?php echo base_url('index.php/part/part_customer_c/delete_part_customer_wi') . "/" . trim($row->CHR_CUS_PART_NO) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Active" onclick="return confirm('Are you sure want to activing this part customer wi?');"><span class="fa fa-times"></span></a>
                                        <?php }
                                    ?>
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

        </div>


    </section>
</aside>


