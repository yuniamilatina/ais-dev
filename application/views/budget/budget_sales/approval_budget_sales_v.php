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
            var dept = $("#INT_ID_DEPT option:selected").val();
            var div = $("#INT_ID_DIV").val();
            var group = $("#INT_ID_GROUP").val(); 
            var cat = $("#INT_ID_BUDGET_CATEGORY option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_sales_c/refresh_detail_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_DEPT: dept, INT_DIV: div, INT_GROUP:group, INT_ID_BUDGET_CATEGORY:cat},
                success: function(data) {
                    document.getElementById('sum_table').style.display = 'block';
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    $("#btn-download-excel").attr("href", url_export_excel)
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }
        
        //FILTER TABLE BY FISCAL YEAR
        $("#INT_ID_FISCAL_YEAR").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_BUDGET_CATEGORY option:selected").val()) && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable();
            }
        });
        
        //FILTER TABLE BY CATEGORY
        $("#INT_ID_BUDGET_CATEGORY").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_CATEGORY option:selected").val()) && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
        });
    });
    
    $(window).load(function() {
      function refreshTable() {
            var fiscalYear = $("#INT_ID_FISCAL_YEAR option:selected").val();
            var dept = $("#INT_ID_DEPT option:selected").val();
            var div = $("#INT_ID_DIV").val();
            var group = $("#INT_ID_GROUP").val(); 
            var cat = $("#INT_ID_BUDGET_CATEGORY option:selected").val();          
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_sales_c/refresh_detail_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_DEPT: dept, INT_DIV: div, INT_GROUP:group, INT_ID_BUDGET_CATEGORY:cat},
                success: function(data) {
                    document.getElementById('sum_table').style.display = 'block';
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    $("#btn-download-excel").attr("href", url_export_excel)
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }
        
      if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_BUDGET_CATEGORY option:selected").val()) && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
          refreshTable();
      }
    });
</script> 

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_sales_c/"') ?>">Approval Budget Sales</a></li>
            <li class="active"> <a href="#"><strong>Approval Budget Sales</strong></a></li>
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
                        <i class="fa fa-edit"></i>
                        <span class="grid-title"><strong>APPROVAL BUDGET SALES</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Report</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open_multipart('budget/budget_sales_c/approve_budget_sales', 'class="form-horizontal"');
                        ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fiscal Year</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_FISCAL_YEAR" id="INT_ID_FISCAL_YEAR" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Fiscal Year -- </option>
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_FISCAL_YEAR_START; ?>" <?php if ($INT_ID_FISCAL_YEAR == $isi->CHR_FISCAL_YEAR_START) echo 'selected' ?>><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div> 
                            
                            <label class="col-sm-2 control-label">Div (GM)</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_GROUP" id="INT_ID_GROUP" required class="form-control" style="width:250px" disabled>
                                       <option value="<?php echo $INT_GROUP ?>" selected><?php echo $CHR_GROUP; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class=" form-group">  
                            <label class="col-sm-2 control-label">Dir</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DIV" id="INT_ID_DIV" required class="form-control" style="width:250px" disabled>
                                    <option value="<?php echo $INT_DIV; ?>" selected><?php echo $CHR_DIV; ?></option>
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:250px" disabled>
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
                            
                            <?php if($role == 1 || $role == 2){ ?>
                            <label class="col-sm-2 control-label">Approve by</label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary" name="btn-save" value="man" style="width:60px;">MAN</button>
                                <button type="submit" class="btn btn-primary" name="btn-save" value="gm" style="width:60px;">GM</button>
                                <button type="submit" class="btn btn-primary" name="btn-save" value="dir" style="width:60px;">DIR</button>
                                <button type="submit" class="btn btn-primary" name="btn-save" value="all" style="width:60px;">ALL</button>
                                <button type="submit" class="btn btn-danger" name="btn-save" value="reject" style="width:100px;">UNAPPROVE</button>
                            </div>
                            <?php } else if($role == 3 || $role == 42 || $role == 43){ ?>
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-primary" name="btn-save" value="dir" style="width:90px;">Approved</button>
                            </div>
                            <?php } else if($role == 4 || $role == 44 || $role == 46 || $role == 47){ ?>
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-primary" name="btn-save" value="gm" style="width:90px;">Approved</button>                                
                            </div>
                            <?php } else if($role == 5 || $role == 39 || $role == 45 || $role == 48 || $role == 49 || $role == 50 || $role == 52){ ?>
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-primary" name="btn-save" value="man" style="width:90px;">Approved</button>                               
                            </div>
                            <?php } ?>
                        </div>
                        <?php echo form_close(); ?>
                    </div>                    
                </div>
            </div>
            <div class="col-md-12" id="sum_table" style="display:none;">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title"><strong>DETAIL DATA SALES</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <div class="grid-body" style="padding-top: 0px">
                            <iframe frameBorder="0" id="iframe" width="100%" height="500" src="<?php echo $url_page ?>"></iframe>
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