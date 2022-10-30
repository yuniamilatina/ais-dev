<?php
//var_dump ("reza",validation_errors());
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tablemaster.js" ></script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href=""><strong>Line Stop</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER</strong>LINE STOP</span>        
                    </div>
                    <div class="grid-body" >
                    	<div >
                        <table width="200" border="0">
                          <tr>
                            <td>Legend Kategori Line Stop</td>
                          </tr>
                          <tr>
                            <td><strong>1. TERENCANA</strong></td>
                          </tr>
                          <tr>
                            <td><strong>2. TIDAK TERENCANA</strong></td>
                          </tr>
                        </table>
                          
                    	</div>     
                    	<div style="width:75%">
                        <form method="POST" id="linestop" action="<?= base_url() ?>index.php/pes/promasdat_c/save_linestop">
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
							<input type="button" id="add" value="Add New Row" onClick="addRow('dataTables1')" /> 
                            <input type="button" id="del" value="Delete New Row" onClick="deleteRow('dataTables1', '<?php echo $tot_line ;?>')" />
                            <input name="btn_save" id="simpan" type="button" value="Save" />
                            </td>
                          </tr>
                        </table>
                        
                        <table id="dataTables1" width="100%" border="1">
                          <thead>
                          <tr>
                            <th></th>
                            <th>Kode</th>
                            <th>Line Stop</th>
                            <th>KATEGORI LINE STOP</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
        					<?php $i=1;foreach( $parts as $part):?>
                          <tr <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>>
                            <td align="center"><?php /*?><?php echo $i ?><?php */?></td>
                            <td <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> ><input <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" readonly="readonly" required="required" class="form-control"  name="MLS_KODE[]" value="<?php echo trim($part->CHR_LINE_CODE);?>" style="width:100% !important" id="txt_kode<?php echo $i;?>"></td>
                            <td <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> ><input <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" readonly="readonly" required="required" class="form-control"  name="MLS_LINE[]" value="<?php echo trim($part->CHR_LINE_STOP);?>" style="width:100% !important" id="txt_line<?php echo $i;?>"></td>
                            <td <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> ><input <?php If($part->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" readonly="readonly" required="required" class="form-control"  name="MLS_KAT[]"  value="<?php echo trim($part->CHR_LINE_CAT);?>"  style="width:100% !important" id="txt_kat<?php echo $i;?>" ></td>
                          	<?php /*?><td align="center" ><a href="<?php echo base_url('index.php/pes/promasdat_c/delete_linestop') . "/" . $part->CHR_LINE_CODE ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this line stop?');"><span class="fa fa-trash-o"></span></a></td><?php */?>
                            <td><label style="width:110px !important; text-align:center !important " id="td_<?php echo $i;?>"><a onClick="writeEna('<?php echo $i;?>')">edit</a> | <a href="<?php echo site_url()?>/pes/promasdat_c/delete_linestop/<?echo trim($part->CHR_LINE_CODE) .'/';?><?if($part->CHR_FLAG_DELETE == 'X'){echo NULL;}else{echo 'X';}?>"><?if($part->CHR_FLAG_DELETE == 'X'){echo 'un-delete';}else{echo 'delete';}?></a></label>
                                      <label id="fd_<?php echo $i;?>" style="display:none;"><a onClick="cancelEdit('<?php echo $i;?>')">cancel</a> | <a onclick="saveEdit('<?php echo $i;?>')">Save</a></label>
                            </td>
                          
                          </tr>
                          <?php $i++;endforeach;?>
                          	<td ><input type="checkbox" name="chk[]" id="ckbx"/></td>
                            <td><input name="new_codels[]" required="required" type="text" class="form-control" style="width:100% !important"/></td>
                            <td> <input name="new_line[]" required="required" type="text" class="form-control" style="width:100% !important"/></td>
                          	<td> <input name="new_kat[]" required="required" type="text" class="form-control" style="width:100% !important"/></td>
                            <td></td>
                            <span ><?php echo validation_errors(); ?></span>
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
		   url: '<?= base_url() ?>index.php/pes/promasdat_c/save_linestop',
		   dataType: 'json',
		   data: $('#linestop').serialize(),
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
    
    var enableTl="#txt_line"+rowid;
    var enableTk="#txt_kat"+rowid;
    
    $(enableTl).removeAttr('readonly');
    $(enableTk).removeAttr('readonly');
    document.getElementById("td_"+rowid).style.display = "none";
    document.getElementById("fd_"+rowid).style.display = "block";
  }
  function cancelEdit(rowid){
    document.location.reload(true);
  }
  function saveEdit(rowid){
    
    var v_tl = document.getElementById("txt_line"+rowid).value;
    var v_tk = document.getElementById("txt_kat"+rowid).value;
    var v_tc = document.getElementById("txt_kode"+rowid).value;
    var urls = v_tc + "/" + v_tl + "/" + v_tk;
    
    location.href="<?php echo site_url()?>/pes/promasdat_c/linestop_save/"+urls;
  }
</script>