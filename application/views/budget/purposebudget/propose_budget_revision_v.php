<?php header("Content-type: text/html; charset=iso-8859-1"); ?>

<style>
    #filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }   
</style>

<script>


    function initDatatables2() {

        var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<i class="fa fa-plus-square link"></i>';
        nCloneTd.className = "center";

        $('#example thead tr').each(function() {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        $('#example tbody tr').each(function() {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        function fnFormatDetails(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var budget_type = aData[10];
            var no_budget = aData[3];
            var fiscal_start = aData[11];
            var fiscal_end = aData[12];

            var sOut = '';
            sOut += '<table name="detail_budget" id="filter" style="width:100%; height:100px; font-weight:bold; background-color:white;">';

            $.ajax({
                async: false,
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('budget/purposebudget_c/get_detail_budget_by_no'); ?>",
                data: "tipe_bgt=" + budget_type + "&nomor_bgt=" + no_budget + "&fis_start=" + fiscal_start + "&fis_end=" + fiscal_end,
                success: function(data){
                    console.log(data);
                    var apr = data['MON04'];
                    var mei = data['MON05'];
                    var jun = data['MON06'];
                    var jul = data['MON07'];
                    var agu = data['MON08'];
                    var sep = data['MON09'];
                    var okt = data['MON10'];
                    var nov = data['MON11'];
                    var des = data['MON12'];
                    var jan = data['MON13'];
                    var feb = data['MON14'];
                    var mar = data['MON15'];
                    
                    sOut += '	<tr align="center" style="background-color:#002a80; color:white;">';
                    sOut += '       <td width="16%">APR '+fiscal_start+'</td>';
                    sOut += '       <td width="16%">MEI '+fiscal_start+'</td>';
                    sOut += '       <td width="16%">JUN '+fiscal_start+'</td>';
                    sOut += '       <td width="16%">JUL '+fiscal_start+'</td>';
                    sOut += '       <td width="16%">AGU '+fiscal_start+'</td>';
                    sOut += '       <td width="16%">SEP '+fiscal_start+'</td>';
                    sOut += '	</tr>';
                    sOut += '	<tr align="center">';
                    sOut += '       <td align="center">Rp '+apr+'</td>';
                    sOut += '       <td align="center">Rp '+mei+'</td>';
                    sOut += '       <td align="center">Rp '+jun+'</td>';
                    sOut += '       <td align="center">Rp '+jul+'</td>';
                    sOut += '       <td align="center">Rp '+agu+'</td>';
                    sOut += '       <td align="center">Rp '+sep+'</td>';
                    sOut += '	</tr>';
                    sOut += '	<tr align="center" style="background-color:#002a80; color:white;">';
                    sOut += '       <td>OKT '+fiscal_start+'</td>';
                    sOut += '       <td>NOV '+fiscal_start+'</td>';
                    sOut += '       <td>DES '+fiscal_start+'</td>';
                    sOut += '       <td>JAN '+fiscal_end+'</td>';
                    sOut += '       <td>FEB '+fiscal_end+'</td>';
                    sOut += '       <td>MAR '+fiscal_end+'</td>';
                    sOut += '	</tr>';
                    sOut += '	<tr align="center">';
                    sOut += '       <td align="center">Rp '+okt+'</td>';
                    sOut += '       <td align="center">Rp '+nov+'</td>';
                    sOut += '       <td align="center">Rp '+des+'</td>';
                    sOut += '       <td align="center">Rp '+jan+'</td>';
                    sOut += '       <td align="center">Rp '+feb+'</td>';
                    sOut += '       <td align="center">Rp '+mar+'</td>';
                    sOut += '	</tr>';
                },
                error: function(data){
                    console.log(data);
                    alert('error');
                }
            }); 
            
            sOut += '</table>';

            return sOut;

        }

        var oTable = $('#example').dataTable({
            paging: true
        });

        $('#example tbody').on('click', 'i', function() {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                $(this).removeClass("fa-minus-square").addClass("fa-plus-square");
                oTable.fnClose(nTr);
            } else {
                $(this).removeClass("fa-plus-square").addClass("fa-minus-square");
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });
    }

    $(function() {
        "use strict";
        initDatatables2();
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Propose Revision Master Budget</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-folder-open"></i>
                        <span class="grid-title"><strong>LIST MASTER BUDGET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/budget/purposebudget_c/propose_unbudget') ?>"  class="btn btn-primary" data-placement="left" title="Propose Unbudget">Create Unbudget</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Fiscal Year</td>                                    
                                    <td width="20%">
                                        <select name="CHR_FISCAL" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?php echo site_url('budget/purposebudget_c/propose_budget_revision/0/' . $data->CHR_FISCAL_YEAR_START . '/CAPEX/ALL'); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%">Department</td>
                                    <td width="20%">
                                        <?php if($role == 5){ ?>
                                            <select disabled name="CHR_DEPT" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } else { ?>
                                            <select name="CHR_DEPT" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } ?>
                                            <?php foreach ($all_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/purposebudget_c/propose_budget_revision/0/' . $fiscal_start . '/' . $budget_type . '/' . $dept->INT_ID_DEPT); ?>" 
                                                <?php
                                                if ($kd_dept == $dept->INT_ID_DEPT) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $dept->CHR_DEPT_DESC; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                     <td width="20%"></td>
                                </tr>
                                <tr>
                                    <td width="10%">Budget Type</td>
                                    <td width="20%">
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_bgt_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/purposebudget_c/propose_budget_revision/0/' . $fiscal_start . '/' . trim($bgt->CHR_BUDGET_TYPE) . '/' . $kd_dept); ?>" 
                                                <?php
                                                if ($budget_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%"></td>
                                    <td width="20%"></td>
                                     <td width="20%"></td>
                                </tr>
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div>
                            <table style="font-size:11px;" id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td width="1%" align="center"><strong>No</strong></td>
                                        <td width="3%" align="center"><strong>Status</strong></td> 
                                        <td width="20%" align="center"><strong>No Budget</strong></td>
                                        <td width="5%" align="center"><strong>Year</strong></td>                                        
                                        <td width="34%" align="center"><strong>Description</strong></td>
                                        <td width="20%" align="center"><strong>Total Amount</strong></td>
                                        <!--<td width="3%" align="center"><strong>Active</strong></td>-->
                                        <td width="3%" align="center"><strong>Change Amount</strong></td>
                                        <td width="3%" align="center"><strong>Reschedule</strong></td>
                                        <td width="4%" align="center"><strong>Action</strong></td>
                                        <!-- FOR AJAX -->
                                        <!-- START -->
                                        <td style="display:none"><strong>Budget Type</strong></td>
                                        <td style="display:none"><strong>Fiscal Start</strong></td>
                                        <td style="display:none"><strong>Fiscal End</strong></td>
                                        <!-- END -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($list_master_budget as $list_bgt) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>" . $no . "</td>";
                                        if ($list_bgt->CHR_KODE_TYPE_BUDGET == 'CAPEX') {
                                            if ($list_bgt->CHR_FLG_APPROVAL_PROCESS == '0' || $list_bgt->CHR_FLG_APPROVAL_PROCESS == '2') {
                                                if ($list_bgt->CHR_FLG_USED == '1') {
                                                    $status = "CLOSED";
                                                    echo "<td>CLOSED</td>";
                                                } else {
                                                    $status = "OPEN";
                                                    echo "<td>OPEN</td>";
                                                }
                                            } else if ($list_bgt->CHR_FLG_APPROVAL_PROCESS == '1') {
                                                $status = "WAITING";
                                                echo "<td>WAITING</td>";
                                            } else {
                                                $status = "HOLD";
                                                echo "<td>HOLD</td>";
                                            }
                                        } else {
                                            if ($list_bgt->CHR_FLG_APPROVAL_PROCESS == '0' || $list_bgt->CHR_FLG_APPROVAL_PROCESS == '2') {
                                                $status = "OPEN";
                                                echo "<td>OPEN</td>"; //                                                                                          
                                            } else if ($list_bgt->CHR_FLG_APPROVAL_PROCESS == '1') {
                                                $status = "WAITING";
                                                echo "<td>WAITING</td>";
                                            } else {
                                                $status = "HOLD";
                                                echo "<td>HOLD</td>";
                                            }
                                        }
                                        echo "<td>" . $list_bgt->CHR_NO_BUDGET . "</td>";
                                        echo "<td align='center'>" . $list_bgt->CHR_TAHUN_BUDGET . "</td>";
                                        $desc = substr($list_bgt->CHR_DESC_BUDGET, 0, 40);
                                        echo "<td>" . $desc . "</td>";
                                        $total_amount = $list_bgt->MON_LIMBLN01 + $list_bgt->MON_LIMBLN02 + $list_bgt->MON_LIMBLN03 + $list_bgt->MON_LIMBLN04 +
                                                $list_bgt->MON_LIMBLN05 + $list_bgt->MON_LIMBLN06 + $list_bgt->MON_LIMBLN07 + $list_bgt->MON_LIMBLN08 +
                                                $list_bgt->MON_LIMBLN09 + $list_bgt->MON_LIMBLN10 + $list_bgt->MON_LIMBLN11 + $list_bgt->MON_LIMBLN12 +
                                                $list_bgt->MON_LIMBLN13 + $list_bgt->MON_LIMBLN14 + $list_bgt->MON_LIMBLN15;
                                        echo "<td align='right' style='font-weight:bold;'>Rp " . number_format($total_amount, '2', ',', '.') . "</td>";
                                        //echo "<td align='center'>X</td>";
                                        if($list_bgt->CHR_FLG_CHANGE_AMOUNT == '0'){
                                            echo "<td align='center'>-</i></td>";
                                        } else {
                                            echo "<td align='center'><i style='color: black;' class='fa fa-check'></i></td>";
                                        }
                                        
                                        if($list_bgt->CHR_FLG_RESCHEDULE == '0'){
                                            echo "<td align='center'>-</i></td>";
                                        } else {
                                            echo "<td align='center'><i style='color: black;' class='fa fa-check'></i></td>";
                                        }
                                        
                                        if ($list_bgt->CHR_KODE_TYPE_BUDGET == 'CAPEX'){
                                            if ($list_bgt->CHR_FLG_USED == '1'){
                                                echo "<td align='center'><i class='fa fa-ban'></i></td>";
                                            } else {
                                                echo "<td align='center'><a href='" . base_url('index.php/budget/purposebudget_c/edit_budget_revision') . "/" . $fiscal_start . "/" . $budget_type . "/" . str_replace('/', '<', trim($list_bgt->CHR_NO_BUDGET)) . "' class='label label-primary' data-placement='left' title='Edit'><span class='fa fa-pencil' ></span></a></td>";
                                            }
                                        } else {
                                            echo "<td align='center'><a href='" . base_url('index.php/budget/purposebudget_c/edit_budget_revision') . "/" . $fiscal_start . "/" . $budget_type . "/" . str_replace('/', '<', trim($list_bgt->CHR_NO_BUDGET)) . "' class='label label-primary' data-placement='left' title='Edit'><span class='fa fa-pencil' ></span></a></td>";
                                        }
                                                                                
                                        //-- FOR AJAX --//
                                        //-- START --//
                                        echo "<td style='display:none;'>" . $list_bgt->CHR_KODE_TYPE_BUDGET . "</td>";
                                        echo "<td style='display:none;'>" . $fiscal_start . "</td>";
                                        echo "<td style='display:none;'>" . $fiscal_end . "</td>";
                                        //-- END --//
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>                                                              
                            </table>                                                      
                        </div>                                         
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
//Use this if table offset against width of content

//                                        $(document).ready(function() {
//                                            $('#example').DataTable({
//                                                destroy: true,
//                                                scrollX: true,
//                                                fixedColumns: {
//                                                    leftColumns: 3
//                                                }
//                                            });
//                                        });
</script>
