<?php echo form_open('login_c/send_mail', 'class="form-login"'); ?> 
<form name="forgot" class="form-login">
    <input type="text" name="NPK" class="form-control" placeholder="NPK" autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Next</button>
    <?php
    if (!is_null($msg)) {
        echo $msg;
    }
    ?></form>