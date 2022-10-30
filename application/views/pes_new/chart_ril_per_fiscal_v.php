<script src="http://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
 
var chart1;
$(document).ready(function () {
        chart1 = new Highcharts.Chart({
        chart: {
                renderTo: 'chartContainer',
                zoomType: 'xy'
        },
        credits: {
            enabled: false
        },
        title: {
                text: ''
        },
        xAxis: {
                categories: ['Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar'],
                crosshair: true
        },
        yAxis: [
			{ // Primary yAxis
            title: {
                text: 'Qty',
            	style: {
                        color: Highcharts.getOptions().colors[0]
                    }
            },
            labels: {
                format: '',
                style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
			min:0
			},
			{ // Secondary yAxis
            labels: {
                format: '',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
            title: {
                text: 'Amount',
                style: {
                        color: Highcharts.getOptions().colors[1]
                    }
				},
				min:0,
				opposite: true
			}
		],
        tooltip: {
                shared: true
		},
		legend: {
			verticalAlign: 'bottom'
		},
        series: [ 
				{
					name: 'QTY BODY PARTS',
					type: 'column',
                    data: [
						<?php echo $bp->NOQTY_1; ?>, 
                        <?php echo $bp->NOQTY_2; ?>, 
                        <?php echo $bp->NOQTY_3; ?>, 
                        <?php echo $bp->NOQTY_4; ?>, 
                    	<?php echo $bp->NOQTY_5; ?>, 
                        <?php echo $bp->NOQTY_6; ?>, 
                        <?php echo $bp->NOQTY_7; ?>, 
                        <?php echo $bp->NOQTY_8; ?>, 
                        <?php echo $bp->NOQTY_9; ?>, 
                        <?php echo $bp->NOQTY_10; ?>, 
                        <?php echo $bp->NOQTY_11; ?>,
                        <?php echo $bp->NOQTY_12; ?>
					]
				},
				{
					name: 'AMOUNT BODY PARTS',
					type: 'spline',
					yAxis: 1,
                    data: [
						<?php echo $bp->NOAMO_1; ?>, 
                        <?php echo $bp->NOAMO_2; ?>, 
                        <?php echo $bp->NOAMO_3; ?>, 
                        <?php echo $bp->NOAMO_4; ?>, 
                    	<?php echo $bp->NOAMO_5; ?>, 
                        <?php echo $bp->NOAMO_6; ?>, 
                        <?php echo $bp->NOAMO_7; ?>, 
                        <?php echo $bp->NOAMO_8; ?>, 
                        <?php echo $bp->NOAMO_9; ?>, 
                        <?php echo $bp->NOAMO_10; ?>, 
                        <?php echo $bp->NOAMO_11; ?>,
                        <?php echo $bp->NOAMO_12; ?>
					]
				},

				{
					name: 'QTY UNIT PARTS',
					type: 'column',
                    data: [
						<?php echo $up->NOQTY_1; ?>, 
                        <?php echo $up->NOQTY_2; ?>, 
                        <?php echo $up->NOQTY_3; ?>, 
                        <?php echo $up->NOQTY_4; ?>, 
                    	<?php echo $up->NOQTY_5; ?>, 
                        <?php echo $up->NOQTY_6; ?>, 
                        <?php echo $up->NOQTY_7; ?>, 
                        <?php echo $up->NOQTY_8; ?>, 
                        <?php echo $up->NOQTY_9; ?>, 
                        <?php echo $up->NOQTY_10; ?>, 
                        <?php echo $up->NOQTY_11; ?>,
                        <?php echo $up->NOQTY_12; ?>
					]
				},
				{
					name: 'AMOUNT UNIT PARTS',
					type: 'spline',
					yAxis: 1,
                    data: [
						<?php echo $up->NOAMO_1; ?>, 
                        <?php echo $up->NOAMO_2; ?>, 
                        <?php echo $up->NOAMO_3; ?>, 
                        <?php echo $up->NOAMO_4; ?>, 
                    	<?php echo $up->NOAMO_5; ?>, 
                        <?php echo $up->NOAMO_6; ?>, 
                        <?php echo $up->NOAMO_7; ?>, 
                        <?php echo $up->NOAMO_8; ?>, 
                        <?php echo $up->NOAMO_9; ?>, 
                        <?php echo $up->NOAMO_10; ?>, 
                        <?php echo $up->NOAMO_11; ?>,
                        <?php echo $up->NOAMO_12; ?>
					]
				},

				{
					name: 'QTY DOOR LOCK',
					type: 'column',
                    data: [
						<?php echo $dl->NOQTY_1; ?>, 
                        <?php echo $dl->NOQTY_2; ?>, 
                        <?php echo $dl->NOQTY_3; ?>, 
                        <?php echo $dl->NOQTY_4; ?>, 
                    	<?php echo $dl->NOQTY_5; ?>, 
                        <?php echo $dl->NOQTY_6; ?>, 
                        <?php echo $dl->NOQTY_7; ?>, 
                        <?php echo $dl->NOQTY_8; ?>, 
                        <?php echo $dl->NOQTY_9; ?>, 
                        <?php echo $dl->NOQTY_10; ?>, 
                        <?php echo $dl->NOQTY_11; ?>,
                        <?php echo $dl->NOQTY_12; ?>
					]
				},
				{
					name: 'AMOUNT DOOR LOCK',
					type: 'spline',
					yAxis: 1,
                    data: [
						<?php echo $dl->NOAMO_1; ?>, 
                        <?php echo $dl->NOAMO_2; ?>, 
                        <?php echo $dl->NOAMO_3; ?>, 
                        <?php echo $dl->NOAMO_4; ?>, 
                    	<?php echo $dl->NOAMO_5; ?>, 
                        <?php echo $dl->NOAMO_6; ?>, 
                        <?php echo $dl->NOAMO_7; ?>, 
                        <?php echo $dl->NOAMO_8; ?>, 
                        <?php echo $dl->NOAMO_9; ?>, 
                        <?php echo $dl->NOAMO_10; ?>, 
                        <?php echo $dl->NOAMO_11; ?>,
                        <?php echo $dl->NOAMO_12; ?>
					]
				},

				{
					name: 'QTY DOOR FRAME',
					type: 'column',
                    data: [
						<?php echo $df->NOQTY_1; ?>, 
                        <?php echo $df->NOQTY_2; ?>, 
                        <?php echo $df->NOQTY_3; ?>, 
                        <?php echo $df->NOQTY_4; ?>, 
                    	<?php echo $df->NOQTY_5; ?>, 
                        <?php echo $df->NOQTY_6; ?>, 
                        <?php echo $df->NOQTY_7; ?>, 
                        <?php echo $df->NOQTY_8; ?>, 
                        <?php echo $df->NOQTY_9; ?>, 
                        <?php echo $df->NOQTY_10; ?>, 
                        <?php echo $df->NOQTY_11; ?>,
                        <?php echo $df->NOQTY_12; ?>
					]
				},
				{
					name: 'AMOUNT DOOR FRAME',
					type: 'spline',
					yAxis: 1,
                    data: [
						<?php echo $df->NOAMO_1; ?>, 
                        <?php echo $df->NOAMO_2; ?>, 
                        <?php echo $df->NOAMO_3; ?>, 
                        <?php echo $df->NOAMO_4; ?>, 
                    	<?php echo $df->NOAMO_5; ?>, 
                        <?php echo $df->NOAMO_6; ?>, 
                        <?php echo $df->NOAMO_7; ?>, 
                        <?php echo $df->NOAMO_8; ?>, 
                        <?php echo $df->NOAMO_9; ?>, 
                        <?php echo $df->NOAMO_10; ?>, 
                        <?php echo $df->NOAMO_11; ?>,
                        <?php echo $df->NOAMO_12; ?>
					]
				},

				{
					name: 'QTY MANUFACTURE',
					type: 'column',
                    data: [
						<?php echo $ma->NOQTY_1; ?>, 
                        <?php echo $ma->NOQTY_2; ?>, 
                        <?php echo $ma->NOQTY_3; ?>, 
                        <?php echo $ma->NOQTY_4; ?>, 
                    	<?php echo $ma->NOQTY_5; ?>, 
                        <?php echo $ma->NOQTY_6; ?>, 
                        <?php echo $ma->NOQTY_7; ?>, 
                        <?php echo $ma->NOQTY_8; ?>, 
                        <?php echo $ma->NOQTY_9; ?>, 
                        <?php echo $ma->NOQTY_10; ?>, 
                        <?php echo $ma->NOQTY_11; ?>,
                        <?php echo $ma->NOQTY_12; ?>
					]
				},
				{
					name: 'AMOUNT MANUFACTURE',
					type: 'spline',
					yAxis: 1,
                    data: [
						<?php echo $ma->NOAMO_1; ?>, 
                        <?php echo $ma->NOAMO_2; ?>, 
                        <?php echo $ma->NOAMO_3; ?>, 
                        <?php echo $ma->NOAMO_4; ?>, 
                    	<?php echo $ma->NOAMO_5; ?>, 
                        <?php echo $ma->NOAMO_6; ?>, 
                        <?php echo $ma->NOAMO_7; ?>, 
                        <?php echo $ma->NOAMO_8; ?>, 
                        <?php echo $ma->NOAMO_9; ?>, 
                        <?php echo $ma->NOAMO_10; ?>, 
                        <?php echo $ma->NOAMO_11; ?>,
                        <?php echo $ma->NOAMO_12; ?>
					]
				},

            ]
        });
});
</script>

<div id="chartContainer" style="height: 300px; width: 100%; "></div> 