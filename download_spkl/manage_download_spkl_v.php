<script>
	$(document).ready(function() {
		var interval_close = setInterval(closeSideBar, 250);

		function closeSideBar() {
			$("#hide-sub-menus").click();
			clearInterval(interval_close);
		}
	});
</script>
<style type="text/css">
	th,
	td {
		white-space: nowrap;
	}

	div.dataTables_wrapper {
		width: 100%;
		margin: 0 auto;
	}

	#table-luar {
		font-size: 11px;
	}

	#filter {
		-webkit-border-horizontal-spacing: 0px;
		-webkit-border-vertical-spacing: 10px;
		border-collapse: separate;
	}

	#filterx {
		-webkit-border-horizontal-spacing: 20px;
		-webkit-border-vertical-spacing: 10px;
		border-collapse: separate;
	}

	.td-fixed {
		width: 30px;
	}

	.td-no {
		width: 10px;
	}

	.ddl {
		width: 120px;
		height: 30px;
	}

	.ddl2 {
		width: 180px;
		height: 30px;
	}

	.fileUpload {
		position: relative;
		overflow: hidden;
		width: 100px;
		margin-left: 15px;
	}

	.fileUpload input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}

	.input-upload {
		border: none;
		width: 50px;
		background: transparent;
		text-align: right;
	}

	/* The container */
	.container-radio {
		/* display: block; */
		position: relative;
		padding-left: 30px;
		font-weight: 400;
		cursor: pointer;
		/* font-size: 10pt; */
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
	}

	/* Hide the browser's default radio button */
	.container-radio input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
	}

	/* Create a custom radio button */
	.checkmark {
		position: absolute;
		top: 0;
		left: 0;
		height: 20px;
		width: 20px;
		background-color: #ccc;
		border-radius: 50%;
		/* margin-top: 22px; */
	}

	/* On mouse-over, add a grey background color */
	.container-radio:hover input~.checkmark {
		background-color: darkgrey;
	}

	/* When the radio button is checked, add a blue background */
	.container-radio input:checked~.checkmark {
		background-color: #2196F3;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.container-radio input:checked~.checkmark:after {
		display: block;
	}

	/* Style the indicator (dot/circle) */
	.container-radio .checkmark:after {
		top: 5px;
		left: 5px;
		width: 10px;
		height: 10px;
		border-radius: 50%;
		background: white;
	}

	.vertical-alignment-helper {
		/* untuk form ditengah */
		display: table;
		height: 100%;
		width: 100%;
		pointer-events: none;
	}


	.vertical-align-center {
		/* To center vertically */
		display: table-cell;
		vertical-align: middle;
		pointer-events: none;
	}

	.modal-content {
		/* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it  center*/
		width: fit-content;
		max-width: fit-content;
		/* For Bootstrap 4 - to avoid the modal window stretching full width */
		height: inherit;
		/* To center horizontally */
		margin: 0 auto;
		pointer-events: all;
	}
</style>

<script>
	function exportTemplate() {
		alert('Save as data ke format .xlsx');
		tableToExcel('template_upload');
	}

	var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,',
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/html40/"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
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
				worksheet: name || <?php echo $period; ?>,
				table: table.innerHTML
			}
			window.location.href = uri + base64(format(template, ctx))
		}
	})()
</script>

