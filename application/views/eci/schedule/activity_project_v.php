<script>
    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        var id_eci = $('#project_n').val();
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('eci/schedule_c/update_table_1'); ?>",
            data: "id_eci=" + id_eci,
            success: function (data) {
                $("#update_content").html(data);
            }
        });

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
//        $("#datepicker3").datepicker({dateFormat: 'dd-mm-yy'}).val();
//        $("#datepicker4").datepicker({dateFormat: 'dd-mm-yy'}).val();

        $("#btnsave").click(function () {
            var id_eci = $('#project_n').val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_1'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $("#btnsaverev").click(function () {
            var id_eci = $('#project_n').val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_2'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $('#myTab a').click(function (e) {
            var id_eci = $('#project_n').val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_2'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $("#project_n_1").change(function () {
            var id_eci = $(this).val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_2'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $("#project_n").change(function () {
            var id_eci = $(this).val();
            if (id_eci == "") {
                $('#eci-message').html('Pilih nomer ECI terlebih dahulu');
            } else {
                $('#eci-message').html('');
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/schedule_c/update_table_1'); ?>",
                    data: "id_eci=" + id_eci,
                    success: function (data) {
                        $("#update_content").html(data);
                    }
                });
            }
        });

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

        $("#username").change(function () {
            var username = $(this).val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/get_data_by_username'); ?>",
                data: "username=" + username,
                success: function (data) {
                    $("#select_pic").html(data);
                    $("#select_pic").html(data);
                    $("#select_pic").html(data);
                    $("#select_pic").html(data);
                    $("#select_pic").html(data);
                }
            });
        });

        $("#project_n").click(function () {
            var id_eci = $(this).val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_1'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $("#project_n_1").click(function () {
            var id_eci = $(this).val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_2'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $("#project_n_1").click(function () {
            var id_eci = $(this).val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/update_table_2'); ?>",
                data: "id_eci=" + id_eci,
                success: function (data) {
                    $("#update_content").html(data);
                }
            });
        });

        $("#btnpublish").click(function () {
            var eci = $('#project_n').val();
            if (eci === "") {
                $('#eci-message').html('Pilih nomer ECI terlebih dahulu');
            } else {
                $('#eci-message').html('');
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/schedule_c/publish_activity'); ?>",
                    data: "id_eci=" + eci,
                    success: function (data) {
                        window.location.href = "<?php echo site_url('eci/schedule_c/activity_project/4/NULL'); ?>";
                    }
                });
            }
        });

        //click button revise
//        $("#btnrevise").click(function () {
//            var eci = $('#project_n_1').val();
//            if (eci === '') {
//                alert('Select ECI Number First');
//            } else {
//                $.ajax({
//                    async: false,
//                    type: "POST",
//                    url: "<?php echo site_url('eci/schedule_c/revise_activity'); ?>",
//                    data: "id_eci=" + eci,
//                    success: function (data) {
//                        location.reload();
//                    }
//                });
//            }
//        });
    });
