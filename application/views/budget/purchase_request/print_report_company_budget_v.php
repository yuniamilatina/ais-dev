<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Report Company Budget</strong></a></li>
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
                        <span class="grid-title"><strong>REPORT</strong> COMPANY BUDGET</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('budget/purchase_request_c/print_report_company_budget', 'class="form-horizontal"'); ?>

                            <select name="INT_ID_FISCAL_YEAR" id="fiscal" class="ddl">
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

                            <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Print"><i class="fa fa-print"></i> Print</button>
                                <?php echo form_close(); ?>

                        </div>


                    </div>

                </div>
            </div>


        </div>
    </section>
</aside>






