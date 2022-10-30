<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/application/application_c/'); ?>">Manage Application</a></li>            
            <li><a href="#"><strong>Edit Application</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('app/application_c/update_application', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT APPLICATION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_APP" class="form-control" readonly required type="hidden" value="<?php echo $data->INT_ID_APP; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Application Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_APP" class="form-control" maxlength="5" required type="text" value="<?php echo trim($data->CHR_APP); ?>" style="width: 200px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Icon</label>
                            <div class="col-sm-5">
                                <select name="CHR_ICON" required class="form-control" value="<?php echo $data->CHR_ICON?>"  style="width:200px">
                                    <option value = "NULL"></option>
                                    <option value = "address-book"></option>
                                    <option value = "address-card">Address Card</option>
                                    <option value = "adjust">Adjust</option>
                                    <option value = "anchor">Anchor</option>
                                    <option value = "archive">Archive</option>
                                    <option value = "cubes">Cubes</option>
                                    <option value = "dashboard">Dashboard</option>
                                    <option value = "desktop">Desktop</option>
                                    <option value = "envelope">Envelope</option> 
                                    <option value = "fax">Fax</option> 
                                    <option value = "file">File</option> 
                                    <option value = "hospital-o">Hospital</option>           
                                    <option value = "puzzle-piece">Puzzle</option> 
                                    <option value = "shopping-cart">Shopping Cart</option>
                                    <option value = "sitemap">Site Map</option>
                                    <option value = "ticket">Ticket</option> 
                                    <option value = "user">User</option>
                                    <option value = "truck">Truck</option>
                                </select>                                    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('app/application_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>