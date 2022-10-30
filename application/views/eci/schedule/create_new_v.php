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
            <li> <a href="#"><span><strong>Create Project Schedule</strong></span></a></li>
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
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE PROJECT SCHEDULE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
                        <?php echo form_open('eci/schedule_c/save_schedule', 'class="form-horizontal"'); ?>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Project Type</label>
                            <div class="col-sm-4">
                                <select name="type_h" id="type_h" onchange="change_type(this.value);" required class="form-control" style="width:150px">
                                    <option selected value="ECI">ECI</option>
                                    <option value="NEW PROJECT">New Project</option>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Customer <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="customer" id="customer" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text">
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Project / ECI Number <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="eci_name" id="eci_name" class="form-control" style="width:200px;text-transform: uppercase;" maxlength="40" required type="text">
                            </div>
                            <label class="col-sm-2 control-label">Model <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="vehicle" id="vehicle" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">FG Part Name <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">   
                                <input name="fg_partname" id="fg_partname" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text">
                            </div>
                            <div id="group_contents">
                                <label class="col-sm-2 control-label">Contents</label>
                                <div class="col-sm-4">   
                                    <input name="content_eci" id="content_eci" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="100" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" >

                            <label class="col-sm-2 control-label">Cust. Request Date <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input  name="cust_date" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width: 125px;text-transform: uppercase;" >
                            </div>
                            <div id="group_category">
                                <label id="group_category_label" class="col-sm-2 control-label">Purpose </label>
                                <div class="col-sm-4">
                                    <select  name="category_h" id="category_h" class="form-control" style="width:250px">
                                        <?php
                                        foreach ($get_cat as $cat_list) {
                                            ?>
                                            <option value="<?php echo $cat_list->INT_ID_CATEGORY; ?>"><?php echo $cat_list->CHR_CATEGORY_NAME; ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Received Date <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input name="receive_date"  id="datepicker1" class="form-control" autocomplete="off"  required type="text" style="width: 125px;text-transform: uppercase;" >
                            </div>
                            <div id="group_interchange">
                                <label class="col-sm-2 control-label">Interchangeability </label>
                                <div class="col-sm-4">
                                    <select name="interchange_h" id="e1" required class="form-control" style="width:100px">
                                        <option value="AX">AX</option>
                                        <option value="AY">AY</option>
                                        <option value="AC">AZ</option>
                                        <option value="BX">BX</option>
                                        <option value="BY">BY</option>
                                        <option value="BZ">BZ</option>
                                        <option value="CX">CX</option>
                                        <option value="CY">CY</option>
                                        <option value="CZ">CZ</option>
                                        <option value="DX">DX</option>
                                        <option value="DY">DY</option>
                                        <option value="DZ">DZ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                            <label class="col-sm-2 control-label">Implementing Date <strong style="color:red;">*</strong></label>
                            <div class="col-sm-4">
                                <input  name="implementing_date" id="datepicker3" class="form-control" autocomplete="off"  required type="text" style="width: 125px;text-transform: uppercase;" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-push-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
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
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PROJECT SCHEDULE TABLE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Project Type</th>
                                    <th>Project / ECI Number</th>
                                    <th>Customer</th>
                                    <th>FG Part Name</th>
                                    <th>Model</th>
                                    <th>Interchange</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr id=\"row_activity_$isi->CHR_ID_ECI\">";
                                    echo "<td>$isi->CHR_ID_ECI</td>";
                                    echo "<td>$isi->INT_TYPE</td>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    echo "<td>$isi->CHR_CUSTOMER</td>";
                                    echo "<td>$isi->CHR_FG_PARTNAME</td>";
                                    echo "<td>$isi->CHR_VEHICLE</td>";
                                    echo "<td>$isi->CHR_INTERCHANGE</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . "</td>";
                                    echo "<td>" . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . "</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/eci/schedule_c/prepare_edit_project'). "/" . $isi->CHR_ID_ECI; ?>" class="label label-warning" ><span class="fa fa-pencil"></span></a>
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