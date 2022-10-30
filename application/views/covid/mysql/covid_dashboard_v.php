<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script>
window.onload = function () {
var chart = new CanvasJS.Chart("chartContainer", {
  theme: "theme1", 
  animationEnabled: true,
  title: {
  },
  axisX: {
    interval: 1
  },
  axisY2: {
    title: "",
    gridThickness:0.01,
    titleFontSize: 10,
    includeZero: true,
    suffix: ""
  },
  data: [{
    type: "bar",
    indexLabelPlacement: "outside",
    indexLabelFontSize: 10,
    indexLabelFontColor: "black",
    indexLabel: "{y}",
    dataPoints: [

		<?php foreach($dept_case as $row){ ?>
			{ label: '<?php echo $row->dept; ?>', y: <?php echo $row->total; ?>  },
		<?php } ?>
    ]
  }]
});
chart.render();
}
</script>


<script type="text/javascript">
    var chart1;
    $(document).ready(function () {
    chart1 = new Highcharts.Chart({
    chart: {
    renderTo: 'container',
            type: 'spline',
            plotBorderWidth: 1
    },
            credits: {
             enabled: false
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            title: {
            text: ''
            },
            xAxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
            },
            yAxis: {
                tickInterval: 1,
                title: {
                    text: 'Case'
                },
                min:0
            },
            series: [
<?php
    foreach ($data_daily_status_case as $row) {
        ?>
                                    {
                                    name: '<?php echo $row->status_covid; ?>',
                                            data: [
        <?php
        echo $row->DT_01 . ',' . $row->DT_02 . ',' . $row->DT_03 . ',' . $row->DT_04 . ',' . $row->DT_05 . ',' . $row->DT_06 . ',' . $row->DT_07 . ',' . $row->DT_08 . ',' . $row->DT_09
        . ',' . $row->DT_10 . ',' . $row->DT_11 . ',' . $row->DT_12 . ',' . $row->DT_13 . ',' . $row->DT_14 . ',' . $row->DT_15 . ',' . $row->DT_16 . ',' . $row->DT_17
        . ',' . $row->DT_18 . ',' . $row->DT_19 . ',' . $row->DT_20 . ',' . $row->DT_21 . ',' . $row->DT_22 . ',' . $row->DT_23 . ',' . $row->DT_24 . ',' . $row->DT_25
        . ',' . $row->DT_26 . ',' . $row->DT_27 . ',' . $row->DT_28 . ',' . $row->DT_29 . ',' . $row->DT_30 . ',' . $row->DT_31;
        ?>
                                            ]
                                    },
        <?php
    }
?>
                            ]
                    });
                    });
                </script>

<style>
	.zoom {
		transition: transform .2s; /* Animation */
	}

	.zoom:hover {
		transform: scale(1.03); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
	}
</style>

<aside class="right-side">
	<section class="content-header">
		<span>Covid-19 Dashboard</span>
		<ol class="breadcrumb">
			<li><a href="index.html">Home</a></li>
			<li class="active">Covid-19 Dashboard</li>
		</ol>
	</section>

    <section class="content">
		<?php
            if ($notif != NULL) {
                echo $notif;
            }
        ?>
		<div class="row">
					<!-- BEGIN WIDGET -->
					<div class="col-sm-12">
						<div class="row">
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="grid widget bg-blue zoom">
									<div class="grid-body" >
										<span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $total_case; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Confirmed (+)
											<span style='text-align:left;margin-left:5px;font-size:9px;font-style:italic;text-transform:lowercase;'>Start from June</span>
										</span>
										<span class="title" style='text-align:left;margin-left:5px;'><?php echo $total_case_today; ?> New Case</span>
										<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/plus.svg')?>" >
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="grid widget bg-yellow zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $active_case; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Active Case (+)</span>
										<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'>20 %</span>
										<span class="title" style='text-align:left;margin-left:5px;'>+ <?php echo $active_case_today; ?> Active Case</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/virus.svg')?>" >
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="grid widget bg-green zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $recovery; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Recovery</span>
										<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'>20 %</span>
										<span class="title" style='text-align:left;margin-left:5px;'>+ <?php echo $recovery_today; ?> Recovery</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/recovery.svg')?>" >
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="grid widget bg-maroon zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong>Case Number</strong></span>
										<span class="title" style='text-align:left;margin-left:5px;'><?php echo $last_case; ?></span>
										<span class="title" style='text-align:left;margin-left:5px;'>Starting from the data created</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/case.svg')?>" >
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END WIDGET -->
		</div>

        <div class="row">
					<!-- BEGIN WIDGET -->
					<div class="col-sm-12">
						<div class="row">
							
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="grid stat bg-white">
                                        <div class="grid-body">
                                            <div id="chartContainer" style="height: 200px; width: 100%;"></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="grid widget bg-orange zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $isoman; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Self Isolation</span>
										<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $isoman_today; ?> Self Isolation</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/isoman.svg')?>" >
									</div>
								</div>
							</div>

                            <div class="col-lg-6 col-md-4 col-sm-6">
								<div class="grid widget bg-aqua zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $vaksin1; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>1st Vaccination</span>
										<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'>20 %</span>
										<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $vaksin1_today; ?> Vaccination</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/vaccine1.svg')?>" >
									</div>
								</div>
							</div>

                            <div class="col-lg-3 col-md-4 col-sm-6">
								<div class="grid widget bg-red zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $hospitalized; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Hospitalized</span>
										<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $hospitalized_today; ?> Hospitalized</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/hospitalized.svg')?>" >
									</div>
								</div>
							</div>

                            <div class="col-lg-6 col-md-4 col-sm-6">
								<div class="grid widget bg-purple zoom">
									<div class="grid-body">
                                        <span class="value" style='text-align:left;margin-left:5px;'><strong><?php echo $vaksin2; ?></strong></span>
										<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>2nd Vaccination</span>
										<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'>20 %</span>
										<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $vaksin2_today; ?> Vaccination</span>
                                        <img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/vaccine2.svg')?>" >
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- END WIDGET -->
		</div>

		<div class="row">
            <div class="col-md-12">
                <div class="grid">
                    
                    <div class="grid-header bg-blue">
                        <i class="fa fa-chart"></i>
                        <span class="grid-title">Perkembangan Kasus Covid 19</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
					<div class="grid-body">
						<div class="pull">
							<table width="100%" id='filter'>
								<tr>
									<td width="100%" style='text-align:right;padding-right:30px;' >
										<select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
											<?php for ($x = -5; $x <= 0; $x++) { ?>
												<option value="<? echo site_url('basis/home_c/index/' . date("Ym", strtotime("+$x month"))); ?>" <?php
												if ($period == date("Ym", strtotime("+$x month"))) {
													echo 'SELECTED';
												}
												?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
													<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</div>
                    <div class="grid-body">
					<?php if ($data_daily_status_case == false) { ?>
						<table width=100% ><td> No data available in diagram</td></table>
					<?php } else { ?>
						<div id="container" style="height: 300px; width: 100%;"></div>
					<?php } ?>
                    </div>
                </div>
            </div>
        </div>
       
	</section>
</aside>