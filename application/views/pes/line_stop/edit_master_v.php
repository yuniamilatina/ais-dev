<?php

?>
<aside class="right-side">
	<section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/line_stop'); ?>"><strong>Line Stop</strong></a></li>
        </ol>
    </section>
    
    <section class="content">
    	<div class="row">
        	<div class="col-md-12">
            	<div class="grid">
                	<div class="grid-header">
                    	<i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>EDIT</strong>MASTER LINE STOP</span>
                    </div>
                    <div class="grid-body"  ><!--style="background-color: #94D1DC"-->
                    	<!---mulai disini--->
                        
                        <?php echo form_open('pes/promasdat_c/update_stopline', 'class="form-horizontal"'); ?>
                        <div>
                        <label for="KODE">Kode : <?php echo trim($data->CHR_LINE_CODE) ; ?></label>
                        </div>
                        <div>
                        <label for="CHR_LINE_STOP">Line Stop</label>
                        <input type="text" id="CHR_LINE_STOP" name="CHR_LINE_STOP" value= "<?php echo trim($data->CHR_LINE_STOP); ?>">
                        </div>
                        <label for="CHR_LINE_CAT">Category</label>
                        <input type="text" id="CHR_LINE_CAT" name="CHR_LINE_CAT" value= "<?php echo trim($data->CHR_LINE_CAT); ?>">
                        <input  id="CHR_LINE_CODE" required type="hidden" name="CHR_LINE_CODE"  value= "<?php echo trim($data->CHR_LINE_CODE) ; ?>">
                        <div>
                        
                        <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><span class="fa fa-refresh"></span> Update</button>
                        </div>
                        <div>
                        
                        </div>
                        </form>
						<?php 
						 echo form_close(); ?>

                        <!---selesai disini--->
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>