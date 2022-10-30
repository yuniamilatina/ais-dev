
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
                        <span class="grid-title"><strong>EXPORT DATA</strong> E-FAKTUR MASUKAN BY SCAN</span>
                    </div>

                    <div class="grid-body">

                                    <form action="" method="POST" >
						<table>
							<tr>

								<td width="100">No Faktur</td><td>&nbsp; : &nbsp;</td>
                                                                <td>
									<input type="text"  value=""  name="ZUONR_LOW" >
								</td> 
                                                                <td>&nbsp; to &nbsp;</td>
                                                                <td>
									<input type="text"  value=""  name="ZUONR_HIGH" >
								</td>
		

								
							</tr>

							<tr>
								<td width="100">Tanggal Posting</td><td>&nbsp; : &nbsp;</td>
                                                                <td>
									<input type="text" placeholder="ddmmyyyy" value=""  name="BUDAT_LOW" >
								</td> 
                                                                <td>&nbsp; to &nbsp;</td>
                                                                <td>
									<input type="text" placeholder="ddmmyyyy" value=""  name="BUDAT_HIGH" >
								</td>
							</tr>
							
                      
							<tr>
								<td width="100">Periode Pajak</td><td>&nbsp; : &nbsp;</td>
                                                                <td>
									<input type="text" placeholder="mm" value=""  name="TGL_FAKTUR_MM" >
								</td> 
                                                                <td></td>   
                                                                <td>
									<input type="text" placeholder="yyyy" value=""  name="TGL_FAKTUR_YYYY" >
								</td>
							</tr>
                                                        
							<tr>
								<td width="100">Supplier</td><td>&nbsp; : &nbsp;</td>
                                                                <td>
									<input type="text" placeholder="" value=""  name="SUPP" >
								</td> 
							</tr>
                                                        
							<tr>
								<td width="100">Tipe File</td><td>&nbsp; : &nbsp;</td>
                                                                <td>
									<input type="radio" name="tipe" value="csv" checked> csv
                                                                        <input type="radio" name="tipe" value="xls" > xls

								</td> 
     
							</tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
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


