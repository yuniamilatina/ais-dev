<aside class="right-side">
	<section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><span><strong>All Video</strong></span></li>
        </ol>
    </section>

    <section class="content">
		<?php
			if ($msg != NULL && $msg != "NULL") {
				echo $msg;
			}
		?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>ALL VIDEO</strong> LIST</span>
						<div class="pull-right">
                            <a href="<?php echo base_url('index.php/efiling/video_c/create_video'); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Upload Video" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-upload"></i> <b>Upload</b></a>
                        </div>
                    </div>
					<div class="grid-body">
                        <div class="row">
							<?php
								$i = 1;
								foreach ($data as $isi) {
								?>
									<div class="col-md-3">
										<a href="<?php echo base_url('index.php/efiling/video_c/select_by_id') . "/" . $isi->INT_ID_DOC; ?>" class="btn btn-primary btn-xxl" role="button">
											<strong><?php echo $isi->CHR_DOC_TITLE; ?></strong><br>
											<span class="glyphicon glyphicon-play-circle"></span>
										</a>
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