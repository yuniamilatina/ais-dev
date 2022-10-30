<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
        	<?php foreach ($breadcrumb as $BName =>  $BUrl): ?>

            <li><a href="<?php echo $BUrl; ?>"><strong><?php echo $BName; ?></strong></a></li>
        	<?php endforeach;?>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                	$this->load->view('pes/ng_no_locking/ng_nolocking_'.$__content);
                 ?>
            </div>
        </div>
    </section>
</aside>
	
	
<script type="text/javascript">

</script>
<style type="text/css">
	.ng-screen-login ::-webkit-input-placeholder {
	   text-align: center;
	}
	.ng-screen-login :-moz-placeholder { /* Firefox 18- */
	   text-align: center;  
	}
	.ng-screen-login ::-moz-placeholder {  /* Firefox 19+ */
	   text-align: center;  
	}
	.ng-screen-login :-ms-input-placeholder {  
	   text-align: center; 
	}
</style>