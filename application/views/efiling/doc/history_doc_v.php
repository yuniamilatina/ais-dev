<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/section_c/') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/pos_c/index/NULL' . "/" . $data_id_subsection) ?>"><span><?php echo $data_name_subsection;?></span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/doc_c/index/NULL' . "/" . $data_id_pos) ?>"><span>Pos <?php echo $data_number_pos;?></span></a></li>
            <li><span><strong><?php echo $data_name_doc;?></strong></span></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong><?php echo strtoupper($data_name_doc);?> POS <?php echo $data_number_pos;?> HISTORY</strong> LIST</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efiling/doc_c/index/NULL' . "/" . $data_id_pos) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back To List Doc" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="row">
							<?php
								$i = 1;
								foreach ($data as $isi) {
								?>
									<div class="col-md-3">
										<a href="#" class="btn btn-primary btn-xl" role="button" data-toggle="modal" data-target="<?php echo'.'.$i?>" data-backdrop="static" data-keyboard="false">
											<strong><?php echo DateTime::createFromFormat('Ymd', $isi->CHR_UPLOAD_DATE)->format('l, d F Y') ?></strong><br>
											<span><?php echo DateTime::createFromFormat('His', $isi->CHR_UPLOAD_TIME)->format('H:i:s') . " WIB" ?></span>
										</a>
									</div>
									
									<!-- Modal -->
									<div class="modal fade <?php echo $i?>" role="dialog">
										<div class="modal-dialog" style='max-height: calc(100% - 100px); position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%)'>
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title"><strong><?php echo $isi->CHR_DOC_TITLE ?></strong><?php echo " - " . DateTime::createFromFormat('Ymd', $isi->CHR_UPLOAD_DATE)->format('d F Y ') . DateTime::createFromFormat('His', $isi->CHR_UPLOAD_TIME)->format('H:i:s') . " WIB"?></h4>
												</div>
												<div class="modal-body">
													<img style = 'display:block; margin-left:auto; margin-right:auto; width: 80%; height: 80%;' src="<?php echo base_url('assets/file/doc/'.$isi->CHR_FILE_LOC) ?>" alt="">
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
							<?php
								$i++;
							}
							?>
						</div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


