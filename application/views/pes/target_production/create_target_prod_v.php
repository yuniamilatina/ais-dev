<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/target_production'); ?>"><strong>Target Production</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>CREATE </strong>MASTER TARGET PRODUCTION</span>        
                    </div>
                    <div class="grid-body"  ><!--style="background-color: #94D1DC"-->   
                    	<div style="width:75%">
                        <form method="POST" action="<?= base_url() ?>index.php/pes/promasdat_c/create_target_prod">
                        <table width="100%">
                          <tr>
                            <td align="left">
							<input type="button" id="add" value="Add" onClick="addRow('dataTable')" /> 
                            <input type="button" id="del" value="Delete" onClick="deleteRow('dataTable')" />
                            <input name="btn_save" id="simpan" type="submit" value="Save" />
                            </td>
                          </tr>
                        </table>
                        
                        <table id="dataTable" width="100%" border="1">
                          <tr>
                            <th></th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Line</th>
                            <th>Qty / Jam</th>
                          </tr>
        					
                          <tr>
                            <td class="col_cb"><input type="checkbox" name="chk[]" id="ckbx"/></td>
                            <td class="col_1"><input type="text" required="required" class="small"  name="COL_BLN[]" value=""></td>
                            <td class="col_2"><input type="text" required="required" class="small"  name="COL_THN[]" value=""></td>
                            <td class="col_3"><input type="text" required="required" class="small"  name="COL_LINE[]" value=""></td>
                            <td class="col_4"><input type="text" required="required" class="small"  name="COL_QTY[]" value=""></td>
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


