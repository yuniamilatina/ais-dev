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
            var budgetGroup = $("#INT_ID_BUDGET_GROUP option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/report_budget_plan_c/refresh_summary_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, INT_ID_BUDGET_GROUP: budgetGroup},
                success: function(data) {
                    url_iframe = data.url_iframe.trim();
                    url_export_excel = data.url_export_excel.trim();
                    url_export_excel_dept = data.url_export_excel_dept.trim();
                    url_export_excel_group = data.url_export_excel_group.trim();
                    if(budgetGroup == '2'){
                        document.getElementById("btn_report_dept").style.display = 'block';
                        document.getElementById("btn_report_group").style.display = 'block';
                    } else if(budgetGroup == '1') {
                        document.getElementById("btn_report_dept").style.display = 'block';
                        document.getElementById("btn_report_group").style.display = 'none';
                    } else {
                        document.getElementById("btn_report_dept").style.display = 'none';
                        document.getElementById("btn_report_group").style.display = 'none';
                    }
                    $("#btn-download-excel").attr("href", url_export_excel);
                    $("#btn_report_dept").attr("href", url_export_excel_dept);
                    $("#btn_report_group").attr("href", url_export_excel_group);
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }
        
        //BUDGET GROUP FOR DOWNLOAD
        $("#INT_ID_BUDGET_GROUP").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_GROUP option:selected").val())) {
                refreshTable()
            }
        });
        
        $("#INT_ID_FISCAL_YEAR").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val()) && ($("#INT_ID_BUDGET_GROUP option:selected").val())) {
                refreshTable()
            }
        });

    });
</script> 

<aside class="right-side">



    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/report_budget_plan_c/"') ?>">Report Budget Summary Company</a></li>
            <li class="active"> <a href="#"><strong>Report Budget Summary Company</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>REPORT BUDGET SUMMARY COMPANY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Report Company</a>
                        </div>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn_report_dept" style="color:white; display:none;"><i class="fa fa-download"></i>&nbsp; Report per Dept</a>                            
                        </div>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn_report_group" style="color:white; display:none;"><i class="fa fa-download"></i>&nbsp; Report per Group</a>                            
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open_multipart('budget/report_budget_c/report_summary_budget', 'class="form-horizontal"');
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
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Budget Group</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_BUDGET_GROUP" id="INT_ID_BUDGET_GROUP" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Budget Group -- </option>
                                    <?php
                                    foreach ($all_group as $group) {
                                        ?>
                                        <option value="<?php echo $group->INT_ID_BUDGET_GROUP; ?>" <?php if ($INT_ID_BUDGET_GROUP == $group->INT_ID_BUDGET_GROUP) echo'selected' ?>><?php echo $group->CHR_BUDGET_GROUP_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
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