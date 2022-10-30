<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from vergo-kertas.herokuapp.com/login.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 16 Sep 2014 01:37:34 GMT -->
    <head>
        <meta charset="utf-8">
        <!--[if IE]>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>AIS &ndash; Log In</title>

        <link rel="icon" href="<?php echo base_url('assets/img/loggo/logo.png'); ?>" >

        <!-- BEGIN CSS FRAMEWORK -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
        <!-- END CSS FRAMEWORK -->

        <!-- BEGIN CSS PLUGIN -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace-theme-minimal.css'); ?>" >

        <!-- END CSS PLUGIN -->

        <!-- BEGIN CSS TEMPLATE -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>" >
        <!-- END CSS TEMPLATE -->
    </head>

    <body class="login">
        <div class="outer">
            <div class="middle">
                    
                    <div class='alert alert-info' style='font-size:10pt;margin-top:-80px;margin-right:50px;margin-left:50px;padding-left:40px;padding-right:40px;'>
                      <span><strong>Pemberitahuan : </strong><br>
                      Jika anda mengalami gagal login, kemungkinan password telah expired (sudah lebih dari 3 bulan tidak diganti),
                      Agar bisa login kembali, anda bisa mengubahnya di link <strong>Update Password</strong> (dibawah tombol Log in AIS).</span>
                      <br>
                      <span style='background:#2B8BFD;color:white;'>Perlu diingat : Password baru, harus mempunyai minimal 8 karakter, dengan berisikan minimal 1 huruf kecil (contoh : abcdef...) dan minimal 1 huruf kapital (contoh : ABCDEF...) 
                      dan password jangan dibagikan !</span>
                    </div>
                    
                    <div class="inner">
                        <div class="row">

                        <!-- BEGIN LOGIN BOX -->
                        <div class="col-lg-12">
                            <div class="account-wall">
                                <!-- BEGIN PROFILE IMAGE -->
                                <!--img class="profile-img" src="<?php echo base_url('assets/img/photo.png'); ?>" alt=""-->
                                <img src="<?php echo base_url('assets/img/loggo/aisin-loggo.svg'); ?>" alt="">
                                <!-- END PROFILE IMAGE -->
                                <!-- BEGIN LOGIN FORM -->
                                <?php $this->load->view($content); ?> 
								
                                <!-- END LOGIN FORM -->
                            </div>
                        </div>
                        <!-- END LOGIN BOX -->
                    </div>
                </div>
            </div>
        </div>

        <!-- BEGIN JS FRAMEWORK -->
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.0.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>

        <!-- BEGIN JS PLUGIN -->
        <script src="<?php echo base_url('assets/plugins/pace/pace.min.js') ?>"></script>
        
    </body>

</html>