<?php header("Content-type: text/html; charset=iso-8859-1"); ?>

<style>
    #filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }
    
    #detail_request { 
        border-spacing: 5px;
        border-collapse: separate;
    }
    
    #input_amo {
        font-size: 12px;
        font-weight: bold;
        max-width: 105px;
        max-height: 20px;
    }
    
    #input_qty {
        font-size: 12px;
        font-weight: bold;
        max-width: 40px;
        max-height: 20px;
    }
    
    #tot_amo {
        font-size: 13px;
        font-weight: bold;
        max-width: 150px;
        max-height: 30px;
    }
    
    #tot_qty {
        font-size: 13px;
        font-weight: bold;
        max-width: 50px;
        max-height: 30px;
    }    
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Propose Revision Master Budget</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <form method="post" action="<?php echo site_url("budget/propose_budget_c/save_revision_budget") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>BUDGET HEADER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                            <tr>
                                <td width="10%">No Budget</td>
                                <td width="2%">:</td>
                                <td width="38%"><strong><?php echo $curr_detail_budget->CHR_NO_BUDGET; ?></strong></td>
                                <td width="10%">Type</td>
                                <td width="2%">:</td>
                                <td width="38%"><strong><?php echo $curr_detail_budget->CHR_KODE_TYPE_BUDGET; ?></strong></td>
                            </tr>
                            <tr>
                                <td width="10%" valign="top">Description</td>
                                <td width="2%" valign="top">:</td>
                                <td width="38%" valign="top"><strong><?php echo substr($curr_detail_budget->CHR_DESC_BUDGET,0,80); ?></strong></td>
                                <td width="10%" valign="top">Department</td>
                                <td width="2%" valign="top">:</td>
                                <td width="38%" valign="top"><strong><?php echo $curr_detail_budget->CHR_KODE_DEPARTMENT; ?></strong></td>
                            </tr>                            
                        </table>
                        <input name="CHR_NO_BUDGET" type="hidden" value="<?php echo $budget_no; ?>">
                        <input name="CHR_TYPE_BUDGET" type="hidden" value="<?php echo $budget_type; ?>">
                        <input name="CHR_FISCAL_START" type="hidden" value="<?php echo $fiscal_start; ?>">
                        <input name="CHR_FISCAL_END" type="hidden" value="<?php echo $fiscal_end; ?>">
                    </div>
                </div>
            </div>
        </div>                
        <div class="row">
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title">DETAIL OF <strong>CURRENT BUDGET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                            <tr>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">APR <?php echo $fiscal_start; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">MEI <?php echo $fiscal_start; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">JUN <?php echo $fiscal_start; ?></td>                                                                    
                            </tr>
                            <tr>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN04" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN04, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN04" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN04; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN05" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN05, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN05" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN05; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN06" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN06, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN06" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN06; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>                                                                   
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">JUL <?php echo $fiscal_start; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">AGU <?php echo $fiscal_start; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">SEP <?php echo $fiscal_start; ?></td>                                                                   
                            </tr>
                            <tr>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN07" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN07, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN07" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN07; ?>" style="background-color: buttonhighlight;" readonly>
                                </td> 
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN08" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN08, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN08" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN08; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN09" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN09, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN09" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN09; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>                                                                                                    
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">OKT <?php echo $fiscal_start; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">NOV <?php echo $fiscal_start; ?></td> 
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">DES <?php echo $fiscal_start; ?></td>
                            </tr>
                            <tr>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN10" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN10, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN10" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN10; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN11" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN11, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN11" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN11; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN12" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN12, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN12" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN12; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">JAN <?php echo $fiscal_end; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">FEB <?php echo $fiscal_end; ?></td>
                                <td width="33%" align="center" style="background-color: #002a80; color:white;">MAR <?php echo $fiscal_end; ?></td>

                            </tr>
                            <tr>                                
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN13" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN13, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN13" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN13; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN14" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN14, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN14" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN14; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>
                                <td width="33%" align="center">
                                    <input name="CURR_BGT_LIMBLN15" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN15, 0, ',', '.'); ?>" style="background-color: buttonhighlight;" readonly>
                                    <input name="CURR_QTY_LIMBLN15" id="input_qty" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN15; ?>" style="background-color: buttonhighlight;" readonly>
                                </td>                                                                    
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td width="33%" align="center"></td>
                                <td width="33%" align="center"></td>
                                <td width="33%" align="center"></td>
                            </tr>
                            <tr>
                                <td width="33%" align="right"><strong>Total Budget &nbsp;&nbsp;&nbsp; Rp</strong></td>
                                <?php
                                $tot_curr_budget = $curr_detail_budget->MON_LIMBLN04 + $curr_detail_budget->MON_LIMBLN05 + $curr_detail_budget->MON_LIMBLN06 +
                                        $curr_detail_budget->MON_LIMBLN07 + $curr_detail_budget->MON_LIMBLN08 + $curr_detail_budget->MON_LIMBLN09 +
                                        $curr_detail_budget->MON_LIMBLN10 + $curr_detail_budget->MON_LIMBLN11 + $curr_detail_budget->MON_LIMBLN12 +
                                        $curr_detail_budget->MON_LIMBLN13 + $curr_detail_budget->MON_LIMBLN14 + $curr_detail_budget->MON_LIMBLN15;
                                ?>
                                <td width="33%" align="left">
                                    <input name="CURR_TOT_AMO" id="tot_amo" value="<?php echo number_format($tot_curr_budget, 0, ',', '.'); ?>" style="background-color: buttonhighlight; font-weight: bold" readonly>
                                </td>
                                <?php
                                $tot_qty_budget = $curr_detail_budget->INT_QTY_LIMBLN04 + $curr_detail_budget->INT_QTY_LIMBLN05 + $curr_detail_budget->INT_QTY_LIMBLN06 +
                                        $curr_detail_budget->INT_QTY_LIMBLN07 + $curr_detail_budget->INT_QTY_LIMBLN08 + $curr_detail_budget->INT_QTY_LIMBLN09 +
                                        $curr_detail_budget->INT_QTY_LIMBLN10 + $curr_detail_budget->INT_QTY_LIMBLN11 + $curr_detail_budget->INT_QTY_LIMBLN12 +
                                        $curr_detail_budget->INT_QTY_LIMBLN13 + $curr_detail_budget->INT_QTY_LIMBLN14 + $curr_detail_budget->INT_QTY_LIMBLN15;
                                ?>
                                <td width="33%" align="left">
                                    <input name="CURR_TOT_QTY" id="tot_qty" value="<?php echo $tot_qty_budget; ?>" style="background-color: buttonhighlight; font-weight: bold" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid">                
                        <div class="grid-header">
                            <i class="fa fa-edit"></i>
                            <span class="grid-title">DETAIL OF <strong>REQUEST BUDGET</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>                        
                        <div class="grid-body">
                                <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">APR <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">MEI <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">JUN <?php echo $fiscal_start; ?></td>                                                                    
                                    </tr>
                                    <tr>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN04" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN04, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN04" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN04; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN05" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN05, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN05" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN05; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN06" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN06, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN06" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN06; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>                                                                   
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">JUL <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">AGU <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">SEP <?php echo $fiscal_start; ?></td>                                                                   
                                    </tr>
                                    <tr>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN07" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN07, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN07" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN07; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td> 
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN08" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN08, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN08" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN08; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN09" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN09, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN09" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN09; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>                                                                                                    
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">OKT <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">NOV <?php echo $fiscal_start; ?></td> 
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">DES <?php echo $fiscal_start; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN10" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN10, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN10" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN10; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN11" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN11, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN11" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN11; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN12" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN12, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN12" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN12; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">JAN <?php echo $fiscal_end; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">FEB <?php echo $fiscal_end; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">MAR <?php echo $fiscal_end; ?></td>

                                    </tr>
                                    <tr>                                
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN13" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN13, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN13" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN13; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN14" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN14, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN14" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN14; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN15" class="money" style="background-color: paleturquoise;" id="input_amo" value="<?php echo number_format($curr_detail_budget->MON_LIMBLN15, 0, ',', '.'); ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN15" id="input_qty" class="qty" style="background-color: paleturquoise;" value="<?php echo $curr_detail_budget->INT_QTY_LIMBLN15; ?>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>                                                                    
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center"></td>
                                        <td width="33%" align="center"></td>
                                        <td width="33%" align="center"></td>
                                    </tr>
                                    <tr>
                                        <td width="33%" align="right"><strong>Total Request &nbsp;&nbsp;&nbsp; Rp</strong></td>                                        
                                        <td width="33%">
                                            <input name="REQ_TOT_AMO" id="tot_amo" class="money_tot" value="<?php echo number_format($tot_curr_budget, 0, ',', '.'); ?>" style="background-color: paleturquoise; font-weight: bold" readonly>
                                        </td>                                        
                                        <td width="33%">
                                            <input name="REQ_TOT_QTY" id="tot_qty" class="qty_tot" value="<?php echo $tot_qty_budget; ?>" style="background-color: paleturquoise; font-weight: bold" readonly>
                                        </td>
                                    </tr>
                                </table>
                            <div>&nbsp;</div>
                                <div>
                                    <table width="100%">
                                        <tr>
                                            <td width="40%"><strong>Keterangan </strong><i>(Harus diisi)</i></td>
                                            <td width="60%"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <textarea name="CHR_NOTES" id="note" value="" style="width:468px; height:70px; background-color: whitesmoke;" required></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <strong><i id="alert_1" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  Amount Capex tidak boleh KURANG dari Rp 3.000.000,00</i></strong>
                                    <strong><i id="alert_2" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  Amount Capex tidak boleh LEBIH dari satu (1) bulan</i></strong>
                                    <strong><i id="alert_3" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  KETERANGAN harus minimal 5 huruf</i></strong>
                                </div>
                            <div align="right">
                                <input id="change_amo" name="CHR_FLG_CHANGE_AMOUNT" type="hidden" value="0">
                                <input id="reschedule" name="CHR_FLG_RESCHEDULE" type="hidden" value="0">
                                <?php 
                                    echo anchor('budget/propose_budget_c/propose_budget_revision', 'Cancel', 'class="btn btn-default"');
                                ?>
                                <button id="propose" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Propose</button>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </form>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script> -->
