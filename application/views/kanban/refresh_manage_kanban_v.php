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
                            <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Work Center</th>
                                        <th>Part No</th>
                                        <th>Part Name</th>
                                        <th>Part No Dash</th>
                                        <th>Back No</th>
                                        <th>Kanban Type</th>
                                        <th>WC Vendor</th>
                                        <th>Sloc From</th>
                                        <th>Sloc To</th>
                                        <th>Box Type</th>
                                        <th>Qty Per Box</th>
                                        <th>Cust Part No</th>
                                        <th>Last Serial</th>
                                        <th>Side</th>
                                        <th>Created Date</th>
                                        <th>Changed Date</th>
                                        <th>Deleted Date</th>
                                        <th>Deleted Flag</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        $date_create = date("d-m-Y", strtotime($isi->CHR_DATE_CREATE));
                                        $date_change = date("d-m-Y", strtotime($isi->CHR_DATE_CHANGE));
                                        $date_delete = date("d-m-Y", strtotime($isi->CHR_DATE_DEL));

                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>-</td>";
                                        echo "<td>$isi->CHR_PART_NO</td>";
                                        echo "<td>$isi->CHR_PART_NAME</td>";
                                        echo "<td>$isi->CHR_PART_NO_DASH</td>";
                                        echo "<td>$isi->CHR_BACK_NO</td>";
                                        echo "<td>$isi->CHR_KANBAN_TYPE</td>";
                                        echo "<td>$isi->CHR_WC_VENDOR</td>";
                                        echo "<td>$isi->CHR_SLOC_FROM</td>";
                                        echo "<td>$isi->CHR_SLOC_TO</td>";
                                        echo "<td>$isi->CHR_BOX_TYPE</td>";
                                        echo "<td>$isi->INT_QTY_PER_BOX</td>";
                                        echo "<td>$isi->CHR_CUST_PART_NO</td>";
                                        echo "<td>$isi->INT_LAST_SERIAL</td>";
                                        echo "<td>$isi->CHR_SIDE</td>";
                                        echo "<td>$date_create</td>";
                                        echo "<td>$date_change</td>";
                                        echo "<td>$date_delete</td>";
                                        echo "<td>$isi->CHR_FLAG_DELETE</td>";
                                        ?>
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
<!-- <script>
   
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

</script> -->