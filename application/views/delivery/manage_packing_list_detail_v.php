<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/delivery/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/delivery/export_c/manage_packing') ?>">Manage Packing List</a></li>
            <li><a href=""><strong>Detail Packing List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        if (isset($success_notif)) {
            echo '<div class = "alert alert-success alert-dismissable"><strong> ' . $success_notif . '</strong></div >';
        }
        ?>
        <form method="post" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="row">
                <!-- BEGIN RESPONSIVE TABLE -->
                <div class="col-md-12">
                    <div class="grid border">
                        <div class="grid-header">
                            <i class="fa fa-cube"></i>
                            <span class="grid-title"> <strong>DETAIL PACKING <?php echo $id_packing; ?></strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div id="table-luar">
                                <div class="table-responsive">
                                    <table id="dataTables3" class="table table-condensed table-striped display">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Part No</th>
                                                <th style="text-align:center;">Pallet No</th>
                                                <th style="text-align:center;">Back No</th>
                                                <th style="text-align:center;">Part No Customer</th>
                                                <th style="text-align:center;">Delivery Date</th>
                                                <th style="text-align:center;">Qty (box)</th>
                                                <th style="text-align:center;">Qty (pcs)</th>
                                                <th style="text-align:center;">Prepared (Box)</th>
                                                <th style="text-align:center;">Prepared Status</th>
                                                <th style="text-align:center;">Status</th>
                                                <?php if($role == '1' || $npk == '6097'){ ?>
                                                <th style="text-align:center;">Print Case Mark</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;

                                            foreach ($packing_list as $value_packing) {
                                                ?>
                                                <tr>
                                                    <td style="text-align:center;"><?php echo $i ?></td>
                                                    <td style="text-align:center;"><?php echo $value_packing->CHR_PART_NO ?></td>
                                                    <td style="text-align:center;"><?php echo "<a data-toggle='modal'data-target='#modalKanban" . $value_packing->INT_NOPALLET ."'>" . $value_packing->INT_NOPALLET . "</a>"; ?></td>                                                    
                                                    <td style="text-align:center;"><?php echo $value_packing->CHR_BACK_NO ?></td>
                                                    <td style="text-align:center;"><?php echo $value_packing->CHR_PARTNO_CUST ?></td>
                                                    <td style="text-align:center;"><?php echo date("d-m-Y", strtotime($value_packing->CHR_DATE_DELIVERY)) ?></td>
                                                    <td style="text-align:center;"><?php echo $value_packing->INT_QTY / $value_packing->INT_QTY_PER_BOX ?></td>
                                                    <td style="text-align:center;"><?php echo $value_packing->INT_QTY ?></td>
                                                    <td style="text-align:center;"><?php
                                                        if ($value_packing->TOTAL_PREPARE_BOX == null) {
                                                            echo "0";
                                                        } else {
                                                            echo $value_packing->TOTAL_PREPARE_BOX;
                                                        }
                                                        ?></td>
                                                    <?php
                                                    if ($value_packing->TOTAL_PREPARE_BOX == NULL) {

                                                        $percentage = "0";
                                                    } else {

                                                        $percentage = round(($value_packing->TOTAL_PREPARE_BOX / $value_packing->TOTAL_BOX) * 100, 1);
                                                    }
                                                    ?>
                                                    <?php
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
                                                        <?php if ($value_packing->CHR_STAT == 1) { ?>
                                                            <img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25">
                                                        <?php } else {
                                                            ?>
                                                            <img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25">
                                                            <?php
                                                        }
                                                        ?>

                                                    </td>
                                                    <?php if($role == '1' || $npk == '6079'){ ?>
                                                    <td style="text-align:center;"><a href="<?php echo site_url('delivery/export_c/print_case_mark/' . trim($value_packing->CHR_IDPACKING) . '/' . trim($value_packing->CHR_IDPALLET) . "/" . $date_from . "/" . $date_to) ?>"><span class="fa fa-print"></a></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="<?php echo base_url("index.php/delivery/export_c/manage_packing/$date_from/$date_to") ?>" class="btn btn-default"><span class="fa fa-arrow-left"></span>&nbsp;&nbsp;Back</a>
                        </div>
                    </div>
                </div>
                <!-- END RESPONSIVE TABLE -->
                <!-- MODAL FOR DETAIL KANBAN SCAN -->
                <?php foreach ($packing_list as $isi) { ?>
                <div class="modal fade" id="modalKanban<?php echo $isi->INT_NOPALLET; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Detail Scan Kanban</strong></h4>
                                    </div>

                                    <div class="modal-body">
                                        <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Serial Kanban</th>
                                                    <th>PN Cust</th>
                                                    <th>Back No</th>
                                                    <th>Date Scan</th>
                                                    <th>Time Scan</th>
                                                    <th>Date Prod</th>
                                                    <th>Time Prod</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $id_pallet = trim($isi->CHR_IDPALLET);
                                                $get_his_pall = $this->db->query("SELECT A.CHR_IDPALLET, CHR_KANBAN_NO, CHR_PARTNO_CUST, CHR_BACK_NO, CHR_DATE_SCAN, CHR_TIME_SCAN, CHR_INLINE_DATE, CHR_INLINE_TIME FROM TT_SCAN_PREPARE_EXPORT A
                                                                    LEFT JOIN PRD.TT_SETUP_CHUTE B ON B.CHR_PRD_ORDER_NO = SUBSTRING(A.CHR_KANBAN_NO,1,19) 
                                                                    WHERE CHR_IDPALLET = '$id_pallet'");
                                                if($get_his_pall->num_rows() > 0){
                                                    $data_kanban = $get_his_pall->result();
                                                    $x = 1;
                                                    foreach($data_kanban as $part){
                                                        echo "<tr>";
                                                        echo "<td align='center'>" . $x . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_KANBAN_NO . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_PARTNO_CUST . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_BACK_NO . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_DATE_SCAN . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_TIME_SCAN . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_INLINE_DATE . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_INLINE_TIME . "</td>";
                                                        echo "</tr>";
                                                        $x++;
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL -->
                    <?php }  ?>
            </div>


    </section>
</aside>