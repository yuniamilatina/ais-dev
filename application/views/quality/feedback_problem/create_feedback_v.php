<script>
    $(document).ready(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/quality_problem_c/') ?>">Manage Quality Problem</a></li>
            <li><a href="#"><strong>Give Feedback Problem</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('quality/quality_feedback_c/send_feedback', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-edit"></i>
                        <span class="grid-title"><strong>FEEDBACK PROBLEM</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <input name="INT_ID_QPROBLEM" class="form-control" required type="hidden" style="width: 300px;">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Feedback Desc</label>
                            <div class="col-sm-5">
                                <textarea rows="4" cols="50" name="CHR_FEEDBACK_DESC" class="form-control" ></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Send feedback"><i class="fa fa-check"></i> Send</button>
                                    <?php
                                    echo anchor('quality/quality_problem_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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