<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>DELAYED JOB</strong></span></a></li>
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
                        <span class="grid-title"><strong>DELAYED</strong> PROJECT ADMIN</span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Project Number</th>
                                    <th>Category Name</th>
                                    <th>Activity Name</th>
                                    <th>PIC</th>
                                    <th>FG Partname</th>
                                    <th>Model</th>
                                    <th>Dept</th>
                                    <th>Customer</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    echo "<td>$isi->CHR_CATEGORY_NAME</td>";
                                    echo "<td>$isi->CHR_ACTIVITY_NAME</td>";
                                    echo "<td>$isi->CHR_PIC_NAME</td>";
                                    echo "<td>$isi->CHR_FG_PARTNAME</td>";
                                    echo "<td>$isi->CHR_VEHICLE</td>";
                                    echo "<td>$isi->CHR_PIC_DEPT</td>";
                                    echo "<td>$isi->CHR_CUSTOMER</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . "</td>";
                                    ?>
                                <td>
                                    <?php
                                    if ($isi->CHR_DATE_START == 0) {
                                        ?>
                                        <a class="label label-danger" data-placement="left" data-toggle="tooltip" name="Ready to Start" title="Ready to Start"><span class="fa fa-play"></span></a>
                                        <?php
                                    } else {
                                        if ($isi->FLT_PROGRESS == NULL || $isi->FLT_PROGRESS == 0) {
                                            if ($isi->CHR_DUE_DATE < $datenow) {
                                                ?>
                                                <a class="label label-danger" data-placement="left" data-toggle="tooltip" name="Project Delayed" title="Project Delayed"><span class="fa fa-play"></span></a>
                                            <?php } else {
                                                ?>
                                                <a class="label label-danger" data-placement="left" data-toggle="tooltip"name="Project already started"  title="Project already started"><span class="fa fa-play"></span></a>
                                                <?php
                                            }
                                        } else {
                                            ?><a class="label label-danger" data-placement="left" data-toggle="tooltip" name="Project has feedback(s)" title="Project has feedback(s)"><span class="fa fa-play"></span></a>
                                                <?php
                                            }
                                        }
                                        ?>
    <!--<a href="<?php echo base_url('index.php/eci/schedule_c/feedback_eci') . "/" . $isi->CHR_ID_ECI . "/" . $isi->INT_REV . "/" . $isi->INT_ID_ACTIVITY; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Give Feedback"><span class="fa fa-eye"></span></a>
                                    -->

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


