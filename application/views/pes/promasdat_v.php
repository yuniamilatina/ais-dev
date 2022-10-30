<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href=""><strong>Master Data Production Execution</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER DATA</strong>PRODUCTION EXECUTION</span>
                        <div class="grid-body">

                        <table width="100%">
                           <tbody>
                               
                                   <?php if( $this->session->userdata('ROLE') == 7 ) { ?>
                                   <tr>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/promasdat_c/target_production/'.date('Ymd')); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/target_prod.png" ?>" alt="Production Entry" width="200" height="200"></div>
                                           <div style="text-align:center" >Master Target Production</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/promasdat_c/reject/'.date('Ymd',strtotime("-1 days"))); ?>"  >   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/rejected.png" ?>" alt="Production Display History" width="200" height="200"></div>
                                           <div style="text-align:center" >Master Reject</div></a></td>  
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/promasdat_c/work_time/'.date('Ymd')); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/worktime.jpg" ?>" alt="Production NG" width="200" height="200"></div>
                                           <div style="text-align:center" >Master Work Time</div></a></td>
                                   <tr>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/promasdat_c/line_stop/'.date('Ymd')); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/stop_line.png" ?>" alt="Master Data Production Execution" width="200" height="200"></div>
                                           <div style="text-align:center" >Master Line Stop</div></a></td>
                                   <td style="width: 33%;"> <a href="<?php echo site_url('pes/promasdat_c/ng/'.date('Ymd')); ?>">   
                                           <div style="text-align:center" ><img src="<?php echo base_url() . "assets/img/NG.png" ?>" alt="Master Data NG" width="200" height="200"></div>
                                           <div style="text-align:center" >Master NG</div></a></td>
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


