<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/backno_subcont_c/'); ?>"><span><strong>Manage Back No Subcont</strong></span></a></li>
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
                        <i class="fa fa-wrench"></i>

                        <span class="grid-title">BACK NO COIL <strong>SUBCONT</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/raw_material/backno_subcont_c/create_backno_subcont/"') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Data Subcont" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div>
                        
                    </div>

                    <div class="grid-body">
                        

                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part No</th>
                                    <th>Part Name</th>
                                    <th>Back No</th>
<!--                                    <th>Nama Supplier</th>-->
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $btn = 'success';
                                    $color = NULL;
                                    $level = null;
                                    $late = NULL;
                                    
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td>$isi->CHR_PART_NAME</td>";                                  
                                    echo "<td>$isi->CHR_BACK_NO</td>";
                                    //echo "<td>$isi->CHR_PROBLEM_TITLE</td>";
                                    
                                    ?>
                                <td>
<!--                                    <a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/view_detail_helpdesk_ticket') . "/" . $isi->INT_ID_TICKET; ?>" class="label label-success" data-placement="left" data-toggle="tooltip" title="View"><span class="fa fa-check"></span></a>-->
                                    <a href="<?php echo site_url('raw_material/backno_subcont_c/delete_backno_subcont') . "?id=" . $isi->INT_ID; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin ingin hapus data?');"><span class="fa fa-times"></span></a>
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