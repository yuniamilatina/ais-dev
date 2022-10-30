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
  .table td, .table th {
   border: 0.5px solid black;
   border-collapse: collapse;
  }
</style>
<table>
  <tr>
    <td>Work Order Number: </td>
    <td><?php  echo $wo ?></td>
  </tr>
</table>
<?php   
  if($wo){
    $n = 1;
    $data = array();
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
    $spanng  = 0;
    $spanls = 0;
    foreach ($tmng->result() as $ng) {
      $showng[trim($ng->CHR_NG_CATEGORY_CODE)] = false;
    }

    foreach ($line_stop->result() as $ls) {
      $showls[trim($ls->CHR_LINE_CODE)] = false;
    }

    if($approval->num_rows() > 0){
      foreach ($approval->result() as $ap) {
        $process = $this->db->get_where('TM_PROCESS', array('CHR_WORK_CENTER'=>$ap->CHR_WORK_CENTER));
        $responsible = '';
        
        if($process->num_rows() > 0){
          $responsible = trim($process->row()->CHR_PERSON_RESPONSIBLE);
        }

        @$persen = $ap->INT_ACTUAL/$ap->INT_TARGET*100;
        
        if($persen<95) $danger = true;
        $time = trim($ap->CHR_WORK_TIME_START).trim($ap->CHR_WORK_TIME_END);
        $totprod = $time . trim($ap->CHR_PART_NO);
        $totmp = "MP-".$totprod;
        $ngpart = "NG-".$time.trim($ap->CHR_PART_NO);
        $lspart = "LS-".$time.trim($ap->CHR_PART_NO);
        array_key_exists($time, $qtyok)?$qtyok[$time]+=$ap->INT_QTY_OK:
        $qtyok[$time] = $ap->INT_QTY_OK;
        array_key_exists($time, $total_produksi)?$total_produksi[$time]+=$ap->INT_TOTAL_QTY:
        $total_produksi[$time] = $ap->INT_TOTAL_QTY;
        
        if(array_key_exists($time, $total_mp)){
          $total_mp[$time] < $ap->INT_MP ? $total_mp[$time]=$ap->INT_MP:
          "";
        } else {
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
        } else {
          $getIntLS[$time] = $pls->row()->INT_MENIT;
          $getIntLSTotal[$time] = $cls->row()->INT_TOTAL_LINE_STOP;
        }
        
        if ($lastime AND $lastime!=$time){
          $item = array();
          $item['tr'] = "<tr>";
          $item['no'] = "<td></td>";
          $item['time'] = "<td></td>";
          $item['wc'] = "<td></td>";
          $item['backno'] = "<td></td>";
          $item['partno'] = "<td></td>";
          $item['partname'] = "<td></td>";
          $PRS = $this->db->get_where('TT_PRODUCTION_RESULT', array('INT_NUMBER'=>$lasintnum))->row();
          $WORK_TIME['CHR_WORK_SHIFT'] = $lastsift;
          $WORK_TIME['CHR_WORK_DAY'] = $lastworkday;
          $WORK_TIME['CHR_WORK_TIME_START'] = $lasttimestart;
          $wt = $this->db->get_where('TM_WORK_TIME',$WORK_TIME);
          $ct = $this->approval_m->getIntCT($lastwc);
          $qtyph = ( 3600/$ct->row()->INT_CT) *$PRS->INT_MP;
          $tperj = floor((($wt->row()->INT_WORK_HOUR - $getIntLS[$lastime])/60) * $qtyph);
          $actual = $this->approval_m->getActual($lasttimestart,$lastdate,$lastwc);
          $chk = (($tperj * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime] - ((($total_produksi[$lastime] * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime]);
          $danger = false;
          @$persen = $actual->row()->INT_TOTAL_QTY/$tperj * 100;
          
          if($persen < 95) $danger = true;
          
          if($danger) $item['tr'] = "<tr style='background-color:#F00';>";
          $item['qtyok'] = '<td class="vcenter">'.$qtyok[$lastime].'</td>';
          ?>
          <!-- TM NG -->
          <?php  
          if($tmng->num_rows() > 0){
            foreach ($tmng->result() as $ng) {
              $tcm = '';
              
              if($commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime] > 0) {
                $tcm = $commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime];
                $item[trim($ng->CHR_NG_CATEGORY_CODE)] ='<td class="vcenter" >'.$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime].'</td>';
              } else $item[trim($ng->CHR_NG_CATEGORY_CODE)] ='<td></td>';
            }

          }
          
          $item['totalng'] = '<td class="vcenter">'.$commonarr['NG-'.$lastime].'</td>'; ?>
          <!-- ./TM NG -->
          <?php  $item['qtyproduksi'] = '<td class="vcenter" >'.$total_produksi[$lastime].'</td>'; ?>
          <!-- TM LINE STOP -->
          <?php 
          if($line_stop->num_rows() > 0){
            foreach ($line_stop->result() as $ls) {
              $tcm = '';
              if($commonarr[$ls->CHR_LINE_CODE.'-'.$lastime] > 0){
                $item[trim($ls->CHR_LINE_CODE)] ='<td class="vcenter" >'.$commonarr[$ls->CHR_LINE_CODE.'-'.$lastime].'</td>';
                $tcm = $commonarr[$ls->CHR_LINE_CODE.'-'.$lastime];
              } else {
                $item[trim($ls->CHR_LINE_CODE)] ='<td></td>';
              }

            }

          }

          $item['totalls'] = '<td class="vcenter" >'.$commonarr['LS-'.$lastime].'</td>';
          ?>
          <!-- ./TM LINE STOP -->
          <?php
          $item['jmp'] = '<td class="vcenter" >'.$total_mp[$lastime].'</td>';
          $item['chokotei'] = '<td class="vcenter" >'.round($chk).'</td>';
          $item['target'] = '<td class="vcenter" >'.$tperj.'</td>';
          $item['actual'] = '<td class="vcenter" >'.$actual->row()->INT_TOTAL_QTY.'</td>';
          $item['percentage'] = '<td class="vcenter" >'.round($persen).'</td>';
         
          array_push($data, $item);
        }

        ?>
        <!-- MAIN -->
        <?php
        $item = array();
        $item['tr'] = "<tr>";
        $item['no'] = '<td class="vcenter">'.$n.'</td>';
        $readonly = "";
        
        if(trim($ap->CHR_VALIDATE)=='X'){
          $readonly = 'readonly="readonly"';
        }

        
        if($lastime!=$time) {
          $item['jam'] = '<td class="vcenter">'.substr_replace(trim($ap->CHR_WORK_TIME_START),":",2,0)."-".substr_replace(trim($ap->CHR_WORK_TIME_END),":",2,0).'</td>';
          $item['wc'] = '<td class="vcenter" >'.trim($ap->CHR_WORK_CENTER).'</td>';
        } else {
          $item['jam'] = '<td class="vcenter"></td>';
          $item['wc'] = '<td class="vcenter"></td>';
        }

        $item['backno'] = '<td class="vcenter" >'.trim($ap->CHR_BACK_NO).'</td>';
        $item['partno'] = '<td class="vcenter" >'.trim($ap->CHR_PART_NO).'</td>';
        $item['partname'] = '<td class="vleft" >'.trim($ap->CHR_PART_NAME).'</td>';
        $item['qtyok'] ='<td class="vcenter" >'.$ap->INT_QTY_OK.'</td>';
        ?>
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
              $showng[trim($ng->CHR_NG_CATEGORY_CODE)] = true;
              $item[trim($ng->CHR_NG_CATEGORY_CODE)] ='<td class="vcenter" >'.$val.'</td>';
            } else $item[trim($ng->CHR_NG_CATEGORY_CODE)] ='<td></td>';
            ;
            array_key_exists($ng->CHR_NG_CATEGORY_CODE.'-'.$time, $commonarr)?$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$time]+=$val:
            $commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$time]=$val;
            array_key_exists($ngpart, $commonarr)?$commonarr[$ngpart]+=$val:
            $commonarr[$ngpart]=$val;
            array_key_exists('NG-'.$time, $commonarr)?$commonarr['NG-'.$time]+=$val:
            $commonarr['NG-'.$time]=$val;
          }

        }

        $item['totalng'] = '<td class="vcenter" >'.$commonarr[$ngpart].'</td>';
        ?>
        <!-- ./TM NG -->
        <?php  $item['qtyproduksi'] = '<td class="vcenter" >'.$ap->INT_TOTAL_QTY.'</td>'; ?>
        <!-- TM LINE STOP -->
        <?php 
        
        if($line_stop->num_rows() > 0){
          foreach ($line_stop->result() as $ls) {
            $val = 0;
            $int_num_ls=0;
            $text = 'text';
            $v = $this->approval_m->getValueLS($ap->INT_NUMBER,$ls->CHR_LINE_CODE);
            
            if($v->num_rows() > 0){
              $showls[trim($ls->CHR_LINE_CODE)] = true;
              $val = $v->row()->INT_MENIT;
              $int_num_ls = $v->row()->INT_NUMBER;
              $item[trim($ls->CHR_LINE_CODE)] ='<td class="vcenter" >'.$val.'</td>';
            } else {
              $val = '';
              $item[trim($ls->CHR_LINE_CODE)] ='<td></td>';
            }

            array_key_exists($ls->CHR_LINE_CODE.'-'.$time, $commonarr)?$commonarr[$ls->CHR_LINE_CODE.'-'.$time]+=$val:
            $commonarr[$ls->CHR_LINE_CODE.'-'.$time]=$val;
            array_key_exists($lspart, $commonarr)?$commonarr[$lspart]+=$val:
            $commonarr[$lspart]=$val;
            array_key_exists('LS-'.$time, $commonarr)?$commonarr['LS-'.$time]+=$val:
            $commonarr['LS-'.$time]=$val;
          }

        }

        $item['totalls'] = '<td class="vcenter" >'.$commonarr[$lspart].'</td>';
        ?>
        <!-- ./TM LINE STOP -->
        <?php 
        
        if($ap->INT_CHOKOTEI !=0) $showck[$time] = true;
        
        if($ap->INT_TARGET !=0) $showtarget[$time] = true;
        
        if($ap->INT_ACTUAL !=0) $showactual[$time] = true;
        $item['jmp'] = '<td class="vcenter" >'.$ap->INT_MP.'</td>';
        $item['chokotei'] = '<td></td>';
        $item['target'] = '<td></td>';
        $item['actual'] = '<td></td>';
        $item['percentage'] = '<td></td>';
        array_push($data, $item);
        ?>
        <!-- ./MAIN -->
        <?php
        $lastime = $time;
        $lasintnum = $ap->INT_NUMBER;
        
        if($n == $approval->num_rows()){
          $item = array();
          $item['tr'] = "<tr>";
          $item['no'] = "<td></td>";
          $item['time'] = "<td></td>";
          $item['wc'] = "<td></td>";
          $item['backno'] = "<td></td>";
          $item['partno'] = "<td></td>";
          $item['partname'] = "<td></td>";
          $PRS = $this->db->get_where('TT_PRODUCTION_RESULT', array('INT_NUMBER'=>$lasintnum))->row();
          $WORK_TIME['CHR_WORK_SHIFT'] = $lastsift;
          $WORK_TIME['CHR_WORK_DAY'] = $lastworkday;
          $wt = $this->db->get_where('TM_WORK_TIME',$WORK_TIME);
          $ct = $this->approval_m->getIntCT($lastwc);
          $qtyph = ( 3600/$ct->row()->INT_CT) *$PRS->INT_MP;
          $tperj = floor((($wt->row()->INT_WORK_HOUR - $getIntLS[$lastime])/60) * $qtyph);
          $actual = $this->approval_m->getActual($lasttimestart,$lastdate,$lastwc);
          $chk = (($tperj * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime] - ((($total_produksi[$lastime] * $ct->row()->INT_CT) / 60) + $getIntLSTotal[$lastime]);
          $danger = false;
          @$persen = $actual->row()->INT_TOTAL_QTY / $tperj * 100;
          
          if($persen < 95) $danger = true;
          
          if($danger) $item['tr'] = "<tr style='background-color:#F00';>";
          
          $item['qtyok'] = '<td class="vcenter">'.$qtyok[$lastime].'</td>'; ?>
          <!-- TM NG -->
          <?php 
          
          if($tmng->num_rows() > 0){
            foreach ($tmng->result() as $ng) {
              $tcm = '';
              
              if($commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime] > 0){
                $tcm = $commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime];
                $item[trim($ng->CHR_NG_CATEGORY_CODE)] ='<td class="vcenter" >'.$commonarr[$ng->CHR_NG_CATEGORY_CODE.'-'.$lastime].'</td>';
              } else $item[trim($ng->CHR_NG_CATEGORY_CODE)] ='<td></td>';
            }

          }

          $item['totalng'] = '<td class="vcenter">'.$commonarr['NG-'.$lastime].'</td>'; ?>
          <!-- ./TM NG -->
          <?php  $item['qtyproduksi'] = '<td class="vcenter" >'.$total_produksi[$lastime].'</td>'; ?>
          <!-- TM LINE STOP -->
          <?php 
          
          if($line_stop->num_rows() > 0){
            foreach ($line_stop->result() as $ls) {
              $tcm = '';
              
              if($commonarr[$ls->CHR_LINE_CODE.'-'.$lastime] > 0){
                $item[trim($ls->CHR_LINE_CODE)] ='<td class="vcenter" >'.$commonarr[$ls->CHR_LINE_CODE.'-'.$lastime].'</td>';
                $tcm = $commonarr[$ls->CHR_LINE_CODE.'-'.$lastime];
              } else {
                $item[trim($ls->CHR_LINE_CODE)] ='<td></td>';
              }

            }

          }

          $item['totalls'] = '<td class="vcenter" >'.$commonarr['LS-'.$lastime].'</td>';
          ?>
          <!-- ./TM LINE STOP -->
          <?php  $item['jmp'] = '<td class="vcenter" >'.$total_mp[$lastime].'</td>'; 
          $item['chokotei'] = '<td class="vcenter" >'.round($chk).'</td>';
          $item['target'] = '<td class="vcenter" >'.$tperj.'</td>';
          $item['actual'] = '<td class="vcenter" >'.$actual->row()->INT_TOTAL_QTY.'</td>';
          $item['percentage'] = '<td class="vcenter" >'.round($persen).'</td>';
         
          array_push($data, $item);
        }

        $n++;
      }

    }
 } ?>
