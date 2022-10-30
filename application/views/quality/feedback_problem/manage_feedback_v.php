<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Manage Feedback Quality Problem</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        $session = $this->session->all_userdata();
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
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right">                            
                            <a href="<?php echo base_url('index.php/quality/quality_problem_c/create') ?>"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Report New Problem">Create New TR</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="8%">Periode</td>
                                    <td width="16%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -15; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('quality/quality_feedback_c/index/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($date_selected == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="36%">
                                        <?php //if($session['ROLE'] == 1){ ?>
                                        <a href="<?php echo base_url('index.php/quality/quality_problem_c/export_list_tr/' . $date_selected) ?>" style="height:32px;"  class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Export to Excel">Export TR</a>
                                        <?php //}?>
                                    </td>
                                    <td width="40%"><marquee>Maksimal feedback <strong>TEMPORARY ACTION</strong> adalah <strong>4 Jam</strong>, jika lebih maka akan berstatus <strong>NO FOLLOW UP</strong> dan berwarna <strong>MERAH</strong></marquee></td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div style=" font-size: 11px;">
                        <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Problem</th>                                    
                                    <th>Back No</th>
                                    <th>Class Problem</th>
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
                                    
                                    if($isi->INT_ID_CHILD > 0){
                                        echo "<tr class='gradeX'>";
                                        echo "<td align='right' style='background-color: wheat;'>$i</td>";
                                    } else {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                    }                                    
                                    echo "<td>$isi->CHR_QPROBLEM_TITLE</td>";                                    
                                    echo "<td>$isi->CHR_BACK_NO</td>";
                                    echo "<td>$isi->CHR_CLASS_PROBLEM</td>";
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
                                        if(date('Ymd') > $isi->CHR_DUE_DATE){
                                            echo "<td style='background-color: #E34234; color: white;'>$status</td>";
                                        } else {
                                            if(date('His') > $isi->CHR_DUE_TIME){
                                                echo "<td style='background-color: #E34234; color: white;'>$status</td>";
                                            } else {
                                                echo "<td style='background-color: #FFA812; color: white;'>$status</td>";
                                            }
                                        }
                                    } else if ($isi->INT_STATUS == 1) {
                                        $status = 'On Progress';
                                        echo "<td style='background-color: #FFA812; color: white;'>$status</td>";
                                    } else if (($isi->INT_STATUS == 2)) {
                                        $status = 'Complete';
                                        echo "<td style='background-color: #27DE55; color: white;'>$status</td>";
                                    } else {
                                        $status = 'Closed';
                                        echo "<td style='background-color: grey; color: white;'>$status</td>";
                                    }
                                    
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/quality/quality_feedback_c/select_quality_problem_by_id') . "/" . trim($isi->INT_ID) ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-search" ></span></a>
                                    
                                    <?php
                                    if($session['NPK'] == $isi->CHR_CREATED_BY){                                                                          
                                    ?>
                                        <a href="<?php echo base_url('index.php/quality/quality_problem_c/delete_quality_problem') . "/" . trim($isi->INT_ID) . "/" . $date_selected ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this TR?');"><span class="fa fa-times" ></span></a>
                                    <?php
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
                                                    leftColumns: 3
                                                }
                                            });
                                        });
</script>