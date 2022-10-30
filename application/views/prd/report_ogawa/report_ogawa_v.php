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
            <li><a href="<?php echo base_url('index.php/prd/report_ogawa_c') ?>"><strong>Report Inventory Parts</strong></a></li>
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
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>REPORT INVENTORY PARTS</strong></span>
                        <div class="pull-right grid-tools">
                            <!-- <a href="<?php echo base_url('index.php/prd/report_ogawa_c/update_part_ogawa') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update Part" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Update Part</a> -->
                            <a href="<?php echo base_url('index.php/prd/report_ogawa_c/export_inventory/' . trim($id_dept) . '/' . trim($work_center)) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Print Report" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Export</a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <?php echo form_open('prd/report_ogawa_c/search_report_ogawa', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%">
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%">
                                        
                                    </td>
                                    <td width="55%">
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Dept</td>
                                        <td width="5%">
                                            <select name="INT_ID_DEPT" id="dept_to_work_center" onchange="get_data_work_center(); document.getElementById('dept_id').value=this.options[this.selectedIndex].value;" class="ddl2" style="width:150px;">
                                                <?php
                                                foreach ($all_dept_prod as $row) {
                                                    if (trim($row->INT_ID_DEPT) == trim($id_dept)) {
                                                        ?>
                                                        <option selected value="<? echo $id_dept; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                    <?php } else { ?>
                                                        <option value="<? echo $row->INT_ID_DEPT; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%">    
                                        
                                    </td>
                                    <td width="25%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select id="work_center" name="CHR_WORK_CENTER" class="ddl2" style="width:150px;" onchange="document.getElementById('work_center_id').value=this.options[this.selectedIndex].value;">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($work_center); ?>" > <?php echo trim($work_center); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select></td>
                                    <td width="5%" colspan="4">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                        <?php form_close(); ?></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'></td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">No</th>
                                    <!-- <th rowspan="2" style="text-align:center;">Date</th> -->
                                    <th rowspan="2" style="text-align:center;">Part No AII</th>
                                    <th rowspan="2" style="text-align:center;">Back No</th>                                    
                                    <th rowspan="2" style="text-align:center;">Part No Cust</th>
                                    <th rowspan="2" style="text-align:center;">Part Name</th>                                    
                                    <th rowspan="2" style="text-align:center;">Total Order</th>
                                    <th colspan="3" style="text-align:center;">On AII</th>
                                    <th rowspan="2" style="text-align:center;">On Shipment</th>
                                    <th colspan="2" style="text-align:center;">On Customer</th>                                    
                                    <th rowspan="2" style="text-align:center;">Finish Order</th>
                                    <th rowspan="2" style="text-align:center;">Total Process Order</th>
                                    <th rowspan="2" style="text-align:center;">Total Remain Order</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Progress Prod</th>
                                    <th style="text-align:center;">Finish Goods</th>
                                    <th style="text-align:center;">Ready to Delivery</th>
                                    <th style="text-align:center;">Receive in WH</th>
                                    <th style="text-align:center;">Next Process</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach($data as $val){
                                        if($val->QTY_FINISH_PROD >= 0){
                                            echo "<tr>";
                                            echo "<td>" . $no . "</td>";
                                            // echo "<td>" . date('Ymd') . "</td>";
                                            echo "<td>" . $val->CHR_PART_NO . "</td>";
                                            
                                            $backno = '';
                                            $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$val->CHR_PART_NO' AND CHR_KANBAN_TYPE IN ('5','6') ORDER BY CHR_KANBAN_TYPE");
                                            if($get_backno->num_rows() > 0){
                                                $backno = $get_backno->row()->CHR_BACK_NO;
                                            }                                        
                                            echo "<td align='center'>" . $backno . "</td>";

                                            $cust_partno = '';
                                            $get_cust_partno = $this->db->query("SELECT TOP 1 CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_PART_NO = '$val->CHR_PART_NO'");
                                            if($get_cust_partno->num_rows() > 0){
                                                $cust_partno = $get_cust_partno->row()->CHR_CUS_PART_NO;
                                            }
                                            echo "<td align='center'>" . $cust_partno . "</td>";

                                            echo "<td>" . $val->CHR_PART_NAME . "</td>";
                                            echo "<td align='center'>0</td>"; //=== Total Order

                                            $qty_progress = $val->QTY_PROGRESS_PROD + $val->QTY_WAIT_PROD;
                                            
                                            echo "<td align='center'>" . $qty_progress ."</td>"; //=== Progress Prod
                                            echo "<td align='center'>" . $val->QTY_FINISH_PROD ."</td>"; //=== FG
                                            echo "<td align='center'>" . $val->QTY_READY_DEL ."</td>"; //=== Ready Del
                                            echo "<td align='center'>" . $val->QTY_ONSHIPMENT ."</td>"; //=== Shipment                                            
                                            echo "<td align='center'>0</td>"; //=== OGAWA WH
                                            echo "<td align='center'>0</td>"; //=== OGAWA WIP
                                            echo "<td align='center'>" . $val->QTY_ONSHIPMENT ."</td>"; //=== Finish Order
                                            
                                            $tot_process = $qty_progress + $val->QTY_FINISH_PROD + $val->QTY_READY_DEL;
                                            echo "<td align='center'>". $tot_process ."</td>"; //=== Process Order
                                            echo "<td align='center'>0</td>"; //=== Remain Order
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
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
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

    function get_data_work_center(){
        var dept_to_work_center = document.getElementById('dept_to_work_center').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
            data:  {
                    INT_ID_DEPT: dept_to_work_center
                    },
            success: function (json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }
</script>
