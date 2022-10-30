
<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10); 
</script>

<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
    }
    .td-fixed{
        width: 10px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btn:hover {
        background: #1E90FF;
        background-image: -webkit-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -moz-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -ms-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -o-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: linear-gradient(to bottom, #1E90FF, #1E90FF);
        color:white;
    }

</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>History Absent Milkrun</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> HISTORY ABSENT MILKRUN </strong></span>

                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/delivery/master_schedule_cust_c/export_excel') . "/" . $selected_date; ?>" class="btn btn-primary" data-placement="left" style="color:white;" title="Export data to Excel"><i class='fa fa-download'></i> Export This Date</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>

                        <div class="pull-right grid-tools">
                            <button <?php //if ($role == 3 || $role == 4) { echo 'disabled'; }?> class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary"><i class="fa fa-download"></i> Export Monthly</button>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Date</label>
                            <div class="col-sm-2">
                                <div class="input-group" >
                                    <input id="datepicker" name="date_checkin" style="background-color:white;" class="form-control" autocomplete="off" placeholder="DD/MM/YYYY" required type="text" value="<?php echo substr($selected_date, 4, 2) . '/' . substr($selected_date, 6, 2) . '/' . substr($selected_date, 0, 4); ?>" onchange="refreshData()">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
<!--                            <div class="col-sm-2">
                                <div class="input-group" >
                                    <input class="btn btn-primary" type="submit" style="height:35px;width:70px;" name="filter" value="Filter" onClick="refreshData()">
                                </div>
                            </div>-->
                        </div>
                        
                        <div>&nbsp;</div>
                        <div class="pull">
                            <table width="100%" id='filter'>
<!--                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="20%">
                                        <select class="ddl2" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('delivery/master_schedule_cust_c/history_absent/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%"></td>
                                </tr>-->
                            </table>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <!------- HEADER TABLE ------->
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">No</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Customer</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Customer Desc</th>
                                        <!--<th rowspan="2" style="vertical-align: middle; text-align: center">Customer Address</th>-->
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Cycle</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Dock</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Route</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Logistic Vendor</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">Dist Channel</th>                                        
                                        <th colspan="3" style="vertical-align: middle; text-align: center">AII Arrival</th>
                                        <th colspan="3" style="vertical-align: middle; text-align: center">AII Departure</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center">LK3 Rank</th>
                                        <th colspan="8" style="vertical-align: middle; text-align: center">Detail LK3</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle; text-align: center">Plan</th>
                                        <th style="vertical-align: middle; text-align: center">Actual</th>
                                        <th style="vertical-align: middle; text-align: center">Result</th>
                                        <th style="vertical-align: middle; text-align: center">Plan</th>
                                        <th style="vertical-align: middle; text-align: center">Actual</th>
                                        <th style="vertical-align: middle; text-align: center">Result</th>
                                        <th style="vertical-align: middle; text-align: center">Helm</th>
                                        <th style="vertical-align: middle; text-align: center">Rompi</th>
                                        <th style="vertical-align: middle; text-align: center">ID Card</th>
                                        <th style="vertical-align: middle; text-align: center">Sepatu Safety</th>
                                        <th style="vertical-align: middle; text-align: center">Ganjal Roda</th>
                                        <th style="vertical-align: middle; text-align: center">SIM Forklift</th>
                                        <th style="vertical-align: middle; text-align: center">APAR</th>
                                        <th style="vertical-align: middle; text-align: center">Uji Kebocoran Oli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        if (count($history) > 0) {
                                            foreach ($history as $isi) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td style=text-align:center;>$no</td>";
                                                echo "<td>$isi->CHR_CUST</td>";
                                                echo "<td>$isi->CHR_CUST_DESC</td>";
                                                //echo "<td>$isi->CHR_CUST_ADDRESS</td>";                                                                                               
                                                echo "<td style=text-align:center;>$isi->INT_CYCLE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_CUST_DOCK</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_ROUTE</td>";
                                                echo "<td style=text-align:center;>$isi->CHR_LOG_VENDOR</td>";
                                                
                                                if($isi->CHR_DIS_CHANNEL == 'C1'){
                                                    echo "<td style=text-align:center;>C1 - OEM</td>";
                                                } else if($isi->CHR_DIS_CHANNEL == 'C2'){
                                                    echo "<td style=text-align:center;>C2 - AM</td>";
                                                } else if($isi->CHR_DIS_CHANNEL == 'C3'){
                                                    echo "<td style=text-align:center;>C3 - TRIAL</td>";
                                                } else {
                                                    echo "<td style=text-align:center;>C4 - OTHER</td>";
                                                } 
                                                
                                                echo "<td style=text-align:center;>" . date('H:i', strtotime($isi->CHR_AII_ARRIVAL)) . "</td>";
                                                
                                                if($isi->CHR_TIME_CHECKIN != NULL){
                                                    echo "<td style=text-align:center;><strong>" . date('H:i', strtotime($isi->CHR_TIME_CHECKIN)) . "</strong></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><strong>-</strong></td>";
                                                }
                                                
                                                if($isi->INT_CHECKIN_STAT == 2 && $isi->CHR_TIME_CHECKIN != NULL){
                                                    echo "<td style=text-align:center;background-color:red;color:white;>Delayed</td>";
                                                } else if($isi->INT_CHECKIN_STAT == 1 && $isi->CHR_TIME_CHECKIN != NULL){
                                                    echo "<td style=text-align:center;background-color:green;color:white;>Advanced</td>";
                                                } else if($isi->INT_CHECKIN_STAT == 0 && $isi->CHR_TIME_CHECKIN != NULL) {
                                                    echo "<td style=text-align:center;background-color:blue;color:white;>On Time</td>";
                                                } else if($isi->INT_CHECKIN_STAT == NULL && $isi->CHR_TIME_CHECKIN == NULL){
                                                    echo "<td style=text-align:center;>-</td>";
                                                }
                                                
                                                echo "<td style=text-align:center;>" . date('H:i', strtotime($isi->CHR_AII_DEPARTURE)) . "</td>";
                                                if($isi->CHR_TIME_CHECKOUT != NULL){
                                                    echo "<td style=text-align:center;><strong>" . date('H:i', strtotime($isi->CHR_TIME_CHECKOUT)) . "</strong></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><strong>-</strong></td>";
                                                }
                                                
                                                if($isi->INT_CHECKOUT_STAT == 2 && $isi->CHR_TIME_CHECKOUT != NULL){
                                                    echo "<td style=text-align:center;background-color:red;color:white;>Delayed</td>";
                                                } else if($isi->INT_CHECKOUT_STAT == 1 && $isi->CHR_TIME_CHECKOUT != NULL){
                                                    echo "<td style=text-align:center;background-color:green;color:white;>Advanced</td>";
                                                } else if($isi->INT_CHECKOUT_STAT == 0 && $isi->CHR_TIME_CHECKOUT != NULL) {
                                                    echo "<td style=text-align:center;background-color:blue;color:white;>On Time</td>";
                                                } else if($isi->INT_CHECKOUT_STAT == NULL && $isi->CHR_TIME_CHECKOUT == NULL) {
                                                    echo "<td style=text-align:center;>-</td>";
                                                }                                                
                                                
                                                if($isi->SCORING == 1 && $isi->CHR_TIME_CHECKIN != NULL){
                                                    echo "<td style=text-align:center;background-color:gold;color:white;>Very Good</td>";
                                                } else if(($isi->SCORING >= 0.8) && ($isi->SCORING <= 0.99) && $isi->CHR_TIME_CHECKIN != NULL){
                                                    echo "<td style=text-align:center;background-color:green;color:white;>Good</td>";
                                                } else if(($isi->SCORING >= 0.7) && ($isi->SCORING <= 0.79) && $isi->CHR_TIME_CHECKIN != NULL) {
                                                    echo "<td style=text-align:center;background-color:blue;color:white;>Fair</td>";
                                                } else if($isi->SCORING < 0.7 && $isi->CHR_TIME_CHECKIN != NULL) {
                                                    echo "<td style=text-align:center;background-color:red;color:white;>Poor</td>";
                                                } else if($isi->SCORING == NULL && $isi->CHR_TIME_CHECKIN == NULL){
                                                    echo "<td style=text-align:center;>-</td>";
                                                }
                                                
                                                if($isi->INT_HELM_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_ROMPI_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_IDCARD_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_SEPATU_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_GANJAL_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_SIM_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_APAR_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                if($isi->INT_OLI_STAT == 0){
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/error1.png' width='25'></td>";
                                                } else {
                                                    echo "<td style=text-align:center;><img src='" . base_url() . "/assets/img/check1.png' width='25'></td>";
                                                }
                                                
                                                echo "</tr>";
                                            $no++;
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
        <div class="modal fade" id="modalPrimary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" action="<?php echo base_url('index.php/delivery/master_schedule_cust_c/export_excel_monthly'); ?>" method="post"  enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2" >Download History Absent</h4>
                            </div>
                            <div class="modal-body" >
<!--                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/delivery/master_schedule_cust_c/export_excel') . "/" . $selected_date; ?>">Download by Date <?php echo date($selected_date); ?></a></span>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Periode </label>
                                    <div class="col-sm-7">
                                        <select class="ddl" id="periode" name="periode">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?PHP echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </div>                                      
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                                    <button class="btn btn-primary" value="1" name="download_button"> Download </button>
                                </div>
                            </div>
                        </form>
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
    function refreshData() {
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(0, 2) + date_t.substr(3, 2)
        location.href = '<?php echo site_url() ?>/delivery/master_schedule_cust_c/history_absent/' + date_fix
    }
    
//    $( document ).ready(function() {
//        var stat = <?php echo $status; ?>;
//        if(stat == 0){
//            alert('WARNING...!!! \nGunakan budget dengan bijak, Rupiah menurun \n1USD = Rp 14.358,10');
//        }
//    });
    
    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 7
            }
        });
    });
</script>

