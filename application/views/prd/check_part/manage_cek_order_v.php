<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/check_part_elina_c/'); ?>"><span><strong>Data Part Kosong Order Elina</strong></span></a></li>
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
                        <span class="grid-title">DATA KOMPONEN YANG PERLU DICEK</span>
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
                                    <th style="text-align: center">Qty Order(Pcs)</th>
                                    <th style="text-align: center">Area</th>
                                    <th style="text-align: center">Date Order</th>
                                    <th style="text-align: center">Time Order</th>
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
                                    echo "<td style='text-align: center'>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align: center'>$isi->CHR_BACK_NO</td>";
                                    echo "<td style='text-align: center'>$isi->INT_ORDER_BOX</td>";
                                    echo "<td style='text-align: center'>$isi->INT_ORDER_PCS</td>";
                                ?>
                                    <?php if ($isi->CHR_PREPARE_AREA == 'A') { ?>
                                        <td>CKD ATAS</td>
                                    <?php } elseif ($isi->CHR_PREPARE_AREA == 'B') { ?>
                                        <td>OUTHOUSE</td>
                                    <?php } elseif ($isi->CHR_PREPARE_AREA == 'C') { ?>
                                        <td>INHOUSE</td>
                                    <?php } ?>
                                    <td style="text-align: center"><?php echo date("d-m-Y", strtotime($isi->CHR_DATE_ORDER)); ?></td>
                                    <td style="text-align: center"><?php echo date("H:i", strtotime($isi->CHR_TIME_ORDER)); ?></td>
                                    <td style='text-align:center;'>
                                        <?php if ($user == '3394' || $user == '9172' || $user == '1582') { ?>
                                            <a href="<?php echo base_url('index.php/prd/check_part_elina_c/edit_data') . "/" . rtrim($isi->INT_ID) . "/" . rtrim($isi->CHR_PART_NO) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Data"><span class="fa fa-pencil"></span></a>
                                        <?php } else { ?>
                                            <?php if ($isi->CHR_PREPARE_AREA == 'C') { ?>
                                                <a href="<?php echo base_url('index.php/prd/check_part_elina_c/edit_data') . "/" . rtrim($isi->INT_ID) . "/" . rtrim($isi->CHR_PART_NO) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Data"><span class="fa fa-pencil"></span></a>
                                            <?php } else { ?>
                                                <a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Edit Data"><span class="fa fa-pencil"></span></a>
                                        <?php }
                                        } ?>
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