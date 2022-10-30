<script>
$(document).ready(function () {
$(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
});
</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Stock Transfer System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/return_material_c/'); ?>">Stock Transfer Execution</a></li>
            <li><a href=""><strong>Stock Transfer</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="grid">
                    <div class="grid-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">SELAMAT DATANG SILAHKAN PILIH LOKASI BARANG YANG AKAN ANDA KEMBALIKAN</div>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="row">
                            <div class="col-sm-12" style="width:75%; float: center">
                                <form method="post" action="<?= base_url() ?>index.php/pes/return_material_c/pilihLoc/">
                                <div class="col-sm-2" style="width:auto">
                                    <label>From Location :</label>
                                </div>
                                <div class="col-sm-2">
                                    <select style="width:100px" id="pilih" name="pilih" class="pilih">
                                        <option value=""></option>
                                        <option value="WP01" <?php if($pilihX == "WP01") echo "selected"?>>WP01</option>
                                        <option value="PP01" <?php if($pilihX == "PP01") echo "selected"?>>PP01</option>
                                        <option value="PP02" <?php if($pilihX == "PP02") echo "selected"?>>PP02</option>
                                        <option value="PP03" <?php if($pilihX == "PP03") echo "selected"?>>PP03</option>
                                        <option value="PP04" <?php if($pilihX == "PP04") echo "selected"?>>PP04</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" id="ok" name="ok" value="OK" class="btn" style="width:80px;height:30px;background-color:#66ccff;font-color:#000000;font-weight:bold" onclick="return validateForm()">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</aside>
<script>
function validateForm() {
            var status=false;
            var pilih = document.getElementById('pilih').value;
            
            if(pilih==""){
                alert("Silahkan pilih lokasi");
                status = false;
            }
            else{
              status=true;
            }
                
            return status;

}
</script>