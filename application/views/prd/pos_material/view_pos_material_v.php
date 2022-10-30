

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/pos_material_c') ?>">MANAGE POS MATERIAL</a></li>
            <li> <a href="#"><strong>VIEW POS MATERIAL</strong></a></li>
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
                        <i class="fa  fa-puzzle-piece"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">VIEW POS MATERIAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php
                        echo form_open('', 'class="form-horizontal"');
                        ?>
                    <div class="grid-body">
                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_WORK_CENTER"  class="form-control" readonly value="<?php echo trim($work_center) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pos</label>
                            <div class="col-sm-2" >
                                <input type="text" name="CHR_PART_NO"  class="form-control" readonly value="<?php echo $data->CHR_POS_PRD ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No</label>
                            <div class="col-sm-3" >
                                <input type="text" name="CHR_PART_NO_FG"  class="form-control" readonly value="<?php echo trim($part_no) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No Material</label>
                            <div class="col-sm-3" >
                                <input type="text" name="CHR_PART_NO_COMP"  class="form-control" readonly value="<?php echo str_replace("#",", ",$data->CHR_PART_NO_COMPONEN); ?>">
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-sm-3 control-label">Back No Material</label>
                            <div class="col-sm-4" >
                                <input type="text" name="CHR_BACK_NO_COMP"  class="form-control" readonly value="<?php echo str_replace("#",", ",$data->CHR_BACK_NO_COMPONEN); ?>">
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-sm-3 control-label">Image</label>
                            <div class="col-sm-6" >
                                <input type="image" src='<?php echo base_url($data->CHR_IMAGE_PIS_URL); ?>' style="width:100%;" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <?php
                                    echo anchor('prd/pos_material_c/index/'.$work_center, 'Cancel', 'class="btn btn-default"');
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
