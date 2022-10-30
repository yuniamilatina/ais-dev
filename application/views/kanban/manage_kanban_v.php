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
            var filter = document.getElementById("filterKanban").value;
            //alert(filter);
            // var type = $("#REPORT_TYPE option:selected").val();
            var url_iframe = "";
            var frame = document.getElementById("iframe");

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/kanban/kanban_c/refresh_table",
                type: "POST",
                dataType: 'json',
                data: { FILTER: filter},
                success: function(data) {
                    document.getElementById('kanban_table').style.display = 'block';
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
        
        //index
        
        
        //FILTER TABLE BY FISCAL YEAR
        $('#filterKanban').on('keyup', function(e){
            if(e.keyCode != 8 && e.keyCode != 46)
            {
                refreshTable();
            }
          
       });
        
    });
</script> 
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Manage Kanban</strong></a></li>
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
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title"><strong>MANAGE KANBAN</strong></span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">
                                        <label type="text">Filter your data</td>
                                    <td width="10%">
                                        <input type="text" style="width: 200px" class="form-control" placeholder="Search" name="filterKanban" id="filterKanban"></td>
                                    <td width="60%">
                                        <!-- "Untuk melihat semua data kanban, bisa dengan cara mendownload semua data kanban" -->
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                        <?php echo form_open('kanban/kanban_c/print_kanban', 'class="form-horizontal"'); ?>
                                        <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Download All Data</button>
                                        <?php echo form_close() ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <div  id="kanban_table" style="display:none;">
                                <iframe frameBorder="0" id="iframe" width="100%" height="600" src="<?php echo $url_page ?>"></iframe>
                            </div> 
                            <!-- <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
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
                                        echo "<td>$isi->CHR_WORK_CENTER</td>";
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
                            </table> -->
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
    $(document).ready(function () {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>
