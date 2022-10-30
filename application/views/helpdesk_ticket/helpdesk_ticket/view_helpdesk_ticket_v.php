<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        text-align: center;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/') ?>">Manage Helpdesk Ticket</a></li>            
            <li><a href="#"><strong>View Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-md-5">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong>HELPDESK TICKET DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <?php
                            $start_date = date("d-M-Y", strtotime($data->CHR_CREATE_DATE));
                            $finish_date = date("d-M-Y", strtotime($data->CHR_FIX_DATE));
                            $due_date = date("d-M-Y", strtotime($data->CHR_DUE_DATE));
                            ?>
                            <tr><td align='right'><strong>No Ticket</strong></td><td><?php echo $data->INT_ID_TICKET; ?></td></tr>
                            <tr><td align='right'><strong>User</strong></td><td><?php echo $data->CHR_USERNAME; ?></td></tr>
                            <tr><td align='right'><strong>Department</strong></td><td><?php echo $data->CHR_DEPT; ?></td></tr>

                            <tr><td align='right'><strong>Problem Type</strong></td><td><?php echo $data->CHR_PROBLEM_TYPE_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Asset</strong></td><td><?php echo $data->CHR_ASSET_NAME; ?></td></tr>
                            <tr><td align='right'><strong>Priority</strong></td><td><?php echo $data->INT_PRIORITY; ?></td></tr>
                            <tr><td align='right'><strong>Problem Title</strong></td><td><?php echo $data->CHR_PROBLEM_TITLE; ?></td></tr>
                            <tr><td align='right'><strong>Description</strong></td><td style="white-space:pre-wrap ; word-wrap:break-word;"><?php echo $data->CHR_PROBLEM_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Problem Start date</strong></td><td><?php echo $start_date; ?></td></tr>
                            <tr><td align='right'><strong>Status Ticket</strong></td><td><?php echo $data->CHR_STATUS; ?></td></tr>
                            <?php if ($data->INT_STATUS == 4) { ?>
                                <tr><td align='right'><strong>Reject Reason</strong></td><td><?php echo $data->CHR_REJECT_DESC; ?></td></tr>
                            <?php } ?>
                            <tr><td align='right'><strong>Due date</strong></td><td><?php echo $due_date; ?></td></tr>
                            <?php if ($data->INT_STATUS == 3) { ?>
                                <tr><td align='right'><strong>Finish date</strong></td><td><?php echo $finish_date; ?></td></tr>
                            <?php } ?>
                        </table>

                        <?php
                        echo anchor('helpdesk_ticket/helpdesk_ticket_c', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        if ($data->INT_STATUS == 0) {
                            ?>
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/approve_ticket') . "/" . $data->INT_ID_TICKET; ?>" class="btn btn-success" data-placement="right" data-toggle="tooltip" title="Approve This Ticket" onclick="return confirm('Approve this ticket');"><span class="fa fa-thumbs-up"></span>&nbsp; Approve</a> 
                            <button data-toggle="modal" data-target="#modalreject<?php echo $data->INT_ID_TICKET ?>" data-placement="left" data-toggle="tooltip" title="Reject This Ticket" class="btn btn-danger"><i class="fa fa-thumbs-down"></i>&nbsp; Reject</button>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <!--</div>-->
            <!--<div class="row">-->
            <div class="col-md-7">
                
               

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong>PROGRESS OF PROBLEM</strong></span>
                        <div class="pull-right grid-tools">
                            <!-- <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example1" class="table table-condensed display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="gradeX">
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Progress Desc</th>
                                        <th>Solver</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    $numrows = $count_progress;

                                    foreach ($data_progress as $isi) {
                                        if ($isi->INT_FLG_DONE == 1) {
                                            echo "<tr class='gradeX success'>";
                                        } else if ($isi->INT_FLG_DONE == 0) {
                                            echo "<tr class='gradeX danger'>";
                                        } else {
                                            echo "<tr class='gradeX'>";
                                        }
                                        echo "<td>$i</td>";
                                        $progress_date = date("d-M-Y", strtotime($isi->CHR_PROGRESS_DATE));
                                        echo "<td>$progress_date</td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>".trim($isi->CHR_PROGRESS_DESC)."</td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_PROVER_DESC</td>";

                                        if ($i == 1) {
                                        //if ($i == $numrows) {
                                            ?>
                                        <td>
                                            <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_TICKET . $isi->INT_ID_PROGRESS; ?>" data-placement="left" data-toggle="tooltip" title="Edit Feedback" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                            <a href="<?php echo base_url('index.php/helpdesk_ticket/progress_desc_c/close_ticket') . "/" . $isi->INT_ID_PROGRESS . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Close This Ticket" onclick="return confirm('This Feedback solved the problem?');"><span class="fa fa-thumbs-up"></span></a>
                                            <a href="<?php echo base_url('index.php/helpdesk_ticket/progress_desc_c/not_close_ticket') . "/" . $isi->INT_ID_PROGRESS . "/" . $isi->INT_ID_TICKET; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Not Solve This Ticket" onclick="return confirm('This Feedback Does not solved the problem?');"><span class="fa fa-thumbs-down"></span></a>
                                        </td>
                                        <?php } else { ?>
                                        <td> 
                                            <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_TICKET . $isi->INT_ID_PROGRESS; ?>" data-placement="left" data-toggle="tooltip" title="Edit Feedback" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                            <label class='label bg-black'>Not solved </label>
                                        </td>
                                    <?php }
                                    ?>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>


                        <?php if ($data->INT_STATUS == 2 || $data->INT_STATUS == 1 || $data->INT_STATUS == 4) { ?>
                            <button data-toggle="modal" data-target="#modalprogress<?php echo $data->INT_ID_TICKET ?>" data-placement="left" data-toggle="tooltip" title="Give Feedback" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Progress</button>
<?php } ?>

                    </div>
                </div>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong>PROBLEM IMAGE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input type="image" src='<?php echo base_url($data->CHR_IMAGE_URL); ?>' style="width:100%;" >
                    </div>
                </div>            

                <?php
                $i = 1;
                $numrows = $count_progress;

                foreach ($data_progress as $isi_modal) {
                    ?>
                    <!--EDIT FEEDBACK-->
                    <div class="modal fade" id="modaledit<?php echo $isi_modal->INT_ID_TICKET . $isi_modal->INT_ID_PROGRESS; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Progress</strong></h4>
                                    </div>
                                    <div class="modal-body">
    <?php echo form_open('helpdesk_ticket/progress_desc_c/edit_progress', 'class="form-horizontal"'); ?>

                                        <input name="INT_ID_TICKET" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi_modal->INT_ID_TICKET ?>">
                                        <input name="INT_ID_PROGRESS" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi_modal->INT_ID_PROGRESS ?>">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Progress Desc</label>
                                            <div class="col-sm-8">
                                                <textarea rows="5" cols="500" name="CHR_PROGRESS_DESC" class="form-control" ><?php echo trim($isi_modal->CHR_PROGRESS_DESC); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
    <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>

                <!--CREATE FEEDBACK-->
                <div class="modal fade" id="modalprogress<?php echo $data->INT_ID_TICKET ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Add Progress</strong></h4>
                                </div>
                                <div class="modal-body">
<?php echo form_open('helpdesk_ticket/progress_desc_c/add_progress', 'class="form-horizontal"'); ?>

                                    <input name="INT_ID_TICKET" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $data->INT_ID_TICKET ?>">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Progress Desc</label>
                                        <div class="col-sm-7">
                                            <textarea rows="5" cols="500" name="CHR_PROGRESS_DESC" class="form-control" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
<?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--ADD REJECT-->
                <div class="modal fade" id="modalreject<?php echo $data->INT_ID_TICKET ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Reject Desc</strong></h4>
                                </div>
                                <div class="modal-body">
<?php echo form_open('helpdesk_ticket/helpdesk_ticket_c/add_reject_desc', 'class="form-horizontal"'); ?>

                                    <input name="INT_ID_TICKET" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $data->INT_ID_TICKET ?>">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Reject Desc</label>
                                        <div class="col-sm-5">
                                            <textarea rows="2" cols="500" name="CHR_REJECT_DESC" class="form-control" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
<?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</aside>


<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                                $(document).ready(function () {
                                        var table = $('#example1').DataTable({
                                        scrollY: "350px",
                                                scrollX: false,
                                                scrollCollapse: true,
                                                paging: false,
                                                bFilter: false,
                                                fixedColumns: {
                                                leftColumns: 2
                                                }
                                        });
                                        });
                                                
</script>