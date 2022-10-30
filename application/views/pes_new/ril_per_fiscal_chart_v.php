<script type="text/javascript">
	var chart1;
	$(document).ready(function() {
		chart1 = new Highcharts.Chart({
			chart: {
				renderTo: 'chartContainer',
				type: 'spline',
				plotBorderWidth: 1
			},
			credits: {
				enabled: false
			},
			title: {
				text: ''
			},
			//subtitle: {
			//text: 'Source: WorldClimate.com'
			//},
			xAxis: {
				categories: ['Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'
				]
			},
			yAxis: {
				title: {
					text: 'Amount RIL'
				},
				min: 0
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
			series: [{
					name: 'ALL',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $all['NO_1'] ?>,
						<?php echo $all['NO_2'] ?>,
						<?php echo $all['NO_3'] ?>,
						<?php echo $all['NO_4'] ?>,
						<?php echo $all['NO_5'] ?>,
						<?php echo $all['NO_6'] ?>,
						<?php echo $all['NO_7'] ?>,
						<?php echo $all['NO_8'] ?>,
						<?php echo $all['NO_9'] ?>,
						<?php echo $all['NO_10'] ?>,
						<?php echo $all['NO_11'] ?>,
						<?php echo $all['NO_12'] ?>
					]

				},

				{
					name: 'BODY PARTS',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $bp['NO_1'] ?>,
						<?php echo $bp['NO_2'] ?>,
						<?php echo $bp['NO_3'] ?>,
						<?php echo $bp['NO_4'] ?>,
						<?php echo $bp['NO_5'] ?>,
						<?php echo $bp['NO_6'] ?>,
						<?php echo $bp['NO_7'] ?>,
						<?php echo $bp['NO_8'] ?>,
						<?php echo $bp['NO_9'] ?>,
						<?php echo $bp['NO_10'] ?>,
						<?php echo $bp['NO_11'] ?>,
						<?php echo $bp['NO_12'] ?>
					]

				},
				{
					name: 'DOOR FRAME',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $df['NO_1'] ?>,
						<?php echo $df['NO_2'] ?>,
						<?php echo $df['NO_3'] ?>,
						<?php echo $df['NO_4'] ?>,
						<?php echo $df['NO_5'] ?>,
						<?php echo $df['NO_6'] ?>,
						<?php echo $df['NO_7'] ?>,
						<?php echo $df['NO_8'] ?>,
						<?php echo $df['NO_9'] ?>,
						<?php echo $df['NO_10'] ?>,
						<?php echo $df['NO_11'] ?>,
						<?php echo $df['NO_12'] ?>
					]

				},
				{
					name: 'DOOR LOCK',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $dl['NO_1'] ?>,
						<?php echo $dl['NO_2'] ?>,
						<?php echo $dl['NO_3'] ?>,
						<?php echo $dl['NO_4'] ?>,
						<?php echo $dl['NO_5'] ?>,
						<?php echo $dl['NO_6'] ?>,
						<?php echo $dl['NO_7'] ?>,
						<?php echo $dl['NO_8'] ?>,
						<?php echo $dl['NO_9'] ?>,
						<?php echo $dl['NO_10'] ?>,
						<?php echo $dl['NO_11'] ?>,
						<?php echo $dl['NO_12'] ?>
					]

				},

				{
					name: 'MANUFACTURE',
					// marker: {
					// symbol: 'diamond'
					// },
					data: [
						<?php echo $ma['NO_1'] ?>,
						<?php echo $ma['NO_2'] ?>,
						<?php echo $ma['NO_3'] ?>,
						<?php echo $ma['NO_4'] ?>,
						<?php echo $ma['NO_5'] ?>,
						<?php echo $ma['NO_6'] ?>,
						<?php echo $ma['NO_7'] ?>,
						<?php echo $ma['NO_8'] ?>,
						<?php echo $ma['NO_9'] ?>,
						<?php echo $ma['NO_10'] ?>,
						<?php echo $ma['NO_11'] ?>,
						<?php echo $ma['NO_12'] ?>
					]
				},
				{
					name: 'UNIT PARTS',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $up['NO_1'] ?>,
						<?php echo $up['NO_2'] ?>,
						<?php echo $up['NO_3'] ?>,
						<?php echo $up['NO_4'] ?>,
						<?php echo $up['NO_5'] ?>,
						<?php echo $up['NO_6'] ?>,
						<?php echo $up['NO_7'] ?>,
						<?php echo $up['NO_8'] ?>,
						<?php echo $up['NO_9'] ?>,
						<?php echo $up['NO_10'] ?>,
						<?php echo $up['NO_11'] ?>,
						<?php echo $up['NO_12'] ?>
					]

				}
			]
		});
	});
</script>

<div id="chartContainer" style="height: 300px; width: 100%; "></div>

<?php echo form_open('pes_new/report_reject_in_line_c/search_amount_by', 'class="form-horizontal"');  ?>
<div class="form-group" style='margin-top:5px;font-size:11px;'>
	<input type='hidden' value='<?php echo $period ?>' name='period'>
	<label class="col-sm-4 control-label"></label>
	<div class="col-sm-4">
		<label class="checkbox-inline">
			<div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" value="Setup" name="Setup" <?php echo $Setup;  ?> class="icheck"></div> Setup
		</label>
		&nbsp;&nbsp;
		<label class="checkbox-inline">
			<div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" value="Process" name="Process" <?php echo $Process;  ?> class="icheck"></div> Process
		</label>
		&nbsp;&nbsp;
		<label class="checkbox-inline">
			<div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" value="Trial" name="Trial" <?php echo $Trial;  ?> class="icheck"></div> Trial
		</label>
		&nbsp;&nbsp;
		<label class="checkbox-inline">
			<div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" value="Broken Test" name="BrokenTest" <?php echo $BrokenTest;  ?> class="icheck"></div> Broken Test
		</label>
	</div>
	<div class="col-sm-4">
		<button type="submit" class="btn btn-default" style="height:30px;width:80px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Refresh</button>
	</div>
</div>
<?php echo form_close();  ?>
