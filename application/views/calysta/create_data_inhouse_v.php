
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/calysta/inhouse_c/create_part_inhouse') ?>">Data Inhouse</a></li>
            <li> <a href="#"><strong>Create Data Inhouse</strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE DATA INHOUSE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('calysta/inhouse_c/save_device', 'class="form-horizontal"');
                    ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Project Name</label>
                                <div class="col-sm-4">
                                    <input name="CHR_PROJECT_NAME" class="form-control"  type="text">
                                </div>
                        </div> 
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
                            <label class="col-sm-3 control-label">Qty</label>
                            <div class="col-sm-4">
                            <input name="INT_QTY" class="form-control" required type="number" required>
                            </div>
                        </div>
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
                            <label class="col-sm-3 control-label">Weight</label>
                                <div class="col-sm-1">
                                    <input name="CHR_WEIGHT" class="form-control" type="number">
                                </div>
                                <label class=" control-label">Kg</label>
                            </div>
                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Proses :</strong></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">RM</label>
                                <div class="col-sm-1">
                                    <input name="CHR_RM" class="form-control" id="rm" onclick="klik()" type="checkbox">
                                </div>
                                <div class="col-sm-3">
                                    <input name="CHR_PROG_RM" class="form-control" id="raw" style="display:none" type="date" dateFormat="dd-mm-yyyy">
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">MC1</label>
                                <div class="col-sm-1">
                                    <input name="CHR_MC1" id="mc1" class="form-control" onclick="klik()" type="checkbox">
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_MC1" class="form-control" oninput="compare()" id="mac1" style="display:none"  type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">HT</label>
                                <div class="col-sm-1">
                                    <input name="CHR_HT" class="form-control" id="ht" onclick="klik()"  type="checkbox">
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_HT" class="form-control" oninput="compare()" id="htr"  style="display:none" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">SG</label>
                                <div class="col-sm-1">
                                    <input name="CHR_SG" id="sg" class="form-control" onclick="klik()" type="checkbox">
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_SG" id="sgr" oninput="compare()" class="form-control" style="display:none" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">WC</label>
                                <div class="col-sm-1">
                                    <input name="CHR_WC" id="wc"class="form-control" onclick="klik()" type="checkbox">
                                </div>
                            <div class="col-sm-3">
                                <input name="CHR_PROG_WC" id="wcut" oninput="compare()" class="form-control" style="display:none" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">MC2</label>
                                <div class="col-sm-1">
                                    <input id="mc2"  name="CHR_MC2"  id="mc2" class="form-control"  onclick="klik()" type="checkbox">
                                </div>
                             <div class="col-sm-3">
                                <input name="CHR_PROG_MC2" id="mac2" oninput="compare()" class="form-control" type="date" style="display:none">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">QC</label>
                                <div class="col-sm-1">
                                    <input name="CHR_QC" id="qc" class="form-control" onclick="klik()" type="checkbox" required>
                                </div>
                             <div class="col-sm-3">
                                <input name="CHR_PROG_QC" id="qcon" oninput="compare()" class="form-control" type="date" style="display:none"  required>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">FINISHING</label>
                                <div class="col-sm-1">
                                    <input name="CHR_FINISH" id="finish" class="form-control" type="checkbox" onclick="klik()" required>
                                </div>
                             <div class="col-sm-3">
                                <input name="CHR_PROG_FIN" id="cek" oninput="compare()" class="form-control" type="date"  style="display:none" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Upload Drawing</label>
                            <div class="col-sm-4">
                                <input name="CHR_IMG_DWG" id="upload" type="file" required> 
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                        <?php echo anchor('calysta/inhouse_c', 'Cancel', 'class="btn btn-default"'); ?>
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
                var mc1 = document.getElementById("mc1");
                    var mac1 = document.getElementById("mac1");
                var ht = document.getElementById("ht");
                    var htr = document.getElementById("htr");
                var sg = document.getElementById("sg");
                    var sgr = document.getElementById("sgr");
                var wc = document.getElementById("wc");
                    var wcut = document.getElementById("wcut");
                var qc = document.getElementById("qc");
                    var qcon = document.getElementById("qcon");
                var mc2 = document.getElementById("mc2");
                    var mac2 = document.getElementById("mac2");
                var finish = document.getElementById("finish");
                    var cek = document.getElementById("cek");
                var dim = document.getElementById("dim");
                    var dimensi1 = document.getElementById("dimensi1");
                    var dimensi2 = document.getElementById('dimensi2');
                    var dimensi3 = document.getElementById('dimensi3');
                var dim1 = document.getElementById("dim1");
                    var dimensi4 = document.getElementById('dimensi4');
                    var dimensi5 = document.getElementById('dimensi5');   

                if (finish.checked == true){
                    cek.style.display = "block";
                }
                    else {
                    cek.style.display = "none";
                    document.getElementById("cek").value = '';
                }
                    if (mc2.checked == true){
                    mac2.style.display = "block";
                }
                    else {
                    mac2.style.display = "none";
                    document.getElementById("mac2").value = '';
                }
                    if (qc.checked == true){
                    qcon.style.display = "block";
                }
                    else {
                    qcon.style.display = "none";
                    document.getElementById("qcon").value = '';
                }
                    if (wc.checked == true){
                    wcut.style.display = "block";
                }
                    else {
                    wcut.style.display = "none";
                    document.getElementById("wcut").value = '';
                }
                    if (sg.checked == true){
                    sgr.style.display = "block";
                }
                    else {
                    sgr.style.display = "none";
                    document.getElementById("sgr").value = '';
                }
                    if (ht.checked == true){
                    htr.style.display = "block";
                }
                    else {
                    htr.style.display = "none";
                    document.getElementById("htr").value = '';
                }
                    if (mc1.checked == true){
                    mac1.style.display = "block";
                }
                    else {
                    mac1.style.display = "none";
                    document.getElementById("mac1").value = '';
                }
                    if (rm.checked == true){
                    raw.style.display = "block";
                }
                    else {
                    raw.style.display = "none";
                    document.getElementById("raw").value = '';
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
                var mac1 = document.getElementById("mac1").value;
                var htr = document.getElementById("htr").value;
                var sgr = document.getElementById("sgr").value;
                var wcut = document.getElementById("wcut").value;
                var mac2 = document.getElementById("mac2").value;
                var qcon = document.getElementById("qcon").value;
                var cek = document.getElementById("cek").value;
                var date_raw = new Date(raw);
                var date_mac1 = new Date(mac1);
                var date_htr = new Date(htr);
                var date_sgr = new Date(sgr);
                var date_wcut = new Date(wcut);
                var date_mac2 = new Date(mac2);
                var date_qcon = new Date(qcon);
                var date_cek = new Date(cek);
                
                if (date_mac1 < date_raw ){
                    alert("Tanggal Planing Tidak Valid" );
                   document.getElementById("mac1").value = '';
                }
                if (date_htr < date_mac1 || date_htr < date_raw){
                    alert("Tanggal Planing Tidak Valid" );
                    document.getElementById("htr").value = '';
                }
                if (date_sgr < date_htr || date_sgr < date_mac1 || date_sgr < date_raw){
                    alert("Tanggal Planing Tidak Valid" );
                    document.getElementById("sgr").value = '';
                }
                if (date_wcut < date_sgr || date_wcut < date_htr || date_wcut < date_mac1 || date_wcut < date_raw){
                    alert("Tanggal Planing Tidak Valid" );
                    document.getElementById("wcut").value = '';
                }
                if (date_mac2 < date_wcut || date_mac2 < date_sgr || date_mac2 < date_htr || date_mac2 < date_mac1 || date_mac2 < date_raw){
                    alert("Tanggal Planing Tidak Valid" );
                    document.getElementById("mac2").value = '';
                }
                if (date_qcon < date_mac2 || date_qcon < date_wcut || date_qcon < date_sgr || date_qcon < date_htr || date_qcon < date_mac1 || date_qcon < date_raw){
                    alert("Tanggal Planing Tidak Valid" );
                    document.getElementById("qcon").value = '';
                }
                if (date_cek < date_qcon || date_cek < date_mac2 || date_cek < date_wcut || date_cek < date_sgr || date_cek < date_htr || date_cek < date_raw){
                    alert("Tanggal Planing Tidak Valid" );
                    document.getElementById("cek").value = '';
                }
                
            }
        </script>
    
        <script type="text/javascript" language="javascript">
            $("#upload").fileinput({
                'showUpload': false
            });
</script>
<!--
   <script type="text/javascript">
       $(function() {
           
               $("#raw").datepicker({ dateFormat: "dd/mm/yy" }).val()
                 $("#mac1").datepicker({ dateFormat: "dd/mm/yy" }).val()
           $('#raw').datepicker();
                 $('#mac1').datepicker();
                var raw = $('#raw').val();
                var mac1 =$('#mac1').val();
                var date_raw = new Date(raw);
                var date_mac1 = new Date(mac1);
                if (date_mac1 < date_raw ){
                    alert("Tanggal Planing Tidak Valid" );
                   document.getElementById("mac1").value = '';
                }
       });

   </script>  
-->
   
    </section>
</aside>


