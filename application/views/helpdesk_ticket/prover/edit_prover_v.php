<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/') ?>">Manage Problem Solver</a></li>            
            <li><a href="#"><strong>Edit Problem Solver</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('helpdesk_ticket/prover_c/update_prover', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>EDIT PROBLEM SOLVER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_PROVER" class="form-control" required type="hidden" value="<?php echo $data->INT_ID_PROVER; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Solver Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_PROVER" class="form-control" maxlength=4" required type="text" value="<?php echo trim($data->CHR_PROVER); ?>" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Solver Desc</label>
                            <div class="col-sm-5">
                                <input name="CHR_PROVER_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo trim($data->CHR_PROVER_DESC); ?>" style="width: 200px;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('helpdesk_ticket/prover_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
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