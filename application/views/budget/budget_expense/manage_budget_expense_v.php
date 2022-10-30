<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/budget_expense_c/"') ?>"><strong>Manage Budget Expense</strong></a></li>
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
                        <span class="grid-title"><strong>Planning</strong> Budget Expense [Admin]</span>
                        <div class="col-md-2 pull-right">
                            <?php
                            echo anchor("budget/budget_expense_c/create_expense", "Create", "class='btn btn-block btn-default'");
                            ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if($header!=NULL){ ?>
                        <h4 class="col-sm-12">Total <strong><?php echo $header->CHR_COMPANY_DESC?></strong>'s Budget: Rp <strong><?php echo number_format($header->DEC_TOTAL) ?> </strong></h4>
                        <?php } ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th>No Budget</th>
                                    <th>Budget Name</th>
                                    <th>Sub Category</th>
                                    <th>Section</th>
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
                                    if ($isi->INT_REVISE != 0) {
                                        $rev = "<span class='badge bg-yellow'>Rev " . $isi->INT_REVISE . "</span>";
                                    }
                                    if ($isi->INT_ID_UNIT != 0) {
                                        $color = 'info';
                                    }
                                    echo "<tr class='gradeX " . $color . "'>";
                                    echo "<td>$i</td>";
                                    switch ($isi->INT_APPROVE) {
                                        case '1':
                                            echo"<td><span class='badge bg-default'>Sect</span></td>";
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
                                            echo"<td><span class='badge bg-default'>Dept</span></td>";
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
                                            echo"<td><span class='badge bg-aqua'>New</span></td>";
                                            break;
                                    }
                                    echo "<td>$isi->INT_NO_BUDGET_EXP  $rev $unb</td>";
                                    echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                    echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";

                                    echo "<td>$isi->CHR_SECTION</td>";
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
        </div>

    </section>
</aside>