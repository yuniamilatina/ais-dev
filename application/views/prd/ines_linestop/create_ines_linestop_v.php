
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/ines_linestop_c') ?>">MANAGE LINE STOP</a></li>
            <li> <a href="#"><strong>CREATE LINE STOP</strong></a></li>
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
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE LINE STOP</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open('prd/ines_linestop_c/start_linestop', 'class="form-horizontal"');
                    ?>
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                    <select id="e1" name="CHR_WORK_CENTER" class="form-control" onchange="get_data_part();">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                }
                                            ?>
                                    </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
					    <label class="col-sm-3 control-label">Shift</label>
							<div class="col-sm-7">
								<div class="radio">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" checked class="icheck" value='1'></div> SHIFT 1</label>
								</div>
								<div class="radio">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" class="icheck" value='2'></div> SHIFT 2</label>
								</div>
								<div class="radio">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" class="icheck" value='3'></div> SHIFT 3</label>
								</div>
								<div class="radio">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_SHIFT" class="icheck"  value='4'></div> SHIFT 4</label>
								</div>
							</div>
					</div>

                    <div class="form-group">
					    <label class="col-sm-3 control-label">Shift Type</label>
							<div class="col-sm-7">
								<div class="radio-inline">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_FLG_SHIFT" checked class="icheck" value='1'></div> LONG SHIFT</label>
								</div>
								<div class="radio-inline">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="INT_FLG_SHIFT" class="icheck" value='0'></div>NORMAL SHIFT</label>
								</div>
							</div>
                    </div>
                    
                    <div class="form-group">
					    <label class="col-sm-3 control-label">Problem</label>
							<div class="col-sm-7">
								<div class="radio-inline">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="CHR_LS_CODE" checked class="icheck" value='LS4'></div> MACHINE</label>
								</div>
								<div class="radio-inline">
									<label><div class="iradio_square-blue" style="position: relative;"><input type="radio" name="CHR_LS_CODE" class="icheck" value='LS5'></div>DIES / JIG</label>
								</div>
							</div>
                    </div>
                   
                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('prd/ines_linestop_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>           
        </div>
        </div>
    </section>
</aside>

