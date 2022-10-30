<?php
//var_dump($t_times);
?>
<script>
$(document).ready(function() {
	$("#no_del").change(function() {
		
		var no_do = $("#no_del").val();
		$.ajax({
            type: "POST",
            url: "<?php echo site_url('qc/qc/getTableDO'); ?>",
            data: "no_do=" + no_do,
            success: function(data) {
                $("#table_do").html(data);
                //$("#no_del").attr("readonly", "true");
            }
        });
	});
	$( "#simpan" ).click(function() {
		  $( "#target" ).submit();
		});
});
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/qc/qc/'); ?>">QC Entry Sheet></li>
            <li><a href=""><strong>Yeahhhhh</strong></a></li>
        </ol>
    </section>
    <form method="POST" id="target" action="<?= base_url() ?>index.php/qc/qc/saveData">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">QC Entry Sheet</span>        
                    </div>
                    
    			
                    <div class="grid-body"  > <!--style="background-color: #94D1DC"-->
                    	
                    	<div style="width:80%">
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
                            <label for="male" class="col-lg-3">Nomor Return Delivery</label>
                            <input type="text" class="col-lg-2" name="no_del" id ="no_del" value="15" width="10" />
                            </td>
                          </tr>
                        </table>  
                        <div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px;" id="table_do">
						
                        
                        </div>                      
                        
                        <table width="100%" class="table table-bordered">
                          <tr>
                            <td align="left">
                            <input name="btn_save" id="simpan" type="button" value="Save" />
                            </td>
                          </tr>
                        </table>
                        </div>
                    </div>                                             
                </div>
            </div>
        </div>

    </section>
    </form>
    
</aside>

