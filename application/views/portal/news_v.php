
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>News & Event</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="grid box-calendar  bg-orange">
                    <div class="row">
                        <div class="col-md-3 no-padding-right" style="width:95%;">
                            <div class="grid-body bg-orange">
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

            <div class="col-md-9 " >
                <?php foreach ($news_top as $new_top): ?>
                    <div class="grid work-progress no-border ">

                        <div class="grid-header " style="z-index: 1;" >
                            <div style="position: absolute; top: 0;bottom: 0;left: 0;right: 0;width: 100%;height: 100%;background-image: url(<?php echo base_url('assets/img/gallery/' . $new_top->INT_ID_NEWS . '.jpg') ?>); z-index: -1;opacity : 0.2;"></div>
                            <span class="title"><font size="8"   ><?php echo $new_top->CHR_NEWS_TITLE; ?></font> 
                                <span class="pull-right"> <?php echo "<strong >" . date('l') . "</strong>&nbsp;" . date('F jS, Y '); ?></span>
                            </span>
                            <span class="sub-title text-blue"><font size="5"  ><i>written by <?php echo $new_top->CHR_CREATED_BY . " (" . trim($new_top->CHR_CREATED_BY) . ")"; ?></i></font></span>
                            <table>
                                <tr>
                                <!--td class="image" width="15%"  style="padding:20px;"><img src="<?php echo base_url('assets/img/gallery/thumb/' . $new_top->INT_ID_NEWS . '.jpg') ?>" alt="" width="210"></td-->
                                    <td class="product" style="padding:20px;"><?php echo substr($new_top->CHR_NEWS_DESC, 0, 350); ?>...<a href='<?php echo base_url('index.php/portal/news_c/detil/' . $new_top->INT_ID_NEWS); ?>'>(read more)</a></td>
                                </tr>
                            </table>
                            <!--h5 align="right">This site developed by MIS Dept © 2015 &nbsp;</h5-->
                        </div>

                    </div>
                <?php endforeach; ?>	
            </div>
        </div>

        <div class="row">
            <!-- BEGIN DRAGGABLE EVENT -->
            <div class="col-md-3">
                <div class="grid no-border">
                    <div class="grid-header">
                        <i class="fa fa-calendar-o"></i>
                        <span class="grid-title">Most Viewed</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <?php foreach ($news as $new): ?>
                                    <tr>

                                        <td class="product" style="padding:20px;">
                                            <strong><?php echo $new->CHR_NEWS_TITLE; ?></strong> <br /><i>written by <?php echo $new->CHR_CREATED_BY . " (" . trim($new->CHR_CREATED_BY) . ")"; ?></i><br><?php echo substr($new->CHR_NEWS_DESC, 0, 80); ?>...<a href='<?php echo base_url('index.php/portal/news_c/detil/' . $new->INT_ID_NEWS); ?>'>(read more)</a> 
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
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
                                        <td class="image" width="15%"  style="padding:20px;"><img src="<?php echo base_url('assets/img/gallery/thumb/' . $new->INT_ID_NEWS . '.jpg') ?>" alt="" width="150"></td>
                                        <td class="product" style="padding:20px;"><strong><?php echo $new->CHR_NEWS_TITLE; ?></strong> &nbsp;<i>written by <?php echo $new->CHR_CREATED_BY . " (" . trim($new->CHR_CREATED_BY) . ")"; ?></i><br><?php echo substr($new->CHR_NEWS_DESC, 0, 250) ?>...<a href='<?php echo base_url('index.php/portal/news_c/detil/' . $new->INT_ID_NEWS); ?>'>(read more)</a> </td>
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









