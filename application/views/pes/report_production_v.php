<?php
session_start();
?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>Report Production</strong></a></li>
        </ol>
    </section>

      <section class="content" >
        <div class="row">
          <div class="col-md-12 text-center" >
            <div class="grid">
              <div class="grid-header">
                <div class="panel panel-default">
                  <div class="panel-heading"><strong>Report Production</strong></div>
                </div>
              </div>
              <div class="grid-body">

              <div class="row">
                <form class="form-inline" method="post" id="form" action="">
					<div class="form-group">
						<label class="col-sm-3 control-label">Line</label>
						<div class="col-sm-7">
							<select id="e1"  name="tx_line" class="populate" style="width:120px">

							  <?php foreach($work_center->result() as $rows){
								 echo ' <option value="'.$rows->CHR_WORK_CENTER.'">'.$rows->CHR_WORK_CENTER.'</option>';
								  }
							  ?>
						  </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tanggal</label>
						<div class="col-sm-3">
							 <input type="text" name="chr_date" class="form-control" id="datepicker" placeholder="" value="<?php echo date('m/d/Y')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Shift</label>
						<div class="col-sm-7">
							<select id="e2"  name="tx_shift" class="populate" style="width:80px">
							 <option >1</option>
							 <option >2</option>
							 <option >3</option>
							 <option >4</option>
							 <option >ALL</option>
							  <?php //foreach($work_center->result() as $rows){
								 //echo ' <option value="'.$rows->CHR_WORK_CENTER.'">'.$rows->CHR_WORK_CENTER.'</option>';
								 // }
							  ?>
						  </select>
						</div>
					</div><br><br>
                  <div class="form-group">
                    <input type="submit" class="btn" name="export_summary" id="export_summary" value="EXPORT SUMMARY" style="margin-right:50px;background-color:#66ccff;">
					<!--input type="submit" class="btn" name="export_detil" id="export_detil" value="EXPORT DETIL" style="margin-right:50px;background-color:#66ccff;"-->
       
                    <a href="<?= base_url() ?>index.php/basis/home_c" class="btn" style="background-color:#66ccff;width:100px" >Close</a>
                  </div>
                </form>
              </div>

              </div>
              <!-- end grid body -->
            </div>
              <!-- end grid class  -->
          </div>  
        </div>
      </section>
    </aside>

