
<script src="<?php echo base_url('assets/js/jquery.form.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js'); ?>"></script>

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
        text-align: center;
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

<script type="text/javascript" >
    function fokus_scan() {
        document.getElementById("sm_scan").focus();
    }

    // function scan_sm_no() {
    //     var nomer_sm = document.getElementById("sm_scan").value;
    //     var sm_no = nomer_sm.replace(/\D/g, '');

    //        $.ajax({
    //            type: "POST",
    //            dataType: "json",
    //            url: "<?php echo base_url(); ?>" + "index.php/delivery/manifest_c/view_detail_manifest",
    //            data: {sm: sm_no},
    //            success: function (data) {
    //                 document.getElementById("data_detail_scan").innerHTML = data;
    //            },
    //            error: function (request) {
    //                alert(request.responseText);
    //            }
    //        });

    //     document.getElementById("sm_scan").value = '';
    // }


</script>

<script>     var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                }
        , format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
                return c[p];
            })
        }
        return function (table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>



<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/delivery/delivery_c/'); ?>"><span><strong>Manage Delay Manifest</strong></span></a></li>
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
                        <i class="fa fa-truck"></i>

                        <span class="grid-title"><strong>RECEIVE MANIFEST</strong></span>
                        <div class="pull-right">
                            <a target="_blank" href="http://192.168.0.231/dora/index.php/Login_c" data-placement="left" data-toggle="tooltip" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Prepare Scan SManifest" >Receive</a>
                            <input type="button" class="btn btn-primary" onclick="tableToExcel('exportHeader', 'Report Delay & Partial Delivery')" value="Export Header">
                            <input type="button" class="btn btn-primary" onclick="tableToExcel('exportDetail', 'Summary Line Stop')" value="Export Detail">
                        </div>
                    </div>


                    <div class="grid-body">
                        <div class="alert alert-success" id="alert-success" style="display:none;">
                            <strong>Well done!</strong> You successfully close Supplier Manifest <a href="#" id="alert-success-sm"></a>.
                        </div>
                        <div class="pull btn-group" style="padding-bottom:10px;">

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Remarks</th>
                                        <th>Cust No.</th>
                                        <th>PO</th>
                                        <th>SM</th>
                                        <th>Dock No</th>
                                        <th>Cycle</th>
                                        <th>Del Date</th>
                                        <th>Plan Total Kanban</th>
                                        <th>Plan Total Qty</th>
                                        <th>Del Total Kanban</th>
                                        <th>Del Total Qty</th>
                                        <th>Total DO</th>
                                        <th>Total Receive DO</th>
                                        <th style='text-align:center'>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        $btn = 'success';
                                        $color = NULL;
                                        $level = null;
                                        $late = NULL;

                                        if ($isi->REMARK == 'DELAYED DELIVERY') {
                                            $color = '#00CED1';
                                        } else if ($isi->REMARK == 'PARTIAL DELIVERY') {
                                            $color = '#FFB401';
                                        } else {
                                            $color = '#7DD488';
                                        }

                                        if ($isi->CHR_CUST_NO == '0010-') {
                                            
                                        } else {
                                            
                                        }

                                        echo "<tr id='" . trim($isi->CHR_SM_NO) . "'>";
                                        echo "<td style='text-align:center;background:$color;'><span style='color:#fff'>$i</span></td>";
                                        echo "<td style='background:$color;'><span style='color:#fff'>$isi->REMARK</span></td>";
                                        echo "<td>$isi->CHR_CUST_NO</td>";
                                        echo "<td>$isi->CHR_PO_NO</td>";
                                        echo "<td>$isi->CHR_SM_NO</td>";
                                        echo "<td>$isi->CHR_DOCK_NO</td>";
                                        echo "<td>$isi->INT_CYCLE</td>";
                                        echo "<td class='td-no'>" . date("d-M-Y", strtotime($isi->CHR_DELIVERY_DATE)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_KANBAN)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_QTY)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_KANBAN)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_QTY)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_TOTAL_DO)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_TOTAL_DO_RECEIVE)) . "</td>";
                                        ?>
                                    <td>
                                        <button onclick="get_data_detail('<?php echo trim($isi->CHR_SM_NO) ?>');" class="btn btn-info" data-toggle="modal" data-target="#modalViewDetailSM">   <i class="fa fa-search"></i> View</button>
                                        <button onclick="get_data_detail_close('<?php echo trim($isi->CHR_SM_NO) ?>');" class="btn btn-warning" data-toggle="modal" data-target="#modalActionCloseSM">   <i class="fa fa-comment"></i> Finish w/ Comment</button>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                                </tbody>
                            </table>

                            <table id="exportHeader" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Remarks</th>
                                        <th>Cust No.</th>
                                        <th>PO</th>
                                        <th>SM</th>
                                        <th>Dock No</th>
                                        <th>Cycle</th>
                                        <th>Del Date</th>
                                        <th>Plan Total Kanban</th>
                                        <th>Plan Total Qty</th>
                                        <th>Del Total Kanban</th>
                                        <th>Del Total Qty</th>
                                        <th>Total DO</th>
                                        <th>Total Receive DO</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        $btn = 'success';
                                        $color = NULL;
                                        $level = null;
                                        $late = NULL;

                                        if ($isi->REMARK == 'DELAYED DELIVERY') {
                                            $color = '#00CED1';
                                        } else if ($isi->REMARK == 'PARTIAL DELIVERY') {
                                            $color = '#FFB401';
                                        } else {
                                            $color = '#7DD488';
                                        }

                                        if ($isi->CHR_CUST_NO == '0010-') {
                                            
                                        } else {
                                            
                                        }

                                        echo "<tr id='" . trim($isi->CHR_SM_NO) . "'>";
                                        echo "<td style='text-align:center;background:$color;'><span style='color:#fff'>$i</span></td>";
                                        echo "<td style='background:$color;'><span style='color:#fff'>$isi->REMARK</span></td>";
                                        echo "<td>$isi->CHR_CUST_NO</td>";
                                        echo "<td>$isi->CHR_PO_NO</td>";
                                        echo "<td>$isi->CHR_SM_NO</td>";
                                        echo "<td>$isi->CHR_DOCK_NO</td>";
                                        echo "<td>$isi->INT_CYCLE</td>";
                                        echo "<td class='td-no'>" . date("d-M-Y", strtotime($isi->CHR_DELIVERY_DATE)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_KANBAN)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_QTY)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_KANBAN)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_QTY)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_TOTAL_DO)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_TOTAL_DO_RECEIVE)) . "</td>";
                                        ?>
                                   
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                                </tbody>
                            </table>

                            <table id="exportDetail" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Remarks</th>
                                        <th>Cust No.</th>
                                        <th>PO</th>
                                        <th>SM</th>
                                        <th>Dock No</th>
                                        <th>Cycle</th>
                                        <th>Del Date</th>
                                        <th>Plan Total Kanban</th>
                                        <th>Plan Total Qty</th>
                                        <th>Del Total Kanban</th>
                                        <th>Del Total Qty</th>
                                        <th>Total DO</th>
                                        <th>Total Receive DO</th>
                                        <th>Part Number</th>
                                        <th>Part Number Customer</th>
                                        <th>Qty Kanban Plan</th>
                                        <th>Qty PCS Plan</th>
                                        <th>Qty Kanban Act</th>
                                        <th>Qty PCS Act</th>
                                        <th>Diff Qty Kanban</th>
                                        <th>Diff Qty Pcs</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_detail as $isi) {
                                        $btn = 'success';
                                        $color = NULL;
                                        $level = null;
                                        $late = NULL;

                                        if ($isi->REMARK == 'DELAYED DELIVERY') {
                                            $color = '#00CED1';
                                        } else if ($isi->REMARK == 'PARTIAL DELIVERY') {
                                            $color = '#FFB401';
                                        } else {
                                            $color = '#7DD488';
                                        }

                                        if ($isi->CHR_CUST_NO == '0010-') {
                                            
                                        } else {
                                            
                                        }

                                        echo "<tr id='" . trim($isi->CHR_SM_NO) . "'>";
                                        echo "<td style='text-align:center;background:$color;'><span style='color:#fff'>$i</span></td>";
                                        echo "<td style='background:$color;'><span style='color:#fff'>$isi->REMARK</span></td>";
                                        echo "<td>$isi->CHR_CUST_NO</td>";
                                        echo "<td>$isi->CHR_PO_NO</td>";
                                        echo "<td>$isi->CHR_SM_NO</td>";
                                        echo "<td>$isi->CHR_DOCK_NO</td>";
                                        echo "<td>$isi->INT_CYCLE</td>";
                                        echo "<td class='td-no'>" . date("d-M-Y", strtotime($isi->CHR_DELIVERY_DATE)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_KANBAN)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_QTY)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_KANBAN)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_QTY)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_TOTAL_DO)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_TOTAL_DO_RECEIVE)) . "</td>";
                                        echo "<td>$isi->CHR_PART_NO</td>";
                                        echo "<td>$isi->CHR_PART_NO_CUST</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_KANBAN_DETAIL)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_QTY_DETAIL)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_KANBAN_DETAIL)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_DEL_TOTAL_QTY_DETAIL)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_KANBAN_DETAIL - $isi->INT_DEL_TOTAL_QTY_DETAIL)) . "</td>";
                                        echo "<td>" . str_replace(',', '.', number_format($isi->INT_PLAN_TOTAL_QTY_DETAIL - $isi->INT_DEL_TOTAL_QTY_DETAIL)) . "</td>";
                                        ?>

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
            </div>
        </div>

    </section>
