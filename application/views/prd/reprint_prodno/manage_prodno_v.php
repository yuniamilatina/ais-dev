<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/reprint_prod_no_c/'); ?>"><span><strong>Data Production Nomor</strong></span></a></li>
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
                        <span class="grid-title">PROD. NOMOR YANG BISA DIREPRINT</span>
                        
                    </div>
                    <div class="grid-body">  
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Prod. No</th>
                                    <th style="text-align: center">Part No</th>
                                    <th style="text-align: center">Back No</th>
                                    <th style="text-align: center">Qty Order(Box)</th>
                                    <th style="text-align: center">Work Center</th>
                                    <th style="text-align: center">Area Prepare</th>
                                    <th style="text-align: center">Date Order</th>
                                    <th style="text-align: center">Time Order</th>
                                    <th style="text-align: center">Status Reprint</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $btn = 'success';
                                    $color = NULL;
                                    $level = null;
                                    $late = NULL;
                                    $id = $isi->INT_ID;

                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PRD_ORDER_NO</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_PART_NO_FG</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_BACK_NO_FG</td>";
                                    echo "<td style='text-align: center'>$isi->INT_QTY_FG</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_WORK_CENTER</td>";
                                    if ($isi->CHR_PREPARE_AREA == 'A'){
                                        echo "<td style='text-align: center'>CKD ATAS</td>";
                                    }elseif($isi->CHR_PREPARE_AREA == 'B'){
                                        echo "<td style='text-align: center'>OUTHOUSE</td>";
                                    }else{
                                        echo "<td style='text-align: center'>INHOUSE</td>";
                                    }
                                    ?>                                      
                                    <td style="text-align: center"><?php echo date("d-m-Y", strtotime($isi->CHR_DATE_ORDER)); ?></td>
                                    <td style="text-align: center"><?php echo date("H:i", strtotime($isi->CHR_TIME_ORDER)); ?></td>
                                    <?php if ($isi->CHR_FLAG_SPOOLING == '1') { ?>
                                        <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                    <?php }else{ ?>
                                        <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                    <?php }?>
                                    <td style='text-align:center;'>
                                        <!-- <a href="<?php echo base_url('index.php/prd/reprint_prod_no_c/edit_data') . "/" . rtrim($isi->INT_ID) . "/" . rtrim($isi->CHR_PREPARE_AREA) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Data"><span class="fa fa-pencil"></span></a>                                        -->
                                        <a href="<?php echo base_url('index.php/prd/reprint_prod_no_c/print_kanban_new') . '/' . rtrim($isi->INT_ID) . "/" . rtrim($isi->CHR_PREPARE_AREA) . '/' . 1;?>"  class="label label-primary" data-placement="left" data-placement="top" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a> 
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