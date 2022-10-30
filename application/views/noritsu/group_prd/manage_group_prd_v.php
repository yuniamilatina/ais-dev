<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Group Production</strong></a></li>
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
                        <span class="grid-title"><strong>GROUP PRODUCTION</strong> TABLE</span>
                        <div class="pull-right">
                            <!-- <a href="<?php echo base_url('index.php/noritsu/group_prd_c/create_group_prd/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Group Production" style="height:30px;font-size:13px;width:100px;">Create</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                    <!-- Filter Table -->
                    <?php echo form_open('noritsu/group_prd_c/filter_group_prd', 'class="form-inline"'); ?>
                    <table width="100%" border="0">
                        <tr>
                            <td><label class="control-label">Department</label></td>
                            <td>
                            <select id="CHR_DEPT_FIL" name="CHR_DEPT_FIL" class="form-control" required>
                                <option disabled selected value="0">-- Select Department --</option>
                            <?php
                                foreach ($dept as $key) {
                                    if($key->INT_ID_DEPT == $department) {
                                ?>
                                        <option value="<?php echo $key->INT_ID_DEPT; ?>" selected><?php echo $key->CHR_DEPT_DESC; ?></option>
                                <?php
                                    } else {
                                ?>
                                        <option value="<?php echo $key->INT_ID_DEPT; ?>"><?php echo $key->CHR_DEPT_DESC; ?></option>
                                <?php
                                    }
                                }
                            ?>
                            </select>
                            </td>
                            <td><label class="control-label">Work Center</label></td>
                            <td>
                                <select id="e2" name="CHR_WORK_CENTER_FIL" class="form-control" required style="width: 170px;">
                                    <option disabled selected value="0">-- Select Work Center --</option>
                                <?php
                                    // foreach ($wc as $key) {
                                    //     if(trim($key->CHR_WORK_CENTER) == trim($workcenter)) {
                                    ?>
                                            <!-- <option value="<?php echo $key->CHR_WORK_CENTER; ?>" selected><?php echo $key->CHR_WORK_CENTER; ?></option> -->
                                    <?php
                                        // } else {
                                    ?>
                                            <!-- <option value="<?php echo $key->CHR_WORK_CENTER; ?>"><?php echo $key->CHR_WORK_CENTER; ?></option> -->
                                    <?php        
                                    //     }
                                    // }
                                ?>
                                </select>
                            </td>
                            <td><label class="control-label">Group</label></td>
                            <td>
                                <select class="form-control" name="CHR_GROUP_NO_FIL" required>
                                    <option disabled selected value="0">-- Select Group --</option>
                                    <?php  
                                        for($g = 1; $g <= 3; $g++){
                                            if($groupno == $g) {
                                    ?>
                                            <option value="<?php echo $g ?>" selected>Group<?php echo " ".$g; ?></option>
                                    <?php
                                            } else {
                                            ?>
                                            <option value="<?php echo $g ?>">Group<?php echo " ".$g; ?></option>
                                            <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Set</button>
                                <a href="<?php echo base_url('index.php/noritsu/group_prd_c/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Clear" style="height:30px;font-size:13px;width:100px;">Clear</a>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="CHR_DEPT_FILL" value="<?php echo trim($department) ?>">
                    <input type="hidden" id="CHR_WORK_CENTER_FILL" value="<?php echo trim($workcenter) ?>">
                    <input type="hidden" id="CHR_GROUP_NO_FILL" value="<?php echo $groupno ?>">
                        <?php echo form_close(); ?>
                    <?php  
                    if($filter == 1) {
                        ?>
                        <br>
                        <a href="#" class="btn label label-success" data-toggle="modal" data-target="#modalmp" data-placement="left" title="Add Man Power"><i class="fa fa-plus"></i> Add Man Power</a>
                        <br>
                        <?php
                    }
                    ?>
                    
                        <br>
                        <!-- Isi Table -->
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>Work Center</th>
                                    <th>Group No</th>
                                    <th>NPK</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DEPT_DESC</td>";
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td>Group $isi->CHR_GROUP_NO</td>";
                                    echo "<td>$isi->CHR_NPK</td>";
                                    echo "<td>$isi->CHR_NAME</td>";
                                    ?>
                                <td>
                                    <a data-toggle="modal" data-target="#modaledit<?php echo $isi->INT_ID_GROUP; ?>" data-placement="left" data-toggle="tooltip" title="Edit Group Production" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/noritsu/group_prd_c/delete_group_prd') . "/" . $isi->INT_ID_GROUP; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this group production?');"><span class="fa fa-times"></span></a>

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

                <?php

                foreach ($data as $isi) {
                    ?>
                    <!--EDIT Vacancy-->
                    <div class="modal fade" id="modaledit<?php echo $isi->INT_ID_GROUP; ?>" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h4 class="modal-title" id="modaledit"><strong>Edit Group Production</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php echo form_open('noritsu/group_prd_c/update_group_prd', 'class="form-horizontal"'); ?>

                                        <input name="INT_ID_GROUP" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_ID_GROUP ?>">
                            
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Department</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="CHR_DEPT">
                                                    <?php
                                                    foreach ($dept as $key) {
                                                        if ($key->INT_ID_DEPT == $isi->INT_ID_DEPT) {
                                                        ?>
                                                            <option value="<?php echo $key->INT_ID_DEPT; ?>" selected><?php echo $key->CHR_DEPT_DESC ?></option>
                                                        <?php
                                                        } else {
                                                    ?>
                                                        <option value="<?php echo $key->INT_ID_DEPT; ?>"><?php echo $key->CHR_DEPT_DESC ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Work Center</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="CHR_WORK_CENTER">
                                                    <?php
                                                    foreach ($wc as $key) {
                                                        if ($key->CHR_WORK_CENTER == $isi->CHR_WORK_CENTER) {
                                                        ?>
                                                            <option value="<?php echo $key->CHR_WORK_CENTER; ?>" selected><?php echo $key->CHR_WORK_CENTER ?></option>
                                                        <?php
                                                        } else {
                                                    ?>
                                                        <option value="<?php echo $key->CHR_WORK_CENTER; ?>"><?php echo $key->CHR_WORK_CENTER ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Group</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="CHR_GROUP_NO">
                                                    <?php  
                                                        for($g = 1; $g <= 3; $g++){
                                                            if($g == $isi->CHR_GROUP_NO) {
                                                    ?>
                                                            <option value="<?php echo $g ?>" selected>Group<?php echo " ".$g; ?></option>
                                                    <?php
                                                            } else {
                                                            ?>
                                                            <option value="<?php echo $g ?>">Group<?php echo " ".$g; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
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
                    <?php
                    $i++;
                }
                ?>
                <?php if($filter == 1) { ?>
                <div class="modal fade" id="modalmp" tabindex="-1" role="dialog" aria-labelledby="modalLabelMp" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog" style="width:1150px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                    <h4 class="modal-title" id="modalLabelMp"><strong>MAN POWER</strong></h4>
                                </div>
                                <div class="modal-body" style="font-size:12px;">
                                    <!-- <div id="all_list_part" style="overflow-y: scroll; max-height: 350px;"> -->
                                    <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NPK</th>
                                                <th>Nama</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            foreach ($mp as $data) { 
                                            ?>
                                            <tr>
                                                <td><?php echo $data->NPK; ?></td>
                                                <td><?php echo $data->NAMA; ?></td>
                                                <td><input type="checkbox" name="check_list<?php echo $i ?>" value="<?php echo $data->NPK.":".$data->NAMA ?>" onclick="$('#chk_list<?php echo $i ?>').click()"></td>
                                            </tr>
                                            <?php 
                                            $i++;
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" title="Add Man Power" onclick="saveMp()" data-dismiss="modal"><i class="fa fa-check"></i> Add to List</button>
                                        <?php
                                        echo form_close();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table style="display:none;">
                <!-- <table> -->
                    <tbody>
                        <?php
                            $j = 1;
                            foreach ($mp as $value_mb) {
                                ?>
                                <tr class="row_data">
                                    <td style="text-align: center">
                                        <input type="checkbox" name="chk_list[]" id="chk_list<?php echo $j ?>" value="<?php echo $value_mb->NPK.":".$value_mb->NAMA ?>">      
                                    </td>
                                    <td style="text-align: center"><?php echo $value_mb->NPK ?></td>
                                </tr>
                                <?php
                            $j++;
                            }
                        ?>
                    </tbody>
                </table>
                <?php } ?>

            </div>
        </div>

        <script>
            function saveMp(){
                var checkedValue = null; 
                var inputElements = document.getElementsByName('chk_list[]');
                var department = document.getElementById('CHR_DEPT_FILL');
                var workcenter = document.getElementById('CHR_WORK_CENTER_FILL');
                var groupno = document.getElementById('CHR_GROUP_NO_FILL');
                var dept = department.value;
                var wc = workcenter.value;
                var no = groupno.value;
                for(var i=0; inputElements[i]; ++i){
                    if(inputElements[i].checked){
                        var mystr = inputElements[i].value;
                        var myarr = mystr.split(":");
                        var NPK = myarr[0].trim();
                        var NAMA = myarr[1].trim();

                        $.ajax({
                            async: false,
                            type: "POST",
                            url: "<?php echo site_url('noritsu/group_prd_c/save_mp'); ?>",
                            data: "CHR_NPK=" + NPK + "&CHR_NAMA=" + NAMA + "&INT_ID_DEPT=" + dept + "&CHR_GROUP_NO=" + no + "&CHR_WORK_CENTER=" + wc,
                            success: function(data) {
                                console.log(data);
                                window.location = "<?php echo site_url('noritsu/group_prd_c/filter_group_prd') ?>/"+dept+"/"+wc+"/"+no+"/1";
                            },
                            error: function(data){
                                console.log(data);
                                alert("CHR_NPK=" + NPK + "&CHR_NAMA=" + NAMA + "&INT_ID_DEPT=" + dept + "&CHR_GROUP_NO=" + no + "&CHR_WORK_CENTER=" + wc);
                            }
                        });
                    }
                }
            }
        </script>
        <script>
            $(document).ready(function () {
                $("#CHR_DEPT_FIL").click(function () {
                    var val = $(this).val();
                    if (val == 21) {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "1"){ if(trim($key->CHR_WORK_CENTER) == trim($workcenter)) {?><option value='<?php echo $key->CHR_WORK_CENTER ?>' selected><?php echo $key->CHR_WORK_CENTER ?></option><?php } else { ?> <option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option> <?php } } } ?>");
                    } else if (val == 22) {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "2"){ if(trim($key->CHR_WORK_CENTER) == trim($workcenter)) {?><option value='<?php echo $key->CHR_WORK_CENTER ?>' selected><?php echo $key->CHR_WORK_CENTER ?></option><?php } else { ?> <option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option> <?php } } } ?>");
                    } else if (val == 23) {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "3"){ if(trim($key->CHR_WORK_CENTER) == trim($workcenter)) {?><option value='<?php echo $key->CHR_WORK_CENTER ?>' selected><?php echo $key->CHR_WORK_CENTER ?></option><?php } else { ?> <option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option> <?php } } } ?>");
                    } else if (val == 24) {
                        $("#e2").html("<?php foreach($wc as $key){ if($key->Prd == "4"){ if(trim($key->CHR_WORK_CENTER) == trim($workcenter)) {?><option value='<?php echo $key->CHR_WORK_CENTER ?>' selected><?php echo $key->CHR_WORK_CENTER ?></option><?php } else { ?> <option value='<?php echo $key->CHR_WORK_CENTER ?>'><?php echo $key->CHR_WORK_CENTER ?></option> <?php } } } ?>");
                    } 
                });
            });
        </script>

    </section>
</aside>


