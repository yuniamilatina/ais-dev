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
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/accounting/report_aiia_c') ?>"><strong>Report Delivery AIIA</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>REPORT DELIVERY AIIA</strong></span>
                        <div class="pull-right grid-tools">
                            <?php if($stat_del == '1'){
                            ?>
                            <a href="<?php echo base_url('index.php/accounting/report_aiia_c/update_function/0/' . trim($periode)) ?>" class="btn btn-danger" data-placement="left" data-toggle="tooltip" title="Enable Delete" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;"><span class='fa fa-unlock'></span>Open</a>
                            <?php } else {
                            ?>
                            <a href="<?php echo base_url('index.php/accounting/report_aiia_c/update_function/1/' . trim($periode)) ?>" class="btn btn-success" data-placement="left" data-toggle="tooltip" title="Disable Delete" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;"><span class='fa fa-lock'></span>Closed</a>
                            <?php }
                            ?>
                            <a href="<?php echo base_url('index.php/accounting/report_aiia_c/export_rekap_delivery_aiia/' . trim($periode)) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:120px;color:white;margin-top:-5px;margin-bottom:-5px;"><span class='fa fa-print'></span>Rekap AIIA</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>                                
                                <tr>
                                    <td width="5%">Periode</td>
                                        <td width="10%">
                                        <select class="form-control" id="periode" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <?php for ($x = -5; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo site_url('accounting/report_aiia_c/index/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($periode == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo strtoupper(date("M Y", strtotime("+$x month"))); ?> </option>
                                                    <?php } ?>
                                                
                                            <!-- TEMPORARY ACTION ERROR MONTH FEBRUARI -->
                                            <!-- <option value="<?php echo site_url('accounting/report_aiia_c/index/201810/'); ?>" <?php if ($periode == '201810') {echo 'selected'; } ?> >OCT 2018</option>
                                            <option value="<?php echo site_url('accounting/report_aiia_c/index/201811/'); ?>" <?php if ($periode == '201811') {echo 'selected'; } ?> >NOV 2018</option>
                                            <option value="<?php echo site_url('accounting/report_aiia_c/index/201812/'); ?>" <?php if ($periode == '201812') {echo 'selected'; } ?> >DEC 2018</option>
                                            <option value="<?php echo site_url('accounting/report_aiia_c/index/201901/'); ?>" <?php if ($periode == '201901') {echo 'selected'; } ?> >JAN 2019</option>
                                            <option value="<?php echo site_url('accounting/report_aiia_c/index/201902/'); ?>" <?php if ($periode == '201902') {echo 'selected'; } ?> >FEB 2019</option>
                                            <option value="<?php echo site_url('accounting/report_aiia_c/index/201903/'); ?>" <?php if ($periode == '201903') {echo 'selected'; } ?> >MAR 2019</option> -->
                                        </select>
                                        </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="50%">    
                                        
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                            </table>
                            <div style="width: 60%;">                            
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">No SJ</th>
                                    <th style="text-align:center;">Picking No</th> 
                                    <th style="text-align:center;">Cust Code</th>                                   
                                    <th style="text-align:center;">Cust Dest</th>
                                    <th style="text-align:center;">Gate ID</th>                                                                        
                                    <th style="text-align:center;">Delivery Date</th>
                                    <th style="text-align:center;">PDS Number</th>
                                    <th style="text-align:center;">PO Number</th>
                                    <th style="text-align:center;">Status Msg</th>
                                    <th style="text-align:center;">Dist Channel</th>
                                    <th style="text-align:center;">Document Date</th>
                                    <th style="text-align:center;">Update Date</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach($data as $val){ 
                                        $cek_part = 0;
                                        $notif = "";
                                        $style = "";
                                        if($val->INT_DELETE_FLAG == 1){
                                            $notif = "<span style='color:navy;' data-toggle='tooltip' title='SJ telah didelete' class='fa fa-warning'></span>";
                                            $style = "style='color:navy;'";
                                        } else {
                                            if($val->INT_SEND_FLAG <> 4){
                                                if($val->INT_STATUS_ERROR == 0){
                                                    $notif = "<span style='color:orange;' data-toggle='tooltip' title='SJ progress interface' class='fa fa-warning'></span>";
                                                    $style = "style='color:orange;'";
                                                } else {
                                                    $notif = "<span style='color:red;' data-toggle='tooltip' title='SJ error interface' class='fa fa-warning'></span>";
                                                    $style = "style='color:red;'";
                                                }
                                            } else {
                                                $query = $this->db->query("SELECT CHR_PART_NO
                                                    FROM TT_DELV_L 
                                                    WHERE CHR_DEL_NO = '$val->CHR_DEL_NO' AND (CHR_SAP_DEL_NO IS NULL OR CHR_SAP_DEL_NO = '')");
                                                $cek_part = $query->num_rows();  
                                                if($cek_part != 0){
                                                    $notif = "<span style='color:red;' data-toggle='tooltip' title='Ada part gagal interface' class='fa fa-warning'></span>";
                                                    $style = "style='color:red;'";
                                                }                                              
                                            }
                                        }

                                        echo "<tr " . $style . ">";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td style='font-weight:bold;'>" . trim($val->CHR_DEL_NO) . " " . $notif . "</td>";
                                        echo "<td>" . trim($val->CHR_PICKING_NO) . "</td>"; 
                                        echo "<td>" . trim($val->CHR_DEST_NO) . "</td>";
                                        echo "<td>" . trim($val->CHR_DEST_NAME) . "</td>";
                                        echo "<td>" . trim($val->CHR_GATE_ID) . "</td>"; 
                                        echo "<td>" . trim($val->CHR_DELIVERY_DATE) . "</td>";    
                                        echo "<td>" . trim($val->CHR_PDS_NO) . "</td>";
                                        echo "<td>" . trim($val->CHR_PO_NO) . "</td>";
                                        echo "<td>" . trim($val->CHR_ERROR_LOG) . "</td>"; 
                                        echo "<td>" . trim($val->CHR_KAT_PART) . "</td>";
                                        echo "<td>" . trim($val->CHR_DOC_DATE) . "</td>";
                                        echo "<td>" . trim($val->CHR_UPDATE_DATE) . "</td>";
                                        echo "<td><a data-target='#modalDetail" . trim(str_replace('/','-',$val->CHR_DEL_NO)) . "' class='label label-info' data-placement='top' data-toggle='modal' title='Detail Part'><span class='fa fa-folder-open'></span></a></td>";
                                        echo "</tr>";
                                        $no++;     
                                    }
                                ?>                            
                            </tbody>
                        </table>
                        <table width="40%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                            <tr>
                                <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d   : </strong></td>
                                <td width="5%">
                                    <span style='color:navy;' data-toggle='tooltip' class='fa fa-warning'></span> : SJ Deleted
                                </td>
                                <td width="5%">
                                    <span style='color:orange;' data-toggle='tooltip' class='fa fa-warning'></span> : SJ On Progress
                                </td>
                                <td width="5%">
                                <span style='color:red;' data-toggle='tooltip' class='fa fa-warning'></span> : SJ Error
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- START MODAL -->  
                    <?php foreach ($data as $isi) { ?>                      
                    <div class="modal fade" id="modalDetail<?php echo trim(str_replace('/','-',$isi->CHR_DEL_NO)); ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">                                    
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="modalprogress"><strong>Detail Data for SJ: <?php echo $isi->CHR_DEL_NO;  ?> </strong></h4>
                                    </div>

                                    <div class="modal-body">
                                        <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>No SO</th>
                                                    <th>No Item SO</th>
                                                    <th>Part No AII</th>
                                                    <th>Back No Cust</th>
                                                    <th>Part Name</th>                                            
                                                    <th>Total Qty</th>
                                                    <th>UoM</th>
                                                    <th>No DO</th>
                                                    <th>No Item DO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $x = 1;
                                                $del_no = trim($isi->CHR_DEL_NO);
                                                $tot_qty = 0;
                                                $get_detail = $this->db->query("SELECT CHR_PART_NO, CHR_FORE_ITM, CHR_NO_FORECAST, CHR_CUS_PART_NO, CHR_PART_NAME, INT_TOT_QTY, CHR_PART_UOM, CHR_SAP_DEL_NO, CHR_SAP_DEL_ITEM FROM TT_DELV_L WHERE CHR_DEL_NO = '$del_no'");
                                                if($get_detail->num_rows() > 0){
                                                    foreach($get_detail->result() as $part){
                                                        $tot_qty = $tot_qty + $part->INT_TOT_QTY;
                                                        
                                                        $warn = "";
                                                        if($part->CHR_SAP_DEL_NO == NULL || $part->CHR_SAP_DEL_NO == ""){
                                                            $warn = "style='color:red;'";
                                                        }

                                                        echo "<tr $warn>";
                                                        echo "<td>" . $x . "</td>";
                                                        echo "<td>" . trim($part->CHR_NO_FORECAST) . "</td>";
                                                        echo "<td>" . trim($part->CHR_FORE_ITM) . "</td>";
                                                        echo "<td>" . trim($part->CHR_PART_NO) . "</td>";
                                                        echo "<td>" . trim($part->CHR_CUS_PART_NO) . "</td>";
                                                        echo "<td>" . trim($part->CHR_PART_NAME) . "</td>";
                                                        echo "<td align='center'>" . $part->INT_TOT_QTY . "</td>";
                                                        echo "<td align='center'>" . $part->CHR_PART_UOM . "</td>";
                                                        echo "<td>" . trim($part->CHR_SAP_DEL_NO) . "</td>";
                                                        echo "<td>" . trim($part->CHR_SAP_DEL_ITEM) . "</td>";
                                                        echo "</tr>";
                                                        $x++; 
                                                    }
                                                    echo "<tr style='font-weight:bold'>";
                                                    echo "<td colspan='6' align='right'>Total Qty</td>";
                                                    echo "<td align='center'>" . $tot_qty . "</td>";
                                                    echo "<td colspan='3'></td>";
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
                    <?php } ?>
                    <!-- END MODAL -->
                </div>                
            </div>            
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 4,
                rightColumns: 1                
            }
        });
    });
</script>