<aside class="right-side">
	<section class="content-header">
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/aorta/download_spkl_c') ?>"><span>Download SPKL</span></a></li>
		</ol>
	</section>

	<section class="content">
		<?php
		if ($msg != NULL) {
			echo $msg;
		}
		?>

		<div class="row">
			<div class="col-md-12">
				<div class="grid">
					<div class="grid-header">
						<i class="fas fa fa-solid fa-download"></i>
						<span class="grid-title"><strong>DOWNLOAD SPKL</strong></span>
						<?php echo form_open('aorta/download_spkl_c/downloadMultiple', 'class="form-horizontal"'); ?>
						<div class="pull-right grid-tools">
							<!-- <button type="submit" id="download_all" name="download_all" value="1" class=" btn btn-default tombolDownloadAll" style="height:30px;font-size:13px;width:110px;padding-left:10px;">Download All</button> -->
						</div>
						<?php echo form_close(); ?>
					</div>

					<div class="grid-body">

						<div>

							<?php echo form_open('aorta/download_spkl_c/search', 'class="form-horizontal"'); ?>

							<div class="form-row">



								<div class="form-group">
									<label class="col-lg-2 control-label">Dari :</label>
									<div class="col-lg-4">
										<input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="<?php echo $tgl_mulai ?>">
									</div>
								</div>



								<div class="form-group">
									<label class="col-lg-2 control-label">Sampai :</label>
									<div class="col-lg-4">
										<input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" value="<?php echo $tgl_selesai ?>">
									</div>
								</div>



								<div class="form-group">
									<label class="col-lg-2 control-label">Cek GM :</label>
									<div class="col-lg-4">
										<select class="form-control mb-2" name="cek_gm" id="cek_gm">
											<option value="1">Sudah Cek GM</option>
											<option value="0">Belum Cek GM</option>

										</select>
									</div>
								</div>

								<script type="text/javascript">
									document.getElementById('cek_gm').value = "<?php echo $cek_gm ?>";
								</script>




								<div class="form-group">
									<label class="col-lg-2 control-label">Status Download :</label>
									<div class="col-lg-4">
										<select class="form-control mb-2" name="status_download" id="status_download">
											<option value="1">Sudah Download</option>
											<option value="0">Belum Download</option>

										</select>
									</div>
								</div>

								<script type="text/javascript">
									document.getElementById('status_download').value = "<?php echo $status_download ?>";
								</script>




								<div class="form-group">
									<label class="col-lg-2 control-label">Department :</label>
									<div class="col-lg-4">
										<select class="form-control mb-2" name="dept" id="dept">
											<option value="ALL">ALL</option>
											<option value="ENG">ENG</option>
											<option value="QC">QC</option>
											<option value="OMD">OMD</option>
											<option value="MIS">MIS</option>
											<option value="MSU">MSU</option>
											<option value="MTE">MTE</option>
											<option value="PPC">PPC</option>
											<option value="BRP">BRP</option>
											<option value="ERP">ERP</option>
											<option value="QUA">QUA</option>
											<option value="PCO">PCO</option>
										</select>
									</div>
								</div>

								<script type="text/javascript">
									document.getElementById('dept').value = "<?php echo $dept ?>";
								</script>



								<!-- <div class="form-group">
									<label class="col-lg-2 control-label">Department:</label>
									<div class="col-lg-4">
										<select class="form-control mb-2" name="dept" id="dept">
											<?php foreach ($all_dept as $row) { ?>

												<option value="<?php echo $row->CHR_DEPT ?>"> <?php echo $row->CHR_DEPT ?> </option>
											<?php } ?>
										</select>
									</div>
								</div> -->



								<div class="form-group">
									<label class="col-lg-2 control-label"></label>
									<div class="col-lg-4">
										<button type="submit" name="filter_tgl" id="filter_tgl" value="1" class="btn btn-primary">Filter</button>
										<button type="submit" name="download_list" id="download_list" value="1" class="btn btn-warning">Download List</button>
									</div>
								</div>


							</div>
							<?php echo form_close(); ?>

						</div>



						<div class="pull">
							<table id='filter' width="100%">
								<tr>


									<td width="60%">
									</td>
							</table>
						</div>

						<div style="overflow-x:auto;">
							<div id="table-luar">

								<?php echo form_open('aorta/download_spkl_c/downloadMultiple', 'class="form-horizontal"'); ?>

								<table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
									<thead>
										<tr>


											<th style="vertical-align: middle;text-align:center;">SPKL</th>

											<th style="vertical-align: middle;text-align:center;">Trace</th>

											<th style="vertical-align: middle;text-align:center;">Tanggal Overtime</th>

											<th style="vertical-align: middle;text-align:center;">Dept</th>

											<th style="vertical-align: middle;text-align:center;">Jumlah Karyawan</th>

											<th style="vertical-align: middle;text-align:center;">Plan Overtime</th>

											<th style="vertical-align: middle;text-align:center;">Real Overtime</th>

											<th style="vertical-align: middle;text-align:center;">Status Download</th>

											<th style="vertical-align: middle;text-align:center;">Actions</th>
											<th> <input type="checkbox" id="checkall" onClick="toggle(this)" /><br /> </th>

										</tr>
									</thead>
									<tbody>


										<?php foreach ($data_download as $isi) : ?>
											<tr>

												<?php
												if ($isi->status == 'merah') {
												?>
													<td style="vertical-align: middle;text-align:center;color:red"><?= $isi->SPKL ?></td>
												<?php
												} else {
												?>
													<td style="vertical-align: middle;text-align:center;"><?= $isi->SPKL ?></td>
												<?php
												}
												?>
												</td>

												<td style="vertical-align: middle;text-align:center;">

													<?php
													if ($isi->TGL_OVERTIME < date("202107") . "30") {

														echo '<i class="fa fa-duotone fa-check" style="color:green;"></i>';
													} else {

														echo '<i class="fa fa-solid fa-minus"></i>';
													}

													?>


												</td>

												<td style="vertical-align: middle;text-align:center;"><?= $isi->TGL_OVERTIME ?></td>

												<td style="vertical-align: middle;text-align:center;"><?= $isi->KD_DEPT ?></td>

												<td style="vertical-align: middle;text-align:center;"><?= $isi->Karyawan ?></td>

												<td style="vertical-align: middle;text-align:center;"><?= $isi->Plan_OT ?></td>

												<td style="vertical-align: middle;text-align:center;"><?= $isi->Real_OT ?></td>

												<td style="vertical-align: middle;text-align:center;">

													<?php
													if ($isi->FLG_DOWNLOAD == 1) {

														$filepath = base_url('/assets/img/ok_summary.png');
														echo '<img src="' . $filepath . '" height="20">';
													} else {

														$filepath = base_url('/assets/img/ng_summary.png');
														echo '<img src="' . $filepath . '" height="20">';
													}

													?>


												</td>




												<td style="vertical-align: middle;text-align:center;">

													<a data-toggle="modal" data-target="#modal-detail<?php echo $isi->SPKL  ?>" class="btn-detail-class btn btn-info" type="button"><span class="fa fa-search"></span></a>

													<a href="<?php echo base_url('index.php/aorta/download_spkl_c/excel/'.$isi->SPKL); ?>" id="download_refresh" class="btn btn-success"><span class="fa fa-solid fa-download"></span></a>

												</td>

												<td style="vertical-align: middle;text-align:center;">
													<input type="checkbox" name="SPKL[]" class="centangDownloadAll" value="<?php echo $isi->SPKL  ?>"><br />
												</td>
											</tr>


										<?php endforeach; ?>


									</tbody>
								</table>

								<button type="submit" id="download_all" name="download_all" value="1" class=" btn btn-primary tombolDownloadAll" style="height:30px;font-size:13px;width:110px;padding-left:10px;">Download All</button>


								<?php echo form_close(); ?>
							</div>


						</div>


					</div>


				</div>


			</div>
		</div>

	</section>
