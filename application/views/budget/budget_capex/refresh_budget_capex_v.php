<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
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
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>


<aside >

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <?php if ($detail_confirm <> null) { ?>
                        <div class="grid-body" style="padding-top: 0px">
                            <div id="table-luar">
                                <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No Budget</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Description</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">CIP</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Sub Category</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Category</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Purpose</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Project</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Product</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Owner</th>
                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Supplier</th>

                                            <th colspan="2" style="text-align:center;">Apr</th>
                                            <th colspan="2" style="text-align:center;">May</th>
                                            <th colspan="2" style="text-align:center;">Jun</th>
                                            <th colspan="2" style="text-align:center;">Jul</th>
                                            <th colspan="2" style="text-align:center;">Aug</th>
                                            <th colspan="2" style="text-align:center;">Sept</th>
                                            <th colspan="2" style="text-align:center;">Oct</th>
                                            <th colspan="2" style="text-align:center;">Nov</th>
                                            <th colspan="2" style="text-align:center;">Dec</th>
                                            <th colspan="2" style="text-align:center;">Jan</th>
                                            <th colspan="2" style="text-align:center;">Feb</th>
                                            <th colspan="2" style="text-align:center;">Mar</th>
                                            <th colspan="2" style="text-align:center;">Total Yearly</th>
                                            <th rowspan="2" style="text-align:center;">Action</th>
                                        </tr>
                                        <tr>
                                            <?php for ($i = 1; $i <= 13; $i++) { ?>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $action = 0;
                                        if ($role != 1 && $role !=2){
                                            $auth_upload = $this->db->query("SELECT INT_FLG_UPLOAD FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD WHERE INT_ID_DEPT = '$INT_DEPT' AND INT_ID_BUDGET_SUB_GROUP = '1' AND INT_FLG_DELETE = '0'"); //=== AUTHORIZE EXPENSE BY BASIC UNIT 
                                            if($auth_upload->num_rows() != 0){                                    
                                                if ($auth_upload->row()->INT_FLG_UPLOAD == 1){
                                                    $action = 1;
                                                }
                                            }
                                        } else {
                                            $action = 1;
                                        }
                                        foreach ($detail_confirm as $value) {
                                            ?>
                                            <tr>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $no; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_NO_BUDGET; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_DESC; ?></td>
                                                <?php if($value->INT_FLG_CIP == 1){ ?>
                                                    <td style="vertical-align: middle;text-align:center;">Yes</td>
                                                <?php } else {?>
                                                    <td style="vertical-align: middle;text-align:center;">No</td>
                                                <?php } ?>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_BUDGET_CATEGORY_DESC; ?></td>
                                                <?php
                                                    $kode_purpose = trim($value->CHR_PURPOSE);
                                                    if($kode_purpose == '-' || $kode_purpose == '' || $kode_purpose == NULL){
                                                        $purpose = $kode_purpose;
                                                    } else {
                                                        $get_purpose =  $this->db->query("SELECT CHR_PURPOSE_DESC FROM CPL.TM_PURPOSE WHERE CHR_PURPOSE LIKE '$kode_purpose%'")->row();
                                                        $purpose = $get_purpose->CHR_PURPOSE_DESC;
                                                    }
                                                    
                                                ?>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $purpose; ?></td>
                                                <?php
                                                    $kode_project = trim($value->CHR_PROJECT);
                                                    if($kode_project == '-' || $kode_project == '' || $kode_project == NULL){
                                                        $project = $kode_project;
                                                    } else {
                                                        $get_project =  $this->db->query("SELECT CHR_PROJECT_DESC FROM CPL.TM_PROJECT WHERE CHR_PROJECT LIKE '$kode_project%'")->row();
                                                        $project = $get_project->CHR_PROJECT_DESC;
                                                    }
                                                ?>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $project; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_PRODUCT; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_DIE_OWNER; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->CHR_SUPPLIER_LOCATION; ?></td>

                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN04; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN05; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN06; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN07; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN08; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN09; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN10; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN11; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN12; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN01; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN02; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN03; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_SUM; ?></td>
                                                <td style="vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_SUM); ?></td>
                                                <td style="vertical-align: middle;text-align:center;">
                                                    <?php
                                                        if($action == 1){
                                                    ?>
                                                    <a target="_parent" href="<?php echo base_url('index.php/budget/budget_capex_c/edit_budget_capex') . "/0/" . str_replace('/','<',trim($value->CHR_NO_BUDGET)) ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                    <a href="<?php echo base_url('index.php/budget/budget_capex_c/delete_budget_capex') . "/" . str_replace('/','<',trim($value->CHR_NO_BUDGET)) ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this number budget?');"><span class="fa fa-times"></span></a>
                                                    <?php
                                                        } 
                                                    ?>                                               
                                                </td>
                                            </tr>
                                            <?php
                                            $no++;
                                        }
                                        ?>
                                        <?php foreach ($detail_confirm_sum as $value) { ?>
                                            <tr>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd; color: #dddddd;"><?php echo $no; ?></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;">Total</td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                                
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN04; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN04); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN05; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN05); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN06; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN06); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN07; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN07); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN08; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN08); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN09; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN09); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN10; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN10); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN11; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN11); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN12; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN12); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN01; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN01); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN02; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN02); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_BLN03; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_BLN03); ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo $value->INT_QTY_SUM; ?></td>
                                                <td style="font-weight: bold; vertical-align: middle;text-align:center;"><?php echo number_format($value->MON_AMT_SUM); ?></td>
                                                <td style="font-weight: bold;text-align: right;background-color: #dddddd;"></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>

                        <?php } else { ?>
                            <div style="margin-top: 20px;height: 10px;"></div>
                            <div class="grid-body" style="padding-top: 0px">
                            </div>
                        <?php } ?>


                    </div>
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
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            order: [[0, 'asc']],
            fixedColumns: {
                leftColumns: 4,
                rightColumns: 1
            }
        });
    });
</script>