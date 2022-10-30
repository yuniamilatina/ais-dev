 <script>
    $(document).ready(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
        
    )};
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Data Part Outhouse</strong></a></li>
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
                        <span class="grid-title"><strong>OUTHOUSE TABLE</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/calysta/outhouse_c/create_part_outhouse/') ?>" class="btn btn-default" data-toggle="modal" data-placement="left" title="Create Device" style="height:30px;font-size:13px;width:100px;">Create</a>
                            <!-- <a href="<?php echo base_url('index.php/calysta/outhouse_c/create_tool/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Tool" style="height:30px;font-size:13px;width:100px;">Create</a> -->
                        </div>
                    </div>
                    <div class="grid-body">
                    <table width="60%" id='filter' border=0px>
                                    <form method="POST" action="<?php echo base_url('index.php/calysta/outhouse_c/excel_check_list') ?>">
                                    <tr>
                                        <td width="5%">Filter</td>
                                        <td width="10%">
                                            <input  name="tanggal_awal" id="datepicker1" class="form-control" placeholder="Start Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="">
                                        </td>
                                        <td width="5%">s/d</td>
                                        <td width="12%">
                                            <input  name="tanggal_akhir" id="datepicker2" class="form-control" placeholder="End Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="">
                                        </td>
                                        
                                        <td width="15%" style="padding-top: 3px">
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-download"></i> Export Excel</button>
                                        </td>
                                    </tr>
                                    </form>
                                </table>
                            <br>

                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                
                                <tr>
                                    <th style="width:3%">No</th>
                                    <th style="width:5%">Item</th>
                                    <th style="width:8%">TM Number</th>
                                    <th style="width:13%">Part Name</th>
                                    <th style="width:8%">Model</th>
                                    <th style="width:7%">Mat</th>
                                    <th style="width:6%">Supplier</th>
                                    <th style="width:6%">Qty</th>
                                    <th style="width:6%">Dimensi</th>
                                    <th style="width:6%">Finish</th>
                                    <th style="width:13%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_ITEM</td>";
                                        echo "<td>$isi->CHR_TM_NUMBER</td>";
                                        echo "<td>$isi->CHR_PART_NAME</td>";
                                        echo "<td>$isi->CHR_MODEL</td>";
                                        echo "<td>$isi->CHR_MAT</td>";
                                        echo "<td>$isi->CHR_SUPPLIER</td>";
                                        echo "<td>$isi->INT_QTY</td>";
                                        echo "<td>$isi->CHR_DIMENSI</td>";
                                        echo "<td>$isi->CHR_PROG_FIN</td>";
                                    ?>
                                    <td>
                                         <a target='_blank' href="<?php echo base_url('index.php/calysta/outhouse_c/pdf_part')."/". $isi->INT_NO_PART; ?>" data-placement="left" data-toggle="tooltip" title="QRCode" class="label label-default"><span class="fa fa-download"></span></a>
                                         <a data-toggle="tooltip" data-target="#modaledit<?php echo $isi->INT_NO_PART; ?>" data-placement="left" data-toggle="tooltip" title="Edit Part" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/calysta/outhouse_c/delete') ."/". $isi->INT_NO_PART; ?>" class="label label-danger" data-placement="top" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Data Part Outhouse?');"><span class="fa fa-times"></span></a>
                                        
                                       
                                    </td>
                                    </tr>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
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
         <!-- Modal Add Device -->

        <?php
            foreach ($data as $isi) {
                ?>
                <!--EDIT Vacancy-->
                
                <div class="modal fade" id="modaledit<?php echo $isi->INT_NO_PART; ?>"  tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="modaledit"><strong>Edit Data Outhouse</strong></h4>
                                </div>
                                <div class="modal-body">
                                <?php echo form_open('calysta/outhouse_c/update', 'class="form-horizontal"'); ?>
                                     <input name="INT_NO_PART" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->INT_NO_PART ?>">
                        
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Item <span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_ITEM" style="width:350px" class="form-control" required type="text" required value="<?php echo $isi->CHR_ITEM ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Part Name<span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_PART_NAME" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_PART_NAME ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Model<span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_MODEL" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_MODEL ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Mat<span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_MAT" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_MAT ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Supplier<span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_SUPPLIER" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_SUPPLIER ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Qty<span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="INT_QTY" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->INT_QTY ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Dimensi<span style="color: red">*</span></label>
                                        <div class="col-sm-5">
                                            <input name="CHR_DIMENSI" class="form-control" style="width:350px" required type="text" required  value="<?php echo $isi->CHR_DIMENSI ?>">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>

                                <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#modaledit<?php echo $isi->INT_NO_PART; ?>').on('shown.bs.modal', function() {
                        $("#datepicker2<?php echo $isi->INT_NO_PART; ?>").datepicker({dateFormat: 'dd-mm-yy'}).val();
                    });
                </script>
                <?php
                $i++;
            }
            ?>
    </section>
</aside>

