<?php
//var_dump($t_times);
?>
<script>
$(document).ready(function() {
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	$("#no_del").change(function() {
		var no_do = $("#no_del").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('qc/qc/getTableDO'); ?>",
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

    $(document).ready(function(){
            $('#no_del').autocomplete({
                source: "<?php echo site_url('qc/qc/search'); ?>",
                minLength:1 ,
            });
    });
});

</script>
<script>
	function checkVal(x) {
        var del = "del_" + x;
        var goods = "good_" + x;
        var repair = "repair_" + x;
        var claim = "claim_" + x;
        var scrap = "scrap_" + x;
        var status = "status_" + x;
        var slocto = "slocto_" + x;
        var field = "field_" + x;
        
        var del_value = parseInt(document.getElementById(del).value);
        var good_value = parseInt(document.getElementById(goods).value);
        var repair_value = parseInt(document.getElementById(repair).value);
        var claim_value = parseInt(document.getElementById(claim).value);
        var scrap_value = parseInt(document.getElementById(scrap).value);
        var total = good_value+repair_value+claim_value+scrap_value;
        var selisih = del_value - total;
        if(selisih == 0){
        	document.getElementById(status).value = 'GOOD';
            document.getElementById(status).style.backgroundColor = 'green';
            document.getElementById(status).style.color = 'white';
        }
        else{
        	document.getElementById(status).value = 'NG';
            document.getElementById(status).style.backgroundColor = 'red';
            document.getElementById(status).style.color = 'white';
        }
    }
   
</script>

   <!-- Memanggil file .js untuk proses autocomplete -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.autocomplete.js"></script>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
</style>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><!-- <a href="<?php echo base_url('index.php/qc/qc/'); ?>"> --><strong>QC Entry Sheet</strong></li>
        </ol>
    </section>
    
    <section class="content">
    <form id ="target" method = "post" action="<?php echo base_url('index.php/qc/qc/saveData/');?>" onsubmit="return validateForm()">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">QC Entry Sheet</span>
                               
                    </div>
    			
                    <div class="grid-body"> 
                    	
                    	<div style="width:100%">
                        <table width="100%">
                          <tr>
                            <td align="left">
                                <label for="male" class="col-lg-3" style="padding-top: 5px;">Nomor Return Delivery</label>
                                <input type="text" name="no_del" id ="no_del" value="" width="10" autofocus="autofocus" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8' style="padding-left: 5px;margin-top: 5px; border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                            </td>
                            <td align="right" width="50px">
                                <input class="btn btn-primary" name="btn_save" id="btn_save" type="submit" value="Save" style="width: 80px;margin-top: 5px;border-radius: 3px;" disabled/>
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

        function validateForm() {
            var status = true;
            var data = document.getElementById('no').value;
            for(var i = 1; i<data; i++){
                var status = document.getElementById("status_" + i).value;
                if(status == "NG" || status == ""){
                    status = false;
                    break;
                }
            }

            if(status == false){
                alert("Maaf, data tidak dapat disimpan karena input quantity salah.");
           	}

            return status;
        }
        
        function cek(){
        	var status = false;
            var no_del = document.getElementById('no_del').value;

        	if(no_del == ''){
            	alert("Maaf, Anda Belum Mengisi Nomor Return Delivery. Silahkan Isi Terlebih Dahulu.");
            	status = false;
            }else{
            	status = true;
            }

            return status;
        }

    </script>


    
</aside>