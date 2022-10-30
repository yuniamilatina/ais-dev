<?php
session_start();
?>
<script>
    $(document).ready(function () {
// ajaxorder
        $("#jnsbox").change(function () {
            var pno = $("#jnsbox").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekBox',
                data: 'pno=' + pno,
                success: function (data) {

                    data = data.substring(0, 11);
                    var len = data.length;
                    if (len != 11) {
                        alert("Boxtype yang sama sudah ada");
                    }
                }
            });
        });
    });//end document ready
</script>
<aside class="right-side" >

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>">Home</a></li>
            <li><a href=""><strong>BOX TYPE</strong></a></li>
        </ol>
    </section>
    <section class="content" >
        <div class="row">
            <div class="col-md-12 text-center" >
                <div class="grid" >
                    <div class="grid-header">
                        <i class="fa fa-barcode"></i>
                        <span class="grid-title"><strong>MASTER BOX TYPE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="clearfix"></div>
                        <?php if ($this->session->flashdata('message') <> ''): ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
                            <br/>
                        <?php endif; ?>
                    </div>
                    <div class="grid-body">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-2 col-sm-offset-0 box">
                                <a href="<?= base_url() ?>index.php/pes/kanban_master/mj_box" class="btn"><span class="glyphicon glyphicon-search"></span>View</a>
                            </div>
                        </div>
                        <div class="row">
                            <form class="form-inline" method="post" action="">
                                <div class="form-group">
                                    <label>Jenis Box</label>
                                    <input type="text" name="jnsbox" id="jnsbox" maxlength="4" style="height:30px;width:50px;margin-right:30px" autofocus="autofocus">
                                </div>
                                <div class="form-group">
                                    <label>Panjang</label>
                                    <input type="number" name="panjang" id="panjang" style="height:30px;width:50px;margin-right:30px">
                                </div>
                                <div class="form-group">
                                    <label>Lebar</label>
                                    <input type="number" name="lebar" id="lebar" style="height:30px;width:50px;margin-right:30px">
                                </div>
                                <div class="form-group">
                                    <label>Tinggi</label>
                                    <input type="number" name="tinggi" id="tinggi" style="height:30px;width:50px;margin-right:30px">
                                </div><br><br><br>
                                <div class="form-group">
                                    <label>Penjelasan</label>
                                    <input type="text" name="exp" id="exp" style="height:30px;width:500px;margin-right:30px">
                                </div><br><br><br>
                                <div class="form-group">
                                    <button class="btn" name="simpan" id="simpan" value="1" style="color:#000000;margin-right:10px;background-color:#66ccff;" onclick="return validateForm()">SAVE</button>
                                    <input type="reset" class="btn" value="CANCEL" style="color:#000000;background-color:#66ccff;margin-right:400px">
                                    <a href="<?= base_url() ?>index.php/basis/home_c" class="btn" style="color:#000000;background-color:#66ccff;width:100px" >Close</a>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- end grid body -->
                </div>
                <!-- end grid class  -->
            </div>  
        </div>
    </section>
</aside>
<script>
    function validateForm() {
        var status = false;
        var jnsbox = document.getElementById('jnsbox').value;
        var panjang = document.getElementById('panjang').value;
        var lebar = document.getElementById('lebar').value;
        var tinggi = document.getElementById('tinggi').value;

        if (jnsbox == "" || panjang == "" || lebar == "" || tinggi == "") {
            alert("Silahkan lengkapi data");
            status = false;
        } else {
            status = true;
        }
        return status;
    }


</script>

