<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 30);
</script>


<script>     var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                }
        , format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
                return c[p];
            })
        }
        return function (table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script> 
<!-- <script>
    $(document).ready(function () {
        var table = $('#dataTables1').DataTable({
            processing: true
        });

        $('#btn_refresh').on('click', function () {
            $(".dataTables_processing").show();
            setTimeout(function () {

                table.draw();
                $(".dataTables_processing").hide();
            }, 1000);
        });

    });
</script> -->

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
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
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }

    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-left-width: 0.4em;
        border-left-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-left-width: 0.4em;
        border-left-color: #bce8f1;
}
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/portal/eform_c"') ?>"><strong>Report Healthy</strong></a></li>
        </ol>
    </section>

    <section class="content">
        

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT HEALTHY MP</strong></span>
                       
                    </div>
                    

                    <div class="grid-body" style="padding-top: 10px">
                        <?php echo form_open('', 'class="form-horizontal"'); ?>
                        <table width="100%" id='filter' border=0px style="margin-bottom: 0px;">
                            <tr>
                                    <td width="5%">Dept</td>
                                    <td width="35%">
                                    <?php $session = $this->session->all_userdata(); ?>
                                    <?php if ($session['ROLE'] === 1  || $session['ROLE'] === 3 || $session['ROLE'] === 2 || $session['ROLE'] === 4 || $session['ROLE'] === 47) { ?>
                                        <select id="e1" name="CHR_DEPT_FIL" class="form-control" >
                                            <option <?php if($dept == 'ALL'){ echo 'selected'; } ?> value="ALL">All Dept</option>
                                        <?php
                                            foreach ($getdept as $key) {
                                                if(trim($key->CHR_DEPT) == trim($dept)) {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>" selected><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                } else {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>"><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                    <?php } else {?>
                                        <select id="e1" name="CHR_DEPT_FIL" class="form-control" >
                                        <?php
                                            foreach ($getdept as $key) {
                                                if(trim($key->CHR_DEPT) == trim($dept)) {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>" selected><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                } else {
                                            ?>
                                                    <option value="<?php echo $key->CHR_DEPT; ?>"><?php echo $key->CHR_DEPT ." - ". $key->CHR_DEPT_DESC; ?></option>
                                            <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                    <?php } ?>
                                    </td>
                                    <td width="0%"></td>
                                    <td width="0%">
                                    </td>
                                    <td width="65%"></td>
                                    <!-- <td style="text-align:right;">
                                    
                                        <input type="button" onclick="tableToExcel('exportToExcel', 'W3C Example Table')" value="Expor to Excel" class="btn btn-primary">
                                    </td> -->
                            </tr>
                            <tr>
                                <td width="10%">Date from</td>
                                <td width="12%">
                                    <input name="CHR_DATE_FROM" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:180px;" value="<?php echo date("d-m-Y", strtotime($date_from)); ?>">
                                </td>
                                <td width="3%">to</td>
                                <td width="10%" style="text-align:right;">
                                    <input name="CHR_DATE_TO" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:180px;" value="<?php echo date("d-m-Y", strtotime($date_to)); ?>">
                                </td>
                                <td width="55%" >
                                <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    <?php echo form_close(); ?>
                                </td>
                                <td style="text-align:right;">
                                    <?php echo form_open('portal/eform_c/print_history_healthy', 'class="form-horizontal"'); ?>
                                    <input name="FROM"  class="form-control"  type="hidden" value="<?php echo $date_from; ?>">
                                    <input name="TO" class="form-control" type="hidden" value="<?php echo $date_to; ?>">
                                    <input type="submit" style="margin-top:4px;" class="btn btn-primary"   value="Export to Excel" ><i class="fa fa-download-up"></i></input>
                                    <?php echo form_close() ?>

                                    <!-- <input type="button" onclick="tableToExcel('exportToExcel', 'Sheet1','')" value="Export to Excel" class="btn btn-primary"> -->
                                </td>
                            </tr>
                            
                        </table>

                        
                        <div id="table-luar">
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th  style='text-align:center;'>No</th>
                                        <th  style='text-align:center;'>NPK</th>
                                        <th  style='text-align:center;'>Nama</th>
                                        <th  style='text-align:center;'>Dept</th>
                                        <th  style='text-align:center;'>Suhu</th>
                                        <th  style='text-align:center;'>Aktifitas</th>
                                        <th  style='text-align:center;'>Kondisi</th>
                                        <th  style='text-align:center;'>Demam</th>
                                        <th  style='text-align:center;'>Kontak Covid19</th>
                                        <th  style='text-align:center;'>Tetangga Covid19</th>
                                        <th  style='text-align:center;'>Anda Sakit?</th>
                                        <th  style='text-align:center;'>Keluarga Sakit?</th>
                                        <th  style='text-align:center;'>Sedang Sakit?</th>
                                        <th  style='text-align:center;'>Hasil SA</th>
                                        <th  style='text-align:center;'>Tanggal SA</th>
                                        <th  style='text-align:center;'>Jam SA</th>
                                        <th  style='text-align:center;'>Lokasi SA</th>
                                        <th  style='text-align:center;'>Resiko Area</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($dt_healthy == 'NULL'){

                                    }else{
                                        $r = 1;
                                        foreach ($dt_healthy as $isi) {
                                            echo "<tr style='text-align:center;'>";
                                            echo "<td style='text-align:center;'>$r</td>";
                                            echo "<td style='text-align:center;'>$isi->npk</td>";
                                            echo "<td style='text-align:left;'>$isi->username</td>";
                                            echo "<td style='text-align:center;'>$isi->dept</td>";
                                            ?>
                                            <?php if ($isi->temp=="") {?>
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo $isi->temp ?></td>
                                            <?php } ?>

                                            <?php if ($isi->activity=='1'){ ?>
                                                <td style='text-align:center;'>Shift 1</td>
                                            <?php } elseif($isi->activity=='2') { ?>
                                                <td style='text-align:center;'>Shift 2</td>
                                            <?php } elseif($isi->activity=='3') { ?>
                                                <td style='text-align:center;'>Shift 3</td>
                                            <?php } elseif($isi->activity=='4') { ?>
                                                <td style='text-align:center;'>Non Shift</td>
                                            <?php } elseif($isi->activity=='5') { ?>
                                                <td style='text-align:center;'>Di Rumah</td>
                                            <?php } elseif($isi->activity=='6') { ?>
                                                <td style='text-align:center;'>Bepergian</td>
                                            <?php } elseif($isi->activity=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>

                                            <?php if($isi->flg_fit=='0'){ ?>
                                                <td style='text-align:center;'>Sehat</td>
                                            <?php } elseif($isi->flg_fit=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>    
                                                <td style='text-align:center;'>Sakit</td>
                                            <?php } ?>

                                            <?php if($isi->flg_fever=='1'){ ?>
                                                <td style='text-align:center;'>Ya</td>
                                            <?php } elseif($isi->flg_fever=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Tidak</td>
                                            <?php } ?>

                                            <?php if($isi->flg_contact=='1'){ ?>
                                                <td style='text-align:center;'>Ya</td>
                                            <?php } elseif($isi->flg_contact=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Tidak</td>
                                            <?php } ?>

                                            <?php if($isi->flg_interaction=='1'){ ?>
                                                <td style='text-align:center;'>Ya</td>
                                            <?php } elseif($isi->flg_interaction=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Tidak</td>
                                            <?php } ?>

                                            <?php if ($isi->self_condition=='0'){ ?>
                                                <td style='text-align:center;'>Tidak Ada Keluhan</td> 
                                            <?php } elseif($isi->self_condition=='1') { ?>   
                                                <td style='text-align:center;'>Demam</td>       
                                            <?php } elseif($isi->self_condition=='2') { ?>   
                                                <td style='text-align:center;'>Flu</td>
                                            <?php } elseif($isi->self_condition=='3') { ?>   
                                                <td style='text-align:center;'>Batuk</td>
                                            <?php } elseif($isi->self_condition=='4') { ?>   
                                                <td style='text-align:center;'>Sesak Nafas</td>
                                            <?php } elseif($isi->self_condition=='5') { ?>   
                                                <td style='text-align:center;'>Radang</td>
                                            <?php } elseif($isi->self_condition=='6') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan mengecap rasa</td>
                                            <?php } elseif($isi->self_condition=='7') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan Mencium bau</td>
                                            <?php } elseif($isi->self_condition=='9') { ?>   
                                                <td style='text-align:center;'>Diare</td>
                                            <?php } elseif($isi->self_condition=='10') { ?>   
                                                <td style='text-align:center;'>Nyeri Dada</td>                     
                                            <?php } elseif($isi->self_condition=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>

                                            <?php if ($isi->fams_condition=='0'){ ?>
                                                <td style='text-align:center;'>Tidak Ada Keluhan</td> 
                                            <?php } elseif($isi->fams_condition=='1') { ?>   
                                                <td style='text-align:center;'>Demam</td>       
                                            <?php } elseif($isi->fams_condition=='2') { ?>   
                                                <td style='text-align:center;'>Flu</td>
                                            <?php } elseif($isi->fams_condition=='3') { ?>   
                                                <td style='text-align:center;'>Batuk</td>
                                            <?php } elseif($isi->fams_condition=='4') { ?>   
                                                <td style='text-align:center;'>Sesak Nafas</td>
                                            <?php } elseif($isi->fams_condition=='5') { ?>   
                                                <td style='text-align:center;'>Radang</td>
                                            <?php } elseif($isi->fams_condition=='6') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan mengecap rasa</td>
                                            <?php } elseif($isi->fams_condition=='7') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan Mencium bau</td>
                                            <?php } elseif($isi->fams_condition=='9') { ?>   
                                                <td style='text-align:center;'>Diare</td>
                                            <?php } elseif($isi->fams_condition=='10') { ?>   
                                                <td style='text-align:center;'>Nyeri Dada</td>                     
                                            <?php } elseif($isi->fams_condition=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>

                                            <?php if ($isi->ill_condition=='0'){ ?>
                                                <td style='text-align:center;'>Tidak Ada Keluhan</td> 
                                            <?php } elseif($isi->ill_condition=='1') { ?>   
                                                <td style='text-align:center;'>Auto imun</td>       
                                            <?php } elseif($isi->ill_condition=='2') { ?>   
                                                <td style='text-align:center;'>Supresi imun (HIV-AIDS)</td>
                                            <?php } elseif($isi->ill_condition=='3') { ?>   
                                                <td style='text-align:center;'>Terapi Kanker</td>
                                            <?php } elseif($isi->ill_condition=='4') { ?>   
                                                <td style='text-align:center;'>Jantung Kronik</td>
                                            <?php } elseif($isi->ill_condition=='5') { ?>   
                                                <td style='text-align:center;'>Lever</td>
                                            <?php } elseif($isi->ill_condition=='6') { ?>   
                                                <td style='text-align:center;'>Diabetes Melitus</td>
                                            <?php } elseif($isi->ill_condition=='7') { ?>   
                                                <td style='text-align:center;'>Gagal Ginjal</td>
                                            <?php } elseif($isi->ill_condition=='8') { ?>   
                                                <td style='text-align:center;'>Asma / Peradangan Paru</td>
                                            <?php } elseif($isi->ill_condition=='9') { ?>   
                                                <td style='text-align:center;'>Hipertensi</td>                    
                                            <?php } elseif($isi->ill_condition=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>                                            
                                                                                        
                                            <?php if(($isi->flg_sa=='0') and ($isi->flg_contact=='0') and ($isi->flg_interaction=='0')) { ?>   
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>                                                
                                            
                                            <?php } elseif($isi->flg_sa=='') { ?>
                                                <td style='text-align:center;'>-</td>
                                            <?php } elseif(($isi->flg_sa=='0') and ($isi->flg_contact=='1') and ($isi->flg_interaction=='1')) { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>    
                                            <?php } ?>

                                            <!-- <?php if($isi->temp=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } elseif((($isi->temp >= 37) and ($isi->self_condition!='0')) or 
                                                        (($isi->temp >= 37) and ($isi->fams_condition!='0')) or 
                                                        (($isi->temp >= 37) and ($isi->flg_fever=='1')) or 
                                                        (($isi->temp >= 37) and ($isi->flg_fit!='1')) ) { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>                                    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                            <?php } ?> -->

                                            <?php if ($isi->date==''){ ?>
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo date("d-M-Y", strtotime($isi->date)) ?></td>
                                            <?php } ?>
                                            
                                            <?php if ($isi->time==''){ ?>
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <!--<td style='text-align:center;'><?php echo date("H:i:s", strtotime($isi->time)) ?></td> -->
                                                <td style='text-align:center;'><?php echo $isi->time ?></td>
                                            <?php } ?>

                                            <?php if ($isi->city==''){ ?>
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo $isi->city ?></td>
                                            <?php } ?>
                                            
                                            <?php if ($isi->status=='RESIKO SEDANG'){ ?>
                                                <td style='text-align:center;background-color:#ffa500;color:black'>SEDANG</td>    
                                            <?php } elseif ($isi->status=='RESIKO TINGGI') { ?>
                                                <td style='text-align:center;background-color:#ff0000;color:white'>TINGGI</td>
                                            <?php } elseif ($isi->status=='') { ?>
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;background-color:#ded716'>RENDAH</td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                }?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                    <tr>
                                        <th  style='text-align:center;'>No</th>
                                        <th  style='text-align:center;'>NPK</th>
                                        <th  style='text-align:center;'>Nama</th>
                                        <th  style='text-align:center;'>Dept</th>
                                        <th  style='text-align:center;'>Suhu</th>
                                        <th  style='text-align:center;'>Aktifitas</th>
                                        <th  style='text-align:center;'>Kondisi</th>
                                        <th  style='text-align:center;'>Demam</th>
                                        <th  style='text-align:center;'>Kontak Covid19</th>
                                        <th  style='text-align:center;'>Tetangga Covid19</th>
                                        <th  style='text-align:center;'>Anda Sakit?</th>
                                        <th  style='text-align:center;'>Keluarga Sakit?</th>
                                        <th  style='text-align:center;'>Sedang Sakit?</th>
                                        <th  style='text-align:center;'>Hasil SA</th>
                                        <th  style='text-align:center;'>Tanggal SA</th>
                                        <th  style='text-align:center;'>Jam SA</th>
                                        <th  style='text-align:center;'>Lokasi SA</th>
                                        <th  style='text-align:center;'>Resiko Area</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($dt_healthy == 'NULL'){

                                    }else{
                                        $r = 1;
                                        foreach ($dt_healthy as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td style='text-align:center;'>$r</td>";
                                            echo "<td style='text-align:center;'>$isi->npk</td>";
                                            echo "<td style='text-align:center;'>$isi->username</td>";
                                            echo "<td style='text-align:center;'>$isi->dept</td>";
                                            ?>
                                            <?php if ($isi->temp=="") {?>
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo $isi->temp ?></td>
                                            <?php } ?>

                                            <?php if ($isi->activity=='1'){ ?>
                                                <td style='text-align:center;'>Shift 1</td>
                                            <?php } elseif($isi->activity=='2') { ?>
                                                <td style='text-align:center;'>Shift 2</td>
                                            <?php } elseif($isi->activity=='3') { ?>
                                                <td style='text-align:center;'>Shift 3</td>
                                            <?php } elseif($isi->activity=='4') { ?>
                                                <td style='text-align:center;'>Non Shift</td>
                                            <?php } elseif($isi->activity=='5') { ?>
                                                <td style='text-align:center;'>Di Rumah</td>
                                            <?php } elseif($isi->activity=='6') { ?>
                                                <td style='text-align:center;'>Bepergian</td>
                                            <?php } elseif($isi->activity=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>

                                            <?php if($isi->flg_fit=='0'){ ?>
                                                <td style='text-align:center;'>Sehat</td>
                                            <?php } elseif($isi->flg_fit=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>    
                                                <td style='text-align:center;'>Sakit</td>
                                            <?php } ?>

                                            <?php if($isi->flg_fever=='1'){ ?>
                                                <td style='text-align:center;'>Ya</td>
                                            <?php } elseif($isi->flg_fever=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Tidak</td>
                                            <?php } ?>

                                            <?php if($isi->flg_contact=='1'){ ?>
                                                <td style='text-align:center;'>Ya</td>
                                            <?php } elseif($isi->flg_contact=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Tidak</td>
                                            <?php } ?>

                                            <?php if($isi->flg_interaction=='1'){ ?>
                                                <td style='text-align:center;'>Ya</td>
                                            <?php } elseif($isi->flg_interaction=='') { ?>   
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Tidak</td>
                                            <?php } ?>

                                            <?php if ($isi->self_condition=='0'){ ?>
                                                <td style='text-align:center;'>Tidak Ada Keluhan</td> 
                                            <?php } elseif($isi->self_condition=='1') { ?>   
                                                <td style='text-align:center;'>Demam</td>       
                                            <?php } elseif($isi->self_condition=='2') { ?>   
                                                <td style='text-align:center;'>Flu</td>
                                            <?php } elseif($isi->self_condition=='3') { ?>   
                                                <td style='text-align:center;'>Batuk</td>
                                            <?php } elseif($isi->self_condition=='4') { ?>   
                                                <td style='text-align:center;'>Sesak Nafas</td>
                                            <?php } elseif($isi->self_condition=='5') { ?>   
                                                <td style='text-align:center;'>Radang Tengoorokan</td>
                                            <?php } elseif($isi->self_condition=='6') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan mengecap rasa</td>
                                            <?php } elseif($isi->self_condition=='7') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan Mencium bau</td>
                                            <?php } elseif($isi->self_condition=='9') { ?>   
                                                <td style='text-align:center;'>Diare</td>
                                            <?php } elseif($isi->self_condition=='10') { ?>   
                                                <td style='text-align:center;'>Nyeri Dada</td>                        
                                            <?php } elseif($isi->self_condition=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>

                                            <?php if ($isi->fams_condition=='0'){ ?>
                                                <td style='text-align:center;'>Tidak Ada Keluhan</td> 
                                            <?php } elseif($isi->fams_condition=='1') { ?>   
                                                <td style='text-align:center;'>Demam</td>       
                                            <?php } elseif($isi->fams_condition=='2') { ?>   
                                                <td style='text-align:center;'>Flu</td>
                                            <?php } elseif($isi->fams_condition=='3') { ?>   
                                                <td style='text-align:center;'>Batuk</td>
                                            <?php } elseif($isi->fams_condition=='4') { ?>   
                                                <td style='text-align:center;'>Sesak Nafas</td>
                                            <?php } elseif($isi->fams_condition=='5') { ?>   
                                                <td style='text-align:center;'>Radang Tengoorokan</td>
                                            <?php } elseif($isi->fams_condition=='6') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan mengecap rasa</td>
                                            <?php } elseif($isi->fams_condition=='7') { ?>   
                                                <td style='text-align:center;'>Hilang Kemampuan Mencium bau</td>
                                            <?php } elseif($isi->self_condition=='9') { ?>   
                                                <td style='text-align:center;'>Diare</td>
                                            <?php } elseif($isi->self_condition=='10') { ?>   
                                                <td style='text-align:center;'>Nyeri Dada</td>                    
                                            <?php } elseif($isi->fams_condition=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>

                                            <?php if ($isi->ill_condition=='0'){ ?>
                                                <td style='text-align:center;'>Tidak Ada Keluhan</td> 
                                            <?php } elseif($isi->ill_condition=='1') { ?>   
                                                <td style='text-align:center;'>Auto imun</td>       
                                            <?php } elseif($isi->ill_condition=='2') { ?>   
                                                <td style='text-align:center;'>Supresi imun (HIV-AIDS)</td>
                                            <?php } elseif($isi->ill_condition=='3') { ?>   
                                                <td style='text-align:center;'>Terapi Kanker</td>
                                            <?php } elseif($isi->ill_condition=='4') { ?>   
                                                <td style='text-align:center;'>Jantung Kronik</td>
                                            <?php } elseif($isi->ill_condition=='5') { ?>   
                                                <td style='text-align:center;'>Lever</td>
                                            <?php } elseif($isi->ill_condition=='6') { ?>   
                                                <td style='text-align:center;'>Diabetes Melitus</td>
                                            <?php } elseif($isi->ill_condition=='7') { ?>   
                                                <td style='text-align:center;'>Gagal Ginjal</td>
                                            <?php } elseif($isi->ill_condition=='8') { ?>   
                                                <td style='text-align:center;'>Asma / Peradangan Paru</td>
                                            <?php } elseif($isi->ill_condition=='9') { ?>   
                                                <td style='text-align:center;'>Hipertensi</td>                    
                                            <?php } elseif($isi->ill_condition=='') { ?>   
                                                <td style='text-align:center;'>-</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>Other</td>
                                            <?php } ?>
                                            
                                            <?php if(($isi->flg_sa=='0') and ($isi->flg_contact=='0') and ($isi->flg_interaction=='0')) { ?>   
                                                <td style='text-align:center;'>OK</td>                                                
                                            
                                            <?php } elseif($isi->flg_sa=='') { ?>
                                                <td style='text-align:center;'>-</td>
                                            <?php } elseif(($isi->flg_sa=='0') and ($isi->flg_contact=='1') and ($isi->flg_interaction=='1')) { ?>
                                                <td style='text-align:center;'>NG</td>
                                            <?php } else { ?>
                                                <td style='text-align:center;'>NG</td>                                     
                                            <?php } ?>

                                            <!-- <?php if($isi->temp=='') { ?>   
                                                <td style='text-align:center;'>-</td> 
                                            <?php } elseif((($isi->temp >= 37) and ($isi->self_condition!='0')) or 
                                                        (($isi->temp >= 37) and ($isi->fams_condition!='0')) or 
                                                        (($isi->temp >= 37) and ($isi->flg_fever=='1')) or 
                                                        (($isi->temp >= 37) and ($isi->flg_fit!='1')) ) { ?>
                                                <td style='text-align:center;'>NG</td>                                               
                                            <?php } else { ?>
                                                <td style='text-align:center;'>OK</td>
                                            <?php } ?> -->

                                            <?php if ($isi->date==''){ ?>
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo date("d-M-Y", strtotime($isi->date)) ?></td>
                                            <?php } ?>
                                            
                                            <?php if ($isi->time==''){ ?>
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo date("H:i:s", strtotime($isi->time)) ?></td>
                                            <?php } ?>

                                            <?php if ($isi->city==''){ ?>
                                                <td style='text-align:center;'>-</td>    
                                            <?php } else { ?>
                                                <td style='text-align:center;'><?php echo $isi->city ?></td>
                                            <?php } ?>
                                            
                                        
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                }?>
                                </tbody>
                            </table>

                        </div>

                        <div class="grid-no-header">
                                <br/>
                                <b>*</b> Data resiko area diambil dari situs <a href="https://covid19.go.id/peta-risiko">Peta COVID-19</a> dengan update terakhir per <b><?php echo ($tgl_cov['date_status']); ?></b> - Last update data <?php echo ($tgl_upd['last_date_update']); ?><br/>
                                <b>*</b> Data status resiko area diambil pada saat pengisian form SA dilakukan
                                <!-- <div style='font-size: 14px;' class="pull-right">
                                    <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total->TOTAL); ?></strong>
                                </div> -->
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

<script>
                                        $(document).ready(function () {
                                            var table = $('#example').DataTable({
                                                        scrollY: "400px",
                                                        scrollX: true,
                                                        scrollCollapse: true,
                                                        paging: false,
                                                        columnDefs: [{
                                                                sortable: false,
                                                                "class": "index",
                                                                targets: 0
                                                            }],
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 4
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                        });

                                        document.getElementById("uploadBtn").onchange = function () {
                                            document.getElementById("uploadFile").value = this.value;
                                        };
</script>