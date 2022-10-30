
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>Production Display History</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>PRODUCTION</strong> DISPLAY HISTORY</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">

<form action="" method="POST" >
						<table>
							<tr>

								<td width="40">Tanggal</td><td>:</td><td>
									<!--select id="tanggal" name="tanggal" >
									  <?php for ($x = -5; $x <= 5; $x++) { ?>
										  <option value="<?php echo date("Ym", strtotime("+$x month"));?>" <?php if( $date_l == date("Ym", strtotime("+$x month")) ){ echo "SELECTED"; }?> > <?php echo date("Ym", strtotime("+$x month"));?> </option>
									  <?php }?>
									</select-->
									
									<input type="text" id="datepicker" placeholder="DD/MM/YYYY" value="<?php echo $date;?>"  name="tanggal" >
								</td>
								<td  width="20"  rowspan="4" > </td>
								<td  rowspan="4">
									<!--input type="submit" name="send" value="1" id="submit" style="height:40px;width:40px; <?php if($shift=='1'){echo 'background-color: #008287;';}else{echo '';} ?>" onClick="location.href='<?php echo site_url('home/form_app/'.$date_l.'/1/'.$wcenter_l.'/'.$set) ?>';"-->

								</td>
								<td  width="20"  rowspan="4" > </td>
								<td  width="140"  rowspan="4" >

								</td>

								
							</tr>
							<tr>
								<!--td width="10"><input type="radio" name="filter" <?php if($defaultSearch=='back_number'){echo 'checked="checked"';} ?> onclick = "clearBoxBackNo()" /></td>
								<td width="140"  height="30" >Back Number</td><td>:</td><td><input id="search_back_number" type="text" name="name" placeholder="Back Number" <?php if($defaultSearch!='back_number'){echo 'disabled="true"';} ?>></td-->
								<td width="150"  height="30" >Work Center</td><td>:</td><td>
									<select id="opt_wcenter"  name="opt_wcenter" >
									  <?php foreach($wcenters as $wcenter):?>
										  <option value="<? echo $wcenter->CHR_WCENTER_MN; ?>"  ><? echo $wcenter->CHR_WCENTER_MN; ?></option>
									  <?php endforeach;?>
										  <option value="<? echo 'ALL'; ?>" >ALL</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="50"  height="30" >Shift</td><td>:</td><td>
									<select id="shift"  name="shift" >
										  <option value="<? echo '1'; ?>" >1</option>
										  <!--option value="<? echo '2'; ?>" >2</option-->
										  <option value="<? echo '3'; ?>" >3</option>
									</select>
								</td>
							</tr>
							<tr>
							<td></td>
							<td></td>
							<td>
								<input type="submit" name="btn_export" value="Export to Excel" onClick="">
							</td>
							</tr>

							</tr>

						
						</table>
						</form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


