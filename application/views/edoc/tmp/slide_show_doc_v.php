<aside class="right-side">
	<section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><span><strong>Show Document</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>The</strong> DOCUMENT</span>
						<div class="pull-right">
                            <a href="<?php echo base_url('index.php/edoc/show_doc_c/'); ?>" id="back" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
                        </div>
                    </div>
					<div class="grid-body">
                        <?php
						foreach ($data as $isi){
						?>
							<img src="<?php echo base_url('assets/file/doc/'.$isi->CHR_FILE_LOC) ?>" data-color="lightblue" alt="">
						<?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>