<?php
session_start();
?>
<script>
    $(document).ready(function () {
        $(window).keydown(function (event) {
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
        $("#sid").focusin(function () {
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pname").val(data);
                }
            });
            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#back_no").val(data);
                }
            });

            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getLastPrintDate',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#printdate2X").val(data);
                }
            });

            var pno = $("#idorder").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupporder',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#sid").html(data);
                }
            });
        });

        $("#sid").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppName3",
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#sname").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStorp',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                success: function (data) {
                    $("#stor").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#qtyperbox").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial2',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#lastserial2").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan2',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#keterangan2").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxTypeor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                success: function (data) {
                    $("#boxtype").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/spor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            $("#side").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagor',
                data: {sud: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });
        });
// end ajax order
// ajax proses
// begin change function
        $("#prodver1").focusin(function () {
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    ;
                    $("#pname1").val(data);
                }
            });
            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#back_no1").val(data);
                    ;
                }
            });

            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getLastPrintDate',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#printdate1X").val(data);
                }
            });

            var pno = $("#idproses").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#prodver1").html(data);
                }
            });



        });
// end change function
// begin focusout function
        $("#prodver1").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro1",
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#selfpro1").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf1pk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function (data) {
                    $("#storself1").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function (data) {
                    $("#stornext1").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextPro1pk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function (data) {
                    $("#nextpro1").val(data);
                    ;
                }
            });

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                success: function (data) {
                    $("#qtyperbox1").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#boxtype1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#side1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#keterangan1").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#lastserial1").val(data);

                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpr',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });

        });
// endfocusoutfunction
// end ajax proses

// begin ajax suplyparts
        $("#sid3").focusin(function () {
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#pname3").val(data);
                }
            });
            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#backno3").val(data);
                }
            });

            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getLastPrintDate',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#printdate4X").val(data);
                }
            });

            var pno = $("#idsupply").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupp',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#sid3").html(data);
                }
            });
        });
        $("#sid3").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppName",
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#sname3").val(data);
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getStor",
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#stor3").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#qtyperbox4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#keterangan4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#boxtype4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#lastserial4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/side4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                success: function (data) {
                    $("#side4").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagsp',
                data: {sud2: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                        success: function (data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });
        });
// end ajax supplyparts

// ajax pickup
// begin change function
        $("#prodver3").focusin(function () {
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    ;
                    $("#pnamepu").val(data);
                }
            });
            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no11',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#back_no3").val(data);
                    ;
                }
            });

            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getLastPrintDate',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#printdate3X").val(data);
                }
            });

            var pno = $("#idpickup").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv5',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#prodver3").html(data);
                }
            });



        });
// end change function

// begin focusout function
        $("#prodver3").focusout(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro3",
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#selfpro3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextPro5pk',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function (data) {
                    $("#nextpro3").val(data);
                    ;
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#qtyperbox3").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#boxtype3").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#side3").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#keterangan3").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#lastserial3").val(data);
                        }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNext11',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#stornext3").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf11',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                success: function (data) {
                    $("#storself3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpu',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
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
        $("#stornext3p").focusin(function () {
            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getLastPrintDate',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#printdate3pX").val(data);
                }
            });


            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function (data) {
                    ;
                    $("#pnamepup").val(data);
                }
            });
            var pno = $("#idpickupp").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_nop',
                data: 'pno=' + pno,
                success: function (data) {
                    $("#back_no3p").val(data);
                    ;
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelfpp',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                success: function (data) {
                    $("#storself3p").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpass',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                success: function (data) {
                    $("#stornext3p").html(data);
                }
            });
        });

        $("#stornext3p").focusout(function () {

            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()}, type: 'POST',
                success: function (data) {
                    $("#qtyperbox3p").val(data);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()}, type: 'POST',
                        success: function (data) {
                            $("#boxtype3p").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()}, type: 'POST',
                        success: function (data) {
                            $("#side3p").val(data);
                        }
            });

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()}, type: 'POST',
                        success: function (data) {
                            $("#keterangan3p").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3p',
                data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()}, type: 'POST',
                        success: function (data) {
                            $("#lastserial3p").val(data);
                        }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/cekFlagpup',
                data: {idpickup: $('#idpickupp').val()}, type: 'POST',
                        success: function (data) {
                            if (data == false) {
                                alert("Data telah dihapus");
                            }
                        }
            });


        });