<table class="table">
  <tr>
    <th rowspan="2" class="vcenter">No</th>
    <th rowspan="2" class="vcenter">Jam</th>
    <th rowspan="2" class="vcenter">Work Center</th>
    <th rowspan="2" class="vcenter">Back No.</th>
    <th rowspan="2" class="vcenter">Part No.</th>
    <th rowspan="2" class="vcenter">Part Name & Model</th>
    <th rowspan="2" class="vcenter">Qty OK</th>
    <?php 
    foreach ($showng as $shng) {
      
      if($shng) $spanng++;
    }
  
    if($tmng->num_rows() > 0){
      echo '<th colspan="'.($spanng+1).'" class="vcenter qty-ng-th">Qty NG</th>';
    }
    ?>
    <th rowspan="2" class="vcenter">Total<br />Qty Produksi</th>
    <?php 
    foreach ($showls as $shls) {
      
      if($shls) $spanls++;
    }
    if($line_stop->num_rows() > 0){
      echo '<th colspan="'.($spanls+ 1).'" class="vcenter ls-th">Line Stop</th>';
    }
  ?>
    <th rowspan="2" class="vcenter">Jml MP</th>
    <th rowspan="2" class="vcenter">Chokotei</th>
    <th rowspan="2" class="vcenter">Target/Jam</th>
    <th rowspan="2" class="vcenter">Actual/Jam</th>
    <th rowspan="2" class="vcenter">Percentage</th>
  </tr>
  <tr>
  <!-- TM NG -->
  <?php 
  if($tmng->num_rows() > 0){
    foreach ($tmng->result() as $ng) {
      
      if($showng[trim($ng->CHR_NG_CATEGORY_CODE)]){
        echo '<th class="vcenter">'.$ng->CHR_NG_CATEGORY.'</th>';
      }

    }

    echo '<th class="vcenter">Total</th>';
  }

  ?>
  <!-- ./TM NG -->
  <!-- TM LINE STOP -->
  <?php 
  if($line_stop->num_rows() > 0){
    foreach ($line_stop->result() as $ls) {
      
      if($showls[trim($ls->CHR_LINE_CODE)]){
        echo '<th class="vcenter tbl-'.$ls->CHR_LINE_CODE.'">'.$ls->CHR_LINE_STOP.'</th>';
      }

    }

    echo '<th class="vcenter">Total</th>';
  }

  ?>
  <!-- ./TM LINE STOP -->
  </tr>
  <?php
  foreach($data as $d){
    foreach($d as $k=>$i){
      if(array_key_exists($k, $showng)){
        if($showng[$k]){
          echo $i;
        }
      } else
      if (array_key_exists($k, $showls)){
        
        if($showls[$k]){
          echo $i;
        }
      } else {
        echo $i;
      }
    }
    echo "</tr>";
  }

  ?> 
</table>