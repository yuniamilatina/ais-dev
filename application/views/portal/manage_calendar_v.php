<script>
    $(document).ready(function() {


<?php foreach ($data as $isi_nya) { ?>
            $('#row_activity_<?php echo trim($isi_nya->CHR_DATE) ?>').click(function() {
                var id_activity = <?php echo trim($isi_nya->CHR_DATE) ?>;
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('portal/calendar_c/getUpdate'); ?>",
                    data: "id_activity=" + id_activity,
                    success: function(data) {
                        $("#update_content").html(data);

                    }
                });

            });
<?php } ?>

    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/portal/calendar_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Calendar</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        

        
       
        ?>

        <div class="row">
            
            

            
            <div class="col-md-6">
                <div class="grid">
                    
                    
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> CALENDAR</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
                        
                        <?php echo form_open('portal/calendar_c/save_calendar', 'class="form-horizontal"'); ?>
                        

                        
                        <div class="form-group dll">
                            <label class="col-sm-4 control-label">Due date</label>
                            <div class="col-sm-5">
                                <input name="CHR_DATE" id="datepicker" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Date Initial</label>
                            <div class="col-sm-5">
                              
                                    <select class="form-control" name="CHR_CODE_DATE" id="CHR_CODE_DATE" required style="width:220px;">
                                        <option value="CB">CB - Cuti Bersama</option>
                                        <option value="LN">LN - Libur Nasional</option>
                                        <option value="HS">HS - Hari Sabtu</option>
                                        <option value="HM">HM - Hari Minggu</option>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Date Description</label>
                            <div class="col-sm-7">
                                <input name="CHR_DESC" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('portal/calendar_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"'); 
                                    echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>GENERATE</strong> HOLIDAY CALENDAR</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" >
                        <?php echo form_open('portal/calendar_c/generate_calendar', 'class="form-horizontal"'); ?>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Year</label>
                            <div class="col-sm-5">
                              
                                    <select class="form-control" name="YEAR" id="YEAR" required style="width:80px;">
                                        <?php for ($x = -2; $x <= 2; $x++) {?>
                                        <option value="<?php echo date('Y', strtotime(''.$x.' year')); ?>" <?php if(date('Y', strtotime(''.$x.' year')) == date('Y')){ echo 'SELECTED'; } ?>><?php echo date('Y', strtotime(''.$x.' year')); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                                                       
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Generate this data"><i class="fa fa-check"></i> Generate</button>
                                    <?php echo anchor('portal/calendar_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"'); 
                                    echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            
            
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>CALENDAR</strong> HOLIDAY TABLE</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/portal/calendar_c/create_calendar/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Create ECI Category" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Date Initial</th>
                                    <th>Date Description</th>
                                    <th>Type</th>
                                    <!--th>Actions</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    //echo "<tr class='gradeX'>";
                                    echo "<tr id=\"row_activity_".trim($isi->CHR_DATE)."\">";
                                    echo "<td>$isi->CHR_DATE</td>";
                                    echo "<td>$isi->CHR_CODE_DATE</td>";
                                    echo "<td>$isi->CHR_DESC</td>";
                                   // echo "<td>$isi->CHR_BUDGET_TYPE</td>";
                                    ?>
                                <td>
                                    <!--a href="<?php echo base_url('index.php/eci/category_c/select_by_id') . "/" . $isi->CHR_DATE;  ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a-->
                                    <!--a href="<?php echo base_url('index.php/eci/category_c/edit_category') . "/" . $isi->CHR_DATE;  ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a-->
                                    <a href="<?php echo base_url('index.php/portal/calendar_c/delete_calendar') . "/" . $isi->CHR_DATE; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this date?');"><span class="fa fa-times"></span></a>
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

    </section>
</aside>


