<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>
<script type="text/javascript">
    function refreshTable() {
            var opt_wcenter = $("#opt_wcenter option:selected").val();
            var filter = document.getElementById("filter").value;
            // var type = $("#REPORT_TYPE option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/samanta/spare_parts_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: {INT_ID_OPT_WCENTER: opt_wcenter, FILTER: filter},
                success: function(data) {
                    document.getElementById('sum_table').style.display = 'block';
                    url_iframe = data.url_iframe.trim();
                    frame.src = url_iframe;
                    frame.contentWindow.location = url_iframe;
                }
            });
        }
    $(document).ready(function() {

        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
        
       
</script>
<aside >

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">                    
                    <div class="grid-body" style="padding-top: 0px;">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;text-align:center;">No</th>
                                    <th style="vertical-align: middle;text-align:center;">Part No</th>
                                    <th style="vertical-align: middle;text-align:center;">Rack No</th>
                                    <th style="vertical-align: middle;text-align:center;">Name</th>
                                    <th style="vertical-align: middle;text-align:center;">Component</th>
                                    <th style="vertical-align: middle;text-align:center;">Model</th>
                                    <th style="vertical-align: middle;text-align:center;">Back No</th>
                                    <th style="vertical-align: middle;text-align:center;">Type</th>
                                    <th style="vertical-align: middle;text-align:center;">Specification</th>                                    
                                    <th style="vertical-align: middle;text-align:center;">Price</th>
                                    <th style="vertical-align: middle;text-align:center;">Qty Use</th>
                                    <th style="vertical-align: middle;text-align:center;">Qty Min</th>
                                    <th style="vertical-align: middle;text-align:center;">Qty Max</th>
                                    <th style="vertical-align: middle;text-align:center;">Qty Actual</th>
                                    <th style="vertical-align: middle;text-align:center;" width="40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $dataTable) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$i</td>";
                                        if ($dataTable->CHR_PART_TYPE == '1') {
                                            echo "<td style=text-align:center;><span class='badge bg-green'>$dataTable->CHR_PART_NO</span></td>";
                                        } 
                                        else if ($dataTable->CHR_PART_TYPE == '2'){
                                            echo "<td style=text-align:center;><span class='badge bg-grey'>$dataTable->CHR_PART_NO</span></td>";
                                        }
                                        else {
                                            echo "<td style=text-align:center;>$dataTable->CHR_PART_NO</td>";
                                        }
                                        ?>
                                        <td style=text-align:center;><a onclick="get_data_detail('<?php echo trim($dataTable->CHR_PART_NO); ?>');" data-toggle="modal" data-target="#modal_<?php echo trim($dataTable->CHR_PART_NO); ?>" class="label label-success"  data-placement="left" title="View Address"><span class="fa fa-search"></span></a></td>
                                        <?php 
                                        echo "<td>$dataTable->CHR_SPARE_PART_NAME</td>";
                                        echo "<td style=text-align:center;>$dataTable->CHR_COMPONENT</td>";
                                        echo "<td style=text-align:center;>$dataTable->CHR_MODEL</td>";
                                        echo "<td style=text-align:center;>$dataTable->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$dataTable->CHR_TYPE</td>";
                                        echo "<td>$dataTable->CHR_SPECIFICATION</td>";
                                        echo "<td align='right'>". number_format($dataTable->CHR_PRICE) ."</td>";
                                        echo "<td style=text-align:center;>$dataTable->INT_QTY_USE</td>";
                                        echo "<td style=text-align:center;>$dataTable->INT_QTY_MIN</td>";
                                        echo "<td style=text-align:center;>$dataTable->INT_QTY_MAX</td>";
                                        // echo "<td style=text-align:center;>$dataTable->INT_QTY_IN</td>";
                                        // echo "<td style=text-align:center;>$dataTable->INT_QTY_OUT</td>";                                  
                                        if ($dataTable->INT_QTY_ACT < $dataTable->INT_QTY_MIN) {
                                            echo "<td style=text-align:center;><span class='badge bg-red'>$dataTable->INT_QTY_ACT</span></td>";
                                        }
                                        elseif ($dataTable->INT_QTY_ACT == $dataTable->INT_QTY_MIN){
                                            echo "<td style=text-align:center;><span class='badge bg-yellow'>$dataTable->INT_QTY_ACT</span></td>";
                                        }
                                        else {
                                            echo "<td style=text-align:center;>$dataTable->INT_QTY_ACT</td>";
                                        }                                        
                                        ?>
                                        <td style="vertical-align: middle;text-align:center;">
                                            <!-- <a href="<?php echo base_url('index.php/samanta/spare_parts_c/goto_edit_sp') . "/" . trim($dataTable->INT_ID) ?>" class="label label-info" data-placement="left" data-toggle="tooltip" title="Edit"></a> -->

                                            <a onclick="window.top.location.href = '<?php echo base_url('index.php/samanta/spare_parts_c/goto_edit_sp') . "/" . trim($dataTable->INT_ID) ?>'"  class="label label-info" data-placement="left" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a> 

                                            
                                            <a onclick="window.top.location.href = '<?php echo base_url('index.php/samanta/spare_parts_c/delete_sp') . "/" . trim($dataTable->INT_ID) ?>'"  class="label label-danger" data-placement="left" data-toggle="tooltip" title="Delete"><span class="fa fa-trash-o"></span></a>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                            </tbody>
                        </table>
                        </div>
                        <?php
                    foreach ($data as $dataTable) {
                        ?>
                        <div class="modal fade" id="modal_<?php echo trim($dataTable->CHR_PART_NO); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('#'); ?>"  enctype="multipart/form-data" role="form">
                                            <div class="modal-header bg-primary">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3">(<?php echo trim($dataTable->CHR_PART_NO) . ")  -  <strong>" . trim($dataTable->CHR_SPARE_PART_NAME) ?></strong>&nbsp;</h4>
                                            </div>
                                            <div class="modal-body" >
                                                <div id="table-luar">
                                                    <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th style="vertical-align: middle;text-align:center;">No</th>
                                                                <th style="vertical-align: middle;text-align:center;">Routing</th>
                                                                <th style="vertical-align: middle;text-align:center;">Alamat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="data_detail<?php echo trim($dataTable->CHR_PART_NO); ?>">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>        
        </div>
    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            filter:false,
            fixedColumns: {
                leftColumns: 0
            }
        });
    });
</script>
<script>
   
    $("#flowcheckall").change(function () {
        $('tbody input[type="checkbox"]').prop('checked', this.checked);
    });

    function get_data_detail(part_no) {
        $("#data_detail").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('samanta/spare_parts_c/view_detail_spare_parts'); ?>",
            data: "part_no=" + part_no,
            success: function (data) {
                $("#data_detail" + part_no).html(data);
            }
        });

    }

</script>