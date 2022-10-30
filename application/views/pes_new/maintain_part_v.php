
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Maintenance Part</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MAINTENACE</strong> PART</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">
                                        <table width="100%">
							<tr>
								<td rowspan="4" width="10%">Sort By</td>
								<td width="10"><input type="radio" name="filter"  checked="checked" onclick = "clearBoxPartNo()"/></td>
								<td width="140" height="30" style="border-right:0px">Part Number</td><td width="10">:</td><td><input id="search_part_number" type="text" name="name" placeholder="Part Number" size="30"></td>
								<td width="150"  height="30" >Work Center</td><td>:</td><td>
									<select id="opt_wcenter" onChange="document.location.href=this.options[this.selectedIndex].value;">
									  <?php foreach($wcenters as $wcenter):?>
										  <option value="<? echo site_url('/pes/admin_c/index/'.($wcenter->CHR_WCENTER_MN)); ?>" <?php if($wcenter_l == $wcenter->CHR_WCENTER_MN){echo 'SELECTED';} ?> ><? echo $wcenter->CHR_WCENTER_MN; ?></option>
									  <?php endforeach;?>
										  <option value="<? echo site_url('/pes/admin_c/index/ALL'); ?>" <?php if($wcenter_l == 'ALL'){echo 'SELECTED';} ?> >ALL</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="10"><input type="radio" name="filter" onclick = "clearBoxBackNo()" /></td>
								<td width="140"  height="30" >Back Number</td><td>:</td><td><input id="search_back_number" type="text" name="name" placeholder="Back Number" ></td>
								<td>
									<input type="submit" name="send" value="Add New Part" id="submit" class="button" onClick="location.href='<?echo site_url()?>/pes/admin_c/add/<?php echo ($wcenter_l);?>'" >
								</td>
							</tr>
							<tr>
								<td width="10"><input type="radio" name="filter" onclick = "clearBoxPartName()" /></td>
								<td width="140"  height="30" >P. Name & Model</td><td>:</td><td><input id="search_part_name" type="text" name="name" placeholder="P. Name & Model" size="40" ></td>
							</tr>
								<td colspan="4">
								<!--input type="submit" name="send" value="Filter" id="submit" class="button"-->
								<input type="submit" name="send" value="Show All" id="submit" class="button" onclick = "showAll()">
								</td>
							</tr>



						
						</table>
                                                <br />
                                                <table class="table table-condensed table-bordered table-striped" cellspacing="0" width="100%" id="list_data">
							<thead>
								<tr>
									<th width="10px"  style="text-align:center;vertical-align:middle">No</th>
									<th width="180px" style="text-align:center;vertical-align:middle">Part No</th>
									<th width="70px"  style="text-align:center;vertical-align:middle">Back No</th>
									<th width="560px"  style="text-align:center;vertical-align:middle">P.Name & Model</th>
									<th width="40px" rowspan="2" style="text-align:center;vertical-align:middle">Type</th>
									<th width="120px"  style="text-align:center;vertical-align:middle">Edit</th>
								</tr>
							</thead>
							
							<tbody> 
								<?php $i=1;foreach($parts as $part):?>
								<tr <?php If($part->CHR_FLG_DELETE == '1'){echo "style='background-color: #FFE4E1;'";} ?>>
									<td><?php echo $i;?></td>
									<td class="part_number"><?php echo $part->CHR_PART_NO;?><input type="hidden" name="part_number[<?php echo $i;?>]" value="<?php echo $part->CHR_PART_NO;?>" /><input type="hidden" name="part_number_hyp[<?php echo $i;?>]" value="<?php echo $part->CHR_PART_NO_HYP;?>" /></td>
									<td class="back_number"><?php echo $part->CHR_BACK_NO;?><input type="hidden" name="back_number[<?php echo $i;?>]" value="<?php echo $part->CHR_BACK_NO;?>" /></td>
									<!--td><?php echo $part->CHR_WCENTER;?></td-->
									<td class="part_name"><?php echo $part->CHR_PART_NAME;?><input type="hidden" name="wcenter[<?php echo $i;?>]" value="<?php echo $part->CHR_WCENTER;?>" /></td>
									<td class="type" style="text-align:center;"><?php echo $part->CHR_TYPE;?></td>
									<td><a href="<?php echo site_url()?>/pes/admin_c/edit/<?echo ($part->CHR_WCENTER).'/'.($part->CHR_PART_NO).'/'.($part->CHR_BACK_NO);?>">edit</a> | <a href="<?php echo site_url()?>/pes/admin_c/index/<?echo ($part->CHR_WCENTER).'/'.($part->CHR_PART_NO).'/'.($part->CHR_BACK_NO).'/';?><?if($part->CHR_FLG_DELETE == '1'){echo '0';}else{echo '1';}?>"><?if($part->CHR_FLG_DELETE == '1'){echo 'un-delete';}else{echo 'delete';}?></a> </td>
								</tr>
								<?php $i++;endforeach;?>

							</tbody>
						</table>
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
		location.href='<?php echo site_url()?>/admin/form/' + t.options[t.selectedIndex].text 
		}else
		{
		location.href='<?php echo site_url()?>/admin/form/' + t.options[t.selectedIndex].text 
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


