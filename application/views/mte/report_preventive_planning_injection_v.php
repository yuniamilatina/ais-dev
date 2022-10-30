<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<style type="text/css">

    #table-luar{
        font-size: 11px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border : 1px;
    }

    #testDiv{
        width: 100%;
        white-space: nowrap; 
        overflow-x:scroll;
        overflow-y:visible;
        font-size: 12px;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
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
</style>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>HOME</span></a></li>
            <li><a href=""><strong>REPORT PREVENTIVE INJECTION</strong></a></li>
        </ol>
    </section>

        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>REPORT PREVENTIVE INJECTION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                        
                        <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='3' style=text-align:center;>Code Mold </th>
                                    <th rowspan='3' style=text-align:center;>Model </th>
                                    <th rowspan='3' style=text-align:center;>Mold name </th>
                                    <!-- <th rowspan='3' style=text-align:center;>Part No </th> -->
                                    <th rowspan='3' style=text-align:center;>Total </th>
                                    <th colspan='372' style=text-align:center;><?php echo date('Y'); ?></th>
                                </tr>
                                <tr class='gradeX'>
                                    <?php
                                    for ($yx = 1; $yx <= 12; $yx++){
                                        $dateObj   = DateTime::createFromFormat('!m', $yx);
                                        $monthName = $dateObj->format('F'); // March
                                        echo "<td colspan='31' style=text-align:center;>$monthName</td>";
                                    }
                                    ?>
                                </tr>
                                <tr class='gradeX'>
                                    <?php
                                    for ($y = 1; $y <= 12; $y++){
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td style=text-align:center;>$x</td>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_CODE_MOLD</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_MODEL</td>";
                                    echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_MOLD_NAME</td>";
                                    // echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0101)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0102)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0103)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0104)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0105)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0106)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0107)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0108)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0109)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0110)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0111)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0112)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0113)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0114)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0115)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0116)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0117)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0118)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0119)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0120)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0121)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0122)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0123)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0124)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0125)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0126)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0127)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0128)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0129)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0130)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->OK_0131)) . "</td>";

                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0201)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0202)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0203)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0204)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0205)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0206)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0207)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0208)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0209)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0210)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0211)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0212)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0213)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0214)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0215)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0216)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0217)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0218)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0219)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0220)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0221)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0222)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0223)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0224)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0225)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0226)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0227)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0228)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0229)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0230)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->OK_0231)) . "</td>";

                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0301)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0302)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0303)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0304)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0305)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0306)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0307)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0308)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0309)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0310)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0311)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0312)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0313)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0314)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0315)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0316)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0317)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0318)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0319)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0320)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0321)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0322)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0323)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0324)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0325)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0326)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0327)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0328)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0329)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0330)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->OK_0331)) . "</td>";

                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0401)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0402)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0403)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0404)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0405)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0406)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0407)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0408)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0409)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0410)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0411)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0412)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0413)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0414)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0415)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0416)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0417)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0418)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0419)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0420)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0421)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0422)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0423)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0424)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0425)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0426)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0427)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0428)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0429)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0430)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->OK_0431)) . "</td>";
                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0501)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0502)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0503)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0504)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0505)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0506)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0507)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0508)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0509)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0510)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0511)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0512)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0513)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0514)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0515)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0516)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0517)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0518)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0519)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0520)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0521)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0522)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0523)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0524)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0525)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0526)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0527)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0528)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0529)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0530)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->OK_0531)) . "</td>";
                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0601)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0602)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0603)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0604)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0605)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0606)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0607)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0608)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0609)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0610)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0611)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0612)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0613)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0614)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0615)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0616)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0617)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0618)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0619)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0620)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0621)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0622)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0623)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0624)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0625)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0626)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0627)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0628)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0629)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0630)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->OK_0631)) . "</td>";
                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0701)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0702)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0703)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0704)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0705)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0706)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0707)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0708)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0709)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0710)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0711)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0712)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0713)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0714)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0715)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0716)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0717)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0718)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0719)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0720)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0721)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0722)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0723)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0724)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0725)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0726)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0727)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0728)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0729)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0730)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 + $isi->OK_0731)) . "</td>";
                                    
                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0801)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0802)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0803)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0804)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0805)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0806)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0807)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0808)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0809)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0810)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0811)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0812)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0813)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0814)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0815)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0816)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0817)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0818)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0819)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0820)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0821)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0822)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0823)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0824)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0825)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0826)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0827)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0828)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0829)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0830)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->OK_0831)) . "</td>";

                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0901)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0902)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0903)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0904)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0905)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0906)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0907)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0908)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0909)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0910)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0911)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0912)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0913)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0914)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0915)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0916)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0917)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0918)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0919)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0920)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0921)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0922)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0923)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0924)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0925)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0926)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0927)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0928)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0929)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0930)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->OK_0931)) . "</td>";

                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1001)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1002)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1003)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1004)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1005)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1006)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1007)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1008)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1009)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1010)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1011)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1012)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1013)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1014)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1015)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1016)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1017)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1018)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1019)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1020)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1021)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1022)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1023)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1024)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1025)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1026)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1027)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1028)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1029)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1030)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->OK_1031)) . "</td>";

                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1101)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1102)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1103)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1104)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1105)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1106)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1107)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1108)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1109)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1110)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1111)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1112)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1113)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1114)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1115)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1116)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1117)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1118)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1119)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1120)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1121)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1122)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1123)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1124)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1125)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1126)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1127)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1128)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1129)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1130)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->OK_1131)) . "</td>";

                                    
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1201)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1202)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1203)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1204)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1205)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1206)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1207)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1208)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1209)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1210)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1211)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1212)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1213)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1214)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1215)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1216)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1217)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1218)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1219)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1220)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1221)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1222)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1223)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1224)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1225)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1226)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1227)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1228)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1229)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1230)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_01 + $isi->TOTAL_02 + $isi->TOTAL_03 + $isi->TOTAL_04 + $isi->TOTAL_05 + $isi->TOTAL_06 +  $isi->TOTAL_07 + $isi->TOTAL_08 + $isi->TOTAL_09 + $isi->TOTAL_10 + $isi->TOTAL_11 + $isi->OK_1231)) . "</td>";
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
        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->
    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>

                                                            $(document).ready(function () {
                                                    var table = $('#example2').DataTable({
                                                            scrollY: "350px",
                                                            scrollX: true,
                                                            scrollCollapse: true,
                                                            paging: false,
                                                            bFilter: true,
                                                            fixedColumns: {
                                                            leftColumns: 4
                                                            },
                                                            language: {
                                                                searchPlaceholder: "Search"
                                                            }
                                                    });
                                                    });

</script>