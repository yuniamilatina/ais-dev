<script language="JavaScript">
    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
//        $("#datepicker3").datepicker({dateFormat: 'dd-mm-yy'}).val();
//        $("#datepicker4").datepicker({dateFormat: 'dd-mm-yy'}).val();

//get pic by dept
        $("#pic_dept").change(function () {
            var dept = $(this).val();
            if (dept == "") {
                $("#select_pic").html('---CHOOSE PIC---');
            } else {
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/schedule_c/get_pic_by_dept'); ?>",
                    data: "dept=" + dept,
                    success: function (data) {
                        $("#select_pic").html(data);
                    }
                });
            }
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li> <a href="#"><strong>Update Activity Project</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>EDIT ACTIVITY PROJECT</strong> </span>
                    </div>


                    <div class="grid-body">
                        <div class="row" style="margin-bottom:10px;">
                            <?php echo form_open('eci/schedule_c/edit_activity', 'class="form-horizontal"'); ?>
                            <div class=" form-group">
                                <label class="col-sm-2 control-label">Project / ECI Number</label>
                                <div class="col-sm-3">
                                    <input name="INT_ID_ECI" class="form-control" required disabled="disabled" value="<?php echo $eci_now; ?>">
                                </div>
                                <div class="col-sm-4">
                                    <input name="CHR_ID_ECIs" class="form-control" required type="hidden" value="<?php echo $idecis; ?>">
                                </div>
                                <div class="col-sm-4">
                                    <input name="INT_ID_ECI_LINEs" class="form-control" required type="hidden" value="<?php echo $eci_line; ?>">
                                </div>
                            </div>
                            <div class=" form-group">
                                <label class="col-sm-2 control-label">Activity</label>
                                <div class="col-sm-4">
                                    <select  name="activity" id="e1" required class="form-control" style="width:250px">
                                        <?php
                                        foreach ($data_activity as $activity_list) {
                                            if (trim($activity_list->INT_ID_ACTIVITY) == $id_act) {
                                                ?>
                                                <option selected value="<?php echo $id_act; ?>"><?php echo $activity_list->CHR_ACTIVITY_NAME; ?></option>
                                            <?php } else { ?>  
                                                <option value="<?php echo $activity_list->INT_ID_ACTIVITY; ?>"><?php echo $activity_list->CHR_ACTIVITY_NAME; ?></option>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </select> 
                                </div>
                                <label class="col-sm-2 control-label">DEPT PIC</label>
                                <div class="col-sm-4">
                                    <select  name="pic_dept" id="pic_dept" required class="form-control" style="width:160px">
                                        <?php
                                        foreach ($data_pic_dept as $pic_dept_list) {
                                            if (trim($pic_dept_list->CHR_DEPT) == trim($dept)) {
                                                ?>
                                                <option selected value="<?php echo $dept; ?>"><?php echo $dept; ?></option>
                                            <?php } else { ?>   
                                                <option value="<?php echo $pic_dept_list->CHR_DEPT; ?>"><?php echo trim($pic_dept_list->CHR_DEPT); ?></option>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </select> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sequence</label>
                                <div class="col-sm-4">
                                    <input name="txtsequence" id="txtsequence" class="form-control" required type="number" style="width: 90px;text-transform: uppercase;" value="<?php echo $int_seq; ?>" >
                                </div>
                                <label class="col-sm-2 control-label">PIC</label>
                                <div class="col-sm-4">
                                    <select  name="pic" id="select_pic" required style="height:35px;width:250px">
                                        <?php
                                        foreach ($data_pic as $pic_list) {
                                            if ($pic_list->INT_ID_PIC == $id_pic) {
                                                ?>
                                                <option selected value="<?php echo $id_pic; ?>"><?php echo $pic_list->CHR_NAME; ?></option>
                                            <?php } else { ?>   
                                                <option value="<?php echo $pic_list->INT_ID_PIC; ?>"><?php echo trim($pic_list->CHR_NAME); ?></option>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </select> 
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Start Date</label>
                                <div class="col-sm-4">
                                    <input name="start_date" id="datepicker1" class="form-control" required type="text" style="width: 200px;text-transform: uppercase;" value="<?php echo $startdate_current; ?>" >
                                </div>
                                <label class="col-sm-2 control-label">Due Date</label>
                                <div class="col-sm-4">
                                    <input name="due_date" id="datepicker2" class="form-control" required type="text" style="width: 200px;text-transform: uppercase;" value="<?php echo $duedate_current; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-push-2">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Edit this data">Update</button>
                                        <?php echo form_close(); ?>
                                        <?php echo anchor('eci/schedule_c/activity_project/0/NULL', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>	