<script>
    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
// ajax order
        $("#idorder").change(function () {
            var pno = $("#idorder").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPart11',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                            $("#idorder").attr("readonly", false);
                        }
                    }
                });
            }
            ;
        });
        $("#sud").focusin(function () {
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pn").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupporder',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#sud").html(data);
                }
            });
            $("#idorder").attr("readonly", true);
        });
        $("#bn").focusin(function () {
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#bn").val(data);
                }
            });
        });
// end change function
        $("#sud").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppNameuor",
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#sn").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStor2',
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            $("#stor").html(data);
                        }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qpbu',
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#qpb").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/btu',
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#bt").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/sideu',
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            $("#side").html(data);
                        }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan2',
                data: {sid: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#keterangan2").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerialu',
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            $("#ls").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagor',
                data: {sud: $('#sud').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            document.getElementById('div_activate_or').style.display = 'block';
                            if (data == false) {
                                //alert("Data telah dihapus");
                                document.getElementById('activecontrolor').style.background= '#80ff80';   
                                document.getElementById('activecontrolor').innerHTML ='ACTIVATE';
                            }
                        }
            });
            
        });

        $("#cek").click(function () {
            var bno = $("#bn").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno1',
                    data: {backno1: $('#bn').val(), idorder: $('#idorder').val()},
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
// // end ajax order

// ajax proses
// begin change function
        $("#idproses").change(function () {
            var pno = $("#idproses").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPart12',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                            $("#idproses").attr("readonly", false);
                        }
                    }
                });
            }
            ;
        });
        $("#pv1").focusin(function () {
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    ;
                    $("#pn1").val(data);
                }
            });
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pv1").html(data);
                }
            });


            $("#idproses").attr("readonly", true);
        });
        $("#bn1").focusin(function () {
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#bn1").val(data);
                    ;
                }
            });
        });
// end change function
// begin focusout function
        $("#pv1").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfprou",
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#sp1").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNext1u',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()},
                success: function (data) {
                    $("#sn1").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf1',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()},
                success: function (data) {
                    $("#ss1").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextpro1',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()},
                success: function (data) {
                    $("#np1").html(data);
                    ;
                }
            });

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxu',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#qpb1").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxTypeu',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#bt1").html(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/sideu1',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#side1").html(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerialu1',
                data: {pv1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#ls1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan1',
                data: {prodver1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#keterangan1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpr',
                data: {prodver1: $('#pv1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            document.getElementById('div_activate_pr').style.display = 'block';
                            if (data == false) {
                                //alert("Data telah dihapus");
                                document.getElementById('activecontrolpr').style.background= '#80ff80';   
                                document.getElementById('activecontrolpr').innerHTML ='ACTIVATE';
                            }
                        }
            });

        });
// endfocusoutfunction
        $("#cek1").click(function () {
            var bno = $("#bn1").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno2',
                    data: {backno: $('#bn1').val(), idproses: $('#idproses').val()},
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

// begin ajax suplyparts
        $("#idsupply").change(function () {
            var pno = $("#idsupply").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPart13',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                            $("#idsupply").attr("readonly", false);
                        }
                    }
                });
            }
            ;
        });
        $("#sud2").focusin(function () {
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pn2").val(data);
                }
            });
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSuppu',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#sud2").html(data);
                }
            });

        });
        $("#bn2").focusin(function () {
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#bn2").val(data);
                }
            });
        });
        $("#sud2").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppNameu",
                data: {sud2: $('#sud2').val()}, type: 'POST',
                success: function (data) {
                    $("#sn2").val(data);
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getStoru2",
                data: {sud2: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#stor2").html(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxu2',
                data: {sud2: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#qpb2").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/btu2',
                data: {sud2: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#bt2").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/sideu2',
                data: {sud2: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                        success: function (data) {
                            $("#side2").html(data);
                        }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan4',
                data: {sid3: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#keterangan4").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerialu2',
                data: {sud2: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                        success: function (data) {
                            $("#ls2").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagsp',
                data: {sud2: $('#sud2').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                        success: function (data) {
                             document.getElementById('div_activate_sp').style.display = 'block';
                            if (data == false) {
                                //alert("Data telah dihapus");
                                document.getElementById('activecontrolsp').style.background= '#80ff80';   
                                document.getElementById('activecontrolsp').innerHTML ='ACTIVATE';
                            }
                        }
            });
            $("#idsupply").attr("readonly", true);
        });

        $("#cek2").click(function () {
            var bno = $("#bn2").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno3',
                    data: {backno3: $('#bn2').val(), idsupply: $('#idsupply').val()},
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

// ajax pickup
// begin change function
        $("#idpickup").change(function () {
            var pno = $("#idpickup").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPart14',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                            $("#idpickup").attr("readonly", false);
                        }
                    }
                });
            }
            ;
        });
        $("#pv3").focusin(function () {
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    ;
                    $("#pn3").val(data);
                }
            });
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv5',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pv3").html(data);
                }
            });

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getQtypick',
                data: {idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#qpb3").val(data);
                }
            });
            $("#idpickup").attr("readonly", true);
        });
