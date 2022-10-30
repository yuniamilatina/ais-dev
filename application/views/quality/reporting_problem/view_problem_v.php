<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/quality_problem_c/') ?>">Manage Quality Problem</a></li>            
            <li><a href="#"><strong>View Reporting Problem</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>PROBLEM DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <?php
                            if ($data_detail->INT_STATUS == 0) {
                                $status = 'Not Started';
                            } else if ($data_detail->INT_STATUS == 1) {
                                $status = 'On Progress';
                            } else {
                                $status = 'Complete';
                            }
                            ?>
                            <tr><td>No TR</td><td><?php echo $data_detail->CHR_TR_NO; ?></td></tr>
                            <tr><td>Problem</td><td><?php echo $data_detail->CHR_QPROBLEM_TITLE; ?></td></tr>
                            <tr><td>Problem Desc</td><td><?php echo $data_detail->CHR_QPROBLEM_DESC; ?></td></tr>
                            <tr><td>Back No</td><td><?php echo $data_detail->CHR_BACK_NO; ?></td></tr>
                            <tr><td>Part Name</td><td><?php echo $data_detail->CHR_PART_NAME; ?></td></tr>
                            <tr><td>Section Inspector</td><td><?php echo $data_detail->CHR_SECTION_REQ; ?></td></tr>
                            <tr><td>Inspector</td><td><?php echo $data_detail->CHR_REQUESTOR; ?></td></tr>
                            <tr><td>Section Before Process</td><td><?php echo $data_detail->CHR_SECTION_PIC; ?></td></tr>
                            <tr><td>PIC Before Process</td><td><?php echo $data_detail->CHR_PIC; ?></td></tr>
                            <tr><td>Qty Part NG</td><td><?php echo $data_detail->INT_QTY; ?></td></tr>
                            <tr><td>Defective Date</td><td><?php echo $data_detail->CHR_START_DATE; ?></td></tr>
                            <tr><td>Defective Time</td><td><?php echo date("H:i", strtotime($data_detail->CHR_START_TIME)); ?></td></tr>
                            <tr><td>Accepted Date</td><td><?php echo $data_detail->CHR_CREATED_DATE; ?></td></tr>
                            <tr><td>Accepted Time</td><td><?php echo $data_detail->CHR_CREATED_TIME; ?></td></tr>
                            <tr><td>Due Date</td><td><?php echo $data_detail->CHR_DUE_DATE; ?></td></tr>
                            <tr><td>Due Time</td><td><?php echo date("H:i", strtotime($data_detail->CHR_DUE_TIME)); ?></td></tr>
                            <tr><td>Status</td><td><?php echo $status; ?></td></tr>

                        </table>
                        <?php echo anchor('quality/quality_problem_c', 'Back', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>LIST FEEDBACK</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Feedback</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_FEEDBACK_DESC</td>";
                                    echo "<td>$isi->CHR_CREATED_DATE</td>";
                                    echo "<td>$isi->CHR_CREATED_TIME</td>";
                                    echo "<td>$isi->INT_ACTION_TYPE</td>";
                                    ?>
                                <?php if ($isi->INT_STATUS == 0){ ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/quality/quality_feedback_c/solved') . "/" . $isi->INT_ID . "/" . $isi->INT_ID_QPROBLEM ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Solved" onclick="return confirm('Solved?');"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/quality/quality_feedback_c/not_solved') . "/" . $isi->INT_ID . "/" . $isi->INT_ID_QPROBLEM  ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Not Solved" onclick="return confirm('Not Solved?');"><span class="fa fa-times"></span></a>
                                </td>
                                <?php } else { 
                                    if ($isi->INT_STATUS == 2){
                                        echo "<td>Solved</td>";
                                    } if ($isi->INT_STATUS == 1){
                                        echo "<td>Not Solved</td>";
                                    }
                                 } ?>
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
    </section>
</aside>