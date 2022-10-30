<script src="http://code.highcharts.com/highcharts.js"></script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_capex_open_c/') ?>">Group Dept List</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_capex_open_c/') ?>">Department List</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budget_capex_open_c/') ?>">Section List</a></li>
            <li><a href="#"><strong>Purchase Request List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PUREQ</strong> <?php echo $group . ' [' . $fiscal . ']' ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                                $session = $this->session->all_userdata();
                                foreach ($data as $isi) {
                                    if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 != 1 && $isi->INT_APPROVE3 != 1) {
                                        echo "<tr class='gradeX danger'>";
                                    } else if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE3 != 1) {
                                        echo "<tr class='gradeX warning'>";
                                    } else if ($isi->INT_APPROVE3 == 1 && $isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE1 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    }
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->INT_NO_PUREQ</td>";
                                    echo "<td>$isi->INT_MONTH_REAL</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    $total = number_format($isi->DEC_TOTAL, 0, '', '.');
                                    echo "<td>$total</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/view_detail_purchase_request_by_other') . "/" . $isi->INT_NO_PUREQ ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
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
                            categories: ['Purchase Request per Number']
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
                        <span class="grid-title"><strong>PURCHASE </strong>REQUEST CHART</span>
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