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
                        <span class="grid-title"><strong>PR3 SECTION</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/edoc/section_c/create_section/') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Section" style="height:30px;font-size:13px;width:100px;"><b>Create</b></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Section Initial</th>
                                    <th>Section Description</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
								?>
                                <tr class='gradeX' >
									<td onclick="window.document.location='<?php echo base_url('index.php/edoc/subsection_c/index/NULL') . "/" . $isi->INT_ID_SECTION; ?>'; " style="cursor: pointer; width:10%;"><?php echo $i ?></td>
                                    <td onclick="window.document.location='<?php echo base_url('index.php/edoc/subsection_c/index/NULL') . "/" . $isi->INT_ID_SECTION; ?>'; " style="cursor: pointer; width:30%;"><?php echo $isi->CHR_SECTION ?></td>
                                    <td onclick="window.document.location='<?php echo base_url('index.php/edoc/subsection_c/index/NULL') . "/" . $isi->INT_ID_SECTION; ?>'; " style="cursor: pointer; width:49%;"><?php echo $isi->CHR_SECTION_DESC ?></td>
									<td tyle="width:11%;">
										<a href="<?php echo base_url('index.php/edoc/section_c/edit_section') . "/" . $isi->INT_ID_SECTION; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
										<a href="<?php echo base_url('index.php/edoc/section_c/delete_section') . "/" . $isi->INT_ID_SECTION ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this section?');"><span class="fa fa-times"></span></a>
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


