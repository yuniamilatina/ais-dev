<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/purchase_request_c') ?>"><strong>Manage Purchase Request</strong></a></li>
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
                        <span class="grid-title"><strong>PURCHASE</strong> REQUEST TABLE</span>


                        <div class="pull-right grid-tools">
                            <div class="btn-group">
                                <button type="button" data-placement="left" class="btn btn-default" data-toggle="dropdown" title="Create Purchase Request" data-toggle="tooltip" style="height:30px;font-size:13px;width:200px;" data-toggle="dropdown"> Create Purchase Request </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo base_url('index.php/budget/purchase_request_c/create_purchase_request/1') ?>">Purchase Request Capex</a></li>
                                    <li><a href="<?php echo base_url('index.php/budget/purchase_request_c/create_purchase_request_e/') ?>">Purchase Request Expense</a></li>
                                </ul>
                            </div>
<!--                            <a href="<?php echo base_url('index.php/budget/purchase_request_c/create_purchase_request/1') ?>" data-placement="left" class="btn btn-default" data-toggle="tooltip" title="Create Purchase Request" style="height:30px;font-size:13px;width:100px;">Create</a>
                            -->
                        </div>
                    </div>
                    <div class="grid-body">

                        <div class="pull btn-group">
                            <h5>Has approved by</h5>
                            <table class="table table-condensed table-bordered display" style='border:1px solid #cccccc;text-align: center'>
                                <tr>
                                    <td class="gradeX default"><a href="<?php echo base_url('index.php/budget/purchase_request_c/select_no_approves'); ?>" style="color:#666666;">No one</a></td>
                                    <td class="gradeX warning"><a href="<?php echo base_url('index.php/budget/purchase_request_c/select_manager_approves'); ?>" style="color:#666666;">Manager</a></td>
                                    <td class="gradeX success" style='width:60px'><a href="<?php echo base_url('index.php/budget/purchase_request_c/select_gm_approves'); ?>" style="color:#666666;">GM</a></td>
                                </tr>
                            </table>
                        </div>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Fiscal</th>
                                    <th>No Purchase Request</th>
                                    <th>Month</th>
                                    <th>Section</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 != 1) {
                                        echo "<tr class='gradeX warning'>";
                                    } else if ($isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE1 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    }
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_FISCAL_YEAR</td>";
                                    echo "<td>$isi->INT_NO_PUREQ</td>";
                                    echo "<td>$isi->INT_MONTH_REAL</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    $total = number_format($isi->DEC_TOTAL, 0, '', '.');
                                    echo "<td>Rp $total</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/view_detail_purchase_request') . "/" . $isi->INT_NO_PUREQ ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/edit_purchase_request') . "/" . $isi->INT_NO_PUREQ ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/delete_purchase_request') . "/" . $isi->INT_NO_PUREQ ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this purchase request?');"><span class="fa fa-times"></span></a>
                                    <?php if ($isi->INT_APPROVE2 == 1) { ?>
                                        <a href="<?php echo base_url('index.php/budget/purchase_request_c/print_approval_sheet') . "/" . $isi->INT_NO_PUREQ ?>" class="label label-info"><span class="fa fa-print"></span></a>
                                    <?php } ?>
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


            <script type="text/javascript">
                                        var chart1;
                                        $(document).ready(function() {
                                            chart1 = new Highcharts.Chart({
                                                chart: {
                                                    renderTo: 'container',
                                                    type: 'column',
                                                    plotBorderWidth: 1
                                                },
                                                credits: {
                                                    enabled: false
                                                },
                                                legend: {
                                                    borderColor: '#cccccc',
                                                    borderWidth: 1,
                                                    borderRadius: 3
                                                },
                                                tooltip: {
                                                    valuePrefix: 'Rp.'
                                                },
                                                title: {
                                                    text: ''
                                                },
                                                xAxis: {
                                                    categories: ['Purchase Request']
                                                },
                                                yAxis: {
                                                    title: {
                                                        text: 'Amount'
                                                    }
                                                },
                                                series: [
<?php
foreach ($data as $row) {
    ?>
                                                        {
                                                            name: '<?php echo $row->INT_NO_PUREQ; ?>',
                                                            data: [<?php echo $row->DEC_TOTAL; ?>]
                                                        },
<?php } ?>
                                                ]
                                            });
                                        });
            </script>


            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PURCHASE REQUEST</strong>  CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</aside>