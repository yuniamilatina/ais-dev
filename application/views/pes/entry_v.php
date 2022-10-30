<?php
if ($set == 2) {
?>
<script>
alert('Maaf, Data sudah di-approve');
window.location.href= "<?php echo site_url()?>/pes/prodentry_c/form/<?php echo $date_l; ?>/<?php echo $shift; ?>/<?php echo $wcenter_l; ?>/1";
</script>

<?php

}
?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>Production Entry</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>PRODUCTION</strong> ENTRY SYSTEM</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">
                                            
                        <table width="100%">
                                <tr>
                                        <td width="5%" rowspan="4">Sort By</td>
                                        <td width="1%" align="right"><input type="radio" name="filter" <?php if($defaultSearch=='part_number'){echo 'checked="checked"';} ?> onclick = "clearBoxPartNo()"/></td>
                                        <td width="15%" height="30" style="border-right:0px">Part Number</td><td width="10">:</td><td><input id="search_part_number" type="text" name="name" placeholder="Part Number" size="30" <?php if($defaultSearch!='part_number'){echo 'disabled="true"';} ?>></td>
                                        <td width="3%" rowspan="4"></td>
                                        <td width="10%">Tanggal</td><td  width="10">:</td>
                                        <td>
                                            <input type="text" id="datepicker" placeholder="DD/MM/YYYY" value="<?php echo $date;?>" <?php if($set==1){echo 'disabled="yes"';}else{echo '';} ?>> <input type="submit" style="height:40px;width:70px;" name="send" value="<?php if($set==1){echo 'Un-Set';}else{echo 'Set';} ?>" id="submit" class="<?php if($set==1){echo 'active';}else{echo 'button';} ?>" onClick="getLocation()">
                                        </td>
                                </tr>
                                <tr>
                                        <td width="10"><input type="radio" name="filter" <?php if($defaultSearch=='back_number'){echo 'checked="checked"';} ?> onclick = "clearBoxBackNo()" /></td>
                                        <td width="140"  height="30" >Back Number</td><td>:</td><td><input id="search_back_number" type="text" name="name" placeholder="Back Number" <?php if($defaultSearch!='back_number'){echo 'disabled="true"';} ?>></td>
                                        <td width="150"  height="30" >Work Center</td><td>:</td><td>
                                                <select id="opt_wcenter" onChange="document.location.href=this.options[this.selectedIndex].value;">
                                                  <?php foreach($wcenters as $wcenter):?>
                                                          <option value="<? echo site_url('pes/prodentry_c/form/'.$date_l.'/'.$shift.'/'.($wcenter->CHR_WCENTER_MN).'/'.$set); ?>" <?php if($wcenter_l == $wcenter->CHR_WCENTER_MN){echo 'SELECTED';} ?> ><? echo $wcenter->CHR_WCENTER_MN; ?></option>
                                                  <?php endforeach;?>
                                                          <option value="<? echo site_url('pes/prodentry_c/form/'.$date_l.'/'.$shift.'/ALL/'.$set); ?>" <?php if($wcenter_l == 'ALL'){echo 'SELECTED';} ?> >ALL</option>
                                                </select>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="10"><input type="radio" name="filter" <?php if($defaultSearch=='part_name'){echo 'checked="checked"';} ?>  onclick = "clearBoxPartName()" /></td>
                                        <td width="140"  height="30" >P. Name & Model</td><td>:</td><td><input id="search_part_name" type="text" name="name" placeholder="P. Name & Model" size="40" <?php if($defaultSearch!='part_name'){echo 'disabled="true"';} ?> ></td>
                                        <td>Shift</td>
                                </tr>
                                        <td colspan="4">
                                        <!--input type="submit" name="send" value="Filter" id="submit" class="button"-->
                                        <input type="submit" name="send" value="Show All" id="submit" class="button" onclick = "showAll()" style="height:40px;width:70px;" >

                                        </td>
                                        <td colspan="5">
                                                <input type="submit" name="send" value="1" id="submit" style="height:40px;width:70px; <?php if($shift=='1'){echo 'background-color: #FBE5BC;';}else{echo 'background-color: #ADC9B7;';} ?>" onClick="location.href='<?php echo site_url('pes/prodentry_c/form/'.$date_l.'/1/'.$wcenter_l.'/'.$set) ?>';">
                                                <input type="submit" name="send" value="2" id="submit" style="height:40px;width:70px; <?php if($shift=='2'){echo 'background-color: #FBE5BC;';}else{echo 'background-color: #ADC9B7;';} ?>" onClick="location.href='<?php echo site_url('pes/prodentry_c/form/'.$date_l.'/2/'.$wcenter_l.'/'.$set) ?>';">
                                                <input type="submit" name="send" value="3" id="submit" style="height:40px;width:70px; <?php if($shift=='3'){echo 'background-color: #FBE5BC;';}else{echo 'background-color: #ADC9B7;';} ?>" onClick="location.href='<?php echo site_url('pes/prodentry_c/form/'.$date_l.'/3/'.$wcenter_l.'/'.$set) ?>';">
                                                <input type="submit" name="send" value="4" id="submit" style="height:40px;width:70px; <?php if($shift=='4'){echo 'background-color: #FBE5BC;';}else{echo 'background-color: #ADC9B7;';} ?>" onClick="location.href='<?php echo site_url('pes/prodentry_c/form/'.$date_l.'/4/'.$wcenter_l.'/'.$set) ?>';">
                                        </td>
                                </tr>



                        <form action="" method="POST" onSubmit="return confirmAction()">
                        </table>
                        <br />
                                <table  width="100%">
                                <tr>
                                        <td  width="30%" rowspan="2" style="text-align:left;vertical-align:middle"><font size='6'>List Data : <?php echo $wcenter_l;?></font></td>
                                        <td  width="10%" rowspan="2"> &nbsp;&nbsp;&nbsp;Ket Type : </td>
                                        <td > A = Bedakan RH & LH </td>
                                        <td > &nbsp;&nbsp;&nbsp;C = Entry di setiap out mesin </td>
                                        
                                        <td rowspan="2">
                                            <?php if ( $apps == 1 ) {  ?>
                                                    <font size='5' color='red'> (APPROVED) </font>
                                            <?php }else{ ?>
                                                    
                                            <?php } ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td > B = Hasil Produksi x 2 </td>
                                        <td > &nbsp;&nbsp;&nbsp;D = Hasil dibagi 2 (RH & LH) </td>
                                </tr>
                                <tr>
                                        <td><input type="submit" name="btn_save" value="Save All" id="submit" class="button" style="height:40px;width:70px;" <?php if ( $apps == 1 ) { echo "disabled"; }?> ></td>
                                </tr>
                        </table>

                        <table class="table table-striped" id="list_data">
                                <thead>
                                        <tr>
                                                <th width="10px" rowspan="2" style="text-align:center;vertical-align:middle">No</th>
                                                <th width="180px" rowspan="2" style="text-align:center;vertical-align:middle">Part No</th>
                                                <th width="70px" rowspan="2" style="text-align:center;vertical-align:middle">Back No</th>
                                                <!--th width="80px">W.Center</th-->
                                                <th width="560px" rowspan="2" style="text-align:center;vertical-align:middle">P.Name & Model</th>
                                                <th width="40px" rowspan="2" style="text-align:center;vertical-align:middle">Type</th>
                                                <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">OK</th>
                                                <th width="60px" colspan="4" style="text-align:center;vertical-align:middle">NG</th>
                                                <th width="60px" rowspan="2" style="text-align:center;vertical-align:middle">Total</th>
                                        </tr>
                                        <tr>
                                                <th width="60px" style="text-align:center;vertical-align:middle">Proses</th>
                                                <th width="60px" style="text-align:center;vertical-align:middle">B.Test</th>
                                                <th width="60px" style="text-align:center;vertical-align:middle">Set Up</th>
                                                <th width="60px" style="text-align:center;vertical-align:middle">Trial</th>
                                        </tr>
                                </thead>

                                <tbody> 
                                        <?php $i=1;foreach($parts as $part):?>
                                        <tr>
                                                <td><?php echo $i;?></td>
                                                <td class="part_number"><?php echo $part->CHR_PART_NO;?><input type="hidden" name="part_number[<?php echo $i;?>]" value="<?php echo $part->CHR_PART_NO;?>" /><input type="hidden" name="part_number_hyp[<?php echo $i;?>]" value="<?php echo $part->CHR_PART_NO_HYP;?>" /></td>
                                                <td class="back_number"><?php echo $part->CHR_BACK_NO;?><input type="hidden" name="back_number[<?php echo $i;?>]" value="<?php echo $part->CHR_BACK_NO;?>" /></td>
                                                <!--td><?php echo $part->CHR_WCENTER;?></td-->
                                                <td class="part_name" style="font-size: 10pt;vertical-align:middle;"><?php echo $part->CHR_PART_NAME;?><input type="hidden" name="wcenter[<?php echo $i;?>]" value="<?php echo $part->CHR_WCENTER;?>" /><input type="hidden" name="wcenter_mn[<?php echo $i;?>]" value="<?php echo $part->CHR_WCENTER_MN;?>" /></td>
                                                <td class="type" style="text-align:center;"><?php echo $part->CHR_TYPE;?></td>
                                                <td><input onkeypress="return isNumberKey(event)" onKeyUp="findTotalOK(<?php echo $i;?>)" style="text-align:right;padding-right:0px;width:60px;background: #7FFFD4;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ok[<?php echo $i;?>]" value="<?php echo number_format($part->INT_QTY_OK,0,',','.');?>" <?php if($set=='0'){echo "disabled='yes'";} ?> ></td>
                                                <td><input onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_proses(<?php echo $i;?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_proses[<?php echo $i;?>]" value="<?php echo number_format($part->INT_QTY_NG_PROSES,0,',','.');?>" <?php if($set=='0'){echo "disabled='yes'";} ?>></td>
                                                <td><input onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_btest(<?php echo $i;?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_btest[<?php echo $i;?>]" value="<?php echo number_format($part->INT_QTY_NG_BTEST,0,',','.');?>" <?php if($set=='0'){echo "disabled='yes'";} ?>></td>
                                                <td><input onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_setup(<?php echo $i;?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_setup[<?php echo $i;?>]" value="<?php echo number_format($part->INT_QTY_NG_SETUP,0,',','.');?>" <?php if($set=='0'){echo "disabled='yes'";} ?>></td>
                                                <td><input onkeypress="return isNumberKey(event)" onKeyUp="findTotalNG_trial(<?php echo $i;?>)" style="text-align:right;padding-right:0px;width:60px;background: #FFE4E1;font-weight:bold;" type="text" size="1" class="decimalFormat" name="qty_ng_trial[<?php echo $i;?>]" value="<?php echo number_format($part->INT_QTY_NG_TRIAL,0,',','.');?>" <?php if($set=='0'){echo "disabled='yes'";} ?>></td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;font-weight:bold;" type="text" size="1" name="sum_qty[<?php echo $i;?>]" id="sum_qty[<?php echo $i;?>]" value="" readonly="yes"></td>
                                        </tr>
                                        <?php $i++;endforeach;?>
                                        <tr style="background-color: #e7e7e7">
                                                <td colspan="5" style="text-align:right;"> Total </td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ok" id="tot_qty_ok" value="" readonly="yes" ></td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_proses" id="tot_qty_ng_proses" value="" readonly="yes"></td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_btest" id="tot_qty_ng_btest" value="" readonly="yes"></td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_setup" id="tot_qty_ng_setup" value="" readonly="yes"></td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_qty_ng_trial" id="tot_qty_ng_trial" value="" readonly="yes"></td>
                                                <td><input style="text-align:right;padding-right:0px;width:60px;" type="text" size="1" name="tot_sum_qty" id="tot_sum_qty" value="" readonly="yes"></td>
                                        </tr>
                                </tbody>
                        </table>
                        <input type="hidden" name="i" value="<?php echo $i-1;?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>




	
<script type="text/javascript">



	
	function clearBoxPartNo() {
		document.getElementById("search_part_number").value = "";
		document.getElementById("search_part_number").disabled = false;
		document.getElementById("search_back_number").value = "";
		document.getElementById("search_back_number").disabled = true;
		document.getElementById("search_part_name").value = "";
		document.getElementById("search_part_name").disabled = true;
		$("#list_data tr td.part_name").parent().show();
	}

	function clearBoxBackNo() {
		document.getElementById("search_part_number").value = "";
		document.getElementById("search_part_number").disabled = true;
		document.getElementById("search_back_number").value = "";
		document.getElementById("search_back_number").disabled = false;
		document.getElementById("search_part_name").value = "";
		document.getElementById("search_part_name").disabled = true;
		$("#list_data tr td.part_name").parent().show();
	}
	
	function clearBoxPartName() {
		document.getElementById("search_part_number").value = "";
		document.getElementById("search_part_number").disabled = true;
		document.getElementById("search_back_number").value = "";
		document.getElementById("search_back_number").disabled = true;
		document.getElementById("search_part_name").value = "";
		document.getElementById("search_part_name").disabled = false;
		$("#list_data tr td.part_name").parent().show();
	}
	
	function showAll() {
		document.getElementById("search_part_number").value = "";
		document.getElementById("search_back_number").value = "";
		document.getElementById("search_part_name").value = "";
		$("#list_data tr td.part_name").parent().show();
	}
	
	function getLocation() {
		var t = document.getElementById("opt_wcenter");
		var date_t = document.getElementById('datepicker').value;
		var date_fix = date_t.substr(6,4) + date_t.substr(3,2) + date_t.substr(0,2)
		if(<?php echo $set ?> ==0)
		{
		location.href='<?php echo site_url()?>/pes/prodentry_c/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/1'
		}else
		{
		location.href='<?php echo site_url()?>/pes/prodentry_c/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
		}
	}
	

      function confirmAction() {
	
		if (document.getElementById("datepicker").disabled==false){
			alert('Maaf, anda belum set tanggal');
			return false;
		}else{
			return confirm("Anda yakin untuk menyimpan data?")
		}
      }
   
      function isNumberKey(evt)
      {
	
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>

<script type="text/javascript">
	/*
	
	function findTotalOK(arrPart){
		$(".decimalFormat").maskMoney({thousands:'.', decimal:',', precision: '0' , allowZero:true});
		var tot=0;
		for(var i=1;i<<?php echo $i;?>;i++){
			var arr = document.getElementsByName('qty_ok[' + i + ']');
			if(parseInt(arr[0].value.replace(".","")))
				tot += parseInt(arr[0].value.replace(".",""));
		}
		document.getElementById('tot_qty_ok').value = tot;
		
		if (arrPart){
			findTotalPart(arrPart);
		}
	}

	function findTotalNG_proses(arrPart){
		$(".decimalFormat").maskMoney({thousands:'.', decimal:',', precision: '0' , allowZero:true});
		var tot=0;
		for(var i=1;i<<?php echo $i;?>;i++){
			var arr = document.getElementsByName('qty_ng_proses[' + i + ']');
			if(parseInt(arr[0].value.replace(".","")))
				tot += parseInt(arr[0].value.replace(".",""));
		}
		document.getElementById('tot_qty_ng_proses').value = tot;
		
		if (arrPart){
			findTotalPart(arrPart);
		}
	}
	
	function findTotalNG_btest(arrPart){
		$(".decimalFormat").maskMoney({thousands:'.', decimal:',', precision: '0' , allowZero:true});
		var tot=0;
		for(var i=1;i<<?php echo $i;?>;i++){
			var arr = document.getElementsByName('qty_ng_btest[' + i + ']');
			if(parseInt(arr[0].value.replace(".","")))
				tot += parseInt(arr[0].value.replace(".",""));
		}
		document.getElementById('tot_qty_ng_btest').value = tot;
		
		if (arrPart){
			findTotalPart(arrPart);
		}
	}
	
	function findTotalNG_setup(arrPart){
		$(".decimalFormat").maskMoney({thousands:'.', decimal:',', precision: '0' , allowZero:true});
		var tot=0;
		for(var i=1;i<<?php echo $i;?>;i++){
			var arr = document.getElementsByName('qty_ng_setup[' + i + ']');
			if(parseInt(arr[0].value.replace(".","")))
				tot += parseInt(arr[0].value.replace(".",""));
		}
		document.getElementById('tot_qty_ng_setup').value = tot;
		
		if (arrPart){
			findTotalPart(arrPart);
		}
	}
	
	function findTotalNG_trial(arrPart){
		$(".decimalFormat").maskMoney({thousands:'.', decimal:',', precision: '0' , allowZero:true});
		var tot=0;
		for(var i=1;i<<?php echo $i;?>;i++){
			var arr = document.getElementsByName('qty_ng_trial[' + i + ']');
			if(parseInt(arr[0].value.replace(".","")))
				tot += parseInt(arr[0].value.replace(".",""));
		}
		document.getElementById('tot_qty_ng_trial').value = tot;
		
		if (arrPart){
			findTotalPart(arrPart);
		}
	}
	

	function findTotalPart(arrPart){
		var tot=0;
		var arrqty_ok 		 = document.getElementsByName('qty_ok[' + arrPart + ']');
		var arrqty_ng_proses = document.getElementsByName('qty_ng_proses[' + arrPart + ']');
		var arrqty_ng_btest  = document.getElementsByName('qty_ng_btest[' + arrPart + ']');
		var arrqty_ng_setup  = document.getElementsByName('qty_ng_setup[' + arrPart + ']');
		var arrqty_ng_trial  = document.getElementsByName('qty_ng_trial[' + arrPart + ']');
		tot = parseInt(arrqty_ok[0].value.replace(".","")) + parseInt(arrqty_ng_proses[0].value.replace(".","")) +  parseInt(arrqty_ng_btest[0].value.replace(".","")) +  parseInt(arrqty_ng_setup[0].value.replace(".","")) + parseInt(arrqty_ng_trial[0].value.replace(".","")) ; 
		document.getElementById('sum_qty[' + arrPart + ']').value = tot;
		
		tot=0;
		for(var i=1;i<<?php echo $i;?>;i++){
		
			var arr = document.getElementsByName('sum_qty[' + i + ']');
			if(parseInt(arr[0].value.replace(".","")))
				tot += parseInt(arr[0].value.replace(".",""));
		}
		document.getElementById('tot_sum_qty').value = tot.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
	
	}
	
	findTotalOK();
	findTotalNG_proses();
	findTotalNG_btest();
	findTotalNG_setup();
	findTotalNG_trial();
	
	var tot=0;
	for(var i=1;i<<?php echo $i;?>;i++){
		findTotalPart(i);
	
		var arr = document.getElementsByName('sum_qty[' + i + ']');
		if(parseInt(arr[0].value))
			tot += parseInt(arr[0].value);
	}
	document.getElementById('tot_sum_qty').value = tot;
	
	*/
	
</script>

 <script>
	  $(function() {
		$("#datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
	  });
	  </script>
	  
	<script type="text/javascript">
		$.expr[':'].Contains = function(x, y, z){
			return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
		};

		$('#search_back_number').keyup(function() 
		{
			var search = $('#search_back_number').val();
			$('#list_data tr').show();
			if(search.length>0)
			{

			$("#list_data tr td.back_number").not(":Contains('"+search+"')").parent().hide();
			}
		});
		
		$('#search_part_number').keyup(function() 
		{
			var search = $('#search_part_number').val();
			$('#list_data tr').show();
			if(search.length>0)
			{

			$("#list_data tr td.part_number").not(":Contains('"+search+"')").parent().hide();
			}
		});
		
		$('#search_part_name').keyup(function() 
		{
			var search = $('#search_part_name').val();
			$('#list_data tr').show();
			if(search.length>0)
			{

			$("#list_data tr td.part_name").not(":Contains('"+search+"')").parent().hide();
			}
		});
		
	</script>
	
	<script>
		$(':text').focus(function(){
			$(this).one('mouseup', function(event){
				event.preventDefault();
			}).select();
		});
	</script>
