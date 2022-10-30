<script>
    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
// ajaxorder
        $("#idorder").change(function () {
            var pno = $("#idorder").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPartd',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                        }
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPartd2',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Supplier Tidak Ditemukan");
                        }
                    }
                });
            }
            ;
        });

        $("#supplierid1").focusin(function () {
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pname1").val(data);
                }
            });
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupplier',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#supplierid1").html(data);
                }
            });

        });
        $("#backno1").focusin(function () {
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno3',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#backno1").val(data);
                }
            });
        });
        $("#supplierid1").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSupplierName",
                data: {supplierid1: $('#supplierid1').val()}, type: 'POST',
                success: function (data) {
                    $("#sname1").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/stor',
                data: {idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#stor1").html(data);
                }
            });
        });

        $("#cek").click(function () {
            var bno = $("#backno1").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno1',
                    data: {backno1: $('#backno1').val(), idorder: $('#idorder').val()},
                    success: function (data) {
                        var len = data.length;
                        if (len == 8) {
                            alert("Back no dapat digunakan");
                        }
                        else if (len == 7) {
                            alert("Back No sudah digunakan!!! Silahkan pilih Back No. lain");
                        }
                        else {
                            alert("Back no dapat digunakan");

                        }
                    }
                });
            }

        });

// end ajax order

//ajax proses 
        $("#idproses").change(function () {
            var pno = $("#idproses").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPartpro',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");

                        }
                    }
                });
            }
            ;
        });
        $("#prodver").focusin(function () {
            var partno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPartName',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#pnameproses").val(data);
                }
            });

            var partno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#prodver").html(data);
                }
            });


            var partno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorSelf',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#storself").html(data);
                }
            });
        });
        $("#backno").focusin(function () {
            var partno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno1',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#backno").val(data);
                }
            });
        });
        $("#prodver").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro",
                data: {prodver: $('#prodver').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#selfpro").val(data);
                }
            });

            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getNextPro",
                data: {prodver: $('#prodver').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#nextpro").html(data);
                }
            });

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorNext',
                data: {prodver: $('#prodver').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#stornext").val(data);
                }
            });

        });

        $("#cek1").click(function () {
            var bno = $("#backno").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno2',
                    data: {backno: $('#backno').val(), idproses: $('#idproses').val()},
                    success: function (data) {
                        var len = data.length;
                        if (len == 8) {
                            alert("Back no dapat digunakan");
                        }
                        else if (len == 7) {
                            alert("Back No sudah digunakan!!! Silahkan pilih Back No. lain");
                        }
                        else {
                            alert("Back no dapat digunakan");

                        }
                    }
                });
            }

        });
// end ajax proses

// begin ajax supplyparts
        $("#idsupply").change(function () {
            var pno = $("#idsupply").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPartd',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                        }
                    }
                });
            }
            ;
        });

        $("#supplierid3").focusin(function () {
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pname3").val(data);
                }
            });
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupplier1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#supplierid3").html(data);
                }
            });
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/Stor3',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#stor3").html(data);
                }
            });

        });
        $("#backno3").focusin(function () {
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno3',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#backno3").val(data);
                }
            });
        });
        $("#supplierid3").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSupplierName3",
                data: {supplierid3: $('#supplierid3').val()}, type: 'POST',
                success: function (data) {
                    $("#sname3").val(data);
                }
            });
        });

        $("#cek2").click(function () {
            var bno = $("#backno3").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno3',
                    data: {backno3: $('#backno3').val(), idsupply: $('#idsupply').val()},
                    success: function (data) {
                        var len = data.length;
                        if (len == 8) {
                            alert("Back no dapat digunakan");
                        }
                        else if (len == 7) {
                            alert("Back No sudah digunakan!!! Silahkan pilih Back No. lain");
                        }
                        else {
                            alert("Back no dapat digunakan");

                        }
                    }
                });
            }

        });
// end ajax supplyparts

