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
            var type = $("#REPORT_TYPE option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/report_budget_plan_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_FISCAL_YEAR: fiscalYear, REPORT_TYPE: type},
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
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#REPORT_TYPE option:selected").val() != '')) {
                refreshTable();
            }
        });
        
        //FILTER TABLE BY TYPE
        $("#REPORT_TYPE").change(function() {
            if (($("#INT_ID_FISCAL_YEAR option:selected").val() != '') && ($("#REPORT_TYPE option:selected").val() != '')) {
                refreshTable();
            }
        });
    });
</script> 

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/report_budget|_c/"') ?>">Report Budget Profit and Loss</a></li>
            <li class="active"> <a href="#"><strong>Report Budget Profit and Loss</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-edit"></i>
                        <span class="grid-title"><strong>REPORT BUDGET PROFIT AND LOSS</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Download Excel</a>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open_multipart('budget/report_budget_plan_c/report_profit_and_loss', 'class="form-horizontal"');
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Report By</label>
                            <div class="col-sm-3">
                                <select name="REPORT_TYPE" id="REPORT_TYPE" required class="form-control" style="width:250px">
                                    <option value=""> -- Select Report Type -- </option>   
                                    <option value="FOH"> Category FOH/OPEX </option>
                                    <option value="A3"> Category A3 </option>
                                </select>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>                    
                </div>
            </div>
            <div class="col-md-12" id="sum_table" style="display:none;">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title"><strong>SUMMARY REPORT PROFIT & LOSS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <div class="grid-body" style="padding-top: 0px">
                            <iframe frameBorder="0" id="iframe" width="100%" height="750" src="<?php echo $url_page ?>"></iframe>
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