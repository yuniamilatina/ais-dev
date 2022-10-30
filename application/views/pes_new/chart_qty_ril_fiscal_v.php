<!-- <script src="http://code.highcharts.com/highcharts.js"></script> -->

<script type="text/javascript">
	var chart1;
	$(document).ready(function() {
		chart1 = new Highcharts.Chart({
			chart: {
				renderTo: 'chartContainer',
				type: 'spline'
			},
			credits: {
				enabled: false
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'
				]
			},
			yAxis: {
				title: {
					text: 'QTY RIL'
				},
				min: 0
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
					data: [
						<?php echo $all['NOQTY_1']; ?>,
						<?php echo $all['NOQTY_2']; ?>,
						<?php echo $all['NOQTY_3']; ?>,
						<?php echo $all['NOQTY_4']; ?>,
						<?php echo $all['NOQTY_5']; ?>,
						<?php echo $all['NOQTY_6']; ?>,
						<?php echo $all['NOQTY_7']; ?>,
						<?php echo $all['NOQTY_8']; ?>,
						<?php echo $all['NOQTY_9']; ?>,
						<?php echo $all['NOQTY_10']; ?>,
						<?php echo $all['NOQTY_11']; ?>,
						<?php echo $all['NOQTY_12']; ?>
					]

				},
				{
					name: 'BODY PARTS',
					data: [
						<?php echo $bp['NOQTY_1']; ?>,
						<?php echo $bp['NOQTY_2']; ?>,
						<?php echo $bp['NOQTY_3']; ?>,
						<?php echo $bp['NOQTY_4']; ?>,
						<?php echo $bp['NOQTY_5']; ?>,
						<?php echo $bp['NOQTY_6']; ?>,
						<?php echo $bp['NOQTY_7']; ?>,
						<?php echo $bp['NOQTY_8']; ?>,
						<?php echo $bp['NOQTY_9']; ?>,
						<?php echo $bp['NOQTY_10']; ?>,
						<?php echo $bp['NOQTY_11']; ?>,
						<?php echo $bp['NOQTY_12']; ?>
					]

				},
				{
					name: 'DOOR FRAME',
					data: [
						<?php echo $df['NOQTY_1']; ?>,
						<?php echo $df['NOQTY_2']; ?>,
						<?php echo $df['NOQTY_3']; ?>,
						<?php echo $df['NOQTY_4']; ?>,
						<?php echo $df['NOQTY_5']; ?>,
						<?php echo $df['NOQTY_6']; ?>,
						<?php echo $df['NOQTY_7']; ?>,
						<?php echo $df['NOQTY_8']; ?>,
						<?php echo $df['NOQTY_9']; ?>,
						<?php echo $df['NOQTY_10']; ?>,
						<?php echo $df['NOQTY_11']; ?>,
						<?php echo $df['NOQTY_12']; ?>
					]

				},
				{
					name: 'DOOR LOCK',
					data: [
						<?php echo $dl['NOQTY_1']; ?>,
						<?php echo $dl['NOQTY_2']; ?>,
						<?php echo $dl['NOQTY_3']; ?>,
						<?php echo $dl['NOQTY_4']; ?>,
						<?php echo $dl['NOQTY_5']; ?>,
						<?php echo $dl['NOQTY_6']; ?>,
						<?php echo $dl['NOQTY_7']; ?>,
						<?php echo $dl['NOQTY_8']; ?>,
						<?php echo $dl['NOQTY_9']; ?>,
						<?php echo $dl['NOQTY_10']; ?>,
						<?php echo $dl['NOQTY_11']; ?>,
						<?php echo $dl['NOQTY_12']; ?>
					]

				},

				{
					name: 'MANUFACTURE',
					data: [
						<?php echo $ma['NOQTY_1']; ?>,
						<?php echo $ma['NOQTY_2']; ?>,
						<?php echo $ma['NOQTY_3']; ?>,
						<?php echo $ma['NOQTY_4']; ?>,
						<?php echo $ma['NOQTY_5']; ?>,
						<?php echo $ma['NOQTY_6']; ?>,
						<?php echo $ma['NOQTY_7']; ?>,
						<?php echo $ma['NOQTY_8']; ?>,
						<?php echo $ma['NOQTY_9']; ?>,
						<?php echo $ma['NOQTY_10']; ?>,
						<?php echo $ma['NOQTY_11']; ?>,
						<?php echo $ma['NOQTY_12']; ?>
					]
				},
				{
					name: 'UNIT PARTS',
					data: [
						<?php echo $up['NOQTY_1']; ?>,
						<?php echo $up['NOQTY_2']; ?>,
						<?php echo $up['NOQTY_3']; ?>,
						<?php echo $up['NOQTY_4']; ?>,
						<?php echo $up['NOQTY_5']; ?>,
						<?php echo $up['NOQTY_6']; ?>,
						<?php echo $up['NOQTY_7']; ?>,
						<?php echo $up['NOQTY_8']; ?>,
						<?php echo $up['NOQTY_9']; ?>,
						<?php echo $up['NOQTY_10']; ?>,
						<?php echo $up['NOQTY_11']; ?>,
						<?php echo $up['NOQTY_12']; ?>
					]

				}
			]
		});
	});
</script>

<div class='pull-right'>
</div>

<div id="chartContainer" style="height: 300px; width: 100%; "></div>

<?php echo form_open('pes_new/report_reject_in_line_c/search_qty_by', 'class="form-horizontal"');  ?>

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