
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
            <li><a href="<?php echo base_url('index.php/prd/schedule_kanban_c') ?>"><strong>Manage Schedule Kanban</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE SCHEDULE KANBAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/prd/schedule_kanban_c/create_schedule_kanban/' . $period . '/' . $id_dept . '/' . $work_center) ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Upload Kanban Schedule" style="height:30px;font-size:13px;width:100px;color:white;margin-top:-5px;margin-bottom:-5px;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%" style='text-align:left;'>Periode</td>
                                    <td width="10%">
                                        <select class="ddl" style="width:120px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -0; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('prd/schedule_kanban_c/search_schedule_kanban/' . date("Ym", strtotime("+$x month")) . '/' . $id_dept . '/' . $work_center . '/0'); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                    </td>
                                    <td width="60%">

                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%">Dept / Work Center</td>
                                    <td width="5%">
                                        <select class="ddl" style="width:120px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept_prod as $row) { ?>
                                                <option value="<?php echo site_url('prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . trim($row->INT_ID_DEPT) . '/' . $work_center . '/0'); ?>"  <?php
                                            if ($id_dept == trim($row->INT_ID_DEPT)) {
                                                echo 'selected';
                                            }
                                                ?> > <?php echo trim($row->CHR_DEPT); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . $id_dept . '/' . trim($row->CHR_WORK_CENTER) . '/0'); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="85%"></td>
                                </tr>                                
                                <tr>
                                    <td width="5%">Status</td>
                                    <td width="5%">
                                        <select class="ddl" style="width:120px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . $id_dept . '/' . $work_center . '/0'); ?>" <?php if($status == 0){ echo 'selected'; } ?>>Waiting Prod</option>
                                            <option value="<?php echo site_url('prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . $id_dept . '/' . $work_center . '/1'); ?>" <?php if($status == 1){ echo 'selected'; } ?>>Already Prod</option>
                                        </select>
                                    </td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="55%"></td>
                                </tr>
                            </table>
                        </div>

                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Sequence</th>
                                    <th style="text-align:center;">Work Center</th>
                                    <th style="text-align:center;">Part No AII</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Part No Cust</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Lot Size</th>
                                    <th style="text-align:center;">Qty/box</th>
                                    <th style="text-align:center;">Qty Pcs</th>
                                    <th style="text-align:center;">Special Order</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$i = 1;
foreach ($data as $isi) {
    if($isi->INT_FLG_SO == 1){
        echo "<tr class='gradeX' style='color:red;'>";
    } else {
        echo "<tr class='gradeX'>";
    }        
    echo "<td style='text-align:center;'>$i</td>";
    echo "<td style='text-align:center;'>$isi->INT_SEQUENCE</td>";
    if($isi->INT_FLG_PRD == 1){
        echo "<td style='text-align:center;background-color:grey;color:white;'>$isi->CHR_WORK_CENTER</td>";
    } else {
        echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
    }    
    echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
    $part_no_cust = $this->db->query("select distinct CHR_CUS_PART_NO from TM_SHIPPING_PARTS where CHR_PART_NO = '$isi->CHR_PART_NO'")->result();
    $part_no_cust_value = "";
    if (count($part_no_cust) > 0) {
        foreach ($part_no_cust as $key => $value) {
            $part_no_cust_value .= $value->CHR_CUS_PART_NO;
            if ($key <> count($part_no_cust) - 1) {
                $part_no_cust_value .= " | ";
            }
        }
    }
    echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
    echo "<td style='text-align:center;'>$part_no_cust_value</td>";
    echo "<td style='text-align:center;'>" . date('d-m-Y', strtotime($isi->CHR_DATE)) . "</td>";
    echo "<td style='text-align:center;'>$isi->INT_LOT_SIZE</td>";
    echo "<td style='text-align:center;'>$isi->INT_QTY_PER_BOX</td>";
    echo "<td style='text-align:center;'>$isi->INT_QTY_PCS</td>";
    
    if($isi->INT_FLG_SO == '1'){
        echo "<td style='text-align:center;'>Yes</td>";
    } else {
        echo "<td style='text-align:center;'>-</td>";
    }
    
    ?>
                                <td style='text-align:center;'>
                                    <?php if($isi->INT_FLG_PRD == 1) {?>
                                    <a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="#" class="label label-default" data-placement="right" data-toggle="tooltip" title="Delete"><span class="fa fa-times"></span></a>
                                    <?php } else { ?>
                                    <a href="<?php echo base_url('index.php/prd/schedule_kanban_c/edit_schedule_kanban') . "/" . $isi->INT_ID . "/" . $isi->CHR_WORK_CENTER . "/" . $status ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/prd/schedule_kanban_c/delete_schedule_kanban') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Part : ' + <?php echo $isi->CHR_PART_NO ?>);"><span class="fa fa-times"></span></a>
                                    <?php } ?>
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

    </section>
</aside>



<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>

    $(document).ready(function () {
        var table = $('#dataTables3').DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                bFilter: true,
                fixedColumns: {
                leftColumns: 4,
                rightColumns: 1
                }
        });
    });

</script>