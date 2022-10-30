<script type="text/javascript">
	var chart1;
	$(document).ready(function() {
		chart1 = new Highcharts.Chart({
			chart: {
				renderTo: 'chartContainer',
				type: 'line'
			},
			credits: {
				enabled: false
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
				title: {
					text: 'Daily Amount RIL'
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
						<?php echo $all['ANG_1']; ?>,
						<?php echo $all['ANG_2']; ?>,
						<?php echo $all['ANG_3']; ?>,
						<?php echo $all['ANG_4']; ?>,
						<?php echo $all['ANG_5']; ?>,
						<?php echo $all['ANG_6']; ?>,
						<?php echo $all['ANG_7']; ?>,
						<?php echo $all['ANG_8']; ?>,
						<?php echo $all['ANG_9']; ?>,
						<?php echo $all['ANG_10']; ?>,
						<?php echo $all['ANG_11']; ?>,
						<?php echo $all['ANG_12']; ?>,
						<?php echo $all['ANG_13']; ?>,
						<?php echo $all['ANG_14']; ?>,
						<?php echo $all['ANG_15']; ?>,
						<?php echo $all['ANG_16']; ?>,
						<?php echo $all['ANG_17']; ?>,
						<?php echo $all['ANG_18']; ?>,
						<?php echo $all['ANG_19']; ?>,
						<?php echo $all['ANG_20']; ?>,
						<?php echo $all['ANG_21']; ?>,
						<?php echo $all['ANG_22']; ?>,
						<?php echo $all['ANG_23']; ?>,
						<?php echo $all['ANG_24']; ?>,
						<?php echo $all['ANG_25']; ?>,
						<?php echo $all['ANG_26']; ?>,
						<?php echo $all['ANG_27']; ?>,
						<?php echo $all['ANG_28']; ?>,
						<?php echo $all['ANG_29']; ?>,
						<?php echo $all['ANG_30']; ?>,
						<?php echo $all['ANG_31']; ?>
					]

				},
				{
					name: 'BODY PARTS',
					data: [
						<?php echo $bp['ANG_1']; ?>,
						<?php echo $bp['ANG_2']; ?>,
						<?php echo $bp['ANG_3']; ?>,
						<?php echo $bp['ANG_4']; ?>,
						<?php echo $bp['ANG_5']; ?>,
						<?php echo $bp['ANG_6']; ?>,
						<?php echo $bp['ANG_7']; ?>,
						<?php echo $bp['ANG_8']; ?>,
						<?php echo $bp['ANG_9']; ?>,
						<?php echo $bp['ANG_10']; ?>,
						<?php echo $bp['ANG_11']; ?>,
						<?php echo $bp['ANG_12']; ?>,
						<?php echo $bp['ANG_13']; ?>,
						<?php echo $bp['ANG_14']; ?>,
						<?php echo $bp['ANG_15']; ?>,
						<?php echo $bp['ANG_16']; ?>,
						<?php echo $bp['ANG_17']; ?>,
						<?php echo $bp['ANG_18']; ?>,
						<?php echo $bp['ANG_19']; ?>,
						<?php echo $bp['ANG_20']; ?>,
						<?php echo $bp['ANG_21']; ?>,
						<?php echo $bp['ANG_22']; ?>,
						<?php echo $bp['ANG_23']; ?>,
						<?php echo $bp['ANG_24']; ?>,
						<?php echo $bp['ANG_25']; ?>,
						<?php echo $bp['ANG_26']; ?>,
						<?php echo $bp['ANG_27']; ?>,
						<?php echo $bp['ANG_28']; ?>,
						<?php echo $bp['ANG_29']; ?>,
						<?php echo $bp['ANG_30']; ?>,
						<?php echo $bp['ANG_31']; ?>
					]

				},
				{
					name: 'DOOR FRAME',
					data: [
						<?php echo $df['ANG_1']; ?>,
						<?php echo $df['ANG_2']; ?>,
						<?php echo $df['ANG_3']; ?>,
						<?php echo $df['ANG_4']; ?>,
						<?php echo $df['ANG_5']; ?>,
						<?php echo $df['ANG_6']; ?>,
						<?php echo $df['ANG_7']; ?>,
						<?php echo $df['ANG_8']; ?>,
						<?php echo $df['ANG_9']; ?>,
						<?php echo $df['ANG_10']; ?>,
						<?php echo $df['ANG_11']; ?>,
						<?php echo $df['ANG_12']; ?>,
						<?php echo $df['ANG_13']; ?>,
						<?php echo $df['ANG_14']; ?>,
						<?php echo $df['ANG_15']; ?>,
						<?php echo $df['ANG_16']; ?>,
						<?php echo $df['ANG_17']; ?>,
						<?php echo $df['ANG_18']; ?>,
						<?php echo $df['ANG_19']; ?>,
						<?php echo $df['ANG_20']; ?>,
						<?php echo $df['ANG_21']; ?>,
						<?php echo $df['ANG_22']; ?>,
						<?php echo $df['ANG_23']; ?>,
						<?php echo $df['ANG_24']; ?>,
						<?php echo $df['ANG_25']; ?>,
						<?php echo $df['ANG_26']; ?>,
						<?php echo $df['ANG_27']; ?>,
						<?php echo $df['ANG_28']; ?>,
						<?php echo $df['ANG_29']; ?>,
						<?php echo $df['ANG_30']; ?>,
						<?php echo $df['ANG_31']; ?>
					]

				},
				{
					name: 'DOOR LOCK',
					data: [
						<?php echo $dl['ANG_1']; ?>,
						<?php echo $dl['ANG_2']; ?>,
						<?php echo $dl['ANG_3']; ?>,
						<?php echo $dl['ANG_4']; ?>,
						<?php echo $dl['ANG_5']; ?>,
						<?php echo $dl['ANG_6']; ?>,
						<?php echo $dl['ANG_7']; ?>,
						<?php echo $dl['ANG_8']; ?>,
						<?php echo $dl['ANG_9']; ?>,
						<?php echo $dl['ANG_10']; ?>,
						<?php echo $dl['ANG_11']; ?>,
						<?php echo $dl['ANG_12']; ?>,
						<?php echo $dl['ANG_13']; ?>,
						<?php echo $dl['ANG_14']; ?>,
						<?php echo $dl['ANG_15']; ?>,
						<?php echo $dl['ANG_16']; ?>,
						<?php echo $dl['ANG_17']; ?>,
						<?php echo $dl['ANG_18']; ?>,
						<?php echo $dl['ANG_19']; ?>,
						<?php echo $dl['ANG_20']; ?>,
						<?php echo $dl['ANG_21']; ?>,
						<?php echo $dl['ANG_22']; ?>,
						<?php echo $dl['ANG_23']; ?>,
						<?php echo $dl['ANG_24']; ?>,
						<?php echo $dl['ANG_25']; ?>,
						<?php echo $dl['ANG_26']; ?>,
						<?php echo $dl['ANG_27']; ?>,
						<?php echo $dl['ANG_28']; ?>,
						<?php echo $dl['ANG_29']; ?>,
						<?php echo $dl['ANG_30']; ?>,
						<?php echo $dl['ANG_31']; ?>
					]

				},

				{
					name: 'MANUFACTURE',
					data: [
						<?php echo $ma['ANG_1']; ?>,
						<?php echo $ma['ANG_2']; ?>,
						<?php echo $ma['ANG_3']; ?>,
						<?php echo $ma['ANG_4']; ?>,
						<?php echo $ma['ANG_5']; ?>,
						<?php echo $ma['ANG_6']; ?>,
						<?php echo $ma['ANG_7']; ?>,
						<?php echo $ma['ANG_8']; ?>,
						<?php echo $ma['ANG_9']; ?>,
						<?php echo $ma['ANG_10']; ?>,
						<?php echo $ma['ANG_11']; ?>,
						<?php echo $ma['ANG_12']; ?>,
						<?php echo $ma['ANG_13']; ?>,
						<?php echo $ma['ANG_14']; ?>,
						<?php echo $ma['ANG_15']; ?>,
						<?php echo $ma['ANG_16']; ?>,
						<?php echo $ma['ANG_17']; ?>,
						<?php echo $ma['ANG_18']; ?>,
						<?php echo $ma['ANG_19']; ?>,
						<?php echo $ma['ANG_20']; ?>,
						<?php echo $ma['ANG_21']; ?>,
						<?php echo $ma['ANG_22']; ?>,
						<?php echo $ma['ANG_23']; ?>,
						<?php echo $ma['ANG_24']; ?>,
						<?php echo $ma['ANG_25']; ?>,
						<?php echo $ma['ANG_26']; ?>,
						<?php echo $ma['ANG_27']; ?>,
						<?php echo $ma['ANG_28']; ?>,
						<?php echo $ma['ANG_29']; ?>,
						<?php echo $ma['ANG_30']; ?>,
						<?php echo $ma['ANG_31']; ?>
					]
				},
				{
					name: 'DRIVE TRAIN',
					data: [
						<?php echo $dt['ANG_1']; ?>,
						<?php echo $dt['ANG_2']; ?>,
						<?php echo $dt['ANG_3']; ?>,
						<?php echo $dt['ANG_4']; ?>,
						<?php echo $dt['ANG_5']; ?>,
						<?php echo $dt['ANG_6']; ?>,
						<?php echo $dt['ANG_7']; ?>,
						<?php echo $dt['ANG_8']; ?>,
						<?php echo $dt['ANG_9']; ?>,
						<?php echo $dt['ANG_10']; ?>,
						<?php echo $dt['ANG_11']; ?>,
						<?php echo $dt['ANG_12']; ?>,
						<?php echo $dt['ANG_13']; ?>,
						<?php echo $dt['ANG_14']; ?>,
						<?php echo $dt['ANG_15']; ?>,
						<?php echo $dt['ANG_16']; ?>,
						<?php echo $dt['ANG_17']; ?>,
						<?php echo $dt['ANG_18']; ?>,
						<?php echo $dt['ANG_19']; ?>,
						<?php echo $dt['ANG_20']; ?>,
						<?php echo $dt['ANG_21']; ?>,
						<?php echo $dt['ANG_22']; ?>,
						<?php echo $dt['ANG_23']; ?>,
						<?php echo $dt['ANG_24']; ?>,
						<?php echo $dt['ANG_25']; ?>,
						<?php echo $dt['ANG_26']; ?>,
						<?php echo $dt['ANG_27']; ?>,
						<?php echo $dt['ANG_28']; ?>,
						<?php echo $dt['ANG_29']; ?>,
						<?php echo $dt['ANG_30']; ?>,
						<?php echo $dt['ANG_31']; ?>
					]

				},
				{
					name: 'ENGINE PART',
					data: [
						<?php echo $ep['ANG_1']; ?>,
						<?php echo $ep['ANG_2']; ?>,
						<?php echo $ep['ANG_3']; ?>,
						<?php echo $ep['ANG_4']; ?>,
						<?php echo $ep['ANG_5']; ?>,
						<?php echo $ep['ANG_6']; ?>,
						<?php echo $ep['ANG_7']; ?>,
						<?php echo $ep['ANG_8']; ?>,
						<?php echo $ep['ANG_9']; ?>,
						<?php echo $ep['ANG_10']; ?>,
						<?php echo $ep['ANG_11']; ?>,
						<?php echo $ep['ANG_12']; ?>,
						<?php echo $ep['ANG_13']; ?>,
						<?php echo $ep['ANG_14']; ?>,
						<?php echo $ep['ANG_15']; ?>,
						<?php echo $ep['ANG_16']; ?>,
						<?php echo $ep['ANG_17']; ?>,
						<?php echo $ep['ANG_18']; ?>,
						<?php echo $ep['ANG_19']; ?>,
						<?php echo $ep['ANG_20']; ?>,
						<?php echo $ep['ANG_21']; ?>,
						<?php echo $ep['ANG_22']; ?>,
						<?php echo $ep['ANG_23']; ?>,
						<?php echo $ep['ANG_24']; ?>,
						<?php echo $ep['ANG_25']; ?>,
						<?php echo $ep['ANG_26']; ?>,
						<?php echo $ep['ANG_27']; ?>,
						<?php echo $ep['ANG_28']; ?>,
						<?php echo $ep['ANG_29']; ?>,
						<?php echo $ep['ANG_30']; ?>,
						<?php echo $ep['ANG_31']; ?>
					]

				}
			]
		});
	});
