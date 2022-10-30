<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Report Budget Usage</strong></a></li>
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
                <div class="grid ">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT</strong> BUDGET USAGE</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('budget/purchase_request_c/search_prepare_report_budget_usage', 'class="form-horizontal"'); ?>

                            <select name="INT_ID_FISCAL_YEAR" class="ddl">
                                <?php
                                foreach ($data_fiscal as $isi) {
                                    if ($new_fiscal == $isi->INT_ID_FISCAL_YEAR) {
                                        ?> 
                                        <option selected="true" value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $isi->INT_ID_FISCAL_YEAR; ?>"><?php echo $isi->CHR_FISCAL_YEAR; ?></option>
                                        <?php
                                    }
                                }
                                ?> 
                            </select>

                            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px"><i class="fa fa-search"></i></button>
                            <?php echo form_close(); ?>

                        </div>
                        <?php
                        echo form_open('budget/purchase_request_c/print_report_budget_usage', 'class="form-horizontal"');
                        ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Fiscal</th>
                                    <th>No Purchase Request</th>
                                    <th>Month</th>
                                    <th>Section</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 != 1) {
                                        echo "<tr class='gradeX danger'>";
                                    } else if ($isi->INT_APPROVE1 == 1 && $isi->INT_APPROVE2 == 1) {
                                        echo "<tr class='gradeX warning'>";
                                    } else if ($isi->INT_APPROVE2 == 1 && $isi->INT_APPROVE1 == 1) {
                                        echo "<tr class='gradeX success'>";
                                    }
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_FISCAL_YEAR</td>";
                                    echo "<td>$isi->INT_NO_PUREQ</td>";
                                    echo "<td>$isi->INT_MONTH_REAL</td>";
                                    echo "<td>$isi->CHR_SECTION</td>";
                                    $total = number_format($isi->DEC_TOTAL, 0, '', '.');
                                    echo "<td>Rp $total</td>";
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid-header">                        
                        <div class="pull-left">
                            <div class="form-group">
                                <div class="btn-group">
                                    <input name="INT_ID_FISCAL_YEAR" value="<?php echo $new_fiscal ?>" type="hidden">
                                    <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Print this fiscal"><i class="fa fa-print"></i> Print</button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
</aside>