<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }

        document.getElementById("id_qrcode").focus();

    });
</script>
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/tracebility_c'); ?>"><span>Traceability</span></a></li>
            <li><a href="<?php echo base_url('index.php/prd/tracebility_c/get_traceability_asdl'); ?>"><span><strong>Traceability ASHV</strong></span></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="pull">
            <?php
            if ($data_detail['msg'] != NULL) {
                echo $data_detail['msg'];
            }
            ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-search"></i>
                        <span class="grid-title"><strong>PART TRACEABILITY - HYBRID DAMPER (HVD) PARTS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('prd/tracebility_c/traceability_ashv', 'class="form-horizontal"'); ?>

                                <input type='hidden' name="CHR_WORK_CENTER" value="<?php echo $data_detail['work_center']; ?>">

                                <div class="input-group">
                                    <input placeholder="Enter QR Code" autocomplete=off name="CHR_UNIQUE_NUMBER" id="id_qrcode" class="form-control" type="text">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit"><span class="fa fa-search"></span>&nbsp;&nbsp;Search</button>
                                    </span>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="lead"><strong>QR Code</strong></p>
                                <p><strong><?php echo "<a style='cursor: pointer' data-toggle='modal' data-target='#modal" . $data_detail['qr_barcode'] . "' title='Trace Forward'>" . $data_detail['qr_barcode'] . "</a>"; ?></strong></p>

                                <p class="lead">Model | Back No</p>
                                <p><?php echo $data_detail['back_no'] . ' | ' . $data_detail['model']; ?></p>

                            </div>
                            <div class="col-md-6" style="text-align:right;">

                                <p class="lead">Production Order Number </p>
                                <p><?php echo $data_detail['prd_order_no']; ?></p>

                                <p class="lead">Production Date</p>
                                <p><?php echo $data_detail['datetime']; ?></p>

                            </div>
                        </div>
                        <!-- <hr> -->
                        <p class="lead"><strong>Information Detail</strong></p>
                        <hr>
                        <div class="pull">
                            <table  class="table display" cellspacing="0"  width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="15" style="text-align: center">UPPER LIMIT</th>
                                    </tr>
                                        <tbody>
                                            <?php
                                            if (!empty($data_traceability)){
                                                echo "<tr class='gradeX'>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_H1_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_H2_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_K1_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_K2_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_H1_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_H2_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K1_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K2_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K3_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_H2_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K2_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K3_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K4_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIN_UPP/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_POS_UPP/1,0,',','.') . "</strong></td>";
                                                echo "</tr>";
                                            }
                                            else { }
                                            ?>
                                        </tbody>
                                    <tr>
                                        <th style="text-align: center"> SMALL H1</th>
                                        <th style="text-align: center"> SMALL H2</th>
                                        <th style="text-align: center"> SMALL K1</th>
                                        <th style="text-align: center"> SMALL K2</th>
                                        <th style="text-align: center"> MIDDLE H1</th>
                                        <th style="text-align: center"> MIDDLE H2</th>
                                        <th style="text-align: center"> MIDLLE K1</th>
                                        <th style="text-align: center"> MIDDLE K2</th>
                                        <th style="text-align: center"> MIDDLE K3</th>
                                        <th style="text-align: center"> LARGE H2</th>
                                        <th style="text-align: center"> LARGE K2</th>
                                        <th style="text-align: center"> LARGE K3</th>
                                        <th style="text-align: center"> LARGE K4</th>
                                        <th style="text-align: center"> MIN</th>
                                        <th style="text-align: center"> POS</th>
                                    </tr>
                                        <tbody>
                                            <?php
                                            if (!empty($data_traceability)){
                                                echo "<tr class='gradeX'>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_H1/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_H2/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_K1/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_K2/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_H1/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_H2/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K1/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K2/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K3/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_H2/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K2/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K3/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K4/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIN/1,0,',','.') . "</strong></td>";
                                                echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_POS/1,0,',','.') . "</strong></td>";
                                                echo "</tr>";
                                            }
                                            else { }
                                            ?>
                                        </tbody>
                                    <tr>
                                        <th colspan="15" style="text-align: center">LOWER LIMIT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($data_traceability)){
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_H1_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_H2_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_K1_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_SMALL_K2_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_H1_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_H2_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K1_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K2_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIDDLE_K3_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_H2_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K2_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K3_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_LARGE_K4_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_MIN_LOW/1,0,',','.') . "</strong></td>";
                                        echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($data_traceability->CHR_POS_LOW/1,0,',','.') . "</strong></td>";
                                        echo "</tr>";
                                    }
                                    else { }
                                    ?>
                                </tbody>
                            </table>

                            <table width="40%" id='filter' style="outline: thin ridge #DDDDDD">
                                    <tr>
                                        <td width="3%" style='text-align:left;' colspan="4"><strong>Legend :</strong></td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" class="btn" style='border:0;background:#FFA500;width:25px;height:25px;'></a> : Result of Machine Tester
                                        </td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" class="btn" style='border:0;background:#4d79ff;width:25px;height:25px;'></a> : Upper and Lower Limit
                                        </td>
                                    </tr>
                            </table>

                            <br>
                        </div>

                        <!-- MODAL FOR TRACE FORWARD -- BY ANU 20191209 -->
                        <div class="modal fade" id="modal<?php echo $data_detail['qr_barcode']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress">Tracing Forward</h4>
                                        </div>

                                        <div class="modal-body">
                                            <form class="form-horizontal" style='font-size:11px;' role="form">
                                                <h5 class="modal-title" id="modalprogress">Detail Part</h5>
                                                <br>
                                                <table id="example1" class="table table-striped table-condensed display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr align='center'>
                                                            <td>Part No</td>
                                                            <td>Part No Cust</td>
                                                            <td>Back No</td>
                                                            <td>ID Kanban</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($data_traceforward != NULL) {
                                                            echo "<tr align='center'>";
                                                            echo "<td>$data_traceforward->CHR_PART_NO</td>";
                                                            echo "<td>$data_traceforward->CHR_PARTNO_CUST</td>";
                                                            echo "<td>$data_traceforward->CHR_BACK_NO</td>";
                                                            echo "<td><strong>$data_traceforward->CHR_KANBAN_NO</strong></td>";
                                                            echo "</tr>";
                                                        } else {
                                                            echo "<tr>";
                                                            echo "<td><strong>No Data Found</strong></td>";
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <h5 class="modal-title" id="modalprogress">Packing / Pallet</h5>
                                                <br>
                                                <table id="example2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr align='center'>
                                                            <td>ID Packing</td>
                                                            <td>ID Pallet</td>
                                                            <td>Qty</td>
                                                            <td>Qty/Box</td>
                                                            <td>Plan Delivery</td>
                                                            <td>Date Scan</td>
                                                            <td>Time Scan</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($data_traceforward != NULL) {
                                                            echo "<tr align='center'>";
                                                            echo "<td>$data_traceforward->CHR_IDPACKING</td>";
                                                            echo "<td><strong>$data_traceforward->CHR_IDPALLET</strong></td>";
                                                            echo "<td>$data_traceforward->INT_QTY</td>";
                                                            echo "<td>$data_traceforward->INT_QTY_PER_BOX</td>";
                                                            echo "<td>" . substr($data_traceforward->CHR_DATE_DELIVERY, 6, 2) . "/" . substr($data_traceforward->CHR_DATE_DELIVERY, 4, 2) . "/" . substr($data_traceforward->CHR_DATE_DELIVERY, 0, 4) . "</td>";
                                                            echo "<td>" . substr($data_traceforward->CHR_DATE_SCAN, 6, 2) . "/" . substr($data_traceforward->CHR_DATE_SCAN, 4, 2) . "/" . substr($data_traceforward->CHR_DATE_SCAN, 0, 4) . "</td>";
                                                            echo "<td>" . substr($data_traceforward->CHR_TIME_SCAN, 0, 2) . ":" . substr($data_traceforward->CHR_TIME_SCAN, 2, 2) . ":" . substr($data_traceforward->CHR_TIME_SCAN, 4, 2) . "</td>";
                                                            echo "</tr>";
                                                        } else {
                                                            echo "<tr>";
                                                            echo "<td><strong>No Data Found</strong></td>";
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <h5 class="modal-title" id="modalprogress">Picking List</h5>
                                                <br>
                                                <table id="example3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr align='center'>
                                                            <td>Picking List</td>
                                                            <td>No PO</td>
                                                            <td>Cust Dest</td>
                                                            <td>Dock</td>
                                                            <td>Actual Delivery</td>
                                                            <td>GI Status</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($data_traceforward != NULL) {
                                                            echo "<tr align='center'>";
                                                            echo "<td><strong>$data_traceforward->CHR_DEL_NO</strong></td>";
                                                            echo "<td>$data_traceforward->CHR_NOPO_SAP</td>";
                                                            echo "<td>$data_traceforward->CHR_CUS_DEST</td>";
                                                            echo "<td>$data_traceforward->CHR_DOK_NO</td>";
                                                            echo "<td>" . substr($data_traceforward->CHR_DEL_DATE_ACT, 6, 2) . "/" . substr($data_traceforward->CHR_DEL_DATE_ACT, 4, 2) . "/" . substr($data_traceforward->CHR_DEL_DATE_ACT, 0, 4) . "</td>";
                                                            echo "<td>$data_traceforward->CHR_GI_DEL</td>";
                                                            echo "</tr>";
                                                        } else {
                                                            echo "<tr>";
                                                            echo "<td><strong>No Data Found</strong></td>";
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-search"></i>
                        <span class="grid-title"><strong>HISTORY TRACEABILITY COMPONENT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <!-- data elina -->
                        <table id="dataTables2" style='font-size:11px;' class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: left">Part No Comp.</th>
                                    <th style="text-align: center">Part Name</th>
                                    <th style="text-align: center">PDS No</th>
                                    <th style="text-align: center">Supplier</th>
                                    <th style="text-align: center">GR date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_history_elina as $isi) { ?>
                                    <tr class='gradeX'>
                                        <td style='text-align: center'><?php echo $i; ?></td>
                                        <td style='text-align: center'><?php echo $isi->CHR_PART_NO; ?></td>
                                        <td style='text-align: left'><?php echo $isi->CHR_PART_NAME; ?></td>
                                        <td style='text-align: center'><strong><a data-toggle='modal' data-target='#modalElina<?php echo trim($isi->CHR_PDS_NO) . "_" . trim($isi->CHR_PART_NO); ?>' title='Trace Forward'><?php echo $isi->CHR_PDS_NO; ?></a></strong></td>
                                        <td style='text-align: left'><?php echo $isi->CHR_SOURCE; ?></td>
                                        <td style='text-align: center'><?php echo date('d-m-Y', strtotime($isi->CHR_DATE_PDS)) . " ~ " . date('h:i:s', strtotime($isi->CHR_TIME_PDS)); ?></td>
                                    </tr>
                                <?php $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- data elina -->

                        <!-- MODAL FOR TRACE PDS USAGE ANOTHER LOT -- BY ANU 20191210 -->
                        <?php
                        foreach ($data_history_elina as $isi) {
                        ?>
                            <div class="modal fade" id="modalElina<?php echo trim($isi->CHR_PDS_NO) . "_" . trim($isi->CHR_PART_NO); ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-blue">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="modalprogress">TRACE PDS USAGE TO ASSY</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form" style='font-size:11px;' role="form">
                                                    <table id="example4" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <td>No</td>
                                                                <td>Work Center</td>
                                                                <td>Prod Order No</td>
                                                                <td>Part No</td>
                                                                <td>Back No</td>
                                                                <td>Qty</td>
                                                                <td>Date Order</td>
                                                                <td>Time Order</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $pds_no = trim($isi->CHR_PDS_NO);
                                                            $comp_no = trim($isi->CHR_PART_NO);
                                                            $get_pds_usage = $this->db->query("SELECT DISTINCT B.CHR_WORK_CENTER, A.CHR_PRD_ORDER_NO, B.CHR_PART_NO_FG, B.CHR_BACK_NO_FG, B.INT_QTY_FG, B.CHR_DATE_ORDER, B.CHR_TIME_ORDER 
                                                                                    FROM PRD.TT_ELINA_HISTORY A
                                                                                    LEFT JOIN PRD.TT_ELINA_H B ON A.CHR_PRD_ORDER_NO = B.CHR_PRD_ORDER_NO 
                                                                                    WHERE A.CHR_PDS_NO = '$pds_no' AND A.CHR_PART_NO = '$comp_no '
                                                                                    ORDER BY B.CHR_DATE_ORDER, B.CHR_TIME_ORDER ASC");
                                                            if ($get_pds_usage->num_rows() > 0) {
                                                                $i = 1;
                                                                foreach ($get_pds_usage->result() as $data) {
                                                                    echo "<tr align='center'>";
                                                                    echo "<td>$i</td>";
                                                                    echo "<td>$data->CHR_WORK_CENTER</td>";
                                                                    echo "<td><strong>$data->CHR_PRD_ORDER_NO</strong></td>";
                                                                    echo "<td>$data->CHR_PART_NO_FG</td>";
                                                                    echo "<td><strong>$data->CHR_BACK_NO_FG</strong></td>";
                                                                    echo "<td>$data->INT_QTY_FG</td>";
                                                                    echo "<td>" . substr($data->CHR_DATE_ORDER, 6, 2) . "/" . substr($data->CHR_DATE_ORDER, 4, 2) . "/" . substr($data->CHR_DATE_ORDER, 0, 4) . "</td>";
                                                                    echo "<td>" . substr($data->CHR_TIME_ORDER, 0, 2) . "/" . substr($data->CHR_TIME_ORDER, 2, 2) . "/" . substr($data->CHR_TIME_ORDER, 4, 2) . "</td>";
                                                                    echo "</tr>";
                                                                    $i++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- END MODAL -->

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
            scrollY: "350px",
            scrollX: false,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 2
            }
        });


    });

    $(document).ready(function() {

        var table = $('#example4').DataTable({
            scrollY: "350px",
            scrollX: false,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 2
            }
        });


    });
</script>