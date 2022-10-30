<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        font-size: 11px;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>VOUCHER LIST STOCK OPNAME</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <!--GRID TO DISPLAY GRID TABLE SCAN-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>DATA VOUCHER LIST STOCK OPNAME</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip"  title="Collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">
                                        Area
                                    </td>
                                    <td width="10%">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_chute as $row) { ?>
                                                <option value="<? echo site_url('inventory/reprint_voucher_c/search_sto_data/' . $row->Chute_id); ?>" <?php
                                                if ($chute == $row->Chute_id) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->Chute).' / '.trim($row->chute_desc); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>                                   
                                    <td width="80%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No </th>
                                        <th style="text-align:center;">ID Doc </th>
                                        <th style="text-align:center;">Back. No </th>
                                        <th style="text-align:center;">Part. No </th>
                                        <th style="text-align:center;">No Seri </th>
                                        <th style="text-align:center;">Part.Name & Model </th>
                                        <th style="text-align:center;">Qty </th>
                                        <th style="text-align:center;">Box </th>
                                        <th style="text-align:center;">Eceran </th>
                                        <th style="text-align:center;">Total Qty </th>                                        
                                        <!-- <th style="text-align:center;">NPK Update </th>
                                        <th style="text-align:center;">Tgl Update </th>
                                        <th style="text-align:center;">Waktu Update </th> -->
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_stock_opname as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_ID_DOC</td>";
                                        echo "<td style=text-align:center;>$isi->B_No</td>";
                                        echo "<td style=text-left:center;>$isi->P_No</td>";
                                        echo "<td style=text-left:center;>$isi->No_Seri</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->P_Name</td>";
                                        echo "<td style=text-align:center;>$isi->Qty</td>";
                                        echo "<td style=text-align:center;>$isi->Multiplier</td>";
                                        echo "<td style=text-align:center;>$isi->eceran</td>";
                                        echo "<td style=text-align:center;>$isi->sum_total</td>";
                                        // echo "<td style=text-align:center;>$isi->NPK_Update</td>";
                                        // echo "<td style=text-align:center;>$isi->Tgl_Update</td>";
                                        // echo "<td style=text-align:center;>$isi->Waktu_Update</td>";
                                        ?>
                                    <td style=text-align:center;>
                                        <a data-toggle="modal" data-target="#modalEditStockOpname<?php echo trim($isi->ID) ?>" data-placement="left" data-toggle="tooltip" title="Edit Stock" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                        <!-- <a href="<?php echo base_url('index.php/inventory/stock_opname_c/edit_stock_opname') . "/" . $isi->No_Seri. '/'. $isi->P_No; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a> -->
                                        <!-- <a href="<?php echo base_url('index.php/inventory/stock_opname_c/delete_stock_opname') . "/" . $isi->No_Seri. '/'. $isi->P_No; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this overtime?');"><span class="fa fa-times"></span></a> -->
                                    </td>
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

                <?php foreach ($data_stock_opname as $isi) { ?>
                    <div class="modal fade" id="modalEditStockOpname<?php echo trim($isi->ID) ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Edit Status Print Voucher List</strong></h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                        <?php echo form_open('inventory/reprint_voucher_c/update_data_sto', 'class="form-horizontal"'); ?>
                                            <input name="CHR_IDDOC" class="form-control" type="hidden"  value="<?php echo trim($isi->CHR_ID_DOC) ?>">
                                            <!-- <input name="CHR_PART_NO_OLD" class="form-control" type="hidden"  value="<?php echo trim($isi->CHR_ID_DOC) ?>">
                                            <input name="CHR_BACK_NO_OLD" class="form-control" type="hidden"  value="<?php echo trim($isi->B_No) ?>">
                                            <input name="CHR_SERI" class="form-control" type="hidden"  value="<?php echo trim($isi->No_Seri) ?>"> -->
                                            <input name="CHR_CHUTE" class="form-control" type="hidden"  value="<?php echo $chute ?>">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Status Print (Ubah Jadi 1)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="CHR_FLAG" class="form-control" id="CHR_FLAG"  required value="<?php echo trim($isi->flag_spooling) ?>" >
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-sm-3 control-label">Box</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="INT_BOX" class="form-control" id="box"  required value="<?php echo trim($isi->Multiplier) ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Eceran</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="INT_ECERAN" class="form-control" id="eceran"  required value="<?php echo trim($isi->eceran) ?>" >
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Back No</label>
                                                <div class="col-sm-4">
                                                    <input type="text" readonly name="CHR_BACK_NO" class="form-control" required value="<?php echo trim($isi->B_No) ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Part No</label>
                                                <div class="col-sm-5">
                                                    <input type="text" readonly name="CHR_PART_NO" class="form-control" required value="<?php echo trim($isi->P_No) ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Part Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="CHR_PART_NAME" class="form-control" required value="<?php echo trim($isi->P_Name) ?>" >
                                                </div>
                                            </div> -->
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>
                                                </div>
                                            </div>                                            
                                        <?php echo form_close(); ?>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                    </div>
                 <?php }   ?>
            </div>
        </div>
    </section>
</aside>