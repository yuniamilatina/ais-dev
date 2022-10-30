<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/problem_type_c/') ?>">Manage Helpdesk Ticket</a></li>
            <li> <a href="#"><strong>Create Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
        echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('helpdesk_ticket/problem_type_c/save_problem_type', 'class="form-horizontal"');
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>CREATE PROBLEM TYPE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Type Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_PROBLEM_TYPE" class="form-control" maxlength="3" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Type Desc</label>
                            <div class="col-sm-6">
                                <input name="CHR_PROBLEM_TYPE_DESC" class="form-control" maxlength="50" required type="text" style="width: 450px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('helpdesk_ticket/problem_type_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>