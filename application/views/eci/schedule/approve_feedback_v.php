<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>APPROVE FEEDBACK</strong></span></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LIST</strong> FEEDBACK</span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ECI No</th>
                                    <th>Activity</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    echo "<td>$isi->CHR_ACTIVITY_NAME</td>";
                                    echo "<td>$isi->CHR_PIC_NAME</td>";
                                    echo "<td>$isi->CHR_TITTLE</td>";
                                    echo "<td>$isi->CHR_COMMENT</td>";
                                    ?>
                                <td>	
                                    <?php
                                    if ($isi->CHR_FILENAME == "_") {
                                        echo "No file uploaded";
                                    } else {
                                        ?>
                                        <a href="<?php echo base_url("index.php/eci/schedule_c/download/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV . "/" . $isi->INT_ID_ACTIVITY . "/" . $isi->INT_FEEDBACK, "Download"); ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Download file" onclick="Download will start"><span class="fa fa-download"></span></a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($isi->CHR_APPROVE_BY_ADMIN == 1) {
                                        ?>
                                        <a class="label label-info" data-placement="right" data-toggle="tooltip" title="Approved"><span class="fa fa-thumbs-up"></span></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo base_url('index.php/eci/schedule_c/approval_feedback') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_ID_ACTIVITY . "/" . $isi->CHR_USR_ENTRY . "/" . $isi->INT_FEEDBACK; ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Approve this feedback" onclick="return confirm('Are you sure want to approve this feedback?');"><span class="fa fa-thumbs-up"></span></a>
                                        <a href="<?php echo base_url('index.php/eci/schedule_c/reject_feedback') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_ID_ACTIVITY . "/" . $isi->CHR_USR_ENTRY . "/" . $isi->INT_FEEDBACK; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Reject this feedback" onclick="return confirm('Are you sure want to reject this feedback?');"><span class="fa fa-thumbs-down"></span></a>
                                            <?php
                                        }
                                    }
                                    ?>
                            </td>
                            </tr>
                            <?php
                            $i++;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>


