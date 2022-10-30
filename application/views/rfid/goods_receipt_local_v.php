<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting Goods Movement System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting</a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting - Good Receipt</a></li>

            <li><a href=""><strong>GOOD RECEIPT - LOCAL (UPLOAD) </strong></a></li>
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
					<input type="submit" name="btn_browse" value="Browse" id="submit" class="button" style="height:30px;width:100px;">
                    <input type="text" name="upload_excel" style="width:80px;height:25px;" >
                    <input type="submit" name="btn_upload" value="Upload" id="submit" class="button" style="height:30px;width:100px;">
                </div>
                
              </div>
              <!-- end grid body -->
            </div>
              <!-- end grid class  -->
          </div>  
        </div>
      </section>
    </aside>