<aside class="right-side">
	<section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><span><strong>All Document</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>ALL DOCUMENT</strong> TABLE</span>
                    </div>
					<div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Section</th>
                                    <th>Sub Section</th>
                                    <th>Pos Number</th>
                                    <th>Pos Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_SECTION_DESC</td>";
                                    echo "<td>$isi->CHR_SUB_SECTION</td>";
                                    echo "<td>Pos $isi->INT_POS_NUMBER</td>";
                                    echo "<td>$isi->CHR_POS_TITLE</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/edoc/slide_show_doc_c/index') . "/" . $isi->INT_ID_POS; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></a>
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