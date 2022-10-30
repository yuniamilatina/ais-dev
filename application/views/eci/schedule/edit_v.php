<script>
    /*
     $(document).ready(function() {
     
     var myVar = setInterval(function() {
     $("#hide-sub-menus").click();
     clearInterval(myVar)
     }, 0.5);
     $('#save-header').click(function() {
     var stat_required = 0;
     var eci_name = $("#eci_name").val();
     var category_h = $("#category_h").val();
     var category_val = $("#category_h option:selected").text();
     var customer = $("#customer").val();
     var content_eci = $("#content_eci").val();
     var start_date = $("#datepicker").val();
     var receive_date = $("#datepicker1").val();
     var due_date = $("#datepicker2").val();
     var cust_shipping_date = $("#datepicker3").val();
     var implementing_date = $("#datepicker4").val();
     var fg_partname = $("#fg_partname").val();
     var vehicle = $("#vehicle").val();
     if (eci_name == '') {
     alert('ECI No Required');
     $("#eci_name").focus();
     }
     else if (category_h == '') {
     alert('Category Required');
     $("#category_h").focus();
     }
     else if (customer == '') {
     alert('Customer Required');
     $("#customer").focus();
     }
     else if (content_eci == '') {
     alert('Content ECI Required');
     $("#content_eci").focus();
     
     }
     else if (start_date == '') {
     alert('Start Date Required');
     $("#datepicker").focus();
     }
     else if (receive_date == '') {
     alert('Receive Date Required');
     $("#datepicker1").focus();
     }
     else if (due_date == '') {
     alert('Due Date Required');
     $("#datepicker2").focus();
     }
     else if (cust_shipping_date == '') {
     alert('Cust Shipping Date Required');
     $("#datepicker3").focus();
     }
     else if (implementing_date == '') {
     alert('Implementing Date Required');
     $("#datepicker4").focus();
     }
     else if (fg_partname == '') {
     alert('FG Part Name Required');
     $("#fg_partname").focus();
     }
     else if (vehicle == '') {
     alert('Vehicle Required');
     $("#vehicle").focus();
     }
     else {
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/saveHeaderECI'); ?>",
     data: "category_h=" + category_h + "&customer=" + customer + "&content_eci=" + content_eci + "&start_date=" + start_date + "&receive_date=" + receive_date + "&due_date=" + due_date + "&cust_shipping_date=" + cust_shipping_date + "&implementing_date=" + implementing_date + "&eci_name=" + eci_name + "&category_val=" + category_val + "&fg_partname=" + fg_partname + "&vehicle=" + vehicle,
     success: function(data) {
     $("#id-eci").html(data);
     //                    $("#category_h").attr("readonly", "true");
     //                    $("#customer").attr("readonly", "true");
     //                    $("#content_eci").attr("readonly", "true");
     //                    $("#datepicker").attr("readonly", "true");
     //                    $("#datepicker1").attr("readonly", "true");
     //                    $("#datepicker2").attr("readonly", "true");
     //                    $("#datepicker3").attr("readonly", "true");
     //                    $("#datepicker4").attr("readonly", "true");
     $("#collapse-header").click();
     $("#eci_name").css("readonly", "true");
     $("#save-header").css("display", "none");
     $("#cancel-header").css("display", "none");
     $("#update-header").css("display", "true");
     $("#create_line").css("display", "true");
     $("#btn-publish").css("display", "true");
     $("#stat-create").css("display", "none");
     $("#stat-create2").css("font-weight", "bold");
     }
     });
     //            }
     });
     $('#update-header').click(function() {
     var stat_required = 0;
     var eci_name = $("#eci_name").val();
     var category_h = $("#category_h").val();
     var category_val = $("#category_h option:selected").text();
     var customer = $("#customer").val();
     var content_eci = $("#content_eci").val();
     var start_date = $("#datepicker").val();
     var receive_date = $("#datepicker1").val();
     var due_date = $("#datepicker2").val();
     var cust_shipping_date = $("#datepicker3").val();
     var implementing_date = $("#datepicker4").val();
     var id_eci = $("#id-eci").text();
     var fg_partname = $("#fg_partname").val();
     var vehicle = $("#vehicle").val();
     if (eci_name == '') {
     alert('ECI No Required');
     $("#eci_name").focus();
     }
     else if (category_h == '') {
     alert('Category Required');
     $("#category_h").focus();
     }
     else if (customer == '') {
     alert('Customer Required');
     $("#customer").focus();
     }
     else if (content_eci == '') {
     alert('Content ECI Required');
     $("#content_eci").focus();
     }
     else if (start_date == '') {
     alert('Start Date Required');
     $("#datepicker").focus();
     }
     else if (receive_date == '') {
     alert('Receive Date Required');
     $("#datepicker1").focus();
     }
     else if (due_date == '') {
     alert('Due Date Required');
     $("#datepicker2").focus();
     }
     else if (cust_shipping_date == '') {
     alert('Cust Shipping Date Required');
     $("#datepicker3").focus();
     }
     else if (implementing_date == '') {
     alert('Implementing Date Required');
     $("#datepicker4").focus();
     } else {
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/updateHeaderECI'); ?>",
     data: "category_h=" + category_h + "&customer=" + customer + "&content_eci=" + content_eci + "&start_date=" + start_date + "&receive_date=" + receive_date + "&due_date=" + due_date + "&cust_shipping_date=" + cust_shipping_date + "&implementing_date=" + implementing_date + "&eci_name=" + eci_name + "&category_val=" + category_val + "&id_eci=" + id_eci + "&fg_partname=" + fg_partname + "&vehicle=" + vehicle,
     success: function(data) {
     $("#table-list-activity").html(data);
     }
     });
     }
     });
     $('#activity_name').change(function() {
     var id_activity = $("#activity_name").val();
     var name_activity = $("#activity_name option:selected").text();
     //            $("#collapse-header").click();
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/getDetailAct'); ?>",
     data: "id_activity=" + id_activity + "&name_activity=" + name_activity,
     success: function(data) {
     $("#detail_activity").html(data);
     //                    $("#collapse-header").click();
     }
     });
     });
     $('#add-line').click(function() {
     var id_eci = $("#id-eci").text();
     var id_activity = $("#activity_name").val();
     var name_activity = $("#activity_name option:selected").text();
     var duration = $("#duration").val();
     var start_date = $("#datepicker").val();
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/addActivity'); ?>",
     data: "id_activity=" + id_activity + "&name_activity=" + name_activity + "&id_eci=" + id_eci + "&duration=" + duration + "&start_date=" + start_date,
     success: function(data) {
     $("#table-list-activity").html(data);
     }
     });
     });
     $('#delete_activity').click(function() {
     var id_eci = $("#id-eci").text();
     var id_activity = $("#id_del_activity").val();
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/delete_activity'); ?>",
     data: "id_activity=" + id_activity + "&id_eci=" + id_eci,
     success: function(data) {
     $("#table-list-activity").html(data);
     }
     });
     });
     $('#btn-publish').click(function() {
     var id_eci = $("#id-eci").text();
     var id_activity = $("#id_del_activity").val();
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/publish'); ?>",
     data: "id_activity=" + id_activity + "&id_eci=" + id_eci,
     success: function(data) {
     $("#published").css("display", "true");
     $("#btn-publish").css("display", "none");
     }
     });
     });
     $('#btn-refresh').click(function() {
     var id_eci = $("#id-eci").text();
     $.ajax({
     async: false,
     type: "POST",
     url: "<?php echo site_url('eci/schedule_c/refresh'); ?>",
     data: "id_eci=" + id_eci,
     success: function(data) {
     $("#table-list-activity").html(data);
     }
     });
     });
     $('#btn-refresh').click();
     });*/



    $(document).ready(function() {


        var myVar = setInterval(function() {
            $("#hide-sub-menus").click();
            clearInterval(myVar)
        }, 0.5);
        $('#save-header').click(function() {
            var stat_required = 0;
            var eci_name = $("#eci_name").val();
            var category_h = $("#category_h").val();
            var category_val = $("#category_h option:selected").text();
            var customer = $("#customer").val();
            var content_eci = $("#content_eci").val();
            var start_date = $("#datepicker").val();
            var receive_date = $("#datepicker1").val();
            var due_date = $("#datepicker2").val();
            var cust_shipping_date = $("#datepicker3").val();
            var implementing_date = $("#datepicker4").val();
            var fg_partname = $("#fg_partname").val();
            var vehicle = $("#vehicle").val();
            if (eci_name == '') {
                alert('ECI No Required');
                $("#eci_name").focus();
            }
            else if (category_h == '') {
                alert('Category Required');
                $("#category_h").focus();
            }
            else if (customer == '') {
                alert('Customer Required');
                $("#customer").focus();
            }
            else if (content_eci == '') {
                alert('Content ECI Required');
                $("#content_eci").focus();

            }
            else if (start_date == '') {
                alert('Start Date Required');
                $("#datepicker").focus();
            }
            else if (receive_date == '') {
                alert('Receive Date Required');
                $("#datepicker1").focus();
            }
            else if (due_date == '') {
                alert('Due Date Required');
                $("#datepicker2").focus();
            }
            else if (cust_shipping_date == '') {
                alert('Cust Shipping Date Required');
                $("#datepicker3").focus();
            }
            else if (implementing_date == '') {
                alert('Implementing Date Required');
                $("#datepicker4").focus();
            }
            else if (fg_partname == '') {
                alert('FG Part Name Required');
                $("#fg_partname").focus();
            }
            else if (vehicle == '') {
                alert('Vehicle Required');
                $("#vehicle").focus();
            }
            else {
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/schedule_c/saveHeaderECI'); ?>",
                    data: "category_h=" + category_h + "&customer=" + customer + "&content_eci=" + content_eci + "&start_date=" + start_date + "&receive_date=" + receive_date + "&due_date=" + due_date + "&cust_shipping_date=" + cust_shipping_date + "&implementing_date=" + implementing_date + "&eci_name=" + eci_name + "&category_val=" + category_val + "&fg_partname=" + fg_partname + "&vehicle=" + vehicle,
                    success: function(data) {
                        var statECI = data;
                        statECI = statECI.toString();
                        statECI = statECI.trim();
//                        if (statECI == "0") {
//                            // $("#id-eci").html(data);
//                            alert("NO ECI yang Anda masukkan sudah ada pada database ECI, silahkan cek table list ECI");
//                        } else {
                            $("#id-eci").html(data);
                            $("#collapse-header").click();
                            $("#eci_name").css("readonly", "true");
                            $("#save-header").css("display", "none");
                            $("#cancel-header").css("display", "none");
                            $("#update-header").css("display", "true");
                            $("#create_line").css("display", "true");
                            $("#btn-publish").css("display", "true");
                            $("#stat-create").css("display", "none");
                            $("#stat-create2").css("font-weight", "bold");
//                        }
                    }
                });
            }
        });
        $('#update-header').click(function() {
            var stat_required = 0;
            var eci_name = $("#eci_name").val();
            var category_h = $("#category_h").val();
            var category_val = $("#category_h option:selected").text();
            var customer = $("#customer").val();
            var content_eci = $("#content_eci").val();
            var start_date = $("#datepicker").val();
            var receive_date = $("#datepicker1").val();
            var due_date = $("#datepicker2").val();
            var cust_shipping_date = $("#datepicker3").val();
            var implementing_date = $("#datepicker4").val();
            var id_eci = $("#id-eci").text();
            var fg_partname = $("#fg_partname").val();
            var vehicle = $("#vehicle").val();
            if (eci_name == '') {
                alert('ECI No Required');
                $("#eci_name").focus();
            }
            else if (category_h == '') {
                alert('Category Required');
                $("#category_h").focus();
            }
            else if (customer == '') {
                alert('Customer Required');
                $("#customer").focus();
            }
            else if (content_eci == '') {
                alert('Content ECI Required');
                $("#content_eci").focus();
            }
            else if (start_date == '') {
                alert('Start Date Required');
                $("#datepicker").focus();
            }
            else if (receive_date == '') {
                alert('Receive Date Required');
                $("#datepicker1").focus();
            }
            else if (due_date == '') {
                alert('Due Date Required');
                $("#datepicker2").focus();
            }
            else if (cust_shipping_date == '') {
                alert('Cust Shipping Date Required');
                $("#datepicker3").focus();
            }
            else if (implementing_date == '') {
                alert('Implementing Date Required');
                $("#datepicker4").focus();
            } else {
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?php echo site_url('eci/schedule_c/updateHeaderECI'); ?>",
                    data: "category_h=" + category_h + "&customer=" + customer + "&content_eci=" + content_eci + "&start_date=" + start_date + "&receive_date=" + receive_date + "&due_date=" + due_date + "&cust_shipping_date=" + cust_shipping_date + "&implementing_date=" + implementing_date + "&eci_name=" + eci_name + "&category_val=" + category_val + "&id_eci=" + id_eci + "&fg_partname=" + fg_partname + "&vehicle=" + vehicle,
                    success: function(data) {
                         alert("Updated Sucess");
                        $("#table-list-activity").html(data);
                    }
                });
            }
        });
        $('#activity_name').change(function() {
            var id_activity = $("#activity_name").val();
            var name_activity = $("#activity_name option:selected").text();
//            $("#collapse-header").click();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/getDetailAct'); ?>",
                data: "id_activity=" + id_activity + "&name_activity=" + name_activity,
                success: function(data) {
                    $("#detail_activity").html(data);
//                    $("#collapse-header").click();
                }
            });
        });

        $('#add-line').click(function() {
            var id_eci = $("#id-eci").text();
            var id_activity = $("#activity_name").val();
            var name_activity = $("#activity_name option:selected").text();
            var duration = $("#duration").val();
            var start_date = $("#datepicker").val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/addActivity'); ?>",
                data: "id_activity=" + id_activity + "&name_activity=" + name_activity + "&id_eci=" + id_eci + "&duration=" + duration + "&start_date=" + start_date,
                success: function(data) {
                    $("#table-list-activity").html(data);
                }
            });
        });
        $('#delete_activity').click(function() {
            var id_eci = $("#id-eci").text();
            var id_activity = $("#id_del_activity").val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/delete_activity'); ?>",
                data: "id_activity=" + id_activity + "&id_eci=" + id_eci,
                success: function(data) {
                    $("#table-list-activity").html(data);
                }
            });
        });
        $('#btn-publish').click(function() {
            var id_eci = $("#id-eci").text();
            var id_activity = $("#id_del_activity").val();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/publish'); ?>",
                data: "id_activity=" + id_activity + "&id_eci=" + id_eci,
                success: function(data) {
                    $("#published").css("display", "true");
                    $("#btn-publish").css("display", "none");
                }
            });
        });
        $('#btn-refresh').click(function() {
            var id_eci = $("#id-eci").text();
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('eci/schedule_c/refresh'); ?>",
                data: "id_eci=" + id_eci,
                success: function(data) {
                    $("#table-list-activity").html(data);
                }
            });
        });

        $('#btn-refresh').click();

    });







