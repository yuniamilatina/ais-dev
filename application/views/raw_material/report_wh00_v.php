
<style type="text/css">
    #scrooltable{
        width: 100%;
        overflow-x: auto;
        white-space: nowrap; 
    }
    #centercoloumnheader{
        text-align:center;
        vertical-align:middle;
        background-color:#f5f5f5;
    } 
    #centercoloumnheader_inoutendstock{
        text-align:center;
        vertical-align:middle;
    }
    #centercoloumnheader_inoutendstock_genap{
        text-align:center;
        vertical-align:middle;
        background-color:#f5f5f5;
    } 
    #centercoloumnpartnumber{
        font-weight:bold;
        font-size:20px;
        text-align:center;
        vertical-align:middle;
    } 
    #td_qty{
        text-align:center;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT WH00</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-table"></i>
                        <span class="grid-title">TABLE REPORT WH00</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('raw_material/raw_material_coil_c', 'class="form-horizontal"'); ?> 

                            <select name="INT_ID_MONTH" id="INT_ID_MONTH" class="ddl">
                                <?php
                                for ($x = 1; $x < 13; $x++) {
                                    if ($month_desc[$x] == $selected_month) {
                                        ?>
                                        <option selected="true" value="<?php echo $x; ?>"><?php echo $month_desc[$x]; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $x; ?>"><?php echo $month_desc[$x]; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <select name="INT_ID_YEAR" id="INT_ID_YEAR" class="ddl">
                                <option selected="true" value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                            </select>

                            <button type="submit" name="btn_submit" id="btn_submit" value="1"  class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px"><i class="fa fa-search"></i></button>
                            <?php echo form_close(); ?>

                        </div>
                        <div id="scrooltable">
                            <table class="table table-condensed table-bordered table-striped display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th colspan="1" rowspan="2" id="centercoloumnheader">Part Name & Spec</th>
                                        <th colspan="2" rowspan="2" id="centercoloumnheader">Item</th>
                                        <th colspan="31" id="centercoloumnheader">Date</th>
                                        <th colspan="2" rowspan="2" id="centercoloumnheader">End Stock</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td >$x</td>";
                                        }
                                        ?>

                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php
                                    $r = 1;
                                    $session = $this->session->all_userdata();

                                    foreach ($data_report_wh00 as $isi) {
                                        echo "<tr class='gradeX'>";

                                        if ($r % 2 != 0) {
                                            $strip_part_no = 'style=background-color:white;';
                                        } else {
                                            $strip_part_no = '';
                                        }

                                        echo "<td rowspan='8' $strip_part_no id=centercoloumnpartnumber>" . $isi->CHR_PART_NUMBER . "</td>";
                                        echo "<td rowspan='4' id=centercoloumnheader_inoutendstock>IN</td>";
                                        echo "<td id='td_qty'>RM</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_1 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_2 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_3 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_4 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_5 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_6 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_7 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_8 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_9 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_10 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_11 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_12 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_13 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_14 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_15 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_16 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_17 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_18 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_19 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_20 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_21 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_22 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_23 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_24 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_25 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_26 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_27 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_28 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_29 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_30 / 1000) . "</td>";
                                        echo "<td id='td_qty'>" . number_format($isi->INT_GR_RM_31 / 1000) . "</td>";
                                        echo "<td id='td_qty'>RM</td>";
                                        echo "<td id='td_qty'>SAP</td>";
                                        echo "</tr>";

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>SAP</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_GR_SAP_31 / 1000) . "</td>";
                                        echo "<td rowspan='3' id=centercoloumnheader_inoutendstock>" . number_format($isi->INT_SALDO_AKHIR_RM) . "</td>";
                                        echo "<td rowspan='3' id=centercoloumnheader_inoutendstock>" . number_format($isi->INT_SALDO_AKHIR_SAP) . "</td>";
                                        echo "</tr>";

                                        echo "<tr>";
                                        echo "</tr>";

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;background-color:#f5f5f5;>DIFF</td>";

                                        if ($isi->INT_GR_DIFF_1 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_1) . "</td>";

                                        if ($isi->INT_GR_DIFF_2 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_2) . "</td>";

                                        if ($isi->INT_GR_DIFF_3 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_3) . "</td>";

                                        if ($isi->INT_GR_DIFF_4 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_4) . "</td>";

                                        if ($isi->INT_GR_DIFF_5 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_5) . "</td>";

                                        if ($isi->INT_GR_DIFF_6 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_6) . "</td>";

                                        if ($isi->INT_GR_DIFF_7 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_7) . "</td>";

                                        if ($isi->INT_GR_DIFF_8 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_8) . "</td>";

                                        if ($isi->INT_GR_DIFF_9 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_9) . "</td>";

                                        if ($isi->INT_GR_DIFF_10 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_10) . "</td>";

                                        if ($isi->INT_GR_DIFF_11 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_11) . "</td>";

                                        if ($isi->INT_GR_DIFF_12 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_12) . "</td>";

                                        if ($isi->INT_GR_DIFF_13 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_13) . "</td>";

                                        if ($isi->INT_GR_DIFF_14 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_14) . "</td>";

                                        if ($isi->INT_GR_DIFF_15 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_15) . "</td>";

                                        if ($isi->INT_GR_DIFF_16 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_16) . "</td>";

                                        if ($isi->INT_GR_DIFF_17 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_17) . "</td>";

                                        if ($isi->INT_GR_DIFF_18 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_18) . "</td>";

                                        if ($isi->INT_GR_DIFF_19 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_19) . "</td>";

                                        if ($isi->INT_GR_DIFF_20 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_20) . "</td>";

                                        if ($isi->INT_GR_DIFF_21 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_21) . "</td>";

                                        if ($isi->INT_GR_DIFF_22 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_22) . "</td>";

                                        if ($isi->INT_GR_DIFF_23 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_23) . "</td>";

                                        if ($isi->INT_GR_DIFF_24 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_24) . "</td>";

                                        if ($isi->INT_GR_DIFF_25 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_25) . "</td>";

                                        if ($isi->INT_GR_DIFF_26 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_26) . "</td>";

                                        if ($isi->INT_GR_DIFF_27 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_27) . "</td>";

                                        if ($isi->INT_GR_DIFF_28 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_28) . "</td>";

                                        if ($isi->INT_GR_DIFF_29 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_29) . "</td>";

                                        if ($isi->INT_GR_DIFF_30 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_GR_DIFF_30) . "</td>";

                                        if ($isi->INT_GR_DIFF_31 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label>" . number_format($isi->INT_GR_DIFF_31) . "</td>";
                                        echo "</tr>";

                                        echo "<tr class='gradeX'>";
                                        echo "<td rowspan='4' id=centercoloumnheader_inoutendstock>OUT</td>";
                                        echo "<td style=text-align:center;>RM</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_31 / 1000) . "</td>";
                                        echo "<td colspan='2' style=text-align:center;>DIFF</td>";
                                        echo "</tr>";

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>SAP</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_31 / 1000) . "</td>";

                                        if ($isi->INT_SALDO_AKHIR_DIFF != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td rowspan='3' colspan='2' style=$red_label id=centercoloumnheader_inoutendstock >" . number_format($isi->INT_SALDO_AKHIR_DIFF) . "</td>";
                                        echo "</tr>";

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>CONS</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_31 / 1000) . "</td>";
                                        echo "</tr>";

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>DIFF</td>";

                                        if ($isi->INT_MOVE_DIFF_1 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_1) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_2 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_2) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_3 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_3) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_4 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_4) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_5 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_5) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_6 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_6) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_7 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_7) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_8 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_8) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_9 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_9) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_10 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_10) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_11 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_11) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_12 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_12) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_13 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_13) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_14 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_14) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_15 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_15) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_16 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_16) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_17 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_17) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_18 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_18) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_19 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_19) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_20 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_20) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_21 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_21) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_22 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_22) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_23 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_23) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_24 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_24) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_25 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_25) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_26 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_26) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_27 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_27) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_28 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_28) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_29 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_29) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_30 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_30) . "</td>";

                                        if ($isi->INT_MOVE_DIFF_31 != 0) {
                                            $red_label = 'background-color:#ff1744;color:white;text-align:center;';
                                        } else {
                                            $red_label = 'background-color:#00c853;color:white;text-align:center;';
                                        }
                                        echo "<td style=$red_label>" . number_format($isi->INT_MOVE_DIFF_31) . "</td>";
                                        echo "</tr>";

