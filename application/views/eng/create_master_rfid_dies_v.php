<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/eng/dies_c/') ?>">Master RFID Dies</a></li>
            <li> <a href="#"><strong>Create Master RFID Dies</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('eng/dies_c/save_master_rfid_dies', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE</strong> RFID DIES</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Number</label>
                            <div class="col-sm-3">
                                <input name="CHR_PART_NO" autocomplete="off" class="form-control" maxlength="20" required type="text"> 
                            </div>
                            <div class="col-sm-5">
                                * Part Number Kanban contoh = 32111350780BB 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Back Number</label>
                            <div class="col-sm-2">
                                <input name="CHR_BACK_NO" autocomplete="off" class="form-control" maxlength="4" required type="text">
                            </div>
                            <div class="col-sm-1">
                                <label class="col-sm-3 control-label">CB60</label> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Marking</label>
                            <div class="col-sm-2">
                                <input name="CHR_PART_MODEL" autocomplete="off" class="form-control" maxlength="4" required type="text">
                            </div>
                            <div class="col-sm-1">
                                <label class="col-sm-3 control-label">DC8</label> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dies</label>
                            <div class="col-sm-2">
                                    <select name="INT_ID_PART_DIES" class="form-control">
                                            <?php
                                            foreach ($dies as $row) {
                                                ?>
                                                    <option value="<?php echo trim($row->INT_ID); ?>" > <?php echo trim($row->CHR_DIES_CODE); ?> </option>
                                                    <?php
                                                }
                                            ?>
                                    </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">ID Part Dies</label>
                            <div class="col-sm-2">
                                <input name="INT_ID_PART_DIES" autocomplete="off" class="form-control" maxlength="4" required type="text">
                            </div>
                            <div class="col-sm-1">
                                <label class="col-sm-3 control-label">1</label> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dies Code</label>
                            <div class="col-sm-2">
                                <input name="CHR_DIES_CODE" autocomplete="off" class="form-control" maxlength="8" required type="text">
                            </div>
                            <div class="col-sm-1">
                                <label class="col-sm-3 control-label">DIES01</label> 
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">RFID Code</label>
                            <div class="col-sm-2">
                                <input name="CHR_RFID_CODE" autocomplete="off" class="form-control" maxlength="6" required type="text">
                            </div>
                            <div class="col-sm-1">
                                <label class="col-sm-3 control-label">2A2A83</label> 
                            </div>
                            
                        </div>
                           <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('eng/dies_c', 'Cancel', 'class="btn btn-default"'); 
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