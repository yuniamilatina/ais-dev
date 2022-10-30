
    <?php echo form_open('login_c/log', 'class="form-signin"'); ?> 
    <div class="login-content">
        <div class="form-group m-b-20">
            <input class="form-control input-lg text-center" autofocus="autofocus" required="true" name="NPK" id="NPK" placeholder="User Id" type="text">
        </div>
        <div class="form-group m-b-20">
            <input class="form-control input-lg text-center" name="PASS" id="PASS" required="true" placeholder="Password" type="password">
        </div>

        <div class="login-buttons">
            <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
        </div>
        <?php
        if (!is_null($msg)) {
            echo $msg;
        }
        ?>
        <div class = "m-t-20">
            Forgot your password? Click <a href = "<?php echo base_url('index.php/login_c/forgot') ?>">here</a> to recover your account.
        </div>

    </div>