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

        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/message_display_prod_c') ?>">Manage Message Display</a></li>
            <li><a href="<?php echo base_url('index.php/display_prod/message_display_prod_c/create_message') ?>"><strong>Create Message Display</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('display_prod/message_display_prod_c/save_message', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>RECOVERY PROD.</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group" >
                            <!--<label class="col-sm-3 control-label" >TIME TARGET</label>-->
                            <div class="col-sm-2">
                                <input name="CHR_TARGET_SOLVE" class="form-control" autocomplete="off"  onkeyup="angka(this);" required type="hidden" max="60" maxlength="2" value="60">
                            </div>
                            <!--Menit-->
                        </div>
                        <div class="form-group"  >
                            <label class="col-sm-3 control-label">RECOVERY</label>
                            <div class="col-sm-5">
                                <select id='recovery-primary' name="CHR_MESSAGE" style='border-color:#CCCCCC;height:30px;'>
                                    <?php
                                    foreach ($getMessage as $message) {
                                        echo'<option value="' . $message->CHR_MESSAGE . '">' . $message->CHR_MESSAGE . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label" ></label>
                            <div class="col-sm-6">
                                <!-- <input name="CHR_MESSAGE_FREE" class="form-control" autocomplete="off" type="text" max="80"> -->
                                <div class="input-group">
								<span class="input-group-addon">
									<input id='check_free' onclick='choosen_freetext()' type="checkbox" name='INT_FLG_CHECK'>
								</span>
								<input type="text" disabled id='message_free' name="CHR_MESSAGE_FREE" class="form-control" max="100" autocomplete="off">
                            </div>
                            </div>
                            
                        </div>
                                           
                                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label">WORK CENTER</label>
                            <div class="col-sm-2">
                                <select id="e1" name="CHR_WORK_CENTER" class="form-control">
                                    <?php
                                    foreach ($work_center_all as $wc) {
                                        echo'<option value="' . $wc->CHR_WORK_CENTER . '">' . $wc->CHR_WORK_CENTER . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label">SHIFT</label>
                            <div class="col-sm-5">
                                <label><input type="radio" name="CHR_SHIFT" id="SHIFT1" class="icheck" checked value="SHIFT1"> Shift 1</label> &nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="CHR_SHIFT" id="SHIFT2" class="icheck" value="SHIFT2"> Shift 2</label> &nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="CHR_SHIFT" id="SHIFT3" class="icheck" value="SHIFT3"> Shift 3</label> &nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="CHR_SHIFT" id="SHIFT4" class="icheck" value="SHIFT4"> Non-Shift</label>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('display_prod/message_display_prod_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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

<script>
function choosen_freetext() {
    var checkBox = document.getElementById("check_free");
    var text = document.getElementById("recovery-primary");
    var free_message = document.getElementById("message_free");
    if (checkBox.checked == true){
        text.disabled = true;
       text.style.background = 'whitesmoke';
       free_message.disabled = false;
    } else {
       text.disabled = false;
        text.style.background = 'white';
        free_message.disabled = true;
    }
}
</script>