

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>View Invoice</strong></a></li>
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
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>INVOICE RECEIPT</strong> <?php echo ' ' . $data->INVNO; ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  >
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-4 ">
                                    <p>PT AISIN INDONESIA<br>
                                        EJIP Industrial Park Plot 5J<br>
                                        Lemahabang Bekasi</p>
                                    <p> 
                                    <table width='100%'>
                                        <tr>
                                            <td>No. AP </td>

                                            <td><?php
                                                echo '   ' . $data->APNO . '/' . date('y');
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Supplier </td>

                                            <td><?php
                                                $user_session = $this->session->all_userdata();
                                                echo '   ' . $namasup;
                                                ?></td>
                                        </tr>

                                    </table>


                                </div>

                                <div class="col-md-4 text-center">

                                    <h4>INVOICE</h4>

                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="panel-body">
    <!--                                    <img src="<?php echo base_url('assets/img/barcode/' . trim($data->KODESUP) . '.jpg') ?>"></img>-->
        <!--            <br><br><br><p><?php echo 'Tanggal : ' . (string) date('d M Y', strtotime($data->TGLTRM)); ?></p>-->

                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th class="total-label"><div class="text-center">No</div></th>
                                    <th class="total-label"><div class="text-center">Invoice</div></th>
                                    <th class="total-label"><div class="text-center">Invoice Date</div></th>
                                    <th class="total-label"><div class="text-center">Information</div></th >
                                    <th class="total-label"><div class="text-center">Amount</div></th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="total-label" colspan="4">
                                                Total:
                                            </th>
                                            <th class="total-amount">
                                    <div class="pull-right"><?php echo $data->KD_CURRENCY . ' ' . number_format($data->AMOUNT); ?></div>

                                    </th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $i = 1; ?>

                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data->INVNO; ?></td>
                                            <td><?php
                                                $TINV = date('d M, Y', strtotime($data->TGLINV));
                                                echo $TINV;
                                                ?></td>
                                            <td><?php echo $data->KET; ?></td>
                                            <td>
                                                <div class="pull-right">
                                                    <?php echo $data->KD_CURRENCY . ' ' . number_format($data->AMOUNT); ?>    
                                                </div>

                                            </td>
                                        </tr>

                                        <?php $i++; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            
                            <div class="col-md-12">
                                <p class="amount-word">
                                    Amount in Word: <span> <br><?php echo $terbilang; ?></span>
                                </p>

        <!--            <br> <?php echo $terbilang; ?> </p>-->

                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <table class="table text-center table-bordered" >
                                        <tr class="info">
                                            <td>Delivered by</td>
                                            <td>Accepted by</td>
                                        </tr>
                                        <tr>
                                            <td><br><br></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><p></td>
                                            <td></td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="col-md-5">

                                    <table width="80%">
                                        <tr>
                                            <td>Bank Name</td>
                                            <td><?php echo '  ' . trim($bank); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Acc No.</td>
                                            <td><?php echo '  ' . trim($acno); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Account Name</td>
                                            <td><?php echo '  ' . trim($namaac); ?></td>
                                        </tr>
                                    </table>
                                    <br><br>
                                </div>

                                <div class="col-md-3 text-center">
                                    <p><?php echo '__________, ' . (string) date('d M Y', strtotime($data->TGLTRM)); ?></p>
                                    <br>

                                    <p><?php echo '( ' . $data->KD_CURRENCY . ' )'; ?>
                                        <br><br><br><br>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <?php
                                echo anchor('evita/invoice_c/view_invoice', 'Back', 'class="btn btn-warning tip-top" title="Back to dashboard"') . ' ';
                                ?>

                            </div>
                            <div class="col-md-12">

                            </div>
                        </div>
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br />
                    </div>
                </div>
            </div>
            
        </div>

    </section>
</aside>


