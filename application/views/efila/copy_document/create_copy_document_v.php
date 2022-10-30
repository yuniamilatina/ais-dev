<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/efila/copy_document_c/') ?>">Manage Copy Document</a></li>
            <li><a href="#"><strong>Copy Document</strong></a></li>
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
        echo form_open_multipart('efila/copy_document_c/save_copy_document', 'class="form-horizontal"', $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>COPY</strong> DOCUMENT</span>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="INT_TYPE" required type="radio" value="1"> Controlled Copy
                                &nbsp;&nbsp;&nbsp;
                                <input name="INT_TYPE" required type="radio" value="0"> Uncontrolled Copy
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Total<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <input name="INT_TOTAL" class="form-control" required type="number" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reasons<font color="red">*</font></label>
                            <div class="col-sm-5">
                                <table id="obsReasons" style="font-size:12px;" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Reasons</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="obsReas">
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
                                    <?php echo anchor('efila/copy_document_c', 'Cancel', 'class="btn btn-default"');
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
            var k = 0;
            function addReason(){
               $('#obsReasons').append('<tr id="baris'+k+'"><td><input type="text" name="reason_list[]" style="width: 300px"></td><td><a href="#" class="label label-danger" onclick="removeRow(\'baris'+k+'\')"><span class="fa fa-times"></span></a></td></tr>');
               k++;
            }

            function removeRow(rowid){
                var row = document.getElementById(rowid);
                row.parentNode.removeChild(row);
            }
        </script>
    </section>
</aside>