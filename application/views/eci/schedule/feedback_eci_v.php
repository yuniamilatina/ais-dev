<script>
    $(document).ready(function () {
        var add_seq = 1;

        /*var myVar = setInterval(function() {
         $("#hide-sub-menus").click();
         clearInterval(myVar)
         }, 0.5);*/
        $('#add-more-file').click(function () {
            add_seq++;
            if (add_seq > 7) {
                alert("You have maximum file upload");
                add_seq--;
            } else {
                $("#jum_file").val(add_seq);
                var idName = "#file-name" + add_seq;
                $(idName).css("display", "true");
            }
        });

    });</script>

<script>
    function deleteThis(value) {
        document.getElementById("id_del_activity").value = value;
        document.getElementById("delete_activity").click();
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/eci/schedule_c/view_project'); ?>">My Job Project</a></li>
            <li> <a href="#"><strong>MY PROJECT ACTIVITY</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">DETAIL ACTIVITY</strong></span><span id="id-eci"></span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%">
                            <tr><td><strong>ECI No</strong></td><td><?php echo $get_eci_h->CHR_NAME . ' ( Rev-' . $get_eci_h->INT_REV . ' )'; ?></td></tr>
                            <tr><td><strong>Activity</strong></td><td><?php echo $get_eci_l->CHR_ACTIVITY_NAME; ?></td></tr>
                            <tr><td><strong>Category</strong></td><td><?php echo $get_eci_h->CHR_CATEGORY_NAME; ?></td></tr>
                            <tr><td><strong>Customer</strong></td><td><?php echo $get_eci_h->CHR_CUSTOMER; ?></td></tr>
                            <tr><td><strong>FG Part Name</strong></td><td><?php echo $get_eci_h->CHR_FG_PARTNAME; ?></td></tr>
                            <tr><td><strong>Start Date</strong></td><td><?php echo date("d-m-Y", strtotime($get_eci_l->CHR_START_DATE)); ?></td></tr>
                            <tr><td><strong>Due Date</strong></td><td><?php echo date("d-m-Y", strtotime($get_eci_l->CHR_DUE_DATE)); ?></td></tr>
                            <tr><td><strong>PIC Name</strong></td><td><?php echo $get_eci_l->CHR_PIC_NAME; ?></td></tr>
                            <tr><td><strong>PIC Mail</strong></td><td><?php echo $get_eci_l->CHR_PIC_MAIL; ?></td></tr>
                            <tr><td><strong>Superior</strong></td><td><?php echo $get_eci_l->CHR_PIC_SUPERIOR; ?></td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil-square"></i>
                        <span class="grid-title"><strong>ADD</strong> FEEDBACK</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php //echo form_open('eci/schedule_c/upload_data', 'class="form-horizontal"', 'enctype="multipart/form-data"', 'role="form"');   ?>
                        <form method="post" action="<?php echo site_url("eci/schedule_c/upload_data") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                            <div class=" form-group">
                                <label class="col-sm-3 control-label">Title *</label>
                                <div class="col-sm-5">
                                    <input name="jum_file" id="jum_file" value="1" autocomplete="off" id="title" class="form-control" style="width:250px;display:none;"  required type="text">
                                    <input name="id_eci" id="id_eci" value="<?php echo $get_eci_l->CHR_ID_ECI ?>" autocomplete="off" id="title" class="form-control" style="width:250px;display:none;"  required type="text">
                                    <input name="rev" id="rev" value="<?php echo $get_eci_l->INT_REV ?>" autocomplete="off" id="title" class="form-control" style="width:250px;display:none;"  required type="text">
                                    <input name="id_activity" value="<?php echo $get_eci_l->INT_ID_ACTIVITY ?>" value="1" autocomplete="off" id="title" class="form-control" style="width:250px;display:none;"  required type="text">
                                    <input name="title" autocomplete="off" id="title" class="form-control" style="width:250px;"  required type="text">
                                </div>
                            </div>
                            <div class=" form-group">
                                <label class="col-sm-3 control-label">Comment</label>
                                <div class="col-sm-5">
                                    <textarea rows="4" cols="40" name="comment" id="comment"></textarea>
                                </div>
                            </div>
                            <div class=" form-group" id="file-name1">
                                <label class="col-sm-3 control-label">File **</label>
                                <div class="col-sm-5">
                                    <input type="file" name="file1" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name2" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file2" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name3" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file3" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name4" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file4" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name5" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file5" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name6" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file6" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name6" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file7" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name7" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file8" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name8" style="display:none;">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <input type="file" name="file9" id="import" size="20"  value="">
                                </div>
                            </div>
                            <div class=" form-group" id="file-name10">
                                <label class="col-sm-3 control-label"></label>

                            </div>
                            <div class="form-group" id="btn-group-header">
                                <div class="col-sm-offset-4 col-sm-4">
                                    <div class="btn-group">
                                        <button id="add-feedback" value="1" name="add-feedback" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add Feedback"><i class="fa fa-check"></i> Add</button>
                                    </div>
                                </div>
                            </div>
                            <font style="color: red; font-weight: bold">* Required Field</font><br>
                            <font style="color: red; font-weight: bold">** You Must Upload a File</font>
                        </form>
                    </div>
                </div>
            </div>

            <?php if ($npk_activity === $npk_created) { ?>			
                <?php
            } else {
                if (count($get_feed_back) > 0) {
                    ?>

                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-pencil-square"></i>
                            <span class="grid-title"><strong>ACTIVITY </strong> FILE</span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <?php //echo form_open('eci/schedule_c/upload_data', 'class="form-horizontal"', 'enctype="multipart/form-data"', 'role="form"');     ?>
                            <form method="post" action="<?php echo site_url("eci/schedule_c/upload_data") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                                <div class=" form-group">
                                    <label class="col-sm-3 control-label">Title</label>
                                    <div class="col-sm-5">
                                        :  <?php echo $get_feed_back[0]->CHR_TITTLE ?>
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label class="col-sm-3 control-label">Comment</label>
                                    <div class="col-sm-5">
                                        : <?php echo $get_feed_back[0]->CHR_COMMENT ?>
                                    </div>
                                </div>
                                <?php
                                $a = 1;
                                foreach ($get_feed_back as $value_feed) {
                                    ?>
                                    <div class=" form-group" id="file-name1">
                                        <label class="col-sm-3 control-label">File $a</label>
                                        <div class="col-sm-5">
                                            <a href="<?php echo base_url('index.php/eci/schedule_c/download') . "/" . $value_feed->CHR_ID_ECI . "/" . $value_feed->INT_REV . "/" . $value_feed->INT_ID_ACTIVITY . "/" . $value_feed->INT_FEEDBACK; ?>">Download File</a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>

                </div>
            </div>

        </div>
        </div>


    </section>
</aside>



