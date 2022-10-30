<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="">Spare Parts <strong>Stock Opname</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>STOCK OPNAME</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/samanta/spare_parts_sto_c/generate_sto/'. $selected_area) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Generate List STO" style="height:35px;font-size:13px;width:150px;"><i class="fa fa-reorder"></i>&nbsp;&nbsp;GENERATE STO</a>&nbsp;
                            <!-- <a href="<?php echo base_url('index.php/samanta/spare_parts_sto_c/upload_sto/') ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Generate List STO" style="height:35px;font-size:13px;width:150px;"><i class="fa fa-upload"></i>&nbsp;&nbsp;UPLOAD DATA</a>&nbsp; -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php
                                if ($msg != NULL) {
                                    echo $msg;
                                }
                            ?>
                        </div>
                        <div align="center">
                            <?php 
                                // var_dump($freeze_value);
                                // echo "<br>" . number_format($freeze_value->FREEZE_VALUE,2, "." , ",");
                            ?>
                            <strong>Freeze Value</strong> : <span style="font-size: small; font-weight: bold;" >Rp <?php echo number_format($freeze_value->FREEZE_VALUE,2, "." , ","); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>PI Value</strong> : <span style="font-size: small; font-weight: bold;" >Rp <?php echo number_format($pi_value->PI_VALUE,2, "." , ","); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Descrepency Value</strong> : <span style="font-size: small; font-weight: bold;">Rp <?php echo number_format($var_value->VAR_VALUE,2, "." , ","); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <br>
                        
                        <div align="center">
                            <strong>Total Part </strong> : <span style="font-size: small; font-weight: bold;" class="label label-primary"><?php echo number_format($total_part->TOTAL_PART,0, "." , ","); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Counted </strong> : <span style="font-size: small; font-weight: bold;" class="label label-success"><?php echo number_format($counted->COUNTED,0, "." , ","); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Remaining </strong> : <span style="font-size: small; font-weight: bold;" class="label label-warning"><?php echo number_format((($total_part->TOTAL_PART)-($counted->COUNTED)),0, "." , ","); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <!-- <strong>Progress </strong> : <span style="font-size: small; font-weight: bold;" class="label label-warning"><?php echo number_format( ((($counted->COUNTED)/($total_part->TOTAL_PART))*100) ,0, "." , ","); ?> %</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        </div>
                        <br>
                        <table width="70%">
                            <td>Warehouse Area</td>
                            <td>
                                <select id="opt_wcenter" name="CHR_DEPT_SELECTED" class="form-control" style="width:200px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                    <option value="ALL">ALL</option>
                                    <?php foreach ($all_area as $row) { ?>
                                        <option value="<?php echo site_url('samanta/spare_parts_sto_c/search_sto/0/' . trim($row->LOCATION)); ?>" <?php
                                        if ($selected_area == trim($row->LOCATION)) {
                                            echo 'SELECTED';
                                        } ?>
                                        ><?php if (trim($row->LOCATION) == 'MT01') { echo "DIES/MOLD MTE"; } elseif (trim($row->LOCATION) == 'MT02') { echo "DOOR FRAME MTE"; } elseif (trim($row->LOCATION) == 'MT03') { echo "MACHINE MTE"; }  elseif (trim($row->LOCATION) == 'MI00') { echo "MIS MTE"; }?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><span class='badge bg-red'>-</span> <strong>is Loss</strong></td>
                            <td><span class='badge bg-green'>+</span> <strong>is Gain</strong></td>
                        </table>
                        <br>
                        <!-- <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" > -->
                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px" style="text-align:center;vertical-align:middle">No</th>
                                    <th width="180px" style="text-align:center;vertical-align:middle">Spare Part No</th>
                                    <th width="500px" style="vertical-align:middle">Spare Part Name & Specification</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Area</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Qty Freeze</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Qty Sto</th>
                                    <th width="150px" style="text-align:center;vertical-align:middle">Variance Qty</th>                                    
                                    <th width="150px" style="text-align:center;vertical-align:middle">Variance Amount</th>
                                </tr>
                            </thead>

                            <tbody> 
                            <?php $i = 1;
                                foreach ($sto_list as $list){
                                    echo "<tr>";
                                    echo "<td style='text-align:center'>$i</td>";
                                    echo "<td class='part_number' style='text-align:center'>$list->CHR_PART_NO</td>";
                                    echo "<td class='spec'>$list->CHR_SPARE_PART_NAME - <strong>$list->CHR_SPECIFICATION</strong></td>";
                                    echo "<td style='text-align:center'>$list->CHR_SLOC</strong></td>";
                                    echo "<td style='text-align:center'>$list->INT_QTY_FREEZE</td>";
                                    echo "<td style='text-align:center'>$list->INT_QTY_STO</td>";
                                    echo "<td style='text-align:center'>$list->QTY_VARIANCE</td>";
                                    echo "<td style='text-align:right'>".number_format($list->AMOUNT_VARIANCE)."</td>";
                                    echo "</tr>";
                                $i++; }
                            ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="i" value="<?php echo $i - 1; ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >


