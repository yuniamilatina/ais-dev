<?php
session_start();
?>
<script>
    $(function() {
        $("#deliv_date").datepicker({dateFormat: 'dd-mm-yy'});
    });
</script>
<script>
    $(document).ready(function() {

        $("#btnExport").click(function(e) {
            window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
            e.preventDefault();
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $("#qtyperbox").css("background-color", "#bfbfbf");
        $("#qtyperbox1").css("background-color", "#bfbfbf");
        $("#qtyperbox4").css("background-color", "#bfbfbf");
        $("#qtyperbox3").css("background-color", "#bfbfbf");
        $("#qtyperbox3p").css("background-color", "#bfbfbf");
// ajax order
        var i = 0;
        $("#sid").focusin(function() {
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#pname").val(data);
                }
            });
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no").val(data);
                }
            });

            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupporder',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#sid").html(data);
                }
            });
        });

        $("#sid").focusout(function() {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppName3",
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function(data) {
                    $("#sname").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorp',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                success: function(data) {
                    $("#stor").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function(data) {
                    $("#qtyperbox").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial2',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function(data) {
                    $("#lastserial2").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan2',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function(data) {
                    $("#keterangan2").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxTypeor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function(data) {
                    $("#boxtype").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/spor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function(data) {
                            $("#side").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagor',
                data: {sud: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function(data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });
        });
// end ajax order
// ajax proses
// begin change function
        $("#prodver1").focusin(function() {
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {
                    ;
                    $("#pname1").val(data);
                }
            });
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no1',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no1").val(data);
                    ;
                }
            });
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv1',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#prodver1").html(data);
                }
            });



        });

        $("#prodver1").focusout(function() {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro1",
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                type: 'POST',
                success: function(data) {
                    $("#selfpro1").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf1pk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#storself1").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#stornext1").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextPro1pk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#nextpro1").val(data);
                    ;
                }
            });

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function(data) {
                    $("#qtyperbox1").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function(data) {
                            $("#boxtype1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function(data) {
                            $("#side1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function(data) {
                            $("#keterangan1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function(data) {
                            $("#lastserial1").val(data);

                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpr',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function(data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });

        });
// endfocusoutfunction
// end ajax proses

// begin ajax suplyparts
        $("#sid3").focusin(function() {
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#pname3").val(data);
                }
            });
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#backno3").val(data);
                }
            });

            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupp',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#sid3").html(data);
                }
            });
        });
        $("#sid3").focusout(function() {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppName",
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#sname3").val(data);
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getStor",
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#stor3").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#keterangan4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#boxtype4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#lastserial4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/side4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#side4").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagsp',
                data: {sud2: $('#sid3').val(), idsupply: $('#idsupply').val()},
                success: function(data) {
                    if (data == false) {
                        alert("Data telah dihapus");
                    }
                }
            });
        });
// end ajax supplyparts

// ajax pickup
// begin change function
        $("#prodver3").focusin(function() {
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {
                    ;
                    $("#pnamepu").val(data);
                }
            });
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_so/back_no11',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no3").val(data);

                }
            });
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv5',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#prodver3").html(data);
                }
            });



        });
// end change function

// begin focusout function
        $("#prodver3").focusout(function() {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro3",
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                type: 'POST',
                success: function(data) {
                    $("#selfpro3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextPro5pk',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#nextpro3").val(data);
                    ;
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_so/qtyPerbox3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function(data) {
                    $("#qtyperbox3").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_so/boxType3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function(data) {
                            $("#boxtype3").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function(data) {
                            $("#side3").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function(data) {
                            $("#keterangan3").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function(data) {
                            $("#lastserial3").val(data);
                        }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNext11',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function(data) {
                    $("#stornext3").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf11',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function(data) {
                    $("#storself3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpu',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function(data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });

        });
// endfocusoutfunction
// end ajax pickup

// ajax pickup passthrough
// begin change function
        $("#stornext3p").focusin(function() {
            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {
                    ;
                    $("#pnamepup").val(data);
                }
            });
            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_nop',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no3p").val(data);
                    ;
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelfpp',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                success: function(data) {
                    $("#storself3p").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpass',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                success: function(data) {
                    $("#stornext3p").html(data);
                }
            });
        });

        $("#stornext3p").focusout(function() {

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox3p").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#boxtype3p").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#side3p").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#keterangan3p").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#lastserial3p").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpup',
                data: {idpickup: $('#idpickupp').val()},
                success: function(data) {
                    if (data == false) {
                        alert("Data telah dihapus");
                    }
                }
            });
        });
