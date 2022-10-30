
<aside class="right-side">



    <section class="content">


        <div class="row">

            <br />
            <div class="col-md-3">
                <div class="grid box-calendar  bg-purple">
                    <div class="row">
                        <div class="col-md-3 no-padding-right" style="width:95%;">
                            <div class="grid-body bg-purple">
                                <span class="date">
                                    <?php echo date('d'); ?>
                                </span>
                                <hr>
                                <span class="notification">
                                    <i class="fa fa-bell-o"></i> <?php echo date('M Y'); ?>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="grid work-progress no-border ">
                    <div class="grid-header">
                        <span class="title">Aisin Indonesia Integrated System </span>
                        <span class="sub-title text-blue">Website Stats</span>

                        <br />
                        <table width="100%">
                            <tr>

                                <td>
                                    <h4>VISITS</h4>
                                    <h2><?php echo $visits; ?></h2>
                                </td>
                                <td>                                                                    
                                    <h4>CLIENT</h4>
                                    <h2><?php echo $tot_user; ?></h2>
                                </td>
                                <td>                                                                    
                                    <h4>THREAD</h4>
                                    <h2><?php echo $tot_thread; ?></h2>
                                </td>
                                <td>                                                                    
                                    <h4>TICKETS</h4>
                                    <h2><?php echo $tot_tickets; ?></h2>
                                </td>
                            </tr>
                        </table>

                        <h5 align="right">This site developed by MIS Dept © 2015 &nbsp;</h5>
                    </div>
                </div>

            </div>





            <div class="col-md-3">
                <div class="grid weather bg-blue">
                    <div class="grid-body full">
                        <h3 class="title"><i class="fa fa-map-marker"></i> Cikarang, ID<span class="pull-right"><?php echo $temperature; ?><sup>&deg;</sup>C</span></h3>
                        <canvas  class="weather-icon"  id="<?php echo trim($weather); ?>"  width="110" height="110"></canvas>

                        <div class="footer">
                            <div class="row">

                                Supported by <a href="http://www.openweathermap.org/">Open Weather Map</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <!-- BEGIN DRAGGABLE EVENT -->

            <div class="col-md-3">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Jangan Membuat Barang NG
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Jangan Menerima Barang NG
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                    Jangan Meneruskan Barang NG
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END DRAGGABLE EVENT -->
            <!-- BEGIN CALENDAR -->
            <div class="col-md-9">
                <div class="grid no-border">
                    <div class="grid-header">
                        <i class="fa fa-calendar-o"></i>
                        <span class="grid-title">News & Event</span>
                    </div>
                    <!--div class="grid-body">
                            <center><img src="<?php echo base_url('assets/img/upload/PORSE FLASH REV 23.jpg') ?>" width="60%"></center>
                            <br />Berikut Hasil Akhir Point Porse Aisin Indonesia 2015 <br />
                            <center><img src="<?php echo base_url('assets/img/upload/klasemen.JPG') ?>" width="100%"></center>
                    
                    </div-->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <?php foreach ($news as $new): ?>
                                    <tr>
                                        <td class="image" width="15%"  style="padding:20px;"><img src="<?php echo base_url('assets/img/gallery/' . $new->INT_ID_NEWS . '.jpg') ?>" alt="" width="150"></td>
                                        <td class="product" style="padding:20px;"><strong><?php echo $new->CHR_NEWS_TITLE; ?></strong> &nbsp;<i>written by <?php echo $new->CHR_CREATED_BY; ?></i><br><?php echo substr($new->CHR_NEWS_DESC, 0, 250) ?>...<a href='<?php echo base_url('index.php/portal/news_c/detil/' . $new->INT_ID_NEWS); ?>'>(read more)</a> </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END CALENDAR -->
        </div>
    </section>
    <!-- END MAIN CONTENT -->
</aside>









