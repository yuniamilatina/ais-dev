<script type="text/javascript">
	$(document).ready(function() {
		var chart1 = new Highcharts.Chart({
			chart: {
				renderTo: 'groupContainer',
				type: 'bar',
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
				categories: ['ADV', 'DIR', 'ENG', 'FAC', 'HRG', 'MKT', 'PRO', 'PUR'],
				labels: {
					style: {
						fontSize: '8px'
					}
				},
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				// tickInterval: 1,
				title: {
					text: ''
				}
			},
			series: [{
				showInLegend: false,
				name: 'Active Case ',
				data: [{
						y: <?php echo $case_by_div->ADV; ?>,
						color: '#FAFF00'
					},
					{
						y: <?php echo $case_by_div->DIR; ?>,
						color: '#DA0037'
					},
					{
						y: <?php echo $case_by_div->ENG; ?>,
						color: '#FF5200'
					},
					{
						y: <?php echo $case_by_div->FAC; ?>,
						color: '#78DEC7'
					},
					{
						y: <?php echo $case_by_div->HRG; ?>,
						color: '#D62AD0'
					},
					{
						y: <?php echo $case_by_div->MKT; ?>,
						color: '#FF8882'
					},
					{
						y: <?php echo $case_by_div->PRO; ?>,
						color: '#185ADB'
					},
					{
						y: <?php echo $case_by_div->PUR; ?>,
						color: '#4AA96C'
					}
				]

			}]
		});

		var chart2 = new Highcharts.Chart({
			chart: {
				renderTo: 'dailyContainer',
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
					'22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
				]
			},
			yAxis: {
				tickInterval: 1,
				title: {
					text: 'Case'
				},
				min: 0
			},
			series: [
				<?php
				foreach ($data_daily_status_case as $row) {
					if ($row->STATUS_COVID == 'Negative') {
						$color = '#71EFA3';
					} else {
						$color = '#FF616D';
					}
				?> {
						name: '<?php echo $row->STATUS_COVID; ?>',
						color: '<?php echo $color; ?>',
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


		var chart3 = new Highcharts.Chart({
			chart: {
				renderTo: 'compareContainer',
				type: 'column',
				plotBorderWidth: 1
			},
			credits: {
				enabled: false
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Case'
				}
			},
			tooltip: {
				valueSuffix: ' Cases'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {},
			series: [

				<?php
				foreach ($data_monthly_status_case as $row) {
					if ($row->STATUS_COVID == 'Negative') {
						$color = '#71EFA3';
					} else {
						$color = '#FF616D';
					}
				?>

					{
						name: '<?php echo $row->STATUS_COVID; ?>',
						color: '<?php echo $color; ?>',
						data: [
							<?php echo $row->Jan . ',' . $row->Feb . ',' . $row->Mar . ',' . $row->Apr . ',' . $row->May
								. ',' . $row->Jun . ',' . $row->Jul . ',' . $row->Aug . ',' . $row->Sep . ',' . $row->Oct . ',' . $row->Nov . ',' . $row->Dec; ?>
						]
					},

				<?php } ?>

			]
		});


	});
</script>

<style>
	.zoom {
		transition: transform .2s;
		/* Animation */
	}

	.zoom:hover {
		transform: scale(1.03);
		/* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
	}
</style>
<aside class="right-side">
	<section class="content-header">
		<span>Covid-19 Dashboard</span>
		<ol style='text-align:right;margin-top:-25px;margin-right:10px;' class="breadcrumb">
			<li><?php echo 'Data displayed for data entered on ' . date('F j, Y', strtotime(' -1 day')); ?> </li>
		</ol>
	</section>

	<section class="content">
		<?php
		if ($notif != NULL) {
			echo $notif;
		}
		?>

		<div class='alert alert-danger'><strong>Data bersifat confidential, </strong>mohon untuk tidak disebarluaskan. </div>

		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-blue zoom">
							<div class="grid-body">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $cutoff_case; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Confirmed (+)
									<span style='text-align:left;margin-left:5px;font-size:9px;font-style:italic;text-transform:lowercase;'>Start from June</span>
									<span class="title" style='text-align:left;margin-left:5px;'>+ <?php echo $cutoff_case_today; ?> New Case</span>
									<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/plus.svg') ?>">
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-yellow zoom">
							<div class="grid-body" style='cursor: pointer;' onclick="window.open('<?php echo base_url('/index.php/covid/covid_c/index/0/1') ?>','_newtab');">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $active_case; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Active Case (+)</span>
								<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'><?php echo $active_case_per ?>%</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+ <?php echo $active_case_today; ?> Active Case</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/virus.svg') ?>">
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-green zoom">
							<div class="grid-body" style='cursor: pointer;' onclick="window.open('<?php echo base_url('/index.php/covid/covid_c/index/0/0') ?>','_newtab');">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo (int)$total_case - (int)$active_case; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Recovery</span>
								<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'><?php echo round(((int)$total_case - (int)$active_case) / $total_case * 100, 2) ?>%</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+ <?php echo $recovery_today; ?> Recovery</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/recovery.svg') ?>">
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-maroon zoom">
							<div class="grid-body">
								<span class="value" style='text-align:left;margin-left:5px;'><strong>Case Number</strong></span>
								<span class="title" style='text-align:left;margin-left:5px;'><?php echo $total_case; ?></span>
								<span class="title" style='text-align:left;margin-left:5px;'>Starting from the data created</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/case.svg') ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="row">

					<div class="col-lg-3">
						<div class="row">
							<div class="col-md-12">
								<div class="grid stat bg-white">
									<div class="grid-body">
										<div id="groupContainer" style="height: 200px; width: 100%;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-orange zoom">
							<div class="grid-body">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $isoman; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Self Isolation</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $isoman_today; ?> Self Isolation</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/isoman.svg') ?>">
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-aqua zoom">
							<div class="grid-body">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $vaksin1; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>1st Vaccination</span>
								<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'><?php echo $vaksin1_per ?>%</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $vaksin1_today; ?> Vaccination</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/vaccine1.svg') ?>">
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-fuchsia zoom">
							<div class="grid-body">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $vaksin2; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>2nd Vaccination</span>
								<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'><?php echo $vaksin2_per ?>%</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $vaksin2_today; ?> Vaccination</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/vaccine3.svg') ?>">
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="grid widget bg-red zoom">
							<div class="grid-body">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $hospitalized; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>Hospitalized</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $hospitalized_today; ?> Hospitalized</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/hospitalized.svg') ?>">
							</div>
						</div>
					</div>

					<div class="col-lg-6 col-md-4 col-sm-6">
						<div class="grid widget bg-purple zoom">
							<div class="grid-body">
								<span class="value" style='font-size:35px;text-align:left;margin-left:5px;'><strong><?php echo $vaksin3; ?></strong></span>
								<span class="title" style='text-align:left;margin-left:5px;text-transform:uppercase;'>3rd Vaccination (Booster)</span>
								<span class="title" style='position: absolute;margin-right:5px; top: 0px; right: 0px;'><?php echo $vaksin3_per ?>%</span>
								<span class="title" style='text-align:left;margin-left:5px;'>+<?php echo $vaksin3_today; ?> Vaccination</span>
								<img class='zoom' style='position: absolute; bottom: 0px; right: 0px;' src="<?php echo base_url('assets/img/covid/vaccine2.svg') ?>">
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="grid">

					<div class="grid-header bg-blue">
						<i class="fa fa-bar-chart-o"></i>
						<span class="grid-title">Perkembangan Harian Kasus Covid 19</span>
						<div class="pull-right grid-tools">
							<a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
						</div>
					</div>
					<div class="grid-body">
						<div class="pull">
							<table width="100%" id='filter'>
								<tr>
									<td width="100%" style='text-align:right;padding-right:10px;'>
										<select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
											<?php for ($x = -5; $x <= 0; $x++) { ?>
												<option value="<? echo site_url('basis/home_c/index/' . $year . '/' . date("Ym", strtotime("+$x month"))); ?>" <?php
																																							if ($period == date("Ym", strtotime("+$x month"))) {
																																								echo 'SELECTED';
																																							}
																																							?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="grid-body">
						<?php if ($data_daily_status_case == false) { ?>
							<table width=100%>
								<td> No data available in diagram</td>
							</table>
						<?php } else { ?>
							<div id="dailyContainer" style="height: 300px; width: 100%;"></div>
						<?php } ?>
					</div>

				</div>
			</div>
			<!-- </div>
       
		<div class="row"> -->
			<div class="col-md-6">
				<div class="grid">
					<div class="grid-header bg-green">
						<i class="fa fa-bar-chart-o"></i>
						<span class="grid-title">Perkembangan Bulanan Kasus Covid 19</span>
						<div class="pull-right grid-tools">
							<a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
						</div>
					</div>
					<div class="grid-body">
						<div class="pull">
							<table width="100%" id='filter'>
								<tr>
									<td width="100%" style='text-align:right;padding-right:10px;'>
										<select class="ddl" style='width:80px;' onChange="document.location.href = this.options[this.selectedIndex].value;">
											<?php for ($x = -5; $x <= 0; $x++) { ?>
												<option value="<? echo site_url('basis/home_c/index/' . date("Y", strtotime("+$x year")) . '/' . $period); ?>" <?php
																																							if ($year == date("Y", strtotime("+$x year"))) {
																																								echo 'SELECTED';
																																							}
																																							?>> <?php echo date("Y", strtotime("+$x year")); ?> </option>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="grid-body">
						<?php if ($data_monthly_status_case == false) { ?>
							<table width=100%>
								<td> No data available in diagram</td>
							</table>
						<?php } else { ?>
							<div id="compareContainer" style="height: 300px; width: 100%;"></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

	</section>
</aside>