<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">

            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>">Manage Budget Expense</a></li>
            <li> <a href="#">Division</a></li>
            <li> <a href="#">Group Department</a></li>
            <li> <a href="#">Department</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>"><strong>Section</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>Planning</strong> Budget Expense [<?php echo $org->CHR_SECTION; ?>] </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <a data-toggle="modal" data-target="#modalLegend"  title="Legend" data-toggle="tooltip" data-placement="left" ><i class="fa fa-question-circle"></i></a>
                        </div>
                        <!--                        <div class="col-md-2 pull-right">
                                                    <a data-toggle="modal" data-target="#modalLegend" class="btn btn-block btn-default" title="Icons and badges legend">Legend</a>
                                                </div>-->
                        <div class="modal fade md-effect-9" id="modalLegend" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-aqua">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel9">Legends</h4>

                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-body">
                                                <p>Are you sure want to commit this Section's Budgets?</p>
                                                <p>Once Budgets is committed, create, edit, or delete <strong>are not allowed.</strong></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (($session['ROLE'] == '6') || ($session['ROLE'] == '2')) {

                            if ($commit->COMMITED == 0) {
                                ?>
                                <div class="col-md-2 pull-right">
                                    <?php
                                    echo anchor("budget/budget_expense_c/create_expense", "Create", "class='btn btn-block btn-default'");
                                    ?>
                                </div>
                                <?php if ($header != NULL) { ?>
                                    <div class="col-md-2 pull-right">
                                        <a data-toggle="modal" data-target="#modalCommit" class="btn btn-block btn-primary" title="Edit">Commit</a>

                                    </div>
                                <?php
                                }
                            } elseif ($revise > 0) {
                                ?>
                                <div class="col-md-2 pull-right">
                                    <a data-toggle="modal" data-target="#modalRevise" class="btn btn-block btn-primary" title="Edit">Commit Revise</a>

                                </div>
                                <?php
                            } elseif ($unbudget > 0) {
                                ?>
                                <div class="col-md-2 pull-right">
                                    <?php
                                    echo anchor("budget/budget_expense_c/create_expense/u", "Unbudget", "class='btn btn-block btn-warning'");
                                    echo "</div>";
                                }
                            }
                            ?>
                            <div class="modal fade md-effect-9" id="modalRevise" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-yellow">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel9">Commit Revise <?php echo $header->CHR_SECTION; ?> Budget</h4>

                                            </div>
<?php echo form_open('budget/budget_expense_c/commit_expense/' . $header->INT_ID_SECTION, 'class="form-horizontal"'); ?>
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <p>Are you sure want to commit this Section's Budgets?</p>
                                                    <div class="grid-body">

                                                    </div>
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
                            <div class="modal fade md-effect-9" id="modalCommit" tabindex="-1" role="dialog" aria-labelledby="myModalLabe8" aria-hidden="true">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-blue">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel9">Commit <?php echo $header->CHR_SECTION; ?> Budget</h4>

                                            </div>
