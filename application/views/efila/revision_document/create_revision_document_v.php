<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/efila/revision_document_c/') ?>">Manage Revision Document</a></li>
            <li><a href="#"><strong>Revision Document</strong></a></li>
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
        foreach ($doc as $key) {
            $iddoc = $key->INT_ID_DOCUMENT;
            $name = $key->CHR_DOCUMENT_NAME;
            $nodoc = $key->CHR_NO_DOC;
            $rev = $key->INT_REVISION;
        }
        $attributes = array('id' => 'form_sub');
        echo form_open_multipart('efila/revision_document_c/save_revision_document', 'class="form-horizontal"', $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REVISION</strong> DOCUMENT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid-body">
                        <font color="RED">* </font> Indicates required field
                        <div class="form-group">
                            <label class="col-sm-3 control-label">No Document</label>
                            <div class="col-sm-5">
                                <input name="INT_ID_DOCUMENT" class="form-control" required type="hidden" value="<?php echo $iddoc; ?>">
                                <input name="CHR_NO_DOC" class="form-control" required type="text" readonly="true" value="<?php echo $nodoc; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document Name</label>
                            <div class="col-sm-5">
                                <input name="CHR_DOCUMENT_NAME" class="form-control" required type="text" readonly="true" value="<?php echo $name ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Revision</label>
                            <div class="col-sm-5">
                                <input name="INT_REVISION" class="form-control" required type="text" readonly="true" value="<?php echo $rev ?>">
                                <input name="INT_REVISION_NOW" class="form-control" required type="hidden" readonly="true" value="<?php echo ($rev + 1) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Effective Date<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="CHR_EFFECTIVE_DATE" id="CHR_EFFECTIVE_DATE" class="form-control" required type="date" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Document<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="CHR_DOC" id="CHR_DOC" class="form-control" required type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description Of Changes<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <table id="revDescChanges" style="font-size:12px;" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Changes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="revChanges">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn label label-success" onclick="addDesc()" data-placement="left" title="Add Description Of Changes"><i class="fa fa-plus"></i> Add Description Of Changes</a>   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reasons<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <table id="revReasons" style="font-size:12px;" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Reasons</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="revReas">
                                        <td><input type="text" name="reason_list[]" style="width: 300px" required></td><td></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn label label-success" onclick="addReason()" data-placement="left" title="Add Reasons"><i class="fa fa-plus"></i> Add Reasons</a>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('efila/revision_document_c', 'Cancel', 'class="btn btn-default"');
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

        <script>
            var j = 0;
            function addDesc(){
               $('#revDescChanges').append('<tr id="row'+j+'"><td><input type="text" name="desc_list[]" style="width: 300px"></td><td><a href="#" class="label label-danger" onclick="removeRow(\'row'+j+'\')"><span class="fa fa-times"></span></a></td></tr>');
               j++;
            }

            var k = 0;
            function addReason(){
               $('#revReasons').append('<tr id="baris'+k+'"><td><input type="text" name="reason_list[]" style="width: 300px" required></td><td><a href="#" class="label label-danger" onclick="removeRow(\'baris'+k+'\')"><span class="fa fa-times"></span></a></td></tr>');
               j++;
            }

            function removeRow(rowid){
                var row = document.getElementById(rowid);
                row.parentNode.removeChild(row);
            }

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
            $("#CHR_DOC").fileinput({
                'showUpload': false
            });
        </script>

    </section>
</aside>