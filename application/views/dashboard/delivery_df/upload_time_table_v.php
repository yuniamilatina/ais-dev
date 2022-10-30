
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/portal/calendar_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Update Time Table </strong></a></li>

        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

            <div class="row">
                







                    <div class="col-md-5">
                        <div class="grid">
                            <div class="grid-header">
                                <i class="fa fa-pencil-square"></i>
                                <span class="grid-title"><strong>UPDATE </strong> TIME TABLE</span>
                                <div class="pull-right grid-tools">
                                    <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="grid-body">
                              <form method="post" action="<?php echo site_url("dashboard/delivery_df_c/submit_timetable") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
                                    <div class=" form-group" id="file-name1">
										
										<label class="col-sm-3 control-label"> </label>
                                        <div class="col-sm-5">
                                           <a href="<?php echo base_url('assets/template/Template_Upload_Time_Table.xlsx') ?>"> Download Template </a>
                                        </div>
									</div>
                                    <div class=" form-group" id="file-name1">
                                        <label class="col-sm-3 control-label">File </label>
                                        <div class="col-sm-5">
                                           <input type="file" name="import" id="import" size="20"  value="">
                                        </div>
                                    </div>
   

                                    <div class="form-group" id="btn-group-header">
                                        <div class="col-sm-offset-4 col-sm-4">
                                            <div class="btn-group">
                                                <button id="add-feedback" value="1" name="btn_submit" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add Activity"><i class="fa fa-check"></i> Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    

  
            </div>
        


    </section>
</aside>



