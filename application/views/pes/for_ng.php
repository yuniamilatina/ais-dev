

<aside class="right-side">
       <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>PRODUCTION ENTRY FOR REPAIR</strong></a></li>
        </ol>
		</section>
		
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="grid border">
                                <div class="grid-header">
                                    <i class="fa fa-table"></i>
                                    <span class="grid-title">Production Entry for Repair</span>
                                    <div class="pull-right grid-tools">
										<a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
									</div>
                                </div>
                                <div class="grid-body">                   
                                        <table id="dataTables1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Part Number</th>
                                                <th>Back No</th>
                                                <th>Part Name $ Model</th>
                                                <th>Work Center</th>
                                                <th>Quantity NG</th>
                                                <th>Jenis Reject</th>
                                                <th>Fg Scrap</th>
                                                <th>Component Scrap</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                          <?php foreach ($id as $show) {
                                           ?>
                                            <tr>

                                            
                                                <td><?php echo $show['INT_NUMBER']; ?></td>
                                                <td><?php echo $show['CHR_DATE']; ?></td>
                                                <td><?php echo $show['CHR_PART_NO']; ?></td>
                                                <td><?php echo $show['CHR_BACK_NO'];?></td>
                                                <td><?php echo $show['CHR_PART_NAME'];?></td>
                                                <td><?php echo $show['CHR_WORK_CENTER'];?></td>
                                                
                                                <td><?php echo $show['QTY_NG'];?></td>
                                                <td><?php echo $show['REJECT_CODE'];?></td>
                                                <td><a href="<?= base_url()?>index.php/pes/for_ng/fg_scrap/<?= $show['INT_NUMBER'] ?>"class="glyphicon glyphicon-edit"></a></td>
                                                <td><a href="<?= base_url()?>index.php/pes/for_ng/component_scrap/<?= $show['INT_NUMBER'] ?>"class="glyphicon glyphicon-edit"></a></td>
                                            </tr>
                                           <?php }?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </section>
            </aside>

