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
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/room/room_reservation_c') ?>">Manage Reservation</a></li>
            <li><a href="#"><strong>View Reservation</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>VIEW RESERVATION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <tr><td align='right'><strong>No Reservation</strong></td><td><?php echo $data->CHR_ID_RESERV; ?></td></tr>
                            <tr><td align='right'><strong>Meeting Desc</strong></td><td style="white-space:pre-wrap ; word-wrap:break-word;"><?php echo $data->CHR_MEETING_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Description</strong></td><td><?php echo $data->CHR_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Meeting PIC</strong></td><td><?php echo $data->CHR_MEETING_PIC; ?></td></tr>
                            <tr><td align='right'><strong>Dept PIC</strong></td><td><?php echo $data->CHR_MEETING_DEPT; ?></td></tr>
                            <tr><td align='right'><strong>Date Start</strong></td><td><?php echo date("d-M-Y", strtotime($data->CHR_DATE_FROM)); ?></td></tr>
                            <tr><td align='right'><strong>Date Finish</strong></td><td><?php echo date("d-M-Y", strtotime($data->CHR_DATE_TO)); ?></td></tr>
                            <tr><td align='right'><strong>Time Start</strong></td><td><?php echo date('H:i', strtotime($data->CHR_TIME_FROM)); ?></td></tr>
                            <tr><td align='right'><strong>Time Finish</strong></td><td><?php echo date('H:i', strtotime($data->CHR_TIME_TO)); ?></td></tr>
                            
                            <?php if ($data->INT_FLG_MEETING == 1) {
                                echo "<tr><td align='right'><strong>Meeting</strong></td><td><img src='" . base_url() . "/assets/img/check1.png' width='25'></td></tr>";
                            } else {
                                echo "<tr><td align='right'><strong>Meeting</strong></td><td><img src='" . base_url() . "/assets/img/error1.png' width='25'></td></tr>";
                            } ?>

                            <?php if ($data->INT_FLG_GENBA == 1) {
                                echo "<tr><td align='right'><strong>Plant Tour</strong></td><td><img src='" . base_url() . "/assets/img/check1.png' width='25'></td></tr>";
                            } else {
                                echo "<tr><td align='right'><strong>Plant Tour</strong></td><td><img src='" . base_url() . "/assets/img/error1.png' width='25'></td></tr>";
                            } ?>

                            <?php if ($data->INT_FLG_CONFERENCE == 1) {
                                echo "<tr><td align='right'><strong>TV Conference</strong></td><td><img src='" . base_url() . "/assets/img/check1.png' width='25'></td></tr>";
                            } else {
                                echo "<tr><td align='right'><strong>TV Conference</strong></td><td><img src='" . base_url() . "/assets/img/error1.png' width='25'></td></tr>";
                            } ?>

                            <tr><td align='right'><strong>Agenda</strong></td><td style="white-space:pre-wrap ; word-wrap:break-word;"><?php echo $data->CHR_AGENDA; ?></td></tr>

                        </table>

                        <?php
                        echo anchor('room/room_reservation_c/', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>

                    </div>

                </div>
            </div>
            <!--</div>-->
            <!--        <div class="row">-->
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>ATTENDANCE LIST</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example1" class="table table-condensed display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="gradeX">
                                        <th>No</th>
                                        <th>NPK</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_attendance as $isi) {
                                        
                                        echo "<td>$i</td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_NPK</td>";

                                        if ($i == 1) {
                                            //if ($i == $numrows) {
                                            ?>
                                        <td>
                                            <a data-toggle="modal" data-target="#modaledit<?php echo $isi->CHR_ID_RESERV . $isi->INT_ID; ?>" data-placement="left" data-toggle="tooltip" title="Edit Feedback" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                            <a href="<?php echo base_url('index.php/helpdesk_ticket/progress_desc_c/close_ticket') . "/" . $isi->INT_ID . "/" . $isi->CHR_ID_RESERV; ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Close This Ticket" onclick="return confirm('This Feedback solved the problem?');"><span class="fa fa-thumbs-up"></span></a>
                                            <a href="<?php echo base_url('index.php/helpdesk_ticket/progress_desc_c/not_close_ticket') . "/" . $isi->INT_ID . "/" . $isi->CHR_ID_RESERV; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Not Solve This Ticket" onclick="return confirm('This Feedback Does not solved the problem?');"><span class="fa fa-thumbs-down"></span></a>
                                        </td>
                                    <?php } else { ?>
                                        <td> 
                                            <a data-toggle="modal" data-target="#modaledit<?php echo $isi->CHR_ID_RESERV . $isi->INT_ID; ?>" data-placement="left" data-toggle="tooltip" title="Edit Feedback" class="label label-warning"><span class="fa fa-pencil"></span></a>
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
                    </div>
                </div>


                <?php
                $i = 1;

                foreach ($data_attendance as $isi_modal) {
                    ?>
                    <!--EDIT FEEDBACK-->
                    <div class="modal fade" id="modaledit<?php echo $isi_modal->CHR_ID_RESERV . $isi_modal->INT_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Progress</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('helpdesk_ticket/progress_desc_c/edit_progress', 'class="form-horizontal"'); ?>

                                        <input name="CHR_ID_RESERV" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi_modal->CHR_ID_RESERV ?>">
                                        <input name="INT_ID" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi_modal->INT_ID ?>">

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
                <div class="modal fade" id="modalprogress<?php echo $data->CHR_ID_RESERV ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Add Progress</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo form_open('helpdesk_ticket/progress_desc_c/add_progress', 'class="form-horizontal"'); ?>

                                    <input name="CHR_ID_RESERV" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $data->CHR_ID_RESERV ?>">

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
                <div class="modal fade" id="modalreject<?php echo $data->CHR_ID_RESERV ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Reject Desc</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo form_open('room/room_reservation_c//add_reject_desc', 'class="form-horizontal"'); ?>

                                    <input name="CHR_ID_RESERV" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $data->CHR_ID_RESERV ?>">

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
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: false,
                                                bFilter: false,
                                                fixedColumns: {
                                                    leftColumns: 2
                                                }
                                            });
                                        });

</script>