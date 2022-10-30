<!DOCTYPE html>
<html>
    <head>
        <title>Setup Welcome Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/welcome_board/css/style_mobile.css') ?>"></link>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/welcome_board/css/style_checkbox.css') ?>"></link>

    </head>
    <body style='background: #0A64E0;'>
        <div class="container">
            <center><div class="toggleMenu">WELCOME TO AISIN INDONESIA</div></center>
            <ul class="nav">
                <li  class="test">
                    <a href="#">HOME</a>
                    <ul class='ul-maps'>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox1; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/1') ?>")' id="test6" /><label for="test6"><span class="ui"></span>Home</label></li>
                    </ul>
                </li>
                <li>
                    <a href="#">MAPS</a>
                    <ul class='ul-maps'>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox2; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/2') ?>")' id="maps" /><label for="maps"><span class="ui"></span>Maps</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox3; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/3') ?>")' id="test1" /><label for="test1"><span class="ui"></span>Parking Lot #1</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox4; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/4') ?>")' id="test2" /><label for="test2"><span class="ui"></span>Parking Lot #2</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox5; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/5') ?>")' id="test3" /><label for="test3"><span class="ui"></span>Lobby</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox6; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/6') ?>")'  id="test4" /><label for="test4"><span class="ui"></span>Mosque</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox7; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/7') ?>")'  id="test5" /><label for="test5"><span class="ui"></span>Court</label></li>
                    </ul>
                </li>
                <li>
                    <a href="#">VIDEO</a>
                    <ul class='ul-maps'>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox8; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/8') ?>")'  id="video10" /><label for="video10"><span class="ui"></span>Video 10th</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox9; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/9') ?>")'  id="video20" /><label for="video20"><span class="ui"></span>Video 20th</label></li>
                        <li class='li-maps'><input type="checkbox" <?php echo $checkbox10; ?> onclick='window.location.assign("<?php echo base_url('index.php/welcome_board/welcome_board_setup_c/index/10') ?>")'  id="videoas" /><label for="videoas"><span class="ui"></span>Video Aisin Seiki</label></li>
                    </ul>
                </li>
            </ul>
        </div>
        <script type="text/javascript" src="<?php echo base_url('assets/welcome_board/js/jquery-1.11.1.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/welcome_board/js/script_mobile.js') ?>"></script>
    </body>
</html>