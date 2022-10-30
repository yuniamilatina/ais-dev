<aside class="right-side">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
                <li><a href="<?php echo base_url('index.php/organization/subsection_c/') ?>">Manage Section</a></li>
                <li><a href="#"><strong>Edit Section</strong></a></li>
            </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('organization/subsection_c/update_subsection', 'class="form-horizontal"');
        ?> 

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> SUB_SECTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <input name="INT_ID_SUB_SECTION" class="form-control" type="hidden" value="<?php echo $data->INT_ID_SUB_SECTION; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_SUB_SECTION" class="form-control" maxlength="7" required type="text" value="<?php echo trim($data->CHR_SUB_SECTION); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_SUB_SECTION_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo trim($data->CHR_SUB_SECTION_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_SECTION" id="source" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_section as $isi) {
                                        if ($data->INT_ID_SECTION == $isi->INT_ID_SECTION) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
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