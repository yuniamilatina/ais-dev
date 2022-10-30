
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
            <li><a href="<?php echo base_url('index.php/prd/one_way_kanban_c') ?>"><strong>One Way Kanban</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>One Way Kanban</strong></span>
                        <div class="pull-right grid-tools">
                            <!--<a href="<?php echo base_url('index.php/prd/one_way_kanban_c/' . $id_dept . '/' . trim($work_center)) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Create Special Order" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Create SO</a>-->
                            <?php if($role == '1' || $npk == '5218') { ?>
                            <a href="<?php echo base_url('index.php/prd/one_way_kanban_c/print_special/') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Create Special Order" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Print Special</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Dept</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<?php echo site_url('prd/one_way_kanban_c/search_one_way_kanban/' . trim($row->INT_ID_DEPT)); ?>"  <?php
                                            if ($id_dept == trim($row->INT_ID_DEPT)) {
                                                echo 'selected';
                                            }
                                                ?> > <?php echo trim($row->CHR_DEPT); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                </tr>
                                <tr>
                                    <td width="5%">Work Center</td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/one_way_kanban_c/search_one_way_kanban/' . $id_dept . '/' . trim($row->CHR_WORK_CENTER)); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4">
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'></td>
                                </tr>
                                <tr>
                                    <td width="5%">Date Prod Order</td>
                                    <td width="5%">
                                        <input id="datepicker" name="date_checkin" style="background-color:white;" class="form-control" autocomplete="off" placeholder="DD/MM/YYYY" required type="text" value="<?php echo substr($date, 4, 2) . '/' . substr($date, 6, 2) . '/' . substr($date, 0, 4); ?>" onchange="refreshData()">
                                        <input id="dept" type="hidden" value="<?php echo $id_dept; ?>">
                                        <input id="wc" type="hidden" value="<?php echo $work_center; ?>">
                                    </td>
                                    <td width="5%" colspan="4">
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'></td>
                                </tr>
                            </table>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Work Order</th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Lot Size</th>
                                    <th style="text-align:center;">Qty/Kanban</th>
                                    <th style="text-align:center;">Total Qty</th>
                                    <th style="text-align:center;">Print Stat</th>
                                    <th style="text-align:center;">Serial</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($data as $isi) {
                                echo "<tr class='gradeX'>";
                                echo "<td style='text-align:center;'>$i</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PRD_ORDER_NO</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
                                echo "<td style='text-align:center;'>$isi->INT_LOT_SIZE</td>";
                                echo "<td style='text-align:center;'>$isi->INT_QTY_PER_BOX</td>";
                                echo "<td style='text-align:center;'>$isi->INT_QTY_PCS</td>";
                                echo "<td style='text-align:center;'>$isi->INT_FLG_PRINT</td>";
                                echo "<td style='text-align:center;'>$isi->CHR_SERIAL</td>";
                                ?>
                                <td style="text-align:center;">
                                    <a href="<?php echo base_url('index.php/prd/one_way_kanban_c/print_kanban') . '/' . str_replace("/", "", $isi->CHR_PRD_ORDER_NO) . '/' . $work_center . '/' . $isi->CHR_SERIAL ;?>"  class="label label-primary" data-placement="left" data-placement="top" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
                                </td>
                                <?php
                                echo "</tr>";
                                    $i++;
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
    
    function refreshData() {
        var date_t = document.getElementById('datepicker').value;
        var dept = document.getElementById('dept').value;
        var wc = document.getElementById('wc').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(0, 2) + date_t.substr(3, 2)
        location.href = '<?php echo site_url() ?>/prd/one_way_kanban_c/search_one_way_kanban/' + dept + '/' + wc + '/' + date_fix
    }
</script>
