<style type="text/css">
  .vcenter {
    vertical-align: middle !important;
    text-align: center !important;
    white-space: nowrap !important;
  }

  .vleft{
    vertical-align: middle !important;
    text-align: left !important;
    white-space: nowrap !important;
  }

  .vright{
    vertical-align: middle !important;
    text-align: right !important;
    white-space: nowrap !important;
    font-weight:bold;
  }

  .input-change{
    text-align: right;
    height: 26px !important;
    padding: 4px;
    font-weight:bold;
  }

  .app-check{
    height: 15px !important;
  }

  #suggesstion{
    margin: 2px auto;
    position:absolute; 
    width: 89%;
  }

  .item-list{list-style:none;margin:0;padding: 0;}
  .item-list li{padding: 10px; text-align: left; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
  .item-list li:hover{background:#DDD;}
  .autocomplete{
    padding: 10px;
    margin: 0 auto;
    display:block; 
    width: 47%;
    font-size: 1em;
    border: #000 1px solid;
  }
  .more{
    text-align: left;font-weight: bold; width: 100%; padding: 5px;
    background:#FAFAFA;
    border-bottom:#F0F0F0 1px solid;
  }
</style>
<script type="text/javascript">
  function hideng(ng){
    var colspan = $('.qty-ng-th').attr('colspan');
    $('.qty-ng-th').attr('colspan',parseInt(colspan) - 1);
    $('.tbl-'+ng).hide();
  }

  function hidels(ls){
    var colspan = $('.ls-th').attr('colspan');
    $('.ls-th').attr('colspan',parseInt(colspan) - 1);
    $('.tbl-'+ls).hide();
  }

</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Approval Production Execution</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <?php 
          $set = $this->uri->segment(4,1);
          $seturi = base_url()."index.php/pes/approval_c/index/".($set == 0 ? 1 : 0);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid" > <!-- style="background-color: #94D1DC" -->
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">APPROVAL PRODUCTION EXECUTION</span>
                    </div>
                    <div class="grid-body" style="min-height: 330px;">
                    <?php 
                    $s = $this->session->flashdata('message');
                    if($s){?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo $s?>
                    </div>
                    <?php } ?>

                    <form class="form-horizontal" role="form" method="get" action="<?php echo base_url()?>index.php/pes/approval_c/index/<?php echo $set?>">
                      <div class="form-group">  
                        <label class="col-sm-1 control-label">Tanggal</label>
                        <div class="col-sm-2">
                          <?php if(!$wo){
                            echo '<input type="text" name="date" disabled="true" class="form-control">';
                          } else {
                              if($approval->num_rows() > 0){
                                $d = trim($approval->row()->CHR_DATE);
                                if(strlen($d) == 8){
                                  
                                  echo '<input type="text" name="date" disabled="true" class="form-control" value="'.substr($d,6,2).'-'.substr($d,4,2).'-'.substr($d,0,4).'">';
                                }
                              } else {
                                echo '<input type="text" name="date" disabled="true" class="form-control">';
                              }
                          }?>
                        </div>

                        <label class="col-sm-4 control-label">Work Order Number</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="wo" id="input-wo" autocomplete="off" value="<?php echo $wo?>" />
                          <div id="suggesstion"></div>
                        </div>

                        <div class="col-sm-2">
                          <input type="submit" value="GO" class="btn btn-default pull-left">
                        </div>
                      </div>
                      </form>
                     
                      <?php if($wo){?>
                      <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url()?>index.php/pes/approval_c/update">
                      <input type="hidden" name="wokrorder" value="<?php echo $wo?>" />
                      <div class="form-group"> 
                      <div class="col-sm-3">&nbsp;</div>
                      <label class="col-sm-4 control-label">Status Close WO</label>
                      <div class="col-sm-3">
                          <input type="checkbox" name="statuswo" value="X" style="margin-top:12px;transform: scale(1.4);">
                      </div>
                      </div>
                      <input type="submit" value="Execute" class="btn btn-default pull-left">
                      <div style="width: 100%; clear: both; height: 2px;"></div>
                      <div style="overflow-x:scroll; overflow-y: hidden;">
                      <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th rowspan="2" class="vcenter">No</th>
                              <th rowspan="2" class="vcenter">Jam</th>
                              <th rowspan="2" class="vcenter">Work Center</th>
                              <th rowspan="2" class="vcenter">Back No.</th>
                              <th rowspan="2" class="vcenter">Part No.</th>
                              <th rowspan="2" class="vcenter">Part Name & Model</th>
                              <th rowspan="2" class="vcenter">Qty OK</th>
                              <?php 
                                if($tmng->num_rows() > 0){
                                  echo '<th colspan="'.($tmng->num_rows() + 1).'" class="vcenter qty-ng-th">Qty NG</th>';
                                }
                              ?>
                              <th rowspan="2" class="vcenter">Total<br />Qty Produksi</th>
                              <?php 
                                if($line_stop->num_rows() > 0){
                                  echo '<th colspan="'.($line_stop->num_rows() + 1).'" class="vcenter ls-th">Line Stop</th>';
                                }
                              ?>
                              <th rowspan="2" class="vcenter">Jml MP</th>
                              <th rowspan="2" class="vcenter">Chokotei</th>
                              <th rowspan="2" class="vcenter">Target/Jam</th>
                              <th rowspan="2" class="vcenter">Actual/Jam</th>
                              <th rowspan="2" class="vcenter">Percentage</th>
                              <th rowspan="2" class="vcenter">Approve</th>
                            </tr>
                            <tr>
                              <!-- TM NG -->
                              <?php 
                                if($tmng->num_rows() > 0){
                                  foreach ($tmng->result() as $ng) {
                                    echo '<th class="vcenter tbl-'.$ng->CHR_NG_CATEGORY_CODE.'">'.$ng->CHR_NG_CATEGORY.'</th>';
                                    $showng[$ng->CHR_NG_CATEGORY_CODE] = false;
                                  }
                                  echo '<th class="vcenter">Total</th>';
                                }
                              ?>
                              <!-- ./TM NG -->
                              <!-- TM LINE STOP -->
                              <?php 
                                if($line_stop->num_rows() > 0){
                                  foreach ($line_stop->result() as $ls) {
                                    echo '<th class="vcenter tbl-'.$ls->CHR_LINE_CODE.'">'.$ls->CHR_LINE_STOP.'</th>';
                                    $showls[$ls->CHR_LINE_CODE] = false;            
                                  }
                                  echo '<th class="vcenter">Total</th>';
                                }
                              ?>
                              <!-- ./TM LINE STOP -->
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $n = 1;
                              $lastime = "";
                              $getIntLS = array();
                              $getIntCT = array();
                              $getIntLSTotal = array();
                              $wt = "";
                              $PRS = "";
                              $ct ="";
                              $lasintnum = "";
                              $lastdate = "";
                              $lasttimestart = "";
                              $lastsift = "";
                              $lastworkday = "";
                              $lastwc = "";
                              $showck = array();
                              $showtarget = array();
                              $showactual = array();
                              $qtyok = array();
                              $total_produksi = array();
                              $total_mp = array();
                              $commonarr = array();
                              if($approval->num_rows() > 0){
                                foreach ($approval->result() as $ap) {
                                  $process = $this->db->get_where('TM_PROCESS', array('CHR_WORK_CENTER'=>$ap->CHR_WORK_CENTER));
                                  $responsible = '';
                                  if($process->num_rows() > 0){
                                      $responsible = trim($process->row()->CHR_PERSON_RESPONSIBLE);
                                  }

                                  echo "<input type='hidden' name='RESPONSIBLE[]' value='".$responsible."' />";
                                  echo "<input type='hidden' name='INT_NUMBER[]' value='".$ap->INT_NUMBER."' />";
                                  echo "<input type='hidden' name='CHR_WO_NUMBER[]' value='".trim($ap->CHR_WO_NUMBER)."' />";
                                  echo "<input type='hidden' name='VALIDATE[]' value='".trim($ap->CHR_VALIDATE)."' />";
                                  echo "<input type='hidden' name='chr_plant[]' value='".trim($ap->CHR_PLANT)."' />";
                                  echo "<input type='hidden' name='chr_date[]' value='".trim($ap->CHR_DATE)."' />";
                                  echo "<input type='hidden' name='CHR_WORK_TIME_START[]' value='".trim($ap->CHR_WORK_TIME_START)."' />";
                                  echo "<input type='hidden' name='CHR_SHIFT[]' value='".trim($ap->CHR_SHIFT)."' />";
                                  echo "<input type='hidden' name='CHR_WORK_DAY[]' value='".trim($ap->CHR_WORK_DAY)."' />";
                                  echo "<input type='hidden' name='chr_part_no[]' value='".trim($ap->CHR_PART_NO)."' />";
                                  echo "<input type='hidden' name='CHR_WORK_CENTER[]' value='".trim($ap->CHR_WORK_CENTER)."' />";

                                  @$persen = $ap->INT_ACTUAL/$ap->INT_TARGET*100;
                                  if($persen<95) $danger = true;
                                  
                                  $time = trim($ap->CHR_WORK_TIME_START).trim($ap->CHR_WORK_TIME_END);
                                  $totprod = $time . trim($ap->CHR_PART_NO);
                                  $totmp = "MP-".$totprod;
                                  $ngpart = "NG-".$time.trim($ap->CHR_PART_NO);
                                  $lspart = "LS-".$time.trim($ap->CHR_PART_NO);
                                  array_key_exists($time, $qtyok)?$qtyok[$time]+=$ap->INT_QTY_OK:$qtyok[$time] = $ap->INT_QTY_OK;
                                  array_key_exists($time, $total_produksi)?$total_produksi[$time]+=$ap->INT_TOTAL_QTY:$total_produksi[$time] = $ap->INT_TOTAL_QTY;
                                  if(array_key_exists($time, $total_mp)){
                                      $total_mp[$time] < $ap->INT_MP ? $total_mp[$time]=$ap->INT_MP:"";
                                  } else{
                                      $total_mp[$time] = $ap->INT_MP;
                                  }

                                  if(!array_key_exists($time, $showck)) $showck[$time] = false;
                                  if(!array_key_exists($time, $showtarget)) $showtarget[$time] = false;
                                  if(!array_key_exists($time, $showactual)) $showactual[$time] = false;

                                  //FOR CALCULATE CHOKOTEI

                                  if($lasintnum == ""){
                                    $lastdate = trim($ap->CHR_DATE);
                                    $lasttimestart = trim($ap->CHR_WORK_TIME_START);
                                    $lastsift = trim($ap->CHR_SHIFT);
                                    $lastworkday = trim($ap->CHR_WORK_DAY);
                                    $lastwc = trim($ap->CHR_WORK_CENTER);
                                  }

                                  $lasintnum = $ap->INT_NUMBER;

                                  $pls = $this->approval_m->getIntLS($lasintnum); 
                                  $cls = $this->approval_m->geCountLS($lasintnum);

                                  if(array_key_exists($time, $getIntLS)){
                                      $getIntLS[$time] += $pls->row()->INT_MENIT;
                                      $getIntLSTotal[$time] += $cls->row()->INT_TOTAL_LINE_STOP;
                                  } else{
                                      $getIntLS[$time] = $pls->row()->INT_MENIT;
                                      $getIntLSTotal[$time] = $cls->row()->INT_TOTAL_LINE_STOP;                                    
                                  }
								                  //echo ($pls->row()->INT_MENIT);
                                  if ($lastime AND $lastime!=$time){
                                    $PRS = $this->db->get_where('TT_PRODUCTION_RESULT', array('INT_NUMBER'=>$lasintnum))->row();
                                    $WORK_TIME['CHR_WORK_SHIFT'] = $lastsift;
                                    $WORK_TIME['CHR_WORK_DAY'] = $lastworkday;
                                    $WORK_TIME['CHR_WORK_TIME_START'] = $lasttimestart;

                                    $wt = $this->db->get_where('TM_WORK_TIME',$WORK_TIME);

                                    $ct = $this->approval_m->getIntCT($lastwc);
									                   if ($ct->row()->INT_CT==NULL) {
                                       echo '<script>alert("Cek data cycle time di Target Produksi!");</script>';
                                      redirect('pes/approval_c/', 'refresh');
                                     }else{
									                  $qtyph = ( 3600/$ct->row()->INT_CT) *$PRS->INT_MP;
                                    }
                                    @$tperj = floor((($wt->row()->INT_WORK_HOUR - $getIntLS[$lastime])/60) * $qtyph);
                                    $actual = $this->approval_m->getActual($lasttimestart,$lastdate,$lastwc);
                  									$chk = (($tperj * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime] - ((($total_produksi[$lastime] * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime]);
                  									
                                    $danger = false;
                                    @$persen = $actual->row()->INT_TOTAL_QTY/$tperj * 100;
                  									if($persen < 95) $danger = true;
                                    ?>
                                    <tr <?php if($danger) echo "style='background-color:#F00';"?>>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="qty-ok-<?php echo $lastime?>"><?php echo $qtyok[$lastime]?></span></td>
                                    <!-- TM NG -->
                                    <?php 
                                      if($tmng->num_rows() > 0){
                                        foreach ($tmng->result() as $ng) {
                                          $tcm = '';
                                          if($commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime] > 0) $tcm = $commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime];
                                          echo '<td '.($danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"').' class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'"><span id="'.$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime.'">'.$tcm.'</span></td>';
                                        }
                                      }
                                    ?>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="NG-<?php echo $lastime?>"><?php echo $commonarr['NG-'.$lastime]?></span></td>
                                    <!-- ./TM NG -->

                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="total-produksi-<?php echo $lastime?>"><?php echo $total_produksi[$lastime]?></span></td>
                                    
                                    <!-- TM LINE STOP -->
                                    <?php 
                                      if($line_stop->num_rows() > 0){
                                        foreach ($line_stop->result() as $ls) {
                                          $tcm = '';
                                          if($commonarr[$ls->CHR_LINE_CODE.'-'.$lastime] > 0) $tcm = $commonarr[$ls->CHR_LINE_CODE.'-'.$lastime];
                                          echo '<td '.($danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"').' class="vright  tbl-'.$ls->CHR_LINE_CODE.'"><span id="'.trim($ls->CHR_LINE_CODE).'-'.$lastime.'">'.$tcm.'</span></td>';
                                        }
                                      }
                                    ?>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="LS-<?php echo $lastime?>"><?php echo $commonarr['LS-'.$lastime]?></span></td>
                                    <!-- ./TM LINE STOP -->
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="mp-<?php echo $lastime?>"><?php echo $total_mp[$lastime]?></span></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo $showck[$lastime] == true? round($chk) : 0?></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo $showtarget[$lastime] == true? $tperj : 0?></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo  $showactual[$lastime] == true? $actual->row()->INT_TOTAL_QTY : 0?></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo round($persen)?></td>
                                    <td class="vcenter">&nbsp;</td>
                                    </tr>
                              <?php } ?>
                              
                              <!-- MAIN -->
                              <tr>
                              <td class="vcenter" ><?php echo $n?></td>
                              <td class="vcenter" >
                              <?php 
                              $readonly = "";
                              if(trim($ap->CHR_VALIDATE)=='X'){
                                $readonly = 'readonly="readonly"';
                              }
                              if($lastime!=$time) {
                                echo substr_replace(trim($ap->CHR_WORK_TIME_START),":",2,0)."-".substr_replace(trim($ap->CHR_WORK_TIME_END),":",2,0);
                              } else echo '&nbsp;';
                              ?>
                              </td>
                              <td class="vcenter" ><?php 
                              if($lastime!=$time) { echo trim($ap->CHR_WORK_CENTER); } else echo '&nbsp;';?></td>
                              <td class="vcenter" ><?php echo trim($ap->CHR_BACK_NO)?></td>
                              <td class="vcenter" ><?php echo trim($ap->CHR_PART_NO)?></td>
                              <td class="vleft" ><?php echo trim($ap->CHR_PART_NAME)?></td>
                              <td class="vright" >
                                <input type="text" <?php echo $readonly;?> name='qty-ok[]' class="form-control input-change" time="<?php echo $time?>" totprod="<?php echo $totprod?>" tag="qty-ok-<?php echo $time?>" value="<?php echo $ap->INT_QTY_OK?>">
                              </td>

                              <!-- TM NG -->
                              <?php 
                                if($tmng->num_rows() > 0){
                                  foreach ($tmng->result() as $ng) {
                                    $text = 'text';
                                    $val = 0;
                                    $int_num_ng=0;

                                    $v = $this->approval_m->getValueNGRepair($ap->INT_NUMBER,$ng->CHR_NG_CATEGORY_CODE,$responsible);
                                    if($v->num_rows() > 0){
                                      $val = $v->row()->INT_TOTAL_QTY_NG;
                                      $int_num_ng = $v->row()->INT_NUMBER_NG;
                                    } else $val = '';

                                    echo '<td class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'">';
                                    
                                    if($int_num_ng==0){
                                      echo trim($val);
                                      $text = 'hidden';
                                    } 
                                    
                                    if($v->num_rows() > 0) $showng[$ng->CHR_NG_CATEGORY_CODE] = true;

                                    echo '<input type="'.$text.'" name="'.trim($ng->CHR_NG_CATEGORY_CODE).'[]" class="form-control input-change" time="'.$time.'" totprod="'.$totprod.'" ngtot="'.$ngpart.'" gng="'.$time.'"  tag="'.$ng->CHR_NG_CATEGORY_CODE.'-'.$time.'" value="'.$val.'" '.$readonly.' />
                                    <input type="hidden" name="INT_NUMBER_'.trim($ng->CHR_NG_CATEGORY_CODE).'[]" value="'.$int_num_ng.'"/>
                                    </td>';

                                    array_key_exists($ng->CHR_NG_CATEGORY_CODE.'-'.$time, $commonarr)?$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$time]+=$val:$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$time]=$val;

                                    array_key_exists($ngpart, $commonarr)?$commonarr[$ngpart]+=$val:$commonarr[$ngpart]=$val;

                                    array_key_exists('NG-'.$time, $commonarr)?$commonarr['NG-'.$time]+=$val:$commonarr['NG-'.$time]=$val;

                                  }
                                }
                              ?>
                              <td class="vright"><span id="<?php echo $ngpart?>"><?php echo $commonarr[$ngpart]?></span></td>
                              <!-- ./TM NG -->

                            
                              <td class="vright">
                                <span id="<?php echo $totprod?>"><?php echo $ap->INT_TOTAL_QTY?></span>
                                <input type="hidden" name="total_produksi[]" value="<?php echo $ap->INT_TOTAL_QTY?>" id="input-produksi-<?php echo $totprod?>"></input>
                              </td>
                              
                              <!-- TM LINE STOP -->
                              <?php 
                                if($line_stop->num_rows() > 0){
                                  foreach ($line_stop->result() as $ls) {
                                    $val = 0;
                                    $int_num_ls=0;
                                    $text = 'text';
                                    $v = $this->approval_m->getValueLS($ap->INT_NUMBER,$ls->CHR_LINE_CODE);

                                    if($v->num_rows() > 0){
                                       $val = $v->row()->INT_MENIT;
                                       $int_num_ls = $v->row()->INT_NUMBER;
                                    } else $val = '';

                                    echo '<td class="vcenter tbl-'.$ls->CHR_LINE_CODE.'">';

                                    if($v->num_rows() > 0) $showls[$ls->CHR_LINE_CODE] = true;

                                    if($int_num_ls==0){
                                      $text = 'hidden';
                                    } 

                                    echo '<input type="'.$text.'" name="'.trim($ls->CHR_LINE_CODE).'[]" class="form-control input-change" timels="'.$time.'" tls="'.$lspart.'" tag="'.trim($ls->CHR_LINE_CODE).'-'.$time.'" value="'.$val.'" '.$readonly.' />
                                    <input type="hidden" name="INT_NUMBER_LS_'.trim($ls->CHR_LINE_CODE).'[]" value="'.$int_num_ls.'" />
                                          </td>';
                                    array_key_exists($ls->CHR_LINE_CODE.'-'.$time, $commonarr)?$commonarr[$ls->CHR_LINE_CODE.'-'.$time]+=$val:$commonarr[$ls->CHR_LINE_CODE.'-'.$time]=$val;

                                    array_key_exists($lspart, $commonarr)?$commonarr[$lspart]+=$val:$commonarr[$lspart]=$val;

                                    array_key_exists('LS-'.$time, $commonarr)?$commonarr['LS-'.$time]+=$val:$commonarr['LS-'.$time]=$val;

                                  }
                                }
                              ?>
                              <td class="vright"><span id="<?php echo $lspart?>"><?php echo $commonarr[$lspart]?></span></td>
                              <!-- ./TM LINE STOP -->

                              <?php 
                                if($ap->INT_CHOKOTEI !=0) $showck[$time] = true;
                                if($ap->INT_TARGET !=0) $showtarget[$time] = true;
                                if($ap->INT_ACTUAL !=0) $showactual[$time] = true;
                              ?>

                              <td class="vright">
                              <input type="text" name="intmp[]" autocomplete="off" value="<?php echo $ap->INT_MP?>" class="form-control input-change" tag="mp-<?php echo $time?>" <?php echo $readonly?> />
                              </td>
                              <td class="vright" ><span id="">&nbsp;</span></td>
                              <td class="vright" ><span id="">&nbsp;</span></td>
                              <td class="vright" ><span id="">&nbsp;</span></td>
                              <td class="vcenter">&nbsp;</td>
                              <td class="vcenter">
                              <input type="checkbox" name="validate_<?php echo $ap->INT_NUMBER?>"  
                              <?php echo $ap->CHR_VALIDATE=='X' ? 'checked="checked" disabled="disabled"' : ''?> class="form-control app-check"></td>
                              </tr>

                              <!-- ./MAIN -->
                              <?php
                                $lastime = $time;
                                $lasintnum = $ap->INT_NUMBER;

                                //NOT VALIDATED
                                $lastdate = trim($ap->CHR_DATE);
                                $lasttimestart = trim($ap->CHR_WORK_TIME_START);
                                $lastsift = trim($ap->CHR_SHIFT);
                                $lastworkday = trim($ap->CHR_WORK_DAY);
                                $lastwc = trim($ap->CHR_WORK_CENTER);

                                
                                if($n == $approval->num_rows()){
                                $PRS = $this->db->get_where('TT_PRODUCTION_RESULT', array('INT_NUMBER'=>$lasintnum))->row();
                                $WORK_TIME['CHR_WORK_SHIFT'] = $lastsift;
                                $WORK_TIME['CHR_WORK_DAY'] = $lastworkday;

                                $wt = $this->db->get_where('TM_WORK_TIME',$WORK_TIME);

                                $ct = $this->approval_m->getIntCT($lastwc);
								                if ($ct->row()->INT_CT==NULL) {
                                    echo '<script>alert("Cek data cycle time di Target Produksi!");</script>';
                                      redirect('pes/approval_c/', 'refresh');
                                }else{
								                $qtyph = ( 3600/$ct->row()->INT_CT) *$PRS->INT_MP;
                                }
                                @$tperj = floor((($wt->row()->INT_WORK_HOUR - $getIntLS[$lastime])/60) * $qtyph);
                                $actual = $this->approval_m->getActual($lasttimestart,$lastdate,$lastwc);
                                $chk = (($tperj * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime] - ((($total_produksi[$lastime] * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime]);
                								
                								$danger = false;
                                @$persen = $actual->row()->INT_TOTAL_QTY / $tperj * 100;
                								if($persen < 95) $danger = true;
								                ?>
                                <tr <?php if($danger) echo "style='background-color:#F00';"?>>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vcenter"></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="qty-ok-<?php echo $lastime?>"><?php echo $qtyok[$lastime]?></span></td>
                                    <!-- TM NG -->
                                    <?php 
                                      if($tmng->num_rows() > 0){
                                        foreach ($tmng->result() as $ng) {
                                          $tcm = '';
                                          if($commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime] > 0) $tcm = $commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime];
                                          echo '<td '.($danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"').' class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'"><span id="'.$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime.'">'.$tcm.'</span></td>';

                                          if(!$showng[$ng->CHR_NG_CATEGORY_CODE]){
                                              echo "<script>hideng('".$ng->CHR_NG_CATEGORY_CODE."');</script>";
                                          }
                                        }
                                      }
                                    ?>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="NG-<?php echo $lastime?>"><?php echo $commonarr['NG-'.$lastime]?></span></td>
                                    <!-- ./TM NG -->

                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>>
                                        <span id="total-produksi-<?php echo $lastime?>"><?php echo $total_produksi[$lastime]?></span>
                                    </td>
                                   
                                   <!-- TM LINE STOP -->
                                    <?php 
                                      if($line_stop->num_rows() > 0){
                                        foreach ($line_stop->result() as $ls) {
                                          $tcm = '';
                                          if($commonarr[$ls->CHR_LINE_CODE.'-'.$lastime] > 0) $tcm = $commonarr[$ls->CHR_LINE_CODE.'-'.$lastime];

                                          echo '<td '.($danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"').' class="vright tbl-'.$ls->CHR_LINE_CODE.'"><span id="'.trim($ls->CHR_LINE_CODE).'-'.$lastime.'">'.$tcm.'</span></td>';

                                           if(!$showls[$ls->CHR_LINE_CODE]){
                                              echo "<script>hidels('".$ls->CHR_LINE_CODE."');</script>";
                                          }
                                        }
                                      }
                                    ?>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="LS-<?php echo $lastime?>"><?php echo $commonarr['LS-'.$lastime]?></span></td>
                                    <!-- ./TM LINE STOP -->

                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><span id="mp-<?php echo $lastime?>"><?php echo $total_mp[$lastime]?></span></td>
                                    
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo $showck[$lastime] == true? round($chk) : 0?></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo $showtarget[$lastime] == true? $tperj : 0?></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo  $showactual[$lastime] == true? $actual->row()->INT_TOTAL_QTY : 0?></td>
                                    <td class="vright" <?php echo $danger?'style="color:#FFF;font-weight:bold;"':'style="font-weight:bold;"'; ?>><?php echo round($persen)?></td>
                                    <td class="vcenter">&nbsp;</td>
                                    </tr>
                              <?php
                              }
                              $n++;
                              }}

                              ?>

                          </tbody>
                        </table>
                      </div>
                    </div>
                    </form>          
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</aside>

<script type="text/javascript">
  var baseurl = '<?php echo base_url()?>';
  $('.input-change').keydown(function(e) { 
       // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
  });

  $('#input-wo').keyup(function(){
    $("#suggesstion").html('');
      if(this.value.length > 3){
          $.ajax({
            type: "POST",
            url: baseurl+"index.php/pes/approval_c/get_wo",
            data:'keyword='+this.value,
            beforeSend: function(){
              $("#input-wo").css("background","#FFF url("+ baseurl +"assets/css/ines/loader.gif) scroll right 10px center no-repeat");
            },
            success: function(data){
              $("#suggesstion").show();
              $("#suggesstion").html(data);
              $("#input-wo").css("background","#FFF");
            }
          });
      }
  });

  $('.input-change').keyup(function() { 
    var tag = $(this).attr('tag');
    var sum = 0;  
    $('input[tag="'+tag+'"]').each(function() {
      if(tag.substr(0,2)=='mp'){
        sum < parseInt(this.value) ? sum = parseInt(this.value):"";
      }
      else{
        sum += parseInt(this.value == "" ? 0 : this.value);
      }
    });
    $("#" + tag).html(sum);

    var totprod = $(this).attr('totprod');
    var sumtotprod = 0;  
    $('input[totprod="'+totprod+'"]').each(function() {
      sumtotprod += parseInt(this.value == "" ? 0 : this.value);
    });
    $("#" + totprod).html(sumtotprod);

    $("#input-produksi-" + totprod).val(sumtotprod);

    var time = $(this).attr('time');
    var sumtottime = 0; 
    $('input[time="'+time+'"]').each(function() {
      sumtottime += parseInt(this.value == "" ? 0 : this.value);
    });
    $("#total-produksi-" + time).html(sumtottime);

    var ngtot = $(this).attr('ngtot');
    var sumng = 0; 
    $('input[ngtot="'+ngtot+'"]').each(function() {
      sumng += parseInt(this.value == "" ? 0 : this.value);
    });
    $("#" + ngtot).html(sumng);

    var gng = $(this).attr('gng');
    var sumgng = 0; 
    $('input[gng="'+gng+'"]').each(function() {
      sumgng += parseInt(this.value == "" ? 0 : this.value);
    });

    $("#NG-" + gng).html(sumgng);
 
    var tls = $(this).attr('tls');
    var sumtls = 0; 
    $('input[tls="'+tls+'"]').each(function() {
      sumtls += parseInt(this.value == "" ? 0 : this.value);
    });

    $("#" + tls).html(sumtls);

    var timels = $(this).attr('timels');
    var sumtimels = 0; 
    $('input[timels="'+timels+'"]').each(function() {
      sumtimels += parseInt(this.value == "" ? 0 : this.value);
    });

    $("#LS-" + timels).html(sumtimels);
  });

  function selectWO(txt){
      $("#suggesstion").html('');
      $('#input-wo').val(txt);
  }
</script>