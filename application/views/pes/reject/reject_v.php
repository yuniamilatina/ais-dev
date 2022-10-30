<?php

?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tablemaster.js" ></script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href=""><strong>Master Reject</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER </strong>REJECT</span>        
                    </div>
                    <div class="grid-body"  > <!-- style="background-color: #94D1DC" -->
                    	<div style="width:100%">
                        <form id="formreject" method="POST" action="<?= base_url() ?>index.php/pes/promasdat_c/save_reject">
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
							<input type="button" id="add" value="Add New Row" onClick="addRow('dataTables1')" /> 
                            <input type="button" id="del" value="Delete New Row" onClick="deleteRow('dataTables1','<?php echo $tot_line ;?>')" />
                            <input name="btn_save" id="simpan" type="button" value="Save" />
                            </td>
                          </tr>
                        </table>
                        
                        <table id="dataTables1" width="100%" border="1">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Kode Jenis Reject</th>
                            <th>Deskripsi Reject</th>
                            <th>Kode Kategori Grup Jenis Reject</th>
                            <th>Deskripsi Kategori Grup Jenis Reject</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
        					<?php $i=1;foreach( $rejects as $reject):?>
                          <tr <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>>
                            <td style="width:30px !important"></td>
                            <td <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>><input <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" class="form-control" style="width:100% !important" name="CHR_REJECT_CODE_OLD[]" 		readonly="readonly" id="txt_rc<?php echo $i;?>"		value="<?php echo $reject->CHR_REJECT_CODE;?>" /></td>
                            <td <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>><input <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" class="form-control" style="width:100% !important" name="CHR_REJECT_TYPE_OLD[]" 		readonly="readonly"	id="txt_rt<?php echo $i;?>"		value="<?php echo $reject->CHR_REJECT_TYPE;?>" /></td>
                            <td <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>><input <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" class="form-control" style="width:100% !important" name="CHR_REJECT_GROUP_CODE_OLD[]" readonly="readonly"	id="txt_rgc<?php echo $i;?>"	value="<?php echo $reject->CHR_REJECT_GROUP_CODE;?>" /></td>
                            <td <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>><input <?php If($reject->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> type="text" class="form-control" style="width:100% !important" name="CHR_REJECT_GROUP_OLD[]" 		readonly="readonly" id="txt_rg<?php echo $i;?>"		value="<?php echo $reject->CHR_REJECT_GROUP;?>" /></td>
                          	<?php /*?><td align="center" ><a href="<?php echo base_url('index.php/pes/promasdat_c/delete_reject') . "/" . $reject->CHR_REJECT_CODE ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Reject?');"><span class="fa fa-trash-o"></span></a></td><?php */?>
                          	<td ><label style="width:110px !important; text-align:center !important "  id="td_<?php echo $i;?>"><a onClick="writeEna('<?php echo $i;?>')">edit</a> | <a href="<?php echo site_url()?>/pes/promasdat_c/delete_reject/<?echo trim($reject->CHR_REJECT_CODE) .'/';?><?if($reject->CHR_FLAG_DELETE == 'X'){echo NULL;}else{echo 'X';}?>"><?if($reject->CHR_FLAG_DELETE == 'X'){echo 'un-delete';}else{echo 'delete';}?></a></label>
                                      <label id="fd_<?php echo $i;?>" style="display:none;"><a onClick="cancelEdit('<?php echo $i;?>')">cancel</a> | <a onclick="saveEdit('<?php echo $i;?>')">Save</a></label>
                            </td>
                          </tr>
                          <?php $i++;endforeach;?>
                          <tr>
                          	<td align="center" ><input type="checkbox" name="chk[]" id="ckbx"/></td>
                            <td ><input type="text" class="form-control" style="width:100% !important" name="CODE_NEW[]" 		/></td>
                            <td ><input type="text" class="form-control" style="width:100% !important" name="TYPE_NEW[]"		/></td>
                            <td ><input type="text" class="form-control" style="width:100% !important" name="GROUP_CODE_NEW[]" id="rgc_new" onchange="func(this.value)"/></td>
                            <td ><input type="text" class="form-control" style="width:100% !important" name="GROUP_NEW[]" 	 id="rg_new"	/></td>
                            <td ></td>
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
		   url: '<?= base_url() ?>index.php/pes/promasdat_c/save_reject',
		   dataType: 'json',
		   data: $('#formreject').serialize(),
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
</script>
<script>
function func(selectedValue){
    //make the ajax call
	var data;
    $.ajax({
        url: '<?= base_url() ?>index.php/pes/promasdat_c/get_desc_reject',
        type: 'POST',
        data: 'value='+selectedValue,
        success: function(data) {
            console.log(data); console.log(selectedValue);
			 $("GROUP_NEW[]").html(data);
        }
    });
}
//document.getElementById('rgc_new').onchange = function() { 
////var formreject = document.forms['formreject'];
////    formreject.rg_new.value = 'haha';
//		$.ajax({
//		   type: 'POST',
//		   url: '<?= base_url() ?>index.php/pes/promasdat_c/get_desc_reject',
//		   dataType: 'json',
//		   data: $('#formreject').serialize(),
//		   success: function(data){
//			   console.log(data);
//			  
//		   }
//		});
//}
  function writeEna(rowid){
    
    //var enableTl="#txt_rc"+rowid;
    var enableRt="#txt_rt"+rowid;
	var enableRgc="#txt_rgc"+rowid;
    var enableRg="#txt_rg"+rowid;
    
    $(enableRt).removeAttr('readonly');
    $(enableRgc).removeAttr('readonly');
	$(enableRg).removeAttr('readonly');
    document.getElementById("td_"+rowid).style.display = "none";
    document.getElementById("fd_"+rowid).style.display = "block";
  }
  function cancelEdit(rowid){
    document.location.reload(true);
  }
  function saveEdit(rowid){
    
    var v_Rc = document.getElementById("txt_rc"+rowid).value;
	var v_Rt = document.getElementById("txt_rt"+rowid).value;
    var v_Rgc = document.getElementById("txt_rgc"+rowid).value;
    var v_Rg = document.getElementById("txt_rg"+rowid).value;
    var urls = v_Rc + "/" + v_Rt + "/" + v_Rgc + "/" + v_Rg;
    
    location.href="<?php echo site_url()?>/pes/promasdat_c/reject_save/"+urls;
  }


</script>
