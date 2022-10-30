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
                            <tr><td align='right'><strong>Description</strong></td><td><?php echo $data->CHR_PROBLEM_DESC; ?></td></tr>

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
                        ?>

                    </div>

                </div>
            </div>

            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-file-text"></i>
                        <span class="grid-title"><strong>PROGRESS OF PROBLEM</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" data-toggle="tooltip" data-placement="left" ><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="gradeX">
                                        <th>No</th>
                                        <th>Date Progress</th>
                                        <th>Progress Desc</th>
                                        <th>Solver</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
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
                                        echo "<td>$isi->CHR_PROGRESS_DESC</td>";
                                        echo "<td>$isi->CHR_PROVER_DESC</td>";
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/progress_desc_c/close_ticket') . "/" . $isi->INT_ID_PROGRESS . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Close This Ticket" onclick="return confirm('This Feedback solved the problem?');"><span class="fa fa-thumbs-up"></span></a>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/progress_desc_c/not_close_ticket') . "/" . $isi->INT_ID_PROGRESS . "/" . $isi->INT_ID_TICKET; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Not Solve This Ticket" onclick="return confirm('This Feedback Does not solved the problem?');"><span class="fa fa-thumbs-down"></span></a>
                                    </td>
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

            </div>
        </div>
    </section>
</aside>