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
            <li><a href="<?php echo base_url('index.php/company_profile/cp_news_c/') ?>">Manage news</a></li>
            <li><a href="#"><strong>Edit News</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open_multipart('company_profile/cp_news_c/update_news', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> NEWS</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input type="hidden" name="INT_ID_NEWS" class="form-control" value="<?php echo $data->INT_ID_NEWS; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">News Title</label>
                            <div class="col-sm-5">
                                <input name="CHR_NEWS_TITLE" class="form-control" value="<?php echo $data->CHR_NEWS_TITLE; ?>" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">News Detail</label>
                            <div class="col-sm-8">
                                <textarea id="editor1" name="CHR_NEWS_DETAIL" class="form-control" required type="textarea" rows="10" cols="50"><?php echo $data->CHR_NEWS_DETAIL; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">News Photo</label>
                            <div class="col-sm-5">
                                <img id="uploadPreview1" src="<?php echo DOCIMG."/image/cp_news/".$data->CHR_NEWS_PHOTO; ?>" class="form-control" style="width: 150px; height: 150px; border: 5px solid #a1a1a1;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <input name="uploadFoto" id="uploadImage1" onchange="PreviewImage(1);" accept="image/*" type="file">
                            </div>
                        </div>
                        <input type="hidden" name="CHR_NEWS_PHOTO_OLD" class="form-control" value="<?php echo $data->CHR_NEWS_PHOTO; ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php echo anchor('company_profile/cp_news_c', 'Cancel', 'class="btn btn-default"');
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
		 <script src="https://adminlte.io/themes/AdminLTE/bower_components/ckeditor/ckeditor.js"></script>
        <script>
          $(function () {
            CKEDITOR.replace( 'editor1', {
                toolbar: [
                    { name: 'document', items: [  '-', 'NewPage', 'Preview', '-', 'Templates' ] }, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                    [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],          // Defines toolbar group without name.
                    '/',                                                                                    // Line break - next group will be placed in new line.
                    { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
                ]
            });
            
          })
        </script>
    </section>
</aside>

