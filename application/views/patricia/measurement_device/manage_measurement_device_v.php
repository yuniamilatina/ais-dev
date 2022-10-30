<script>
    $(document).ready(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
        
    )};
    $(document).ready(function () {
        $("#datepicker3").datepicker({dateFormat: 'dd-mm-yy'}).val();
        
    )};
    $(document).ready(function () {
        $("#datepicker11").datepicker({dateFormat: 'dd-mm-yy'}).val();
        
    )};
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Measurement Device</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>MEASUREMENT DEVICE</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="#modaladd" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Device" style="height:30px;font-size:13px;width:100px;">Create</a>
                            <!-- <a href="<?php echo base_url('index.php/patricia/measurement_device_c/create_tool/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Tool" style="height:30px;font-size:13px;width:100px;">Create</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Measurement Device Name</th>
									<th>Measurement Device Model</th>
                                    <th>Asset Number</th>
                                    <th>Serial Number</th>
                                    <th>Area</th>
                                    <th>Work Center</th>
                                    <th>Calibration Date</th>
                                    <th>Expired Date</th>
                                    <th>Unit of Measurement</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_DEVICE_DESC</td>";
                                        echo "<td>$isi->CHR_MODEL</td>";
                                        echo "<td>$isi->CHR_NUMBER_ASSET</td>";
                                        echo "<td>$isi->CHR_SERIAL_NO</td>";
                                        echo "<td>$isi->CHR_AREA</td>";
                                        echo "<td>$isi->CHR_WC</td>";
                                        echo "<td>". date('d F Y', strtotime($isi->CHR_CLB_DATE)) ."</td>";
                                        echo "<td>". date('d F Y', strtotime($isi->CHR_EXP_DATE)) ."</td>";
                                        echo "<td>$isi->CHR_UNIT</td>";
                                    ?>
                                    <td>
                                        <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_DEVICE_ID; ?>" data-placement="left" data-toggle="tooltip" title="Edit Device" class="label label-warning"><span class="fa fa-pencil"></span></a>

                                        <a href="<?php echo base_url('index.php/patricia/measurement_device_c/delete') . "/" . $isi->INT_DEVICE_ID; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this measurement device?');"><span class="fa fa-times"></span></a>
                                    </td>

                                    </tr>
                                 <?php
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal Add Device -->
        <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                     <?php echo form_open('patricia/measurement_device_c/save_device', 'class="form-horizontal"'); ?>
                        <div class="modal-header bg-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalprogress"><strong>Add Measurement Device</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Device Name <span style="color: red">*</span></label>
                                <div class="col-sm-7">
                                    <input name="CHR_DEVICE_DESC" class="form-control" required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Device Model <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_MODEL" class="form-control" required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Asset Number <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_NUMBER_ASSET" class="form-control" style="width:350px" required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Serial Number <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_SERIAL_NO" class="form-control"  required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Calibration Date <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_CLB_DATE" id="datepicker1" class="form-control" style="width:350px" required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Expired Date <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <input name="CHR_EXP_DATE" id="datepicker3" class="form-control" style="width:350px" required type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Area Pemakaian <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select name="CHR_AREA" id="opt_wcenter" style="width: 150px;" class="form-control" required>
                                    <option value=""></option>
                                        <?php 
                                        foreach ($all_dvc_dept as $row) { ?>
                                            <?php                             
                                            $dept = trim($row->CHR_DEPT);
                                            ?>
                                            <option value="<?php echo $dept ?>" > <?php echo $dept ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Work Center <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select name="CHR_WC" id="e1" style="width: 150px;" class="form-control" required>
                                        <option value=""></option>
                                        <?php 
                                        foreach ($all_work_centers as $row) { ?>
                                            <?php                             
                                            $wc = trim($row->CHR_WORK_CENTER);
                                            ?>
                                            <option value="<?php echo $wc ?>" > <?php echo $wc ?> </option>
                                        <?php } ?>
                                        <option value="REC" > RECEIVING </option>
                                        <option value="DEL" > DELIVERY </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Unit of Measurement<span> </span><span style="color: red">*</span></label>
                                <div class="col-sm-3">
                                    <input name="CHR_UNIT" class="form-control" required type="text" placeholder="mm / cm / N" onkeypress="return hanyaHuruf(event)" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
            foreach ($data as $isi) {
                $d = ($isi->CHR_AREA);
                $w = ($isi->CHR_WC);
                ?>
                <!--EDIT Vacancy-->
                <div class="modal fade" id="modaledit<?php echo $isi->INT_DEVICE_ID; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Edit Measurement Device</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php echo form_open('patricia/measurement_device_c/update', 'class="form-horizontal"'); ?>

                                    <input name="INT_DEVICE_ID" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_DEVICE_ID ?>">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Device Name <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_DEVICE_DESC" style="width:350px" class="form-control" required type="text" required value="<?php echo $isi->CHR_DEVICE_DESC ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Device Model <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_MODEL" class="form-control" style="width:350px" required type="text" required value="<?php echo $isi->CHR_MODEL ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Asset Number <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_NUMBER_ASSET" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_NUMBER_ASSET ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Serial Number <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_SERIAL_NO" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_SERIAL_NO ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Calibration Date <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_CLB_DATE" id="datepicker2<?php echo $isi->INT_DEVICE_ID ?>" class="form-control" style="width:350px" required type="text" required value="<?php echo date("m/d/Y", strtotime($isi->CHR_CLB_DATE));  ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Expired Date <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_EXP_DATE" id="datepicker<?php echo $isi->INT_DEVICE_ID ?>" class="form-control" style="width:350px" required type="text" required value="<?php echo date("m/d/Y", strtotime($isi->CHR_EXP_DATE));  ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                <label class="col-sm-4 control-label">Area Pemakaian <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select name="CHR_AREA" id="opt_wcenter" style="width: 150px;" class="form-control" required>
                                    
                                        <?php 
                                        foreach ($all_dvc_dept as $row) { ?>
                                            <?php                             
                                            $dept = trim($row->CHR_DEPT);
                                            ?>
                                            <option value="<?php echo $dept ?>" <?php if ($d == trim($dept)) echo "selected" ?>> <?php echo $dept ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Work Center <span style="color: red">*</span></label>
                                <div class="col-sm-5">
                                    <select name="CHR_WC" id="e2" style="width: 150px;" class="form-control" required>
                                        
                                        <?php 
                                        foreach ($all_work_centers as $row) { ?>
                                            <?php                             
                                            $wc = trim($row->CHR_WORK_CENTER);
                                            ?>
                                            <option value="<?php echo $wc ?>" <?php if ($w == trim($wc)) echo "selected" ?>> <?php echo $wc ?> </option>
                                        <?php } ?>
                                        <option value="REC" > RECEIVING </option>
                                        <option value="DEL" > DELIVERY </option>
                                    </select>
                                </div>
                            </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Unit of Measurement<span> </span><span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_UNIT" class="form-control" required style="width:350px" type="text" placeholder="mm / cm / N" onkeypress="return hanyaHuruf(event)" maxlength="10" value="<?php echo $isi->CHR_UNIT ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#modaledit<?php echo $isi->INT_DEVICE_ID; ?>').on('shown.bs.modal', function() {
                        $("#datepicker2<?php echo $isi->INT_DEVICE_ID; ?>").datepicker({dateFormat: 'dd-mm-yy'}).val();
                    });
                </script>
                <?php
                $i++;
            }
            ?>
    </section>
</aside>


