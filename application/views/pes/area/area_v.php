<?php
//var_dump ("reza",$last);
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tablemaster.js" ></script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href=""><strong>Master AREA</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER </strong>AREA</span>        
                    </div>
                    <div class="grid-body"> 
                    	<div style="width:80%">
                        <form method="POST" id="area" action="<?= base_url() ?>index.php/pes/promasdat_c/save_area">
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
							<input type="button" id="add" value="Add New Row" onClick="addRow('dataTables1')" /> 
                            <input type="button" id="del" value="Delete New Row" onClick="deleteRow('dataTables1', '<?php echo $tot_line ;?>' )" />
                            <input name="btn_save" id="simpan" type="button" value="Save" />
                            </td>
                          </tr>
                        </table>
                        
                        <table id="dataTables1" width="100%" border="1" class="display"  >
                          <thead>
                          <tr>
                          	<th></th>
                            <th class="col-lg-6">Kode Area</th>
                            <th class="col-lg-6">Deskripsi Area</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
        					<?php $i=1;foreach( $areas as $area):?>
                          <tr <?php If($area->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>>
                            <td style="width:30px !important; "></td>
                            <td><input <?php If($area->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> style="width:100% !important" required  type="text"	readonly="readonly" name="old_area[]" id="txt_ca<?php echo $i;?>" class="form-control" value="<?php echo trim($area->CHR_AREA);?>"></td>
                            <td><input <?php If($area->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> style="width:100% !important" required  type="text"	readonly="readonly"	name="old_desc[]" id="txt_da<?php echo $i;?>" class="form-control" value="<?php echo $area->CHR_DESC_AREA;?>"></td>
                            <?php /*?><td align="center" ><a href="<?php echo base_url('index.php/pes/promasdat_c/delete_area') . "/" . $area->CHR_AREA ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Area?');"><span class="fa fa-trash-o"></span></a></td><?php */?>
                         	<td ><label style="width:110px !important; text-align:center !important "  id="td_<?php echo $i;?>"><a onClick="writeEna('<?php echo $i;?>')">edit</a> | <a href="<?php echo site_url()?>/pes/promasdat_c/delete_area/<?echo trim($area->CHR_AREA) .'/';?><?if($area->CHR_FLAG_DELETE == 'X'){echo NULL;}else{echo 'X';}?>"><?if($area->CHR_FLAG_DELETE == 'X'){echo 'un-delete';}else{echo 'delete';}?></a></label>
                                      <label id="fd_<?php echo $i;?>" style="display:none;"><a onClick="cancelEdit('<?php echo $i;?>')">cancel</a> | <a onclick="saveEdit('<?php echo $i;?>')">Save</a></label>
                            	</td>
                          </tr>
                          
                          <?php $i++;endforeach;?>
                          <tr>
                          	<td align="center"><input type="checkbox" 	name="chk[]" id="ckbx"/></td>
                            <td><input type="text" 	name="new_area[]" required style="width:100% !important"/></td> <?php /*?>placeholder="NG<?php echo $lastno + 1 ; ?>"<?php */?> 
                            <span ><?php echo validation_errors(); ?></span>
                            <td><input type="text" 	name="new_desc[]" required style="width:100% !important"/></td>
                            <td></td>
                          </tr>
                         </tbody>
                        </table>
                        </form>
                        </div>
                    </div>                                                      
                </div>
          </div>
        </div>

    </section>
</aside>
<script type="text/javascript">
$(document).ready(function() {
	$('#simpan').click(function(){
		$.ajax({
		   type: 'POST',
		   url: '<?= base_url()?>index.php/pes/promasdat_c/save_area',
		   dataType: 'json',
		   data: $('#area').serialize(),
		   success: function(data){
			   console.log(data);
			  if(data==true){
				 	location.reload();
			   } else {
			   		alert(data);
			   }
		   }
		});
	});
});

function writeEna(rowid){
    
    //var enableTl="#txt_rc"+rowid;
    var enableCa="#txt_ca"+rowid;
	var enableDa="#txt_da"+rowid;
    
    //$(enableCc).removeAttr('readonly');
    $(enableDa).removeAttr('readonly');
    document.getElementById("td_"+rowid).style.display = "none";
    document.getElementById("fd_"+rowid).style.display = "block";
  }
  function cancelEdit(rowid){
    document.location.reload(true);
  }
  function saveEdit(rowid){
    
    var v_Ca = document.getElementById("txt_ca"+rowid).value;
	var v_Da = document.getElementById("txt_da"+rowid).value;
    var urls = v_Ca + "/" + v_Da ;
    
    location.href="<?php echo site_url()?>/pes/promasdat_c/area_save/"+urls;
  }
</script>

