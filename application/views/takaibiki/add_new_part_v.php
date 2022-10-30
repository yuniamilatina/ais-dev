
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

</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/takaibiki/takaibiki_c') ?>">MANAGE PART TAKAIBIKI</a></li>
            <li> <a href="#"><strong>ADD NEW PART</strong></a></li>
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
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">ADD NEW PART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                        echo form_open_multipart('takaibiki/takaibiki_c/save_new_part', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group" id="group_1">
                        <label class="col-sm-3 control-label">Back No</label>
                        <div class="col-sm-2">
                            <select name="CHR_BACK_NO" id="e1" class="form-control" onchange="getPartName(value);">
                                <?php foreach ($all_back_no as $isi) { ?>
                                    <option value="<?php echo $isi->CHR_BACK_NO; ?>"><?php echo $isi->CHR_BACK_NO; ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                    </div>
                            
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Part Name</label>
                        <div class="col-sm-2">
                            <input name="CHR_PART_NAME" readonly id="part_name" class='form-control' type="text" style="width: 300px;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">PIS Image</label>
                        <div class="col-sm-4">
                            <input name="CHR_IMG_FILE_NAME" id="upload" type="file" required> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <?php
                        echo anchor('takaibiki/takaibiki_c/', 'Cancel', 'class="btn btn-default"');
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

function getPartName(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('takaibiki/takaibiki_c/get_part_name'); ?>",
            data: "back_no=" + value,
            success: function(data) {
                $("#part_name").val(data);
            }
        });
    }

</script>