<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">HOME</a></li>
            <li><a href="<?php echo base_url('index.php/prd/pis_comp_c/') ?>">PIS COMPONENT</a></li>
            <li> <a href="#"><strong>UPDATE PIS COMPONENT</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
            echo form_open_multipart('prd/pis_comp_c/update_pis_comp', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">UPDATE PIS COMPONENT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <input name="INT_KANBAN_NO" class="form-control" type="hidden" value="<?php echo $data->INT_KANBAN_NO; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Back Number</label>
                            <div class="col-sm-4">
                                <input name="CHR_BACK_NO" id="back_no" class="form-control" maxlength="50" required type="text" value="<?php echo $data->CHR_BACK_NO; ?>" readonly >
                            </div>
                        </div>                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Image</label>
                            <div class="col-sm-4">                        
                                <input name="CHR_IMAGE_PIS_URL" id="upload" type="file" required> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('prd/pis_comp_c/', 'Cancel', 'class="btn btn-default"');
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
