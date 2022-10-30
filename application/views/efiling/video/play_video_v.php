<aside class="right-side">
	<section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><span><strong>Play Video</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong><?php echo strtoupper($desc)?></strong> VIDEO</span>
						<div class="pull-right">
                            <a href="<?php echo base_url('index.php/efiling/video_c/'); ?>" id="back" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back" style="height:35px;font-size:14px;width:100px;"><i class="fa fa-arrow-left"></i> <b>Back</b></a>
                        </div>
                    </div>
					<div class="grid-body">
                        <center><video id="myVideo" width="640"  height="480" src="<?php echo base_url('assets/file/doc/'.$location) ?>" type="video/mp4" controls> </video></center>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>

<script type="text/javascript" language="javascript">
	var video = document.getElementById(myVideo);
	function stopVideo(){
		video.pause();
		video.currentTime = 0;
	}
	$("#back").on('click', function(){
		stopVideo();
		alert(myVideo);
	});
</script>