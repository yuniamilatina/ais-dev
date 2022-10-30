<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script> 

<script type="text/javascript">

window.onload = function() {

    var chart_summary_efficiency = new CanvasJS.Chart("chartSummaryEfficiency", {
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
            type: "line",
            showInLegend: true,
            color: "#00AB55",
            legendText: "Formula : (Work Time - Bridging) / Work Time * 100", 
            dataPoints: [
            
    <?php
    foreach ($summary_efficiency as $isi) {
            ?>

                { x: new Date(<?php echo $isi->YEAR_START; ?>, 3), y: <?php echo $isi->NO_1; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 4), y: <?php echo $isi->NO_2; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 5), y: <?php echo $isi->NO_3; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 6), y: <?php echo $isi->NO_4; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 7), y: <?php echo $isi->NO_5; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 8), y: <?php echo $isi->NO_6; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 9), y: <?php echo $isi->NO_7; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 10), y: <?php echo $isi->NO_8; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 11), y: <?php echo $isi->NO_9; ?> },
                { x: new Date(<?php echo $isi->YEAR_START; ?>, 12), y: <?php echo $isi->NO_10; ?> }, //indexLabel: "highest",markerColor: "red", markerType: "triangle" 
                { x: new Date(<?php echo $isi->YEAR_END; ?>, 1), y: <?php echo $isi->NO_11; ?> },
                { x: new Date(<?php echo $isi->YEAR_END; ?>, 2), y: <?php echo $isi->NO_12; ?> }
                
                <?php
            }
            ?>

                ]
        }]
    });
    chart_summary_efficiency.render();

}
</script>

<?php if ($summary_efficiency == false) { ?>
    <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
<?php } else { ?>
    <div id="chartSummaryEfficiency" style="height: 300px; width: 100%; margin-top:-100px;"></div> 
<?php } ?>