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
            <li><a href="<?php echo base_url('index.php/prd/tracebility_c/'); ?>"><span><strong>Tracebility View</strong></span></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        //query not yet transport, data tester not yet ready
        echo form_open('prd/tracebility_c/tracebility_new', 'class="form-horizontal"');
        ?>
        <div class="pull">
            <?php
                if ($msg != NULL) {
                    echo $msg;
                }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title">PART TRACEABILITY - CLUTCH DISC (CD) PARTS</span>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr style="vertical-align: center">
                                    <td width="5%">Input QR Code</td>
                                    <td width="20%">
                                        <input autocomplete=off name="id_qrcode" id="id_qrcode" class="form-control" type="text" style="width:180px;">
                                    </td>
                                    <script type="text/javascript" >
                                        document.getElementById("id_qrcode").focus();
                                    </script>
                                    <td width="5%">
                                        <button type="submit" class="btn btn-primary" ><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="1%"></td>
                                   
                                        <td width="30%" style="font-size: 17px"></td>
                                        <td width="5%"></td>
                                        <td width="1%"></td>
                                        <td width="30%" style="font-size: 17px"></td>
                                        <td width="5%"></td>
                                        <td width="1%"></td>
                                        <td width="30%" style="font-size: 17px"></td>
                                    
                                </tr>
                            </table>
                            <table width="100%" id='filter' border=0px>
                                <tr style="vertical-align: center">
                                    <td width="5%">QR Code :</td>
                                    <td width="20%" style="font-size: 17px">
                                    <!-- <strong><?php echo $qr_barcode; ?></strong> -->
                                    <strong><?php echo "<a data-toggle='modal'data-target='#modal" . $qr_barcode ."' title='Trace Forward'>$qr_barcode</a>"; ?></strong>
                                    </td>
                                    <td width="5%">
                                    </td>
                                    <td width="5%"></td>
                                    <td width="5%">Prod. Order No</td>
                                    <td width="1%">:</td>
                                    <?php if (!empty($datadetail)) {?>
                                        <td width="30%" style="font-size: 17px"><strong><?php echo $prd_order; ?></strong></td>
                                        <td width="5%">Back No</td>
                                        <td width="1%">:</td>
                                        <td width="30%" style="font-size: 17px"><strong><?php echo $back_no; ?></strong></td>
                                        <td width="5%">Production Date</td>
                                        <td width="1%">:</td>
                                        <td width="30%" style="font-size: 17px"><strong><?php echo $datetime; ?></strong></td>
                                    <?php } else { ?>
                                        <td width="30%" style="font-size: 17px"><strong><?php echo "___________________" ?></strong></td>
                                        <td width="5%">Back No</td>
                                        <td width="1%">:</td>
                                        <td width="30%" style="font-size: 17px"><strong><?php echo "___________" ?></strong></td>
                                        <td width="5%">Production Date</td>
                                        <td width="1%">:</td>
                                        <td width="30%" style="font-size: 17px"><strong><?php echo "___________" ?></strong></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>

                        
                        <br>

                        <table  class="table display" cellspacing="0"  width="100%">
                            <thead>
                            <tr>
                                <th colspan="8" style="text-align: center">M O D E L</th>
                                <tbody>
                                <?php
                                    if (!empty($datatester)){
                                        echo "<tr class='gradeX'>";
                                        echo "<td colspan='8' style='text-align: center; color: black; font-size: 16px'><strong>$datatester->CHR_MODEL</strong></td>";
                                        echo "</tr>";
                                        }
                                        else {

                                         }
                                        ?>   
                                </tbody>
                            </tr>
                                <tr>
                                    <!-- <th style="text-align: center">MODEL</th> -->
                                    <th colspan="8" style="text-align: center">UPPER LIMIT</th>
                                    <!-- <th style="text-align: center">UPPER LIMIT</th> -->
                                    <!-- <th style="text-align: center">UPPER LIMIT</th>
                                    <th style="text-align: center">UPPER LIMIT</th>
                                    <th style="text-align: center">UPPER LIMIT</th>
                                    <th style="text-align: center">UPPER LIMIT</th>
                                    <th style="text-align: center">UPPER LIMIT</th>
                                    <th style="text-align: center">UPPER LIMIT</th> -->
                                </tr>
                                    <tbody>
                                        <?php
                                        if (!empty($datatester)){
                                            echo "<tr class='gradeX'>";
                                            // echo "<td rowspan='5' style='text-align: center; color: black; font-size: 18px'><strong>$datatester->CHR_MODEL</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_LOW_K1_UPP/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_LOW_H1_UPP/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_H1_UPP/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_H2_UPP/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K1_UPP/1,0,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K2_UPP/1,0,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K3_UPP/1,0,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K4_UPP/1,0,',','.') . "</strong></td>";
                                            echo "</tr>";
                                        }
                                        else { }
                                        ?>
                                    </tbody>
                                <tr>
                                    <!-- <th style="text-align: center"></th> -->
                                    <th style="text-align: center"> LOW K1</th>
                                    <th style="text-align: center"> LOW H1</th>
                                    <th style="text-align: center"> HIGH H1</th>
                                    <th style="text-align: center"> HIGH H2</th>
                                    <th style="text-align: center"> HIGH K1</th>
                                    <th style="text-align: center"> HIGH K2</th>
                                    <th style="text-align: center"> HIGH K3</th>
                                    <th style="text-align: center"> HIGH K4</th>
                                </tr>
                                    <tbody>
                                        <?php
                                        if (!empty($datatester)){
                                            echo "<tr class='gradeX'>";
                                            // echo "<td style='text-align: center; background-color: ; color: white; font-size: 18px'><strong></strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_LOW_K1/100,2,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_LOW_H1/100,2,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_H1/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_H2/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K1/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K2/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K3/10,1,',','.') . "</strong></td>";
                                            echo "<td style='text-align: center; background-color: #FFA500; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K4/10,1,',','.') . "</strong></td>";
                                            echo "</tr>";
                                        }
                                        else { }
                                        ?>
                                    </tbody>
                                <tr>
                                    <!-- <th style="text-align: center"></th> -->
                                    <th colspan="8" style="text-align: center">LOWER LIMIT</th>
                                    <!-- <th style="text-align: center">LOWER LIMIT</th>
                                    <th style="text-align: center">LOWER LIMIT</th>
                                    <th style="text-align: center">LOWER LIMIT</th>
                                    <th style="text-align: center">LOWER LIMIT</th>
                                    <th style="text-align: center">LOWER LIMIT</th>
                                    <th style="text-align: center">LOWER LIMIT</th>
                                    <th style="text-align: center">LOWER LIMIT</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($datatester)){
                                    echo "<tr class='gradeX'>";
                                    // echo "<td style='text-align: center; background-color: ; color: white; font-size: 18px'><strong></strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_LOW_K1_LOW/10,1,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_LOW_H1_LOW/10,1,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_H1_LOW/10,1,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_H2_LOW/10,1,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K1_LOW/1,0,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K2_LOW/1,0,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K3_LOW/1,0,',','.') . "</strong></td>";
                                    echo "<td style='text-align: center; background-color: #4d79ff; color: white; font-size: 18px'><strong>" . number_format($datatester->CHR_HIGH_K4_LOW/1,0,',','.') . "</strong></td>";
                                    echo "</tr>";
                                }
                                else { }
                                ?>
                            </tbody>
                        </table>

                        <table width="40%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
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
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">Part No Comp.</th>
                                    <!-- <th style="text-align: center">Back No</th> -->
                                    <th style="text-align: center">Part Name</th>
                                    <!-- <th style="text-align: center">Order Qty</th> -->
                                    <th style="text-align: center">PDS No</th>
                                    <th style="text-align: center">Supplier</th>
                                    <th style="text-align: center">GR date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                if (!empty($datadetail)){
                                    foreach ($datadetail as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align: center'>$i</td>";
                                        echo "<td style='text-align: center'>$isi->CHR_PART_NO</td>";
                                        // echo "<td style='text-align: center'>$isi->CHR_BACK_NO</td>";
                                        echo "<td style='text-align: left'>$isi->CHR_PART_NAME</td>";
                                        // echo "<td style='text-align: center'>$isi->INT_QTY_PCS</td>";
                                        // echo "<td style='text-align: center'>$isi->CHR_PDS_NO</td>"; //===== BEFORE EDIT
                                        
                                        //===== ADDITIONAL FUNCTION TRACE --- BY ANU 20191210 =====//
                                        echo "<td style='text-align: center'><a data-toggle='modal'data-target='#modalElina" . trim($isi->CHR_PDS_NO) ."_" . trim($isi->CHR_PART_NO) . "' title='Trace Forward'>$isi->CHR_PDS_NO</a></td>";
                                        //===== END ADDITIONAL FUNCTION =====//

                                        echo "<td style='text-align: left'>$isi->CHR_SOURCE</td>";
                                        echo "<td style='text-align: center'>" . date('d-m-Y', strtotime($isi->CHR_DATE_PDS)) . " ~ " . date('h:i:s', strtotime($isi->CHR_TIME_PDS)) . "</td>";                       
                                        echo "</tr>";

                                    $i++;
                                    }
                                    
                                }
                                else { }
                            ?>
                            </tbody>
                        </table>
                        
                        <div class="btn-group">
                                <?php
                                echo anchor('prd/tracebility_c/', 'Refresh', 'class="btn btn-warning"');
                                ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
            echo form_close();
        ?>    
                    <!-- MODAL FOR TRACE FORWARD -- BY ANU 20191209 -->
                    <div class="modal fade" id="modal<?php echo $qr_barcode; ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress">TRACE FORWARD</h4>
                                    </div>

                                    <div class="modal-body">
                                        <h5 class="modal-title" id="modalprogress">Detail Part</h5>
                                        <br>
                                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
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
                                                if($data_traceforward != NULL){
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
                                                if($data_traceforward != NULL){
                                                    echo "<tr align='center'>";
                                                    echo "<td>$data_traceforward->CHR_IDPACKING</td>";
                                                    echo "<td><strong>$data_traceforward->CHR_IDPALLET</strong></td>";                                                    
                                                    echo "<td>$data_traceforward->INT_QTY</td>";
                                                    echo "<td>$data_traceforward->INT_QTY_PER_BOX</td>";                                                    
                                                    echo "<td>" . substr($data_traceforward->CHR_DATE_DELIVERY,6,2) . "/" . substr($data_traceforward->CHR_DATE_DELIVERY,4,2) . "/" . substr($data_traceforward->CHR_DATE_DELIVERY,0,4) . "</td>";
                                                    echo "<td>" . substr($data_traceforward->CHR_DATE_SCAN,6,2) . "/" . substr($data_traceforward->CHR_DATE_SCAN,4,2) . "/" . substr($data_traceforward->CHR_DATE_SCAN,0,4) . "</td>";
                                                    echo "<td>" . substr($data_traceforward->CHR_TIME_SCAN,0,2) . ":" . substr($data_traceforward->CHR_TIME_SCAN,2,2) . ":" . substr($data_traceforward->CHR_TIME_SCAN,4,2) . "</td>";
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
                                                if($data_traceforward != NULL){
                                                    echo "<tr align='center'>";                                                    
                                                    echo "<td><strong>$data_traceforward->CHR_DEL_NO</strong></td>";
                                                    echo "<td>$data_traceforward->CHR_NOPO_SAP</td>";
                                                    echo "<td>$data_traceforward->CHR_CUS_DEST</td>";
                                                    echo "<td>$data_traceforward->CHR_DOK_NO</td>";
                                                    echo "<td>" . substr($data_traceforward->CHR_DEL_DATE_ACT,6,2) . "/" . substr($data_traceforward->CHR_DEL_DATE_ACT,4,2) . "/" . substr($data_traceforward->CHR_DEL_DATE_ACT,0,4) . "</td>";
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL --> 
                    <!-- MODAL FOR TRACE PDS USAGE ANOTHER LOT -- BY ANU 20191210 -->
                    <?php
                    if (!empty($datadetail)){
                        foreach ($datadetail as $isi) {
                    ?>
                    <div class="modal fade" id="modalElina<?php echo trim($isi->CHR_PDS_NO) ."_" . trim($isi->CHR_PART_NO); ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress">TRACE PDS USAGE TO ASSY</h4>
                                    </div>

                                    <div class="modal-body">

                                        <table id="example4" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr align='center'>
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
                                                if($get_pds_usage->num_rows() > 0){
                                                    $i = 1;
                                                    foreach($get_pds_usage->result() as $data){
                                                        echo "<tr align='center'>";
                                                        echo "<td>$i</td>";
                                                        echo "<td>$data->CHR_WORK_CENTER</td>";
                                                        echo "<td><strong>$data->CHR_PRD_ORDER_NO</strong></td>";
                                                        echo "<td>$data->CHR_PART_NO_FG</td>";
                                                        echo "<td><strong>$data->CHR_BACK_NO_FG</strong></td>";
                                                        echo "<td>$data->INT_QTY_FG</td>";   
                                                        echo "<td>" . substr($data->CHR_DATE_ORDER,6,2) . "/" . substr($data->CHR_DATE_ORDER,4,2) . "/" . substr($data->CHR_DATE_ORDER,0,4) . "</td>";
                                                        echo "<td>" . substr($data->CHR_TIME_ORDER,0,2) . "/" . substr($data->CHR_TIME_ORDER,2,2) . "/" . substr($data->CHR_TIME_ORDER,4,2) . "</td>";
                                                        echo "</tr>";
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
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <!-- END MODAL -->    
    </section>
</aside>
