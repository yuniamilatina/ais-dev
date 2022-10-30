<?php echo form_open('login_c/change_expired', 'class="form-login"'); ?> 
<form name="forgot" class="form-login">
    <input type="text" name="CHR_NPK" class="form-control" required placeholder="NPK" autofocus>
    <input type="password" name="CHR_PASS" class="form-control" required placeholder="Password Lama" autofocus>
    <input type="password" name="CHR_NEW_PASS" class="form-control" required placeholder="Password Baru" autofocus>
    <input type="password" name="CHR_NEW_PASS_CONFIRM" class="form-control" required placeholder="Konfirmasi Password Baru" autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">SUBMIT</button>

    <a href="<?php echo base_url('index.php/login_c') ?>" class="pull-right need-help">Coba Login</a><span class="clearfix"></span>
    <?php
    if (!is_null($msg)) {
        echo $msg;
    }
    ?></form>