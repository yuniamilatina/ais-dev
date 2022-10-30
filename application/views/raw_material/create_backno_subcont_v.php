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
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
    function upperCaseF(a){
        setTimeout(function(){
            a.value = a.value.toUpperCase();
        }, 1);
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/backno_subcont_c/') ?>">Manage Back No Subcont</a></li>
            <li> <a href="<?php echo base_url('index.php/raw_material/backno_subcont_c/create_backno_subcont') ?>"><strong>Create Back No Subcont</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('raw_material/backno_subcont_c/save_backno_subcont', 'class="form-horizontal"');
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>CREATE</strong> BACK NO SUBCONT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Back No Subcont</label>
                            <div class="col-sm-6">
                                <input name="CHR_BACKNO" class="form-control" maxlength="40" required type="text" onkeydown="upperCaseF(this)">
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label">Problem Type</label>
                            <div class="col-sm-8">
                                <select autofocus name="INT_ID_PROBLEM_TYPE" class="form-control" style="width:250px">
                                    <?php
                                    foreach ($data_problem_type as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->INT_ID_PROBLEM_TYPE; ?>"><?php echo $isi->CHR_PROBLEM_TYPE_DESC; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('raw_material/backno_subcont_c', 'Cancel', 'class="btn btn-default"');
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