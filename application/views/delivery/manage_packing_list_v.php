<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }
</style>

<script>
    $(function() {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>
<script>
    $(function() {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/delivery/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/delivery/export_c/manage_packing') ?>"><strong>Manage Packing List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <form method="post" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-cube"></i>
                            <span class="grid-title"><strong>MANAGE DELIVERY PACKING LIST</strong></span>
                            <div class="pull-right grid-tools">
                                <div class="pull-right">
                                    <a href="<?php echo base_url('index.php/delivery/export_c/upload/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload Packing List" style="height:30px;font-size:13px;width:100px;color:#000000;">Upload</a>
                                </div>
                            </div>
                        </div>
                        <div class="grid-body">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery Date From</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <input type="text" name="date_from" class="form-control date-picker" id="datepicker" name="delivery_date" value="<?php echo date("d-m-Y", strtotime($date_from)) ?>">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    </div>

                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery Date to</label>
                                <div class="col-sm-3">
                                    <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4">
                                        <input type="text" name="date_to" class="form-control date-picker" id="datepicker1" name="delivery_date" value="<?php echo date("d-m-Y", strtotime($date_to)) ?>">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    </div>

                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary" data-placement="right" data-toggle="tooltip" title="Filter Packing" name="btn-upload" value="1"><i class="fa fa-filter"></i> filter</button>
                                        <?php
                                        echo form_close();
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div id="table-luar">
                                <div class="table-responsive">
                                    <table id="dataTables3" class="table table-condensed table-striped display">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Packing ID</th>
                                                <th style="text-align:center;">Customer Code</th>
                                                <th style="text-align:center;">PO Cust</th>
                                                <th style="text-align:center;">Delivery Date</th>
                                                <th style="text-align:center;">Total Pallet</th>
                                                <th style="text-align:center;">Total Scan Pallet</th>
                                                <th style="text-align:center;">Prepare Status</th>
                                                <th style="text-align:center;">Status</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;

                                            foreach ($packing_list as $value_packing) {
                                                $packing_list_detail = $this->db->query("select  distinct CHR_CUST_CODE,CHR_NOPO_CUST,CHR_DATE_DELIVERY, CHR_IDPALLET , CHR_STAT from TT_PACKING_UPLOAD where CHR_IDPACKING = '$value_packing->CHR_IDPACKING' ");
//                                            $ro_packing_list = $this->db->query("select MAX(INT_NOPALLET) as tot from TT_PACKING_UPLOAD where CHR_IDPACKING = '$value_packing->CHR_IDPACKING'")->row();
//                                            $pallet_num = $packing_list_detail->num_rows();
                                                $percentagePrepare = $this->db->query("select SUM(INT_QTY/INT_QTY_PER_BOX) as JumBox , SUM(INT_QTY_PREPARE/INT_QTY_PER_BOX)  as JumBoxScan
                                                                            FROM         TT_PACKING_UPLOAD
                                                                            WHERE     (CHR_IDPACKING = '$value_packing->CHR_IDPACKING')")->row();
                                                $percentage = round(($percentagePrepare->JumBoxScan / $percentagePrepare->JumBox) * 100 , 1);
                                                $pallet_num = $packing_list_detail->num_rows();
                                                $packing_list_detail = $packing_list_detail->result();
                                                $jum_scan = 0;
                                                foreach ($packing_list_detail as $value_pack_detail) {
                                                    if ($value_pack_detail->CHR_STAT == "1") {
                                                        $jum_scan++;
                                                    }
                                                }
                                                $CUST_CODE = $packing_list_detail[0]->CHR_CUST_CODE;
                                                $PO_CUST = $packing_list_detail[0]->CHR_NOPO_CUST;
                                                $DATE_DELIVERY = $packing_list_detail[0]->CHR_DATE_DELIVERY;
                                                ?>
                                                <tr>
                                                    <td style="text-align:center;"><?php echo $i ?></td>
                                                    <td style="text-align:center;"><a data-placement="right" data-toggle="tooltip" title="View detail packing" href="<?php echo base_url('index.php/delivery/export_c/manage_packing_details/' . trim($value_packing->CHR_IDPACKING) . '/' . $date_from . '/' . $date_to) ?>"><span class="fa fa-search"></span><strong><?php echo $value_packing->CHR_IDPACKING ?></strong></a></td>
                                                    <td style="text-align:center;"><?php echo $CUST_CODE ?></td>
                                                    <td style="text-align:center;"><?php echo $PO_CUST ?></td>
                                                    <td style="text-align:center;"><?php echo date("d-m-Y", strtotime($DATE_DELIVERY)) ?></td>
                                                    <td style="text-align:center;"><?php echo $pallet_num ?></td>
                                                    <td style="text-align:center;"><?php echo $jum_scan ?></td>
                                                    <?php
                                                    if($percentage == null){
                                                      $percentage = 0; 
                                                    }
                                                    if ($percentage == 0) {
                                                        $style = "background-color: #ff0000;color: #ffffff";
                                                    } else if ($percentage < 100) {
                                                        $style = "background-color: #fbff00;";
                                                    } else {
                                                        $style = "background-color: #33ff00;";
                                                    }
                                                    ?>
                                                    <td style="text-align:center;<?php echo $style ?>"><?php echo $percentage . " %" ?></td>


                                                    <td style="text-align:center;">
                                                        <?php if ($jum_scan == $pallet_num) { ?>
                                                            <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25">
                                                        <?php } else {
                                                            ?>
                                                            <img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25">
                                                            <?php
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url("index.php/delivery/export_c/print_barcode/$value_packing->CHR_IDPACKING/") ?>" class="label label-warning" data-placement="right" data-toggle="tooltip" title="Download this Packing" ><span class="fa fa-download"></span></a>
                                                        <?php if ($jum_scan === 0) { ?>
                                                            <a href="<?php echo base_url('index.php/delivery/export_c/delete_packing') . '/' . trim($value_packing->CHR_IDPACKING) . '/' . $date_from . '/' . $date_to ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this packing?');"><span class="fa fa-times"></span></a>
                                                            <?php } ?>
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
                <!-- END RESPONSIVE TABLE -->
            </div>


    </section>
</aside>