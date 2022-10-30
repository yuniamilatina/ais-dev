<script src="http://code.highcharts.com/highcharts.js"></script>
<?php $session = $this->session->all_userdata(); ?>
<script type="text/javascript">
    function ChooseFiscal(data) {
    document.getElementById("jYear").value = data.value;
    }
</script> 

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <?php if ($session['ROLE'] == 4) { ?>
                <li><a href ="<?php echo base_url('index.php/budget/capex_plan_temp_c/') ?>">Department List</a></li>
            <?php } if ($session['ROLE'] == 3) { ?>
                <li><a href ="<?php echo base_url('index.php/budget/capex_plan_temp_c/') ?>">GM List</a></li>
                <li><a href ="<?php echo base_url('index.php/budget/capex_plan_temp_c/select_by_gm/' . $id_dept . '/' . $id_fiscal) ?>">Department List</a></li>
            <?php } ?>
            <li><a href="#"><strong>Section List</strong></a></li>
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
                        <span class="grid-title"><strong>CAPEX</strong> <?php echo $group . '[' . $fiscal . ']' ?> </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" >
                        <?php if ($session['ROLE'] == 5) { ?>
                            <div class="pull" hidden="true">
                                <?php echo form_open('budget/capex_plan_temp_c/search_prepare_approve_capex', 'class="form-horizontal"'); ?>
                                <select name="INT_ID_FISCAL_YEAR" autofocus onchange="ChooseFiscal(this);" class="ddl">
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        if ($this_fiscal_year == $isi->INT_ID_FISCAL_YEAR) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                                <button type="submit" name="btn_seacrh" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px"><i class="fa fa-search"></i></button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                            <?php
                        }
                        echo form_open('budget/capex_plan_temp_c/approve_capex_by_manager', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Section</th>
                                    <th>Total</th>
                                    <!--<th>Actions</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_plan = null;
                                foreach ($data as $isi) {
                                    if ($isi->INT_APPROVE1 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE1 == 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else {
                                        echo "<tr class='gradeX'>";
                                    }

                                    if ($isi->INT_APPROVE1 == 0 || $isi->INT_APPROVE1 == 2) {
                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_SECTION . '"></input></td>';
                                    } else {
                                        echo '<td><input class="icheck" type="hidden" disabled="true"></input></td>';
                                    }

                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    echo "<td>" . 'Rp ' . number_format($isi->total, 0, '', '.') . "</td>";
                                    ?>
    <!--                                <td>
                                        <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/view_detail_by_supervisor') . "/" . $isi->INT_ID_SECTION . "/" . $isi->INT_ID_FISCAL_YEAR; ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
                                    <?php if ($isi->INT_APPROVE1 == 70) { ?>
                                                <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/reject_capex_plan_temp') . "/" . $isi->INT_ID_SECTION . "/" . $isi->INT_ID_FISCAL_YEAR; ?>" class="label label-danger" data-toggle="tooltip" data-placement="right" title="reject" onclick = "return confirm('Are you sure want to reject this budget?');"><span class="fa fa-thumbs-down"></span></a>
                                    <?php }
                                    ?>
                                    </td>-->
                                    </tr>
                                    <?php
                                    $i++;
                                    $total_plan = $isi->total + $total_plan;
                                }
                                ?> 
                            </tbody>
                        </table>
                        <hr>                        
                        <strong>Total budget Planning <?php echo $group; ?> Dept:</strong><span style="background-color: yellow;"> Rp <?php echo number_format($total_plan, 0, '', '.'); ?></span><br>

                    </div>

                    <?php
                    if ($session['ROLE'] == 5) {
                        ?>
                        <div class = "grid-header">
                            <div class = "grid-body">
                                <div class = "pull-right">
                                    <div class = "form-group">
                                        <?php if ($permit_approve == 1) { ?>
                                            <div class = "btn-group">

                                                <input name="INT_ID_FISCAL" value="<?php echo $this_fiscal_year ?>" type="hidden" id="jYear">
                                                <button type = "submit" na me = "btn_approve" value="0" class = "btn btn-primary" data-toggle = "tooltip" data-placement = "bottom" title = "Approve this budget" onclick = "return confirm('Are you sure want to approve this budget?');"><i class = "fa fa-thumbs-up"></i> Approve</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        <?php } else { ?>
                                            <hr> Budgets are being planned...
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
                        echo form_open('budget/capex_plan_temp_c/reject_capex_plan_temp', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables3" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>No Budget</th>
                                    <th>Budget Name</th>
                                    <th>Total Plan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $w = 1;
                                foreach ($data_capex_detail as $isi) {
                                    if ($isi->INT_APPROVE1 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE1 == 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else {
                                        echo "<tr class='gradeX'>";
                                    }

                                    if ($isi->INT_APPROVE1 == 0) {
                                        echo '<td><input class="icheck" type="checkbox" id="select" name="casereject[]" value="' . $isi->INT_NO_BUDGET_CPX_TEMP . '"></input></td>';
                                    } else {
                                        echo '<td><input class="icheck" type="hidden" disabled="true"></input></td>';
                                    }

                                    echo "<td>$w</td>";
                                    echo "<td>$isi->INT_NO_BUDGET_CPX_TEMP</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    echo "<td>" . 'Rp ' . number_format($isi->DEC_PRICE_PER_UNIT, 0, '', '.') . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/view_detail_capex_plan_temp') . "/" . $isi->INT_NO_BUDGET_CPX_TEMP; ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
                                </td>
                                </tr>
                                <?php
                                $w++;
                            }
                            ?> 
                            </tbody>
                        </table>
                    </div>
                        <div class = "grid-header">
                            <div class = "grid-body">
                                <div class = "pull-right">
                                    <div class = "form-group">
                                        <?php // if ($permit_approve == 1) { ?>
                                            <div class = "btn-group">
                                                <button type = "submit" na me = "btn_approve" value="0" class = "btn btn-danger" data-toggle = "tooltip" data-placement = "bottom" title = "Reject this budget" onclick = "return confirm('Are you sure want to reject this budget?');"><i class = "fa fa-thumbs-down"></i> Reject</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        <?php // } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div> 
            </div>
        </div>

        <div class="row">
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
    categories: ['Section']
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
        name: '<?php echo $row->CHR_SECTION; ?>',
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
                        <span class="grid-title"><strong>SECTION</strong> BUDGETING CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container"></div>
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
                categories: ['Budget Plan Capex']
                },
                        yAxis: {
                title: {
                text: 'Budget plan per number'
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

