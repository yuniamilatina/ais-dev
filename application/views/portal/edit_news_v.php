<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/portal/news_c/maintain_news') ?>">Manage News</a></li>
            <li><a href="#"><strong>Edit News</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('portal/news_c/update_news', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comments"></i>
                        <span class="grid-title"><strong>EDIT NEWS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label">News Title</label>
                            <div class="col-sm-5">
                                <input name="INT_ID_NEWS" class="form-control" maxlength="200" required type="text" value="<?php echo trim($data->INT_ID_NEWS); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">News Title</label>
                            <div class="col-sm-5">
                                <input name="CHR_NEWS_TITLE" class="form-control" maxlength="200" required type="text" value="<?php echo trim($data->CHR_NEWS_TITLE); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description News</label>
                            <div class="col-sm-5">
                                <textarea name="CHR_NEWS_DESC" class="form-control" maxlength="200" required type="textarea" rows="4" cols="50"><?php echo trim($data->CHR_NEWS_DESC); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Image</label>
                            <div class="col-sm-4">
                                <input name="CHR_URL_IMAGE" id="upload" type="file" required> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('portal/news_c/maintain_news', 'Cancel', 'class="btn btn-default"');
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

<script type="text/javascript" language="javascript">
            $("#upload").fileinput({
                'showUpload': false
            });
</script>
