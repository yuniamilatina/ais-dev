<style type="text/css">
    .filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btnt{
        border:none;
    }

    .btnt:focus{
        outline: none;
    }

    .btnt:hover {
        background: #428bca;
        background-image: -webkit-linear-gradient(top, #428bca, #428bca);
        background-image: -moz-linear-gradient(top, #428bca, #428bca);
        background-image: -ms-linear-gradient(top, #428bca, #428bca);
        background-image: -o-linear-gradient(top, #428bca, #428bca);
        background-image: linear-gradient(to bottom, #428bca, #428bca);
        color:white;
    }
    .ui-autocomplete { 
        position: absolute;
        list-style: none; 
        background-color: #f5f8f9;
        font-family: 'Ubuntu', sans-serif;
        float: left; 
        display: none; 
        min-width: 472px !important;
        padding: 0px 10px; 
        margin: 0 0 10px 25px;    
    }
</style>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
</script>

<script type="text/javascript">
    // $(document).ready(function () {
    //     $('#idbackno').autocomplete({
    //         source: function(request, response) {
    //             $.getJSON('<?php //echo site_url('/mte/preventive_schedule_c/search/'); ?>', {
    //                 term: request.term
    //             }, response)
    //         },
    //         minLength: 1,
    //         focus: function( event, ui ) {
    //             $('#idbackno').val(ui.item.back_no);
    //             return false;
    //         },
    //         select: function( event, ui ) {
    //             $('#idbackno').val(ui.item.back_no);
    //             $('#partno').val(ui.item.part_no);
    //             $('#partname').val(ui.item.part_name);
    //             return false;
    //         }        
    //     });
    // }); 

    function get_work_center(){
        var backno = document.getElementById('idbackno').value;
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('mte/preventive_schedule_c/get_data_work_center'); ?>",
            data:  {
                    CHR_BACK_NO: backno
                    },
            success: function (json_data) {
                $("#work_center").html(json_data['data']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }

    function get_part_no(){
        var backno = document.getElementById('idbackno').value;
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('mte/preventive_schedule_c/get_data_part_number'); ?>",
            data:  {
                    CHR_BACK_NO: backno
                    },
            success: function (json_data) {
                $("#partno").val(json_data['part_no']);
                $('#partname').val(json_data['part_name']);
            },
            error: function (request) {
                alert(request.responseText);
            }
        });
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Manage Project PIC</strong></span></a></li>
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
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>DETAIL PARTS</strong></span>
                    </div>
                    <div class="grid-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal_add_part_no" data-placement="left" title="Add Part Number">Add Part Number</button>
                        <?php echo anchor('mte/preventive_schedule_c/index/0/' . $group_line, 'Back', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                        echo form_close();
                        ?>
                            <input name="partcode" id="partcode" type="hidden" value="<?php echo $part_code; ?>">
                            <input name="id_part" id="id_part" type="hidden" value="<?php echo $id_part; ?>">
                        <br><br>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr align="center">
                                    <th>Part Code</th>                                    
                                    <th>Work Center</th>
                                    <th>Part Number</th>
                                    <th>Back No</th>
                                    <th>Part Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr id=\"row_activity_$isi->CHR_PART_CODE\">";
                                    echo "<td>$isi->CHR_PART_CODE</td>";                                    
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td>$isi->CHR_PART_NO</td>";
                                    echo "<td>$isi->CHR_BACK_NO</td>";
                                    echo "<td>$isi->CHR_PART_NAME</td>";
                                    ?>
                                    <td>
                                        <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/delete_detail') . "/" . $isi->CHR_PART_CODE . "/" . $isi->CHR_PART_NO; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this Part?');"><span class="fa fa-times"></span></a>
                                    </td>
                                </tr>
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

        <div class="modal fade" id="modal_add_part_no"  tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper" style="width: 700px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 class="modal-title" id="modalprogress"><strong>Add Part Number</strong></h4>
                        </div>
                        <form method="POST" action="<?php echo base_url() ?>index.php/mte/preventive_schedule_c/add_part_no">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6">
                                            <label class="col-sm-3 control-label">Back No</label>
                                            <div class="form-group ui-front">
                                                <div class="col-sm-9">
                                                <input name="partcode" id="partcode" type="hidden" value="<?php echo $part_code; ?>">
                                                <input name="id_part" id="id_part" type="hidden" value="<?php echo $id_part; ?>">
                                                <input class="form-control" autofocus name="backno" id="idbackno" type="text" onchange="get_work_center(); document.getElementById('idbackno').value; get_part_no(); " />
                                                </div>
                                            </div>
                                    </div>                                                                                                     
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6">
                                        <label class="col-sm-3 control-label">Prod Line</label>
                                        <div class="col-sm-4">
                                            <select id="work_center" name="work_center" required style="height:35px;width:200px;">
                                            </select>
                                        </div>                            
                                    </div>
                                </div>
                                <br> 
                                <div class="row">  
                                    <div class="col-sm-6 col-lg-6">
                                            <label class="col-sm-3 control-label">Part No</label>
                                            <div class="form-group ui-front">
                                                <div class="col-sm-9">
                                                <input class="form-control" name="partno" id="partno" type="text" value=""  readonly/>                                                
                                                </div>
                                            </div>
                                    </div>                            
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6">
                                        <label class="col-sm-3 control-label">Part Name</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name="partname" id="partname" type="text" value="" style="height:35px;width:400px;" readonly/>
                                        </div>                            
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: none" >
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add this data" onclick="add_temp_part_no()" id="add_new_part_no"><i class="fa fa-check"></i>Add Part Number</button>
                                </div>                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>