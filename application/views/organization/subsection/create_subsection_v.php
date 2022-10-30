<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/organization/section_c/') ?>">Manage Section</a></li>
            <li><a href="#"><strong>Create Section</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('organization/subsection_c/save_subsection', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> SECTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Initial</label>
                            <div class="col-sm-5" >
                                <input name="CHR_SUB_SECTION" id="section" class="form-control" maxlength="7" required type="text" style="width: 100px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_SUB_SECTION_DESC" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_SECTION" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_section as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('organization/subsection_c', 'Cancel', 'class="btn btn-default"');
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

