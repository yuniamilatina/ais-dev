
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/calysta/outhouse_c/create_part_outhouse') ?>">Data Outhouse</a></li>
            <li> <a href="#"><strong>CREATE DATA OUTHOUSE</strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE DATA OUTHOUSE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('calysta/outhouse_c/save_device', 'class="form-horizontal"');
                    ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item</label>
                                <div class="col-sm-4">
                                    <input name="CHR_ITEM" class="form-control"  type="text">
                                </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                                <div class="col-sm-4">
                                    <select  name="CHR_TM_NUMBER" id="e1" class="form-control"  value="<?= $tmn; ?>">
                                    <option value=""></option>
                                        <option value="01">Project Desain</option>
                                        <option value="02">Deis MTE</option>
                                        <option value="03">Engineering</option>
                                        <option value="04">Quality</option>
                                        <option value="05">Produksi</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Name</label>
                                <div class="col-sm-4">
                                    <input name="CHR_PART_NAME" class="form-control" type="text" required>
                                </div>
                            </div>  
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Model</label>
                                <div class="col-sm-4">
                                    <input name="CHR_MODEL" class="form-control" type="text" required>
                                </div>
                            </div>  
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mat</label>
                                <div class="col-sm-4">
                                    <input name="CHR_MAT" class="form-control" type="text" required>
                                </div>
                            </div>  
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Supplier</label>
                            <div class="col-sm-4">
                                <!-- <select  name="CHR_SUPPLIER" id="e2" onchange="get_data_part_cust();" class="form-control">
                                    <option value="OUTHOUSE">Outhouse</option>
                                </select> -->
                                <input name="CHR_SUPPLIER" class="form-control" type="text" required>
                            </div>
                        </div> 
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Qty</label>
                                <div class="col-sm-4">
                                    <input name="INT_QTY" class="form-control" required type="number" required>
                                </div>
                        </div>  
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Dimensi</label>
                                <div class="col-sm-4">
                                    <input name="CHR_DIMENSI" class="form-control" required type="text" required>
                                </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Dimensi :</strong></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Panjang x Lebar x Tinggi</label>
                                <div class="col-sm-1">
                                    <input name="CHR_DIM1" class="form-control" onclick="klik()" type="checkbox" id="dim" value="X">
                                </div>
                                <div class="col-sm-1">
                                    <input name="CHR_DIMENSI_P" style="display:none" class="form-control" type="number" placeholder="P" id="dimensi1">
                                </div>
                                <div class="col-sm-1">
                                    <input name="CHR_DIMENSI_L" style="display:none" class="form-control" type="number" placeholder="L" id="dimensi2" >
                                </div>
                                <div class="col-sm-1">
                                    <input name="CHR_DIMENSI_T" style="display:none" class="form-control"  type="number" placeholder="T" id="dimensi3" >
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Diameter x Tinggi</label>
                                <div class="col-sm-1">
                                    <input name="CHR_DIM2" class="form-control" onclick="klik()" type="checkbox" id="dim1" value="X">
                                </div>
                                <div class="col-sm-1">
                                    <input name="CHR_DIMENSI_D" style="display:none" class="form-control" type="number" placeholder="D" id="dimensi4">
                                </div>
                                <div class="col-sm-1">
                                    <input name="CHR_DIMENSI_Td" style="display:none" class="form-control" type="number" placeholder="T" id="dimensi5" >
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Proses :</strong></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">RM</label>
                                <div class="col-sm-1">
                                    <input name="CHR_RM" class="form-control" id="rm" onclick="klik()"  type="checkbox" required>
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_RM" class="form-control" id="raw" oninput="compare()" style="display:none" type="date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">DELIVERY</label>
                                <div class="col-sm-1">
                                    <input name="CHR_HT" class="form-control" id="delive" onclick="klik()"  type="checkbox" required>
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_HT" class="form-control" id="delivery" oninput="compare()" style="display:none" type="date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">RECEIVING</label>
                                <div class="col-sm-1">
                                    <input name="CHR_SG" id="receive" class="form-control" onclick="klik()" type="checkbox" required>
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_SG" id="receiving" class="form-control" oninput="compare()" style="display:none" type="date" required>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">FINISHING</label>
                                <div class="col-sm-1">
                                    <input name="CHR_FINISH" id="finish" class="form-control" type="checkbox" onclick="klik()" type="date" required>
                                </div>
                             <div class="col-sm-3">
                                <input name="CHR_PROG_FIN" id="finishing" class="form-control" type="date"  style="display:none" oninput="compare()" type="date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Upload Drawing</label>
                            <div class="col-sm-4">
                                <input name="CHR_IMG_DWG" id="upload" type="file" /> 
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                        <?php echo anchor('calysta/outhouse_c', 'Cancel', 'class="btn btn-default"'); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div> 
                </div>
            </div>           
        </div>
        </div>
        <script>
            function klik() {
                var rm = document.getElementById("rm");
                    var raw = document.getElementById("raw");
                var delive = document.getElementById("delive");
                    var delivery = document.getElementById("delivery");
                var receive = document.getElementById("receive");
                    var receiving = document.getElementById("receiving");
                var finish = document.getElementById("finish");
                    var finishing = document.getElementById("finishing");
                var dim = document.getElementById("dim");
                    var dimensi1 = document.getElementById("dimensi1");
                    var dimensi2 = document.getElementById('dimensi2');
                    var dimensi3 = document.getElementById('dimensi3');
                var dim1 = document.getElementById("dim1");
                    var dimensi4 = document.getElementById('dimensi4');
                    var dimensi5 = document.getElementById('dimensi5');  

                if (finish.checked == true){
                    finishing.style.display = "block";
                } 
                    else {
                    finishing.style.display = "none";
                    }
                if (receive.checked == true){
                    receiving.style.display = "block";
                } 
                    else {
                    receiving.style.display = "none";
                    }
                if (delive.checked == true){
                    delivery.style.display = "block";
                }
                    else {
                    delivery.style.display = "none";
                    }
                if (rm.checked == true){
                    raw.style.display = "block";
                }
                    else {
                    raw.style.display = "none";
                    } 
                    if (dim.checked == true){
                    dimensi1.style.display = "block";
                    dimensi2.style.display = "block";
                    dimensi3.style.display = "block";
                }
                    else {
                    dimensi1.style.display = "none";
                    dimensi2.style.display = "none";
                    dimensi3.style.display = "none";
                    document.getElementById("dimensi1").value = '';
                    document.getElementById("dimensi2").value = '';
                    document.getElementById("dimensi3").value = '';
                }
                
                if (dim1.checked == true){
                    dimensi4.style.display = "block";
                    dimensi5.style.display = "block";
                }
                    else {
                    dimensi4.style.display = "none";
                    dimensi5.style.display = "none";
                    document.getElementById("dimensi4").value = '';
                    document.getElementById("dimensi5").value = '';
                }
            }

            function compare() {
                var raw = document.getElementById("raw").value;
                var delivery = document.getElementById("delivery").value;
                var date_raw = new Date(raw);
                var date_delivery = new Date(delivery);
                
                
                if (date_delivery < date_raw){
                    alert("Tanggal Target Tidak Valid" );
                    document.getElementById("raw").valuereset("raw");
                }
                
            }
        </script>
        <script type="text/javascript" language="javascript">
            $("#upload").fileinput({
                'showUpload': false
            });
</script>
    </section>
</aside>


