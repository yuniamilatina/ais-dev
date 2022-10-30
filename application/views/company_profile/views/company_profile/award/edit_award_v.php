<script type="text/javascript">
    function PreviewImage(no) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview"+no).src = oFREvent.target.result;
            document.getElementById("uploadPreview"+no).height = 100;
            document.getElementById("uploadPreview"+no).width = 100;
        };
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/company_profile/award_c/') ?>">Manage Award</a></li>
            <li><a href="#"><strong>Edit Award</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open_multipart('company_profile/award_c/update_award', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> AWARD</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input type="hidden" name="INT_ID_AWARD" class="form-control" value="<?php echo $data->INT_ID_AWARD; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Award Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_AWARD_NAME" class="form-control" value="<?php echo $data->CHR_AWARD_NAME; ?>" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Award Name</label>
                            <div class="col-sm-5">
                                <?php
                                    $tgl = $data->CHR_AWARD_DATE; 
                                    $date = date("Y-m-d", strtotime($tgl));
                                ?>
                                <input name="CHR_AWARD_DATE" class="form-control" value="<?php echo $date; ?>" required type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Award Description</label>
                            <div class="col-sm-5">
                                <textarea name="CHR_AWARD_DESC" class="form-control" required><?php echo $data->CHR_AWARD_DESC; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Award Photo</label>
                            <div class="col-sm-5">
                                <img id="uploadPreview1" src="<?php echo base_url()."assets/img/Award/".$data->CHR_AWARD_PHOTO; ?>" class="form-control" style="width: 150px; height: 150px; border: 5px solid #a1a1a1;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <input name="uploadFoto" id="uploadImage1" onchange="PreviewImage(1);" type="file">
                            </div>
                        </div>
                        <input type="hidden" name="CHR_AWARD_PHOTO_OLD" class="form-control" value="<?php echo $data->CHR_AWARD_PHOTO; ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php echo anchor('company_profile/award_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>

