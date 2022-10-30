<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);

    $(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function () {
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function () {
        $("#datepicker3").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        /* border-spacing: 10px; */
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 120px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE DATA COVID 19</strong></a></li>
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
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>MANAGE DATA COVID19</strong></span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;' >
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <option <?php if($group == 1){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_covid/1'); ?>"> DIR</option>
                                                <option <?php if($group == 2){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_covid/2'); ?>"> ADV</option>
                                                <option <?php if($group == 3){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_covid/3'); ?>"> PRD</option>
                                                <option <?php if($group == 4){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_covid/4'); ?>"> ENG</option>
                                                <option <?php if($group == 5){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_covid/5'); ?>"> MKT,HR,IRL,GA</option>
                                                <option <?php if($group == 6){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_covid/6'); ?>"> FAC,PUR&IMPORT</option>
                                        </select>
                                    </td>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <!-- <th  style='text-align:center;'>No</th> -->
                                        <th  style='text-align:center;'>NPK</th>
                                        <th  style='text-align:center;'>Name</th>
                                        <th  style='text-align:center;'>Group</th>
                                        <th  style='text-align:center;'>Dept</th>
                                        <th  style='text-align:center;'>Status <br> Covid 19</th>
                                        <th  style='text-align:center;'>Status of<br> Quarantine</th>
                                        <th  style='text-align:center;'>Vaccine 1</th>
                                        <th  style='text-align:center;'>Vaccine 2</th>
                                        <th  style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $row) {
                                        echo "<tr class='gradeX'>";
                                        // echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='text-align:center;'>$row->npk</td>";
                                        echo "<td style='text-align:left;'>$row->username</td>";
                                        echo "<td style='text-align:center;'>$row->group</td>";
                                        echo "<td style='text-align:center;'>$row->dept</td>";
                                        if($row->flg_pcr_positive == 0){
                                            $color = 'background:#06d6a0;color:#FFFFFF;';
                                        }else{
                                            $color = 'background:#ff4d6d;color:#FFFFFF;';
                                        }
                                        echo "<td style='text-align:center;$color'>$row->status_covid</td>";
                                        echo "<td style='text-align:center;'>$row->status_quarantine</td>";
                                        echo "<td style='text-align:center;'>$row->vaccine1_date_format</td>";
                                        echo "<td style='text-align:center;'>$row->vaccine2_date_format</td>";
                                        ?>
                                    <td  style='text-align:center;'>
                                        <a data-toggle="modal" onclick="get_detail_case('<?php echo $row->npk ?>');" data-target="#modalDetail" class="label label-primary"  data-placement="left" title="View Detail Case"><span class="fa fa-eye"></span></a>
                                        <a data-toggle="modal" onclick="get_detail_data('<?php echo $row->npk ?>');" data-target="#modal" class="label label-danger"  data-placement="left" title="Case"><span class="fa fa-stethoscope"></span></a>
                                        <?php if($row->flg_pcr_positive == 0){ ?>
                                            <a data-toggle="modal" onclick="get_detail_user_vaccine('<?php echo $row->npk ?>');" data-target="#modalVaccine" class="label label-success"  data-placement="left" title="Update Vaccine"><span class="fa fa-medkit"></span></a>
                                        <?php } else { ?>
                                            <a class="label label-default" style='cursor: not-allowed;'  data-placement="left" title="Cannot update Vaccine"><span class="fa fa-medkit"></span></a>
                                        <?php } ?>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
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

    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-wrapper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/covid/covid_c/update_data_covid'); ?>" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel3"><strong style='text-transform:uppercase;'>Detail Case</strong></h4>
                        </div>
                        <div class="modal-body" >
                            <div id="table-luar">
                                <table id="nope" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Case No</th>
                                        <th style="text-align:center;">PCR Date</th> 
                                        <th style="text-align:center;">Case Status</th> 
                                        <th style="text-align:center;">Quarantine</th>
                                    </tr>
                                    </thead>
                                    <tbody id="data_detail_case">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-wrapper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/covid/covid_c/update_data_covid'); ?>" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel3"><strong style='text-transform:uppercase;' class='case-title'></strong></h4>
                        </div>
                        <div class="modal-body" >
                            <input name="npk" class='npk' type='hidden' />
                            <input name="group_id" class='group_id' type='hidden' />
                            <input name="flg_pcr_positive" id='flg_pcr_positive' type='hidden'/>
                            <input name="flg_quarantine" id='flg_quarantine' type='hidden'/>
                            <input name="pcr_date" id='pcr_date' type='hidden' />
                                    
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Name</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" readonly id='username'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">PCR Date</label>
                                <div class="col-sm-3">
                                    <input name="pcr_date_new" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:180px;" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">PCR Result</label>
                                <div class="col-sm-3">
                                    <select onchange='cekStatusPositive(this.value);' name='flg_pcr_positive_new' id='flg_pcr' class="form-control">
                                        <option value="0"> Negative</option>
                                        <option selected value="1"> Positive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id='qua-status-label'>
                                    <label class="col-sm-4 control-label">Quarantine Status</label>
                                    <div class="col-sm-4">
                                        <select name='flg_quarantine_new' id='flg_qua' class="form-control">
                                            <option selected value="1"> Self Isolation</option>
                                            <option value="2"> Hospitalized</option>
                                        </select>
                                    </div>
                            </div> 
                           
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                <button type="submit" class="btn btn-success"> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVaccine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-wrapper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/covid/covid_c/update_vaccine'); ?>" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel3"><strong>VACCINATION</strong></h4>
                        </div>
                        <div class="modal-body" >
                            <input name="npk" class='npk' type='hidden' />
                            <input name="group_id" class='group_id' type='hidden' />
                                    
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Name</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" readonly id='username_vaccine'>
                                </div>
                            </div>

                            <div class="form-group" id='datepicker1_label'>
                                <label class="col-sm-4 control-label">1st Vaccination Date</label>
                                <div class="col-sm-3">
                                    <input name="vaccine1_date" id="datepicker1" autocomplete='off' class="form-control" type="text" style="width:180px;">
                                </div>
                            </div>

                            <div class="form-group" id='datepicker2_label' >
                                <label class="col-sm-4 control-label" >2nd Vaccination Date</label>
                                <div class="col-sm-3">
                                    <input name="vaccine2_date" id="datepicker2" autocomplete='off' class="form-control" type="text" style="width:180px;">
                                </div>
                            </div>
                           
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                <button type="submit" class="btn btn-success"> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</aside>

<script type="text/javascript" language="javascript">

function get_detail_case(npk) {
    $("#data_detail_case").html("");
    $.ajax({
        async: false,
        type: "POST",
        url: "<?php echo site_url('covid/covid_c/get_detail_case'); ?>",
        data: { npk: npk },
        success: function (data) {
            $("#data_detail_case").html(data);
        }, 
        error: function (request) {
            alert(request.responseText);
        }
    });
}

function cekStatusPositive(flg_case){
    if(flg_case == 0){
        $("#qua-status-label").fadeOut(250);
    }

    if(flg_case == 1){
        $("#qua-status-label").fadeIn(250);
    }
}

function get_detail_data(npk){
    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('covid/covid_c/get_detail_user'); ?>",
        data:  { npk: npk },
        success: function (json_data) {
            $(".npk").val(json_data.npk);
            $("#username").val(json_data.username);
            $(".group_id").val(json_data.group_id);
            $("#flg_pcr_positive").val(json_data.flg_pcr_positive);
            $("#flg_quarantine").val(json_data.flg_quarantine);
            $("#flg_qua").html(json_data.flg_qua);
            $("#pcr_date").val(json_data.pcr_date);
            $("#datepicker").val(json_data.pcr_date);

            if(json_data.flg_pcr_positive == 1){
                $(".case-title").text('UPDATE CASE');
            }else{
                $(".case-title").text('CREATE NEW CASE');
            }
            
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}

function get_detail_user_vaccine(npk){
    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('covid/covid_c/get_detail_user'); ?>",
        data:  { npk: npk },
        success: function (json_data) {
            $(".npk").val(json_data.npk);
            $("#username_vaccine").val(json_data.username);
            $(".group_id").val(json_data.group_id);
            $("#datepicker1_label").show();
            $("#datepicker2_label").show();

            if(json_data.vaccine1 == '' && json_data.vaccine2 == ''){
                $("#datepicker1").val('');
                $("#datepicker2").val('');
                $("#datepicker2_label").hide();
            }
            
            if(json_data.vaccine1 != '' && json_data.vaccine2 == ''){
                $("#datepicker1").val(json_data.vaccine1);
                $("#datepicker2").val('');
            }

            if(json_data.vaccine1 != '' && json_data.vaccine2 != ''){
                $("#datepicker1").val(json_data.vaccine1);
                $("#datepicker2").val(json_data.vaccine2);
            }
            
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}

</script>