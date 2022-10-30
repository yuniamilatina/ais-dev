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
    $(document).ready(function() {

        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }

        function refreshTable() {
            var fiscalYear = $("#INT_ID_FISCAL_YEAR option:selected").val();
            var budgetType = $("#INT_ID_BUDGET_TYPE option:selected").val()
            var dept = $("#INT_ID_DEPT option:selected").val();
            var section = $("#SECTION option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, CHR_BUDGET_TYPE: budgetType, INT_DEPT: dept, INT_SECT: section}, 
                success: function(data) {
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    url_export_excel_2 = data.url_export_excel_2.trim();
                    $("#btn-download-excel").attr("href", url_export_excel);
                    $("#btn-download-excel-2").attr("href", url_export_excel_2);
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                    
                }
            });
        }

        $("#SECTION").change(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });


        $("#INT_ID_DEPT").focusout(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/null_category",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $('#BUDGET_SUBGROUP').val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });
        });

        //BUDGET TYPE
        $("#INT_ID_BUDGET_TYPE").change(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            budget_type = $(this).val().toString();
            role = <?php echo $role ?>;
            budget_type_desc = $(this).find('option:selected').text().toString().trim();
            if(budget_type != "" && role == 1 || budget_type != "" && role == 2){
                document.getElementById('btn-download-excel-2').style.display = 'inline-block';
            } else {
                document.getElementById('btn-download-excel-2').style.display = 'none';
            }
            
            $("#download_template").text(budget_type_desc + ".xls");
            $("#download_template").show();
            $("#download_template").attr("href", '<?php echo base_url("index.php/budget/budget_expense_c/download_template/") ?>' + '/' + budget_type);
        });

        //BUDGET_CATEGORY
        $("#INT_ID_DEPT").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/null_category",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#BUDGET_CATEGORY").html(data);
                }
            });
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $('#BUDGET_SUBGROUP').val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });
        });

        $("#BUDGET_SUBGROUP").change(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $(this).val(),
                    INT_ID_DEPT: $('#INT_ID_DEPT').val(),
                }, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });

        });

        $("#BUDGET_SUBGROUP").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/show_more",
                data: {BUDGET_SUBGROUP: $(this).val(), INT_ID_DEPT: $('#INT_ID_DEPT').val()}, type: "POST",
                success: function(data) {
                    $("#subcontent").html(data);
                }
            });

        });

        $("#INT_ID_FISCAL_YEAR").change(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_TYPE option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_fiscal_month",
                data: {INT_ID_FISCAL_YEAR: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#fiscal_month").html(data);
                }
            });
        });

        $("#INT_ID_FISCAL_YEAR").focusout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_c/gen_fiscal_month",
                data: {INT_ID_FISCAL_YEAR: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#fiscal_month").html(data);
                }
            });
        });

    });
</script> 

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li class="active"> <a href="#"><strong>Create Budget Expense</strong></a></li>
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
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>CREATE BUDGET EXPENSE</strong></span>
                        <div class= "pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel-2" style="color:white; display:none;"><i class="fa fa-download"></i>&nbsp; Download All Dept</a>
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Report</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_expense_c/upload_budget_expense', 'class="form-horizontal"');
                        ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fiscal Year</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_FISCAL_YEAR" id="INT_ID_FISCAL_YEAR" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Fiscal Year -- </option>
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_FISCAL_YEAR_START; ?>" <?php if ($INT_ID_FISCAL_YEAR == $isi->CHR_FISCAL_YEAR_START) echo'selected' ?>><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:350px">
                                    <?php
                                    foreach ($dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>" <?php if ($INT_DEPT == $isi->INT_ID_DEPT) echo'selected' ?>><?php echo $isi->CHR_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>                            
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Budget Type</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_TYPE" id="INT_ID_BUDGET_TYPE" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Budget Type -- </option>
                                    <?php
                                    foreach ($budget_type as $budget_type_val) {
                                        ?>
                                        <option value="<?php echo $budget_type_val->INT_ID_BUDGET_TYPE; ?>" <?php if ($INT_ID_BUDGET_TYPE == $budget_type_val->INT_ID_BUDGET_TYPE) echo'selected' ?>><?php echo $budget_type_val->CHR_BUDGET_TYPE_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_SECT" id="SECTION" required class="form-control" style="width:350px">
                                    <?php
                                    foreach ($section as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_SECTION; ?>" <?php if ($INT_SECT == $isi->CHR_SECTION) echo'selected' ?>><?php echo $isi->CHR_SECTION . " / " . $isi->CHR_SECTION_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Download Template</label>
                            <label class="col-sm-2">
                                <a class="btn btn-info" style="display:none;" id="download_template" href="<?php echo base_url("index.php/budget/budget_expense_c/download_template/2") ?>">Download</a>
                            </label>

                            <label class="col-sm-3 control-label">Upload File</label>
                            <div class="col-sm-3">
                                <input type="file" name="upload_budget_expense" class="form-control" id="import" size="20" value="" required>
                            </div>
                            <?php //===== FUNCTION FOR SHOW AND HIDE BUTTON UPLOAD
                                if ($role != 1 && $role !=2){
                                    $auth_upload = $this->db->query("SELECT INT_FLG_UPLOAD FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD WHERE INT_ID_DEPT = '$kode_dept' AND INT_ID_BUDGET_SUB_GROUP = '3' AND INT_FLG_DELETE = '0'"); //=== AUTHORIZE EXPENSE BY BASIC UNIT 
                                    if($auth_upload->num_rows() != 0){                                    
                                        if ($auth_upload->row()->INT_FLG_UPLOAD == 1){
                            ?>
                            <button type="submit" class="btn btn-primary" name="btn-save" value="1" <?php //if($role != 1 && $role != 2){ echo 'disabled';} ?>><i class="fa fa-upload"></i>&nbsp; Upload</button>
                            <?php
                                        }
                                    }
                                } else {                                
                            ?>
                            <button type="submit" class="btn btn-primary" name="btn-save" value="1" <?php //if($role != 1 && $role != 2){ echo 'disabled';} ?>><i class="fa fa-upload"></i>&nbsp; Upload</button>
                            <?php
                                }
                            ?>
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
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>