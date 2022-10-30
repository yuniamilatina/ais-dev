
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
                        <span class="grid-title"><strong>SCAN</strong> E-FAKTUR MASUKAN</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">

                                    <form action="" method="POST" >
						<table>
							<tr>

								<td width="100">No Faktur</td><td>: &nbsp;</td>
                                                                <td>
									<input type="text"  value=""  name="no_faktur" id="no_faktur" >
								</td> 
                                                                <script>document.getElementById('no_faktur').focus()</script>
		

								
							</tr>

						</table>
                                        
                                                <?php if($data_view <> "") { ?>
                                                <?php foreach($data_view as $data_view_d):?>
						<br />
                                                 <table>
                                                        
							<tr>
                                                            <td>No Faktur</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td><strong><?php echo $data_view_d->CHR_NO_FAKTUR ?></strong></td>
							</tr>
							<tr>
                                                            <td>Tgl Faktur</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td>
                                                                <?php echo $data_view_d->CHR_TGL_FAKTUR ?>
                                                                <?php
                                                                    $month = (int)substr($data_view_d->CHR_TGL_FAKTUR,3,2);
                                                                    $year = substr($data_view_d->CHR_TGL_FAKTUR,6,4);
                                                                    $curr_month = (int)date('m');
                                                                    $curr_year = date('Y');
                                                                    if($curr_year > $year){
                                                                        if(($month - $curr_month) < 9){
                                                                            echo "<i class='fa fa-exclamation-triangle' style='color:red;'>Warning</i>";
                                                                        }
                                                                    } else {
                                                                        if(($curr_month - $month) > 9){
                                                                            echo "<i class='fa fa-exclamation-triangle' style='color:red;'>Warning</i>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
							</tr>
							<tr>
                                                            <td>NPWP Penjual</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td><?php echo $data_view_d->CHR_NPWP_PENJUAL ?></td>
							</tr>
							<tr>
                                                            <td>Nama Penjual</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td><strong><?php echo $data_view_d->CHR_NAMA_PENJUAL ?></strong></td>
							</tr>
							<tr>
                                                            <td>Alamat Penjual</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td><?php echo $data_view_d->CHR_ALAMAT_PENJUAL ?></td>
							</tr>
                                                        <tr>
                                                            <td>NPWP Lawan Trans</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td>
                                                                <strong><?php echo $data_view_d->CHR_NPWP_LAWAN_TRANS ?></strong>
                                                                <?php if(trim($data_view_d->CHR_NPWP_LAWAN_TRANS) != '010653053055000'){ echo "<i class='fa fa-exclamation-triangle' style='color:red;'>Warning</i>"; } ?>
                                                            </td>
							</tr>
                                                        <tr>
                                                            <td>Lawan Transaksi</td>
                                                            <td>&nbsp; : &nbsp;</td>
                                                            <td>
                                                                <strong><?php echo $data_view_d->CHR_NAMA_LAWAN_TRANS ?></strong>
                                                                <?php if(strpos($data_view_d->CHR_NAMA_LAWAN_TRANS, 'AISIN') != true && strpos($data_view_d->CHR_NAMA_LAWAN_TRANS, 'Aisin') != true && strpos($data_view_d->CHR_NAMA_LAWAN_TRANS, 'aisin') != true){ echo "<i class='fa fa-exclamation-triangle' style='color:red;'>Warning</i>"; } ?>
                                                            </td>
							</tr>
                                                        
						</table>
                                        
						<br />
                                                 <table id="dataTables" class="table table-condensed table-bordered table-hover display" cellspacing="0" width="100%">
                                                     <thead>
                                                         <tr align="center" style="font-weight:bold;" bgcolor="#E0FFFF">
                                                            <td bgcolor="#ADDFFF" >NO FAKTUR</td>
                                                            <td bgcolor="#ADDFFF">NAMA TRANS</td>
                                                            <td bgcolor="#ADDFFF">HARGA SATUAN</td>
                                                            <td bgcolor="#ADDFFF">JUMLAH BARANG</td>
                                                            <td bgcolor="#ADDFFF">HARGA TOTAL</td>
                                                            <td bgcolor="#ADDFFF">DISKON</td>
                                                            <td bgcolor="#ADDFFF">DPP</td>
                                                            <td bgcolor="#ADDFFF">PPN</td>
                                                            <td bgcolor="#ADDFFF">TARIF PPNBM</td>
                                                            <td bgcolor="#ADDFFF">PPNBM</td>
                                                        </tr>
                                                     </thead>
                                                     <tbody>
                                                         <?php foreach($data_view_detil as $data_view_detil_d):?>
							<tr>
                                                            <td><?php echo $data_view_detil_d->CHR_NO_FAKTUR ?></td>
                                                            <td><?php echo $data_view_detil_d->CHR_NAMA_TRANS ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_HARGA_SATUAN,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->INT_JUMLAH_BARANG,0,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_HARGA_TOTAL,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_DISKON,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_DPP,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_PPN,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_TARIF_PPNBM,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_detil_d->MON_PPNBM,2,",","."); ?></td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                        <tr style="font-weight:bold;" bgcolor="#E0FFFF">
                                                            <td align="center" colspan="6">TOTAL</td>
                                                            <td><?php echo number_format($data_view_d->MON_JML_DPP,2,",","."); ?></td>
                                                            <td><?php echo number_format($data_view_d->MON_JML_PPN,2,",","."); ?></td>
                                                            <td>0,00</td>
                                                            <td><?php echo number_format($data_view_d->MON_JML_PPNBM,2,",","."); ?></td>
                                                        </tr>
                                                     </tbody>                                                        
						</table>
                                                <?php endforeach;?>
                                                <?php } ?>
                                    </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


