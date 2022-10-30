<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>TRANSAKSI RAW MATERIAL</strong></a></li>
        </ol>
    </section>
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>TRANSAKSI RAW MATERIAL</strong> EXECUTION</span>
                        <div class="grid-body">

                        <table width="100%">
                           <tbody>
                               
                                   <?php if( $this->session->userdata('ROLE') == 7 ) { ?>
                                   <tr>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/tranrmwho_c/whowip/'.date('Ymd')); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/transaction.png" ?>" alt="Transaksi Raw Material Execution" width="200" height="200"></div>
                                           <div style="text-align:center" >Transaksi RM WHO WIP</div></a></td>
                                   </tr>
                                   <?php } ?>
            
                           </tbody>
                       </table>
                    </div>
                    </div>                                                                
                </div>
            </div>
        </div>

    </section>
</aside>


