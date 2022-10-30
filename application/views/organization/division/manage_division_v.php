<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/organization/division_c/'); ?>"><strong>Manage Division</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>DIVISION</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/organization/division_c/create_division/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Division" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Division Initial</th>
                                    <th>Division Description</th>
                                    <th>Company</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_DIVISION</td>";
                                    echo "<td>$isi->CHR_DIVISION_DESC</td>";
                                    echo "<td>$isi->CHR_COMPANY_DESC</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/organization/division_c/select_by_id') . "/" . $isi->INT_ID_DIVISION; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>
                                    <a href="<?php echo base_url('index.php/organization/division_c/edit_division') . "/" . $isi->INT_ID_DIVISION; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/organization/division_c/delete_division') . "/" . $isi->INT_ID_DIVISION; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this division?');"><span class="fa fa-times"></span></a>
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