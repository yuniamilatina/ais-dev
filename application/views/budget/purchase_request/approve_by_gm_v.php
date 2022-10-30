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
            <li><a href="<?php echo base_url('index.php/budget/home_c/') ?>"><span>Home</span></a></li>
            <?php if ($session['ROLE'] == 3) { ?>
                <li><a href ="<?php echo base_url('index.php/budget/purchase_request_c/prepare_approve_purchase_request') ?>">Gruop Dept List</a></li>
            <?php } ?>
            <li> <a href="#"><strong>Department List</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PUREQ</strong> <?php echo $group . ' [' . $fiscal . ']' ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($session['ROLE'] == 4) { ?>
                            <div class="pull" hidden="true">
                                <?php echo form_open('budget/purchase_request_c/search_purchase_request', 'class="form-horizontal"'); ?>
                                <select name="INT_ID_FISCAL_YEAR" autofocus onchange="ChooseFiscal(this);" class="ddl">
                                    <?php
                                    foreach ($data_fiscal as $isi) {
                                        if ($new_fiscal == $isi->INT_ID_FISCAL_YEAR) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                                <button type="submit" name="search" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search"><i class="fa fa-search"></i></button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Dept</th> 
                                    <th>Planning</th> 
                                    <th>Actual</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_real = 0;
                                $total_plan = 0;
                                foreach ($data as $isi) {
                                    if ($isi->INT_APPROVE2 === 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE2 === 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else {
                                        echo "<tr class='gradeX default'>";
                                    }

                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DEPT</td>";
                                    $total_plan = $this->capex_plan_m->get_total_capex_plan_by_dept($isi->INT_ID_DEPT, $isi->INT_ID_FISCAL_YEAR);
                                    echo "<td>" . 'Rp ' . number_format($total_plan, 0, '', '.') . "</td>";
                                    echo "<td>" . 'Rp ' . number_format($isi->total, 0, '', '.') . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/view_detail_by_manager') . '/' . $isi->INT_ID_DEPT . '/' . $isi->INT_ID_FISCAL_YEAR; ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                                $total_real = $isi->total + $total_real;
                            }
                            ?>
                            </tbody>
                        </table>
                        <hr>                        
                        <strong>Total budget Planning <?php echo $group; ?> Dept:</strong> <span style="background-color: yellow;">Rp <?php echo number_format($total_plan, 0, '', '.'); ?></span><br>
                        <strong>Total budget Realization <?php echo $group; ?> Dept:</strong> <span style="background-color: yellow;">Rp <?php echo number_format($total_real, 0, '', '.'); ?></span><br>
                        ________________________________________________  ___<br>
                        <strong>Total budget Balance <?php echo $group; ?> Dept:</strong> <span style="background-color: yellow;">Rp <?php echo number_format($total_plan - $total_real, 0, '', '.'); ?></span><br>                    

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="grid-title">ALL <strong>PUREQ </strong> <?php echo $group ?> </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo form_open('budget/purchase_request_c/approve_purchase_request', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables3" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>No Pureq</th>
                                    <th>Month</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $w = 1;
                                foreach ($data_pureq_detail as $isi) {
                                    if ($isi->INT_APPROVE2 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    } else if ($isi->INT_APPROVE2 == 2) {
                                        echo "<tr class='gradeX danger'>";
                                    } else if ($isi->INT_APPROVE2 == 0) {
                                        echo "<tr class='gradeX default'>";
                                    }

                                    if ($isi->INT_APPROVE2 != 1) {
                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_NO_PUREQ . '"></input></td>';
                                    } else {
                                        echo '<td><input class="icheck" type="hidden" disabled="true"></input></td>';
                                    }
                                    echo "<td>$w</td>";
                                    echo "<td>$isi->INT_NO_PUREQ</td>";
                                    echo "<td>$isi->INT_MONTH_REAL</td>";
                                    echo "<td>" . 'Rp ' . number_format($isi->DEC_TOTAL, 0, '', '.') . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/purchase_request_c/view_detail_purchase_request_by_other') . "/" . $isi->INT_NO_PUREQ; ?>" class="label label-success" data-toggle="tooltip" data-placement="right" title="View"><span class="fa fa-check"></span></a>
                                    <?php if ($isi->INT_APPROVE2 == 0) { ?>
                                        <a href="<?php echo base_url('index.php/budget/purchase_request_c/reject_purchase_request') . "/" . $isi->INT_NO_PUREQ; ?>" class="label label-danger" data-toggle="tooltip" data-placement="right" title="reject" onclick = "return confirm('Are you sure want to reject this budget?');"><span class="fa fa-thumbs-down"></span></a>
                                    <?php }
                                    ?>
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
                                    <div class = "btn-group">
                                        <button type = "submit" name = "btn_approve" class = "btn btn-primary" data-toggle = "tooltip" data-placement = "bottom" title = "Approve this budget" onclick = "return confirm('Are you sure want to approve this budget?');"><i class = "fa fa-thumbs-up"></i> Approve</button>
                                        <?php echo form_close(); ?>
                                    </div>
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
    categories: ['Planning', 'Actual']
    },
            yAxis: {
    title: {
    text: 'Total Budget'
    }
    },
            series: [
<?php
foreach ($data as $row) {
    $total_plan_per_dept = $this->capex_plan_m->get_total_capex_plan_by_dept($row->INT_ID_DEPT, $row->INT_ID_FISCAL_YEAR);
    ?>
        {
        name: '<?php echo $row->CHR_DEPT; ?>',
                data: [<?php echo $total_plan_per_dept; ?>,<?php echo $row->total; ?>]
        },
<?php } ?>
    ]
    });
    });</script>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>DEPARTMENT</strong> PURCHASING CHART</span>
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
                categories: ['Purchase Request']
                },
                        yAxis: {
                title: {
                text: 'Amount'
                }
                },
                        series: [
<?php
foreach ($data_pureq_detail as $row) {
    ?>
                    {
                    name: '<?php echo $row->INT_NO_PUREQ . '[' . $row->CHR_DEPT . ']'; ?>',
                            data: [<?php echo $row->DEC_TOTAL; ?>]
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
                        <span class="grid-title"><strong>PURCHASE </strong>REQUEST CHART</span>
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
