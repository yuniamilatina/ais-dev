    <div class="pull">
        <table width="100%" id="filter">
            <tr>
                <td width="10%">Budget Type</td>                                    
                <td width="20%">
                    <select name="CHR_BUDGET_TYPE" class="form-control" id="bgt" onChange="document.location.href = this.options[this.selectedIndex].value;">
                        <?php foreach ($all_budget_type as $data) { ?>
                            <option value="<?PHP echo site_url('budget/new_propose_budget_c/view_detail_budget_per_month/' . $fiscal_start . '/' . $kode_dept . '/' . $data->CHR_BUDGET_TYPE); ?>" <?php
                            if ($bgt_type == $data->CHR_BUDGET_TYPE) {
                                echo 'SELECTED';
                            }
                            ?> > <?php echo $data->CHR_BUDGET_TYPE; ?> </option>
                                <?php } ?>
                    </select>
                </td>
                <td width="70%"></td>
            </tr>
        </table>
    </div>
    <div>&nbsp;</div>
    <div> <!--style="overflow-x: scroll; overflow-y: hidden" width="100%" height="100%">-->
        <table id='dataTable' class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="font-size: 11px;">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                    <td align='center' style="font-weight: bold;">APR <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">MEI <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">JUN <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">JUL <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">AGU <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">SEP <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">OKT <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">NOV <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">DES <?php echo substr($fiscal_start, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">JAN <?php echo substr($fiscal_end, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">FEB <?php echo substr($fiscal_end, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">MAR <?php echo substr($fiscal_end, 2, 2); ?></td>
                    <td align='center' style="font-weight: bold;">TOTAL</td>
                </tr>
            </thead>
            <tbody>
                <!-- PLAN ----------------------------------------------------->
                <tr>
                    <?php $tot_plan = 0; ?>
                    <td>1</td>
                    <td style="font-weight: bold;">Plan </br>(a)</td>
                    <td align='right'>
                        <?php 
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN04;
                                echo number_format($detail_budget->PBLN04, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN05;
                                echo number_format($detail_budget->PBLN05, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN06;
                                echo number_format($detail_budget->PBLN06, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_plan = $tot_plan + $detail_budget->PBLN07;
                                echo number_format($detail_budget->PBLN07, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN08;
                                echo number_format($detail_budget->PBLN08, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN09;
                                echo number_format($detail_budget->PBLN09, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_plan = $tot_plan + $detail_budget->PBLN10;
                                echo number_format($detail_budget->PBLN10, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN11;
                                echo number_format($detail_budget->PBLN11, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN12;
                                echo number_format($detail_budget->PBLN12, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_plan = $tot_plan + $detail_budget->PBLN13;
                                echo number_format($detail_budget->PBLN13, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_plan = $tot_plan + $detail_budget->PBLN14;
                                echo number_format($detail_budget->PBLN14, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_plan = $tot_plan + $detail_budget->PBLN15;
                                echo number_format($detail_budget->PBLN15, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_plan, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END -- PLAN ---------------------------------------------->
                
                <!-- REVISI --------------------------------------------------->
                <tr>
                    <?php $tot_rev = 0; ?>
                    <td>2</td>
                    <td style="font-weight: bold;">Revisi</td>
                    <td align='right'>
                        <?php 
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN04;
                                echo number_format($rev_budget->PBLN04, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN05;
                                echo number_format($rev_budget->PBLN05, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN06;
                                echo number_format($rev_budget->PBLN06, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN07;
                                echo number_format($rev_budget->PBLN07, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN08;
                                echo number_format($rev_budget->PBLN08, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN09;
                                echo number_format($rev_budget->PBLN09, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN10;
                                echo number_format($rev_budget->PBLN10, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN11;
                                echo number_format($rev_budget->PBLN11, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN12;
                                echo number_format($rev_budget->PBLN12, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN13;
                                echo number_format($rev_budget->PBLN13, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN14;
                                echo number_format($rev_budget->PBLN14, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($rev_budget != NULL){
                                $tot_rev = $tot_rev + $rev_budget->PBLN15;
                                echo number_format($rev_budget->PBLN15, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_rev, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END -- REVISI -------------------------------------------->
                
                <!-- LIMIT ORI ------------------------------------------------>
                <tr>
                    <?php $tot_limit_ori = 0; ?>
                    <td>3</td>
                    <td style="font-weight: bold;">Limit </br>70% (b)</td>
                    <td align='right'>
                        <?php 
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN04 * 0.7);
                                echo number_format(($detail_budget->PBLN04 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($detail_budget != NULL){ 
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN05 * 0.7);
                                echo number_format(($detail_budget->PBLN05 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($detail_budget != NULL){ 
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN06 * 0.7);
                                echo number_format(($detail_budget->PBLN06 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN07 * 0.7);
                                echo number_format(($detail_budget->PBLN07 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN08 * 0.7);
                                echo number_format(($detail_budget->PBLN08 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN09 * 0.7);
                                echo number_format(($detail_budget->PBLN09 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){ 
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN10 * 0.7);
                                echo number_format(($detail_budget->PBLN10 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN11 * 0.7);
                                echo number_format(($detail_budget->PBLN11 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN12 * 0.7);
                                echo number_format(($detail_budget->PBLN12 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN13 * 0.7);
                                echo number_format(($detail_budget->PBLN13 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN14 * 0.7);
                                echo number_format(($detail_budget->PBLN14 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($detail_budget != NULL){
                                $tot_limit_ori = $tot_limit_ori + ($detail_budget->PBLN15 * 0.7);
                                echo number_format(($detail_budget->PBLN15 * 0.7), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_limit_ori, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END -- LIMIT ORI ----------------------------------------->
                
                <!-- ACTUAL PROPOSED ------------------------------------------>
                <tr>
                    <?php $tot_proposed = 0; ?>
                    <td>4</td>
                    <td style="font-weight: bold;">Proposed </br>(c)</td>
                    <td align='right'>
                        <?php 
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN04;
                                echo number_format($limit_budget->PBLN04, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN05;
                                echo number_format($limit_budget->PBLN05, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN06;
                                echo number_format($limit_budget->PBLN06, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN07;
                                echo number_format($limit_budget->PBLN07, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){ 
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN08;
                                echo number_format($limit_budget->PBLN08, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN09;
                                echo number_format($limit_budget->PBLN09, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN10;
                                echo number_format($limit_budget->PBLN10, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN11;
                                echo number_format($limit_budget->PBLN11, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){ 
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN12;
                                echo number_format($limit_budget->PBLN12, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){ 
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN13;
                                echo number_format($limit_budget->PBLN13, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){ 
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN14;
                                echo number_format($limit_budget->PBLN14, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){ 
                                $tot_proposed = $tot_proposed + $limit_budget->PBLN15;
                                echo number_format($limit_budget->PBLN15, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_proposed, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END -- ACTUAL PROPOSED ----------------------------------->
                
                <!-- ACTUAL PR ------------------------------------------------>
                <tr>
                    <?php $tot_pr = 0; ?>
                    <td>5</td>
                    <td style="font-weight: bold;">Est.GR by </br>PR (d)</td>
                    <td align='right'>
                        <?php 
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN04;
                                echo number_format($actual_real->OPRBLN04, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($actual_real != NULL){ 
                                $tot_pr = $tot_pr + $actual_real->OPRBLN05;
                                echo number_format($actual_real->OPRBLN05, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($actual_real != NULL){ 
                                $tot_pr = $tot_pr + $actual_real->OPRBLN06;
                                echo number_format($actual_real->OPRBLN06, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN07;
                                echo number_format($actual_real->OPRBLN07, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_pr = $tot_pr + $actual_real->OPRBLN08;
                                echo number_format($actual_real->OPRBLN08, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_pr = $tot_pr + $actual_real->OPRBLN09;
                                echo number_format($actual_real->OPRBLN09, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_pr = $tot_pr + $actual_real->OPRBLN10;
                                echo number_format($actual_real->OPRBLN10, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN11;
                                echo number_format($actual_real->OPRBLN11, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN12;
                                echo number_format($actual_real->OPRBLN12, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN13;
                                echo number_format($actual_real->OPRBLN13, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN14;
                                echo number_format($actual_real->OPRBLN14, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_pr = $tot_pr + $actual_real->OPRBLN15;
                                echo number_format($actual_real->OPRBLN15, 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_pr, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END -- ACTUAL PR ----------------------------------------->
                
                <!-- BALANCE PLAN VS PROPOSE ---------------------------------->
                <tr>
                    <?php $tot_balance_prop = 0; ?>
                    <td>6</td>
                    <td style="font-weight: bold;">Balance </br>Prop (a-c)</td>
                    <td align='right'>
                        <?php 
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN04 - $limit_budget->PBLN04);
                                echo number_format(($detail_budget->PBLN04 - $limit_budget->PBLN04), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN05 - $limit_budget->PBLN05);
                                echo number_format(($detail_budget->PBLN05 - $limit_budget->PBLN05), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN06 - $limit_budget->PBLN06);
                                echo number_format(($detail_budget->PBLN06 - $limit_budget->PBLN06), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN07 - $limit_budget->PBLN07);
                                echo number_format(($detail_budget->PBLN07 - $limit_budget->PBLN07), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN08 - $limit_budget->PBLN08);
                                echo number_format(($detail_budget->PBLN08 - $limit_budget->PBLN08), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN09 - $limit_budget->PBLN09);
                                echo number_format(($detail_budget->PBLN09 - $limit_budget->PBLN09), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN10 - $limit_budget->PBLN10);
                                echo number_format(($detail_budget->PBLN10 - $limit_budget->PBLN10), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN11 - $limit_budget->PBLN11);
                                echo number_format(($detail_budget->PBLN11 - $limit_budget->PBLN11), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN12 - $limit_budget->PBLN12);
                                echo number_format(($detail_budget->PBLN12 - $limit_budget->PBLN12), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN13 - $limit_budget->PBLN13);
                                echo number_format(($detail_budget->PBLN13 - $limit_budget->PBLN13), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN14 - $limit_budget->PBLN14);
                                echo number_format(($detail_budget->PBLN14 - $limit_budget->PBLN14), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($limit_budget != NULL){
                                $tot_balance_prop = $tot_balance_prop + ($detail_budget->PBLN15 - $limit_budget->PBLN15);
                                echo number_format(($detail_budget->PBLN15 - $limit_budget->PBLN15), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_balance_prop, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END - BALANCE PLAN --------------------------------------->
                
                <!-- BALANCE PLAN VS ACTUAL PR -------------------------------->
                <tr>
                    <?php $tot_balance_plan = 0; ?>
                    <td>7</td>
                    <td style="font-weight: bold;">Balance </br>Plan (a-d)</td>
                    <td align='right'>
                        <?php 
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN04 - $actual_real->OPRBLN04);
                                echo number_format(($detail_budget->PBLN04 - $actual_real->OPRBLN04), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN05 - $actual_real->OPRBLN05);
                                echo number_format(($detail_budget->PBLN05 - $actual_real->OPRBLN05), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php 
                            if($actual_real != NULL){ 
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN06 - $actual_real->OPRBLN06);
                                echo number_format(($detail_budget->PBLN06 - $actual_real->OPRBLN06), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN07 - $actual_real->OPRBLN07);
                                echo number_format(($detail_budget->PBLN07 - $actual_real->OPRBLN07), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN08 - $actual_real->OPRBLN08);
                                echo number_format(($detail_budget->PBLN08 - $actual_real->OPRBLN08), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN09 - $actual_real->OPRBLN09);
                                echo number_format(($detail_budget->PBLN09 - $actual_real->OPRBLN09), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN10 - $actual_real->OPRBLN10);
                                echo number_format(($detail_budget->PBLN10 - $actual_real->OPRBLN10), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN11 - $actual_real->OPRBLN11);
                                echo number_format(($detail_budget->PBLN11 - $actual_real->OPRBLN11), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN12 - $actual_real->OPRBLN12);
                                echo number_format(($detail_budget->PBLN12 - $actual_real->OPRBLN12), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN13 - $actual_real->OPRBLN13);
                                echo number_format(($detail_budget->PBLN13 - $actual_real->OPRBLN13), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN14 - $actual_real->OPRBLN14);
                                echo number_format(($detail_budget->PBLN14 - $actual_real->OPRBLN14), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <?php  
                            if($actual_real != NULL){ 
                                $tot_balance_plan = $tot_balance_plan + ($detail_budget->PBLN15 - $actual_real->OPRBLN15);
                                echo number_format(($detail_budget->PBLN15 - $actual_real->OPRBLN15), 0, ',', '.');
                            } else {
                                echo '0';
                            }
                        ?>
                    </td>
                    <td align='right'>
                        <strong>
                        <?php  
                            echo number_format($tot_balance_plan, 0, ',', '.');
                        ?>
                        </strong>
                    </td>
                </tr>
                <!-- END - BALANCE PLAN --------------------------------------->
                
                <!-- ESTIMATE GR BY PROPOSE ----------------------------------->
                <tr>
                    <td>8</td>
                    <td style="font-weight: bold;">Est.GR by Propose</td>
                    <?php
                        $tot_est_gr_prop = 0;
                        for($x = 0; $x < 12; $x++){
                            $tot_est_gr_prop = $tot_est_gr_prop + $est_gr_prop[$x];
                            echo "<td align='right'>";
                            echo number_format($est_gr_prop[$x], 0, ',', '.');
                            echo "</td>";
                        }
                    ?>
                    <td align='right'>
                        <strong>
                        <?php 
                            echo number_format($tot_est_gr_prop, 0, ',', '.'); 
                        ?>
                        </strong>
                    </td>
                </tr> 
                <!-- END -- ESTIMATE GR BY PROPOSE ---------------------------->
                
                <!-- ESTIMATE GR BY PR ---------------------------------------->
<!--                <tr>
                    <td>8</td>
                    <td style="font-weight: bold;">Est.GR by PR</td>
                    <?php
                        $tot_est_gr_pr = 0;
                        for($x = 0; $x < 12; $x++){
                            $tot_est_gr_pr = $tot_est_gr_pr + $est_gr_pr[$x];
                            echo "<td align='right'>";
                            echo number_format($est_gr_pr[$x], 0, ',', '.');
                            echo "</td>";
                        }
                    ?>
                    <td align='right'>
                        <strong>
                        <?php echo number_format($tot_est_gr_pr, 0, ',', '.'); ?>
                        </strong>
                    </td>
                </tr>-->
                <!-- END -- ESTIMATE GR BY PR --------------------------------->
                
                <!-- ACTUAL GR ------------------------------------------------>
                <tr>
                    <td>9</td>
                    <td style="font-weight: bold;">Actual GR</td>
                    <?php
                        $tot_act_gr = 0;
                        for($x = 0; $x < 12; $x++){
                            $tot_act_gr = $tot_act_gr + $actual_gr[$x];
                            echo "<td align='right'>";
                            echo number_format($actual_gr[$x], 0, ',', '.');
                            echo "</td>";
                        }
                    ?>
                    <td align='right'>
                        <strong>
                        <?php echo number_format($tot_act_gr, 0, ',', '.'); ?>
                        </strong>
                    </td>                
                </tr> 
                <!-- END -- ACTUAL GR ----------------------------------------->
            </tbody>
        </table>
        <div>&nbsp;</div>
        <div>
            <table width="100%">
                <tr>
                    <td>Total Plan :</td>
                    <td><span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_plan, 0, ',', '.'); ?></span></td>
                    <td></td>
                    <td>Total Limit :</td>
                    <td><span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_limit_ori, 0, ',', '.'); ?></span></td>
                    <td></td>
<!--                    <td>Total Proposed :</td>
                    <td><span style="font-size: small; font-weight: bold;" 
                        <?php 
                        if($tot_proposed > $tot_limit_ori && $tot_proposed < $tot_plan){ 
                            echo 'class="label label-warning"';                             
                        } else if($tot_proposed > $tot_plan) { 
                            echo 'class="label label-danger"';                             
                        } else { 
                            echo 'class="label label-primary"';                        
                        } ?>>Rp <?php echo number_format($tot_proposed, 0, ',', '.'); 
                        ?></span></td>
                    <td></td>-->
                    <td>Total PR :</td>
                    <td><span style="font-size: small; font-weight: bold;" 
                        <?php 
                        if($tot_pr > $tot_limit_ori && $tot_pr < $tot_plan){ 
                            echo 'class="label label-warning"';                             
                        } else if($tot_pr > $tot_plan) { 
                            echo 'class="label label-danger"';                             
                        } else { 
                            echo 'class="label label-primary"';                            
                        } ?>>Rp <?php echo number_format($tot_pr, 0, ',', '.'); ?>
                        </span></td>
                    <td></td>
                    <td>Total GR :</td>
                    <td><span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_act_gr, 0, ',', '.'); ?></span></td>
                    <td></td>
                    <td>Total Saldo :</td>
                    <td><span style="font-size: small; font-weight: bold;" 
                        <?php 
                        $saldo_plan_fy = $tot_plan - $tot_pr;
                            echo 'class="label label-primary"';                        
                        ?>>Rp <?php echo number_format($saldo_plan_fy, 0, ',', '.'); 
                        ?></span></td>
                    <td></td>
                </tr>            
            </table>
        </div>
    </div>
    
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 2
            }
        });
    });
</script>
