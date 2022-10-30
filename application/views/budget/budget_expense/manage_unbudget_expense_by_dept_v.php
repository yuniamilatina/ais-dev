
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>">Manage Unbudget Expense</a></li>
            <li> <a href="#">Division</a></li>
            <li> <a href="#">Group Department</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/prepare_approve_unbudget_expense"') ?>"><strong>Department</strong></a></li>
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
                        <span class="grid-title"><strong>UNBUDGET </strong>EXPENSE <?php echo $org->CHR_DEPT; ?> Department </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>

                    </div>
                    <div class="grid-body">
                        <?php echo form_open('budget/budget_expense_c/approve_unbudget_expense/', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Status</th>
                                    <th>No Budget</th>
                                    <th>Name</th>
                                    <th>Section</th>
                                    <th>Sub Category</th>
                                    <th>Allocation</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    if ($isi->INT_APPROVE == 1) {
                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_SECTION . '"></input></td>';
                                    } else {
                                        echo '<td><input class="icheck" type="checkbox" disabled="true"></input></td>';
                                    }
                                    echo "<td>$i</td>";
                                    switch ($isi->INT_APPROVE) {
                                        case '1':
                                            echo"<td><span class='badge bg-aqua'>New</span></td>";
                                            break;
                                        case '2':
                                            echo"<td><span class='badge bg-green'>Dept</span></td>";
                                            break;
                                        case '3':
                                            if ($isi->BIT_LOCK == 1) {
                                                echo"<td><span class='badge bg-red'><span class='fa fa-lock'></span>Dept</span></td>";
                                            } else {
                                                echo"<td><span class='badge bg-red'><span class='fa fa-unlock'></span>Dept</span></td>";
                                            }
                                            break;
                                        case '4':
                                            echo"<td><span class='badge bg-default'>Commit</span></td>";
                                            break;
                                        case '5':
                                            echo"<td><span class='badge bg-green'>G Dept</span></td>";
                                            break;
                                        case '6':
                                            if ($isi->BIT_LOCK == 1) {
                                                echo"<td><span class='badge bg-red'><span class='fa fa-lock'></span>G Dept</span></td>";
                                            } else {
                                                echo"<td><span class='badge bg-red'><span class='fa fa-unlock'></span>G Dept</span></td>";
                                            }
                                            break;
                                        case '7':
                                            echo"<td><span class='badge bg-default'>G Dept</span></td>";
                                            break;
                                        case '8':
                                            echo"<td><span class='badge bg-green'>Div</span></td>";
                                            break;
                                        case '9':
                                            if ($isi->BIT_LOCK == 1) {
                                                echo"<td><span class='badge bg-red'><span class='fa fa-lock'></span>Div</span></td>";
                                            } else {
                                                echo"<td><span class='badge bg-red'><span class='fa fa-unlock'></span>Div</span></td>";
                                            }
                                            break;
                                        case '10':
                                            echo"<td><span class='badge bg-default'>Div</span></td>";
                                            break;
                                        case '11':
                                            echo"<td><span class='badge bg-green'>Ok</span></td>";
                                            break;
                                        default:
                                            echo"<td><span class='badge bg-default'>Pending</span></td>";
                                            break;
                                    }
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    echo "<td class='text-right'>" . number_format($isi->TOTAL) . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/budget_expense_c/select_expense_by_section') . "/" . $isi->INT_ID_SECTION ?>" class="label label-success"><span class="fa fa-search"></span></a>
                                    <?php if ($isi->INT_APPROVE == 1) { ?>
                                        <a href="<?php echo base_url('index.php/budget/budget_expense_c/reject_expense') . "/" . $isi->INT_ID_SECTION . "/" ?>" class="label label-danger"  onclick="return confirm('Are you sure want to reject this budget expense?');"><span class="fa fa-times"></span></a>
                                    <?php } elseif (($isi->INT_APPROVE == 3) && ($isi->BIT_LOCK == 1)) {
                                        ?>
                                        <a href="<?php echo base_url('index.php/budget/budget_expense_c/unlock_expense') . "/" . $isi->INT_ID_SECTION . "/" ?>" class="label label-warning"><span class="fa fa-unlock"></span></a>
                                    <?php } ?>

                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php if ($approve_button == '1') { ?>
                            <div class="form-group text-center">
                                <br>
                                <div class="btn-group ">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check "></i> Approve</button>
                                </div>
                            </div>
                            <?php
                        }
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                                    var chart1;
                                    $(document).ready(function() {
                                        chart1 = new Highcharts.Chart({
                                            chart: {
                                                renderTo: 'chart',
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
                                                        data: [<?php echo $row->TOTAL; ?>]
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
                        <span class="grid-title"><strong>SECTION</strong> BUDGETING CHART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>


        </div>

    </section>
</aside>