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
            <li><a href=""><strong>Master NG</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER </strong>NG</span>        
                    </div>
                    <div class="grid-body"> 
                    	<div style="width:80%">
                        <form method="POST" id="apalah" action="<?= base_url() ?>index.php/pes/promasdat_c/save_ng">
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
							              <input type="button" id="add" value="Add New Row" onClick="addRow('dataTables1')" /> 
                            <input type="button" id="del" value="Delete New Row" onClick="deleteRow('dataTables1', '<?php echo $tot_line ;?>' )" />
                            <input name="btn_save" id="simpan" type="button" value="Save" />
                            </td>
                          </tr>
                        </table>
                        
                        <table id="dataTables1" width="100%" border="1"  >
                          <thead>
                              <tr>
                                <th></th>
                                <th>Kode Kategori NG</th>
                                <th>Deskripsi NG</th>
                                <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
        					<?php $i=1;foreach( $ngs as $ng):?>
                              <tr <?php If($ng->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?>>
                                <td ></td>
                                <td><input <?php If($ng->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> style="width:100% !important"  required readonly="readonly" type="text"	class="form-control" name="old_code[]" id="txt_cc<?php echo $i;?>" value="<?php echo trim($ng->CHR_NG_CATEGORY_CODE) ; ?>"></td>
                                <td><input <?php If($ng->CHR_FLAG_DELETE == 'X'){echo "style='background-color: #FFE4E1;'";} ?> style="width:100% !important"  required readonly="readonly"	type="text"	class="form-control" name="old_desc[]" id="txt_cd<?php echo $i;?>" value="<?php echo $ng->CHR_NG_CATEGORY;?>"></td>
                                <?php /*?><td align="center" ><a href="<?php echo base_url('index.php/pes/promasdat_c/delete_ng') . "/" . $ng->CHR_NG_CATEGORY_CODE ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this NG?');"><span class="fa fa-trash-o"></span></a></td><?php */?>
                              	<td ><label style="width:110px !important; text-align:center !important "  id="td_<?php echo $i;?>"><a onClick="writeEna('<?php echo $i;?>')">edit</a> | <a href="<?php echo site_url()?>/pes/promasdat_c/delete_ng/<?echo trim($ng->CHR_NG_CATEGORY_CODE) .'/';?><?if($ng->CHR_FLAG_DELETE == 'X'){echo NULL;}else{echo 'X';}?>"><?if($ng->CHR_FLAG_DELETE == 'X'){echo 'un-delete';}else{echo 'delete';}?></a></label>
                                      <label id="fd_<?php echo $i;?>" style="display:none;"><a onClick="cancelEdit('<?php echo $i;?>')">cancel</a> | <a onclick="saveEdit('<?php echo $i;?>')">Save</a></label>
                            	</td>
                              </tr>
                          
                          	<?php $i++;endforeach;?>
                              <tr>
                                <td align="center" ><input type="checkbox" name="chk[]" id="ckbx"/></td>
                                <td> 				<input type="text" 		name="new_code[]" required class="form-control" style="width:100% !important"/></td> 
                                <td>				<input type="text" 		name="new_desc[]" required class="form-control" style="width:100% !important"/></td>
                                <span ><?php echo validation_errors(); ?></span>
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
		   url: '<?= base_url() ?>index.php/pes/promasdat_c/save_ng',
		   dataType: 'json',
		   data: $('#apalah').serialize(),
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
    var enableCc="#txt_cc"+rowid;
	var enableCd="#txt_cd"+rowid;
    
    //$(enableCc).removeAttr('readonly');
    $(enableCd).removeAttr('readonly');
    document.getElementById("td_"+rowid).style.display = "none";
    document.getElementById("fd_"+rowid).style.display = "block";
  }
  function cancelEdit(rowid){
    document.location.reload(true);
  }
  function saveEdit(rowid){
    
    var v_Cc = document.getElementById("txt_cc"+rowid).value;
	var v_Cd = document.getElementById("txt_cd"+rowid).value;
    var urls = v_Cc + "/" + v_Cd ;
    
    location.href="<?php echo site_url()?>/pes/promasdat_c/ng_save/"+urls;
  }
</script>