<script>
    $(document).ready(function () {
        document.body.style.zoom = 0.85;

        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $('.money').mask("#.##0", {reverse: true});
    
    $(document).on("change", ".money", function() {
        var sum = 0;
        $(".money").each(function(){
            var amo = $(this).val().replace(/[.]/g,"");
            sum += +amo;            
        });
        var tot_amo = sum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".money_tot").val(tot_amo);
    });
    
    $(document).on("change", ".qty", function() {
        var sum = 0;
        $(".qty").each(function(){
            sum += +$(this).val();            
        });
        $(".qty_tot").val(sum);
    });
    
    $(document).on("change", "#note", function() {
        if ($(this).val().length < 5) {
            document.getElementById('alert_3').style.display = 'block';
        } else {
            document.getElementById('alert_3').style.display = 'none';
        }
    });
    
    $(document).on("change", ".money", function() {
        var sum = 0;
        var count = 0;
        $(".money").each(function(){
            var amo = $(this).val().replace(/[.]/g,"");
            sum += +amo;
            if(amo > 0){
                count += +1;
            }            
        });
        var bgt_type = document.getElementsByName("CHR_TYPE_BUDGET")[0].value;
        if(bgt_type = "CAPEX"){
            if(sum < 3000000){
                document.getElementById('alert_1').style.display = 'block';
                document.getElementById("propose").disabled = true;
            } else {
                document.getElementById('alert_1').style.display = 'none';
                if(count > 1){
                    document.getElementById('alert_2').style.display = 'block';
                    document.getElementById("propose").disabled = true;
                } else {
                    document.getElementById('alert_2').style.display = 'none';
                    document.getElementById("propose").disabled = false;
                }
            }            
        }
    });

    
</script>
