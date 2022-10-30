<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efila/register_document_c/"') ?>"><span>New Register</span></a></li>
            <li> <a href="#"><strong>Register Document Detail</strong></a></li>
        </ol>
    </section>
    <?php
        $count = 0;
        foreach ($req as $isi) {
            $count++;
        }
    ?>
    <section class="content">
        <?php
        if($msg != NULL){
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REASONS DETAIL</strong> TABLE</span>
                        
                    </div>
                    <div class="grid-body">
                        <table class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($req as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_REASON</td>";
                                    if($count == 1){
                                        echo "<td></td>";
                                    } else {
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/register_document_c/delete_reason') . "/" . $isi->INT_ID_DETAIL . "/" .$regist; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this reason?');"><span class="fa fa-times"></span></a>
                                </td>
                                <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modalreason" data-placement="left" title="Add Reason" class="btn btn-primary">Add</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?php echo anchor('efila/register_document_c', 'Back', 'class="btn btn-default"');?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>DOCUMENT SUPPORT</strong> TABLE</span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Document Name</th>
                                    <th>Document Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($supp as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_NAME</td>";
                                    echo "<td>$isi->CHR_DOCUMENT_DESC</td>";
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/register_document_c/delete_support') . "/" . $isi->INT_ID_DOCUMENT . "/" .$regist; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this supporting document?');"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modalsupp" data-placement="left" title="Add Reason" class="btn btn-primary">Add</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>DOCUMENT DISTRIBUTION</strong> TABLE</span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($dist as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DEPT</td>";
                                    echo "<td>$isi->CHR_DEPT_DESC</td>";
                                ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/efila/register_document_c/delete_dist') . "/" . $isi->INT_ID_DIST . "/" .$regist; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this distribution document?');"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modaldist" data-placement="left" title="Add Reason" class="btn btn-primary">Add</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalreason" tabindex="-1" role="dialog" aria-labelledby="modalLabelReason" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <?php
                        echo form_open('efila/register_document_c/save_reason', 'class = "form-horizontal"');
                        ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalLabelReason"><strong>REASON</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <input type="hidden" name="INT_ID_REGISTER" value="<?php echo $regist; ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Reason<font color="red">*</font></label>
                                <div class="col-sm-5">
                                    <input name="CHR_REASON" class="form-control" required type="text">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Save Reason"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalsupp" tabindex="-1" role="dialog" aria-labelledby="modalLabelMold" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalLabelMold"><strong>DOCUMENT SUPPORT</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No Document</th>
                                        <th>Document Name</th>
                                        <th>Document Desc</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    foreach ($doc as $data) { 
                                    ?>
                                    <tr>
                                        <td><?php echo $data->CHR_NO_DOC; ?></td>
                                        <td><?php echo $data->CHR_DOCUMENT_NAME; ?></td>
                                        <td><?php echo $data->CHR_DOCUMENT_DESC; ?></td>
                                        <td><input type="checkbox" name="check_list<?php echo $i ?>" value="<?php echo $data->INT_ID_DOCUMENT.":".$regist; ?>" onclick="$('#chk_list<?php echo $i ?>').click()"></td>
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
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add Supporting Doc" onclick="saveSupp()"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table style="display: none;">
        <!-- <table> -->
            <tbody>
                <?php
                    $j = 1;
                    foreach ($doc as $value_mb) {
                        ?>
                        <tr class="row_data">
                            <td style="text-align: center">
                                <!-- <input type="checkbox" name="chk_list<?php echo trim($value_mb->PartNo).trim($value_mb->WorkCenter) ?>" id="chk_list<?php echo trim($value_mb->PartNo).trim($data->WorkCenter) ?>" value="<?php echo $value_mb->PartNo.":".$value_mb->BackNo.":".$value_mb->PartName.":".$value_mb->WorkCenter ?>">  -->
                                <input type="checkbox" name="chk_list[]" id="chk_list<?php echo $j ?>" value="<?php echo $value_mb->INT_ID_DOCUMENT.":".$regist; ?>">      
                            </td>
                        </tr>
                        <?php
                    $j++;
                    }
                ?>
            </tbody>
        </table>

        <div class="modal fade" id="modaldist" tabindex="-1" role="dialog" aria-labelledby="modalLabelMold" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalLabelMold"><strong>DISTRIBUTION DOCUMENT</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    foreach ($dept as $data) { 
                                    ?>
                                    <tr>
                                        <td><?php echo $data->CHR_DEPT; ?></td>
                                        <td><?php echo $data->CHR_DEPT_DESC; ?></td>
                                        <td><input type="checkbox" name="dept_list<?php echo $i ?>" value="<?php echo $data->INT_ID_DEPT.":".$regist; ?>" onclick="$('#dpt_list<?php echo $i ?>').click()"></td>
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
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add Distribution Doc" onclick="saveDist()"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table style="display: none;">
        <!-- <table> -->
            <tbody>
                <?php
                    $j = 1;
                    foreach ($dept as $value_mb) {
                        ?>
                        <tr class="row_data">
                            <td style="text-align: center">
                                <!-- <input type="checkbox" name="chk_list<?php echo trim($value_mb->PartNo).trim($value_mb->WorkCenter) ?>" id="chk_list<?php echo trim($value_mb->PartNo).trim($data->WorkCenter) ?>" value="<?php echo $value_mb->PartNo.":".$value_mb->BackNo.":".$value_mb->PartName.":".$value_mb->WorkCenter ?>">  -->
                                <input type="checkbox" name="dpt_list[]" id="dpt_list<?php echo $j ?>" value="<?php echo $value_mb->INT_ID_DEPT.":".$regist; ?>">      
                            </td>
                        </tr>
                        <?php
                    $j++;
                    }
                ?>
            </tbody>
        </table>

    </section>

    <script>
        function saveSupp(){
            var checkedValue = null; 
            var inputElements = document.getElementsByName('chk_list[]');
            for(var i=0; inputElements[i]; ++i){
                if(inputElements[i].checked){
                    var mystr = inputElements[i].value;
                    //Splitting it with : as the separator
                    var myarr = mystr.split(":");
                    //Then read the values from the array where 0 is the first
                    var iddoc = myarr[0];
                    var idreg = myarr[1];

                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "<?php echo site_url('efila/register_document_c/save_support'); ?>",
                        data: "INT_ID_DOCUMENT="+iddoc+" &INT_ID_REGISTER=" + idreg,
                        success: function(data) {
                            console.log(data);
                            var kode = "/" + idreg;
                            var param = "/1";
                            window.location = "<?php echo site_url('efila/register_document_c/detail_edit_register/') ?>" + kode + param;
                        },
                        error: function(data){
                            console.log(data);
                            alert('error');
                        }
                    });
                }
            }
        }

        function saveDist(){
            var checkedValue = null; 
            var inputElements = document.getElementsByName('dpt_list[]');
            for(var i=0; inputElements[i]; ++i){
                if(inputElements[i].checked){
                    var mystr = inputElements[i].value;
                    //Splitting it with : as the separator
                    var myarr = mystr.split(":");
                    //Then read the values from the array where 0 is the first
                    var iddept = myarr[0];
                    var idreg = myarr[1];

                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "<?php echo site_url('efila/register_document_c/save_dist'); ?>",
                        data: "INT_ID_DEPT="+iddept+" &INT_ID_REGISTER=" + idreg,
                        success: function(data) {
                            console.log(data);
                            var kode = "/" + idreg;
                            var param = "/1";
                            window.location = "<?php echo site_url('efila/register_document_c/detail_edit_register/') ?>" + kode + param;
                        },
                        error: function(data){
                            console.log(data);
                            alert('error');
                        }
                    });
                }
            }
        }
    </script>
</aside>


