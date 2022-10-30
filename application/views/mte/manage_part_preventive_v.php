<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        //var type = <?php echo $group_line; ?>;
        $("#btn_create").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/mte/preventive_schedule_c/show_create/<?php echo $group_line; ?>",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#2nd_panel").html(data);
                }
            });
        });
    });

    $(document).ready(function () {
        <?php 
            foreach ($data as $contain) { ?>
                $('#row_activity_<?php echo $contain->CHR_PART_CODE ?>').click(function () {
                    var part_code = <?php echo trim($contain->CHR_PART_CODE); ?>;
                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "<?php echo site_url('mte/preventive_schedule_c/get_update_data'); ?>",
                        data: "part_code=" + part_code,
                        success: function (data) {
                            $("#update_content").html(data);
                            $("#sub-title").html('EDIT PART PREVENTIVE');
                        }
                    });
                });
            <?php } ?>
    });
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Manage Project PIC</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <!-- <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong id='sub-title'>CREATE PART PREVENTIVE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
                        <?php echo form_open('mte/preventive_schedule_c/save', 'class="form-horizontal"'); ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Part Code <font style="color:red;">*</font></label>
                            <div class="col-sm-8">
                                <input name="CHR_PART_CODE" autofocus class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Part Name <font style="color:red;">*</font></label>
                            <div class="col-sm-8">
                                <input name="CHR_PART_NAME" class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Model <font style="color:red;">*</font></label>
                            <div class="col-sm-8">
                                <input name="CHR_MODEL" autofocus class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-push-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('mte/preventive_schedule_c', 'Reset', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <font style="color: red; font-weight: bold">* Required Field</font>
                    </div>
                </div>
            </div> -->
            <div class="col-md-7">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LIST PARTS PREVENTIVE - <?php echo $group_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <!-- <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/generate_template'); ?>" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download template</a> -->
                            <!-- <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/go_to_upload_wo/') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload WO" style="height:30px;font-size:12px;width:120px;color:white"><i class="fa fa-upload"></i>&nbsp;&nbsp;UPLOAD WO</a> -->
                            <button id="btn_create" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Add Part" style="height:30px;font-size:13px;width:100px;">Add Part</button>
                        </div>
                    </div>                    
                    <div class="grid-body">
                        <div class="pull">
                            <table width="5%" id='filter'>
                                <td>Filter</td>
                                <td style="vertical-align:top">
                                    <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                        <?php foreach ($all_group_line as $row) { ?>
                                            <option value="<?php echo site_url('mte/preventive_schedule_c/index/0/' . $row->ID); ?>" <?php
                                            if ($group_line == $row->ID) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                <?php } ?>
                                    </select>
                                </td>                                
                            </table>
                        </div>
                        <br>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Activity</th>                                    
                                    <th>Part Code</th>
                                    <th>Part Name</th>
                                    <th>Model</th>
                                    <?php if($group_line == 4 || $group_line == 7 || $group_line == 8){ ?>
                                        <th>Freq Prev</th>
                                    <?php } else { ?>
                                        <th>Std Stroke</th>
                                    <?php } ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                $i = 1;
                                $remain = 0;
                                $warning = "";
                                foreach ($data as $isi) { 
                                    echo "<tr id='row_activity_" . $isi->CHR_PART_CODE ."'>";
                                    echo "<td>" . $i . "</td>";
                                    $remain = $isi->INT_STROKE_BIG - $isi->INT_STROKE;

                                    //=== Old by IJA ===//
                                    // if ($isi->CHR_STATUS == 0) { ?> 
                                        <!-- <td>
                                            <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/update_flag_prev') . "/" . $isi->INT_ID; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Done">Done</span></a>
                                        </td> -->
                                    <?php //} else { ?>
                                        <!-- <td><a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Done">Done</span></a></td> -->
                                    <?php //}

                                    //=== New by ANU - 20200703 ===//
                                    if ($isi->CHR_STATUS == 1 || $isi->CHR_STATUS == 4) {
                                        $warning = "<span style='color:orange;' data-toggle='tooltip' title='Remain Stroke: " . $remain ."' class='fa fa-warning'></span>";
                                    } else if($isi->CHR_STATUS == 2 || $isi->CHR_STATUS == 5){
                                        $warning = "<span style='color:red;' data-toggle='tooltip' title='Remain Stroke: " . $remain ."' class='fa fa-warning'></span>";
                                    } else if($isi->CHR_STATUS == 3 || $isi->CHR_STATUS == 6){
                                        $warning = "<span style='color:purple;' data-toggle='tooltip' title='Remain Stroke: " . $remain ."' class='fa fa-warning'></span>";
                                    }


                                    if ($isi->CHR_STATUS == 0) { ?>                                         
                                        <td><a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Not yet">Done</span></a></td>                                                                          
                                    <?php } else { ?>
                                        <td>
                                            <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/update_flag_prev') . "/" . $isi->INT_ID; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Done"  onclick="return confirm('Are you really sure you have finished doing the preventive of this Part?');">Done</span></a>
                                            <?php echo $warning; ?>
                                        </td> 
                                    <?php }

                                    echo "<td>$isi->CHR_PART_CODE</td>";
                                    echo "<td style='text-align:left;'>" . substr($isi->CHR_PART_NAME,0,13) . "</td>";
                                    echo "<td>$isi->CHR_MODEL</td>";
                                    if($group_line == 4 || $group_line == 7 || $group_line == 8){
                                        echo "<td>" . $isi->FLG_TYPE_PREV . " Months</td>";
                                    } else {
                                        echo "<td>$isi->INT_STROKE_SMALL</td>";
                                    }
                                    
                                    ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/add_detail') . "/" . $isi->CHR_PART_CODE; ?>" class="label label-success" data-placement="right" data-toggle="tooltip" title="Add Detail"><span class="fa fa-list"></span></a>
                                        <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/delete') . "/" . $isi->CHR_PART_CODE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Part?');"><span class="fa fa-times"></span></a>
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
            <div id="2nd_panel" class="col-md-5">
                <?php
                if ($subcontent != NULL) {
                    $this->load->view($subcontent);
                }
                ?>
            </div> 
        </div>        
    </section>
</aside>