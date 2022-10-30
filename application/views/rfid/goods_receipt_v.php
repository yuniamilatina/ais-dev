<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting Goods Movement System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting</a></li>
            <li><a href=""><strong>SLITTING - GOOD RECEIPT</strong></a></li>
        </ol>
    </section>


      <section class="content" >
        <div class="row">
          <div class="col-md-12 text-center" >
            <div class="grid">
              <div class="grid-header" style="margin-">
                <div class="panel panel-default">
                  <div class="panel-heading"><strong>INPUT GOOD RECEIPT DATA</strong></div>
                </div>
              </div>
              <div class="grid-body">
                <div class="btn-group">
                  <a href="<?php echo base_url('index.php/rfid/slitting_c/goods_receipt_local_v'); ?>" class="btn btn-info btn-md" style="width:200px;margin-right:20px" role="button">LOCAL</a>
                  <a href="<?php echo base_url('index.php/rfid/slitting_c/goods_receipt_import_v'); ?>" class="btn btn-info btn-md" style="width:200px;" role="button">IMPORT</a><br>
                  
                </div>
              </div>
              <!-- end grid body -->
            </div>
              <!-- end grid class  -->
          </div>  
        </div>
      </section>
    </aside>