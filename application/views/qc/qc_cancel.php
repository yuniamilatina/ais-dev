<?php
//var_dump($t_times);
?>

    <script>
        $(document).ready(function(){
                $('#no_del').autocomplete({
                    source: "<?php echo site_url('qc/qc/searchCancel'); ?>",
                    minLength:2 ,
                });
        });
    </script> 

<script>
$(document).ready(function() {
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	$("#no_del").focusout(function() {
		var no_do = $("#no_del").val();
		$.ajax({
            type: "POST",
            url: "<?php echo site_url('qc/qc/getTableDOCancel'); ?>",
            data: "no_do=" + no_do,
            success: function(data) {
                $("#table_do").html(data);
                //$("#no_del").attr("readonly", "true");
                var id    = $("#iddatahid").val();
        
                if(id == 1){

                    $("#btn_save").prop('disabled', false);
                }
                else if(id == 0){
                    $("#btn_save").prop('disabled', true);
                }
            }
        });
	});
});

</script>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
</style>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><!-- <a href="<?php echo base_url('index.php/qc/qc/'); ?>"> --><strong>Cancel QC</strong></li>
        </ol>
    </section>
   
    <section class="content">
    <form id ="target" method = "post" action="<?php echo base_url('index.php/qc/qc/saveDataCancel/');?>">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">Cancel QC</span>
                                
                    </div>
    			
                    <div class="grid-body"> 
                    	
                    	<div style="width:100%">
                        <table width="100%">
                          <tr>
                            <td width="230px">
                                <label style="padding-top: 8px;">Nomor Return Delivery Cancel</label>
                            </td>
                            <td>
                                <input type="text" name="no_del" id ="no_del" value="" width="10" autofocus="autofocus" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8' style="padding-left: 5px;margin-top: 5px; border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                            </td>
                            <td align="right"  width="50px">
                                <input class="btn btn-primary" name="btn_save" id="btn_save" type="submit" value="Delete" style="width: 80px;margin-top: 5px; border-radius: 3px;" disabled/>
                            </td>
                          </tr>
                        </table>  
                        <div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px; " id="table_do">
                        </div>                     
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    </form>

<script>
        function cek(){
            var status = false;
            var no_del = document.getElementById('no_del').value;

            if(no_del == ''){
                alert("Maaf, Anda Belum Mengisi Nomor Return Delivery Cancel. Silahkan Isi Terlebih Dahulu.");
                status = false;
            }else{
                status = true;
            }

            return status;
        }
</script>

</aside>