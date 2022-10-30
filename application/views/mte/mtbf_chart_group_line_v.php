<script src="http://code.highcharts.com/highcharts.js"></script>

 <script type="text/javascript">
 
var chart1;
$(document).ready(function () {
        chart1 = new Highcharts.Chart({
        chart: {
                renderTo: 'chartContainer',
                type: 'line',
                plotBorderWidth: 1
        },
        credits: {
            enabled: false
        },
        title: {
                text: ''
        },
        xAxis: {
                categories: ['Jan', 'Feb', 'Mar','Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
                title: {
                        text: 'Hour'
                },
                // labels: {
                //         formatter: function () {
                //                 return this.value;
                //         }
                // }
        },
        tooltip: {
                crosshairs: true,
                shared: true
        },
        plotOptions: {
                spline: {
                        marker: {
                                radius: 4,
                                lineColor: '#666666',
                                lineWidth: 1
                        }
                }
        },
        series: [

                        <?php
                        foreach ($data_mtbf as $isi) {
                        ?>

                                {
                                        name: <?php echo '"'.$isi->CHR_GROUP_LINE.'"'; ?>,
                                        data: [
                                                <?php echo $isi->COLUMN01; ?>, 
                                                <?php echo $isi->COLUMN02; ?>, 
                                                <?php echo $isi->COLUMN03; ?>, 
                                                <?php echo $isi->COLUMN04; ?>, 
                                                <?php echo $isi->COLUMN05; ?>, 
                                                <?php echo $isi->COLUMN06; ?>, 
                                                <?php echo $isi->COLUMN07; ?>, 
                                                <?php echo $isi->COLUMN08; ?>, 
                                                <?php echo $isi->COLUMN09; ?>, 
                                                <?php echo $isi->COLUMN10; ?>, 
                                                <?php echo $isi->COLUMN11; ?>,
                                                <?php echo $isi->COLUMN12; ?>
                                                ]

                                },
                        <?php 
                        }
                        ?>
                

                ]
        });
});
</script>


<div id="chartContainer" style="height: 300px; width: 100%; "></div> 