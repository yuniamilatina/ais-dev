<?php header("Refresh:120"); ?>
<div id="mycarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
	<?php
	foreach ($data as $isi){
	$i=0;
	?>
		<li data-target="#mycarousel" data-slide-to="<?php echo"$i"?>"></li>
	<?php
	}
	?>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
	<?php
	foreach ($data as $isi){
	?>
		<div class="item">
			<img src="<?php echo base_url('assets/file/doc/'.$isi->CHR_FILE_LOC) ?>" data-color="lightblue" alt="">
			<div class="carousel-caption">
				<h3><?php echo"$isi->CHR_DOC_TITLE"?></h3>
			</div>
		</div>
	<?php
	}
	?>
	</div>
</div>