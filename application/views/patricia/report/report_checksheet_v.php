<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
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
}
</style>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>REPORT DETAIL CHECKSHEET</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>REPORT DETAIL CHECKSHEET</strong></span>
                    </div>
                    <div class="grid-body">

                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date_awal ?>" type="hidden">
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date_akhir ?>" type="hidden">
                        <?php 
                            $selecteddate2 = '';
                            $selecteddate1 = '';
                            if($selected_date_awal!=''){
                                $selecteddate1 = date("m/d/Y", strtotime($selected_date_awal));
                            }

                            if($selected_date_akhir!=''){
                                $selecteddate2 = date("m/d/Y", strtotime($selected_date_akhir));
                            }                            
                        ?>

                        <div class="pull-right">
                        <table width="100%" id='filter' border=0px>
                            <form method="POST" action="<?php echo base_url('index.php/patricia/report_checksheet_c/excel_check_list') ?>">
                                <tr>
                                    <td width="10%">
                                        <input  name="tanggal_awal" id="datepicker1" class="form-control" placeholder="Start Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo $selecteddate1 ?>">
                                    </td>
                                    <td width="1%">S/D</td>
                                    <td width="10%">
                                        <input  name="tanggal_akhir" id="datepicker2" class="form-control" placeholder="End Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo $selecteddate2 ?>">
                                    </td>                                        
                                    <td width="74%" style="padding-top: 3px">
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-download"></i> Export Excel</button>
                                    </td>
                                </tr>
                            </form>
                        </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>PDS No.</th>
                                        <th>Lot No.</th>
                                        <th>Part No.</th>
                                        <th>Part Name</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        foreach ($data as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td style='text-align:center;'>$i</td>";
                                            echo "<td style='text-align:left;'>".date("d F Y", strtotime($isi->CHR_CREATED_DATE))."</td>"; 
                                            echo "<td style='text-align:center;'>$isi->CHR_PDS_NUMBER</td>";
                                            echo "<td style='text-align:center;'>$isi->CHR_LOAD_NUMBER</td>";
                                            echo "<td style='text-align:center;'>$isi->CHR_ID_PART</td>";
                                            echo "<td>$isi->CHR_NAMA_PART</td>";
                                            echo "<td>$isi->CHR_NAMA_VENDOR</td>";    
                                            echo "<td style='text-align:center;'>$isi->CHR_STATUS</td>";    
                                        ?>
                                        <td>
                                            <a href="<?php echo base_url('index.php/patricia/report_checksheet_c/excel_checksheet') . "/" . $isi->CHR_CREATED_DATE ."/".trim($isi->CHR_ID_PART) ."/". trim($isi->CHR_PDS_NUMBER); ?>" data-placement="left" data-toggle="tooltip" title="Excel" class="label label-default"><span class="fa fa-download"></span></a>
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
</aside>