// endfocusoutfunction
// end ajax pickup passthrough

        $('.cekcheckbox').click(function() {

            i++;
            var checkbox = $(this).val();
            var a = a + $(this).val();
            if (checkbox == "yes") {
                if (i % 2 != 0) {
                    $("#qtyperbox").attr("readonly", false);
                    $("#qtyperbox").css("background-color", "");
                    $("#qtyperbox1").attr("readonly", false);
                    $("#qtyperbox1").css("background-color", "");
                    $("#qtyperbox4").attr("readonly", false);
                    $("#qtyperbox4").css("background-color", "");
                    $("#qtyperbox3").attr("readonly", false);
                    $("#qtyperbox3").css("background-color", "");
                    $("#qtyperbox3p").attr("readonly", false);
                    $("#qtyperbox3p").css("background-color", "");
                }
                else {
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxor',
                        data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                        type: 'POST',
                        success: function(data) {
                            $("#qtyperbox").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox1',
                        data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                        type: 'POST',
                        success: function(data) {
                            $("#qtyperbox1").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox4',
                        data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                        type: 'POST',
                        success: function(data) {
                            $("#qtyperbox4").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3',
                        data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                        type: 'POST',
                        success: function(data) {
                            $("#qtyperbox3").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3p',
                        data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()},
                        type: 'POST',
                        success: function(data) {
                            $("#qtyperbox3p").val(data);
                        }
                    });
                    $("#qtyperbox").attr("readonly", true);
                    $("#qtyperbox").css("background-color", "#bfbfbf");
                    $("#qtyperbox1").attr("readonly", true);
                    $("#qtyperbox1").css("background-color", "#bfbfbf");
                    $("#qtyperbox4").attr("readonly", true);
                    $("#qtyperbox4").css("background-color", "#bfbfbf");
                    $("#qtyperbox3").attr("readonly", true);
                    $("#qtyperbox3").css("background-color", "#bfbfbf");
                    $("#qtyperbox3p").attr("readonly", true);
                    $("#qtyperbox3p").css("background-color", "#bfbfbf");
                }

            }
        });

        $('#part_no_cust').focusout(function() {
            var part_no_cust = $(this).val();
            if (part_no_cust != "") {

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>index.php/pes/kanban_so/part_no_aii',
                    data: {part_no_cust: part_no_cust},
                    success: function(data) {
                        if (data == 0) {
                            alert("Master kanban untuk Part No Cust tersebut belum terdaftar, silahkan hubungi kaizen");
                            $("#idpickup").attr("readonly", true);
                            $("#idpickup").css("background-color", "bfbfbf");
                        } else {
                            $("#idpickup").html(data);
                            $("#idpickup").attr("readonly", true);
                            $("#idpickup").css("background-color", "bfbfbf");
                        }

                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });

            }
        });

        $('#idpickup').focusout(function() {
            var part_no_cust = $("#part_no_cust").val();
            var part_no = $("#idpickup").val();

            $.ajax({
                type: 'POST',
                dataType: "json",
                url: '<?= base_url() ?>index.php/pes/kanban_so/getCusNo',
                data: {part_no_cust: part_no_cust, part_no: part_no},
                success: function(data) {
                    if (data.status == false) {
                        $("#cust_no").attr("readonly", true);
                        $("#cust_no").css("background-color", "bfbfbf");
                        $("#cust_name").attr("readonly", true);
                        $("#cust_name").css("background-color", "bfbfbf");
                    } else {
                        $("#cust_no").html(data.cust_no_option);
                        $("#cust_name").html(data.cust_name_option);
                        $("#cust_no").attr("readonly", true);
                        $("#cust_no").css("background-color", "bfbfbf");
                        $("#cust_name").attr("readonly", true);
                        $("#cust_name").css("background-color", "bfbfbf");
                    }

                },
                error: function (request) {
                    alert(request.responseText);
                }
            });
        });

        $('#cust_no').focusout(function() {
            var part_no_cust = $("#part_no_cust").val();
            var part_no = $("#idpickup").val();
            var cust_no = $("#cust_no").val();

            $.ajax({
                type: 'POST',
                dataType: "json",
                url: '<?= base_url() ?>index.php/pes/kanban_so/getCusName',
                data: {part_no_cust: part_no_cust, part_no: part_no, cust_no: cust_no},
                success: function(data) {
                    if (data.status == false) {
                        $("#cust_name").attr("readonly", true);
                        $("#cust_name").css("background-color", "bfbfbf");
                    } else {
                        $("#cust_name").text(data.cust_name);
                        $("#cust_name").val(data.cust_name);
                        $("#cust_name").attr("readonly", true);
                        $("#cust_name").css("background-color", "bfbfbf");
                    }

                },
                error: function (request) {
                    alert(request.responseText);
                }
            });
        });

        $('#part_no_cust').click(function() {
            $("#part_no_cust").val("");
        });

        $('#add_list_print').click(function() {
            var part_no_cust = $("#part_no_cust").val();
            var partno = $("#idpickup").val();
            var cust_no = $("#cust_no").val();
            var cust_name = $("#cust_name").val();
            // console.log(partno);
            var backno = $("#back_no3").val();
            var self_proc = $("#selfpro3").val();
            var self_loc = $("#storself3").val();
            var next_proc = $("#nextpro3").val();
            var next_loc = $("#stornext3").val();
            var qty_per_box = $("#qtyperbox3").val();
            var jenis_box = $("#boxtype3").val();
            var ket = $("#keterangan3").val();
            var side = $("#side3").val();
            var cb = $(".cekcheckbox").val();
            var partName = $("#pnamepu").val();
            var deliv_date = $("#deliv_date").val();

            var printqty = document.getElementById('printqty3').value;
            var prodver = document.getElementById('prodver3').value;

            if (!clickOffConfirmed) {
                return false;
            }

            if (part_no_cust == "") {
                alert("Silahkan pilih production version");
                status = false;
            }
            else if (partno == "") {
                alert("Silahkan masukkan data kanban yang akan di print");
                status = false;
            }
            else if (partno == "0") {
                alert("Silahkan Hubungi Kaizen Untuk Pendaftaran Master Kanban");
                status = false;
            }
            else if (printqty == "") {
                alert("Silahkan masukkan jumlah kanban yang akan di print");
                status = false;
            }
            // else if (prodver == "") {
            //     alert("Silahkan pilih production version");
            //    status = false;
            else {
                $("#isi_body").html("");
                $.ajax({
                    url: '<?= base_url() ?>index.php/pes/kanban_so/insert_tw_kanban_so',
                    data: {deliv_date: deliv_date, partName: partName, cb: cb, side: side,
                        part_no_cust: part_no_cust, cust_no: cust_no, cust_name: cust_name, partno: partno, backno: backno, self_proc: self_proc,
                        self_loc: self_loc, next_proc: next_proc, next_loc: next_loc, qty_per_box: qty_per_box,
                        jenis_box: jenis_box, ket: ket, printqty: printqty, prodver: prodver},
                    type: 'POST',
                    success: function(data) {
                        $(".isi_body").html(data);
                        $("#part_no_cust").val("");
                        $("#cust_no").val("");
                        $("#cust_name").val("");
                        $("#idpickup").val("");
                        $("#pnamepu").val("");
                        $("#side3").val("");
                        $("#back_no3").val("");
                        $("#selfpro3").val("");
                        $("#storself3").val("");
                        $("#nextpro3").val("");
                        $("#stornext3").val("");
                        $("#qtyperbox3").val("");
                        $("#boxtype3").val("");
                        $("#keterangan3").val("");
                    }
                });
            }
//            
        });

        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

