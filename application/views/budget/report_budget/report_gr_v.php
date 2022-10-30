<?php header("Content-type: text/html; charset=iso-8859-1"); ?>
<style>
#filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

div.scrollmenu {
    overflow: auto;
    white-space: nowrap;
    font-size: 11px;
}

</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Report GR Actual</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT GR ACTUAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
						<div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_gr_c/export_report_gr_actual', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_EXP" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_EXP" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_EXP" value="<?php echo $kode_sect; ?>" type="hidden">
                                <input name="CHR_BUDGET_TYPE_EXP" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id="filter">
                                <tr>
                                    <td width="10%">Fiscal Year</td>
                                    <td width="20%">
                                        <select name="CHR_FISCAL_YEAR" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($data_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/report_gr_c/filter/' . $data->CHR_FISCAL_YEAR_START . '/' . $bgt_type . '/' . $kode_dept . '/' . $kode_sect); ?>" <?php
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
                                            <select <?php if($role != 1 && $role != 2 && $role != 13 && $npk != '0483' && $npk != '0483a' && $npk != '7520'){ echo 'disabled';} ?> name="CHR_DEPARTMENT" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;">
											<option value="<?php echo site_url('budget/report_gr_c/filter/' . $fiscal_start . '/' . $bgt_type. '/' . 'ALL/' . $kode_sect); ?>">ALL</option>
                                            <?php foreach ($list_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/report_gr_c/filter/' . $fiscal_start . '/' . $bgt_type . '/' . trim($dept->CHR_KODE_DEPARTMENT) . '/' . $kode_sect); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($dept->CHR_KODE_DEPARTMENT) . ' - ' . $dept->CHR_DEPARTMENT_DESCRIPTION; ?> </option>
                                                    <?php } ?>
                                        </select>
									</td>
                                    <td width="20%"></td> 
                                </tr>
                                <tr>
                                    <td>Budget Type</td>
                                    <td>
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""></option>
                                            <?php foreach ($list_budget_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/report_gr_c/filter/' . $fiscal_start . '/' . trim($bgt->CHR_BUDGET_TYPE) . '/' . $kode_dept . '/' . $kode_sect); ?>" <?php
                                                if ($bgt_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>                                             
                                    </td>
                                    <td></td>
                                    <td>Section</td>
                                    <td>
                                            <select name="CHR_SECTION" class="form-control" id="sect_name" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                                <option value="<?php echo site_url('budget/report_gr_c/filter/' . $fiscal_start . '/' . $bgt_type. '/' . $kode_dept . '/ALL'); ?>">ALL</option>
                                            <?php foreach ($list_sect as $sect) { ?>
                                                <option value="<?php echo site_url('budget/report_gr_c/filter/' . $fiscal_start . '/' . $bgt_type. '/' . $kode_dept . '/' . trim($sect->CHR_KODE_SECTION)); ?>" <?php
                                                if ($kode_sect == trim($sect->CHR_KODE_SECTION)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($sect->CHR_KODE_SECTION); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>                                                     
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <div>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr class="gradeX">
                                    <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;text-align:center;">Section</th>
                                    <th colspan='13' style="text-align:center;">Amount</th>
                                </tr>
								<tr class='gradeX'>
                                    <th style="text-align:center;"><?php echo 'APR '. substr($fiscal_start, -2);?></th>
                                    <th style="text-align:center;"><?php echo 'MAY '. substr($fiscal_start, -2);?></th>
                                    <th style="text-align:center;"><?php echo 'JUN '. substr($fiscal_start, -2);?></th>
                                    <th style="text-align:center;"><?php echo 'JUL '. substr($fiscal_start, -2);?></th>
                                    <th style="text-align:center;"><?php echo 'AUG '. substr($fiscal_start, -2);?></th>
                                    <th style="text-align:center;"><?php echo 'SEP '. substr($fiscal_start, -2);?></th>
                                    <th style="text-align:center;"><?php echo 'OKT '. substr($fiscal_start, -2);?></th>
									<th style="text-align:center;"><?php echo 'NOV '. substr($fiscal_start, -2);?></th>
									<th style="text-align:center;"><?php echo 'DES '. substr($fiscal_start, -2);?></th>
									<th style="text-align:center;"><?php echo 'JAN '. substr($fiscal_end, -2);?></th>
									<th style="text-align:center;"><?php echo 'FEB '. substr($fiscal_end, -2);?></th>
									<th style="text-align:center;"><?php echo 'MAR '. substr($fiscal_end, -2);?></th>
									<th style="text-align:center;">TOTAL</th>
                                </tr>

                            </thead>
                            <tbody>
                             <?php
                                        $i = 1;
                                        if($list_data)
                                        {
                                            foreach ($list_data as $isi) {
                                        
                                        if($isi->CHR_SECTION != 'TOTAL'){
                                            echo "<tr>";
                                            echo "<td align='center'>". $i . "</td>";
                                        } else {
                                            echo "<tr style='font-weight:bold; background-color:whitesmoke;'>";
                                            echo "<td align='center' style='color:whitesmoke;'>". $i . "</td>";
                                        }                                        
                                            
                                            echo "<td align='center'>". $isi->CHR_SECTION ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_APRIL,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_MAY,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_JUNE,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_JULY,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_AUGUST,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_SEPTEMBER,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_OCTOBER,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_NOVEMBER,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_DECEMBER,0,',','.') ."</td>";
											echo "<td align='center'>". number_format($isi->MNY_JANUARY,0,',','.') ."</td>";
                                            echo "<td align='center'>". number_format($isi->MNY_FEBRUARY,0,',','.') ."</td>";
											echo "<td align='center'>". number_format($isi->MNY_MARCH,0,',','.') ."</td>";
											echo "<td align='center'><strong>". number_format($isi->MNY_TOTAL_AMOUNT,0,',','.') ."</strong></td>";
                                        echo"</tr>";

                                                $i++;
                                            }   
                                        }
                                        else
                                        {
                                            
                                        }
                                    ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT GR ACTUAL - DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
						<div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_gr_c/export_report_gr_actual_detail', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_EXP" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_EXP" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_EXP" value="<?php echo $kode_sect; ?>" type="hidden">
                                <input name="CHR_BUDGET_TYPE_EXP" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            
                        </div>
                        <div>&nbsp;</div>
                        <div>
                         <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr class='gradeX'>
                                    <th style=text-align:center;>No</th>
                                    <th style=text-align:center;>PR No</th>
                                    <th style=text-align:center;>Budget No</th>
                                    <th style=text-align:center;>Item Description</th>
                                    <th style=text-align:center;>GL Account</th>
                                    <th style=text-align:center;>Cost Center SAP</th>
                                    <th style=text-align:center;>GR Date</th>
                                    <th style=text-align:center;>Amount</th>
                                    <th style=text-align:center;>Supplier</th>
                                    <th style=text-align:center;>PIC</th>
                                </tr>                                
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if($list_data_detail)
                                        {
                                            foreach ($list_data_detail as $isi_detail) {

                                    ?>
                                        <tr>
                                            <td align='center'><?php echo $i ?></td>
                                            <td><?php echo $isi_detail->CHR_NO_PR ?></td>
                                            <td><?php echo $isi_detail->CHR_NO_BUDGET ?></td>
                                            <td><?php echo $isi_detail->CHR_ITEM_DESC ?></td>
                                            <td><?php echo $isi_detail->CHR_GL_ACCOUNT ?></td>
                                            <td><?php echo $isi_detail->CHR_COST_CENTER_SAP ?></td>
                                            <td><?php echo $isi_detail->CHR_GR_DATE ?></td>
                                            <td align='right'><strong><?php echo number_format($isi_detail->MNY_AMOUNT,0,',','.')?></strong></td>
                                            <td><?php echo $isi_detail->CHR_SUPPLIER ?></td>
                                            <td><?php echo $isi_detail->CHR_PIC  ?></td>
                                        </tr>
                                    <?php
                                                $i++;
                                            }   
                                        }
                                        else
                                        {
                                            
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
    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 2
            }
        });
		
		 $('#example2').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        });
    });
</script>