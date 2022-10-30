<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/prover_c/') ?>">Manage Prover</a></li>            
            <li><a href="#"><strong>View Detail Prover</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        echo form_open('helpdesk_ticket/prover_c/moving_ticket', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong><?php echo strtoupper($data->CHR_PROVER_DESC); ?>'S TASKS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Ticket</th>
                                    <th>User</th>
                                    <th>Date of Problem</th>
                                    <th>Finish date</th>
                                    <th>Problem Type</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_ticket as $isi) {
                                    if ($isi->INT_STATUS === 0) {
                                        echo "<tr class='gradeX default'>";
                                    } else if ($isi->INT_STATUS === 1) {
                                        echo "<tr class='gradeX warning'>";
                                    } else if ($isi->INT_STATUS === 2) {
                                        echo "<tr class='gradeX info'>";
                                    } else if ($isi->INT_STATUS === 3) {
                                        echo "<tr class='gradeX success'>";
                                    }

                                    if ($isi->INT_STATUS === 0 || $isi->INT_STATUS === 1) {
                                        echo '<td><input class="icheck" type="checkbox" id="select" name="case[]" value="' . $isi->INT_ID_TICKET . '"></input></td>';
                                    } else {
                                        echo '<td></td>';
                                    }

                                    echo "<td>$isi->INT_ID_TICKET</td>";
                                    echo "<td>$isi->CHR_USERNAME</td>";
                                    $date_problem = date('d-M-Y', strtotime($isi->CHR_CREATE_DATE));
                                    $time_problem = date('H:i', strtotime($isi->CHR_CREATE_TIME));
                                    $date_problem2 = $isi->CHR_FIX_DATE;
                                    $time_problem2 = $isi->CHR_FIX_TIME;
                                    if ($isi->CHR_FIX_DATE == NULL && $isi->CHR_FIX_TIME == NULL) {
                                        $date_problem2 = '';
                                        $time_problem2 = '-';
                                    } else {
                                        $date_problem = date('d-M-Y', strtotime($isi->CHR_FIX_DATE));
                                        $time_problem = date('H:i', strtotime($isi->CHR_FIX_TIME));
                                    }
                                    echo "<td>$date_problem $time_problem</td>";
                                    echo "<td>$date_problem2 $time_problem2</td>";
                                    echo "<td>$isi->CHR_PROBLEM_TYPE - $isi->CHR_PROBLEM_TYPE_DESC</td>";
                                    echo "<td>$isi->CHR_DEPT</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/view_detail_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="grid-body">
                        <input type="hidden" name="INT_ID_PROVER" value="<?php echo $data->INT_ID_PROVER; ?>">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <select name="INT_ID_PROVER_NEW" class="ddl" data-toggle="tooltip" data-placement="right" title="Choose department to move" style="width:300px">
                                    <?php
                                    foreach ($data_prover as $isi) {
                                        if ($data->INT_ID_PROVER === $isi->INT_ID_PROVER) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_PROVER; ?>"><?php echo $isi->CHR_PROVER_DESC . ' - ' . $isi->CHR_PROVER_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_PROVER; ?>"><?php echo $isi->CHR_PROVER_DESC . ' - ' . $isi->CHR_PROVER_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure want to moving this tickets?');"><i class="fa fa-refresh"></i> Move</button>
                                    <?php
                                    echo anchor('helpdesk_ticket/prover_c', 'Back', 'class="btn btn-default"');
                                    echo form_close()
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

