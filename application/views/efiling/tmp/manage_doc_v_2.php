<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/section_c/') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/pos_c/index/NULL' . "/" . $data_id_subsection) ?>"><span><?php echo $data_name_subsection;?></span></a></li>
            <li><span><strong>Pos <?php echo $data_number_pos;?></strong></span></li>
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
                        <span class="grid-title"><strong>POS <?php echo $data_number_pos;?> DOCUMENT</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/edoc/pos_c/index/NULL' . "/" . $data_id_subsection) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back To Pos" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
							<a href="<?php echo base_url('index.php/edoc/doc_c/create_doc/NULL') . "/" . $data_id_pos ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create New Doc" style="height:35px;font-size:14px;width:100px;"><b>Create</b></a>
						</div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Document Name</th>
                                    <th>Latest Update</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
								?>
								<tr class="gradeX" >
									<td onclick="window.document.location='<?php echo base_url('index.php/edoc/doc_c/history') . "/" . $isi->INT_ID_POS . "/" . $isi->INT_ID_DOC ?>'; " style="cursor: pointer; width:10%;"><?php echo $i ?></td>
                                    <td onclick="window.document.location='<?php echo base_url('index.php/edoc/doc_c/history') . "/" . $isi->INT_ID_POS . "/" . $isi->INT_ID_DOC ?>'; " style="cursor: pointer; width:30%;"><?php echo $isi->CHR_DOC_TITLE ?></td>
                                    <td onclick="window.document.location='<?php echo base_url('index.php/edoc/doc_c/history') . "/" . $isi->INT_ID_POS . "/" . $isi->INT_ID_DOC?>'; " style="cursor: pointer; width:55%;"><?php echo DateTime::createFromFormat('Ymd', $isi->CHR_UPLOAD_DATE)->format('l, d F Y, ') . DateTime::createFromFormat('His', $isi->CHR_UPLOAD_TIME)->format('H:i:s') . " WIB"?></td>
                                
									<td style="width:5%;">
										<a href="#" class="label label-success" data-placement="top" data-toggle="modal" data-target="<?php echo'.'.$i?>" data-backdrop="static" data-keyboard="false" title="View"><span class="fa fa-eye"></span></a>
									</td>
                                </tr>
								
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
												<img style = 'display:block; margin-left:auto; margin-right:auto; width: 50%; height: 50%;' src="<?php echo base_url('assets/file/doc/'.$isi->CHR_FILE_LOC) ?>" alt="">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>