<?php echo form_open('budget/budget_expense_c/commit_expense/' . $header->INT_ID_SECTION, 'class="form-horizontal"'); ?>
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <p>Are you sure want to commit this Section's Budgets?</p>
                                                    <p>Once Budgets is committed, create, edit, or delete <strong>are not allowed.</strong></p>
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
                        <div class="grid-body">
                            <?php
                            $status = NULL;
                            $rev = NULL;
                            $int_revise = 0;
                            $int_approve = 0;
                            if ($header != NULL) {
                                $int_revise = $header->INT_REVISE;
                                $int_approve = $header->INT_APPROVE;
                            }
                            if ($int_revise != 0) {
                                $rev = "<span class='badge bg-yellow'>Rev " . $header->INT_REVISE . "</span>";
                            }
                            switch ($int_approve) {
                                case '1':
                                    $status = "<span class='badge bg-default'>Commit</span>";
                                    break;
                                case '2':
                                    $status = "<span class='badge bg-green'>Dept</span>";
                                    break;
                                case '3':
                                    $status = "<span class='badge bg-red'>Dept</span>";
                                    break;
                                case '4':
                                    $status = "<span class='badge bg-default'>Dept</span>";
                                    break;
                                case '5':
                                    $status = "<span class='badge bg-green'>G Dept</span>";
                                    break;
                                case '6':
                                    $status = "<td><span class='badge bg-red'>G Dept</span>";
                                    break;
                                case '7':
                                    $status = "<span class='badge bg-default'>G Dept</span>";
                                    break;
                                case '8':
                                    $status = "<span class='badge bg-green'>Div</span>";
                                    break;
                                case '9':
                                    $status = "<td><span class='badge bg-red'>Div</span>";
                                    break;
                                case '10':
                                    $status = "<span class='badge bg-default'>Div</span>";
                                    break;
                                case '11':
                                    $status = "<span class='badge bg-green'>Ok</span>";
                                    break;
                                default:
                                    $status = "<span class='badge bg-aqua'>New</span>";
                                    break;
                            }
                            ?>
                            <?php if ($header != NULL) { ?>
                                <h4 class="col-sm-12">Total <strong><?php echo $header->CHR_SECTION_DESC ?></strong>'s Budget: Rp <strong><?php echo number_format($header->DEC_TOTAL) ?> </strong> <?php echo " $status $rev" ?></h4>
<?php } ?>
                            <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Budget</th>
                                        <th>Budget Name</th>
                                        <th>Sub Category</th>
                                        <th>Allocate</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;

                                    foreach ($data as $isi) {
                                        $color = '';
                                        $rev = '';
                                        $unb = '';
                                        if ($isi->BIT_UNBUDGET == true) {
                                            $unb = "<span class='badge bg-red'>Un</span>";
                                        }

                                        if ($isi->INT_ID_UNIT != 0) {
                                            $color = 'info';
                                        }
                                        echo "<tr class='gradeX " . $color . "'>";
                                        echo "<td>$i</td>";

                                        echo "<td>$isi->INT_NO_BUDGET_EXP $unb</td>";
                                        echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                        echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";
                                        echo "<td>";
                                        if ($isi->INT_ALLOCATE == 1) {
                                            echo 'Regular';
                                        } elseif ($isi->INT_ALLOCATE == 2) {
                                            echo 'Irregular';
                                        } else {
                                            echo 'New Project';
                                        }
                                        echo "</td>";
                                        echo "<td class='text-right'>" . number_format($isi->DEC_TOTAL) . "</td>";
                                        ?>

                                    <td>
                                        <a href="<?php echo base_url('index.php/budget/budget_expense_c/expense_detail') . "/" . $isi->INT_NO_BUDGET_EXP . "/" . $isi->INT_REVISE . "/" ?>" class="label label-success"><span class="fa fa-check"></span></a>

                                        <?php
                                        if (($session['ROLE'] == '6') || ($session['ROLE'] == '2') || ($session['ROLE'] == '1')) {
                                            if (((($isi->INT_APPROVE == 3) || ($isi->INT_APPROVE == 6) || ($isi->INT_APPROVE == 9) ) && ($isi->BIT_LOCK == 0)) || ($isi->INT_APPROVE == 0)) {
                                                ?>
                                                <a href="<?php echo base_url('index.php/budget/budget_expense_c/edit_expense') . "/" . $isi->INT_NO_BUDGET_EXP . "/" . $isi->INT_REVISE . "/" ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo base_url('index.php/budget/budget_expense_c/delete_expense') . "/" . $isi->INT_NO_BUDGET_EXP . "/" . $isi->INT_REVISE . "/" ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this budget expense?');"><span class="fa fa-times"></span></a>

                                                <?php
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
                </div>

                <script type="text/javascript">
                                        var chart1;
                                        $(document).ready(function() {
                                            chart1 = new Highcharts.Chart({
                                                chart: {
                                                    renderTo: 'chart_budget',
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
                                                    categories: ['Budget Name']
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
                                                            name: '<?php echo $row->CHR_BUDGET_NAME; ?>',
                                                            data: [<?php echo $row->DEC_TOTAL; ?>]
                                                        },
<?php } ?>
                                                ]
                                            });
                                        });
                </script>
<?php if ($data != NULL) { ?>
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
                                <div id="chart_budget"></div>
                            </div>
                        </div>
                    </div>

<?php } ?>
            </div>

    </section>
</aside>