
<aside class="right-side">
                <section class="content">
                    <div class="row">
                        <!-- BEGIN BASIC ELEMENTS -->
                        <div class="col-md-12">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-align-left"></i>
                                    <span class="grid-title">Production Entry System For NG ( FG SCRAP )</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <form class="form-horizontal" method="post" action="<?= base_url() ?>index.php/pes/for_ng/insert_fg_scrap" >

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Back Number</label>
                                            <div class="col-sm-5">
                                                <input type="hidden" name="INT_NUMBER" class="form-control" value="<?php echo $data[0]->INT_NUMBER?>" maxlength="4" required readonly="readonly">
                                                <input type="hidden" name="CHR_PV" class="form-control" value="<?php echo $data[0]->CHR_PV?>" maxlength="4" required readonly="readonly">
                                                 <input type="hidden" name="CHR_UOM" class="form-control" value="<?php echo $data[0]->CHR_UOM?>" maxlength="4" required readonly="readonly">
                                                <input type="text" name="CHR_BACK_NO" class="form-control" value="<?php echo $data[0]->CHR_BACK_NO?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Part Number</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_PART_NO" class="form-control" value="<?php echo $data[0]->CHR_PART_NO?>" maxlength="4"  required readonly="readonly">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jenis Reject</label>
                                            <div class="col-sm-5">
                                                <input type="text"  class="form-control" value="<?php echo @$namereject[0]->CHR_REJECT_TYPE?>" maxlength="4"  required readonly="readonly">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">P.Name & Model</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_PART_NAME" class="form-control" value="<?php echo $data[0]->CHR_PART_NAME?>"  required readonly="readonly">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Output Qty/Uom</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="INT_QTY_OK" class="form-control" onkeypress="return hanyaAngka(event, false)"  value="<?php echo $data[0]->INT_QTY_OK?>" maxlength="4" required autocomplete = "off" >
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Storage Location</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_STRONGE_LOCATION" class="form-control" value="WP02" maxlength="4" required readonly="true">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Tanggal</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_DATE" class="form-control" value="<?php echo $data[0]->CHR_DATE?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Work Center</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_WORK_CENTER" class="form-control" value="<?php echo $data[0]->CHR_WORK_CENTER?>" maxlength="4" readonly="readonly" required >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Code Area</label>
                                            <div class="col-sm-5">
                                                <select class="form-control select" data-live-search="true" name='CHR_AREA'>
                                    
                                    <?php

                                    foreach ($getarea as $show) {
                                    ?>
                                    <option><?php echo $show->CHR_AREA ?>, <?php echo $show->CHR_DESC_AREA ?></option> 
                                    <?php
                                    }
                                    ?>
                                </select>
                                            </div>
                                        </div>
                                      

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-5">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END BASIC ELEMENTS -->
                    </div>

   
                </section>
                <!-- END MAIN CONTENT -->
            </aside>
            <!-- END CONTENT -->
            <script language="javascript">
    function hanyaAngka(e, decimal) {
    var key;
    var keychar;
     if (window.event) {
         key = window.event.keyCode;
     } else
     if (e) {
         key = e.which;
     } else return true;
  
    keychar = String.fromCharCode(key);
    if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
        return true;
    } else
    if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else
    if (decimal && (keychar == ".")) {
        return true;
    } else return false;
    }
</script>