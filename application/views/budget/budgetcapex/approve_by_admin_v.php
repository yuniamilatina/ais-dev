<script src="http://code.highcharts.com/highcharts.js"></script>

<?php $session = $this->session->all_userdata(); ?>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Group Dept List</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>CAPEX</strong> <?php echo $group . ' [' . $fiscal . ']' ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Group Dept</th>                
                                    <th>Total Budget</th>                
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_plan = null;
                                foreach ($data as $isi) {
                                    if ($isi->INT_APPROVE3 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE3 == 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else {
                                        echo "<tr class='gradeX'>";
                                    }
                                    if ($isi->INT_APPROVE3 == 0 || $isi->INT_APPROVE3 == 2) {
                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_GROUP_DEPT . '"></input></td>';
                                    } else {
                                        echo '<td><input class="icheck" type="hidden" disabled="true"></input></td>';
                                    }
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_GROUP_DEPT</td>";
                                    echo "<td>" . 'Rp ' . number_format($isi->total, 0, '', '.') . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/view_detail_by_gm') . '/' . $isi->INT_ID_GROUP_DEPT . '/' . $isi->INT_ID_FISCAL_YEAR ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                                $total_plan = $isi->total + $total_plan;
                            }
                            ?>
                            </tbody>
                        </table>
                        <hr>                        
                        <strong>Total budget Planning <?php echo $group; ?> Division:</strong><span style="background-color: yellow;"> Rp <?php echo number_format($total_plan, 0, '', '.'); ?></span><br>

                    </div>

                </div>
            </div>
            
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title"><strong>BUDGET</strong> PLANNING </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">

                        </div>
                        <?php
                        echo form_open('budget/capex_plan_temp_c/approve_capex_by_manager', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables3" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
<!--                                    <th>#</th>-->
                                    <th>No</th>
                                    <th>No Budget</th>
                                    <th>Budget Name</th>
                                    <th>Total Plan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $w = 1;
                                foreach ($data_capex_detail as $isi) {
                                    if ($isi->INT_APPROVE3 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE3 == 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else {
                                        echo "<tr class='gradeX'>";
                                    }

//                                    if ($isi->INT_APPROVE1 == 0 || $isi->INT_APPROVE1 == 2) {
//                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_NO_BUDGET_CPX_TEMP . '"></input></td>';
//                                    } else {
//                                        echo '<td><input class="icheck" type="hidden" disabled="true"></input></td>';
//                                    }

                                    echo "<td>$w</td>";
                                    echo "<td>$isi->INT_NO_BUDGET_CPX_TEMP</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    echo "<td>".'Rp '. number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.') . "</td>";
                                    ?>
                                </tr>
                                <?php
                                $w++;
                            }
                            ?> 
                            </tbody>
                        </table>
                    </div>
                    <?php
                    if ($session['ROLE'] == 5) {
                        ?>
                        <div class = "grid-header">
                            <div class = "grid-body">
                                <div class = "pull-right">
                                    <div class = "form-group">
                                        <?php if ($permit_approve == 0) { ?>
                                            <div class = "btn-group">
                                                <!--<button type = "submit" na me = "btn_approve" value="0" class = "btn btn-default" data-toggle = "tooltip" data-placement = "bottom" title = "Reject this budget" onclick = "return confirm('Are you sure want to reject this budget?');"><i class = "fa fa-thumbs-down"></i> Reject</button>-->
                                                <?php echo form_close(); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div> 
            </div>
        </div>

        <div class="row">
            <script type="text/javascript">
                                                    var chart1;
                                                    $(document).ready(function () {
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
                                            categories: ['Group Department']
                                            },
                                                    yAxis: {
                                            title: {
                                            text: 'Total Budget'
                                            }
                                            },
                                                    series: [
<?php
foreach ($data as $row) {
    ?>
                                                {
                                                name: '<?php echo $row->CHR_GROUP_DEPT; ?>',
                                                        data: [<?php echo $row->total; ?>]
                                                },
<?php } ?>
                                            ]
                                            });
                                            });</script>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>GROUP DEPT</strong> BUDGETING CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container" ></div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                        var chart2;
                        $(document).ready(function() {
                chart2 = new Highcharts.Chart({
                chart: {
                renderTo: 'container1',
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
                categories: ['budget plan capex']
                },
                        yAxis: {
                title: {
                text: 'Budget per number'
                }
                },
                        series: [
<?php
foreach ($data_capex_detail as $row) {
    ?>
                    {
                    name: '<?php echo $row->INT_NO_BUDGET_CPX_TEMP . '[' . $row->CHR_SECTION . ']'; ?>',
                            data: [<?php echo $row->DEC_PRICE_PER_UNIT; ?>]
                    },
<?php } ?>
                ]
                });
                });
            </script>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>BUDGET </strong>PLANNING CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container1"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>