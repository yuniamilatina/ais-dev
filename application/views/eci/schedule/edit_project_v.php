<script>
    $(document).ready(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
        $("#datepicker3").datepicker({dateFormat: 'dd-mm-yy'}).val();

        $('#dataTables1').DataTable({
            "order": [[0, "desc"]]
        });
    });

    function change_type(value)
    {
        if (value === 'NEW PROJECT') {
            $('#group_category_label').hide();
            $('#group_category').hide();
            $('#group_contents').hide();
            $('#group_interchange').hide();
        } else {
            $('#group_category_label').show();
            $('#group_category').show();
            $('#group_contents').show();
            $('#group_interchange').show();
        }
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li> <a href="#"><span><strong>Edit Project Schedule</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>EDIT PROJECT SCHEDULE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
                        <?php echo form_open('eci/schedule_c/update_schedule', 'class="form-horizontal"'); ?>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Project Type</label>
                            <div class="col-sm-4">
                                <input name="type_h" readonly id="type_h" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data->INT_TYPE; ?>">
                            </div>
                            <label class="col-sm-2 control-label">Customer <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="customer" id="customer" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data->CHR_CUSTOMER; ?>">
                            </div>
                        </div>
                        <input name="eci_id" type='hidden' class="form-control" style="width:200px;text-transform: uppercase;" maxlength="40"  value="<?php echo $data->CHR_ID_ECI; ?>">
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Project / ECI Number <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="eci_name" readonly id="eci_name" class="form-control" style="width:200px;text-transform: uppercase;" maxlength="40" required type="text" value="<?php echo $data->CHR_NAME; ?>">
                            </div>
                            <label class="col-sm-2 control-label">Model <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="vehicle" id="vehicle" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data->CHR_VEHICLE; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">FG Part Name <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">   
                                <input name="fg_partname" id="fg_partname" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data->CHR_FG_PARTNAME; ?>">
                            </div>
                            <?php if (trim($data->INT_TYPE) == 'ECI') { ?>
                                <div id="group_contents">
                                    <label class="col-sm-2 control-label">Contents <strong style="color:red;">*</strong></label>
                                    <div class="col-sm-4">   
                                        <input name="content_eci" id="content_eci" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="80" required type="text" value="<?php echo $data->CHR_CONTENT; ?>">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group" >

                            <label class="col-sm-2 control-label">Cust. Request Date <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input  name="due_date" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo date('d-m-Y', strtotime($data->CHR_DUE_DATE)); ?>">
                            </div>
                             <?php if (trim($data->INT_TYPE) == 'ECI') { ?>
                            <div id="group_category">
                                <label id="group_category_label" class="col-sm-2 control-label">Category </label>
                                <div class="col-sm-4">
                                    <select  name="category_h" id="category_h" class="form-control" style="width:250px">
                                        <?php
                                        foreach ($get_cat as $cat_list) {
                                            if (trim($data->ID_CATEGORY) == trim($cat_list->INT_ID_CATEGORY)) {
                                                ?>
                                                <option selected value="<?php echo $data->ID_CATEGORY; ?>"><?php echo $data->CHR_CATEGORY_NAME; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $cat_list->INT_ID_CATEGORY; ?>"><?php echo $cat_list->CHR_CATEGORY_NAME; ?></option>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </select>
                                </div>
                            </div>
                             <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Received Date <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="receive_date"  id="datepicker1" class="form-control" autocomplete="off"  required type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo date('d-m-Y', strtotime($data->CHR_RECEIVE_DATE)); ?>">
                            </div>
                             <?php if (trim($data->INT_TYPE) == 'ECI') { ?>
                            <div id="group_interchange">
                                <label class="col-sm-2 control-label">Interchangeability </label>
                                <div class="col-sm-4">
                                    <input readonly name="interchange_h" id="fg_partname" class="form-control" style="width:150px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data->CHR_INTERCHANGE; ?>">
                                </div>
                            </div>
                             <?php } ?>
                        </div>
                        <div class="form-group">

                            <label class="col-sm-2 control-label">Implementing Date <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input  name="implementing_date" id="datepicker3" class="form-control" autocomplete="off"  required type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo date('d-m-Y', strtotime($data->CHR_IMPLEMENTING_PLAN)); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-push-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('eci/schedule_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <font style="color: red;"><strong>* Required Field</strong></font>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>