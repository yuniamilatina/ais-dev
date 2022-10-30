
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
    .blue{
        background-color :#0ED09C;
    }
</style>


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
var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
window.location.href = uri + base64(format(template, ctx))
}
})()

function getExcelSP(type) {             
    var tanggal = document.getElementById("tanggal").value;
    var tanggal1 = tanggal.substr(tanggal.length - 6);
    var tanggal2 = tanggal.substr(tanggal.length - 11);
    
    var opt_sloc = document.getElementById("opt_sloc").value;

    if(type==1)
    {
        window.location.href = "<?php echo site_url('samanta/report_spare_parts_c_2/export_report_all_data');?>?";
    }
    else if(type == 2)
    {
        window.location.href = "<?php echo site_url('samanta/report_spare_parts_c_2/generate_report_pdf/');?>/"+ tanggal1;
    }
    else
    {
        window.location.href = "<?php echo site_url('samanta/report_spare_parts_c_2/generate_detail/');?>/"+ tanggal2 + "/" + opt_sloc;
    }
}
</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT SPARE PARTS</strong></a></li>
        </ol>
    </section>
    <?php
    $date = new DateTime($first_sunday);
    $thisMonth = $date->format('m');

    $x = 0;
    while ($date->format('m') === $thisMonth) {
        $datesunday[$x] = $date->format('j');
        $date->modify('next Sunday');
        $x++;
    }
    ?>

    <section class="content">
        <script type="text/javascript">
        window.onload = function() {
            // chart_spare_parts_in_out
            var chart_spare_parts_in_out = new CanvasJS.Chart("chart_spare_parts_in_out",
            {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 30
                },
                toolTip: {
                    shared: true
                },
                axisX: {
                    title: "Date",
                    valueFormatString: "####",
                    // gridThickness: 1,
                    interval: 1,
                    stripLines:[
                        <?php
                        for ($a = 0; $a < $x; $a++) {
                            if ($a == $x - 1) { ?>
                                {
                                    startValue: <?php echo $datesunday[$a] - 1; ?>,
                                    endValue:<?php echo $datesunday[$a]; ?>,
                                    color:"#FC3322",
                                    opacity: .2
                                }
                            <?php } else { ?>
                                {
                                    startValue:<?php echo $datesunday[$a] - 1; ?>,
                                    endValue:<?php echo $datesunday[$a]; ?>,
                                    color:"#FC3322",
                                    opacity: .2
                                },
                            <?php
                            }
                        }
                        ?>
                    ]
                },
                axisY: {
                    title: "Amount (*in Million)",
                    gridThickness: 0.3
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount IN",
                    legendText: "Spare Parts In",
                    dataPoints: [
                        <?php
                        $i = 1;
                        while ($i <= $sum_date_this_month) {
                            $j = 0;
                            if($data_spare_parts_in!=0)
                            {
                                foreach ($data_spare_parts_in as $isi_in) {
                                    if ($i == intval($isi_in->CHR_DATE)) {
                                        if ($i != $sum_date_this_month) { ?>
                                            { 
                                                x: <?php echo $i; ?>, 
                                                y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                                indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                            },
                                            <?php
                                            $j = $i;             
                                        } else {
                                            ?>
                                            {
                                                x: <?php echo $i; ?>,
                                                y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                                indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                            }
                                            <?php
                                            $j = $i;
                                        }
                                    }
                                }
                            }
                                
                            if ($j != $i) {
                                if ($i != $sum_date_this_month) {
                                    ?>
                                        { 
                                            x: <?php echo $i; ?>, 
                                            y: <?php echo 0; ?>,
                                            indexLabel: ""
                                        },
                                <?php } else { ?>
                                        { 
                                            x: <?php echo $i; ?>, 
                                            y: <?php echo 0; ?>,
                                            indexLabel: ""
                                        }
                                    <?php
                                }
                            }
                            $i++;
                        }
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc                         
                    color: "#FF4D4D",
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount OUT",
                    legendText: "Spare Parts Out",
                    dataPoints: [
                        <?php
                        $i = 1;
                        while ($i <= $sum_date_this_month) {
                            $j = 0;
                            if($data_spare_parts_out!=0)
                            {
                                foreach ($data_spare_parts_out as $isi_out) {
                                    if ($i == intval($isi_out->CHR_DATE)) {
                                        if ($i != $sum_date_this_month) { ?>
                                            { 
                                                x: <?php echo $i; ?>, 
                                                y: <?php echo $isi_out->CHR_AMOUNT; ?>, 
                                                indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                            },
                                            <?php
                                            $j = $i;             
                                        } else {
                                            ?>
                                            {
                                                x: <?php echo $i; ?>,
                                                y: <?php echo $isi_out->CHR_AMOUNT; ?>,
                                                indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                                
                                            }
                                            <?php
                                            $j = $i;
                                        }
                                    }
                                }
                            }
                                
                            if ($j != $i) {
                                if ($i != $sum_date_this_month) {
                                    ?>
                                        { 
                                            x: <?php echo $i; ?>, 
                                            y: <?php echo 0; ?>,
                                            indexLabel: ""
                                        },
                                <?php } else { ?>
                                        { 
                                            x: <?php echo $i; ?>, 
                                            y: <?php echo 0; ?>,
                                            indexLabel: ""
                                        }
                                    <?php
                                }
                            }
                            $i++;
                        }
                        ?>
                    ]
                }],
                legend: {
                    cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } 
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart_spare_parts_in_out.render();
                        }
                }
            });
            chart_spare_parts_in_out.render();

            // CC
            var chart_cc_in_out = new CanvasJS.Chart("chart_cc_in_out",
            {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 30
                },
                toolTip: {
                    shared: true
                },
                axisX: {
                    interval: 3,
                    intervalType: "month",
                    // title: "",
                    // // valueFormatString: "MMMM",
                    // interval: 1,
                    // intervalType: "month",
                    // gridThickness: 1,
                    // interval: 1,
                },
                axisY: {
                    title: "Amount (*in Million)",
                    gridThickness: 0.3
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount IN",
                    legendText: "Clutch Cover Masuk",
                    dataPoints: [
                        <?php

                            if($data_cc_in!=0)
                            {
                                foreach ($data_cc_in as $isi_in) { 
                                $bulan = (int)substr($isi_in->CHR_DATE, -2)-1; ?>
                                { 
                                    x: new Date(<?php 
                                         echo substr($isi_in->CHR_DATE, 0, -2).',0'.$bulan.'' ?>),
                                    y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                    indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                    // x: new Date(2019,02),
                                    // y: 0,
                                    // indexLabel: 0
                                }           
                                        
                                <?php }
                            }
                            
                            
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc                         
                    color: "#FF4D4D",
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount OUT",
                    legendText: "Clutch Cover Keluar",
                    dataPoints: [
                        <?php
                            if($data_cc_out!=0)
                            {
                                foreach ($data_cc_out as $isi_out) { 
                                $bulan = (int)substr($isi_in->CHR_DATE, -2)-1; ?>
                                { 
                                    x: new Date(<?php 
                                         echo substr($isi_out->CHR_DATE, 0, -2).',0'.$bulan.'' ?>),
                                    y: <?php echo $isi_out->CHR_AMOUNT; ?>, 
                                    indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                    // x: new Date(2019,02),
                                    // y: 0,
                                    // indexLabel: 0
                                }
                                <?php
                                       
                                }
                                
                            }
                            
                        ?>
                    ]
                }],
                legend: {
                    cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } 
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart_cc_in_out.render();
                        }
                }
            });
            <?php
                if($data_cc_out!=0 || $data_cc_in!=0)
                {  ?>
                    chart_cc_in_out.render();
            <?php }
            ?>
            
            // DL
            var chart_dl_in_out = new CanvasJS.Chart("chart_dl_in_out",
            {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 30
                },
                toolTip: {
                    shared: true
                },
                axisX: {
                    title: "",
                    // valueFormatString: "MMMM",
                    interval: 1,
                intervalType: "month",
                    // gridThickness: 1,
                    // interval: 1,
                },
                axisY: {
                    title: "Amount (*in Million)",
                    gridThickness: 0.3
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount IN",
                    legendText: "Door Lock Masuk",
                    dataPoints: [
                        <?php
                            if($data_dl_in!=0)
                            {
                                foreach ($data_dl_in as $isi_in) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_in->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                    indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                },           
                                        
                        <?php }
                            }
                            
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc                         
                    color: "#FF4D4D",
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount OUT",
                    legendText: "Door Lock Keluar",
                    dataPoints: [
                        <?php
                            if($data_dl_out!=0)
                            {
                                foreach ($data_dl_out as $isi_out) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_out->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_out->CHR_AMOUNT; ?>, 
                                    indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                }
                        <?php }
                            }
                            
                        ?>
                    ]
                }],
                legend: {
                    cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } 
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart_dl_in_out.render();
                        }
                }
            });
            
            <?php
                if (($data_dl_in != 0) || ($data_dl_out != 0))
                {  ?>
                    chart_dl_in_out.render();
            <?php }
            ?>
            // BP
            var chart_bp_in_out = new CanvasJS.Chart("chart_bp_in_out",
            {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 30
                },
                toolTip: {
                    shared: true
                },
                axisX: {
                    title: "",
                    // valueFormatString: "MMMM",
                    interval: 1,
                intervalType: "month",
                    // gridThickness: 1,
                    // interval: 1,
                },
                axisY: {
                    title: "Amount (*in Million)",
                    gridThickness: 0.3
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount IN",
                    legendText: "Body Part Masuk",
                    dataPoints: [
                        <?php
                            if($data_bp_in!=0)
                            {
                                foreach ($data_bp_in as $isi_in) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_out->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                    indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                },           
                                        
                                <?php }
                            }
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc                         
                    color: "#FF4D4D",
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount OUT",
                    legendText: "Body Part Keluar",
                    dataPoints: [
                        <?php
                            if($data_bp_out!=0)
                            {
                                foreach ($data_bp_out as $isi_out) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_out->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_out->CHR_AMOUNT; ?>, 
                                    indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                }
                                <?php
                                       
                                }
                                
                            }
                        ?>
                    ]
                }],
                legend: {
                    cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } 
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart_bp_in_out.render();
                        }
                }
            });
            <?php
                if (($data_bp_in != 0) || ($data_bp_out != 0))
                {  ?>
                    chart_bp_in_out.render();
            <?php }
            ?>
            // chart_bp_in_out.render();
            // DF
            var chart_df_in_out = new CanvasJS.Chart("chart_df_in_out",
            {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 30
                },
                toolTip: {
                    shared: true
                },
                axisX: {
                    title: "",
                    // valueFormatString: "MMMM",
                    interval: 1,
                intervalType: "month",
                    // gridThickness: 1,
                    // interval: 1,
                },
                axisY: {
                    title: "Amount (*in Million)",
                    gridThickness: 0.3
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount IN",
                    legendText: "Door Frame Masuk",
                    dataPoints: [
                        <?php
                            if($data_df_in!=0)
                            {
                                foreach ($data_df_in as $isi_in) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_in->CHR_DATE, -2)-1;
                                         echo substr($isi_in->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                    indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                },           
                                        
                                <?php }
                            }
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc                         
                    color: "#FF4D4D",
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount OUT",
                    legendText: "Door Frame Keluar",
                    dataPoints: [
                        <?php
                            if($data_df_out!=0)
                            {
                                foreach ($data_df_out as $isi_out) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_out->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_out->CHR_AMOUNT; ?>, 
                                    indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                }
                                <?php
                                       
                                }
                                
                            }
                        ?>
                    ]
                }],
                legend: {
                    cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } 
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart_df_in_out.render();
                        }
                }
            });
            <?php
                if (($data_df_in != 0) || ($data_df_out != 0))
                {  ?>
                    chart_df_in_out.render();
            <?php }
            ?>
            // chart_df_in_out.render();
            // AL
            var chart_al_in_out = new CanvasJS.Chart("chart_al_in_out",
            {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 30
                },
                toolTip: {
                    shared: true
                },
                axisX: {
                    title: "",
                    // valueFormatString: "MMMM",
                    interval: 1,
                intervalType: "month",
                    // gridThickness: 1,
                    // interval: 1,
                },
                axisY: {
                    title: "Amount (*in Million)",
                    gridThickness: 0.3

                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount IN",
                    legendText: "Improvement IN",
                    dataPoints: [
                        <?php
                            if($data_al_in!=0)
                            {
                                foreach ($data_al_in as $isi_in) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_out->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_in->CHR_AMOUNT; ?>,
                                    indexLabel: "<?php echo number_format($isi_in->CHR_AMOUNT,0,',','.'); ?>"
                                },           
                                        
                                <?php }
                            }
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#FF4D4D",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total Amount OUT",
                    legendText: "Improvement Keluar",
                    dataPoints: [
                        <?php
                            if($data_al_out!=0)
                            {
                                foreach ($data_al_out as $isi_out) { ?>
                                { 
                                    x: new Date(<?php $bulan = (int)substr($isi_out->CHR_DATE, -2)-1;
                                         echo substr($isi_out->CHR_DATE, 0, -2).' , 0'.$bulan.',1' ?>), 
                                    y: <?php echo $isi_out->CHR_AMOUNT; ?>,
                                    indexLabel: "<?php echo number_format($isi_out->CHR_AMOUNT,0,',','.'); ?>"
                                },           
                                        
                                <?php }

                            }
                        ?>
                    ]
                }],
                legend: {
                    cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } 
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart_al_in_out.render();
                        }
                }
            });
            <?php
                if (($data_al_in != 0) || ($data_al_out != 0))
                {  ?>
                    chart_al_in_out.render();
            <?php }
            ?>
            // chart_al_in_out.render();

        }
        </script>


        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>SPARE PARTS REPORT CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <button onclick="getExcelSP(3)" title="Export Detail" class="btn btn-success" style="font-size:12px;"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Export Detail</button>
                            <button onclick="getExcelSP(1)" title="Export All Data to Excel" class="btn btn-success" style="font-size:12px;"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Export All Data</button>
                            <button onclick="getExcelSP(2)" title="Export ACC Data to PDF" class="btn btn-danger" style="font-size:12px;"><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Export ACC Data</button>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php
                                if ($msg != NULL) {
                                    echo $msg;
                                }
                            ?>
                        </div>
                        <div class="pull">
                            <!-- <div class="pull-right grid-tools">
                                <?php //echo form_open('pes_new/report_prod_date_c/print_report_prod_entry', 'class="form-horizontal"'); ?>
                            </div> -->
                            <table width="30%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Period</td>
                                    <td width="5%">
                                        <select id="tanggal" class="form-control" style="width:150px;" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -8; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('samanta/report_spare_parts_c_2/search/' . date("Ym", strtotime("+$x month")).'/'.$sloc2); ?>"<?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="6%">
                                        Warehouse
                                    </td>
                                    <td width="6%">
                                        <select id="opt_sloc" style="width:150px" class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                        <option value="<?php echo site_url('samanta/report_spare_parts_c_2/search/' .$selected_date.'/'); ?>">ALL</option>
                                        <?php
                                        foreach ($w_sloc as $sloc):
                                            $sloc_choose = trim($sloc->CHR_SLOC);
                                            ?>
                                            <option value="<?php echo site_url('samanta/report_spare_parts_c_2/search/' .$selected_date.'/'.$sloc_choose); ?>" <?php
                                            if ($sloc2 == $sloc_choose) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php if (trim($sloc_choose) == 'MT01') { echo "DIES/MOLD MTE"; } 
                                            elseif (trim($sloc_choose) == 'MT02') { echo "DOOR FRAME MTE"; } 
                                            elseif (trim($sloc_choose) == 'MT03') { echo "MACHINE MTE"; }  
                                            elseif (trim($sloc_choose) == 'IT01') { echo "MIS"; } 
                                            elseif (trim($sloc_choose) == 'MS01') { echo "MSU"; } 
                                            elseif (trim($sloc_choose) == 'WH30') { echo "CONSUMABLE"; }
                                            elseif (trim($sloc_choose) == 'EN02') { echo "ENGINEERING"; } ?></option>
                                                <?php endforeach; ?>
                                    </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">

                        <?php if (($data_spare_parts_in == 0) && ($data_spare_parts_out == 0)) { ?>
                             <table width=100% id='filterdiagram' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_spare_parts_in_out" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                        <div align="center">
                            <label><h4>S U M M A R Y</h4></label>
                            <div>
                                <div align="center">
                                    <strong>Total Spare Parts In</strong> : <span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($total_in, 0, ',', '.'); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Total Spare Parts Out</strong> : <span style="font-size: small; font-weight: bold;" class="label label-danger">Rp <?php echo number_format($total_out, 0, ',', '.'); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Total Inventory</strong> : <span style="font-size: small; font-weight: bold;" class="label label-success">Rp <?php echo number_format($inventory, 0, ',', '.'); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <div class="row">
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>CLUTCH COVER CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <?php if (($data_cc_in == 0) && ($data_cc_out == 0)) { ?>
                             <table width=100% id='cc' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_cc_in_out" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>DOOR LOCK CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if (($data_dl_in == 0) && ($data_dl_out == 0)) { ?>
                             <table width=100% id='dl' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_dl_in_out" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                    </div>

                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <div class="row">
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>BODY PART CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <?php if (($data_bp_in == 0) && ($data_bp_out == 0)) { ?>
                             <table width=100% id='bp' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_bp_in_out" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>DOOR FRAME CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if (($data_df_in == 0) && ($data_df_out == 0)) { ?>
                             <table width=100% id='df' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_df_in_out" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>IMPROVEMENT REPORT CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <?php if (($data_al_in == 0) && ($data_al_out == 0)) { ?>
                             <table width=100% id='al' ><td>No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_al_in_out" style="height: 280px; width: 100%;"></div>
                        <?php } ?>
                        <br>
                    </div>

                </div>
            </div>
        </div>
        
    </section>
</aside>
<!--  -->
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >