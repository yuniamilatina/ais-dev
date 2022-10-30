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
                        <span class="grid-title"><strong>ALL VIDEO</strong> TABLE</span>
						<div class="pull-right">
                            <a href="<?php echo base_url('index.php/evideo/video_c/create_video'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload Video" style="height:30px;font-size:13px;width:100px;"><i class="fa fa-upload"></i> <b>Upload</b></a>
                        </div>
                    </div>
					<div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Video Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='width:10%'>$i</td>";
                                    echo "<td style='width:80%'>$isi->CHR_VIDEO_DESC</td>";
                                    ?>
                                <td style='width:10%'>
                                    <a href="<?php echo base_url('index.php/evideo/video_c/select_by_id') . "/" . $isi->INT_ID_VIDEO; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="Play"><span class="fa fa-play"></span></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>