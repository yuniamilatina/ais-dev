<?php $session = $this->session->all_userdata(); ?>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/capex_plan_temp_c/prepare_approve_capex') ?>">Manage Budget Capex</a></li>            
            <li> <a href="#"><strong>View Budget Capex</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-8">
                <div class="grid top">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong>CAPEX</strong> DETAIL</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <tr><td align='right'><strong>Status</strong></td><td><div class='label label-danger' style='cursor:not-allowed'><i class='fa fa-lock'></div></td></tr>
                            <tr><td align='right'><strong>Fiscal Year</strong></td><td><?php echo $data->CHR_FISCAL_YEAR; ?></td></tr>
                            <tr><td align='right'><strong>No Budget</strong></td><td><?php echo $data->INT_NO_BUDGET_CPX_TEMP; ?></td></tr>
                            <tr><td align='right'><strong>Category</strong></td><td><?php echo $data->CHR_BUDGET_CATEGORY_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Sub Category</strong></td><td><?php echo $data->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Purpose</strong></td><td><?php echo $data->CHR_PURPOSE_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Department</strong></td><td><?php echo $data->CHR_DEPT_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Section</strong></td><td><?php echo $data->CHR_SECTION_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Owner</strong></td><td><?php echo $data->BIT_FLG_OWNER; ?></td></tr>
                            <tr><td align='right'><strong>New/Carry over</strong></td><td><?php echo $data->BIT_FLG_NEW; ?></td></tr>
                            <tr><td align='right'><strong>Type</strong></td><td><?php echo $data->BIT_FLG_CIP; ?></td></tr>
                            <tr><td align='right'><strong>Supplier</strong></td><td><?php echo $data->BIT_FLG_LOCAL; ?></td></tr>
                            <tr><td align='right'><strong>Budget Name</strong></td><td><?php echo $data->CHR_BUDGET_NAME; ?></td></tr>
                            <tr><td align='right'><strong>Plan Month</strong></td><td><?php echo $data->INT_MONTH_PLAN; ?></td></tr>
                            <tr><td align='right'><strong>Price</strong></td><td><?php echo 'Rp ' . number_format($data->DEC_PRICE_PER_UNIT, 0, '', '.'); ?></td></tr>
                            <tr><td align='right'><strong>Quantity</strong></td><td><?php echo $data->INT_QUANTITY; ?></td></tr>
                            <tr><td align='right'><strong>Approve By Manager</strong></td><td><?php echo $data->INT_APPROVE1; ?></td></tr>
                            <tr><td align='right'><strong>Approve By Group Manager</strong></td><td><?php echo $data->INT_APPROVE2; ?></td></tr>
                            <tr><td align='right'><strong>Approve By Director</strong></td><td><?php echo $data->INT_APPROVE3; ?></td></tr>
                        </table>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo anchor('budget/capex_plan_temp_c/prepare_approve_capex', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">PROJECT(S)</span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Project</th>
                                    <th>Project Desc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_project as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PROJECT</td>";
                                    echo "<td>$isi->CHR_PROJECT_DESC</td>";
                                    ?>
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

            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">PRODUCT(S)</span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table  class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Product Desc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_product as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PRODUCT</td>";
                                    echo "<td>$isi->CHR_PRODUCT_DESC</td>";
                                    echo "<tr>";
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