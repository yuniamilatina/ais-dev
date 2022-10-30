
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/basis/user_c/') ?>">Manage Employee</a></li>
            <li> <a href="#"><strong>Edit Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('basis/user_c/update_user', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>EDIT EMPLOYEE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_NPK" class="form-control" type="hidden" value="<?php echo $data->CHR_NPK; ?>">
                        <input name="CHR_REGIS_DATE" class="form-control" type="hidden" value="<?php echo $data->CHR_REGIS_DATE; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-5">
                                <input name="CHR_USERNAME" class="form-control" maxlength="20" required type="text" value="<?php echo trim($data->CHR_USERNAME); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-5">
                                <input name="CHR_PASS" class="form-control" required type="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Confirm Password</label>
                            <div class="col-sm-5">
                                <input name="CHR_PASS_CONFIRM" class="form-control" required type="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Level</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_ROLE" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_role as $isi) {
                                        if ($data->INT_ID_ROLE == $isi->INT_ID_ROLE) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_ROLE; ?>"><?php echo $isi->CHR_ROLE; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_ROLE; ?>"><?php echo $isi->CHR_ROLE; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Company</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_COMPANY" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_company as $isi) {
                                        if ($data->INT_ID_COMPANY == $isi->INT_ID_COMPANY) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_COMPANY; ?>"><?php echo $isi->CHR_COMPANY . ' - ' . $isi->CHR_COMPANY_DESC; ?></option>
                                        <?php } else if ($isi->INT_ID_COMPANY == 0) { ?>
                                            <option selected="true" value=0>--Choose Company--</option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_COMPANY; ?>"><?php echo $isi->CHR_COMPANY . ' - ' . $isi->CHR_COMPANY_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_DIVISION" class="form-control" style="width:400px">
                                    <?php
                                    if ($data->INT_ID_DIVISION == 0) {
                                        ?>
                                        <option selected="true" value=0>--Choose Division--</option>
                                        <?php
                                        foreach ($data_division as $isi) {
                                            ?> 
                                            <option value="<?php echo $isi->INT_ID_DIVISION; ?>"><?php echo $isi->CHR_DIVISION . ' - ' . $isi->CHR_DIVISION_DESC; ?></option>
                                            <?php
                                        }
                                    } else {
                                        foreach ($data_division as $isi) {
                                            if ($data->INT_ID_DIVISION == $isi->INT_ID_DIVISION) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_DIVISION; ?>"><?php echo $isi->CHR_DIVISION . ' - ' . $isi->CHR_DIVISION_DESC; ?></option>
                                            <?php } else if ($data->INT_ID_DIVISION == 0) { ?>
                                                <option selected="true" value=0>--Choose Division--</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_DIVISION; ?>"><?php echo $isi->CHR_DIVISION . ' - ' . $isi->CHR_DIVISION_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?> 
                                    </optgroup>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group Department</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_GROUP_DEPT" class="form-control" style="width:400px">
                                    <?php
                                    if ($data->INT_ID_GROUP_DEPT == 0) {
                                        ?>
                                        <option selected="true" value=0>--Choose Group Department--</option>
                                        <?php
                                        foreach ($data_groupdept as $isi) {
                                            ?> 
                                            <option value="<?php echo $isi->INT_ID_GROUP_DEPT; ?>"><?php echo $isi->CHR_GROUP_DEPT . ' - ' . $isi->CHR_GROUP_DEPT_DESC; ?></option>
                                            <?php
                                        }
                                    } else {
                                        foreach ($data_groupdept as $isi) {
                                            if ($data->INT_ID_GROUP_DEPT == $isi->INT_ID_GROUP_DEPT) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_GROUP_DEPT; ?>"><?php echo $isi->CHR_GROUP_DEPT . ' - ' . $isi->CHR_GROUP_DEPT_DESC; ?></option>
                                            <?php } else if ($data->INT_ID_GROUP_DEPT == 0) { ?>
                                                <option selected="true" value=0>--Choose Group Department--</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_GROUP_DEPT; ?>"><?php echo $isi->CHR_GROUP_DEPT . ' - ' . $isi->CHR_GROUP_DEPT_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_DEPT" class="form-control" style="width:400px">
                                    <?php
                                    if ($data->INT_ID_DEPT == 0) {
                                        ?>
                                        <option selected="true" value=0>--Choose Department--</option>
                                        <?php
                                        foreach ($data_dept as $isi) {
                                            ?> 
                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                            <?php
                                        }
                                    } else {
                                        foreach ($data_dept as $isi) {
                                            if ($data->INT_ID_DEPT == $isi->INT_ID_DEPT) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                            <?php } else if ($data->INT_ID_DEPT == 0) { ?>
                                                <option selected="true" value=0>--Choose Department--</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_SECTION" class="form-control" style="width:400px">
                                    <?php
                                    if ($data->INT_ID_SECTION == 0) {
                                        ?>
                                        <option selected="true" value=0>--Choose Section--</option>
                                        <?php
                                        foreach ($data_section as $isi) {
                                            ?> 
                                            <option value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                            <?php
                                        }
                                    } else {
                                        foreach ($data_section as $isi) {
                                            if ($data->INT_ID_SECTION == $isi->INT_ID_SECTION) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_SECTION; ?>"><?php echo $isi->CHR_SECTION . ' - ' . $isi->CHR_SECTION_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub section</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_SUB_SECTION" class="form-control" style="width:400px">
                                    <?php
                                    if ($data->INT_ID_SUB_SECTION == 0) {
                                        ?>
                                        <option selected="true" value=0>--Choose Subsection--</option>
                                        <?php
                                        foreach ($data_subsection as $isi) {
                                            ?> 
                                            <option value="<?php echo $isi->INT_ID_SUB_SECTION; ?>"><?php echo $isi->CHR_SUB_SECTION . ' - ' . $isi->CHR_SUB_SECTION_DESC; ?></option>
                                            <?php
                                        }
                                    } else {
                                        foreach ($data_subsection as $isi) {
                                            if ($data->INT_ID_SUB_SECTION == $isi->INT_ID_SUB_SECTION) {
                                                ?> 
                                                <option selected="true" value="<?php echo $isi->INT_ID_SUB_SECTION; ?>"><?php echo $isi->CHR_SUB_SECTION . ' - ' . $isi->CHR_SUB_SECTION_DESC; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $isi->INT_ID_SUB_SECTION; ?>"><?php echo $isi->CHR_SUB_SECTION . ' - ' . $isi->CHR_SUB_SECTION_DESC; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('basis/user_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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
