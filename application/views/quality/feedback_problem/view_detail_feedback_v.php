
<style>
    .button{
        background-color: #3A89CF;
        font-size:13px; 
        transition-duration: 0.1s;
        border: none;
        cursor: pointer;
    }
    
    .button1:hover{
        background-color: #0075b0;
    }
    
    .button1:disabled{
        background-color: #83B3DC;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/quality_feedback_c/') ?>">Manage Feedback Problem</a></li>            
            <li><a href="#"><strong>View Detail Feedback</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>DETAIL FEEDBACK</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed  display" cellspacing="0" width="100%">
                            <tr><td>Action Type</td><td><strong><?php echo $data_feedback->INT_ACTION_TYPE; ?></strong></td></tr>
                            <tr><td>Created Date</td><td><?php echo $data_feedback->CHR_CREATED_DATE; ?></td></tr>
                            <tr><td>Created By</td><td><?php echo $data_feedback->CHR_CREATED_BY; ?></td></tr>
                            <tr><td>Corrective Action</td><td><?php echo $data_feedback->CHR_FEEDBACK_DESC; ?></td></tr>
                            <tr><td>Cause Problem</td><td><?php echo $data_feedback->INT_CAUSE_PROBLEM; ?></td></tr>
                            <tr><td>Man Analysis</td><td><?php echo $data_feedback->CHR_MAN_ANALYSIS; ?></td></tr>
                            <tr><td>Machine Analysis</td><td><?php echo $data_feedback->CHR_MACHINE_ANALYSIS; ?></td></tr>
                            <tr><td>Material Analysis</td><td><?php echo $data_feedback->CHR_MATERIAL_ANALYSIS; ?></td></tr>
                            <tr><td>Methode Analysis</td><td><?php echo $data_feedback->CHR_METHODE_ANALYSIS; ?></td></tr>
                            <tr><td>Evidence</td><td><?php if ($data_feedback->CHR_FILEUPLOAD != NULL){ echo 'Yes &nbsp;  <a href="' . base_url('index.php/quality/quality_feedback_c/download_evidence') . '/' . $data_feedback->INT_ID . '" class="label label-primary" style="color:white;"><i class="fa fa-download"></i></a>'; } else { echo 'No'; }?></td></tr>
                        </table>
                        <?php 
                            echo anchor('quality/quality_feedback_c/select_quality_problem_by_id/' . $data_feedback->INT_ID_QPROBLEM, 'Back', 'class="btn btn-default"');
                        ?>
                            <a href="<?php echo base_url('index.php/quality/quality_feedback_c/delete_feedback_problem') . "/" . $data_feedback->INT_ID . "/" . $data_feedback->INT_ID ?>" class="btn btn-danger" data-placement="right" title="Delete" onclick="return confirm('Are you sure want to delete this feedback?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>        
    </section>
</aside>