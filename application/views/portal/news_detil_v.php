
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/portal/news_c'); ?>"><span>News & Event</span></a></li>
            <li><a href=""><strong><?php echo $news_id_title; ?></strong></a></li>
        </ol>
    </section>

    <section class="content">
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

            <div class="col-md-9 " >
                <?php foreach ($news_id as $new_id): ?>
                    <div class="grid work-progress no-border ">

                        <div class="grid-header " style="z-index: 1;" >
                            <div style="position: absolute; top: 0;bottom: 0;left: 0;right: 0;width: 100%;height: 100%;background-image: url(<?php echo base_url('assets/img/gallery/' . $new_id->INT_ID_NEWS . '.jpg') ?>); z-index: -1;opacity : 0.06;"></div>
                            <span class="title"><font size="8"   ><?php echo $new_id->CHR_NEWS_TITLE; ?></font> 
                                <span class="pull-right"> <?php echo "<strong >" . date('l') . "</strong>&nbsp;" . date('F jS, Y '); ?></span>
                            </span>
                            <span class="sub-title text-blue"><font size="5"  ><i>written by <?php echo $new_id->CHR_CREATED_BY; ?></i></font></span>
                            <br />
                            <center><img src="<?php echo base_url( $new_id->CHR_URL_IMAGE ) ?>" width="650"/></center>
                            <table>
                                <tr>
                                <!--td class="image" width="15%"  style="padding:20px;"><img src="<?php echo base_url('assets/img/gallery/' . $new_id->INT_ID_NEWS . '.jpg') ?>" alt="" width="210"></td-->
                                    <td class="product" style="padding:20px;"><?php echo $new_id->CHR_NEWS_DESC . " "; ?></td>
                                </tr>
                            </table>
                            <!--h5 align="right">This site developed by MIS Dept © 2015 &nbsp;</h5-->
                        </div>

                    </div>
                <?php endforeach; ?>	
            </div>
            <!-- END DRAGGABLE EVENT -->
            <!-- BEGIN CALENDAR -->

            <!-- END CALENDAR -->
        </div>
    </section>
    <!-- END MAIN CONTENT -->
</aside>









