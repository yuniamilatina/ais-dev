<?php

$user_session = $this->session->all_userdata();
if ($user_session['NPK'] == '') {
    redirect(base_url('index.php/login_c'));
}

?>
