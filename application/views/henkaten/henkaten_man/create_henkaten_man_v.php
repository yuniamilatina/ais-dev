
<script src="<?php echo base_url('assets/datetimepicker/jquery.timepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/jquery.timepicker.css'); ?>" >
<script src="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/lib/bootstrap-datepicker.css'); ?>" >

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/henkaten/henkaten_man_c/') ?>">Manage Henkaten MP</a></li>
            <li><a href="#"><strong>Create Henkaten MP</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>CREATE HENKATEN MP</strong> ( Absensi - Pindah Line )</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('henkaten/henkaten_man_c/save_henkaten_man', 'class="form-horizontal"'); ?>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">NPK - USERNAME</label>
                                <div class="col-sm-4">
                                    <select name="CHR_NPK" id="e1" class="form-control">
                                        <?php foreach ($all_user as $isi) { ?>
                                            <option value="<?php echo $isi->NPK.'-'.$isi->NAMA; ?>"><?php echo $isi->NPK.' - '.$isi->NAMA; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-5">
                                    <label><input type="radio" name="INT_STATUS_ABSEN" class="icheck" checked value="0"> S.I.A</label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="INT_STATUS_ABSEN" class="icheck" value="1"> CUTI</label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="INT_STATUS_ABSEN" class="icheck" value="2"> OUT</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Process Name</label>
                                <div class="col-sm-5">
                                    <input name="CHR_PROCESS_NAME" class="form-control" required type="text" style="width: 200px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Work Center</label>
                                <div class="col-sm-2">
                                    <select name="CHR_WORK_CENTER" id="e2" class="form-control">
                                        <?php foreach ($all_work_center as $isi) { ?>
                                            <option value="<?php echo $isi->CHR_WORK_CENTER; ?>"><?php echo $isi->CHR_WORK_CENTER; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>

                            <div id="datepairExample">
                                <div  class="form-group">
                                    <label class="col-sm-3 control-label">Schedule Date</label>
                                    <div class="col-sm-3">
                                        <div class="input-group" >
                                            <input type="text" class="form-control date start" autocomplete="off" name="CHR_SCHEDULE_DATE" value='<?php echo date('d-m-Y'); ?>'>
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                        </div>
                                    </div>
<!--                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control time start" autocomplete="off" name="CHR_SCHEDULE_TIME" value='<?php echo date('H:i'); ?>'>
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>-->
                                </div>

                                <div  class="form-group" >
                                    <label class="col-sm-3 control-label">Actual Date</label>
                                    <div class="col-sm-3">
                                        <div class="input-group" >
                                            <input type="text" class="form-control date start" autocomplete="off" name="CHR_ACT_DATE" value='<?php echo date('d-m-Y'); ?>'>
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                        </div>
                                    </div>
<!--                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control time end" autocomplete="off" name="CHR_ACT_TIME" value='<?php echo date('H:i'); ?>'>
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>-->
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                        <?php
                                        echo anchor('henkaten/henkaten_man_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                        echo form_close();  
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</aside>

<script>
    $('#datepairExample .time').timepicker({
        'showDuration': true,
        'timeFormat': 'G:i'
    });

    $('#datepairExample .date').datepicker({
        'format': 'dd-mm-yyyy',
        'autoclose': true
    });

    $('#datepairExample').datepair();
</script>

<script>
    function getPartName(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('henkaten/henkaten_man_c/get_part_name'); ?>",
            data: "back_no=" + value,
            success: function(data) {
                $("#part_name").val(data);
            }
        });
    }

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