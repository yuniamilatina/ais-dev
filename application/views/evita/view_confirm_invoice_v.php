<script>
    $(document).ready(function() {
        $("#jt_tempo").change(function() {

            var jt_tempo = $("#jt_tempo").val();
            // var jt_tempo_val = $("#jt_tempo option:selected").text();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('evita/invoice_c/due_date' . '/' . $data->APNO  . '-' . substr($data->TGLENTRY1, 2, 2)); ?>",
                data: "jt_tempo=" + jt_tempo,
                success: function(data) {
                    //alert('asd');
                    $("#txtHint").html(data);
                    $("#datepicker").val(data);
                    $("#txtHint2").html(data);
                }
            });
        });
        $("#TGLJTTEMPO").focusout(function() {

            var TGLJTTEMPO = $("#TGLJTTEMPO").val();
            var TGLJTTEMPO_val = $("#TGLJTTEMPO :input").text();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('evita/invoice_c/due_date2' . '/' . $data->APNO  . '-' . substr($data->TGLENTRY1, 2, 2)); ?>",
                data: "TGLJTTEMPO=" + TGLJTTEMPO,
                success: function(data) {
                    $("#txtHint").html(data);
                    $("#txtHint2").html(data);
                }
            });
        });

        $("#jt_tempo").mouseleave(function() {
            //alert('a');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cashier/page'); ?>",
                success: function() {}
            });
        });

    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Confirm Invoice</strong></a></li>
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
                        <i class="fa fa-print"></i>
                        <span class="grid-title"><strong>CONFIRM INVOICE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-2 ">
                                    <?php
                                    if ($data->TGLTRM != NULL || $data->TGLTRM != "") {
                                    ?>
                                        <a target="blank" href="<?php echo base_url('index.php/evita/invoice_c/reprint') . '/' . $data->APNO . '-' . substr($data->TGLENTRY1, 2, 2); ?>"><button class="btn btn-block btn-success tip-bottom" title="You can re_print this invoice, just in case">Re_Print</button></a>
                                        <a target="blank" href="<?php echo base_url('index.php/evita/invoice_c/reprint_all') . '/' . $data->APNO . '-' . substr($data->TGLENTRY1, 2, 2); ?>"><button class="btn btn-block btn-success tip-bottom" title="You can re_print this invoice, just in case">Re_Print All</button></a>

                                    <?php
                                    } else {
                                    ?>
                                        <!--a target="blank" <?php echo $disable; ?>  href="<?php echo base_url('index.php/evita/invoice_c/cashier_confirm') . '/' . $data->APNO . '-' . substr($data->TGLENTRY1, 2, 2); ?>"><button <?php echo $disable; ?>  class="btn btn-block btn-success tip-bottom" title="Confirm the invoice">Confirm</button></a-->
                                        <?php echo form_open('evita/invoice_c/cashier_confirm', 'class="form-horizontal"'); ?>
                                        <button formtarget="_blank" <?php echo $disable; ?> type="submit" class="btn btn-block btn-success tip-bottom" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Confirm</button>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-sm-2">
                                    <?php //echo anchor('cashier/cashier_edit' . '/' . str_replace('=', '-', str_replace('/', '_', base64_encode($data->APNO))), 'Edit', '' . $disable . ' class="btn btn-block btn-primary tip-bottom" title="Edit the invoice"'); 
                                    ?>
                                    <?php echo anchor('evita/invoice_c/reject' . '/' . $data->APNO . '-' . substr($data->TGLENTRY1, 2, 2), 'Reject', '' . $disable . ' class="btn btn-block btn-danger tip-bottom" title="Reject the invoice"'); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo anchor('evita/invoice_c/confirm', 'Scan Invoice', 'class="btn btn-block btn-warning tip-bottom" title="Scan another Invoices"'); ?>
                                </div>

                                <div class="col-sm-3">
                                    <div class="controls">
                                        Select payment due date type :
                                        <select <?php echo $disable; ?> class="form-control" title="Select payment due date type." id="jt_tempo" name="jt_tempo">
                                            <option value="<?php echo $tempo_minggu; ?>">2 Weeks</option>
                                            <option value="<?php echo $tempo_bulan; ?>">1 Month</option>
                                            <option value="<?php echo $tempo_30d; ?>">30 Days</option>
                                        </select>
                                    </div>

                                </div>
                                <!--        <div class="col-xs-2">
                                            <div class="form-group">
                                                <div  class=" controls">
                                                    < </div>
                                            </div>
                                        </div>-->
                                <div class="col-sm-2">
                                    <!--            <form action="POST">
                                    <?php // echo form_open('cashier/cashier_confirm/' . $data->APNO, 'class="form-horizontal"');   
                                    ?> -->
                                    <!--<button id="txtHint" class="btn btn-block btn-default tip-bottom" title="Due date payment" name="txtHint"  readonly=true ><?php echo date('d M, Y', strtotime($tempo)); ?></button>-->
                                    Payment due date :
                                    <input autofocus="autofocus" id="datepicker" type="text" <?php echo $disable; ?> name="TGLJTTEMPO" data-date-format="dd-mm-yyyy" value="<?php echo date('m/d/Y', strtotime($tempo)); ?>" title="Choose due date manually on date picker." class="datepicker form-control input-sm tip-bottom">
                                    <input type="hidden" name="APNO" value="<?php echo $data->APNO; ?>">
                                    <input type="hidden" name="YEAR" value="<?php echo substr($data->TGLENTRY1, 2, 2); ?>">
                                    <!--</form>-->


                                </div>


                            </div>
                        </div>
                        <br /><br />

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-print"></i>
                        <span class="grid-title"><strong>INVOICE RECEIPT</strong> <?php echo ' ' . $data->INVNO; ?></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-4 ">
                                    <p>PT AISIN INDONESIA<br>
                                        EJIP Industrial Park Plot 5J<br>
                                        Lemahabang Bekasi</p>
                                    <p>
                                    <table width='100%'>
                                        <tr>
                                            <td>No. AP </td>

                                            <td><?php
                                                echo '   ' . $data->APNO . '/' . date('y');
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Supplier </td>

                                            <td><?php
                                                $user_session = $this->session->all_userdata();
                                                echo '   ' . $namasup;
                                                ?></td>
                                        </tr>

                                    </table>


                                </div>

                                <div class="col-md-4 text-center">

                                    <h4>INVOICE</h4>

                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="panel-body">
                                        <!--                                    <img src="<?php echo base_url('assets/img/barcode/' . trim($data->KODESUP) . '.jpg') ?>"></img>-->
                                        <!--            <br><br><br><p><?php echo 'Tanggal : ' . (string) date('d M Y', strtotime($data->TGLTRM)); ?></p>-->

                                    </div>
                                </div>


                            </div>


                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th class="total-label">
                                                <div class="text-center">No</div>
                                            </th>
                                            <th class="total-label">
                                                <div class="text-center">Invoice</div>
                                            </th>
                                            <th class="total-label">
                                                <div class="text-center">Invoice Date</div>
                                            </th>
                                            <th class="total-label">
                                                <div class="text-center">Information</div>
                                            </th>
                                            <th class="total-label">
                                                <div class="text-center">Amount</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="total-label" colspan="4">
                                                Total:
                                            </th>
                                            <th class="total-amount">
                                                <div class="pull-right"><?php echo $data->KD_CURRENCY . ' ' . number_format($data->AMOUNT); ?></div>

                                            </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $i = 1; ?>

                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data->INVNO; ?></td>
                                            <td><?php
                                                $TINV = date('d M, Y', strtotime($data->TGLINV));
                                                echo $TINV;
                                                ?></td>
                                            <td><?php echo $data->KET; ?></td>
                                            <td>
                                                <div class="pull-right">
                                                    <?php echo $data->KD_CURRENCY . ' ' . number_format($data->AMOUNT); ?>
                                                </div>

                                            </td>
                                        </tr>

                                        <?php $i++; ?>
                                    </tbody>
                                </table>
                            </div>


                            <div class="col-md-12">
                                <p class="amount-word">
                                    Amount in Word: <span> <br><?php echo $terbilang; ?></span>
                                </p>

                                <!--            <br> <?php echo $terbilang; ?> </p>-->

                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <table class="table text-center table-bordered">
                                        <tr class="info">
                                            <td>Delivered by</td>
                                            <td>Accepted by</td>
                                        </tr>
                                        <tr>
                                            <td><br><br></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="col-md-5">

                                    <table width="80%">
                                        <tr>
                                            <td>Bank Name</td>
                                            <td><?php echo '  ' . trim($bank); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Acc No.</td>
                                            <td><?php echo '  ' . trim($acno); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Account Name</td>
                                            <td><?php echo '  ' . trim($namaac); ?></td>
                                        </tr>
                                    </table>
                                    <br><br>
                                </div>

                                <div class="col-md-3 text-center">
                                    <!--p><?php echo '__________, ' . (string) date('d M Y'); ?></p>
                                    <br>

                                    <p><?php echo '( ' . $data->KD_CURRENCY . ' )'; ?>
                                        <br--><br><br><br><br>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <?php
                                echo anchor('evita/invoice_c/confirm', 'Back', 'class="btn btn-warning tip-top" title="Back to dashboard"') . ' ';
                                ?>

                            </div>
                            <div class="col-md-12">

                            </div>
                        </div>
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <br /><br />
                    </div>
                </div>
            </div>

        </div>

    </section>
</aside>