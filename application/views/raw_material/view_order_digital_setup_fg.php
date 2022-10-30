
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/order_setup_chute_c/'); ?>"><span>Data Order Digital Setup Chute FG</span></a></li>
            <li><a href=""><strong>View Order Digital Setup Chute FG</strong></a></li>
        </ol>
    </section>

    <section class="content">
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>VIEW DATA ORDER DIGITAL SETUP CHUTE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th align='center'>Prod No</th>
                                    <th align='center'>Part No</th>
                                    <th align='center'>Part Nama</th>
                                    <th align='center'>Back No</th>
                                    <th align='center'>Order Box</th>
                                    <th align='center'>Order Pcs</th>
                                    
                                </tr>
                            </thead>

                            <tbody align="center">
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    $btn = 'success';
                                    $color = NULL;
                                    $level = null;
                                    $late = NULL;
                                    
                                    echo "<tr>";
                                    echo "<td align='center'>$i</td>";
                                    echo "<td align='center'>$isi->CHR_PRD_ORDER_NO</td>";
                                    echo "<td align='center'>$isi->CHR_PART_NO</td>";
                                    echo "<td align='center'>$isi->CHR_PART_NAME</td>";
                                    echo "<td align='center'>$isi->CHR_BACK_NO</td>";
                                    echo "<td align='center'>$isi->INT_ORDER_BOX</td>";
                                    echo "<td align='center'>$isi->INT_ORDER_PCS</td>";
                                    ?>
                                                             
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            
                                <div class="btn-group">
                                    <?php
                                    echo anchor('raw_material/order_setup_chute_c', 'Back', 'class="btn btn-default"');
                                    ?>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>