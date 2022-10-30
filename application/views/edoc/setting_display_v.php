<aside class="right-side">
	<section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><span><strong>All Document</strong></span></li>
        </ol>
    </section>
	
	<section class="content">
        <?php
        if ($msg != NULL && $msg != "NULL") {
            echo $msg;
        }
        ?>
		<?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('edoc/setting_display_c/update_doc', 'class="form-horizontal"');
        ?> 

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>SETTING</strong> DISPLAY</span>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Set</button>
                        </div>
                    </div>
                    <div class="grid-body">
						<table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Name</th>
									<th>Time</th>
                                    <th>Actions</th>
									<th>Choose</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
								?>
                                <tr class='gradeX' >
									<td style="width:10%;"><?php echo $i ?></td>
                                    <td style="width:20%;">
									<?php
										if($isi->BIT_TYPE == TRUE){
											echo "Document";
										}
										else{
											echo "Video";
										}
									?>
									</td>
                                    <td style="width:30%;"><?php echo $isi->CHR_DOC_TITLE ?></td>
									<td style="width:20%;"><?php echo $isi->INT_DOC_HOUR . " : " . $isi->INT_DOC_MINUTE . " : " . $isi->INT_DOC_SECOND ?></td>
									<td style="width:10%;">
										<a href="<?php echo base_url('index.php/edoc/doc_c/edit_category') . "/" . $isi->INT_ID_DOC; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" value="Edit Time"><span class="fa fa-pencil"></span></a>
									</td>
									<td tyle="width:10%;">
										<?php
											if ($isi->BIT_ACTIVE == TRUE) {
												?> 
												<input type="radio" name="INT_ID_DOC" value="<?php echo $isi->INT_ID_DOC; ?>" checked>
											<?php } else { ?>
												<input type="radio" name="INT_ID_DOC" value="<?php echo $isi->INT_ID_DOC; ?>" >
												<?php
											}
										?>
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