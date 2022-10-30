

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>List Invoice</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        

        
       
        ?>

        <div class="row">
            
            

            
            <div class="col-md-3">
                <div class="grid">
                    
                    
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title">LEGEND</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
 
                        <p> 
                        <div class="col-xs-12 col-sm-12"><a class="image btn btn-block btn-default btn-xs tip-top" title="Invoices with white background">New Invoices</a></div>
                        <p><div class="col-xs-12 col-sm-12"><a class="image btn btn-block btn-warning btn-xs tip-top" title="Invoices with yellow background" >Accepted Invoices</a></div>
                        <p><div class="col-xs-12 col-sm-12"><a class="image btn btn-block btn-success btn-xs tip-top" title="Invoices with green background" >Paid Invoices</a></div>
                        <p><div class="col-xs-12 col-sm-12"><a class="image btn btn-block btn-danger btn-xs tip-top" title="Invoices with red background" >Unpaid Invoices</a></div>
                        <p><div class="col-xs-12 col-sm-4"></div>&nbsp;
                        </p>
           
                    </div>
                    

                    
                </div>
            </div>
            

            <div class="col-md-9">
                <div class="grid">
                    
                    
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>LIST</strong> INVOICE <?php echo $appno; ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"  id="update_content">
 
                        <table class="table table-bordered data-table">
                           <thead>
                               <tr>
                                   <th>No</th>
                                   <th>AP No</th>
                                   <th>Invoice No</th>

                                   <th>Invoice Date</th>
                                   <th>Accepted Date</th>
                                   <th>Due Date</th>
                                   <th>Amount</th>
                                   <th>Action</th>

                               </tr>
                           </thead>
                           <tbody>
                               <?php
                               $i = 1;
                               foreach ($data as $isi) {

                                   $TINV = date('d M Y', strtotime($isi->TGLINV));
                                   $TTRM = '';
                                   $TJTTEMPO = '';
                                   $kode = '';
                                   $bayar = '';
                                   $exp = date('Y-m-d', strtotime($isi->TGLJTTEMPO));
                                   $now = date('Y-m-d');
                                   if (trim($isi->TGLTRM) != NULL) {
                                       $TTRM = date('d M Y', strtotime($isi->TGLTRM));
                                       $kode = 'warning';
                                       $TJTTEMPO = date('d M Y', strtotime($isi->TGLJTTEMPO));
                                       if ($exp < $now) {
                                           $kode = 'danger';
                                       }
                                   }
                                   if (trim($isi->BAYAR) == 'Y') {
                                       $bayar = '<span class="label label-success">Paid</span>';
                                       $kode = 'success';
                                   }
                                   ?>
                                   <tr class="<?php echo $kode ?>">
                                       <td ><?php echo $i ?></td>
                                       <td ><?php echo $isi->APNO ?></td>
                                       <td ><?php echo $isi->INVNO ?></td>
                                       <td><?php echo $TINV ?></td>
                                       <td><?php echo $TTRM ?></td>
                                       <td><?php
                                           if ($kode == '') {
                                               echo '';
                                           } else {
                                               echo $TJTTEMPO;
                                           }
                                           ?></td>
                                       <td class="text-right"><?php echo number_format($isi->AMOUNT) ?></td>
                                       <td>
                                           
                                               <a href="<?php echo base_url('index.php/evita/invoice_c/view_detail_invoice') . '/' . $isi->APNO . '-' . substr($isi->TGLENTRY1,2,2); ?>" class="label label-success tip-top" title="View Details"><span class="fa fa-eye" ></span></a>
                                               <a href="<?php echo base_url('index.php/evita/invoice_c/reject_by_user/') . '/' . $isi->APNO . '-' . substr($isi->TGLENTRY1,2,2); ?>" class="label label-danger tip-top" title="Reject"><span class="fa fa-times" ></span></a>
                                         

                                           <?php
                                           echo "</td>";
                                           echo "</tr>";
                                           $i++;
                                       }
                                       ?>

                           </tbody>
                       </table> 
           
                    </div>
                    

                    
                </div>
            </div>
            
        </div>

    </section>
</aside>


