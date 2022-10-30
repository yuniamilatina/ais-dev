<?php echo form_open('login_c/log', 'class="form-login"'); ?>

<form name="login" class="form-login">

    <input type="text" name="NPK" class="form-control" placeholder="NPK" maxlength="6" autofocus>
    <input type="password" name="PASS" class="form-control" placeholder="Password">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Log in AIS</button>

    <!--<a href="<?php echo base_url('index.php/login_c/forgot') ?>" class="pull-right need-help">Forgot Password?</a><span class="clearfix"></span>-->
    <a href="<?php echo base_url('index.php/login_c/change') ?>" class="pull-right need-help">Update Password</a><span class="clearfix"></span>

    <?php
    if (!is_null($msg)) {
        echo $msg;
    }
    ?>

</form>