<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/feedback_recovery_prod_c') ?>"><strong>Manage Problem & Corrective Act</strong></a></li>
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
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>PROBLEM & CORRECTIVE ACT.</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/display_prod/feedback_recovery_prod_c/create_feedback/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create Employee" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:20px;">
                                <tr>
                                    <td style="vertical-align:top" width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -7; $x <= 0; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('display_prod/feedback_recovery_prod_c/index/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Ym", strtotime("+$x month")); ?> 
                                                </option>
                                                    <?php } ?>

                                         </select>
                                    </td>
                                    <td>
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='text-align:center'>No</th>
                                    <th>Wo Number</th>
                                    <th>Problem</th>
                                    <th>Feedback</th>
                                    <th>Create By</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center'>$i</td>";
                                    echo "<td>$isi->CHR_WO_NUMBER</td>";
                                    echo "<td>$isi->CHR_PROBLEM</td>";
                                    echo "<td>$isi->CHR_CORRECTIVE_ACTION</td>";
                                    echo "<td>$isi->CHR_CREATED_BY</td>";
                                    echo "<td>".date('d-m-Y',strtotime($isi->CHR_CREATED_DATE)).' '.date('H:i',strtotime($isi->CHR_CREATED_TIME))."</td>";
                                    ?>
                               <td>
                                    <a href="<?php echo base_url('index.php/display_prod/feedback_recovery_prod_c/edit_feedback') . "/" . $isi->INT_ID ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/display_prod/feedback_recovery_prod_c/delete_feedback') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this feedback?');"><span class="fa fa-times"></span></a>
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