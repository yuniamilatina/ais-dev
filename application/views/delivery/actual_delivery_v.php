<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });

    $(document).ready(function () {
        var date = new Date();

        $("#datepicker3").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });

    $(document).ready(function () {
        $('#month').change(function () {
            search_data_by_period();
        });

        $('#datepicker2').change(function () {
            search_data_by_date();
        });

        $('#datepicker3').change(function () {
            search_data_by_date();
        });

        $('#filter_cus').change(function () {
            var start_date = $('#datepicker2').val();
            var end_date = $('#datepicker3').val();
            var period = $('#month').val();

            if (document.getElementById("status_radio").value === 'date') {
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'false') {
                    var cust = $('#filter_cus').val();
                    var ship = '';

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                type: 'POST',
                                data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });

                            //if ($('#po_check').val() === 'true'){}
                            //if ($('#po_check').val() === 'false'){ }

                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'true') {
                    var cust = $('#filter_cus').val();
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                type: 'POST',
                                data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
            } else {
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'false') {
                    var cust = $('#filter_cus').val();
                    var ship = '';

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po_by_period'); ?>",
                        type: 'POST',
                        data: {period: period, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust_by_period'); ?>",
                                type: 'POST',
                                data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'true') {
                    var cust = $('#filter_cus').val();
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                type: 'POST',
                                data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
            }

        });

        $('#filter_ship').change(function () {
            var start_date = $('#datepicker2').val();
            var end_date = $('#datepicker3').val();
            var period = $('#month').val();

            if (document.getElementById("status_radio").value === 'date') {
                if ($('#cust_check').val() === 'false' && $('#cust_dest_check').val() === 'true') {
                    var cust = '';
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                type: 'POST',
                                data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'true') {
                    var cust = $('#filter_cus').val();
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                type: 'POST',
                                data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
            } else {
                if ($('#cust_check').val() === 'false' && $('#cust_dest_check').val() === 'true') {
                    var cust = '';
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po_by_period'); ?>",
                        type: 'POST',
                        data: {period: period, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust_by_period'); ?>",
                                type: 'POST',
                                data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'true') {
                    var cust = $('#filter_cus').val();
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                        type: 'POST',
                        data: {period: period, cust: cust, ship: ship},
                        success: function (data_cus_po) {
                            $("#filter_cus_po").html(data_cus_po);
                            var cus_po = $("#filter_cus_po").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                type: 'POST',
                                data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                                success: function (data_cus_part_no) {
                                    $("#filter_part_no_cust").html(data_cus_part_no);
                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
            }

        });

        $('#filter_cus_po').change(function () {
            var start_date = $('#datepicker2').val();
            var end_date = $('#datepicker3').val();
            var period = $('#month').val();
            var cus_po = $('#filter_cus_po').val();

            if (document.getElementById("status_radio").value === 'date') {
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'false') {
                    var cust = $('#filter_cus').val();
                    var ship = '';

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                        success: function (data_cus_part_no) {
                            $("#filter_part_no_cust").html(data_cus_part_no);
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'false' && $('#cust_dest_check').val() === 'true') {
                    var cust = '';
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                        success: function (data_cus_part_no) {
                            $("#filter_part_no_cust").html(data_cus_part_no);
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'true') {
                    var cust = $('#filter_cus').val();
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                        success: function (data_cus_part_no) {
                            $("#filter_part_no_cust").html(data_cus_part_no);
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }

            } else {

                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'false') {
                    var cust = $('#filter_cus').val();
                    var ship = '';

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust_by_period'); ?>",
                        type: 'POST',
                        data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                        success: function (data_cus_part_no) {
                            $("#filter_part_no_cust").html(data_cus_part_no);
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'false' && $('#cust_dest_check').val() === 'true') {
                    var cust = '';
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust_by_period'); ?>",
                        type: 'POST',
                        data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                        success: function (data_cus_part_no) {
                            $("#filter_part_no_cust").html(data_cus_part_no);
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }
                if ($('#cust_check').val() === 'true' && $('#cust_dest_check').val() === 'true') {
                    var cust = $('#filter_cus').val();
                    var ship = $('#filter_ship').val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust_by_period'); ?>",
                        type: 'POST',
                        data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                        success: function (data_cus_part_no) {
                            $("#filter_part_no_cust").html(data_cus_part_no);
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
                }

            }
        });

        function search_data_by_period() {
            var period = $('#month').val();

            $.ajax({
                url: "<?php echo site_url('delivery/delivery_c/update_filter_cust_by_period'); ?>",
                type: 'POST',
                data: {period: period},
                success: function (data_cust) {
                    $("#filter_cus").html(data_cust);
                    var cust = $("#filter_cus").val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cust_dest_by_period'); ?>",
                        type: 'POST',
                        data: {period: period},
                        success: function (data_ship) {
                            $("#filter_ship").html(data_ship);
                            var ship = $("#filter_ship").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po_by_period'); ?>",
                                type: 'POST',
                                data: {period: period, cust: cust, ship: ship},
                                success: function (data_cus_po) {
                                    $("#filter_cus_po").html(data_cus_po);
                                    var cus_po = $("#filter_cus_po").val();

                                    $.ajax({
                                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust_by_period'); ?>",
                                        type: 'POST',
                                        data: {period: period, cust: cust, ship: ship, cus_po: cus_po},
                                        success: function (data_cus_part_no) {
                                            $("#filter_part_no_cust").html(data_cus_part_no);
                                        },
                                        error: function (request) {
                                            alert(request.responseText);
                                        }
                                    });

                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });

                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });

                },
                error: function (request) {
                    alert(request.responseText);
                }
            });
        }

        function search_data_by_date() {
            var start_date = $('#datepicker2').val();
            var end_date = $('#datepicker3').val();

            $.ajax({
                url: "<?php echo site_url('delivery/delivery_c/update_filter_cust'); ?>",
                type: 'POST',
                data: {end_date: end_date, start_date: start_date},
                success: function (data_cust) {
                    $("#filter_cus").html(data_cust);
                    var cust = $("#filter_cus").val();

                    $.ajax({
                        url: "<?php echo site_url('delivery/delivery_c/update_filter_cust_dest'); ?>",
                        type: 'POST',
                        data: {end_date: end_date, start_date: start_date},
                        success: function (data_ship) {
                            $("#filter_ship").html(data_ship);
                            var ship = $("#filter_ship").val();

                            $.ajax({
                                url: "<?php echo site_url('delivery/delivery_c/update_filter_cus_po'); ?>",
                                type: 'POST',
                                data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship},
                                success: function (data_cus_po) {
                                    $("#filter_cus_po").html(data_cus_po);
                                    var cus_po = $("#filter_cus_po").val();

                                    $.ajax({
                                        url: "<?php echo site_url('delivery/delivery_c/update_filter_part_no_cust'); ?>",
                                        type: 'POST',
                                        data: {end_date: end_date, start_date: start_date, cust: cust, ship: ship, cus_po: cus_po},
                                        success: function (data_cus_part_no) {
                                            $("#filter_part_no_cust").html(data_cus_part_no);
                                        },
                                        error: function (request) {
                                            alert(request.responseText);
                                        }
                                    });

                                },
                                error: function (request) {
                                    alert(request.responseText);
                                }
                            });

                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });

                },
                error: function (request) {
                    alert(request.responseText);
                }
            });
        }

    });
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        font-size: 11px;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl3{
        width: 200px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT ACTUAL DELIVERY PART</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <!--GRID TO DISPLAY GRID TABLE SCAN-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"> <strong>REPORT ACTUAL DELIVERY PART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip"  title="Collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('delivery/delivery_c/search_actual_delivery', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">
                                        <input type="radio" id="radio_period" name="CHR_PERIOD_RADIO" <?php echo $radio_period_status; ?> onclick = "clearBoxMonth()" />
                                        Permonth
                                    </td>
                                    <td width="10%" >                                        
                                        <select class="form-control" name="CHR_PERIOD" <?php echo $period_picker; ?> id="month" style="width:100px;" >
                                            <?php for ($x = -10; $x <= 0; $x++) { ?>
                                                <option value="<?php echo date("m-Y", strtotime("+$x month")) ?>" <?php
                                                if ($period == date("m-Y", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("m-Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="50%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">

                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"><input type="radio" id="radio_date" name="CHR_PERIOD_RADIO"  <?php echo $radio_date_status; ?> onclick = "clearBoxPeriod()" />
                                        Period From
                                    </td>
                                    <td width="10%">                                        
                                        <input name="CHR_START_PERIOD" id="datepicker2" <?php echo $start_date_picker; ?> class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $start_date; ?>">
                                    </td>
                                    <td width="10%">Until
                                    </td>
                                    <td width="50%">
                                        <input name="CHR_END_PERIOD" id="datepicker3" <?php echo $end_date_picker; ?> class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $finish_date; ?>">
                                    </td>
                                    <td width="10%">
                                        <input type="hidden" name="INT_FLG_STATUS_RADIO" id="status_radio" value="<?php echo $value_status_radio; ?>">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"><input type="checkbox" id="cust_check" name="CHR_CUSTOMER_CHECK" value="<?php echo $customer_value; ?>" <?php echo $customer_check; ?> onchange="check_box_dest(this)">
                                        Customer
                                    </td>
                                    <td width="10%">   
                                        <select name="CHR_CUS_NO" class="ddl3" id="filter_cus" <?php echo $customer_status; ?>  style="width:300px;background:#EEEEEE;">
                                            <?php foreach ($all_customer as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_CUST_NO) ?>" <?php
                                                if (trim($customer) == trim($row->CHR_CUST_NO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_CUST_NAME); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%"><input type="checkbox" id="cust_dest_check" name="CHR_CUST_DEST_CHECK" value="<?php echo $cust_dest_value; ?>" <?php echo $custdest_check; ?> onchange="check_box_dest2(this)">
                                        Ship To
                                    </td>
                                    <td width="50%">
                                        <select name="CHR_SHIP_NO" class="ddl3" id="filter_ship" <?php echo $custdest_status; ?> style="width:300px;background:#EEEEEE;">
                                            <?php foreach ($all_cust_dest as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_CUST_NO) ?>" <?php
                                                if (trim($cus_dest) == trim($row->CHR_CUST_NO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_CUST_NAME); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">
                                        <input type="checkbox" id="po_check" name="CHR_PO_NO_CHECK" <?php echo $po_check; ?> value="<?php echo $po_value; ?>" onchange="check_box_po_cust(this)">
                                        PO Customer Number
                                    </td>
                                    <td width="10%">   
                                        <select name="CHR_PO_NO" id="filter_cus_po" class="ddl3" <?php echo $po_status; ?> style="width:200px;background:#EEEEEE;">
                                            <?php foreach ($all_cust_po as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_PO_NO) ?>" <?php
                                                if (trim($cust_po) == trim($row->CHR_PO_NO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_PO_NO); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="50%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"><input type="checkbox"  id="check_part_no" name="CHR_CUST_PART_NO_CHECK" <?php echo $part_no_check; ?> value="<?php echo $part_no_value; ?>" onchange="check_box_part_no_cust(this)">
                                        Part Number Customer 
                                    </td>
                                    <td width="10%">   
                                        <select name="CHR_CUST_PART_NO" class="ddl3" id="filter_part_no_cust" <?php echo $part_no_status; ?> style="width:200px;background:#EEEEEE;">
                                            <?php foreach ($all_part_no_cust as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_CUST_PART_NO) ?>" <?php
                                                if (trim($part_no_cust) == trim($row->CHR_CUST_PART_NO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_CUST_PART_NO); ?></option>
                                                    <?php } ?>
                                        </select>
                                        <button type="submit" style="margin-top:2px;" name="btn_filter" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-filter"></i> Filter</button>
                                        <?php echo form_close() ?>
                                    </td>
                                    <td width="10%">

                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                        <?php echo form_open('delivery/delivery_c/print_actual_delivery', 'class="form-horizontal"'); ?>
                                        <input type="hidden" name="CHR_PERIOD_EXCEL" id="status_radio_excel" value="<?php echo $period; ?>">
                                        <input type="hidden" name="CHR_START_PERIOD_EXCEL" id="status_radio_excel" value="<?php echo $start_date; ?>">
                                        <input type="hidden" name="CHR_END_PERIOD_EXCEL" id="status_radio_excel" value="<?php echo $finish_date; ?>">
                                        <input type="hidden" name="CHR_CUS_NO_EXCEL" id="status_radio_excel" value="<?php echo $customer; ?>">
                                        <input type="hidden" name="CHR_SHIP_NO_EXCEL" id="status_radio_excel" value="<?php echo $cus_dest; ?>">
                                        <input type="hidden" name="CHR_PO_NO_EXCEL" id="status_radio_excel" value="<?php echo $cust_po; ?>">
                                        <input type="hidden" name="CHR_CUST_PART_NO_EXCEL" id="status_radio_excel" value="<?php echo $part_no_cust; ?>">
                                        <input type="hidden" name="INT_FLG_STATUS_RADIO_EXCEL" id="status_radio_excel" value="<?php echo $value_status_radio; ?>">
                                        <button type="submit" style="margin-top:2px;" name="btn_submit" value="1" class="btn btn-success" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php echo form_close() ?>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No. </th>
                                        <th style="text-align:center;">PO. No. </th>
                                        <th style="text-align:center;">Delivery No. </th>
                                        <th style="text-align:center;">PDS No.</th>
                                        <th style="text-align:center;">Cust. Code</th>
                                        <th style="text-align:center;">Cust. Desc.</th> 
                                        <th style="text-align:center;">Ship To </th>
                                        <th style="text-align:center;">Ship Desc </th>
                                        <th style="text-align:center;">Dock </th>
                                        <th style="text-align:center;">Delivery Date </th>
                                        <th style="text-align:center;">Part No. Aisin </th>
                                        <th style="text-align:center;">Part No. Cust. </th>
                                        <th style="text-align:center;">Part Name </th>
                                        <th style="text-align:center;">Qty Delivery </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_delivery as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PO_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_DEL_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PDS_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CUS_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CUST_NAME</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CUS_DEST</td>";
                                        echo "<td style=text-align:center;>$isi->CUST_DEST_NAME</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_DOK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_DEL_DATE_ACT</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_CUST_PART_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACTUAL_DEL</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>

<script type="text/javascript">
    function clearBoxMonth() {
        document.getElementById("month").disabled = false;
        document.getElementById("datepicker2").disabled = true;
        document.getElementById("datepicker3").disabled = true;
        $('#status_radio').val('period');
    }

    function clearBoxPeriod() {
        document.getElementById("month").disabled = true;
        document.getElementById("datepicker2").disabled = false;
        document.getElementById("datepicker3").disabled = false;
        $('#status_radio').val('date');
    }

    function check_box_dest(checkboxElem) {
        if (checkboxElem.checked) {
            document.getElementById("filter_cus").disabled = false;
            $("#filter_cus").css('background', '#FFFFFF');
            $("#cust_check").val('true');
        } else {
            document.getElementById("filter_cus").disabled = true;
            $("#filter_cus").css('background', '#EEEEEE');
            $("#cust_check").val('false');
        }
    }

    function check_box_dest2(checkboxElem) {
        if (checkboxElem.checked) {
            document.getElementById("filter_ship").disabled = false;
            $("#filter_ship").css('background', '#FFFFFF');
            $("#cust_dest_check").val('true');
        } else {
            document.getElementById("filter_ship").disabled = true;
            $("#filter_ship").css('background', '#EEEEEE');
            $("#cust_dest_check").val('false');
        }
    }

    function check_box_po_cust(checkboxElem) {
        if (checkboxElem.checked) {
            document.getElementById("filter_cus_po").disabled = false;
            $("#filter_cus_po").css('background', '#FFFFFF');
            $("#po_check").val('true');
        } else {
            document.getElementById("filter_cus_po").disabled = true;
            $("#filter_cus_po").css('background', '#EEEEEE');
            $("#po_check").val('false');
        }
    }

    function check_box_part_no_cust(checkboxElem) {
        if (checkboxElem.checked) {
            document.getElementById("filter_part_no_cust").disabled = false;
            $("#filter_part_no_cust").css('background', '#FFFFFF');
            $("#check_part_no").val('true');
        } else {
            document.getElementById("filter_part_no_cust").disabled = true;
            $("#filter_part_no_cust").css('background', '#EEEEEE');
            $("#check_part_no").val('false');
        }
    }
</script>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 4
            }
        });
    });
</script>
