<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/line_stop'); ?>"><strong>Line Stop</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>CREATE </strong>MASTER LINE STOP</span>        
                    </div>
                    <div class="grid-body"  ><!--style="background-color: #94D1DC"-->
                    	<div style="margin-left:70%">
                        <table width="200" border="0">
                          <tr>
                            <td>Legend</td>
                          </tr>
                          <tr>
                            <td>1. TERENCANA</td>
                          </tr>
                          <tr>
                            <td>2. TIDAK TERENCANA</td>
                          </tr>
                        </table>
                          
                    	</div>     
                    	<div style="width:75%">
                        <form method="POST" action="<?= base_url() ?>index.php/pes/promasdat_c/line_stop">
                        <table width="100%">
                          <tr>
                            <td align="left">
							<input type="button" id="add" value="Add" onClick="addRow('dataTable')" /> 
                            <input type="button" id="del" value="Delete" onClick="deleteRow('dataTable')" />
                            <input name="btn_save" id="simpan" type="submit" value="Save" />
                            </td>
                          </tr>
                        </table>
                        
                        <table id="dataTable"  border="1">
                          <tr>
                            <th></th>
                            <th>Kode</th>
                            <th>Line Stop</th>
                            <th>KATEGORI LINE STOP</th>
                          </tr>
        					
                          <tr>
                            <td class="col_cb"><input type="checkbox" name="chk[]" id="ckbx"/></td>
                            <td class="col_1"><input type="text" required="required" class="small"  name="MLS_KODE[]" value="" size="30"></td>
                            <td class="col_2"><input type="text" id="txt_line" required="required" class="small"  name="MLS_LINE[]" value="" size="30"></td>
                            <td class="col_3"><input type="text" id="txt_kat" required="required" class="small"  name="MLS_KAT[]" value="" size="30"></td></td>
                          </tr>
                          
                        </table>
                        </form>
                        </div>
                    </div>                                                      
                </div>
            </div>
        </div>

    </section>
</aside>

<script>

function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	// if(rowCount < 6){							// limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;	
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[1].cells[i].innerHTML;
			
		}
	//}else{
	//	 alert("Maximum Passenger per ticket is 5.");
			   
	//}
	
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 2) { 						// limit the user from removing all the fields
				alert("Cannot Remove all.");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}</script>