</script>

<script>
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
		
<div class="pull-right grid-tools">
	<input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcelAmountNg', 'Amount NG')" value="Export to Excel"><i class="fa fa-download-up"></i></input>
</div>

<div id="chartContainer" style="height: 300px; width: 100%; "></div>

<?php echo form_open('pes_new/report_reject_in_line_c/search_day_amount_by', 'class="form-horizontal"');  ?>
<div class="form-group" style='margin-top:40px;font-size:11px;'>
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


<div class="grid-body" style='font-size:11px;'>
	<table id="exportToExcelAmountNg" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
		<thead>
			<tr class='gradeX'>
				<th rowspan="2" style="vertical-align: middle;">Product <br> Category</th>
				<th colspan='31' style="text-align:center;">Date</th>
			</tr>
			<tr class='gradeX'>
				<?php
				for ($x = 1; $x <= 31; $x++) {
					echo "<td style='text-align:center;'><div class='td-fixed'>" . $x . "</div></td>";
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>DRIVE TRAIN</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dt['ANG_31']) . "</td>";
			echo "</tr>";
			?>

			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>BODY PARTS</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($bp['ANG_31']) . "</td>";
			echo "</tr>";
			?>

			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>DOOR LOCK</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($dl['ANG_31']) . "</td>";
			echo "</tr>";
			?>

			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>DOOR FRAME</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($df['ANG_31']) . "</td>";
			echo "</tr>";
			?>

			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>MANUFACTURE</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ma['ANG_31']) . "</td>";
			echo "</tr>";
			?>


			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>ENGINE PART</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($ep['ANG_31']) . "</td>";
			echo "</tr>";
			?>

			<?php
			echo "<tr style=text-align:left; >";
			echo "<td style=text-align:center;><strong>ALL</strong></td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_1']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_2']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_3']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_4']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_5']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_6']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_7']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_8']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_9']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_10']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_11']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_12']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_13']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_14']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_15']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_16']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_17']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_18']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_19']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_20']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_21']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_22']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_23']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_24']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_25']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_26']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_27']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_28']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_29']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_30']) . "</td>";
			echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($all['ANG_31']) . "</td>";
			echo "</tr>";
			?>

		</tbody>
	</table>
</div>