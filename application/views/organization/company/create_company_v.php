<aside class="right-side">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
                <li><a href="<?php echo base_url('index.php/organization/company_c/') ?>">Manage Company</a></li>
                <li> <a href="#"><strong>Create Company</strong></a></li>
            </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('organization/company_c/save_company', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-university"></i>
                        <span class="grid-title"><strong>CREATE</strong> COMPANY</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Company Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_COMPANY" class="form-control" maxlength="3" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Company Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_COMPANY_DESC" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('organization/company_c', 'Cancel', 'class="btn btn-default"'); 
                                    echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>