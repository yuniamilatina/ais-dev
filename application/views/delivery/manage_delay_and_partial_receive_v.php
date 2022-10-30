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

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/delivery/delivery_c/'); ?>"><span><strong>Manage Helpdesk Ticket</strong></span></a></li>
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
                                <a target="_blank" href="http://192.168.0.231/dora/index.php/Login_c" data-placement="left" data-toggle="tooltip" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Prepare Scan SManifest" style="height:30px;font-size:13px;width:100px;">Receive</a>
                            </div>
                    </div>

                    <div class="grid-body">
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
                                        <th>Actions</th>
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

                                        if ($isi->CHR_CUST_NO == '0010-'){
                                        }else{
                                        }

                                        echo "<tr>";
                                        echo "<td style='text-align:center;background:$color;'><span style='color:#fff'>$i</span></td>";
                                        echo "<td style='background:$color;'><span style='color:#fff'>$isi->REMARK</span></td>";
                                        echo "<td>$isi->CHR_CUST_NO</td>";
                                        echo "<td>$isi->CHR_PO_NO</td>";
                                        echo "<td>$isi->CHR_SM_NO</td>";
                                        echo "<td>$isi->CHR_DOCK_NO</td>";
                                        echo "<td>$isi->INT_CYCLE</td>";
                                        echo "<td class='td-no'>".date("d-M-Y", strtotime($isi->CHR_DELIVERY_DATE))."</td>";
                                        echo "<td>".str_replace(',','.',number_format($isi->INT_PLAN_TOTAL_KANBAN))."</td>";
                                        echo "<td>".str_replace(',','.',number_format($isi->INT_PLAN_TOTAL_QTY))."</td>";
                                        echo "<td>".str_replace(',','.',number_format($isi->INT_DEL_TOTAL_KANBAN))."</td>";
                                        echo "<td>".str_replace(',','.',number_format($isi->INT_DEL_TOTAL_QTY))."</td>";
                                        echo "<td>".str_replace(',','.',number_format($isi->INT_TOTAL_DO))."</td>";
                                        echo "<td>".str_replace(',','.',number_format($isi->INT_TOTAL_DO_RECEIVE))."</td>";
                                        ?>
                                    <td>
                                        <a onclick="get_data_detail(<?php echo trim($isi->CHR_SM_NO); ?>);" data-toggle="modal" data-target="#modalViewSM<?php echo trim($isi->CHR_SM_NO); ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-primary"><span class="fa fa-search"></span></a>
                                    </td>
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


                <!-- <div class="modal fade" id="modalReceiveSM" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header  bg-primary">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="modalprogress"><strong>Receive Supplier Manifest No</strong></h4>
                            </div>
                            <div class="modal-body">
                            <?php echo form_open('delivery/manifest_c/update_receive_do', 'class="form-horizontal"'); ?>
                                <div class="form-group" style="padding-bottom:30px;padding-left:20px;">
                                    <label class="col-sm-5 control-label">Scan Supplier Manifest</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_SM_NO" autofocus="autofocus" id="sm_scan" onchange="get_data_detail_scan();" autocomplete="off" required type="text">
                                    </div>
                                </div>
                               
                                <div id="table-luar">
                                    <table id="dataTables01" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">No</td>
                                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No</td>
                                                <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No Customer</td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan kanban</td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan Qty</td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Kanban</td>
                                                <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Qty</td>
                                            </tr>
                                        </thead>
                                        <tbody id="data_detail_scan">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group" style="padding-bottom:30px;padding-left:20px;">
                                    <label class="col-sm-5 control-label">Scan Delivery Order</label>
                                    <div class="col-sm-6">
                                        <input name="CHR_DO_NO" id="do_scan" autocomplete="off" required type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div> -->

                <?php
                $array_qr = 0;
                $id_qrcode[$array_qr] = 0;
                foreach ($data as $isi) {
                    if ($id_qrcode[$array_qr] != $isi->CHR_SM_NO) {
                        $id_qrcode[$array_qr] = $isi->CHR_SM_NO;
                        ?>

                        <div class="modal fade" id="modalViewSM<?php echo trim($isi->CHR_SM_NO); ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Supplier Manifest No : <?php echo $isi->CHR_SM_NO ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <div class="form-group" style="padding-bottom:30px;padding-left:20px;display:none;">
                                                <div class="col-sm-6">
                                                    <input name="CHR_DO_NO" id="do" placeholder="Scan Supplier Manifest" autocomplete="off" required type="hidden">
                                                </div>
                                            </div>

                                            <div class="form-group" style="padding-bottom:30px;padding-left:20px;display:none;">
                                                <div class="col-sm-6">
                                                    <input name="CHR_DO_NO" id="do" placeholder="Scan Delivery Order" autocomplete="off" required type="hidden">
                                                </div>
                                            </div>

                                            <div id="table-luar">
                                            <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">No</td>
                                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No</td>
                                                    <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Part No Customer</td>
                                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan kanban</td>
                                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Plan Qty</td>
                                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Kanban</td>
                                                    <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Del Qty</td>
                                                </tr>

                                            </thead>
                                            <tbody id="data_detail<?php echo trim($isi->CHR_SM_NO); ?>">
                                            </tbody>
                                        </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        $array_qr++;
                    }
                    $id_qrcode[$array_qr] = 0;
                }
                ?>

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
                                                        $("#data_detail" + sm).html(data);
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
</script>