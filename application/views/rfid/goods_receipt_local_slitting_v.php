<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting Goods Movement System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting</a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Slitting - Good Receipt</a></li>
             <li><a href="<?php echo base_url('index.php/pes/kanban_master/'); ?>">Good Receipt - Local (Upload)</a></li>

            <li><a href=""><strong>LOCAL SLITTING</strong></a></li>
        </ol>
    </section>


      <section class="content" >
        <div class="row">
          <div class="col-md-12 text-center" >
            <div class="grid">
              <div class="grid-header" style="margin-">
                <div class="panel panel-default">
                  <div class="panel-heading"><strong>PLEASE TAG YOUR RFID</strong></div>
 				</div>
               </div>
              <table class="table table-striped">
              		<tr>
						<th></th>
                        <th></th>
						<th><input type="submit" name="btn_save_post" value="Save/Post" id="submit" class="button" style="height:30px;width:100px;float:right;" ></th>
                    </tr>
                </table>

              <div class="grid-body">
               <table class="table table-striped" id="list_data">
							<thead>
								<tr>
									<th width="auto"  style="text-align:center;vertical-align:middle">No</th>
									<th width="auto" style="text-align:center;vertical-align:middle">PO No</th>
									<th width="auto" style="text-align:center;vertical-align:middle">Part No</th>
						     		<th width="auto" style="text-align:center;vertical-align:middle">Back No</th>
									<th width="auto"  style="text-align:center;vertical-align:middle">SCI No</th>
									<th width="auto" style="text-align:center;vertical-align:middle">Description</th>
									<th width="auto" style="text-align:center;vertical-align:middle">Size</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">QTY(Weight)</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">Unit</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">Date</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">Serial</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">Location</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">Vendor</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">Batch</th>
                                    <th width="auto" style="text-align:center;vertical-align:middle">RFID No</th>
								</tr>
							</thead>
							
							<tbody> 
								
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>
              </div>
              <!-- end grid body -->
            </div>
              <!-- end grid class  -->
          </div>  
        </div>
      </section>
    </aside>