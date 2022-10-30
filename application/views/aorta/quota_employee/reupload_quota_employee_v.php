<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
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
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    .fileUpload {
        position: relative;
        overflow: hidden;
        width:100px;
        margin-left: 15px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .input-upload{
        border:none;width:50px;background:transparent;
        text-align: right;
    }
</style>
<style>
/* The container */
.container-radio {
    /* display: block; */
    position: relative;
    padding-left: 30px;
    font-weight:400;
    cursor: pointer;
    /* font-size: 10pt; */
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

/* Hide the browser's default radio button */
.container-radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #ccc;
    border-radius: 50%;
    /* margin-top: 22px; */
}

/* On mouse-over, add a grey background color */
.container-radio:hover input ~ .checkmark {
    background-color: darkgrey;
}

/* When the radio button is checked, add a blue background */
.container-radio input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-radio input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.container-radio .checkmark:after {
    top: 5px;
    left: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: white;
}
</style>


<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/quota_employee_c/"') ?>">Manage Quota Employee</a></li>
            <li class="active"> <a href="#"><strong>Reupload Quota Employee</strong></a></li>
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
                        <i class="fa fa-upload"></i>
                        <span class="grid-title"><strong>REUPLOAD QUOTA EMPLOYEE</strong></span>
                        <div class="pull-right grid-tools">
                               <a  href="<?php echo base_url('index.php/aorta/quota_employee_c/download_template_quota_employee') ?>"  name="btn-download" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download template</a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-top: 25px;">
                    <?php echo form_open_multipart('aorta/quota_employee_c/reupload_quota_employee', 'class="form-horizontal"'); ?>
                        
                    <div class="pull" style="margin-top: -20px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="10%" style='text-align:left;' ><strong>Periode</strong></td>
                                    <td width="25%">
                                        <select class="ddl" id="tanggal" name="CHR_PERIOD" onchange="document.getElementById('id_period').value=this.options[this.selectedIndex].value; document.getElementById('period_strong').value=this.options[this.selectedIndex].value;">
                                            <?php for ($x = -2; $x <= 2; $x++) { ?>
                                                <option value="<?php echo date("Ym", strtotime("+$x month")); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    
                                    <td width="20%" style='text-align:left;display:none;' colspan="4">
                                        <select class="form-control" id="dept" name="CHR_DEPT" onchange="document.getElementById('id_dept').value=this.options[this.selectedIndex].value; document.getElementById('dept_strong').value=this.options[this.selectedIndex].value;">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<?php echo $row->KODE; ?>" <?php
                                                if ($dept == $row->KODE) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->KODE); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                   
                                    <td width="20%"></td>
                                   
                                    <td width="5%" style='text-align:right;'>
                                        <strong>Reason</strong>       
                                    </td>
                                    <td width="50%" style='text-align:right;'>
                                        <div> 
                                            <textarea id="reason" name="CHR_REASON" rows="2" cols="500" class="form-control" placeholder="Please detail your quota request" maxlength="400">Quota Standar</textarea>
                                        </div>
                                    </td>
                                   
                            </table>
                        </div>

                        <input type="hidden" name="INT_ID_DOC" value="<?php echo $id_doc; ?>">

                        <div class="pull" style="margin-top: -15px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                <td width="10%" style='text-align:left;' ><strong>File (.xlsx)</strong></td>
                                    <td width="27%" style='text-align:left;' colspan="3">
                                        <input type="file" name="upload_quota" class="form-control" id="import" size="15"> 
                                    </td>
                                    <td width="43%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Upload</button>
                                    </td>
                                    <td width="10%" style='text-align:right;'> </td>
                                    <td width="10%" style='text-align:right;'> </td>
                            </table>
                        </div>

                        <div class="pull" style="margin-top: -10px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                <td width="10%" style='text-align:left;' ><strong>Quota Type</td>
                                    <td width="10%" style='text-align:left;' colspan="5">
                                        <label class="container-radio" >Quota Standar<input type="radio" name="INT_TYPE_QUOTA" value="0" id="enable" checked> 
                                            <span class="checkmark"></span>
                                        </label>
                                       
                                    </td>
                                    <td width="10%">
                                    <label class="container-radio">Quota Tambahan<input type="radio" name="INT_TYPE_QUOTA" value="1" id="disable"> 
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td width="70%" style='text-align:right;'>
                                    </td>
                            </table>
                        </div>

                    </div >
                    
                    <?php echo form_close(); ?>
                    <?php echo form_open('aorta/quota_employee_c/save_quota_employee', 'class="form-horizontal"'); ?>

                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                        <!--<th rowspan="2" style="vertical-align: middle;text-align:center;">Nama</th>-->
                                        <!--<th rowspan="2" style="vertical-align: middle;text-align:center;">Section</th> -->
                                        <!--<th rowspan="2" style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Sub Section</th> -->

                                        <th style="vertical-align: middle;text-align:center;" colspan="5">Production (H)</th>
                                        <th style="vertical-align: middle;text-align:center;" colspan="5">Improvement (H)</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Status</th>
                                    </tr>
                                    <tr>
                                        <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Request</td>
                                        <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Current</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Used</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Saldo</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Next Saldo</td>

                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Request</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Current</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Used</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Saldo</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Next Saldo</td>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $tot_qr_pr = 0;
                                    $tot_saldo_pr = 0;
                                    $tot_qr_im = 0;
                                    $tot_saldo_im = 0;
                                    foreach ($data as $isi) {
                                        $saldo_pr = $isi->SALDO_QUOTA_PR - $isi->TERPAKAI_QUOTA_PR;
                                        $next_saldo_pr = $saldo_pr + $isi->QUANTITY_QUOTA_PR;
                                        $saldo_im = $isi->SALDO_QUOTA_IM - $isi->TERPAKAI_QUOTA_IM;
                                        $next_saldo_im = $saldo_im + $isi->QUANTITY_QUOTA_IM;

                                        $tot_qr_pr = $tot_qr_pr + $isi->QUANTITY_QUOTA_PR;
                                        $tot_saldo_pr = $tot_saldo_pr + $next_saldo_pr;
                                        $tot_qr_im = $tot_qr_im + $isi->QUANTITY_QUOTA_IM;
                                        $tot_saldo_im = $tot_saldo_im + $next_saldo_im;

                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>";
                                        // echo "<td style='vertical-align: middle;text-align:left'>$isi->NAMA</td>";
                                        // echo "<td style='vertical-align: middle;text-align:center'>$isi->KD_SECTION</td>";
                                        // echo "<td style='vertical-align: middle;text-align:center'>$isi->KD_SUB_SECTION</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_PR, 2, ',', '.') . "</strong></td>";
                                        echo "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_PR, 2, ',', '.') . "</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_PR, 2, ',', '.') . "</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_pr, 2, ',', '.') . "</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_pr, 2, ',', '.') . "</strong></td>";
                                        echo "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_IM, 2, ',', '.') . "</strong></td>";
                                        echo "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_IM, 2, ',', '.') . "</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_IM, 2, ',', '.') . "</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_im, 2, ',', '.') . "</td>";
                                        echo "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_im, 2, ',', '.') . "</strong></td>";

                                        if($isi->KADEP_APPROVE == 1){
                                            $color = '#FE2D45';
                                            
                                            $status = 'Has Been Approve By Kadept';
                                            if($isi->GM_APPROVE == 1){
                                                $status = 'Has Been Approve By GM';
                                                if($isi->DIR_APPROVE == 1){
                                                    $status = 'Has Been Approve By Dir';
                                                    if($isi->FLG_FINISH_APPROVE == 1){
                                                        $status = 'Finish';
                                                    }
                                                }
                                            }
                                        }else{
                                            $status = 'Waiting Approve';
                                            $color = '#55D785';
                                        }
                                        echo "<td style='background:$color;color:#fff;vertical-align: middle;text-align:center'><strong>$status</strong></td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px >
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>NB   : </strong></td>
                                    <td width="10%">
                                        Quota for period <input type="text" id='period_strong' disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:55px;border: none;border-color: transparent;" value="<?php echo $period; ?>"></input> 
                                        for departement <strong style="background:yellow;color:black;"><input type="text" id='dept_strong' disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:45px;border: none;border-color: transparent;" value="<?php echo $dept; ?>"></input></strong>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pull-right" style="padding-left:600px;margin-top: -40px;">

                            <?php echo form_open('aorta/quota_employee_c/save_quota_employee', 'class="form-horizontal"'); ?>

                            <input type="hidden" name="CHR_PERIOD" id="id_period" value="<?php echo $period; ?>"></input>
                            <input type="hidden" name="CHR_DEPT" id="id_dept" value="<?php echo $dept; ?>"></input>
                            <input type="hidden" name="ID_DOC" id="id_doc" value="<?php echo $id_doc; ?>"></input>

                             <div style="float:right;">
                                <?php if ($status == true) { ?>
                                    <button type="submit" name="submit" class="btn btn-success" value="1"  data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;" onclick='return confirm("Apakah data quota untuk dept <?php echo $dept; ?> ?")'><i class="fa fa-check"></i> Save</button>
                                    <a href="<?php echo base_url('index.php/aorta/quota_employee_c/search_quota_employee/'.$period.'/'.$dept) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                <?php } else { ?>
                                    <button type="submit" name="submit" disabled class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;" onclick='return confirm("Apakah data quota untuk dept <?php echo $dept; ?> ?")'><i class="fa fa-check"></i> Save</button>
                                    <a href="<?php echo base_url('index.php/aorta/quota_employee_c/search_quota_employee/'.$period.'/'.$dept) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                <?php } ?>
                            </div>

                            <?php echo form_close(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
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
                                            paging: false,
                                            fixedColumns: {
                                                leftColumns: 3
                                            }
                                        });

                                        // By Default Disable radio button
                                    $("#reason").attr('disabled', true);
                                    // Disable radio buttons function on Check Disable radio button.
                                    $("form input:radio").change(function() {
                                        if ($(this).val() == "0") {
                                            $("#reason").attr('disabled', true);
                                            $("#reason").text('Quota Standar');
                                        }
                                        // Else Enable radio buttons.
                                        else {
                                            $("#reason").attr('disabled', false);
                                            $("#reason").text('');
                                        }
                                    });
                                    });

                                    // document.getElementById("uploadBtn").onchange = function () {
                                    //     document.getElementById("uploadFile").value = this.value;
                                    // };

                                    
</script>