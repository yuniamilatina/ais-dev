<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/approve_helpdesk_ticket'); ?>"><strong>Approve Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        echo form_open('helpdesk_ticket/helpdesk_ticket_c/approve_helpdesk_ticket', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-check-square"></i>
                        <span class="grid-title"><strong>APPROVAL HELPDESK TICKET</strong></span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Ticket</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Problem Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $color = NULL;


                                    if ($isi->INT_STATUS == 1) {
                                        $color = 'warning';
                                    } else if ($isi->INT_STATUS == 2) {
                                        $color = 'info';
                                    } else if ($isi->INT_STATUS == 3) {
                                        $color = 'success';
                                    } else if ($isi->INT_STATUS == 4) {
                                        $color = 'danger';
                                    }

                                    echo "<tr class='gradeX " . $color . "'>";
//                                    if ($isi->INT_STATUS == 0) {
//                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_TICKET . '"></input></td>';
//                                    } else {
//                                        echo '<td></td>';
//                                    }
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->INT_ID_TICKET</td>";
                                    echo "<td>$isi->CHR_USERNAME</td>";
                                    $start_date = date("d-M-Y", strtotime($isi->CHR_CREATE_DATE)).' '.date("h:i", strtotime($isi->CHR_CREATE_TIME));
                                    echo "<td>$start_date</td>";
                                    echo "<td>$isi->CHR_PROBLEM_TYPE_DESC</td>";
                                    echo "<td>$isi->CHR_ASSET_NAME - $isi->CHR_PROBLEM_TITLE</td>";
                                    ?>
                                <td>
                                     <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/view_detail_helpdesk_ticket_for_approve') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <?php if ($isi->INT_STATUS == 0) { ?>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/approve_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Appprove" onclick = "return confirm('Are you sure want to approve this ticket?');"><span class="fa fa-thumbs-up"></span></a>
                                        <a data-toggle="modal" data-target="#modalReject_<?php echo $isi->INT_ID_TICKET; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Reject"><span class="fa fa-thumbs-down"></span></a>
                                    <?php } ?>
                                </td>

                                <div class="modal fade md-effect-18" id="modalReject_<?php echo $isi->INT_ID_TICKET; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
                                    <div class="modal-wrapper">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel9">REASON REJECTED</h4>
                                                </div>
                                                <?php echo form_open('helpdesk_ticket/helpdesk_ticket_c/reject_helpdesk_ticket', 'class="form-horizontal"'); ?>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">No Ticket</label>
                                                        <div class="col-sm-3">
                                                            <input name="INT_ID_TICKET" class="form-control" required type="text" readonly="true" value="<?php echo $isi->INT_ID_TICKET; ?>">
                                                        </div>                                            
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Reason</label>
                                                        <div class="col-sm-7">
                                                            <input name="CHR_REJECT_DESC" class="form-control" required type="text">
                                                        </div>                                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="btn-group">
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($to_approve != 0) { ?>
<!--                        <div class = "grid-header">
                            <div class = "grid-body">
                                <div class="btn-group">
                                    <button type = "submit" name = "btn_approve" class = "btn btn-primary" data-toggle = "tooltip" data-placement = "left" title = "Approve this ticket" onclick = "return confirm('Are you sure want to approve this ticket?');"><i class = "fa fa-thumbs-up"></i> Approve</button>
                                </div>
                            </div>
                        </div>-->
                        <?php
                    }
                    echo form_close();
                    ?>

                </div>
            </div>
        </div>

    </section>
</aside>