
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li> <a href="#"><strong>Change Password</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('basis/user_c/change_password_user', 'class="form-horizontal"');
        ?>
        
        <div class='alert alert-info'>
          <span>Password harus mempunyai minimal 8 karakter, dengan berisikan minimal 1 huruf kecil (contoh : abcdef...), minimal 1 huruf kapital (contoh : ABCDEF...) serta minimal 1 angka </span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>CHANGE PASSWORD</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_REGIS_DATE" class="form-control" type="hidden" value="<?php echo $data->CHR_REGIS_DATE; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPK</label>
                            <div class="col-sm-5">
                                <input name="CHR_NPK" class="form-control" maxlength="20" readonly type="text" value="<?php echo trim($data->CHR_NPK); ?>">
                            </div>
                        </div>
                        
                        <input name="CHR_USERNAME" class="form-control" maxlength="20" readonly type="hidden" value="<?php echo trim($data->CHR_USERNAME); ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">New Password</label>
                            <div class="col-sm-5">
                                <input name="CHR_NEW_PASS" class="form-control" required type="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Confirm New Password</label>
                            <div class="col-sm-5">
                                <input name="CHR_NEW_PASS_CONFIRM" class="form-control" required type="password">
                            </div>
                        </div>       
     

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-refresh"></i> Update</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           


            </div>
        </div>


    </section>
</aside>
