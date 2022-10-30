<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/message_display_prod_c') ?>"><strong>Manage Message Display</strong></a></li>
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
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>MESSAGE DISPLAY</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/display_prod/message_display_prod_c/create_message/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Employee" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Wo number</th>
                                    <th>Message</th>
                                    <th>Time Target</th>
                                    <th>Creator</th>
                                    <th>Created Date</th>
                                    <th>Created Time</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_WO_NUMBER</td>";
                                    echo "<td>$isi->CHR_MESSAGE</td>";
                                    echo "<td>$isi->CHR_TARGET_SOLVE</td>";
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    echo "<td>".date('d-m-Y',strtotime($isi->CHR_CREATED_DATE))."</td>";
                                    echo "<td>".date('H:i:s',strtotime($isi->CHR_CREATED_TIME))."</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/display_prod/message_display_prod_c/edit_message') . "/" . $isi->INT_ID ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/display_prod/message_display_prod_c/delete_message') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this message?');"><span class="fa fa-times"></span></a>
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

    </section>
</aside>