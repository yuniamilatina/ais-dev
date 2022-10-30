
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Production Display History</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>EXPORT DATA</strong> E-FAKTUR MASUKAN</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">

                                    <form action="" method="POST" >
						<table>
							<tr>

								<td width="100">No Faktur</td><td>:</td>
                                                                <td>
									<input type="text"  value=""  name="ZUONR_LOW" >
								</td> 
                                                                <td> to </td>
                                                                <td>
									<input type="text"  value=""  name="ZUONR_HIGH" >
								</td>
		

								
							</tr>

							<tr>
								<td width="100">Tanggal Posting</td><td>:</td>
                                                                <td>
									<input type="text" placeholder="ddmmyyyy" value=""  name="BUDAT_LOW" >
								</td> 
                                                                <td> to </td>
                                                                <td>
									<input type="text" placeholder="ddmmyyyy" value=""  name="BUDAT_HIGH" >
								</td>
							</tr>
                                                        
                                                        
							<tr>
								<td width="100">Tipe File</td><td>:</td>
                                                                <td>
									<input type="radio" name="tipe" value="csv" checked> csv
                                                                        <input type="radio" name="tipe" value="xls" > xls

								</td> 
     
							</tr>
                                                        
                                                        <tr>
							<td></td>
							<td></td>
							<td>
								<input type="submit" name="btn_export" value="Export to Excel" onClick="">
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


