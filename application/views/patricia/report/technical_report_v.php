<style type="text/css">
    td{
        width: 100px;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>TECHNICAL REPORT</strong></a></li>
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
                        <span class="grid-title"><strong>TECHNICAL REPORT</strong> TABLE</span>
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

                        <div class="pull">
                            <table width="60%" id='filter' border=0px>
                                <form method="POST" action="<?php echo base_url('index.php/patricia/technical_report_c/excel_technical_list') ?>">
                                    <tr>
                                        <td width="5%">Filter</td>
                                        <td width="10%">
                                            <input  name="tanggal_awal" id="datepicker1" class="form-control" placeholder="Start Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo $selecteddate1 ?>">
                                        </td>
                                        <td width="5%"><center>s/d</center></td>
                                        <td width="10%">
                                            <input  name="tanggal_akhir" id="datepicker2" class="form-control" placeholder="End Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo $selecteddate2 ?>">
                                        </td>
                                        
                                        <td width="15%" style="padding-top: 3px">
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-download"></i> Export Excel</button>
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                        <br><br>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>TR No.</th>
                                    <th>Prob. Experience</th>
                                    <th>Prob. Rank</th>
									<th>Part Number</th>
                                    <th>Part Name</th>
                                    <th>Supplier</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td>$isi->CHR_TR_NO</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PROB_EXP</td>"; 
                                        echo "<td style='text-align:center;'>$isi->CHR_PROB_RANK</td>";
                                        echo "<td>$isi->CHR_ID_PART</td>";
                                        echo "<td>$isi->CHR_NAMA_PART</td>";
                                        echo "<td>$isi->CHR_NAMA_VENDOR</td>";
                                        echo "<td>".date("d F Y", strtotime($isi->CHR_TR_DATE))."</td>";
                                    ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/patricia/technical_report_c/excel_technical') . "/" . $isi->INT_TR_ID; ?>" data-placement="left" data-toggle="tooltip" title="Excel" class="label label-default"><span class="fa fa-download"></span></a>
<!-- 
                                        <a href="<?php echo base_url('index.php/patricia/report_checksheet_c/grafik') . "/" . $isi->INT_TR_ID; ?>" id="detail" class="label label-info" data-placement="top" data-toggle="tooltip" title="Detail"><span class="fa fa-info"></span></a> -->
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
        
    </section>
</aside>


