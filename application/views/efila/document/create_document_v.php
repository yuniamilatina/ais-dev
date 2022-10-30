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
            <li><a href="<?php echo base_url('index.php/efila/document_c/') ?>">Manage Document</a></li>
            <li><a href="#"><strong>Create Document</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open_multipart('efila/document_c/save_document', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE</strong> DOCUMENT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_DOCUMENT_NAME" class="form-control" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Description</label>
                            <div class="col-sm-5">
                                <textarea name="CHR_DOCUMENT_DESC" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Category</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_CATEGORY" class="form-control" required>
                                    <?php foreach ($cat as $row) { ?>
                                        <option value = '<?php echo $row->INT_ID_CATEGORY; ?>'><?php echo $row->CHR_CATEGORY_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document</label>
                            <div class="col-sm-5">
                                <input name="uploadFile" id="uploadImage" type="file" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('efila/document_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" language="javascript">
            $("#uploadImage").fileinput({
                'showUpload': false
            });
        </script>
    </section>
</aside>