// begin ajax pickup
        $("#idpickup").change(function () {
            var pno = $("#idpickup").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPartpro',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");

                        }
                    }
                });
            }
            ;
        });
        $("#prodver4").focusin(function () {
            var partno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPartName',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#pnamepickup").val(data);
                }
            });
            var partno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#prodver4").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorSelf1',
                data: {idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#storself4").html(data);
                        }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBoxtypePick',
                data: {idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#boxtype4").html(data);
                        }
            });

        });
        $("#backno4").focusin(function () {
            var partno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno1',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#backno4").val(data);
                }
            });
        });
        $("#prodver4").focusout(function () {
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorNext4d1',
                data: {prodver4: $('#prodver4').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#stornext4").val(data);
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro4",
                data: {prodver4: $('#prodver4').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#selfpro4").val(data);
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getNextpro4d",
                data: {selfpro: $('#selfpro4').val()}, type: 'POST',
                success: function (data) {
                    $("#nextpro4").html(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getQtypick',
                data: {idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    if (data != false) {
                        $("#qtyperpack4").val(data);
                        $("#qtyperpack4").attr("readonly", false);
                    } else if (data == false) {
                        $("#qtyperpack4").attr("readonly", false);
                    }

                }
            });

        });
        $("#cek3").click(function () {
            var bno = $("#backno4").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno4',
                    data: {backno4: $('#backno4').val(), idpickup: $('#idpickup').val()},
                    success: function (data) {
                        var len = data.length;
                        if (len == 8) {
                            alert("Back no dapat digunakan");
                        }
                        else if (len == 7) {
                            alert("Back No sudah digunakan!!! Silahkan pilih Back No. lain");
                        }
                        else {
                            alert("Back no dapat digunakan");

                        }
                    }
                });
            }

        });

// end ajax pickup

// begin ajax pickup passthrough
        $("#idpickupp").change(function () {
            var pno = $("#idpickupp").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPartd',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");

                        }
                    }
                });
            }
            ;
        });
        $("#storself4p").focusin(function () {
            var partno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPartName',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#pnamepickupp").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorself4d',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                        success: function (data) {
                            $("#storself4p").html(data);
                        }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorNext4d',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                success: function (data) {
                    $("#stornext4p").html(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getQtypass',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                success: function (data) {
                    var len = data.length;
                    if (len != 2) {
                        $("#qtyperpack4p").val(data);
                        $("#qtyperpack4p").attr("readonly", true);
                    } else if (len == 2) {
                        $("#qtyperpack4p").attr("readonly", false);
                    }


                }
            });
        });
        $("#backno4p").focusin(function () {
            var partno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno1',
                data: 'partno=' + partno,
                success: function (data) {
                    $("#backno4p").val(data);
                }
            });
        });
        $("#cek3p").click(function () {
            var bno = $("#backno4p").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno4',
                    data: {backno4: $('#backno4p').val(), idpickup: $('#idpickupp').val()},
                    success: function (data) {
                        var len = data.length;
                        if (len == 8) {
                            alert("Back no dapat digunakan");
                        }
                        else if (len == 7) {
                            alert("Back No sudah digunakan!!! Silahkan pilih Back No. lain");
                        }
                        else {
                            alert("Back no dapat digunakan");

                        }
                    }
                });
            }

        });

// end ajax pickup passthrough

        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

// store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

// on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#myTab a[href="' + hash + '"]').tab('show');
    });
// end document ready

    $(document).ready(function () {
// autocomplete
        $('#idorder').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/search'); ?>",
            minLength: 1,
        });
        $('#idsupply').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/search'); ?>",
            minLength: 1,
        });
        $('#idproses').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchpartno'); ?>",
            minLength: 1,
        });
        $('#idpickup').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchpartno'); ?>",
            minLength: 1,
        });
        $('#idpickupp').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/search'); ?>",
            minLength: 1,
        });
    }); //end document ready

</script>
<style type="text/css">
    label{
        color:#000000;
    }
    input{
        color:#000000;
        //font-weight: bold;
    }
    button{
        color:#000000;
        //font-weight: bold;
    }
    li{
        color:#000000;
        //font-weight: bold;
    }
    select{
        color:#000000;
        //font-weight: bold;
    }
</style>


