<script type="text/javascript">
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<script>
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
<aside class="right-side">
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/prd/change_status_elina_c/optimize_capacity') ?>"><strong>Optimize Capacity</strong></a></li>
        </ol>
    </section>
    <!-- END CONTENT HEADER -->
    <!-- BEGIN MAIN CONTENT -->
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <!-- BEGIN BASIC DATATABLES -->

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>Optimize Capacity</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/prd/change_status_elina_c/upload_list_part/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload Overstock Parts" style="height:30px;font-size:13px;width:100px;color:grey;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                            <input type="button" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;" onclick="tableToExcel('exportToExcel', 'report_history_setup_chute')" value="Export to Excel"><i class="fa fa-download-up"></i></input>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                        <?php echo form_open('prd/change_status_elina_c/filter_optimize_capacity', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Group Product</td>
                                    <td width="10%">
                                        <select name="group_prd" id="group_to_work_center" class="ddl2" style="width:150px;">
                                            <?php
                                            foreach ($all_group_prd as $row) {
                                                if (trim($row->CHR_GROUP_PRODUCT_CODE) == trim($group_prd)) {
                                            ?>
                                                    <option selected value="<? echo $group_prd; ?>"><?php echo trim($row->CHR_GROUP_PRODUCT_DESC); ?></option>
                                                <?php } else { ?>
                                                    <option value="<? echo $row->CHR_GROUP_PRODUCT_CODE; ?>"><?php echo trim($row->CHR_GROUP_PRODUCT_DESC); ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="2%"></td>
                                    <td width="10%">Periode</td>
                                    <td width="10%">
                                        <select class="form-control" id="month" name="period" style="width:150px;">
                                            <?php for ($x = -1; $x <= 3; $x++) { ?>
                                                <option value="<?PHP echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                                                                                    if ($month == date("Ym", strtotime("+$x month"))) {
                                                                                                                        echo 'SELECTED';
                                                                                                                    }
                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="2%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="2%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                </tr>
                                <tr>
                                    <td width="10%">Priority Line</td>                                    
                                        <?php
                                            foreach ($all_work_centers as $line) {
                                        ?>
                                            <td><span><?php echo trim($line->CHR_WORK_CENTER); ?></span>
                                                <input class="form-control" type="number" min="1" name="line_<?php echo trim($line->CHR_WORK_CENTER); ?>" value="<?php echo $line->INT_PRIORITY; ?>" style="width:50px;">
                                            </td>
                                        <?php
                                            }
                                        ?> 
                                        <?php
                                            foreach ($all_work_centers_mfg as $line_mfg) {
                                        ?>
                                            <td><span><?php echo trim($line_mfg->CHR_WORK_CENTER); ?></span>
                                                <input class="form-control" type="number" min="1" name="line_mfg_<?php echo trim($line_mfg->CHR_WORK_CENTER); ?>" value="<?php echo $line_mfg->INT_PRIORITY; ?>" style="width:50px;">
                                            </td>
                                        <?php
                                            }
                                        ?>                                  
                                </tr>
                                <tr>
                                    <td width="10%">Priority Order</td>                                    
                                        <?php
                                            foreach ($all_order as $type) {
                                        ?>
                                            <td><span><?php echo trim($type->CHR_TYPE); ?></span>
                                                <input class="form-control" type="number" min="1" name="type_<?php echo trim($type->CHR_TYPE); ?>" value="<?php echo $type->INT_PRIORITY; ?>" style="width:50px;">
                                            </td>
                                        <?php
                                            }
                                        ?>                                   
                                </tr>
                                <tr>
                                    <td width="10%">Capacity</td>                                    
                                        <?php
                                            foreach ($all_work_centers as $cap) {
                                        ?>
                                            <td><span><?php echo trim($cap->CHR_WORK_CENTER); ?></span>
                                                <input class="form-control" type="number" min="0" name="cap_<?php echo trim($cap->CHR_WORK_CENTER); ?>" value="<?php echo $cap->INT_CAPACITY; ?>" style="width:90px;">
                                            </td>
                                        <?php
                                            }
                                        ?>
                                        <?php
                                            foreach ($all_work_centers_mfg as $cap_mfg) {
                                        ?>
                                            <td><span><?php echo trim($cap_mfg->CHR_WORK_CENTER); ?></span>
                                                <input class="form-control" type="number" min="0" name="cap_mfg_<?php echo trim(str_replace(" ", "_", $cap_mfg->CHR_WORK_CENTER)); ?>" value="<?php echo $cap_mfg->INT_CAPACITY; ?>" style="width:90px;">
                                            </td>
                                        <?php
                                            }
                                        ?>                                   
                                </tr>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="10%">
                                        <button type="submit" class="btn btn-success" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                </tr>
                            </table>
                        <?php echo form_close(); ?>
                        </div>
                        <div class="pull">
                            <?php
                                // $max_cc01 = 46800;
                                // $max_cc02 = 46800;
                                // $max_cc03 = 54600;
                                // $max_cc04 = 11700;
                                // $max_cc05 = 41600;

                                // $max_mads01 = 70200;
                                // $max_mads03 = 52000;
                                // $max_mads04 = 52000;
                                // $max_ckd = 15000;

                                $max_cc01 = 0;
                                $max_cc02 = 0;
                                $max_cc03 = 0;
                                $max_cc04 = 0;
                                $max_cc05 = 0;

                                foreach($all_work_centers as $x){
                                    if($x->CHR_WORK_CENTER == 'ASCC01'){
                                        $max_cc01 = $x->INT_CAPACITY;
                                    } 
                                    
                                    if($x->CHR_WORK_CENTER == 'ASCC02'){
                                        $max_cc02 = $x->INT_CAPACITY;
                                    } 
                                    
                                    if($x->CHR_WORK_CENTER == 'ASCC03'){
                                        $max_cc03 = $x->INT_CAPACITY;
                                    } 
                                    
                                    if($x->CHR_WORK_CENTER == 'ASCC04'){
                                        $max_cc04 = $x->INT_CAPACITY;
                                    } 

                                    if($x->CHR_WORK_CENTER == 'ASCC05'){
                                        $max_cc05 = $x->INT_CAPACITY;
                                    } 
                                }

                                $max_mads01 = 0;
                                $max_mads03 = 0;
                                $max_mads04 = 0;
                                $max_ckd = 0;

                                foreach($all_work_centers_mfg as $y){
                                    if($y->CHR_WORK_CENTER == 'MADS 01 02'){
                                        $max_mads01 = $y->INT_CAPACITY;
                                    } 
                                    
                                    if($y->CHR_WORK_CENTER == 'MADS 03'){
                                        $max_mads03 = $y->INT_CAPACITY;
                                    } 
                                    
                                    if($y->CHR_WORK_CENTER == 'MADS 04'){
                                        $max_mads04 = $y->INT_CAPACITY;
                                    } 
                                    
                                    if($y->CHR_WORK_CENTER == 'CKD'){
                                        $max_ckd = $y->INT_CAPACITY;
                                    }
                                }
                            ?>
                        </div>
                        <br>
                        
                        <table class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                
                                <tr>
                                    <th rowspan="3">No</th>                                    
                                    <th rowspan="3">WO</th>
                                    <th rowspan="3">Type</th>
                                    <th rowspan="3">Order</th>
                                    <th colspan="10">Assy Line</th>
                                    <th colspan="8">Manufacture</th>         
                                </tr>
                                <tr>
                                    <th colspan="2">ASCC01</th>
                                    <th colspan="2">ASCC02</th>
                                    <th colspan="2">ASCC03</th>
                                    <th colspan="2">ASCC04</th>
                                    <th colspan="2">ASCC05</th>
                                    <th colspan="2">MADS01/02</th>
                                    <th colspan="2">MADS03</th>
                                    <th colspan="2">MADS04</th>
                                    <th colspan="2">CKD</th>    
                                </tr>
                                <tr>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;

                                // for ($i=1; $i<=5; $i++) {
                                //     if($i == 1){
                                //         $type = 'OE-OE';
                                //     } else if($i == 2){
                                //         $type = 'GNP-GNP';
                                //     } else if($i == 3) {
                                //         $type = 'AM-OE';
                                //     } else if($i == 4) {
                                //         $type = 'AM-GNP';
                                //     } else {
                                //         $type = 'AM-AM';
                                //     }
                                
                                foreach($all_order as $ord){
                                    $type = trim($ord->CHR_TYPE);

                                    $mrp_d = $this->load->database("mrp_d", TRUE);
                                    $get_line = $mrp_d->query("SELECT DISTINCT A.CHR_WORK_CENTER, B.INT_PRIORITY 
                                                            FROM TM_GROUP_PRODUCT A
                                                            LEFT JOIN TM_CAPACITY_MRP B ON A.CHR_WORK_CENTER = B.CHR_WORK_CENTER
                                                            WHERE A.CHR_GROUP_PRODUCT_CODE = '$group_prd' AND A.INT_FLG_DELETE = '0' 
                                                            ORDER BY B.INT_PRIORITY ASC")->result();
                                    foreach ($get_line as $cc){
                                        $data = $mrp_d->query("SELECT * FROM TT_OPTIMIZE_CAPACITY WHERE CHR_MONTH = '$month' AND CHR_TYPE = '$type' AND CHR_WORK_CENTER = '$cc->CHR_WORK_CENTER' AND INT_FLG_DELETE = '0' ORDER BY CHR_WORK_CENTER, CHR_PART_NO ASC")->result();
                                    
                                        foreach($data as $isi){
                                            echo "<tr class='gradeX'>";
                                            echo "<td>$no</td>";
                                            echo "<td>" . $isi->CHR_PART_NO . "</td>";
                                            echo "<td>" . $type . "</td>";
                                            echo "<td>" . $isi->INT_QTY_ORDER . "</td>";

                                            if($max_cc01 < 0){
                                                $max_cc01 = 0;
                                            }

                                            if($max_cc02 < 0){
                                                $max_cc02 = 0;
                                            }

                                            if($max_cc03 < 0){
                                                $max_cc03 = 0;
                                            }

                                            if($max_cc04 < 0){
                                                $max_cc04 = 0;
                                            }

                                            if($max_cc05 < 0){
                                                $max_cc05 = 0;
                                            }

                                            if($max_mads01 < 0){
                                                $max_mads01 = 0;
                                            }

                                            if($max_mads03 < 0){
                                                $max_mads03 = 0;
                                            }

                                            if($max_mads04 < 0){
                                                $max_mads04 = 0;
                                            }

                                            if($max_ckd < 0){
                                                $max_ckd = 0;
                                            }

                                            //===== START ASCC 01
                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc01 <= $max_mads01){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                   
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    }  else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc01 <= $max_mads03){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    }  else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc01 <= $max_mads04){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc01 <= $max_ckd){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03. "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 01

                                            //===== START ASCC 02
                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc02 <= $max_mads01){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                               
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc02 <= $max_mads03){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc02 <= $max_mads04){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc02 <= $max_ckd){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 02

                                            //===== START ASCC 03
                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc03 <= $max_mads01){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc03 <= $max_mads03){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";                                                                
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc03 <= $max_mads04){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc03 <= $max_ckd){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }
                                            //===== END ASCC 03

                                            //===== START ASCC 04
                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc04 <= $max_mads01){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";          
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                      
    
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc04 <= $max_mads03){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";     
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc04 <= $max_mads04){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";     
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc04 <= $max_ckd){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";   
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";  
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>"; 
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";    
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 04
                                            
                                            //===== START ASCC 05
                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc05 <= $max_mads01){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td></td>";
                                                                echo "<td>" . $max_cc04 . "</td>";          
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                      
    
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc05 <= $max_mads03){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";     
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc05 <= $max_mads04){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";     
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc05 <= $max_ckd){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";   
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";  
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>"; 
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";    
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 05
                                        
                                        //===== END CONDITION
                                        }      
                                    }                                   
                                                                      
                                        
                                    ?>                                
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                        <thead>
                                <?php
                                    // $max_cc01 = 46800;
                                    // $max_cc02 = 46800;
                                    // $max_cc03 = 54600;
                                    // $max_cc04 = 11700;
                                    // $max_cc05 = 41600;
    
                                    // $max_mads01 = 70200;
                                    // $max_mads03 = 52000;
                                    // $max_mads04 = 52000;
                                    // $max_ckd = 15000;

                                    $max_cc01 = 0;
                                    $max_cc02 = 0;
                                    $max_cc03 = 0;
                                    $max_cc04 = 0;
                                    $max_cc05 = 0;

                                    foreach($all_work_centers as $x){
                                        if($x->CHR_WORK_CENTER == 'ASCC01'){
                                            $max_cc01 = $x->INT_CAPACITY;
                                        } 
                                        
                                        if($x->CHR_WORK_CENTER == 'ASCC02'){
                                            $max_cc02 = $x->INT_CAPACITY;
                                        } 
                                        
                                        if($x->CHR_WORK_CENTER == 'ASCC03'){
                                            $max_cc03 = $x->INT_CAPACITY;
                                        } 
                                        
                                        if($x->CHR_WORK_CENTER == 'ASCC04'){
                                            $max_cc04 = $x->INT_CAPACITY;
                                        } 

                                        if($x->CHR_WORK_CENTER == 'ASCC05'){
                                            $max_cc05 = $x->INT_CAPACITY;
                                        } 
                                    }

                                    $max_mads01 = 0;
                                    $max_mads03 = 0;
                                    $max_mads04 = 0;
                                    $max_ckd = 0;

                                    foreach($all_work_centers_mfg as $y){
                                        if($y->CHR_WORK_CENTER == 'MADS 01 02'){
                                            $max_mads01 = $y->INT_CAPACITY;
                                        } 
                                        
                                        if($y->CHR_WORK_CENTER == 'MADS 03'){
                                            $max_mads03 = $y->INT_CAPACITY;
                                        } 
                                        
                                        if($y->CHR_WORK_CENTER == 'MADS 04'){
                                            $max_mads04 = $y->INT_CAPACITY;
                                        } 
                                        
                                        if($y->CHR_WORK_CENTER == 'CKD'){
                                            $max_ckd = $y->INT_CAPACITY;
                                        }
                                    }
                                ?>
                                
                                <tr>
                                    <th rowspan="3">No</th>                                    
                                    <th rowspan="3">WO</th>
                                    <th rowspan="3">Type</th>
                                    <th rowspan="3">Order</th>
                                    <th colspan="10">Assy Line</th>
                                    <th colspan="8">Manufacture</th>         
                                </tr>
                                <tr>
                                    <th colspan="2">ASCC01</th>
                                    <th colspan="2">ASCC02</th>
                                    <th colspan="2">ASCC03</th>
                                    <th colspan="2">ASCC04</th>
                                    <th colspan="2">ASCC05</th>
                                    <th colspan="2">MADS01/02</th>
                                    <th colspan="2">MADS03</th>
                                    <th colspan="2">MADS04</th>
                                    <th colspan="2">CKD</th>    
                                </tr>
                                <tr>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>
                                    <th>Qty</th>
                                    <th>Sisa</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;

                                // for ($i=1; $i<=5; $i++) {
                                //     if($i == 1){
                                //         $type = 'OE-OE';
                                //     } else if($i == 2){
                                //         $type = 'GNP-GNP';
                                //     } else if($i == 3) {
                                //         $type = 'AM-OE';
                                //     } else if($i == 4) {
                                //         $type = 'AM-GNP';
                                //     } else {
                                //         $type = 'AM-AM';
                                //     }
                                
                                foreach($all_order as $ord){
                                    $type = trim($ord->CHR_TYPE);

                                    $mrp_d = $this->load->database("mrp_d", TRUE);
                                    $get_line = $mrp_d->query("SELECT DISTINCT A.CHR_WORK_CENTER, B.INT_PRIORITY 
                                                            FROM TM_GROUP_PRODUCT A
                                                            LEFT JOIN TM_CAPACITY_MRP B ON A.CHR_WORK_CENTER = B.CHR_WORK_CENTER
                                                            WHERE A.CHR_GROUP_PRODUCT_CODE = '$group_prd' AND A.INT_FLG_DELETE = '0' 
                                                            ORDER BY B.INT_PRIORITY ASC")->result();
                                    foreach ($get_line as $cc){
                                        $data = $mrp_d->query("SELECT * FROM TT_OPTIMIZE_CAPACITY WHERE CHR_TYPE = '$type' AND CHR_WORK_CENTER = '$cc->CHR_WORK_CENTER' AND INT_FLG_DELETE = '0' ORDER BY CHR_WORK_CENTER, CHR_PART_NO ASC")->result();
                                    
                                        foreach($data as $isi){
                                            echo "<tr class='gradeX'>";
                                            echo "<td>$no</td>";
                                            echo "<td>" . $isi->CHR_PART_NO . "</td>";
                                            echo "<td>" . $type . "</td>";
                                            echo "<td>" . $isi->INT_QTY_ORDER . "</td>";

                                            if($max_cc01 < 0){
                                                $max_cc01 = 0;
                                            }

                                            if($max_cc02 < 0){
                                                $max_cc02 = 0;
                                            }

                                            if($max_cc03 < 0){
                                                $max_cc03 = 0;
                                            }

                                            if($max_cc04 < 0){
                                                $max_cc04 = 0;
                                            }

                                            if($max_cc05 < 0){
                                                $max_cc05 = 0;
                                            }

                                            if($max_mads01 < 0){
                                                $max_mads01 = 0;
                                            }

                                            if($max_mads03 < 0){
                                                $max_mads03 = 0;
                                            }

                                            if($max_mads04 < 0){
                                                $max_mads04 = 0;
                                            }

                                            if($max_ckd < 0){
                                                $max_ckd = 0;
                                            }

                                            //===== START ASCC 01
                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc01 <= $max_mads01){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                   
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    }  else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc01 <= $max_mads03){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    }  else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc01 <= $max_mads04){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC01' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc01 <= $max_ckd){
                                                    if($max_cc01 > 0){
                                                        $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                        if($max_cc01 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03. "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc01 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_cc01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc01 = $max_cc01 - $isi->INT_QTY_ORDER;
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc01 = $max_cc01 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc01 >= 0){
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 01

                                            //===== START ASCC 02
                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc02 <= $max_mads01){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                               
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc02 <= $max_mads03){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc02 <= $max_mads04){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC02' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc02 <= $max_ckd){
                                                    if($max_cc02 > 0){
                                                        $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                        if($max_cc02 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc02 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_cc02 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc02 = $max_cc02 - $isi->INT_QTY_ORDER;
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc02 = $max_cc02 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc02 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 02

                                            //===== START ASCC 03
                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc03 <= $max_mads01){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";

                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc03 <= $max_mads03){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";                                                                
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc03 <= $max_mads04){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC03' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc03 <= $max_ckd){
                                                    if($max_cc03 > 0){
                                                        $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                        if($max_cc03 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc03 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_cc03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc03 = $max_cc03 - $isi->INT_QTY_ORDER;
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";      
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc03 = $max_cc03 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";                                                                
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                    
                                                } 
                                            }
                                            //===== END ASCC 03

                                            //===== START ASCC 04
                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc04 <= $max_mads01){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";          
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                      
    
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc04 <= $max_mads03){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";     
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc04 <= $max_mads04){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";     
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC04' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc04 <= $max_ckd){
                                                    if($max_cc04 > 0){
                                                        $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                        if($max_cc04 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";   
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc04 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";  
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";  
                                                                echo "<td>" . ($max_cc04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc04 = $max_cc04 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>"; 
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc04 = $max_cc04 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";    
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 04
                                            
                                            //===== START ASCC 05
                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'MADS 01 02'){

                                                if($max_cc05 <= $max_mads01){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads01 = $max_mads01 - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_mads01 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td></td>";
                                                                echo "<td>" . $max_cc04 . "</td>";          
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                      
    
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads01 > 0){
                                                        $max_mads01 = $max_mads01 - $isi->INT_QTY_ORDER;
                                                        if($max_mads01 >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_mads01 + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>" . ($max_mads01 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'MADS 03'){

                                                if($max_cc05 <= $max_mads03){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                                
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads03 = $max_mads03 - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_mads03 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";     
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads03 > 0){
                                                        $max_mads03 = $max_mads03 - $isi->INT_QTY_ORDER;
                                                        if($max_mads03 >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_mads03 + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>" . ($max_mads03 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'MADS 04'){

                                                if($max_cc05 <= $max_mads04){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";     
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                           
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_mads04 = $max_mads04 - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_mads04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_mads04 > 0){
                                                        $max_mads04 = $max_mads04 - $isi->INT_QTY_ORDER;
                                                        if($max_mads04 >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc04 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";      
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_mads04 + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>" . ($max_mads04 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_ckd . "</td>";   
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }

                                            if($isi->CHR_WORK_CENTER == 'ASCC05' && $isi->CHR_WORK_CENTER_MFG == 'CKD'){

                                                if($max_cc05 <= $max_ckd){
                                                    if($max_cc05 > 0){
                                                        $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                        if($max_cc05 >= 0){
                                                            $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";   
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        } else {
                                                            $max_ckd = $max_ckd - ($max_cc05 + $isi->INT_QTY_ORDER);
                                                            if($max_ckd >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>";  
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";                                                              
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>"; 
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";  
                                                                echo "<td>" . ($max_cc05 + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>";
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } else {
                                                    if($max_ckd > 0){
                                                        $max_ckd = $max_ckd - $isi->INT_QTY_ORDER;
                                                        if($max_ckd >= 0){
                                                            $max_cc05 = $max_cc05 - $isi->INT_QTY_ORDER;
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . $isi->INT_QTY_ORDER . "</td>";
                                                                echo "<td>" . $max_ckd . "</td>"; 
                                                                $no++;
                                                            }
                                                        } else {
                                                            $max_cc05 = $max_cc05 - ($max_ckd + $isi->INT_QTY_ORDER);
                                                            if($max_cc05 >= 0){
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc02 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_cc04 . "</td>"; 
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>" . $max_cc05 . "</td>";                                                               
    
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads01 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads03 . "</td>";
                                                                echo "<td>0</td>";
                                                                echo "<td>" . $max_mads04 . "</td>";   
                                                                echo "<td>" . ($max_ckd + $isi->INT_QTY_ORDER) . "</td>";
                                                                echo "<td>0</td>";    
                                                                $no++;
                                                            } 
                                                        }
                                                    } else {
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc01 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc02 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_cc05 . "</td>";

                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads01 . "</td>";      
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads03 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_mads04 . "</td>";
                                                        echo "<td>0</td>";
                                                        echo "<td>" . $max_ckd . "</td>";   
                                                        $no++;
                                                    }                                                     
                                                } 
                                            }
                                            //===== END ASCC 05
                                        
                                        //===== END CONDITION
                                        }      
                                    }                                   
                                                                      
                                        
                                    ?>                                
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- END MAIN CONTENT -->
</aside>