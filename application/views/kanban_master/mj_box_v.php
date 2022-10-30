<?php
session_start();
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tablemaster.js" ></script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/kanban_master/box_type'); ?>">Box Type</a></li>
            <li><a href=""><strong>Master Jenis Box</strong></a></li>
        </ol>
    </section>

    <section class="content" >
        <div class="row" >
            <div class="col-md-12 text-center" >
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-barcode"></i>
                        <span class="grid-title"><strong>MANAGE BOX TYPE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php if ($this->session->flashdata('message') <> ''): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                        <br/>
                    <?php endif; ?>
                    <div class="grid-body">
                        <form method="POST" action="<?= base_url() ?>index.php/pes/kanban_master/mj_box">
                            <div class="row">
                                <div class="col-sm-2">
                                    <input type="submit" name="simpan" id="simpan" class="btn btn-primary" style="width:100px;" value="Save">
                                </div>
                                <div class="col-sm-2">
                                    <a href="<?= base_url() ?>index.php/pes/kanban_master/box_type" class="btn btn-default" style="width:100px;">Close</a>
                                </div>
                            </div><br>

                            <table class="table table-bordered" width="75%" id="dataTables1">
                                <thead>
                                    <tr>
                                        <th>Jenis Box</th>
                                        <th>Panjang</th>
                                        <th>Lebar</th>
                                        <th>Tinggi</th>
                                        <th>Penjelasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($databox as $dbox): ?>
                                        <tr>
                                            <td><input class="form-control" readonly="readonly" name="jnsbox[]" value= "<?php echo trim($dbox->CHR_BOX_TYPE); ?>" style="width:150px"></td>
                                            <td><input class="form-control" name="panjang[]" value= "<?php echo trim($dbox->CHR_LENGTH); ?>" style="width:150px"></td>
                                            <td><input class="form-control" name="lebar[]" value= "<?php echo trim($dbox->CHR_WIDTH); ?>" style="width:150px"></td>
                                            <td><input class="form-control" name="tinggi[]" value= "<?php echo trim($dbox->CHR_HEIGHT); ?>" style="width:150px"></td>
                                            <td><input class="form-control" name="exp[]" value= "<?php echo trim($dbox->CHR_DESC); ?>" style="width:300px"></td>
                                        </tr>
    <?php $i++;
endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- end grid body -->
                </div>
                <!-- end grid class  -->
            </div>  
        </div>
    </section>
</aside>