</aside>





<!-------------------------------------------------------------------------------------------------------------------------------------------->
<!--                                                                                                                                        -->
<!--                                                                                                                                        -->
<!--                                                     START MODAL POP UP                                                                 -->
<!--                                                                                                                                        -->
<!--                                                                                                                                        -->
<!-------------------------------------------------------------------------------------------------------------------------------------------->



<?php foreach ($data_download as $isi) : ?>
	<div class="container">
		<div class="modal fade" id="modal-detail<?php echo $isi->SPKL  ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="vertical-alignment-helper">
				<div class="modal-dialog vertical-align-center" role="document">
					<div class="modal-content">

						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">SPKL <?php echo $isi->SPKL  ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body table responsive">
							<table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
								<thead>
									<tr>

										<!--A -->
										<th style="vertical-align: middle;text-align:center;">Reference No</th>
										<!--B -->
										<th style="vertical-align: middle;text-align:center;">Employee ID</th>
										<!--C -->
										<th style="vertical-align: middle;text-align:center;">Overtime Date</th>
										<!--D -->
										<th style="vertical-align: middle;text-align:center;">Reference Date</th>
										<!--E -->
										<th style="vertical-align: middle;text-align:center;">Overtime In Date</th>
										<!--F -->
										<th style="vertical-align: middle;text-align:center;">Overtime In Time</th>
										<!--G -->
										<th style="vertical-align: middle;text-align:center;">Overtime Out Date</th>
										<!--H -->
										<th style="vertical-align: middle;text-align:center;">Overtime Out Time</th>
										<!--I -->
										<th style="vertical-align: middle;text-align:center;">Remark</th>

									</tr>
								</thead>
								<tbody>


									<?php

									$detail_data_download = $aortadb = $this->load->database("aorta", TRUE);

									$query = $aortadb->query("SELECT NO_SEQUENCE,NPK, CEK_GM, TGL_OVERTIME, TGL_ENTRY, REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME,
							(RTRIM(NPK)+'/'+TGL_OVERTIME+'/01') AS Reference,
							(NO_SEQUENCE+''+CLOSE_TRANS) AS Remark,
							LEFT(REAL_MULAI_OV_TIME, 4) AS OVT_IN_TIME,
							LEFT(REAL_SELESAI_OV_TIME, 4) AS OVT_OUT_TIME,

							CASE
							WHEN REAL_MULAI_OV_TIME > REAL_SELESAI_OV_TIME
							THEN CONVERT(VARCHAR (8), DATEADD(DAY, 1, TGL_OVERTIME), 112)
							ELSE TGL_OVERTIME
							END AS OVT_OUT_DATE


							FROM TT_KRY_OVERTIME
							WHERE CEK_GM = '$isi->CEK_GM' AND NO_SEQUENCE ='$isi->SPKL'
							ORDER BY Remark DESC");


									foreach ($detail_data_download = $query->result() as $key) : ?>
										<tr>
											<!--A -->
											<!--Reference NO -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->Reference ?></td>
											<!--B -->
											<!--Employee ID -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->NPK ?></td>
											<!--C -->
											<!--Overtime Date -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->TGL_OVERTIME ?></td>
											<!--D -->
											<!--Reference Date -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->TGL_ENTRY ?></td>
											<!--E -->
											<!--Overtime In Date -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->TGL_OVERTIME ?></td>
											<!--F -->
											<!--Overtime In Time -->
											<!-- --ambil 4 angka didepan-- LEFT di query -->
											<!-- --REAL_MULAI_OV_TIME-- -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->OVT_IN_TIME ?></td>
											<!--G -->
											<!-- Overtime Out Date -->
											<!-- --ada tambahan if-- CASE WHEN di query -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->OVT_OUT_DATE ?></td>
											<!--H -->
											<!-- Overtime Out Time -->
											<!-- --ambil 4 angka didepan-- LEFT di query -->
											<!-- --REAL_OV_TIME-- -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->OVT_OUT_TIME ?></td>
											<!--I -->
											<!-- Remark -->
											<!--NO SEQUENCE + CLOSE_TRANS -- CONCAT di query -->
											<td style="vertical-align: middle;text-align:center;"><?= $key->Remark ?></td>


										</tr>

									<?php endforeach; ?>




								</tbody>
							</table>

						</div>



					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>


<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.multiDownload.js') ?>"></script>
<script src="<?php echo base_url('assets/js/refresh.js') ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">

<script>
	$(document).ready(function() {
		// var oTable = $('#dataTables3').dataTable({
		// 	stateSave: true
		// });

		// var allPages = oTable.fnGetNodes();

		// $('body').on('click', '#checkall', function() {
		// 	if ($(this).hasClass('allChecked')) {
		// 		$('input[type="checkbox"]', allPages).prop('checked', false);
		// 	} else {
		// 		$('input[type="checkbox"]', allPages).prop('checked', true);
		// 	}
		// 	$(this).toggleClass('allChecked');
		// });


		// var oTable = $('#dataTables3').dataTable({
		// 	stateSave: true
		// });

		// var allPages = oTable.cells().nodes();

		// $('#checkall').click(function() {
		// 	if ($(this).hasClass('allChecked')) {
		// 		$(allPages).find('input[type="checkbox"]').prop('checked', false);
		// 	} else {
		// 		$(allPages).find('input[type="checkbox"]').prop('checked', true);
		// 	}
		// 	$(this).toggleClass('allChecked');
		// });

		var oTable = $('#dataTables3').dataTable({
			stateSave: true,
			"bDestroy": true
		});

		var allPages = oTable.fnGetNodes();

		$('#checkall').click(function(e) {
			if ($(this).hasClass('checkedAll')) {
				$('input', allPages).prop('checked', false);
				$(this).removeClass('checkedAll');
			} else {
				$('input', allPages).prop('checked', true);
				$(this).addClass('checkedAll');
			}
		});


		// $('#checkall').click(function(e) {

		// 	if ($(this).is(":checked")) {
		// 		$('.centangDownloadAll').prop('checked', true);
		// 	} else {
		// 		$('.centangDownloadAll'), prop('checked', false);
		// 	}
		// });

		// $('.download_all').submit(function(e) {
		// 	e.preventDefault();

		// 	let jmldata = $('.centangDownloadAll:checked');

		// 	if (jmldata.length == 0) {
		// 		Swal.fire({
		// 			icon: 'warning',
		// 			title: 'Perhatian',
		// 			text: 'maaf tidak ada yang di download'
		// 		})
		// 	}
		// 	return false;
		// });

	});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	// $('#download_refresh').click(function() {
	// 	location.reload(true);
	// });


	// $('#download_coba').click(function(event) {
	//     event.preventDefault();
	//     $('.satu').multiDownload();
	// });


	// $(document).ready(function() {


	// });



	//                                             $(document).ready(function () {
	//                                                 var table = $('#example').DataTable({
	//                                                     scrollY: "350px",
	//                                                     scrollX: true,
	//                                                     scrollCollapse: true,
	//                                                     paging: true,
	//                                                     fixedColumns: {
	//                                                         leftColumns: 4
	//                                                     }
	//                                                 });

	// //                                                    $('.dataTables_filter input').addClass('search-query');
	//                                                 $('.dataTables_filter input').attr('placeholder', 'Search');
	//                                             });
</script>