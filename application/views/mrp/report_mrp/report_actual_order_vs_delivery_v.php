<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

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

    $(function() {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
    
    $(function() {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function() {
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function() {
        $( ".datepicker" ).datepicker();
    });
    
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/mrp/report_mrp_c/') ?>"><strong>Report Actual Order vs Delivery</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-cubes"></i>
                        <span class="grid-title"><strong>REPORT ACTUAL ORDER VS DELIVERY</strong></span>
                        <div class="pull-right grid-tools">                            
                            <input type="button" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;" onclick="tableToExcel('exportToExcel', 'report_history_movement_wh')" value="Export to Excel"><i class="fa fa-download-up"></i></input>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('mrp/report_mrp_c/search_report_actual_order_vs_delivery', 'class="form-horizontal"'); ?>
                            <table width="40%" id='filter' border=0px>
                                <tr align="left">
                                    <td>Group Product</td>
                                    <td>
                                        <select name="group_prd" id="group_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;" class="ddl2">
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
                                    <td>
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;">
                                            <option value="">All</option>
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                            ?>
                                                    <option selected value="<?php echo trim($work_center); ?>"> <?php echo trim($work_center); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>"> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>                         
                                <tr align="left">
                                    <td>Period</td>
                                    <td>
                                        <select id="period" name="period" class="ddl2">
                                            <?php for ($x = -4; $x <= 2; $x++) { ?>
                                                <option value="<?php echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                    if ($period == date("Ym", strtotime("+$x month"))) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td>Customer</td>
                                    <td>
                                        <select id="cust" name="cust" class="ddl2">
                                            <option value="" <?php if($cust == ""){ echo "selected"; }?>>All</option>
                                            <?php foreach ($list_cust as $cus) { ?>
                                                <option value="<?php echo trim($cus->CHR_CUST_NO); ?>" <?php
                                                    if ($cust == trim($cus->CHR_CUST_NO)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?>> <?php echo trim($cus->CHR_CUST_NAME); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td></td>
                                    <td>
                                    <button type="submit" class="btn btn-info" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                </tr>                                
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="3" style="text-align:center;">No</th>
                                    <th rowspan="3" style="text-align:center;">Cust Code</th>
                                    <th rowspan="3" style="text-align:center;">Cust Name</th>
                                    <th rowspan="3" style="text-align:center;">Part No</th>
                                    <th rowspan="3" style="text-align:center;">Back No</th>
                                    <th rowspan="3" style="text-align:center;">Part Name</th>
                                    <th colspan="62" style="text-align:center;">Month</th>
                                    <th colspan="3" style="text-align:center;">Total</th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align:center;">01</th>
                                    <th colspan="2" style="text-align:center;">02</th>
                                    <th colspan="2" style="text-align:center;">03</th>
                                    <th colspan="2" style="text-align:center;">04</th>
                                    <th colspan="2" style="text-align:center;">05</th>
                                    <th colspan="2" style="text-align:center;">06</th>
                                    <th colspan="2" style="text-align:center;">07</th>
                                    <th colspan="2" style="text-align:center;">08</th>
                                    <th colspan="2" style="text-align:center;">09</th>
                                    <th colspan="2" style="text-align:center;">10</th>
                                    <th colspan="2" style="text-align:center;">11</th>
                                    <th colspan="2" style="text-align:center;">12</th>
                                    <th colspan="2" style="text-align:center;">13</th>
                                    <th colspan="2" style="text-align:center;">14</th>
                                    <th colspan="2" style="text-align:center;">15</th>
                                    <th colspan="2" style="text-align:center;">16</th>
                                    <th colspan="2" style="text-align:center;">17</th>
                                    <th colspan="2" style="text-align:center;">18</th>
                                    <th colspan="2" style="text-align:center;">19</th>
                                    <th colspan="2" style="text-align:center;">20</th>
                                    <th colspan="2" style="text-align:center;">21</th>
                                    <th colspan="2" style="text-align:center;">22</th>
                                    <th colspan="2" style="text-align:center;">23</th>
                                    <th colspan="2" style="text-align:center;">24</th>
                                    <th colspan="2" style="text-align:center;">25</th>
                                    <th colspan="2" style="text-align:center;">26</th>
                                    <th colspan="2" style="text-align:center;">27</th>
                                    <th colspan="2" style="text-align:center;">28</th>
                                    <th colspan="2" style="text-align:center;">29</th>
                                    <th colspan="2" style="text-align:center;">30</th>
                                    <th colspan="2" style="text-align:center;">31</th>
                                    <th colspan="3" style="text-align:center;">Qty</th>                                    
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th> 
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Diff</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                $mtd_act = 0;
                                $diff = 0;
                                if($data != NULL){
                                    foreach ($data as $val) {
                                        echo "<tr align='center'>";
                                        echo "<td align='center'>" . $no . "</td>";
                                        echo "<td align='center'>" . $val->CUST_DEST . "</td>";
                                        echo "<td align='center'>" . $val->CHR_CUST_NAME . "</td>";
                                        echo "<td align='center'>" . $val->PART_NO . "</td>";
                                        echo "<td align='center'>" . $val->CHR_BACK_NO . "</td>";
                                        echo "<td align='center'>" . $val->PART_NAME . "</td>";                                        
                                        
                                        echo "<td align='center'>" . $val->PLN_01 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_01 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_02 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_02 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_03 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_03 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_04 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_04 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_05 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_05 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_06 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_06 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_07 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_07 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_08 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_08 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_09 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_09 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_10 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_10 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_11 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_11 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_12 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_12 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_13 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_13 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_14 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_14 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_15 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_15 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_16 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_16 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_17 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_17 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_18 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_18 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_19 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_19 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_20 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_20 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_21 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_21 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_22 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_22 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_23 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_23 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_24 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_24 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_25 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_25 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_26 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_26 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_27 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_27 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_28 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_28 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_29 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_29 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_30 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_30 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_31 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_31 . "</td>";

                                        $mtd_plan = $val->PLN_01 + $val->PLN_02 + $val->PLN_03 + $val->PLN_04 + $val->PLN_05 + $val->PLN_06 + $val->PLN_07 + $val->PLN_08 + $val->PLN_09 + $val->PLN_10 +
                                            $val->PLN_11 + $val->PLN_12 + $val->PLN_13 + $val->PLN_14 + $val->PLN_15 + $val->PLN_16 + $val->PLN_17 + $val->PLN_18 + $val->PLN_19 + $val->PLN_20 +
                                            $val->PLN_21 + $val->PLN_22 + $val->PLN_23 + $val->PLN_24 + $val->PLN_25 + $val->PLN_26 + $val->PLN_27 + $val->PLN_28 + $val->PLN_29 + $val->PLN_30 +
                                            $val->PLN_31;                                        
                                        $mtd_act = $val->ACT_01 + $val->ACT_02 + $val->ACT_03 + $val->ACT_04 + $val->ACT_05 + $val->ACT_06 + $val->ACT_07 + $val->ACT_08 + $val->ACT_09 + $val->ACT_10 +
                                            $val->ACT_11 + $val->ACT_12 + $val->ACT_13 + $val->ACT_14 + $val->ACT_15 + $val->ACT_16 + $val->ACT_17 + $val->ACT_18 + $val->ACT_19 + $val->ACT_20 +
                                            $val->ACT_21 + $val->ACT_22 + $val->ACT_23 + $val->ACT_24 + $val->ACT_25 + $val->ACT_26 + $val->ACT_27 + $val->ACT_28 + $val->ACT_29 + $val->ACT_30 +
                                            $val->ACT_31;
                                        $diff = $mtd_act - $mtd_plan;
                                        
                                        echo "<td align='center' style='font-weight:bold;'>" . $mtd_plan . "</td>";
                                        echo "<td align='center' style='font-weight:bold;'>" . $mtd_act . "</td>";
                                        
                                        $style = '';
                                        if($diff < 0){
                                            $style = 'style="font-weight:bold; color:red;"';
                                        } elseif($diff > 0){
                                            $style = 'style="font-weight:bold; color:blue;"';
                                        } else {
                                            $style = 'style="font-weight:bold;"';
                                        }
                                        echo "<td align='center' " . $style . ">" . $diff . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <table id="exportToExcel" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                        <thead>
                                <tr>
                                    <th rowspan="3" style="text-align:center;">No</th>
                                    <th rowspan="3" style="text-align:center;">Cust Code</th>
                                    <th rowspan="3" style="text-align:center;">Cust Name</th>
                                    <th rowspan="3" style="text-align:center;">Part No</th>
                                    <th rowspan="3" style="text-align:center;">Back No</th>
                                    <th rowspan="3" style="text-align:center;">Part Name</th>
                                    <th colspan="62" style="text-align:center;">Month</th>
                                    <th colspan="3" style="text-align:center;">Total</th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align:center;">01</th>
                                    <th colspan="2" style="text-align:center;">02</th>
                                    <th colspan="2" style="text-align:center;">03</th>
                                    <th colspan="2" style="text-align:center;">04</th>
                                    <th colspan="2" style="text-align:center;">05</th>
                                    <th colspan="2" style="text-align:center;">06</th>
                                    <th colspan="2" style="text-align:center;">07</th>
                                    <th colspan="2" style="text-align:center;">08</th>
                                    <th colspan="2" style="text-align:center;">09</th>
                                    <th colspan="2" style="text-align:center;">10</th>
                                    <th colspan="2" style="text-align:center;">11</th>
                                    <th colspan="2" style="text-align:center;">12</th>
                                    <th colspan="2" style="text-align:center;">13</th>
                                    <th colspan="2" style="text-align:center;">14</th>
                                    <th colspan="2" style="text-align:center;">15</th>
                                    <th colspan="2" style="text-align:center;">16</th>
                                    <th colspan="2" style="text-align:center;">17</th>
                                    <th colspan="2" style="text-align:center;">18</th>
                                    <th colspan="2" style="text-align:center;">19</th>
                                    <th colspan="2" style="text-align:center;">20</th>
                                    <th colspan="2" style="text-align:center;">21</th>
                                    <th colspan="2" style="text-align:center;">22</th>
                                    <th colspan="2" style="text-align:center;">23</th>
                                    <th colspan="2" style="text-align:center;">24</th>
                                    <th colspan="2" style="text-align:center;">25</th>
                                    <th colspan="2" style="text-align:center;">26</th>
                                    <th colspan="2" style="text-align:center;">27</th>
                                    <th colspan="2" style="text-align:center;">28</th>
                                    <th colspan="2" style="text-align:center;">29</th>
                                    <th colspan="2" style="text-align:center;">30</th>
                                    <th colspan="2" style="text-align:center;">31</th>
                                    <th colspan="3" style="text-align:center;">Qty</th>                                    
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th> 
                                    <th style="text-align:center;">Order</th>
                                    <th style="text-align:center;">Deliv</th>
                                    <th style="text-align:center;">Diff</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $mtd_plan = 0;
                                $mtd_act = 0;
                                $diff = 0;
                                if($data != NULL){
                                    foreach ($data as $val) {
                                        echo "<tr align='center'>";
                                        echo "<td align='center'>" . $no . "</td>";
                                        echo "<td align='center'>" . $val->CUST_DEST . "</td>";
                                        echo "<td align='center'>" . $val->CHR_CUST_NAME . "</td>";
                                        echo "<td align='center'>" . $val->PART_NO . "</td>";
                                        echo "<td align='center'>" . $val->CHR_BACK_NO . "</td>";
                                        echo "<td align='center'>" . $val->PART_NAME . "</td>";                                        
                                        
                                        echo "<td align='center'>" . $val->PLN_01 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_01 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_02 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_02 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_03 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_03 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_04 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_04 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_05 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_05 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_06 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_06 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_07 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_07 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_08 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_08 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_09 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_09 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_10 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_10 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_11 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_11 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_12 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_12 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_13 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_13 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_14 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_14 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_15 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_15 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_16 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_16 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_17 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_17 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_18 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_18 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_19 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_19 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_20 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_20 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_21 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_21 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_22 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_22 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_23 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_23 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_24 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_24 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_25 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_25 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_26 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_26 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_27 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_27 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_28 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_28 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_29 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_29 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_30 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_30 . "</td>";
                                        echo "<td align='center'>" . $val->PLN_31 . "</td>";
                                        echo "<td align='center'>" . $val->ACT_31 . "</td>";

                                        $mtd_plan = $val->PLN_01 + $val->PLN_02 + $val->PLN_03 + $val->PLN_04 + $val->PLN_05 + $val->PLN_06 + $val->PLN_07 + $val->PLN_08 + $val->PLN_09 + $val->PLN_10 +
                                            $val->PLN_11 + $val->PLN_12 + $val->PLN_13 + $val->PLN_14 + $val->PLN_15 + $val->PLN_16 + $val->PLN_17 + $val->PLN_18 + $val->PLN_19 + $val->PLN_20 +
                                            $val->PLN_21 + $val->PLN_22 + $val->PLN_23 + $val->PLN_24 + $val->PLN_25 + $val->PLN_26 + $val->PLN_27 + $val->PLN_28 + $val->PLN_29 + $val->PLN_30 +
                                            $val->PLN_31;                                        
                                        $mtd_act = $val->ACT_01 + $val->ACT_02 + $val->ACT_03 + $val->ACT_04 + $val->ACT_05 + $val->ACT_06 + $val->ACT_07 + $val->ACT_08 + $val->ACT_09 + $val->ACT_10 +
                                            $val->ACT_11 + $val->ACT_12 + $val->ACT_13 + $val->ACT_14 + $val->ACT_15 + $val->ACT_16 + $val->ACT_17 + $val->ACT_18 + $val->ACT_19 + $val->ACT_20 +
                                            $val->ACT_21 + $val->ACT_22 + $val->ACT_23 + $val->ACT_24 + $val->ACT_25 + $val->ACT_26 + $val->ACT_27 + $val->ACT_28 + $val->ACT_29 + $val->ACT_30 +
                                            $val->ACT_31;
                                        $diff = $mtd_act - $mtd_plan;
                                        
                                        echo "<td align='center' style='font-weight:bold;'>" . $mtd_plan . "</td>";
                                        echo "<td align='center' style='font-weight:bold;'>" . $mtd_act . "</td>";
                                        
                                        $style = '';
                                        if($diff < 0){
                                            $style = 'style="font-weight:bold; color:red;"';
                                        } elseif($diff > 0){
                                            $style = 'style="font-weight:bold; color:blue;"';
                                        } else {
                                            $style = 'style="font-weight:bold;"';
                                        }
                                        echo "<td align='center' " . $style . ">" . $diff . "</td>";
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
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        document.body.style.zoom = 0.90;

        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#dataTables3').DataTable({
            scrollX: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
            ,fixedColumns: {
                leftColumns: 5,
                rightColumns: 3
            }
        });
    });

    function get_data_work_center() {
        var group = document.getElementById('group_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('mrp/manage_mrp_c/get_work_center_by_group'); ?>",
            data: {
                GROUP_CODE: group
            },
            success: function(json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }
</script>