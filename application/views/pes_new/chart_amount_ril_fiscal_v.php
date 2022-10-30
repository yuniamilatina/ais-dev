
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
						<?php echo $all['NOAMO_1'] ?>,
						<?php echo $all['NOAMO_2'] ?>,
						<?php echo $all['NOAMO_3'] ?>,
						<?php echo $all['NOAMO_4'] ?>,
						<?php echo $all['NOAMO_5'] ?>,
						<?php echo $all['NOAMO_6'] ?>,
						<?php echo $all['NOAMO_7'] ?>,
						<?php echo $all['NOAMO_8'] ?>,
						<?php echo $all['NOAMO_9'] ?>,
						<?php echo $all['NOAMO_10'] ?>,
						<?php echo $all['NOAMO_11'] ?>,
						<?php echo $all['NOAMO_12'] ?>
					]

				},

				{
					name: 'BODY PARTS',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $bp['NOAMO_1'] ?>,
						<?php echo $bp['NOAMO_2'] ?>,
						<?php echo $bp['NOAMO_3'] ?>,
						<?php echo $bp['NOAMO_4'] ?>,
						<?php echo $bp['NOAMO_5'] ?>,
						<?php echo $bp['NOAMO_6'] ?>,
						<?php echo $bp['NOAMO_7'] ?>,
						<?php echo $bp['NOAMO_8'] ?>,
						<?php echo $bp['NOAMO_9'] ?>,
						<?php echo $bp['NOAMO_10'] ?>,
						<?php echo $bp['NOAMO_11'] ?>,
						<?php echo $bp['NOAMO_12'] ?>
					]

				},
				{
					name: 'DOOR FRAME',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $df['NOAMO_1'] ?>,
						<?php echo $df['NOAMO_2'] ?>,
						<?php echo $df['NOAMO_3'] ?>,
						<?php echo $df['NOAMO_4'] ?>,
						<?php echo $df['NOAMO_5'] ?>,
						<?php echo $df['NOAMO_6'] ?>,
						<?php echo $df['NOAMO_7'] ?>,
						<?php echo $df['NOAMO_8'] ?>,
						<?php echo $df['NOAMO_9'] ?>,
						<?php echo $df['NOAMO_10'] ?>,
						<?php echo $df['NOAMO_11'] ?>,
						<?php echo $df['NOAMO_12'] ?>
					]

				},
				{
					name: 'DOOR LOCK',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $dl['NOAMO_1'] ?>,
						<?php echo $dl['NOAMO_2'] ?>,
						<?php echo $dl['NOAMO_3'] ?>,
						<?php echo $dl['NOAMO_4'] ?>,
						<?php echo $dl['NOAMO_5'] ?>,
						<?php echo $dl['NOAMO_6'] ?>,
						<?php echo $dl['NOAMO_7'] ?>,
						<?php echo $dl['NOAMO_8'] ?>,
						<?php echo $dl['NOAMO_9'] ?>,
						<?php echo $dl['NOAMO_10'] ?>,
						<?php echo $dl['NOAMO_11'] ?>,
						<?php echo $dl['NOAMO_12'] ?>
					]

				},

				{
					name: 'MANUFACTURE',
					// marker: {
					// symbol: 'diamond'
					// },
					data: [
						<?php echo $ma['NOAMO_1'] ?>,
						<?php echo $ma['NOAMO_2'] ?>,
						<?php echo $ma['NOAMO_3'] ?>,
						<?php echo $ma['NOAMO_4'] ?>,
						<?php echo $ma['NOAMO_5'] ?>,
						<?php echo $ma['NOAMO_6'] ?>,
						<?php echo $ma['NOAMO_7'] ?>,
						<?php echo $ma['NOAMO_8'] ?>,
						<?php echo $ma['NOAMO_9'] ?>,
						<?php echo $ma['NOAMO_10'] ?>,
						<?php echo $ma['NOAMO_11'] ?>,
						<?php echo $ma['NOAMO_12'] ?>
					]
				},
				{
					name: 'UNIT PARTS',
					// marker: {
					// symbol: 'square'
					// },
					data: [
						<?php echo $up['NOAMO_1'] ?>,
						<?php echo $up['NOAMO_2'] ?>,
						<?php echo $up['NOAMO_3'] ?>,
						<?php echo $up['NOAMO_4'] ?>,
						<?php echo $up['NOAMO_5'] ?>,
						<?php echo $up['NOAMO_6'] ?>,
						<?php echo $up['NOAMO_7'] ?>,
						<?php echo $up['NOAMO_8'] ?>,
						<?php echo $up['NOAMO_9'] ?>,
						<?php echo $up['NOAMO_10'] ?>,
						<?php echo $up['NOAMO_11'] ?>,
						<?php echo $up['NOAMO_12'] ?>
					]

				}
			]
		});
	});
</script>

<div class='pull-right'>
</div>

<div id="chartContainer" style="height: 300px; width: 100%; "></div>

<?php echo form_open('pes_new/report_reject_in_line_c/search_amount_by', 'class="form-horizontal"');  ?>
<div class="form-group" style='margin-top:20px;font-size:11px;'>
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
	<div class="col-sm-2">
		<button type="submit" class="btn btn-default" style="height:30px;width:80px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Refresh</button>
	</div>
	<div class="col-sm-2">
		<label style='font-size:11px;font-weight:300;font-style: italic;color:smokescreen;'><?php echo 'Last Update : ' . date("d-m-Y", strtotime($lastUpdate->CHR_MODIFIED_DATE)) . ' ' . date("h:i", strtotime($lastUpdate->CHR_MODIFIED_TIME)) ?></label>
	</div>
</div>
<?php echo form_close();  ?>