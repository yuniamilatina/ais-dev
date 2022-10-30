<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/efila/register_document_c/') ?>">Manage Register Document</a></li>
            <li><a href="#"><strong>Register Document</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php 
            if ($msg != NULL) {
                echo $msg;
            } 
        ?> 
        <?php
        // if (validation_errors()) {
        //     echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        // }
        $attributes = array('id' => 'form_reg');
        echo form_open_multipart('efila/register_document_c/save_register_document', 'class="form-horizontal"', $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REGISTER DOCUMENT</strong> </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <font color="RED">* </font> Indicates required field
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Template</label>
                            <div class="col-sm-5">
                                <a href="<?php echo base_url('assets/Document/Template/template.doc'); ?>" class="btn label label-success"><i class="fa fa-download"></i> Download</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Name<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="CHR_DOCUMENT_NAME" class="form-control" required type="text" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Description<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <textarea class="form-control" name="CHR_DOCUMENT_DESC" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category Name<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <select name="INT_ID_CATEGORY" class="form-control" required="">
                                <?php
                                    foreach ($cat as $key) {
                                        ?>
                                        <option value="<?php echo $key->INT_ID_CATEGORY ?>"><?php echo $key->CHR_CATEGORY_NAME; ?></option>
                                        <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reasons<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <table id="reqSubmission" style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Reasons</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reqSub">
                                        <tr>
                                            <td><input type="text" name="reason_list[]" style="width: 300px" required></td><td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn label label-success" onclick="addReason()" data-placement="left" title="Add Reason"><i class="fa fa-plus"></i> Add Reason</a>   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="uploadFile" id="uploadImage" type="file" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Scope<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="CHR_SCOPE" required type="radio" value="internal"> Internal
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="CHR_SCOPE" required type="radio" value="external"> External
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Effective Date<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="CHR_EFFECTIVE_DATE" id="CHR_EFFECTIVE_DATE" class="form-control" required type="date" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Distribution</label>
                            <div class="col-sm-5">
                                <table id="regDoc" style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="regDocument">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn label label-success" data-toggle="modal" data-target="#modaldept" data-placement="left" title="Add Department"><i class="fa fa-plus"></i> Add Department</a>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Supporting Document</label>
                            <div class="col-sm-5">
                                <table id="regDoc1" style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No Document</th>
                                            <th>Document Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="regDocument1">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn label label-success" data-toggle="modal" data-target="#modaldoc" data-placement="left" title="Add Document"><i class="fa fa-plus"></i> Add Supporting Document</a>  
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('efila/register_document_c', 'Cancel', 'class="btn btn-default"');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                        <?php
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modaldept" tabindex="-1" role="dialog" aria-labelledby="modalLabelDept" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalLabelDept"><strong>DEPARTMENT</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <!-- <div id="all_list_part" style="overflow-y: scroll; max-height: 350px;"> -->
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
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
                                        <td><input type="checkbox" name="check_list<?php echo $i ?>" value="<?php echo $data->INT_ID_DEPT;?>" onclick="$('#chk_list<?php echo $i ?>').click()"></td>
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
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add Department" onclick="setTable(<?php echo ($i-1) ?>)" data-dismiss="modal"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modaldoc" tabindex="-1" role="dialog" aria-labelledby="modalLabelDoc" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog" style="width:1150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title" id="modalLabelDoc"><strong>SUPPORTING DOCUMENT</strong></h4>
                        </div>
                        <div class="modal-body" style="font-size:12px;">
                            <!-- <div id="all_list_part" style="overflow-y: scroll; max-height: 350px;"> -->
                            <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No Document</th>
                                        <th>Document Name</th>
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
                                        <td><input type="checkbox" name="doc<?php echo $i ?>" value="<?php echo $data->INT_ID_DOCUMENT;?>" onclick="$('#doc_list<?php echo $i ?>').click()"></td>
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
                                <button type="submit" class="btn btn-primary" data-placement="left" title="Add Document" onclick="setTable1(<?php echo ($i-1) ?>)" data-dismiss="modal"><i class="fa fa-check"></i> Add to List</button>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var l = 0;
            function addReason(){
               $('#reqSubmission').append('<tr id="back'+l+'"><td><input type="text" name="reason_list[]" style="width: 300px" required></td><td><a href="#" class="label label-danger" onclick="removeRow(\'back'+l+'\')"><span class="fa fa-times"></span></a></td></tr>');
               l++;
            }


            var j = 0;
            function setTable(row){
                var checkedValue = null; 
                var inputElements = document.getElementsByName('chk_list[]');

                var Parent = document.getElementById('regDocument');
                while(Parent.hasChildNodes())
                {
                   Parent.removeChild(Parent.firstChild);
                }
                
                for(var i=0; inputElements[i]; ++i){
                      if(inputElements[i].checked){
                        var mystr = inputElements[i].value;
                        //Then read the values from the array where 0 is the first
                        var myarr = mystr.split(":");

                        var id = myarr[0].trim();
                        var dept = myarr[1].trim();
                        var desc = myarr[2].trim();
                        
                       $('#regDocument').append('<tr id="row'+j+'"><td>'+dept+'<input type="hidden" name="iddept[]" value="'+id+'"></td><td>'+desc+'</td><td><a href="#" class="label label-danger" onclick="removeRow(\'row'+j+'\')"><span class="fa fa-times"></span></a></td></tr>');
                       j++;
                      }
                }
            }

            var k = 0;
            function setTable1(row){
                var checkedValue = null; 
                var inputElements = document.getElementsByName('doc_list[]');

                var Parent = document.getElementById('regDocument1');
                while(Parent.hasChildNodes())
                {
                   Parent.removeChild(Parent.firstChild);
                }
                
                for(var i=0; inputElements[i]; ++i){
                      if(inputElements[i].checked){
                        var mystr = inputElements[i].value;
                        //Then read the values from the array where 0 is the first
                        var myarr = mystr.split(":");

                        var id = myarr[0].trim();
                        var no = myarr[1].trim();
                        var name = myarr[2].trim();
                        
                       $('#regDocument1').append('<tr id="baris'+k+'"><td>'+no+'<input type="hidden" name="iddoc[]" value="'+id+'"></td><td>'+name+'</td><td><a href="#" class="label label-danger" onclick="removeRow(\'baris'+k+'\')"><span class="fa fa-times"></span></a></td></tr>');
                       j++;
                      }
                }
            }
            function removeRow(rowid){
                var row = document.getElementById(rowid);
                row.parentNode.removeChild(row);
            }

            // var maxDate = year + '-' + month + '-' + day;
            // alert(maxDate);
            // $('#CHR_EFFECTIVE_DATE').attr('min', maxDate);
            $(function(){
                var dtToday = new Date();
                
                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();
                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();
                
                var maxDate = year + '-' + month + '-' + day;
                // alert(maxDate);
                $('#CHR_EFFECTIVE_DATE').attr('min', maxDate);
            });
        </script>
        <script type="text/javascript" language="javascript">
            $("#uploadImage").fileinput({
                'showUpload': false
            });
        </script>

    </section>
</aside>

<table style="display:none;">
<!-- <table> -->
    <tbody>
        <?php
            $j = 1;
            foreach ($dept as $value_mb) {
                ?>
                <tr class="row_data">
                    <td style="text-align: center">
                        <input type="checkbox" name="chk_list[]" id="chk_list<?php echo $j ?>" value="<?php echo $value_mb->INT_ID_DEPT.":".$value_mb->CHR_DEPT.":".$value_mb->CHR_DEPT_DESC ?>">      
                    </td>
                    <td style="text-align: center"><?php echo $value_mb->CHR_DEPT ?></td>
                </tr>
                <?php
            $j++;
            }
        ?>
    </tbody>
</table>

<table style="display:none;">
<!-- <table> -->
    <tbody>
        <?php
            $j = 1;
            foreach ($doc as $value_mb) {
                ?>
                <tr class="row_data">
                    <td style="text-align: center">
                        <input type="checkbox" name="doc_list[]" id="doc_list<?php echo $j ?>" value="<?php echo $value_mb->INT_ID_DOCUMENT.":".$value_mb->CHR_NO_DOC.":".$value_mb->CHR_DOCUMENT_NAME ?>">      
                    </td>
                    <td style="text-align: center"><?php echo $value_mb->CHR_DOCUMENT_NAME ?></td>
                </tr>
                <?php
            $j++;
            }
        ?>
    </tbody>
</table>