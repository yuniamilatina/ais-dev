<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage Quality Problem</strong></a></li>
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
                        <i class="fa fa-table"></i>
                        <span class="grid-title"><strong>QUALITY PROBLEM TABLE</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/quality/quality_problem_c/create') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Report New Problem">New Problem</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="8%">Periode</td>
                                    <td width="22%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('quality/quality_feedback_c/index/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($date_selected == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%"></td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>TR No</th>
                                    <th>Problem</th>
                                    <th>Class Problem</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Inspector</th>
                                    <th>Section Inspector</th>
                                    <th>PIC (BP)</th>
                                    <th>Section (BP)</th>
                                    <th>Defective Date</th>
                                    <th>Defective Time</th>
                                    <th>Due Date</th>
                                    <th>Due Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $starttime = date("H:i", strtotime($isi->CHR_START_TIME));
                                    $duetime = date("H:i", strtotime($isi->CHR_DUE_TIME));
                                    
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_TR_NO</td>";
                                    echo "<td>$isi->CHR_QPROBLEM_TITLE</td>";
                                    echo "<td>$isi->CHR_CLASS_PROBLEM</td>";
                                    echo "<td>$isi->CHR_BACK_NO</td>";
                                    echo "<td>$isi->CHR_PART_NAME</td>";
                                    echo "<td>$isi->CHR_REQUESTOR</td>";
                                    echo "<td>$isi->CHR_SECTION_REQ</td>";
                                    echo "<td>$isi->CHR_PIC</td>";
                                    echo "<td>$isi->CHR_SECTION_PIC</td>";
                                    echo "<td>$isi->CHR_START_DATE</td>";
                                    echo "<td>$starttime</td>";
                                    echo "<td>$isi->CHR_DUE_DATE</td>";
                                    echo "<td>$duetime</td>";
                                    if ($isi->INT_STATUS == 0) {
                                        $status = 'No Follow Up';
                                        echo "<td style='background-color: #E34234; color: white;'>$status</td>";
                                    } else if ($isi->INT_STATUS == 1) {
                                        $status = 'On Progress';
                                        echo "<td style='background-color: #FFA812; color: white;'>$status</td>";
                                    } else if ($isi->INT_STATUS == 2) {
                                        $status = 'Complete';
                                        echo "<td style='background-color: #27DE55; color: white;'>$status</td>";
                                    } else {
                                        $status = 'Closed';
                                        echo "<td style='background-color: grey; color: white;'>$status</td>";
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/quality/quality_feedback_c/select_quality_problem_by_id') . "/" . trim($isi->INT_ID) ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-eye" ></span></a>
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
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>

                                        $(document).ready(function() {
                                            $('#example').DataTable({
                                                scrollX: true,
                                                fixedColumns: {
                                                    leftColumns: 4
                                                }
                                            });
                                        });
</script>