// store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

// on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#myTab a[href="' + hash + '"]').tab('show');

    });
// end document ready

    $(document).ready(function() {
// autocomplete
        $('#idorder').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldOr'); ?>",
            minLength: 1
        });
        $('#idsupply').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldSp'); ?>",
            minLength: 1
        });
        $('#idproses').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldPr'); ?>",
            minLength: 1
        });
        $('#idpickup').autocomplete({
            source: "<?php echo site_url('pes/kanban_so/searchOldPu'); ?>",
            minLength: 1
        });
        $('#part_no_cust').autocomplete({
            source: "<?php echo site_url('pes/kanban_so/test'); ?>",
            minLength: 1
        });
        $('#idpickupp').autocomplete({
            source: "<?php echo site_url('pes/kanban_master/searchOldPup'); ?>",
            minLength: 1
        });
    }); //end document ready
</script>
<style type="text/css">
    label{
        color:#000000;
    }
    input{
        color:#000000;
    }
    button{
        color:#000000;
    }
    li{
        color:#000000;
    }
    select{
        color:#000000;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Kanban SO</strong></a></li>
        </ol>
    </section>

    <section class="content" >
        <div class="row">
            <div class="col-md-12 text-center" >
                <div class="grid">
                    <div class="grid-header" >
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PRINT KANBAN SO</strong></span>
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
                        <ul class="nav nav-tabs" id="myTab" >
                            <li><a data-toggle="tab" href="#pickup_v">Pick Up</a></li>

                        </ul>
                        <!-- begin tab content -->
                        <div class="tab-content" style="text-align:left;">
                            <!-- begin tab pickup -->
                            <div id="pickup_v" class="tab-pane fade in active">
                                <!-- baris ke 1 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="margin-left:0;text-align:left;">
                                        <label>Plant <select><option>600</option></select></label>
                                    </div>      
                                    <div class="col-sm-9" style="margin-left:0;text-align:right;">


                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Delivery Date : </label>
                                            <div class="col-sm-3">
                                                <div class="input-group date form_datetime" data-date="2014-06-14T05:25:07Z" data-date-format="dd-mm-yyyy HH:ii" data-link-field="dtp_input2">
                                                    <input type="text" class="form-control" name="deliv_date" id="deliv_date" value="<?php echo date("d-m-Y") ?>">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="hidden" id="dtp_input2" value="" />
                                            </div>
                                        </div>
                                    </div>      
                                    <div class="col-sm-4" style="margin-left:0;text-align:left;">

                                    </div>      

                                </div>
                                <!-- end row 1 -->
                                <!-- baris ke 2-->
                                <div class="row"  style="margin-bottom:20px;">
                                    <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                                        <label style="margin-bottom:10px;">Part Customer</label><br>
                                        <label style="margin-bottom:10px;">Part No AII</label><br>
                                        <label style="margin-bottom:10px;">Customer No</label><br>
                                        <label style="margin-bottom:10px;">Customer Name</label><br>
                                        <label style="margin-bottom:10px;">Back No</label><br>
                                        <label style="margin-bottom:10px;">Production version</label><br>
                                        <label style="margin-bottom:10px;">Self Process</label><br>
                                        <label style="margin-bottom:10px;">Storage(Self Process)</label><br>
                                        <label style="margin-bottom:10px;">Next Process</label><br>
                                        <label style="margin-bottom:10px;">Storage(Next Process)</label><br>
                                    </div>
                                    <div class= "col-sm-1" style="width:auto;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                        <form method="post" action="">

                                            <input class="form-control" id ="part_no_cust" name="part_no_cust" style="height:25px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                            <select class="form-control" id ="idpickup" name="idpickup" style="height:28px;margin-bottom:5px" >
                                                <option></option>
                                            </select>
                                            <select class="form-control" id ="cust_no" name="cust_no" style="height:28px;margin-bottom:5px" >
                                                <option></option>
                                            </select>
                                            <input type="text" name="cust_name" id="cust_name"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <!--<input class="form-control" id ="idpickup" name="idpickup" style="height:25px;width:200px;margin-bottom:5px">-->
                                            <input type="text" name="back_no3" id="back_no3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <select class="form-control" id ="prodver3" name="prodver3" style="height:28px;margin-bottom:5px" >
                                                <option></option>
                                            </select>
                                            <input type="text" name="selfpro3" id="selfpro3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <input type="text" name="storself3" id="storself3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <input type="text" name="nextpro3" id="nextpro3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <input type="text" name="stornext3" id="stornext3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly">
                                            </div>
                                            <div class= "col-sm-3" style="width:auto;margin-left:0px;" >
                                                <input type="text" name = "pnamepu" id = "pnamepu" value ="" style="background-color:#bfbfbf;width:250px;height:25px;margin-bottom:35px;" readonly="readonly"></br>
                                            </div>
                                            <div class="col-sm-3" style="margin-left:30px;">
                                                <label>Side</label>
                                                <input type="text" name="side3" id = "side3" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                                            </div>
                                    </div>
                                    <!-- end row 2 -->

                                    <!-- baris ke 3 -->
                                    <div class="row" style="margin-bottom:10px;">

                                        <div class="col-sm-3">
                                            <label>Qty/Pack</label><input type="text" name="qtyperbox3" id="qtyperbox3" style="background-color:#bfbfbf;height:25px;width:80px;margin-left:10px" readonly="readonly";><br>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Jenis Box</label>
                                            <input type="text" name="boxtype3" id = "boxtype3" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                                        </div> 
                                        <div>
                                            <label>Keterangan </label>
                                            <input type ="textarea" id="keterangan3" name = "keterangan3" readonly="readonly" style="background-color:#bfbfbf;">
                                        </div>   
                                    </div><br>
                                    <!-- end row 3 -->

                                    <!-- baris ke 4 -->     
                                    <div class="row" >
                                        <div class="col-sm-12">
                                            <div class="col-sm-2" style="width:auto;border-left:1px solid;border-top:1px solid;border-bottom:1px solid;height:70px">
                                                <label style="margin-top:15px">Print Qty</label>
                                                <input type="number" name="printqty3" id="printqty3" min="1" max="1000" style="margin-bottom:20px;margin-left:10px;width:50px;height:25px;">
                                            </div>
                                            <div class="col-sm-4" style="width:auto;text-align:left;border-top:1px solid;border-bottom:1px solid;height:70px">
                                                <div class="checkbox" >
                                                    <!--<label><input type="checkbox" id="F[]" name="checkboxA[]" class="cekcheckbox" value="no">Temporary</label><br>-->
                                                    <label><input type="checkbox" id="checkboxB[]" name="checkboxB[]" class="cekcheckbox" value="yes">Special Order</label>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2" style="border-top:1px solid;border-bottom:1px solid;height:70px;" ></div>
                                            <div class="col-sm-2" style="padding-top:5px;width:auto;border-top:1px solid;border-bottom:1px solid;height:70px;border-right:1px solid;" >
                                                <label>Last Serial No</label><input type="text" id="lastserial3" name="lastserial3" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                                <label>Print Date</label><input name="printdate3" id="printdate3" type="text" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">
                                            </div> 
                                        </div>         
                                    </div>
                                    <!-- end row 4 -->

                                    <!-- baris ke 5 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                        <div class="col-sm-6">
                                            <div class="btn btn-danger" name="add_list_print" id="add_list_print" value="#add_list_print" onclick="clickOffConfirmed = confirm('Are you sure?');" ><span class="fa fa-plus"></span>&nbsp;&nbsp;Add to List</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn btn-primary" name="printpu" id="printpu" value="#pickup_v" onclick="return validateFormPick()" ><span class="fa fa-print"></span>&nbsp;&nbsp;Print Kanban</button>&nbsp;
                                            <button class="btn btn-default" name="cancel" id="cancel" value="cancel"><span class="fa fa-refresh"></span>&nbsp;&nbsp;Cancel</button>
                                            <button id="loading" class="btn btn-success" data-toggle="modal" data-target="#modalSuccess" style="display:none;">Success</button>
                                        </div>
                                    </div>
                                    </form>
                                    <!-- end row 5 -->
                                </div>
                                <!-- end tab pickup -->

                                <!-- begin tab pickup passthrough -->

                                <!-- end tab pickup passthrough -->

                            </div>
                            <!--                            <div>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        masuk
                                                                    </td>
                                                                </tr>
                                                                    
                                                            </table>
                                                        </div>-->
                            <!-- end tab content -->

                        </div>
                        <!-- end grid body -->
                    </div>
                    <!-- end grid class  -->
                </div>  
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="grid border">
                        <div class="grid-header">
                            <i class="fa fa-upload"></i>
                            <span class="grid-title"><strong>UPLOAD KANBAN SO</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body" >
                            <div class="row"  style="margin-bottom:20px;">
                                <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                                    <label style="margin-bottom:10px;">Template Excel</label><br>
                                    <label style="margin-bottom:10px;">Upload Excel</label><br>
                                </div>
                                <div class= "col-sm-1" style="width:auto;margin-left:0px;">
                                    <label style="margin-bottom:10px;">:</label><br>
                                    <label style="margin-bottom:10px;">:</label><br>
                                </div>
                                <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data" role="form" action="">
                                        <?php echo anchor("pes/kanban_so/download", "Kanban_SO.xlsx") ?>
                                        <input type="file" name="import" id="import" size="20" value="" style="margin-top:10px;">

                                        </div>

                                        </div>
                                        <div class="row"  style="margin-bottom:20px;">
                                            <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                                <!--<button class="btn" name="upload_excel" id="upload_excel" value="1" style="background-color:#66ccff;width:100px;height:30px;" onclick="" ><i class="icon-ok icon-white" ></i>PRINT</button>-->
                                                <button class="btn btn-success" name="upload_excel" id="upload_excel" value="1" onclick="" ><span class="fa fa-print" ></span>&nbsp;&nbsp;Upload</button>
                                            </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                        <div id="dvData" style="display:none;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Part No AII</th>
                                        <th>Part No Customer</th>
                                        <th>Back No</th>
                                        <th>Part Name</th>
                                        <th>Self Process</th>
                                        <th>Next Process</th>
                                        <th>Self Location</th>
                                        <th>Next Location</th>
                                        <th>Qty Per Box</th>
                                        <th>Box Type</th>
                                        <th>Print Qty</th>
                                        <th>Status</th>
                                        <th>Error Message</th>
                                    </tr>
                                </thead>
                                <tbody class="isi_body">
                                    <?php
                                    foreach ($data_list_print as $value_lp) {
                                        $part_no_aii1 = $value_lp->CHR_PART_NO_AII;
                                        $part_no_cust1 = $value_lp->CHR_PART_NO_CUST;
                                        $back_no1 = $value_lp->CHR_BACK_NO;
                                        $part_name1 = $value_lp->CHR_PART_NAME;
                                        $self_prcs1 = $value_lp->CHR_SELF_PRCS;
                                        $next_prcs1 = $value_lp->CHR_NEXT_PRCS;
                                        $self_loc1 = $value_lp->CHR_SELF_LOC;
                                        $next_loc1 = $value_lp->CHR_NEXT_LOC;
                                        $qty_per_box1 = $value_lp->INT_QTY_PER_BOX;
                                        $box_type1 = $value_lp->CHR_BOX_TYPE;
                                        $status = $value_lp->CHR_STATUS;
                                        $errmsg = $value_lp->CHR_ERROR_MESSAGE;
                                        $print_qty_arr = $this->db->query("select COUNT(CHR_PART_NO_AII) as TOT FROM TW_PRINT_KANBAN_SO WHERE CHR_PART_NO_AII = '$part_no_aii1' and INT_QTY_PER_BOX = $qty_per_box1")->row();
                                        $print_qty1 = $print_qty_arr->TOT;
                                        echo "<tr>
                                        <td>$part_no_aii1</td>
                                        <td>$part_no_cust1</td>
                                        <td>$back_no1</td>
                                        <td>$part_name1</td>
                                        <td>$self_prcs1</td>
                                        <td>$next_prcs1</td>
                                        <td>$self_loc1</td>
                                        <td>$next_loc1</td>
                                        <td>$qty_per_box1</td>
                                        <td>$box_type1</td>
                                        <td>$print_qty1</td>
                                        <td>$status</td>
                                        <td>$errmsg</td>
                                    </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END BASIC DATATABLES -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="grid border">
                            <div class="grid-header">
                                <i class="fa fa-th-large"></i>
                                <span class="grid-title"><strong>LIST DATA PRINT</strong></span>
                                <div class="pull-right grid-tools">
                                    <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                    <a id="btn-save" title="Save" onclick="document.getElementById('btnExport').click()"><i class="fa fa-save"></i></a>
                                    <input type="button" id="btnExport" style="display:none;" value=" Export Table data into Excel " />
                                </div>
                            </div>
                            <div class="grid-body" >
                                <table  class="table" cellspacing="0" width="100%" >
                                    <thead>
                                        <tr>
                                            <th>Part No AII</th>
                                            <th>Part No Customer</th>
                                            <th>Back No</th>
                                            <th>Part Name</th>
                                            <th>Self Process</th>
                                            <th>Next Process</th>
                                            <th>Self Location</th>
                                            <th>Next Location</th>
                                            <th>Qty Per Box</th>
                                            <th>Box Type</th>
                                            <th>Print Qty</th>
                                            <th>Status</th>
                                            <th>Error Message</th>
                                        </tr>
                                    </thead>
                                    <tbody class="isi_body">
                                        <?php
                                        foreach ($data_list_print as $value_lp) {
                                            $part_no_aii1 = $value_lp->CHR_PART_NO_AII;
                                            $part_no_cust1 = $value_lp->CHR_PART_NO_CUST;
                                            $back_no1 = $value_lp->CHR_BACK_NO;
                                            $part_name1 = $value_lp->CHR_PART_NAME;
                                            $self_prcs1 = $value_lp->CHR_SELF_PRCS;
                                            $next_prcs1 = $value_lp->CHR_NEXT_PRCS;
                                            $self_loc1 = $value_lp->CHR_SELF_LOC;
                                            $next_loc1 = $value_lp->CHR_NEXT_LOC;
                                            $qty_per_box1 = $value_lp->INT_QTY_PER_BOX;
                                            $box_type1 = $value_lp->CHR_BOX_TYPE;
                                            $status = $value_lp->CHR_STATUS;
                                            $errmsg = $value_lp->CHR_ERROR_MESSAGE;
                                            $print_qty_arr = $this->db->query("select COUNT(CHR_PART_NO_AII) as TOT FROM TW_PRINT_KANBAN_SO WHERE CHR_PART_NO_AII = '$part_no_aii1' and INT_QTY_PER_BOX = $qty_per_box1")->row();
                                            $print_qty1 = $print_qty_arr->TOT;
                                            echo "<tr>
                                        <td>$part_no_aii1</td>
                                        <td>$part_no_cust1</td>
                                        <td>$back_no1</td>
                                        <td>$part_name1</td>
                                        <td>$self_prcs1</td>
                                        <td>$next_prcs1</td>
                                        <td>$self_loc1</td>
                                        <td>$next_loc1</td>
                                        <td>$qty_per_box1</td>
                                        <td>$box_type1</td>
                                        <td>$print_qty1</td>
                                        <td ";
                                            if ($status == "S") {
                                                echo "style='background:#0bf90b;color:black;text-align:center;' ";
                                            } else {
                                                echo "style='background:#f44336;color:white;text-align:center;' ";
                                            }

                                            echo ">$status</td>
                                        <td>$errmsg</td>
                                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="dvData" style="display:none;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Part No AII</th>
                                    <th>Part No Customer</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Self Process</th>
                                    <th>Next Process</th>
                                    <th>Self Location</th>
                                    <th>Next Location</th>
                                    <th>Qty Per Box</th>
                                    <th>Box Type</th>
                                    <th>Print Qty</th>
                                    <th>Status</th>
                                    <th>Error Message</th>
                                </tr>
                            </thead>
                            <tbody class="isi_body">
                                <?php
                                foreach ($data_list_print as $value_lp) {
                                    $part_no_aii1 = $value_lp->CHR_PART_NO_AII;
                                    $part_no_cust1 = $value_lp->CHR_PART_NO_CUST;
                                    $back_no1 = $value_lp->CHR_BACK_NO;
                                    $part_name1 = $value_lp->CHR_PART_NAME;
                                    $self_prcs1 = $value_lp->CHR_SELF_PRCS;
                                    $next_prcs1 = $value_lp->CHR_NEXT_PRCS;
                                    $self_loc1 = $value_lp->CHR_SELF_LOC;
                                    $next_loc1 = $value_lp->CHR_NEXT_LOC;
                                    $qty_per_box1 = $value_lp->INT_QTY_PER_BOX;
                                    $box_type1 = $value_lp->CHR_BOX_TYPE;
                                    $status = $value_lp->CHR_STATUS;
                                    $errmsg = $value_lp->CHR_ERROR_MESSAGE;
                                    $print_qty_arr = $this->db->query("select COUNT(CHR_PART_NO_AII) as TOT FROM TW_PRINT_KANBAN_SO WHERE CHR_PART_NO_AII = '$part_no_aii1' and INT_QTY_PER_BOX = $qty_per_box1")->row();
                                    $print_qty1 = $print_qty_arr->TOT;
                                    echo "<tr>
                                        <td>$part_no_aii1</td>
                                        <td>$part_no_cust1</td>
                                        <td>$back_no1</td>
                                        <td>$part_name1</td>
                                        <td>$self_prcs1</td>
                                        <td>$next_prcs1</td>
                                        <td>$self_loc1</td>
                                        <td>$next_loc1</td>
                                        <td>$qty_per_box1</td>
                                        <td>$box_type1</td>
                                        <td>$print_qty1</td>
                                             <td>$status</td>
                                        <td>$errmsg</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END BASIC DATATABLES -->
                </div>

                <div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel1" style="text-align:center;">Please Wait</h4>
                                </div>
                                <div class="modal-body" style="text-align:center;">
                                    <p><img src="<?php echo base_url(); ?>assets/img/loading/ajax-loader-7.gif" title="Loading Please Wait!!" ></p>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                </section>
                </aside>

                <script>
                    function validateFormOrd() {
                        var status = false;
                        var partno = document.getElementById('idorder').value;
                        var printqty = document.getElementById('printqtyor').value;
                        var sid = document.getElementById('sid').value;

                        if (partno == "") {
                            alert("Silahkan masukkan data kanban yang akan di print");
                            status = false;
                        }
                        else if (printqty == "") {
                            alert("Silahkan masukkan jumlah kanban yang akan di print");
                            status = false;

                        } else if (sid == "") {
                            alert("Silahkan pilih supplier id");
                            status = false;
                        }
                        else {
                            var r = confirm("Print data kanban ?");
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
                        var printqty = document.getElementById('printqty').value;
                        var prodver = document.getElementById('prodver1').value;

                        if (partno == "") {
                            alert("Silahkan masukkan data kanban yang akan di print");
                            status = false;
                        }
                        else if (printqty == "") {
                            alert("Silahkan masukkan jumlah kanban yang akan di print");
                            status = false;
                        }
                        else if (prodver == "") {
                            alert("Silahkan pilih production version");
                            status = false;

                        }
                        else {
                            var r = confirm("Print kanban ?");
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
                        var printqty = document.getElementById('printqty4').value;
                        var sid = document.getElementById('sid3').value;

                        if (partno == "") {
                            alert("Silahkan masukkan data kanban yang akan di print");
                            status = false;
                        }
                        else if (printqty == "") {
                            alert("Silahkan masukkan jumlah kanban yang akan di print");
                            status = false;
                        }
                        else if (sid == "") {
                            alert("Silahkan pilih supplier id");
                            status = false;

                        }
                        else {
                            var r = confirm("Print kanban ?");
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
                        var printqty = document.getElementById('printqty3').value;
                        var prodver = document.getElementById('prodver3').value;


                        var r = confirm("Print kanban ?");
                        if (r == true) {
                            status = true;
                            document.getElementById("loading").click();
                            var win = window.open("<?php echo base_url() ;?>index.php/pes/kanban_so/print_kanban/1", '_blank');
                            var win = window.open("<?php echo base_url() ;?>index.php/pes/kanban_so/print_kanban/2", '_blank');
                            win.focus();
                        } else {
                            status = false
                        }

                        return status;

                    }

                    function validateFormPass() {
                        var status = false;
                        var partno = document.getElementById('idpickupp').value;
                        var printqty = document.getElementById('printqty3p').value;
                        var slocfrom = document.getElementById('stornext3p').value;

                        if (partno == "") {
                            alert("Silahkan masukkan data kanban yang akan di print");
                            status = false;
                        }
                        else if (printqty == "") {
                            alert("Silahkan masukkan jumlah kanban yang akan di print");
                            status = false;
                        }
                        else if (slocfrom == "") {
                            alert("Silahkan pilih storage location to");
                            status = false;

                        }
                        else {
                            var r = confirm("Print kanban ?");
                            if (r == true) {
                                status = true;
                            } else {
                                status = false
                            }

                        }

                        return status;

                    }
                </script>




