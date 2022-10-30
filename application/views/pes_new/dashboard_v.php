
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prod_entry_c/'); ?>"><strong>Production Result Entry</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>PRODUCTION</strong> RESULT ENTRY</span>

                    </div>

                    <div class="grid-body">

                        <table width="100%">
                           <tbody>
                               <tr>
                                   <?php if( $this->session->userdata('ROLE') == 1  or $this->session->userdata('ROLE') == 17) { ?>

                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes_new/prodentry_c/form/'.date('Ymd').'/1/'.$first_wcenter.'/0'); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/box.png" ?>" alt="Production Entry" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Entry</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes_new/prodentry_c/report/'.date('Ym')); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/report.png" ?>" alt="Production NG Report" width="200" height="200"></div>
                                           <div style="text-align:center" >Production NG Report</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes_new/prodentry_c/report_display/'.date('Ymd',strtotime("-1 days"))); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/web_database.png" ?>" alt="Production Display History" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Display History</div></a></td>
                                   <?php }else{ ?>
                                   
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes_new/prodentry_c/form/'.date('Ymd').'/1/'.$first_wcenter.'/0'); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/box.png" ?>" alt="Production Entry" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Entry</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes_new/prodentry_c/report/'.date('Ym')); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/report.png" ?>" alt="Production NG Report" width="200" height="200"></div>
                                           <div style="text-align:center" >Production NG Report</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes_new/prodentry_c/report_display/'.date('Ymd',strtotime("-1 days"))); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/web_database.png" ?>" alt="Production Display History" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Display History</div></a></td>     


                                   <?php } ?>
                               </tr>
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>