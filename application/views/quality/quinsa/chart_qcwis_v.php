<script type="text/javascript">
	$(document).ready(function() {

		<?php if ($data_qcwis) { ?>
			<?php foreach ($data_qcwis as $isi) { ?>

				new Highcharts.Chart({
					chart: {
						renderTo: '<?php echo $isi->CHECK_POINT_ID; ?>',
						type: 'errorbar',
						backgroundColor: 'rgba(0,0,0,0)',
						plotBorderWidth: 0,
						marginRight: 20,
						marginLeft: 60
						// marginBottom:0,
						// marginTop:0
					},
					exporting: {
						enabled: false
					},
					credits: {
						enabled: false
					},
					legend: {
						enabled: true,
						align: 'right',
						verticalAlign: 'top',
						// layout: 'vertical',
						borderWidth: 0,
						x: 0,
						y: 0
					},
					title: {
						text: '<?php echo $isi->CHR_CHECK_POINT . ' | ' . $part_no; ?>',
						style: {
							fontSize: '14px'
						}
					},
					xAxis: {
						gridLineColor: 'whitesmoke',
						gridLineWidth: 1,
						min: 0,
						offset: 0,
						tickmarkPlacement: 'on',
						labels: {
							style: {
								color: '#9E9E9E',
								fontSize: '11px'
							},
						},
						categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24]
					},
					yAxis: {
						gridLineColor: 'whitesmoke',
						gridLineWidth: 0,
						max: <?php echo $isi->UPPL; ?>,
						min: <?php echo $isi->LOWL; ?>,
						offset: 0,
						title: {
							text: '<?php echo $isi->CHR_UOM; ?>'
						},
						labels: {
							style: {
								color: '#9E9E9E',
								fontSize: '10px'
							}
						},
						plotLines: [{
								color: 'red',
								value: <?php echo $isi->CHR_USL; ?>,
								width: 1,
								zIndex: 90,
								dashStyle: 'longdashdot',
								label: {
									text: 'Max SL <?php echo $isi->CHR_USL; ?>',
									align: 'right',
									style: {
										color: '#adb5bd'
									}
								}
							},
							{
								color: 'red',
								value: <?php echo $isi->CHR_LSL; ?>,
								width: 1,
								zIndex: 90,
								dashStyle: 'longdashdot',
								label: {
									text: 'Min SL <?php echo $isi->CHR_LSL; ?>',
									align: 'right',
									style: {
										color: '#adb5bd'
									}
								}
							}
						]
					},
					series: [

						{
							fillColor: {
								linearGradient: {
									x1: 0,
									y1: 0,
									x2: 0,
									y2: 1
								},
								stops: [
									[0, 'blue'],
									[1, 'rgba(0,0,0,0)']
								]
							},
							name: '<?php echo trim($isi->CHR_CHECK_POINT) . ' (' . $isi->CHR_UOM . ')'; ?>',
							color: 'blue',
							// backgroundColor: '#fcff38',
							data: [
								[<?php echo $isi->MIN_01 . ',' . $isi->MAX_01; ?>],
								[<?php echo $isi->MIN_02 . ',' . $isi->MAX_02; ?>],
								[<?php echo $isi->MIN_03 . ',' . $isi->MAX_03; ?>],
								[<?php echo $isi->MIN_04 . ',' . $isi->MAX_04; ?>],
								[<?php echo $isi->MIN_05 . ',' . $isi->MAX_05; ?>],
								[<?php echo $isi->MIN_06 . ',' . $isi->MAX_06; ?>],
								[<?php echo $isi->MIN_07 . ',' . $isi->MAX_07; ?>],
								[<?php echo $isi->MIN_08 . ',' . $isi->MAX_08; ?>],
								[<?php echo $isi->MIN_09 . ',' . $isi->MAX_09; ?>],
								[<?php echo $isi->MIN_10 . ',' . $isi->MAX_10; ?>],
								[<?php echo $isi->MIN_11 . ',' . $isi->MAX_11; ?>],
								[<?php echo $isi->MIN_12 . ',' . $isi->MAX_12; ?>],
								[<?php echo $isi->MIN_13 . ',' . $isi->MAX_13; ?>],
								[<?php echo $isi->MIN_14 . ',' . $isi->MAX_14; ?>],
								[<?php echo $isi->MIN_15 . ',' . $isi->MAX_15; ?>],
								[<?php echo $isi->MIN_16 . ',' . $isi->MAX_16; ?>],
								[<?php echo $isi->MIN_17 . ',' . $isi->MAX_17; ?>],
								[<?php echo $isi->MIN_18 . ',' . $isi->MAX_18; ?>],
								[<?php echo $isi->MIN_19 . ',' . $isi->MAX_19; ?>],
								[<?php echo $isi->MIN_20 . ',' . $isi->MAX_20; ?>],
								[<?php echo $isi->MIN_21 . ',' . $isi->MAX_21; ?>],
								[<?php echo $isi->MIN_22 . ',' . $isi->MAX_22; ?>],
								[<?php echo $isi->MIN_23 . ',' . $isi->MAX_23; ?>],
								[<?php echo $isi->MIN_24 . ',' . $isi->MAX_24; ?>]
							],
							tooltip: {
								headerFormat: '<em>Pengukuran tanggal {point.key} </em><br/>'
							}
						},

					]
				});

			<?php } ?>
		<?php } ?>
	});
</script>
<div class="card-body">
	<div class="position-relative mb-2">

		<?php if ($data_qcwis) { ?>
			<?php foreach ($data_qcwis as $isi) { ?>
				<hr style='background-color:#6c757d;'>
				<div id="<?php echo $isi->CHECK_POINT_ID; ?>" style="min-width: 400px;  margin: 0 auto;"></div>
				<br>
			<?php } ?>
		<?php } else { ?>
			<div style="min-width: 400px; height: 560px; margin: 0 auto;">
				<span style='width: 100%;font-size:14px;text-align:center;color:#e9ecef;'>Data Not Founded</span>
			</div>
		<?php } ?>
	</div>
</div>