</script>

<script>
    function deleteThis(value) {
        document.getElementById("id_del_activity").value = value;
        document.getElementById("delete_activity").click();
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/portal/calendar_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>EDIT ECI </strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT</strong> ECI </span><span id="id-eci"><?php echo $data_eci[0]->CHR_ID_ECI; ?></span>
                        <div class="pull-right grid-tools">
                            <div id="btn-publish" style="display:none;" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Publish ECI"><i class="fa fa-upload"></i> Publish</div>
                            <div id="published" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Published"> Published</div>
                            <a href="<?php echo site_url("eci/schedule_c/list_eci") ?>"><div id="back-to-list" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-danger" data-placement="right" data-toggle="tooltip" title="Published"> Published</div></a>
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('eci/schedule_c/new_entry', 'class="form-horizontal"'); ?>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" >ECI Name</label>
                            <div class="col-sm-3">
                                <input autofocus name="eci_name" autocomplete="off" id="eci_name" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data_eci[0]->CHR_NAME; ?>">
                            </div>

                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-3">
                                <select  name="category_h" id="category_h" required class="form-control" style="width:250px">
                                    <?php
                                    foreach ($get_cat as $cat_list) {
                                        ?>
                                        <option value="<?php echo $cat_list->INT_ID_CATEGORY; ?>" <?php
                                        if ($cat_list->INT_ID_CATEGORY == $data_eci[0]->ID_CATEGORY) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $cat_list->CHR_CATEGORY_NAME; ?></option>
                                                <?php
                                            }
                                            ?> 
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Customer</label>
                            <div class="col-sm-3">
                                <input name="customer" autocomplete="off" id="customer" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data_eci[0]->CHR_CUSTOMER; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">FG Part Name</label>
                            <div class="col-sm-3">   
                                <input name="content_eci" autocomplete="off" id="fg_partname" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data_eci[0]->CHR_FG_PARTNAME; ?>">
                            </div>
                            <label class="col-sm-2 control-label">Vehicle</label>
                            <div class="col-sm-3">
                                <input name="content_eci" autocomplete="off" id="vehicle" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="<?php echo $data_eci[0]->CHR_VEHICLE; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contents</label>
                            <div class="col-sm-3">   
                                <input name="content_eci" autocomplete="off" id="content_eci" class="form-control" style="width:250px" maxlength="50" required type="text" value="<?php echo $data_eci[0]->CHR_CONTENT; ?>">
                            </div>
                            <label class="col-sm-2 control-label">Start Date</label>
                            <div class="col-sm-3">
                                <input name="CHR_DATE" id="datepicker" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;"  value="<?php echo substr($data_eci[0]->CHR_START_DATE, 4, 2) . '/' . substr($data_eci[0]->CHR_START_DATE, 6, 2) . '/' . substr($data_eci[0]->CHR_START_DATE, 0, 4); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Receive Date</label>
                            <div class="col-sm-3">
                                <input name="CHR_DATE" id="datepicker1" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;"  value="<?php echo substr($data_eci[0]->CHR_RECEIVE_DATE, 4, 2) . '/' . substr($data_eci[0]->CHR_RECEIVE_DATE, 6, 2) . '/' . substr($data_eci[0]->CHR_RECEIVE_DATE, 0, 4); ?>">

                            </div>
                            <label class="col-sm-2 control-label">Request Due Date</label>
                            <div class="col-sm-3">
                                <input name="CHR_DATE" id="datepicker2" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;"  value="<?php echo substr($data_eci[0]->CHR_DUE_DATE, 4, 2) . '/' . substr($data_eci[0]->CHR_DUE_DATE, 6, 2) . '/' . substr($data_eci[0]->CHR_DUE_DATE, 0, 4); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cust Shipping Date</label>
                            <div class="col-sm-3">
                                <input name="CHR_DATE" id="datepicker3" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;"  value="<?php echo substr($data_eci[0]->CHR_SHIPPING_DATE, 4, 2) . '/' . substr($data_eci[0]->CHR_SHIPPING_DATE, 6, 2) . '/' . substr($data_eci[0]->CHR_SHIPPING_DATE, 0, 4); ?>">
                            </div>
                            <label class="col-sm-2 control-label">Implementing Date</label>
                            <div class="col-sm-3">
                                <input name="CHR_DATE" id="datepicker4" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;"  value="<?php echo substr($data_eci[0]->CHR_IMPLEMENTING_PLAN, 4, 2) . '/' . substr($data_eci[0]->CHR_IMPLEMENTING_PLAN, 6, 2) . '/' . substr($data_eci[0]->CHR_IMPLEMENTING_PLAN, 0, 4); ?>">
                                <input name="id_del_activity" id="id_del_activity" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;display:none;" >
                                <div style="display:none;" id="delete_activity" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</div>

                            </div>
                        </div>

                        <div class="form-group" id="btn-group-header" style="float:none">
                            <div class="col-sm-offset-3 col-sm-12" style="margin:30px 0 0 30px ;">
                                <div class="btn-group">
                                    <div id="save-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</div>
                                    <div style="display:none;"id="update-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-refresh"></i> Update</div>
                                    <div id="cancel-header" type="submit" class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"> Cancel</div>
                                    <?php
                                    echo form_close();
                                    ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="row" style="" id="schedule">
                    <div class="col-md-12">
                        <div class="grid">
                            <div class="grid-header">
                                <i class="fa fa-calendar"></i>
                                <span class="grid-title" id=""><strong>SCHEDULE </strong> ACTIVITY</span>
                                <div class="pull-right grid-tools">
                                    <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="grid-body" >
                                <div id="gantt_here" style="width:100%; height:400px;"></div>
        
                            </div>
                        </div>
                    </div>
        
                </div>-->

        <div class="row" style="" id="create_line">
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MANAGE </strong> ACTIVITY</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('eci/schedule_c/new_entry', 'class="form-horizontal"'); ?>
                        <div class=" form-group">
                            <label class="col-sm-3 control-label">Activity</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="Activity"  id="activity_name" required style="width: 220px" >

                                    <?php
                                    $level = 0;
                                    $dep1 = 1;
                                    $dep2 = 1;
                                    $dep3 = 1;
                                    $dep4 = 1;
                                    echo " <option value=\"0\"> -- Choose Activity -- </option> ";
                                    foreach ($get_act as $act_val) {
                                        echo " <option value=\"$act_val->CHR_ID_ACTIVITY\"><strong>$dep1. $act_val->CHR_ACIVITY_NAME</option>";
                                        $child = $this->db->query("select * from TM_ECI_ACTIVITY where ID_DEPENDENCY = '$act_val->CHR_ID_ACTIVITY' ORDER BY INT_SEQ ")->result();
                                        if (count($child) > 0) {
                                            foreach ($child as $child_val) {
                                                echo " <option value=\"$child_val->CHR_ID_ACTIVITY\">&nbsp;&nbsp;&nbsp;&nbsp;$dep1.$dep2. $child_val->CHR_ACIVITY_NAME</option>";
                                                $child1 = $this->db->query("select * from TM_ECI_ACTIVITY where ID_DEPENDENCY = '$child_val->CHR_ID_ACTIVITY' ORDER BY INT_SEQ")->result();
                                                if (count($child1) > 0) {
                                                    foreach ($child1 as $child1_val) {
                                                        echo " <option value=\"$child1_val->CHR_ID_ACTIVITY\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$dep1.$dep2.$dep3. $child1_val->CHR_ACIVITY_NAME</option>";
                                                        $child2 = $this->db->query("select * from TM_ECI_ACTIVITY where ID_DEPENDENCY = '$child1_val->CHR_ID_ACTIVITY' ORDER BY INT_SEQ")->result();
                                                        if (count($child2) > 0) {
                                                            foreach ($child2 as $child2_val) {
                                                                echo " <option value=\"$child2_val->CHR_ID_ACTIVITY\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$dep1.$dep2.$dep3.$dep4. $child2_val->CHR_ACIVITY_NAME</option>";
                                                                $dep4++;
                                                            }
                                                        }
                                                        $dep3++;
                                                        $dep4 = 1;
                                                    }
                                                    $dep3++;
                                                    $dep4 = 1;
                                                }
                                                $dep2++;
                                                $dep3 = 1;
                                            }
                                        }
                                        $dep1++;
                                        $dep2 = 1;
                                    }
                                    ?>

                                </select>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9" id="detail_activity">

                            </div>
                        </div>


                        <div class="form-group" id="btn-group-header">
                            <div class="col-sm-offset-4 col-sm-4">
                                <div class="btn-group">
                                    <div id="add-line" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add Activity"><i class="fa fa-check"></i> Add</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>LIST </strong> OF ACTIVITY</span>
                        <div class="pull-right grid-tools">
                            <div id="btn-refresh" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Refresh"><i class="fa fa-refresh"></i> Refresh</div>
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" id="table-list-activity">
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>


