<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgetcategory_a3_c/') ?>">Manage Budget Category A3</a></li>            
            <li><a href="#"><strong>View Budget Category</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-usd"></i>
                        <span class="grid-title"><strong><?php echo $data->CHR_CODE_CATEGORY_A3; ?></strong> BUDGET CATEGORY A3</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Budget Sub Category Initial</th>
                                    <th>Budget Sub Category Description</th>
                                    <th>Budget Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_budgetsubcategory as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY</td>";
                                    echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";
                                    echo "<td>$isi->CHR_BUDGET_CATEGORY</td>";
                                    ?>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php echo anchor('budget/budgetcategory_a3_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"'); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>