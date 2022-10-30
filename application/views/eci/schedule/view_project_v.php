<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>MY JOB PROJECT </strong></span></a></li>
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
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title"><strong>MY JOB PROJECT</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Project Number</th>
                                    <th>Rev</th>
                                    <th>Category Name</th>
                                    <th>Activity Name</th>
                                    <th>FG Partname</th>
                                    <th>Model</th>
                                    <th>Customer</th>
                                    <th>Due Date</th>
                                    <th>File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    echo "<td>$isi->INT_REV</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_ACTIVITY_NAME</td>";
                                    echo "<td>$isi->CHR_FG_PARTNAME</td>";
                                    echo "<td>$isi->CHR_VEHICLE</td>";
                                    echo "<td>$isi->CHR_CUSTOMER</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . "</td>";
                                    ?>
                                <td>	
                                    <?php
                                    if ($isi->CHR_FLG_ATTTACH == NULL || $isi->CHR_FLG_ATTTACH == 0) {
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
                                    if ($isi->CHR_DATE_START == 0) {
                                        ?>
                                        <a href="<?php echo base_url('index.php/eci/schedule_c/start_activity') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_ID_ECI_LINE; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Start" onclick="return confirm('Are you sure want to start this activity?');"><span class="fa fa-play"></span></a>
                                        <?php
                                    } else {
                                        if ($isi->FLT_PROGRESS == NULL) {
                                            if ($isi->INT_FLG_REJECTED === 1) {
                                                ?>
                                                <a class="label gradeX bg-red" data-placement="left" data-toggle="tooltip" title="Project already rejected"><span class="fa fa-play"></span></a>
                                                <a href="<?php echo base_url('index.php/eci/schedule_c/feedback_eci_user') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV . "/" . $isi->INT_ID_ACTIVITY; ?>" class="label gradeX bg-red" data-placement="top" data-toggle="tooltip" title="Give Feedback"><span class="fa fa-comment"></span></a>
                                            <?php } else { ?>
                                                <a class="label gradeX bg-yellow" data-placement="left" data-toggle="tooltip" title="Project already started"><span class="fa fa-play"></span></a>
                                                <a href="<?php echo base_url('index.php/eci/schedule_c/feedback_eci_user') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV . "/" . $isi->INT_ID_ACTIVITY; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Give Feedback"><span class="fa fa-comment"></span></a>
                                                <?php
                                            }
                                        } else {
                                            if ($isi->INT_FLG_REJECTED === 1) {
                                                ?>
                                                <a class="label gradeX bg-blue" data-placement="left" data-toggle="tooltip" title="Project has feedback(s)"><span class="fa fa-play"></span></a>
                                            <?php } else {
                                                ?>
                                                <a class="label gradeX bg-green" data-placement="left" data-toggle="tooltip" title="Project has been approve"><span class="fa fa-thumbs-up"></span></a>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>


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


