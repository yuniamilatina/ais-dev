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
            var section = $("#SECTION option:selected").val();
            var div = $("#INT_ID_DIV").val();
            var group = $("#INT_ID_GROUP").val();            
            var url_iframe = "";
            var url_iframe2 = "";
            var frame = document.getElementById("iframe");
            var frame2 = document.getElementById("iframe2");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/refresh_detail_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_DEPT: dept, INT_SECT: section, INT_DIV: div, INT_GROUP:group},
                success: function(data) {
                    document.getElementById('sum_table').style.display = 'block';
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    $("#btn-download-excel").attr("href", url_export_excel)
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/refresh_summary_table",
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_DEPT: dept, INT_SECT: section, INT_DIV: div, INT_GROUP:group}, type: "POST",
                success: function(data) {
                    document.getElementById('sum_table2').style.display = 'block';
                    url_iframe2 = data.trim();
                    frame2.src = url_iframe2;
                    frame2.contentWindow.location = url_iframe2;
                }
            });
        }
        
        //FILTER GROUPDEPT AND TABLE BY DIVISION
        $("#INT_ID_DIV").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_groupdept",
                data: {INT_ID_DIV: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#INT_ID_GROUP").html(data);
                }
            });
            
            var a = '';
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_dept",
                data: {INT_ID_GROUP: a}, type: "POST",
                success: function(data) {
                    $("#INT_ID_DEPT").html(data);
                }
            });            
            
            var b = '';
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_section_app",
                data: {INT_ID_DEPT: b}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        //FILTER DEPT AND TABLE BY GROUPDEPT
        $("#INT_ID_GROUP").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_dept",
                data: {INT_ID_GROUP: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#INT_ID_DEPT").html(data);
                }
            });
            
            var c = '';
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_section_app",
                data: {INT_ID_DEPT: c}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        //FILTER SECTION AND TABLE BY DEPT
        $("#INT_ID_DEPT").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable()
            }
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/gen_ddl_section_app",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#SECTION").html(data);
                }
            });
        });
        
        $("#SECTION").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') &&  ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val()) && ($("#SECTION option:selected").val()) ) {
                refreshTable()
            }
        });
        
        //FILTER TABLE BY FISCAL YEAR
        $("#INT_ID_FISCAL_YEAR").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
                refreshTable();
            }
        });
    });
    
    $(window).load(function() {
      function refreshTable() {
            var fiscalYear = $("#INT_ID_FISCAL_YEAR option:selected").val();
            var dept = $("#INT_ID_DEPT option:selected").val();
            var section = $("#SECTION option:selected").val();
            var div = $("#INT_ID_DIV").val();
            var group = $("#INT_ID_GROUP").val();            
            var url_iframe = "";
            var url_iframe2 = "";
            var frame = document.getElementById("iframe");
            var frame2 = document.getElementById("iframe2");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/refresh_detail_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_DEPT: dept, INT_SECT: section, INT_DIV: div, INT_GROUP:group},
                success: function(data) {
                    document.getElementById('sum_table').style.display = 'block';
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    $("#btn-download-excel").attr("href", url_export_excel)
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/budget_capex_c/refresh_summary_table",
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_DEPT: dept, INT_SECT: section, INT_DIV: div, INT_GROUP:group}, type: "POST",
                success: function(data) {
                    document.getElementById('sum_table2').style.display = 'block';
                    url_iframe2 = data.trim();
                    frame2.src = url_iframe2;
                    frame2.contentWindow.location = url_iframe2;
                }
            });
        }
        
      if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#INT_ID_DIV option:selected").val()) && ($("#INT_ID_GROUP option:selected").val()) && ($("#INT_ID_DEPT option:selected").val())) {
          refreshTable();
      }
    });
</script> 

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_capex_c/"') ?>">Approval Budget Capex</a></li>
            <li class="active"> <a href="#"><strong>Approval Budget Capex</strong></a></li>
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
                        <span class="grid-title"><strong>APPROVAL BUDGET CAPITAL EXPENDITURE</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Report</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open_multipart('budget/budget_capex_c/approve_budget_capex', 'class="form-horizontal"');
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
                            
                            <label class="col-sm-2 control-label">Department</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DEPT" id="INT_ID_DEPT" required class="form-control" style="width:250px" <?php if ($role == 5 || $role == 6 || $role == 39 || $role == 45) { echo ' disabled'; }?>>
                                    <option value=""> -- Select Department -- </option>
                                    <?php
                                    foreach ($list_dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>" <?php if ($INT_DEPT == $isi->INT_ID_DEPT) echo 'selected' ?>><?php echo $isi->CHR_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div> 
                        </div>
                        <div class=" form-group">  
                            <label class="col-sm-2 control-label">Division</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_DIV" id="INT_ID_DIV" required class="form-control" style="width:250px" <?php if ($role == 3 || $role == 4 || $role == 5 || $role == 6 || $role == 39 || $role == 45) { echo ' disabled'; }?> >
                                    <option value=""> -- Select Division -- </option>
                                    <?php
                                    foreach ($list_div as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DIVISION; ?>" <?php if ($INT_DIV == $isi->INT_ID_DIVISION) echo 'selected' ?>><?php echo $isi->CHR_DIVISION_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            
                            <label class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_SECT" id="SECTION" class="form-control" style="width:250px">
                                    <option value=""> -- Select Section -- </option>
                                    <?php
                                    foreach ($section as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_SECTION; ?>" <?php if ($INT_SECT == $isi->CHR_SECTION){ echo 'selected'; } ?>><?php echo $isi->CHR_SECTION . " / " . $isi->CHR_SECTION_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class=" form-group">  
                            <label class="col-sm-2 control-label">Group Dept</label>
                            <div class="col-sm-3">
                                <select autofocus name="INT_ID_GROUP" id="INT_ID_GROUP" required class="form-control" style="width:250px" <?php if ($role == 4 || $role == 5 || $role == 6 || $role == 39 || $role == 45) { echo ' disabled'; }?> >
                                    <option value=""> -- Select Group Dept -- </option>
                                    <?php
                                    foreach ($list_group as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_GROUP_DEPT; ?>" <?php if ($INT_GROUP == $isi->INT_ID_GROUP_DEPT){ echo'selected'; }?>><?php echo $isi->CHR_GROUP_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                            <?php if($role == 1 || $role == 2){ ?>
                            <label class="col-sm-2 control-label">Approve by</label>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary" name="btn-save" value="man" style="width:70px;">MAN</button>
                                <button type="submit" class="btn btn-primary" name="btn-save" value="gm" style="width:70px;">GM</button>
                                <button type="submit" class="btn btn-primary" name="btn-save" value="dir" style="width:70px;">DIR</button>
                                <button type="submit" class="btn btn-success" name="btn-save" value="all" style="width:130px;">APPROVE ALL</button>
                                <button type="submit" class="btn btn-danger" name="btn-save" value="reject" style="width:130px;">UNAPPROVE ALL</button>
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
                        <span class="grid-title"><strong>DETAIL BUDGET CAPEX BY DEPT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <div class="grid-body" style="padding-top: 0px">
                            <iframe frameBorder="0" id="iframe" width="100%" height="700" src="<?php echo $url_page ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($role <= 5) {?>
            <div class="col-md-12" id="sum_table2" style="display:none;">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title"><strong>SUMMARY ALL CAPEX</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">                        
                        <div class="grid-body" style="padding-top: 0px">
                            <iframe frameBorder="0" id="iframe2" width="100%" height="500" src="<?php //echo $url_page2 ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
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
                leftColumns: 3
            }
        });
    });
</script>