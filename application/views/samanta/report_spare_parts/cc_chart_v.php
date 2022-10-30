<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script> 

<script type="text/javascript">

window.onload = function() {

    //report Summary CC
    var chart_summary_cc = new CanvasJS.Chart("chart_summary_cc", {
                animationEnabled: true,
                theme: "light",
                title:{
                    text: ""
                },
                legend: {
                horizontalAlign: "center", 
                verticalAlign: "bottom", 
                fontSize: 12
                },
                axisY:{
                    title: "Percentage (%)",
                    includeZero: false,
                    valueFormatString: "0.0#",
                    gridThickness: 1,
                    opacity: .4
                },
                axisX:{
                title: "Period",
                valueFormatString: "MMM",
                labelAngle: 45
                //    interval:1 
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
                    name: "Total IN CC",
                    legendText: "Spare Parts Masuk",
                    dataPoints: [
                        <?php
                        $inn = "IN";
                        foreach ($summary_in_cc as $in) {
                            echo '{label: "' . $inn . '", y:' . $in->TOTAL_IN . ', indexLabel:"' . number_format($in->TOTAL_IN,0,',','.') . '"}';
                        }
                        ?>
                    ]
                },
                {
                    type: "column", //change type to bar, line, area, pie, etc
                    color: "#1A75FF",   
                    indexLabelPlacement: "outside",
                    indexLabelFontSize: 10,
                    indexLabelFontColor: "black",
                    indexLabelFontWeight: "bold",
                    indexLabelOrientation: "horizontal",
                    showInLegend: true,
                    name: "Total OUT CC",
                    legendText: "Spare Parts Keluar",
                    dataPoints: [
                        <?php
                        $outt = "OUT";
                        foreach ($summary_out_cc as $out) {
                            echo '{label: "' . $outt . '", y:' . $out->TOTAL_OUT . ', indexLabel:"' . number_format($out->TOTAL_OUT,0,',','.') . '"}';
                        }
                        ?>
                    ]
                }]
            });
        chart_summary_cc.render();
}
</script>

<?php if (($summary_in_cc == false) && ($summary_out_cc == false)) { ?>
    <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
<?php } else { ?>
    <div id="chart_summary_cc" style="height: 300px; width: 100%; margin-top:-100px;"></div> 
<?php } ?>