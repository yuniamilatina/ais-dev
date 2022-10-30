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
            }
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
        
        var del_value = parseInt(document.getElementById(del).value);
        var good_value = parseInt(document.getElementById(goods).value);
        var repair_value = parseInt(document.getElementById(repair).value);
        var claim_value = parseInt(document.getElementById(claim).value);
        var scrap_value = parseInt(document.getElementById(scrap).value);
        var total = good_value+repair_value+claim_value+scrap_value;
        var selisih = del_value - total;
        if(selisih >= 0){
        	document.getElementById(status).value = 'GOOD';
        }
        else{
        	document.getElementById(status).value = 'NG';
        }
    function test(){
        alert('rere');
    	return event.charCode >= 48 && event.charCode <= 57;
    }
            
        //alert(total);
        
    }
    
    
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><!-- <a href="<?php echo base_url('index.php/qc/qc/'); ?>"> --><strong>QC Entry Sheet</strong></li>
        </ol>
    </section>
    <form id ="target" method = "post" action="<?php echo base_url('index.php/qc/qc/saveData/');?>">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">QC Entry Sheet</span>        
                    </div>
                    
    			
                    <div class="grid-body"  ><!--style="background-color: #94D1DC"--> 
                    	
                    	<div style="width:100%">
                        <table width="100%">
                          <tr>
                            <td align="left">
                                <label for="male" class="col-lg-3" style="padding-top: 5px;">Nomor Return Delivery</label>
                                <input type="text"  name="no_del" id ="no_del" value="" width="10" autofocus="autofocus" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8' style="padding-left: 5px;margin-top: 5px;">
                            </td>
                            <td align="right">
                                <input name="btn_save" id="simpan" type="submit" value="Save" style="width: 80px;margin-top: 5px;" onclick = "click()" />
                            </td>
                          </tr>
                        </table>  
                        <div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px;" id="table_do">
                        </div>                     
                        <table width="100%" >
                          <tr>
                            <td align="left">
                                
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

