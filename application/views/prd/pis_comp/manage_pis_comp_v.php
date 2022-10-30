<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>HOME</span></a></li>
            <li> <a href="#"><strong>PIS COMPONENT</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>PIS COMPONENT</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/prd/pis_comp_c/create_pis_comp/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create PIS" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:left;">Part Name</th>
                                    <th style="text-align:center;">Rack No</th>
                                    <th style="text-align:center;">Image</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$i</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_BACK_NO</td>";
                                    echo "<td style='text-align:left;'> $isi->CHR_PART_NAME</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_RAKNO</td>";
                                    echo "<td style='text-align:center;'><img id='myImg' alt='PIS Image' src='" . base_url($isi->CHR_IMAGE_PIS_URL). "' width='20px' height='20px'></td>";
                                    ?>
                                    <td style="text-align:center;">
                                        <a data-toggle="modal" data-target="#modal_<?php echo trim($isi->CHR_PART_NO); ?>" class="label label-success"  data-placement="left" title="View Image"><span class="fa fa-eye"></span></a>
                                        <a href="<?php echo base_url('index.php/prd/pis_comp_c/edit_pis_comp') . "/" . trim($isi->CHR_BACK_NO) ?>" class="label label-warning" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/prd/pis_comp_c/delete_pis_comp') . "/" . trim($isi->CHR_BACK_NO) ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Delete"><span class="fa fa-trash-o"></span></a> 
                                    </td>
                                </tr>
                                <?php
                                    $i++;
                                } ?>
                            </tbody>
                        </table> 
                    </div>
                    <!-- =========================================================================================================================== -->
                    <!-- =========================================================================================================================== -->
                    <?php
                    foreach ($data as $isi) {
                        ?>
                        <div class="modal fade" id="modal_<?php echo trim($isi->CHR_PART_NO); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/dies_sp/md_dies_misumi_c/upload_image'); ?>"  enctype="multipart/form-data" role="form">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3"><strong>(<?php echo trim($isi->CHR_PART_NO) . ") - " . trim($isi->CHR_BACK_NO) ?></strong>&nbsp;&nbsp; <?php echo substr($isi->CHR_PART_NAME,0,20) ?> ...</h4>
                                            </div>
                                            <div class="modal-body" >
                                                <div style='text-align:center;'>                                                    
                                                        <img id="myImg" alt="PIS Image" src="<?php echo 'http://192.168.0.231/AIS_PP/' . $isi->CHR_IMAGE_PIS_URL; ?>" width='600px' height='450px'>                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- =========================================================================================================================== -->
                    <!-- =========================================================================================================================== -->
                </div>
            </div>
        </div>

    </section>
</aside>
