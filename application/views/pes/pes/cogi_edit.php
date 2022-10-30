
<aside class="right-side">
                <section class="content">
                    <div class="row">
                        <!-- BEGIN BASIC ELEMENTS -->
                        <div class="col-md-12">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-align-left"></i>
                                    <span class="grid-title">Edit Cogi</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <form class="form-horizontal" method="post" action="<?= base_url()?>index.php/pes/product_entry_c/updateCogi/" >
										<input type="hidden" name="INT_NUMBER" class="form-control" value="<?php echo $data->INT_NUMBER?>" maxlength="4"  required readonly="readonly">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Part Number</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_PART_NO" class="form-control" value="<?php echo $data->CHR_PART_NO?>" maxlength="4"  required readonly="readonly">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">P.Name & Model</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_PART_NAME" class="form-control" value="<?php echo $data->CHR_PART_NAME?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Created On</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_DATE" class="form-control" value="<?php echo $data->CHR_DATE?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-3 control-label">Qty Produksi</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="CHR_DATE" class="form-control" value="<?php echo $data->INT_TOTAL_QTY?>" maxlength="4" required readonly="readonly">
                                            </div>
                                        </div>
										
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">UPLOAD</label>
                                            <div class="col-sm-5">
                                                <select class="form-control select" data-live-search="true" name='UPLOAD'>

												<option><?php echo $data->CHR_UPLOAD; ?></option> 
												<option value=""> </option> 
												<option value>X</option> 
												</select>

                                            </div>
                                        </div>
                                      

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-5">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END BASIC ELEMENTS -->
                    </div>

   
                </section>
                <!-- END MAIN CONTENT -->
            </aside>
            <!-- END CONTENT -->
