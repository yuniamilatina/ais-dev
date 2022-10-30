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
                        <div class="pull-right">
                            <?php
                                $now = date("Ym");
                                if($year_month >= $now){                                
                            ?>
                            <a href="<?php echo site_url('budget/propose_budget_c/propose_budget/'. $fiscal_start . '/' . $year_month . '/' . $kode_dept) ?>"  class="btn btn-primary" data-placement="left" title="Propose Budget"><i class="fa fa-plus"></i> New Propose</a>
                            <?php } ?>
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
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/0/' . $data->CHR_FISCAL_YEAR_START . '/' . $year_month . '/' . $kode_dept); ?>" <?php
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
<!--                                        <select class="ddl" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <option value="<?php echo site_url('budget/propose_budget_c/index/0/' . $fiscal_start . '/201604/' . $kode_dept); ?>" <?php if($year_month == '201604'){ echo 'SELECTED';}?>>Apr 2016</option>
                                            <option value="<?php echo site_url('budget/propose_budget_c/index/0/' . $fiscal_start . '/201605/' . $kode_dept); ?>" <?php if($year_month == '201605'){ echo 'SELECTED';}?>>Mei 2016</option>
                                        </select>-->
                                        <select class="form-control" id="month" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <?php for ($x = -3; $x <= 1; $x++) { ?>
                                                <option value="<?PHP echo site_url('budget/propose_budget_c/index/0/' . $fiscal_start . '/' . date("Ym", strtotime("+$x month")) . '/' . $kode_dept); ?>" <?php
                                                if ($year_month == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td>
                                        <?php if($role == '5' || $role == '39' || $role == '45'){ ?>
                                            <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;" style="background-color:whitesmoke;" disabled>
                                        <?php } else { ?>
                                            <select name="CHR_DEPT" class="form-control" id="dept" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } ?> 
                                            <option value=""></option>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/propose_budget_c/index/0/' . $fiscal_start . '/' . $year_month . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
                                                if (trim($kode_dept) == trim($dept->CHR_KODE_DEPARTMENT)) {
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
                        <div style="font-size:11px;">
                            <table style="font-size:11px;" id="table_cpx" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr style="background-color: #002a80; color: white;">
                                        <td width="3%" align="center"><strong>No</strong></td>
                                        <td width="25%" align="center"><strong>No Propose</strong></td>
                                        <td width="15%" align="center"><strong>Department</strong></td>                                        
                                        <td width="10%" align="center"><strong>Year</strong></td>
                                        <td width="10%" align="center"><strong>Month</strong></td>
                                        <td width="10%" align="center"><strong>Approval Process</strong></td>
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
                                                echo "<td align='center'>" . $prop->CHR_DEPT . "</td>";                                            
                                                echo "<td align='center'>" . $prop->CHR_YEAR_PROPOSE . "</td>";
                                                echo "<td align='center'>" . date('F', mktime(0, 0, 0, $prop->CHR_MONTH_PROPOSE, 10)) . "</td>";
                                                
                                                if($prop->CHR_FLG_SWITCH == '0'){
                                                    echo "<td align='center'><strong>OUTSTANDING</strong></td>";
                                                } else if ($prop->CHR_FLG_SWITCH == '1'){
                                                    echo "<td align='center'><strong>PROPOSED (GM)</strong></td>";
                                                } else if ($prop->CHR_FLG_SWITCH == '2'){
                                                    echo "<td align='center'><strong>PROPOSED (BOD)</strong></td>";
                                                } else {
                                                    echo "<td align='center'><strong>COMPLETE</strong></td>";
                                                }
                                                
                                                echo "<td align='center'>";
                                                echo "<a href='" . base_url('index.php/budget/propose_budget_c/view_propose_budget') . "/0/" . str_replace('/','<',trim($prop->CHR_NO_PROPOSE)) . "' class='label label-primary' data-placement='left' title='View'><span class='fa fa-search'></span></a>";
                                                if($prop->CHR_FLG_SWITCH == '0'){
                                                    echo "<a href='" . base_url('index.php/budget/propose_budget_c/delete_propose_budget') . "/" . str_replace('/','<',trim($prop->CHR_NO_PROPOSE)) . "' class='label label-danger' data-placement='left' title='View' onclick='return confirm('Are you sure want to DELETE this propose budget?');'><span class='fa fa-times'></span></a>";
                                                }
                                                echo "</td>";
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