// endfocusoutfunction
// end ajax pickup passthrough

        $('.cekcheckbox').click(function () {

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
                        data: {sid: $('#sid').val(), idorder: $('#idorder').val()}, type: 'POST',
                        success: function (data) {
                            $("#qtyperbox").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox1',
                        data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()}, type: 'POST',
                        success: function (data) {
                            $("#qtyperbox1").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox4',
                        data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()}, type: 'POST',
                        success: function (data) {
                            $("#qtyperbox4").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3',
                        data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()}, type: 'POST',
                        success: function (data) {
                            $("#qtyperbox3").val(data);
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3p',
                        data: {idpickup: $('#idpickupp').val(), slocto: $('#stornext3p').val()}, type: 'POST',
                        success: function (data) {
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
            <li><a href=""><strong>Kanban Master System</strong></a></li>
        </ol>
    </section>

    <section class="content" >
        <div class="row">
            <div class="col-md-12 text-center" >
                <div class="grid">
                    <div class="grid-header" >
                        <i class="fa fa-print"></i>
                        <span class="grid-title"><strong>PRINT KANBAN</strong></span>
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
                            <li class="active" ><a data-toggle="tab" href="#order_v">Order</a></li>
                            <li><a data-toggle="tab" href="#proses_v">Proses</a></li>
                            <li><a data-toggle="tab" href="#supplyparts_v">Supply Parts</a></li>
                            <li><a data-toggle="tab" href="#pickup_v">Pick Up</a></li>
                            <li><a data-toggle="tab" href="#pickupp_v">Pick Up Passthrough</a></li>
                        </ul>
                        <!-- begin tab content -->
                        <div class="tab-content" style="text-align:left;">
                            <!-- begin tab order -->
                            <div id="order_v" class="tab-pane fade in active" >
                                <!-- baris ke 1 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="margin-left:0px;">
                                        <label>Plant <select><option>600</option></select></label>
                                    </div>      
                                </div>
                                <!-- end row 1  -->

                                <!-- baris ke 2-->
                                <div class="row" style="margin-bottom:15px;">
                                    <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                        <label style="margin-bottom:10px;">No. Part</label><br>
                                        <label style="margin-bottom:10px;">Back No</label><br>
                                        <label style="margin-bottom:10px;">Supplier</label><br>
                                        <label style="margin-bottom:10px;">Storage</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                        <label style="margin-bottom:10px;">:</label><br>
                                    </div>
                                    <div class= "col-sm-2" style="margin-left:0px;" >
                                        <form id="myForm" method="post" action="" >
                                            <div class="form-group" style="margin-bottom:0px">
                                                <input class="form-control" id ="idorder" name="idorder" style="height:25px;width:200px;" autofocus="autofocus" >
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input type="text" name="back_no" id="back_no"  style="background-color:#bfbfbf;height:25px;width:200px;" readonly="readonly">
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <select class="form-control" name="sid" id="sid" style="height:28px;width:200px;margin-bottom:5px" >
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                <input type="text" name="stor" id="stor"  style="background-color:#bfbfbf;height:25px;width:200px;" readonly="readonly">
                                            </div>  
                                    </div>
                                    <div class="col-sm-3" style="margin-left:30px;">
                                        <input type="text" name="pname" id="pname" value="" style="background-color:#bfbfbf;width:300px;height:25px;margin-left:30px;margin-bottom:40px;" readonly="readonly">
                                        <input type="text" name="sname" id="sname" value="" style="background-color:#bfbfbf;width:300px;height:25px;margin-left:30px;" readonly="readonly">
                                    </div>
                                    <div class="col-sm-3" style="margin-left:30px;">
                                        <label>Side</label>
                                        <input type="text" name="side" id = "side" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                                    </div>
                                </div>
                                <!-- end row 2 -->

                                <!-- baris ke 3 -->
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-sm-3">
                                        <label>Qty/Pack</label>
                                        <input type="text" name="qtyperbox" id="qtyperbox" style="background-color:#bfbfbf;height:25px;width:80px;margin-left:10px" readonly="readonly"><br>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Jenis Box</label>
                                        <input type="text" name="boxtype" id="boxtype" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly">
                                    </div> 
                                    <div class="col-sm-4">
                                        <label>Keterangan </label>
                                        <input type="text" id="keterangan2" name="keterangan2" readonly="readonly" style="background-color:#bfbfbf;">
                                    </div>   
                                </div><br>
                                <!-- end row 3 -->
                                <!-- baris ke 4 -->     
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-2" style="width:auto;border-left:1px solid;border-top:1px solid;border-bottom:1px solid;height:80px">
                                            <label style="margin-top:15px">Print Qty</label><input type="number" id="printqtyor" name="printqtyor" min="1" max="1000" style="margin-bottom:20px;margin-left:10px;width:50px;height:25px;">
                                        </div>
                                        <div class="col-sm-4" style="width:auto;text-align:left;border-top:1px solid;border-bottom:1px solid;height:80px">
                                            <div class="checkbox" >
                                                <label><input type="checkbox" id="checkboxA[]" name="checkboxA[]" class="cekcheckbox" value="no">Temporary</label><br>
                                                <label><input type="checkbox" id="checkboxB[]" name="checkboxB[]" class="cekcheckbox" value="yes">Special Order</label><br>
                                                <label><input type="checkbox" id="checkboxC[]" name="checkboxC[]" value="yes">Build Out</label>
                                            </div>
                                        </div> 
                                        <div class="col-sm-2" style="border-top:1px solid;border-bottom:1px solid;height:80px;" ></div>
                                        <div class="col-sm-2" style="padding-top:5px;width:auto;border-top:1px solid;border-bottom:1px solid;height:80px;border-right:1px solid;" >
                                            <label>Last Serial No</label><input type="text" id = "lastserial2" name = "lastserial2" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                            <label>Last Print Date</label><input type="text" id = "printdate2X" name = "printdate2X" value="" style="background-color:#bfbfbf;margin-left:5px;width:100px;height:25px;" readonly="readonly">
                                            <input style="display:none;" type="text" id = "printdate2" name = "printdate2" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:5px;width:100px;height:25px;" readonly="readonly">
                                        </div>
                                    </div>         
                                </div>
                                <!-- end row 4 -->
                                <!-- baris ke 5 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class="col-sm-6">
                                        <button class="btn" name="printor" id="printor" value="#order_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormOrd()" ><i class="icon-ok icon-white" ></i>PRINT</button>
                                      <!-- <input type="submit" name="printor" id="printor" class="btn btn-info btn-md" value="PRINT"> -->
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="<?= base_url() ?>index.php/pes/kanban_master/print_kanban" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                                    </div>
                                </div>
                                </form>
                                <!-- end row 5 -->
                                <!-- end all row -->
                            </div>
                            <!-- end tab order -->
                            <!-- begin tab proses -->
                            <div id="proses_v" class="tab-pane fade">
                                <!-- baris ke 1 -->
                                <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                    <div class="col-sm-2" style="margin-left:0;">
                                        <label>Plant <select><option>600</option></select></label>
                                    </div>      
                                </div>
                                <!-- end row 1 -->
                                <!-- baris ke 2-->
                                <div class="row"  style="margin-bottom:20px;">
                                    <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                                        <label style="margin-bottom:10px;">No. Part</label><br>
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
                                        <form method="post" action="" >
                                            <input class="form-control" id ="idproses" name="idproses" style="height:25px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                            <input type="text" name="back_no1" id="back_no1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <select class="form-control" id ="prodver1" name="prodver1" style="height:28px;margin-bottom:5px" >
                                                <option></option>
                                            </select>
                                            <input type="text" name="selfpro1" id="selfpro1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <input type="text" name="storself1" id="storself1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <input type="text" name="nextpro1" id="nextpro1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                            <input type="text" name="stornext1" id="stornext1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly">
                                            </div>
                                            <div class= "col-sm-3" style="width:auto;margin-left:0px;" >
                                                <input type="text" name = "pname1" id = "pname1" value ="" style="background-color:#bfbfbf;width:250px;height:25px;margin-bottom:35px;" readonly="readonly"></br>
                                            </div>
                                            <div class="col-sm-3" style="margin-left:30px;">
                                                <label>Side</label>
                                                <input type="text" name="side1" id = "side1" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                                            </div>
                                    </div>
                                    <!-- end row 2 -->

                                    <!-- baris ke 3 -->
                                    <div class="row" style="margin-bottom:10px;">

                                        <div class="col-sm-3">
                                            <label>Qty/Pack</label>
                                            <input type="text" id="qtyperbox1" name="qtyperbox1" style="background-color:#bfbfbf;height:25px;width:80px;margin-left:10px" readonly="readonly"><br>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Jenis Box</label>
                                            <input type="text" name="boxtype1" id = "boxtype1" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                                        </div>  
                                        <div class="col-sm-4">
                                            <label>Keterangan </label>
                                            <input type ="textarea" id="keterangan1" name = "keterangan1" readonly="readonly" style="background-color:#bfbfbf;">
                                        </div>  
                                    </div><br>
                                    <!-- end row 3 -->

                                    <!-- baris ke 4 -->     
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-2" style="width:auto;border-left:1px solid;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                <label style="margin-top:15px">Print Qty</label><input type="number" name="printqty" id="printqty" min="1" max="1000" style="margin-bottom:20px;margin-left:10px;width:50px;height:25px;">
                                            </div>
                                            <div class="col-sm-4" style="width:auto;text-align:left;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                <div class="checkbox" >
                                                    <label><input type="checkbox" id="checkboxA[]" name="checkboxA[]" class="cekcheckbox" value="no">Temporary</label><br>
                                                    <label><input type="checkbox" id="checkboxB[]" name="checkboxB[]" class="cekcheckbox" value="yes">Special Order</label><br>
                                                    <label><input type="checkbox" id="checkboxC[]" name="checkboxC[]" value="yes">Build Out</label></div>
                                            </div> 
                                            <div class="col-sm-2" style="border-top:1px solid;border-bottom:1px solid;height:80px;" ></div>
                                            <div class="col-sm-2" style="padding-top:5px;width:auto;border-top:1px solid;border-bottom:1px solid;height:80px;border-right:1px solid;" >
                                                <label>Last Serial No</label><input type="text" id ="lastserial1" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                                <label>Last Print Date</label><input type="text" name="printdate1X" id="printdate1X" value="" style="background-color:#bfbfbf;margin-left:5px;width:100px;height:25px;" readonly="readonly">     
                                                <input style="display:none;" type="text" name="printdate1" id="printdate1" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">     
                                            </div> 
                                        </div>         
                                    </div>
                                    <!-- end row 4 -->
                                    <!-- baris ke 5 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                        <div class="col-sm-6">
                                            <button class="btn" name="printpr" id="printpr" value="2" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormProc()" ><i class="icon-ok icon-white" ></i>PRINT</button>

                          <!-- <input type="submit" name="printpr" id="printpr" class="btn btn-info btn-md" value="PRINT"> -->
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="<?= base_url() ?>index.php/pes/kanban_master/print_kanban" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                                        </div>
                                    </div>
                                    </form>
                                    <!-- end row 5 -->
                                </div>
                                <!-- end tab proses -->

                                <!-- begin tab supply parts -->
                                <div id="supplyparts_v" class="tab-pane fade">
                                    <!-- baris ke 1 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                        <div class="col-sm-2">
                                            <label>Plant <select><option>600</option></select></label>
                                        </div>      
                                    </div>
                                    <!-- end row 1 -->
                                    <!-- baris ke 2-->
                                    <div class="row" style="margin-bottom:15px;">
                                        <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                                            <label style="margin-bottom:10px;">No. Part</label><br>
                                            <label style="margin-bottom:10px;">Back No</label><br>
                                            <label style="margin-bottom:10px;">Supplier</label><br>
                                            <label style="margin-bottom:10px;">Storage</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                            <label style="margin-bottom:10px;">:</label><br>
                                            <label style="margin-bottom:10px;">:</label><br>
                                            <label style="margin-bottom:10px;">:</label><br>
                                            <label style="margin-bottom:10px;">:</label><br>
                                        </div>
                                        <div class= "col-sm-2" style="margin-left:0px;" >
                                            <form  method="post" action="" >
                                                <div class="form-group" style="margin-bottom:0px">
                                                    <input class="form-control" id ="idsupply" name="idsupply" style="height:25px;width:200px;" autofocus="autofocus" >
                                                </div>
                                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                    <input type="text" name="backno3" id="backno3"  style="background-color:#bfbfbf;height:25px;width:200px;" readonly="readonly">
                                                </div>
                                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                    <select class="form-control" name="sid3" id="sid3" style="height:28px;width:200px;margin-bottom:5px" >
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                                    <input type="text" name="stor3" id="stor3" style="background-color:#bfbfbf;height:28px;width:200px;margin-bottom:5px;"readonly="readonly">

                                                </div>  
                                        </div>
                                        <div class="col-sm-3" style="margin-left:30px;">
                                            <input type="text" name="pname3" id="pname3" value="" style="background-color:#bfbfbf;width:300px;height:25px;margin-left:30px;margin-bottom:35px;" readonly="readonly">
                                            <input type="text" name="sname3" id="sname3" value="" style="background-color:#bfbfbf;width:300px;height:25px;margin-left:30px;" readonly="readonly">
                                        </div>
                                        <div class="col-sm-2" >
                                            <label style="margin-left:170px;">Side</label>
                                        </div>
                                        <div class="col-sm-2" style="margin-left:0px;">
                                            <div class="form-group">
                                                <input type="text" name="side4" id="side4" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row 2 -->

                                    <!-- baris ke 3 -->
                                    <div class="row" style="margin-left:20px;margin-bottom:10px;">
                                        <div class="col-sm-3">
                                            <label>Qty/Pack</label>
                                            <input type="text" name="qtyperbox4" id="qtyperbox4" style="background-color:#bfbfbf;width:80px;height:25px;margin-left:10px" readonly="readonly"><br>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Jenis Box</label>
                                            <input type="text" name="boxtype4" id="boxtype4" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                                        </div> 
                                        <div class="col-sm-4">
                                            <label>Keterangan </label>
                                            <input type ="textarea" id="keterangan4" name = "keterangan4" readonly="readonly" style="background-color:#bfbfbf;">
                                        </div> 
                                    </div><br>
                                    <!-- end row 3 -->

                                    <!-- baris ke 4 -->     
                                    <div class="row" >
                                        <div class="col-sm-12">
                                            <div class="col-sm-2" style="width:auto;border-left:1px solid;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                <label style="margin-top:15px">Print Qty</label>
                                                <input type="number" id="printqty4" name="printqty4" min="1" max="1000" style="margin-bottom:20px;margin-left:10px;width:50px;height:25px;">
                                            </div>
                                            <div class="col-sm-4" style="width:auto;text-align:left;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                <div class="checkbox" >
                                                    <label><input type="checkbox" id="checkboxA[]" name="checkboxA[]" class="cekcheckbox" value="no">Temporary</label><br>
                                                    <label><input type="checkbox" id="checkboxB[]" name="checkboxB[]" class="cekcheckbox" value="yes">Special Order</label>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2" style="border-top:1px solid;border-bottom:1px solid;height:80px;" ></div>
                                            <div class="col-sm-2" style="padding-top:5px;width:auto;border-top:1px solid;border-bottom:1px solid;height:80px;border-right:1px solid;" >
                                                <label>Last Serial No</label><input type="text" id = "lastserial4" name = "lastserial4" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                                <label>Print Date</label><input id = "printdate4X" name = "printdate4X" type="text" value="" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">
                                                <input  style="display:none;" id = "printdate4" name = "printdate4" type="text" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">
                                            </div> 
                                        </div>         
                                    </div>
                                    <!-- end row 4 -->
                                    <!-- baris ke 5 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                        <div class="col-sm-6">
                                            <button class="btn" id="printsp" name="printsp" value="1" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormSupp()" ><i class="icon-ok icon-white" ></i>PRINT</button>

                        <!-- <input type="submit" id="printsp" name="printsp" class="btn btn-info btn-md" value="PRINT"> -->
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="<?= base_url() ?>index.php/pes/kanban_master/print_kanban" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                                        </div>
                                    </div>
                                    </form>
                                    <!-- end row 5 -->
                                </div>
                                <!-- end tab supply parts -->

                                <!-- begin tab pickup -->
                                <div id="pickup_v" class="tab-pane fade">
                                    <!-- baris ke 1 -->
                                    <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                        <div class="col-sm-2" style="margin-left:0;">
                                            <label>Plant <select><option>600</option></select></label>
                                        </div>      
                                    </div>
                                    <!-- end row 1 -->
                                    <!-- baris ke 2-->
                                    <div class="row"  style="margin-bottom:20px;">
                                        <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                                            <label style="margin-bottom:10px;">No. Part</label><br>
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
                                                <input class="form-control" id ="idpickup" name="idpickup" style="height:25px;width:200px;margin-bottom:5px" autofocus="autofocus" >
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
                                                <div class="col-sm-2" style="width:auto;border-left:1px solid;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                    <label style="margin-top:15px">Print Qty</label>
                                                    <input type="number" name="printqty3" id="printqty3" min="1" max="1000" style="margin-bottom:20px;margin-left:10px;width:50px;height:25px;">
                                                </div>
                                                <div class="col-sm-4" style="width:auto;text-align:left;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                    <div class="checkbox" >
                                                        <label><input type="checkbox" id="checkboxA[]" name="checkboxA[]" class="cekcheckbox" value="no">Temporary</label><br>
                                                        <label><input type="checkbox" id="checkboxB[]" name="checkboxB[]" class="cekcheckbox" value="yes">Special Order</label><br>
                                                        <label><input type="checkbox" id="checkboxC[]" name="checkboxC[]" value="yes">Build Out</label>
                                                    </div>
                                                </div> 
                                                <div class="col-sm-2" style="border-top:1px solid;border-bottom:1px solid;height:80px;" ></div>
                                                <div class="col-sm-2" style="padding-top:5px;width:auto;border-top:1px solid;border-bottom:1px solid;height:80px;border-right:1px solid;" >
                                                    <label>Last Serial No</label><input type="text" id="lastserial3" name="lastserial3" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                                    <label>Last Print Date</label><input name="printdate3X" id="printdate3X" type="text" value="" style="background-color:#bfbfbf;margin-left:5px;width:100px;height:25px;" readonly="readonly">
                                                    <input style="display:none;"  name="printdate3" id="printdate3" type="text" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">
                                                </div> 
                                            </div>         
                                        </div>
                                        <!-- end row 4 -->

                                        <!-- baris ke 5 -->
                                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                            <div class="col-sm-6">
                                                <button class="btn" name="printpu" id="printpu" value="#pickup_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormPick()" ><i class="icon-ok icon-white" ></i>PRINT</button>

                          <!-- <input type="submit" name="printpu" id="printpu" class="btn btn-info btn-md" value="PRINT"> -->
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="<?= base_url() ?>index.php/pes/kanban_master/print_kanban" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                                            </div>
                                        </div>
                                        </form>
                                        <!-- end row 5 -->
                                    </div>
                                    <!-- end tab pickup -->

                                    <!-- begin tab pickup passthrough -->
                                    <div id="pickupp_v" class="tab-pane fade">
                                        <!-- baris ke 1 -->
                                        <div class="row" style="margin-top:10px;margin-bottom:10px" >
                                            <div class="col-sm-2" style="margin-left:0;">
                                                <label>Plant <select><option>600</option></select></label>
                                            </div>      
                                        </div>
                                        <!-- end row 1 -->
                                        <!-- baris ke 2-->
                                        <div class="row"  style="margin-bottom:20px;">
                                            <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                                                <label style="margin-bottom:10px;">No. Part</label><br>
                                                <label style="margin-bottom:10px;">Back No</label><br>
                                                <label style="margin-bottom:10px;">Storage Location From</label><br>
                                                <label style="margin-bottom:10px;">Storage Location To</label><br>
                                            </div>
                                            <div class= "col-sm-1" style="width:auto;margin-left:0px;">
                                                <label style="margin-bottom:10px;">:</label><br>
                                                <label style="margin-bottom:10px;">:</label><br>
                                                <label style="margin-bottom:10px;">:</label><br>
                                                <label style="margin-bottom:10px;">:</label><br>
                                            </div>
                                            <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                                                <form method="post" action="">
                                                    <input class="form-control" id ="idpickupp" name="idpickupp" style="height:25px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                                                    <input type="text" name="back_no3p" id="back_no3p"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                                                    <input class="form-control" name="storself3p" id="storself3p" style="background-color:#bfbfbf;height:28px;margin-bottom:5px" readonly="readonly">
                                                    <select class="form-control" name="stornext3p" id="stornext3p" style="height:28px;margin-bottom:5px" >
                                                        <option></option>
                                                    </select>
                                            </div>
                                            <div class= "col-sm-3" style="width:auto;margin-left:0px;" >
                                                <input type="text" name = "pnamepup" id = "pnamepup" value ="" style="background-color:#bfbfbf;width:250px;height:25px;margin-bottom:35px;" readonly="readonly"></br>
                                            </div>
                                            <div class="col-sm-3" style="margin-left:30px;">
                                                <label>Side</label>
                                                <input type="text" name="side3p" id = "side3p" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                                            </div>
                                        </div>
                                        <!-- end row 2 -->

                                        <!-- baris ke 3 -->
                                        <div class="row" style="margin-bottom:10px;">

                                            <div class="col-sm-3">
                                                <label>Qty/Pack</label
                                                ><input type="text" name="qtyperbox3p" id="qtyperbox3p" style="background-color:#bfbfbf;height:25px;width:80px;margin-left:10px" readonly="readonly";><br>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Jenis Box</label>
                                                <input type="text" name="boxtype3p" id = "boxtype3p" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                                            </div> 
                                            <div>
                                                <label>Keterangan </label>
                                                <input type ="textarea" id="keterangan3p" name = "keterangan3p" readonly="readonly" style="background-color:#bfbfbf;">
                                            </div>   
                                        </div><br>
                                        <!-- end row 3 -->

                                        <!-- baris ke 4 -->     
                                        <div class="row" >
                                            <div class="col-sm-12">
                                                <div class="col-sm-2" style="width:auto;border-left:1px solid;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                    <label style="margin-top:15px">Print Qty</label>
                                                    <input type="text" name="printqty3p" id="printqty3p" style="margin-bottom:20px;margin-left:10px;width:50px;height:25px;">
                                                </div>
                                                <div class="col-sm-4" style="width:auto;text-align:left;border-top:1px solid;border-bottom:1px solid;height:80px">
                                                    <div class="checkbox" >
                                                        <label><input type="checkbox" id="checkboxA[]" name="checkboxA[]" class="cekcheckbox" value="no">Temporary</label><br>
                                                        <label><input type="checkbox" id="checkboxB[]" name="checkboxB[]" class="cekcheckbox" value="yes">Special Order</label>
                                                    </div>
                                                </div> 
                                                <div class="col-sm-2" style="border-top:1px solid;border-bottom:1px solid;height:80px;" ></div>
                                                <div class="col-sm-2" style="padding-top:5px;width:auto;border-top:1px solid;border-bottom:1px solid;height:80px;border-right:1px solid;" >
                                                    <label>Last Serial No</label><input type="text" id="lastserial3p" name="lastserial3p" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                                    <label>Last Print Date</label><input name="printdate3pX" id="printdate3pX" type="text" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:5px;width:100px;height:25px;" readonly="readonly">
                                                    <input style="display:none;" name="printdate3p" id="printdate3p" type="text" value="<?php echo date("Y-m-d") ?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">
                                                </div> 
                                            </div>         
                                        </div>
                                        <!-- end row 4 -->
                                        <!-- baris ke 5 -->
                                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                            <div class="col-sm-6">
                                                <button class="btn" name="printpup" id="printpup" value="#pickupp_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormPass()" ><i class="icon-ok icon-white" ></i>PRINT</button>                        
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="<?= base_url() ?>index.php/pes/kanban_master/print_kanban" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                                            </div>
                                        </div>
                                        </form>
                                        <!-- end row 5 -->
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




