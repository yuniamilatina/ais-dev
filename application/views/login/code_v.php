<?php echo form_open('login_c/check_code', 'class="form-login"'); ?> 
<form name="forgot" class="form-login">
    <input type="text" name="CODE" class="form-control" placeholder="Verification Code" autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Next</button>
    <?php
    if (!is_null($msg)) {
        echo $msg;
    }
    ?></form>