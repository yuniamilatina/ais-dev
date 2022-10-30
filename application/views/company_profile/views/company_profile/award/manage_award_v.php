<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Award</strong></a></li>
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
                        <span class="grid-title"><strong>AWARD</strong> TABLE</span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/company_profile/award_c/create_award/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Award" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Award Name</th>
                                    <th>Award Date</th>
                                    <th>Award Description</th>
                                    <th>Award Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_AWARD_NAME</td>";
                                    $tgl = $isi->CHR_AWARD_DATE; 
                                    $date = date("Y-m-d", strtotime($tgl));
                                    echo "<td>$date</td>";
                                    echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>".trim($isi->CHR_AWARD_DESC)."</td>";
                                    echo "<td><img src=\"".base_url()."assets/img/Award/".$isi->CHR_AWARD_PHOTO."\" height=\"200px\" width=\"250px\" ></td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/company_profile/award_c/edit_award') . "/" . $isi->INT_ID_AWARD; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('index.php/company_profile/award_c/delete_award') . "/" . $isi->INT_ID_AWARD; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this award?');"><span class="fa fa-times"></span></a>
                                    
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


