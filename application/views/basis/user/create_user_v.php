<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/basis/user_c/') ?>">Manage Employee</a></li>
            <li><a href="#"><strong>Create Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('basis/user_c/save_user', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>CREATE EMPLOYEE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">


                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPK</label>
                            <div class="col-sm-2">
                                <input name="CHR_NPK" class="form-control" maxlength="6" autocomplete="off" onkeyup="angka(this);" required type="text" >
                            </div> 4 sampai 6 karakter
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-4">
                                <input name="CHR_USERNAME" class="form-control" maxlength="20" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Level</label>
                            <div class="col-sm-2">
                                <select id="level" name="INT_ID_ROLE" class="form-control" onchange="gantirole()">
                                    <?php
                                    foreach ($data_role as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_ROLE + 1000; ?>"><?php echo $isi->CHR_ROLE; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="display:none;" >
                            <label class="col-sm-3 control-label">Company</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_COMPANY" class="form-control">
                                    <?php
                                    foreach ($data_company as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_COMPANY; ?>"><?php echo $isi->CHR_COMPANY . ' - ' . $isi->CHR_COMPANY_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div id="division" class="form-group" >
                            <label class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-3">
                                <select name="INT_ID_DIVISION" class="form-control">
                                    <option selected="true" value=0>--Choose Division--</option>
                                    <?php
                                    foreach ($data_div as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DIVISION; ?>"><?php echo $isi->CHR_DIVISION . ' - ' . $isi->CHR_DIVISION_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div id="gm" class="form-group" >
                            <label class="col-sm-3 control-label">Group Department</label>
                            <div class="col-sm-4">
                                <select name="INT_ID_GROUP_DEPT"  class="form-control">
                                    <option selected="true" value=0>--Choose Group Department--</option>
                                    <?php
                                    foreach ($data_groupdept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_GROUP_DEPT; ?>"><?php echo $isi->CHR_GROUP_DEPT . ' - ' . $isi->CHR_GROUP_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div id="dept" class="form-group" >
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-4">
                                <select name="INT_ID_DEPT"  class="form-control">
                                    <option selected="true" value=0>--Choose Department--</option>
                                    <?php
                                    foreach ($data_dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div id="section" class="form-group" >
                            <label class="col-sm-3 control-label">Section</label>
                            <div class="col-sm-4">
                                <select name="INT_ID_SECTION"  class="form-control" >
                                    <option selected="true" value=0>--Choose Section--</option>
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

                        <div id="subsection" style="display:none;"  class="form-group" >
                            <label class="col-sm-3 control-label">Sub Section</label>
                            <div class="col-sm-5">
                                <select name="INT_ID_SUB_SECTION"  class="form-control">
                                    <option selected="true" value=0>--Choose Subsection--</option>
                                    <?php
                                    foreach ($data_subsection as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_SUB_SECTION; ?>"><?php echo $isi->CHR_SUB_SECTION . ' - ' . $isi->CHR_SUB_SECTION_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-4">
                                <input name="CHR_PASS" class="form-control" required type="password" value="P@ssw0rd">
                            </div> Default : P@ssw0rd
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Confirm Password</label>
                            <div class="col-sm-4">
                                <input name="CHR_PASS_CONFIRM" class="form-control" required type="password" value="P@ssw0rd">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
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