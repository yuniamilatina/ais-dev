<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/budgetsubcategory_c/') ?>">Manage Sub Category Budget</a></li>            
            <li><a href="#"><strong>View Sub Category Budget</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-usd"></i>
                        <span class="grid-title"><strong><?php echo $data->CHR_BUDGET_SUB_CATEGORY; ?></strong> BUDGET SUB CATEGORY</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-striped table-condensed table-striped display" cellspacing="0" width="100%">

                            <tr><td>Sub category Budget Initial</td><td><?php echo $data->CHR_BUDGET_SUB_CATEGORY; ?></td></tr>

                            <tr><td>Sub category Budget Description</td><td><?php echo $data->CHR_BUDGET_SUB_CATEGORY_DESC; ?></td></tr>

                            <tr><td>Type</td><td><?php echo $data->CHR_BUDGET_CATEGORY; ?></td></tr>

                        </table>
                        <?php echo anchor('budget/budgetsubcategory_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>