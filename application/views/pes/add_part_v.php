
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>Production NG Report</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>PRODUCTION</strong> NG REPORT</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">

						<form action="" method="POST" onSubmit="return confirmAction()">
<table>
							<tr>
								<td width="140" height="30" style="border-right:0px">Part Number</td><td width="10">:</td><td><input id="search_part_number" type="text" name="part_no" placeholder="Part Number" size="30" ></td>
							</tr>
							<tr>
								<td width="140" height="30" style="border-right:0px">Part Number Hyp</td><td width="10">:</td><td><input id="search_part_number" type="text" name="part_no_hyp" placeholder="Part Number Hyp" size="30" ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Back Number</td><td>:</td><td><input id="search_back_number" type="text" name="back_no" placeholder="Back Number"   ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Work Center</td><td>:</td><td><input id="search_back_number" type="text" name="wcenter" placeholder="Work Center"   ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Work Center MN</td><td>:</td><td><input id="search_back_number" type="text" name="wcenter_mn" placeholder="Work Center MN"  ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >P. Name & Model</td><td>:</td><td><input id="search_part_name" type="text" name="part_name" placeholder="P. Name & Model" size="80"   ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Type</td><td>:</td><td><input id="search_back_number" type="text" name="type" placeholder="Type"   ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Sloc</td><td>:</td><td><input id="search_back_number" type="text" name="sloc" placeholder="Sloc"  ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Production</td><td>:</td><td><input id="search_back_number" type="text" name="prod" placeholder="Production (1-4)"  ></td>
							</tr>
							<tr>
								<td width="140"  height="30" >Flag Delete</td><td>:</td><td><input id="search_back_number" type="text" name="flg_delete" placeholder="Flag Delete (0/1)"   ></td>
							</tr>
							<tr>
								<td colspan="4">
								<!--input type="submit" name="send" value="Filter" id="submit" class="button"-->
								<input type="submit" name="btn_save" value="Save" id="submit" class="button" >
								<input type="button" name="send" value="Back"  class="button" onClick="location.href='<?echo site_url()?>/pes/admin_c/index/<?echo $wcenter; ?>'" >
								</td>
							</tr>
						</table>
						</form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>
	


<script>
  function confirmAction() {
		return confirm("Anda yakin untuk menyimpan data?")
  }
</script>


