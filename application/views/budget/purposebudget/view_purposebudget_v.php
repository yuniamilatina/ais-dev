<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/budget/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/purposebudget_c/') ?>">Manage Purpose Budget</a></li>            
            <li><a href="#"><strong>View Purpose Budget</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-usd"></i>
                        <span class="grid-title"><?php echo $data->CHR_PURPOSE; ?> PURPOSE BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-striped display" cellspacing="0" width="100%">


                            <tr><td>Purpose Budget Initial</td><td><?php echo $data->CHR_PURPOSE; ?></td></tr>

                            <tr><td>Purpose Budget Description</td><td><?php echo $data->CHR_PURPOSE_DESC; ?></td></tr>

                        </table>
                        <?php echo anchor('budget/purposebudget_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"'); ?>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</aside>