//                                        echo "<tr class='gradeX'>";
//                                            echo "<td rowspan='3' id=centercoloumnheader_inoutendstock_genap>END STOCK</td>";
//                                            echo "<td style=text-align:center;>RM</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_1 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_2 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_3 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_4 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_5 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_6 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_7 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_8 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_9 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_10 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_11 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_12 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_13 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_14 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_15 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_16 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_17 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_18 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_19 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_20 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_21 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_22 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_23 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_24 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_25 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_26 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_27 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_28 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_29 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_30 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_RM_31 / 1000). "</td>";
//                                        echo "</tr>";
//                                        
//                                        echo "<tr class='gradeX'>";
//                                            echo "<td style=text-align:center;>SAP</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_1 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_2 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_3 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_4 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_5 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_6 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_7 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_8 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_9 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_10 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_11 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_12 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_13 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_14 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_15 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_16 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_17 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_18 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_19 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_20 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_21 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_22 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_23 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_24 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_25 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_26 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_27 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_28 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_29 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_30 / 1000). "</td>";
//                                            echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_SAP_31 / 1000). "</td>";
//                                        echo "</tr>";
//                                    
//                                        echo "<tr class='gradeX'>";
//                                            echo "<td style=text-align:center;>DIFF</td>";
//                                            
//                                            if ($isi->INT_MOVE_DIFF_1 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//                                                echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_1). "</td>";
//
//                                            if ($isi->INT_MOVE_DIFF_2 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//                                                echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_2). "</td>";
//                                                
//                                            if ($isi->INT_MOVE_DIFF_3 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//                                                echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_3). "</td>";
//                                                
//                                            if ($isi->INT_MOVE_DIFF_4 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_4). "</td>";
//                                            
//					    if ($isi->INT_MOVE_DIFF_5 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_5). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_6 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_6). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_7 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_7). "</td>";
//											 
//                                            if ($isi->INT_MOVE_DIFF_8 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_8). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_9 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_9). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_10 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_10). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_11 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_11). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_12 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_12). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_13 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_13). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_14 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_14). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_15 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_15). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_16 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_16). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_17 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_17). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_18 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_18). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_19 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_19). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_20 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_20). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_21 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_21). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_22 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_22). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_23 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_23). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_24 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_24). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_25 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_25). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_26 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_26). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_27 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_27). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_28 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_28). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_29 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//                                                echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_29). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_30 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//						echo "<td style=$red_label text-align:center;>" . number_format($isi->INT_MOVE_DIFF_30). "</td>";
//											
//                                            if ($isi->INT_MOVE_DIFF_31 != 0){ $red_label = 'background-color:#ff1744;color:white;text-align:center;';
//                                            }else{ $red_label = 'background-color:#00c853;color:white;text-align:center;'; }
//                                            echo "<td style=$red_label>" . number_format($isi->INT_MOVE_DIFF_31). "</td>";
//                                        echo "</tr>";

                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="grid-header">                        
                        <div class="pull-left">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</aside>






