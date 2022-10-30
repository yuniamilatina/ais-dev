<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Report Preventive</strong></a></li>
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
                        <span class="grid-title"><strong>PREVENTIVE</strong> DATA</span>
                        <!-- <div class="pull-right">
                            <a href="<?php echo base_url('index.php/asset/asset_c/create_asset/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Asset" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div> -->
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part Code</th>
                                    <th>Description</th>
                                    <th>Stroke</th>
                                    <th>Preventive Type</th>
                                    <th>Date</th>
                                    <th>Person</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PART_CODE</td>";
                                    echo "<td>".trim($isi->PART_NAME)."</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>".trim($isi->CHR_ASSET_DESC)."</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/asset/asset_c/select_by_id') . "/" . $isi->INT_ID; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/asset/asset_c/edit_asset') . "/" . $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/asset/asset_c/delete_asset') . "/" . $isi->INT_ID ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this asset?');"><span class="fa fa-times"></span></a>
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


