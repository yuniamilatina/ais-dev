    <div class="pull">
        <table width="100%" id="filter">
            <tr>
                <td width="10%">Budget Type</td>                                    
                <td width="20%">
                    <select name="CHR_BUDGET_TYPE" class="form-control" id="bgt" onChange="document.location.href = this.options[this.selectedIndex].value;">
                        <?php foreach ($all_budget_type as $data) { ?>
                            <option value="<?PHP echo site_url('budget/propose_budget_c/view_detail_budget_per_month/' . $fiscal_start . '/' . $kode_dept . '/' . $data->CHR_BUDGET_TYPE); ?>" <?php
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
    <div>
        <table class="table table-condensed table-hover display" cellspacing="0" width="100%" style="font-size: 11px;">
            <tr style="background-color: whitesmoke;">
                <td width='7%'></td>
                <td width='1%'></td>
                <td width='7%' align='center' style="font-weight: bold;">APR <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">MEI <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">JUN <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">JUL <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">AGU <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">SEP <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">OKT <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">NOV <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">DES <?php echo substr($fiscal_start, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">JAN <?php echo substr($fiscal_end, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">FEB <?php echo substr($fiscal_end, 2, 2); ?></td>
                <td width='7%' align='center' style="font-weight: bold;">MAR <?php echo substr($fiscal_end, 2, 2); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Plan</td>
                <td align='center'>:</td>
                <td align='right'>
                    <?php 
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN04, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php 
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN05, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php 
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN06, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN07, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN08, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN09, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN10, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN11, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN12, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN13, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN14, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($detail_budget != NULL){ 
                            echo number_format($detail_budget->PBLN15, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Limit</td>
                <td align='center'>:</td>
                <td align='right'>
                    <?php 
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN04, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php 
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN05, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php 
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN06, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN07, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN08, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN09, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN10, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN11, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN12, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN13, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN14, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($limit_budget != NULL){ 
                            echo number_format($limit_budget->PBLN15, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Act PR</td>
                <td align='center'>:</td>
                <td align='right'>
                    <?php 
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN04, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php 
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN05, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php 
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN06, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN07, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN08, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN09, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN10, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN11, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN12, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN13, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN14, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){ 
                            echo number_format($actual_real->OPRBLN15, 0, ',', '.');
                        } else {
                            echo '0';
                        }
                    ?>
                </td>
            </tr>                                
            <tr>
                <td style="font-weight: bold;">Acc PR</td>
                <td align='center'>:</td>
                <td align='right'>
                    <?php
                        $accu = 0;
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN04;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN05;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN06;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN07;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN08;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN09;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN10;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN11;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN12;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN13;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right'>
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN14;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
                <td align='right' >
                    <?php  
                        if($actual_real != NULL){
                            $accu = $accu + $actual_real->OPRBLN15;
                            echo number_format($accu, 0, ',', '.');
                        } else {
                            $accu = $accu + 0;
                            echo number_format($accu, 0, ',', '.');
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Act GR</td>
                <td align='center'>:</td>
                <td align='right'>
                    <?php echo number_format($actual_gr[0], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[1], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[2], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[3], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[4], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[5], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[6], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[7], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[8], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[9], 0, ',', '.'); ?>
                </td>
                <td align='right'>
                    <?php echo number_format($actual_gr[10], 0, ',', '.'); ?>
                </td>
                <td align='right' >
                    <?php echo number_format($actual_gr[11], 0, ',', '.'); ?>
                </td>
            </tr>            
        </table>
        <?php
            $tot_plan = $detail_budget->PBLN04 + $detail_budget->PBLN05 + $detail_budget->PBLN06 + $detail_budget->PBLN07 + $detail_budget->PBLN08 +
                    $detail_budget->PBLN09 + $detail_budget->PBLN10 + $detail_budget->PBLN11 + $detail_budget->PBLN12 + $detail_budget->PBLN13 +
                    $detail_budget->PBLN14 + $detail_budget->PBLN15;
            $tot_limit = $limit_budget->PBLN04 + $limit_budget->PBLN05 + $limit_budget->PBLN06 + $limit_budget->PBLN07 + $limit_budget->PBLN08 +
                    $limit_budget->PBLN09 + $limit_budget->PBLN10 + $limit_budget->PBLN11 + $limit_budget->PBLN12 + $limit_budget->PBLN13 +
                    $limit_budget->PBLN14 + $limit_budget->PBLN15;
            $tot_pr = $actual_real->OPRBLN04 + $actual_real->OPRBLN05 + $actual_real->OPRBLN06 + $actual_real->OPRBLN07 + $actual_real->OPRBLN08 +
                    $actual_real->OPRBLN09 + $actual_real->OPRBLN10 + $actual_real->OPRBLN11 + $actual_real->OPRBLN12 + $actual_real->OPRBLN13 +
                    $actual_real->OPRBLN14 + $actual_real->OPRBLN15;
            $tot_gr = $actual_gr[0] + $actual_gr[1] + $actual_gr[2] + $actual_gr[3] + $actual_gr[4] + $actual_gr[5] + $actual_gr[6] +
                    $actual_gr[7] + $actual_gr[8] + $actual_gr[9] + $actual_gr[10] + $actual_gr[11];
        ?>
        <div>
            <table width="100%">
                <tr>
                    <td width="8%">Total Plan :</td>
                    <td width="13%"><span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_plan, 0, ',', '.'); ?></span></td>
                    <td width="4%"></td>
                    <td width="8%">Total Limit :</td>
                    <td width="13%"><span style="font-size: small; font-weight: bold;" <?php if($tot_limit > $tot_plan){ echo 'class="label label-danger"'; } else { echo 'class="label label-primary"';} ?>>Rp <?php echo number_format($tot_limit, 0, ',', '.'); ?></span></td>
                    <td width="4%"></td>
                    <td width="8%">Total PR :</td>
                    <td width="13%"><span style="font-size: small; font-weight: bold;" <?php if($tot_pr > $tot_limit){ echo 'class="label label-danger"'; } else { echo 'class="label label-primary"';} ?>>Rp <?php echo number_format($tot_pr, 0, ',', '.'); ?></span></td>
                    <td width="4%"></td>
                    <td width="8%">Total GR :</td>
                    <td width="13%"><span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_gr, 0, ',', '.'); ?></span></td>
                    <td width="4%"></td>
                </tr>            
            </table>
        </div>
    </div>