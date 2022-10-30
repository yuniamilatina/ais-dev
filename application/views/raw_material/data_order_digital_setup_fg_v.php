<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>

<script>
    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>

<script type="text/javascript" language="javascript" class="init">
    $.fn.dataTable.TableTools.defaults.aButtons = ["copy", "csv", "xls", "pdf"];
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'T<"clear">lfrtip',
            tableTools: {
                "sSwfPath": "<?php echo base_url(); ?>assets/swf/copy_csv_xls_pdf.swf"
            }
        });
    });
</script>
<style type="text/css">
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 5px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/order_setup_chute_c/'); ?>"><span><strong>Data Order Digital Setup Chute FG</strong></span></a></li>
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
                        <i class="fa fa-table"></i>
                        <span class="grid-title">DATA ORDER DIGITAL SETUP CHUTE</span>
<!--                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/raw_material/komparasi_kbn_fg_c/prepare_upload_data/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload target Production" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Upload Data</a>
                        </div>-->
                    </div>
                    <div class="grid-body">  
                        <div class="pull">
                            <?php echo form_open('raw_material/order_setup_chute_c/index', 'class="form-horizontal"'); ?> 
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="5%">From</td>
                                    <td width="20%">
                                        <div class="input-group date form_date" >
                                            <input type="text" class="form-control date-picker" id="datepicker" name="start_date" value="<?php echo $start_date; ?>">
                                        </div>
                                    </td>
                                    <td width="5%">To</td>
                                    <td width="20%">
                                        <div class="input-group date form_date" >
                                            <input type="text" class="form-control date-picker" id="datepicker1" name="finish_date" value="<?php echo $finish_date; ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" name="btn_submit" id="btn_submit" value="1" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Search" style="height:35px;width:100px;"><i class="fa fa-filter"></i>&nbsp;&nbsp;Filter</button>
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Prod No</th>
                                    <th>Part No</th>
                                    <th>Back No</th>
                                    <th>Qty Order</th>
                                    <th>Date Order</th>
                                    <th>Time Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $btn = 'success';
                                    $color = NULL;
                                    $level = null;
                                    $late = NULL;
                                    
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PRD_ORDER_NO</td>";
                                    echo "<td>$isi->CHR_PART_NO_FG</td>";
                                    echo "<td align='center'>$isi->CHR_BACK_NO_FG</td>";
                                    echo "<td>$isi->INT_QTY_FG</td>";
                                    echo "<td>".date("d-M-Y", strtotime($isi->CHR_DATE_ORDER))."</td>";
                                    echo "<td>".date("H:i", strtotime($isi->CHR_TIME_ORDER))."</td>";
                                    ?>
                                    <td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/raw_material/order_setup_chute_c/view_data_order') . "/" . trim($isi->INT_ID) ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="View Data Order"><span class="fa fa-check"></span></a>
                                        
                                    </td>                           
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DATA IN SETUP CHUTE</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No </th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Kanban IN</th>
                                    <th style="text-align:center;">Date Scan-IN</th>
                                    <th style="text-align:center;">Time Scan-IN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($setup_in as $isi) {
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
                                    echo "<td style='text-align:center;'>$isi->scan_ord</td>";
                                    ?>
                                <td style="text-align:center;">
                                    <?php echo date("d-M-Y", strtotime($isi->CHR_DATE_ENTRY)) ?>
                                </td>
                                <td style="text-align:center;">
                                    <?php echo date("H:i", strtotime($isi->CHR_DATE_ENTRY)) ?>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DATA STOCK IN FINISH GOOD</strong></span>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No </th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Kanban IN</th>
                                    <th style="text-align:center;">Date Scan-Out</th>
                                    <th style="text-align:center;">Time Scan-Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($setup_out as $isi) {
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
                                    echo "<td style='text-align:center;'></td>";
                                    echo "<td style='text-align:center;'>$isi->scan_out</td>";
                                    ?>
                                <td style="text-align:center;">
                                    <?php echo date("d-M-Y", strtotime($isi->CHR_DATE_ENTRY)) ?>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>-->
    </section>
</aside>