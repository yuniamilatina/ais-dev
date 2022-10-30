<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/"') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>"><strong>Manage Budget Expense</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">BUDGET <strong>EXPENSE</strong></span>
                        <div class="col-md-3 pull-right">
                            <?php echo anchor('budget/budget_expense_c/create_expense', 'Create Budget Expense', 'class="btn btn-block btn-primary"'); ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Budget Name</th>
                                    <th>No Budget</th>
                                    <th>Fiscal Year</th>
                                    <th>Budget</th>
                                    <th>Allocate</th>
                                    <th>Section</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;

                                foreach ($data as $isi) {
                                    $color = '';
                                    if ($isi->INT_ID_UNIT != NULL) {
                                        $color = 'info';
                                    }
                                    echo "<tr class='gradeX " . $color . "'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    echo "<td>$isi->CHR_NO_BUDGET</td>";
                                    echo "<td>$isi->CHR_FISCAL_YEAR</td>";
                                    echo "<td>$isi->CHR_BUDGET</td>";
                                    echo "<td>";
                                    if ($isi->INT_ALLOCATE == 1) {
                                        echo 'Regular';
                                    } elseif ($isi->INT_ALLOCATE == 2) {
                                        echo 'Irregular';
                                    } else {
                                        echo 'New Project';
                                    }
                                    echo "</td>";
                                    echo "<td>$isi->CHR_GROUP</td>";
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/budget/budget_expense_c/expense_detail') . "/" . $isi->INT_ID_NO_BUDGET ?>" class="label label-success"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/budget_expense_c/edit_expense') . "/" . $isi->INT_ID_NO_BUDGET ?>" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/budget/budget_expense_c/delete_expense') . "/" . $isi->INT_ID_NO_BUDGET ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this budget expense?');"><span class="fa fa-times"></span></a>
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
        </div>

    </section>
</aside>