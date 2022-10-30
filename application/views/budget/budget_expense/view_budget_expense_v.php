
<aside class="right-side">
    <!-- BEGIN CONTENT HEADER -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/select_expense_by_bod/"') ?>">Manage Budget Expense</a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/select_expense_by_div/"') ?>">Division</a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/select_expense_by_gdept/"') ?>">Group Department</a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/select_expense_by_dept/"') ?>">Department</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/select_expense_by_section/"') ?>">Section</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/expense_detail/' . $data->INT_NO_BUDGET_EXP . '/' . $data->INT_REVISE . '"') ?>"><strong>Budget Expense Detail</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        $session = $this->session->all_userdata();
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>Expense</strong> Budgeting Chart</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chart_details"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div id="3rd_panel" class="grid">
                    <div class="grid-header">
                        <i class="fa fa-calendar"></i>
                        <span class="grid-title"><strong><?php
                                if ($data->INT_ID_UNIT == 0) {
                                    echo'Pure Expense';
                                } else {
                                    echo'Subexpense';
                                }
                                ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <h4><strong><?php echo $data->CHR_BUDGET_NAME ?></strong>'s Details </h4>

                        <table class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <tbody>
                                <tr><td>No Budget</td><td><strong><?php
                                            echo $data->INT_NO_BUDGET_EXP;
                                            if ($data->INT_REVISE != NULL) {
                                                echo " <span class='badge bg-yellow'>Rev " . $data->INT_REVISE . "</span>";
                                            }
                                            ?></strong></td></tr>
                                <tr><td>Budget Name</td><td><?php echo $data->CHR_BUDGET_NAME; ?></td></tr>
                                <tr><td>Allocation</td><td><?php
                                        switch ($data->INT_ALLOCATE) {
                                            case '1': echo 'Regular (Preventive)';
                                                break;
                                            case '2': echo 'Irregular';
                                                break;
                                            default: echo 'New Project';
                                                break;
                                        }
                                        ?></td></tr>
                                <tr><td>Fiscal Year</td><td><?php echo $data->CHR_FISCAL_YEAR; ?></td></tr>
                                <tr><td>Fiscal Detail</td><td><?php
                                        $m_start = trim($data->CHR_MONTH_START);
                                        $m_end = trim($data->CHR_MONTH_END);
                                        if (strlen(trim($data->CHR_MONTH_START)) == 1) {
                                            $m_start = '0' . $data->CHR_MONTH_START;
                                        }
                                        if (strlen(trim($data->CHR_MONTH_END)) == 1) {
                                            $m_end = '0' . $data->CHR_MONTH_END;
                                        }
                                        $date_start = date('Y M ', strtotime($data->CHR_FISCAL_YEAR_START . trim($m_start) . '01000000'));
                                        $date_end = date('Y M ', strtotime($data->CHR_FISCAL_YEAR_END . trim($m_end) . '01000000'));
                                        echo $date_start . ' - ' . $date_end;
                                        ?></td></tr>
                                <?php
                                if ($data->INT_ID_UNIT != 0) {
                                    echo "<tr><td>UOM</td><td>$data->CHR_UNIT</td></tr>";
                                    echo "<tr><td>Price per Unit</td><td>" . number_format($data->DEC_MONEY_PER_UNIT) . "</td></tr>";
                                }
                                ?>
                                <tr><td>Budget Category</td><td><?php echo trim($data->CHR_BUDGET_SUB_CATEGORY) . ' / ' . trim($data->CHR_BUDGET_SUB_CATEGORY_DESC); ?></td></tr>
                                <tr><td>Section</td><td><?php echo $data->CHR_SECTION . ' / ' . $data->CHR_SECTION_DESC; ?></td></tr>
                                <tr><td>Department</td><td><?php echo $data->CHR_DEPT . ' / ' . $data->CHR_DEPT_DESC; ?></td></tr>
                                <tr><td>Cost Center</td><td><?php echo $data->CHR_COST_CENTER . ' / ' . $data->CHR_COST_CENTER_DESC; ?></td></tr>
                            </tbody>
                        </table>
                        <div class="form-group text-center">
                            <div class="btn-group">
                                <?php echo anchor('budget/budget_expense_c', 'Back', 'class="btn btn-block btn-default"'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div id="3rd_panel" class="grid">
                    <div class="grid-header">
                        <i class="fa fa-calendar"></i>
                        <span class="grid-title"><strong><?php echo $data->CHR_BUDGET_NAME ?></strong>'s Budget Details</span>

                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <?php
                        if (($session['ROLE'] == '6') || ($session['ROLE'] == '2') || ($session['ROLE'] == '1')) {
                            if ($data->BIT_LOCK == 0) {
                                ?> <div class="pull-right grid-tools">
                                    <a  title="Add" data-toggle="modal" data-target="#modalAdd" data-toggle="tooltip" data-placement="left" ><i class="fa fa-plus"></i></a>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="grid-body">

                        <h4>Total <strong><?php echo $data->CHR_BUDGET_NAME ?></strong>'s Budget: <strong><?php echo number_format($data->DEC_TOTAL) ?> </strong> </h4>

                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Month Budget</th>
                                    <?php
                                    if (trim($data->INT_ID_UNIT) == 0) {
                                        echo '<th>Amount</th>';
                                        $ex = "'Rp '";
                                    } else {
                                        echo '<th>Quantity</th>';
                                        $ex = "'Qty: '";
                                    }
                                    ?>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $type;
                                if ($data->INT_ID_UNIT == 0) {
                                    $type = 'e';
                                } else {
                                    $type = 's';
                                }
                                $i = 1;
                                $x = count($details);
                                foreach ($details as $isi) {
                                    $color = '';
                                    if ($isi->BIT_FLG_DEL == 1) {
                                        $color = 'warning';
                                    }
                                    echo "<tr class='gradeX $color'>";
                                    echo "<td>$i</td>";
                                    $y = $data->CHR_FISCAL_YEAR_START;
                                    $x = $isi->INT_MONTH_PLAN;
                                    if ($isi->INT_MONTH_PLAN > 12) {
                                        $y = $data->CHR_FISCAL_YEAR_END;
                                        $x = $isi->INT_MONTH_PLAN - 12;
                                    }
                                    if ($x < 10) {
                                        $x = '0' . $x;
                                    }
                                    $date = $y . $x . '01000000';

                                    echo "<td>" . date('Y M ', strtotime($date)) . "</td>";
                                    if (trim($data->INT_ID_UNIT) == 0) {
                                        echo "<td class=\"text-right\">" . number_format($isi->DEC_MONEY_EXPENSE) . "</td>";
                                    } else {
                                        echo "<td class=\"text-center\">$isi->INT_QUANTITY</td>";
                                    }
                                    ?>
                                <td>
                                    <?php
                                    if (($session['ROLE'] == '6') || ($session['ROLE'] == '2') || ($session['ROLE'] == '1')) {
                                        if ($data->BIT_LOCK == 0) {
                                            ?>
                                            <?php if ($isi->BIT_FLG_DEL == 0) { ?>
                                                <a data-toggle="modal" data-target="#modalEdit_<?php echo $data->INT_NO_BUDGET_EXP . '-' . $data->INT_REVISE . '-' . $isi->INT_MONTH_PLAN ?>"  class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <div class="modal fade md-effect-9" id="modalEdit_<?php echo $data->INT_NO_BUDGET_EXP . '-' . $data->INT_REVISE . '-' . $isi->INT_MONTH_PLAN ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                                                    <div class="modal-wrapper">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-yellow">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel9">Edit Budget <?php echo $data->CHR_BUDGET_NAME ?> Detail</h4>
                                                                    <?php
                                                                    $type = 's';
                                                                    if ($data->INT_ID_UNIT == 0) {
                                                                        $type = 'e';
                                                                    }
                                                                    echo form_open('budget/budget_expense_c/edit_expense_detail/' . $data->INT_NO_BUDGET_EXP . '/' . $data->INT_REVISE . '/' . $isi->INT_MONTH_PLAN . '/' . $type, 'class="form-horizontal"');
                                                                    ?>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="modal-body">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="col-sm-4 control-label">Month</label>
                                                                                <label class="col-sm-4 control-label"><?php echo $isi->INT_MONTH_PLAN ?></label>

                                                                            </div>
                                                                            <p>
                                                                                <br>
                                                                                <?php if ($type == 'e') { ?>
                                                                                <div class="form-group">
                                                                                    <label class="col-sm-4 control-label">Amount</label>
                                                                                    <div class="col-sm-6">
                                                                                        <input name="INT_AMOUNT" id="INT_AMOUNT" class="form-control" required value="<?php echo $isi->DEC_MONEY_EXPENSE ?>" type="text">
                                                                                    </div>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="form-group">
                                                                                    <label class="col-sm-4 control-label">Quantity</label>
                                                                                    <div class="col-sm-6">
                                                                                        <input name="INT_QTY" id="INT_QTY" class="form-control" required value="<?php echo $isi->INT_QUANTITY ?>" type="text">
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <br>
                                                                        <p><span style="color: red"></span>Updating amount or quantity only is allowed</p>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Edit</button>
                                                                    </div>
                                                                    <?php echo form_close(); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="<?php echo base_url('index.php/budget/budget_expense_c/delete_expense_detail') . "/" . $isi->INT_NO_BUDGET_EXP . "/" . $isi->INT_REVISE . "/" . $isi->INT_MONTH_PLAN ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this budget detail?');"><span class="fa fa-times"></span></a>

                                            <?php } else { ?>
                                                <a href="<?php echo base_url('index.php/budget/budget_expense_c/restore_expense_detail') . "/" . $isi->INT_NO_BUDGET_EXP . "/" . $isi->INT_REVISE . "/" . $isi->INT_MONTH_PLAN ?>" class="label label-default" onclick="return confirm('Are you sure want to restore this budget detail?');"><span class="fa fa-refresh"></span></a>

                                                <?php
                                            }
                                        }
                                    }
                                    ?>

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
            </div> <!--END BASIC DATATABLES-->


            <script type = "text/javascript">
                                    var chart1;
                                    $(document).ready(function() {
                                        chart1 = new Highcharts.Chart({
                                            chart: {
                                                renderTo: 'chart_details',
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
                                                valuePrefix: <?php echo $ex
                            ?>
                                            },
                                            title: {
                                                text: '<?php echo "<strong>" . $data->CHR_BUDGET_NAME . "</strong>" . " Budgeting Detail" ?>'
                                            },
                                            xAxis: {
                                                categories: [<?php echo $categories ?>]
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'Amount'
                                                }
                                            },
                                            series: [
<?php
foreach ($details as $isi) {

    $y = $data->CHR_FISCAL_YEAR_START;
    $x = $isi->INT_MONTH_PLAN;
    if ($isi->INT_MONTH_PLAN > 12) {
        $y = $data->CHR_FISCAL_YEAR_END;
        $x = $isi->INT_MONTH_PLAN - 12;
    }
    if ($x < 10) {
        $x = '0' . $x;
    }
    $date = $y . $x . '01000000';

    $date = date('Y M ', strtotime($date));
    if (trim($data->INT_ID_UNIT) == 0) {
        $num = $isi->DEC_MONEY_EXPENSE;
    } else {
        $num = $isi->INT_QUANTITY;
    }
    ?>
                                                    {
                                                        name: '<?php echo $date ?>',
                                                        data: [<?php echo $data_budget ?>]
                                                    },
<?php } ?>
                                            ]
                                        });
                                    });
            </script>




        </div>

    </section>
    <!-- END MAIN CONTENT -->
</aside>



<div class="modal fade md-effect-9" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-aqua">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel9">Add Budget <?php echo $data->CHR_BUDGET_NAME ?> Detail</h4>
                    <?php
                    $type = 's';
                    if ($data->INT_ID_UNIT == 0) {
                        $type = 'e';
                    }
                    echo form_open('budget/budget_expense_c/add_detail/' . $data->INT_NO_BUDGET_EXP . '/' . $data->INT_REVISE . '/' . $type, 'class="form-horizontal"');
                    ?>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Month</label>
                                <div class="col-sm-6">
                                    <input name="INT_MONTH" id="INT_MONTH" class="form-control" required type="text">
                                </div>
                            </div>
                            <p>
                                <br>
                                <?php if ($type == 'e') { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Amount</label>
                                    <div class="col-sm-6">
                                        <input name="INT_AMOUNT" id="INT_AMOUNT" class="form-control" required type="text">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Quantity</label>
                                    <div class="col-sm-6">
                                        <input name="INT_QTY" id="INT_QTY" class="form-control" required type="text">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <br>
                        <p><span style="color: red">*</span> Adding detail on the same other detail's month will fail this action.</p>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Add</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade md-effect-9" id="Edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-aqua">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel9">Add Budget <?php echo $data->CHR_BUDGET_NAME ?> Detail</h4>
                    <?php
                    $type = 's';
                    if ($data->INT_ID_UNIT == 0) {
                        $type = 'e';
                    }
                    echo form_open('budget/budget_expense_c/add_detail/' . $data->INT_NO_BUDGET_EXP . '/' . $data->INT_REVISE . '/' . $type, 'class="form-horizontal"');
                    ?>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Month</label>
                                <div class="col-sm-6">
                                    <input name="INT_MONTH" id="INT_MONTH" class="form-control" required type="text">
                                </div>
                            </div>
                            <p>
                                <br>
                                <?php if ($type == 'e') { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Amount</label>
                                    <div class="col-sm-6">
                                        <input name="INT_AMOUNT" id="INT_AMOUNT" class="form-control" required type="text">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Quantity</label>
                                    <div class="col-sm-6">
                                        <input name="INT_QTY" id="INT_QTY" class="form-control" required type="text">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <br>
                        <p><span style="color: red">*</span> Adding detail on the same other detail's month will fail this action.</p>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Add</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>