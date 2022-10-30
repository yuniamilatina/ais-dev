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
//    $.fn.dataTable.TableTools.defaults.aButtons = ["copy", "csv", "xls", "pdf"];
//    $(document).ready(function () {
//        $('#example').DataTable({
//            dom: 'T<"clear">lfrtip',
//            tableTools: {
//                "sSwfPath": "<?php echo base_url(); ?>assets/swf/copy_csv_xls_pdf.swf"
//            }
//        });
//    });
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>


<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT RAW MATERIAL STOCK OPNAME</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title">RAW MATERIAL STOCK OPNAME</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('raw_material/scan_raw_material_sto_c/print_report_rm_sto', 'class="form-horizontal"'); ?>
                                <button type="submit" name="submit" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                <input type="hidden" name="id_sto" id="id_sto" value="<?php echo $id; ?>" >
                                <input type="hidden" name="date_sto" id="date_sto" value="<?php echo $date; ?>">
								<input type="hidden" name="time_sto" id="time_sto" value="<?php echo $time; ?>">
                            <?php echo form_close() ?>
                        </div><br/>
<!--                        <div class="pull">
                            <?php echo form_open('raw_material/scan_raw_material_sto_c/index', 'class="form-horizontal"'); ?> 
                            <table >
                                <tr>
                                    <td >PIC &nbsp;</td>
                                    <td >
                                        <select class="ddl" id="pic" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                        <select class="ddl" id="pic_sto" name="pic_sto" onchange="this.parentNode.elements['pic'].value += this.value + ' '">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                            <option value="<? echo site_url('pes_new/report_prod_part_ng_ok_c/search_prod_part/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod . '/' . $work_center); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                            <option value=""></option>
                                            <?php
                                            foreach ($getPic as $p) {
                                                echo'<option value="' . $p->CHR_NAME . '">' . $p->CHR_NAME . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    
                                    <td>&nbsp;&nbsp;From &nbsp;</td>
                                    <td>
                                        <div class="input-group date form_date" >
                                            <input type="text" class="form-control date-picker" id="datepicker" name="start_date" value="<?php echo $start_date; ?>">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                    <td> &nbsp;&nbsp; To &nbsp;</td>
                                    <td>
                                        <div class="input-group date form_date" >
                                            <input type="text" class="form-control date-picker" id="datepicker1" name="finish_date" value="<?php echo $finish_date; ?>">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </td>
                                    <td>&nbsp;
                                        <button type="submit" name="btn_submit" id="btn_submit" value="1" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search" style="height:35px;"><i class="fa fa-search"></i></button>
                                    </td>
                                    <input type="text" id='pic' name="pic" value="<?php echo $pic; ?>" disabled/>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div><br/>-->

                        <table id="dataTables3" class="table table-condensed table-striped display" cellspacing="0" width="100%">
                            <thead>
                            <th>No</th>
							<th style="text-align:center">Barcode ID</th>
                            <!--<th>Date Receive</th>
                            <th>Back No</th>
                            <th>Weight</th>
                            <th>Serial</th>
                            <th>Sci No</th>-->
							<th>Tipe Supplier</th>
							<th>Storage Location</th>
							<th>Receiving Area</th>                            
                            </thead> 
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data_rm_sto_detail as $data) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>  
										<td style="text-align:left"><?php echo $data->CHR_SER_NO; ?> <?php echo $data->CHR_BACK_NO ?> <?php echo sprintf("%04s",$data->CHR_WEIGHT); ?> <?php echo $data->CHR_REC_DATE ?> <?php echo $data->CHR_SCI_NO; ?> <?php echo $data->CHR_PDS_NO; ?></td>
                                        <!--<td><?php echo $data->CHR_REC_DATE ?></td>
                                        <td><?php echo $data->CHR_BACK_NO ?></td>
                                        <td><?php echo sprintf("%04s",$data->CHR_WEIGHT); ?></td>
                                        <td><?php echo $data->CHR_SER_NO; ?></td>
                                        <td><?php echo $data->CHR_SCI_NO; ?></td>-->
										<td><?php echo $data->CHR_TIPE_SUPP; ?></td>
										<td><?php echo $data->CHR_STO_LOCT; ?></td>
										<td><?php echo $data->CHR_REC_AREA; ?></td>
                                        <?PHP
                                        $no++;
                                    }
                                    ?></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="grid-header">                        
                        <div class="pull-left">
                            <div class="form-group">
                                <div class="btn-group">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</aside>
