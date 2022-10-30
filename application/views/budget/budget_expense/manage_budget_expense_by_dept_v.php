
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/prepare_approve_expense"') ?>">Manage Budget Expense</a></li>
            <li> <a href="#">Division</a></li>
            <li> <a href="#">Group Department</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/prepare_approve_expense"') ?>"><strong>Department</strong></a></li>
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
                        <span class="grid-title">EXPENSE<strong> <?php echo $org->CHR_DEPT; ?> </strong>Department </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>

                        <div class="col-md-3 pull-right">
                            <?php
                            $commit_button = '0';
                            $approve_button = '1';
                            if ($commit == '1') {//all ready to commit
                                $commit_button = '1';
                                $approve_button = '0';
                            } elseif ($commit == '2') {// not ready to commit
                                $approve_button = '0';
                            }
                            if ($commit_button == '1') {
                                if ($header != NULL) {
                                    ?>
                                    <a data-toggle="modal" data-target="#modalCommit" class="btn btn-block btn-primary" title="Edit">Commit</a>
                                    <?php
                                }
                            }
                            ?>
                            <div class="modal fade md-effect-9" id="modalCommit" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-blue">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel9">Commit <?php echo $header->CHR_DEPT; ?> Budget</h4>

                                            </div>
<?php echo form_open('budget/budget_expense_c/commit_expense/' . $header->INT_ID_DEPT, 'class="form-horizontal"'); ?>
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <p>Are you sure want to commit this Department's Budgets?</p>
                                                    <p>Once Budgets is committed, approve and reject <strong>are not allowed.</strong></p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Commit</button>
                                                </div>
                                            </div>
<?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($header != NULL) { ?>
                            <h4 class="col-sm-12">Total <strong><?php echo $header->CHR_DEPT ?></strong>'s Budget: Rp <strong><?php echo number_format($header->DEC_TOTAL) ?> </strong></h4>
                            <?php
                        }
                        echo form_open('budget/budget_expense_c/approve_expense/', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th>Section</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                $approve = null;
                                $box = "<td><input class='icheck' type='checkbox' disabled='true'></input></td>";
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    foreach ($data_status as $value) {
                                        if ($value->INT_ID_SECTION == $isi->INT_ID_SECTION) {
                                            $approve = $value->INT_APPROVE;
                                            if ($value->INT_APPROVE == 1) {
                                                $box = "<td><input class='icheck' type='checkbox' id='select' name='case[]' value='" . $isi->INT_ID_SECTION . "'></input></td>";
                                            }
                                        }
                                    }
                                    echo $box;
                                    echo "<td>$i</td>";
                                    switch ($approve) {
                                        case '1':
                                            echo"<td><span class='badge bg-aqua'>New</span></td>";
                                            break;
                                        case '2':
                                            echo"<td><span class='badge bg-green'>Dept</span></td>";
                                            break;
                                        case '3':
                                            echo"<td><span class='badge bg-red'>Dept</span></td>";
                                            break;
                                        case '4':
                                            echo"<td><span class='badge bg-default'>Commit</span></td>";
                                            break;
                                        case '5':
                                            echo"<td><span class='badge bg-green'>G Dept</span></td>";
                                            break;
                                        case '6':
                                            echo"<td><span class='badge bg-red'>G Dept</span></td>";
                                            break;
                                        case '7':
                                            echo"<td><span class='badge bg-default'>G Dept</span></td>";
                                            break;
                                        case '8':
                                            echo"<td><span class='badge bg-green'>Div</span></td>";
                                            break;
                                        case '9':
                                            echo"<td><span class='badge bg-red'>Div</span></td>";
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
                                    <?php if ($approve == 1) { ?>
                                        <a href="<?php echo base_url('index.php/budget/budget_expense_c/reject_expense') . "/" . $isi->INT_ID_SECTION . "/" ?>" class="label label-danger"  onclick="return confirm('Are you sure want to reject this budget expense?');"><span class="fa fa-times"></span></a>
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
<?php if ($header != NULL) { ?>
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
<?php } ?>

        </div>

    </section>
</aside>