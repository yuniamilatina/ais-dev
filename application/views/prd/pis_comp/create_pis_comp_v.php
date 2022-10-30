<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/prd/pis_comp_c/') ?>">PIS COMPONENT</a></li>
            <li> <a href="#"><strong>CREATE PIS COMPONENT</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE PIS COMPONENT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('prd/pis_comp_c/save_pis_comp', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group">
                            <label class="col-sm-3 control-label">Back Number</label>
                            <div class="col-sm-2">
                                <select  name="CHR_BACK_NO" id="e1" class="form-control" style="width:250px">
                                    <?php foreach ($kanban_data as $list) { ?>
                                        <option value="<?php echo $list->CHR_BACK_NO; ?>"><?php echo trim($list->CHR_BACK_NO).' '.trim($list->CHR_PART_NO); ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Image </label>
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