// end change function
        $("#bn3").focusin(function () {
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no11',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#bn3").val(data);
                    ;
                }
            });
        });
// begin focusout function
        $("#pv3").focusout(function () {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf1u',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#ss3").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNext2u',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#sn3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextpro5',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#np3").html(data);
                    ;
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfprou3",
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#sp3").val(data);
                }
            });

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxu3',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#qpb3").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxTypeu3',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#bt3").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/sideu3',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#side3").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerialu3',
                data: {pv3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#ls3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3',
                data: {prodver3: $('#pv3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#keterangan3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpu',
                data: {prodver3: $('#pv3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            document.getElementById('div_activate_pu').style.display = 'block';
                            if (data == false) {
                                //alert("Data telah dihapus");
                                document.getElementById('activecontrolpu').style.background= '#80ff80';   
                                document.getElementById('activecontrolpu').innerHTML ='ACTIVATE';
                            }
                        }
            });

        });
// endfocusoutfunction
        $("#cek3").click(function () {
            var bno = $("#bn3").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno4',
                    data: {backno4: $('#bn3').val(), idpickup: $('#idpickup').val()},
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

// ajax pickup passthrough
// begin change function
        $("#idpickupp").change(function () {
            var pno = $("#idpickupp").val();
            var pnol = pno.length;
            if (pnol > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekPart14p',
                    data: 'pno=' + pno,
                    dataType: 'json',
                    success: function (data) {
                        if (data == false) {
                            alert("Data Tidak Ditemukan");
                            $("#idpickupp").attr("readonly", false);
                        }
                    }
                });
            }
            ;
        });
        $("#sn3p").focusin(function () {
            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    ;
                    $("#pn3p").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpp',
                data: {idpickup: $('#idpickupp').val()},
                success: function (data) {
                    $("#sn3p").html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelfpp',
                data: {idpickup: $('#idpickupp').val()},
                success: function (data) {
                    $("#ss3p").val(data);
                }
            });
        });
        $("#sn3p").focusout(function () {
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getQtypass',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#sn3p').val()}, type: 'POST',
                success: function (data) {
                    $("#qpb3p").val(data);
                }
            });
            $("#idpickupp").attr("readonly", true);
        });
// end change function
        $("#bn3p").focusin(function () {
            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_nop',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#bn3p").val(data);
                    ;
                }
            });
        });
// begin focusout function
        $("#sn3p").focusout(function () {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxTypeu3pp',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#sn3p').val(), slocfrom: $('#ss3p').val()}, type: 'POST',
                        success: function (data) {
                            $("#bt3p").html(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/sideu3p',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                        success: function (data) {
                            $("#side3p").html(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3p',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                        success: function (data) {
                            $("#ls3p").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3pp',
                data: {idpickup: $('#idpickupp').val()},
                success: function (data) {
                    $("#keterangan3p").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpup',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#sn3p').val()}, type: 'POST',
                        success: function (data) {
                            document.getElementById('div_activate_up').style.display = 'block';
                            if (data == false) {
                                //alert("Data telah dihapus");
                                document.getElementById('activatecontrolpup').style.background= '#80ff80';   
                                document.getElementById('activatecontrolpup').innerHTML ='ACTIVATE';
                            }
                        }
            });

        });