</aside>


<div class="modal fade" id="modalViewDetailSM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7" aria-hidden="true" style="display: none;">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title" id="modal-title-view-sm-id"></h4>
                </div>
                <div class="modal-body">
                    <table id="modal-detail-id" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">No</td>
                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No</td>
                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No Customer</td>
                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part Name</td>
                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan kanban</td>
                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan Qty</td>
                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Kanban</td>
                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Qty</td>
                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Status</td>
                            </tr>
                        </thead>
                        <tbody id="data-detail-sm">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalActionCloseSM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7" aria-hidden="true" style="display: none;">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title" id="modal-title-close-sm-id"></h4>
                </div>
                <form method="post" id="actionCloseFrm">
                    <div class="modal-body">
                        <table id="modal-detail-id" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">No</td>
                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No</td>
                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No Customer</td>
                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part Name</td>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan kanban</td>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan Qty</td>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Kanban</td>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Qty</td>
                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Feedback</td>
                                </tr>
                            </thead>
                            <tbody id="data-close-detail-sm">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" id="btn-save-close-sm" class="btn btn-primary" >Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>-->
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                            $(document).ready(function () {
                                                var table = $('#example').DataTable({
                                                    scrollY: "350px",
                                                    scrollX: true,
                                                    scrollCollapse: true,
                                                    paging: true,
                                                    fixedColumns: {
                                                        leftColumns: 2
                                                    }
                                                });
                                            });
                                            function get_data_detail(sm) {
                                                $("#data_detail").html("");
                                                $.ajax({
                                                    async: false,
                                                    type: "POST",
                                                    url: "<?php echo site_url('delivery/manifest_c/view_detail_manifest'); ?>",
                                                    data: "sm=" + sm,
                                                    success: function (data) {
                                                        $("#data-detail-sm").html(data);
                                                        $("#modal-title-view-sm-id").text("Detail Supplier Manifest : " + sm);
                                                    }
                                                });
                                            }

                                            function get_data_detail_close(sm) {
                                                $("#data_detail").html("");
                                                $.ajax({
                                                    async: false,
                                                    type: "POST",
                                                    url: "<?php echo site_url('delivery/manifest_c/view_detail_manifest_close'); ?>",
                                                    data: "sm=" + sm,
                                                    success: function (data) {
                                                        $("#data-close-detail-sm").html(data);
                                                        $("#modal-title-close-sm-id").text("Close Supplier Manifest : " + sm);
                                                    }
                                                });
                                            }

                                            function get_data_detail_scan() {
                                                sm = $("#sm_scan").val();
                                                $("#data_detail_scan").html("");
                                                $.ajax({
                                                    async: false,
                                                    type: "POST",
                                                    url: "<?php echo site_url('delivery/manifest_c/view_detail_manifest'); ?>",
                                                    data: "sm=" + sm,
                                                    success: function (data) {
                                                        // alert(data);
                                                        $("#data_detail_scan" + sm).html(data);
                                                    }
                                                });
                                            }


                                            $("#btn-save-close-sm").click(function () {
                                                var mdl_action = $("#modalActionCloseSM");
                                                var $valid = $("#actionCloseFrm").valid();
                                                if (!$valid) {
                                                    return false;
                                                }


                                                var frm_crud = $("#actionCloseFrm");
                                                var frm_data = frm_crud.serializeArray();
                                                $.ajax({
                                                    async: false,
                                                    type: "GET",
                                                    url: "<?php echo site_url('delivery/manifest_c/close_manifest_wcmnt'); ?>",
                                                    data: $("#actionCloseFrm").serialize(),
                                                    success: function (data) {
                                                        var no_sm = '#' + $.trim(data);
                                                        $(no_sm).remove();
                                                        $("#alert-success").show();
                                                        $("#alert-success-sm").text($.trim(data));
                                                        mdl_action.modal('hide');
                                                    }
                                                });
                                            });




</script>