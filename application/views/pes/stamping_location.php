</script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Stock Transfer System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/return_stamping_c/'); ?>">Stock Transfer Execution</a></li>
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
                                <form method="post" action="<?= base_url() ?>index.php/pes/return_stamping_c/pilihLoc/">
                                <div class="col-sm-2" style="width:auto">
                                    <label>From Location :</label>
                                </div>
                                <div class="col-sm-2">
                                    <select style="width:100px" id="pilih" name="pilih" class="pilih">
                                        <option value=""></option>
                                        <option value="ST01" <?php if($pilihX == "ST01") echo "selected"?>>ST01</option>
                                        <option value="WP01" <?php if($pilihX == "WP01") echo "selected"?>>WP01</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" id="ok" name="ok" value="OK" class="btn" style="width:80px;height:30px">
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