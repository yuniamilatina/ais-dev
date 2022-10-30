<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>PR3</strong></a></li>
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
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>PR3 SECTION</strong> LIST</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efiling/section_c/create_section/') ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Create Section" style="height:35px;font-size:14px;width:100px;"><b>Create</b></a>
                        </div>
                    </div>
                    <div class="grid-body">
						<div class="row">
							<?php
								$i = 1;
								foreach ($data as $isi) {
								?>
									<div class="col-md-3">
										<a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL') . "/" . $isi->INT_ID_SECTION; ?>" class="btn btn-primary btn-xl" role="button">
											<strong><?php echo $isi->CHR_SECTION ?></strong><br>
											<span><?php echo $isi->CHR_SECTION_DESC ?></span>
										</a>
										<div class="btn-group">
											<a href="<?php echo base_url('index.php/efiling/section_c/edit_section') . "/" . $isi->INT_ID_SECTION; ?>" class="btn btn-warning btn-s" role="button"><strong>Update</strong></a>
											<a href="<?php echo base_url('index.php/efiling/section_c/delete_section') . "/" . $isi->INT_ID_SECTION ?>" class="btn btn-danger btn-s" role="button" onclick="return confirm('Are you sure want to delete this section?');"><strong>Delete</strong></a>
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


