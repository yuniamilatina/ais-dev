<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        font-size: 11px;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT STOCK OPNAME</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <!--GRID TO DISPLAY GRID TABLE SCAN-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>REPORT STOCK OPNAME SCAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">
                                        Chute/Area
                                    </td>
                                    <td width="10%">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_chute as $row) { ?>
                                                <option value="<? echo site_url('inventory/stock_opname_c/index/' . $row->Chute_id); ?>" <?php
                                                                                                                                                        if ($chute == $row->Chute_id) {
                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                        }
                                                                                                                                                        ?>><?php echo trim($row->Chute) . ' / ' . trim($row->chute_desc); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>

                                    <td width="80%" style='text-align:right;'>
                                        <?php echo form_open('inventory/stock_opname_c/print_stock_opname', 'class="form-horizontal"'); ?>
                                        <input type='hidden' name='CHUTE' value='<?php echo trim($chute); ?>'>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Qty </th>
                                        <th style="text-align:center;">Box </th>
                                        <th style="text-align:center;">Eceran </th>
                                        <th style="text-align:center;">Total Qty </th>
                                        <th style="text-align:center;">Uom</th>
                                        <th style="text-align:center;">Sub Area </th>
                                        <th style="text-align:center;">Chute </th>
                                        <!--                                        <th style="text-align:center;">Scanned By </th>
                                        <th style="text-align:center;">Scanned Date </th>
                                        <th style="text-align:center;">Scanned Time </th>-->
                                    </tr>
                                </thead>
                                <!--                                <tfoot>
                                     <tr class='gradeX'>
                                        <th style="text-align:center;">No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Qty </th> 
                                        <th style="text-align:center;">Box </th>
                                        <th style="text-align:center;">Total Qty </th>
                                        <th style="text-align:center;">Uom</th>
                                        <th style="text-align:center;">Sub Area </th>
                                        <th style="text-align:center;">Chute </th>
                                        <th style="text-align:center;">Location Sto. </th>
                                        <th style="text-align:center;">Scanned By </th>
                                        <th style="text-align:center;">Scanned Date </th>
                                        <th style="text-align:center;">Scanned Time </th>
                                    </tr>
                                </tfoot>-->
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_stock_opname as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->B_No</td>";
                                        echo "<td style=text-left:center;>$isi->P_No</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->P_Name</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->S_Location</td>";
                                        echo "<td style=text-align:center;>$isi->Qty</td>";
                                        echo "<td style=text-align:center;>$isi->Multiplier</td>";
                                        echo "<td style=text-align:center;>$isi->eceran</td>";
                                        echo "<td style=text-align:center;>$isi->sum_total</td>";
                                        echo "<td style=text-align:center;>$isi->uom</td>";
                                        echo "<td style=text-align:center;>$isi->SUBAREA</td>";
                                        echo "<td style=text-align:center;>$isi->Chute</td>";
                                        //                                        echo "<td style=text-align:center;>$isi->CHR_SCANNED_BY</td>";
                                        //                                        echo "<td style=text-align:center;>$isi->CHR_SCANNED_DATE</td>";
                                        //                                        echo "<td style=text-align:center;>$isi->CHR_SCANNED_TIME</td>";
                                    ?>
                                        </tr>
                                    <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--GRID TO DISPLAY GRID TABLE ENTRY-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>REPORT STOCK OPNAME ENTRY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                        </div>
                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Sloc.</th>
                                        <th style="text-align:center;">Qty </th>
                                        <th style="text-align:center;">Box </th>
                                        <th style="text-align:center;">Eceran </th>
                                        <th style="text-align:center;">Total Qty </th>
                                        <th style="text-align:center;">Uom</th>
                                        <th style="text-align:center;">Sub Area </th>
                                        <th style="text-align:center;">Chute </th>
                                        <th style="text-align:center;">iso_qty_box </th>
                                        <th style="text-align:center;">lso_qty_eceran </th>
                                        <th style="text-align:center;">lso_acc_qty_box </th>
                                        <th style="text-align:center;">lso_acc_qty_eceran </th>
                                        <th style="text-align:center;">lso_acc_total </th>
                                        <th style="text-align:center;">lso_acc_diff </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_stock_opname_entry as $isi) {
                                        $total = ($isi->lso_amount_pcs_in_box * $isi->lso_amount_box) + $isi->lso_amount_pcs;
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->lso_back_no</td>";
                                        echo "<td style=text-left:center;>$isi->lso_no_sap</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->lso_part_name</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->lso_sloc</td>";
                                        echo "<td style=text-align:center;>$isi->lso_amount_pcs_in_box</td>";
                                        echo "<td style=text-align:center;>$isi->lso_amount_box</td>";
                                        echo "<td style=text-align:center;>$isi->lso_amount_pcs</td>";
                                        echo "<td style=text-align:center;>$total</td>";
                                        echo "<td style=text-align:center;>$isi->lso_unit</td>";
                                        echo "<td style=text-align:center;>$isi->lso_area</td>";
                                        echo "<td style=text-align:center;>Area $isi->lso_area_sto</td>";
                                        echo "<td style=text-align:center;>$isi->Iso_qty_box</td>";
                                        echo "<td style=text-align:center;>$isi->Iso_qty_eceran</td>";
                                        echo "<td style=text-align:center;>$isi->lso_acc_qty_box</td>";
                                        echo "<td style=text-align:center;>$isi->lso_acc_qty_eceran</td>";
                                        echo "<td style=text-align:center;>$isi->lso_acc_total</td>";
                                        echo "<td style=text-align:center;>$isi->lso_acc_diff</td>";
                                    ?>
                                        </tr>
                                    <?php
                                        $r++;
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>