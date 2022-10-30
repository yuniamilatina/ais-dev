<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script>

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
                                <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="grid-body">
                       <div class="pull btn-group" style="padding-bottom:10px;">
                           <!--<div class="pull">-->
                                <table width="40%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                    <tr>
                                        <td width="3%" style='text-align:left;' colspan="4"><strong>Legend :</strong></td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" title="Click to filter" class="btn" style='border:0;background:#7DD488;width:25px;height:25px;' href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/3'); ?>"></a> : Done
                                        </td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" title="Click to filter" class="btn" style='border:0;background:#00CED1;width:25px;height:25px;' href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/2'); ?>"></a> : On Progress
                                        </td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" title="Click to filter" class="btn"  style='background:#DDDDDD;border:0;width:25px;height:25px;' href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/0'); ?>"></a> : Wait Approve
                                        </td>
                                        <td width="3%" colspan="4"></td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" title="Click to filter" class="btn" style='background:#FFB401;border:0;width:25px;height:25px;' href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/1'); ?>"></a> : Not Started
                                        </td>
                                        <td width="10%">        
                                            <a data-toggle="tooltip" data-placement="left" title="Click to filter" class="btn" style='background:#E63F53;border:0;width:25px;height:25px;' href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/4'); ?>"></a> : Rejected
                                        </td>
                                        <td width="10%">
                                            <a data-toggle="tooltip" data-placement="left" title="Click to filter" class="btn"  style='background:#000000;border:0;width:25px;height:25px;' href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/12'); ?>"></a> : All Status
                                        </td>
                                        
                                    </tr>
                                </table>
                           
                            <!--</div>-->
                            <!-- <table class="table table-condensed table-bordered display" style='border:2px solid #cccccc;text-align: center'>
                                <tr>
                                    <td class="gradeX default"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/0'); ?>" style="color:#666666;">Wait Approve</a></td>
                                    <td class="gradeX warning"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/1'); ?>" style="color:#666666;">Not Started</a></td>
                                    <td class="gradeX info"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/2'); ?>" style="color:#666666;">On Progress</a></td>
                                    <td class="gradeX success"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/3'); ?>" style="color:#666666;">Done</a></td>
                                    <td class="gradeX danger"><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/4'); ?>" style="color:#666666;">Rejected</a></td>
                                    <td><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/select_by_status/12'); ?>" style="color:#666666;">All Status</a></td>
                                </tr>
                            </table>-->
                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Desc</th>
                                        <th>User</th>
                                        <!-- <th>Problem Date</th>
                                        <th>Due Date</th> -->
                                        <th>Problem Type</th>
                                        <th>Dept</th>
                                        <!-- <th>PIC</th> -->
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
                                            $color = '#00CED1';
                                            $status = 'On Progress';
                                        } else if ($isi->INT_STATUS == 1) {
                                            $color = '#FFB401';
                                            $status = 'Not Started';
                                        } else if ($isi->INT_STATUS == 3) {
                                            $color = '#7DD488';
                                            $status = 'Done';
                                        } else if ($isi->INT_STATUS == 4) {
                                            $color = '#E63F53';
                                            $status = 'Rejected';
                                        } else {
                                            $color = '#DDDDDD';
                                            $status = 'Wait Approve';
                                        }

                                        echo "<tr>";
                                        echo "<td style='text-align:center;background:$color;'><span style='color:#fff'>$isi->INT_ID_TICKET</span></td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;text-align:left;'>$isi->CHR_PROBLEM_DESC</span></td>";
                                        echo "<td>$isi->CHR_USERNAME</td>";
                                        // echo "<td class='td-no'>".date("d-M-Y", strtotime($isi->CHR_CREATE_DATE))."</td>";
                                        // echo "<td class='td-no'>".date("d-M-Y", strtotime($isi->CHR_DUE_DATE))."</td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->CHR_PROBLEM_TYPE - $isi->CHR_ASSET_NAME</td>";
                                        echo "<td class='td-no'>$isi->CHR_DEPT</td>";
                                        // echo "<td class='td-no'>$isi->CHR_PROVER_DESC</td>";

                                        
                                        
                                        ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/prepare_to_feedback_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/edit_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <?php
                                        if ($isi->INT_STATUS != '3') {
                                            ?>
                                        <?php } ?>
                                        <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/delete_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this helpdesk_ticket?');"><span class="fa fa-times"></span></a>
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
