<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/'); ?>"><span>Manage Helpdesk Ticket</span></a></li>
            <li><a href=""><strong>Edit Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('helpdesk_ticket/helpdesk_ticket_c/update_helpdesk_ticket_by_staff', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT HELPDESK TICKET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="INT_ID_TICKET" class="form-control" required type="hidden" value="<?php echo $data->INT_ID_TICKET; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Title</label>
                            <div class="col-sm-4">
                                <input name="CHR_PROBLEM_TITLE" class="form-control" value="<?php echo trim($data->CHR_PROBLEM_TITLE) ?>" maxlength="30" required type="text">
                            </div>
                        </div>
                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Due Date</label>
                            <div class="col-sm-3">
                                <div class="input-group" >
                                    <input name="CHR_DUE_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo date("d-m-Y", strtotime($data->CHR_DUE_DATE)); ?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Type</label>
                            <div class="col-sm-4">
                                <select name="INT_ID_PROBLEM_TYPE" class="form-control">
                                    <?php
                                    foreach ($data_problem_type as $isi) {
                                        if ($data->INT_ID_PROBLEM_TYPE == $isi->INT_ID_PROBLEM_TYPE) {
                                            ?>
                                            <option selected value="<?php echo $isi->INT_ID_PROBLEM_TYPE; ?>"><?php echo $isi->CHR_PROBLEM_TYPE_DESC; ?></option>
                                            <?php
                                        } else {
                                            ?><option value="<?php echo $isi->INT_ID_PROBLEM_TYPE; ?>"><?php echo $isi->CHR_PROBLEM_TYPE_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Assets/Software</label>
                            <div class="col-sm-5">
                                <input name="CHR_ASSET_NAME" value="<?php echo trim($data->CHR_ASSET_NAME) ?>" class="form-control" maxlength="20" required type="text" style="width:250px">
                                <strong>Contoh Asset :</strong> Komputer, Printer, Laptop, Scanner, Dan lain lain 
                                <br>
                                <strong>Contoh Software :</strong> AORTA, AIS, ELISA, In Line Scan, Dan lain lain
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_PROBLEM_DESC" class="form-control" value="<?php echo trim($data->CHR_PROBLEM_DESC) ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('helpdesk_ticket/helpdesk_ticket_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>