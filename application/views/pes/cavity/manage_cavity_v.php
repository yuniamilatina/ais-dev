


<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/cavity_c/"') ?>"><strong>Manage Part Cavity</strong></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>MASTER PART CAVITY</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/pes/cavity_c/create_cavity"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create master part cavity" style="height:30px;font-size:13px;width:110px;padding-left:10px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                        </div>
                    </div >

                    <div class="grid-body" style="padding-top: 0px">

                        <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='text-align:center;'>No</th>
                                    <th style='text-align:center;'>Part No</th>
                                    <th style='text-align:center;'>Part No Mate</th>
                                    <th style='text-align:center;'>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($data_cavity as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td style='text-align:center;'>$r</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_PART_NO</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_PART_NO_MATE</td>";
                                    ?>
                                <td style='text-align:center;'>
                                    <a href="<?php echo base_url('index.php/pes/cavity_c/edit_cavity') . "/" . $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/pes/cavity_c/delete_cavity') . "/" . $isi->INT_ID; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this target production?');"><span class="fa fa-times"></span></a>
                                </td>
                                </tr>
                                <?php
                                $r++;
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
