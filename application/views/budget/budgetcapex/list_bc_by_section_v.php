<script src="http://code.highcharts.com/highcharts.js"></script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/prepare_approve_capex') ?>">Group Dept List</a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/prepare_approve_capex') ?>">Department List</a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/prepare_approve_capex') ?>">Section List</a></li>
            <li><a href="#"><strong>Capex List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>CAPEX</strong> <?php echo $group . ' [' . $fiscal . ']' ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Budget</th>
                                    <th>Sub Category</th>
                                    <th>Purpose</th>
                                    <th>Budget Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $session = $this->session->all_userdata();
                                foreach ($data as $isi) {

                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->INT_NO_BUDGET_CPX_TEMP</td>";
                                    echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";
                                    echo "<td>$isi->CHR_PURPOSE_DESC</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/view_detail_capex_plan_temp') . "/" . $isi->INT_NO_BUDGET_CPX_TEMP; ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
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
                            categories: ['Budgeting per Number']
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
                                    name: '<?php echo $row->INT_NO_BUDGET_CPX_TEMP; ?>',
                                    data: [<?php echo $row->DEC_PRICE_PER_UNIT; ?>]
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
                        <span class="grid-title"><strong>BUDGETING</strong>  CHART</span>
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