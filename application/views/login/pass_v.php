<?php echo form_open('login_c/check_pass', 'class="form-login"'); ?> 
<form name="forgot" class="form-login">
    <input type="password" name="PASS1" class="form-control" placeholder="New Password ex: MyPass@2015" autofocus>
    <input type="password" name="PASS2" class="form-control" placeholder="Retype New Password">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Complete</button>
    <?php
    if (!is_null($msg)) {
        echo $msg;
    }
    ?></form>