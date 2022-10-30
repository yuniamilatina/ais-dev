<aside class="right-side">
     <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/for_ng/'); ?>">Component Repair</a></li>
        </ol>
    </section>
<?php 
$session  = $this->session->userdata('start');
?>
                <section class="content">
                    <div class="row">
                        <!-- BEGIN BASIC ELEMENTS -->
                        <div class="col-md-12">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-align-left"></i>
                                    <span class="grid-title">Production Entry System For NG ( Component Scrap )</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <form class="form-horizontal" method="post" action="<?= site_url('/pes/for_ng/component_scrap/'.$id)?>" >
                                        <div class="form-group">
                                            <div class="col-sm-offset-1">
                                                 <?if (!isset($xxx)):?>
                                                <div class="btn-group">
                                                     
                                                    <button type="submit" name="start" class="btn btn-primary">Start </button>
                                                </div>
                                                  <?php endif;?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Back Number</label>
                                            <div class="col-sm-5">
                                                <input type="hidden" name="INT_NUMBER" class="form-control" value="<?php echo $data->INT_NUMBER?>" maxlength="4" required readonly="readonly">
                                                <input type="hidden" name="CHR_SHIFT" class="form-control" value="<?php echo $data->CHR_SHIFT?>" maxlength="4" required readonly="readonly">
                                                <input type="hidden" name="CHR_WORK_DAY" class="form-control" value="<?php echo $data->CHR_WORK_DAY?>" maxlength="4" required readonly="readonly">
                                                <input type="hidden" name="CHR_WORK_TIME_START" class="form-control" value="<?php echo $data->CHR_WORK_TIME_START?>" maxlength="4" required readonly="readonly">
                                                <input type="hidden" name="CHR_PV" class="form-control" value="<?php echo $data->CHR_PV?>" maxlength="4" required readonly="readonly">
                                                <input type="hidden" name="CHR_WO_NUMBER" class="form-control" value="<?php echo $data->CHR_WO_NUMBER?>" maxlength="4" required readonly="readonly">
                                                <input type="text" name="CHR_BACK_NO" class="form-control" value="<?php echo $data->CHR_BACK_NO?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Part Number</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_PART_NO" class="form-control" value="<?php echo $data->CHR_PART_NO?>" maxlength="4"  required readonly="readonly">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">P.Name & Model</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_PART_NAME" class="form-control" value="<?php echo $data->CHR_PART_NAME?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
                                        <?if (!isset($xxx)):?>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Output Qty/Uom</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="INT_QTY_OK" onkeypress="return hanyaAngka(event, false)" class="form-control" value="<?php echo @$totalng?>" maxlength="4" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Output Qty/Uom</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="INT_QTY_OK" onkeypress="return hanyaAngka(event, false)" class="form-control" value="<?php echo @$session['INT_QTY_OK']?>" maxlength="4" autocomplete="off" readonly required>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                   <div class="col-md-6">
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Storage Location</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_STRONGE_LOCATION" class="form-control" value="WP02" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Tanggal</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_DATE" class="form-control" value="<?php echo $data->CHR_DATE?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Work Center</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_WORK_CENTER" class="form-control" value="<?php echo $data->CHR_WORK_CENTER?>" maxlength="4" readonly="readonly" required >
                                            </div>
                                        </div>
                                         <?if (!isset($xxx)):?>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Code Area</label>
                                            <div class="col-sm-5">
                                                <select class="form-control select" data-live-search="true" name='CHR_AREA' >
                                    
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

                                        <?php else: ?>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Work Center</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" value="<?php echo $chrarea['chrarea'];?>" maxlength="4" readonly="readonly" required >
                                            </div>
                                        </div>
                                     <?php endif; ?>
                                    </div>
                                </form>
								
								</div>
                                   <?if (!isset($view)):?>
                           <form class="form-horizontal" method="post"  action="<?= site_url('/pes/for_ng/component_scrap/'.$id.'/save')?>" >
                             <div class="grid-body">                   
                                    <!--table id="dataTables1" class="table table-hover display" cellspacing="0" width="100%"         revisi rudi data table error-->
									<table class="table table-hover display" cellspacing="0" width="100%">
                                        <thead>
                                         
                                            <tr>
                                                <th>No</th>
                                                <th>Component Part NO</th>
                                                <th>Description</th>
                                                <th>Qty /PC</th>
                                                <th>QTY</th>
                                                <th>Uom</th>
                                                <th>Oke</th>
                                                <th>Repair</th>
                                                <th>NG</th>
                                                <th>Area</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                          <?php   
                                           foreach ($table as $show) {
                                           ?>
                                            <tr>

                                            <?php  ?>

                                                <td><input  class="form-control" maxlength="4"  type="text" name="no[]" value="<?php echo $show['no']; ?>" readonly  style="width: 50px;" readonly required></td>
                                                <td><input type="text" name="IDNRK[]" value="<?php echo $show['IDNRK']; ?>" class="form-control" maxlength="4" required class="form-control" readonly></td>
                                                <td><input type="text" name="OJTXP[]" value="<?php echo $show['OJTXP']; ?>" style="width: 300px;" readonly class="form-control" maxlength="4" required> </td>
                                                <td><input type="text" name="MENGE[]" value="<?php echo $show['MENGE'];?>" style="width: 75px;" readonly class="form-control" maxlength="4" required></td>
                                                <td><input type="text" name="qty[]" value="<?php echo $show['qty']; ?>" style="width: 75px;" readonly class="form-control" maxlength="4" required></td>
                                                <td><input type="text" name="MMEIN[]" value="<?php echo $show['MMEIN'];?>" style="width: 50px;" readonly class="form-control" maxlength="4" required ></td>
                                                
                                                <td><input type="text" name="oke[]" value="<?php echo $show['qty']; ?>" style="width: 60px;" autocomplete="off"  ></td>
                                                <td><input type="text" name="repair[]"  style="width: 60px;" autocomplete="off"> </td>
                                                <td><input type="text" name="NG[]"  style="width: 60px;" autocomplete="off"> </td>
                                                <td><input type="text" name="sloc[]"  style="width: 80px;" value="<?php echo $show['chrarea'];?>"readonly class="form-control" maxlength="4" required></td>
                                                <td><input type="hidden" name="id" value="<?php echo $id;?>" readonly></td>
                                            
                                            </tr>
                                           <?php }?>

                                        </tbody>
                                    </table>
                                                <div class="form-group">
                                                        <div class="col-sm-offset-1">
                                                            <div class="btn-group">
                                                                <h4 style="color: red;padding-bottom: 30px;"><?php echo @$error;?></h4>
                                                                <button type="submit" name="save" class="btn btn-primary">Save</button>
                                                            </div>
                                                           
                                                        </div>
                                                </div>
                            </div>
                        </form>
                           <form class="form-horizontal" method="post" action="<?= site_url('/pes/for_ng/component_scrap/'.$id.'/print_awal')?>" >
                             <div class="btn-group">
                                <?php 
                                foreach ($table as $hidden) {
                                      ?>
                                        <td><input type="hidden" name="IDNRK[]" value="<?php echo $hidden['IDNRK']; ?>"></td> 
                                        <td><input type="hidden" name="OJTXP[]" value="<?php echo $hidden['OJTXP']; ?>"></td>
                                        <td><input type="hidden" name="MENGE[]" value="<?php echo $hidden['MENGE'];?>"></td>
                                        <td><input type="hidden" name="qty[]" value="<?php echo $hidden['qty']; ?>"></td>
                                        <td><input type="hidden" name="MMEIN[]" value="<?php echo $hidden['MMEIN'];?>"></td>
                                        <td><input type='hidden' name='sloc[]' value=" <?php echo @$hidden['chrarea']; ?>"></td>
                                      <input name="print_awal" type="submit" value="print" class="btn btn-primary"  style="margin-top: -79px; margin-left: 42px;">
                                   <?php } ?> 
                              </div>
                           </form>

                                
                                <?php else: ?>
                                <form class="form-horizontal"method="post"action="<?= site_url('/pes/for_ng/component_scrap/'.$id.'/print')?>">
                                  <div class="grid-body">  
                                             

                                        <!--table id="dataTables1" class="table table-hover display" cellspacing="0" width="100%"    revisi rudi data table error-->
										<table  class="table table-hover display" cellspacing="0" width="100%"  >
                                        <thead>
                                          <tr>
                                                <th>No</th>
                                                <th>Component Part NO</th>
                                                <th>Description</th>
                                                <th>Qty /PC</th>
                                                <th>QTY</th>
                                                <th>Uomm</th>
                                                <th>Oke</th>
                                                <th>Repair</th>
                                                <th>NG</th>
                                                <th>Area</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                          <?php 
                                           foreach 
                                            ($view as $show) {
                                           ?>
                                            <tr>
                                                <td><input type="text" name="no[]" value="<?php echo $show['no']; ?>" readonly  style="width: 30px;" ></input></td>
                                                <td><input type="text" name="IDNRK[]" value="<?php echo $show['IDNRK']; ?>" readonly=""></input></td>
                                                <td><input type="text" name="OJTXP[]" value="<?php echo $show['OJTXP']; ?>" style="width: 300px;" readonly></input></td>
                                                <td><input type="text" name="MENGE[]" value="<?php echo $show['MENGE'];?>" style="width: 50px;" readonly></input></td>
                                                <td><input type="tex" name="qty[]" value="<?php echo $show['qty']; ?>" style="width: 50px;" readonly></input></td> 
                                                <td><input type="text" name="MMEIN[]" value="<?php echo $show['MMEIN'];?>"style="width: 50px;" readonly="readonly"></td>
                                                <td><input type="text" name="oke[]" value="<?php echo $show['oke'];?>"  style="width: 60px;" ></input></td>
                                                <td><input type="text" name="repair[]" value="<?php echo $show['repair'];?>" style="width: 60px;"> </td>
                                                <td><input type="text" name="NG[]" value="<?php echo $show['NG'];?>"  style="width: 60px;"> </td>
                                            <td><input type="text" name="sloc[]" value="<?php echo $show['sloc'];?>" style="width: 60px;"></td>
                                                <td><input type="hidden" name="id" value="<?php echo $id;?>"></td>
                                              <input type="hidden" id="refreshed" value="no">
                                            </tr>
                                           <?php }?>

                                        </tbody>
                                    </table>    
                                     <div class="col-sm-offset-1">
                                                <div class="btn-group">
                                                    <input name="print" type="submit" value="print" class="btn btn-primary">
                                                </div>
                                            </div>
                                </div>
                                </form>
                                <?php endif;?>
								
								
                            </div>
                        </div>
                        <!-- END BASIC ELEMENTS -->
                    </div>

                </section>
                <!-- END MAIN CONTENT -->
</aside>
            <!-- END CONTENT -->


<script type="text/javascript">
    onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
    else{e.value="no";location="<?php base_url('/pes/for_ng');?>";}
    }
</script>

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