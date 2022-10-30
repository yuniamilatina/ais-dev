<script>
    $(document).ready(function() {
        var intXPosition;
        var intYPosition;

        var myVar = setInterval(function() {
            $("#hide-sub-menus").click();
            clearInterval(myVar)
        }, 0.5);


        $('#save-header').click(function() {
            var p_no = "<?php echo $part_no; ?>";
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('takaibiki/home_c/save_point'); ?>",
                data: "part_no=" + p_no + "&left=" + intXPosition + "&top=" + intYPosition,
                success: function(data) {
                    alert("Data Berhasil Dsimpan");
                    window.location.assign("http://192.168.0.231/AIS_PP/index.php/takaibiki/home_c/edit_point/<?php echo $back_no ?>");
                }
            });

        });


        $("#bg-big").click(function(e) {
//            switch (e.which) {
//                case 1:
//                    alert('Left Mouse button pressed.');
//                    break;
//                case 2:
//                    alert('Middle Mouse button pressed.');
//                    break;
//                case 3:
//                    alert('Right Mouse button pressed.');
//                    break;
//                default:
//                    alert('You have a strange Mouse!');
//            }
//            

            var parentOffset = $(this).parent().offset();
            var relativeXPosition = (e.pageX - parentOffset.left); //offset -> method allows you to retrieve the current position of an element 'relative' to the document
            var relativeYPosition = (e.pageY - parentOffset.top);

            intXPosition = parseInt(relativeXPosition);
            intXPosition = intXPosition - 65;
            intYPosition = parseInt(relativeYPosition);
            intYPosition = intYPosition - 60;
            $("#result").html("<p><strong>X-Position: </strong>" + intXPosition + " | <strong>Y-Position: </strong>" + intYPosition + "</p>");
            $("#point_rep").remove("");
            $("#bg-big").append("<img id='point_rep' src='http://192.168.0.249/PLS_TOUCH/assets/img/red%20glossy.png' style='width:100px;height:100px;position:absolute;top: " + intYPosition + "px;left:" + intXPosition + "px;'>");

        });

<?php
if (count($pointer) > 0) {
    foreach ($pointer as $value_pointer) {
        $left = $value_pointer->width;
        $top = $value_pointer->height;
        $cek_no = $value_pointer->cek_no;
        ?>
                $("#img-point-<?php echo $cek_no ?>").click(function(e) {
                    var p_no = "<?php echo $part_no; ?>";
                    var cek_no = "<?php echo $cek_no; ?>";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('takaibiki/home_c/delete_point'); ?>",
                        data: "part_no=" + p_no + "&cek_no=" + cek_no,
                        success: function(data) {
                            alert("Data Berhasil dIHAPUS");
                            window.location.assign("http://192.168.0.231/AIS_PP/index.php/takaibiki/home_c/edit_point/<?php echo $back_no ?>");
                        }
                    });
                });
        <?php
    }
}
?>



    });</script>

<script>
    function deleteThis(value) {
        document.getElementById("id_del_activity").value = value;
        document.getElementById("delete_activity").click();
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/portal/calendar_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE PART TAKAIBIKI </strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-3">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE</strong> NEW PART</span><span id="id-eci"></span>
                        <div class="pull-right grid-tools">
                            <div id="btn-publish" style="display:none;" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Publish ECI"><i class="fa fa-upload"></i> Publish</div>
                            <div id="published" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Published"> Published</div>
                            <a href="<?php echo site_url("eci/schedule_c/list_eci") ?>"><div id="back-to-list" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-danger" data-placement="right" data-toggle="tooltip" title="Published"> Published</div></a>
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form role="form" action="<?php echo site_url('takaibiki/home_c/new_entry') ?>" class="form-horizontal">

                            <div class=" form-group">

                                <div class="col-sm-3">
                                    <span id="result">results</span>
                                </div>
                            </div>

                            <div class="form-group" id="btn-group-header" style="float:none">
                                <div class="col-sm-offset-3 col-sm-12" style="margin:30px 0 0 30px ;">
                                    <div class="btn-group">
                                        <div id="save-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</div>
                                        <div style="display:none;"id="update-header" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-refresh"></i> Delete</div>
                                        <div id="cancel-header" type="submit" class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"> Cancel</div>
                                        <?php
                                        echo form_close();
                                        ?>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT</strong> POINT CEK  <?php echo $back_no ?></span><span id="id-eci"></span>
                        <div class="pull-right grid-tools">
                            <div id="btn-publish" style="display:none;" type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Publish ECI"><i class="fa fa-upload"></i> Publish</div>
                            <div id="published" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Published"> Published</div>
                            <a href="<?php echo site_url("eci/schedule_c/list_eci") ?>"><div id="back-to-list" style="display:none;background-color:#42CA51;border-color:#FFFFFF" class="btn btn-danger" data-placement="right" data-toggle="tooltip" title="Published"> Published</div></a>
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="text-align:center;margin-left: auto;margin-right: auto;">
                        <div id="bg-big" style="width:940px;height:600px;background-image: url('http://192.168.0.249/PLS/images/<?php echo $back_no ?>.JPG');background-size: 940px 600px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;" >
                        <!--<div id="bg-big" style="width:940px;height:600px;background-image: url('http://192.168.0.249/PLS_TOUCH/images/<?php echo $back_no ?>.JPG');background-size: 940px 600px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;" >-->
                            <?php
                            if (count($pointer) > 0) {
                                foreach ($pointer as $value_pointer) {
                                    $left = $value_pointer->width;
                                    $top = $value_pointer->height;
                                    $cek_no = $value_pointer->cek_no;
                                    echo '<img id="img-point-' . $cek_no . '" src="http://192.168.0.249/PLS_TOUCH/assets/img/red%20glossy.png" style="width:100px;height:100px;position:absolute;top: ' . $top . 'px;left:' . $left . 'px;">';
                                }
                            }
                            ?>                          

                        </div>

                    </div>
                </div>
            </div>           
        </div>
    </section>
</aside>


