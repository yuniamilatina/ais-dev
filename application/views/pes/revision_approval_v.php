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
            <li><a href=""><strong>Revision Approval Production Execution</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid" ><!-- style="background-color: #94D1DC" -->
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">REVISION APPROVAL PRODUCTION EXECUTION</span>
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

                    <form class="form-horizontal" role="form" method="get" action="<?php echo base_url()?>index.php/pes/revision_approval_c/index">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">TANGGAL</label>
                          <div class="col-sm-2">
                            <input type="text" autocomplete="off" name="date" id="datepicker" class="form-control" value="<?php echo $tanggal?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">NPK LEADER</label>
                          <div class="col-sm-2">
                            <input type="text" autocomplete="off" id="npkleader" class="form-control" required="true" name="npkleader" value="<?php echo $npkleader?>" />
                          </div>

                          <div class="col-sm-2">
                                <button type="submit" class="md-trigger btn btn-primary pull-left">GO</button>
                              </div>

                        </div>
                      </form>
                    
                      <?php if($npkleader && $tanggal){?>
                      <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url()?>index.php/pes/revision_approval_c/update">
                      <input type="hidden" name="npkleader" value="<?php echo $npkleader?>"></input>
                      <input type="hidden" name="tanggal" value="<?php echo $tanggal?>"></input>
                      <input type="submit" value="Execute" class="btn btn-default pull-left">
                      
                      <div style="width: 100%; clear: both; height: 2px;"></div>`
                      <div style="overflow-x:scroll; overflow-y: hidden;">
                      <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="vcenter">No</th>
                              <th class="vcenter">Jam</th>
                              <th class="vcenter">Work Center</th>
                              <th class="vcenter">Back No.</th>
                              <th class="vcenter">Part No.</th>
                              <th class="vcenter">Part Name & Model</th>
                              <th class="vcenter">Total Qty<br />Produksi</th>
                              <th class="vcenter">Revise</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                            if($revise->num_rows() > 0){
                              $n = 1;
                              foreach ($revise->result() as $r) {
                                  echo "<tr>
                                          <td class='vcenter'>$n</td>
                                          <td class='vcenter'>".substr_replace(trim($r->CHR_WORK_TIME_START),":",2,0)."-".substr_replace(trim($r->CHR_WORK_TIME_END),":",2,0)."</td>
                                          <td class='vcenter'>".trim($r->CHR_WORK_CENTER)."</td>
                                          <td class='vcenter'>".trim($r->CHR_BACK_NO)."</td>
                                          <td class='vcenter'>".trim($r->CHR_PART_NO)."</td>
                                          <td>".trim($r->CHR_PART_NAME)."</td>
                                          <td>
                                              <input type='hidden' name='int_number[]' class='form-control input-change' value='$r->INT_NUMBER'>

                                              <input type='text' name='qty_".$r->INT_NUMBER."' class='form-control input-change' value='$r->INT_TOTAL_QTY'>
                                          </td>
                                          <td class='vcenter'>
                                          <input type='checkbox' name='revise_".$r->INT_NUMBER."' class='form-control app-check'>
                                          </td>
                                        </tr>";  
                                  $n++;
                              }
                            }
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
</script>