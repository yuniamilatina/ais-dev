<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">SELAMAT DATANG MASUKAN KODE AREA</span>
    </div>

    <div class="grid-body">
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/check')?>" class="form-horizontal">
            <input type="submit" value="Save" class="btn btn-primary pull-right"></input>
            <input type="hidden" name="ng_area"></input>
            <center>
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
			<div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$this->session->flashdata('error');?></h4></div>
            <?php if (is_array($location)): ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Location</label>
                    <div class="col-sm-4">
                            <select name="CHR_SLOC_FROM" class="form-control">
                                <?php foreach ($location as $value): ?>
                                 <option value="<?php echo $value;?>"><?php echo $value;?></option>
                                <?php endforeach;?>
                            </select>
                    </div>
                 </div>
            <?php else:?>
                <input type="hidden" name="CHR_SLOC_FROM"  class="form-control" value="<?php echo $location;?>"></input>
            <?php endif;?>
			
            <?php if (isset($wc)): //add by reza req by vivin?> 
                <div class="form-group">
                    <label class="col-sm-2 control-label">Work Center</label>
                    <div class="col-sm-4">
                            <select name="CHR_WORK_CENTER" class="form-control" onchange="getarea(this.value)">
								<option value="" >-----</option>
                                <?php foreach ($wc as $wcvalue): ?>
                                 <option value="<?php echo $wcvalue->CHR_WORK_CENTER;?>" ><?php echo $wcvalue->CHR_WORK_CENTER;?></option>
                                <?php endforeach;?>
                            </select>
                    </div>
                 </div>
            <?php endif; // end?>
                       
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Area</label>
                 <?php if (isset($wc)): ?>
                    <div class="col-sm-4">
                    	<input id="CHR_AREA" name="CHR_AREA" required class="form-control" readonly="readonly"></input>
                        <input id="CHR_DESC_AREA" type="hidden" name="CHR_DESC_AREA" readonly="" required></input>
                    </div>
                 <?php else:?> 
                    <div class="col-sm-4">
                        <select name="CHR_AREA" class="form-control">
                            <?php foreach ($area as $value): ?>
                             <option value="<?php echo $value->CHR_AREA;?>" <?php echo ($value->CHR_AREA == @$CHR_AREA)? "selected" : "";  ?>><?php echo $value->CHR_AREA.", ". $value->CHR_DESC_AREA;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                  <?php endif; // end?>
                 </div>
            
            </div>
			
            </center>
        </form>
    </div>
</div>

<script>
function getarea(wc){
//	var var_wc = document.getElementsByName('CHR_WORK_CENTER');	
	$.ajax({
		   type: 'POST',
		   url: '<?= base_url() ?>index.php/pes/ng_no_locking/get_area',
		   dataType: 'json',
		   data: {wc : wc},
		   success: function(data){
			   console.log(data);
			  if(data){
				 	document.getElementById('CHR_AREA').value = data[0]['CHR_AREA'];
				 	// document.getElementById('CHR_AREA').text = data[0]['CHR_DESC_AREA'];
					// element.option[element.selectedIndex].text = data[0]['CHR_DESC_AREA'];
					document.getElementById('CHR_DESC_AREA').value = data[0]['CHR_DESC_AREA'];
					
			   } else {
			   		alert(data);
			   }
		   }
		});
}
</script>