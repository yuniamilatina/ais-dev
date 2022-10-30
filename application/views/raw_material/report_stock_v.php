<script>
    $(document).ready(function () {
        var table = $('#dataTables1').DataTable({
            processing: true
        });

        $('#btn_refresh').on('click', function () {
            $(".dataTables_processing").show();
            setTimeout(function () {

                table.draw();
                $(".dataTables_processing").hide();
            }, 1000);
        });
    });
</script>
<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    input[type=checkbox].css-checkbox {
        position:absolute; z-index:-1000; left:-1000px; overflow: hidden; clip: rect(0 0 0 0); 
        height:1px; width:1px; margin:-1px; padding:0; border:0;
    }

    input[type=checkbox].css-checkbox + label.css-label {
        padding-left:30px;
        height:25px; 
        display:inline-block;
        line-height:25px;
        background-repeat:no-repeat;
        background-position: 0 0;
        font-size:12px;
        vertical-align:middle;
        cursor:pointer;
    }

    input[type=checkbox].css-checkbox:checked + label.css-label {
        background-position: 0 -25px;
    }
    label.css-label {
        background-image:url(http://csscheckbox.com/checkboxes/u/csscheckbox_391ce065f36b1460c4845fa9b5173fba.png);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT INVENTORY</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT INVENTORY </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('raw_material/report_stock_c/search_by', 'class="form-horizontal"'); ?> 
                            <table width="100%" id='filter' >
                                <tr>
                                    <td width="10%">
                                        <input type="checkbox" value="PP01" name="PP01" id="checkboxPP01" <?php echo $checkedPP01; ?> class="css-checkbox" /> 
                                        <label for="checkboxPP01" class="css-label">PP01 (FG)</label>
                                    </td>
                                    <td width="10%">
                                        <input type="checkbox" value="PP02" name="PP02" id="checkboxPP02" <?php echo $checkedPP02; ?> class="css-checkbox" /> 
                                        <label for="checkboxPP02" class="css-label">PP02 (OEM)</label>
                                    </td>
                                    <td width="10%">
                                        <input type="checkbox" value="PP03" name="PP03" id="checkboxPP03" <?php echo $checkedPP03; ?> class="css-checkbox" /> 
                                        <label for="checkboxPP03" class="css-label">PP03 (AM)</label>
                                    </td>
                                    <td width="10%">
                                        <input type="checkbox" value="PP04" name="PP04" id="checkboxPP04" <?php echo $checkedPP04; ?> class="css-checkbox" /> 
                                        <label for="checkboxPP04" class="css-label">PP04 (DELIVERY)</label>
                                    </td>
                                    <td width="20%">
                                        <input type="checkbox" value="PP05" name="PP05" id="checkboxPP05" <?php echo $checkedPP05; ?> class="css-checkbox" /> 
                                        <label for="checkboxPP05" class="css-label">PP05 (AIIA)</label>
                                    </td>
                                    <td width="20%">
                                    </td>
                                <tr>
                                <tr>
                                    <td width="10%">
                                        <input type="checkbox" value="WH00" name="WH00" id="checkboxWH00" <?php echo $checkedWH00; ?> class="css-checkbox" /> 
                                        <label for="checkboxWH00" class="css-label">WH00 (Warehouse & RM)</label>
                                    </td>
                                    <td width="10%">
                                        <input type="checkbox" value="WP01" name="WP01" id="checkboxWP01" <?php echo $checkedWP01; ?> class="css-checkbox" /> 
                                        <label for="checkboxWP01" class="css-label">WP01 (Work in Process)</label>
                                    </td>
                                    <td width="10%">
                                        <input type="checkbox" value="RE01" name="RE01" id="checkboxRE01" <?php echo $checkedRE01; ?> class="css-checkbox" /> 
                                        <label for="checkboxRE01" class="css-label">RE01 (Reject)</label>
                                    </td>
                                    <td width="20%">
                                        <input type="checkbox" value="WH20" name="WH20" id="checkboxWH20" <?php echo $checkedWH20; ?> class="css-checkbox" /> 
                                        <label for="checkboxWH20" class="css-label">WH20 (WH Multisarana)</label>
                                    </td>
                                    <td width="20%">
                                        <input type="checkbox" value="WH30" name="WH30" id="checkboxWH30" <?php echo $checkedWH30; ?> class="css-checkbox" /> 
                                        <label for="checkboxWH30" class="css-label">WH30 (WH SGL)</label>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="20%">
                                    </td>
                                    <td width="20%">
                                        <input type="checkbox" value=true name="isNegatife" id="checkboxNeg" <?php echo $checkedNeg; ?> class="css-checkbox"> 
                                        <label for="checkboxNeg" class="css-label"> Negative Stock Only</label>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="20%">

                                        <button type="submit" name="btn_submit" id="btn_submit" value="1" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px;width:100px;"><i class="fa fa-search"></i>&nbsp;&nbsp;Filter</button>
                                        <?php echo form_close(); ?></td>
                                    <td width="20%">
                                    </td>
                                    <td width="20%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="20%">
                                        <?php echo form_open('raw_material/report_stock_c/download', 'class="form-horizontal"'); ?> 
                                        <button type="submit" name="btn_submit" id="btn_download" value="1" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Export to Excel" style="height:30px;width:150px;"><i class="fa fa-download"></i>&nbsp;&nbsp;Export to Excel</button>
                                        <?php echo form_close(); ?>
                                    </td>
                                <tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;"><div class='td-fixed'>Back No</div></th>
                                <th style="text-align:center;">Part Name</th>
                                <th style="text-align:center;"><div class='td-fixed'>SLOC.</div></th>
                                <th style="text-align:center;">Mat Type Name</th>
                                <th style="text-align:center;">Total Qty. </th>
                                <th style="text-align:center;">Unit </th>
                                <th style="text-align:center;">Amount </th>
                                <th style="text-align:center;">Std. Cost </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_stock as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_SLOC</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_MAT_TYPE_NAME</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->INT_TOTAL_QTY) . "</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_UOM</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->CHR_TOTAL_PRICE) . "</td>";
                                        echo "<td style=text-align:right;>" . number_format($isi->CHR_STD_PRICE) . "</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($load_to_sql == 0) { ?>
                            <div class="grid-no-header">
                                Data was acquired on <?php echo date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])); ?>
                                <div style='font-size: 14px;' class="pull-right">
                                    <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="grid-no-header">
                                Data is being generated, wait for a few minutes or click <a href='<?php echo base_url('index.php/raw_material/report_stock_c') ?>' id="btn_refresh" >Refresh</button>
                                    <div style='font-size: 14px;' class="pull-right">
                                        <strong class='badge bg-blue'>TOTAL : Calculate... </strong> 
                                    </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