// endfocusoutfunction
        $("#cek3p").click(function () {
            var bno = $("#bn3p").val();
            if (bno == '') {
                alert("Silahkan Masukkan Back No")
            } else if (bno != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_master/cekBackno4',
                    data: {backno4: $('#bn3p').val(), idpickup: $('#idpickupp').val()},
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
            source: "<?php echo site_url('pes/kanban_master/searchOldOr'); ?>",
            minLength: 1,
        });
        $('#idsupply').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldSp'); ?>",
            minLength: 1,
        });
        $('#idproses').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldPr'); ?>",
            minLength: 1,
        });
        $('#idpickup').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldPu'); ?>",
            minLength: 1,
        });
        $('#idpickupp').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldPup'); ?>",
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

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="">Kanban Master System</a></li>
        </ol>
    </section>

    <section class="content" >
        <div class="row">
            <div class="col-md-12 text-center" >
                <div class="grid">
                    <div class="grid-header" >
                        <i class="fa fa-barcode"></i>
                        <span class="grid-title"><strong>UPDATE KANBAN</strong></span>
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
                        <div class="tab-content" style="align:left;">
                            <!-- begin tab order -->
                            <div id="order_v" class="tab-pane fade in active" >
                                <!-- baris ke 1 -->
                                 <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="width:auto;margin-left:0px;">
                                        <label style="color:black;margin-left: 3px;margin-top:5px;">Plant   </label>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:20px;">
                                        <label style="margin-top:5px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:0px;">
                                        <select class="form-control" style="width:70px">
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
                                        <form  id="apalah" method="post" action="" >
                                            <div class="form-group" style="margin-bottom:0px">
                                                <input class="form-control" id ="idorder" name="idorder" style="height:30px;width:200px;" autofocus="autofocus" >
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input type="text" name="bn" id="bn" maxlength ="5" style="height:30px;width:150px;">
                                                <button class="btn btn-primary" type="button" id="cek" name="cek" style=";width:50px;border: none;">Cek</button>
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="sud" id="sud" style="height:30px;width:200px;margin-bottom:5px;">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="stor" id="stor"  style="height:30px;width:200px;margin-bottom:5px;">
                                                    <option></option>
                                                </select>
                                            </div>
                                             <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input class="form-control" type="text" name="qpb" id="qpb" style="height:30px;width:80px;" onkeypress="validate(event)">
                                            </div>  
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                        <label style="margin-bottom:5px;height: 30px;width: 90px;text-align: -webkit-left;">Part Name</label><br>
                                        <label style="margin-bottom:10px;height: 30px;width: 90px;text-align: -webkit-left;">Supplier Name</label><br>
                                        <label style="margin-bottom:15px;width: 90px;text-align: -webkit-left;">Jenis Box</label><br>
                                        <label style="margin-bottom:10px;width: 90px;text-align: -webkit-left;">Side</label><br>
                                        <label style="margin-bottom:5px;width: 90px;text-align: -webkit-left;">Keterangan</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                        <label style="height: 30px">:</label><br>
                                        <label style="height: 30px;margin-bottom:10px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group" style="margin-bottom:5px">
                                            <input class="form-control" type="text" name="pn" id="pn" value="" style="width:200px;height:30px;" readonly="readonly">
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <input class="form-control" type="text" name="sn" id="sn" value="" style="height:30px;width:200px;" readonly="readonly">
                                        </div>
                                        <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select class="form-control" name="bt" id="bt" style="width:80px;height:30px;
                                            margin-bottom:5px"">
                                                <option></option>
                                            </select>
                                        </div>
                                         <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                            <select name="side" class="form-control" id="side" style="height:30px;width:80px;">
                                                <option></option>
                                            </select>
                                         </div>
                                         <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                             <input type ="textarea" id="keterangan2" name = "keterangan2" class="form-control" style="width: 200px;height:30px">
                                         </div>
                                    </div>
                                   
                                    <!--<div class="col-sm-4" style="margin-left:30px;">
                                        <label>Side</label>  
                                        <select name="side" id="side" style="height:25px;width:70px;">
                                            <option></option>
                                        </select>
                                    </div><br>
                                    <div class="col-sm-4">
                                        <label>Keterangan</label>
                                        <input type ="textarea" id="keterangan2" name = "keterangan2" class="form-control" 
                                        style="width: 200px;height:30px">
                                    </div>-->
                                </div>
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class= "col-sm-1" style="width:1px;margin-left:0px;">
                                    </div>
                                     <div class="col-sm-2 col-sm-offset-1 box" style="border:1px solid;width:auto;padding:10px;width:auto;margin-left:0px;" >
                                        <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                             <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Last Serial No</label><br>
                                             <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Print Date</label>
                                        </div>
                                        <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                            <label >:</label><br>
                                            <label >:</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                            <div class="form-group" style="margin-bottom:5px">
                                                <input class="form-control" type="text" name="ls" id="ls" readonly="readonly"
                                                style="width:100px;height:25px;">
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input class="form-control" type="text" name="pd" id="pd" value="<? echo date("Y-m-d"); ?>"  readonly="readonly" style="width:100px;height:25px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row 3 --
                                <!-- baris ke 4 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class="col-sm-1" style="margin-right: 30px">
                                        <button class="btn btn-primary" id="updateor" name="updateor" value="#order_v" style="width:100px;height:30px;border: none;" onclick="return validateFormOrd()" >UPDATE</button>
                                    </div>
                                    <div class="col-sm-1"  id="div_activate_or" style="display: none;margin-right: 30px">
                                        <button class="btn btn-default" id="activecontrolor" name="activecontrolor" value="#order_v" style="background-color:#ff8080;width:100px;height:30px;color:#ffffff" onclick="return confirm('Ubah status Aktif pada data kanban?');" >DEACTIVATE</button>
                                    </div>
                                    <div class="col-sm-1" style="margin-right: 30px">
                                        <button class="btn btn-danger" id="deleteor" name="deleteor" value="#order_v" style="width:100px;height:30px;color:#ffffff" onclick="return confirm('Apakah Anda yakin untuk menghapus data kanban secara permanen?');" >DELETE</button>
                                    </div>
                                    <div class="col-sm-1" style="margin-right: 30px">
                                        <a href="<?= base_url() ?>index.php/pes/kanban_master/updatemenu" class="btn btn-default" style="width:100px;height:30px;color:#000000">CANCEL</a>
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
                                        <select class="form-control" style="width:70px">
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
                                        <form method="post" action="<?= base_url() ?>index.php/pes/kanban_master/updatemenu">
                                            <input class="form-control" id ="idproses" name="idproses" style="height:30px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                 <input type="text" name="bn1" id="bn1" maxlength ="5" style="height:30px;width:150px;">
                                                <button class="btn-primary" type="button" id="cek1" name="cek1" style="border: none;height:30px;width:50px;">Cek</button>
                                            </div>
                                           
                                            <select class="form-control" id ="pv1" name="pv1" style="height:30px;margin-bottom:5px;width:200px;" >
                                                <option></option>
                                            </select>
                                            <input class="form-control" type="text" name="sp1" id="sp1"  style="height:30px;width:200px;margin-bottom:5px;" readonly="readonly">
                                            <select class="form-control" name="ss1" id="ss1" style="height:30px;margin-bottom:5px;width:200px;">
                                                <option></option>
                                            </select>
                                            <select class="form-control" id ="np1" name="np1" style="height:30px;margin-bottom:5px;width:200px;" >
                                                <option></option>
                                            </select>
                                            <!--<input type="text" name="sn1" id="sn1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly">-->
                                    </div>
                                    <div class= "col-sm-3" style="margin-left:0px;width:155px;text-align:left" >
                                        <label style="margin-bottom:10px;height: 30px;">Part Name</label><br>
                                        <label style="height: 30px;">Storage(Next Process)</label><br>
                                        <label style=";height: 30px;">Qty/Pack</label><br>
                                        <label style=";height: 30px;">Jenis Box</label><br>
                                        <label style=";height: 30px;">Side</label><br>
                                        <label style=";height: 30px;">Keterangan</label><br>
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
                                        <input class="form-control" type="text" name = "pn1" id = "pn1" value ="" style="width:200px;height:30px;margin-bottom:5px;" readonly="readonly">
                                        <input class="form-control" type="text" name="sn1" id="sn1"  style="height:30px;width:200px;margin-bottom:5px" readonly="readonly">
                                         <input class="form-control" type="text" id="qpb1" name="qpb1" style="height:30px;width:80px;margin-bottom:5px" onkeypress="validate(event)">
                                        <select class="form-control" name="bt1" id="bt1" style="height:30px;width:80px;
                                        margin-bottom:5px">
                                                <option></option>  
                                        </select>
                                        <select class="form-control" name="side1" id="side1" style="height:30px;width:80px;margin-bottom:5px">
                                            <option></option>  
                                        </select>
                                        <div class="form-group">
                                            <input class="form-control" type ="textarea" id="keterangan1" name = "keterangan1"
                                            style="height:30px;width:200px">
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class= "col-sm-1" style="width:1px;margin-left:0px;">
                                    </div>
                                     <div class="col-sm-2 col-sm-offset-1 box" style="border:1px solid;width:auto;padding:10px;width:auto;margin-left:0px;" >    
                                        <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                             <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Last Serial No</label><br>
                                             <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Print Date</label>
                                        </div>
                                        <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                            <label >:</label><br>
                                            <label >:</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                            <div class="form-group" style="margin-bottom:5px">
                                                <input class="form-control" type="text" id ="ls1" name="ls1" style="width:100px;height:25px;" readonly="readonly">
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input class="form-control" type="text" name="pd1" id="pd1" value="<? echo date("Y-m-d"); ?>" readonly="readonly" style="width:100px;height:25px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <!-- end row 3 -->
                                    <!-- baris ke 4 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                        <div class="col-sm-1" style="margin-right: 30px">
                                            <button class="btn btn-primary" id="updatepr" name="updatepr" value="#proses_v" style="width:100px;height:30px;border: none;" onclick="return validateFormProc()" >UPDATE</button>
                                        </div>
                                        <div class="col-sm-1" id="div_activate_pr" style="display: none;margin-right: 30px">
                                            <button class="btn btn-default" id="activecontrolpr" name="activecontrolpr" value="#proses_v" style="background-color:#ff8080;width:100px;height:30px;color:#ffffff" onclick="return confirm('Ubah status Aktif pada data kanban??');" >DEACTIVATE</button>
                                        </div>
                                        <div class="col-sm-1" style="margin-right: 30px">
                                            <button class="btn btn-danger" id="deletepr" name="deletepr" value="#proses_v" style="width:100px;height:30px;color:#ffffff" onclick="return confirm('Hapus kanban?');" >DELETE</button>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="<?= base_url() ?>index.php/pes/kanban_master/updatemenu" class="btn btn-default" style="width:100px;height:30px;color:#000000">CANCEL</a>
                                        </div>
                                </div>
                                </form>
                                    <!-- end row 4 -->
                                </div>
                                <!-- end tab proses -->

                                <!-- begin tab supply parts -->
                                <div id="supplyparts_v" class="tab-pane fade">
                                    <!-- baris ke 1 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                        <div class="col-sm-2" style="width:auto;margin-left:0px;">
                                            <label style="color:black;margin-left: 3px;margin-top:5px;">Plant   </label>
                                        </div>
                                        <div class= "col-sm-2" style="width:1px;margin-left:20px;">
                                            <label style="margin-top:5px;">:</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="margin-left:0px;">
                                            <select class="form-control" style="width:70px">
                                                <option>600</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end row 1 -->
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
                                        <form  method="post" action="<?= base_url() ?>index.php/pes/kanban_master/updatemenu" >
                                            <div class="form-group" style="margin-bottom:0px">
                                                <input class="form-control" id ="idsupply" name="idsupply" style="height:30px;width:200px;" autofocus="autofocus" >
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input type="text" name="bn2" id="bn2" maxlength ="5" style="height:30px;width:150px;" >
                                                <button type="btn btn-primary" id="cek2" name="cek2" style="border: none;height:30px;width:50px;">Cek</button>
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="sud2" id="sud2" style="height:30px;width:200px;margin-bottom:5px;">
                                                    <option></option>
                                                </select> 
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="stor2" id="stor2" style="height:30px;width:200px;margin-bottom:5px;">
                                                    <option></option>
                                                </select> 
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input class="form-control" type="text" id="qpb2" name="qpb2" style="height:30px;width:80px;margin-bottom:5px;" onkeypress="validate(event)">
                                            </div>  

                                        </div>
                                        <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                            <label style="margin-bottom:5px;height: 30px;width: 90px;text-align: -webkit-left;">Part Name</label><br>
                                            <label style="margin-bottom:10px;height: 30px;width: 90px;text-align: -webkit-left;">Supplier Name</label><br>
                                            <label style="margin-bottom:15px;width: 90px;text-align: -webkit-left;">Jenis Box</label><br>
                                            <label style="margin-bottom:10px;width: 90px;text-align: -webkit-left;">Side</label><br>
                                            <label style="margin-bottom:5px;width: 90px;text-align: -webkit-left;">Keterangan</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                            <label style="height: 30px">:</label><br>
                                            <label style="height: 30px;margin-bottom:10px"">:</label><br>
                                            <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                            <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                            <label style="height: 30px;margin-bottom:5px"">:</label><br>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group" style="margin-bottom:5px">
                                                <input class="form-control" type="text" name="pn2" id="pn2" value="" style="width:200px;height:30px;" readonly="readonly">
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input class="form-control" type="text" name="sn2" id="sn2" value="" style="height:30px;width:200px;" readonly="readonly">
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="bt2" id="bt2" style="width:80px;height:30px;
                                                margin-bottom:5px"">
                                                    <option></option>
                                                </select>
                                            </div>
                                             <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select name="side2" class="form-control" id="side2" style="height:30px;width:80px;">
                                                    <option></option>
                                                </select>
                                             </div>
                                             <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                 <input type ="textarea" id="keterangan4" name = "keterangan4" class="form-control" style="width: 200px;height:30px">
                                             </div>
                                        </div>
                                    </div>
                                    <!-- end row 2 -->

                                    <!-- baris ke 3 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                        <div class= "col-sm-1" style="width:1px;margin-left:0px;">
                                        </div>
                                         <div class="col-sm-2 col-sm-offset-1 box" style="border:1px solid;width:auto;padding:10px;width:auto;margin-left:0px;" >    
                                            <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                                 <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Last Serial No</label><br>
                                                 <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Print Date</label>
                                            </div>
                                            <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                                <label >:</label><br>
                                                <label >:</label><br>
                                            </div>
                                            <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                                <div class="form-group" style="margin-bottom:5px">
                                                    <input class="form-control" type="text" id ="ls2" name="ls2" style="width:100px;height:25px;" readonly="readonly">
                                                </div>
                                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                    <input class="form-control" type="text" name="pd2" id="pd2" value="<? echo date("Y-m-d"); ?>" readonly="readonly" style="width:100px;height:25px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row 3 -->
                                    <!-- baris ke 4 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                            <div class="col-sm-1" style="margin-right: 30px">
                                                <button class="btn btn-primary" id="updatesp" name="updatesp" value="#supplyparts_v" style="width:100px;height:30px;border: none;" onclick="return validateFormSupp()" >UPDATE</button>
                                            </div>
                                            <div class="col-sm-1" id="div_activate_sp" style="display: none;margin-right: 30px">
                                                <button class="btn btn-default" id="activecontrolsp" name="activecontrolsp" value="#supplyparts_v" style="background-color:#ff8080;width:100px;height:30px;color:#ffffff" onclick="return confirm('Ubah status Aktif pada data kanban?');" >DEACTIVATE</button>
                                            </div>
                                            <div class="col-sm-1" style="margin-right: 30px">
                                                <button class="btn btn-danger" id="deletesp" name="deletesp" value="#supplyparts_v" style="width:100px;height:30px;color:#ffffff" onclick="return confirm('Hapus kanban?');" >DELETE</button>
                                            </div>
                                            <div class="col-sm-1" style="margin-right: 30px">
                                                <a href="<?= base_url() ?>index.php/pes/kanban_master/updatemenu" class="btn btn-default" style="width:100px;height:30px;color:#000000" >CANCEL</a>
                                            </div>
                                    </div>
                                    </form>
                                    <!-- end row 4 -->
                                </div>
                                <!-- end tab supply parts -->

                                <!-- begin tab pickup -->
                                <div id="pickup_v" class="tab-pane fade">
                                    <!-- baris ke 1 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                        <div class="col-sm-2" style="width:138px;margin-left:0px;text-align: left;">
                                            <label style="color:black;margin-top:5px;">Plant</label>
                                        </div>
                                        <div class= "col-sm-2" style="width:1px;margin-left:18px;">
                                            <label style="margin-top:5px;">:</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="margin-left:2px;">
                                            <select class="form-control" style="width:70px">
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
                                            <form method="post" action="<?= base_url() ?>index.php/pes/kanban_master/updatemenu">
                                                <input class="form-control" id ="idpickup" name="idpickup" style="height:30px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                     <input type="text" name="bn3" id="bn3" maxlength ="5" style="height:30px;width:150px;">
                                                    <button class="btn-primary" type="button" id="cek3" name="cek3" style="border: none;height:30px;width:50px;">Cek</button>
                                                </div>
                                               
                                                <select class="form-control" id ="pv3" name="pv3" style="height:30px;margin-bottom:5px;width:200px;" >
                                                    <option></option>
                                                </select>
                                                <input class="form-control" type="text" name="sp3" id="sp3"  style="height:30px;width:200px;margin-bottom:5px;" readonly="readonly">
                                                <select class="form-control" name="ss3" id="ss3" style="height:30px;margin-bottom:5px;width:200px;">
                                                    <option></option>
                                                </select>
                                                <select class="form-control" id ="np3" name="np3" style="height:30px;margin-bottom:5px;width:200px;" >
                                                    <option></option>
                                                </select>
                                        </div>
                                        <div class= "col-sm-3" style="margin-left:0px;width:155px;text-align:left" >
                                            <label style="margin-bottom:10px;height: 30px;">Part Name</label><br>
                                            <label style="height: 30px;">Storage(Next Process)</label><br>
                                            <label style=";height: 30px;">Qty/Pack</label><br>
                                            <label style=";height: 30px;">Jenis Box</label><br>
                                            <label style=";height: 30px;">Side</label><br>
                                            <label style=";height: 30px;">Keterangan</label><br>
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
                                            <input class="form-control" type="text" name = "pn3" id = "pn3" value ="" style="width:200px;height:30px;margin-bottom:5px;" readonly="readonly">
                                            <input class="form-control" type="text" name="sn3" id="sn3"  style="height:30px;width:200px;margin-bottom:5px" readonly="readonly">
                                             <input class="form-control" type="text" id="qpb3" name="qpb3" style="height:30px;width:80px;margin-bottom:5px" onkeypress="validate(event)">
                                            <select class="form-control" name="bt3" id="bt3" style="height:30px;width:80px;
                                            margin-bottom:5px">
                                                    <option></option>  
                                            </select>
                                            <select class="form-control" name="side3" id="side3" style="height:30px;width:80px;margin-bottom:5px">
                                                <option></option>  
                                            </select>
                                            <div class="form-group">
                                                <input class="form-control" type ="textarea" id="keterangan3" name = "keterangan3"
                                                style="height:30px;width:200px">
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                        <!-- end row 2 -->

                                        <!-- baris ke 3 -->
                                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                            <div class= "col-sm-1" style="width:1px;margin-left:0px;">
                                            </div>
                                             <div class="col-sm-2 col-sm-offset-1 box" style="border:1px solid;width:auto;padding:10px;width:auto;margin-left:0px;" >    
                                                <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                                     <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Last Serial No</label><br>
                                                     <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Print Date</label>
                                                </div>
                                                <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                                    <label >:</label><br>
                                                    <label >:</label><br>
                                                </div>
                                                <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                                    <div class="form-group" style="margin-bottom:5px">
                                                        <input class="form-control" type="text" id ="ls3" name="ls3" style="width:100px;height:25px;" readonly="readonly">
                                                    </div>
                                                    <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                        <input class="form-control" type="text" name="pd3" id="pd3" value="<? echo date("Y-m-d"); ?>" readonly="readonly" style="width:100px;height:25px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row 3 -->
                                        <!-- baris ke 4 -->
                                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                                <div class="col-sm-1" style="margin-right: 30px">
                                                    <button class="btn btn-primary" id="updatepu" name="updatepu" value="#pickup_v" style="width:100px;height:30px;border: none;" onclick="return validateFormPick()" >UPDATE</button>
                                                </div>
                                                <div class="col-sm-1" id="div_activate_pu" style="display: none;margin-right: 30px">
                                                    <button class="btn btn-default" id="activecontrolpu" name="activecontrolpu" value="#pickup_v" style="background-color:#ff8080;width:100px;height:30px;color:#ffffff" onclick="return confirm('Ubah status Aktif pada data kanban?');" >DEACTIVATE</button>
                                                </div>
                                                <div class="col-sm-1" style="margin-right: 30px">
                                                    <button class="btn btn-danger" id="deletepu" name="deletepu" value="#pickup_v" style="width:100px;height:30px;color:#ffffff" onclick="return confirm('Hapus kanban?');" >DELETE</button>
                                                </div>
                                                <div class="col-sm-1" style="margin-right: 30px">
                                                    <a href="<?= base_url() ?>index.php/pes/kanban_master/updatemenu" class="btn btn-default" style="width:100px;height:30px;color:#000000" >CANCEL</a>
                                                </div>
                                        </div>
                                        </form>
                                        <!-- end row 4 -->
                                    </div>
                                    <!-- end tab pickup -->

                                    <!-- begin tab pickup passthrough -->
                                    <div id="pickupp_v" class="tab-pane fade">
                                        <!-- baris ke 1 -->
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
                                        <div class="row"  style="margin-bottom:10px;">
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
                                            <form method="post" action="<?= base_url() ?>index.php/pes/kanban_master/updatemenu">
                                                <input class="form-control" maxlength="18" id ="idpickupp" name="idpickupp" style="height:30px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                                <input type="text" maxlength = "5" name="bn3p" id="bn3p"  style="height:30px;width:150px;margin-bottom:5px"> 
                                                <button class="btn btn-primary" type="button" id="cek3p" name="cek3p" style="border: none;height:30px;width:50px;">Cek</button><br>
                                                <input type="text" class="form-control" id ="ss3p" name="ss3p" style="height:30px;margin-bottom:5px" readonly="readonly">
                                                </select>
                                                <select class="form-control" name="sn3p" id="sn3p" style="height:30px;margin-bottom:5px" >
                                                    <option></option>
                                                </select>
                                                <input class="form-control" type="text" name="qpb3p" id="qpb3p" style="height:30px;width:80px" onkeypress="validate(event)">
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
                                                <input type="text" class="form-control" name="pn3p" id="pn3p" value="" style="width:200px;height:30px;margin-bottom:5px;" readonly="readonly">
                                                <select class="form-control" name="bt3p" id="bt3p" style="height:30px;width:80px;margin-bottom:5px" >
                                                    <option></option>
                                                </select>
                                                 <select class="form-control" name="side3p" id="side3p" style="height:30px;width:80px;margin-bottom:5px;">
                                                    <option></option>
                                                </select>
                                                <input type ="textarea" class="form-control" style="height:30px;width:200px;margin-bottom:5px;" id="keterangan3p" name = "keterangan3p">
                                            </div>
                                        </div>
                                        <!-- end row 2 -->

                                        <!-- baris ke 3 -->
                                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                            <div class= "col-sm-1" style="width:1px;margin-left:0px;">
                                            </div>
                                             <div class="col-sm-2 col-sm-offset-1 box" style="border:1px solid;width:auto;padding:10px;width:auto;margin-left:0px;" >    
                                                <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                                     <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Last Serial No</label><br>
                                                     <label style="margin-bottom:5px;width: 80px;text-align: -webkit-left;">Print Date</label>
                                                </div>
                                                <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                                    <label >:</label><br>
                                                    <label >:</label><br>
                                                </div>
                                                <div class= "col-sm-2" style="margin-left:0px;width:auto" >
                                                    <div class="form-group" style="margin-bottom:5px">
                                                        <input class="form-control" type="text" id ="ls3p" name="ls3p" style="width:100px;height:25px;" readonly="readonly">
                                                    </div>
                                                    <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                        <input class="form-control" type="text" name="pd3p" id="pd3p" value="<? echo date("Y-m-d"); ?>" readonly="readonly" style="width:100px;height:25px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row 3 -->
                                        <!-- baris ke 4 -->
                                         <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                                <div class="col-sm-1" style="margin-right: 30px">
                                                    <button class="btn btn-primary" id="updatepup" name="updatepup" value="#pickupp_v" style="width:100px;height:30px;border: none;" onclick="return validateFormPass()">UPDATE</button>
                                                </div>
                                                <div class="col-sm-1" id="div_activate_up" style="display: none;margin-right: 30px">
                                                    <button class="btn btn-default" id="activatecontrolpup" name="activatecontrolpup" value="#pickupp_v" style="background-color:#ff8080;width:100px;height:30px;color:#ffffff" onclick="return confirm('Ubah status Aktif pada data kanban?');">DEACTIVATE</button>
                                                </div>
                                                <div class="col-sm-1" style="margin-right: 30px">
                                                    <button class="btn btn-danger" id="deletepup" name="deletepup" value="#pickupp_v" style="width:100px;height:30px;color:#ffffff" onclick="return confirm('Hapus kanban?');">DELETE</button>
                                                </div>
                                                <div class="col-sm-1" style="margin-right: 30px">
                                                    <a href="<?= base_url() ?>index.php/pes/kanban_master/updatemenu" class="btn btn-default" style="width:100px;height:30px;color:#000000" >CANCEL</a>
                                                </div>
                                        </div>
                                        </form>
                                        <!-- end row 4 -->
                                    </div>
                                    <!-- end tab pickup passthrough -->

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
                        var backno = document.getElementById('bn3p').value;
                        var slocfrom = document.getElementById('ss3p').value;
                        var slocto = document.getElementById('sn3p').value;
                        var qtyperpack = document.getElementById('qpb3p').value;
                        var boxtype = document.getElementById('bt3p').value;

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
                        var backno = document.getElementById('bn3').value;
                        var qtyperpack = document.getElementById('qpb3').value;
                        var boxtype = document.getElementById('bt3').value;

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
                        var backno = document.getElementById('bn2').value;
                        var sid = document.getElementById('sud2').value;
                        var storage = document.getElementById('stor2').value;
                        var qtyperpack = document.getElementById('qpb2').value;
                        var boxtype = document.getElementById('bt2').value;

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
                        var backno = document.getElementById('bn1').value;
                        var qtyperpack = document.getElementById('qpb1').value;
                        var boxtype = document.getElementById('bt1').value;

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
                        var backno = document.getElementById('bn').value;
                        var sid = document.getElementById('sud').value;
                        var storage = document.getElementById('stor').value;
                        var qtyperpack = document.getElementById('qpb').value;
                        var boxtype = document.getElementById('bt').value;

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
