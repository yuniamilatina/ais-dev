<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/section_c/') ?>"><span>PR3</span></a></li>
            <li><span><strong><?php echo $data_name_section[1];?></strong></span></li>
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
                        <span class="grid-title"><strong><?php echo $data_name_section[1];?> LINE</strong> LIST</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/edoc/section_c/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back To Section" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
							<a href="<?php echo base_url('index.php/edoc/subsection_c/create_subsection') . "/" . $data_id_section ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Create Line" style="height:35px;font-size:14px;width:100px;"><b>Create</b></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="row">
							<?php
								$i = 1;
								foreach ($data as $isi) {
								?>
									<div class="col-md-3">
										<a href="<?php echo base_url('index.php/edoc/pos_c/index/NULL') . "/" . $isi->INT_ID_SUB_SECTION; ?>" class="btn btn-primary btn-xl" role="button">
											<strong><?php echo $isi->CHR_SUB_SECTION ?></strong><br>
											<span><?php echo $isi->CHR_SUB_SECTION_DESC ?></span>
										</a>
										<div class="btn-group">
											<a href="<?php echo base_url('index.php/edoc/subsection_c/edit_subsection') . "/" . $isi->INT_ID_SUB_SECTION; ?>" class="btn btn-warning btn-s" role="button"><strong>Update</strong></a>
											<a href="<?php echo base_url('index.php/edoc/subsection_c/delete_subsection') . "/" . $isi->INT_ID_SUB_SECTION ?>" class="btn btn-danger btn-s" role="button" onclick="return confirm('Are you sure want to delete this subsection?');"><strong>Delete</strong></a>
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


