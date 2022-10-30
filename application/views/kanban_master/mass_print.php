<?php
session_start();
?>
<script>
$('#myTab a').click(function(e) {
e.preventDefault();
$(this).tab('show');
});

// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  var id = $(e.target).attr("href").substr(1);
  window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#myTab a[href="' + hash + '"]').tab('show');
});
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Kanban Master System</a></li>
            <li><a href=""><strong>KANBAN MASTER</strong></a></li>
        </ol>
    </section>

    <section class="content" >
        <div class="row">
          <div class="col-md-12 text-center" >
            <div class="grid">
              <div class="grid-header" style="margin-">
                <div class="panel panel-default">
                  <div class="panel-heading"><strong>Mass Print</strong></div>
                </div>
              </div>
              <div class="clearfix"></div>
                    <?php if($this->session->flashdata('message')<>''): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message');?>
                        </div>
                       <br/>
                    <?php endif;?>
              <div class="grid-body">
                <ul class="nav nav-tabs" id="myTab" >
                  <li class="active" ><a data-toggle="tab" href="#proses_v">Proses</a></li>
                  <li><a data-toggle="tab" href="#pickup_v">Pick Up</a></li>
                </ul>
                  <!-- begin tab proses -->
                  <div id="proses_v" class="tab-pane fade in active">
                      <!-- baris 1 -->
                      <form method="post" action="<?= base_url() ?>index.php/pes/kanban_master/massprintpr">
                        <div class="row" style="margin-top:20px;">
                          <div class="col-sm-6">
                            <label>No. Kanban</label>
                            <select id="from" name="from" style="width:80px">
                            <option  value=""></option>
                                <?php 
                                foreach ($idproses as $show):  ?>
                                <option  value="<?php echo $show->INT_KANBAN_NO;?>"><?php echo ucfirst($show->INT_KANBAN_NO);?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>To</label>
                            <select id="to" name="to" style="width:80px">
                            <option  value=""></option>
                                <?php 
                                foreach ($idproses as $show):  ?>
                                <option  value="<?php echo $show->INT_KANBAN_NO;?>"><?php echo ucfirst($show->INT_KANBAN_NO);?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      <!-- end row 1 -->
                     <!-- baris ke 2 -->
                      <div class="row" style="margin-top:20px;" >
                        <div class="col-sm-6">
                          <input type="submit" name="mppr" id="mppr" class="btn btn-info btn-md" value="PRINT">
                        </div>
                        <div class="col-sm-6">
                          <a href="<?= base_url() ?>index.php/pes/kanban_master" class="btn" style="background-color:#66ccff;width:100px;height:30px" >Cancel</a>
                        </div>
                      </div>
                      </form>
                      <!-- end row 2 -->
                  </div>
                  <!-- end tab proses -->

                  <!-- begin tab pickup -->
                  <div id="pickup_v" class="tab-pane fade">
                      <!-- baris 1 -->
                      <form method="post" action="<?= base_url() ?>index.php/pes/kanban_master/massprintpu">
                        <div class="row" style="margin-top:20px;">
                          <div class="col-sm-6">
                            <label>No. Kanban</label>
                            <select id="from" name="from" style="width:80px">
                            <option  value=""></option>
                                <?php 
                                foreach ($idpickup as $show):  ?>
                                <option  value="<?php echo $show->INT_KANBAN_NO;?>"><?php echo ucfirst($show->INT_KANBAN_NO);?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>To</label>
                            <select id="to" name="to" style="width:80px">
                            <option  value=""></option>
                                <?php 
                                foreach ($idpickup as $show):  ?>
                                <option  value="<?php echo $show->INT_KANBAN_NO;?>"><?php echo ucfirst($show->INT_KANBAN_NO);?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      <!-- end row 1 -->
                     <!-- baris ke 2 -->
                      <div class="row" style="margin-top:10px;margin-bottom:10px" >
                          <div class="col-sm-6">
                            <input type="submit" name="mppu" id="mppu" class="btn btn-info btn-md" value="PRINT">
                          </div>
                          <div class="col-sm-6">
                            <a href="<?= base_url() ?>index.php/pes/kanban_master" class="btn" style="background-color:#66ccff;width:100px;height:30px" >Cancel</a>
                          </div>
                        </form>
                      </div>
                      <!-- end row 2 -->
                  </div>
                  <!-- end tab pickup -->
              </div>
              <!-- end grid body -->
        </div>
        <!-- end grid class  -->
      </div>  
    </div>
  </section>
</aside>

  