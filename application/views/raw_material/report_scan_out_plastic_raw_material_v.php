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
            <li><a href=""><strong>REPORT SCAN OUT PLASTIC RAW MATERIAL</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title"><strong>SCAN OUT PLASTIC RAW MATERIAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('raw_material/scan_out_plastic_c/index', 'class="form-horizontal"'); ?> 
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
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                <th>No</th>
                                <th>Date/Time In</th>
                                <th>Part No</th>
                                <th>Back No</th>
                                <th>Part Name</th>
                                <th>SLOC From</th>
                                <th>SLOC To</th>
                                <th>Qty/Box</th>
                                <th>Qty Box</th>
                                <th>Qty</th>
                                </thead> 
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data_scan_out as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo date("d-M-Y", strtotime($data->CHR_DATE)) . ' ' . date("H:i:s", (strtotime($data->CHR_TIME_ENTRY) - 3600)) ?></td>
                                            <td><?php echo $data->CHR_PART_NO ?></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_BACK_NO ?></div></td>
                                            <td><?php echo $data->CHR_PART_NAME; ?></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_SLOC_FROM; ?></div></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_SLOC_TO; ?></div></td>
                                            <td><?php echo $data->INT_QTY_PER_BOX; ?></td>
                                            <td><?php echo $data->INT_QTY_BOX; ?></td>
                                            <td><?php echo $data->INT_TOTAL_QTY; ?></td>
                                            <?PHP
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






