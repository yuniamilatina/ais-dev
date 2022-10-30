<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/application/application_c/'); ?>"><strong>Manage Application</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
            if ($msg != NULL) {
                    echo $msg;
            }
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>MANAGE APPLICATION</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr style="text-align:center">
                                    <!--<th>ID App</th>-->
                                    <th>Application</th>
                                    <th>Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";                                    
//                                    echo "<td>$isi->INT_ID_APP</td>";
                                    if ($isi->CHR_APP == null) {
                                            echo "<td><span class='label label-warning'>NO DATA</span></td>";
                                    }
                                    else {
                                            echo "<td>$isi->CHR_APP</td>";
                                    }
                                    if ($isi->CHR_ICON == null) {
                                            echo "<td><span class='label label-warning'>NO DATA</span></td>";
                                    }
                                    else {
                                            echo "<td><i class='fa fa-$isi->CHR_ICON'</i></td>";
                                    }
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/app/application_c/edit_application') . "/" . $isi->INT_ID_APP; ?>" 
                                                    class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>

                                    <a href="<?php echo base_url('index.php/app/application_c/delete_application') . "/" . $isi->INT_ID_APP; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" 
                                                    title="Delete" onclick="return confirm('Are you sure want to delete this MIS document?');"><span class="fa fa-times"></span></a> 
                                </td>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                        
<!--            <div class="col-md-5">
                <?php
                    if (validation_errors()) {
                        echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
                    }
                    echo form_open('application/application_c/save_application', 'class="form-horizontal"');
                ?>

                <div class="grid">
                    <div class="grid-header">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="grid-title">CREATE <strong>APPLICATION</strong> </span>
                            <div class="pull-right grid-tools">
                                    <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Application Name</label>
                            <div class="#">
                                    <input name="CHR_APP" class="form-control" maxlength="15" required type="text" style="width: 200px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Icon</label>
                            <div class="#">
                                <select name="CHR_ICON" id="e1" required class="form-control" style="width:200px"> 
                                <select name="CHR_ICON" required class="form-control" style="width:200px">
                                    <option value = "NULL"></option>
                                    <option value = "address-book">Address Book</option>
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
                                <div class="col-md-offset-4">
                                        <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>  Save</button>
                                                <?php echo anchor('application/application_c', 'Cancel', 'class="btn btn-default"'); 
                                                echo form_close();
                                                ?>
                                        </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>-->
    </div>		
	</section>
</aside>