<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/portal/news_c/maintain_news') ?>">Manage News</a></li>
            <li><a href="#"><strong>View News</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        echo form_open('portal/news_c/update_news', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comments"></i>
                        <span class="grid-title"><strong>VIEW NEWS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label">News Title</label>
                            <div class="col-sm-5">
                                <input disabled class="form-control" maxlength="200" required type="text" value="<?php echo trim($data->INT_ID_NEWS); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">News Title</label>
                            <div class="col-sm-5">
                                <input disabled class="form-control" maxlength="200" required type="text" value="<?php echo trim($data->CHR_NEWS_TITLE); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description News</label>
                            <div class="col-sm-5">
                                <textarea disabled class="form-control" maxlength="200" required type="textarea" rows="4" cols="50"><?php echo trim($data->CHR_NEWS_DESC); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description News</label>
                            <div class="col-sm-5">
                            <img src="<?php echo base_url( $data->CHR_URL_IMAGE ) ?>" width="650"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
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

