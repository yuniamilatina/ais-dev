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
    //text-align: right; !important;
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
                <div class="grid" ><!--style="background-color: #94D1DC"-->
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">APPROVAL PRODUCTION EXECUTION</span>
                    </div>
                    <div class="grid-body">
                    <form class="form-horizontal" role="form" method="get" action="<?php echo base_url()?>index.php/pes/approval_c/index/<?php echo $set?>">
                      <div class="form-group">
                        <label class="col-sm-1 control-label">Tanggal</label>
                        <div class="col-sm-2">
                          <input type="text" name="date" <?php echo ($set == 0 ? "" : "disabled='true'")?> class="form-control" id="datepicker" placeholder="DD/MM/YYYY" value="<?php  echo date('d/m/Y') ?>">
                        </div>

                        <div class="col-sm-2">
                          <input id="btn-date" type="button" value="<?php echo ($set == 0 ? "Set" : "Un-Set")?>" class="btn btn-default pull-left">
                        </div>

                        <label class="col-sm-2 control-label">Work Order Number</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="wo" value="<?php echo $wo?>" />
                        </div>

                        <div class="col-sm-2">
                          <input type="submit" value="GO" class="btn btn-default pull-left">
                        </div>
                      </div>
                      </form>

                      <?php if($wo){?>
                      
                      <div style="overflow-x:scroll; overflow-y: hidden;">

                      <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url()?>index.php/pes/approval_c/update">

                      <input type="submit" value="Execute" class="btn btn-default pull-left">

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
                        if($tmng->num_rows() > 0){
                          echo '<th colspan="'.($line_stop->num_rows() + 1).'" class="vcenter ls-th">Line Stop</th>';
                        }
                      ?>
                      <th rowspan="2" class="vcenter">Jml MP</th>
                      <th rowspan="2" class="vcenter">Chokotei</th>
                      <th rowspan="2" class="vcenter">Target/Jam</th>
                      <th rowspan="2" class="vcenter">Actual/Jam</th>
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
                      $qtyok = array();
                      $total_produksi = array();
                      $total_mp = array();
                      $commonarr = array();
                      if($approval->num_rows() > 0){
                        foreach ($approval->result() as $ap) {
                          echo "<input type='hidden' name='CHR_WO_NUMBER[]' value='".$ap->CHR_WO_NUMBER."' />";
                          echo "<input type='hidden' name='chr_plant[]' value='".$ap->CHR_PLANT."' />";
                          echo "<input type='hidden' name='chr_date[]' value='".$ap->CHR_DATE."' />";
                          echo "<input type='hidden' name='CHR_WORK_TIME_START[]' value='".$ap->CHR_WORK_TIME_START."' />";
                          echo "<input type='hidden' name='chr_part_no[]' value='".$ap->CHR_PART_NO."' />";

                          $danger = false;
                          $text = 'text';
                          if($ap->INT_ACTUAL < $ap->INT_TARGET) $danger = true;
                          if($danger) $text='hidden';

                          $time = trim($ap->CHR_WORK_TIME_START);
                          $totprod = $time . trim($ap->CHR_PART_NO);
                          $totmp = "MP-".$totprod;
                          $ngpart = "NG-".$time.trim($ap->CHR_PART_NO);
                          $lspart = "LS-".$time.trim($ap->CHR_PART_NO);
                          array_key_exists($time, $qtyok)?$qtyok[$time]+=$ap->INT_QTY_OK:$qtyok[$time] = $ap->INT_QTY_OK;
                          array_key_exists($time, $total_produksi)?$total_produksi[$time]+=$ap->INT_TOTAL_QTY:$total_produksi[$time] = $ap->INT_TOTAL_QTY;
                          array_key_exists($time, $total_mp)?$total_mp[$time]+=$ap->INT_MP:$total_mp[$time] = $ap->INT_MP;

                          if ($lastime AND $lastime!=$time){?>
                            <tr>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vright"><span id="qty-ok-<?php echo $lastime?>"><?php echo $qtyok[$lastime]?></span></td>
                            <!-- TM NG -->
                            <?php 
                              if($tmng->num_rows() > 0){
                                foreach ($tmng->result() as $ng) {
                                  echo '<td class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'"><span id="'.$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime.'">'.$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime].'</span></td>';
                                }
                              }
                            ?>
                            <td class="vright"><span id="NG-<?php echo $lastime?>"><?php echo $commonarr['NG-'.$lastime]?></span></td>
                            <!-- ./TM NG -->

                            <td class="vright"><span id="total-produksi-<?php echo $lastime?>"><?php echo $total_produksi[$lastime]?></span></td>
                            
                            <!-- TM LINE STOP -->
                            <?php 
                              if($line_stop->num_rows() > 0){
                                foreach ($line_stop->result() as $ls) {
                                  echo '<td class="vright  tbl-'.$ls->CHR_LINE_CODE.'"><span id="'.trim($ls->CHR_LINE_CODE).'-'.$lastime.'">'.$commonarr[$ls->CHR_LINE_CODE.'-'.$lastime].'</span></td>';
                                }
                              }
                            ?>
                            <td class="vright"><span id="LS-<?php echo $lastime?>"><?php echo $commonarr['LS-'.$lastime]?></span></td>
                            <!-- ./TM LINE STOP -->
                            <td class="vright"><span id="total-mp-<?php echo $lastime?>"><?php echo $total_mp[$lastime]?></span></td>
                            <td class="vcenter">&nbsp;</td>
                            <td class="vcenter">&nbsp;</td>
                            <td class="vcenter">&nbsp;</td>
                            <td class="vcenter">&nbsp;</td>
                            </tr>
                      <?php } ?>
                      
                      <!-- MAIN -->
                      <tr <?php if($danger) echo "style='background-color:#F00'"?>>
                      <td class="vcenter"><?php echo $n?></td>
                      <td class="vcenter"><?php echo substr_replace(trim($ap->CHR_WORK_TIME_START),":",2,0)?></td>
                      <td class="vcenter"><?php echo trim($ap->CHR_WORK_CENTER)?></td>
                      <td class="vcenter"><?php echo trim($ap->CHR_BACK_NO)?></td>
                      <td class="vcenter"><?php echo trim($ap->CHR_PART_NO)?></td>
                      <td class="vleft"><?php echo trim($ap->CHR_PART_NAME)?></td>
                      <td class="vright">
                        <?php if($danger){
                          echo trim($ap->INT_QTY_OK);

                        } ?>

                        <input type="<?php echo $text?>" name='qty-ok[]' class="form-control input-change" time="<?php echo $time?>" totprod="<?php echo $totprod?>" tag="qty-ok-<?php echo $time?>" value="<?php echo $ap->INT_QTY_OK?>">
                      </td>

                      <!-- TM NG -->
                      <?php 
                        if($tmng->num_rows() > 0){
                          foreach ($tmng->result() as $ng) {
                            $val = 0;
                            $v = $this->approval_m->getValueNGRepair($ap->CHR_WO_NUMBER,$ap->CHR_PLANT,$ap->CHR_DATE,$ap->CHR_WORK_TIME_START,$ap->CHR_PART_NO,$ng->CHR_NG_CATEGORY_CODE);
                            $v->num_rows() > 0 ? $val = $v->row()->INT_TOTAL_QTY_NG:'';

                            echo '<td class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'">';
                            
                            if($danger){
                              echo trim($val);
                            } 

                            if($v->num_rows() > 0) $showng[$ng->CHR_NG_CATEGORY_CODE] = true;

                            echo '<input type="'.$text.'" name="'.trim($ng->CHR_NG_CATEGORY_CODE).'[]" class="form-control input-change" time="'.$time.'" totprod="'.$totprod.'" ngtot="'.$ngpart.'" gng="'.$time.'"  tag="'.$ng->CHR_NG_CATEGORY_CODE.'-'.$time.'" value="'.$val.'">
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
                            echo '<td class="vcenter tbl-'.$ls->CHR_LINE_CODE.'">';

                            if($danger){
                              echo trim($val);
                            } 

                            if($v->num_rows() > 0) $showls[$ls->CHR_LINE_CODE] = true;

                            echo '<input type="'.$text.'" name="'.trim($ls->CHR_LINE_CODE).'[]" class="form-control input-change" timels="'.$time.'" tls="'.$lspart.'" tag="'.trim($ls->CHR_LINE_CODE).'-'.$time.'" value="'.$val.'">
                                  </td>';
                            array_key_exists($ls->CHR_LINE_CODE.'-'.$time, $commonarr)?$commonarr[$ls->CHR_LINE_CODE.'-'.$time]+=$val:$commonarr[$ls->CHR_LINE_CODE.'-'.$time]=$val;

                            array_key_exists($lspart, $commonarr)?$commonarr[$lspart]+=$val:$commonarr[$lspart]=$val;

                            array_key_exists('LS-'.$time, $commonarr)?$commonarr['LS-'.$time]+=$val:$commonarr['LS-'.$time]=$val;

                          }
                        }
                      ?>
                      <td class="vright"><span id="<?php echo $lspart?>"><?php echo $commonarr[$lspart]?></span></td>
                      <!-- ./TM LINE STOP -->

                      <td class="vright"><span id="<?php echo $totmp?>"><?php echo $ap->INT_MP?></span></td>
                      <td class="vright"><span id=""><?php echo $ap->INT_CHOKOTEI?></span></td>
                      <td class="vright"><span id=""><?php echo $ap->INT_TARGET?></span></td>
                      <td class="vright"><span id=""><?php echo $ap->INT_ACTUAL?></span></td>
                      <td class="vcenter"><input type="checkbox" class="form-control app-check"></td>
                      </tr>

                      <!-- ./MAIN -->
                      <?php

                        $lastime = $time;
                        if($n == $approval->num_rows()){
                      ?>
                        <tr>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vcenter"></td>
                            <td class="vright"><span id="qty-ok-<?php echo $lastime?>"><?php echo $qtyok[$lastime]?></span></td>
                            <!-- TM NG -->
                            <?php 
                              if($tmng->num_rows() > 0){
                                foreach ($tmng->result() as $ng) {
                                  echo '<td class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'"><span id="'.$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime.'">'.$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime].'</span></td>';

                                  if(!$showng[$ng->CHR_NG_CATEGORY_CODE]){
                                      echo "<script>hideng('".$ng->CHR_NG_CATEGORY_CODE."');</script>";
                                  }
                                }
                              }
                            ?>
                            <td class="vright"><span id="NG-<?php echo $lastime?>"><?php echo $commonarr['NG-'.$lastime]?></span></td>
                            <!-- ./TM NG -->

                            <td class="vright">
                                <span id="total-produksi-<?php echo $lastime?>"><?php echo $total_produksi[$lastime]?></span>
                            </td>
                           
                           <!-- TM LINE STOP -->
                            <?php 
                              if($line_stop->num_rows() > 0){
                                foreach ($line_stop->result() as $ls) {
                                  echo '<td class="vright tbl-'.$ls->CHR_LINE_CODE.'"><span id="'.trim($ls->CHR_LINE_CODE).'-'.$lastime.'">'.$commonarr[$ls->CHR_LINE_CODE.'-'.$lastime].'</span></td>';

                                   if(!$showls[$ls->CHR_LINE_CODE]){
                                      echo "<script>hidels('".$ls->CHR_LINE_CODE."');</script>";
                                  }
                                }
                              }
                            ?>
                            <td class="vright"><span id="LS-<?php echo $lastime?>"><?php echo $commonarr['LS-'.$lastime]?></span></td>
                            <!-- ./TM LINE STOP -->

                            <td class="vright"><span id="total-mp-<?php echo $lastime?>"><?php echo $total_mp[$lastime]?></span></td>
                            <td class="vcenter">&nbsp;</td>
                            <td class="vcenter">&nbsp;</td>
                            <td class="vcenter">&nbsp;</td>
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
                    </form>
                    </div>                
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</aside>

<script type="text/javascript">
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


  $('#btn-date').click(function(){
    window.location.href = "<?php echo $seturi?>";
  });

  $('.input-change').keyup(function() { 
    var tag = $(this).attr('tag');
    var sum = 0;  
    $('input[tag="'+tag+'"]').each(function() {
      sum += parseInt(this.value == "" ? 0 : this.value);
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
</script>