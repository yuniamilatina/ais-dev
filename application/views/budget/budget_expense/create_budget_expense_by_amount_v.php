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
        
        function refreshTable() {
            var fiscal_year = $("#INT_ID_FISCAL_YEAR option:selected").val();
            var sub_group = $("#INT_ID_BUDGET_SUB_GROUP option:selected").val()
            var dept = $("#INT_ID_DEPT option:selected").val();
            var section = $("#SECTION option:selected").val();
            var url_iframe = "";
            var status = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_by_amount_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscal_year, INT_ID_BUDGET_SUB_GROUP: sub_group, INT_DEPT: dept, INT_SECT: section},
                success: function(data) {
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    status = data.status_approve;
                    if(status == '0'){
                        document.getElementById("btn_upload").disabled = false;
                    } else {
                        document.getElementById("btn_upload").disabled = true;
                    }
                    $("#btn-download-excel").attr("href", url_export_excel)
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }
        
        $("#SECTION").change(function() {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_SUB_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });
        
        //DEPT
        $("#INT_ID_DEPT").change(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_SUB_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            id_dept = $("#INT_ID_DEPT option:selected").val();
            $("#download_template").text("Template_Expense_Amount.xls");
            $("#download_template").show();
            $("#download_template").attr("href", '<?php echo base_url("index.php/budget/budget_expense_by_amount_c/download_template/") ?>' + '/' + id_dept);
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_by_amount_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        $("#INT_ID_DEPT").focusout(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_BUDGET_SUB_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            $("#download_template").text("Template_Expense_Amount.xls");
            $("#download_template").show();
            $("#download_template").attr("href", '<?php echo base_url("index.php/budget/budget_expense_by_amount_c/download_template/") ?>' + '/' + $(this).val());
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_expense_by_amount_c/gen_ddl_section",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        $("#INT_ID_FISCAL_YEAR").focusout(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_BUDGET_SUB_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            id_dept2 = $("#INT_ID_DEPT option:selected").val();
            $("#download_template").text("Template_Expense_Amount.xls");
            $("#download_template").show();
            $("#download_template").attr("href", '<?php echo base_url("index.php/budget/budget_expense_by_amount_c/download_template/") ?>' + '/' + id_dept2);
        });

        $("#INT_ID_FISCAL_YEAR").change(function () {
            if (($("#SECTION option:selected").val() != '') && ($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_BUDGET_SUB_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable();
            }
            
            id_dept2 = $("#INT_ID_DEPT option:selected").val();
            $("#download_template").text("Template_Expense_Amount.xls");
            $("#download_template").show();
            $("#download_template").attr("href", '<?php echo base_url("index.php/budget/budget_expense_by_amount_c/download_template/") ?>' + '/' + id_dept2);
        });

    });
</script> 

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_expense_by_amount_c/"') ?>">Manage Budget Expense by Amount</a></li>
            <li class="active"> <a href="#"><strong>Create Budget Expense</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>CREATE BUDGET EXPENSE BY AMOUNT</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Report</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_expense_by_amount_c/upload_budget_expense', 'class="form-horizontal"');
                        ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fiscal Year</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_FISCAL_YEAR" id="INT_ID_FISCAL_YEAR" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Fiscal Year -- </option>
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>" 
                                            <?php if($INT_ID_FISCAL_YEAR == $isi->INT_ID_FISCAL_YEAR) { 
                                                echo 'selected';
                                            }?>><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
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
                            <label class="col-sm-2 control-label">Budget Sub Group</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_SUB_GROUP" id="INT_ID_BUDGET_SUB_GROUP" required class="form-control" style="width:250px">
                                    <?php
                                    foreach ($subgroup as $budget) {
                                        ?>
                                        <option value="<?php echo $budget->INT_ID_BUDGET_SUB_GROUP; ?>" <?php if ($INT_ID_BUDGET_SUB_GROUP == $budget->INT_ID_BUDGET_SUB_GROUP) echo'selected' ?>><?php echo $budget->CHR_BUDGET_SUB_GROUP_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_SECT" id="SECTION" required class="form-control" style="width:250px">
                                    <option value="">  -- Select Section -- </option>  
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Download Template</label>
                            <label class="col-sm-2 control-label">
                                <a class="btn btn-info" style="display:none;" id="download_template" href="<?php echo base_url("index.php/budget/budget_expense_by_amount_c/download_template") ?>">Download</a>
                            </label>

                            <label class="col-sm-3 control-label">Upload File</label>
                            <div class="col-sm-3">
                                <input type="file" name="upload_budget_expense" class="form-control" id="import" size="20" value="">
                            </div>
                            <?php //===== FUNCTION FOR SHOW AND HIDE BUTTON UPLOAD
                                if ($role != 1 && $role !=2){
                                    $auth_upload = $this->db->query("SELECT INT_FLG_UPLOAD FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD WHERE INT_ID_DEPT = '$kode_dept' AND INT_ID_BUDGET_SUB_GROUP = '2' AND INT_FLG_DELETE = '0'"); //=== AUTHORIZE EXPENSE BY AMOUNT 
                                    if($auth_upload->num_rows() != 0){                                    
                                        if ($auth_upload->row()->INT_FLG_UPLOAD == 1){
                            ?>
                            <button type="submit" class="btn btn-primary" id="btn_upload" name="btn-save" value="1" <?php //if($role != 1 && $role != 2){ echo 'disabled';} ?>><i class="fa fa-upload"></i>&nbsp; Upload</button>
                            <?php
                                        }
                                    }
                                } else {                                
                            ?>
                            <button type="submit" class="btn btn-primary" id="btn_upload" name="btn-save" value="1" <?php //if($role != 1 && $role != 2){ echo 'disabled';} ?>><i class="fa fa-upload"></i>&nbsp; Upload</button>
                            <?php
                                }
                            ?>
                        </div>

                        <?php echo form_close(); ?>

                    </div>
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