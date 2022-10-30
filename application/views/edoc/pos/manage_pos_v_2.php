<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/section_c/') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
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
                        <span class="grid-title"><strong><?php echo $data_name_subsection;?> POS</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/edoc/subsection_c/index/NULL' . "/" . $data_id_section) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back To Line" style="height:30px;font-size:13px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
							<a href="<?php echo base_url('index.php/edoc/pos_c/create_pos') . "/" . $data_id_subsection ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Pos" style="height:30px;font-size:13px;width:100px;"><b>Create</b></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pos Number</th>
                                    <th>Pos Name</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
								?>
								<tr class="gradeX" >
									<td onclick="window.document.location='<?php echo base_url('index.php/edoc/doc_c/index/NULL') . "/" . $isi->INT_ID_POS; ?>'; " style="cursor: pointer; width:10%;"><?php echo $i ?></td>
                                    <td onclick="window.document.location='<?php echo base_url('index.php/edoc/doc_c/index/NULL') . "/" . $isi->INT_ID_POS; ?>'; " style="cursor: pointer; width:30%;"><?php echo "POS " . $isi->INT_POS_NUMBER ?></td>
                                    <td onclick="window.document.location='<?php echo base_url('index.php/edoc/doc_c/index/NULL') . "/" . $isi->INT_ID_POS; ?>'; " style="cursor: pointer; width:49%;"><?php echo $isi->CHR_POS_TITLE ?></td>
                                
									<td style="width:11%;">
										<a href="<?php echo base_url('index.php/edoc/pos_c/edit_pos') . "/" . $isi->INT_ID_POS; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
										<a href="<?php echo base_url('index.php/edoc/pos_c/delete_pos') . "/" . $isi->INT_ID_POS ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this pos?');"><span class="fa fa-times"></span></a>
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