<aside class="right-side">

    <section class="content-header" >
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Kanban Master System</strong></a></li>
        </ol>
    </section>


    <section class="content" >
        <div class="row" >
            <div class="col-md-12 text-center" >
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-barcode"></i>
                        <span class="grid-title"><strong>DATA BARU KANBAN</strong></span>
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
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active" ><a href="#order_v">Order</a></li>
                            <li><a href="#proses_v">Proses</a></li>
                            <li><a href="#supplyparts_v">Supply Parts</a></li>
                            <li><a href="#pickup_v">Pick Up</a></li>
                            <li><a href="#pickupp_v">Pick Up Passthrough</a></li>
                        </ul>
                        <!-- begin tab content -->
                        <div class="tab-content" style="margin-top: 20px" >
                            <!-- begin tab order -->
                            <div id="order_v" class="tab-pane fade in active" >
                                <!-- baris ke 1 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="color:black;margin-left: 3px;margin-top:5px;">Plant</label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:17px;">
                                        <label style="margin-top:5px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:0px;">
                                        <select class="form-control" style="width:200px">
                                            <option>600</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end row 1  -->

                                <!-- baris ke 2-->
                                <div class="row" style="margin-bottom:15px;">
                                    <form  id="form" name="form" method="post" action="" >
                                    <div class= "col-sm-3" style="width:auto;margin-left:0px;"> 
                                        <label style="margin-bottom:5px;height: 30px">No. Part</label><br>
                                        <label style="margin-bottom:10px;height: 30px">Back No</label><br>
                                        <label style="margin-bottom:15px;">Supplier</label><br>
                                        <label style="margin-bottom:10px;">Storage</label><br>
                                        <label style="margin-top:5px;">Qty/Pack</label>
                                    </div>
                                    <div class= "col-sm-3" style="width:1px;margin-left:0px;">
                                        <label style="height: 30px">:</label><br>
                                        <label style="height: 30px;margin-bottom:10px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                    </div>
                                    <div class= "col-sm-3" style="margin-left:0px;width:auto" >
                                            <div class="form-group" style="margin-bottom:0px">
                                                <input class="form-control" id ="idorder" name="idorder" maxlength="18" style="height:30px;width:200px;" autofocus="autofocus" >
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input  type="text" maxlength = "5" name="backno1" id="backno1"  style="box-shadow: none;height:30px;width:150px;" >
                                                <button class="btn btn-primary" type="button" id="cek" name="cek" style=";width:48px;border: none;">Cek</button>
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="supplierid1" id="supplierid1" style="height:30px;width:200px;margin-bottom:5px;">
                                                    <option></option>
                                                </select>

                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="stor1" id="stor1" style="height:30px;width:200px;margin-bottom:5px;">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input type="number" class="form-control" id="qtyperbox1" name="qtyperbox1" style="height:30px;" min="1" max="100000">
                                            </div>
                                    </div>
                                   <div class= "col-sm-3" style="width:auto;margin-left:0px;"> 
                                        <label style="margin-bottom:5px;height: 30px;width: 90px;text-align: -webkit-left;">Part Name</label><br>
                                        <label style="margin-bottom:10px;height: 30px;width: 90px;text-align: -webkit-left;">Supplier Name</label><br>
                                        <label style="margin-bottom:15px;width: 90px;text-align: -webkit-left;">Jenis Box</label><br>
                                        <label style="margin-bottom:10px;width: 90px;text-align: -webkit-left;">Side</label><br>
                                        <label style="margin-top:5px;width: 90px;text-align: -webkit-left;">Keterangan</label><br>
                                    </div>
                                    <div class= "col-sm-3" style="width:1px;margin-left:0px;">
                                        <label style="height: 30px">:</label><br>
                                        <label style="height: 30px;margin-bottom:10px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                    </div>
                                    <div class="col-sm-3" >
                                        <div class="form-group" style="margin-bottom:5px">
                                            <input class="form-control" type="text" name="pname1" id="pname1" style="width:200px;height:30px;" readonly="readonly">
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <input class="form-control" type="text" name="sname1" id="sname1" value="" style="height:30px;width:200px;" readonly="readonly">
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select class="form-control" id ="boxtype1" name="boxtype1" style="height:30px;width:200px;margin-bottom:5px" >
                                                <option  value=""></option> 
                                                <?php foreach ($boxtype as $showproses): ?>
                                                    <option  value="<?php echo $showproses->CHR_BOX_TYPE; ?>"><?php echo ucfirst($showproses->CHR_BOX_TYPE); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select name="side1" class="form-control" id="side1" style="width:200px;height:30px">
                                                <option value=""></option>
                                                <option value="RH">RH</option>
                                                <option value="LH">LH</option>
                                                <option value="LH/RH">LH/RH</option>
                                            </select>
                                            
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <input type ="textarea" id="keterangan" class="form-control" name = "keterangan" style="width: 200px;height:30px">
                                        </div>
                                    </div>
                                </div>

                                <!-- end row 2 -->

                                <!-- baris ke 3 -->
                                <!-- <div class="row" style="margin-bottom:10px;">
                                    <div class="col-sm-3" style="width:auto;margin-left:20px">
                                        <label>Qty/Pack</label>
                                        <input type="number" id="qtyperbox1" name="qtyperbox1" style"height:25px;" min="1" max="100000">
                                    </div>
                                    <div class="col-sm-1" style="width:auto;text-align:left">
                                        <label>Jenis Box</label>
                                    </div>  
                                    <div class="col-sm-2" style="width:auto" >
                                        
                                    </div>
                                    <div class="col-sm-4" style="width:auto">
                                        <label>Keterangan </label>
                                        <input type ="textarea" id="keterangan" name = "keterangan">
                                    </div>
                                </div><br> -->
                                <!-- end row 3 -->

                                <!-- baris ke 4 -->
                                <div class="row" style="margin-top:30px;margin-bottom:10px;">
                                    <div class="col-sm-2">
                                        <button  id="order" name="order" value="1" class="btn btn-primary" style="width:100px;height:30px;border: none;" onclick="return validateFormOrd()"><i class="icon-ok icon-white" ></i>SAVE</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="<?= base_url() ?>index.php/pes/kanban_master/databaru" class="btn btn-default" style="width:100px;height:30px;">CANCEL</a>
                                    </div>
                                </div>
                                </form>
                                <!-- end row 4 -->
                                <!-- end all row -->
                            </div>
                            <!-- end tab order -->

                            <!-- begin tab proses -->
                            <div id="proses_v" class="tab-pane fade">
                                <!-- baris ke 1 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="width:138px;margin-left:0px;text-align: left;">
                                        <label style="color:black;margin-top:5px;">Plant</label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:18px;">
                                        <label style="margin-top:5px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:2px;">
                                        <select class="form-control" style="width:200px">
                                            <option>600</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end row 1 -->
                                <!-- baris ke 2-->
                                <div class="row"  style="margin-bottom:10px;">
                                    <form  method="post" action="" >
                                    <div class= "col-sm-3" style="margin-left:0px;width:155px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">No. Part</label><br>
                                        <label style="height: 30px;">Back No</label><br>
                                        <label style=";height: 30px;">Production version</label><br>
                                        <label style=";height: 30px;">Self Process</label><br>
                                        <label style=";height: 30px;">Storage(Self Process)</label><br>
                                        <label style=";height: 30px;">Next Process</label><br>
                                        
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="height: 30px;margin-top:7px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                        
                                            <input class="form-control" maxlength="18" id ="idproses" name="idproses" style="height:30px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input  type="text" maxlength="5" name="backno" id="backno" style="box-shadow: none;height:30px;width:150px;" >
                                                <button class="btn-primary" type="button" id="cek1" name="cek1" style="border: none;height:30px;width:48px;">Cek</button>
                                            </div>
                                            <select class="form-control" id ="prodver" name="prodver" style="height:30px;margin-bottom:5px" >
                                                <option></option>
                                            </select>
                                            <input type="text" name="selfpro" id="selfpro" class="form-control" style="height:30px;width:200px;margin-bottom:5px;" readonly="readonly" >
                                            <select class="form-control" id ="storself" name="storself" style="height:30px;margin-bottom:5px" >
                                                <option ></option>
                                            </select>
                                            <select class="form-control" id ="nextpro" name="nextpro" style="height:30px;margin-bottom:5px" >
                                            </select>
                                            
                                    </div>
                                    <div class= "col-sm-3" style="margin-left:0px;width:155px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">Part Name</label><br>
                                        <label style="height: 30px;">Storage(Next Process)</label><br>
                                        <label style=";height: 30px;">Qty/Pack</label><br>
                                        <label style=";height: 30px;">Jenis Box</label><br>
                                        <label style=";height: 30px;">Keterangan</label><br>
                                        <label style=";height: 30px;">Side</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="height: 30px;margin-top:7px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;" >
                                        <input type="text" name="pnameproses" class="form-control" id="pnameproses" value="" style="width:200px;height:30px;margin-bottom:5px" readonly="readonly">
                                        <input type="text" name="stornext" class="form-control" id="stornext" style="height:30px;width:200px;margin-bottom:5px;" readonly="readonly">
                                        <input class="form-control" type="number" name="qtyperpack" id="qtyperpack" class="form-control"  min="1" max="100000" style="height:30px;width:200px;margin-bottom:5px">
                                        <select class="form-control" id ="boxtype" name="boxtype" style="height:30px;width:200px;margin-bottom:5px" >
                                            <option  value=""></option> 
                                            <?php foreach ($boxtype as $showproses): ?>
                                                <option  value="<?php echo $showproses->CHR_BOX_TYPE; ?>"><?php echo ucfirst($showproses->CHR_BOX_TYPE); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input class="form-control" type ="textarea" id="keterangan" name = "keterangan" style="height:30px;width:200px;margin-bottom:5px">
                                        <div class="form-group">
                                            <select class="form-control" name="side" id="side" style="height:30px;width:200px;">
                                                <option value=""></option>
                                                <option value="RH">RH</option>
                                                <option value="LH">LH</option>
                                                <option value="LH/RH">LH/RH</option>
                                            </select>
                                        </div>
                                    </div>
                                        

                                    <!-- baris ke 4 -->

                                    <div class="row" >
                                        <div class="col-sm-3" style="margin-top: 20px;">
                                            <button class="btn btn-primary" id="proses" name="proses" value="2" style="width:100px;height:30px;font-weight: bold;border: none;" onclick="return validateFormProc()"><i class="icon-ok icon-white" ></i>SAVE</button>
                                        </div>
                                        <div class="col-sm-2" style="margin-top: 20px;">
                                            <a href="<?= base_url() ?>index.php/pes/kanban_master/databaru" class="btn btn-default" style="width:100px;height:30px;font-weight: bold;" >Cancel</a>
                                        </div>
                                    </div>
                                    </form>
                                    <!-- end row 4 -->
                                </div>
                            </div>
                                <!-- end tab proses -->

                            <!-- begin tab supplyparts -->
                            <div id="supplyparts_v" class="tab-pane fade" >
                                <form  id="form" name="form" method="post" action="" >
                                    <!-- baris ke 1 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="color:black;margin-left: 3px;margin-top:5px;">Plant</label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:17px;">
                                        <label style="margin-top:5px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:0px;">
                                        <select class="form-control" style="width:200px">
                                            <option>600</option>
                                        </select>
                                    </div>
                                </div>
                                        <!-- end row 1  -->
                                <!-- baris ke 2-->
                                <div class="row" style="margin-bottom:15px;">
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                       <label style="margin-bottom:5px;height: 30px">No. Part</label><br>
                                        <label style="margin-bottom:10px;height: 30px">Back No</label><br>
                                        <label style="margin-bottom:15px;">Supplier</label><br>
                                        <label style="margin-bottom:10px;">Storage</label><br>
                                        <label style="margin-top:5px;">Qty/Pack</label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                        <label style="height: 30px">:</label><br>
                                        <label style="height: 30px;margin-bottom:10px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                        <div class="form-group" style="margin-bottom:0px">
                                            <input class="form-control" maxlength="18" id ="idsupply" name="idsupply" style="height:30px;width:200px;" autofocus="autofocus" >
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <input type="text" maxlength = "5" name="backno3" id="backno3"  style="height:30px;width:150px;">
                                            <button type="button" class="btn btn-primary" id="cek2" name="cek2" style="height:30px;width:50px;border: none">Cek</button>
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select class="form-control" name="supplierid3" id="supplierid3" style="height:30px;width:200px;margin-bottom:5px;">
                                                <option></option>
                                            </select> 
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select class="form-control" name="stor3" id="stor3" style="height:30px;width:200px;margin-bottom:5px;">
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" name="qtyperbox3" id="qtyperbox3" style="height:30px;width:200px;" min="1" max="100000"><br>
                                    </div>
                                    <div class= "col-sm-3" style="width:auto;margin-left:0px;"> 
                                        <label style="margin-bottom:5px;height: 30px;width: 90px;text-align: -webkit-left;">Part Name</label><br>
                                        <label style="margin-bottom:10px;height: 30px;width: 90px;text-align: -webkit-left;">Supplier Name</label><br>
                                        <label style="margin-bottom:15px;width: 90px;text-align: -webkit-left;">Jenis Box</label><br>
                                        <label style="margin-bottom:10px;width: 90px;text-align: -webkit-left;">Side</label><br>
                                        <label style="margin-top:5px;width: 90px;text-align: -webkit-left;">Keterangan</label><br>
                                    </div>
                                    <div class= "col-sm-3" style="width:1px;margin-left:0px;">
                                        <label style="height: 30px">:</label><br>
                                        <label style="height: 30px;margin-bottom:10px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                    </div>
                                    <div class="col-sm-3" style="margin-left:5px;">
                                        <div class="form-group" style="margin-bottom:0px">
                                            <input class="form-control" type="text" name="pname3" id="pname3" value="" style="width:200px;height:30px;margin-bottom:5px;" readonly="readonly">
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <input type="text" class="form-control" name="sname3" id="sname3" value="" style="width:200px;height:30px;margin-bottom:5px;" readonly="readonly">
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select class="form-control" id ="boxtype3" name="boxtype3" style="height:30px;width:200px;margin-bottom:5px" >
                                                <option  value=""></option> 
                                                <?php foreach ($boxtype as $showproses): ?>
                                                    <option  value="<?php echo $showproses->CHR_BOX_TYPE; ?>"><?php echo ucfirst($showproses->CHR_BOX_TYPE); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select name="side3" class="form-control" id="side3" style="height:30px;width:200px;margin-bottom:5px;">
                                                <option value=""></option>
                                                <option value="RH">RH</option>
                                                <option value="LH">LH</option>
                                                <option value="LH/RH">LH/RH</option>
                                            </select>
                                        </div>
                                        <input class="form-control" type ="textarea" id="keterangan" name = "keterangan" style="height:30px;width:200px;">
                                    </div>
                                </div>

                                    <!-- baris ke 4 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary" id="supplyparts" name="supplyparts" value="3" style="width:100px;height:30px;font-weight: bold;border: none;" onclick="return validateFormSupp()"><i class="icon-ok icon-white" ></i>SAVE</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="<?= base_url() ?>index.php/pes/kanban_master/databaru" class="btn btn-default" style="width:100px;height:30px;font-weight: bold;" >Cancel</a>
                                    </div>
                                </div>
                                </form>
                            </div>
                                <!-- end tab supplyparts -->

                            <!-- begin tab pickup -->
                            <div id="pickup_v" class="tab-pane fade">
                                <form  id="form" name="form" method="post" action="" >
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="width:138px;margin-left:0px;text-align: left;">
                                        <label style="color:black;margin-top:5px;">Plant</label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:18px;">
                                        <label style="margin-top:5px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:2px;">
                                        <select class="form-control" style="width:200px">
                                            <option>600</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end row 1 -->
                                <!-- baris ke 2-->
                                <div class="row"  style="margin-bottom:10px;">
                                    <div class= "col-sm-3" style="margin-left:0px;width:155px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">No. Part</label><br>
                                        <label style="height: 30px;">Back No</label><br>
                                        <label style=";height: 30px;">Production version</label><br>
                                        <label style=";height: 30px;">Self Process</label><br>
                                        <label style=";height: 30px;">Storage(Self Process)</label><br>
                                        <label style=";height: 30px;">Next Process</label><br>

                                        <!-- <label style="margin-bottom:10px;">Storage(Next Process)</label><br> -->
                                       
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="height: 30px;margin-top:7px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                            <input class="form-control" maxlength="18" id ="idpickup" name="idpickup" style="height:30px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input type="text" maxlength = "5" name="backno4" id="backno4" style="box-shadow: none;height:30px;width:150px;"> 
                                                <button type="button" class="btn btn-primary" id="cek3" name="cek3" style="border: none;height:30px;width:48px;">Cek</button>
                                            </div>
                                            <select class="form-control" id ="prodver4" name="prodver4" style="height:30px;margin-bottom:5px;width:200px;" >
                                                <option></option>
                                            </select> 
                                            <input type="text" name="selfpro4" id="selfpro4"  class="form-control" style="height:30px;width:200px;margin-bottom:5px;" readonly="readonly">
                                            <select class="form-control" id ="storself4" name="storself4" style="height:30px;margin-bottom:5px;width:200px;" >
                                                <option ></option>
                                            </select>
                                            <select class="form-control" id ="nextpro4" name="nextpro4" style="height:30px;margin-bottom:5px;width:200px;" >
                                                <option></option>
                                            </select>
                                    </div>
                                    <div class= "col-sm-3" style="margin-left:0px;width:155px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">Part Name</label><br>
                                        <label style="height: 30px;">Storage(Next Process)</label><br>
                                        <label style=";height: 30px;">Qty/Pack</label><br>
                                        <label style=";height: 30px;">Jenis Box</label><br>
                                        <label style=";height: 30px;">Keterangan</label><br>
                                        <label style=";height: 30px;">Side</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="height: 30px;margin-top:7px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;" >
                                        <input type="text" name="pnamepickup" class="form-control" id="pnamepickup" value="" style="width:200px;height:30px;margin-bottom:5px" readonly="readonly">
                                        <input type="text" name="stornext4" class="form-control" id="stornext4" style="height:30px;width:200px;margin-bottom:5px;" readonly="readonly">
                                        <input class="form-control" type="number" name="qtyperpack4" id="qtyperpack4" class="form-control"  min="1" max="100000" style="height:30px;width:200px;margin-bottom:5px">
                                        <select class="form-control" id ="boxtype4" name="boxtype4" style="height:30px;width:200px;margin-bottom:5px" >
                                            <option  value=""></option> 
                                            <?php foreach ($boxtype as $showproses): ?>
                                                <option  value="<?php echo $showproses->CHR_BOX_TYPE; ?>"><?php echo ucfirst($showproses->CHR_BOX_TYPE); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input class="form-control" type ="textarea" id="keterangan" name = "keterangan" style="height:30px;width:200px;margin-bottom:5px">
                                        <div class="form-group">
                                            <select class="form-control" name="side4" id="side4" style="height:30px;width:200px;">
                                                <option value=""></option>
                                                <option value="RH">RH</option>
                                                <option value="LH">LH</option>
                                                <option value="LH/RH">LH/RH</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <!-- end row 1 -->

                                        <!-- baris ke 4 -->
                                <div class="row" >
                                    <div class="col-sm-2" style="margin-top:20px;">
                                        <button class="btn btn-primary" id="pickup" name="pickup" value="4" style="width:100px;height:30px;font-weight: bold;border: none;" onclick="return validateFormPick()"><i class="icon-ok icon-white" ></i>SAVE</button>
                                    </div>
                                    <div class="col-sm-2" style="margin-top:20px;">
                                        <a href="<?= base_url() ?>index.php/pes/kanban_master/databaru" class="btn btn-default" style=";width:100px;height:30px;font-weight: bold;" >Cancel</a>
                                    </div>
                                </div>
                                </form>
                                    <!-- end row 4 -->
                            </div>
                                    <!-- end tab pickup -->

                            <!-- begin tab pickup passthrough -->
                            <div id="pickupp_v" class="tab-pane fade">
                                <form  id="form" name="form" method="post" action="">
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="width:138px;margin-left:0px;text-align: left;">
                                        <label style="color:black;margin-top:5px;">Plant</label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:23px;">
                                        <label style="margin-top:5px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:2px;">
                                        <select class="form-control" style="width:200px">
                                            <option>600</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end row 1 -->
                                <!-- baris ke 2-->
                                <div class="row"  style="margin-bottom:20px;">
                                    <div class= "col-sm-3" style="margin-left:0px;width:160px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">No. Part</label><br>
                                        <label style="height: 30px;">Back No</label><br>
                                        <label style=";height: 30px;">Storage Location From</label><br>
                                        <label style=";height: 30px;">Storage Location To</label><br>
                                        <label style=";height: 30px;">Qty/Pack</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="height: 30px;margin-top:7px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                        <input class="form-control" maxlength="18" id ="idpickupp" name="idpickupp" style="height:30px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                        <input type="text" maxlength = "5" name="backno4p" id="backno4p"  style="height:30px;width:150px;margin-bottom:5px"> 
                                        <button class="btn btn-primary" type="button" id="cek3p" name="cek3p" style="border: none;height:30px;width:48px;">Cek</button><br>
                                        <select class="form-control" id ="storself4p" name="storself4p" style="height:30px;margin-bottom:5px" >
                                            <option ></option>
                                        </select>
                                        <select class="form-control" name="stornext4p" id="stornext4p" style="height:30px;margin-bottom:5px" >
                                            <option></option>
                                        </select>
                                        <input class="form-control" type="text" name="qtyperpack4p" id="qtyperpack4p" style="height:30px;width:200px" onkeypress="validate(event)">
                                    </div>
                                    <div class= "col-sm-3" style="margin-left:0px;width:160px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">Part Name</label><br>
                                        <label style="height: 30px;">Jenis Box</label><br>
                                        <label style=";height: 30px;">Side</label><br>
                                        <label style=";height: 30px;">Keterangan</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="height: 30px;margin-top:7px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                        <label style="height: 30px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;" >
                                        <input type="text" class="form-control" name="pnamepickupp" id="pnamepickupp" value="" style="width:200px;height:30px;margin-bottom:5px;" readonly="readonly">
                                        <select class="form-control" id ="boxtype4p" name="boxtype4p" style="height:30px;width:200px;margin-bottom:5px" >
                                            <option  value=""></option> 
                                            <?php foreach ($boxtype as $showproses): ?>
                                                <option  value="<?php echo $showproses->CHR_BOX_TYPE; ?>"><?php echo ucfirst($showproses->CHR_BOX_TYPE); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <select class="form-control" name="side4p" id="side4p" style="height:30px;width:200px;margin-bottom:5px;">
                                            <option value=""></option>
                                            <option value="RH">RH</option>
                                            <option value="LH">LH</option>
                                            <option value="LH/RH">LH/RH</option>
                                        </select>
                                        <input type ="textarea" class="form-control" style="height:30px;width:200px;margin-bottom:5px;" id="keterangan" name = "keterangan">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class="col-sm-2" style="margin-top: 20px">
                                        <button class="btn btn-primary" id="pickupp" name="pickupp" value="5" style="width:100px;height:30px;font-weight: bold;border: none;" onclick="return validateFormPass()"><i class="icon-ok icon-white"></i>SAVE</button>
                                    </div>
                                    <div class="col-sm-2" style="margin-top: 20px">
                                        <a href="<?= base_url() ?>index.php/pes/kanban_master/databaru" class="btn btn-default" style=";width:100px;height:30px;font-weight: bold;" >Cancel</a>
                                    </div>
                                </div>
                                        </form>
                                        <!-- end row 4 -->
                                    </div>
                                    <!-- end tab pickup -->

                                </div>
                                <!-- end tab content -->

                            </div>
                            <!-- end grid body -->
                        </div>
                        <!-- end grid class  -->
                    </div>  
                </div>
                </section>
                </aside>

                <script>
                    function validateFormPass() {
                        var status = false;
                        var partno = document.getElementById('idpickupp').value;
                        var backno = document.getElementById('backno4p').value;
                        var slocfrom = document.getElementById('storself4p').value;
                        var slocto = document.getElementById('stornext4p').value;
                        var qtyperpack = document.getElementById('qtyperpack4p').value;
                        var boxtype = document.getElementById('boxtype4p').value;

                        if (partno == "" || backno == "" || slocfrom == "" || slocto == "" || qtyperpack == "" || boxtype == "") {
                            alert("Silahkan lengkapi data yang masih kosong");
                            status = false;

                        } else {
                            var r = confirm("Simpan data kanban ?");
                            if (r == true) {
                                status = true;
                            } else {
                                status = false
                            }

                        }

                        return status;

                    }

                    function validateFormPick() {
                        var status = false;
                        var partno = document.getElementById('idpickup').value;
                        var backno = document.getElementById('backno4').value;
                        var qtyperpack = document.getElementById('qtyperpack4').value;
                        var boxtype = document.getElementById('boxtype4').value;

                        if (partno == "" || backno == "" || qtyperpack == "" || boxtype == "") {
                            alert("Silahkan lengkapi data yang masih kosong");
                            status = false;

                        } else {
                            var r = confirm("Simpan data kanban ?");
                            if (r == true) {
                                status = true;
                            } else {
                                status = false
                            }

                        }

                        return status;

                    }

                    function validateFormSupp() {
                        var status = false;
                        var partno = document.getElementById('idsupply').value;
                        var backno = document.getElementById('backno3').value;
                        var sid = document.getElementById('supplierid3').value;
                        var storage = document.getElementById('stor3').value;
                        var qtyperpack = document.getElementById('qtyperbox3').value;
                        var boxtype = document.getElementById('boxtype3').value;

                        if (partno == "" || backno == "" || sid == "" || storage == "" || qtyperpack == "" || boxtype == "") {
                            alert("Silahkan lengkapi data yang masih kosong");
                            status = false;

                        } else {
                            var r = confirm("Simpan data kanban ?");
                            if (r == true) {
                                status = true;
                            } else {
                                status = false
                            }

                        }

                        return status;

                    }

                    function validateFormProc() {
                        var status = false;
                        var partno = document.getElementById('idproses').value;
                        var backno = document.getElementById('backno').value;
                        var qtyperpack = document.getElementById('qtyperpack').value;
                        var boxtype = document.getElementById('boxtype').value;

                        if (partno == "" || backno == "" || qtyperpack == "" || boxtype == "") {
                            alert("Silahkan lengkapi data yang masih kosong");
                            status = false;

                        } else {
                            var r = confirm("Simpan data kanban ?");
                            if (r == true) {
                                status = true;
                            } else {
                                status = false
                            }

                        }

                        return status;

                    }

                    function validateFormOrd() {
                        var status = false;
                        var partno = document.getElementById('idorder').value;
                        var backno = document.getElementById('backno1').value;
                        var sid = document.getElementById('supplierid1').value;
                        var storage = document.getElementById('stor1').value;
                        var qtyperpack = document.getElementById('qtyperbox1').value;
                        var boxtype = document.getElementById('boxtype1').value;

                        if (partno == "" || backno == "" || sid == "" || storage == "" || qtyperpack == "" || boxtype == "") {
                            alert("Silahkan lengkapi data yang masih kosong");
                            status = false;

                        } else {
                            var r = confirm("Simpan data kanban ?");
                            if (r == true) {
                                status = true;
                            } else {
                                status = false
                            }

                        }

                        return status;

                    }

                    function validate(evt) {
                        if (evt.keyCode != 8) {
                            var theEvent = evt || window.event;
                            var key = theEvent.keyCode || theEvent.which;
                            key = String.fromCharCode(key);
                            var regex = /[0-9]|\./;

                            if (!regex.test(key)) {
                                theEvent.returnValue = false;
                                if (theEvent.preventDefault)
                                    theEvent.preventDefault();
                            }
                        }
                    }
                </script>
