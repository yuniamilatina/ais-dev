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
    
    #input_propose {
        font-size: 11px;
        width: 110px;
        height: 23px;
        background-color: whitesmoke;
        text-align: right;
    }
    #input_notes {
        font-size: 11px;
        width: 120px;
        height: 23px;
        background-color: whitesmoke;
    }
    
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Propose Budget Monthly</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <form method="post" id="filter_form" action="<?php echo site_url("budget/propose_budget_c/save_propose_budget") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>PROPOSE BUDGET FOR <?php echo strtoupper(date("F", mktime(null, null, null, $month))) . ' ' . substr($year_month,0,4); ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>                        
                    </div>
                    <div class="grid-body">
                        <div class="pull">                            
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Fiscal</td>                                    
                                    <td width="15%">
                                        <select name="CHR_FISCAL" class="form-control" id="fiscal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/manage_approval_monthly_budget/0/' . $data->CHR_FISCAL_YEAR_START . '/' . $year_month . '/' . $kode_dept); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="75%"></td>
                                </tr>                                
                                <tr>
                                    <td>Month</td>                                    
                                    <td>
                                        <select class="form-control" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for($i = 0; $i < 12; $i++) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/manage_approval_monthly_budget/0/' . $fiscal_start . '/' . $all_month[$i][0] . '/' . $kode_dept); ?>"
                                            <?php 
                                                if($year_month == $all_month[$i][0]){ 
                                                    echo " selected";
                                                }
                                            ?> > 
                                            <?php echo $all_month[$i][1]; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td>
                                       <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/propose_budget_c/manage_approval_monthly_budget/0/' . $fiscal_start . '/' . $year_month . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $dept->CHR_KODE_DEPARTMENT; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>                                
                            </table>
                        </div>
                        <div>&nbsp;</div>                        
                        <div style="font-size:12px;">
                            <table style="font-size:12px;" id="dataTable" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="2%" align="center"><strong>No</strong></td>
                                        <td width="20%" align="center"><strong>No Propose</strong></td>
                                        <td width="10%" align="center"><strong>Year</strong></td>
                                        <td width="10%" align="center"><strong>Month</strong></td>
                                        <td width="15%" align="center"><strong>Department</strong></td>
                                        <td width="15%" align="center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($all_propose != NULL){
                                            $no = 1;
                                            foreach ($all_propose as $prop) {
                                                echo "<tr class='gradeX'>";
                                                echo "<td align='center'>" . $no . "</td>";
                                                echo "<td align='left'>" . $prop->CHR_NO_PROPOSE . "</td>";
                                                echo "<td align='center'>" . $prop->CHR_YEAR_PROPOSE . "</td>";
                                                echo "<td align='center'>" . date('F', mktime(0, 0, 0, $prop->CHR_MONTH_PROPOSE, 10)) . "</td>";
                                                echo "<td align='center'>" . $prop->CHR_DEPT . "</td>";
                                                echo "<td align='center'><a href='" . base_url('index.php/budget/propose_budget_c/approval_monthly_budget') . "/0/" . str_replace('/','<',trim($prop->CHR_NO_PROPOSE)) . "' class='label label-primary' data-placement='left' title='View'><span class='fa fa-search'></span></a></td>";
                                                echo "</tr>";                                            
                                                $no++;
                                            }
                                        } else {
                                            echo "<tr style='background-color:whitesmoke;'>";
                                            echo "<td colspan='7'><strong>No Data Available</strong></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>                                
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
</aside>
