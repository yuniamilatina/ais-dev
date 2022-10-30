
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

            <div class="col-md-6">
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
                            $start_date = date("d/M/Y", strtotime($data->CHR_CREATE_DATE));
                            if ($data->CHR_FINISH_DATE == NULL) {
                                $finish_date = '---';
                            } else {
                                $finish_date = date("d/M/Y", strtotime($data->CHR_FINISH_DATE));
                            }
                            if ($data->CHR_DUE_DATE == NULL) {
                                $due_date = '---';
                            } else {
                                $due_date = date("d/M/Y", strtotime($data->CHR_DUE_DATE));
                            }
                            ?>
                            <tr><td align='right'><strong>No Ticket</strong></td><td><?php echo $data->INT_ID_TICKET; ?></td></tr>
                            <tr><td align='right'><strong>User</strong></td><td><?php echo $data->CHR_USERNAME; ?></td></tr>
                            <tr><td align='right'><strong>Department</strong></td><td><?php echo $data->CHR_DEPT; ?></td></tr>

                            <tr><td align='right'><strong>Problem Type</strong></td><td><?php echo $data->CHR_PROBLEM_TYPE_DESC; ?></td></tr>
                            <tr><td align='right'><strong>Asset</strong></td><td><?php echo $data->CHR_ASSET_NAME; ?></td></tr>
                            <tr><td align='right'><strong>Problem Title</strong></td><td><?php echo $data->CHR_PROBLEM_TITLE; ?></td></tr>
                            <tr><td align='right'><strong>Description</strong></td><td><?php echo $data->CHR_PROBLEM_DESC; ?></td></tr>

                            <tr><td align='right'><strong>Problem Start date</strong></td><td><?php echo $start_date; ?></td></tr>
                            <tr><td align='right'><strong>Status Ticket</strong></td><td><?php echo $data->CHR_STATUS; ?></td></tr>
                            <?php if ($data->INT_STATUS == 4) { ?>
                                <tr><td align='right'><strong>Reject Reason</strong></td><td><?php echo $data->CHR_REJECT_DESC; ?></td></tr>
                            <?php } ?>
                            <tr><td align='right'><strong>Approval Status</strong></td><td><?php echo $data->INT_APPROVE; ?></td></tr>
                            <?php if ($data->INT_STATUS == 2 || $data->INT_STATUS == 3) { ?>
                                <tr><td align='right'><strong>Due date</strong></td><td><?php echo $due_date; ?></td></tr>
                                <tr><td align='right'><strong>Finish date</strong></td><td><?php echo $finish_date; ?></td></tr>
                                <tr><td align='right'><strong>Problem Solver</strong></td><td><?php echo $data->CHR_PROVER; ?></td></tr>
                                <tr><td align='right'><strong>Cost Solve</strong></td><td><?php echo $data->DEC_COST_SOLVE; ?></td></tr>
                            <?php } ?>
                        </table>

                    </div>
                    <div class="grid-body">
                        <?php
                        echo anchor('helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket', 'Back', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="grid">

                    <div class="grid-body">

                        <?php
                        $start_date = date("d/M/Y", strtotime($data->CHR_CREATE_DATE));

                        if ($data->CHR_FINISH_DATE == NULL) {
                            $finish_date = '---';
                        } else {
                            $finish_date = date("d/M/Y", strtotime($data->CHR_FINISH_DATE));
                        }
                        if ($data->CHR_DUE_DATE == NULL) {
                            $due_date = '---';
                        } else {
                            $due_date = date("d/M/Y", strtotime($data->CHR_DUE_DATE));
                        }
                        ?>
                        <span class="grid-title"><h4><strong>Info Problem</strong></h4></span>





                        <?php echo 'Problem Tittle : '.trim($data->CHR_PROBLEM_TITLE); ?>
                        <b class="badge"><?php echo trim($data->CHR_PROBLEM_TYPE_DESC); ?></b>
                        <b class='badge bg-red'>urgent</b><br>

                        <p><?php echo 'Problem Description : '.trim($data->CHR_PROBLEM_DESC); ?> </p>
                        
                        <div class="pull-right">Opened by <strong><?php echo trim($data->CHR_USERNAME); ?></strong> 
                            (<?php echo $data->CHR_DEPT; ?>), <i><?php echo $start_date; ?></i>
                        </div>
                        <br>
                        <hr>


                        <div class="pull-right">PIC by <strong><?php echo $data->CHR_PROVER_DESC; ?></strong>, Due date <i><?php echo $due_date; ?></i>
                        </div>
                        <span class="grid-title"><h4><strong>Progress</strong></h4></span>


                        <table class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                                <tr class="gradeX bg-info">
                                    <th>No</th>
                                    <th>Date Progress</th>
                                    <th>Progress Desc</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_progress as $isi) {
                                    echo "<tr class='gradeX default'>";
                                    echo "<td>$i</td>";
                                    $progress_date = date("d-M-Y", strtotime($isi->CHR_PROGRESS_DATE));
                                    echo "<td>$progress_date</td>";
                                    echo "<td>$isi->CHR_PROGRESS_DESC</td></tr>";
                                    $i++;
                                }
                                ?>
                            </tbody>

                        </table>



                    </div>
                </div>
            </div>

        </div>
    </section>
</aside>