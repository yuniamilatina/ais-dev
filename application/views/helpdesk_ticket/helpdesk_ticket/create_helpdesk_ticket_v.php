<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
</script>

<script language="JavaScript">
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = Number(c);
    }

    function Number(s) {
//        while (s.substr(0, 1) == '0' && s.length > 1) {
//            s = s.substr(1, 9999);
//        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }

</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/') ?>">Manage Helpdesk Ticket</a></li>
            <li> <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/create_helpdesk_ticket') ?>"><strong>Create Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open_multipart('helpdesk_ticket/helpdesk_ticket_c/save_helpdesk_ticket', 'class="form-horizontal"');
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>CREATE HELPDESK TICKET</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Title</label>
                            <div class="col-sm-6">
                                <input name="CHR_PROBLEM_TITLE" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>

                        <?php $session = $this->session->all_userdata(); ?>
                        <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 38 || $session['ROLE'] == 7) { ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">NPK / Username </label>
                                <div class="col-sm-5">
                                    <select  name="CHR_NPK" id="e2" class="form-control" required >
                                        <option value="">--- CHOOSE NPK / USERNAME  ---</option>
                                        <?php foreach ($data_user as $list) { ?>
                                            <option value="<?php echo $list->CHR_NPK; ?>"><?php echo $list->CHR_NPK . ' - ' . trim($list->CHR_USERNAME); ?></option>
                                        <?php }
                                        ?> 
                                    </select>
                                </div>
                            </div>
<!--                            <div class="form-group">
                                <label class="col-sm-3 control-label">NPK</label>
                                <div class="col-sm-5">
                                    <input name="CHR_NPK" autocomplete="off" onkeyup="angka(this);" class="form-control" maxlength="6" required type="text" style="width: 80px;text-transform: uppercase;">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Priority</label>
                                <div class="col-sm-8">
                                    <select name="INT_PRIORITY" class="form-control" style="width:250px">
                                        <option selected value="3">Normal</option>
                                        <option value="2">Important</option>
                                        <option value="1">Urgent</option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Image Problem (Additional)</label>
                            <div class="col-sm-4">
                                <input name="CHR_IMAGE_URL" id="upload" type="file"> 
                            </div>
                        </div>

                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Due Date</label>
                            <div class="col-sm-3">
                                <div class="input-group" >
                                    <input name="CHR_DUE_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo $date; ?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Type</label>
                            <div class="col-sm-9">
                                <select autofocus name="INT_ID_PROBLEM_TYPE" class="form-control" style="width:350px">
                                    <?php
                                    foreach ($data_problem_type as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_PROBLEM_TYPE; ?>"><?php echo $isi->CHR_PROBLEM_TYPE_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Assets/Software</label>
                            <div class="col-sm-8">
                                <input name="CHR_ASSET_NAME" class="form-control" maxlength="40" required type="text" style="width:350px" > 
                                <strong>Contoh Asset :</strong> Komputer, Printer, Laptop, Scanner, Dan lain lain 
                                <br>
                                <strong>Contoh Software :</strong> AORTA, AIS, ELISA, In Line Scan, Dan lain lain
                            </div>
                        </div>
                        <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 38 || $session['ROLE'] == 7) { ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Problem Solver</label>
                                <div class="col-sm-8">
                                    <select name="INT_ID_PROVER" class="form-control" style="width:250px">
                                        <?php
                                        foreach ($data_prover as $isi) {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_PROVER; ?>"><?php echo $isi->CHR_PROVER_DESC; ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Description</label>
                            <div class="col-sm-6">
                                <textarea name="CHR_PROBLEM_DESC" rows="5" cols="500" class="form-control" placeholder="Please detail your issue" maxlength="500"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
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


<script type="text/javascript" language="javascript">
            $("#upload").fileinput({
                'showUpload': false
            });
</script>