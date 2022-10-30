<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>Work Order Document</strong></a></li>
        </ol>
    </section>
	
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                <form method="post"  action="<?php echo base_url();?>index.php/pes/product_entry_c/save_work_order" class="form-horizontal" role="form" ><!--style="background-color: #94D1DC"-->
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>WORK </strong>ORDER DOCUMENT</span>        
                    </div>
                    <div class="clearfix"></div>
                    <?php if($this->session->flashdata('message')<>''): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message');?>
                        </div>
                       <br/>
                    <?php endif;?>
                    <!--<form id="form1" name="form1" method="post" action="<?php echo base_url();?>/"   ><!--style="background-color: #94D1DC"-->
                     <div class="grid-body"  ><!--style="background-color: #94D1DC"--> 
                     	<!--<input name="save" type="button" value="save" class="btn btn-flat"/><br/><br/>
                       <!-- <div class="grid-body">-->
                       
								
                                	 <br/><br/>
                                     <div class="form-group">
                                            <div class="col-md-6 col-md-offset-1">
                                                <button id="send" type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </div><br/>
									<div class="form-group">
										<label class="col-sm-3 control-label">Tanggal</label>
										<div class="col-sm-2">
											 <input type="text" name="chr_date" class="form-control" id="datepicker" placeholder="" value="<?php echo date('m/d/Y')?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Work Center</label>
										<div class="col-sm-7">
											<select id="e1"  name="tx_work_center"  style="width:300px" class="form-control">
                                             <option ></option>
                                              <?php foreach($work_center->result() as $rows){
                                                 echo '
												 <option value="'.$rows->CHR_WORK_CENTER.'">'.$rows->CHR_WORK_CENTER.'</option>';
                                                  }
                                              ?>
                                          </select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Shift</label>
										<div class="col-sm-3">
											<select name="tx_work_shift"  id="shift" class="form-control" style="width:300px">
											<?PHP
											echo '<option value = ""></option>';
                                            foreach($chr_shift->result() as $rows){
                                            echo '
											
											<option value="'.$rows->CHR_WORK_SHIFT.'">'.$rows->CHR_WORK_SHIFT.'</option>';
                                            }
                                            ?>
                                           </select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">JP</label>
										<div class="col-sm-4">
                                        	<input type="text" name="tx_jp" id="tx_jp" class="form-control angka" style="width:350px" required="required"/>
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-3 control-label">Leader</label>
										<div class="col-sm-4">
                                        	<input type="text" name="tx_leader" id="tx_leader" class="form-control angka" style="width:350px" required="required"/>
										</div>
									</div>
                                    
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 1</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator1" id="tx_operator1" class="form-control angka" style="width:350px" required="required"/>
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-3 control-label">Operator 2</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator2" id="tx_operator2" class="form-control angka" style="width:350px"/>
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-3 control-label">Operator 3</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator3" id="tx_operator3" class="form-control angka" style="width:350px" />
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-3 control-label">Operator 4</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator4" id="tx_operator4" class="form-control angka" style="width:350px"/>
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-3 control-label">Operator 5</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator5" id="tx_operator5" class="form-control angka" style="width:350px"/>
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-3 control-label">Operator 6</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator6" id="tx_operator6" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 7</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator7" id="tx_operator7" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 8</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator8" id="tx_operator8" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 9</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator9" id="tx_operator9" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 10</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator10" id="tx_operator10" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 11</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator11" id="tx_operator11" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 12</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator12" id="tx_operator12" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 13</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator13" id="tx_operator13" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 14</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator14" id="tx_leader14" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Operator 15</label>
										<div class="col-sm-4">
											<input type="text" name="tx_operator15" id="tx_operator15" class="form-control angka" style="width:350px"/>
										</div>
									</div>
									<br/>
                                    
                                   <div class="form-group"><!--value="BDDF01/13022016/SHIFT1" -->
										<label class="col-sm-3 control-label">Work Order No</label>
										<div class="col-sm-4">
                                        <input type="text" name="work_order" id="work_order" class="form-control" required="required" readonly="readonly"/>
										</div>
									</div><br/><br/>
								</form>
							</div>
                         </div>
                       </div>	
                    </div>                                                      
                </div>
  
    </section>
</aside>


<script>
jQuery(document).ready(function () {
	$('#shift').select2();

	$('.angka').keydown(function(e) { 
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

	$('#e1').on('change', function() {
	   renderWorkOrder(); 
	    
	});

	$('#shift').on('change', function() {
		renderWorkOrder(); 

	});

	$('#datepicker').on('change', function() {
		renderWorkOrder(); 

	});

	function renderWorkOrder(){
		var chr_datedate = $.trim($("#datepicker").val());
	    var str = chr_datedate.split("/");
	    var shift =$.trim($("#shift").val());
	    var work_center =$.trim($("#e1").val());

	    
	    if(str.length == 3){
			$('#work_order').val(work_center+'/'+str[1]+str[0]+str[2]+'/SHIFT'+shift);
			
		}
	}

});
 
</script>


<script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script>
