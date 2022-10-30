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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/'); ?>"><span><strong>Manage Helpdesk Ticket</strong></span></a></li>
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
                        <i class="fa fa-wrench"></i>

                        <span class="grid-title"><strong>HELPDESK TICKETS TABLE</strong></span>
                        <?php
                        $session = $this->session->all_userdata();
                        if ($session['ROLE'] != '6') {
                            ?>
                            <div class="pull-right">
                                <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="grid-body">
                        <div class="pull btn-group">
                            <table class="table table-condensed table-bordered display" style='border:2px solid #cccccc;text-align: center'>
                                <tr>
                                    <td class="gradeX default"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/0'); ?>" style="color:#666666;">Wait Approve</a></td>
                                    <td class="gradeX warning"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/1'); ?>" style="color:#666666;">Not Started</a></td>
                                    <td class="gradeX info"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/2'); ?>" style="color:#666666;">On Progress</a></td>
                                    <td class="gradeX success"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/3'); ?>" style="color:#666666;">Done</a></td>
                                    <td class="gradeX danger"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/4'); ?>" style="color:#666666;">Rejected</a></td>
                                    <td><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/12'); ?>" style="color:#666666;">All Status</a></td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Ticket</th>
                                        <th>User</th>
                                        <th>Problem Date</th>
                                        <th>Due Date</th>
                                        <th>Problem Type</th>
<!--                                        <th>Problem Title</th>-->
                                        <th>Dept</th>
                                        <th>PIC</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        $btn = 'success';
                                        $color = NULL;
                                        $level = null;
                                        $late = NULL;

                                        if ($isi->INT_STATUS == 2) {
                                            $color = 'info';
                                            $status = 'Solved';
                                        } else if ($isi->INT_STATUS == 1) {
                                            $color = 'warning';
                                            $status = 'On Progress';
                                        } else if ($isi->INT_STATUS == 3) {
                                            $color = 'success';
                                            $status = '-';
                                        } else if ($isi->INT_STATUS == 4) {
                                            $color = 'danger';
                                            $status = '-';
                                        } else {
                                            $color = 'default';
                                            $status = 'Not Started';
                                        }

                                        echo "<tr class='gradeX " . $color . "'>";
                                        echo "<td class='td-no'>$i</td>";
                                        echo "<td class='td-no'>$isi->INT_ID_TICKET</td>";
//                                        echo "<td>$status</td>";
                                        echo "<td>$isi->CHR_USERNAME</td>";
                                        $finish_date = date("d-M-Y", strtotime($isi->CHR_DUE_DATE));
                                        $start_date = date("d-M-Y", strtotime($isi->CHR_CREATE_DATE));
                                        echo "<td class='td-no'>$start_date</td>";
                                        echo "<td class='td-no'>$finish_date</td>";
                                        echo "<td>$isi->CHR_PROBLEM_TYPE - $isi->CHR_ASSET_NAME</td>";
//                                        echo "<td>$isi->CHR_PROBLEM_TITLE</td>";
                                        echo "<td class='td-no'>$isi->CHR_DEPT</td>";
                                        echo "<td class='td-no'>$isi->CHR_PROVER_DESC</td>";
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/view_detail_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                        <?php
                                        if (trim($isi->CHR_NPK) == trim($npk)) {
                                            if ($isi->INT_STATUS == '0' || $isi->INT_STATUS == '4') {
                                                ?>
                                                <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/edit_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/print_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-info" data-placement="bottom" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
                                                <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/delete_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this helpdesk_ticket?');"><span class="fa fa-times"></span></a>

                                            <?php }
                                        } ?>
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