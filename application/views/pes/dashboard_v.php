
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prod_entry_c/'); ?>"><strong>Production Entry System</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>PRODUCTION</strong> ENTRY SYSTEM</span>
                        <!--div class="pull-right">
                            <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Ticket" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div-->
                    </div>

                    <div class="grid-body">

                        <table width="100%">
                           <tbody>
                               
                                   <?php if( $this->session->userdata('ROLE') == 7 ) { ?>
                                   <tr>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prod_entry_c/form/'.date('Ymd').'/1/'.$first_wcenter.'/0'); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/box.png" ?>" alt="Production Entry" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Entry</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prodentry_c/report/'.date('Ym')); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/report.png" ?>" alt="Production NG Report" width="200" height="200"></div>
                                           <div style="text-align:center" >Production NG Report</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prodentry_c/report_display/'.date('Ymd',strtotime("-1 days"))); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/web_database.png" ?>" alt="Production Display History" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Display History</div></a></td>
                                   </tr>   
                                   <tr>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prodng_c/form/'.date('Ymd').'/1/'.$first_wcenter.'/0'); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/box-red.jpg" ?>" alt="Production NG" width="200" height="200"></div>
                                           <div style="text-align:center" >Production NG</div></a></td>
                                   </tr>
                                   <?php }else{ ?>
                                   
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prodentry_c/form_app/'.date('Ymd').'/1/'.$first_wcenter.'/0'); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/box.png" ?>" alt="Production Entry" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Entry</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prodentry_c/report/'.date('Ym')); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/report.png" ?>" alt="Production NG Report" width="200" height="200"></div>
                                           <div style="text-align:center" >Production NG Report</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/prodentry_c/report_display/'.date('Ymd',strtotime("-1 days"))); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/web_database.png" ?>" alt="Production Display History" width="200" height="200"></div>
                                           <div style="text-align:center" >Production Display History</div></a></td>     


                                   <?php } ?>
                               
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>