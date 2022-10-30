
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $title ?></title>

        <link rel="icon" href="<?php echo base_url('assets/img/LogoAisin.png'); ?>" > 
        <link rel="stylesheet" href="<?php echo base_url('assets/css/celine/bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/celine/main.css'); ?>" >

        <style type="text/css">
            body {
                padding-top: 80px;
            }
            .imgcctv{
                width: 100%;
                height: 350px;
            }
        </style>
        
    </head>
    <body>

        <?php 
        $path = 'http://192.168.0.221:81/mjpg/'; 
        $format = '/video.mjpg'; 
        $baseurl = 'http://192.168.0.231/AIS_PP/index.php/';
        ?>
        
        <!-- NAVIGATION MENU -->
        <div class="navbar-nav navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php base_url() ?>"><img src="<?php echo base_url('assets/img/loggo/aisin-loggo.svg') ?>" alt="loggo"></a>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="delivery"><i class="icon-th icon-white"></i> Delivery</a></li>
                        <li ><a href="unitparts"><i class="icon-th icon-white"></i> Unit Parts</a></li>
                        <li><a href="hybrid"><i class="icon-th icon-white"></i> Hybrid</a></li>
                        <li><a href="imani"><i class="icon-th icon-white"></i> Imani & CHC</a></li>
                        <li><a href="bodyparts"><i class="icon-th icon-white"></i> Body Parts</a></li>
                        <li><a href="doorlock"><i class="icon-th icon-white"></i> Door Lock</a></li>
                        <li><a href="doorframe"><i class="icon-th icon-white"></i> Door Frame</a></li>
                        <li class="active"><a href="#"><i class="icon-th icon-white"></i> Stamping</a></li>
                        <li><a href="injection"><i class="icon-th icon-white"></i> Injection</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="half-unit">
                        <dtitle>
                        STAMPING C-TYPE
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img class="imgcctv" src="<?php echo $path . 'PR003A' . $format ?>" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="half-unit">
                        <dtitle>
                        PR006H - PR006I
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img class="imgcctv" src="<?php echo $path . 'PR006H'. $format ?>" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="half-unit">
                        <dtitle>
                        PR006Q
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img class="imgcctv" src="<?php echo $path . 'PR006Q' . $format ?>" >
                        </div>
                    </div>
                </div>
                
            </div>

        </div>

        <div id="footerwrap" class="footer">
            <div class="col-sm-6 col-lg-12">
                <p>Developed by MIS @2019</p>
            </div>  
        </div>


</body>
</html>