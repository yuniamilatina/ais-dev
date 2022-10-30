<?php
//var_dump($t_times);
?>
<style type="text/css">
  .vcenter {
    vertical-align: middle !important;
    text-align: center !important;
    width: 7.142%  !important;
  }
</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href=""><strong>Master Work Time</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER </strong>WORK TIME</span>        
                    </div>
                    <div class="grid-body" > 
                    	<div style="width:100%">
                        <form method="POST" action="<?= base_url() ?>index.php/pes/promasdat_c/save_work_time">
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
                            <input name="btn_save" id="simpan" type="submit" value="Save" />
                            </td>
                          </tr>
                        </table> 
                                                     
                        
                        <table id="dataTable" border="1">
                          <tr>
                              <th rowspan="2" style="text-align:center">Time</th>
                              <th colspan="2" style="text-align:center">Shift 1</th>
                              <th colspan="2" style="text-align:center">Shift 1 LS</th>
                              <th style="text-align:center">Shift 2</th>
                              <th style="text-align:center">Shift 3</th>
                              <th style="text-align:center">Shift 3 LS</th>
                              <th colspan="2" style="text-align:center">Non Shift</th>
                              <th colspan="2" style="text-align:center">Non Shift LS</th>
                              <th colspan="2" style="text-align:center">Non Shift Puasa</th>
                          </tr>
                          <tr>                         
                            <th class="vcenter">Sabtu-Kamis</th> 	<!--SHIFT 1-->
                            <th class="vcenter">Jumat</th>		  	<!--SHIFT 1-->
                            <th class="vcenter">Sabtu-Kamis</th> 	<!--SHIFT 1 LS-->
                            <th class="vcenter">Jumat</th>		  	<!--SHIFT 1 LS-->
                            <th class="vcenter">Senin-Minggu</th> 	<!--SHIFT 2-->
                            <th class="vcenter">Senin-Minggu</th> 	<!--SHIFT 3-->
                            <th class="vcenter">Senin-Minggu</th> 	<!--SHIFT 3 LS-->
                            <th class="vcenter">Sabtu-Kamis</th> 	<!--NON SHIFT-->
                            <th class="vcenter">Jumat</th>	  	<!--NON SHIFT-->
                            <th class="vcenter">Sabtu-Kamis</th> 	<!--NON SHIFT LS-->
                            <th class="vcenter">Jumat</th>	  		<!--NON SHIFT LS-->
                            <th class="vcenter">Sabtu-Kamis</th> 	<!--NON SHIFT PUASA-->
                            <th class="vcenter">Jumat</th>	  		<!--NON SHIFT PUASA-->
                          </tr>
        					<?php $i=1;foreach( $t_times as $time):?>
                          <tr>
                            
                            <td >
                            <input type="text" class="form-control" name="CH_TIME[]" readonly="readonly" style="width:100px !important" value="<?php echo $time->CH_TIME;?>" />
                            <input type="hidden" class="form-control" name="TIME[]" readonly="readonly" value="<?php echo $time->TIME;?>" />
                            </td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="SENIN1[]" value="<?php echo $time->SENIN1;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="JUMAT1[]" value="<?php echo $time->JUMAT1;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="LS1SENIN[]" value="<?php echo $time->LS1SENIN;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="LS1JUMAT[]" value="<?php echo $time->LS1JUMAT;?>" /></td>                            
                            <td ><input autocomplete="off"  type="text" class="form-control" name="SHIFT2[]" value="<?php echo $time->SHIFT2;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="SHIFT3[]" value="<?php echo $time->SHIFT3;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="SHIFT3LS[]" value="<?php echo $time->SHIFT3LS;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="NON_SENIN[]" value="<?php echo $time->NON_SENIN;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="NON_JUMAT[]" value="<?php echo $time->NON_JUMAT;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="NON_SENIN_LS[]" value="<?php echo $time->NON_SENIN_LS;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="NON_JUMAT_LS[]" value="<?php echo $time->NON_JUMAT_LS;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="PUASA_SENIN_NON[]" value="<?php echo $time->PUASA_SENIN_NON;?>" /></td>
                            <td ><input autocomplete="off"  type="text" class="form-control" name="PUASA_JUMAT_NON[]" value="<?php echo $time->PUASA_JUMAT_NON;?>" /></td>
                          </tr>
                          <?php $i++;endforeach;?>
                        </table>
                        </form>
                        </div>
                       
                    </div>                                                      
                </div>
            </div>
        

    </section>
</aside>

