<script type="text/javascript">
    function refreshTable() {
        var e1 = $("#e1 option:selected").val();
        var e2 = $("#e2 option:selected").val();
        var filter = document.getElementById("filter").value;
        var url_iframe = "";
        var frame = document.getElementById("iframe");

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/mrp/manage_mrp_c/refresh_table",
            type: "POST",
            dataType: 'json',
            data: {
                INT_REV: e1,
                CHR_MONTH: e2,
                FILTER: filter
            },
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
        $("#e1").change(function() {
            if (($("#e1 option:selected").val() != '')) {
                refreshTable();
            }
        });
        $("#e2").change(function() {
            if (($("#e2 option:selected").val() != '')) {
                refreshTable();
            }
        });
        $('#filter').on('keyup', function(e) {
            if (e.keyCode != 8 && e.keyCode != 46) {
                refreshTable();
            }
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Master Data WO</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong> Master Data WO </strong></span>
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalPrimary">Upload</button>
                            <!--<a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>-->
                        </div>
                    </div>

                    <div class="grid-body" style="padding-top: 10px">
                        <div>
                            <table width="70%">
                                <td>Month</td>
                                <td>
                                    <select id="e2" name="CHR_MONTH" class="form-control" style="width:200px;">
                                        <?php for ($x = -2; $x <= 0; $x++) {
                                            $y = $x * 28 ?>
                                            <option value="<?php echo date("Ym", strtotime("+$y day")); ?>"><?php echo date("M Y", strtotime("+$y day")); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Version</td>
                                <td>
                                    <select id="e1" name="INT_REV" class="form-control" style="width:100px;">
                                        <?php for ($x = 0; $x <= 5; $x++) { ?>
                                            <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Filter</td>
                                <td><input type="text" style="width: 200px" class="form-control" name="filter" id="filter"></td>
                            </table>
                        </div>
                        <br>
                        <div id="sum_table" style="display:none;">
                            <iframe frameBorder="0" id="iframe" name="iframe" width="100%" height="750" src="<?php echo $url_page ?>"></iframe>
                        </div>
                        <div id="append" name="append" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPrimary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post" role="form" action="<?php echo base_url('index.php/mrp/manage_mrp_c/upload_template_data_wo'); ?>" enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2">Upload Master WO Customer</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><a href="<?php echo base_url('index.php/mrp/manage_mrp_c/generate_temp_wo'); ?>">Download Template Master WO</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Input File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_stock" id="import_stock" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [0, 'asc']
            ],
            fixedColumns: {
                leftColumns: 4
            }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>