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

<script type="text/javascript">
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
        
        //REFRESH TABLE
        function refreshTable() {
            var fiscalYear = $("#INT_ID_FISCAL_YEAR option:selected").val();
            var budgetType = $("#INT_ID_BUDGET_TYPE option:selected").val();
            var dept = $("#INT_ID_DEPT option:selected").val();
            var section = $("#SECTION option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, CHR_BUDGET_TYPE: budgetType, INT_DEPT: dept, INT_SECT: section}, 
                success: function(data) {
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    $("#btn-download-excel").attr("href", url_export_excel)
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }
        
        //DEPT
        $("#INT_ID_DEPT").change(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        $("#INT_ID_DEPT").focusout(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        $("#SECTION").change(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });
        
        $("#SECTION").focusout(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });

        $("#INT_ID_FISCAL_YEAR").change(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });

    });
</script> 

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_capex_c/"') ?>">Manage Budget Capital Expenditure</a></li>
            <li class="active"> <a href="#"><strong>Manage Budget Capex</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>MANAGE BUDGET CAPITAL EXPENDITURE</strong></span>
                        <div class="pull-right grid-tools">
                            <?php //===== FUNCTION FOR SHOW AND HIDE BUTTON UPLOAD
                                if ($role != 1 && $role !=2){
                                    $auth_upload = $this->db->query("SELECT INT_FLG_UPLOAD FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD WHERE INT_ID_DEPT = '$INT_DEPT' AND INT_ID_BUDGET_SUB_GROUP = '1' AND INT_FLG_DELETE = '0'"); //=== AUTHORIZE EXPENSE BY BASIC UNIT 
                                    if($auth_upload->num_rows() != 0){                                    
                                        if ($auth_upload->row()->INT_FLG_UPLOAD == 1){
                            ?>
                            <a href="<?php echo base_url('index.php/budget/budget_capex_c/create_budget_capex"') ?>" class="btn btn-primary"  id="create_capex" style="color:white;"><i class="fa fa-shopping-cart"></i>&nbsp; New Capex</a>
                            <?php
                                        }
                                    }
                                } else {                                
                            ?>
                            <a href="<?php echo base_url('index.php/budget/budget_capex_c/create_budget_capex"') ?>" class="btn btn-primary"  id="create_capex" style="color:white;"><i class="fa fa-shopping-cart"></i>&nbsp; New Capex</a>
                            <?php
                                }
                            ?>
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Report</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_capex_c/index', 'class="form-horizontal"');
                        ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fiscal Year</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_FISCAL_YEAR" id="INT_ID_FISCAL_YEAR" required class="form-control" style="width:250px">
                                    <option value="">-- Select Fiscal Year --</option>
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:250px">
                                    <?php
                                    foreach ($dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>"
                                            <?php if($INT_DEPT == $isi->INT_ID_DEPT) { 
                                                echo 'selected';
                                            }?>><?php echo $isi->CHR_DEPT . ' / ' . $isi->CHR_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>                            
                            
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Budget Type</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_TYPE" id="INT_ID_BUDGET_TYPE" required class="form-control" style="width:250px" readonly>
                                    <option value="<?php echo $INT_ID_BUDGET_TYPE; ?>" selected=""> Capital Expenditure </option>                                    
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_SECT" id="SECTION" required class="form-control" style="width:250px">
                                    <option value="">-- Select Section --</option>  
                                </select>  
                            </div>
                        </div> 

                        <?php echo form_close(); ?>

                    </div >
                    
                    <div style="margin-top: 20px;height: 10px;"></div>
                        <div class="grid-body" style="padding-top: 0px">
                            <iframe frameBorder="0" id="iframe" width="100%" height="800" src="<?php echo $url_page ?>"></iframe>
                        </div>
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
    $(document).ready(function () {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>