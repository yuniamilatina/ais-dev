<script type="text/javascript">
    $(document).ready(function () {
        $("#btn_create").click(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/helpdesk_ticket/helpdesk_ticket_c/show_update",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function (data) {
                    $("#2nd_panel").html(data);
                }
            });
        });
    });
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/') ?>">Manage Helpdesk Ticket</a></li>            
            <li><a href="#"><strong>View Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong>HELPDESK</strong> TICKET DETAIL</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <?php
                            $date = DateTime::createFromFormat('Ymd', $data->CHR_CREATE_DATE);
                            $date_problem = $date->format('d-M-Y');
                            $time = DateTime::createFromFormat('His', $data->CHR_CREATE_TIME);
                            $time_problem = $time->format('H:i');
                            ?>

                            <tr><td align='right'><strong>No Ticket</strong></td><td><?php echo $data->INT_ID_TICKET; ?></td></tr>
                            <tr><td align='right'><strong>User</strong></td><td><?php echo $data->CHR_USERNAME; ?></td></tr>
                            <tr><td align='right'><strong>Department</strong></td><td><?php echo $data->CHR_DEPT; ?></td></tr>
                            <tr><td align='right'><strong>Status Ticket</strong></td><td><?php echo $data->INT_APPROVE; ?></td></tr>
                            <tr><td align='right'><strong>Problem Title</strong></td><td><?php echo $data->CHR_PROBLEM_TITLE; ?></td></tr>
                            <tr ><td align='right'><strong>Description</strong></td><td><?php echo $data->CHR_PROBLEM_DESC; ?></td></tr>
                            <?php
                            if ($in_queue == $data->INT_ID_TICKET) {
                                ?>
                                <a data-toggle="modal" data-target="#modalProverEdit_<?php echo $data->INT_ID_TICKET; ?>" class="label label-warning" title="Edit"><span class="fa fa-pencil"></span></a>
                            <?php } ?>
                            
                        </table>


                        <div class="modal fade md-effect-18" id="modalProverEdit_<?php echo $data->INT_ID_TICKET; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel9">CHANGE PROBLEM SOLVER</h4>
                                        </div>
                                        <?php echo form_open('helpdesk_ticket/helpdesk_ticket_c/change_prover', 'class="form-horizontal"'); ?>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">No Ticket</label>
                                                <div class="col-sm-3">
                                                    <input name="INT_ID_TICKET" class="form-control" required type="text" readonly="true" value="<?php echo $data->INT_ID_TICKET; ?>">
                                                </div>                                            
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Choose PIC</label>
                                                <div class="col-sm-5">
                                                    <select name="INT_ID_PROVER" class="form-control">
                                                        <?php
                                                        foreach ($data_prover as $isi) {
                                                            if ($data->INT_ID_PROVER == $isi->INT_ID_PROVER) {
                                                                ?> 
                                                                <option selected value="<?php echo $isi->INT_ID_PROVER; ?>"><?php echo $isi->CHR_PROVER . ' - ' . $isi->CHR_PROVER_DESC; ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $isi->INT_ID_PROVER; ?>"><?php echo $isi->CHR_PROVER . ' - ' . $isi->CHR_PROVER_DESC; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?> 
                                                    </select>
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



                    </div>
                    <div class="grid-body">
                        <?php
                        echo anchor('helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
</aside>