
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/plan_prod_c') ?>"><strong>Manage Prod Planning</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">     
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>COGI (RETURN ERROR FROM SAP)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php if ($this->session->flashdata('message') <> ''): ?>
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                    <?php endif; ?>  

                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Part Number</th>
                                    <th>Part Name & Model</th>
                                    <th>Created On</th>
                                    <th>Qty Produksi</th>
                                    <th>UoM</th>
                                    <th>Upload</th>
                                    <th>Status</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($cogi as $row) { ?>
                                    <tr>
                                        <td><?php echo $row->CHR_PART_NO; ?></td>
                                        <td><?php echo $row->CHR_PART_NAME; ?></td>
                                        <td><?php echo $row->CHR_DATE; ?></td>
                                        <td><?php echo $row->INT_TOTAL_QTY; ?></td>
                                        <td><?php echo $row->CHR_UOM; ?></td>
                                        <td><?php echo $row->CHR_UPLOAD; ?></td>
                                        <td><?php echo $row->CHR_STATUS; ?></td>
                                        <td><?php echo $row->CHR_MESSAGE; ?></td>
                                        <td align="center"><a href="<?= base_url() ?>index.php/pes/product_entry_c/cogiEdit/<?php echo $row->INT_NUMBER ?>" class="glyphicon glyphicon-edit"></a></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>


                    </div> 
                </div>
            </div>

        </div> 
        </div>
        </div>

        </div>
        </div>
        </div>
    </section>


</aside>
