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
        
        //REFRESH TABLE
        function refreshTable() {
            var fiscalYear = $("#INT_ID_FISCAL_YEAR option:selected").val();
            var budgetCat = $("#INT_ID_BUDGET_CATEGORY option:selected").val()
            var dept = $("#INT_ID_DEPT option:selected").val();
            var section = $("#SECTION option:selected").val();
            var url_iframe = "";
            var status = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_sales_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, ID_BUDGET_CATEGORY: budgetCat, INT_DEPT: dept, INT_SECT: section},
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
        
        //BUDGET CATEGORY FOR DOWNLOAD
        $("#INT_ID_BUDGET_CATEGORY").change(function() {
            if (($("#SECTION option:selected").val()) && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_CATEGORY option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            budget_category = $(this).val().toString();
            budget_category_desc = $(this).find('option:selected').text().toString().trim();
            $("#download_template").text(budget_category_desc + ".xls");            
            $("#download_template").show();
            $("#download_template").attr("href", '<?php echo base_url("index.php/budget/budget_sales_c/download_template/") ?>' + '/' + budget_category);
        });
        
        $("#INT_ID_FISCAL_YEAR").change(function() {
            if (($("#SECTION option:selected").val()) && ($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_CATEGORY option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });

    });
</script> 

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_sales_c/"') ?>">Manage Budget Sales</a></li>
            <li class="active"> <a href="#"><strong>Create Budget Sales</strong></a></li>
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
                        <span class="grid-title"><strong>CREATE BUDGET SALES</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Report</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/budget_sales_c/upload_budget_sales', 'class="form-horizontal"');
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
                                <select autofocus name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:350px" readonly>
                                    <option value="<?php echo $INT_DEPT; ?>" selected><?php echo $CHR_DEPT; ?></option>
                                </select>
                            </div>                            
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Category Type</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_CATEGORY" id="INT_ID_BUDGET_CATEGORY" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Category Type -- </option>
                                    <?php
                                    foreach ($category as $category_val) {
                                        ?>
                                        <option value="<?php echo $category_val->INT_ID_BUDGET_CATEGORY; ?>" <?php if ($INT_ID_BUDGET_CATEGORY == $category_val->INT_ID_BUDGET_CATEGORY) echo'selected' ?>><?php echo $category_val->CHR_BUDGET_CATEGORY_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>

                            <label class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_SECT" id="SECTION" required class="form-control" style="width:350px" readonly>
                                    <option value="<?php echo $INT_SECT; ?>" selected><?php echo $CHR_SECT; ?></option> 
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Download Template</label>
                            <label class="col-sm-2">
                                <a class="btn btn-info" style="display:none;" id="download_template" href="<?php echo base_url("index.php/budget/budget_sales_c/download_template/2") ?>">Download</a>
                            </label>

                            <label class="col-sm-3 control-label">Upload File</label>
                            <div class="col-sm-3">
                                <input type="file" name="upload_budget_sales" class="form-control" id="import" size="20" value="" required>
                            </div>
                            <input type="hidden" name="INT_ID_BUDGET_TYPE" value="<?php echo $INT_ID_BUDGET_TYPE; ?>">
                            <?php //===== FUNCTION FOR SHOW AND HIDE BUTTON UPLOAD
                                if ($role != 1 && $role !=2){
                                    $auth_upload = $this->db->query("SELECT INT_FLG_UPLOAD FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD WHERE INT_ID_DEPT = '$INT_DEPT' AND INT_ID_BUDGET_SUB_GROUP = '4' AND INT_FLG_DELETE = '0'"); //=== AUTHORIZE SALES 
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
                leftColumns: 4
            }
        });
    });
</script>