</script>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li> <a href="#"><span><strong>Activity Project</strong></span></a></li>
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
                        <i class="fa fa-suitcase"></i>
                        <span class="grid-title"><strong>ACTIVITY PROJECT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a data-toggle="tab" href="#add">Add</a></li>
                            <li><a data-toggle="tab" href="#revise">Revise</a></li>
                        </ul>
                        <div class="tab-content" style="font-size:12px;">
                            <!--==================TAB ADD=====================-->	
                            <div name="tabadd" id="add" class="tab-pane fade in active">
                                <div class="row" style="margin-bottom:5px;margin-top: 15px;">
                                    <?php echo form_open('eci/schedule_c/save_activity', 'class="form-horizontal"'); ?>
                                    <div class=" form-group" name="test">
                                        <label class="col-sm-2 control-label">Project / ECI Number *</label>
                                        <div class="col-sm-4">
                                            <select name="project_n" id="project_n" class="form-control" required style="width:200px">
                                                <option value="">---CHOOSE ECI NUMBER---</option>
                                                <?php
                                                foreach ($data_eci as $project_list) {
                                                    if ($project_list->CHR_FLG_PUBLISH === "0") {
                                                        if (trim($project_list->CHR_ID_ECI) === trim($eci_id)) {
                                                            ?><option selected value="<?php echo $project_list->CHR_ID_ECI; ?>"><?php echo $project_list->CHR_NAME; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $project_list->CHR_ID_ECI; ?>"><?php echo $project_list->CHR_NAME; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select><span style='font-size:12px;color:crimson;' id='eci-message'></span>
                                        </div>
                                    </div>
                                    <div class=" form-group">
                                        <label class="col-sm-2 control-label">Activity *</label>
                                        <div class="col-sm-4">
                                            <select  name="activity" id="e1" class="form-control" required style="width:250px">
                                                <option value="">---CHOOSE ACTIVITY---</option>
                                                <?php
                                                foreach ($data_activity as $activity_list) {
                                                    ?>
                                                    <option style="text-transform: uppercase;" value="<?php echo $activity_list->INT_ID_ACTIVITY; ?>"><?php echo $activity_list->CHR_ACTIVITY_NAME; ?></option>
                                                    <?php
                                                }
                                                ?> 
                                            </select> &nbsp;&nbsp; <button class="btn btn-danger" data-toggle="modal" data-target="#modalDefault" data-placement="left" data-toggle="tooltip" title="Add Activity"><span class="fa fa-plus"></span></button>
                                        </div>

                                        <label class="col-sm-2 control-label">DEPT PIC *</label>
                                        <div class="col-sm-4">
                                            <select  name="pic_dept" id="pic_dept" required class="form-control" style="width:150px">
                                                <option value="">---CHOOSE DEPT---</option>
                                                <?php foreach ($data_pic_dept as $pic_dept_list) { ?>
                                                    <option value="<?php echo $pic_dept_list->CHR_DEPT; ?>"><?php echo trim($pic_dept_list->CHR_DEPT); ?></option>
                                                <?php }
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Sequence *</label>
                                        <div class="col-sm-4">
                                            <input name="txtsequence" id="txtsequence" class="form-control" required type="number" style="width: 90px;text-transform: uppercase;" >
                                        </div>
                                        <label class="col-sm-2 control-label">PIC *</label>
                                        <div class="col-sm-4">
                                            <select name="pic" id="select_pic" required style="height:35px;width:200px;">
                                                <option value=""> &nbsp;&nbsp;&nbsp;&nbsp;---CHOOSE PIC---</option>
                                            </select> &nbsp;&nbsp; <button class="btn btn-danger" data-toggle="modal" data-target="#modalPic" data-placement="left" data-toggle="tooltip" title="Add PIC"><span class="fa fa-plus"></span></button>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Start Date *</label>
                                        <div class="col-sm-4">
                                            <input name="start_date" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width: 200px;text-transform: uppercase;" >
                                        </div>
                                        <label class="col-sm-2 control-label">Due Date *</label>
                                        <div class="col-sm-4">
                                            <input name="due_date" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width: 200px;text-transform: uppercase;" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-push-2">
                                            <div class="btn-group">
                                                <button type="submit" id='btn-add' class="btn btn-primary" data-placement="left" ><span class="fa fa-plus"></span>&nbsp;&nbsp;Add</button>
                                                <button type="reset" class="btn btn-default">Reset</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 col-sm-push-2">
                                            <div class="btn-group">
                                                <button type="button" style="width:120px;" id="btnpublish" class="btn btn-success"><span class="fa fa-send"></span>&nbsp;&nbsp;Publish</button>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label">
                                        <font style="color: red; font-weight: bold">* Required Field</font>
                                    </label>
                                </div>
                            </div>

                            <!--MODAL ACTIVITY-->
                            <div class="modal fade" id="modalDefault" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel1"><strong>Add Activity</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo form_open('eci/activity_c/save_activity_popup', 'class="form-horizontal"'); ?>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">ACTIVITY NAME *</label>
                                                    <div class="col-sm-8">
                                                        <input name="activity_name" id="activity_name" autofocus class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;float:left;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button id="btn-ok" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                                    <?php
                                                    echo form_close();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--MODAL PIC-->
                            <div class="modal fade" id="modalPic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                                <div class="modal-wrapper">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel1"><strong>Add PIC</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo form_open('eci/pic_c/save_pic_popup', 'class="form-horizontal"'); ?>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Nama *</label>
                                                    <div class="col-sm-8">
                                                        <select  name="CHR_NPK" id="e2" class="form-control" required style="width:300px">
                                                            <option value="">--- CHOOSE NPK/NAME/DEPT ---</option>
                                                            <?php foreach ($data_user as $list) { ?>
                                                                <option value="<?php echo $list->CHR_NPK; ?>"><?php echo $list->CHR_NPK.' - '.trim($list->CHR_USERNAME).' [ '.$list->CHR_DEPT.' ] '; ?></option>
                                                            <?php }
                                                            ?> 
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button id="btn-ok" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                                    <?php
                                                    echo form_close();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--==================TAB REVISE=====================-->	
                            <div name="tabrev" id="revise" class="tab-pane fade">
                                <div class="row" style="margin-bottom:5px;margin-top: 15px;">
                                    <?php // echo form_open('eci/schedule_c/save_revise_activity', 'class="form-horizontal"'); ?>
                                    <?php echo form_open('eci/schedule_c/revise_activity', 'class="form-horizontal"'); ?>
                                    <div class=" form-group">
                                        <label class="col-sm-2 control-label">Project / ECI Number *</label>
                                        <div class="col-sm-4">
                                            <select name="project_n_1" id="project_n_1" required class="form-control" style="width:250px">
                                                <option value="">---CHOOSE ECI NUMBER---</option>
                                                <?php
                                                foreach ($data_eci as $project_list) {
                                                    if ($project_list->CHR_FLG_PUBLISH === "1") {
                                                        ?>
                                                        <option value="<?php echo $project_list->CHR_ID_ECI; ?>"><?php echo $project_list->CHR_NAME; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--                                    <div class=" form-group">
                                                                            <label class="col-sm-2 control-label">Activity *</label>
                                                                            <div class="col-sm-4">
                                                                                <select  name="activity" id="activity" required class="form-control" style="width:250px">
                                                                                    <option value="">---CHOOSE ACTIVITY---</option>
                                   
                                                                                </select>
                                                                            </div>-->
                                    <!--                                        <label class="col-sm-2 control-label">PIC *</label>
                                                                            <div class="col-sm-4">
                                                                                <select  name="pic" id="pic" required class="form-control" style="width:250px">
                                                                                    <option value="">---CHOOSE PIC---</option>
                                    
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Sequence *</label>
                                                                            <div class="col-sm-4">
                                                                                <input name="txtsequence" id="txtsequence" class="form-control" required type="text" style="width: 90px;text-transform: uppercase;" >
                                                                            </div>
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Start Date *</label>
                                                                            <div class="col-sm-4">
                                                                                <input enabled onkeydown="return false" name="start_date" id="datepicker3" class="form-control" autocomplete="off" required type="text" style="width: 250px;text-transform: uppercase;" >
                                                                            </div>
                                                                            <label class="col-sm-2 control-label">Due Date *</label>
                                                                            <div class="col-sm-4">
                                                                                <input enabled onkeydown="return false" name="due_date" id="datepicker4" class="form-control" autocomplete="off" required type="text" style="width: 250px;text-transform: uppercase;" >
                                                                            </div>
                                                                        </div>-->
                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-push-2">
                                            <div class="btn-group">
                                                <button type="submit" id="btnrevise" class="btn btn-warning"><span class="fa fa-gavel"></span>&nbsp;&nbsp;Revise</button>
                                                <!--<button id="btnsaverev" type="submit" class="btn btn-primary" data-placement="left" name="btnsave" data-toggle="tooltip" title="Save this data">Save</button>-->
                                                <?php echo form_close(); ?>
                                                <?php // echo anchor('eci/schedule_c/activity_project/0/NULL', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <label class="col-sm-2 control-label">
                                                                            <font style="color: red; font-weight: bold">* Required Field</font>
                                                                        </label>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--==================TABLE DIBAWAH=====================-->			
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-tasks"></i>
                        <span class="grid-title"><strong>PROJECT ACTIVITY LIST</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" id="update_content">
                        <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Seq</th>
                                    <th>Activity</th>
                                    <th>PIC</th>
                                    <th>Department</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;

                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$isi->INT_SEQ</td>";
                                    echo "<td>$isi->CHR_ACTIVITY_NAME</td>";
                                    echo "<td>$isi->CHR_PIC_NAME</td>";
                                    echo "<td>$isi->CHR_PIC_DEPT</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . "</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/eci/schedule_c/delete_activity') . "/" . trim($isi->CHR_ID_ECI) . "/" . trim($isi->INT_ID_ECI_LINE); ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this activity?');"><span class="fa fa-times"></span></a>
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