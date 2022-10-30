<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/organization/subsection_c/') ?>">Manage Section</a></li>            
            <li><a href="#"><strong>View Section</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-users"></i>
                        <span class="grid-title"><strong>SUB</strong> SECTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-striped table-condensed table-striped display" cellspacing="0" width="100%">

                            <tr><td>Subsection Initial</td><td><?php echo $data->CHR_SUB_SECTION; ?></td></tr>

                            <tr><td>Subsection Description</td><td><?php echo $data->CHR_SUB_SECTION_DESC; ?></td></tr>

                            <tr><td>Section</td><td><?php echo $data->CHR_SECTION; ?></td></tr>

                        </table>
                        <?php echo anchor('organization/subsection_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"'); ?>
                    </div>
                    

                </div>
            </div>
        </div>
    </section>
</aside>