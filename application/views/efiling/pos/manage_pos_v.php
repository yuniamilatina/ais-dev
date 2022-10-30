<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/section_c/') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
            <li><span><strong><?php echo $data_name_subsection;?></strong></span></li>
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
                        <span class="grid-title"><strong><?php echo $data_name_subsection;?> POS</strong> LIST</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back To Line" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
							<a href="<?php echo base_url('index.php/efiling/pos_c/create_pos') . "/" . $data_id_subsection ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Create Pos" style="height:35px;font-size:14px;width:100px;"><b>Create</b></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="row">
							<?php
								$i = 1;
								foreach ($data as $isi) {
								?>
									<div class="col-md-3">
										<a href="<?php echo base_url('index.php/efiling/doc_c/index/NULL') . "/" . $isi->INT_ID_POS; ?>" class="btn btn-primary btn-xl" role="button">
											<strong><?php echo "POS " . $isi->INT_POS_NUMBER ?></strong><br>
											<span><?php echo $isi->CHR_POS_TITLE ?></span>
										</a>
										<div class="btn-group">
											<a href="<?php echo base_url('index.php/efiling/pos_c/edit_pos') . "/" . $isi->INT_ID_POS; ?>" class="btn btn-warning btn-s" role="button"><strong>Update</strong></a>
											<a href="<?php echo base_url('index.php/efiling/pos_c/delete_pos') . "/" . $isi->INT_ID_POS ?>" class="btn btn-danger btn-s" role="button" onclick="return confirm('Are you sure want to delete this pos?');"><strong>Delete</strong></a>
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


