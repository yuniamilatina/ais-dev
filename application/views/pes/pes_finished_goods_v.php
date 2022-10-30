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

</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>NG Finished Goods</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <?php 
          $set = $this->uri->segment(4,1);
          $seturi = base_url()."index.php/pes/finished_goods_c/index/".($set == 0 ? 1 : 0);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid" ><!--style="background-color: #94D1DC"-->
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">NG FINISHED GOODS</span>
                    </div>
                    <div class="grid-body">
                    <?php 
                    $s = $this->session->flashdata('message');
                    if($s){?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo $s?>
                    </div>
                    <?php } ?>

                    <form class="form-horizontal" role="form" method="get" action="<?php echo base_url()?>index.php/pes/finished_goods_c/index">
                      <div class="form-group">  
                        <label class="col-sm-1 control-label">Tanggal</label>
                        <div class="col-sm-2">
                          <input type="text" autocomplete="off" name="date" id="datepicker" class="form-control" value="<?php echo $tanggal?>">
                        </div>

                        <label class="col-sm-4 control-label">Back Number</label>
                        <div class="col-sm-3">
                          <input type="text" autocomplete="off" id="backno" class="form-control" required="true" name="backno" value="<?php echo $backno?>" />
                        </div>
                        <div class="col-sm-2">
                          <button type="button" id="popup" style="margin-right: 20px" class="md-trigger btn btn-primary pull-left" data-modal="modal-1">
                            <i class="fa fa-list-alt"></i>
                          </button>
                          <button type="submit" class="md-trigger btn btn-primary pull-left">GO</button>
                        </div>
                      </div>
                      </form>

                      <?php if($backno && $tanggal){?>
                      <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url()?>index.php/pes/finished_goods_c/update">
                      <input type="hidden" name="backno" value="<?php echo $backno?>"></input>
                      <input type="submit" value="Execute" class="btn btn-default pull-left">
                      <div style="width: 100%; clear: both; height: 2px"></div>
                        <label class="control-label">Kode Area</label>
                        <div style="width: 100%; clear: both; height: 2px"></div>
                        <input class="form-control"id="kode_area" name="kode_area" style="width: 200px" value="<?php echo $area?>" readonly="readonly">
                      <div style="width: 100%; clear: both; height: 2px;"></div>`
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
                                if($tmng->num_rows() > 0){
                                  echo '<th colspan="'.($line_stop->num_rows() + 1).'" class="vcenter ls-th">Line Stop</th>';
                                }
                              ?>
                              <th rowspan="2" class="vcenter">Jml MP</th>
                            </tr>
                            <tr>
                              <!-- TM NG -->
                              <?php 
                                if($tmng->num_rows() > 0){
                                  foreach ($tmng->result() as $ng) {
                                    echo '<th class="vcenter tbl-'.trim($ng->CHR_NG_CATEGORY_CODE).'">'.trim($ng->CHR_NG_CATEGORY).'</th>';
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
                                    echo '<th class="vcenter tbl-'.trim($ls->CHR_LINE_CODE).'">'.trim($ls->CHR_LINE_STOP).'</th>';
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
                              if($prodresult->num_rows() > 0){
                                foreach ($prodresult->result() as $ap) {
                                  $process = $this->db->get_where('TM_PROCESS', array('CHR_WORK_CENTER'=>trim($ap->CHR_WORK_CENTER)));
                                  $responsible = '';
                                  if($process->num_rows() > 0){
                                      $responsible = trim($process->row()->CHR_PERSON_RESPONSIBLE);
                                  }

                                  $ppart = $this->db->get_where('TM_PROCESS_PARTS', array('CHR_WORK_CENTER'=>trim($ap->CHR_WORK_CENTER),'CHR_PART_NO'=>trim($ap->CHR_PART_NO)));

                                  $slocto = '';
                                  if($ppart->num_rows() > 0){
                                      $slocto = trim($ppart->row()->CHR_SLOC_TO);
                                  }
                                  
                                  echo "<input type='hidden' name='RESPONSIBLE[]' value='".$responsible."' />";
                                  echo "<input type='hidden' name='SLOC_TO[]' value='".$slocto."' />";
                                  echo "<input type='hidden' name='INT_NUMBER[]' value='".$ap->INT_NUMBER."' />";
                                  echo "<input type='hidden' name='CHR_WO_NUMBER[]' value='".$ap->CHR_WO_NUMBER."' />";
                                  echo "<input type='hidden' name='chr_plant[]' value='".$ap->CHR_PLANT."' />";
                                  echo "<input type='hidden' name='chr_date[]' value='".$ap->CHR_DATE."' />";
                                  echo "<input type='hidden' name='CHR_WORK_TIME_START[]' value='".$ap->CHR_WORK_TIME_START."' />";
                                  echo "<input type='hidden' name='chr_part_no[]' value='".$ap->CHR_PART_NO."' />";

                                  echo "<input type='hidden' name='CHR_SHIFT[]' value='".trim($ap->CHR_SHIFT)."' />";
                                  echo "<input type='hidden' name='CHR_WORK_DAY[]' value='".trim($ap->CHR_WORK_DAY)."' />";
                                  echo "<input type='hidden' name='CHR_WORK_CENTER[]' value='".trim($ap->CHR_WORK_CENTER)."' />";
                                  
                                  $time = trim($ap->CHR_WORK_TIME_START).trim($ap->CHR_WORK_TIME_END);
                                  $totprod = $time . trim($ap->CHR_PART_NO);
                                  $totmp = "MP-".$totprod;
                                  $ngpart = "NG-".$time.trim($ap->CHR_PART_NO).$ap->INT_NUMBER;
                                  $lspart = "LS-".$time.trim($ap->CHR_PART_NO).$ap->INT_NUMBER;
                               ?>
                              
                              <!-- MAIN -->
                              <tr>
                              <td class="vcenter"><?php echo $n?></td>
                              <td class="vcenter"><?php echo substr_replace(trim($ap->CHR_WORK_TIME_START),":",2,0)."-".substr_replace(trim($ap->CHR_WORK_TIME_END),":",2,0)?></td>
                              <td class="vcenter"><?php echo trim($ap->CHR_WORK_CENTER)?></td>
                              <td class="vcenter"><?php echo trim($ap->CHR_BACK_NO)?></td>
                              <td class="vcenter"><?php echo trim($ap->CHR_PART_NO)?></td>
                              <td class="vleft"><?php echo trim($ap->CHR_PART_NAME)?></td>
                              <td class="vright">
                                <input type="text" readonly="readonly" autocomplete="off" name='qty-ok[]' class="form-control input-change" totprod="<?php echo $totprod?>" value="<?php echo $ap->INT_QTY_OK?>">
                              </td>

                              <!-- TM NG -->
                              <?php 
                                if($tmng->num_rows() > 0){
                                  $total = 0;
                                  foreach ($tmng->result() as $ng) {
                                    $val = '';
                                    $v = $this->approval_m->getValueNGRepair($ap->INT_NUMBER,$ng->CHR_NG_CATEGORY_CODE,$responsible);

                                    if($v->num_rows() > 0){
                                      $val = $v->row()->INT_TOTAL_QTY_NG;
                                      $total += $val;
                                      if($responsible=='014'){
                                        if($v->row()->CHR_AREA){
                                            echo "<script>$('#kode_area').val('".trim($v->row()->CHR_AREA)."');</script>";
                                        }
                                      }
                                    } 

                                    echo '<td class="vright tbl-'.$ng->CHR_NG_CATEGORY_CODE.'">';
                                    echo '<input type="text" autocomplete="off" name="'.trim($ng->CHR_NG_CATEGORY_CODE).'[]" class="form-control input-change" value="'.$val.'" totprod="'.$totprod.'" ngtot="'.$ngpart.'" gng="'.$time.'" />
                                    </td>';
                                  }
                                }
                              ?>
                              <td class="vright"><span id="<?php echo $ngpart?>"><?php echo $total ?></span></td>
                              <!-- ./TM NG -->

                            
                              <td class="vright">
                                <span id="<?php echo $totprod?>"><?php echo $total + $ap->INT_QTY_OK?></span>
                                <input type="hidden" name="total_produksi[]" value="<?php echo $total + $ap->INT_QTY_OK?>" id="input-produksi-<?php echo $totprod?>"></input>
                              </td>
                              
                              <!-- TM LINE STOP -->
                              <?php 
                                if($line_stop->num_rows() > 0){
                                    $total = 0;
                                  foreach ($line_stop->result() as $ls) {
                                    $val = '';
                                    $text = 'text';
                                    $v = $this->approval_m->getValueLS($ap->INT_NUMBER,$ls->CHR_LINE_CODE);

                                    if($v->num_rows() > 0){
                                       $val = $v->row()->INT_MENIT;
                                       $total += $val;
                                    }

                                    echo '<td class="vcenter tbl-'.$ls->CHR_LINE_CODE.'">';

                                    if($v->num_rows() > 0) $showls[$ls->CHR_LINE_CODE] = true;

                                    echo '<input type="text" autocomplete="off" name="'.trim($ls->CHR_LINE_CODE).'[]" class="form-control input-change" value="'.$val.'" tls="'.$lspart.'" />
                                     </td>';

                                  }
                                }
                              ?>
                              <td class="vright"><span id="<?php echo $lspart?>"><?php echo $total?></span></td>
                              <!-- ./TM LINE STOP -->

                              <td class="vright">
                              <input type="text" autocomplete="off" name='qty_mp[]' class="form-control input-change" value="<?php echo $ap->INT_MP?>"></td>
                              
                              <!-- ./MAIN -->
                              <?php
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

<div class="md-modal md-effect-1" id="modal-1">
  <div class="md-content modal-content">
    <div class="modal-header">
      <h4 class="modal-title">BACK NUMBER</h4>
    </div>
    <div class="modal-body">
      <table class="table">
        <?php
            for($i=1; $i<=10; $i+=2){
                echo ' <tr>
                          <td style="border:none !important"><input type="text" class="backno input-back-no-'.$i.' form-control"/></td>
                          <td style="border:none !important"><input type="text" class="backno input-back-no-'.($i+1).' form-control"/></td>
                      </tr>';
            }
        ?>
       
      </table>
    </div>
    <div class="modal-footer">
      <div class="btn-group">
        <button type="button" class="btn btn-primary md-close" data-dismiss="modal" id="backno-ok">OK</button>
      </div>
    </div>
  </div>
</div>

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

  $('.input-change').keyup(function() {
    var sum = 0;  
    var totprod = $(this).attr('totprod');
    var sumtotprod = 0;  
    $('input[totprod="'+totprod+'"]').each(function() {
      sumtotprod += parseInt(this.value == "" ? 0 : this.value);
    });
    $("#" + totprod).html(sumtotprod);

    $("#input-produksi-" + totprod).val(sumtotprod);

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

  });

  $('#popup').click(function(){
      $(".backno").each(function() {
        this.value = "";
      });

      var s = $('#backno').val().split(";");
      for(i = 1; i<=s.length; i++){
        if(s[i-1]!=""){
          $(".input-back-no-"+i).val(s[i-1]);
        }
      }
  });

  $('#backno-ok').click(function(){
    var s = "";
    $(".backno").each(function() {
      if(this.value!="") s = s+this.value+";";
    });
    var str = s.substring(s.length - 1);
    if(str == ";") s = s.substring(0, s.length - 1);
    $('#backno').val(s);
  });
</script>